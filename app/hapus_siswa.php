<?php
session_start();

// Cek apakah pengguna sudah login, jika tidak, alihkan ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Panggil file koneksi
include 'koneksi/inc_koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id_siswa = $_GET['id'];

    // Query untuk menghapus data siswa berdasarkan ID
    $sql = "DELETE FROM data_siswa WHERE id = $id_siswa";
    $result = $conn->query($sql);

    // Periksa apakah penghapusan berhasil
    if ($result) {
        header("Location: dashboard.php?page=data_siswa"); // Redirect kembali ke halaman data siswa setelah berhasil hapus
        exit;
    } else {
        echo "Gagal menghapus data siswa.";
    }
}

// Tutup koneksi database
$conn->close();
?>
