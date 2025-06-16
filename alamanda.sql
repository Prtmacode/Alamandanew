-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 16, 2025 at 06:50 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alamanda`
--

-- --------------------------------------------------------

--
-- Table structure for table `alat`
--

CREATE TABLE `alat` (
  `id` int(11) NOT NULL,
  `id_alat` varchar(20) NOT NULL,
  `kategori` enum('scanner','cpu','monitor') NOT NULL,
  `jenis` varchar(100) DEFAULT NULL,
  `merek` varchar(100) DEFAULT NULL,
  `seri` varchar(100) DEFAULT NULL,
  `ukuran` enum('kecil','sedang','besar') DEFAULT NULL,
  `spesifikasi` text DEFAULT NULL,
  `ukuran_inch` decimal(4,1) DEFAULT NULL,
  `resolusi` varchar(50) DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `status` enum('Tersedia','Dipinjam','Rusak','Dalam Perbaikan','Hilang') NOT NULL DEFAULT 'Tersedia',
  `jumlah_pemakaian` int(11) DEFAULT 0,
  `keterangan` text DEFAULT NULL,
  `tgl_masuk` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alat`
--

INSERT INTO `alat` (`id`, `id_alat`, `kategori`, `jenis`, `merek`, `seri`, `ukuran`, `spesifikasi`, `ukuran_inch`, `resolusi`, `lokasi`, `status`, `jumlah_pemakaian`, `keterangan`, `tgl_masuk`) VALUES
(27, '0001', 'scanner', NULL, 'Canon', 'SCN 1111', 'sedang', NULL, NULL, NULL, NULL, 'Tersedia', 3, NULL, '2025-06-16'),
(29, '0002', 'cpu', 'NUC', 'Asus', NULL, NULL, 'i3 9000k', NULL, NULL, NULL, 'Tersedia', 1, NULL, '2025-06-16'),
(30, '0003', 'monitor', NULL, 'View Sonic', 'MTR 0111', NULL, '144hz', 27.0, NULL, NULL, 'Tersedia', 1, NULL, '2025-06-16');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` int(11) NOT NULL,
  `id_peminjaman` varchar(20) NOT NULL,
  `id_alat` varchar(20) NOT NULL,
  `peminjam` varchar(100) NOT NULL,
  `divisi` varchar(100) DEFAULT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status` enum('Dipinjam','Dikembalikan') NOT NULL DEFAULT 'Dipinjam',
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `id_peminjaman`, `id_alat`, `peminjam`, `divisi`, `tanggal_pinjam`, `tanggal_kembali`, `status`, `keterangan`) VALUES
(11, 'PMJ1750088255', '0001', 'Dimaz', 'Teknisi', '2025-06-16', '2025-06-16', 'Dikembalikan', 'Bawa Balik'),
(12, 'PMJ1750088283', '0003', 'Agam', 'Admin', '2025-06-16', '2025-06-16', 'Dikembalikan', 'Meledak dirumah'),
(13, 'PMJ1750088308', '0002', 'Fito', 'Teknisi', '2025-06-16', '2025-06-16', 'Dikembalikan', 'Buat Ngegame'),
(14, 'PMJ1750088424', '0001', 'Dimas', 'Teknisi', '2025-06-16', '2025-06-16', 'Dikembalikan', 'asa'),
(15, 'PMJ1750088521', '0001', 'Dimas', 'Teknis', '2025-06-16', '2025-08-17', 'Dikembalikan', 'asa');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$a6mD5B0gJspQIBX6rm2pSe1c1/7U6OXhPzt8RGHEEahKDJVKr8bxK', '2025-05-29 15:02:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alat`
--
ALTER TABLE `alat`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_alat` (`id_alat`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_peminjaman` (`id_peminjaman`),
  ADD KEY `id_alat` (`id_alat`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alat`
--
ALTER TABLE `alat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_alat`) REFERENCES `alat` (`id_alat`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
