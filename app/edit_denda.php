<?php
session_start();
include 'koneksi/inc_koneksi.php'; // Menggunakan include dengan path relatif dari file koneksi

// Proses update kategori denda
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $harga_denda = $_POST['harga_denda'];
    $status = $_POST['status'];

    $queryUpdate = "UPDATE kategori_denda SET harga_denda = '$harga_denda', status = '$status' WHERE id = '$id'";
    $resultUpdate = mysqli_query($conn, $queryUpdate);

    if ($resultUpdate) {
        header('Location: dashboard.php?page=kategori_denda'); // Redirect ke halaman data kategori denda setelah berhasil edit
        exit;
    } else {
        echo "Gagal mengupdate data kategori denda.";
    }
}

// Mendapatkan data kategori denda berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM kategori_denda WHERE id = '$id'";
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
    <title>Edit Kategori Denda</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style_buku.css">
    <link rel="stylesheet" href="css/style_data.css">
    <style>
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .btn-submit {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-submit:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <h2>Edit Kategori Denda</h2>
    <form method="POST" action="edit_denda.php">
        <div class="form-group">
            <label for="harga_denda">Harga Denda:</label>
            <input type="number" id="harga_denda" name="harga_denda" value="<?php echo $data['harga_denda']; ?>" required>
        </div>
        <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="aktif" <?php echo ($data['status'] == 'aktif') ? 'selected' : ''; ?>>Aktif</option>
                <option value="non-aktif" <?php echo ($data['status'] == 'non-aktif') ? 'selected' : ''; ?>>Non-Aktif</option>
            </select>
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
