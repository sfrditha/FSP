<?php
require_once 'database.php';  
require_once 'event_class.php';

$database = new Database();
$koneksi = $database->getConnection();
$event = new Event($koneksi);

if (isset($_GET['idevent'])) {
    $idevent = $_GET['idevent'];
    $result = $event->getEvent($idevent);
    $row = $result->fetch_assoc();
}

if (isset($_POST['submit'])) {
    $idevent = $_POST['idevent'];
    $name = $_POST['name'];
    $date = $_POST['date'];
    $description = $_POST['description'];

    $event->updateEvent($name, $date, $description, $idevent);

    header("Location: event.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>
    <link rel="stylesheet" href="eventAdEditt.css">
</head>
<body>
    <h2>EDIT EVENTS</h2>
    <form action="" method="POST">
        <input type="hidden" name="idevent" value="<?php echo $row['idevent']; ?>">
        <label>Nama Event:</label><br>
        <input type="text" name="name" value="<?php echo $row['name']; ?>"><br><br>
        <label>Tanggal:</label><br>
        <input type="date" name="date" value="<?php echo $row['date']; ?>"><br><br>
        <label>Deskripsi:</label><br>
        <input type="text" name="description" value="<?php echo $row['description']; ?>"><br><br>
        <input type="submit" name="submit" value="Update">
    </form>
</body>
</html>
