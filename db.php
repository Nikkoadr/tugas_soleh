<?php
$host = 'localhost'; // Sesuaikan dengan host Anda
$dbname = 'gaji_dosen'; // Nama database Anda
$username = 'root'; // Username database Anda
$password = ''; // Password database Anda (kosong jika menggunakan default)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set mode error PDO ke exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Koneksi gagal: ' . $e->getMessage();
}
?>
