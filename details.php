<?php
// Data tim menggunakan array
$teams = [
    1 => [
        'name' => 'Bigetron Red Aliens',
        'game' => 'PUBG Mobile',
        'members' => [
            ['name' => 'Luxxy', 'role' => 'Sniper'],
            ['name' => 'Zuxxy', 'role' => 'In-Game Leader'],
            ['name' => 'Ryzen', 'role' => 'Assaulter'],
            ['name' => 'Microboy', 'role' => 'Support'],
        ],
        'achievements' => [
            'PMCO Global Championship 2019 - Champion',
            'PMPL SEA 2020 - Champion',
        ],
        'events' => [
            ['name' => 'PUBG Global Invitational', 'date' => '2025-02-10'],
            ['name' => 'PMPL SEA Championship', 'date' => '2025-03-05'],
        ],
    ],
    2 => [
        'name' => 'Bigetron Alpha',
        'game' => 'Mobile Legends',
        'members' => [
            ['name' => 'Maxx', 'role' => 'Jungler'],
            ['name' => 'Kyy', 'role' => 'Support'],
            ['name' => 'Rippo', 'role' => 'EXP Laner'],
            ['name' => 'Matt', 'role' => 'Gold Laner'],
        ],
        'achievements' => [
            'MPL Indonesia Season 7 - Runner-up',
            'MPL Invitational 2021 - Champion',
        ],
        'events' => [
            ['name' => 'MPL Season 12', 'date' => '2025-01-20'],
            ['name' => 'MLBB Southeast Asia Cup', 'date' => '2025-04-10'],
        ],
    ],
];

// Mendapatkan ID tim dari URL
$teamId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Memeriksa apakah ID tim valid
if (!isset($teams[$teamId])) {
    die('Invalid team ID.');
}

// Data tim yang dipilih
$team = $teams[$teamId];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($team['name']) ?> - Details</title>
    <link rel="stylesheet" href="details.css">
</head>
<body>
    <header class="header">
        <h1><?= htmlspecialchars($team['name']) ?></h1>
        <p>Game: <?= htmlspecialchars($team['game']) ?></p>
    </header>

    <section class="team-members">
        <h2>Team Members</h2>
        <ul>
            <?php foreach ($team['members'] as $member): ?>
                <li><?= htmlspecialchars($member['name']) ?> - <?= htmlspecialchars($member['role']) ?></li>
            <?php endforeach; ?>
        </ul>
    </section>

    <section class="team-achievements">
        <h2>Achievements</h2>
        <ul>
            <?php foreach ($team['achievements'] as $achievement): ?>
                <li><?= htmlspecialchars($achievement) ?></li>
            <?php endforeach; ?>
        </ul>
    </section>

    <section class="team-events">
        <h2>Upcoming Events</h2>
        <ul>
            <?php foreach ($team['events'] as $event): ?>
                <li><?= htmlspecialchars($event['name']) ?> - <?= htmlspecialchars($event['date']) ?></li>
            <?php endforeach; ?>
        </ul>
    </section>

    <footer class="footer">
        <p>&copy; 2025 DOLA DOLA Esports. All rights reserved.</p>
    </footer>
</body>
</html>
