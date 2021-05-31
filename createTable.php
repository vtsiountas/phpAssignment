<?php

// Include config file
require_once "config.php";

session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
if($_SESSION["username"] != "admin") {
    die("You do not have permission to access this page.");
}


$sql = "CREATE TABLE forms (
    userID INT NOT NULL,
    FOREIGN KEY (userID) REFERENCES users(id),
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    gender CHAR(1) NOT NULL,
    country VARCHAR(25) NOT NULL,
    birthdate date NOT NULL,
    comment VARCHAR(1500),
    submited_at DATETIME DEFAULT CURRENT_TIMESTAMP
);";
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
    if($conn->query($sql)) {
        echo "<div class=\"alert green\">Table forms created successfully</div>";
    } else {
        echo "<div class=\"alert red\">Error creating table: " . $conn->error . "</div>";
    }
    ?>
</body>
</html>
