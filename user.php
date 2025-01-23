<?php  
// Konfigurasi database
include 'db.php';

// Menangkap input pencarian
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

// Query untuk mengambil data pengguna
$sql = "
    SELECT id_user, username, nama, role 
    FROM users
    WHERE username LIKE ? OR nama LIKE ? OR role LIKE ?
";

// Menyiapkan query dan binding parameter
$stmt = $conn->prepare($sql);
$search_term = "%" . $cari . "%";
$stmt->bind_param("sss", $search_term, $search_term, $search_term);
$stmt->execute();

// Mendapatkan hasil query
$result = $stmt->get_result();

// Menyimpan data ke dalam array
$users = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row; // Menyimpan data pengguna
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
    <title>Daftar Pengguna</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Konten -->
    <div class="container mt-4">
        <h3>Daftar Pengguna</h3>

        <!-- Form Pencarian Pengguna -->
        <form class="mb-3" method="get" action="users.php">
            <div class="input-group">
                <input type="text" class="form-control" name="cari" placeholder="Cari Username, Nama, atau Email" value="<?= htmlspecialchars($cari ?? ''); ?>">
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
        </form>

        <!-- Tombol Tambah Pengguna -->
        <a href="tambah_user.php" class="btn btn-success mb-3">Tambah Pengguna</a>

        <!-- Tabel Data Pengguna -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Aksi</th> <!-- Kolom Aksi untuk Edit dan Hapus -->
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $index => $user): ?>
                        <tr>
                            <td><?= $index + 1; ?></td>
                            <td><?= htmlspecialchars($user['username']); ?></td>
                            <td><?= htmlspecialchars($user['nama']); ?></td>
                            <td><?= htmlspecialchars($user['role']); ?></td>
                            <td>
                                <!-- Tombol Edit -->
                                <a href="edit_user.php?id=<?= $user['id_user']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                
                                <!-- Tombol Hapus -->
                                <a href="hapus_user.php?id=<?= $user['id_user']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data pengguna yang ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
