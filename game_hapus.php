<?php
require_once 'database.php';  
require_once 'game_class.php'; 

$database = new Database();
$koneksi = $database->getConnection();
$game = new Game($koneksi);

if (isset($_POST['idgame'])) {
    $idgame = $_POST['idgame'];

    $game->deleteGame($idgame);

    header("Location: game.php");
}
?>
