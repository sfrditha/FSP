<?php
session_start(); 


require_once 'database.php';
require_once 'achievement_class.php';


$db = new Database();
$koneksi = $db->getConnection();

$limit = 5;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page > 1) ? ($page * $limit) - $limit : 0;

$achievement = new Achievement($koneksi);

$total = $achievement->getTotalAchievements();

$total_pages = ceil($total / $limit);

$result = $achievement->getAchievements($limit, $start);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Achievement</title>
    <link rel="stylesheet" href="achievemen.css">
</head>
<body>
<h2>ACHIEVEMENTS</h2>

<?php
echo "<table border='1'>";
echo "<tr><th>IDAchievement</th><th>Nama Tim</th><th>Name</th><th>Date</th><th>Deskripsi</th>";

// Tampilkan aksi hanya jika user adalah admin
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    echo "<th colspan='2'>Aksi</th>"; 
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
    
    
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        // Tombol hapus
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

$db->closeConnection();
?>

<!-- buat paging -->
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
