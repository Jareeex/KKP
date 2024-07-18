-- Buat database
CREATE DATABASE IF NOT EXISTS `dbperpus`;

-- Gunakan database
USE `dbperpus`;

-- Struktur tabel `buku`
CREATE TABLE IF NOT EXISTS `buku` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `pengarang` varchar(255) NOT NULL,
  `penerbit` varchar(255) NOT NULL,
  `tahun_terbit` int(11) NOT NULL,
  `rak_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rak_id` (`rak_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Isi data untuk tabel `buku`
INSERT INTO `buku` (`id`, `judul`, `pengarang`, `penerbit`, `tahun_terbit`, `rak_id`) VALUES
(9, 'Pemrograman', 'egi', 'Egi', 2020, 1),
(10, 'Fisika', 'tes 1', 'tes 2', 2012, 2);

-- Struktur tabel `data_diri`
CREATE TABLE IF NOT EXISTS `data_diri` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `no_telepon` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Struktur tabel `data_siswa`
CREATE TABLE IF NOT EXISTS `data_siswa` (
  `id` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `no_telepon` varchar(15) NOT NULL,
  `alamat` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Isi data untuk tabel `data_siswa`
INSERT INTO `data_siswa` (`id`, `nim`, `nama`, `jenis_kelamin`, `no_telepon`, `alamat`) VALUES
(19, '111', 'Budi', 'Laki-laki', '123456', 'Bogor\r\n');

-- Struktur tabel `kategori_denda`
CREATE TABLE IF NOT EXISTS `kategori_denda` (
  `id` int(11) NOT NULL,
  `harga_denda` int(11) NOT NULL,
  `status` enum('aktif','non-aktif') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Isi data untuk tabel `kategori_denda`
INSERT INTO `kategori_denda` (`id`, `harga_denda`, `status`) VALUES
(1, 10000, 'aktif'),
(2, 20000, 'aktif');

-- Struktur tabel `peminjaman_buku`
CREATE TABLE IF NOT EXISTS `peminjaman_buku` (
  `id` int(11) NOT NULL,
  `no_pinjam` varchar(100) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `status` enum('aktif','non-aktif') NOT NULL,
  `judul_buku` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Struktur tabel `pengembalian_buku`
CREATE TABLE IF NOT EXISTS `pengembalian_buku` (
  `id` int(11) NOT NULL,
  `peminjaman_id` int(50) NOT NULL,
  `no_pinjam` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `tgl_pinjam` date NOT NULL,
  `tgl_kembali` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `kembali` date NOT NULL,
  `judul_buku` varchar(100) NOT NULL,
  `denda` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Struktur tabel `rak_buku`
CREATE TABLE IF NOT EXISTS `rak_buku` (
  `id` int(11) NOT NULL,
  `nama_rak` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Isi data untuk tabel `rak_buku`
INSERT INTO `rak_buku` (`id`, `nama_rak`) VALUES
(1, 'Rak A'),
(2, 'Rak B'),
(20, 'Rak C');

-- Struktur tabel `users`
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Isi data untuk tabel `users`
INSERT INTO `users` (`id`, `username`, `password`, `created`, `role`) VALUES
(4, 'admin', '$2y$10$1ggiiTMUuwTJaKn5gMi0Mu.Sj/ZPYwddPpRnHA1ZB5HAFnUl.9nEe', '2024-05-25 17:00:55', 'admin'),
(5, 'egi', '$2y$10$Dy0SrYGB/ZuZaAMlsDFTh.2YABYpDBILovj0K4cARpJjkaaC0Atxm', '2024-05-25 17:24:40', '');

-- Penambahan foreign key constraints
ALTER TABLE `buku`
  ADD CONSTRAINT `buku_ibfk_1` FOREIGN KEY (`rak_id`) REFERENCES `rak_buku` (`id`) ON DELETE CASCADE;

ALTER TABLE `data_diri`
  ADD CONSTRAINT `data_diri_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`);