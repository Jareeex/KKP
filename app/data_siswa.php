<?php
session_start();

// Cek apakah pengguna sudah login, jika tidak, alihkan ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Panggil file koneksi
include 'koneksi/inc_koneksi.php';

// Query untuk mengambil data siswa
$sql = "SELECT * FROM data_siswa";
$result = $conn->query($sql);
// Tutup koneksi database
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style_buku.css">
    <link rel="stylesheet" href="css/style_data.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Data Siswa</h2>
    <button onclick="loadData('tambah_siswa.php')" class="btn-tambah">Tambah Data</button>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>No. Telepon</th>
                <th>Alamat</th>
                <th>Action</th> <!-- Kolom untuk tombol edit dan hapus -->
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $no = 1; // Inisialisasi nomor urut
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . $row['nim'] . "</td>"; // Tambahkan kolom NIM
                    echo "<td>" . $row['nama'] . "</td>";
                    echo "<td>" . $row['jenis_kelamin'] . "</td>";
                    echo "<td>" . $row['no_telepon'] . "</td>";
                    echo "<td>" . $row['alamat'] . "</td>";
                    echo "<td>";
                    echo "<button onclick=\"loadData('edit_siswa.php?id=" . $row['id'] . "')\" class=\"btn-edit\">Edit</button>";
                    echo "<a href='hapus_siswa.php?id=" . $row['id'] . "' class='btn-hapus' onclick='return confirm(\"Apakah Anda yakin ingin menghapus siswa ini?\")'>Hapus</a>"; // Tombol Hapus
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Tidak ada data siswa</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>
