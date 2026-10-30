<?php
require_once 'config.php';

$translations = [
    'id' => [
        'app_title' => 'Katalog Buku Perpustakaan',
        'login_title' => 'Masuk Sistem Katalog',
        'username' => 'Nama Pengguna',
        'password' => 'Kata Sandi',
        'login_btn' => 'Masuk',
        'logout' => 'Keluar',
        'dashboard' => 'Daftar Katalog Buku',
        'add_new' => 'Tambah Buku Baru',
        'isbn' => 'ISBN',
        'judul' => 'Judul Buku',
        'pengarang' => 'Pengarang',
        'penerbit' => 'Penerbit',
        'tahun' => 'Tahun Terbit',
        'action' => 'Aksi',
        'edit' => 'Ubah',
        'delete' => 'Hapus',
        'save' => 'Simpan',
        'update' => 'Perbarui',
        'back' => 'Kembali',
        'confirm_delete' => 'Yakin ingin menghapus buku ini?',
        'err_empty' => 'Semua kolom wajib diisi!',
        'err_tahun' => 'Tahun terbit harus berupa angka!',
        'err_login' => 'Username atau password salah!'
    ],
    'en' => [
        'app_title' => 'Book Catalog System',
        'login_title' => 'Catalog System Login',
        'username' => 'Username',
        'password' => 'Password',
        'login_btn' => 'Login',
        'logout' => 'Logout',
        'dashboard' => 'Book Catalog List',
        'add_new' => 'Add New Book',
        'isbn' => 'ISBN',
        'judul' => 'Book Title',
        'pengarang' => 'Author',
        'penerbit' => 'Publisher',
        'tahun' => 'Year',
        'action' => 'Action',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'save' => 'Save',
        'update' => 'Update',
        'back' => 'Back',
        'confirm_delete' => 'Are you sure you want to delete this book?',
        'err_empty' => 'All fields are required!',
        'err_tahun' => 'Year must be a number!',
        'err_login' => 'Invalid username or password!'
    ]
];

$lang_code = $_SESSION['lang'];
$txt = $translations[$lang_code];
?>