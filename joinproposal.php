<?php
session_start();
require_once 'database.php';
require_once 'joinproposal_class.php';

$database = new Database();
$koneksi = $database->getConnection();

$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$isAdmin = $role === 'admin';

if ($isAdmin) {
    $limit = 5;

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $start = ($page > 1) ? ($page * $limit) - $limit : 0;

    $joinProposal = new JoinProposal($koneksi);
    $status_filter = isset($_GET['status']) ? $_GET['status'] : 'all';
    $result = $joinProposal->getJoinProposals($limit, $start, $status_filter);

    $total = $joinProposal->getTotalJoinProposals($status_filter);
    $total_pages = ceil($total / $limit);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && isset($_POST['idjoin_proposal'])) {
        $idproposal = intval($_POST['idjoin_proposal']);
        $action = $_POST['action'];

        if ($action === 'approve') {
            $joinProposal->updateJoinProposalStatus($idproposal, 'approved');

            $get_proposal_sql = "SELECT idteam, idmember FROM join_proposal WHERE idjoin_proposal = ?";
            $get_proposal_stmt = $koneksi->prepare($get_proposal_sql);
            $get_proposal_stmt->bind_param("i", $idproposal);
            $get_proposal_stmt->execute();
            $proposal_data = $get_proposal_stmt->get_result()->fetch_assoc();

            $idteam = $proposal_data['idteam'];
            $idmember = $proposal_data['idmember'];

            $check_sql = "SELECT COUNT(*) AS count FROM team_members WHERE idteam = ? AND idmember = ?";
            $check_stmt = $koneksi->prepare($check_sql);
            $check_stmt->bind_param("ii", $idteam, $idmember);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result()->fetch_assoc();

            if ($check_result['count'] == 0) {
                $insert_sql = "INSERT INTO team_members (idteam, idmember, description) 
                               SELECT idteam, idmember, description FROM join_proposal WHERE idjoin_proposal = ?";
                $insert_stmt = $koneksi->prepare($insert_sql);
                $insert_stmt->bind_param("i", $idproposal);
                $insert_stmt->execute();
            }
        } elseif ($action === 'rejected') {
            $joinProposal->updateJoinProposalStatus($idproposal, 'rejected');
        }

        header("Location: joinproposal.php?status=$status_filter&page=$page");
        exit();
    }
} else {
    echo "Halaman ini hanya dapat diakses oleh admin";
    echo '<a href="home.php">Kembali ke Beranda</a>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Kelola Join Proposal</title>
    <link rel="stylesheet" type="text/css" href="admin_style.css">
</head>
<body>
    <h2>Daftar Pengajuan Join Proposal</h2>

    <form method="GET" action="joinproposal.php">
        <label for="status">Filter berdasarkan status:</label>
        <select name="status" id="status" onchange="this.form.submit()">
            <option value="all" <?= $status_filter === 'all' ? 'selected' : '' ?>>Semua</option>
            <option value="waiting" <?= $status_filter === 'waiting' ? 'selected' : '' ?>>Waiting</option>
            <option value="approved" <?= $status_filter === 'approved' ? 'selected' : '' ?>>Approved</option>
            <option value="rejected" <?= $status_filter === 'rejected' ? 'selected' : '' ?>>Rejected</option>
        </select>
    </form>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID Proposal</th>
                <th>Nama Tim</th>
                <th>Nama Member</th>
                <th>Deskripsi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= $row['idjoin_proposal'] ?></td>
                    <td><?= $row['team_name'] ?></td>
                    <td><?= $row['member_name'] ?></td>
                    <td><?= $row['description'] ?></td>
                    <td><?= $row['status'] ?></td>
                    <td>
                        <?php if ($row['status'] === 'waiting') : ?>
                            <form method="POST" action="">
                                <input type="hidden" name="idjoin_proposal" value="<?= $row['idjoin_proposal'] ?>">
                                <button type="submit" name="action" value="approve">Approve</button>
                                <button type="submit" name="action" value="rejected">Reject</button>
                            </form>
                        <?php else : ?>
                            Tidak Ada Aksi
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- PAGING -->
    <br>
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?status=<?php echo $status_filter; ?>&page=<?php echo $page - 1; ?>" class="disabled"><--Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href="?status=<?php echo $status_filter; ?>&page=<?php echo $i; ?>" class="<?php echo $i == $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
            <a href="?status=<?php echo $status_filter; ?>&page=<?php echo $page + 1; ?>">Next--></a>
        <?php endif; ?>
    </div>
    <br>

    <a href="home.php">Kembali ke Beranda</a>
</body>
</html>

<?php
$database->closeConnection();
?>
