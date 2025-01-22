<?php 
// Konfigurasi database
$host = "localhost";
$user = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$database = "gaji_dosen"; // Nama database

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah pengguna sudah login
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Mahasiswa</title>
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
    <h3>Data Pembayaran Mahasiswa</h3>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID Bayaran</th>
                <th>ID Mahasiswa</th>
                <th>Jumlah Bayaran</th>
                <th>Tanggal Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Query untuk mengambil data pembayaran mahasiswa
            $sql = "SELECT * FROM BayaranMahasiswa";
            $result = $conn->query($sql);

            if (!$result) {
                die("Query gagal: " . $conn->error);
            }

            if ($result->num_rows > 0) {
                // Output data dari setiap baris
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id_bayaran'] . "</td>";
                    echo "<td>" . $row['id_mahasiswa'] . "</td>";
                    echo "<td>Rp " . number_format($row['jumlah_bayaran'], 2, ',', '.') . "</td>";
                    echo "<td>" . $row['tanggal_pembayaran'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Tidak ada data pembayaran.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <p><a href="logout.php">Logout</a></p>
</body>
</html>
