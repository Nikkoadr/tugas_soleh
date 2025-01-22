<?php
include 'db.php';

// Ambil ID dari URL
$id = $_GET['id'] ?? 0;
$nama_fakultas = '';

// Ambil data fakultas berdasarkan ID
if ($id) {
    $result = $conn->query("SELECT * FROM fakultas WHERE id_fakultas = $id");
    $data = $result->fetch_assoc();
    $nama_fakultas = $data['nama_fakultas'];
}

// Proses Update Fakultas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_fakultas = $_POST['nama_fakultas'];
    $sql = "UPDATE fakultas SET nama_fakultas = '$nama_fakultas' WHERE id_fakultas = $id";
    if ($conn->query($sql)) {
        header("Location: fakultas.php");
        exit();
    } else {
        echo "Gagal mengupdate data: " . $conn->error;
    }
}

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Fakultas</title>
</head>
<body>
    <h3>Edit Fakultas</h3>
    <form method="POST" action="">
        <label for="nama_fakultas">Nama Fakultas:</label>
        <input type="text" id="nama_fakultas" name="nama_fakultas" value="<?= htmlspecialchars($nama_fakultas); ?>" required>
        <button type="submit">Update</button>
    </form>
    <a href="fakultas.php">Kembali</a>
</body>
</html>
