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
        <form action="index.php" method="post" id="Add Player">
            <label>Select a Game:</label>
            <select name="game_id">
                <?php foreach($games as $game) : ?>
                    <option value="<?php echo $game['GameID']; ?>">
                        <?php echo $game['Gamename']; ?>
                    </option>
                <?php endforeach; ?>
            </select><br>     

            <label>Player First Name:</label>
            <input type="text" name="player_fname"><br>

            <label>Player Last Name:</label>
            <input type="text" name="player_lname"><br>

            <label>Street 1:</label>
            <input type="text" name="street1"><br>

            <label>Street 2:</label>
            <input type="text" name="street2"><br>

            <label>Zip Code:</label>
            <input type="text" name="zip_Code"><br>

            <label>State:</label>
            <input type="text" name="state"><br>

            <label>&nbsp;</label>
            <input type="submit" value="Add Player"><br>
        </form>
        <p><a href="index.php">View Game List</a></p>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Game Inc.</p>
    </footer>
</body>
</html>
