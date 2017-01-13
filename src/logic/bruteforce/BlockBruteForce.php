<?php
/**
 * Created by PhpStorm.
 * User: Kemoy Cambpell
 * @version 1.5
 * Date: 6/9/16
 * Time: 1:32 PM
 */

namespace BlockBruteForce;


class BlockBruteForce
{
    //private variables
    private $dbname;
    private $dbusername;
    private $dbpassword;
    private $host;
    private $msg=null;
    private $connected = false;
    private $PDO;
    private $defaultDatabase = 'brute_force_login_attempts';
    private $dump=array();
    private $sql = 'SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
    SET time_zone = "+00:00";
    CREATE TABLE `login_attempts` (
      `username` varchar(50) NOT NULL,
      `ip_address` varchar(50) NOT NULL,
      `time` datetime NOT NULL,
      `attempts` in NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;';
    private $sandbox = true;
    public $blockTime = 10;
    private $blockAttempts = 4;
    private $debugEnable = true;


    /**
     * BlockBruteForce constructor. The constructor takes the array config data and initalize
     * the necessary variables such as hostname, username, password. Supplying database name is
     * optional. If a database name is not supplied, a database namely brute_force_login_attempts
     * will be automatically created
     * @param null $config - config is an array with the necessary parameters to connect to the host mysql server
     * The format is as follow array('dbname'=>$dbname,'dbusername'=>$dbusername,'dbpassword'=>$dbpassword,'host'=>$host)
     */
    public function __construct($config=null)
    {
        //ensure that the config is a array
        if(!is_array($config) || $config==null || !isset($config))
        {
            $obj = new \stdClass();
            $obj->status = 400;
            $obj->error = 'Bad configuration data! Ensure that the configuration data is passed as array';
            $this->msg = $obj;
            array_push($this->dump,$obj);
            $this->outputDebug($this->debugEnable);
        }

        //ensure that the required parameters are supplied
        if(count($config) > 4|| count($config)<4 || !isset($config['dbname']) ||!isset($config['dbusername']) ||
            !isset($config['dbpassword']) || !isset($config['host']) )
        {
            $obj = new \stdClass();
            $obj->status = 400;
            $obj->error = 'Bad parameter(s)! The config parameter must be passed
             as follow array(\'dbname\'=>$dbname,\'dbusername\'=>$dbusername,\'dbpassword\'=>$dbpassword,\'host\'=>$host)';
            $obj->method = '_construct($config)';
             $this->msg = $obj;
            array_push($this->dump,$obj);
            $this->outputDebug($this->debugEnable);
        }

        //valid format hence proceed
        $this->dbname = $config['dbname'];
        $this->dbusername = $config['dbusername'];
        $this->dbpassword = $config['dbpassword'];
        $this->host = $config['host'];


    }//end of construct method

    /**
     * This method is used to setup the block time. By the the block time is set to 10 minutes.
     * @param $time - desired block time in whole number
     * @return \stdClass a stdclass object is return if an error occurs
     */
    public function setBlockTime($time)
    {
        //verify the time is numeric
        try
        {

            is_numeric($time);

            //must be whole
            is_int($time);

            $this->blockTime = $time;

        }
        catch(Exception $e)
        {
            $obj = new \stdClass();
            $obj->status = 400;
            $obj->error = $e->getMessage();
            $obj->method = 'setBlockTime($time)';
            array_push($this->dump,$obj);
            $this->outputDebug($this->debugEnable);
            return $obj;
        }
    }

    /**
     * This method is use to set the debug flag. The parameter must be a boolean true or false
     * @param $bool - either true or false
     * @return \stdClass - return stdclass object if there are any error
     */
    public function setEnableDebug($bool)
    {
        if(is_bool($bool)===true)
        {
            $this->debugEnable = $bool;
        }
        else
        {
            $obj = new \stdClass();
            $obj->status = 400;
            $obj->error = 'the parameter $bool must be boolean ';
            $obj->method = 'setEnableDebug($bool)';
            array_push($this->dump,$obj);
            $this->outputDebug(true);
            return $obj;

        }
    }

    /**
     * This method is used to set the max attempts allowed.
     * @param $max - the max attempts allowed in whole number
     * @return \stdClass -  a stdclass object is return if an error occurs
     */
    public function setBlockAttempts($max)
    {
        try
        {

            is_numeric($max);

            //must be whole
            is_int($max);

            $this->blockAttempts = $max;

        }
        catch(Exception $e)
        {
            $obj = new \stdClass();
            $obj->status = 400;
            $obj->error = $e->getMessage();
            $obj->method = 'setBlockAttempt($time)';
            array_push($this->dump,$obj);
            $this->outputDebug($this->debugEnable);
            return $obj;
        }

    }


    /**
     * This method is used to indicate whether a developer is using the localhost for the development.
     * The reason for this is to assist with get ip and return it as 127.0.0.1 when using localhost machine.
     * By default the sandbox is set as true
     * @param bool $bool - a true or false whether to enable sandbox. Should be off when in production
     * @return \stdClass - return stdclass object if there are any issues.
     */
    public function setSandbox($bool=true)
    {
         if(is_bool($bool)===true)
         {
            $this->sandbox = $bool;
         }
         else
         {
             $obj = new \stdClass();
             $obj->status = 400;
             $obj->error = 'the parameter $bool must be boolean ';
             $obj->method = 'setSandbox($bool)';
             array_push($this->dump,$obj);
             $this->outputDebug($this->debugEnable);
             return $obj;

         }
    }




    /**
     * This method used the config data supplied in the constructor and attempts to connect to the
     * mysql server. If the connection was not successful then a stdclass is returned detailing the error.
     * If the connection was successful a true is return.
     * @return bool|\stdClass - return true if the connection was successful otherwise a stdclass object with a detailed
     * info about the error
     */
    public function connect()
    {

        //was there any errors with the configuration?
        if($this->msg!==null)
        {
            $obj = new \stdClass();
            $obj->status = 400;
            $obj->error = $this->msg;
            $obj->method = 'connect()';
            array_push($this->dump,$obj);
            $this->outputDebug($this->debugEnable);

            return $obj;
        }
        //attempt to connect
        try
        {
            //check if database is default to null
            if($this->dbname==='default')
            {
                $databaseConnectString = 'mysql:host='.$this->host;
            }
            else
            {
                $databaseConnectString = 'mysql:host='.$this->host.';dbname='.$this->dbname;
            }

            $conn = new \PDO($databaseConnectString,$this->dbusername,$this->dbpassword);
            $conn->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
            $this->PDO = $conn;
            $this->connected = true;
            return true;
        }

        catch(\Exception $e)
        {
            $obj = new \stdClass();
            $obj->status = 400;
            $obj->error = $e->getMessage();

            //store the object here so we can easily called it in other methods when there has been an error with establishing the connection
            $this->msg = $obj;
            array_push($this->dump,$obj);
            $this->outputDebug($this->debugEnable);



            return $obj;
        }
    }

    /**
     * This method returns the connection status. If the connection has
     * been successful established then true is return otherwise a stdclass
     * with the status(header code 400) and error
     *
     * @return bool|stdClass - return true if the connection is established otherwise
     *return stdClass containing the status code and error message.
     */
    public function connectionStatus()
    {
        if($this->connected)
        {
            return true;
        }

        //connection not established
        $obj = new \stdClass();
        $obj->status = 400;
        $obj->error = 'A database connection has not been established';
        $obj->method = 'connectionStatus()';
        array_push($this->dump,$obj);
        $this->outputDebug($this->debugEnable);

        return $obj;


    }


    /**
     * This method is used to read the sql file into the table. If the file was successful read
     * then a true is return otherwise stdclass object with the error info
     * @param $file - the file that contains the sql with the necessary fields for the blockbruteforce
     * @return bool|\stdClass - return true if successful read otherwise stdclass object
     */
    public function readSql()
    {
        //ensure connection has already established
        if($this->connected)
        {
            try
            {
                $this->PDO->exec($this->sql);
                return true;

            } catch(\Exception $e)
            { // Database failed to connect
                $obj = new \stdClass();
                $obj->status = 400;
                $obj->error = $e->getMessage();
                $obj->method = 'readSql($file)';
                array_push($this->dump,$obj);
                $this->outputDebug($this->debugEnable);
                return $obj;
            }
        }

        //connection failed hence output the stdclas
        else
        {
            return $this->connectionStatus();
        }
    }

    /**
     * This method is a put together of both createDatabase and readSql methods in order to load all necessary database
     * and tables with the required fields for the blockbruteforce
     * @return bool - return false if failure occurs otherwise true
     */
    public function loadDependencyDatabase()
    {

        $status = $this->createDatabase();
        if($status instanceof \stdClass)
        {
            return false;
        }
        else
        {
            //read the sql and load it in
            $status = $this->readSql();
            if($status instanceof \stdClass)
            {
                return false;
            }
        }

        return true;

    }

    /**
     * This method is used to update the number of attempts the user has made. We only use this method if the
     * user has made previous failed attempt. If the update was successful then true is return and false if nothing to update.
     * a stdclass is return if any errors occurs
     * @param $username - the name of the user whose attempts to update
     * @return bool|\stdClass - return true if the update was successful, false if nothing was update and stdclass object if
     * any errors occurs
     */
    public function updateAttempts($username)
    {
        //ensure connected to the database
        if($this->connected)
        {
            //ensure the username parameter is verified
            $verify = $this->verifyUsernameParameter($username);
            if($verify===true)
            {
                //get the latest attempts information
                $latest = $this->getLastLoginAttempt($username);

                //ensure that the latest is not false or an error
                if($latest!==false && !($latest instanceof \stdClass))
                {
                    //procceed to the query in try and catch
                    try
                    {
                        $query = 'UPDATE login_attempts SET ip_address =:ip,time=:log_time,attempts =:attempts
                                  WHERE username =:username';

                        $ip = $this->get_ip_address();
                        $time = date('Y-m-d H:i:s');
                        //print_r($latest);
                        $attempts = $latest['attempts'] + 1;

                        print_r($latest);
                        $bind= array(':ip'=>$ip,':log_time'=>$time,':attempts'=>$attempts,':username'=>$username);
                        $stmt = $this->PDO->prepare($query);
                        $stmt->execute($bind);

                        if($stmt->rowCount() > 0)
                            return true;
                        return false;
                    }
                    catch(Exception $e)
                    {
                        $obj = new \stdClass();
                        $obj->status = 400;
                        $obj->error = $e->getMessage();
                        $obj->method = 'updateAttempts($username)';
                        array_push($this->dump,$obj);
                        $this->outputDebug($this->debugEnable);
                        return $obj;
                    }

                }

                //return the false or error
                else
                {
                    return $latest;
                }

            }

            //othwise return the err
            else
            {
                return $verify;
            }
        }

        //return the connection status..(stdclass)
        else{
            return $this->connectionStatus();
        }
    }


    /**
     * This method is used to ensure that the username parameter is supplied
     * @param $username - the username parameter
     * @return bool|\stdClass - return true if supplied stdclass object otherwise
     */
    public function verifyUsernameParameter($username)
    {
        if($username==null || empty($username) || $username=='')
        {
            $obj = new \stdClass();
            $obj->status = 400;
            $obj->error= 'Username cannot be empty';
            $obj->method = 'getLastLoginAttempt($username)';
            array_push($this->dump,$obj);
            $this->outputDebug($this->debugEnable);

            return $obj;
        }

        return true;
    }


    /**
     * This method is used to fetch the user's last login attempt from the database. We first check to ensure that
     * the username is supplied. Further we ensure that the database connection is established. If we were able to find the
     * user's last attempt in the database, the resultset is return, false if no data was found. A stdclass object is return if any error
     * were occurs
     * @param $username - the username to check for last login attempt
     * @return bool|\stdClass - resultset is returned if the result was found, false if nothing was found and stdclass object if any errors occurs
     */
    public function getLastLoginAttempt($username)
    {
        if($username==null || empty($username) || $username=='')
        {
            $obj = new \stdClass();
            $obj->status = 400;
            $obj->error= 'Username cannot be empty';
            $obj->method = 'getLastLoginAttempt($username)';
            array_push($this->dump,$obj);
            $this->outputDebug($this->debugEnable);

            return $obj;
        }

        else
        {
            //ensure connected
            if($this->connected)
            {
                try
                {

                    $query = 'SELECT * FROM login_attempts where username =:username';
                    $bind = array(':username'=>$username);
                    $stmt = $this->PDO->prepare($query);
                    $stmt->execute($bind);
                    if($stmt->rowCount() > 0)
                        return $stmt->fetch();

                    return false;
                }
                catch(Exception $e)
                {
                    $obj = new \stdClass();
                    $obj->status = 400;
                    $obj->error = $e->getMessage();
                    $obj->method = 'getLastLoginAttempt()';
                    array_push($this->dump,$obj);
                    $this->outputDebug($this->debugEnable);

                    return $obj;
                }

            }

            //connection issue, return the status(stdclass object)
            else
            {
                return $this->connectionStatus();
            }
        }
    }

    /**
     * This method is used to delete an existing record from the database. The record are only removed
     * if the time elapse is >= block time that is defined by the developer
     * @param $username - the username to delete the record for
     * @return bool|\stdClass - return true if successful delete, false if nothing to delete and stdclass object if any errors
     */
    public function deleteRecord($username)
    {
        //ensure that the connection is set
        if($this->connected)
        {
            //verifying the username parameter
            $verify = $this->verifyUsernameParameter($username);

            if($verify===true)
            {
                $exist = $this->getLastLoginAttempt($username);

                //ensure the user exist in the database
                if($exist!=false && !$exist instanceof \stdClass)
                {


                    //ensure that we only delete one with block minutes already passed
                    //check the time if the block time has passed
                    $now = date_create(date('Y-m-d H:i:s'));
                    $lastAttempt = date_create($exist['time']);

                    $interval = date_diff($lastAttempt,$now);

                    //check if the minutes has passed
                    if($interval->i > 0 && $interval->i >= $this->blockTime)
                    {
                        try
                        {
                            //set up the pdo statements
                            $query = 'DELETE FROM login_attempts WHERE username =:username';
                            $bind = array(':username'=>$username);
                            $stmt = $this->PDO->prepare($query);
                            $stmt->execute($bind);

                            if($stmt->rowCount() > 0)
                                return true;
                            return false;
                        }
                        catch(\Exception $e)
                        {
                            $obj = new \stdClass();
                            $obj->status = 400;
                            $obj->erro  = $e->getMessage();
                            $obj->method = 'delete($username)';
                            array_push($this->dump,$obj);
                            $this->outputDebug($this->debugEnable);

                        }
                    }

                    return false;
                }

                else
                {
                    return $exist;
                }

            }

            //return the steclass err
            else
            {
                return $verify;
            }
        }

        //return the stdclass error fo connection status
        else
        {
            return $this->connectionStatus();
        }

    }

    /**This method takes the time of the last login attempts and returns the minutes elapse since the last login attempts
     * @param $lastAttempt- the time of the last login attempts
     * @return int|\stdClass - returns the minutes elapsed otherwise a stdclass detailing the error
     */
    public function getMinuteElapse($lastAttempt)
    {
        //check if the $lastAttempt is not given
        if(!isset($lastAttempt) || $lastAttempt===null || empty($lastAttempt) || $lastAttempt==='')
        {

            //the requirement failed hence return the error in stdclass obj
            $obj = new \stdClass();
            $obj->status = 400;
            $obj->error='the parameter lastAttempt is required';
            $obj->method = 'getMinuteElapse($lastAttempt)';
            array_push($this->dump,$obj);

            return $obj;
        }

        //everything else valid hence move forward
        else
        {
            //wrap in try and catch so we can get the necesssary errors
            try
            {
                //parsing the necessary times
                $now = date_create(date('Y-m-d H:i:s'));//the current time
                $lastAttempt = date_create($lastAttempt);
                $interval = date_diff($now,$lastAttempt);

                return $interval->i;
            }
            catch(Exception $e)
            {
                $obj = new \stdClass();
                $obj->status = 400;
                $obj->error = $e->getMessage();
                $obj->method = 'getMinuteElapse($lastAttempt)';
                $this->outputDebug($this->debugEnable);

                return $obj;
            }
        }

    }

    /**This performs the complex check using many of the functions delcared in this class to checks wether a user is block.
     * The method first verified that the username is passed and the database is connected. Further more we get the last login
     * attempts data of the user if any, compare the minutes elapse and number of attempts. if the minutes elapse is more than
     * the block time then the record is removed, the user marked as not block. However if the attempts is more than the max allowed
     * and and 10 minutes has not passed the user is marked as block. If there are no attempts for the user then one is register otherwise
     * the number of attempts is updated
     * @param $username - the username to check if marked as block
     * @return bool|\stdClass - return true if the user is blocked, false if the user is not block otherwise stdclass object
     * detailing the error.
     */
    public function isBlock($username)
    {
        //ensure that the username parameter is supplied
        $verify = $this->verifyUsernameParameter($username);

        if( $verify instanceof \stdClass)
        {
            //return the stdclass error
            return $verify;
        }

        //ensure that the connection has been established
        if($this->connected)
        {
            //does this user has any failed attempted in the database?
            $exist = $this->getLastLoginAttempt($username);

            //we know the user exist if what we get is an instance of PDOStatement
            if(!$exist instanceof \stdClass && $exist!==false)
            {
                //check how many minutes has elapse since the user's last attempt
                $minutes = $this->getMinuteElapse($exist['time']);

                //ensure that there is no errors
                if(!$minutes instanceof \stdClass)
                {
                    //is the minutes passed more than the block minutes?
                    if($minutes > $this->blockTime)
                    {
                        //delete the block and return false
                        $delete = $this->deleteRecord($username);
                        if($delete===true)
                            return false;

                        //return whatever delete return, it is either stdclass obj or false
                        return $delete;
                    }

                    //less than block time
                    else if($minutes < $this->blockTime)
                    {
                        $attempts = $exist['attempts'] + 1;

                        //is this more than the attempts allowed? if so the user is block
                        if($attempts > $this->blockAttempts)
                        {
                            return true;
                        }
                        else
                        {
                            //add the record to the update
                            $update = $this->updateAttempts($username);
                            if($update===true)
                            {
                                //did the recently attempts add up to block attempts?
                                if($attempts>=$this->blockAttempts)
                                {
                                    return true;
                                }

                                return false;
                            }

                            //return false or stdclass
                            return $update;

                        }


                        return false;
                    }

                    return false;
                }

                //has error
                else
                {
                    return $minutes;
                }
            }

            //doesnt exist hence we will register this failed login attempt
            else if($exist===false)
            {
                $register = $this->registerFailedLogin($username);
                //register was successful added to the database
                if($register===true)
                    return false;

                //otherwise just return false or stdclass with detailed error
                return $register;
            }


            return false;
        }

        //the database is not connected hence return the stdclass detailing the error
        else
        {
            return $this->connectionStatus();
        }
    }

    /**
     * This method is used to register a failed attempts for a particular user in the database.
     * We log the following fields, username, ip address, action time and attempts as 1
     * @param $username - the username to register the failed attempt for
     * @return bool|\stdClass return true if the data was registered, false if not and stdclass if an error occurs
     */
    public function registerFailedLogin($username)
    {
        try
        {
            $ip = $this->get_ip_address();
            $time = date('Y-m-d H:i:s');

            $query = "INSERT into login_attempts (username,ip_address,time) VALUES(:username,:ip,:time)";
            $stmt = $this->PDO->prepare($query);

            //$stmt->bindParam(array(':username'=>$username,':ip'=>$ip));
            $bind = array(':username'=>$username,':ip'=>$ip,':time'=>$time);
            $stmt->execute($bind);
            return true;

        }

        catch(Exception $e)
        {
            $obj = new \stdClass();
            $obj->status = 400;
            $obj->error = $e->getMessage();
            $obj->method = 'registerFailedLogin($username)';
            array_push($this->dump,$obj);
            $this->outputDebug($this->debugEnable);
            return $obj;
        }
    }


    /**
     * This method is used to get the ip of the user
     * @return stdClass|bool|string - return stdclass if an error occurs. false if we are not able to get the address. otherwise the ip
     * is returned
     */
    public function get_ip_address()
    {

        //return localhost if sandbox enable
        if($this->sandbox===true)
        {
            return '127.0.0.1';
        }
        $ip_keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
        foreach ($ip_keys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    // trim for safety measures
                    $ip = $this->trim($ip);
                    // attempt to validate IP
                    if ($this->validate_ip($ip)) {
                        return $ip;
                    }
                }
            }
        }
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;
    }

