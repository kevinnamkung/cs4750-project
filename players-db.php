<?php
function getAllPlayers()
{
  global $db;
  $query = "select * from Players";
  $statement = $db->prepare($query); 
  $statement->execute();
  $results = $statement->fetchAll();   // fetch()
  $statement->closeCursor();
  return $results;
}

function filterPlayers($playerName, $position, $club, $nationality)
{
    global $db;

    $query = "select * from Players WHERE 1=1"; // Starting with a true condition
    
    // Add conditions for filtering if criteria are provided
    if ($playerName !== null && !empty($playerName)) {
        $query .= " AND playerName = :playerName";
        //if ($position!=NULL or $club!=NULL or $nationality !=NULL){
        //    $query .= " AND";
        //}
        
    }
    
    if ($position !== null && !empty($position)) {
        $query .= " AND position = :position";
        //if ($club!=NULL or $nationality !=NULL){
        //    $query .= " AND";
        //}
    }
    
    if ($club !== null && !empty($club)) {
        $query .= " AND club = :club";
        //if ($nationality !=NULL){
        //    $query .= " AND";
        //}
    }
    
    if ($nationality !== null && !empty($nationality)) {
        $query .= " AND nationality = :nationality";
    }

    $statement = $db->prepare($query);

    // Bind parameters if they are provided
    if ($playerName !== null && !empty($playerName)) {
        $statement->bindValue(':playerName', $playerName);
    }

    if ($position !== null && !empty($position)) {
        $statement->bindValue(':position', $position);
    }

    if ($club !== null && !empty($club)) {
        $statement->bindValue(':club', $club);
    }

    if ($nationality !== null && !empty($nationality)) {
        $statement->bindValue(':nationality', $nationality);
    }

        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closeCursor();
        return $results;
}
?>