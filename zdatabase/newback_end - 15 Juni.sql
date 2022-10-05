-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 15, 2022 at 01:53 PM
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
-- Database: `newback_end`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int NOT NULL,
  `brand_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brand_name`) VALUES
(1, 'Samsul'),
(2, 'Iphone');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`) VALUES
(1, 'IPL'),
(2, 'BASIC-FACIAL'),
(3, 'LASER'),
(4, 'HIFU'),
(5, 'JVR'),
(6, 'EPN');

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `id` int NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `content` longtext,
  `flag_ket` int NOT NULL DEFAULT '0',
  `flag_delete` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`id`, `nama`, `content`, `flag_ket`, `flag_delete`, `active`) VALUES
(1, 'config_no_telp_pusat 1', 'testing', 0, 1, 1),
(2, 'config1', 'asdafaqweqw', 0, 1, 0),
(3, 'style header biru', 'color: blue', 0, 0, 0),
(4, 'aaaa', 'test', 1, 0, 1),
(5, 'naju', 't', 1, 0, 1),
(6, 'url_barcode', 'http://127.0.0.1:8000/showproducts/qr_code/', 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `division`
--

CREATE TABLE `division` (
  `id_division` int NOT NULL,
  `division_name` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  `flag_delete` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `division`
--

INSERT INTO `division` (`id_division`, `division_name`, `created_at`, `updated_at`, `active`, `flag_delete`) VALUES
(1, 'IT', '2022-04-30 17:00:00', '2022-04-30 17:00:00', 1, 0),
(2, 'Design', '2022-04-30 17:00:00', '2022-04-30 17:00:00', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `barcode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `satuan` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  `qr_code` text,
  `url_qr_code` varchar(255) DEFAULT NULL,
  `deksripsi` text NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `spesifikasi` text NOT NULL,
  `supplier` varchar(255) NOT NULL,
  `brand_id` int NOT NULL,
  `category_id` int NOT NULL,
  `kode_products` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `updated_by` int DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `flag_delete` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `nama`, `barcode`, `satuan`, `slug`, `active`, `qr_code`, `url_qr_code`, `deksripsi`, `image`, `spesifikasi`, `supplier`, `brand_id`, `category_id`, `kode_products`, `created_at`, `updated_at`, `updated_by`, `created_by`, `flag_delete`) VALUES
