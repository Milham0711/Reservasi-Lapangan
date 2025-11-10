-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 10, 2025 at 05:05 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reservasilapangan_232112`
--

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_lapangan_232112`
--

CREATE TABLE `jadwal_lapangan_232112` (
  `jadwal_id_232112` int NOT NULL,
  `lapangan_id_232112` int NOT NULL,
  `hari_232112` enum('senin','selasa','rabu','kamis','jumat','sabtu','minggu') NOT NULL,
  `jam_buka_232112` time NOT NULL,
  `jam_tutup_232112` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lapangan_232112`
--

CREATE TABLE `lapangan_232112` (
  `lapangan_id_232112` int NOT NULL,
  `nama_lapangan_232112` varchar(100) NOT NULL,
  `jenis_lapangan_232112` enum('futsal','badminton') NOT NULL,
  `harga_per_jam_232112` decimal(10,2) NOT NULL,
  `deskripsi_232112` text,
  `status_232112` enum('active','maintenance','inactive') DEFAULT 'active',
  `created_at_232112` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi_232112`
--

CREATE TABLE `notifikasi_232112` (
  `notifikasi_id_232112` int NOT NULL,
  `user_id_232112` int NOT NULL,
  `judul_232112` varchar(200) NOT NULL,
  `pesan_232112` text NOT NULL,
  `tipe_232112` enum('email','whatsapp') NOT NULL,
  `status_232112` enum('sent','failed','pending') DEFAULT 'pending',
  `created_at_232112` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_232112`
--

CREATE TABLE `pembayaran_232112` (
  `pembayaran_id_232112` int NOT NULL,
  `reservasi_id_232112` int NOT NULL,
  `metode_pembayaran_232112` enum('transfer','e_wallet','cash') NOT NULL,
  `jumlah_bayar_232112` decimal(10,2) NOT NULL,
  `status_pembayaran_232112` enum('pending','paid','failed','refunded') DEFAULT 'pending',
  `bukti_pembayaran_232112` varchar(255) DEFAULT NULL,
  `tanggal_pembayaran_232112` timestamp NULL DEFAULT NULL,
  `verified_by_232112` int DEFAULT NULL,
  `created_at_232112` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservasi_232112`
--

CREATE TABLE `reservasi_232112` (
  `reservasi_id_232112` int NOT NULL,
  `kode_booking_232112` varchar(20) NOT NULL,
  `user_id_232112` int NOT NULL,
  `lapangan_id_232112` int NOT NULL,
  `tanggal_booking_232112` date NOT NULL,
  `jam_mulai_232112` time NOT NULL,
  `jam_selesai_232112` time NOT NULL,
  `lama_pemakaian_232112` int NOT NULL,
  `total_biaya_232112` decimal(10,2) NOT NULL,
  `status_232112` enum('pending','confirmed','paid','cancelled','completed') DEFAULT 'pending',
  `created_at_232112` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_232112`
--

CREATE TABLE `users_232112` (
  `user_id_232112` int NOT NULL,
  `nama_232112` varchar(100) NOT NULL,
  `email_232112` varchar(100) NOT NULL,
  `nomor_telepon_232112` varchar(20) DEFAULT NULL,
  `username_232112` varchar(50) NOT NULL,
  `password_232112` varchar(255) NOT NULL,
  `role_232112` enum('customer','admin') DEFAULT 'customer',
  `created_at_232112` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at_232112` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jadwal_lapangan_232112`
--
ALTER TABLE `jadwal_lapangan_232112`
  ADD PRIMARY KEY (`jadwal_id_232112`),
  ADD KEY `idx_lapangan_hari_232112` (`lapangan_id_232112`,`hari_232112`);

--
-- Indexes for table `lapangan_232112`
--
ALTER TABLE `lapangan_232112`
  ADD PRIMARY KEY (`lapangan_id_232112`);

--
-- Indexes for table `notifikasi_232112`
--
ALTER TABLE `notifikasi_232112`
  ADD PRIMARY KEY (`notifikasi_id_232112`),
  ADD KEY `user_id_232112` (`user_id_232112`);

--
-- Indexes for table `pembayaran_232112`
--
ALTER TABLE `pembayaran_232112`
  ADD PRIMARY KEY (`pembayaran_id_232112`),
  ADD UNIQUE KEY `reservasi_id_232112` (`reservasi_id_232112`),
  ADD KEY `verified_by_232112` (`verified_by_232112`);

--
-- Indexes for table `reservasi_232112`
--
ALTER TABLE `reservasi_232112`
  ADD PRIMARY KEY (`reservasi_id_232112`),
  ADD UNIQUE KEY `kode_booking_232112` (`kode_booking_232112`),
  ADD KEY `user_id_232112` (`user_id_232112`),
  ADD KEY `lapangan_id_232112` (`lapangan_id_232112`),
  ADD KEY `idx_tanggal_jam_232112` (`tanggal_booking_232112`,`jam_mulai_232112`,`jam_selesai_232112`),
  ADD KEY `idx_status_232112` (`status_232112`);

--
-- Indexes for table `users_232112`
--
ALTER TABLE `users_232112`
  ADD PRIMARY KEY (`user_id_232112`),
  ADD UNIQUE KEY `email_232112` (`email_232112`),
  ADD UNIQUE KEY `username_232112` (`username_232112`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jadwal_lapangan_232112`
--
ALTER TABLE `jadwal_lapangan_232112`
  MODIFY `jadwal_id_232112` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lapangan_232112`
--
ALTER TABLE `lapangan_232112`
  MODIFY `lapangan_id_232112` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifikasi_232112`
--
ALTER TABLE `notifikasi_232112`
  MODIFY `notifikasi_id_232112` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembayaran_232112`
--
ALTER TABLE `pembayaran_232112`
  MODIFY `pembayaran_id_232112` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservasi_232112`
--
ALTER TABLE `reservasi_232112`
  MODIFY `reservasi_id_232112` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_232112`
--
ALTER TABLE `users_232112`
  MODIFY `user_id_232112` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwal_lapangan_232112`
--
ALTER TABLE `jadwal_lapangan_232112`
  ADD CONSTRAINT `jadwal_lapangan_232112_ibfk_1` FOREIGN KEY (`lapangan_id_232112`) REFERENCES `lapangan_232112` (`lapangan_id_232112`) ON DELETE CASCADE;

--
-- Constraints for table `notifikasi_232112`
--
ALTER TABLE `notifikasi_232112`
  ADD CONSTRAINT `notifikasi_232112_ibfk_1` FOREIGN KEY (`user_id_232112`) REFERENCES `users_232112` (`user_id_232112`);

--
-- Constraints for table `pembayaran_232112`
--
ALTER TABLE `pembayaran_232112`
  ADD CONSTRAINT `pembayaran_232112_ibfk_1` FOREIGN KEY (`reservasi_id_232112`) REFERENCES `reservasi_232112` (`reservasi_id_232112`),
  ADD CONSTRAINT `pembayaran_232112_ibfk_2` FOREIGN KEY (`verified_by_232112`) REFERENCES `users_232112` (`user_id_232112`);

--
-- Constraints for table `reservasi_232112`
--
ALTER TABLE `reservasi_232112`
  ADD CONSTRAINT `reservasi_232112_ibfk_1` FOREIGN KEY (`user_id_232112`) REFERENCES `users_232112` (`user_id_232112`),
  ADD CONSTRAINT `reservasi_232112_ibfk_2` FOREIGN KEY (`lapangan_id_232112`) REFERENCES `lapangan_232112` (`lapangan_id_232112`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
