<?php
session_start();
$koneksi = new mysqli("localhost:3306", "root", "", "esport");

if ($koneksi->connect_errno) {
    echo "Koneksi ke Database Failed: " . $koneksi->connect_errno;
}

// Cek role
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Games</title>
    <link rel="stylesheet" href="gem.css">
</head>
<body>
    <h2>GAMES</h2>
    <?php

    // Tentukan jumlah data per halaman
    $limit = 5;

    // Ambil halaman saat ini dari URL, jika tidak ada halaman maka halaman 1
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $start = ($page > 1) ? ($page * $limit) - $limit : 0;

    // Hitung total data
    $result_total = $koneksi->query("SELECT COUNT(*) AS total FROM game");
    $row_total = $result_total->fetch_assoc();
    $total = $row_total['total'];

    // Hitung jumlah halaman
    $total_pages = ceil($total / $limit);

    $sql = "SELECT * FROM game
            LIMIT $start, $limit";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<table border='1'>";
    echo "<tr><th>ID Game</th><th>Nama Game</th><th>Deskripsi</th>";

    if ($isAdmin) {
        echo "<th colspan='2'>Aksi</th>"; // Tampilkan aksi hanya jika user adalah admin
    }

    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row['idgame']."</td>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['description']."</td>";

        // Tombol hapus dan edit hanya ditampilkan untuk admin
        if ($isAdmin) {
            echo "<td>
                    <form action='game_hapus.php' method='POST'>
                        <input type='hidden' name='idgame' value='".$row['idgame']."'>
                        <input type='submit' value='Hapus' class='btnHapus'>
                    </form>
                  </td>";
            echo "<td>
                    <a href='game_edit.php?idgame=".$row['idgame']."'>
                        <button>Edit</button>
                    </a>
                  </td>";
        } 
        echo "</tr>";
    }
    echo "</table>";

    

    $koneksi->close();
    ?>
    <!-- Navigasi Halaman -->
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