(1, 'baju', '1125860677', 'kg', 'baju', 1, NULL, NULL, '', '', '', '', 0, 0, '', '2022-06-06 06:28:33', '2022-06-06 06:28:33', 1, 1, 0),
(187, 'testing coba', '202206150404071', 'gr', 'testing_coba', 1, '<svg  xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\" width=\"250\" height=\"250\" viewBox=\"0 0 250 250\"><rect x=\"0\" y=\"0\" width=\"250\" height=\"250\" fill=\"#ffffff\"/><g transform=\"scale(7.576)\"><g transform=\"translate(0,0)\"><path fill-rule=\"evenodd\" d=\"M8 0L8 1L10 1L10 0ZM14 0L14 2L11 2L11 4L10 4L10 3L9 3L9 2L8 2L8 5L9 5L9 6L8 6L8 7L9 7L9 8L8 8L8 9L7 9L7 8L6 8L6 9L7 9L7 10L6 10L6 11L7 11L7 10L8 10L8 9L9 9L9 10L10 10L10 9L9 9L9 8L10 8L10 7L11 7L11 8L12 8L12 7L13 7L13 6L14 6L14 8L15 8L15 6L14 6L14 3L15 3L15 5L16 5L16 8L18 8L18 10L20 10L20 11L18 11L18 12L16 12L16 11L17 11L17 10L16 10L16 11L14 11L14 10L15 10L15 9L14 9L14 10L13 10L13 11L11 11L11 13L10 13L10 12L9 12L9 11L8 11L8 14L6 14L6 13L7 13L7 12L6 12L6 13L5 13L5 15L4 15L4 12L3 12L3 11L2 11L2 10L0 10L0 11L2 11L2 14L0 14L0 15L1 15L1 16L2 16L2 15L3 15L3 16L4 16L4 17L5 17L5 15L8 15L8 17L7 17L7 16L6 16L6 17L7 17L7 18L3 18L3 17L0 17L0 18L1 18L1 19L0 19L0 22L1 22L1 20L2 20L2 22L3 22L3 23L1 23L1 24L0 24L0 25L1 25L1 24L3 24L3 23L4 23L4 25L7 25L7 24L6 24L6 23L9 23L9 21L10 21L10 20L9 20L9 21L8 21L8 20L6 20L6 19L7 19L7 18L8 18L8 19L9 19L9 18L10 18L10 17L12 17L12 18L11 18L11 19L12 19L12 20L11 20L11 21L12 21L12 22L11 22L11 23L14 23L14 22L15 22L15 21L16 21L16 20L15 20L15 21L14 21L14 20L13 20L13 18L14 18L14 17L12 17L12 16L14 16L14 15L15 15L15 16L16 16L16 17L15 17L15 19L16 19L16 18L17 18L17 14L16 14L16 13L19 13L19 14L18 14L18 15L19 15L19 17L18 17L18 19L17 19L17 21L18 21L18 20L19 20L19 22L18 22L18 23L19 23L19 22L22 22L22 26L21 26L21 29L20 29L20 32L19 32L19 31L17 31L17 33L18 33L18 32L19 32L19 33L22 33L22 32L23 32L23 29L25 29L25 30L24 30L24 32L25 32L25 33L26 33L26 32L27 32L27 33L28 33L28 32L30 32L30 33L31 33L31 32L30 32L30 29L32 29L32 30L33 30L33 29L32 29L32 28L33 28L33 27L32 27L32 28L31 28L31 26L30 26L30 24L29 24L29 23L28 23L28 24L26 24L26 23L27 23L27 22L28 22L28 21L26 21L26 20L29 20L29 21L30 21L30 22L31 22L31 24L32 24L32 25L33 25L33 24L32 24L32 23L33 23L33 21L31 21L31 20L30 20L30 18L31 18L31 19L32 19L32 20L33 20L33 19L32 19L32 18L33 18L33 16L31 16L31 14L32 14L32 13L30 13L30 14L28 14L28 15L27 15L27 14L26 14L26 13L25 13L25 10L26 10L26 11L27 11L27 13L29 13L29 12L28 12L28 11L31 11L31 12L32 12L32 11L33 11L33 8L32 8L32 9L31 9L31 8L28 8L28 9L26 9L26 8L25 8L25 4L24 4L24 9L23 9L23 10L22 10L22 8L23 8L23 6L22 6L22 4L23 4L23 2L24 2L24 0L20 0L20 1L21 1L21 2L20 2L20 3L19 3L19 4L17 4L17 3L15 3L15 0ZM17 0L17 2L18 2L18 1L19 1L19 0ZM22 1L22 2L21 2L21 3L20 3L20 4L22 4L22 2L23 2L23 1ZM12 3L12 5L10 5L10 6L9 6L9 7L10 7L10 6L11 6L11 7L12 7L12 5L13 5L13 3ZM16 4L16 5L17 5L17 4ZM18 5L18 6L17 6L17 7L18 7L18 8L20 8L20 9L21 9L21 8L22 8L22 6L21 6L21 7L20 7L20 6L19 6L19 5ZM18 6L18 7L19 7L19 6ZM0 8L0 9L4 9L4 11L5 11L5 9L4 9L4 8ZM24 9L24 10L25 10L25 9ZM28 9L28 10L27 10L27 11L28 11L28 10L31 10L31 11L32 11L32 10L31 10L31 9ZM21 10L21 12L19 12L19 13L20 13L20 14L21 14L21 15L23 15L23 17L25 17L25 18L22 18L22 17L21 17L21 20L20 20L20 21L21 21L21 20L22 20L22 21L24 21L24 22L25 22L25 23L26 23L26 22L25 22L25 21L24 21L24 20L26 20L26 15L25 15L25 14L24 14L24 13L23 13L23 14L22 14L22 10ZM12 12L12 14L11 14L11 16L12 16L12 14L13 14L13 15L14 15L14 14L13 14L13 13L15 13L15 12ZM15 14L15 15L16 15L16 14ZM24 15L24 16L25 16L25 15ZM28 15L28 16L30 16L30 15ZM8 17L8 18L9 18L9 17ZM19 17L19 19L20 19L20 17ZM27 17L27 18L28 18L28 17ZM31 17L31 18L32 18L32 17ZM2 18L2 20L3 20L3 22L4 22L4 23L6 23L6 22L7 22L7 21L6 21L6 20L5 20L5 21L6 21L6 22L4 22L4 20L3 20L3 18ZM22 19L22 20L23 20L23 19ZM16 22L16 23L17 23L17 22ZM20 23L20 24L14 24L14 26L13 26L13 24L12 24L12 25L11 25L11 24L8 24L8 26L9 26L9 27L10 27L10 25L11 25L11 28L12 28L12 29L13 29L13 28L12 28L12 26L13 26L13 27L14 27L14 30L13 30L13 33L15 33L15 32L16 32L16 30L17 30L17 26L18 26L18 27L19 27L19 28L20 28L20 26L19 26L19 25L21 25L21 23ZM16 25L16 26L14 26L14 27L15 27L15 29L16 29L16 26L17 26L17 25ZM25 25L25 28L28 28L28 25ZM26 26L26 27L27 27L27 26ZM29 26L29 29L28 29L28 31L27 31L27 32L28 32L28 31L29 31L29 29L30 29L30 26ZM23 27L23 28L22 28L22 29L23 29L23 28L24 28L24 27ZM9 28L9 29L8 29L8 33L9 33L9 29L10 29L10 28ZM18 29L18 30L19 30L19 29ZM26 29L26 30L27 30L27 29ZM10 30L10 31L11 31L11 32L10 32L10 33L11 33L11 32L12 32L12 31L11 31L11 30ZM21 30L21 32L22 32L22 30ZM25 31L25 32L26 32L26 31ZM32 31L32 32L33 32L33 31ZM0 0L0 7L7 7L7 0ZM1 1L1 6L6 6L6 1ZM2 2L2 5L5 5L5 2ZM26 0L26 7L33 7L33 0ZM27 1L27 6L32 6L32 1ZM28 2L28 5L31 5L31 2ZM0 26L0 33L7 33L7 26ZM1 27L1 32L6 32L6 27ZM2 28L2 31L5 31L5 28Z\" fill=\"#000000\"/></g></g></svg>', 'http://127.0.0.1:8000/showproducts/qr_code/HRC-165526584744187', 'adaawaw', 'C:\\fakepath\\Sakura.jpg', 'awawawaw', 'awawawawa', 2, 3, 'baju123', NULL, NULL, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id_role` int NOT NULL,
  `role_name` varchar(100) DEFAULT NULL,
  `flag_delete` int NOT NULL DEFAULT '0',
  `active` int NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id_role`, `role_name`, `flag_delete`, `active`, `created_at`, `updated_at`) VALUES
