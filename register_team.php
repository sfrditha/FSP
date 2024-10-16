<?php
session_start();
$koneksi = new mysqli("localhost:3306", "root", "", "esport");

if ($koneksi->connect_errno) {
    die("Koneksi ke Database Failed: " . $koneksi->connect_errno);
}


$idmember = isset($_SESSION['idmember']) ? $_SESSION['idmember'] : 0; 

if ($idmember > 0) {
    // Mengecek apakah user sudah mengajukan bergabung ke tim
    $checkProposal = "SELECT status FROM join_proposal WHERE idmember = ?";
    $stmt = $koneksi->prepare($checkProposal);
    $stmt->bind_param("i", $idmember);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $status = $row['status'];
        
        // Jika status waiting, approved, atau rejected
        if ($status === 'waiting') {
            echo "<p>Pengajuan Anda masih dalam status <b>'waiting'</b>. Harap tunggu persetujuan.</p>";
            echo "<a href='home.php'>Kembali ke Beranda</a>";
            exit(); // Menghentikan eksekusi kode selanjutnya
        } elseif ($status === 'approved') {
            echo "<p>Pengajuan Anda telah <b>'Diterima'</b>. Anda sekarang anggota tim.</p>";
            echo "<a href='home.php'>Kembali ke Beranda</a>";
            exit(); 
        } elseif ($status === 'rejected') {
            echo "<p>Pengajuan Anda telah <b>'Ditolak'</b>. Silakan ajukan ke tim lain atau perbarui permintaan.</p>";
        }
    }
}

// Menangani proses pendaftaran join proposal
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idteam = isset($_POST['idteam']) ? intval($_POST['idteam']) : 0; // Tim yang dipilih oleh pengguna
    $description = isset($_POST['description']) ? $_POST['description'] : 'role preference: support, attacker, dll'; // Deskripsi default
    $status = 'waiting'; // Set status menjadi 'waiting'

    if ($idteam > 0) {
        // Simpan data ke join_proposal jika user belum memiliki pengajuan aktif
        $sql = "INSERT INTO join_proposal (idteam, idmember, description, status) VALUES (?, ?, ?, ?)";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("iiss", $idteam, $idmember, $description, $status);

        if ($stmt->execute()) {
            header("Location: home.php");
            exit();
        } else {
            $error = "Registrasi tim gagal.";
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
    <link rel="stylesheet" type="text/css" href="registerr.css">
</head>
<body>
    <h2>Pendaftaran Pengajuan Bergabung dengan Tim</h2>

    <form action="" method="POST">
        <label for="idteam">Pilih Tim:</label>
        <select name="idteam" id="idteam" required>
            <option value="">-- Pilih Tim --</option>
            <?php
            // Menampilkan daftar tim yang tersedia
            $sql = "SELECT idteam, name FROM team";
            $result = $koneksi->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<option value='" . $row['idteam'] . "'>" . $row['name'] . "</option>";
            }
            ?>
        </select><br><br>

        <label for="description">Deskripsi :</label><br>
        <textarea name="description" id="description" rows="4" cols="50" placeholder="Posisi yang anda inginkan"></textarea><br><br>

        <input type="submit" value="Ajukan Bergabung dengan Tim">
    </form>

    <br>
    <a href="home.php">Kembali ke Beranda</a>
</body>
</html>

<?php
$koneksi->close();
?>
