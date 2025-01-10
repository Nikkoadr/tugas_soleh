<?php
session_start(); // Memulai session untuk menyimpan login status

// Koneksi ke database
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek apakah username dan password sesuai dengan yang ada di database
    $stmt = $pdo->prepare("SELECT * FROM Users WHERE username = :username AND password = :password");
    $stmt->execute(['username' => $username, 'password' => $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Jika login berhasil, simpan user id dan role dalam session
        $_SESSION['user_id'] = $user['id_user'];
        $_SESSION['role'] = $user['role']; // Simpan role pengguna (mahasiswa/dosen)
        header("Location: index.php"); // Redirect ke halaman index setelah login
        exit();
    } else {
        // Jika login gagal, tampilkan pesan error
        $error_message = 'Username atau Password salah!';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($error_message)) { echo "<p style='color:red;'>$error_message</p>"; } ?>
    <form method="POST" action="login.php">
        <label>Username:</label>
        <input type="text" name="username" required><br><br>
        <label>Password:</label>
        <input type="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
