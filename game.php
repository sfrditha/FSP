<?php
session_start();
require_once 'database.php';  
require_once 'game_class.php'; 

$database = new Database();
$koneksi = $database->getConnection();

$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

$limit = 5;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page > 1) ? ($page * $limit) - $limit : 0;

$game = new Game($koneksi);
$total = $game->getTotalGames();

$total_pages = ceil($total / $limit);

$games = $game->getGames($limit, $start);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Games</title>
    <link rel="stylesheet" href="gemm.css">
</head>
<body>
    <h2>GAMES</h2>
    <?php
    echo "<table border='1'>";
    echo "<tr><th>ID Game</th><th>Nama Game</th><th>Deskripsi</th>";

    if ($isAdmin) {
        echo "<th colspan='2'>Aksi</th>"; 
    }

    echo "</tr>";

    while ($row = $games->fetch_assoc()) {
        echo "<tr>";
        echo "<td data-label='ID Game'>".$row['idgame']."</td>";
        echo "<td data-label='Nama Game'>".$row['name']."</td>";
        echo "<td data-label='Deskripsi'>".$row['description']."</td>";

        if ($isAdmin) {
            echo "<td data-label='Hapus'>
                    <form action='game_hapus.php' method='POST'>
                        <input type='hidden' name='idgame' value='".$row['idgame']."'>
                        <input type='submit' value='Hapus' class='btnHapus'>
                    </form>
                  </td>";
            echo "<td data-label='Edit'>
                    <a href='game_edit.php?idgame=".$row['idgame']."'>
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
        echo "<br><a href='game_insert.php'><button>Tambah Game</button></a>";
    }
    ?>
    <br>
    <br><a href="home.php">Back To Home</a>
</body>
</html>
