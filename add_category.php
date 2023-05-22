<?php
// Get the game data
$gameID = filter_input(INPUT_POST, 'game_id');
$gameName = filter_input(INPUT_POST, 'game_name');

// Validate inputs
if ($gameID === null || $gameName === null) {
    $error = "Invalid game data. Check all fields and try again.";
    include('error.php');
} else {
    require_once('database.php');

    // Add the game to the database
    $query = 'INSERT INTO Game (GameID, Gamename) VALUES (:game_id, :game_name)';
    $statement = $db->prepare($query);
    $statement->bindValue(':game_id', $gameID);
    $statement->bindValue(':game_name', $gameName);
    $success = $statement->execute();
    $statement->closeCursor();

    // Redirect to the Game List page
    header("Location: game_list.php");
    exit();
}
?>
