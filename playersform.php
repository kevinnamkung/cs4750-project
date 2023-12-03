<?php
  require("connect-db.php");
  // include("connect-db.php");
  require("players-db.php");
  session_start();
  
  //check if user is logged in
  if(!isset($_SESSION["logged"]) && $_SESSION["logged"] == false){
      header("location: userLogin.php");
      exit;
  }

?>

<?php 
    $selectedTeam = $_SESSION['teamName'];
    $status_message = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
      if (!empty($_POST['addBtn'])) {
        addPlayer($_SESSION['userID'], $selectedTeam, $_POST['playerName']);
        $player = $_POST['playerName'];
        $status_message = "$player added successfuly!";
      }
    }
?>

<!DOCTYPE html>
<html>
<head>
        <meta charset="UTF-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="kevin">
        <meta name="description" content="players form">  
        <title>Player form</title>
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
            .position-buttons {
              display: flex;
              justify-content: space-around;
              margin: 20px 0;
            }

            .position-button {
                padding: 10px;
                text-decoration: none;
                color: #333;
                background-color: #eee;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            .position-button.active {
                background-color: #4285f4;
                color: #fff;
            }
        </style>
    </head>

<body style="background-color: #d4d4dc;">
<?php include('shared/header.php'); ?>
<div class="container">
  <h1>Waivers</h1>
  
  <?php if (!empty($status_message)): ?>
        <div class="alert alert-success mb-3 mx-3" role="alert">
            <?php echo $status_message; ?>
        </div>
    <?php endif; ?>

  <h4>Switch Positions:</h4>

  <div class="position-buttons">
    <?php
    //check if a position is selected
    if (isset($_GET['position'])) {
        $selectedPosition = $_GET['position'];
    } else {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['filterBtn'])) {
          $selectedPosition = $_POST['selectedPosition'];
        } else{ 
          $selectedPosition = "Forward";
        }
    }

    // Create buttons for different positions
    $positions = ['Forward', 'Midfielder', 'Defender', 'Goalkeeper'];
    foreach ($positions as $pos) {
        //highlight the selected button
        $activeClass = ($pos === $selectedPosition) ? 'active' : '';

        //link
        echo "<a href=\"?position=$pos\" class=\"position-button $activeClass\">$pos</a>";
    }
    ?>
</div>

  <!-- <a href="simpleform.php">Click to open the next page</a> -->
 
  <form name="mainForm" action="playersform.php" method="post">
      <h4>Filter based on Attributes:</h4>  
      <div class="row mb-3 mx-3">
        Player name:
        <input type="text" class="form-control" name="playerName" />        
      </div>  
      <div class="row mb-3 mx-3">
        Club:
        <select class="form-control" name="club">
            <option value="">Any Club</option>
            <option value="Arsenal">Arsenal</option>
            <option value="Aston-Villa">Aston-Villa</option>
            <option value="Brighton-and-Hove-Albion">Brighton-and-Hove-Albion</option>
            <option value="Burnley">Burnley</option>
            <option value="Chelsea">Chelsea</option>
            <option value="Club">Club</option>
            <option value="Crystal-Palace">Crystal-Palace</option>
            <option value="Everton">Everton</option>
            <option value="Fulham">Fulham</option>
            <option value="Leeds-United">Leeds-United</option>
            <option value="Leicester-City">Leicester-City</option>
            <option value="Liverpool">Liverpool</option>
            <option value="Manchester-City">Manchester-City</option>
            <option value="Manchester-United">Manchester-United</option>
            <option value="Newcastle-United">Newcastle-United</option>
            <option value="Sheffield-United">Sheffield-United</option>
            <option value="Tottenham-Hotspur">Tottenham-Hotspur</option>
            <option value="West-Bromwich-Albion">West-Bromwich-Albion</option>
            <option value="West-Ham-United">West-Ham-United</option>
            <option value="Wolverhampton-Wanderers">Wolverhampton-Wanderers</option>
        </select>
      </div>  
      <div class="row mb-3 mx-3">
        Nationality:
        <input type="text" class="form-control" name="nationality" />        
      </div>
      <h4>Filter based on Statistic:</h4>
      <div class="row mb-3 mx-3">
        <div class="form-group d-flex">
          <div class="mr-2">
            <select class="form-control" name="filterStat">
              <?php if ($selectedPosition == 'Forward'): ?>
                <option value="goals">Goals</option>
                <option value="assists">Assists</option>
                <option value="shots">Shots</option>
              <?php elseif ($selectedPosition == 'Midfielder'): ?>
                <option value="duelsWon">Duels Won</option>
                <option value="assists">Assists</option>
                <option value="passes">Passes</option>
              <?php elseif ($selectedPosition == 'Defender'): ?>
                <option value="cleanSheets">Clean Sheets</option>
                <option value="tackleSuccess">Tackle Success (%)</option>
              <?php elseif ($selectedPosition == 'Goalkeeper'): ?>
                <option value="cleanSheets">Clean Sheets</option>
                <option value="saves">Saves</option>
              <?php endif; ?>
            </select>
          </div>
          <div class="mr-2">
            <select class="form-control" name="filterOperator">
                <option value="=">=</option>
                <option value=">">></option>
                <option value="<"><</option>
            </select>
          </div>
          <div>
            <input type="number" class="form-control" name="filterNumber" />
          </div>
        </div>
      </div>
      <h4>Sort based on Statistic:</h4>
      <div class="row mb-3 mx-3">
        <div class="form-group d-flex">
          <div class="mr-2">
            <select class="form-control" name="sortedStat">
              <?php if ($selectedPosition == 'Forward'): ?>
                <option value="goals">Goals</option>
                <option value="assists">Assists</option>
                <option value="shots">Shots</option>
              <?php elseif ($selectedPosition == 'Midfielder'): ?>
                <option value="duelsWon">Duels Won</option>
                <option value="assists">Assists</option>
                <option value="passes">Passes</option>
              <?php elseif ($selectedPosition == 'Defender'): ?>
                <option value="cleanSheets">Clean Sheets</option>
                <option value="tackleSuccess">Tackle Success (%)</option>
              <?php elseif ($selectedPosition == 'Goalkeeper'): ?>
                <option value="cleanSheets">Clean Sheets</option>
                <option value="saves">Saves</option>
              <?php endif; ?>
            </select>
          </div>
          <div class="mr-2">
            <select class="form-control" name="sortedCrit">
                <option value="none">None</option>
                <option value="ASC">Ascending</option>
                <option value="DESC">Descending</option>
            </select>
          </div>
        </div>
      </div>
      <!-- hidden input -->
      <input type="hidden" name="selectedPosition" value="<?php echo htmlspecialchars($selectedPosition); ?>" /> 
      <div class="row mb-3 mx-3">
        <input type="submit" value="Filter" name="filterBtn" 
        class="btn btn-primary" title="Filter through Players" />
      </div>
    </form>     

