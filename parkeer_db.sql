-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 01, 2025 at 12:41 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parkeer_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `mall_id` int(11) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `level` enum('admin','super_admin') DEFAULT 'admin',
  `created_at` datetime DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `mall_id`, `username`, `password`, `nama`, `email`, `level`, `created_at`, `last_login`, `is_active`) VALUES
(1, 1, 'admincp', 'admincp', 'Admin CP', 'admincp@gmail.com', 'admin', '2025-04-25 19:22:13', '2025-05-01 17:07:34', 1),
(2, 2, 'adminsp', 'adminsp', 'Admin SP', 'adminsp@gmail.com', 'admin', '2025-04-25 19:47:05', '2025-05-01 02:29:45', 1),
(3, 3, 'admindp', 'admindp', 'Admin DP', 'admindp@gmail.com', 'admin', '2025-04-30 23:26:58', '2025-05-01 01:33:28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `malls`
--

CREATE TABLE `malls` (
  `id` int(11) NOT NULL,
  `nama_mall` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `total_slot` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `malls`
--

INSERT INTO `malls` (`id`, `nama_mall`, `alamat`, `total_slot`, `created_at`) VALUES
(1, 'Centre Point Mall', 'Jl. Jawa No.8, Medan', 9, '2025-04-28 22:26:29'),
(2, 'Sun Plaza', 'Jl. K.H. Zainul Arifin No.7, Medan', 9, '2025-04-28 22:26:29'),
(3, 'Deli Park Mall', 'Jl. Putri Hijau Dalam No.1, Medan', 9, '2025-04-29 20:51:36');

-- --------------------------------------------------------

--
-- Table structure for table `parking_slots`
--

CREATE TABLE `parking_slots` (
  `id` int(11) NOT NULL,
  `mall_id` int(11) NOT NULL,
  `slot_code` varchar(10) NOT NULL,
  `status` enum('available','booked','occupied') DEFAULT 'available',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `parking_slots`
--

INSERT INTO `parking_slots` (`id`, `mall_id`, `slot_code`, `status`, `created_at`) VALUES
(1, 1, 'CP-P1', 'available', '2025-04-28 22:26:29'),
(2, 1, 'CP-P2', 'available', '2025-04-28 22:26:29'),
(3, 1, 'CP-P3', 'available', '2025-04-28 22:26:29'),
(4, 1, 'CP-P4', 'available', '2025-04-28 22:26:29'),
(5, 1, 'CP-P5', 'available', '2025-04-28 22:26:29'),
(6, 1, 'CP-P6', 'available', '2025-04-28 22:26:29'),
(7, 1, 'CP-P7', 'available', '2025-04-28 22:26:29'),
(8, 1, 'CP-P8', 'available', '2025-04-28 22:26:29'),
(9, 1, 'CP-P9', 'available', '2025-04-28 22:26:29'),
(10, 2, 'SP-P1', 'available', '2025-04-28 22:26:29'),
(11, 2, 'SP-P2', 'available', '2025-04-28 22:26:29'),
(12, 2, 'SP-P3', 'available', '2025-04-28 22:26:29'),
(13, 2, 'SP-P4', 'available', '2025-04-28 22:26:29'),
(14, 2, 'SP-P5', 'available', '2025-04-28 22:26:29'),
(15, 2, 'SP-P6', 'available', '2025-04-28 22:26:29'),
(16, 2, 'SP-P7', 'available', '2025-04-28 22:26:29'),
(17, 2, 'SP-P8', 'available', '2025-04-28 22:26:29'),
(18, 2, 'SP-P9', 'available', '2025-04-28 22:26:29'),
(19, 3, 'DP-P1', 'available', '2025-04-29 20:53:36'),
(20, 3, 'DP-P2', 'available', '2025-04-29 20:53:36'),
(21, 3, 'DP-P3', 'available', '2025-04-29 20:53:36'),
(22, 3, 'DP-P4', 'available', '2025-04-29 20:53:36'),
(23, 3, 'DP-P5', 'available', '2025-04-29 20:53:36'),
(24, 3, 'DP-P6', 'available', '2025-04-29 20:53:36'),
(25, 3, 'DP-P7', 'available', '2025-04-29 20:53:36'),
(26, 3, 'DP-P8', 'available', '2025-04-29 20:53:36'),
(27, 3, 'DP-P9', 'available', '2025-04-29 20:53:36');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `mall_id` int(11) NOT NULL,
  `parking_slot_id` int(11) NOT NULL,
  `booking_code` varchar(50) NOT NULL,
  `waktu_masuk` datetime NOT NULL,
  `waktu_keluar` datetime NOT NULL,
  `durasi` int(11) NOT NULL COMMENT 'Durasi dalam menit',
  `biaya` int(11) NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `qr_code_path` varchar(255) DEFAULT NULL,
  `status` enum('pending','completed','cancelled') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `vehicle_id`, `mall_id`, `parking_slot_id`, `booking_code`, `waktu_masuk`, `waktu_keluar`, `durasi`, `biaya`, `metode_pembayaran`, `qr_code_path`, `status`, `created_at`) VALUES
(43, 12, 13, 1, 1, 'BK681347727332B', '2025-05-01 17:05:00', '2025-05-01 18:05:00', 60, 5000, 'Dompet Parkeer', '-', 'completed', '2025-05-01 17:05:38'),
(44, 13, 16, 3, 19, 'BK681348EA6EC97', '2025-05-01 17:11:00', '2025-05-01 17:13:00', 2, 6000, 'Dompet Parkeer', '-', 'cancelled', '2025-05-01 17:11:54');

-- --------------------------------------------------------

--
-- Table structure for table `topup_history`
--

CREATE TABLE `topup_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `method` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `topup_history`
--

INSERT INTO `topup_history` (`id`, `user_id`, `amount`, `method`, `created_at`) VALUES
(39, 12, 50000, 'BCA', '2025-05-01 10:04:50'),
(40, 13, 50000, 'm-BCA', '2025-05-01 10:09:54'),
(41, 13, 6000, 'Refund Pembatalan Reservasi', '2025-05-01 10:12:03');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_history`
--

CREATE TABLE `transaction_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `transaction_history`
--

INSERT INTO `transaction_history` (`id`, `user_id`, `amount`, `keterangan`, `created_at`) VALUES
(39, 12, 5000, 'Booking di Centre Point Mall', '2025-05-01 10:05:38'),
(40, 13, 6000, 'Booking di DeliPark Mall', '2025-05-01 10:11:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `saldo` int(11) DEFAULT 0,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `last_login` datetime DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `foto_profile` varchar(255) DEFAULT 'assets/img/profilepic.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `no_hp`, `saldo`, `password`, `created_at`, `last_login`, `is_active`, `foto_profile`) VALUES
(12, 'Cariven', 'cariven@gmail.com', '089646478875', 45000, 'kede', '2025-05-01 17:03:58', '2025-05-01 17:04:03', 1, 'uploads/1746093860_f1.jpg'),
(13, 'Jansen Khang', 'jansen@gmail.com', '087865654322', 50000, 'asen', '2025-05-01 17:09:20', '2025-05-01 17:09:36', 1, 'uploads/1746094216_f1-2.jpg'),
(14, 'Vincent', 'vincent@gmail.com', '081233001298', 0, 'acen', '2025-05-01 17:14:59', '2025-05-01 17:15:07', 1, 'assets/img/defaultpp.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `plate` varchar(20) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `color` varchar(50) NOT NULL,
  `is_primary` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `user_id`, `plate`, `brand`, `color`, `is_primary`, `created_at`) VALUES
(13, 12, 'BK 1234 KL', 'Honda Brio', 'Merah', 0, '2025-05-01 17:04:29'),
(14, 12, 'BK 1234 KK', 'Honda CRV', 'Putih', 1, '2025-05-01 17:04:38'),
(15, 13, 'BK 1223 HM', 'Toyota Innova', 'Putih', 1, '2025-05-01 17:10:34'),
(16, 13, 'BK 112 MK', 'Toyota Raize', 'Hitam', 0, '2025-05-01 17:10:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `malls`
--
ALTER TABLE `malls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parking_slots`
--
ALTER TABLE `parking_slots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mall_id` (`mall_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_code` (`booking_code`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `vehicle_id` (`vehicle_id`),
  ADD KEY `mall_id` (`mall_id`),
  ADD KEY `parking_slot_id` (`parking_slot_id`);

--
-- Indexes for table `topup_history`
--
ALTER TABLE `topup_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `malls`
--
ALTER TABLE `malls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `parking_slots`
--
ALTER TABLE `parking_slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `topup_history`
--
ALTER TABLE `topup_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `transaction_history`
--
ALTER TABLE `transaction_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `parking_slots`
--
ALTER TABLE `parking_slots`
  ADD CONSTRAINT `parking_slots_ibfk_1` FOREIGN KEY (`mall_id`) REFERENCES `malls` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`vehicle_id`) REFERENCES `vehicles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`mall_id`) REFERENCES `malls` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_4` FOREIGN KEY (`parking_slot_id`) REFERENCES `parking_slots` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `topup_history`
--
ALTER TABLE `topup_history`
  ADD CONSTRAINT `topup_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD CONSTRAINT `transaction_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
