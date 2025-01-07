<?php
// Data tim dan event statis
$game = [
    'Valorant' => ['Valorant Vipers', 'Valorant Assassins'],
    'Dota 2' => ['Dota Destroyers', 'Radiant Warriors'],
    'Counter-Strike: Global Offensive' => ['CSGO Sharpshooters', 'Global Tacticians'],
    'Rocket League' => ['Rocket Racers', 'Boost Blasters']
];

$eventsData = [
    'Valorant' => [
        ['name' => 'Valorant Invitational', 'date' => '2024-05-10', 'description' => 'A showdown of top Valorant teams.'],
        ['name' => 'Global Valorant Cup', 'date' => '2024-06-15', 'description' => 'Worldwide Valorant championship.']
    ],
    'Dota 2' => [
        ['name' => 'Dota Major League', 'date' => '2024-07-20', 'description' => 'Major Dota 2 teams competing.'],
        ['name' => 'Radiant Showdown', 'date' => '2024-08-05', 'description' => 'Clash of legends in Dota 2.']
    ],
    'Counter-Strike: Global Offensive' => [
        ['name' => 'CSGO World Series', 'date' => '2024-09-12', 'description' => 'The ultimate CSGO tournament.'],
        ['name' => 'Global Offensive Open', 'date' => '2024-10-01', 'description' => 'An open tournament for rising stars.']
    ],
    'Rocket League' => [
        ['name' => 'Rocket League Grand Prix', 'date' => '2024-11-18', 'description' => 'Intense rocket-powered action.'],
        ['name' => 'Aerial Supremacy Cup', 'date' => '2024-12-03', 'description' => 'High-flying Rocket League excitement.']
    ]
];

// Mendapatkan parameter game dari URL
$game = isset($_GET['game']) ? $_GET['game'] : '';

// Memastikan data game yang diminta tersedia
$teams = isset($teamsData[$game]) ? $teamsData[$game] : [];
$events = isset($eventsData[$game]) ? $eventsData[$game] : [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($game) ?> Details</title>
    <link rel="stylesheet" href="dash_details.css">
</head>

<body>
    <!-- Main Content -->
    <main class="details">
        <div class="container">
            <h1><?= htmlspecialchars($game) ?> - Details</h1>

            <!-- Teams Section -->
            <section id="teams" class="team-details">
                <h2>Teams</h2>
                <?php if (!empty($teams)): ?>
                    <ul>
                        <?php foreach ($teams as $team): ?>
                            <li><strong><?= htmlspecialchars($team) ?></strong></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No teams found for this game.</p>
                <?php endif; ?>
            </section>

            <!-- Events Section -->
            <section id="events" class="event-details">
                <h2>Events</h2>
                <?php if (!empty($events)): ?>
                    <ul>
                        <?php foreach ($events as $event): ?>
                            <li>
                                <strong><?= htmlspecialchars($event['name']) ?></strong> - <?= htmlspecialchars($event['date']) ?><br>
                                <span><?= htmlspecialchars($event['description']) ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No events found for this game.</p>
                <?php endif; ?>
            </section>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 DOLA DOLA Esports. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>
