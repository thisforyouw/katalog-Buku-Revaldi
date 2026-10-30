<?php
require_once 'config.php';
require_once 'lang.php';

// Proteksi Session: Jika belum login, lempar kembali ke login.php
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Ambil seluruh data buku dari database
$query = "SELECT * FROM buku ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="<?= $lang_code ?>">
<head>
    <meta charset="UTF-8">
    <title><?= $txt['app_title'] ?></title>
    <!-- Versi CSS dinaikkan ke v=4 -->
    <link rel="stylesheet" href="style.css?v=4">
</head>
<body class="bg-dashboard">
    <div class="container">
        <div class="header">
            <h2><?= $txt['dashboard'] ?></h2>
            <div class="lang-switch">
                <a href="?set_lang=id">ID</a> | <a href="?set_lang=en">EN</a> | 
                <a href="logout.php" class="btn-logout"><?= $txt['logout'] ?></a>
            </div>
        </div>
        
        <p style="margin-top: 10px;">Selamat Datang, <b><?= htmlspecialchars($_SESSION['username']); ?></b>!</p>
        
        <a href="create.php" class="btn btn-add">+ <?= $txt['add_new'] ?></a>

        <table>
            <thead>
                <tr>
                    <th><?= $txt['isbn'] ?></th>
                    <th><?= $txt['judul'] ?></th>
                    <th><?= $txt['pengarang'] ?></th>
                    <th><?= $txt['penerbit'] ?></th>
                    <th><?= $txt['tahun'] ?></th>
                    <th><?= $txt['action'] ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['isbn']) ?></td>
                            <td><?= htmlspecialchars($row['judul']) ?></td>
                            <td><?= htmlspecialchars($row['pengarang']) ?></td>
                            <td><?= htmlspecialchars($row['penerbit']) ?></td>
                            <td><?= htmlspecialchars($row['tahun_terbit']) ?></td>
                            <td>
                                <a href="edit.php?id=<?= $row['id'] ?>" class="btn-sm btn-edit"><?= $txt['edit'] ?></a>
                                <a href="delete.php?id=<?= $row['id'] ?>" class="btn-sm btn-delete" onclick="return confirm('<?= $txt['confirm_delete'] ?>')"><?= $txt['delete'] ?></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center; color: #888; padding: 25px;">Belum Ada Data Buku</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>