import push from '../../utils/routing';
import Parse from '../../utils/parse';
import { newError } from '../errors';
import { createClassRoom, joinClassRoom } from '../classRoom';
import * as actionTypes from '../../constants/actions';
import * as analyticsTypes from '../../constants/analytics';
import { createNotificationsSettings } from '../notifications/settings';
import * as TEXT from '../../constants/texts';
import { createCookie, deleteCookie } from '../../utils/cookie';
import { analyticsTrackEvent } from '../analytics';

// Helpers
const parseResetPassword = (email) => (
  new Promise((resolve, reject) => {
    Parse.User.requestPasswordReset(email, {
      success: () => {
        resolve();
      }, error: (err) => {
        reject(err);
      },
    });
  })
);

function checkClassCode(classCode) {
  return new Promise((resolve, reject) => {
    const query = new Parse.Query('UBClassRoom');
    query.equalTo('code', classCode);
    query.find().then((result) => {
      console.info('---- classRooms with code:', classCode, ': ', result);
      if (result.length > 0) resolve(true);
      else resolve(false);
    }, (error) => reject(error));
  });
}

function parseLogin(email, password) {
  return new Promise((resolve, reject) => {
    Parse.User.logIn(email, password).then(
      user => resolve(user),
      error => reject(error)
    );
  });
}

function parseSignUp(info) {
  return new Promise((resolve, reject) => {
    const user = new Parse.User();

    user.set('password', info.password);
    user.set('email', info.email.toLowerCase());
    user.set('firstName', info.firstName);
    user.set('lastName', info.lastName);
    user.set('username', info.email.toLowerCase());

    user.signUp(null, {
      success: (u) => {
        const userACL = new Parse.ACL(u);
        userACL.setPublicReadAccess(true);

        u.setACL(userACL);
        u.save().then(
          aclUser => resolve(aclUser),
          (error) => reject(error)
        );
      },
      error: (u, error) => {
        if (error.code === 202) {
          reject(Object.assign({}, error, { message: TEXT.ERROR_ACCOUNT_EXISTS }));
        }
        reject(error);
      },
    });
  });
}

function fetchCurrentUser(state) {
  return new Promise((resolve, reject) => {
    if (!state.user.user) {
      return resolve(null);
    }

    return Parse.Object.fromJSON({ ...state.user.user, className: '_User' }).fetch().then(
      (user) => resolve(user),
      (error) => reject(error)
    );
  });
}

// Actions
const fetchedUser = (user) => ({
  type: actionTypes.USER_FETCH_CURRENT,
  user,
});

function loginStart() {
  return {
    type: actionTypes.USER_LOGIN,
    status: 'started',
  };
}

function loginSuccess(user, dispatch) {
  dispatch({
    type: actionTypes.USER_LOGIN,
    status: 'success',
    user,
  });
}

function loginError(error, dispatch) {
  dispatch(newError(error, 'login'));
  dispatch({
    type: actionTypes.USER_LOGIN,
    status: 'error',
    error,
  });
}

function logoutError(error, dispatch) {
  dispatch(newError(error, 'logout'));
  dispatch({
    type: actionTypes.USER_LOGOUT,
    status: 'error',
    error,
  });
}

export function login(email, password) {
  return (dispatch) => {
    if (!email || !password) {
      const err = { message: 'Missing email or password' };
      return loginError(err, dispatch);
    }
    // Starting the login process
    dispatch(loginStart());

    // if (getState().user.isLogged) {
    //   Parse.User.logOut();
    //
    //   const err = { message: 'You need to logout first' };
    //   return loginError(err, dispatch);
    // }

    // Login with Parse
    return parseLogin(email.toLowerCase(), password).then(
      // Dispatch successfull login
      user => {
        createCookie('ub-logged', 'true', 365, '', '.ublend.co');
        dispatch(analyticsTrackEvent(analyticsTypes.INTENTIONAL_LOGIN, {}, user.toJSON()));
        loginSuccess(user, dispatch);

        return { code: 202 };
      },
      error => loginError(error, dispatch)
    );
  };
}

export function logout() {
  return (dispatch, getState) => {
    return new Promise((resolve, reject) => {
      if (!getState().user.isLogged) {
        const err = new Error('User not logged in');
        return logoutError(err, dispatch);
      }

      dispatch({
        type: actionTypes.USER_LOGOUT,
        status: 'started',
      });

      deleteCookie('ub-logged', '', '.ublend.co');
      Parse.User.logOut().then(() => {
        dispatch({
          type: actionTypes.USER_LOGOUT,
          status: 'success',
        });

        resolve();
      }, (err) => reject(err));
    });
  };
}