    /**
     * This method is used to trim the ip address
     * @param $ip - the ip address to trim
     * @return stdClass|string - stdclass if an error occurs otherwise the trimmed ip address is returned
     */
    public function trim($ip)
    {
        if(empty($ip) || $ip=='')
        {
            $obj = new stdClass();
            $obj->status = 400;
            $obj->error = 'The parameter ip cannot be empty!';
            array_push($this->dump,$obj);
            $this->outputDebug($this->debugEnable);

            return $obj;
        }

        else
        {
            $pos = strrpos($ip, '.');
            if ($pos !== false) {
                $ip = substr($ip, 0, $pos+1);
            }
            return $ip . '.0';

        }
    }

    /**
     * This method is used to validate the ip address
     * @param $ip - the ip address to validate
     * @return bool - return true if verified and false if otherwise
     */
    public function validate_ip($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return false;
        }
        return true;
    }

    /**
     * If a user is block, this method is used to state how many minutes before the user may login again
     * @param $username - the username of the user we want to notify when can login again
     * @return bool|int|\stdClass - false if any user not found, stdclass if any errors and lastly the minutes before
     * the user can login again is returned
     */
    public function youMayLoginAgainIn($username)
    {
        //verify the username
        $verify  = $this->verifyUsernameParameter($username);

        if($verify===true)
        {
            //get the last attempt detail
            $history = $this->getLastLoginAttempt($username);

            //ensure no failure
            if($history!==false && !$history instanceof \stdClass)
            {
                $lastAttempt = $history['time'];
                $elapse = $this->getMinuteElapse($lastAttempt);
                if(!$elapse instanceof \stdClass)
                {
                    //find out how many minutes remain
                    return $this->blockTime - $elapse;
                }

                //return the error
                return $elapse;
            }
            //return error or false;
            return $history;
        }
        else
        {
            return $verify;
        }

    }


    /**
     * This method is used to create a database for the blockbruteforce if the user leave the database configuration in its
     * default state in the config.php
     * @return bool|\stdClass - true if the database was created, false if not and stdclass object if an error occurs
     */
    public function createDatabase()
    {
        //ensure connected
        if($this->connected)
        {
            //check if a custom database was supplied
            if($this->dbname==='default')
            {

                //check if the database exist if not create it
                try
                {
                    $status = $this->PDO->query("CREATE DATABASE IF NOT EXISTS $this->defaultDatabase");
                    if($status!=false)
                    {
                        //return true as the database is well existed and "created"
                        $this->PDO->query("use $this->defaultDatabase");
                        return true;
                    }


                    return false;

                }
                catch(\Exception $e)
                {
                    $obj = new \stdClass();
                    $obj->status = 400;
                    $obj->error=$e->getMessage();
                    $obj->method = 'createDatabase';
                    array_push($this->dump,$obj);
                    $this->outputDebug($this->debugEnable);
                    return $obj;
                }
            }


        }
        else
        {
            return $this->connectionStatus();
        }


    }

    /**
     * This method is used to occurs in the program. The user can enable or disable by supplying a boolean statement
     * as the parameter
     * @param $bool - true to print the output and false othewise
     */
    public function outputDebug($bool)
    {
        if($bool===true)
        {
            print_r($this->dump);
        }

    }


}
