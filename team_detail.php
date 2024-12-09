<?php
session_start();
require_once 'database.php';
require_once 'team_class.php';

// Inisialisasi koneksi
$db = new Database();
$koneksi = $db->getConnection();
$team = new Team($koneksi);

// Periksa apakah pengguna adalah admin
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// Menentukan ID team berdasarkan user/admin
if ($isAdmin) {
    $idteam = isset($_POST['idteam']) ? intval($_POST['idteam']) : 0;
} else {
    $idmember = isset($_SESSION['idmember']) ? intval($_SESSION['idmember']) : 0;
    $result = $team->getIdTeams($idmember);
    $idteam = $result->num_rows > 0 ? $result->fetch_assoc()['idteam'] : null;
}

// Menentukan opsi yang dipilih (default: team_member)
$selectedOption = isset($_POST['option']) ? $_POST['option'] : 'team_member';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Team</title>
    <link rel="stylesheet" href="tim_detail.css">
    <script>
        function submitForm() {
            document.getElementById("teamForm").submit();
        }
    </script>
</head>
<body>
    <h2>Team Detail</h2>

    <form id="teamForm" method="POST" action="team_detail.php">
        <!-- Input tersembunyi untuk idteam -->
        <input type="hidden" name="idteam" value="<?php echo htmlspecialchars($idteam); ?>">
        <label for="option">Pilih Kategori:</label>
        <select name="option" id="option" onchange="submitForm()">
            <option value="team_member" <?php if ($selectedOption === 'team_member') echo 'selected'; ?>>Team Members</option>
            <option value="achievement" <?php if ($selectedOption === 'achievement') echo 'selected'; ?>>Achievements</option>
            <option value="event" <?php if ($selectedOption === 'event') echo 'selected'; ?>>Events</option>
        </select>
    </form>
    <hr>

    <?php
    if ($idteam === null) {
        echo '<p>Anda belum memiliki tim, Lakukan registrasi terlebih dahulu.</p>';
        echo '<br><a href="register_team.php">Registrasi menjadi member team</a>';
    } else {
        switch ($selectedOption) {
            case 'team_member':
                // Menampilkan anggota tim
                $result = $team->displayMembers($idteam);
                echo "<h3>Team Members</h3>";
                echo "<table border='1'>";
                echo "<tr><th>First Name</th><th>Last Name</th><th>Role</th>";
                if ($isAdmin) echo "<th>Action</th>";
                echo "</tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['fname']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['lname']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                    if ($isAdmin) {
                        echo "<td><a href='edit_team_member.php?idteam=" . $idteam . "'>Hapus</a></td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
                break;

            case 'achievement':
                // Menampilkan pencapaian
                $result = $team->displayAchievements($idteam);
                echo "<h3>Achievements</h3>";
                echo "<table border='1'>";
                echo "<tr><th>Name</th><th>Date</th><th>Description</th>";
                if ($isAdmin) echo "<th colspan='2'>Aksi</th>";
                echo "</tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                    if ($isAdmin) {
                        echo "<td>
                                <form action='achievement_hapus.php' method='POST'>
                                    <input type='hidden' name='idachievement' value='" . $row['idachievement'] . "'>
                                    <input type='submit' value='Hapus'>
                                </form>
                              </td>";
                        echo "<td><a href='achievement_edit.php?idachievement=" . $row['idachievement'] . "'><button>Edit</button></a></td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
                break;

            case 'event':
                // Menampilkan event yang diikuti
                $result = $team->displayEvents($idteam);
                echo "<h3>Events</h3>";
                echo "<table border='1'>";
                echo "<tr><th>Name</th><th>Date</th><th>Description</th>";
                if ($isAdmin) echo "<th colspan='2'>Aksi</th>";
                echo "</tr>";

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['date']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                    if ($isAdmin) {
                        echo "<td>
                                <form action='event_hapus.php' method='POST'>
                                    <input type='hidden' name='idevent' value='" . $row['idevent'] . "'>
                                    <input type='submit' value='Hapus'>
                                </form>
                              </td>";
                        echo "<td><a href='event_edit.php?idevent=" . $row['idevent'] . "'><button>Edit</button></a></td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
                break;
        }
    }

    echo $isAdmin ? '<br><a href="team.php">Back to Teams</a>' : '<br><a href="home.php">Back to Home</a>';
    ?>
</body>
</html>
