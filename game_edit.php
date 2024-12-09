<?php
require_once 'database.php';  
require_once 'game_class.php'; 

$database = new Database();
$koneksi = $database->getConnection();
$game = new Game($koneksi);

if (isset($_GET['idgame'])) {
    $idgame = $_GET['idgame'];
    $result = $game->getGame($idgame);
    $row = $result->fetch_assoc();
}

if (isset($_POST['submit'])) {
    $idgame = $_POST['idgame'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    $game->updateGame($idgame, $name, $description);

    header("Location: game.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Game</title>
    <link rel="stylesheet" href="gameAdEditt.css">
</head>
<body>
    <h2>EDIT GAME</h2>
    <form action="" method="POST">
        <input type="hidden" name="idgame" value="<?php echo $row['idgame']; ?>">
        <label>Nama Game:</label><br>
        <input type="text" name="name" value="<?php echo $row['name']; ?>"><br><br>
        <label>Deskripsi:</label><br>
        <input type="text" name="description" value="<?php echo $row['description']; ?>"><br><br>
        <input type="submit" name="submit" value="Update">
    </form>
</body>
</html>
