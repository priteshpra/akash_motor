-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2024 at 03:40 AM
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
(1, 'A', 1, 1, '2024-11-19 12:03:01', '2024-11-19 12:03:01'),
(2, 'Cat A', 1, 1, '2024-11-21 11:35:51', '2024-11-21 11:35:51'),
(3, 'Category B', 2, 1, '2024-11-21 12:19:20', '2024-11-21 12:19:20'),
(4, 'XYZ', 1, 1, '2024-12-03 10:40:22', '2024-12-03 10:40:22');

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
(1, 'Product A', 1, '2024-11-21 11:35:31', '2024-11-21 11:35:31'),
(2, 'Product B', 1, '2024-11-21 12:18:54', '2024-11-21 12:18:54'),
(3, 'Product C', 1, '2024-11-27 11:13:20', '2024-11-27 11:13:20'),
(4, 'Product D', 1, '2024-12-03 10:38:48', '2024-12-03 10:38:48'),
(5, 'Product E', 1, '2024-12-03 10:39:22', '2024-12-03 10:39:22');

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
  `flange_percentage` varchar(100) DEFAULT NULL,
  `flange_val` varchar(100) DEFAULT NULL,
  `footval` varchar(100) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products_add_data`
--

INSERT INTO `products_add_data` (`id`, `category_id`, `product_id`, `subcategory_id`, `subcategory_val`, `flange_percentage`, `flange_val`, `footval`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 5, '55', NULL, NULL, '12', 1, '2024-12-07 03:45:49', '2024-12-07 03:45:49'),
(2, 1, 1, 6, '22', NULL, NULL, '12', 1, '2024-12-07 03:45:49', '2024-12-07 03:45:49'),
(7, 3, 2, 2, '50', '18', '100', NULL, 1, '2024-12-07 03:49:19', '2024-12-07 03:49:19'),
(8, 3, 2, 4, '40', '18', '100', NULL, 1, '2024-12-07 03:49:19', '2024-12-07 03:49:19'),
(9, 3, 2, 7, '30', '18', '100', NULL, 1, '2024-12-07 03:49:19', '2024-12-07 03:49:19'),
(10, 3, 2, 8, '20', '18', '100', NULL, 1, '2024-12-07 03:49:19', '2024-12-07 03:49:19'),
(11, 3, 2, 2, '1', '', NULL, '5', 1, '2024-12-07 03:59:55', '2024-12-07 03:59:55'),
(12, 3, 2, 4, '2', '', NULL, '5', 1, '2024-12-07 03:59:55', '2024-12-07 03:59:55'),
(13, 3, 2, 7, '3', '', NULL, '5', 1, '2024-12-07 03:59:55', '2024-12-07 03:59:55'),
(14, 3, 2, 8, '4', '', NULL, '5', 1, '2024-12-07 03:59:55', '2024-12-07 03:59:55');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `subcategory_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `product_id`, `category_id`, `subcategory_name`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Sub Cat A', '2024-11-21 12:10:13', '2024-11-21 12:10:13'),
(2, 2, 3, 'Sub Cat B', '2024-11-21 12:19:39', '2024-11-21 12:19:39'),
(3, 1, 4, 'JJJ', '2024-12-03 10:40:44', '2024-12-03 10:40:44'),
(4, 2, 3, 'II', '2024-12-03 10:42:24', '2024-12-03 10:42:24'),
(5, 1, 1, 'aaa', '2024-12-03 10:59:31', '2024-12-03 10:59:31'),
(6, 1, 1, 'kdk', '2024-12-03 11:20:59', '2024-12-03 11:20:59'),
(7, 2, 3, 'HS', '2024-12-03 11:22:39', '2024-12-03 11:22:39'),
(8, 2, 3, 'NN', '2024-12-03 11:22:44', '2024-12-03 11:22:44');

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
(18, '10', '12', '12', 1, '2024-12-07 02:43:33', '2024-12-07 02:43:33'),
(19, '10', '10', '18', 1, '2024-12-07 02:43:33', '2024-12-07 02:43:33'),
(20, '10', NULL, '20', 1, '2024-12-07 02:43:33', '2024-12-07 02:43:33');

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
(2, 'Pritesh Prajapati', 'admin', 'test@example.com', NULL, '5f4dcc3b5aa765d61d8327deb882cf99', 'rz1hlrKS0Rp1qTFeX0A8765zWo30eT9ROpTaYSpf', NULL, NULL);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products_add_data`
--
ALTER TABLE `products_add_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tax`
--
ALTER TABLE `tax`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
