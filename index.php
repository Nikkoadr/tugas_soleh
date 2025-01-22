<?php
session_start(); // Memulai session

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Jika belum login, arahkan ke login
    exit();
}

$username = $_SESSION['username']; // Ambil username dari session
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navbar -->
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="fakultas.php">Fakultas</a></li>
            <li><a href="jurusan.php">Jurusan</a></li>
            <li><a href="dosen.php">Dosen</a></li>
            <li><a href="mahasiswa.php">Mahasiswa</a></li>
            <li><a href="pembayaran.php">Pembayaran</a></li>
            <li><a href="laporan.php">Laporan</a></li>
        </ul>
    </nav>

    <!-- Konten -->
    <h3>Selamat datang, <?= htmlspecialchars($username); ?>!</h3>
    <p><a href="logout.php">Logout</a></p>
</body>
</html>
