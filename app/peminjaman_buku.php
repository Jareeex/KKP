<?php
session_start();

// Cek apakah pengguna sudah login, jika tidak, alihkan ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Panggil file koneksi
include 'koneksi/inc_koneksi.php';

// Query untuk mengambil data peminjaman buku
$sql = "SELECT * FROM peminjaman_buku";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Buku</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style_data.css">
    <link rel="stylesheet" href="css/style_buku.css">
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

        .btn-tambah {
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-tambah:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <h2>Peminjaman Buku</h2>
    <button onclick="loadData('tambah_peminjaman.php')" class="btn-tambah">Tambah Data</button>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Pinjam</th>
                <th>Nama</th>
                <th>NIM</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
                <th>Judul Buku</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            <?php
           if ($result->num_rows > 0) {
            $no = 1; // Inisialisasi nomor urut
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . $row['no_pinjam'] . "</td>";
                echo "<td>" . $row['nama'] . "</td>";
                echo "<td>" . $row['nim'] . "</td>";
                echo "<td>" . $row['tgl_pinjam'] . "</td>";
                echo "<td>" . $row['tgl_kembali'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "<td>" . $row['judul_buku'] . "</td>";
                echo "<td>";
                echo "<button onclick=\"loadData('edit_peminjaman.php?id=" . $row['id'] . "')\" class=\"btn-edit\">Edit</button>";
                echo "<a href='proses_pengembalian.php?id=" . $row['id'] . "' class='btn-hapus' onclick='return confirm(\"Apakah Anda yakin ingin menghapus peminjaman ini?\")'>Dikembalikan</a>"; // Tombol Dikembalikan
                if ($row['status'] === 'non-aktif') {
                    echo "<a href='peminjaman_aktif.php?id=" . $row['id'] . "' class='btn-aktifkan' onclick='return confirm(\"Apakah Anda yakin ingin mengaktifkan peminjaman ini?\")'>Aktifkan</a>";
                }
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>Tidak ada data peminjaman buku</td></tr>";
        }
        
            ?>
        </tbody>
    </table>
</body>

</html>

<?php
// Tutup koneksi database
$conn->close();
?>
