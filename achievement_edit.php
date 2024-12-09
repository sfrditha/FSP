<?php
require_once 'database.php';
require_once 'achievement_class.php';

$db = new Database();
$koneksi = $db->getConnection();
$achievement = new Achievement($koneksi);

// Mendapatkan idachievement dari URL
if (isset($_GET['idachievement'])) {
    $idachievement = $_GET['idachievement'];
    $result = $achievement->getAchievement($idachievement);
    $data = $result->fetch_assoc();

    if ($data) {
        $idteam = $data['idteam'];
        $name = $data['name'];
        $date = $data['date'];
        $description = $data['description'];
    } else {
        echo "Achievement tidak ditemukan.";
        exit;
    }
}

// Jika form disubmit untuk mengupdate data
if (isset($_POST['submit'])) {
    $idachievement = $_POST['idachievement'];
    $idteam = $_POST['idteam'];
    $name = $_POST['name'];
    $date = $_POST['date'];
    $description = $_POST['description'];

    if ($achievement->updateAchievement($idteam, $name, $date, $description, $idachievement) > 0) {
        echo "Data berhasil diupdate.";
    } else {
        echo "Error dalam mengupdate data.";
    }

    header("Location: achievement.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>EDIT ACHIEVEMENTS</title>
    <link rel="stylesheet" href="achievementAddEditt.css">
</head>
<body>
    <h2>Edit Achievement</h2>
    <form action="" method="POST">
        <input type="hidden" name="idachievement" value="<?php echo $idachievement; ?>">
        <label>ID Team:</label><br>
        <input type="text" name="idteam" value="<?php echo $idteam; ?>" readonly><br><br>
        <label>Name:</label><br>
        <input type="text" name="name" value="<?php echo $name; ?>"><br><br>
        <label>Date:</label><br>
        <input type="date" name="date" value="<?php echo $date; ?>"><br><br>
        <label>Description:</label><br>
        <textarea name="description"><?php echo $description; ?></textarea><br><br>
        <input type="submit" name="submit" value="Update">
    </form>
</body>
</html>
