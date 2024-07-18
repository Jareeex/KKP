<?php
include 'koneksi/inc_koneksi.php'; // Menggunakan include dengan path relatif dari file data_rak.php

// Proses tambah rak buku
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id_rak'])) {
        // Proses edit rak buku
        $id_rak = $_POST['id_rak'];
        $nama_rak = $_POST['nama_rak'];

        $queryUpdate = "UPDATE rak_buku SET nama_rak = '$nama_rak' WHERE id = '$id_rak'";
        $resultUpdate = mysqli_query($conn, $queryUpdate);

        if ($resultUpdate) {
            header('Location: dashboard.php?page=kategori_buku'); // Redirect kembali ke halaman data_rak.php setelah berhasil edit
            exit;
        } else {
            echo "Gagal mengupdate data rak buku.";
        }
    } else {
        // Proses tambah rak buku
        $nama_rak = $_POST['nama_rak'];

        $queryTambah = "INSERT INTO rak_buku (nama_rak) VALUES ('$nama_rak')";
        $resultTambah = mysqli_query($conn, $queryTambah);

        if ($resultTambah) {
            header('Location: dashboard.php?page=kategori_buku'); // Redirect kembali ke halaman data_rak.php setelah berhasil tambah
            exit;
        } else {
            echo "Gagal menambahkan rak buku.";
        }
    }
}

// Mengambil data rak buku
$queryRak = "SELECT * FROM rak_buku";
$resultRak = mysqli_query($conn, $queryRak);
$numRows = mysqli_num_rows($resultRak); // Menghitung jumlah baris

// Tutup koneksi database
$conn->close();
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
    <title>Data Rak Buku</title>
    <h2>Data Kategori Buku</h2>
</head>

<body>
    <div class="container">
        <div class="input-rak">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <label for="nama_rak">Nama Rak:</label>
                <input type="text" id="nama_rak" name="nama_rak" required><br><br>
                <button type="submit" class="btn-tambah">Tambah Kategori</button>
            </form>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $counter = 1; // Variabel untuk nomor urut
                    while ($rowRak = mysqli_fetch_assoc($resultRak)) :
                    ?>
                        <tr>
                            <td><?php echo $counter; ?></td>
                            <td><?php echo htmlspecialchars($rowRak['nama_rak']); ?></td>
                            <td>
                            <button class="btn-edit" onclick="loadData('edit_kategori.php?id=<?php echo $rowRak['id']; ?>')">Edit</button>
                                <a href="hapus_kategori.php?id=<?php echo $rowRak['id']; ?>" class="btn-hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus rak ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php
                        $counter++; // Increment nomor urut setiap kali loop
                    endwhile;
                    ?>
                </tbody>
            </table>
        </div>
        <!-- Container untuk menampilkan data edit -->
        <div id="edit-data-container"></div>
    </div>

    <!-- Script untuk AJAX -->
    <script>
        function loadEditData(id) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("edit-data-container").innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "edit_kategori.php?id=" + id, true);
            xhttp.send();
        }
    </script>
</body>

</html>
