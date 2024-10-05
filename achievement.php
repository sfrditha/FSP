<?php
session_start(); // Pastikan session dimulai

$koneksi = new mysqli("localhost:3306", "root", "", "esport");

if ($koneksi->connect_errno) {
    echo "Koneksi ke Database Failed: " . $koneksi->connect_errno;
}

echo "Koneksi sukses. <br>";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Achievement</title>
    <link rel="stylesheet" href="achievement.css">
</head>
<body>
<b>Achievement</b>
<?php

$sql = "SELECT achievement.idachievement, team.name AS team_name, achievement.name, achievement.date, achievement.description
        FROM achievement
        JOIN team ON achievement.idteam = team.idteam";
$stmt  = $koneksi->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

echo "<table border='1'>";
echo "<tr><th>IDAchievement</th><th>Nama Tim</th><th>Name</th><th>Date</th><th>Deskripsi</th>";

if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    echo "<th colspan='2'>Aksi</th>"; // Tampilkan aksi hanya jika user adalah admin
}

echo "</tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>".$row['idachievement']."</td>";
    echo "<td>".$row['team_name']."</td>";
    echo "<td>".$row['name']."</td>";
    $rilis = date("d F Y", strtotime($row['date']));
    echo "<td>".$rilis."</td>";
    echo "<td>".$row['description']."</td>";
    
    // Tombol hapus
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        echo "<td>
                <form action='achievement_hapus.php' method='POST'>
                    <input type='hidden' name='idachievement' value='".$row['idachievement']."'>
                    <input type='submit' value='Hapus' class='btnHapus'>
                </form>
              </td>";
        
        // Tombol edit
        echo "<td>
                <a href='achievement_edit.php?idachievement=".$row['idachievement']."'>
                    <button>Edit</button>
                </a>
              </td>";
    }
    echo "</tr>";
}
echo "</table>";

$koneksi->close();
?>
<br>
<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
    <a href="achievement_insert.php">
        <button>Tambah</button>
    </a>
<?php endif; ?>
<br><br>
<a href="home.php">Back To Home</a>

<script type="text/javascript" src="js/jquery-3.7.1.min.js"></script>
<script type="text/javascript"></script>
</body>
</html>
