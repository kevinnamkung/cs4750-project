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

    $list_of_users = retrieveUsers($_SESSION["userID"]);

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (!empty($_POST['userTeamsBtn'])) {
          deletePlayer($_SESSION['userID'], $selectedTeam, $_POST['playerName']);
          $player = $_POST['playerName'];
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
        <title>Users</title>
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
            <h2>List of Users</h2>
            <table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
            <thead>
                <tr style="background-color:#B0B0B0">
                <th width="30%">First Name     
                <th width="30%">Last Name
                <th width="30%">Email
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                </tr>
            </thead>
            <?php foreach ($list_of_users as $user): ?>
                <tr>
                    <td><?php echo $user['firstName']; ?></td>
                    <td><?php echo $user['lastName']; ?></td>   
                    <td><?php echo $user['email']; ?></td>      
                    <td>
                    <form method="post" action="otherUsers.php?userID=<?php echo $user['userID']; ?>">
                        <input type="hidden" name="userID" value="<?php echo $user['userID']; ?>">
                        <input type="submit" name="userTeamsBtn" value="Teams" class="btn btn-secondary">
                    </form>

                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <br>
        </body_x>
    </body>
</html>
