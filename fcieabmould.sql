-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 16, 2025 at 06:02 AM
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
(1, 'COPPER-A', NULL, '2025-04-11', '2025-04-10 19:02:34', '2025-04-10 19:02:34'),
(2, 'MATERIALS', NULL, '2025-04-11', '2025-04-10 19:03:15', '2025-04-10 19:03:15'),
(3, 'TOOLS', NULL, '2025-04-11', '2025-04-10 19:03:21', '2025-04-10 19:03:21'),
(4, 'FABRIC', NULL, '2025-04-11', '2025-04-10 19:03:26', '2025-04-10 19:03:26'),
(5, 'FIBERS', NULL, '2025-04-11', '2025-04-10 19:03:52', '2025-04-10 19:03:52'),
(6, 'FABRIC2.5', NULL, '2025-04-30', '2025-04-30 01:02:37', '2025-04-30 01:02:37'),
(7, 'MATERIALS2.5', NULL, '2025-04-30', '2025-04-30 01:02:53', '2025-04-30 01:02:53'),
(8, 'UNIFORM-W', NULL, '2025-04-30', '2025-04-30 01:04:52', '2025-04-30 01:04:52'),
(9, 'NICKLE-T', NULL, '2025-04-30', '2025-04-30 01:05:01', '2025-04-30 01:05:01'),
(10, 'PPE-T', NULL, '2025-04-30', '2025-04-30 01:05:32', '2025-04-30 01:05:32'),
(11, 'UNI-W', NULL, '2025-04-30', '2025-04-30 01:13:32', '2025-04-30 01:13:32');

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
  `barcode` varchar(255) DEFAULT NULL,
  `total_cost` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `user_id`, `item_code`, `supplier_name`, `unit_cost`, `quantity`, `treshold`, `category`, `description`, `brand`, `release_date`, `created_at`, `updated_at`, `barcode`, `total_cost`) VALUES
(16, 1, '234HG', NULL, 22.00, 983, 5000, 'TOOLS', 'dasdsa', NULL, '2025-04-28', '2025-04-28 21:50:50', '2025-04-30 03:25:42', NULL, 21626),
(17, 1, 'FLTENDZ', NULL, 58.00, 397, 2323, 'MATERIALS', 'ABS X 103', 'MITSUBISHI', '2025-04-28', '2025-04-30 00:56:39', '2025-05-06 22:38:21', NULL, 23200),
(18, 1, 'FLTENDZ2.5', NULL, 90.00, 10, 500, 'TOOLS', '10 X 4', 'MITSYBISHI', '2025-05-14', '2025-04-30 00:57:35', '2025-04-30 00:57:35', NULL, 900),
(19, 1, 'FLTENDz3', NULL, 0.00, 100, 100, 'FABRIC', '10 X 56', NULL, '2025-05-14', '2025-04-30 00:58:43', '2025-05-06 23:31:41', NULL, 0),
(20, 1, 'FLTENDz4', NULL, 13.00, 100, 10002, 'MATERIALS', '14 x 20', NULL, '2025-04-30', '2025-04-30 00:59:35', '2025-05-06 22:58:16', NULL, 1300),
(21, 1, 'FLTENDz5', NULL, 100.00, 500, 1000, 'UNIFORM-W', '20 x 50', NULL, '2025-04-30', '2025-04-30 01:09:09', '2025-04-30 01:09:09', NULL, 50000),
(22, 1, 'FLTENDz6', NULL, 20.00, 25, 500, 'PPE-T', '2 x 10 M', NULL, '2025-05-30', '2025-04-30 01:10:01', '2025-04-30 01:10:01', NULL, 500),
(23, 1, 'FLTENDz7', NULL, 100.00, 20, 500, 'FABRIC2.5', 'none', NULL, '2025-04-30', '2025-04-30 01:10:37', '2025-04-30 01:10:37', NULL, 2000),
(24, 1, 'FLTENDz8a', NULL, 94.00, 25, 100, 'UNIFORM-W', 'M - L', NULL, '2025-04-09', '2025-04-30 01:11:32', '2025-04-30 01:11:32', NULL, 2350),
(25, 1, 'FLTENDB-A', NULL, 10.00, 21, 50012, 'NICKLE-T', 'N/A', NULL, '2025-04-30', '2025-04-30 01:12:42', '2025-05-06 22:59:23', NULL, 210),
(26, 1, 'FLTENDBs', NULL, 0.00, 100, 500, 'UNI-W', 'N/A', NULL, '2025-04-30', '2025-04-30 01:14:27', '2025-04-30 01:14:27', NULL, 0),
(27, 1, 'FLTENDBs-A', NULL, 212.00, 5, 1000, 'COPPER-A', 'N/A', NULL, '2025-04-30', '2025-04-30 01:15:50', '2025-05-06 23:04:16', NULL, 1060),
(28, 1, 'FLTENDd', NULL, 10.00, 20, 5009, 'MATERIALS2.5', 'N/A', NULL, '2025-04-30', '2025-04-30 01:16:42', '2025-05-06 23:23:56', NULL, 200),
(29, 1, 'FLTENDe', NULL, 100.00, 50, 100, 'UNIFORM-W', 'N/A', NULL, '2025-04-30', '2025-04-30 01:17:40', '2025-04-30 01:17:40', NULL, 5000),
(30, 1, 'FLTENDzr', NULL, 10.00, 10, 100, 'UNIFORM-W', 'N/A', NULL, '2025-04-30', '2025-04-30 01:18:03', '2025-04-30 01:18:03', NULL, 100),
(31, 1, 'FLTENDt', NULL, 100.00, 5, 1000, 'PPE-T', 'N/A', NULL, '2025-04-30', '2025-04-30 01:18:43', '2025-04-30 01:18:43', NULL, 500),
(32, 1, 'BUMBAY', 'Kiell', 2.00, 10, 20, 'NICKLE-T', 'dsadsa', 'SAMSUNG', '2025-05-07', '2025-05-07 01:07:33', '2025-05-07 01:07:33', NULL, 20);

