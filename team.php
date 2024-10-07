<?php
session_start();
$koneksi = new mysqli("localhost:3307", "root", "", "esport");

if ($koneksi->connect_errno) {
    echo "Koneksi ke Database Failed: " . $koneksi->connect_errno;
}

// Cek role
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teams</title>
    <link rel="stylesheet" href="teamm.css">
</head>
<body>
    <h2>TEAMS</h2>
    <?php
    $sql = "SELECT * FROM team";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<table border='1'>";
    echo "<tr><th>ID Team</th><th>ID Game</th><th>Nama Team</th>";

    if ($isAdmin) {
        echo "<th colspan='2'>Aksi</th>"; // Tampilkan aksi hanya jika user adalah admin
    }

    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row['idteam']."</td>";
        echo "<td>".$row['idgame']."</td>";
        echo "<td>".$row['name']."</td>";

        // Tombol hapus dan edit hanya ditampilkan untuk admin
        if ($isAdmin) {
            echo "<td>
                    <form action='team_hapus.php' method='POST'>
                        <input type='hidden' name='idteam' value='".$row['idteam']."'>
                        <input type='submit' value='Hapus' class='btnHapus'>
                    </form>
                  </td>";
            echo "<td>
                    <a href='team_edit.php?idteam=".$row['idteam']."'>
                        <button>Edit</button>
                    </a>
                  </td>";
        } 
        echo "</tr>";
    }
    echo "</table>";

    if ($isAdmin) {
        echo "<br><a href='team_insert.php'><button>Tambah Team</button></a>";
    }

    $koneksi->close();
    ?>
    <br>
    <br><a href="home.php">Back To Home</a>
</body>
</html>
