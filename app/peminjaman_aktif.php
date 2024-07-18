<?php
session_start();
include 'koneksi/inc_koneksi.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Ambil ID peminjaman dari URL
$id = $_GET['id'];

// Perbarui status peminjaman menjadi "aktif"
$query = "UPDATE peminjaman_buku SET status='aktif' WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Redirect kembali ke halaman peminjaman buku setelah berhasil memperbarui status
    header("Location: dashboard.php?page=peminjaman_buku");
    exit;
} else {
    echo "Gagal mengaktifkan peminjaman.";
}

// Tutup koneksi
$stmt->close();
$conn->close();
?>
