<?php
session_start(); 

$koneksi = new mysqli("localhost:3307", "root", "", "esport");

if ($koneksi->connect_errno) {
    die("Koneksi ke Database Failed: " . $koneksi->connect_errno);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    // Check if the username already exists
    $check_query = "SELECT * FROM member WHERE username = ?";
    $stmt = $koneksi->prepare($check_query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Username already exists
        $error = "Username sudah terdaftar. Silakan pilih username lain.";
    } else {

        // // kalau pake Hash password 
        // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // // Query untuk menambahkan pengguna baru ke dalam database
        // $query = "INSERT INTO member (username, password, profile, fname, lname) VALUES (?, ?, ?, ?, ?)";
        // $stmt = $koneksi->prepare($query);
        // $role = 'member'; // Asumsikan role default adalah 'member'
        // $stmt->bind_param("sssss", $username, $hashed_password, $role, $first_name, $last_name);

        // Proceed with registration
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
}

$koneksi->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pengguna Baru</title>
    <link rel="stylesheet" type="text/css" href="regis.css">
</head>
<body>
    
    <form method="POST" action="">
        <h1>REGISTRASI</h1>
        <div>
            <label>Nama Depan:</label>
            <input type="text" placeholder="Nama Depan" name="first_name" required>
        </div>
        <div>
            <label>Nama Belakang:</label>
            <input type="text" placeholder="Nama Belakang" name="last_name" required>
        </div>
        <div>
            <label>Username:</label>
            <input type="text" placeholder="Username" name="username" required>
        </div>
        <div>
            <label>Password:</label>
            <input type="password" placeholder="Password" name="password" required>
        </div>
        <button type="submit">Daftar</button>
        <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    </form>
    
    <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
</body>
</html>
