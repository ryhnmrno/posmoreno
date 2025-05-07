-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Bulan Mei 2025 pada 23.27
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun`
--

CREATE TABLE `akun` (
  `id_user` int(50) NOT NULL,
  `nama_kasir` varchar(255) DEFAULT NULL,
  `level` enum('admin','user') DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `akun`
--

INSERT INTO `akun` (`id_user`, `nama_kasir`, `level`, `email`, `password`, `no_hp`, `tgl_lahir`, `alamat`, `foto`) VALUES
(1, 'reno', 'admin', 'rr@gmail.com', '$2y$10$xa5lX2QyUThxld8x.e4tve1etKiW163/iFUyJvp1zds897BG/Ms/m', '085711036196', '2025-01-15', 'Harapan indah', 'uploads/1740032681_1740032401_4x6.png'),
(2, 'rafles', 'admin', 'rawlescantik@gmail.com', '$2y$10$Phg03hOcfbJJojOmYHEyWuzb00zFkRkntWuy50XZwIAjSaSf6DGKC', NULL, NULL, NULL, ''),
(3, 'rafly', 'user', 'alwale@gmail.com', '$2y$10$nluuL2n1oJZn4gatvklvn.sE954aSTyLc9MlS5yEkgmoe8Ji8nKIy', NULL, NULL, NULL, ''),
(4, 'iyan', 'admin', 'iyan@gmail.com', '$2y$10$02qCsnNc3WXO9W/MG15iy.0Faps6mS1Md3X7Sj9ZSFULSfEQS5eXe', NULL, NULL, NULL, ''),
(6, 'moreno', 'user', 'mm@gmail.com', '$2y$10$zzcnjMfmSccnFLXX416UiekqlPxRMeZNSOaXK7ecYpHmIjDLfeJ6i', NULL, NULL, NULL, ''),
(7, 'rehan', 'admin', 'rehanganteng@gmail.com', '$2y$10$r1jNx4pXbr9K/cCtnCloH.8YCSgJ6ncudfFrrsqTglvTOpmPllCkS', NULL, NULL, NULL, ''),
(8, NULL, NULL, NULL, '', NULL, NULL, NULL, 'webcam-toy-photo2.jpg'),
(9, 'reno', 'admin', 'hdu@gmail.com', '$2y$10$X6F.iX3Zl6js1y3m9NDOku9Npcvlb1WDF5AivBaWjti4F4vrS89FS', '0439', NULL, 'ue', 'uploads/1743583254_webcam-toy-photo4.jpg'),
(10, 'moreno', 'admin', 'guaaganteng888@gmail.com', '$2y$10$IdXz7XZteK0f80ND2qXV4ums8iyM5Z0gWamzB5EaLnHXBwHUX8FdG', NULL, NULL, NULL, ''),
(11, 'reno', 'admin', 'reyhanmoreno9@gmail.com', '$2y$10$zPYTZecSFhEud8FqJn/zH.uftDpGaHXZm182PuHuUztiMdEaTiU/a', NULL, NULL, NULL, ''),
(12, 'moreno', 'admin', 'admin@gmail.com', '$2y$10$xeGT8slTV0LXQtETn6vSv.BjuP4.5qMbtHx3h3tndgKbHiwbhHRri', NULL, NULL, NULL, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `id_detail` int(50) NOT NULL,
  `id_produk` int(50) DEFAULT NULL,
  `id_penjualan` int(50) DEFAULT NULL,
  `id_user` int(50) DEFAULT NULL,
  `jumlah_produk` int(50) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_bulanan`
--

