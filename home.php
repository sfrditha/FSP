<?php
$koneksi = new mysqli("localhost:3306", "root", "", "esport");

if ($koneksi->connect_errno) {
    echo "Koneksi ke Database Failed", $koneksi->connect_errno;
    exit();
}

$koneksi->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>eSport Website</title>
    <link rel="stylesheet" type="text/css" href="homee.css">
    <script type="text/javascript">
        window.onload = function() {
            alert("Koneksi sukses.");
        };

        function toggleDropdown() {
            var dropdown = document.getElementById("dropdown");
            dropdown.style.display = dropdown.style.display === "none" ? "block" : "none";
        }
    </script>
</head>
<body>
    <h1>WELCOME!</h1>

    <div class="profile-container">
        <img src="user.png" alt="Profile" class="profile-icon" onclick="toggleDropdown()">
        <span class="dropdown-indicator" onclick="toggleDropdown()">▼</span> <!-- Dropdown indicator -->
        <div id="dropdown" style="display: none;">
            <ul>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="card-container">
        <div class="card">
            <a href="team.php">
                <div class="card-content">
                    <h2>TEAM</h2>
                    <p>Meet our team members</p>
                </div>
            </a>
        </div>
        <div class="card">
            <a href="game.php">
                <div class="card-content">
                    <h2>GAME</h2>
                    <p>Explore the games we play</p>
                </div>
            </a>
        </div>
        <div class="card">
            <a href="event.php">
                <div class="card-content">
                    <h2>EVENT</h2>
                    <p>Check out our events</p>
                </div>
            </a>
        </div>
        <div class="card">
            <a href="achievement.php">
                <div class="card-content">
                    <h2>ACHIEVEMENT</h2>
                    <p>See our team achievements</p>
                </div>
            </a>
        </div>
    </div>
</body>
</html>
