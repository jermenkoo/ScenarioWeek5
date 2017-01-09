# ScenarioWeek5

## Requirements

The application is modelled on Google Gruyere, you may design your own application if you wish. The set of features is not complete but represents a subset that you can start with. The Gruyere application refers to snippets. A snippet is simply text that may contain, in this case, some basic HTML formatting. Think of it as a small blog post.

| Number |  Description | Assigned To | Done | Vulnerability |
|--------|--------------|-------------|------|---------------|
| 1 | A user must set a login name and password using an HTML form. | | | |
| 2 | A user must sign-in using their login name and password.| | | |
| 3 | A user may set or modify a user name. The user name will be shown in the menu bar of the application. | | | |
| 4 | A user may set or modify the following attributes: password, URL for an icon, URL for a homepage, profile colour (text description), a private snippet. | | | |
| 5 | An administrator can edit the profile attributes of any user, as listed above. | | | |
| 6 | In addition, an administrator can edit the permissions associated with the user. These are:  Whether the user is an administrator or not. Whether the user can create snippets or not. | | | |
| 7 | A user can create a snippet. | | | |
| 8 | A user can delete one of their own snippets. | | | |
| 9 | If the user is not logged in, the Home page contains links to the sign-in and sign-up functions. The Home page also contains a list of all the users. A list containing information about all users. The following is displayed for each user: The user’s user name; The last snippet created by the user; A link to a page displaying all the user’s snippets. | | | |
| 10 | When a user has logged in, they can view the following additional items of information on the site home page: A link to the user’s homepage. The default value for the user’s home page is a link to the website login page with the user’s username and password. For example: <website URL>/login?uid=benbear&pw=bear | | | |
| 11 | A user may can upload a file to the website from the local filesystem. | | | |
| 12 | A user may view files that have been uploaded. Assuming that the user uploads a file called theFile.html, the file can be viewed at the URL: <website>/userid/theFile.htm | | | |

## Vulnerabilities

### Cross Site Scripting (XSS)
The vulnerable version will be vulnerable to XSS. (obviously, baby!)

* Snippets / Profile: ideally the snippets should be able to render raw JavaScript such as `"><img src=x onerror=alert(1)>` or `"><body onload=alert(1)>`.

**FIX:** Escape your inputs.

Links:
* https://github.com/cure53/DOMPurify

### SQL Injection (SQLi)
The vulnerable version of the website will operate on raw SQL queries, allowing SQLi to be present.
SQL injection should be (ideally) present in these spaces:

* Login dialog - the idea is to perform a raw SQL query like this: `statement = "SELECT * FROM users WHERE name = '" + userName + "';"`. If we inject a payload similar to this `' OR '1'='1' --`, it renders the following SQL query `SELECT * FROM users WHERE name = '' OR '1'='1' -- ';`, which allows us to login as our user.

* Snippet browsing - assuming the SQL query behind looks like `"SELECT * FROM snippets WHERE id=" + id`, it is possible to inject `id` parameter.

**FIX:** Use prepared statements and parametrized queries. Escape your inputs.

Links:
* https://stackoverflow.com/questions/60174/how-can-i-prevent-sql-injection-in-php

### CSS Injection

Links:
* https://www.owasp.org/index.php/Testing_for_CSS_Injection_(OTG-CLIENT-005)
* http://httpsecure.org/?works=css-injection
* https://www.owasp.org/index.php/DOM_based_XSS_Prevention_Cheat_Sheet (how to prevent CSS injection)
* https://packetstormsecurity.com/files/129696/eBay.com-oc  snext-CSS-Injection.html (example vulnerability from the past)

### Cross-Site Request Forgery (CSRF)
The vulnerable version will be vulnerable to CSRF in multiple places:

* Logout - if a user clicks on link masked to `<website>/logout`, he should get logged out.

* Delete snippets - if a user clicks on link pointing to `<website>/delete?id=<id>` (or similar), his snippet with id `id` should get deleted. (that's the idea)

**FIX:** Use a nonce to prevent this. (https://www.owasp.org/index.php/PHP_CSRF_Guard)

### Unsecure File Upload
* Not validating extension at all
* Client-side validation
* Not validating some extensions (e.g. `php` vs `php5`)
* Validate the MIME type of a file! Apache can execute when using `AddHandler` even files like `.php`, `.php.jpg` etc. as `.php` file; uploading `shell.php.jpg` bypasses this.

Links:
* https://www.acunetix.com/websitesecurity/upload-forms-threat/

### Bruteforce Login
It should be possible to bruteforce the access to the website trying as many as username:password combinations as possible.

### Application Misconfiguration
