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
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_tlp` varchar(100) NOT NULL,
  `active` int NOT NULL DEFAULT '1',
  `flag_delete` int NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `no_tlp`, `active`, `flag_delete`, `created_at`, `updated_at`) VALUES
(1, 'Test plugin', 'superuser@admin.com', '081558796392', 1, 0, '0000-00-00 00:00:00', '2022-06-18 01:01:57'),
(5, 'Dedi wibowo', 'ade@hercaweb.com', '081558796392', 1, 0, '2022-06-16 03:08:14', '2022-06-16 03:25:13'),
(28, 'idam', 'idam@gmail.com', 'sadsadsadsadsadsad', 0, 0, '2022-06-20 00:18:33', '2022-06-21 01:37:27'),
(29, 'Ahmad Fazri Nursamsi', 'fazri@gmail.com', '089535947078991', 1, 0, '2022-06-20 19:34:06', '2022-06-21 21:32:49'),
(30, 'absen', 'asdsadsadasdsad', 'asdsadasdasdasd', 1, 0, '2022-06-21 01:38:33', '2022-06-21 01:38:33'),
(31, 'dsfdsfdsf', 'dsfsdfds', 'fdsfdsfdsfdsf', 0, 0, '2022-06-21 02:03:15', '2022-06-21 02:03:15'),
(32, 'ahmad fazzzz', 'wq asdaaaaaaaaaa', 'qw asd', 0, 0, '2022-06-21 02:04:06', '2022-06-21 03:45:51'),
(33, 'asdsadsadsadsad', 'sadsadsadsadsadsad', 'sadsadsadsadsadsadsadsad', 1, 0, '2022-06-21 02:05:03', '2022-06-21 03:55:24'),
(34, 'Ahmad FAzriiiiiii', 'aabiyyu.bpp@gmail.com', 'asdsadsadsad', 0, 0, '2022-06-21 03:51:26', '2022-06-21 21:32:43'),
(35, '00000000000000000000', '00000000000000000000', '000000000000000000000000', 0, 0, '2022-06-21 03:53:02', '2022-06-21 04:00:12'),
(36, 'Ahmasss', '12', '12', 0, 0, '2022-06-21 04:03:27', '2022-06-21 04:03:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`,`email`,`no_tlp`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
