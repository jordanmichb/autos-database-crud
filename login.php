<?php
    session_start();

    if (isset($_POST["cancel"])) { 
        header("Location: index.php"); 
        return;
    }

    if (isset($_POST["email"]) && isset($_POST["pass"])) { 
        unset($_SESSION["name"]); // Logout current user
        // Validate input
        // If invalid, set $_SESSION["error"] and redirect to clear $_POST data
        if ($_POST["email"] == "" || $_POST["pass"] == "") {
            $_SESSION["error"] = "User name and password are required";
            header("Location: login.php");
            return;
        }
        if (strpos($_POST["email"], '@') === false) {
            $_SESSION["error"] = "Email must have an at-sign (@)";
            header("Location: login.php");
            return;
        }
        // If input is valid, check password
        if (validPassword($_POST["pass"])) {
            $_SESSION["name"] = $_POST["email"];
            header("Location: view.php");
            return;
        } else {
            $_SESSION["error"] = "Incorrect password";
            header("Location: login.php");
            return;
        }
    }
    // Function to check for valid password
    function validPassword($pass) {
        $salt = 'XyZzy12*_';
        $storedHash = '1a52e17fa899cf40fb04cfc42e6352f1'; // Correct hash
        $test = $salt . $pass; // Concat salt and input to check against storedHash
        if (hash('md5', $test) == $storedHash) { return true; } // If hashes match, password is correct
        return false; // Else password is incorrect
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Jordan Ballard Autombile Tracker Login</title>
        <link rel="stylesheet" href="./styles.css">
    </head>
    <body>
        <h1 class="header">Please Log In</h1>
        <?php 
            // If an error was set, display and then unset it to follow flash message pattern
            if (isset($_SESSION["error"])) {
                 echo ("<p class='msg error'>" . htmlentities($_SESSION["error"]) . "</p>");
                 unset($_SESSION["error"]);
            }
        ?>
        <form method="post">
            <div>
                <label for="email">User Name:</label>
                <input type="text" id="email" name="email">
            </div>
            <div>
                <label for="pass">Password:</label>
                <input type="text" id="pass" name="pass">
            </div>

            <p class="hint">**Password is php123</p>

            <button type="submit" name="login">Log In</button>
            <button type="submit" name="cancel">Cancel</button>
        </form>
    </body>
</html>