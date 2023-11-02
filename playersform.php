<?php
require("connect-db.php");
// include("connect-db.php");
require("players-db.php");

// $list_of_friends = ''; 
$list_of_players = getAllPlayers();


if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
   if (!empty($_POST['addBtn']))
   {
      //filterPlayers($_POST['playerName'], $_POST['position'], $_POST['club'], $_POST['nationality']);
      $list_of_players=filterPlayers($_POST['playerName'], $_POST['position'], $_POST['club'], $_POST['nationality']);
      //$list_of_players = getAllPlayers();    
      // var_dump($list_of_friends);
   }
}
?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="your name">
  <meta name="description" content="include some description about your page">  
  <title>Get started with DB programming</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="icon" type="image/png" href="http://www.cs.virginia.edu/~up3f/cs4750/images/db-icon.png" />
</head>

<body>
<div class="container">
  <h1>Waivers</h1>  

  <!-- <a href="simpleform.php">Click to open the next page</a> -->
 
  <form name="mainForm" action="playersform.php" method="post">   
      <div class="row mb-3 mx-3">
        Player name:
        <input type="text" class="form-control" name="playerName" />        
      </div>  
      <div class="row mb-3 mx-3">
        Position:
        <select class="form-control" name="position">
            <option value="">Any Position</option>
            <option value="Forward">Forward</option>
            <option value="Midfielder">Midfielder</option>
            <option value="Defender">Defender</option>
            <option value="Goalkeeper">Goalkeeper</option>
        </select>       
      </div>  
      <div class="row mb-3 mx-3">
        Club:
        <select class="form-control" name="Club">
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
      <div class="row mb-3 mx-3">
        <input type="submit" value="Filter" name="addBtn" 
        class="btn btn-primary" title="Filter through Players" />
      </div>
    </form>     

<hr/>
<h3>List of players</h3>
<div class="row justify-content-center">  
<table class="w3-table w3-bordered w3-card-4 center" style="width:70%">
  <thead>
  <tr style="background-color:#B0B0B0">
    <th width="30%">PlayerName        
    <th width="30%">Position
    <th width="30%">Club     
    <th width="30%">Nationality 
    <th>&nbsp;</th>
    <th>&nbsp;</th>
  </tr>
  </thead>


<?php foreach ($list_of_players as $player): ?>
  <tr>
     <td><?php echo $player['playerName']; ?></td>   <!-- column name --> 
     <td><?php echo $player['position']; ?></td>   
     <td><?php echo $player['club']; ?></td>      
     <td><?php echo $player['nationality']; ?></td>  
     <td><input type="submit" value="add" class="btn btn-secondary" /></td>
  </tr>
<?php endforeach; ?>
</table>
</div>  



  <!-- CDN for JS bootstrap -->
  <!-- you may also use JS bootstrap to make the page dynamic -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->
  
  <!-- for local -->
  <!-- <script src="your-js-file.js"></script> -->  
  
</div>    
</body>
</html>