-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 11, 2024 at 03:07 PM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_food_api`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

DROP TABLE IF EXISTS `addresses`;
CREATE TABLE IF NOT EXISTS `addresses` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `addresses_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `address`, `user_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'bsssss', 1, NULL, '2024-01-27 04:42:37', '2024-01-27 12:03:21'),
(2, 'yazd bolvar jomhory', 3, NULL, '2024-01-27 04:49:35', '2024-01-27 11:39:49'),
(3, 'bsssss', 1, NULL, '2024-01-27 06:09:05', '2024-01-27 12:03:47'),
(4, 'yazd bolvar jomhory', 1, NULL, '2024-01-27 13:32:30', '2024-01-27 13:32:30'),
(5, 'yazd bolvar jomhory', 1, NULL, '2024-01-27 13:32:33', '2024-01-27 13:32:33'),
(6, 'yazd bolvar jomhory', 1, NULL, '2024-01-27 13:32:35', '2024-01-27 13:32:35'),
(7, 'یزد', 1, NULL, '2024-02-06 12:57:15', '2024-02-06 12:57:15'),
(8, 'یزد', 1, NULL, '2024-02-06 13:09:57', '2024-02-06 13:09:57');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`, `display_name`, `description`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 0, 'namess', 'namess', NULL, NULL, '2024-01-27 09:32:45', '2024-01-27 11:03:21'),
(2, 1, 'namenss', 'namenss', NULL, NULL, '2024-01-27 09:35:39', '2024-01-27 13:33:56'),
(3, 1, 'namensss', 'namensss', NULL, NULL, '2024-01-27 09:35:43', '2024-01-27 09:35:43'),
(4, 1, 'محمد', 'محمد', NULL, NULL, '2024-02-06 13:10:29', '2024-02-06 13:14:07');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(9, '2014_10_12_000000_create_users_table', 1),
(10, '2014_10_12_100000_create_password_resets_table', 1),
(11, '2019_08_19_000000_create_failed_jobs_table', 1),
(12, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(13, '2022_01_25_163416_create_categories_table', 1),
(14, '2024_01_25_163214_create_products_table', 1),
(15, '2024_01_25_163752_create_product_images_table', 1),
(16, '2024_01_25_163929_create_addresses_table', 1),
(17, '2024_02_02_150618_orders', 2);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `product_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtotal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `price`, `quantity`, `subtotal`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 4, '2', '10', '5', '50', NULL, '2024-02-02 11:51:30', '2024-02-03 13:33:43'),
(2, 4, '2', '10', '5', '50', NULL, '2024-02-02 11:52:26', '2024-02-02 11:52:26'),
(3, 4, '3', '10', '5', '50', NULL, '2024-02-02 11:52:26', '2024-02-02 11:52:26'),
(4, 1, '3', '10', '20', '200', NULL, '2024-02-03 11:28:12', '2024-02-03 11:28:12'),
(5, 1, '3', '10', '20', '200', NULL, '2024-02-03 11:30:46', '2024-02-03 11:30:46'),
(6, 1, '3', '10', '10', '100', NULL, '2024-02-03 11:31:29', '2024-02-03 11:31:29'),
(7, 1, '10', '10', '10', '100', NULL, '2024-02-03 11:39:56', '2024-02-03 11:39:56'),
(8, 1, '10', '10', '10', '100', NULL, '2024-02-03 11:40:16', '2024-02-03 11:40:16'),
(9, 1, '7', '10', '10', '100', NULL, '2024-02-03 11:40:38', '2024-02-03 11:40:38'),
(10, 1, '6', '10', '7', '70', '2024-02-03 13:37:56', '2024-02-03 11:42:11', '2024-02-03 13:37:56'),
(11, 1, '4', '10', '7', '70', NULL, '2024-02-03 11:42:48', '2024-02-03 11:42:48'),
(12, 4, '2', '10', '7', '70', NULL, '2024-02-03 11:43:39', '2024-02-03 11:43:39'),
(13, 1, '2', '10', '7', '70', NULL, '2024-02-03 11:45:22', '2024-02-03 11:45:22'),
(14, 1, '2', '10', '7', '70', NULL, '2024-02-03 11:46:15', '2024-02-03 11:46:15'),
(15, 1, '2', '10', '7', '70', NULL, '2024-02-03 11:49:27', '2024-02-03 11:49:27'),
(16, 1, '2', '10', '7', '70', NULL, '2024-02-03 11:50:07', '2024-02-03 11:50:07'),
(18, 4, '2', '10', '2', '20', NULL, '2024-02-03 11:51:35', '2024-02-03 11:51:35'),
(19, 4, '2', '10', '2', '20', NULL, '2024-02-03 11:52:45', '2024-02-03 11:52:45'),
(20, 1, '2', '10', '2', '20', NULL, '2024-02-03 12:54:14', '2024-02-03 12:54:14'),
(21, 1, '5', '10', '2', '20', NULL, '2024-02-03 12:54:14', '2024-02-03 12:54:14'),
(22, 4, '2', '10', '2', '20', NULL, '2024-02-03 12:55:05', '2024-02-03 12:55:05'),
(23, 1, '5', '10', '2', '20', NULL, '2024-02-03 12:55:05', '2024-02-03 12:55:05'),
(24, 1, '2', '10', '2', '20', NULL, '2024-02-03 13:37:02', '2024-02-03 13:37:02'),
(25, 1, '5', '10', '2', '20', NULL, '2024-02-03 13:37:02', '2024-02-03 13:37:02');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'myApp', '2010c8291874aa9e1074ec1351f6bec438fd9e53ef6a85640bd20d62c7c6c377', '[\"*\"]', '2024-02-06 13:09:57', '2024-01-27 04:40:45', '2024-02-06 13:09:57'),
(2, 'App\\Models\\User', 1, 'myApp', '6a0c791d5b15369b79143679961bc81152e82f12bb8238485e4894eb86b39646', '[\"*\"]', '2024-01-27 06:34:05', '2024-01-27 06:33:29', '2024-01-27 06:34:05'),
(3, 'App\\Models\\User', 1, 'myApp', 'f1627f54c939fdc99177e29a9eae725615e8d4ef1cc6244d3f7ef4ef8ac83659', '[\"*\"]', '2024-01-27 06:38:23', '2024-01-27 06:38:08', '2024-01-27 06:38:23'),
(4, 'App\\Models\\User', 1, 'myApp', '76c7d1af16382228357ff2cf25029e0ecd2f548f2f4f17b37f14b15507db3aa7', '[\"*\"]', NULL, '2024-01-27 10:25:49', '2024-01-27 10:25:49'),
(5, 'App\\Models\\User', 1, 'myApp', 'b576901e97e851779e6a9fba9dfab39b343db5dc3364d54a87394dc3e613acf6', '[\"*\"]', '2024-01-27 11:40:06', '2024-01-27 11:15:32', '2024-01-27 11:40:06'),
(6, 'App\\Models\\User', 1, 'myApp', '682eb5424a936a4ea72e8bdb1b0f399151444b993ca1b3b787967bded3989405', '[\"*\"]', '2024-01-27 12:03:47', '2024-01-27 12:01:30', '2024-01-27 12:03:47'),
(7, 'App\\Models\\User', 1, 'myApp', 'c754c9a9b8141314c37e16ff6a5e4aebc5658010d79c3ebc64e6c8569172750a', '[\"*\"]', '2024-01-27 13:32:35', '2024-01-27 13:31:27', '2024-01-27 13:32:35'),
(8, 'App\\Models\\User', 1, 'myApp', 'e5ab1ff11ab3abf43384aefcc895cfa8d8a3549d3bda111b3884b1d1a6ed5492', '[\"*\"]', '2024-01-29 01:15:17', '2024-01-29 01:04:32', '2024-01-29 01:15:17'),
(9, 'App\\Models\\User', 1, 'myApp', 'f887240ab9b9af6942a9e7dd340965d898f1bf10d74d6c53141fc9d9547115aa', '[\"*\"]', '2024-02-06 13:14:07', '2024-01-31 11:17:45', '2024-02-06 13:14:07'),
(10, 'App\\Models\\User', 1, 'myApp', 'cb88f6b6a3893cb7c1ca6198304e05b386665c3eefab6661aa3bc543168216b6', '[\"*\"]', '2024-02-02 11:52:26', '2024-02-02 10:59:51', '2024-02-02 11:52:26'),
(11, 'App\\Models\\User', 1, 'myApp', '39a71f0dbecf570357b48dd96e1e1c7494e5f5dcf1ebc3e9f979dbf9a8a45436', '[\"*\"]', '2024-02-03 13:49:15', '2024-02-03 11:12:27', '2024-02-03 13:49:15'),
(12, 'App\\Models\\User', 4, 'myApp', '4dbb279e734b6e206915788355c8bbfb4a50b18b49584566628e1a10a6383591', '[\"*\"]', '2024-02-03 13:52:00', '2024-02-03 13:49:46', '2024-02-03 13:52:00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `primary_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` int UNSIGNED NOT NULL DEFAULT '0',
  `quantity` int UNSIGNED NOT NULL DEFAULT '0',
  `delivery_amount` int UNSIGNED NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_category_id_foreign` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `title`, `category_id`, `primary_image`, `description`, `price`, `quantity`, `delivery_amount`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 'mohammad', 2, '1706535309jpg', 'description', 10, 19992, 2000, NULL, '2024-01-29 10:05:09', '2024-02-03 13:37:02'),
