<?php
require_once 'database.php';
require_once 'team_class.php';
require_once 'event_class.php';

// Membuat koneksi ke database
$dbConnection = new Database();
$db = $dbConnection->getConnection();

// Membuat instance class Team dan Event
$team = new Team($db);
$event = new Event($db);

// Mendapatkan semua data tim dan event dari database
$teams = $team->getTeamsFull();
$events = $event->getAllEvents();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esports Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <!-- Header Section -->
    <header class="header">
        <div class="container">
            <div class="logo">DOLA DOLA</div>
            <div class="menu-toggle">&#9776;</div>
            <nav class="nav">
                <ul>
                    <li><a href="#about">About</a></li>
                    <li><a href="#teams">Teams</a></li>
                    <li><a href="#matches">Matches</a></li>
                    <li><a href="#news">News</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- About Section -->
    <section id="about" class="about">
        <div class="about-image">
            <img src="img/11.jpg" alt="About Us Image" style="width: 100%; border-radius: 10px;">
        </div>
        <div class="about-content">
            <h2>About Us</h2>
            <p>We bring you the latest updates and thrilling events from the world of esports. Join us as we explore the passion, excitement, and community of gamers worldwide.</p>
            <a href="#join" class="join-now-btn">Join Now</a>
        </div>
    </section>

    <!-- Teams Section -->
    <section id="teams" class="teams">
        <div class="container">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <h2>Our Teams</h2>
            </div>
            <div class="team-grid">
                <?php while ($row = $teams->fetch_assoc()): ?>
                    <div class="team">
                        <img src="img/<?= htmlspecialchars($row['idteam']) ?>.jpg" alt="<?= htmlspecialchars($row['name']) ?>" onerror="this.src='img/default.jpg';">
                        <h3><?= htmlspecialchars($row['name']) ?></h3>
                        <p>Game: <?= htmlspecialchars($row['game']) ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Matches Section -->
    <section id="matches" class="matches">
        <div class="container">
            <h2>Schedule</h2>
            <ul>
                <?php while ($eventRow = $events->fetch_assoc()): ?>
                    <li>
                        <strong><?= htmlspecialchars($eventRow['name']) ?></strong> - 
                        <?= htmlspecialchars($eventRow['date']) ?> 
                        <br>
                        <span><?= htmlspecialchars($eventRow['description']) ?></span>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
    </section>

    <!-- News Section -->
    <section id="news" class="news">
        <div class="container">
            <h2>Latest News</h2>
            <p>Stay tuned for the latest news in esports.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 DOLA DOLA Esports. All rights reserved.</p>
        </div>
    </footer>

    <!-- JavaScript for Toggle Menu -->
    <script>
        document.querySelector('.menu-toggle').addEventListener('click', function() {
            this.classList.toggle('active');
            document.querySelector('.nav ul').classList.toggle('active');
        });
    </script>
</body>
</html>
