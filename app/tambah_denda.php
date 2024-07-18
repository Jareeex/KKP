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
$error_harga = '';

// Proses form tambah kategori denda
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $harga_denda = $_POST['harga_denda'];
    $status = $_POST['status'];

    // Validasi data
    if (empty($harga_denda) || !is_numeric($harga_denda)) {
        $error_harga = "Harga denda harus diisi dengan angka";
    }

    // Jika tidak ada error, tambahkan kategori denda ke database
    if (empty($error_harga)) {
        $queryTambah = "INSERT INTO kategori_denda (harga_denda, status) VALUES ('$harga_denda', '$status')";
        $resultTambah = mysqli_query($conn, $queryTambah);

        if ($resultTambah) {
            header("Location: dashboard.php?page=kategori_denda"); // Redirect kembali ke halaman kategori denda setelah berhasil tambah
            exit;
        } else {
            echo "Gagal menambahkan kategori denda.";
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
    <title>Tambah Kategori Denda</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style_buku.css">
    <link rel="stylesheet" href="css/form.css">
</head>

<body>
    <h2>Tambah Kategori Denda</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="form-group">
            <label for="harga_denda">Harga Denda:</label>
            <input type="text" id="harga_denda" name="harga_denda" required>
            <span class="error"><?php echo $error_harga; ?></span>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="aktif">Aktif</option>
                <option value="non-aktif">Non-Aktif</option>
            </select>
        </div>
        <button type="submit" class="btn-submit">Tambah Kategori</button>
    </form>
</body>

</html>
