# ScenarioWeek5

## Requirements

| Number   |      Description      |  Vulnerability |
|----------|-------------|------|
| 1 | A user must set a login name and password using an HTML form. | |
| 2 | A user must sign-in using their login name and password.| |
| 3 | A user may set or modify a user name. The user name will be shown in the menu bar of the application. |
| 4 | A user may set or modify the following attributes: password, URL for an icon, URL for a homepage, profile colour (text description), a private snippet. | |
| 5 | An administrator can edit the profile attributes of any user, as listed above. | |
| 6 | In addition, an administrator can edit the permissions associated with the user. These are:  Whether the user is an administrator or not. Whether the user can create snippets or not. |
| 7 | A user can create a snippet. | |
| 8 | A user can delete one of their own snippets. | |
| 9 | If the user is not logged in, the Home page contains links to the sign-in and sign-up functions. The Home page also contains a list of all the users. A list containing information about all users. The following is displayed for each user: The user’s user name; The last snippet created by the user; A link to a page displaying all the user’s snippets. | |
| 10 | When a user has logged in, they can view the following additional items of information on the site home page: A link to the user’s homepage. The default value for the user’s home page is a link to the website login page with the user’s username and password. For example: <website URL>/login?uid=benbear&pw=bear | |
| 11 | A user may can upload a file to the website from the local filesystem. | |
| 12 | A user may view files that have been uploaded. Assuming that the user uploads a file called theFile.html, the file can be viewed at the URL: <website>/userid/theFile.htm | |

## Vulnerabilities

### Cross Site Scripting (XSS)

### SQL Injection (SQLi)
The vulnerable version of the website will operate on raw SQL queries, allowing SQLi to be present.
SQL injection should be (ideally) present in these spaces:

* Login dialog - the idea is to perform a raw SQL query like this: `statement = "SELECT * FROM users WHERE name = '" + userName + "';"`. If we inject a payload similar to this `' OR '1'='1' --`, it renders the following SQL query `SELECT * FROM users WHERE name = '' OR '1'='1' -- ';`, which allows us to login as our user.

* Snippet browsing - assuming the SQL query behind looks like `"SELECT * FROM snippets WHERE id=" + id`, it is possible to inject `id` parameter.

### CSS Injection

### Cross-Site Request Forgery (CSRF)

### Unsecure File Upload
