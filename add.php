<?php
    require_once "pdo.php";
    session_start();
    // Make sure user is logged in  
    if (!isset($_SESSION["name"])) { die("ACCESS DENIED"); }
    // Redirect if cancel button is pressed
    if (isset($_POST["cancel"])) { 
        header("Location: view.php"); 
        return;
    }

    if (isset($_POST["make"]) && isset($_POST["model"]) && isset($_POST["year"]) && isset($_POST["mileage"])) {
        // Validate input
        if ($_POST["make"] == "" || $_POST["model"] == "" || $_POST["year"] == "" || $_POST["mileage"] == "") {
            $_SESSION["error"] = "All fields are required";
            header("Location: add.php");
            return;
        }
        if (!is_numeric($_POST["year"]) || !is_numeric($_POST["mileage"])) {
            $_SESSION["error"] = "Mileage and year must be numeric";
            header("Location: add.php");
            return;
        }
        else {
            // Input is valid, add to database
            $stmt = $pdo->prepare("INSERT INTO autos (make, model, `year`, mileage) VALUES (:mk, :md, :yr, :mi)");
            $stmt->execute(array(
                    ":mk" => $_POST["make"],
                    ":md" => $_POST["model"],
                    ":yr" => $_POST["year"],
                    ":mi" => $_POST["mileage"])
            );
            $_SESSION["success"] = "Record added";
            header("Location: view.php");
            return;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Jordan Ballard Autombile Tracker Add</title>
        <link rel="stylesheet" href="./styles.css">
    </head>
    <body>
        <h1 class="header">Adding Automobile</h1>
        <?php
            if (isset($_SESSION["error"])) {
                echo("<p class='msg error'>" . htmlentities($_SESSION["error"]) . "</p>");
                unset($_SESSION["error"]);
            }
        ?>
        <form method="post">
            <div>
                <label for="make">Make:</label>
                <input type="text" id="make" name="make">
            </div>
            <div>
                <label for="model">Model:</label>
                <input type="text" id="model" name="model">
            </div>
            <div>
                <label for="year">Year:</label>
                <input type="text" id="year" name="year">
            </div>
            <div>
                <label for="mileage">Mileage:</label>
                <input type="text" id="mileage" name="mileage">
            </div>
            <button type="submit" name="add">Add</button>
            <button type="submit" name="cancel">Cancel</button>
        </form>
    </body>
</html>