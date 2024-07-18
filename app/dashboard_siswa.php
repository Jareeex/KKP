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
<h1>tes</h1>
<body>
    <div class="header">
        <h1>Aplikasi Peminjaman Buku Perpustakaan</h1>
        <h1>SMPN 07 Depok</h1>
        <?php if (isset($_SESSION['username'])) : ?>
            <p>Selamat datang, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
        <?php endif; ?>
    </div>
    <h1>tes</h1>
    <div class="container">
        <div class="menu">
            <a href="dashboard_siswa.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            <a href="dashboard_siswa.php?page=data_diri"><i class="fas fa-users"></i> Data Diri</a>
            <a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
        <div id="content" class="content">
            <!-- Konten akan dimuat di sini -->
        </div>
    </div>
    <div class="footer">
        <p>&copy; 2024 Perpustakaan</p>
    </div>

    <script>
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

        window.onload = function() {
            const params = new URLSearchParams(window.location.search);
            const page = params.get('page');

            if (page === 'data_diri') {
                loadData('data_diri.php');
            } else {
                loadData('dashboard_default.php'); // Halaman default ketika pertama kali diakses
            }
        }
    </script>
</body>

</html>
