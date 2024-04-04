-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 04, 2024 at 02:05 AM
-- Server version: 8.2.0
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lara_vue`
--

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` bigint UNSIGNED NOT NULL,
  `uniq_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_bonus` decimal(10,2) NOT NULL,
  `persentase` int NOT NULL,
  `pembayaran` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `uniq_code`, `name`, `total_bonus`, `persentase`, `pembayaran`, `created_at`, `updated_at`) VALUES
(1, 'IfLDAu0PhZ', 'Buruh 1', '20000000.00', 50, '10000000.00', '2024-04-03 18:52:52', '2024-04-03 18:56:37'),
(2, 'IfLDAu0PhZ', 'Buruh 2', '20000000.00', 20, '4000000.00', '2024-04-03 18:52:52', '2024-04-03 18:56:37'),
(3, 'IfLDAu0PhZ', 'Buruh 3', '20000000.00', 10, '2000000.00', '2024-04-03 18:52:52', '2024-04-03 18:56:37'),
(4, 'He9t9jm7ul', 'Buruh 4', '20000000.00', 10, '2000000.00', '2024-04-03 18:52:52', '2024-04-03 18:54:40'),
(5, 'He9t9jm7ul', 'Buruh 2', '2000000.00', 20, '400000.00', '2024-04-03 18:51:19', '2024-04-03 18:51:19'),
(6, 'He9t9jm7ul', 'Buruh 3', '2000000.00', 10, '200000.00', '2024-04-03 18:51:19', '2024-04-03 18:51:19'),
(7, 'He9t9jm7ul', 'Buruh 4', '2000000.00', 10, '200000.00', '2024-04-03 18:51:19', '2024-04-03 18:51:19'),
(8, 'He9t9jm7ul', 'Buruh 5', '2000000.00', 40, '800000.00', '2024-04-03 18:51:19', '2024-04-03 18:51:19'),
(9, 'IfLDAu0PhZ', 'Buruh 4', '20000000.00', 10, '2000000.00', '2024-04-03 18:56:07', '2024-04-03 18:56:37'),
(10, 'IfLDAu0PhZ', 'Buruh 5', '20000000.00', 10, '2000000.00', '2024-04-03 18:56:27', '2024-04-03 18:56:37'),
(11, 'BRmAw7ALeJ', 'Buruh 1', '10000000.00', 10, '1000000.00', '2024-04-03 19:04:59', '2024-04-03 19:05:24'),
(12, 'BRmAw7ALeJ', 'Buruh 2', '10000000.00', 10, '1000000.00', '2024-04-03 19:04:59', '2024-04-03 19:05:24'),
(13, 'BRmAw7ALeJ', 'Buruh 3', '10000000.00', 60, '6000000.00', '2024-04-03 19:04:59', '2024-04-03 19:05:24'),
(14, 'BRmAw7ALeJ', 'Buruh 4', '10000000.00', 10, '1000000.00', '2024-04-03 19:04:59', '2024-04-03 19:05:24'),
(15, 'BRmAw7ALeJ', 'Buruh 5', '10000000.00', 10, '1000000.00', '2024-04-03 19:05:24', '2024-04-03 19:05:24');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2a$12$Jo4VXAxt0Cm1mKait1A9puWo1UqzW7YT3VN29.S/Imk.vkXXZ49qu', 'admin', '2024-04-18 01:47:21', '2024-04-12 01:47:21'),
(2, 'user', '$2a$12$ZsM2A./O/88ZjpMm8Rbdxeby/kZSJCXFDrpKiS/PtRxzjy3.Ho42y', 'user', '2024-04-04 01:40:17', '2024-04-04 01:32:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
