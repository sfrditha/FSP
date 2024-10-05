<?php
session_start();
$koneksi = new mysqli("localhost:3306", "root", "", "esport");

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
    <title>Events</title>
    <link rel="stylesheet" href="event.css">
</head>
<body>
    <h2>Events</h2>
    <?php
    $sql = "SELECT * FROM event";
    $stmt = $koneksi->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<table border='1'>";
    echo "<tr><th>ID Event</th><th>Nama Event</th><th>Tanggal</th><th>Deskripsi</th></tr>";

	if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
		echo "<th colspan='2'>Aksi</th>"; // Tampilkan aksi hanya jika user adalah admin
	}
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row['idevent']."</td>";
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['date']."</td>";
        echo "<td>".$row['description']."</td>";

        // Tombol hapus dan edit hanya ditampilkan untuk admin
        if ($isAdmin) {
            echo "<td>
                    <form action='event_hapus.php' method='POST'>
                        <input type='hidden' name='idevent' value='".$row['idevent']."'>
                        <input type='submit' value='Hapus' class='btnHapus'>
                    </form>
                  </td>";
            echo "<td>
                    <a href='event_edit.php?idevent=".$row['idevent']."'>
                        <button>Edit</button>
                    </a>
                  </td>";
        } 
        echo "</tr>";
    }
    echo "</table>";

    if ($isAdmin) {
        echo "<br><a href='event_insert.php'><button>Tambah Event</button></a>";
    }

    $koneksi->close();
    ?>
    <br><a href="home.php">Back To Home</a>
</body>
</html>