CREATE TABLE `laporan_bulanan` (
  `id_laporan_bulanan` int(50) NOT NULL,
  `total_penjualan` decimal(10,2) DEFAULT NULL,
  `bulan_penjualan` date DEFAULT NULL,
  `nama_kasir` varchar(255) DEFAULT NULL,
  `id_user` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `laporan_bulanan`
--

INSERT INTO `laporan_bulanan` (`id_laporan_bulanan`, `total_penjualan`, `bulan_penjualan`, `nama_kasir`, `id_user`) VALUES
(1, 58000.00, '2025-02-01', 'reyhan', 1),
(2, 6000.00, '2025-01-01', 'reyhan', 1),
(3, 106000.00, '2025-02-01', 'reno', 1),
(4, 6000.00, '2025-01-01', 'reno', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan_harian`
--

CREATE TABLE `laporan_harian` (
  `id_laporan_harian` int(50) NOT NULL,
  `total_penjualan` decimal(10,2) DEFAULT NULL,
  `tanggal_penjualan` date DEFAULT NULL,
  `uang_diberikan` varchar(255) DEFAULT NULL,
  `kembalian` varchar(255) NOT NULL,
  `nama_kasir` varchar(255) NOT NULL,
  `id_user` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `laporan_harian`
--

INSERT INTO `laporan_harian` (`id_laporan_harian`, `total_penjualan`, `tanggal_penjualan`, `uang_diberikan`, `kembalian`, `nama_kasir`, `id_user`) VALUES
(21, 6000.00, '2025-02-07', '10000', '4000', '', NULL),
(22, 3000.00, '2025-02-07', '5000', '2000', '', NULL),
(23, 6000.00, '2025-02-09', '10000', '4000', '', NULL),
(24, 2000.00, '2025-02-09', '4000', '2000', '', NULL),
(25, 2000.00, '2025-02-09', '4000', '2000', 'hendrik24', NULL),
(26, 6000.00, '2025-02-09', '8000', '2000', '', NULL),
(27, 6000.00, '2025-02-09', '8000', '2000', 'reyhan', NULL),
(28, 6000.00, '2025-02-09', '10000', '4000', 'reyhan', NULL),
(29, 6000.00, '2025-02-09', '10000', '4000', 'reyhan', NULL),
(30, 6000.00, '2025-02-09', '10000', '4000', 'reyhan', NULL),
(31, 6000.00, '2025-02-09', '10000', '4000', 'reyhan', NULL),
(32, 3000.00, '2025-02-09', '5000', '2000', 'reyhan', NULL),
(33, 6000.00, '2025-01-09', '10000', '4000', 'reyhan', NULL),
(34, 6000.00, '2025-02-10', '10000', '4000', 'reyhan', NULL),
(35, 6000.00, '2025-02-19', '10000', '4000', 'reyhan', NULL),
(36, 3000.00, '2025-02-19', '5000', '2000', 'reyhan', NULL),
(37, 3000.00, '2025-02-19', '5000', '2000', 'reyhan', NULL),
(38, 4000.00, '2025-02-19', '10000', '6000', 'reyhan', NULL),
(39, 6000.00, '2025-02-19', '10000', '4000', 'reyhan', NULL),
(40, 6000.00, '2025-02-19', '10000', '4000', 'reno', NULL),
(41, 3000.00, '2025-02-19', '5000', '2000', 'reno', NULL),
(42, 3000.00, '2025-02-19', '5000', '2000', 'reno', NULL),
(43, 2000.00, '2025-02-19', '3000', '1000', 'reno', NULL),
(44, 2000.00, '2025-02-19', '3000', '1000', 'reno', NULL),
(45, 2000.00, '2025-02-19', '4000', '2000', 'reno', NULL),
(46, 2000.00, '2025-02-19', '4000', '2000', 'reno', NULL),
(47, 2000.00, '2025-02-19', '4000', '2000', 'reno', NULL),
(48, 2000.00, '2025-02-19', '4000', '2000', 'reno', NULL),
(49, 2000.00, '2025-02-19', '4000', '2000', 'reno', NULL),
(50, 2000.00, '2025-02-19', '4000', '2000', 'reno', NULL),
(51, 2000.00, '2025-02-19', '4000', '2000', 'reno', NULL),
(52, 2000.00, '2025-02-19', '4000', '2000', 'reno', NULL),
(53, 2000.00, '2025-02-19', '5000', '3000', 'reno', NULL),
(54, 2000.00, '2025-02-19', '5000', '3000', 'reno', NULL),
(55, 2000.00, '2025-02-19', '5000', '3000', 'reno', NULL),
(56, 2000.00, '2025-02-19', '5000', '3000', 'reno', NULL),
(57, 3000.00, '2025-02-19', '5000', '2000', 'reno', NULL),
(58, 3000.00, '2025-02-19', '5000', '2000', 'reno', NULL),
(59, 3000.00, '2025-02-19', '5000', '2000', 'reno', NULL),
(60, 3000.00, '2025-02-19', '5000', '2000', 'reno', NULL),
(61, 3000.00, '2025-02-19', '5000', '2000', 'reno', NULL),
(62, 3000.00, '2025-02-19', '5000', '2000', 'reyhan', NULL),
(63, 3000.00, '2025-02-20', '5000', '2000', 'reyhan', NULL),
(64, 5500.00, '2025-02-20', '6000', '500', 'reno', NULL),
(65, 5500.00, '2025-02-20', '6000', '500', 'reno', NULL),
(66, 3000.00, '2025-02-26', '5000', '2000', 'reno', NULL),
(67, 3000.00, '2025-02-26', '5000', '2000', 'reno', NULL),
(68, 3000.00, '2025-04-13', '5000', '2000', 'reno', NULL),
(69, 6000.00, '2025-04-14', '10000', '4000', 'reno', NULL),
(70, 10000.00, '2025-04-14', '10000', '0', 'reno', NULL),
(71, 3000.00, '2025-05-05', '5000', '2000', 'moreno', NULL),
(72, 4500.00, '2025-05-05', '5000', '500', 'moreno', NULL),
(73, 2000.00, '2025-05-06', '5000', '3000', 'moreno', NULL),
(74, 2000.00, '2025-05-06', '6000', '4000', 'moreno', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(50) NOT NULL,
  `nama_pelanggan` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `no_hp` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan`
--

CREATE TABLE `penjualan` (
  `id_penjualan` int(50) NOT NULL,
  `tanggal_penjualan` date DEFAULT NULL,
  `total_harga` decimal(10,2) DEFAULT NULL,
  `uang_diberikan` varchar(255) NOT NULL,
  `kembalian` varchar(255) NOT NULL,
  `nama_kasir` varchar(255) NOT NULL,
  `id_pelanggan` int(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `penjualan`
--

INSERT INTO `penjualan` (`id_penjualan`, `tanggal_penjualan`, `total_harga`, `uang_diberikan`, `kembalian`, `nama_kasir`, `id_pelanggan`) VALUES
(21, '2025-02-07', 6000.00, '10000', '4000', '', NULL),
(22, '2025-02-07', 3000.00, '5000', '2000', '', NULL),
(23, '2025-02-09', 6000.00, '10000', '4000', '', NULL),
(24, '2025-02-09', 2000.00, '4000', '2000', '', NULL),
(25, '2025-02-09', 2000.00, '4000', '2000', 'hendrik24', NULL),
(26, '2025-02-09', 6000.00, '8000', '2000', '', NULL),
(27, '2025-02-09', 6000.00, '8000', '2000', 'reyhan', NULL),
(28, '2025-02-09', 6000.00, '10000', '4000', 'reyhan', NULL),
(29, '2025-02-09', 6000.00, '10000', '4000', 'reyhan', NULL),
(30, '2025-02-09', 6000.00, '10000', '4000', 'reyhan', NULL),
(31, '2025-02-09', 6000.00, '10000', '4000', 'reyhan', NULL),
(32, '2025-02-09', 3000.00, '5000', '2000', 'reyhan', NULL),
(33, '2025-01-09', 6000.00, '10000', '4000', 'reyhan', NULL),
(34, '2025-02-10', 6000.00, '10000', '4000', 'reyhan', NULL),
(35, '2025-02-19', 6000.00, '10000', '4000', 'reyhan', NULL),
(36, '2025-02-19', 3000.00, '5000', '2000', 'reyhan', NULL),
(37, '2025-02-19', 3000.00, '5000', '2000', 'reyhan', NULL),
(38, '2025-02-19', 4000.00, '10000', '6000', 'reyhan', NULL),
(39, '2025-02-19', 6000.00, '10000', '4000', 'reyhan', NULL),
(40, '2025-02-19', 6000.00, '10000', '4000', 'reno', NULL),
(41, '2025-02-19', 3000.00, '5000', '2000', 'reno', NULL),
(42, '2025-02-19', 3000.00, '5000', '2000', 'reno', NULL),
(43, '2025-02-19', 2000.00, '3000', '1000', 'reno', NULL),
(44, '2025-02-19', 2000.00, '3000', '1000', 'reno', NULL),
(45, '2025-02-19', 2000.00, '4000', '2000', 'reno', NULL),
(46, '2025-02-19', 2000.00, '4000', '2000', 'reno', NULL),
(47, '2025-02-19', 2000.00, '4000', '2000', 'reno', NULL),
(48, '2025-02-19', 2000.00, '4000', '2000', 'reno', NULL),
(49, '2025-02-19', 2000.00, '4000', '2000', 'reno', NULL),
(50, '2025-02-19', 2000.00, '4000', '2000', 'reno', NULL),
(51, '2025-02-19', 2000.00, '4000', '2000', 'reno', NULL),
(52, '2025-02-19', 2000.00, '4000', '2000', 'reno', NULL),
(53, '2025-02-19', 2000.00, '5000', '3000', 'reno', NULL),
(54, '2025-02-19', 2000.00, '5000', '3000', 'reno', NULL),
(55, '2025-02-19', 2000.00, '5000', '3000', 'reno', NULL),
(56, '2025-02-19', 2000.00, '5000', '3000', 'reno', NULL),
(57, '2025-02-19', 3000.00, '5000', '2000', 'reno', NULL),
(58, '2025-02-19', 3000.00, '5000', '2000', 'reno', NULL),
(59, '2025-02-19', 3000.00, '5000', '2000', 'reno', NULL),
(60, '2025-02-19', 3000.00, '5000', '2000', 'reno', NULL),
(61, '2025-02-19', 3000.00, '5000', '2000', 'reno', NULL),
(62, '2025-02-19', 3000.00, '5000', '2000', 'reyhan', NULL),
(63, '2025-02-20', 3000.00, '5000', '2000', 'reyhan', NULL),
(64, '2025-02-20', 5500.00, '6000', '500', 'reno', NULL),
(65, '2025-02-20', 5500.00, '6000', '500', 'reno', NULL),
(66, '2025-02-26', 3000.00, '5000', '2000', 'reno', NULL),
(67, '2025-02-26', 3000.00, '5000', '2000', 'reno', NULL),
(68, '2025-04-13', 3000.00, '5000', '2000', 'reno', NULL),
(69, '2025-04-14', 6000.00, '10000', '4000', 'reno', NULL),
(70, '2025-04-14', 10000.00, '10000', '0', 'reno', NULL),
(71, '2025-05-05', 3000.00, '5000', '2000', 'moreno', NULL),
(72, '2025-05-05', 4500.00, '5000', '500', 'moreno', NULL),
(73, '2025-05-06', 2000.00, '5000', '3000', 'moreno', NULL),
(74, '2025-05-06', 2000.00, '6000', '4000', 'moreno', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(50) NOT NULL,
  `nama_produk` varchar(255) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `harga`, `stok`) VALUES
(1, 'teh pucuk', 4000.00, 3);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id_user`);

--
-- Indeks untuk tabel `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `id_penjualan` (`id_penjualan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `laporan_bulanan`
--
ALTER TABLE `laporan_bulanan`
  ADD PRIMARY KEY (`id_laporan_bulanan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `laporan_harian`
--
ALTER TABLE `laporan_harian`
  ADD PRIMARY KEY (`id_laporan_harian`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`id_penjualan`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `akun`
--
ALTER TABLE `akun`
  MODIFY `id_user` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `laporan_bulanan`
--
ALTER TABLE `laporan_bulanan`
  MODIFY `id_laporan_bulanan` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `laporan_harian`
--
ALTER TABLE `laporan_harian`
  MODIFY `id_laporan_harian` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  MODIFY `id_penjualan` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD CONSTRAINT `detail_penjualan_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`),
  ADD CONSTRAINT `detail_penjualan_ibfk_2` FOREIGN KEY (`id_penjualan`) REFERENCES `penjualan` (`id_penjualan`),
  ADD CONSTRAINT `detail_penjualan_ibfk_3` FOREIGN KEY (`id_user`) REFERENCES `akun` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `laporan_bulanan`
--
ALTER TABLE `laporan_bulanan`
  ADD CONSTRAINT `laporan_bulanan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `akun` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `laporan_harian`
--
ALTER TABLE `laporan_harian`
  ADD CONSTRAINT `laporan_harian_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `akun` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
