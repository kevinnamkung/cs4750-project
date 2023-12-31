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

    $userID = htmlspecialchars($_GET['userID']);
    $userData = retrieveUserData($userID);
    $firstName = $userData[0]['firstName'];
    $lastName = $userData[0]['lastName'];
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
        <body_x>
            <br>
            <?php echo "<h2> $firstName's Teams </h2>" ?>
            <?php
                if (isset($_GET['userID'])) {
                    $list_of_teams=displayTeams($userID);
                    if (!empty($list_of_teams)) {
                        echo '<ul>';
                        foreach ($list_of_teams as $team) {
                            echo '<li>';
                            echo '<a href="otherPlayers.php?userID=' . urlencode($userID) . '&team=' . urlencode($team['teamName']) . '">';
                            echo $team['teamName'];
                            echo '</a>';
                            echo '</li>';
                        }
                        echo '</ul>';
                    } else {
                        echo "No teams found for $firstName";
                    }
                } else {
                    // Handle the case when the user ID is not present in the URL
                    echo "Something went wrong";
                }
                ?>

            <br>
        </body_x>
    </body>
</html>
