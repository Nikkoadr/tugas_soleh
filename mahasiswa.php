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

// Query untuk mengambil data mahasiswa dengan INNER JOIN
$sql = "
    SELECT users.nama AS nama_mahasiswa, jurusan.nama_jurusan 
    FROM mahasiswa
    INNER JOIN users ON mahasiswa.id_user = users.id_user
    INNER JOIN jurusan ON mahasiswa.id_jurusan = jurusan.id_jurusan
   
"; // Pastikan nama tabel dan kolom sesuai

$result = $conn->query($sql);

// Menyimpan data ke dalam array
$mahasiswa = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mahasiswa[] = $row; // Menyimpan data mahasiswa
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
    <title>Daftar Mahasiswa</title>
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
    <h3>Daftar Mahasiswa</h3>
    <table>
        <tr>
            <th>No</th>
            <th>Nama Mahasiswa</th>
            <th>Jurusan</th>
            
        </tr>
        <?php if (!empty($mahasiswa)): ?>
            <?php foreach ($mahasiswa as $index => $data_mahasiswa): ?>
                <tr>
                    <td><?= $index + 1; ?></td>
                    <td><?= htmlspecialchars($data_mahasiswa['nama_mahasiswa']); ?></td>
                    <td><?= htmlspecialchars($data_mahasiswa['nama_jurusan']); ?></td>
                    
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Tidak ada data mahasiswa yang ditemukan.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
