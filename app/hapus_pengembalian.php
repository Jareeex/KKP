<?php
session_start();

// Cek apakah pengguna sudah login, jika tidak, alihkan ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Panggil file koneksi
include 'koneksi/inc_koneksi.php';

// Periksa apakah parameter ID telah diterima dari URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data pengembalian buku berdasarkan ID
    $sql = "DELETE FROM pengembalian_buku WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Data pengembalian berhasil dihapus.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "ID tidak valid.";
}

// Redirect kembali ke halaman pengembalian buku setelah menghapus data
header("Location: dashboard.php?page=pengembalian_buku");

// Tutup koneksi database
$conn->close();
?>
