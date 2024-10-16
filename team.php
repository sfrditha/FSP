<?php
session_start();
$koneksi = new mysqli("localhost:3307", "root", "", "esport");

if ($koneksi->connect_errno) {
    echo "Koneksi ke Database Failed: " . $koneksi->connect_errno;
}

// Cek role
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

$isMember = isset($_SESSION['role']) && $_SESSION['role'] === 'member';

if($isMember){
    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teams</title>
    <link rel="stylesheet" href="tim.css">
</head>
<body>
    <h2>TEAMS</h2>
    <?php
    // Tentukan jumlah data per halaman
    $limit = 5;

    // Ambil halaman saat ini dari URL, jika tidak ada halaman maka halaman 1
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $start = ($page > 1) ? ($page * $limit) - $limit : 0;

    // Hitung total data
    $result_total = $koneksi->query("SELECT COUNT(*) AS total FROM team");
    $row_total = $result_total->fetch_assoc();
    $total = $row_total['total'];

    // Hitung jumlah halaman
    $total_pages = ceil($total / $limit);

    $sql = "select t.idteam, g.name as game, t.name
            from game g inner join team t on g.idgame=t.idgame
            LIMIT $start, $limit";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<table border='1'>";
    echo "<tr><th>ID Team</th><th>ID Game</th><th>Nama Team</th>";

    if ($isAdmin) {
        echo "<th colspan='3'>Aksi</th>"; // Tampilkan aksi hanya jika user adalah admin
    }

    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row['idteam']."</td>";
        echo "<td>".$row['game']."</td>";
        echo "<td>".$row['name']."</td>";

        // Tombol hapus dan edit hanya ditampilkan untuk admin
        if ($isAdmin) {
            echo "<td>
                    <form action='team_hapus.php' method='POST'>
                        <input type='hidden' name='idteam' value='".$row['idteam']."'>
                        <input type='submit' value='Hapus' class='btnHapus'>
                    </form>
                  </td>";
            echo "<td>
                    <a href='team_edit.php?idteam=".$row['idteam']."'>
                        <button>Edit</button>
                    </a>
                  </td>";
            echo "<td>
                  <form action='team_detail.php' method='POST'>
                        <input type='hidden' name='idteam' value='".$row['idteam']."'>
                        <input type='submit' value='Detail' class='btnDetail'>
                    </form>
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


    <?php
    if ($isAdmin) {
        echo "<br><a href='team_insert.php'><button>Tambah Team</button></a>";
    }
    ?>
    <br>
    <br><a href="home.php">Back To Home</a>
</body>
</html>
