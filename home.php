<?php
session_start();
require_once 'database.php';  

$database = new Database();
$koneksi = $database->getConnection();

if ($koneksi->connect_errno) {
    echo "Koneksi ke Database Failed", $koneksi->connect_errno;
    exit();
}

// Check user role
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$koneksi->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>eSport Website</title>
    <link rel="stylesheet" type="text/css" href="homm.css">
    <script type="text/javascript">
        function toggleDropdown() {
            var dropdown = document.getElementById("dropdown");
            dropdown.style.display = dropdown.style.display === "none" ? "block" : "none";
        }
    </script>
</head>
<body>
    <h1>WELCOME!</h1>

    <div class="profile-container">
        <img src="img/user.png" alt="Profile" class="profile-icon" onclick="toggleDropdown()">
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
            <a href="<?php echo ($role === 'admin') ? 'team.php' : 'team_detail.php'; ?>">
                <div class="card-content">
                    <h2>TEAM</h2>
                    <p>Meet our team members</p>
                </div>
            </a>
        </div>

        <!-- MEMBER -->
        <?php if ($role === 'member'): ?>
        <div class="card">
            <a href="proposal.php">
                <div class="card-content">
                    <h2>JOIN-PROPOSAL</h2>
                </div>
            </a>
        </div>
        <?php endif; ?>

        <!-- ADMIM -->
        <?php if ($role === 'admin'): ?>
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
        <div class="card">
            <a href="proposal.php">
                <div class="card-content">
                    <h2>JOIN-PROPOSAL</h2>
                </div>
            </a>
        </div>
        <div class="card">
            <a href="joinproposal.php">
                <div class="card-content">
                    <h2>JOIN-PROPOSAL(Admin)</h2>
                </div>
            </a>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
