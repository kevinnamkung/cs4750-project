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

            .team-list-container {
        margin-top: 20px; /* Add margin to create space between header and list */
    }

    .team-list-title {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 10px;
        text-align: center;
    }

    .team-list {
        list-style-type: none;
        padding: 10px;
        margin: 5px;
        background-color: white;
        border-radius: 5px;
    }

    .team-item {
        margin-top: 5px;
        margin-bottom: 5px;
        padding: 5px;
        background-color: white;
        font-weight: bold;
        position: relative;
    }

    .team-link {
        text-decoration: none;
        color: #333;
    }

    .team-link:hover {
        color: #0066cc;
    }

    .team-item:not(:last-child)::after {
        content: "";
        display: block;
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100%;
        height: 1px;
        background-color: #ccc;
    }

        </style>
    </head>
<body style="background-color: #d4d4dc;">
    <?php include('shared/header.php'); ?>

    <body_x>
        <br>
        <h1>Premier League Dream Team Maker</h1>
        
        <h2>Welcome <?php echo htmlspecialchars($_SESSION["firstName"]); ?>!</h2>

        <div class="team-list-container">
            <div class="team-list-title">Your Teams</div>
            <ul class="team-list">
                <?php foreach ($list_of_teams as $team): ?>
                    <li class="team-item">
                        <a class="team-link" href="teamPlayers.php?team=<?= urlencode($team['teamName']); ?>">
                            <?= $team['teamName']; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

    <button onclick="location.href='createTeam.php'" type="button" class="btn btn-primary">Create New Team</button>



    </body_x>
    
</body>
</html>