-- --------------------------------------------------------

--
-- Table structure for table `item_logs`
--

CREATE TABLE `item_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `action` enum('created','update','deleted') NOT NULL,
  `date_created` date NOT NULL,
  `time` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `item_logs`
--

INSERT INTO `item_logs` (`id`, `user_id`, `item_id`, `action`, `date_created`, `time`, `created_at`, `updated_at`) VALUES
(56, 1, 16, 'update', '2025-05-07', '05:06 PM', '2025-05-07 01:06:31', '2025-05-07 01:06:31'),
(57, 1, 32, 'created', '2025-05-07', '05:07 PM', '2025-05-07 01:07:33', '2025-05-07 01:07:33');

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
(64, '2025_03_27_230103_create_item_logs_table', 1),
(65, '2025_04_27_095824_create_schedule_requests_table', 2);

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
(1, 'App\\Models\\User', 1, 'admin@gmail.com', '6379de989ebbcf9a70daf34054f2847d340ba9207f8034e053fc4b07048f5965', '[\"*\"]', '2025-04-26 08:44:45', NULL, '2025-04-10 19:02:05', '2025-04-26 08:44:45'),
(2, 'App\\Models\\User', 2, 'inventory@gmail.com', 'cd868192ba3ec648fbd2376307899f07a28ac82c20dcd2a5ad3c9f83b14f5619', '[\"*\"]', '2025-04-26 08:45:09', NULL, '2025-04-26 08:45:05', '2025-04-26 08:45:09'),
(3, 'App\\Models\\User', 1, 'admin@gmail.com', '58280cebc10170245d0bbb0a912aa3da36f740831dd2a475959d4a1c10deccc8', '[\"*\"]', '2025-04-26 08:50:49', NULL, '2025-04-26 08:50:00', '2025-04-26 08:50:49'),
(4, 'App\\Models\\User', 2, 'inventory@gmail.com', 'a7845d7849af008648346304603a47321385ae8323d90626a144071e932953c3', '[\"*\"]', '2025-04-26 08:59:02', NULL, '2025-04-26 08:53:05', '2025-04-26 08:59:02'),
(5, 'App\\Models\\User', 1, 'admin@gmail.com', 'ba87a7741997b42e0f35e43bda784afcb3b6f64b7099c726818095bb0696ab2d', '[\"*\"]', '2025-04-30 00:40:25', NULL, '2025-04-26 08:59:15', '2025-04-30 00:40:25'),
(6, 'App\\Models\\User', 2, 'inventory@gmail.com', '74ccc860f5dc9ac809bb01eb611f90a3f19dcf51ee41e0ffabf1e8c5df4dc7b9', '[\"*\"]', '2025-04-30 00:45:47', NULL, '2025-04-30 00:45:18', '2025-04-30 00:45:47'),
(7, 'App\\Models\\User', 3, 'tl@gmail.com', '2e8c31a4f83543629fee0768be5c7ca5b3993f86ff7abdad882ecb53f3b9396f', '[\"*\"]', '2025-04-30 00:49:38', NULL, '2025-04-30 00:48:01', '2025-04-30 00:49:38'),
(8, 'App\\Models\\User', 4, 'member@gmail.com', 'feefabc67a2818f27ce1e976d52bbbd772aed40e5fa81af08bf7bc05b6457376', '[\"*\"]', '2025-04-30 00:51:11', NULL, '2025-04-30 00:50:30', '2025-04-30 00:51:11'),
(9, 'App\\Models\\User', 1, 'admin@gmail.com', '3d1e00a6e273cc6f8ad2d2e2b26561234811a5280bf3a66ed132e3f8ab415c32', '[\"*\"]', '2025-05-07 00:31:34', NULL, '2025-04-30 00:51:45', '2025-05-07 00:31:34'),
(10, 'App\\Models\\User', 3, 'tl@gmail.com', '498606aa312bbdfae1ce10e9ad9066bb7887758ef64b73ebbc3ca03c32be2ab4', '[\"*\"]', '2025-05-07 00:48:41', NULL, '2025-05-07 00:48:40', '2025-05-07 00:48:41'),
(11, 'App\\Models\\User', 1, 'admin@gmail.com', '401a53ece341b4e256b50fe260f2770e1822d87810b9337b04f7886483987506', '[\"*\"]', '2025-05-12 22:07:38', NULL, '2025-05-07 00:49:18', '2025-05-12 22:07:38'),
(12, 'App\\Models\\User', 1, 'admin@gmail.com', '6423fefcff990b6fc4d268be70d5211c5e2e554ec978531880db9c0e271ff9fc', '[\"*\"]', '2025-05-13 23:35:32', NULL, '2025-05-12 22:09:47', '2025-05-13 23:35:32'),
(13, 'App\\Models\\User', 1, 'admin@gmail.com', '1e13209acb719602ea2c513d1791f853552422caa865c342dab31224e7810e0a', '[\"*\"]', '2025-05-13 23:41:13', NULL, '2025-05-13 23:36:13', '2025-05-13 23:41:13'),
(14, 'App\\Models\\User', 1, 'admin@gmail.com', '09efdcb6f964c4d6511a01fb72602d19ebd0f38bacb840076bd791efe8c9cd14', '[\"*\"]', '2025-05-14 00:43:31', NULL, '2025-05-13 23:41:29', '2025-05-14 00:43:31');

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
-- Table structure for table `schedule_requests`
--

CREATE TABLE `schedule_requests` (
  `schedule_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `schedule_quantity` varchar(255) NOT NULL,
  `schedule_date` date NOT NULL,
  `status` enum('pending','not-release','released') NOT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedule_requests`
--

INSERT INTO `schedule_requests` (`schedule_id`, `user_id`, `item_id`, `schedule_quantity`, `schedule_date`, `status`, `message`, `created_at`, `updated_at`) VALUES
(29, 1, 16, '3', '2025-05-06', 'released', NULL, '2025-04-28 21:56:17', '2025-04-28 22:00:25'),
(30, 1, 16, '4', '2025-04-22', 'not-release', NULL, '2025-04-28 21:59:17', '2025-04-28 22:00:17'),
(31, 1, 17, '3', '2025-04-23', 'released', NULL, '2025-04-30 03:20:46', '2025-04-30 03:22:55'),
(32, 1, 16, '1', '2025-05-15', 'pending', NULL, '2025-05-06 22:27:53', '2025-05-06 22:27:53'),
(33, 1, 18, '20', '2025-05-14', 'pending', NULL, '2025-05-13 19:59:14', '2025-05-13 19:59:14'),
(34, 1, 21, '1', '2026-03-05', 'pending', NULL, '2025-05-13 21:01:30', '2025-05-13 21:01:30'),
(35, 1, 17, '200', '2025-05-14', 'pending', NULL, '2025-05-13 23:46:57', '2025-05-13 23:46:57');

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
('3q1HzS836H7FqcnY8AV4srm4y8D5AgH6zmTmPhhF', NULL, '127.0.0.1', 'PostmanRuntime/7.43.4', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRTVzaUVwMk4xR2JqYmFKaTltV1pLOTJ2c3BLUDh6bHcyUWtCSjVLMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcGkvaXRlbS1saXN0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1747206153),
('dc8dtqmwPkbIT0QcocV1bv9nj1EWPE5U9DJ0UIHH', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36 Edg/136.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZlhXUWdiSmw0clhCSUtRY3hvTTZzd2lGeHA0RFdPUjhSMVlkUU5oYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1747212211);

-- --------------------------------------------------------

--
-- Table structure for table `stock_logs`
--

CREATE TABLE `stock_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `action` enum('treshold','quantity') NOT NULL,
  `date_released` date NOT NULL,
  `time` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_logs`
--

INSERT INTO `stock_logs` (`id`, `user_id`, `item_id`, `action`, `date_released`, `time`, `created_at`, `updated_at`) VALUES
(13, 1, 28, 'treshold', '2025-05-07', '03:24 PM', '2025-05-06 23:24:25', '2025-05-06 23:24:25'),
(14, 1, 19, 'treshold', '2025-05-07', '03:31 PM', '2025-05-06 23:31:41', '2025-05-06 23:31:41');

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
(1, 'Kiel', NULL, 'Bermudez', 'admin', 'admin@gmail.com', NULL, '$2y$12$vJXaVSY7zKsBOOIaXebs2egBBy4CeTjx9WZ.eL0Pn2u.I6qDSojvC', NULL, '2025-04-10 19:29:39', '2025-05-06 22:45:35', '09193471522', 'UFYuAb5iQ4dBVwqxi1PDrmBvw4tuqBJ7knSFeTSU.jpg'),
(2, 'Angelicaa', NULL, 'Calingo', 'inventory-manager', 'inventory@gmail.com', NULL, '$2y$12$vJXaVSY7zKsBOOIaXebs2egBBy4CeTjx9WZ.eL0Pn2u.I6qDSojvC', NULL, '2025-04-10 19:29:39', '2025-04-30 03:29:04', '91934715222', 'gf6vkeHTC1HmZx5ey2V0Y8w3BXKwUl6GP7Rbjdqd.jpg'),
(3, 'Jazmine', NULL, 'Sanchez', 'TL', 'tl@gmail.com', NULL, '$2y$12$vJXaVSY7zKsBOOIaXebs2egBBy4CeTjx9WZ.eL0Pn2u.I6qDSojvC', NULL, '2025-04-10 19:32:58', '2025-04-30 00:39:21', '9193472612', 'ZICCyZMOJXu7Vgjfgqsj3mX36fBMY1MzGlzK4end.jpg'),
(4, 'Wincrich', NULL, 'Gloria', 'member', 'member@gmail.com', NULL, '$2y$12$vJXaVSY7zKsBOOIaXebs2egBBy4CeTjx9WZ.eL0Pn2u.I6qDSojvC', NULL, '2025-04-10 19:33:41', '2025-04-30 00:39:34', '9456023942', 'hDf8Jb3DIZ9vqTBcNtlK3l1cY0gDk7r5fKD7nflZ.jpg');

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
-- Indexes for table `schedule_requests`
--
ALTER TABLE `schedule_requests`
  ADD PRIMARY KEY (`schedule_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `item_logs`
--
ALTER TABLE `item_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
-- AUTO_INCREMENT for table `schedule_requests`
--
ALTER TABLE `schedule_requests`
  MODIFY `schedule_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `stock_logs`
--
ALTER TABLE `stock_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
