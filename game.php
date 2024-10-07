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
    <title>Games</title>
    <link rel="stylesheet" href="gamee.css">
</head>
<body>
    <h2>GAMES</h2>
    <?php
    $sql = "SELECT * FROM game";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<table border='1'>";
    echo "<tr><th>ID Game</th><th>Nama Game</th><th>Deskripsi</th>";

    if ($isAdmin) {
        echo "<th colspan='2'>Aksi</th>"; // Tampilkan aksi hanya jika user adalah admin
    }

    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row['idgame']."</td>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['description']."</td>";

        // Tombol hapus dan edit hanya ditampilkan untuk admin
        if ($isAdmin) {
            echo "<td>
                    <form action='game_hapus.php' method='POST'>
                        <input type='hidden' name='idgame' value='".$row['idgame']."'>
                        <input type='submit' value='Hapus' class='btnHapus'>
                    </form>
                  </td>";
            echo "<td>
                    <a href='game_edit.php?idgame=".$row['idgame']."'>
                        <button>Edit</button>
                    </a>
                  </td>";
        } 
        echo "</tr>";
    }
    echo "</table>";

    if ($isAdmin) {
        echo "<br><a href='game_insert.php'><button>Tambah Game</button></a>";
    }

    $koneksi->close();
    ?>
    <br>
    <br><a href="home.php">Back To Home</a>
</body>
</html>
