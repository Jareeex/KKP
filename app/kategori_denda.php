<?php
session_start();
include 'koneksi/inc_koneksi.php'; // Menggunakan include dengan path relatif dari file koneksi

// Query untuk mengambil data kategori denda
$sql = "SELECT * FROM kategori_denda";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Denda</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style_buku.css">
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

        .status-aktif {
            color: green;
        }

        .status-non-aktif {
            color: red;
        }

        .catatan-denda {
            margin-top: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <h2>Kategori Denda</h2>
    <button onclick="loadData('tambah_denda.php')" class="btn-tambah">Tambah Kategori</button>
    <table>
        <thead>
            <tr>
                <th>Telat</th>
                <th>Harga Denda</th>
                <th>Status</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $no++ . " Hari</td>"; // Menggunakan increment untuk nomor late
                    echo "<td>Rp " . number_format($row['harga_denda']) . "</td>";
                    echo "<td class='" . ($row['status'] == 'aktif' ? 'status-aktif' : 'status-non-aktif') . "'>" . ucfirst($row['status']) . "</td>";
                    echo "<td>";
                    echo "<a href='#' class='btn-edit' onclick=\"loadData('edit_denda.php?id=" . $row['id'] . "')\">Edit</a> ";
                    echo "<a href='#' class='btn-hapus' onclick=\"loadData('hapus_denda.php?id=" . $row['id'] . "')\" onclick='return confirm(\"Apakah Anda yakin ingin menghapus kategori denda ini?\")'>Hapus</a>";
                    
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>Tidak ada data kategori denda</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <div class="catatan-denda">
        <p>Catatan: Setiap lewat 1 hari akan didenda Rp. 10.000. Setiap lebih dari 1 hari, denda akan ditambah Rp. 10.000.</p>
    </div>
</body>

</html>