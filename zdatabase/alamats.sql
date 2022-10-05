-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 22, 2022 at 01:34 PM
-- Server version: 8.0.29-0ubuntu0.20.04.3
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `division`
--

-- --------------------------------------------------------

--
-- Table structure for table `alamats`
--

CREATE TABLE `alamats` (
  `id` int NOT NULL,
  `id_customer` int DEFAULT NULL,
  `province` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `district` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `village` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `flag_delete` int NOT NULL DEFAULT '0',
  `flag_active` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `alamats`
--

INSERT INTO `alamats` (`id`, `id_customer`, `province`, `city`, `district`, `village`, `alamat`, `flag_delete`, `flag_active`, `created_at`, `updated_at`) VALUES
(17, 27, '31', '3173', '317304', '3173041002', 'Rt 06 rw 05', 0, 1, '2022-06-19 23:19:38', '2022-06-19 23:19:38'),
(18, 28, '32', '3216', '321602', '3216022002', 'Kp Muara', 0, 1, '2022-06-20 00:18:33', '2022-06-20 00:18:33'),
(19, 29, '31', '3172', '317204', '3172041003', 'Kongsi', 0, 1, '2022-06-20 19:34:06', '2022-06-20 19:34:06'),
(20, 30, '12', '1202', '120205', '1202052004', 'lolol9ololololol', 0, 1, '2022-06-21 01:38:33', '2022-06-21 01:38:33'),
(21, 32, '14', '1403', '140303', '1403031010', 'arrrrrrrrrrrrrrrrrrrr', 0, 1, '2022-06-21 02:04:06', '2022-06-21 03:45:51'),
(22, 33, '11', '1103', '110303', '1103032006', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 0, 1, '2022-06-21 02:05:03', '2022-06-21 03:52:25'),
(23, 33, '31', '3172', '317204', '3172041003', 'assasasasasasasasasas', 0, 1, '2022-06-21 02:08:38', '2022-06-21 02:08:38'),
(24, 32, '13', '1301', '130101', '3171021003', 'awawawawawawaw', 0, 1, '2022-06-21 02:10:11', '2022-06-21 02:10:11'),
(25, 34, '13', '1303', '130303', '1101012001', '123', 0, 1, '2022-06-21 03:51:26', '2022-06-21 04:01:45'),
(26, 35, '34', '3404', '340405', '3404052003', '12', 0, 1, '2022-06-21 03:53:02', '2022-06-21 04:01:17'),
(27, 36, '31', '3172', '317202', '3172021007', 'kakas', 0, 1, '2022-06-21 04:03:27', '2022-06-21 04:04:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alamats`
--
ALTER TABLE `alamats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_customer` (`id_customer`),
  ADD KEY `province` (`province`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alamats`
--
ALTER TABLE `alamats`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
