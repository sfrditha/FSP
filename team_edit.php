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
    $photo = $_FILES['photo'];

    if ($photo['error'] === UPLOAD_ERR_OK) {
        $targetDir = 'img/';
        $targetFile = $targetDir . $idteam . '.jpg';
        move_uploaded_file($photo['tmp_name'], $targetFile);
    }

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
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const output = document.getElementById('team-photo-preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</head>
<body>
    <h2>EDIT TEAM</h2>

    <form action="" method="POST" enctype="multipart/form-data">
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

        <label for="photo">Team Photo:</label><br>
        <input type="file" name="photo" onchange="previewImage(event)"><br><br>
        <img id="team-photo-preview" src="img/<?php echo htmlspecialchars($row['idteam']); ?>.jpg?<?php echo 
        file_exists('img/' . htmlspecialchars($row['idteam']) . '.jpg') ? 
        filemtime('img/' . htmlspecialchars($row['idteam']) . '.jpg') : time(); ?>" 
        alt="Team Photo" style="max-width: 200px;"><br><br>

        <input type="submit" name="submit" value="Update">
    </form>
</body>
</html>
