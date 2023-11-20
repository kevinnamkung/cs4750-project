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
        $query .= " AND playerName = :playerName";
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
        $statement->bindValue(':playerName', $playerName);
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
?>