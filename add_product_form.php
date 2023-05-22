<?php
require_once('database.php');

$query = 'SELECT *
          FROM Game
          ORDER BY GameID';

$statement = $db->prepare($query);
$statement->execute();
$games = $statement->fetchAll();
$statement->closeCursor();
?>
<!DOCTYPE html>
<html>
<!-- the head section -->
<head>
    <title>Game Manager</title>
    <link rel="stylesheet" type="text/css" href="main.css">
</head>
<!-- the body section -->
<body>
    <header>
        <h1>Game Manager</h1>
    </header>

    <main>
        <h1>Add Player to Game</h1>
        <form action="add_player.php" method="post" id="Add_Player_Form">
            <label for="game_id">Select a Game:</label>
            <select name="game_id" id="game_id">
                <?php foreach($games as $game) : ?>
                    <option value="<?php echo $game['GameID']; ?>">
                        <?php echo $game['Gamename']; ?>
                    </option>
                <?php endforeach; ?>
            </select><br>

            <label for="player_fname">Player First Name:</label>
            <input type="text" name="player_fname" id="player_fname"><br>

            <label for="player_lname">Player Last Name:</label>
            <input type="text" name="player_lname" id="player_lname"><br>

            <label for="street1">Street 1:</label>
            <input type="text" name="street1" id="street1"><br>

            <label for="street2">Street 2:</label>
            <input type="text" name="street2" id="street2"><br>

            <label for="zip_code">Zip Code:</label>
            <input type="text" name="zip_code" id="zip_code"><br>

            <label for="state">State:</label>
            <input type="text" name="state" id="state"><br>

            <input type="submit" value="Add Player"><br>
        </form>
        <p><a href="index.php">View Game List</a></p>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Game Inc.</p>
    </footer>
</body>
</html>
