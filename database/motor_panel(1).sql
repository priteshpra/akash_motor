-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2025 at 07:09 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `motor_panel`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_name`, `product_id`, `status`, `created_at`, `updated_at`) VALUES
(5, 'IE2', 6, 1, '2024-12-10 12:28:34', '2024-12-10 12:28:34'),
(6, 'IE3', 6, 1, '2024-12-10 12:28:40', '2024-12-10 12:28:40'),
(7, 'Simens', 7, 1, '2024-12-11 10:41:19', '2024-12-11 10:41:19'),
(8, 'dhdh', 6, 1, '2025-01-18 10:45:49', '2025-01-18 10:45:49');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_11_19_164216_create_categories_table', 2),
(6, '2024_11_19_174557_create_sub_categories_table', 3),
(7, '2024_11_19_175427_create_products_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `NotificationID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Description` text NOT NULL,
  `TypeID` int(11) NOT NULL,
  `ActionType` varchar(50) DEFAULT NULL,
  `IsRead` int(11) NOT NULL DEFAULT 0,
  `CreatedBy` int(11) NOT NULL,
  `CreatedDate` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 3, 'authToken', '0ee19288dba3130bfb5525e5e67b0440b8a478ba897b8241ba88d577c2652941', '[\"*\"]', NULL, '2025-02-09 02:29:40', '2025-02-09 02:29:40'),
(2, 'App\\Models\\User', 3, 'authToken', '1889edf18a53e5c7f4297a1f8c9f44636315ac2973bafbe95f64d879d2e07a35', '[\"*\"]', NULL, '2025-02-12 11:41:08', '2025-02-12 11:41:08');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Product A', 0, '2024-11-21 11:35:31', '2024-12-11 10:39:16'),
(2, 'Product B', 0, '2024-11-21 12:18:54', '2024-12-11 10:39:18'),
(3, 'Product C', 0, '2024-11-27 11:13:20', '2024-12-11 10:39:14'),
(4, 'Product D', 0, '2024-12-03 10:38:48', '2024-12-11 10:39:21'),
(5, 'Product E', 0, '2024-12-03 10:39:22', '2024-12-11 10:39:11'),
(6, 'CG MOTOR', 1, '2024-12-10 12:28:14', '2024-12-10 12:28:14'),
(7, 'Motor', 1, '2024-12-11 10:39:47', '2024-12-11 10:39:47');

-- --------------------------------------------------------

--
-- Table structure for table `products_add_data`
--

CREATE TABLE `products_add_data` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `subcategory_id` int(11) NOT NULL,
  `subcategory_val` varchar(200) DEFAULT NULL,
  `typeOption` varchar(100) DEFAULT NULL,
  `flange_percentage` varchar(100) DEFAULT NULL,
  `flange_val` varchar(100) DEFAULT NULL,
  `footval` varchar(100) DEFAULT NULL,
  `size` varchar(100) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `date` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products_add_data`
--

