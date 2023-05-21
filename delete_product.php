require_once('database.php');

// Get IDs
$player_id = filter_input(INPUT_POST, 'player_id', FILTER_VALIDATE_INT);

// Delete the player from the database
if ($player_id != false) {
    $query = 'DELETE FROM Beta_Tester
              WHERE PlayerID = :player_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':player_id', $player_id);
    $success = $statement->execute();
    $statement->closeCursor();    
}

// Display the Player List page
include('index.php');
