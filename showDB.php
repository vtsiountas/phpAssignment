<?php

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
if($_SESSION["username"] != "admin") {
    die("You do not have permission to access this page.");
}

require_once "config.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>showDB</title>
    <link rel="stylesheet" href="./style.css">
    <style>
        body {
            text-align: center;
        }
    </style>
</head>
<body>

    <?php

    function showTable($tableName, $conn) {

        $err = "";
        $query = "SHOW columns FROM $tableName";
        if($queryResult = $conn->query($query)) {
            echo "<caption> $tableName </caption>";
            echo "<tr>";
            while($queryRow = $queryResult->fetch_row()) {
                echo "<th>$queryRow[0]</th>";
            }
            echo "<tr>";
        } else {
            echo $err = "<div class=\"alert red\">Error: Table $tableName has maybe not been created.</div>";
        }

        if(empty($err)) {
            $query = "SELECT * FROM $tableName;";
            if($queryResult = $conn->query($query)) {

                $rows = 0;

                while ($queryRow = $queryResult->fetch_row()) {
                    echo "<tr>";
                    for($i = 0; $i < $queryResult->field_count; $i++){
                        echo "<td>$queryRow[$i]</td>";
                    }
                    echo "</tr>";
                    $rows++;
                }
                if($rows == 0) {
                    echo "<div class=\"alert green\">Table $tableName is empty.</div>";
                }
            }
        }

    }
    ?>

    <table>
    <?php

    showTable("forms", $conn);

    ?>
    </table>
    <table>
    <?php
    showTable("users", $conn);
    ?>
    </table>



    <?php
    $conn->close();
    ?>



    
</body>
</html>


