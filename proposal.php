<?php
session_start();
require_once 'database.php';
require_once 'joinproposal_class.php';

$koneksi = new Database();
$joinProposal = new JoinProposal($koneksi->getConnection());
$idmember = isset($_SESSION['idmember']) ? $_SESSION['idmember'] : 0;

// Mengambil daftar proposal yang diajukan oleh pengguna
$proposals = $joinProposal->getProposalsByMember($idmember);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Proposal Pengajuan</title>
    <link rel="stylesheet" type="text/css" href="proposal.css">
</head>
<body>
    <h2>Daftar Proposal Pengajuan Bergabung dengan Tim</h2>

    <div class="proposal-container">
        <?php if ($proposals->num_rows > 0) : ?>
            <?php while ($row = $proposals->fetch_assoc()) : ?>
                <div class="proposal-card">
                    <h3><?= htmlspecialchars($row['team_name']) ?></h3>
                    <p><strong>Game:</strong> <?= htmlspecialchars($row['game_name']) ?></p>
                    <p><strong>Posisi:</strong> <?= htmlspecialchars($row['description']) ?></p>
                    <p><strong>Status:</strong> <span class="status <?= strtolower($row['status']) ?>"><?= htmlspecialchars($row['status']) ?></span></p>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <p>Belum ada proposal yang diajukan.</p>
        <?php endif; ?>
    </div>

    <div class="action-buttons">
        <a href="register_team.php" class="register-team-button">Ajukan Tim Baru</a>
        <a href="home.php" class="back-button">Kembali ke Beranda</a>
    </div>
</body>
</html>
