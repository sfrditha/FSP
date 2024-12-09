<?php
require_once 'database.php';
require_once 'team_class.php';

$db = new Database();
$koneksi = $db->getConnection();
$team = new Team($koneksi);

if (isset($_POST['submit'])) {
    $idgame = $_POST['idgame'];
    $team_name = $_POST['name'];
    $idteam = $team->insertTeam($idgame, $team_name);

    // Upload foto jika ada
    if (!empty($_FILES['photo']['name'])) {
        $lokasi = "img/";
        $namaFile = $lokasi . $idteam . ".jpg"; 
        move_uploaded_file($_FILES['photo']['tmp_name'], $namaFile);
    }

    $koneksi->close();
    header("Location: team.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Team</title>
    <link rel="stylesheet" href="timAdEditt.css">
</head>
<body>
    <h2>TAMBAH TEAM</h2>

    <form action="" method="POST" enctype="multipart/form-data">
        <label for="idgame">Game:</label><br>
        <select name="idgame">
            <?php
                $sql = "SELECT idgame, name FROM game";
                $result = $koneksi->query($sql);

                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['idgame'] . "'>" . $row['name'] . "</option>";
                }
            ?>
        </select><br><br>

        <label for="name">Team Name:</label><br>
        <input type="text" name="name"><br><br>

        <label for="photo">Foto Team:</label><br>
        <input type="file" name="photo" accept="image/*"><br><br>

        <input type="submit" name="submit" value="Simpan">
    </form>
</body>
</html>
