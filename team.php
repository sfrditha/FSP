<?php
session_start();
require_once 'database.php';
require_once 'team_class.php';

$db = new Database();
$koneksi = $db->getConnection();

$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
$isMember = isset($_SESSION['role']) && $_SESSION['role'] === 'member';

$team = new Team($koneksi);

$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page > 1) ? ($page * $limit) - $limit : 0;

$total = $team->getTotalTeams();
$total_pages = ceil($total / $limit);

$result = $team->getTeams($start, $limit);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teams</title>
    <link rel="stylesheet" href="timm.css">
</head>
<body>
    <h2>TEAMS</h2>
    <table>
        <thead>
            <tr>
                <th>ID Team</th>
                <th>Game</th>
                <th>Nama Team</th>
                <th>Foto Team</th>
                <?php if ($isAdmin): ?>
                    <th colspan="3">Aksi</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td data-label="ID Team"><?php echo htmlspecialchars($row['idteam']); ?></td>
                    <td data-label="Game"><?php echo htmlspecialchars($row['game']); ?></td>
                    <td data-label="Nama Team"><?php echo htmlspecialchars($row['name']); ?></td>
                    <td data-label="Foto Team">
                        <img src="img/<?php echo htmlspecialchars($row['idteam']); ?>.jpg" alt="Team Photo">
                    </td>
                    <?php if ($isAdmin): ?>
                        <td data-label="Hapus">
                            <form action="team_hapus.php" method="POST">
                                <input type="hidden" name="idteam" value="<?php echo htmlspecialchars($row['idteam']); ?>">
                                <input type="submit" value="Hapus" class="btnHapus">
                            </form>
                        </td>
                        <td data-label="Edit">
                            <a href="team_edit.php?idteam=<?php echo htmlspecialchars($row['idteam']); ?>"><button>Edit</button></a>
                        </td>
                        <td data-label="Detail">
                            <form action="team_detail.php" method="POST">
                                <input type="hidden" name="idteam" value="<?php echo htmlspecialchars($row['idteam']); ?>">
                                <input type="submit" value="Detail" class="btnDetail">
                            </form>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>">&larr; Previous</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <?php if ($i == $page): ?>
                <span class="active"><?php echo $i; ?></span>
            <?php else: ?>
                <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            <?php endif; ?>
        <?php endfor; ?>
        <?php if ($page < $total_pages): ?>
            <a href="?page=<?php echo $page + 1; ?>">Next &rarr;</a>
        <?php endif; ?>
    </div>

    <?php if ($isAdmin): ?>
        <br><a href="team_insert.php"><button>Tambah Team</button></a>
    <?php endif; ?>
    <br><br><a href="home.php">Back To Home</a>
</body>
</html>

<?php $db->closeConnection(); ?>
