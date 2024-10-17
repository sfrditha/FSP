<?php
session_start();
$koneksi = new mysqli("localhost:3307", "root", "", "esport");

if ($koneksi->connect_errno) {
    echo "Koneksi ke Database Failed: " . $koneksi->connect_errno;
}

$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

$selectedOption = isset($_POST['option']) ? $_POST['option'] : 'team_member'; 
if ($isAdmin) {
    $idteam = isset($_POST['idteam']) ? intval($_POST['idteam']) : 0; 
} else {
    $idmember = isset($_SESSION['idmember']) ? $_SESSION['idmember'] : 0;
    $sql = "SELECT idteam FROM team_members WHERE idmember = ?;";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("i", $idmember);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc(); // Fetch the row containing idteam
        $idteam = isset($row['idteam']) ? $row['idteam'] : null;
    } else {
        // Handle the case where no team is found for this member
        $idteam = null; // Set to null if no team is found
    }
    $stmt->close();
}
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
        <input type="hidden" name="idteam" value="<?php echo $idteam; ?>">
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
        // Tampilan jika pengguna belum memiliki tim
        echo '<p>Anda belum memiliki tim, Lakukan registrasi terlebih dahulu.</p>';
        echo '<br>';
        echo '<a href="register_team.php">Registrasi menjadi member team</a>';
    } else {
        if ($selectedOption === 'team_member') {
            // Display Team Members
            $sql = "SELECT tm.idteam, m.fname, m.lname, tm.description
                    FROM team_members tm
                    INNER JOIN member m ON tm.idmember = m.idmember
                    WHERE tm.idteam = ?";
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("i", $idteam);
            $stmt->execute();
            $result = $stmt->get_result();

            echo "<h3>Team Members</h3>";
            echo "<table border='1'>";
            echo "<tr><th>First Name</th><th>Last Name</th><th>Role</th>";

            if ($isAdmin) {
                echo "<th>Action</th>"; // Tampilkan aksi jika user adalah admin
            }
            echo "</tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['fname'] . "</td>";
                echo "<td>" . $row['lname'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                if ($isAdmin) {
                    echo "<td><a href='edit_team_member.php?idteam=".$row['idteam']."'>Hapus</a></td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } elseif ($selectedOption === 'achievement') {
            // Display Achievements
            $sql = "SELECT * FROM achievement WHERE idteam = ?";
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("i", $idteam);
            $stmt->execute();
            $result = $stmt->get_result();

            echo "<h3>Achievements</h3>";
            echo "<table border='1'>";
            echo "<tr><th>Name</th><th>Date</th><th>Description</th>";

            if ($isAdmin) {
                echo "<th colspan='2'>Aksi</th>"; // Tampilkan aksi hanya jika user adalah admin
            }

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                $idachievement = $row['idachievement'];
                if ($isAdmin) {
                    echo "<td>
                            <form action='achievement_hapus.php' method='POST'>
                                <input type='hidden' name='idachievement' value='".$row['idachievement']."'>
                                <input type='submit' value='Hapus' class='btnHapus'>
                            </form>
                          </td>";
                    
                    // Tombol edit
                    echo "<td>
                            <a href='achievement_edit.php?idachievement=".$row['idachievement']."'>
                                <button>Edit</button>
                            </a>
                          </td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        } elseif ($selectedOption === 'event') {
            // Display Events
            $sql = "SELECT * 
                    FROM event_teams et
                    INNER JOIN event e ON et.idevent = e.idevent
                    WHERE et.idteam = ?";
            $stmt = $koneksi->prepare($sql);
            $stmt->bind_param("i", $idteam);
            $stmt->execute();
            $result = $stmt->get_result();

            echo "<h3>Events</h3>";
            echo "<table border='1'>";
            echo "<tr><th>Name</th><th>Date</th><th>Description</th>";

            if ($isAdmin) {
                echo "<th colspan='2'>Aksi</th>"; // Tampilkan aksi hanya jika user adalah admin
            }
            echo "</tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                $idevent = $row['idevent'];

                if ($isAdmin) {
                    echo "<td>
                            <form action='event_hapus.php' method='POST'>
                                <input type='hidden' name='idevent' value='".$row['idevent']."'>
                                <input type='submit' value='Hapus' class='btnHapus'>
                            </form>
                          </td>";
                    echo "<td>
                            <a href='event_edit.php?idevent=".$row['idevent']."'>
                                <button>Edit</button>
                            </a>
                          </td>";
                } 
                echo "</tr>";
            }
            echo "</table>";
        }
    }

    if ($isAdmin) {
        echo '<br>';
        echo '<a href="team.php">Back to Teams</a>';
    } else {
        echo '<br>';
        echo '<a href="home.php">Back to Home</a>';
    }

    $koneksi->close();
    ?>
    <br>
</body>
</html>
