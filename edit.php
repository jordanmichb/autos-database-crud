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

    if (isset($_POST["make"]) && isset($_POST["model"]) && isset($_POST["year"]) && isset($_POST["mileage"]) && isset($_POST["autos_id"])) {
        // Validate input
        // If invalid, redirect to the same page and keep the GET id param
        if ($_POST["make"] == "" || $_POST["model"] == "" || $_POST["year"] == "" || $_POST["mileage"] == "") {
            $_SESSION["error"] = "All fields are required";
            header("Location: edit.php?autos_id=" . $_REQUEST["autos_id"]);
            return;
        }
        if (!is_numeric($_POST["year"]) || !is_numeric($_POST["mileage"])) {
            $_SESSION["error"] = "Mileage and year must be numeric";
            header("Location: edit.php?autos_id=" . $_REQUEST["autos_id"]);
            return;
        }
        else {
            // Input is valid, update database
            $stmt = $pdo->prepare("UPDATE Autos SET make = :mk, model = :md, `year` = :yr, mileage = :mi WHERE autos_id = :id");
            $stmt->execute(array(
                    ":mk" => $_POST["make"],
                    ":md" => $_POST["model"],
                    ":yr" => $_POST["year"],
                    ":mi" => $_POST["mileage"],
                    ":id" => $_POST["autos_id"])
            );
            $_SESSION["success"] = "Record edited";
            header("Location: view.php");
            return;
        }
    }
    // Cannot enter page without GET param
    if (!isset($_GET["autos_id"])) {
        $_SESSION["error"] = "Missing autos_id";
        header("Location: view.php");
        return;
    }

    // Get the auto info
    $stmt = $pdo->prepare("SELECT * FROM Autos WHERE autos_id = :x");
    $stmt->execute(array(":x" => $_GET["autos_id"]));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // Cannot enter page with invalid id
    if ($row === false) {
        $_SESSION["error"] = "Car does not exist";
        header("Location: view.php");
        return;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Jordan Ballard Autombile Tracker Edit</title>
        <link rel="stylesheet" href="./styles.css">
    </head>
    <body>
        <h1 class="header">Editing Automobile</h1>
        <?php
            if (isset($_SESSION["error"])) {
                echo("<p class='msg error'>" . htmlentities($_SESSION["error"]) . "</p>");
                unset($_SESSION["error"]);
            }
        ?>
        <form method="post">
            <div>
                <label for="make">Make:</label>
                <input type="text" id="make" name="make" value=<?= htmlentities($row["make"]) ?>>
            </div>
            <div>
                <label for="model">Model:</label>
                <input type="text" id="model" name="model" value=<?= htmlentities($row["model"]) ?>>
            </div>
            <div>
                <label for="year">Year:</label>
                <input type="text" id="year" name="year" value=<?= htmlentities($row["year"]) ?>>
            </div>
            <div>
                <label for="mileage">Mileage:</label>
                <input type="text" id="mileage" name="mileage" value=<?= htmlentities($row["mileage"]) ?>>
            </div>
            <!-- Hidden input so id can be sent with post -->
            <input type="hidden" name="autos_id" value="<?= $row["autos_id"] ?>">
            <button type="submit" name="save">Save</button>
            <button type="submit" name="cancel">Cancel</button>
        </form>
    </body>
</html>