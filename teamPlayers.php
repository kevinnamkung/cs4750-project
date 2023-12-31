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

<?php 
    $selectedTeam = urldecode($_GET['team']);
    $status_message = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
      if (!empty($_POST['delBtn'])) {
        deletePlayer($_SESSION['userID'], $selectedTeam, $_POST['playerName']);
        $player = $_POST['playerName'];
        $status_message = "$player deleted successfuly";
      }
    }
?>


<!DOCTYPE html>
<html>
<head>
        <meta charset="UTF-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="kevin">
        <meta name="description" content="User Form">  
        <title>Team Players</title>
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
            <?php if (!empty($status_message)): ?>
                <div class="alert alert-danger mb-3 mx-3" role="alert">
                    <?php echo $status_message; ?>
                </div>
             <?php endif; ?>
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
            // Check if the team parameter is set
            $selectedTeam = urldecode($_GET['team']);
            $players = retrieveTeamPlayers($_SESSION['userID'], $selectedTeam);

            echo '<h2>Team: ' . htmlspecialchars($selectedTeam) . '</h2>';
            ?>
            <?php foreach ($players as $player): ?>
                <?php $full_player = findPlayer($player['playerName']); ?>
                <tr>
                    <td><?php echo $full_player[0]['playerName']; ?></td>
                    <td><?php echo $full_player[0]['position']; ?></td>   
                    <td><?php echo $full_player[0]['club']; ?></td>      
                    <td><?php echo $full_player[0]['nationality']; ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="playerName" value="<?php echo $player['playerName']; ?>">
                            <input type="submit" name="delBtn" value="Delete" class="btn btn-secondary">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <br>
        
        <a href="playersForm.php?teamName=<?php echo urlencode($selectedTeam); ?>">Add more players</a>
        <?php $_SESSION['teamName'] = $selectedTeam ?>
        </body_x>
    </body>
</html>
