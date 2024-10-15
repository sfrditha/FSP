<?php
session_start();
$koneksi = new mysqli("localhost:3306", "root", "", "esport");

if ($koneksi->connect_errno) {
    echo "Koneksi ke Database Failed: " . $koneksi->connect_errno;
}

$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

$selectedOption = isset($_POST['option']) ? $_POST['option'] : 'team_member'; 
$idteam = isset($_POST['idteam']) ? intval($_POST['idteam']) : 0; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Team</title>
    <link rel="stylesheet" href="teamm.css">
    <script>
        function submitForm() {
            document.getElementById("teamForm").submit();
        }
    </script>
</head>
<body>
    <h2>Edit Team</h2>

    <form id="teamForm" method="POST" action="team_detail.php">
        <!-- Input tersembunyi untuk idteam -->
        <input type="hidden" name="idteam" value="<?php echo $idteam; ?>">
        <label for="option">Select View:</label>
        <select name="option" id="option" onchange="submitForm()">
            <option value="team_member" <?php if ($selectedOption === 'team_member') echo 'selected'; ?>>Team Members</option>
            <option value="achievement" <?php if ($selectedOption === 'achievement') echo 'selected'; ?>>Achievements</option>
            <option value="event" <?php if ($selectedOption === 'event') echo 'selected'; ?>>Events</option>
        </select>
    </form>
    <hr>

    <?php
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
                echo "<td><a href='edit_team_member.php?idteam=".$row['idteam']."'>Edit</a></td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } elseif ($selectedOption === 'achievement') {
        // Display Achievements
        $sql = "SELECT name, date, description FROM achievement WHERE idteam = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("i", $idteam);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<h3>Achievements</h3>";
        echo "<table border='1'>";
        echo "<tr><th>Name</th><th>Date</th><th>Description</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['date'] . "</td>";
            echo "<td>" . $row['description'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } elseif ($selectedOption === 'event') {
        // Display Events
        $sql = "SELECT e.name, e.date, e.description 
                FROM event_teams et
                INNER JOIN event e ON et.idevent = e.idevent
                WHERE et.idteam = ?";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("i", $idteam);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<h3>Events</h3>";
        echo "<table border='1'>";
        echo "<tr><th>Name</th><th>Date</th><th>Description</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['date'] . "</td>";
            echo "<td>" . $row['description'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    $koneksi->close();
    ?>
    <br>
    <a href="team.php">Back to Teams</a>
</body>
</html>
