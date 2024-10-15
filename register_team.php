<?php
session_start();
$koneksi = new mysqli("localhost:3306", "root", "", "esport");

if ($koneksi->connect_errno) {
    echo "Koneksi ke Database Failed: " . $koneksi->connect_errno;
}

// Cek apakah pengguna sudah login dan memiliki tim
$idmember = isset($_SESSION['idmember']) ? $_SESSION['idmember'] : 0; // Mengambil idmember dari session (pengguna yang sudah login)

if ($idmember > 0) {
    // Mengecek apakah user sudah menjadi anggota tim
    $checkTeam = "SELECT idteam FROM team_members WHERE idmember = ?";
    $stmt = $koneksi->prepare($checkTeam);
    $stmt->bind_param("i", $idmember);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Pengguna sudah memiliki tim, beri tahu dan hanya tampilkan link ke home.php
        echo "<p>Anda sudah menjadi anggota tim.</p>";
        echo "<a href='home.php'>Kembali ke Beranda</a>";
        exit(); // Menghentikan eksekusi kode selanjutnya
    }
}

// Menangani proses pendaftaran join proposal
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idteam = isset($_POST['idteam']) ? intval($_POST['idteam']) : 0; // Tim yang dipilih oleh pengguna
    $description = isset($_POST['description']) ? $_POST['description'] : 'role preference: support, attacker, dll'; // Deskripsi default jika tidak diisi
    $status = 'waiting'; // Set status menjadi 'waiting'

    if ($idteam > 0) {
        // Simpan data ke join_proposal jika belum ada tim
        $sql = "INSERT INTO join_proposal (idteam, idmember, description, status) VALUES (?, ?, ?, ?)";
        $stmt = $koneksi->prepare($sql);
        $stmt->bind_param("iiss", $idteam, $idmember, $description, $status);

        if ($stmt->execute()) {
            header("Location: home.php");
            exit();
        } else {
            $error = "Registrasi team gagal";
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
        <?php
            echo $idmember;
        ?>

        <label for="description">Deskripsi :</label><br>
        <textarea name="description" id="description" rows="4" cols="50" placeholder="Ceritakan tentang peran yang Anda inginkan, keahlian, dll."></textarea><br><br>

        <input type="submit" value="Ajukan Bergabung dengan Tim">
    </form>

    <br>
    <a href="home.php">Kembali ke Beranda</a>
</body>
</html>

<?php
$koneksi->close();
?>