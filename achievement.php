<?php
session_start(); // Pastikan session dimulai

$koneksi = new mysqli("localhost:3307", "root", "", "esport");

if ($koneksi->connect_errno) {
    echo "Koneksi ke Database Failed: " . $koneksi->connect_errno;
}

// Tentukan jumlah data per halaman
$limit = 5;

// Ambil halaman saat ini dari URL, jika tidak ada halaman maka halaman 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page > 1) ? ($page * $limit) - $limit : 0;

// Hitung total data
$result_total = $koneksi->query("SELECT COUNT(*) AS total FROM achievement");
$row_total = $result_total->fetch_assoc();
$total = $row_total['total'];

// Hitung jumlah halaman
$total_pages = ceil($total / $limit);

$sql = "SELECT achievement.idachievement, team.name AS team_name, achievement.name, achievement.date, achievement.description
        FROM achievement
        JOIN team ON achievement.idteam = team.idteam
        LIMIT $start, $limit"; // Tambahkan LIMIT untuk pagination
$stmt  = $koneksi->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Achievement</title>
    <link rel="stylesheet" href="achievementt.css">
</head>
<body>
<h2>ACHIEVEMENTS</h2>

<?php
echo "<table border='1'>";
echo "<tr><th>IDAchievement</th><th>Nama Tim</th><th>Name</th><th>Date</th><th>Deskripsi</th>";

if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    echo "<th colspan='2'>Aksi</th>"; // Tampilkan aksi hanya jika user adalah admin
}

echo "</tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>".$row['idachievement']."</td>";
    echo "<td>".$row['team_name']."</td>";
    echo "<td>".$row['name']."</td>";
    $rilis = date("d F Y", strtotime($row['date']));
    echo "<td>".$rilis."</td>";
    echo "<td>".$row['description']."</td>";
    
    // Tombol hapus
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        echo "<td>
                <form action='achievement_hapus.php' method='POST'>
                    <input type='hidden' name='idachievement' value='".$row['idachievement']."'>
                    <input type='submit' value='Hapus' class='btnHapus'>
                </form>
              </td>";
        
        // Tombol edit
        echo "<td>
                <a href='achievement_edit.php?idachievement=".$row['idachievement']."'>
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
<div>
    <?php if ($page > 1): ?>
        <a href="?page=<?php echo $page - 1; ?>"><--Previous</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
        <a href="?page=<?php echo $page + 1; ?>">Next--></a>
    <?php endif; ?>
</div>

<br>
<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <a href="achievement_insert.php">
        <button>Tambah Achievement</button>
    </a>
<?php endif; ?>
<br><br>
<a href="home.php">Back To Home</a>

<script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
<script type="text/javascript"></script>
</body>
</html>
