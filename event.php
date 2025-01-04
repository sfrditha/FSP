<?php
session_start();
require_once 'database.php';  
require_once 'event_class.php'; 

$database = new Database();
$koneksi = $database->getConnection();

$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

$limit = 5;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page > 1) ? ($page * $limit) - $limit : 0;

$event = new Event($koneksi);
$total = $event->getTotalEvents();

$total_pages = ceil($total / $limit);

$events = $event->getEvents($limit, $start);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <link rel="stylesheet" href="even.css">
</head>
<body>
    <h2>EVENTS</h2>
    <?php
    echo "<table border='1'>";
    echo "<tr><th>ID Event</th><th>Nama Event</th><th>Tanggal</th><th>Deskripsi</th>";
    if ($isAdmin) {
        echo "<th colspan='2'>Aksi</th>"; 
    }
    echo "</tr>";

    while ($row = $events->fetch_assoc()) {
        echo "<tr>";
        echo "<td data-label='ID Event'>".$row['idevent']."</td>";
        echo "<td data-label='Nama Event'>".$row['name']."</td>";
        echo "<td data-label='Tanggal'>".$row['date']."</td>";
        echo "<td data-label='Deskripsi'>".$row['description']."</td>";

        if ($isAdmin) {
            echo "<td data-label='Hapus'>
                    <form action='event_hapus.php' method='POST'>
                        <input type='hidden' name='idevent' value='".$row['idevent']."'>
                        <input type='submit' value='Hapus' class='btnHapus'>
                    </form>
                  </td>";
            echo "<td data-label='Edit'>
                    <a href='event_edit.php?idevent=".$row['idevent']."'>
                        <button>Edit</button>
                    </a>
                  </td>";
        } 
        echo "</tr>";
    }
    echo "</table>";
    ?>

    <!-- PAGING -->
    <br>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>"><--Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <?php if ($i == $page): ?>
                <span class="active"><?php echo $i; ?></span>
            <?php else: ?>
                <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page + 1; ?>">Next--></a>
        <?php endif; ?>
    </div>
    <br>

    <?php
        if ($isAdmin) {
            echo "<br><a href='event_insert.php'><button>Tambah Event</button></a>";
        }
    ?>

    <br>
    <br><a href="home.php">Back To Home</a>
</body>
</html>