INSERT INTO `products_add_data` (`id`, `category_id`, `product_id`, `subcategory_id`, `subcategory_val`, `typeOption`, `flange_percentage`, `flange_val`, `footval`, `size`, `status`, `date`, `created_at`, `updated_at`) VALUES
(28, 5, 6, 9, '100', 'Flange', '20', NULL, '5010', '50', 1, '2024-12-19 16:22:56', '2024-12-19 10:52:56', '2024-12-28 04:15:25'),
(29, 5, 6, 10, '5', 'Foot', NULL, NULL, '5001', '5', 1, '2024-12-19 16:22:56', '2024-12-19 10:52:56', '2024-12-28 02:05:31'),
(30, 5, 6, 14, '101', 'Flange', NULL, NULL, '5011', '5', 1, '2024-12-19 16:22:56', '2024-12-19 10:52:56', '2024-12-19 12:03:20'),
(31, 6, 6, 15, 'BB', 'Flange', '12', NULL, '500', '10', 1, '2024-12-19 17:30:54', '2024-12-19 12:00:54', '2024-12-19 12:00:54'),
(32, 5, 6, 9, 'A', 'Flange', '20', NULL, '5000', '6', 1, '2024-12-19 17:31:28', '2024-12-19 12:01:28', '2024-12-19 12:01:28'),
(35, 7, 7, 11, '800', 'Foot, Flange', '12', NULL, '500', '5', 1, '2024-12-22 05:15:16', '2024-12-21 23:45:16', '2024-12-21 23:45:16'),
(36, 7, 7, 12, '800', 'Foot, Flange', '5', NULL, '500', '5', 1, '2024-12-22 05:15:16', '2024-12-21 23:45:16', '2024-12-28 04:15:43'),
(37, 7, 7, 13, '800', 'Foot, Flange', '12', NULL, '500', '5', 1, '2024-12-22 05:15:16', '2024-12-21 23:45:16', '2024-12-21 23:45:16'),
(38, 5, 6, 9, '800', 'Foot', '', NULL, '560', '5', 1, '2024-12-23 16:43:06', '2024-12-23 11:13:06', '2024-12-23 11:13:06'),
(39, 5, 6, 10, '500', 'Foot', '', NULL, '560', '5', 1, '2024-12-23 16:43:06', '2024-12-23 11:13:06', '2024-12-23 11:13:06'),
(40, 5, 6, 14, '300', 'Foot', '', NULL, '560', '5', 1, '2024-12-23 16:43:06', '2024-12-23 11:13:06', '2024-12-23 11:13:06'),
(41, 6, 6, 15, '500', 'Foot, Flange', '20', NULL, '600', '6', 1, '2024-12-23 16:43:27', '2024-12-23 11:13:27', '2024-12-23 11:13:27');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `subcategory_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `product_id`, `category_id`, `subcategory_name`, `status`, `created_at`, `updated_at`) VALUES
(9, 6, 5, 'HP', 1, '2024-12-10 12:28:55', '2024-12-10 12:28:55'),
(10, 6, 5, 'FRAME SIZE', 1, '2024-12-10 12:29:03', '2024-12-10 12:29:03'),
(11, 7, 7, 'Class', 1, '2024-12-11 10:41:48', '2024-12-11 10:41:48'),
(12, 7, 7, 'HP', 1, '2024-12-11 10:41:54', '2024-12-11 10:41:54'),
(13, 7, 7, 'RPM', 1, '2024-12-11 10:41:58', '2024-12-11 10:41:58'),
(14, 6, 5, 'A', 1, '2024-12-19 10:52:17', '2024-12-19 10:52:17'),
(15, 6, 6, 'B', 1, '2024-12-19 10:52:24', '2024-12-19 10:52:24'),
(16, 6, 5, 'jdjd', 1, '2025-01-18 10:46:00', '2025-01-18 10:46:00'),
(17, 6, 5, 'djjd2', 1, '2025-01-18 10:46:25', '2025-01-18 10:46:25'),
(18, 6, 5, 'jdj3', 1, '2025-01-18 10:46:29', '2025-01-18 10:46:29'),
(19, 6, 5, 'llr4', 1, '2025-01-18 10:46:33', '2025-01-18 10:46:33');

-- --------------------------------------------------------

--
-- Table structure for table `tax`
--

CREATE TABLE `tax` (
  `id` int(11) NOT NULL,
  `gst` varchar(100) NOT NULL DEFAULT '0',
  `tax` varchar(50) DEFAULT '0',
  `flange` varchar(100) DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tax`
--

