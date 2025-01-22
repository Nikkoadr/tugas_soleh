<?php
// Konfigurasi database
$host = "localhost";
$user = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$database = "gaji_dosen"; // Nama database

// Membuat koneksi
$conn = new mysqli($host, $user, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data fakultas
$sql = "SELECT nama_fakultas FROM fakultas"; // Pastikan nama tabel dan kolom sesuai
$result = $conn->query($sql);

// Menyimpan data ke dalam array
$fakultas = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $fakultas[] = $row['nama_fakultas']; // Sesuaikan dengan nama kolom
    }
}

// Menutup koneksi
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Fakultas</title>
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
    <h3>Daftar Fakultas</h3>
    <table>
        <tr>
            <th>No</th>
            <th>Fakultas</th>
        </tr>
        <?php if (!empty($fakultas)): ?>
            <?php foreach ($fakultas as $index => $nama_fakultas): ?>
                <tr>
                    <td><?= $index + 1; ?></td>
                    <td><?= htmlspecialchars($nama_fakultas); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="2">Tidak ada data fakultas yang ditemukan.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
