<?php
require_once 'database.php';  
require_once 'event_class.php';

$database = new Database();
$koneksi = $database->getConnection();
$event = new Event($koneksi);

if (isset($_POST['idevent'])) {
    $idevent = $_POST['idevent'];
    $event->deleteEvent($idevent);

    header("Location: event.php");
}
?>
