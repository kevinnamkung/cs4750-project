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
        <title>Other Players</title>
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
        <body_x>
            <br>
        <table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
            <thead>
                <tr style="background-color:#B0B0B0">
                <th width="30%">Player Name        
                <th width="30%">Position
                <th width="30%">Club     
                <th width="30%">Nationality
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                </tr>
            </thead>
            <?php
            $selectedTeam = urldecode($_GET['team']);
            $selectedUser = urldecode($_GET['userID']);
            $players = retrieveTeamPlayers($selectedUser, $selectedTeam);

            echo '<h2>Team: ' . htmlspecialchars($selectedTeam) . '</h2>';
            ?>
            <?php foreach ($players as $player): ?>
                <?php $full_player = findPlayer($player['playerName']); ?>
                <tr>
                    <td><?php echo $full_player[0]['playerName']; ?></td>
                    <td><?php echo $full_player[0]['position']; ?></td>   
                    <td><?php echo $full_player[0]['club']; ?></td>      
                    <td><?php echo $full_player[0]['nationality']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        </body_x>
    </body>
</html>
