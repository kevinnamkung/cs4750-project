<?php
function getAllPlayers()
{
  global $db;
  $query = "SELECT * FROM Players;"; 
  
  $statement = $db->prepare($query); 
  $statement->execute();
  $results = $statement->fetchAll();   // fetch()
  $statement->closeCursor();
  return $results;
}

function filterPlayers($playerName, $position, $club, $nationality, $filterStat, $filterOp, $filterNum, $sortedStat, $sortedCrit)
{
    global $db;

    $query = "SELECT * FROM Players";
    
    if ($position !== null && !empty($position)) {
        if($position == "Forward") {
            $query .= " NATURAL JOIN Forward";

        }
        if($position == "Midfielder") {
            $query .= " NATURAL JOIN Midfielder";

        }
        if($position == "Defender") {
            $query .= " NATURAL JOIN Defender";

        }
        if($position == "Goalkeeper") {
            $query .= " NATURAL JOIN Goalkeepers";
        }
    }

    $query .= " WHERE 1=1";

    // Add conditions for filtering if criteria are provided
    if ($playerName !== null && !empty($playerName)) {
        $query .= " AND playerName LIKE :playerName";
    }
    
    if ($club !== null && !empty($club)) {
        $query .= " AND club = :club";
    }
    
    if ($nationality !== null && !empty($nationality)) {
        $query .= " AND nationality = :nationality";
    }

    if ($filterNum !== null && !empty($filterNum)) {
        $query .= " AND $filterStat $filterOp :filterNum";
    }

    if($sortedCrit !== "none" && !empty($sortedCrit)){
        $query .= " ORDER BY $sortedStat $sortedCrit";
    }

    $statement = $db->prepare($query);

    // Bind parameters if they are provided
    if ($playerName !== null && !empty($playerName)) {
        $pattern = "%" . $playerName . "%";
        $statement->bindValue(':playerName', $pattern);
    }

    if ($club !== null && !empty($club)) {
        $statement->bindValue(':club', $club);
    }

    if ($nationality !== null && !empty($nationality)) {
        $statement->bindValue(':nationality', $nationality);
    }
    
    if ($filterNum !== null && !empty($filterNum)) {
        $statement->bindValue(':filterNum', $filterNum);
    }

    $statement->execute();
    $results = $statement->fetchAll();
    $statement->closeCursor();
    return $results;
}

function addPlayer($userID, $teamName, $playerName){
    global $db;
    $query = "INSERT INTO PlayerList (userID, teamName, playerName) VALUES (:userID, :teamName, :playerName)";
    $statement = $db->prepare($query); 

    if ($userID !== null && !empty($userID)) {
        $statement->bindValue(':userID', $userID);
    }

    if ($teamName !== null && !empty($teamName)) {
        $statement->bindValue(':teamName', $teamName);
    }

    if ($playerName !== null && !empty($playerName)) {
        $statement->bindValue(':playerName', $playerName);
    }

    $statement->execute();
    $statement->closeCursor();
}

function deletePlayer($userID, $teamName, $playerName) {
    global $db;
    $query = "DELETE FROM PlayerList WHERE userID = :userID AND teamName = :teamName AND playerName = :playerName";
    $statement = $db->prepare($query); 

    if ($userID !== null && !empty($userID)) {
        $statement->bindValue(':userID', $userID);
    }

    if ($teamName !== null && !empty($teamName)) {
        $statement->bindValue(':teamName', $teamName);
    }

    if ($playerName !== null && !empty($playerName)) {
        $statement->bindValue(':playerName', $playerName);
    }

    $statement->execute();
    $statement->closeCursor();
}
?>