<hr/>
<h2>Players</h2>
<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="30%">Player Name        
    <th width="30%">Position
    <th width="30%">Club     
    <th width="30%">Nationality
    <?php if ($selectedPosition == 'Forward'): ?>
        <th>Goals</th>
        <th>Assists</th>
        <th>Shots</th>
    <?php elseif ($selectedPosition == 'Midfielder'): ?>
        <th>Duels Won</th>
        <th>Assists</th>
        <th>Passes</th>
    <?php elseif ($selectedPosition == 'Defender'): ?>
        <th>Clean Sheets</th>
        <th>Tackle Success (%)</th>
    <?php elseif ($selectedPosition == 'Goalkeeper'): ?>
        <th>Clean Sheets</th>
        <th>Saves</th>
    <?php endif; ?>
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  </thead>

<!-- lot of stuff happens here -->
<?php $list_of_players=filterPlayers(null, $selectedPosition, null, null, null, null, null, null, null); ?>
<?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['filterBtn'])) {
  $list_of_players=filterPlayers(
    $_POST['playerName'], 
    $_POST['selectedPosition'],
    $_POST['club'],
    $_POST['nationality'],
    $_POST['filterStat'],
    $_POST['filterOperator'],
    $_POST['filterNumber'],
    $_POST['sortedStat'],
    $_POST['sortedCrit']);
  $results_length = count($list_of_players);

  echo "<h4>Showing <b>$results_length</b> result(s):</h4>";
}
?>
<?php foreach ($list_of_players as $player): ?>
  <tr>
     <td><?php echo $player['playerName']; ?></td>   <!-- column name --> 
     <td><?php echo $player['position']; ?></td>   
     <td><?php echo $player['club']; ?></td>      
     <td><?php echo $player['nationality']; ?></td>
    <?php if ($selectedPosition == 'Forward'): ?>
        <td><?php echo $player['goals']; ?></td>
        <td><?php echo $player['shots']; ?></td>
        <td><?php echo $player['assists']; ?></td>
    <?php elseif ($selectedPosition == 'Midfielder'): ?>
        <td><?php echo $player['duelsWon']; ?></td>
        <td><?php echo $player['assists']; ?></td>
        <td><?php echo $player['passes']; ?></td>
    <?php elseif ($selectedPosition == 'Defender'): ?>
        <td><?php echo $player['cleanSheets']; ?></td>
        <td><?php echo $player['tackleSuccess']; ?></td>
    <?php elseif ($selectedPosition == 'Goalkeeper'): ?>
        <td><?php echo $player['cleanSheets']; ?></td>
        <td><?php echo $player['saves']; ?></td>
    <?php endif; ?>
    <?php if (isset($_SESSION['teamName'])):?>
     <td>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="playerName" value="<?php echo $player['playerName']; ?>">
            <input type="submit" name="addBtn" value="Add" class="btn btn-secondary">
        </form>
    </td>
    <?php endif; ?>
  </tr>
<?php endforeach; ?>
</table>
</div>  
  
</div>    
</body>
</html>