INSERT INTO `tax` (`id`, `gst`, `tax`, `flange`, `status`, `created_at`, `updated_at`) VALUES
(42, '10', '12', '12', 1, '2024-12-19 12:05:51', '2024-12-19 12:05:51'),
(43, '10', '10', '20', 1, '2024-12-19 12:05:51', '2024-12-19 12:05:51'),
(44, '10', NULL, '5', 1, '2024-12-19 12:05:51', '2024-12-19 12:05:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `role`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'Pritesh Prajapati', 'admin', 'test@example.com', NULL, '5f4dcc3b5aa765d61d8327deb882cf99', 'rz1hlrKS0Rp1qTFeX0A8765zWo30eT9ROpTaYSpf', NULL, NULL),
(3, 'Pritesh Prajapati', 'User', 'user@example.com', NULL, '5f4dcc3b5aa765d61d8327deb882cf99', 'rz1hlrKS0Rp1qTFeX0A8765zWo30eT9ROpTaYSpf', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_devices`
--

CREATE TABLE `user_devices` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `device_token` varchar(255) DEFAULT NULL,
  `login_token` varchar(255) DEFAULT NULL,
  `device_type` enum('Android','IOS') DEFAULT 'Android',
  `api_version` varchar(100) DEFAULT NULL,
  `app_version` varchar(20) DEFAULT NULL,
  `os_version` varchar(20) DEFAULT NULL,
  `device_model_name` varchar(20) DEFAULT NULL,
  `app_language` varchar(100) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_devices`
--

INSERT INTO `user_devices` (`id`, `user_id`, `device_token`, `login_token`, `device_type`, `api_version`, `app_version`, `os_version`, `device_model_name`, `app_language`, `status`, `created_at`, `updated_at`) VALUES
(2, 139, 'fBCgEo-9ReiikRRG-ba--N:APA91bFZfnyb6udgJ8xswncB-qd8AyMXbhhCdp4UmnCrOPPIbN3jRtmGOKjO5Xavn5GH3qpMOgQtNQz4DG9j5ZLb_-IE8v-nndvHTsFTrF_YAxRpIGtWkGfiZ2jDgUuEuytxMRUQFqH-', '214|zRYMhwfBNqe8kxJWBU2ug4OikyIELRy7K4vUURC6d852f892216|SL77pkKQwvJiqg8KuyJodnkBFKYowDeTGLNoIHut374c18d8', 'Android', NULL, NULL, NULL, NULL, NULL, 1, '2024-08-14 11:14:40', NULL),
(3, 3, '', '4|WdL6S4knFim5NSxPTmEpeBG4baQeCY7Ium34ujDX', NULL, NULL, NULL, NULL, NULL, NULL, 0, '2024-11-21 22:09:55', NULL),
(4, 4, '', '5|7mloJr0XnuKFi8ojWJmGHko5IVvrw5xOx81dSIg5', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-11-23 14:22:25', NULL),
(5, 4, '', '6|z5fApcS0wQlMPEn108ga2uMZGPAijCakRv6WPWHj', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-11-23 14:23:17', NULL),
(6, 4, '', '7|Ja9YFAPnuGeV7PZbPHN8ogVTn0R8plNNDCKNvtt5', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-11-23 14:24:48', NULL),
(7, 4, '', '8|EEBtpGRG1ojtGtcZ75lBYO3Q5hG5gABbkEqRDAOh', NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-11-23 15:13:25', NULL),
(8, 8, '', '9|7tiyaxMXT5pqk0VV2VVn9IrvuAkRpgrflYioSufN', 'Android', '', '', '', '', '', 1, '2024-12-09 22:17:32', NULL),
(9, 8, '', '10|zEdNyHocENEd0ywYpOJFix6yOlS9Nnihqqk4j6NV', 'Android', '', '', '', '', '', 1, '2024-12-09 22:18:21', NULL),
(10, 8, '', '11|k2i9EMGHbvj5wpCCL6yOj91j0B5Jzk98EBLo97mC', 'Android', '', '', '', '', '', 1, '2024-12-09 22:18:32', NULL),
(11, 29, '', '12|ro87TlHdYD4uLQWidG6XA8NiGnD9mo9chaOzJWHN', 'Android', '', '', '', '', '', 1, '2024-12-12 23:04:21', NULL),
(12, 29, '', '13|zjiSLYufrMsm7AbugTDxKeZBG5VFYTifJwGycD61', 'Android', '', '', '', '', '', 1, '2024-12-12 23:05:09', NULL),
(13, 29, 'dfdsf', '14|m9PS3Xj3hOeivA2CQuD0iiIa4qYmeJbssXmmPNwv', 'Android', '1.1', '1.0', '0.1.1', 'SS', 'EN', 1, '2024-12-12 23:05:46', NULL),
(14, 22, 'dfdsf', '15|zqPa8vxHpjZEunuoHwZsbtknytz7hmRuxPMiZhJ9', 'Android', '1.1', '1.0', '0.1.1', 'SS', 'EN', 1, '2024-12-12 23:33:33', NULL),
(15, 22, 'dfdsf', '16|VTzKSTxRV5QUC77P5SnFqgo8G36MXMSehEqPdDdX', 'Android', '1.1', '1.0', '0.1.1', 'SS', 'EN', 1, '2024-12-12 23:33:49', NULL),
(16, 22, 'dfdsf', '17|BYaRzPSjqBNAipkGqVmcX9FJXGkkngF3XxFvHL8D', 'Android', '1.1', '1.0', '0.1.1', 'SS', 'EN', 1, '2024-12-12 23:34:17', NULL),
(17, 22, 'dfdsf', '18|mU71PyysLolRG73P1G7T4NPLDiKrpZinA220iv79', 'Android', '1.1', '1.0', '0.1.1', 'SS', 'EN', 1, '2024-12-12 23:37:28', NULL),
(18, 22, 'dfdsf', '19|NHnqAuc4aVkW5sTK7Rf4ckbA1FOUDmE15oui8CJh', 'Android', '1.1', '1.0', '0.1.1', 'SS', 'EN', 1, '2024-12-12 23:38:29', NULL),
(19, 34, '', '20|0EswlHqjDPjQDQ274OVzDM21mSNI8l82HzgoJURV', 'Android', '1.1', '1.0', '0.1.1', 'SS', 'EN', 0, '2024-12-23 21:06:43', '2024-12-23 18:14:23'),
(20, 34, '', '21|kvwPDg9S9poO2YWQA2NqdE5Ct4FPAsLclo2wIsQU', 'Android', '1.1', '1.0', '0.1.1', 'SS', 'EN', 0, '2024-12-23 21:07:11', '2024-12-23 18:14:23'),
(21, 34, '', '22|j24p63ly2yxXREOAsCrJ41vIT9KbwVofEWKPcRH4', 'Android', '1.1', '1.0', '0.1.1', 'SS', 'EN', 0, '2024-12-23 21:18:27', '2024-12-23 18:14:23'),
(22, 34, '', '24|K3bPJX5bt6qoEMHpv56CyHkTMtpePeVJqO2fjhVH', 'Android', '1.1', '1.0', '0.1.1', 'SS', 'EN', 0, '2024-12-28 12:07:06', NULL),
(23, 34, 'dfdsf', '25|y695jyADff99Xh5lXm1aAfvjOylmQBNsTQz4KdsR', 'Android', '1.1', '1.0', '0.1.1', 'SS', 'EN', 1, '2024-12-28 12:07:24', NULL),
(24, 3, '', '1|jcl5kMyieKbrjk4pIpcuqEUPlYuyOdslP62BrGMr', 'Android', '', '', '', '', '', 0, '2025-02-09 13:29:40', NULL),
(25, 3, '', '2|VbN6jFPHV4Z4H7OZgcGhLG4fuPd8AMsfLxdjoBMm', 'Android', '', '', '', '', '', 1, '2025-02-12 22:41:08', NULL);

--
-- Indexes for dumped tables
--

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
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products_add_data`
--
ALTER TABLE `products_add_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tax`
--
ALTER TABLE `tax`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_devices`
--
ALTER TABLE `user_devices`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products_add_data`
--
ALTER TABLE `products_add_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tax`
--
ALTER TABLE `tax`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_devices`
--
ALTER TABLE `user_devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
