<?php
session_start();

// Cek apakah pengguna sudah login, jika tidak, alihkan ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Panggil file koneksi
include 'koneksi/inc_koneksi.php';

// Inisialisasi variabel untuk menampung pesan kesalahan
$error_nama = $error_tgl_pinjam = $error_tgl_kembali = $error_judul_buku = '';

// Proses form tambah peminjaman buku
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama']; // Nama dari data siswa
    $tgl_pinjam = $_POST['tgl_pinjam'];
    $tgl_kembali = $_POST['tgl_kembali'];
    $judul_buku = $_POST['judul_buku'];
    $status = 'non-aktif'; // Status diatur otomatis menjadi 'non_aktif'

    // Validasi data
    if (empty($nama)) {
        $error_nama = "Nama harus dipilih";
    }

    if (empty($tgl_pinjam)) {
        $error_tgl_pinjam = "Tanggal Pinjam harus diisi";
    }

    if (empty($tgl_kembali)) {
        $error_tgl_kembali = "Tanggal Kembali harus diisi";
    }

    if (empty($judul_buku)) {
        $error_judul_buku = "Judul Buku harus dipilih";
    }

    // Jika tidak ada error, tambahkan data peminjaman ke database
    if (empty($error_nama) && empty($error_tgl_pinjam) && empty($error_tgl_kembali) && empty($error_judul_buku)) {
        // Ambil NIM berdasarkan nama yang dipilih
        $queryNamaSiswa = "SELECT nim FROM data_siswa WHERE nama = '$nama'";
        $resultNamaSiswa = $conn->query($queryNamaSiswa);
        if ($resultNamaSiswa->num_rows > 0) {
            $rowSiswa = $resultNamaSiswa->fetch_assoc();
            $nim = $rowSiswa['nim']; // Ambil NIM dari data siswa

            // Generate nomor pinjam
            $queryNoPinjam = "SELECT MAX(no_pinjam) AS max_no_pinjam FROM peminjaman_buku";
            $resultNoPinjam = $conn->query($queryNoPinjam);
            $rowNoPinjam = $resultNoPinjam->fetch_assoc();
            $maxNoPinjam = $rowNoPinjam['max_no_pinjam'];
            $nextNoPinjam = 'P001';

            if ($maxNoPinjam) {
                $maxNoPinjamNumber = (int)substr($maxNoPinjam, 1);
                $nextNoPinjamNumber = $maxNoPinjamNumber + 1;
                $nextNoPinjam = 'P' . str_pad($nextNoPinjamNumber, 3, '0', STR_PAD_LEFT);
            }

            // Simpan data peminjaman ke database
            $queryTambah = "INSERT INTO peminjaman_buku (no_pinjam, nama, nim, tgl_pinjam, tgl_kembali, status, judul_buku) 
                            VALUES ('$nextNoPinjam', '$nama', '$nim', '$tgl_pinjam', '$tgl_kembali', '$status', '$judul_buku')";
            $resultTambah = $conn->query($queryTambah);

            if ($resultTambah) {
                header("Location: dashboard.php?page=peminjaman_buku"); // Redirect kembali ke halaman peminjaman buku setelah berhasil tambah
                exit;
            } else {
                echo "Gagal menambahkan data peminjaman buku.";
            }
        } else {
            $error_nama = "Nama siswa tidak valid";
        }
    }
}

// Ambil daftar nama siswa
$querySiswa = "SELECT nama FROM data_siswa";
$resultSiswa = $conn->query($querySiswa);

// Ambil daftar judul buku
$queryBuku = "SELECT judul FROM buku";
$resultBuku = $conn->query($queryBuku);

// Tutup koneksi database
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Peminjaman Buku</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/form.css">
</head>

<body>
    <h2>Tambah Peminjaman Buku</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="form-group">
            <label for="nama">Nama:</label>
            <select id="nama" name="nama" required>
                <option value="">Pilih Nama Siswa</option>
                <?php
                while ($rowSiswa = $resultSiswa->fetch_assoc()) :
                ?>
                    <option value="<?php echo $rowSiswa['nama']; ?>"><?php echo $rowSiswa['nama']; ?></option>
                <?php endwhile; ?>
            </select>
            <span class="error"><?php echo $error_nama; ?></span>
        </div>
        <div class="form-group">
            <label for="tgl_pinjam">Tanggal Pinjam:</label>
            <input type="date" id="tgl_pinjam" name="tgl_pinjam" required>
            <span class="error"><?php echo $error_tgl_pinjam; ?></span>
        </div>
        <div class="form-group">
            <label for="tgl_kembali">Tanggal Kembali:</label>
            <input type="date" id="tgl_kembali" name="tgl_kembali" required>
            <span class="error"><?php echo $error_tgl_kembali; ?></span>
        </div>
        <div class="form-group">
            <label for="judul_buku">Judul Buku:</label>
            <select id="judul_buku" name="judul_buku" required>
                <option value="">Pilih Judul Buku</option>
                <?php
                while ($rowBuku = $resultBuku->fetch_assoc()) :
                ?>
                    <option value="<?php echo $rowBuku['judul']; ?>"><?php echo $rowBuku['judul']; ?></option>
                <?php endwhile; ?>
            </select>
            <span class="error"><?php echo $error_judul_buku; ?></span>
        </div>
        <button type="submit" class="btn-submit">Tambah Data</button>
    </form>
</body>

</html>
