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
    <div class="header">
        <h1>Aplikasi Peminjaman Buku Perpustakaan</h1>
        <h1>SMPN 07 Depok</h1>
        <?php if (isset($_SESSION['username'])) : ?>
            <p>Selamat datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        <?php endif; ?>
    </div>
    <div class="container">
        <div class="menu">
            <a href="dashboard.php?page=dashboard_spk"><i class="fas fa-users"></i> Dashboard</a>
            <a href="dashboard.php?page=data_siswa"><i class="fas fa-users"></i> Data Siswa</a>
            <a href="dashboard.php?page=daftar_buku"><i class="fas fa-list"></i> Daftar Buku</a>
            <a href="#" id="buku-link"><i class="fas fa-book"></i> Kelola Buku</a>
            <div class="submenu" id="buku-submenu">
                <a href="dashboard.php?page=tambah_buku"><i class="fas fa-plus"></i> Tambah Buku</a>
                <a href="dashboard.php?page=kategori_buku"><i class="fas fa-search"></i> Kategori Buku</a>
            </div>
            <a href="#" id="transaksi-link"><i class="fas fa-book"></i> Riwayat Buku</a>
            <div class="submenu" id="transaksi-submenu">
                <a href="dashboard.php?page=peminjaman_buku"><i class="fas fa-book-reader"></i> Peminjaman</a>
                <a href="dashboard.php?page=pengembalian_buku"><i class="fas fa-undo-alt"></i> Pengembalian</a>
            </div>
            <a href="dashboard.php?page=kategori_denda"><i class="fas fa-undo-alt"></i> Kategori Denda</a>
            <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
        <div id="content" class="content">

            <!-- Konten dari tambah_buku.php atau konten lainnya akan dimuat di sini -->
        </div>
    </div>
    <div class="footer">
        <p>&copy; 2024 Perpustakaan</p>
    </div>

    <script>
        document.getElementById('buku-link').addEventListener('click', function(event) {
            event.preventDefault();
            var submenu = document.getElementById('buku-submenu');
            submenu.classList.toggle('visible');
        });

        document.getElementById('transaksi-link').addEventListener('click', function(event) {
            event.preventDefault();
            var submenu = document.getElementById('transaksi-submenu');
            submenu.classList.toggle('visible');
        });

        function loadData(url) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("content").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", url, true);
            xhttp.send();
        }

        function filterBuku() {
            var selectedRak = document.getElementById('rak').value;
            var bukuList = document.getElementById('buku-list').getElementsByTagName('tr');

            for (var i = 0; i < bukuList.length; i++) {
                var dataRak = bukuList[i].getAttribute('data-rak');
                if (selectedRak === 'all' || selectedRak === dataRak) {
                    bukuList[i].style.display = '';
                } else {
                    bukuList[i].style.display = 'none';
                }
            }
        }

        // Fungsi untuk memperbarui tanggal Kembali secara otomatis saat tanggal berubah
        function updateKembaliDate(inputId) {
            var inputTanggal = document.getElementById(inputId);
            var currentDate = new Date().toISOString().slice(0, 10); // Mendapatkan tanggal saat ini dalam format YYYY-MM-DD
            inputTanggal.value = currentDate;
        }

        // Panggil fungsi updateKembaliDate saat halaman dimuat
        window.onload = function() {
            // Ganti 'tgl_kembali_input' dengan ID input tanggal Kembali pada tabel Anda
            updateKembaliDate('kembali');
        }


        window.onload = function() {
            const params = new URLSearchParams(window.location.search);
            const page = params.get('page');

            if (page === 'tambah_buku') {
                loadData('tambah_buku.php');
            } else if (page === 'kategori_buku') {
                loadData('kategori_buku.php');
            } else if (page === 'daftar_buku') {
                loadData('daftar_buku.php');
            } else if (page === 'peminjaman_buku') {
                loadData('peminjaman_buku.php');
            } else if (page === 'pengembalian_buku') {
                loadData('pengembalian_buku.php');
            } else if (page === 'data_siswa') {
                loadData('data_siswa.php');
            } else if (page === 'kategori_denda') {
                loadData('kategori_denda.php');
            } else if (page === 'dashboard_spk') {
                loadData('dashboard_spk.php');
            }

        }
    </script>
</body>

</html>