(1, 'admin', 0, 1, '2022-05-26 17:00:00', '2022-05-26 17:00:00'),
(2, 'user', 0, 1, '2022-05-26 17:00:00', '2022-05-26 17:00:00'),
(3, 'guest', 0, 1, '2022-05-26 17:00:00', '2022-05-26 17:00:00'),
(99, 'superadmin', 0, 1, '2022-05-26 17:00:00', '2022-05-26 17:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_division` int NOT NULL DEFAULT '1',
  `join_date` datetime DEFAULT NULL,
  `mobile` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` int NOT NULL DEFAULT '1',
  `id_role` int NOT NULL DEFAULT '3',
  `flag_delete` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `id_division`, `join_date`, `mobile`, `active`, `id_role`, `flag_delete`) VALUES
(1, 'superuser', 'superuser', 'superuser@admin.com', NULL, '$2y$10$SFwa85IFn61XbJGjjg5P3uTOY4hSWY..aqhJaPoFL2BUeZULECfjS', NULL, '2022-05-27 06:22:29', '2022-05-26 06:22:29', 1, '2022-05-25 00:00:00', '08775884515', 1, 99, 0),
(2, 'Joko', 'admin1', 'admin1@admin.com', NULL, '$2y$10$SFwa85IFn61XbJGjjg5P3uTOY4hSWY..aqhJaPoFL2BUeZULECfjS', NULL, '2022-05-27 06:22:29', '2022-05-26 06:22:29', 2, '2022-05-25 00:00:00', '08775884515', 1, 1, 0),
(3, 'Budi', 'itbudi', 'it1@admin.com', NULL, '$2y$10$SFwa85IFn61XbJGjjg5P3uTOY4hSWY..aqhJaPoFL2BUeZULECfjS', NULL, '2022-05-27 06:22:29', '2022-05-27 23:31:47', 1, '2022-05-25 00:00:00', '08775884515', 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_access`
--

CREATE TABLE `user_access` (
  `id_access` int NOT NULL,
  `id_users` int DEFAULT '0',
  `name_access` varchar(100) DEFAULT NULL,
  `key_access` varchar(10) DEFAULT NULL,
  `val_access` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_access`
--

INSERT INTO `user_access` (`id_access`, `id_users`, `name_access`, `key_access`, `val_access`) VALUES
(1, 2, 'users', 'view', 1),
(2, 2, 'users', 'add', 1),
(3, 2, 'users', 'edit', 1),
(4, 2, 'users', 'delete', 1),
(5, 2, 'users', 'import', 1),
(6, 2, 'users', 'export', 1),
(7, 3, 'users', 'view', 1),
(8, 3, 'users', 'add', 1),
(9, 3, 'users', 'edit', 1),
(10, 3, 'users', 'delete', 1),
(11, 3, 'users', 'import', 1),
(12, 3, 'users', 'export', 1),
(13, 2, 'divisi', 'view', 1),
(14, 2, 'divisi', 'add', 1),
(15, 2, 'divisi', 'edit', 1),
(16, 2, 'divisi', 'delete', 1),
(17, 2, 'divisi', 'import', 1),
(18, 2, 'divisi', 'export', 1),
(19, 3, 'divisi', 'view', 1),
(20, 3, 'divisi', 'add', 1),
(21, 3, 'divisi', 'edit', 1),
(22, 3, 'divisi', 'delete', 1),
(23, 3, 'divisi', 'import', 1),
(24, 3, 'divisi', 'export', 1),
(25, 2, 'role', 'add', 1),
(26, 2, 'role', 'view', 1),
(27, 3, 'role', 'export', 1),
(28, 3, 'role', 'import', 1),
(29, 3, 'role', 'delete', 1),
(30, 3, 'role', 'edit', 1),
(31, 3, 'role', 'add', 1),
(32, 3, 'role', 'view', 1),
(33, 2, 'role', 'export', 1),
(34, 2, 'role', 'import', 1),
(35, 2, 'role', 'delete', 1),
(36, 2, 'role', 'edit', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `division`
--
ALTER TABLE `division`
  ADD PRIMARY KEY (`id_division`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `images` (`active`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_access`
--
ALTER TABLE `user_access`
  ADD PRIMARY KEY (`id_access`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `division`
--
ALTER TABLE `division`
  MODIFY `id_division` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id_role` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_access`
--
ALTER TABLE `user_access`
  MODIFY `id_access` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
