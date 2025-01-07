<?php
session_start();
require_once 'database.php';
require_once 'achievement_class.php';

$db = new Database();
$koneksi = $db->getConnection();
$achievement = new Achievement($koneksi);

$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page > 1) ? ($page * $limit) - $limit : 0;

$total = $achievement->getTotalAchievements();
$total_pages = ceil($total / $limit);

$result = $achievement->getAchievements($limit, $start);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achievement</title>
    <link rel="stylesheet" href="aciv.css">
    <style>
        /* Tambahkan CSS di sini jika diperlukan */
    </style>
</head>
<body>
    <h2>ACHIEVEMENTS</h2>

    <table>
        <tr>
            <th>IDAchievement</th>
            <th>Nama Tim</th>
            <th>Name</th>
            <th>Date</th>
            <th>Deskripsi</th>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <th colspan="2">Aksi</th>
            <?php endif; ?>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td data-label="IDAchievement"><?php echo $row['idachievement']; ?></td>
                <td data-label="Nama Tim"><?php echo $row['team_name']; ?></td>
                <td data-label="Name"><?php echo $row['name']; ?></td>
                <td data-label="Date"><?php echo date("d F Y", strtotime($row['date'])); ?></td>
                <td data-label="Deskripsi"><?php echo $row['description']; ?></td>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                    <td data-label="Aksi Hapus">
                        <form action="achievement_hapus.php" method="POST">
                            <input type="hidden" name="idachievement" value="<?php echo $row['idachievement']; ?>">
                            <input type="submit" value="Hapus" class="btnHapus">
                        </form>
                    </td>
                    <td data-label="Aksi Edit">
                        <a href="achievement_edit.php?idachievement=<?php echo $row['idachievement']; ?>">
                            <button>Edit</button>
                        </a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>">&#8592; Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?page=<?php echo $i; ?>" <?php echo ($i == $page) ? 'class="active"' : ''; ?>>
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page + 1; ?>">Next &#8594;</a>
        <?php endif; ?>
    </div>

    <br><br>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
        <a href="achievement_insert.php"><button>Tambah Achievement</button></a>
    <?php endif; ?>
    <br><br>
    <a href="home.php">Back To Home</a>
</body>
</html>
