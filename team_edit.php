<?php
require_once 'database.php';
require_once 'team_class.php';

$db = new Database();
$koneksi = $db->getConnection();

$team = new Team($koneksi);

if (isset($_GET['idteam'])) {
    $idteam = $_GET['idteam'];
    $result = $team->getTeam($idteam);
    $row = $result->fetch_assoc();
}

if (isset($_POST['submit'])) {
    $idteam = $_POST['idteam'];
    $idgame = $_POST['idgame'];
    $team_name = $_POST['name'];

    $team->updateTeam($idgame, $team_name, $idteam);
    $koneksi->close();
    header("Location: team.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Team</title>
    <link rel="stylesheet" href="timAdEditt.css">
</head>
<body>
    <h2>EDIT TEAM</h2>

    <form action="" method="POST">
        <input type="hidden" name="idteam" value="<?php echo $row['idteam']; ?>">

        <label for="idgame">Game:</label><br>
        <select name="idgame">
            <?php
                $sql = "SELECT idgame, name FROM game";
                $result = $koneksi->query($sql);

                while ($game_row = $result->fetch_assoc()) {
                    $selected = $game_row['idgame'] == $row['idgame'] ? "selected" : "";
                    echo "<option value='" . $game_row['idgame'] . "' $selected>" . $game_row['name'] . "</option>";
                }
            ?>
        </select><br><br>

        <label for="name">Team Name:</label><br>
        <input type="text" name="name" value="<?php echo $row['name']; ?>"><br><br>

        <input type="submit" name="submit" value="Update">
    </form>
</body>
</html>
