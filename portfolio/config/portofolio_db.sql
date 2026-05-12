-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2026 at 04:27 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `portofolio_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `level`
--

CREATE TABLE `level` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `level`
--

INSERT INTO `level` (`id`, `nama`, `created_at`) VALUES
(1, ' TK (Taman Kanak-Kanak)', '2026-04-28 15:18:23'),
(2, ' SD (Sekolah Dasar)', '2026-04-28 15:18:23'),
(3, ' SMP (Sekolah Menengah Pertama)', '2026-04-28 15:18:23'),
(4, ' SMA/SMK (Sekolah Menengah Atas)', '2026-04-28 15:18:23'),
(10, 'S1 (Sarjana Komputer)', '2026-05-04 07:35:51');

-- --------------------------------------------------------

--
-- Table structure for table `studies`
--

CREATE TABLE `studies` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `idlevel` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `tahun_lulus` year(4) DEFAULT NULL,
  `foto_sekolah` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studies`
--

INSERT INTO `studies` (`id`, `nama`, `idlevel`, `keterangan`, `tahun_lulus`, `foto_sekolah`, `created_at`) VALUES
(7, 'MA Fath Institute', 4, '', '2025', '1777880470_69f84d96a1be5.jpeg', '2026-05-04 07:41:10'),
(8, 'TK IT Bina Cendikia', 1, '', '2010', '1777880803_69f84ee33ad87.jpeg', '2026-05-04 07:46:43'),
(9, 'SMPIT Arriyadl', 3, '', '2022', '1777881020_69f84fbccb8ca.jpeg', '2026-05-04 07:50:20'),
(10, 'SDN Merak 1', 2, '', '2019', '1777881096_69f85008a34e7.jpeg', '2026-05-04 07:51:36'),
(11, 'STT Terpadu Nurul Fikri', 10, '', '2029', '1777903033_69f8a5b9db4aa.jpeg', '2026-05-04 13:57:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_login` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `name`, `email`, `no_hp`, `alamat`, `foto`, `role`, `created_at`, `last_login`, `is_active`) VALUES
(1, 'icad', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'icad\r\n', 'admin@portofolio.com', '081234567890', NULL, NULL, 'admin', '2026-04-28 15:18:23', NULL, 1),
(3, 'jokowi', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'jokowi', 'joko@example.com', '081234567891', NULL, NULL, 'user', '2026-05-01 08:59:26', NULL, 1),
(4, 'ganjar', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ganjar', 'anjar@example.com', '081234567892', NULL, NULL, 'user', '2026-05-01 08:59:26', NULL, 1),
(5, 'prabowo', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'prabowo', 'bowo@example.com', '081234567893', NULL, NULL, 'user', '2026-05-01 08:59:26', NULL, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `level`
--
ALTER TABLE `level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studies`
--
ALTER TABLE `studies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idlevel` (`idlevel`);

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
-- AUTO_INCREMENT for table `level`
--
ALTER TABLE `level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `studies`
--
ALTER TABLE `studies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `studies`
--
ALTER TABLE `studies`
  ADD CONSTRAINT `studies_ibfk_1` FOREIGN KEY (`idlevel`) REFERENCES `level` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
