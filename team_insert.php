<?php
$koneksi = new mysqli("localhost:3306", "root", "", "esport");

if ($koneksi->connect_errno) {
    echo "Koneksi ke Database Failed: ", $koneksi->connect_error;
}

if (isset($_POST['submit'])) {
    $idgame = $_POST['idgame'];
    $team_name = $_POST['name'];
    
    // Insert tanpa foto dulu
    $sql = "INSERT INTO team (idgame, name) VALUES (?, ?)";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("is", $idgame, $team_name);
    $stmt->execute();
    
    // Dapatkan ID team yang baru dimasukkan
    $idteam = $stmt->insert_id;
    
    // Jika ada file yang diunggah, simpan ke folder img dengan nama idteam
    if (!empty($_FILES['photo']['name'])) {
        $lokasi = "img/";
        $namaFile = $lokasi . $idteam . ".jpg"; 
        move_uploaded_file($_FILES['photo']['tmp_name'], $namaFile);
    }

    $stmt->close();
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
