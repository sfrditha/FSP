<?php
require_once 'database.php';
require_once 'achievement_class.php';

$db = new Database();
$koneksi = $db->getConnection();
$achievement = new Achievement($koneksi);

if (isset($_POST['submit'])) {
    $teamid = $_POST['team'];
    $name = $_POST['name'];
    $date = $_POST['date'];
    $description = $_POST['description'];

    if ($achievement->insertAchievement($teamid, $name, $date, $description) > 0) {
        header("Location: achievement.php");
        exit();
    } else {
        echo "<p style='color: red;'>Gagal menambahkan achievement.</p>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>INSERT ACHIEVEMENT</title>
    <link rel="stylesheet" href="achievementAddEditt.css">
</head>
<body>
    <h2>INSERT ACHIEVEMENTS</h2><br><br>
    <form method="post" action="">
        <label>Nama Team</label>
        <select name="team">
            <?php
            $sql = "SELECT * FROM team";
            $stmt = $koneksi->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = $result->fetch_assoc()) {
                echo "<option value='".$row['idteam']."'>".$row['name']."</option>";
            }
            ?>
        </select><br><br>

        <label>Kejuaraan</label>
        <input type="text" name="name" required><br><br>

        <label>Tanggal</label>
        <input type="date" name="date" required><br><br>

        <label>Deskripsi</label>
        <textarea name="description" rows="4" cols="50" required></textarea><br><br>

        <input type="submit" name="submit" value="Insert Achievement">
    </form>
</body>
</html>
