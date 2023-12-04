<?php
require("connect-db.php");
require("userdb.php");
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION["logged"]) || $_SESSION["logged"] == false) {
    header("location: userLogin.php");
    exit;
}

$current_userID = $_SESSION["userID"];
$list_of_users = retrieveUsers($current_userID);

function getCannotViewSettings($current_userID) {
    global $db;
    $query = "SELECT userID2 FROM CanView WHERE userID1 = :currentUserID";
    $statement = $db->prepare($query);
    $statement->bindValue(':currentUserID', $current_userID);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_COLUMN, 0);
    $statement->closeCursor();
    return $results;
}

$cannotViewSettings = getCannotViewSettings($current_userID);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateViewPreferences'])) {
    $db->beginTransaction();
    try {
        $removeQuery = "DELETE FROM CanView WHERE userID1 = :currentUserID AND userID2 = :otherUserID";
        $removeStmt = $db->prepare($removeQuery);

        $addQuery = "INSERT INTO CanView (userID1, userID2) VALUES (:currentUserID, :otherUserID)";
        $addStmt = $db->prepare($addQuery);

        foreach ($list_of_users as $user) {
            $otherUserID = $user['userID'];
            $shouldBlock = in_array($otherUserID, $_POST['canView'] ?? []);

            if (!$shouldBlock && in_array($otherUserID, $cannotViewSettings)) {
                $removeStmt->execute([':currentUserID' => $current_userID, ':otherUserID' => $otherUserID]);
            } elseif ($shouldBlock && !in_array($otherUserID, $cannotViewSettings)) {
                $addStmt->execute([':currentUserID' => $current_userID, ':otherUserID' => $otherUserID]);
            }
        }

        $db->commit();
    } catch (Exception $e) {
        $db->rollBack();
        error_log("Database error: " . $e->getMessage());
    }

    header("Location: manage-canview.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
        <meta charset="UTF-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="henry">
        <meta name="description" content="Manage viewers">  
        <title>Manage Viewers</title>
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

    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <br>
        <h2>Manage View Permissions</h2>
        <form method="post" action="manage-canview.php">
            <table>
                <?php foreach ($list_of_users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['firstName'] . ' ' . $user['lastName']); ?></td>
                        <td>
                            <button type="button" class="toggle-view" data-user-id="<?php echo $user['userID']; ?>"
                                    style="background-color: <?php echo in_array($user['userID'], $cannotViewSettings) ? 'red' : 'green'; ?>">
                                <?php echo in_array($user['userID'], $cannotViewSettings) ? 'No' : 'Yes'; ?>
                            </button>
                            <?php if (in_array($user['userID'], $cannotViewSettings)): ?>
                                <input type="hidden" name="canView[]" value="<?php echo $user['userID']; ?>">
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <br>
            <input type="submit" name="updateViewPreferences" value="Update Preferences" class="btn btn-primary">
        </form>
        <br>
    </div>

    <script>
        document.querySelectorAll('.toggle-view').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const userId = this.getAttribute('data-user-id');
                const canView = this.textContent === 'Yes';
                this.style.backgroundColor = canView ? 'red' : 'green';
                this.textContent = canView ? 'No' : 'Yes';

                let input = document.querySelector(`input[name="canView[]"][value="${userId}"]`);
                if (canView) {
                    if (!input) {
                        input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'canView[]';
                        input.value = userId;
                        this.form.appendChild(input);
                    }
                } else {
                    if (input) {
                        input.remove();
                    }
                }
            });
        });
    </script>
</body>
</html>
