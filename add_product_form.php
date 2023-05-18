<?php
require('database.php');

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
    <header><h1>Game Manager</h1></header>

    <main>
        <h1>Add Game</h1>
        <form action="add_product.php" method="post" id="add_product_form">
            <label>Add game to Player:</label>
            <select name="player_id">
            <?php foreach($beta_tester as $betaP) : ?>
                <option value="<?php echo $betaP['PlayerID']; ?>">
                <?php echo $player['PlayerFname'].''.['PlayerLname']; ?>
            </option>
            <?php endforeach;?>
            </select><br>     

            <label>Game ID:</label>
            <input type="text" name="game_id"><br>

            <label>Game Name:</label>
            <input type="text" name="game_name"><br>

            <label>Date Released:</label>
            <input type="text" name="date_released"><br>

            <label>Game Cost:</label>
            <input type="text" name="game_cost"><br>

            <label>&nbsp;</label>
            <input type="submit" value="Add Game"><br>
        </form>
        <p><a href="index.php">View Game List</a></p>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Game Inc.</p>
    </footer>
</body>
</html>
