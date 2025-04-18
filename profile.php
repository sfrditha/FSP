<?php
session_start();

$database = new Database();
$koneksi = $database->getConnection();

if ($koneksi->connect_errno) {
    echo "Koneksi ke Database Failed", $koneksi->connect_errno;
    exit();
}

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Get user information from database
$username = $_SESSION['username'];
$query = "SELECT idmember, fname, lname, username, profile FROM member WHERE username = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Get team and position information
$idmember = $user['idmember'];
$query_team = "
    SELECT t.name AS team_name, tm.description AS position
    FROM team_members tm
    JOIN team t ON tm.idteam = t.idteam
    WHERE tm.idmember = ?
";
$stmt_team = $koneksi->prepare($query_team);
$stmt_team->bind_param("i", $idmember);
$stmt_team->execute();
$result_team = $stmt_team->get_result();

$teams = [];
while ($row = $result_team->fetch_assoc()) {
    $teams[] = $row;
}

$stmt->close();
$stmt_team->close();
$koneksi->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="profil.css">
</head>
<body>
    <!-- User Profile Title (Outside Card) -->
    <h1>USER PROFILE</h1>

    <div class="profile-container">
        <div class="profile-card">
            <!-- User Full Name (Bold) -->
            <h2><?php echo "<strong>" . $user['fname'] . " " . $user['lname'] . "</strong>"; ?></h2>
            <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
            <p><strong>Profile:</strong> <?php echo ucfirst($user['profile']); ?></p>
            <br>
            <!-- Team Information -->
            <h3>Team Information</h3>
            <?php if (!empty($teams)): ?>
                <ul>
                    <?php foreach ($teams as $team): ?>
                        <li>
                            <strong>Team:</strong> <?php echo $team['team_name']; ?> <br>
                            <strong>Position:</strong> <?php echo $team['position']; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>You are not a member of any team.</p>
            <?php endif; ?>
        </div>

        <!-- Back to Home Button -->
        <div class="profile-footer">
            <a href="home.php">Back to Home</a>
        </div>
    </div>
</body>
</html>


