<?php
    require_once "pdo.php";
    session_start();

    if ( ! isset($_SESSION['name']) ) {
        die('ACCESS DENIED');
    }
    // Get autos from database to show in tthe view
    $stmt = $pdo->prepare("SELECT * FROM Autos");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Jordan Ballard Autombile Tracker</title>
        <link rel="stylesheet" href="./styles.css">
    </head>
    <body>
        <div class="header">
            <h1>Tracking Autos for <?= htmlentities($_SESSION["name"]); ?></h1>
            <a href="./add.php">Add New Entry</a>
            <a href="./logout.php">Logout</a>
        </div>
        <?php
            if (isset($_SESSION["error"])) {
                echo("<p class='msg error'>" . htmlentities($_SESSION["error"]) . "</p>");
                unset($_SESSION["error"]);
            }
            if (isset($_SESSION["success"])) {
                echo("<p class='msg success'>" . htmlentities($_SESSION["success"]) . "</p>");
                unset($_SESSION["success"]);
            }
        ?>
        <table>
            <caption>Automobiles</caption>
            <thead>
                <tr>
                    <th scope="col">Make</th>
                    <th scope="col">Model</th>
                    <th scope="col">Year</th>
                    <th scope="col">Mileage</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if ($rows == false) { 
                        echo "<tr>";
                        echo "<td colspan='100%'>No rows found</td>";
                        echo "</tr>";
                    } else {
                        foreach ($rows as $row) {
                            echo "<tr>";
                            echo "<td>" . htmlentities($row["make"]) . "</td>";
                            echo "<td>" . htmlentities($row["model"]) . "</td>";
                            echo "<td>" . htmlentities($row["year"]) . "</td>";
                            echo "<td>" . htmlentities($row["mileage"]) . "</td>";
                            // Send id as GET param so edit and delete pages know which auto to operate on
                            echo "<td><a href='edit.php?autos_id=" . $row["autos_id"] . "'>Edit</a>";
                            echo " / ";
                            echo "<a href='delete.php?autos_id=" . $row["autos_id"] . "'>Delete</a></td>";
                            echo "</tr>";
                        }
                    }
                ?>
            </tbody>
        </table>
    </body>
</html>