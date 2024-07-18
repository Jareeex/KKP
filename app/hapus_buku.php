<?php
include 'koneksi/inc_koneksi.php'; // Menggunakan include dengan path relatif dari file hapus_rak.php

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id_rak = $_GET['id'];

    $queryHapus = "DELETE FROM buku WHERE id = '$id_rak'";
    $resultHapus = mysqli_query($conn, $queryHapus);

    if ($resultHapus) {
        header('Location: dashboard.php?page=daftar_buku'); // Redirect kembali ke halaman data_rak.php setelah berhasil hapus
        exit;
    } else {
        echo "Gagal menghapus buku.";
    }
} else {
    echo "Permintaan tidak valid.";
}
?>
