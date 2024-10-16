<?php
session_start();
$koneksi = new mysqli("localhost:3307", "root", "", "esport");

if ($koneksi->connect_errno) {
    echo "Koneksi ke Database Failed: " . $koneksi->connect_errno;
}

// Cek role
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$isAdmin = $role === 'admin';

if ($isAdmin) {
    // Tentukan jumlah data per halaman
    $limit = 5;

    // Ambil halaman saat ini dari URL, jika tidak ada halaman maka halaman 1
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $start = ($page > 1) ? ($page * $limit) - $limit : 0;

    // Hitung total data
    $result_total = $koneksi->query("SELECT COUNT(*) AS total FROM join_proposal");
    $row_total = $result_total->fetch_assoc();
    $total = $row_total['total'];

    
    $total_pages = ceil($total / $limit);

    
    $status_filter = isset($_GET['status']) ? $_GET['status'] : 'all';
    $sql = "SELECT jp.idjoin_proposal, jp.idteam, jp.idmember, jp.description, jp.status, t.name AS team_name, m.username AS member_name 
            FROM join_proposal jp 
            JOIN team t ON jp.idteam = t.idteam 
            JOIN member m ON jp.idmember = m.idmember";

    if ($status_filter !== 'all') {
        $sql .= " WHERE jp.status = ?";
    }
    //fungsinya buat nambahin limit di var sql
    $sql .= " LIMIT $start, $limit";

    $stmt = $koneksi->prepare($sql);
    if ($status_filter !== 'all') {
        $stmt->bind_param("s", $status_filter);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    //  approve/rejected
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && isset($_POST['idjoin_proposal'])) {
    $idproposal = intval($_POST['idjoin_proposal']);
    $action = $_POST['action'];

    if ($action === 'approve') {
        // Update status menjadi 'approved'
        $update_sql = "UPDATE join_proposal SET status = 'approved' WHERE idjoin_proposal = ?";
        $update_stmt = $koneksi->prepare($update_sql);
        $update_stmt->bind_param("i", $idproposal);
        $update_stmt->execute();

        // Ambil data idteam dan idmember dari proposal yang di-approve
        $get_proposal_sql = "SELECT idteam, idmember FROM join_proposal WHERE idjoin_proposal = ?";
        $get_proposal_stmt = $koneksi->prepare($get_proposal_sql);
        $get_proposal_stmt->bind_param("i", $idproposal);
        $get_proposal_stmt->execute();
        $proposal_data = $get_proposal_stmt->get_result()->fetch_assoc();

        $idteam = $proposal_data['idteam'];
        $idmember = $proposal_data['idmember'];

        // Periksa apakah member sudah ada di team_members
        $check_sql = "SELECT COUNT(*) AS count FROM team_members WHERE idteam = ? AND idmember = ?";
        $check_stmt = $koneksi->prepare($check_sql);
        $check_stmt->bind_param("ii", $idteam, $idmember);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result()->fetch_assoc();

        if ($check_result['count'] == 0) {
            // Masukkan data ke tabel team_members jika belum ada
            $insert_sql = "INSERT INTO team_members (idteam, idmember, description) 
                           SELECT idteam, idmember, description FROM join_proposal WHERE idjoin_proposal = ?";
            $insert_stmt = $koneksi->prepare($insert_sql);
            $insert_stmt->bind_param("i", $idproposal);
            $insert_stmt->execute();
        }
    } elseif ($action === 'rejected') {
        $update_sql = "UPDATE join_proposal SET status = 'rejected' WHERE idjoin_proposal = ?";
        $update_stmt = $koneksi->prepare($update_sql);
        $update_stmt->bind_param("i", $idproposal);
        $update_stmt->execute();
    }
    // Redirect kembali ke halaman untuk mencegah pengulangan post data
    header("Location: joinproposal.php?status=$status_filter&page=$page");
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

    <!-- Navigasi Halaman -->
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
<br>

<?php
} else {
    echo "Halaman ini hanya dapat diakses oleh admin";
    echo '<a href="home.php">Kembali ke Beranda</a>';
    exit();
}

$koneksi->close();
?>
