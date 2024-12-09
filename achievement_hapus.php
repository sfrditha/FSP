<?php
require_once 'database.php';
require_once 'achievement_class.php';

$db = new Database();
$koneksi = $db->getConnection();
$achievement = new Achievement($koneksi);

if (isset($_POST['idachievement'])) {
    $idachievement = $_POST['idachievement'];

    if ($achievement->deleteAchievement($idachievement) > 0) {
        echo "Data berhasil dihapus.";
    } else {
        echo "Error dalam menghapus data.";
    }
}

header("Location: achievement.php");
?>
