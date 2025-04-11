-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2025 at 05:36 AM
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
-- Database: `fcieabmould`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `details` varchar(255) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `details`, `release_date`, `created_at`, `updated_at`) VALUES
(1, 'MISTSUBISHI', NULL, '2025-04-11', '2025-04-10 19:02:34', '2025-04-10 19:02:34'),
(2, 'MATERIALS', NULL, '2025-04-11', '2025-04-10 19:03:15', '2025-04-10 19:03:15'),
(3, 'TOOLS', NULL, '2025-04-11', '2025-04-10 19:03:21', '2025-04-10 19:03:21'),
(4, 'FABRIC', NULL, '2025-04-11', '2025-04-10 19:03:26', '2025-04-10 19:03:26'),
(5, 'FIBERS', NULL, '2025-04-11', '2025-04-10 19:03:52', '2025-04-10 19:03:52');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `item_code` varchar(255) DEFAULT NULL,
  `supplier_name` varchar(255) DEFAULT NULL,
  `unit_cost` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `treshold` int(11) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `user_id`, `item_code`, `supplier_name`, `unit_cost`, `quantity`, `treshold`, `category`, `description`, `brand`, `release_date`, `created_at`, `updated_at`, `barcode`) VALUES
(1, 1, 'FLTENDz', NULL, 0.00, 3, 1000, 'TOOLS', 'FLAT ENDMILL 1 X 4', 'MITSUBISHI', '2025-04-11', '2025-04-10 19:07:45', '2025-04-10 19:07:45', NULL),
(2, 1, 'FLTEND3', NULL, 3.00, 50, 100, 'TOOLS', 'FLAT ENDMILL 1.5 X 6', 'MITSUBISHI', '2025-04-11', '2025-04-10 19:10:01', '2025-04-10 19:10:01', NULL),
(3, 1, 'FLTEND2.5', NULL, 3.00, 50, 100, 'TOOLS', 'FLAT ENDMILL 2 x 5', 'MITSUBISHI', '2025-04-11', '2025-04-10 19:11:29', '2025-04-10 19:11:29', NULL),
(4, 1, 'FLTEND4', NULL, 0.00, 25, 1000, 'TOOLS', 'FLAT ENDMIL 2 X 8', 'MITSUBISHI', '2025-04-11', '2025-04-10 19:12:47', '2025-04-10 19:12:47', NULL),
(5, 1, 'FLTEND7', NULL, 0.00, 50, 1000, 'TOOLS', 'FLAT ENDMILL 6 X 15', NULL, '2025-04-11', '2025-04-10 19:14:09', '2025-04-10 19:14:09', NULL),
(6, 1, 'ABRAS', 'SAKAMOTO', 0.00, 100, 500, 'MATERIALS', 'ABRASIVE CUTTING WHEELS - HEIWA 160 X 0.7 X 25.4', NULL, '2025-04-11', '2025-04-10 19:15:28', '2025-04-10 19:16:53', NULL),
(7, 1, 'ABRAS1', NULL, 0.00, 49, 500, 'MATERIALS', 'ABRASIVE CLOTH GRIT 0', NULL, '2025-04-11', '2025-04-10 19:16:24', '2025-04-10 19:16:24', NULL),
(8, 1, 'ABRAS2', NULL, 0.00, 38, 200, 'MATERIALS', 'ABRASIVE CLOTH GRIT 240', NULL, '2025-04-11', '2025-04-10 19:18:15', '2025-04-10 19:18:15', NULL),
(9, 1, 'ABRASG15', 'CBC', 15.00, 95, 100, 'MATERIALS', 'ABRASIVE PAPER (SANDAPER) GRIT 120', NULL, '2025-04-11', '2025-04-10 19:19:20', '2025-04-10 19:19:20', NULL),
(10, 1, 'ABRASG16', 'CBC', 0.00, 102, 400, 'MATERIALS', 'ABRASIVE PAPER (SANDPAPER) GRIT 180', NULL, '2025-04-11', '2025-04-10 19:20:17', '2025-04-10 19:20:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `item_logs`
--

CREATE TABLE `item_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `action` enum('created','update','deleted') NOT NULL,
  `date_created` date NOT NULL,
  `time` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_logs`
--

INSERT INTO `item_logs` (`id`, `user_id`, `action`, `date_created`, `time`, `created_at`, `updated_at`) VALUES
(1, 1, 'created', '2025-04-11', '11:11 AM', '2025-04-10 19:11:29', '2025-04-10 19:11:29'),
(2, 1, 'created', '2025-04-11', '11:12 AM', '2025-04-10 19:12:47', '2025-04-10 19:12:47'),
(3, 1, 'created', '2025-04-11', '11:14 AM', '2025-04-10 19:14:09', '2025-04-10 19:14:09'),
(4, 1, 'created', '2025-04-11', '11:15 AM', '2025-04-10 19:15:28', '2025-04-10 19:15:28'),
(5, 1, 'created', '2025-04-11', '11:16 AM', '2025-04-10 19:16:24', '2025-04-10 19:16:24'),
(6, 1, 'update', '2025-04-11', '11:16 AM', '2025-04-10 19:16:53', '2025-04-10 19:16:53'),
(7, 1, 'created', '2025-04-11', '11:18 AM', '2025-04-10 19:18:15', '2025-04-10 19:18:15'),
(8, 1, 'created', '2025-04-11', '11:19 AM', '2025-04-10 19:19:20', '2025-04-10 19:19:20'),
(9, 1, 'created', '2025-04-11', '11:20 AM', '2025-04-10 19:20:17', '2025-04-10 19:20:17');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(49, '0001_01_01_000000_create_users_table', 1),
(50, '0001_01_01_000001_create_cache_table', 1),
(51, '0001_01_01_000002_create_jobs_table', 1),
(52, '2024_07_22_023503_create_personal_access_tokens_table', 1),
(53, '2024_07_23_183742_add_tel_no_to_users_table', 1),
(54, '2024_07_24_054654_add_image_to_users_table', 1),
(55, '2024_07_25_073535_create_schedules_table', 1),
(56, '2024_07_28_045324_create_items_table', 1),
(57, '2024_08_14_040614_add_barcode_to_items_table', 1),
(58, '2024_08_15_122928_create_announcements_table', 1),
(59, '2024_11_02_031133_create_scanned__items_table', 1),
(60, '2024_11_02_073010_create_scanned_items_outs_table', 1),
(61, '2025_02_24_072727_create_notifications_table', 1),
(62, '2025_03_12_152406_create_categories_table', 1),
(63, '2025_03_26_151634_create_stock_logs_table', 1),
(64, '2025_03_27_230103_create_item_logs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `message` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'admin@gmail.com', '6379de989ebbcf9a70daf34054f2847d340ba9207f8034e053fc4b07048f5965', '[\"*\"]', '2025-04-10 19:35:52', NULL, '2025-04-10 19:02:05', '2025-04-10 19:35:52');

-- --------------------------------------------------------

--
-- Table structure for table `scanned_items_outs`
--

CREATE TABLE `scanned_items_outs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `item_id` bigint(20) NOT NULL,
  `category` varchar(255) NOT NULL,
  `item_code` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `unit_cost` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `scanned__items`
--

CREATE TABLE `scanned__items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `item_id` bigint(20) NOT NULL,
  `category` varchar(255) NOT NULL,
  `item_code` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `unit_cost` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `item_code` varchar(255) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `status` enum('pending','approved','not-approved','released') NOT NULL,
  `date_schedule` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('njXCu8o0rFJxHWV4GYkAMFUOeSnSFu0JDPWGDGy6', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36 Edg/135.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT2U2UGNKanNEVUthRzJxQWdXUHk4ZW9YSzQ3YWM3YXVpNnF1cndHSSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9Vc2VySW1hZ2UvdW5kZWZpbmVkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1744342552);

-- --------------------------------------------------------

--
-- Table structure for table `stock_logs`
--

CREATE TABLE `stock_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `action` enum('treshold','quantity') NOT NULL,
  `date_released` date NOT NULL,
  `time` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `role` enum('admin','inventory-manager','member','TL') DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tel_no` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `middle_name`, `last_name`, `role`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `tel_no`, `image`) VALUES
(1, 'Kiel', 'Alarcon', 'Bermudez', 'admin', 'admin@gmail.com', NULL, '$2y$12$vrZA9VQF8q93P91VogLJ2.7sFPgXFcnMmQ54p8YVdVCy0tDqr4grC', NULL, NULL, '2025-04-10 19:28:00', '09193471522', 'UFYuAb5iQ4dBVwqxi1PDrmBvw4tuqBJ7knSFeTSU.jpg'),
(2, 'Angelica', 'S', 'Calingo', 'inventory-manager', 'inventory@gmail.com', NULL, '$2y$12$vJXaVSY7zKsBOOIaXebs2egBBy4CeTjx9WZ.eL0Pn2u.I6qDSojvC', NULL, '2025-04-10 19:29:39', '2025-04-10 19:29:39', '91934715222', 'gf6vkeHTC1HmZx5ey2V0Y8w3BXKwUl6GP7Rbjdqd.jpg'),
(3, 'Jazmine', NULL, 'Sanchez', 'TL', 'tl@gmail.com', NULL, '$2y$12$DdHgUhmlZ8rCx7yraJvxL.6s1G/X4CTeBHEC.ijaVTZ0C7k/Xig9O', NULL, '2025-04-10 19:32:58', '2025-04-10 19:32:58', '9193472612', 'ZICCyZMOJXu7Vgjfgqsj3mX36fBMY1MzGlzK4end.jpg'),
(4, 'Wincrich', NULL, 'Gloria', 'member', 'member@gmail.com', NULL, '$2y$12$KwtYYn2f/L6MbccYGf3FV.6MMcp2caO7FlEdRGZaXhPiitbVaqTga', NULL, '2025-04-10 19:33:41', '2025-04-10 19:33:41', '9456023942', 'hDf8Jb3DIZ9vqTBcNtlK3l1cY0gDk7r5fKD7nflZ.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_logs`
--
ALTER TABLE `item_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `scanned_items_outs`
--
ALTER TABLE `scanned_items_outs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scanned__items`
--
ALTER TABLE `scanned__items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stock_logs`
--
ALTER TABLE `stock_logs`
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
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `item_logs`
--
ALTER TABLE `item_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `scanned_items_outs`
--
ALTER TABLE `scanned_items_outs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scanned__items`
--
ALTER TABLE `scanned__items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stock_logs`
--
ALTER TABLE `stock_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
