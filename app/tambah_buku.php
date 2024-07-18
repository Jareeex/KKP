<?php
include 'koneksi/inc_koneksi.php'; // Include koneksi ke database

// Proses tambah buku
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $rak_id = $_POST['rak_id'];

    $queryTambah = "INSERT INTO buku (judul, pengarang, penerbit, tahun_terbit, rak_id) VALUES ('$judul', '$pengarang', '$penerbit', '$tahun_terbit', '$rak_id')";
    $resultTambah = mysqli_query($conn, $queryTambah);

    if ($resultTambah) {
        header('Location: dashboard.php?page=daftar_buku'); // Redirect ke halaman daftar buku setelah berhasil tambah
        exit;
    } else {
        echo "Gagal menambahkan buku.";
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
    <link rel="stylesheet" href="css/style_buku.css">
    <link rel="stylesheet" href="css/form.css">
    <title>Tambah Buku</title>
    <h2>Tambah Buku</h2>
</head>

<body>
    <div class="container">
        <div class="input-buku">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <label for="judul">Judul Buku:</label>
                <input type="text" id="judul" name="judul" required><br><br>
                <label for="pengarang">Pengarang:</label>
                <input type="text" id="pengarang" name="pengarang" required><br><br>
                <label for="penerbit">Penerbit:</label>
                <input type="text" id="penerbit" name="penerbit" required><br><br>
                <label for="tahun_terbit">Tahun Terbit:</label>
                <input type="number" id="tahun_terbit" name="tahun_terbit" required><br><br>
                <label for="rak_id">Rak Buku:</label>
                <select id="rak_id" name="rak_id" required>
                    <option value="" disabled selected>Pilih Rak Buku</option>
                    <?php
                    $queryRak = "SELECT * FROM rak_buku";
                    $resultRak = mysqli_query($conn, $queryRak);
                    while ($rowRak = mysqli_fetch_assoc($resultRak)) :
                    ?>
                        <option value="<?php echo $rowRak['id']; ?>"><?php echo $rowRak['nama_rak']; ?></option>
                    <?php endwhile; ?>
                </select><br><br>
                <button type="submit" class="btn-tambah">Tambah Buku</button>
            </form>
        </div>
    </div>
</body>

</html>
