<?php
session_start();

// Cek apakah pengguna sudah login, jika tidak, alihkan ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Panggil file koneksi
include 'koneksi/inc_koneksi.php';

// Periksa apakah id siswa telah diberikan melalui parameter GET
if (isset($_GET['id'])) {
    $id_siswa = $_GET['id'];

    // Query untuk mengambil data siswa berdasarkan id
    $sql = "SELECT * FROM data_siswa WHERE id = '$id_siswa'";
    $result = $conn->query($sql);

    // Jika data siswa ditemukan
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nim = $row['nim'];
        $nama = $row['nama'];
        $jenis_kelamin = $row['jenis_kelamin'];
        $no_telepon = $row['no_telepon'];
        $alamat = $row['alamat'];
    } else {
        echo "Data siswa tidak ditemukan.";
        exit;
    }
} else {
    echo "ID siswa tidak diberikan.";
    exit;
}

// Proses penyimpanan perubahan data siswa
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_siswa = $_POST['id_siswa'];
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $no_telepon = $_POST['no_telepon'];
    $alamat = $_POST['alamat'];

    // Query untuk mengupdate data siswa
    $sql = "UPDATE data_siswa SET  nim='$nim',nama='$nama', jenis_kelamin='$jenis_kelamin', no_telepon='$no_telepon', alamat='$alamat' WHERE id='$id_siswa'";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php?page=data_siswa");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
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
    <title>Edit Data Siswa</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style_buku.css">
    <link rel="stylesheet" href="css/form.css">
</head>

<body>
    <h2>Edit Data Siswa</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $id_siswa; ?>" method="POST">
        <input type="hidden" name="id_siswa" value="<?php echo $id_siswa; ?>">
        <div class="form-group">
            <label for="nim">Nim:</label>
            <input type="text" id="nim" name="nim" value="<?php echo $nim; ?>" required>
        </div>
        <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" value="<?php echo $nama; ?>" required>
        </div>
        <div class="form-group">
            <label for="jenis_kelamin">Jenis Kelamin:</label>
            <select id="jenis_kelamin" name="jenis_kelamin" required>
                <option value="L" <?php if ($jenis_kelamin == 'L') echo 'selected'; ?>>Laki-laki</option>
                <option value="P" <?php if ($jenis_kelamin == 'P') echo 'selected'; ?>>Perempuan</option>
            </select>
        </div>
        <div class="form-group">
            <label for="no_telepon">No. Telepon:</label>
            <input type="text" id="no_telepon" name="no_telepon" value="<?php echo $no_telepon; ?>" required>
        </div>
        <div class="form-group">
            <label for="alamat">Alamat:</label>
            <textarea id="alamat" name="alamat" required><?php echo $alamat; ?></textarea>
        </div>
        <button type="submit" class="btn-submit">Simpan Perubahan</button>
    </form>
</body>

</html>
