<?php
require_once('database.php');

// Get player ID
if (!isset($player_id)) {
    $player_id = filter_input(INPUT_GET, 'player_id', FILTER_VALIDATE_INT);
    if ($player_id == NULL || $player_id == FALSE) {
        $player_id = 1;
    }
}
// Delete the player from the database
if (isset($_POST['player_id'])) {
    $delete_player_id = filter_input(INPUT_POST, 'player_id', FILTER_VALIDATE_INT);

    if ($delete_player_id !== NULL && $delete_player_id !== FALSE) {
        $query = 'DELETE FROM Beta_Tester WHERE PlayerID = :player_id';
        $delete_statement = $db->prepare($query);
        $delete_statement->bindValue(':player_id', $delete_player_id);
        $delete_statement->execute();
        $delete_statement->closeCursor();
    }
}

// Get name for selected player
$queryPlayer = 'SELECT * FROM Beta_Tester WHERE PlayerID = :player_id';
$statement1 = $db->prepare($queryPlayer);
$statement1->bindValue(':player_id', $player_id);
$statement1->execute();
$player = $statement1->fetch();
$player_name = $player['PlayerFname'] . ' ' . $player['PlayerLname'];
$statement1->closeCursor();

// Get all games
$query = 'SELECT * FROM Game ORDER BY GameID';
$statement = $db->prepare($query);
$statement->execute();
$games = $statement->fetchAll();
$statement->closeCursor();

if(isset($_GET['game_id'])){
    $game_id = $_GET['game_id'];

    $queryGame = 'SELECT Gamename FROM Game WHERE GameID = :game_id';
    $statement2 = $db->prepare($queryGame);
    $statement2->bindValue(':game_id', $game_id);
    $statement2->execute();
    $game = $statement2->fetch();
    $game_name = $game['Gamename'];
    $statement2->closeCursor();


    // Get players for selected game
    $queryPlayers = 'SELECT bt.* FROM Beta_Tester bt
                INNER JOIN Payment p ON bt.PlayerID = p.PlayerID
                WHERE p.GameID = :game_id
                ORDER BY bt.PlayerID';
    $statement3 = $db->prepare($queryPlayers);
    $statement3->bindValue(':game_id', $game_id);
    $statement3->execute();
    $players = $statement3->fetchAll();
    $statement3->closeCursor();
}
?>

<!DOCTYPE html>
<html>
<!-- the head section -->
<head>
    <title>Game Manager</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
</head>
<!-- the body section -->
<body>
    <header><h1>Game Manager</h1></header>
    <main>
        <h1>Game List</h1>
        <aside>
            <!-- display a list of games -->
            <h2>Games</h2>
            <nav>
                <ul>
                    <?php foreach ($games as $game) : ?>
                        <li>
                            <a href=".?game_id=<?php echo $game['GameID']; ?>">
                                <?php echo $game['Gamename']; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </nav>          
        </aside>
        <section>
            <?php if (isset($game_name)) : ?>
            <!-- display a table of players for selected game -->
            <h2><?php echo $game_name; ?></h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Street</th>
                    <th>City</th>
                    <th>Zip Code</th>
                    <th>State</th>
                </tr>
                <?php foreach ($players as $player) : ?>
                    <tr>
                        <td><?php echo $player['PlayerID']; ?></td>
                        <td><?php echo $player['PlayerFname'] . ' ' . $player['PlayerLname']; ?></td>
                        <td><?php echo $player['Street1']; ?></td>
                        <td><?php echo $player['Street2']; ?></td>
                        <td><?php echo $player['ZipCode']; ?></td>
                        <td><?php echo $player['State']; ?></td>
                        <td>
                        <form action="edit_player_form.php" method="post"
                            input type="hidden" name="player_id"
                                value="<?php echo $player['PlayerID']; ?>">
                            <input type="submit" value="Edit">
                </form>
                </td>
                        <td>
                        <form action="delete_player.php" method="post">
                        <input type="hidden" name="player_id"
                            value="<?php echo $player['PlayerID']; ?>">
                        <input type="submit" value="Delete">
                    </form>
                </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <p><a href="add_player_form.php?game_id=<?php echo $game_id; ?>">Add Player</a></p>
            <?php else : ?>
                <p>No game selected.</p>
            <?php endif; ?>
            <p><a href="game_list.php">List Games</a></p>        
        </section>
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Game Manager Inc.</p>
    </footer>
</body>
</html>