export function fetchCurrentUserIfNeeded() {
  return (dispatch, getState) => (
    fetchCurrentUser(getState()).then(
      (user) => (user && dispatch(fetchedUser(user))),
      (error) => dispatch(newError(error, 'fetchCurrentUser'))
    )
  );
}

// Register
function registerStart() {
  return {
    type: actionTypes.USER_REGISTER,
    status: 'started',
  };
}

function registerSuccess(user, dispatch) {
  dispatch({
    type: actionTypes.USER_REGISTER,
    status: 'success',
    user,
  });
}

function registerError(error, dispatch) {
  dispatch(newError(error, 'register'));
  dispatch({
    type: actionTypes.USER_REGISTER,
    status: 'error',
    error,
  });
}

const registerCheckFields = (info, state) => (
  new Promise((resolve, reject) => {
    const checkFields = () => {
      if (!info || !info.password || !info.email || !info.firstName || !info.lastName) {
        const err = { message: 'Missing user info (password, email, firstName, lastname)' };
        return err;
      }

      if (state.user.isLogged) {
        const err = { message: 'You need to logout first' };
        return err;
      }

      return null;
    };

    if (info.type === 'join' || !info.type) {
      checkClassCode(info.classCode).then((classCodeExists) => {
        if (!classCodeExists) {
          const err = { message: 'Class code is incorrect.' };
          reject(err);
          return;
        }

        const error = checkFields();
        if (!error) {
          resolve();
        } else {
          reject(error);
        }
      });
    } else {
      const error = checkFields();
      if (!error) {
        resolve();
      } else {
        reject(error);
      }
    }
  })
);

export function register(info) {
  return (dispatch, getState) => {
    dispatch(registerStart());

    return new Promise((resolve, reject) => {
      registerCheckFields(info, getState()).then(
        () => {
          parseSignUp(info).then((user) => {
            const result = createNotificationsSettings(user, info.isInstructor)(dispatch);
            if (!result) {
              const err = { message: 'Impossible to create notificationSettings' };
              registerError(err, dispatch);
              reject(err);
              return;
            }

            result.then(
              () => {
                createCookie('ub-logged', 'true', 365, '', '.ublend.co');
                registerSuccess(user, dispatch);
                resolve();
              },
              (err) => {
                registerError(err, dispatch);
                reject(err);
              }
            );
          },
          (error) => {
            registerError(error, dispatch);
            reject(error);
          });
        },
        (err) => registerError(err, dispatch)
      );
    });
  };
}

export function registerAndAddClass(info) {
  return (dispatch) => {
    const resultRegister = dispatch(register(info));

    if (!resultRegister) {
      return null;
    }

    return resultRegister.then(() => {
      let resultClass;
      let analyticsEvent;
      let isInstructor;
      if (info.type === 'create') {
        isInstructor = true;
        analyticsEvent = analyticsTypes.SIGNUP_CREATE;
        resultClass = dispatch(createClassRoom(info.className, info.isInstructor));
      } else {
        isInstructor = false;
        analyticsEvent = analyticsTypes.SIGNUP_JOIN;
        resultClass = dispatch(joinClassRoom(info.classCode));
      }

      if (!resultClass) {
        return null;
      }

      return resultClass.then((classRoomUser) => {
        const classRoomId = classRoomUser.classRoom.objectId;
        return dispatch(analyticsTrackEvent(analyticsEvent, {
          isInstructor,
          activeClassroom: classRoomId,
        }));
      });
    });
  };
}

export function getSessionToken(store) {
  return () => {
    if (store.getState().user.isLogged) {
      push('/feed');
    } else {
      push('/');
    }
  };
}

const resetPasswordStart = (dispatch) => {
  dispatch({
    type: actionTypes.USER_RESET_PASSWORD,
    status: 'started',
  });
};

const resetPasswordSuccess = (dispatch) => {
  dispatch({
    type: actionTypes.USER_RESET_PASSWORD,
    status: 'success',
  });
};

const resetPasswordError = (error, dispatch) => {
  dispatch(newError(error, 'resetPassword'));
  dispatch({
    type: actionTypes.USER_RESET_PASSWORD,
    status: 'error',
    error,
  });
};

export const resetPassword = (email) => (
  (dispatch) => {
    if (!email) {
      const err = { message: 'email missing' };
      return resetPasswordError(err, dispatch);
    }

    resetPasswordStart(dispatch);

    return parseResetPassword(email).then(
      () => resetPasswordSuccess(dispatch),
      (error) => resetPasswordError(error, dispatch)
    );
  }
);
