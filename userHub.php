<?php
    #session_start();
    
    require("connect-db.php");
    require("userdb.php");

    session_start();
        
    //check if user is logged in
    if(!isset($_SESSION["logged"]) && $_SESSION["logged"] == false){
        header("location: userLogin.php");
        exit;
    }

    $list_of_teams = displayTeams($_SESSION['userID']);
?>
<!DOCTYPE html>
<html>
<head>
        <meta charset="UTF-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="kevin">
        <meta name="description" content="User Form">  
        <title>User Hub</title>
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
        <h1>Premier League Dream Team Maker</h1>
        
        <h2>Welcome <?php echo htmlspecialchars($_SESSION["firstName"]); ?>!</h2>

        <h3>Your Teams:</h3>
        <ul>
            <?php foreach ($list_of_teams as $team): ?>
                <li>
                    <a href="teamPlayers.php?team=<?php echo urlencode($team['teamName']); ?>">
                        <?php echo $team['teamName']; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

    </body_x>
    
</body>
</html>
