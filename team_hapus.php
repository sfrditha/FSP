<?php
require_once 'database.php';
require_once 'team_class.php';

$db = new Database();
$koneksi = $db->getConnection();

$team = new Team($koneksi);

if (isset($_POST['idteam'])) {
    $idteam = $_POST['idteam'];
    $team->deleteTeam($idteam);
    $koneksi->close();
    header("Location: team.php");
}
?>
