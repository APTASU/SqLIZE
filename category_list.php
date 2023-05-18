<?php
require_once('database.php');

// Get all games
$query = 'SELECT * FROM Game
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
    <title>My Game Shop</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
</head>

<!-- the body section -->
<body>
<header><h1>Game Manager</h1></header>
<main>
    <h1>Game List</h1>
    <table>
        <tr>
            <th>Name</th>
            <th>Date Released</th>
            <th>Cost</th>
            <th>&nbsp;</th>
        </tr>        
        <?php foreach ($games as $game) : ?>
        <tr>
            <td><?php echo $game['Gamename']; ?></td>
            <td><?php echo $game['Date_Realeased']; ?></td>
            <td><?php echo $game['GameCost']; ?></td>
            <td>
                <form action="delete_game.php" method="post">
                    <input type="hidden" name="game_id"
                           value="<?php echo $game['GameID']; ?>"/>
                    <input type="submit" value="Delete"/>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>    
    </table>

    <h2 class="margin_top_increase">Add Game</h2>
    <form action="add_game.php" method="post"
          id="add_game_form">

        <label>Name:</label>
        <input type="text" name="name" />
        <br>

        <label>Date Released:</label>
        <input type="text" name="date_released" />
        <br>

        <label>Cost:</label>
        <input type="text" name="cost" />
        <br>

        <input id="add_game_button" type="submit" value="Add"/>
    </form>
    
    <p><a href="index.php">List Products</a></p>

</main>
<footer>
    <p>&copy; <?php echo date("Y"); ?> My Game Shop, Inc.</p>
</footer>
</body>
</html>
