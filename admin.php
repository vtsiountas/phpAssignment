<?php

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
if($_SESSION["username"] != "admin") {
    die("You do not have permission to access this page.");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="./style.css">
    <style>
        body {
            text-align: center;
        }
        .wrapper {
            display: grid;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <a class="admin-btns" href="./createTable.php">Create table</a>
        <a class="admin-btns" href="./showDB.php">ShowDB</a>
        <a class="admin-btns" href="./search.php">Search</a>

        <a href="./logout.php" style="margin-top: 100px;">Sign Out</a>
    </div>
</body>
</html>