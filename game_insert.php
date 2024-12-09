<?php
require_once 'database.php';  
require_once 'game_class.php'; 

$database = new Database();
$koneksi = $database->getConnection();
$game = new Game($koneksi);

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];

    $game->insertGame($name, $description);

    header("Location: game.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Game</title>
    <link rel="stylesheet" href="gameAdEditt.css">
</head>
<body>
    <h2>TAMBAH GAME</h2>
    <form action="" method="POST">
        <label>Nama Game:</label><br>
        <input type="text" name="name"><br><br>
        <label>Deskripsi:</label><br>
        <input type="text" name="description"><br><br>
        <input type="submit" name="submit" value="Simpan">
    </form>
</body>
</html>
