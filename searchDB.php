<?php

session_start();

require_once "config.php";

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

if($_SESSION["username"] != "admin") {
    die("You do not have permission to access this page.");
}


function fix_post($string) {
    return htmlspecialchars(stripslashes(trim($string)));
}
$err = "";
$firstnames = $lastnames = $emails = $countries = $birthdates = $comments = array();

foreach($_POST["firstnames"] as $firsname) {
    if(!empty($firsname = fix_post($firsname))) {
        array_push($firstnames, fix_post($firsname));
    }
}

foreach($_POST["lastnames"] as $lastname) {
    if(!empty($lastname = fix_post($lastname))) {
        array_push($lastnames, $lastname);
    }
}

foreach($_POST["emails"] as $email) {
    if(!empty($email = fix_post($email))) {
        array_push($emails, $email);
    }
}

foreach($_POST["countries"] as $country) {
    if($country != '0') {
        array_push($countries, fix_post($country));
    }
}

foreach($_POST["birthdates"] as $birthdate) {
    if(!empty($birthdate)) {
        array_push($birthdates, date('Y-m-d', strtotime($birthdate)));
    }
}

foreach($_POST["comments"] as $comment) {
    if(!empty($comment = fix_post($comment))) {
        array_push($comments, $comment);
    }
}

$gender = "b";
if($_POST["gender"] == "m") {
    $gender = "m";
} else if($_POST["gender"] == "f") {
    $gender = "f";
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SearchDB</title>
    <link rel="stylesheet" href="./style.css">
    <style>
        body {
            text-align: center;
        }
    </style>
</head>
<body>
    <?php
    if(!isset($_POST["searchSubmit"])) {
        header("location: searchTest.php");
    }
    ?>

    <table>



        <?php

        $query = "SHOW columns FROM forms";
        if($queryResult = $conn->query($query)) {
            echo "<tr>";
            while($queryRow = $queryResult->fetch_row()) {
                echo "<th>$queryRow[0]</th>";
            }
            echo "<tr>";
        } else {
            echo $err = "<div class=\"alert red\">Error: Table forms has maybe not been created.</div>";
        }




        if(empty($err)) {


            $previous_filter = false;
            $query = "";

            if(!empty($firstnames)) {

                $previous_filter = true;

                $query .= "SELECT * FROM forms WHERE firstname = \"" . $firstnames[0] . "\"";
                
                for($i=1; $i<count($firstnames); $i++) {
                    $query .= " || firstname = \"" . $firstnames[$i] . "\"";
                }
            }



            

            if(!empty($lastnames)) {


                if($previous_filter) {
                    $query .= " INTERSECT ";
                }

                $previous_filter = true;

                $query .= "SELECT * FROM forms WHERE lastname = \"" . $lastnames[0] . "\"";


                for($i=1; $i<count($firstnames); $i++) {
                    $query .= " || lastname = \"" . $lastnames[$i] . "\"";
                }

            }
            

            if(!empty($emails)) {

                if($previous_filter) {
                    $query .= " INTERSECT ";
                }

                $previous_filter = true;

                $query .=   "SELECT * FROM forms WHERE email like \"%" . $emails[0] . "%\"";

                for($i=1; $i<count($emails); $i++) {
                    $query .= " || email like\"%" . $emails[$i] . "%\"";
                }

            }

            if($gender != "b") {


                if($previous_filter) {
                    $query .= " INTERSECT ";
                }

                $previous_filter = true;

                $query .=   "SELECT * FROM forms WHERE gender =\"" . $gender . "\"";


            }


            if(!empty($countries)) {
                
                if($previous_filter) {
                    $query .= " INTERSECT ";
                }

                $previous_filter = true;

                $query .= "SELECT * FROM forms WHERE country = \"" . $countries[0] . "\"";

                for($i=1; $i<count($countries); $i++) {
                    $query .= " || country = \"" . $countries[$i] . "\"";
                }

            }

            if(!empty($birthdates)) {
                
                if($previous_filter) {
                    $query .= " INTERSECT ";
                }

                $previous_filter = true;

                $query .= "SELECT * FROM forms WHERE birthdate = \"" . $birthdates[0] . "\"";

                for($i=1; $i<count($birthdates); $i++) {
                    $query .= " || birthdate = \"" . $birthdates[$i] . "\"";
                }
                
            }
            

            if(!empty($comments)) {

                if($previous_filter) {
                    $query .= " INTERSECT ";
                }

                $previous_filter = true;

                $query .=   "SELECT * FROM forms WHERE comment like \"%" . $comments[0] . "%\"";

                for($i=1; $i<count($comments); $i++) {
                    $query .= " || comment like\"%" . $comments[$i] . "%\"";
                }

            }


            if(empty($query)) {
                $query = "SELECT * FROM forms";
            }


            // echo "<div class=\"alert green\">" . $query . "</div>";


            if($queryResult = $conn->query($query)) {
                while ($queryRow = $queryResult->fetch_row()) {
                    echo "<tr>";
                    for($i = 0; $i < $queryResult->field_count; $i++){
                        echo "<td>$queryRow[$i]</td>";
                    }
                    echo "</tr>";
                }
            }


        }


        $conn->close();

        ?>
    </table>
</body>
</html>