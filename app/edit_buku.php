<?php
include 'koneksi/inc_koneksi.php'; // Menggunakan include dengan path relatif dari file edit_buku.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data yang dikirimkan melalui form
    $id_buku = $_POST['id_buku'];
    $judul = $_POST['judul'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $rak_id = $_POST['rak_id'];

    // Query untuk mengupdate data buku berdasarkan ID
    $update_query = "UPDATE buku SET judul='$judul', pengarang='$pengarang', penerbit='$penerbit', tahun_terbit='$tahun_terbit', rak_id='$rak_id' WHERE id='$id_buku'";

    try {
        // Lakukan query update
        $update_result = mysqli_query($conn, $update_query);

        // Periksa apakah proses update berhasil
        if ($update_result) {
            // Redirect kembali ke halaman daftar_buku.php setelah berhasil diupdate
            header("Location: dashboard.php?page=daftar_buku");
            exit;
        } else {
            throw new Exception("Gagal mengupdate data buku.");
        }
    } catch (Exception $e) {
        // Tangani kesalahan dengan menampilkan pesan error
        echo "<script>alert('" . $e->getMessage() . "');</script>";
        echo "<script>window.location='edit_buku.php?id=$id_buku';</script>";
        exit;
    }
} else {
    // Periksa apakah ada parameter ID buku yang dikirim melalui URL
    if (isset($_GET['id'])) {
        $id_buku = $_GET['id'];

        // Query untuk mendapatkan data buku berdasarkan ID
        $queryBuku = "SELECT * FROM buku WHERE id='$id_buku'";
        $resultBuku = mysqli_query($conn, $queryBuku);

        // Periksa apakah buku dengan ID tersebut ada dalam database
        if (mysqli_num_rows($resultBuku) > 0) {
            $rowBuku = mysqli_fetch_assoc($resultBuku);
        } else {
            // Redirect atau tampilkan pesan error jika buku tidak ditemukan
            echo "<script>alert('Buku tidak ditemukan.');</script>";
            echo "<script>window.location='daftar_buku.php';</script>";
            exit;
        }
    } else {
        // Redirect atau tampilkan pesan error jika parameter ID tidak ada
        echo "<script>alert('ID buku tidak ditemukan.');</script>";
        echo "<script>window.location='daftar_buku.php';</script>";
        exit;
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
    <title><?php echo isset($rowBuku) ? 'Edit Buku' : 'Tambah Buku'; ?></title>
    <h2><?php echo isset($rowBuku) ? 'Edit Buku' : 'Tambah Buku'; ?></h2>
</head>

<body>
    <div class="container">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <?php if (isset($rowBuku)) : ?>
                <input type="hidden" name="id_buku" value="<?php echo $rowBuku['id']; ?>">
            <?php endif; ?>
            <label for="judul">Judul:</label>
            <input type="text" id="judul" name="judul" value="<?php echo isset($rowBuku) ? htmlspecialchars($rowBuku['judul']) : ''; ?>" required>
            <label for="pengarang">Pengarang:</label>
            <input type="text" id="pengarang" name="pengarang" value="<?php echo isset($rowBuku) ? htmlspecialchars($rowBuku['pengarang']) : ''; ?>" required>
            <label for="penerbit">Penerbit:</label>
            <input type="text" id="penerbit" name="penerbit" value="<?php echo isset($rowBuku) ? htmlspecialchars($rowBuku['penerbit']) : ''; ?>" required>
            <label for="tahun_terbit">Tahun Terbit:</label>
            <input type="number" id="tahun_terbit" name="tahun_terbit" value="<?php echo isset($rowBuku) ? htmlspecialchars($rowBuku['tahun_terbit']) : ''; ?>" required>
            <label for="rak_id">Rak Buku:</label>
            <select id="rak_id" name="rak_id" required>
                <?php
                $queryRak = "SELECT * FROM rak_buku";
                $resultRak = mysqli_query($conn, $queryRak);
                while ($rowRak = mysqli_fetch_assoc($resultRak)) :
                    $selected = ($rowRak['id'] == $rowBuku['rak_id']) ? 'selected' : '';
                ?> <option value="<?php echo $rowRak['id']; ?>" <?php echo $selected; ?>><?php echo $rowRak['nama_rak']; ?></option>
                <?php endwhile; ?>
            </select>
            <button type="submit" class="btn-submit">Simpan Perubahan</button>
        </form>
    </div>
</body>

</html>