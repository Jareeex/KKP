<?php
include 'koneksi/inc_koneksi.php'; // Include koneksi ke database

// Cek apakah pengguna sudah login, jika tidak, alihkan ke halaman login
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Proses update peminjaman
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $tgl_pinjam = $_POST['tgl_pinjam'];
    $tgl_kembali = $_POST['tgl_kembali'];

    $queryUpdate = "UPDATE peminjaman_buku SET tgl_pinjam = '$tgl_pinjam', tgl_kembali = '$tgl_kembali' WHERE id = '$id'";
    $resultUpdate = mysqli_query($conn, $queryUpdate);

    if ($resultUpdate) {
        header('Location:dashboard.php?page=peminjaman_buku'); // Redirect ke halaman data peminjaman setelah berhasil edit
        exit;
    } else {
        echo "Gagal mengupdate data peminjaman buku.";
    }
}

// Mendapatkan data peminjaman berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM peminjaman_buku WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result->num_rows > 0) {
        $data = mysqli_fetch_assoc($result);
    } else {
        echo "Data tidak ditemukan.";
        exit;
    }
} else {
    echo "ID tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Peminjaman Buku</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style_buku.css">
    <link rel="stylesheet" href="css/form.css">
</head>

<body>
    <h2>Edit Peminjaman Buku</h2>
    <form method="POST" action="edit_peminjaman.php">
        <div class="form-group">
            <label for="tgl_pinjam">Tanggal Pinjam:</label>
            <input type="date" id="tgl_pinjam" name="tgl_pinjam" value="<?php echo $data['tgl_pinjam']; ?>" required>
        </div>
        <div class="form-group">
            <label for="tgl_kembali">Tanggal Kembali:</label>
            <input type="date" id="tgl_kembali" name="tgl_kembali" value="<?php echo $data['tgl_kembali']; ?>" required>
        </div>
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
        <button type="submit" class="btn-submit">Update</button>
    </form>
</body>

</html>

<?php
// Tutup koneksi database
$conn->close();
?>
