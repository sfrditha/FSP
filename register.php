<?php
session_start(); 

$koneksi = new mysqli("localhost:3306", "root", "", "esport");

if ($koneksi->connect_errno) {
    die("Koneksi ke Database Failed: " . $koneksi->connect_errno);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    // // kalau pake Hash password 
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // // Query untuk menambahkan pengguna baru ke dalam database
    // $query = "INSERT INTO member (username, password, profile, fname, lname) VALUES (?, ?, ?, ?, ?)";
    // $stmt = $koneksi->prepare($query);
    // $role = 'member'; // Asumsikan role default adalah 'member'
    // $stmt->bind_param("sssss", $username, $hashed_password, $role, $first_name, $last_name);


    $query = "INSERT INTO member (username, password, profile, fname, lname) VALUES (?, ?, ?, ?, ?)";
    $stmt = $koneksi->prepare($query);
    $role = 'member'; 
    $stmt->bind_param("sssss", $username, $password, $role, $first_name, $last_name);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else {
        $error = "Registrasi gagal. Coba lagi.";
    }
}

$koneksi->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pengguna Baru</title>
</head>
<body>
    <h2>Registrasi</h2>
    <form method="POST" action="">
        <div>
            <label>Nama Depan:</label>
            <input type="text" name="first_name" required>
        </div>
        <div>
            <label>Nama Belakang:</label>
            <input type="text" name="last_name" required>
        </div>
        <div>
            <label>Username:</label>
            <input type="text" name="username" required>
        </div>
        <div>
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Daftar</button>
        <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    </form>
    
    <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
</body>
</html>
