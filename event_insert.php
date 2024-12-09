<?php
require_once 'database.php';  
require_once 'event_class.php';

$database = new Database();
$koneksi = $database->getConnection();
$event = new Event($koneksi);

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $description = $_POST['description'];

    $event->insertEvent($name, $date, $description);

    header("Location: event.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Event</title>
    <link rel="stylesheet" href="eventAdEditt.css">
</head>
<body>
    <h2>TAMBAH EVENT</h2>
    <form action="" method="POST">
        <label>Nama Event:</label><br>
        <input type="text" name="name"><br><br>
        <label>Tanggal:</label><br>
        <input type="date" name="date"><br><br>
        <label>Deskripsi:</label><br>
        <input type="text" name="description"><br><br>
        <input type="submit" name="submit" value="Simpan">
    </form>
</body>
</html>
