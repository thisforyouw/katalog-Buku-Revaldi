<?php
require_once 'config.php';
require_once 'lang.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$error = '';

$stmt = mysqli_prepare($conn, "SELECT * FROM buku WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$data) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isbn         = htmlspecialchars(trim($_POST['isbn']));
    $judul        = htmlspecialchars(trim($_POST['judul']));
    $pengarang    = htmlspecialchars(trim($_POST['pengarang']));
    $penerbit     = htmlspecialchars(trim($_POST['penerbit']));
    $tahun_terbit = htmlspecialchars(trim($_POST['tahun_terbit']));

    if (empty($isbn) || empty($judul) || empty($pengarang) || empty($penerbit) || empty($tahun_terbit)) {
        $error = $txt['err_empty'];
    } elseif (!is_numeric($tahun_terbit)) {
        $error = $txt['err_tahun'];
    } else {
        // Cek apakah ISBN dipunyai oleh BUKU LAIN (id != $id saat ini)
        $check_stmt = mysqli_prepare($conn, "SELECT id FROM buku WHERE isbn = ? AND id != ?");
        mysqli_stmt_bind_param($check_stmt, "si", $isbn, $id);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);

        if (mysqli_stmt_num_rows($check_stmt) > 0) {
            $error = "ISBN '$isbn' sudah dipakai oleh buku lain! Silakan gunakan ISBN lain.";
        } else {
            // Update data jika ISBN aman
            $update_stmt = mysqli_prepare($conn, "UPDATE buku SET isbn = ?, judul = ?, pengarang = ?, penerbit = ?, tahun_terbit = ? WHERE id = ?");
            mysqli_stmt_bind_param($update_stmt, "ssssii", $isbn, $judul, $pengarang, $penerbit, $tahun_terbit, $id);
            
            if (mysqli_stmt_execute($update_stmt)) {
                header("Location: index.php");
                exit;
            } else {
                $error = "Error saat memperbarui data!";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $lang_code ?>">
<head>
    <meta charset="UTF-8">
    <title><?= $txt['edit'] ?></title>
    <link rel="stylesheet" href="style.css?v=4">
</head>
<body class="bg-dashboard">
    <div class="card-center">
        <h2><?= $txt['edit'] ?></h2>
        
        <?php if ($error): ?>
            <div class="alert"><?= $error ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label><?= $txt['isbn'] ?></label>
                <input type="text" name="isbn" value="<?= htmlspecialchars($_POST['isbn'] ?? $data['isbn']) ?>" required>
            </div>
            <div class="form-group">
                <label><?= $txt['judul'] ?></label>
                <input type="text" name="judul" value="<?= htmlspecialchars($_POST['judul'] ?? $data['judul']) ?>" required>
            </div>
            <div class="form-group">
                <label><?= $txt['pengarang'] ?></label>
                <input type="text" name="pengarang" value="<?= htmlspecialchars($_POST['pengarang'] ?? $data['pengarang']) ?>" required>
            </div>
            <div class="form-group">
                <label><?= $txt['penerbit'] ?></label>
                <input type="text" name="penerbit" value="<?= htmlspecialchars($_POST['penerbit'] ?? $data['penerbit']) ?>" required>
            </div>
            <div class="form-group">
                <label><?= $txt['tahun'] ?></label>
                <input type="number" name="tahun_terbit" value="<?= htmlspecialchars($_POST['tahun_terbit'] ?? $data['tahun_terbit']) ?>" required>
            </div>
            
            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button type="submit" class="btn" style="flex: 1;"><?= $txt['update'] ?></button>
                <a href="index.php" class="btn btn-delete" style="flex: 1; text-align: center; text-decoration: none; display: inline-block; line-height: 20px;"><?= $txt['back'] ?></a>
            </div>
        </form>
    </div>
</body>
</html>