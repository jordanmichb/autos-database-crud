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

    if (isset($_POST["delete"]) && isset($_POST["autos_id"])) {
        $stmt = $pdo->prepare("DELETE FROM Autos WHERE autos_id = :x");
        $stmt->execute(array(":x" => $_POST["autos_id"]));
        $_SESSION["success"] = "Record deleted";
        header("Location: view.php");
        return;
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
        <title>Jordan Ballard Autombile Tracker Delete</title>
        <link rel="stylesheet" href="./styles.css">
    </head>
    <body>
        <h2>Do you really want to delete <?= $row["make"] . " " . $row["model"] ?>?</h2>
        <?php
            if (isset($_SESSION["error"])) {
                echo("<p class='msg error'>" . htmlentities($_SESSION["error"]) . "</p>");
                unset($_SESSION["error"]);
            }
        ?>
        <form method="post">
            <!-- Hidden input so id can be sent with post -->
            <input type="hidden" name="autos_id" value="<?= $row["autos_id"] ?>">
            <button type="submit" name="delete">Delete</button>
            <button type="submit" name="cancel">Cancel</button>
        </form>
    </body>
</html>