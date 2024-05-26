# University of Michigan via Coursera - Building Database Applications in PHP

## Autos Database - Using the POST-Redirect-GET Pattern and CRUD

### Assignment Specifications

Tools used: PHP, SQL, VSCode, MAMP, phpMyAdmin

You must use the PHP PDO database layer for this assignment. Your program must be resistant to both HTML and SQL Injection attempts.

Please do not use HTML5 in-browser data validation (i.e. type="number") for the fields in this assignment as we want to make sure you can properly do server side data validation. And in general, even when you do client-side data validation, you should still validate data on the server in case the user is using a non-HTML5 browser.

You will need to create a database, a user to connect to the database and a password for that user. You will need to make a connection to that database in a PHP file.

When you first come to the application (index.php) you are told to go to a login screen.

The login.php should be a login screen should present a field for the person's email and their password. Your form should have a button labeled "Log In" that submits the form data using method="POST" (i.e. these should not be GET parameters). The login screen needs to have some error checking on its input data. If either the name or the password field is blank, you should output an error message. If the password is non-blank and incorrect, you should output an error message. If the login name is missing an '@', you should output an error message.

The script must redirect after every POST. It must never produce HTML output as a result of a POST operation. With a successful login, login.php must redirect to view.php and must pass the logged in user's name through the session. A GET parameter is not allowed.

All error messages must be passed between the POST and GET using the session and "flash message" pattern. The error message must be displayed only on the next GET request. Subsequent GET requests (i.e. refreshing the page) should not show the error message to properly implement the POST-Redirect-GET-Flash pattern.

In order to protect the database from being modified without the user properly logging in, on each page you must first check the session to see if the user's name is set and if the user's name is not set in the session the they must stop immediately using the PHP die() function.

In view.php if the Logout button is pressed the user should be redirected back to the logout.php page. The logout.php page should clear the session and immediately redirect back to index.php.
