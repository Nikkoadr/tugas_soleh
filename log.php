<?php 
include 'db.php';  // Koneksi ke database

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
    <title>Laporan Pembayaran Mahasiswa</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Konten -->
    <div class="container mt-4">
        <h3>Daftar Laporan Pembayaran</h3>

        <!-- Tombol Tambah Laporan -->
        <a href="tambah_laporan.php" class="btn btn-success mb-3">Tambah Laporan</a>

        <!-- Tabel Data Laporan -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Laporan</th>
                    <th>Deskripsi Laporan</th>
                    <th>Tanggal Laporan</th>
                    <th>Tipe Laporan</th>
                    <th>ID Dosen</th>
                    <th>ID Mahasiswa</th>
                    <th>ID Bayaran</th>
                    <th>Aksi</th> <!-- Kolom Aksi untuk Edit dan Hapus -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Query untuk mengambil data laporan
                $sql_laporan = "SELECT * FROM Laporan";
                $result_laporan = $conn->query($sql_laporan);

                if ($result_laporan && $result_laporan->num_rows > 0) {
                    while ($row = $result_laporan->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?= $row['id_laporan']; ?></td>
                            <td><?= $row['deskripsi_laporan']; ?></td>
                            <td><?= date("d-m-Y", strtotime($row['tanggal_laporan'])); ?></td>
                            <td><?= $row['tipe_laporan']; ?></td>
                            <td><?= $row['id_dosen']; ?></td>
                            <td><?= $row['id_mahasiswa']; ?></td>
                            <td><?= $row['id_bayaran']; ?></td>
                            <td>
                                <!-- Tombol Edit dan Hapus -->
                                <a href="edit_laporan.php?id=<?= $row['id_laporan']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="hapus_laporan.php?id=<?= $row['id_laporan']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');">Hapus</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada laporan yang tersedia.</td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
