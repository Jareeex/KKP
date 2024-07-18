<?php
session_start();

// Cek apakah pengguna sudah login, jika tidak, alihkan ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Panggil file koneksi
include 'koneksi/inc_koneksi.php';

// Query untuk mengambil data pengembalian buku
$sql = "SELECT * FROM pengembalian_buku";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengembalian Buku</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style_data.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        .btn-hapus {
            background-color: #f44336;
            color: white;
            padding: 6px 12px;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-hapus:hover {
            background-color: #d32f2f;
        }
    </style>
</head>

<body>
    <h2>Pengembalian Buku</h2>
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
                <th>Denda</th>
                <th>Kembali</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $no = 1;
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
                    echo "<td>Rp. " . number_format($row['denda'], 0, ',', '.') . "</td>";
                    echo "<td>" . $row['kembali'] . "</td>";
                    

                    // Perbarui kolom "Kembali" dengan tanggal saat ini jika belum dikembalikan
                    if (!$row['kembali']) {
                        echo "<td>" . date('Y-m-d') . "</td>"; // Tampilkan tanggal saat ini
                    }

                    echo "<td><a href='edit_pengembalian.php?id=" . $row['id'] . "' class='btn-edit'></a>";
                    echo "<a href='hapus_pengembalian.php?id=" . $row['id'] . "' class='btn-hapus' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data pengembalian ini?\")'>Hapus</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='11'>Tidak ada data pengembalian buku</td></tr>";
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