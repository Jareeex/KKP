<?php
session_start();
include 'koneksi/inc_koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Perpustakaan</title>

</head>

<body>
    <img src="img/SMP.jpg" alt="Library Image" style="width: 20%; height: auto; display: block; margin: 0 auto;">

    <div class="container">
        <div class="dashboard-icons">
            <a href="dashboard.php?page=data_siswa" class="icon-container" id="data-siswa-icon">
                <i class="fas fa-users"></i>
                <p>Data Siswa</p>
            </a>
            <a href="dashboard.php?page=daftar_buku" class="icon-container" id="daftar-buku-icon">
                <i class="fas fa-list"></i>
                <p>Daftar Buku</p>
            </a>
            <a href="dashboard.php?page=peminjaman_buku" class="icon-container" id="peminjaman-buku-icon">
                <i class="fas fa-book-reader"></i>
                <p>Peminjaman Buku</p>
            </a>
            <a href="dashboard.php?page=pengembalian_buku" class="icon-container" id="pengembalian-buku-icon">
                <i class="fas fa-undo-alt"></i>
                <p>Pengembalian Buku</p>
            </a>
        </div>
    </div>
</body>

</html>