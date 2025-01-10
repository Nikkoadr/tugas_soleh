<?php
session_start(); // Memulai session

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Tampilkan pesan berdasarkan role pengguna
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>
<body>
    <h2>Selamat datang!</h2>
    <?php
    if ($role == 'mahasiswa') {
        echo "<p>Halo Mahasiswa! Anda login sebagai mahasiswa.</p>";
    } elseif ($role == 'dosen') {
        echo "<p>Halo Dosen! Anda login sebagai dosen.</p>";
    }
    ?>
    
    <a href="logout.php">Logout</a> <!-- Tautan untuk logout -->
</body>
</html>
