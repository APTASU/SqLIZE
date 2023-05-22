<?php
// Get game ID
$gameID = filter_input(INPUT_POST, 'game_id', FILTER_VALIDATE_INT);

// Validate inputs
if ($gameID === null || $gameID === false) {
    $error = "Invalid game ID.";
    include('error.php');
} else {
    require_once('database.php');

    // Delete the game from the database
    $query = 'DELETE FROM Game WHERE GameID = :game_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':game_id', $gameID);
    $success = $statement->execute();
    $statement->closeCursor();

    // Redirect to the Game List page
    header("Location: game_list.php");
    exit();
}
?>
