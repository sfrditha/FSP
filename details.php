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

$teamId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if (empty($teamId)) {
    die('Team parameter is missing.');
}

$getteamData = $team->getTeam($teamId);
$teamData = $getteamData->fetch_assoc();
if (!$teamData) {
    die('Team not found.');
}

$getGame = $game->getGameByTeam($teamId);
$games = $getGame->fetch_assoc();

$members = $team->displayMembers($teamId);
// $members = $getmembers->fetch_assoc();
$achievements = $team->displayAchievements($teamId);
// $achievements = $getachievements->fetch_assoc();
$events = $team->displayEvents($teamId);
// $events = $getevents->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($teamData['name']) ?> - Details</title>
    <link rel="stylesheet" href="details.css">
</head>
<body>
    <header class="header">
        <h1><?= htmlspecialchars($teamData['name']) ?></h1>
        <p>Game: <?= htmlspecialchars($games['name']) ?></p>
    </header>

    <!-- Team Members Section -->
    <section class="team-members">
        <h2>Team Members</h2>
        <ul>
            <?php if ($members->num_rows > 0): ?>
                <?php while ($member = $members->fetch_assoc()): ?>
                    <li><?= htmlspecialchars($member['fname']) ?> - <?= htmlspecialchars($member['description']) ?></li>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No members found for this team.</p>
            <?php endif; ?>
        </ul>
    </section>

    <!-- Achievements Section -->
    <section class="team-achievements">
        <h2>Achievements</h2>
        <ul>
            <?php if ($achievements->num_rows > 0): ?>
                <?php while ($achievement = $achievements->fetch_assoc()): ?>
                    <li><?= htmlspecialchars($achievement['name']) ?></li>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No achievements found for this team.</p>
            <?php endif; ?>
        </ul>
    </section>

    <!-- Upcoming Events Section -->
    <section class="team-events">
        <h2>Upcoming Events</h2>
        <ul>
            <?php if ($events->num_rows > 0): ?>
                <?php while ($eventRow = $events->fetch_assoc()): ?>
                    <li><?= htmlspecialchars($eventRow['name']) ?> - <?= htmlspecialchars($eventRow['date']) ?></li>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No events found for this team.</p>
            <?php endif; ?>
        </ul>
    </section>

    <footer class="footer">
        <p>&copy; 2025 DOLA DOLA Esports. All rights reserved.</p>
    </footer>
</body>
</html>
