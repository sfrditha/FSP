<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esports Home</title>
    <link rel="stylesheet" href="front.css">
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
                </ul>
            </nav>
        </div>
    </header>

    <!-- About Section -->
    <section class="about">
        <div class="about-image">
            <img src="img/11.jpg" alt="About Us Image" style="width: 100%; border-radius: 10px;">
        </div>
        <div class="about-content">
            <h2>About Us</h2>
            <p>We bring you the latest updates and thrilling events from the world of esports. Join us as we explore the passion, excitement, and community of gamers worldwide.</p>
            <!-- Join Now Button -->
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
                <div class="team">
                    <img src="img/1.jpg" alt="Valorant">
                    <h3>Team Valorant</h3>
                </div>
                <div class="team">
                    <img src="img/2.jpg" alt="Dota2">
                    <h3>Team Dota 2</h3>
                </div>
                <div class="team">
                    <img src="img/4.jpg" alt="RocketLeauge">
                    <h3>Team Rocket Leauge</h3>
                </div>
                <div class="team">
                    <img src="img/5.jpg" alt="Pubg">
                    <h3>Team Pubg</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- Matches Section -->
    <section id="matches" class="matches">
        <div class="container">
            <h2>Schedule</h2>
            <ul>
                <li>Team Alpha vs Team Bravo - Jan 15, 2024</li>
                <li>Team Delta vs Team Omega - Jan 18, 2024</li>
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
