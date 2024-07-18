<?php
include 'koneksi/inc_koneksi.php'; // Menggunakan include dengan path relatif dari file daftar_buku.php
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style_buku.css">
    <title>Daftar Semua Buku</title>
    <h2>Daftar Semua Buku</h2>
</head>

<body>
    <div class="container">
        <div class="filter">
            <label for="rak">Pilih Rak Buku:</label>
            <select id="rak" name="rak" onchange="filterBuku()" class="btn-tambah">
                <option value="all">Semua Rak</option>
                <?php
                $queryRak = "SELECT * FROM rak_buku";
                $resultRak = mysqli_query($conn, $queryRak);
                while ($rowRak = mysqli_fetch_assoc($resultRak)) :
                ?>
                    <option value="<?php echo $rowRak['id']; ?>"><?php echo $rowRak['nama_rak']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Penerbit</th>
                        <th>Tahun Terbit</th>
                        <th>Rak Buku</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="buku-list">
                    <?php
                    $queryBuku = "SELECT buku.*, rak_buku.nama_rak FROM buku LEFT JOIN rak_buku ON buku.rak_id = rak_buku.id";
                    $resultBuku = mysqli_query($conn, $queryBuku);
                    while ($rowBuku = mysqli_fetch_assoc($resultBuku)) :
                    ?>
                        <tr data-rak="<?php echo $rowBuku['rak_id']; ?>">
                            <td><?php echo htmlspecialchars($rowBuku['judul']); ?></td>
                            <td><?php echo htmlspecialchars($rowBuku['pengarang']); ?></td>
                            <td><?php echo htmlspecialchars($rowBuku['penerbit']); ?></td>
                            <td><?php echo htmlspecialchars($rowBuku['tahun_terbit']); ?></td>
                            <td><?php echo htmlspecialchars($rowBuku['nama_rak']); ?></td>
                            <td>
                                <button class="btn-edit" onclick="loadData('edit_buku.php?id=<?php echo $rowBuku['id']; ?>')">Edit</button>
                                <a href="hapus_buku.php?id=<?php echo $rowBuku['id']; ?>" class="btn-hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">Hapus</a>
                            </td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>