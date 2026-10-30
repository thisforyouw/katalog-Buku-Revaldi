<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'db_katalog_buku';

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'id';
}

if (isset($_GET['set_lang'])) {
    $lang = $_GET['set_lang'];
    if (in_array($lang, ['id', 'en'])) {
        $_SESSION['lang'] = $lang;
    }
    $redirect = strtok($_SERVER["REQUEST_URI"], '?');
    header("Location: " . $redirect);
    exit;
}
?>