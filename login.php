<?php
session_start(); 

$koneksi = new mysqli("localhost:3307", "root", "", "esport");

if ($koneksi->connect_errno) {
    die("Koneksi ke Database Failed: " . $koneksi->connect_errno);
}

// Cek jika form login telah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mendapatkan username dan password dari database
    $query = "SELECT * FROM member WHERE username = ? AND password = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();  

    $query = "SELECT * FROM member WHERE username = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // // KALAU PAKE HASH
    // jalankan syntax ini dulu di db (ALTER TABLE member MODIFY COLUMN password VARCHAR(255);)
    // if ($result->num_rows == 1) {
    //     $row = $result->fetch_assoc();

    //     // Verifikasi password 
    //     if (password_verify($password, $row['password'])) {
    //         // Set sesi untuk username, role, dan nama depan pengguna
    //         $_SESSION['username'] = $row['username'];
    //         $_SESSION['role'] = $row['profile']; // Asumsi 'profile' adalah field yang berisi role
    //         $_SESSION['first_name'] = $row['fname']; // Mengambil nama depan dari database

    //         // Redirect ke halaman home.php
    //         header("Location: home.php");
    //         exit();
    //     } else {
    //         $error = "Password salah.";
    //     }
    // } else {
    //     $error = "Username tidak ditemukan.";
    // }

    // Cek apakah username dan password cocok

    if ($result->num_rows == 1) {
        // Ambil data user
        $user = $result->fetch_assoc();
        
        // Set sesi untuk username dan role
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['profile']; // Ambil role dari kolom profile

        
        header("Location: home.php");
        exit();
    } else {
        $error = "Username atau password salah.";
    }
}

$koneksi->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="logn.css"> 
</head>
<body>
    
    <form method="POST" action="">
        <h1>LOGIN</h1>
        <div>
            <label>Username:</label>
            <input type="text" placeholder="Username" name="username" required>
        </div>
        <div>
            <label>Password:</label>
            <input type="password" placeholder="Password" name="password" required>
        </div>
        <button type="submit">Login</button>
        <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    </form>

    <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
</body>
</html>
