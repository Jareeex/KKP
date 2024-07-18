<?php
include 'koneksi/inc_koneksi.php'; // Include koneksi ke database

// Cek apakah pengguna sudah login, jika tidak, alihkan ke halaman login
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Proses edit kategori
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_rak'])) {
    $id_rak = $_POST['id_rak'];
    $nama_rak = $_POST['nama_rak'];

    $queryUpdate = "UPDATE rak_buku SET nama_rak = '$nama_rak' WHERE id = '$id_rak'";
    $resultUpdate = mysqli_query($conn, $queryUpdate);

    if ($resultUpdate) {
        header('Location: dashboard.php?page=kategori_buku'); // Redirect ke halaman data rak setelah berhasil edit
        exit;
    } else {
        echo "Gagal mengupdate data rak buku.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/style_buku.css">
    <title>Edit Kategori Buku</title>
    <h2>Edit Kategori Buku</h2>
</head>

<body>
    <div class="container">
        <div class="input-rak">
            <?php
            if (isset($_GET['id'])) {
                $id_rak = $_GET['id'];
                $queryDetailRak = "SELECT * FROM rak_buku WHERE id = '$id_rak'";
                $resultDetailRak = mysqli_query($conn, $queryDetailRak);
                $rowDetailRak = mysqli_fetch_assoc($resultDetailRak);
                if ($rowDetailRak) {
            ?>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <input type="hidden" name="id_rak" value="<?php echo $rowDetailRak['id']; ?>">
                        <label for="nama_rak">Nama Rak:</label>
                        <input type="text" id="nama_rak" name="nama_rak" value="<?php echo htmlspecialchars($rowDetailRak['nama_rak']); ?>" required><br><br>
                        <button type="submit" class="btn-tambah">Update Kategori</button>
                    </form>
            <?php
                } else {
                    echo "Data rak buku tidak ditemukan.";
                }
            } else {
                echo "ID rak tidak ditemukan.";
            }
            ?>
        </div>
    </div>
</body>

</html>
