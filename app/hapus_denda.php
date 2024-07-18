<?php
session_start();
include 'koneksi/inc_koneksi.php'; // Menggunakan include dengan path relatif dari file koneksi

// Proses hapus kategori denda
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $queryDelete = "DELETE FROM kategori_denda WHERE id = '$id'";
    $resultDelete = mysqli_query($conn, $queryDelete);

    if ($resultDelete) {
        header('Location: kategori_denda.php'); // Redirect ke halaman data kategori denda setelah berhasil hapus
        exit;
    } else {
        echo "Gagal menghapus data kategori denda.";
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
    <title>Hapus Kategori Denda</title>
</head>

<body>
    <h2>Hapus Kategori Denda</h2>
</body>

</html>

<?php
// Tutup koneksi database
$conn->close();
?>
