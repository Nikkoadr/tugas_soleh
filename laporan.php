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

// Query untuk mengambil data jumlah laporan
$sql_laporan_count = "SELECT COUNT(id_laporan) AS total_laporan FROM Laporan";
$result_laporan_count = $conn->query($sql_laporan_count);
$laporan_count = $result_laporan_count->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - Pembayaran Mahasiswa</title>
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
            <!-- Menampilkan jumlah laporan pada item navbar -->
            <li><a href="laporan.php">Laporan (<?php echo $laporan_count['total_laporan']; ?> laporan)</a></li>
        </ul>
    </nav>

    <!-- Halaman Laporan -->
    <h3>Daftar Laporan</h3>
    <table>
        <thead>
            <tr>
                <th>ID Laporan</th>
                <th>Deskripsi Laporan</th>
                <th>Tanggal Laporan</th>
                <th>Tipe Laporan</th>
                <th>ID Dosen</th>
                <th>ID Mahasiswa</th>
                <th>ID Bayaran</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Query untuk mengambil data laporan
            $sql_laporan = "SELECT * FROM Laporan";
            $result_laporan = $conn->query($sql_laporan);

            if (!$result_laporan) {
                die("Query gagal: " . $conn->error);
            }

            if ($result_laporan->num_rows > 0) {
                // Output data dari setiap baris
                while ($row = $result_laporan->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id_laporan'] . "</td>";
                    echo "<td>" . $row['deskripsi_laporan'] . "</td>";
                    echo "<td>" . date("d-m-Y", strtotime($row['tanggal_laporan'])) . "</td>";
                    echo "<td>" . $row['tipe_laporan'] . "</td>";
                    echo "<td>" . $row['id_dosen'] . "</td>";
                    echo "<td>" . $row['id_mahasiswa'] . "</td>";
                    echo "<td>" . $row['id_bayaran'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Tidak ada laporan yang tersedia.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <p><a href="logout.php">Logout</a></p>
</body>
</html>
