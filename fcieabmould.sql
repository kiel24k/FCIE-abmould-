-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 02, 2024 at 04:01 AM
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
-- Table structure for table `histories`
--

CREATE TABLE `histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `item_code` varchar(255) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `change_by_name` varchar(255) NOT NULL,
  `made` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `histories`
--

INSERT INTO `histories` (`id`, `date`, `category`, `item_code`, `barcode`, `change_by_name`, `made`, `created_at`, `updated_at`) VALUES
(1, '24/09/01', 'materials', 'dsad', '263856', '1', 'Updated', '2024-09-01 00:14:57', '2024-09-01 00:14:57'),
(2, '24/09/01', 'materials', 'dsad', '263856', 'Admin111111', 'Updated', '2024-09-01 00:15:59', '2024-09-01 00:15:59'),
(3, '24/09/01', 'materials', 'dsad', '263856', 'Admin111111', 'Updated', '2024-09-01 00:36:06', '2024-09-01 00:36:06'),
(4, '24/09/01', 'materials', 'dsad', '263856', 'Admin111111', 'Updated', '2024-09-01 17:28:09', '2024-09-01 17:28:09'),
(5, '24/09/01', 'materials', 'dsad', '263856', 'Admin111111', 'Deleted', '2024-09-01 17:31:04', '2024-09-01 17:31:04');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_code` varchar(255) DEFAULT NULL,
  `supplier_name` varchar(255) DEFAULT NULL,
  `unit_cost` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `barcode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `item_code`, `supplier_name`, `unit_cost`, `quantity`, `category`, `description`, `brand`, `created_at`, `updated_at`, `barcode`) VALUES
(1, 'dsad', '232', 323.00, 197, 'materials', 'dsadasd', 'asdsa', '2024-08-31 23:49:20', '2024-09-01 17:31:03', '263856');

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
(33, '0001_01_01_000000_create_users_table', 1),
(34, '0001_01_01_000001_create_cache_table', 1),
(35, '0001_01_01_000002_create_jobs_table', 1),
(36, '2024_07_22_023503_create_personal_access_tokens_table', 1),
(37, '2024_07_23_183742_add_tel_no_to_users_table', 1),
(38, '2024_07_24_054654_add_image_to_users_table', 1),
(42, '2024_07_25_011501_create_tools__inventories_table', 2),
(63, '2024_07_25_073535_create_schedules_table', 3),
(64, '2024_07_28_045324_create_items_table', 3),
(65, '2024_08_14_040614_add_barcode_to_items_table', 3),
(66, '2024_08_15_122928_create_announcements_table', 3),
(69, '2024_09_01_033255_history', 4);

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
(1, 'App\\Models\\User', 1, 'admin@example.com', '4cb3a2cbd35a3e39094d1ed111eb9956429b570cce1de74d6f97b7b6a7d9111c', '[\"*\"]', '2024-07-24 14:11:07', NULL, '2024-07-24 14:11:06', '2024-07-24 14:11:07'),
(2, 'App\\Models\\User', 1, 'admin@example.com', '489aaaf8730b6fdaee0ec71283cd6c905bf696c1016597a454d64ee5a4c037b2', '[\"*\"]', '2024-07-24 14:11:24', NULL, '2024-07-24 14:11:23', '2024-07-24 14:11:24'),
(3, 'App\\Models\\User', 1, 'admin@example.com', '07e6f834f48e2d857667bc518734d7579600d74275466e641e81c4cff795670b', '[\"*\"]', '2024-07-24 17:42:40', NULL, '2024-07-24 14:12:10', '2024-07-24 17:42:40'),
(4, 'App\\Models\\User', 2, 'yusername0123@gmail.com', '8634e98ea937e3ca3665be3c33df03ec081c02062584e960c6985e077f4d2e76', '[\"*\"]', '2024-07-24 17:43:09', NULL, '2024-07-24 17:42:58', '2024-07-24 17:43:09'),
(5, 'App\\Models\\User', 1, 'admin@example.com', 'dbd9a06ba2e99302fe28290cb73029d4945ab85a913f2d59d86ef29cd995dd09', '[\"*\"]', '2024-07-24 17:44:07', NULL, '2024-07-24 17:43:31', '2024-07-24 17:44:07'),
(6, 'App\\Models\\User', 2, 'yusername0123@gmail.com', 'bbebb9af09daddd0293b7d9569c802c4a1a064dd45eb9031228369fe7863d0eb', '[\"*\"]', '2024-07-27 19:48:08', NULL, '2024-07-24 17:44:15', '2024-07-27 19:48:08'),
(7, 'App\\Models\\User', 1, 'admin@example.com', 'd313f647fb572764554c855da3693c6ac5b3480194240ab650841f990effeb3d', '[\"*\"]', '2024-07-30 22:51:52', NULL, '2024-07-27 19:48:25', '2024-07-30 22:51:52'),
(8, 'App\\Models\\User', 2, 'yusername0123@gmail.com', '76be4e126a18108ad8e51d423ee5dc36f97edd70e6d5f5dffdaad7f5c9ce83e9', '[\"*\"]', '2024-07-30 22:54:47', NULL, '2024-07-30 22:53:12', '2024-07-30 22:54:47'),
(9, 'App\\Models\\User', 2, 'user@gmail.com', 'ad75f6acc06457eed2d52ccf5f3963429dfe8d4a4e50c9762a0ccd23a4a324bc', '[\"*\"]', '2024-07-30 23:03:45', NULL, '2024-07-30 22:54:57', '2024-07-30 23:03:45'),
(10, 'App\\Models\\User', 1, 'admin@example.com', 'a0b702ee3bf9eb01d7cce821c4a8bde94301cd4e61a9b51e0aa7172e7c3b9c2c', '[\"*\"]', '2024-08-31 09:18:34', NULL, '2024-08-31 09:05:12', '2024-08-31 09:18:34'),
(11, 'App\\Models\\User', 1, 'admin@example.com', '47b9ac85a240d783594d961661c8be9c25c37cf06ad72df5eb3d39ffb6182f9c', '[\"*\"]', '2024-09-01 17:22:09', NULL, '2024-08-31 18:47:08', '2024-09-01 17:22:09'),
(12, 'App\\Models\\User', 1, 'admin@example.com', '7ad64c40403d1faa241f94dc77ac652b5772d6c87bea31f1f753e447f76c8283', '[\"*\"]', '2024-09-01 17:55:15', NULL, '2024-09-01 17:23:18', '2024-09-01 17:55:15'),
(13, 'App\\Models\\User', 3, 'IM@gmail.com', '59627fca311c62e26464a94eee52b194d654d60ceb68c662efe361b4222c186c', '[\"*\"]', '2024-09-01 18:00:05', NULL, '2024-09-01 17:58:04', '2024-09-01 18:00:05');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `item_code` varchar(255) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
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
('18BtTItEv6IK9jlMBxGa59w5LkfUfSExruIX1yBz', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 Edg/127.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNWE2WGQwRDBOYzBycTh4MU9ucHlrb3oxOEpZdmp5Z3k1V2lhRm5NaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9pbnZlbnRvcnktbWFuYWdlci1kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1722409417);

-- --------------------------------------------------------

--
-- Table structure for table `tool_inventories`
--

CREATE TABLE `tool_inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item_code` varchar(255) DEFAULT NULL,
  `brand` varchar(255) NOT NULL,
  `supplier_name` varchar(255) DEFAULT NULL,
  `unit_cost` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `item_type` enum('new','old') NOT NULL,
  `description` varchar(255) NOT NULL,
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
  `middle_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `role` enum('admin','inventory-manager','member') NOT NULL,
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
(1, 'Admin111111', 'Kiel', 'olok', 'admin', 'admin@gmail.com', '2024-07-24 02:19:07', '$2y$12$4wtE1hCOL7NmXFpWiB1tA.u5jEHX6xokSradY2nEQCzT2/NoFmB/C', 'CfPxM8h6v6', '2024-07-24 02:19:07', '2024-08-31 18:47:17', '09193471522', 'kTswGn7u9LR6EfIA8COcxgPMIPCROT7w4RiMWYlZ.png'),
(2, 'Kiel', 'si kiel', 'Bermudez', 'member', 'member@gmail.com', NULL, '$2y$12$Fy9M0e8.difntXqFsT9OceLyco2fOES8Oacoq5jX8BH/p9jjFv2Nq', NULL, '2024-07-24 17:42:40', '2024-08-31 09:17:53', '09193471522', 'SFwBwcVZwEoRterYYKEW2r044ns2QHfAh6ZFolS3.png'),
(3, 'Im_Manager', 'Inventory_manager', 'Im_Manager', 'inventory-manager', 'IM@gmail.com', NULL, '$2y$12$3PQWp5U5U1F0an/g/HuXvu00rHQyEsc3MC3jIUAGT9yqmz7lARmYO', NULL, '2024-08-31 09:07:14', '2024-08-31 09:07:14', '09193471522', NULL);

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `histories`
--
ALTER TABLE `histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
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
-- Indexes for table `tool_inventories`
--
ALTER TABLE `tool_inventories`
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
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `histories`
--
ALTER TABLE `histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tool_inventories`
--
ALTER TABLE `tool_inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
