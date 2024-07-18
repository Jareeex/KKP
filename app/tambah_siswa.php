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
$error_nim = $error_nama = $error_jk = $error_telepon = $error_alamat = '';

// Proses form tambah data siswa
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $no_telepon = $_POST['no_telepon'];
    $alamat = $_POST['alamat'];

    // Validasi data
    if (empty($nim)) {
        $error_nim = "Nim siswa harus diisi";
    }

    if (empty($nama)) {
        $error_nama = "Nama siswa harus diisi";
    }

    if (empty($jenis_kelamin)) {
        $error_jk = "Jenis kelamin harus dipilih";
    }

    if (empty($no_telepon)) {
        $error_telepon = "Nomor telepon harus diisi";
    }

    if (empty($alamat)) {
        $error_alamat = "Alamat harus diisi";
    }

    // Jika tidak ada error, tambahkan data siswa ke database
    if (empty($error_nama) && empty($error_jk) && empty($error_telepon) && empty($error_alamat)) {
        $queryTambah = "INSERT INTO data_siswa (nim, nama, jenis_kelamin, no_telepon, alamat) VALUES ('$nim','$nama', '$jenis_kelamin', '$no_telepon', '$alamat')";
        $resultTambah = mysqli_query($conn, $queryTambah);

        if ($resultTambah) {
            header("Location: dashboard.php?page=data_siswa"); // Redirect kembali ke halaman data siswa setelah berhasil tambah
            exit;
        } else {
            echo "Gagal menambahkan data siswa.";
        }
    }
}

// Tutup koneksi database
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Siswa</title>
    <link rel="stylesheet" href="css/style_buku.css">
    <link rel="stylesheet" href="css/form.css">
</head>

<body>
    <h2>Tambah Data Siswa</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required>
            <span class="error"><?php echo $error_nama; ?></span>
        </div>
        <div class="form-group">
            <label for="nim">NIS:</label>
            <input type="text" id="nim" name="nim" required>
            <span class="error"><?php echo $error_nim; ?></span>
        </div>
        <div class="form-group">
            <label for="jenis_kelamin">Jenis Kelamin:</label>
            <select id="jenis_kelamin" name="jenis_kelamin" required>
                <option value="">Pilih Jenis Kelamin</option>
                <option value="laki-laki">Laki-laki</option>
                <option value="perempuan">Perempuan</option>
            </select>
            <span class="error"><?php echo $error_jk; ?></span>
        </div>
        <div class="form-group">
            <label for="no_telepon">No. Telepon:</label>
            <input type="text" id="no_telepon" name="no_telepon" required>
            <span class="error"><?php echo $error_telepon; ?></span>
        </div>
        <div class="form-group">
            <label for="alamat">Alamat:</label>
            <textarea id="alamat" name="alamat" required></textarea>
            <span class="error"><?php echo $error_alamat; ?></span>
        </div>
        <button type="submit" class="btn-submit">Tambah Data</button>
    </form>
</body>

</html>