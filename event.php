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
    <title>Events</title>
    <link rel="stylesheet" href="even.css">
</head>
<body>
    <h2>EVENTS</h2>
    <?php

    // Tentukan jumlah data per halaman
    $limit = 5;

    // Ambil halaman saat ini dari URL, jika tidak ada halaman maka halaman 1
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $start = ($page > 1) ? ($page * $limit) - $limit : 0;

    // Hitung total data
    $result_total = $koneksi->query("SELECT COUNT(*) AS total FROM event");
    $row_total = $result_total->fetch_assoc();
    $total = $row_total['total'];

    // Hitung jumlah halaman
    $total_pages = ceil($total / $limit);

    $sql = "SELECT * FROM event
            LIMIT $start, $limit";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<table border='1'>";
    echo "<tr><th>ID Event</th><th>Nama Event</th><th>Tanggal</th><th>Deskripsi</th>";
    if ($isAdmin) {
        echo "<th colspan='2'>Aksi</th>"; 
    }
    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row['idevent']."</td>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['date']."</td>";
        echo "<td>".$row['description']."</td>";

        // Tombol hapus dan edit hanya ditampilkan untuk admin
        if ($isAdmin) {
            echo "<td>
                    <form action='event_hapus.php' method='POST'>
                        <input type='hidden' name='idevent' value='".$row['idevent']."'>
                        <input type='submit' value='Hapus' class='btnHapus'>
                    </form>
                  </td>";
            echo "<td>
                    <a href='event_edit.php?idevent=".$row['idevent']."'>
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
            echo "<br><a href='event_insert.php'><button>Tambah Event</button></a>";
        }
    ?>

    <br>
    <br><a href="home.php">Back To Home</a>
</body>
</html>
