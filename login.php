<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';
require_once 'lang.php';

if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Peringatan: Username dan Password tidak boleh kosong!";
    } else {
        $stmt = mysqli_prepare($conn, "SELECT id, password FROM users WHERE username = ?");
        
        if (!$stmt) {
            die("Query SQL Error: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
            // Menerima password hash (BCRYPT) ATAU password teks biasa dari phpMyAdmin
            if (password_verify($password, $user['password']) || $password === $user['password']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $username;
                
                // Redirect langsung
                header("Location: index.php");
                exit;
            } else {
                $error = "Password yang kamu masukkan SALAH!";
            }
        } else {
            $error = "Username '$username' TIDAK DITEMUKAN di database!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login System</title>
    <!-- Versi CSS dinaikkan ke v=4 -->
    <link rel="stylesheet" href="style.css?v=4">
</head>
<body class="bg-login">
    <div class="card-center">
        <h2>Sistem Informasi Katalog Buku Perpustakaan Sinar Kata</h2>
        
        <!-- Notifikasi Error/Peringatan -->
        <?php if (!empty($error)): ?>
            <div class="alert">
                <strong>Gagal:</strong> <?= $error ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn" style="width: 100%;">Masuk</button>
        </form>
    </div>
</body>
</html>