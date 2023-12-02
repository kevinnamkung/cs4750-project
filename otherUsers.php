<?php
    #session_start();
    require("connect-db.php");
    require("players-db.php");
    require("userdb.php");

    session_start();
        
    //check if user is logged in
    if(!isset($_SESSION["logged"]) && $_SESSION["logged"] == false){
        header("location: userLogin.php");
        exit;
    }
?>



<!DOCTYPE html>
<html>
<head>
        <meta charset="UTF-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="kevin">
        <meta name="description" content="User Form">  
        <title>Other User</title>
        <link rel="stylesheet" type="text/css" href="shared/homestyle.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <style>
            /* Center text elements within the body */
            body_x {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }
        </style>
    </head>
    <body style="background-color: #d4d4dc;">
        <?php include('shared/header.php'); ?>
        <div class="container">
        <h1>
        <?php
                if (isset($_GET['userID'])) {
                    //get userID form url
                    $userID = htmlspecialchars($_GET['userID']);
                    echo "Viewing $userID 's squad";
                } else {
                    // Handle the case when the user ID is not present in the URL
                    echo "Something went wrong";
                }
                ?>
        </h1>
        <body_x>
            <br>
            <?php
                if (isset($_GET['userID'])) {
                    $userID = htmlspecialchars($_GET['userID']);
                    $list_of_teams=displayTeams($userID['userID']);
                    echo $list_of_teams;
                    //get userID form url
                    //$userID = htmlspecialchars($_GET['userID']);
                    //echo "Viewing $userID 's squad";
                } else {
                    // Handle the case when the user ID is not present in the URL
                    echo "Something went wrong";
                }
                ?>

            <br>
        </body_x>
    </body>
</html>
