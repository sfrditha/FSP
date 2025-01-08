<?php
require_once 'database.php';
require_once 'team_class.php';
require_once 'event_class.php';
require_once 'game_class.php';


$dbConnection = new Database();
$db = $dbConnection->getConnection();


$team = new Team($db);
$event = new Event($db);
$game = new Game($db);

// Mendapatkan parameter game dari URL
$id_game = isset($_GET['id_game']) ? (int) $_GET['id_game'] : 0;

if (empty($id_game)) {
    die('Game parameter is missing.');
}


$games1 = $game->getGame($id_game);
$games =  $games1->fetch_assoc();


if (!$games) {
    die('Game not found.');
}


$teams = $team->getTeamsByGame($id_game);
$events = $event->getEventsByGame($id_game);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($games['name']) ?> Details</title>
    <link rel="stylesheet" href="dash_details.css">
</head>

<body>
    <main class="details">
        <div class="container">
            <h1><?= htmlspecialchars($games['name']) ?> - Details</h1>

            <section id="teams" class="team-details">
                <h2>Teams</h2>
                <?php if ($teams->num_rows > 0): ?>
                    <ul>
                        <?php while ($teamRow = $teams->fetch_assoc()): ?>
                            <li><strong><?= htmlspecialchars($teamRow['name']) ?></strong></li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p>No teams found for this game.</p>
                <?php endif; ?>
            </section>

            <section id="events" class="event-details">
                <h2>Events</h2>
                <?php if ($events->num_rows > 0): ?>
                    <ul>
                        <?php while ($eventRow = $events->fetch_assoc()): ?>
                            <li>
                                <strong><?= htmlspecialchars($eventRow['name']) ?></strong> - <?= htmlspecialchars($eventRow['date']) ?><br>
                                <span><?= htmlspecialchars($eventRow['description']) ?></span>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p>No events found for this game.</p>
                <?php endif; ?>
            </section>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 DOLA DOLA Esports. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
