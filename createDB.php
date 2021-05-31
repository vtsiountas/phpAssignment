<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'TSIOUNTAS_web');
 
$connDB = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD);
 
if(!$connDB){
    die("ERROR: Could not connect. " . $connDB->connect_error);
}

$sqlDB = "CREATE DATABASE " . DB_NAME . ";";


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CreateDB</title>
    <link rel="stylesheet" href="./style.css">
    <style>
        body {
            text-align: center;
        }
    </style>
</head>
<body>
    <?php
    if($connDB->query($sqlDB)) {
        echo "<div class=\"alert green\">Database created successfully</div>";
    } else {
        echo "<div class=\"alert red\">Error: " . $connDB->error . "</div>";
    }

    $connDB->close();
 
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
    if(!$conn){
        die("ERROR: Could not connect. " . $conn->connect_error);
    }

    $sqlTable = "CREATE TABLE users (
        id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    );";

    if($conn->query($sqlTable)) {
        echo "<div class=\"alert green\">Table users created successfully</div>";
    } else {
        echo "<div class=\"alert red\">Error: " . $conn->error . "</div>";
    }

    $sql_admin = "INSERT INTO users (username, password) VALUES (?, ?)";
    if($stmt = $conn->prepare($sql_admin)) {

        $stmt->bind_param("ss", $param_username, $param_password);

        $param_username = "admin";
        $param_password = "$2y$10\$E4deOZTI3M.u10DT3nx0T.d0MQARyw2m/Z4xNRsLTVeBSY6poDeOC"; // Password is 123456

        if($stmt->execute()) {
            echo "<div class=\"alert green\">User admin created successfully</div>";
        } else {
            echo "<div class=\"alert red\">Error: " . $stmt->error . "</div>";
        }

        $stmt->close();
    }
    
    $conn->close();
    
    ?>
</body>
</html>