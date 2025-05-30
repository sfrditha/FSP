<?php
session_start();
require_once 'database.php';
require_once 'joinproposal_class.php';

$koneksi = new Database();
$joinProposal = new JoinProposal($koneksi->getConnection());
$idmember = isset($_SESSION['idmember']) ? $_SESSION['idmember'] : 0;

if ($idmember > 0) {
    $existingProposal = $joinProposal->memberStatus($idmember);
    
    // if ($existingProposal->num_rows > 0) {
    //     $row = $existingProposal->fetch_assoc();
    //     $status = $row['status'];
        
    //     if ($status === 'waiting') {
    //         echo "<p>Pengajuan Anda masih dalam status <b>'waiting'</b>. Harap tunggu persetujuan.</p>";
    //         echo "<a href='home.php'>Kembali ke Beranda</a>";
    //         exit();
    //     } elseif ($status === 'approved') {
    //         echo "<p>Pengajuan Anda  sebelumnya telah <b>'Diterima'</b>. Anda sekarang anggota tim.</p>";
    //     } elseif ($status === 'rejected') {
    //         echo "<p>Pengajuan Anda telah <b>'Ditolak'</b>. Silakan ajukan ke tim lain atau perbarui permintaan.</p>";
    //     }
    // }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idteam = isset($_POST['idteam']) ? intval($_POST['idteam']) : 0;
    $description = isset($_POST['description']) ? $_POST['description'] : 'role preference: support, attacker, dll';
    $status = 'waiting';

    if ($idteam > 0) {
        $affectedRows = $joinProposal->insertJoinProposal($idteam, $idmember, $description, $status);
        if ($affectedRows > 0) {
            header("Location: proposal.php");
            exit();
        } else {
            echo "Registrasi tim gagal.";
        }
    } else {
        echo "Pilih tim yang ingin Anda ajukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Bergabung dengan Tim</title>
    <link rel="stylesheet" type="text/css" href="regisTim.css">
</head>
<body>
    <h2>Pendaftaran Pengajuan Bergabung dengan Tim</h2>

    <form action="" method="POST">
        <label for="idteam">Pilih Tim:</label>
        <select name="idteam" id="idteam" required>
            <option value="">-- Pilih Tim --</option>
            <?php
            $result = $joinProposal->getTeams($idmember);

            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['idteam'] . "'>" . $row['name'] . "</option>";
            }
            ?>
        </select><br><br>

        <label for="description">Posisi:</label>
        <textarea name="description" id="description" rows="4" cols="50" placeholder="Tulis Posisi yang anda inginkan di team ini" required></textarea>
        <br>

        <input type="submit" value="Kirim Pengajuan">
    </form>

    <br><a href="home.php">Kembali ke Beranda</a>
</body>
</html>
