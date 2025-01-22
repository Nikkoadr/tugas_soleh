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

// Query untuk mengambil data dosen dengan INNER JOIN
$sql = "
    SELECT users.nama AS nama_dosen, jurusan.nama_jurusan, dosen.nidn 
    FROM dosen
    INNER JOIN users ON dosen.id_user = users.id_user
    INNER JOIN jurusan ON dosen.id_jurusan = jurusan.id_jurusan
"; // Pastikan nama tabel dan kolom sesuai

$result = $conn->query($sql);

// Menyimpan data ke dalam array
$dosen = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dosen[] = $row; // Menyimpan data dosen
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
    <title>Daftar Dosen</title>
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
    <h3>Daftar Dosen</h3>
    <table>
        <tr>
            <th>No</th>
            <th>Nama Dosen</th>
            <th>Jurusan</th>
            <th>NIDN</th>
        </tr>
        <?php if (!empty($dosen)): ?>
            <?php foreach ($dosen as $index => $data_dosen): ?>
                <tr>
                    <td><?= $index + 1; ?></td>
                    <td><?= htmlspecialchars($data_dosen['nama_dosen']); ?></td>
                    <td><?= htmlspecialchars($data_dosen['nama_jurusan']); ?></td>
                    <td><?= htmlspecialchars($data_dosen['nidn']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Tidak ada data dosen yang ditemukan.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
