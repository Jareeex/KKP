<?php
session_start();

// Cek apakah pengguna sudah login, jika tidak, alihkan ke halaman login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Panggil file koneksi
include 'koneksi/inc_koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id_peminjaman = $_GET['id'];

    // Query untuk mengambil data peminjaman berdasarkan ID
    $sqlPeminjaman = "SELECT * FROM peminjaman_buku WHERE id = $id_peminjaman";
    $resultPeminjaman = $conn->query($sqlPeminjaman);

    if ($resultPeminjaman->num_rows > 0) {
        $rowPeminjaman = $resultPeminjaman->fetch_assoc();

        // Salin data peminjaman ke pengembalian
        $no_pinjam = $rowPeminjaman['no_pinjam'];
        $nama = $rowPeminjaman['nama'];
        $nim = $rowPeminjaman['nim'];
        $tgl_pinjam = $rowPeminjaman['tgl_pinjam'];
        $tgl_kembali = $rowPeminjaman['tgl_kembali'];
        $status = "Dikembalikan"; // Ubah status menjadi "Dikembalikan"
        $judul_buku = $rowPeminjaman['judul_buku'];
        $tgl_sekarang = date('Y-m-d'); // Ambil tanggal saat ini

        // Hitung selisih hari
        $datetime1 = new DateTime($tgl_kembali);
        $datetime2 = new DateTime($tgl_sekarang);
        $interval = $datetime1->diff($datetime2);
        $selisih_hari = $interval->days;

        // Hitung denda
        $denda = 0;
        if ($tgl_sekarang > $tgl_kembali) {
            $denda = $selisih_hari * 10000;
        }

        // Query untuk menyimpan data ke pengembalian buku
        $sqlSimpanPengembalian = "INSERT INTO pengembalian_buku (no_pinjam, nama, nim, tgl_pinjam, tgl_kembali, status, judul_buku, kembali, denda) 
                                    VALUES ('$no_pinjam', '$nama', '$nim', '$tgl_pinjam', '$tgl_kembali', '$status', '$judul_buku', '$tgl_sekarang', '$denda')";
        $resultSimpanPengembalian = $conn->query($sqlSimpanPengembalian);

        // Jika berhasil disalin ke pengembalian, hapus data dari peminjaman buku
        if ($resultSimpanPengembalian) {
            $sqlHapusPeminjaman = "DELETE FROM peminjaman_buku WHERE id = $id_peminjaman";
            $resultHapusPeminjaman = $conn->query($sqlHapusPeminjaman);

            if ($resultHapusPeminjaman) {
                // Redirect kembali ke halaman peminjaman buku setelah berhasil dikembalikan
                header("Location: dashboard.php?page=pengembalian_buku");
                exit;
            }
        } else {
            echo "Gagal menyalin data ke pengembalian buku.";
        }
    } else {
        echo "Data peminjaman tidak ditemukan.";
    }
}

// Tutup koneksi database
$conn->close();
?>