(3, 'mohammad', 2, '1706535340.jpg', 'description', 10, 0, 2000, NULL, '2024-01-29 10:05:40', '2024-02-03 11:31:29'),
(4, 'mohammad', 2, '1706535881.jpg', 'description', 10, 30, 2000, NULL, '2024-01-29 10:14:41', '2024-02-03 11:42:48'),
(5, 'mohammad', 2, '1706535892.jpg', 'description', 10, 9999994, 2000, NULL, '2024-01-29 10:14:52', '2024-02-03 13:37:02'),
(6, 'mohammad', 2, '1706535946.jpg', 'description', 10, 3, 2000, NULL, '2024-01-29 10:15:46', '2024-02-03 11:42:11'),
(7, 'mohammad', 2, '1706536025.jpg', 'description', 10, 0, 2000, NULL, '2024-01-29 10:17:05', '2024-02-03 11:40:38'),
(8, 'mohammad', 2, '1706536094.jpg', 'description', 10, 10, 2000, NULL, '2024-01-29 10:18:14', '2024-01-29 10:18:14'),
(9, 'mohammad', 2, '350567.jpg', 'description', 10, 10, 2000, NULL, '2024-01-29 10:19:49', '2024-01-29 10:19:49'),
(10, 'moj', 2, '630691.jpg', 'des000', 10, 999980, 1050, NULL, '2024-01-30 11:23:19', '2024-02-03 11:40:16');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
CREATE TABLE IF NOT EXISTS `product_images` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_images_product_id_foreign` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `deleted_at`, `created_at`, `updated_at`) VALUES
(20, 10, '754271.jpg', '2024-01-30 12:28:54', '2024-01-30 12:27:06', '2024-01-30 12:28:54'),
(21, 10, '756407.jpg', '2024-01-30 12:28:54', '2024-01-30 12:27:06', '2024-01-30 12:28:54'),
(22, 10, '758953.jpg', '2024-01-30 12:28:54', '2024-01-30 12:27:06', '2024-01-30 12:28:54'),
(23, 10, '763598.jpg', '2024-01-30 12:28:54', '2024-01-30 12:27:06', '2024-01-30 12:28:54'),
(24, 10, '713228.jpg', NULL, '2024-01-30 12:28:54', '2024-01-30 12:28:54'),
(25, 10, '724038.jpg', NULL, '2024-01-30 12:28:54', '2024-01-30 12:28:54'),
(26, 10, '732550.jpg', NULL, '2024-01-30 12:28:54', '2024-01-30 12:28:54'),
(27, 10, '741322.jpg', NULL, '2024-01-30 12:28:54', '2024-01-30 12:28:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `profile` text COLLATE utf8mb4_unicode_ci,
  `cellphone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `permission` enum('user','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `email_verified_at`, `profile`, `cellphone`, `password`, `permission`, `remember_token`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'mohammad', 'mohammadi', 'mohammad@gmail.com', NULL, NULL, NULL, '$2y$10$.5n5ByHxQ539nTPi0tkYe.btrIvvswFa//zTZgmcGJo7LUr/IN2Nu', 'admin', NULL, NULL, '2024-01-27 04:40:45', '2024-01-27 11:47:44'),
(3, 'mohammads', 'mohammadi', 'mohamsmad@gmail.com', NULL, NULL, NULL, '$2y$10$.5n5ByHxQ539nTPi0tkYe.btrIvvswFa//zTZgmcGJo7LUr/IN2Nu', 'admin', NULL, NULL, '2024-01-27 04:40:45', '2024-02-02 11:13:56'),
(4, 'hass', 'hassan', 'mohammadhassan@gmail.com', NULL, NULL, NULL, '$2y$10$FFedoi.91j4XauEVr5lvwue8DUu/x14QR3RlG6mtno5Wzbo/yrBxu', 'user', NULL, NULL, '2024-02-03 13:49:46', '2024-02-03 13:49:46');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
