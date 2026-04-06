-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 05, 2026 at 09:09 PM
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
-- Database: `thekawacompany`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:78:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:12:\"admin.access\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:14:\"dashboard.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:11:\"orders.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:13:\"orders.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:13:\"payments.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:15:\"payments.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:13:\"products.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:15:\"products.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:15:\"products.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:15:\"products.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:15:\"categories.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:17:\"categories.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:17:\"categories.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:17:\"categories.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:14:\"inventory.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:16:\"inventory.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:12:\"coupons.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:14:\"coupons.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:14:\"coupons.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:14:\"coupons.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:10:\"users.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:12:\"users.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:12:\"users.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:12:\"users.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:12:\"reviews.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:14:\"reviews.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:10:\"carts.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:14:\"wishlists.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:16:\"wishlists.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:10:\"blogs.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:12:\"blogs.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:12:\"blogs.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:12:\"blogs.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:10:\"roles.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:12:\"roles.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:12:\"roles.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:12:\"roles.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:12:\"profile.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:14:\"profile.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:39;a:3:{s:1:\"a\";i:40;s:1:\"b\";s:12:\"admin.access\";s:1:\"c\";s:7:\"sanctum\";}i:40;a:3:{s:1:\"a\";i:41;s:1:\"b\";s:14:\"dashboard.view\";s:1:\"c\";s:7:\"sanctum\";}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:11:\"orders.view\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:13:\"orders.update\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:13:\"payments.view\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:15:\"payments.update\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:13:\"products.view\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:46;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:15:\"products.create\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:47;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:15:\"products.update\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:48;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:15:\"products.delete\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:49;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:15:\"categories.view\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:50;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:17:\"categories.create\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:51;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:17:\"categories.update\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:52;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:17:\"categories.delete\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:53;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:14:\"inventory.view\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:54;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:16:\"inventory.update\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:55;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:12:\"coupons.view\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:56;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:14:\"coupons.create\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:57;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:14:\"coupons.update\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:58;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:14:\"coupons.delete\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:59;a:3:{s:1:\"a\";i:60;s:1:\"b\";s:10:\"users.view\";s:1:\"c\";s:7:\"sanctum\";}i:60;a:3:{s:1:\"a\";i:61;s:1:\"b\";s:12:\"users.create\";s:1:\"c\";s:7:\"sanctum\";}i:61;a:3:{s:1:\"a\";i:62;s:1:\"b\";s:12:\"users.update\";s:1:\"c\";s:7:\"sanctum\";}i:62;a:3:{s:1:\"a\";i:63;s:1:\"b\";s:12:\"users.delete\";s:1:\"c\";s:7:\"sanctum\";}i:63;a:3:{s:1:\"a\";i:64;s:1:\"b\";s:12:\"reviews.view\";s:1:\"c\";s:7:\"sanctum\";}i:64;a:3:{s:1:\"a\";i:65;s:1:\"b\";s:14:\"reviews.delete\";s:1:\"c\";s:7:\"sanctum\";}i:65;a:4:{s:1:\"a\";i:66;s:1:\"b\";s:10:\"carts.view\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:66;a:4:{s:1:\"a\";i:67;s:1:\"b\";s:14:\"wishlists.view\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:67;a:4:{s:1:\"a\";i:68;s:1:\"b\";s:16:\"wishlists.delete\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:68;a:4:{s:1:\"a\";i:69;s:1:\"b\";s:10:\"blogs.view\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:69;a:3:{s:1:\"a\";i:70;s:1:\"b\";s:12:\"blogs.create\";s:1:\"c\";s:7:\"sanctum\";}i:70;a:3:{s:1:\"a\";i:71;s:1:\"b\";s:12:\"blogs.update\";s:1:\"c\";s:7:\"sanctum\";}i:71;a:3:{s:1:\"a\";i:72;s:1:\"b\";s:12:\"blogs.delete\";s:1:\"c\";s:7:\"sanctum\";}i:72;a:3:{s:1:\"a\";i:73;s:1:\"b\";s:10:\"roles.view\";s:1:\"c\";s:7:\"sanctum\";}i:73;a:3:{s:1:\"a\";i:74;s:1:\"b\";s:12:\"roles.create\";s:1:\"c\";s:7:\"sanctum\";}i:74;a:3:{s:1:\"a\";i:75;s:1:\"b\";s:12:\"roles.update\";s:1:\"c\";s:7:\"sanctum\";}i:75;a:3:{s:1:\"a\";i:76;s:1:\"b\";s:12:\"roles.delete\";s:1:\"c\";s:7:\"sanctum\";}i:76;a:4:{s:1:\"a\";i:77;s:1:\"b\";s:12:\"profile.view\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:77;a:4:{s:1:\"a\";i:78;s:1:\"b\";s:14:\"profile.update\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}}s:5:\"roles\";a:4:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:7:\"manager\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:5:\"staff\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:5:\"staff\";s:1:\"c\";s:7:\"sanctum\";}}}', 1775501570);

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
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 4, '2026-03-23 14:51:04', '2026-03-23 14:51:04');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `variant_id`, `quantity`, `created_at`, `updated_at`) VALUES
(2, 1, 1, 1, '2026-03-23 14:51:11', '2026-03-23 14:51:11');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image_path`, `parent_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 'test', 'test', 'hello this is testing', NULL, NULL, 1, '2026-03-19 13:51:22', '2026-03-19 13:51:22'),
(2, 'heloo', 'heloo', 'jdfkjsdfkjsdkfjh', NULL, 1, 1, '2026-03-19 13:51:55', '2026-03-19 13:51:55'),
(3, 'Testing', 'testing', 'Hello this is testing', NULL, NULL, 1, '2026-03-21 15:05:51', '2026-03-21 15:05:51'),
(4, 'deepak', 'deepak', 'dgdgdg', 'categories/mdmORWpr37CndaaWLAgaahd2B0erlYk9CxeJyHz2.jpg', 1, 1, '2026-03-22 06:13:22', '2026-03-22 06:13:22');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `discount_type` enum('fixed','percent') NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `min_order_amount` decimal(10,2) DEFAULT NULL,
  `max_discount` decimal(10,2) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `usage_limit` int(10) UNSIGNED DEFAULT NULL,
  `per_user_limit` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount_type`, `discount_value`, `min_order_amount`, `max_discount`, `expiry_date`, `usage_limit`, `per_user_limit`, `is_active`, `created_at`, `updated_at`) VALUES
(1, '1234', 'fixed', 100.00, 20.00, 60.00, '2028-12-12', 10, 2, 1, '2026-03-21 15:42:27', '2026-03-21 15:42:27');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_usages`
--

CREATE TABLE `coupon_usages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `used_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) UNSIGNED NOT NULL,
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `reserved_stock` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `warehouse` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventories`
--

INSERT INTO `inventories` (`id`, `variant_id`, `stock`, `reserved_stock`, `warehouse`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, 'default', '2026-03-21 15:07:52', '2026-03-21 15:07:52');

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
  `name` varchar(255) NOT NULL,
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_03_08_184019_create_personal_access_tokens_table', 1),
(5, '2026_03_12_180032_create_permission_tables', 1),
(6, '2026_03_13_181121_create_categories_table', 2),
(7, '2026_03_15_072049_create_ecommerce_tables', 3),
(8, '2026_03_15_080001_add_phone_to_users_table', 4),
(9, '2026_03_15_080002_create_products_table', 4),
(10, '2026_03_15_080003_create_product_variants_table', 4),
(11, '2026_03_15_080004_create_product_images_table', 4),
(12, '2026_03_15_080005_create_product_ingredients_table', 4),
(13, '2026_03_15_080006_create_product_nutritions_table', 4),
(14, '2026_03_15_080007_create_inventories_table', 4),
(15, '2026_03_15_080008_create_user_addresses_table', 4),
(16, '2026_03_15_080009_create_carts_table', 4),
(17, '2026_03_15_080010_create_cart_items_table', 4),
(18, '2026_03_15_080011_create_wishlists_table', 4),
(19, '2026_03_15_080012_create_coupons_table', 4),
(20, '2026_03_15_080013_create_orders_table', 4),
(21, '2026_03_15_080014_create_order_items_table', 4),
(22, '2026_03_15_080015_create_payments_table', 4),
(23, '2026_03_15_080016_create_coupon_usages_table', 4),
(24, '2026_03_15_080017_create_reviews_table', 4),
(25, '2026_03_15_080018_create_shipping_methods_table', 4),
(26, '2026_03_20_000001_add_size_and_color_to_product_variants_table', 5),
(27, '2026_03_20_000002_add_product_id_to_order_items_table', 5),
(28, '2026_03_22_120001_create_product_variant_images_table', 6),
(29, '2026_03_22_210000_update_variant_image_schema', 7),
(30, '2026_03_22_220000_add_image_path_to_categories_table', 7);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 5);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `address_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_number` varchar(255) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `coupon_code` varchar(255) DEFAULT NULL,
  `status` enum('pending','confirmed','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `payment_status` enum('unpaid','paid','failed','refunded') NOT NULL DEFAULT 'unpaid',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `address_id`, `order_number`, `subtotal`, `discount_amount`, `shipping_amount`, `total_amount`, `coupon_code`, `status`, `payment_status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 'ORD-20260323202107-7310', 432.00, 0.00, 0.00, 432.00, NULL, 'confirmed', 'paid', 'E2E order test', '2026-03-23 14:51:07', '2026-03-23 14:51:09');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `variant_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `variant_id`, `product_name`, `variant_name`, `price`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 'Hello', 'wer', 432.00, 1, '2026-03-23 14:51:07', '2026-03-23 14:51:07');

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('initiated','success','failed','refunded') NOT NULL DEFAULT 'initiated',
  `gateway_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gateway_payload`)),
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_method`, `transaction_id`, `amount`, `status`, `gateway_payload`, `paid_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'cod', 'TXN-20260324015058', 432.00, 'success', '{\"source\":\"codex-e2e\"}', '2026-03-23 14:51:09', '2026-03-23 14:51:09', '2026-03-23 14:51:09');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin.access', 'web', '2026-04-05 13:20:40', '2026-04-05 13:20:40'),
(2, 'dashboard.view', 'web', '2026-04-05 13:20:40', '2026-04-05 13:20:40'),
(3, 'orders.view', 'web', '2026-04-05 13:20:40', '2026-04-05 13:20:40'),
(4, 'orders.update', 'web', '2026-04-05 13:20:40', '2026-04-05 13:20:40'),
(5, 'payments.view', 'web', '2026-04-05 13:20:40', '2026-04-05 13:20:40'),
(6, 'payments.update', 'web', '2026-04-05 13:20:40', '2026-04-05 13:20:40'),
(7, 'products.view', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(8, 'products.create', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(9, 'products.update', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(10, 'products.delete', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(11, 'categories.view', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(12, 'categories.create', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(13, 'categories.update', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(14, 'categories.delete', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(15, 'inventory.view', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(16, 'inventory.update', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(17, 'coupons.view', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(18, 'coupons.create', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(19, 'coupons.update', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(20, 'coupons.delete', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(21, 'users.view', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(22, 'users.create', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(23, 'users.update', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(24, 'users.delete', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(25, 'reviews.view', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(26, 'reviews.delete', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(27, 'carts.view', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(28, 'wishlists.view', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(29, 'wishlists.delete', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(30, 'blogs.view', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(31, 'blogs.create', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(32, 'blogs.update', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(33, 'blogs.delete', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(34, 'roles.view', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(35, 'roles.create', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(36, 'roles.update', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(37, 'roles.delete', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(38, 'profile.view', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(39, 'profile.update', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(40, 'admin.access', 'sanctum', '2026-04-05 13:22:05', '2026-04-05 13:22:05'),
(41, 'dashboard.view', 'sanctum', '2026-04-05 13:22:05', '2026-04-05 13:22:05'),
(42, 'orders.view', 'sanctum', '2026-04-05 13:22:05', '2026-04-05 13:22:05'),
(43, 'orders.update', 'sanctum', '2026-04-05 13:22:05', '2026-04-05 13:22:05'),
(44, 'payments.view', 'sanctum', '2026-04-05 13:22:05', '2026-04-05 13:22:05'),
(45, 'payments.update', 'sanctum', '2026-04-05 13:22:05', '2026-04-05 13:22:05'),
(46, 'products.view', 'sanctum', '2026-04-05 13:22:05', '2026-04-05 13:22:05'),
(47, 'products.create', 'sanctum', '2026-04-05 13:22:05', '2026-04-05 13:22:05'),
(48, 'products.update', 'sanctum', '2026-04-05 13:22:05', '2026-04-05 13:22:05'),
(49, 'products.delete', 'sanctum', '2026-04-05 13:22:05', '2026-04-05 13:22:05'),
(50, 'categories.view', 'sanctum', '2026-04-05 13:22:05', '2026-04-05 13:22:05'),
(51, 'categories.create', 'sanctum', '2026-04-05 13:22:06', '2026-04-05 13:22:06'),
(52, 'categories.update', 'sanctum', '2026-04-05 13:22:06', '2026-04-05 13:22:06'),
(53, 'categories.delete', 'sanctum', '2026-04-05 13:22:06', '2026-04-05 13:22:06'),
(54, 'inventory.view', 'sanctum', '2026-04-05 13:22:06', '2026-04-05 13:22:06'),
(55, 'inventory.update', 'sanctum', '2026-04-05 13:22:06', '2026-04-05 13:22:06'),
(56, 'coupons.view', 'sanctum', '2026-04-05 13:22:06', '2026-04-05 13:22:06'),
(57, 'coupons.create', 'sanctum', '2026-04-05 13:22:06', '2026-04-05 13:22:06'),
(58, 'coupons.update', 'sanctum', '2026-04-05 13:22:06', '2026-04-05 13:22:06'),
(59, 'coupons.delete', 'sanctum', '2026-04-05 13:22:06', '2026-04-05 13:22:06'),
(60, 'users.view', 'sanctum', '2026-04-05 13:22:06', '2026-04-05 13:22:06'),
(61, 'users.create', 'sanctum', '2026-04-05 13:22:06', '2026-04-05 13:22:06'),
(62, 'users.update', 'sanctum', '2026-04-05 13:22:06', '2026-04-05 13:22:06'),
(63, 'users.delete', 'sanctum', '2026-04-05 13:22:06', '2026-04-05 13:22:06'),
(64, 'reviews.view', 'sanctum', '2026-04-05 13:22:06', '2026-04-05 13:22:06'),
(65, 'reviews.delete', 'sanctum', '2026-04-05 13:22:06', '2026-04-05 13:22:06'),
(66, 'carts.view', 'sanctum', '2026-04-05 13:22:06', '2026-04-05 13:22:06'),
(67, 'wishlists.view', 'sanctum', '2026-04-05 13:22:06', '2026-04-05 13:22:06'),
(68, 'wishlists.delete', 'sanctum', '2026-04-05 13:22:06', '2026-04-05 13:22:06'),
(69, 'blogs.view', 'sanctum', '2026-04-05 13:22:06', '2026-04-05 13:22:06'),
(70, 'blogs.create', 'sanctum', '2026-04-05 13:22:06', '2026-04-05 13:22:06'),
(71, 'blogs.update', 'sanctum', '2026-04-05 13:22:06', '2026-04-05 13:22:06'),
(72, 'blogs.delete', 'sanctum', '2026-04-05 13:22:06', '2026-04-05 13:22:06'),
(73, 'roles.view', 'sanctum', '2026-04-05 13:22:07', '2026-04-05 13:22:07'),
(74, 'roles.create', 'sanctum', '2026-04-05 13:22:07', '2026-04-05 13:22:07'),
(75, 'roles.update', 'sanctum', '2026-04-05 13:22:07', '2026-04-05 13:22:07'),
(76, 'roles.delete', 'sanctum', '2026-04-05 13:22:07', '2026-04-05 13:22:07'),
(77, 'profile.view', 'sanctum', '2026-04-05 13:22:07', '2026-04-05 13:22:07'),
(78, 'profile.update', 'sanctum', '2026-04-05 13:22:07', '2026-04-05 13:22:07');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
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
(1, 'App\\Models\\User', 1, 'auth_token', 'e214b82ad13bd8dca9a3a962f78d15bd1b51501a18a812b706d2fdf728316a9e', '[\"*\"]', NULL, NULL, '2026-03-15 19:56:08', '2026-03-15 19:56:08'),
(2, 'App\\Models\\User', 1, 'auth_token', '58babf41d5c1f377ade9c99ac49ab4fe620b1b68cb7d294d51a9ac0445ddb849', '[\"*\"]', NULL, NULL, '2026-03-15 20:16:57', '2026-03-15 20:16:57'),
(3, 'App\\Models\\User', 2, 'auth_token', '5ccc64df0132c2207bba0571a0ebf21543627dc7f0effa98dae73d0b87e7967a', '[\"*\"]', NULL, NULL, '2026-03-19 13:44:20', '2026-03-19 13:44:20'),
(4, 'App\\Models\\User', 2, 'auth_token', '14e40df21eb7b28dbbb2267a1b733b7d21e2865221547e9738a785c7db8e67eb', '[\"*\"]', '2026-03-19 13:47:57', NULL, '2026-03-19 13:47:55', '2026-03-19 13:47:57'),
(5, 'App\\Models\\User', 2, 'auth_token', '97914da239bf78a8072821c69cff2ad75bdf8ee0ac299e64a17accd46e808404', '[\"*\"]', '2026-03-19 15:37:58', NULL, '2026-03-19 13:47:58', '2026-03-19 15:37:58'),
(7, 'App\\Models\\User', 2, 'auth_token', '01ef873cd0b7431b90095a01dda60adc30cbdff00dab3a8f74c814da61dd2f91', '[\"*\"]', '2026-03-21 15:15:08', NULL, '2026-03-21 15:04:04', '2026-03-21 15:15:08'),
(8, 'App\\Models\\User', 2, 'auth_token', 'b4627bb187a184836536bf1f322576912ed26232d17df994081ee269ed404893', '[\"*\"]', NULL, NULL, '2026-03-21 15:15:57', '2026-03-21 15:15:57'),
(9, 'App\\Models\\User', 2, 'auth_token', '9c9e373051fe63d5893c74e7673d50b56c8b882ec3cf412a9b89b37b6ec33dda', '[\"*\"]', NULL, NULL, '2026-03-21 15:15:59', '2026-03-21 15:15:59'),
(10, 'App\\Models\\User', 2, 'auth_token', '6ec6de15142fc3e42b83f95283cf7a38349702cf350a97b84ab3f6689ba9328b', '[\"*\"]', '2026-03-21 16:25:40', NULL, '2026-03-21 15:24:44', '2026-03-21 16:25:40'),
(11, 'App\\Models\\User', 2, 'auth_token', '9a2a2e595ea97d97e33b25fd6d1888b4496caf92c0889856c1a2c89a0a9d3195', '[\"*\"]', '2026-03-22 07:22:02', NULL, '2026-03-22 04:56:04', '2026-03-22 07:22:02'),
(12, 'App\\Models\\User', 2, 'auth_token', '71ff642dfa7fcc9cac02087b9116c7afe9b89f58bfe64678616b8a0b4341bad5', '[\"*\"]', '2026-03-23 11:58:34', NULL, '2026-03-23 11:58:32', '2026-03-23 11:58:34'),
(13, 'App\\Models\\User', 2, 'auth_token', '210682d31db286637a22153a24529356c28b06b63394aeca91e0d6cac10e5493', '[\"*\"]', '2026-03-23 15:38:32', NULL, '2026-03-23 11:58:38', '2026-03-23 15:38:32'),
(14, 'App\\Models\\User', 4, 'auth_token', 'af73f45779f2a44bc4f50b119e9117486b3edc93a47ada0c42a7a7ccb6813bac', '[\"*\"]', '2026-03-23 14:51:11', NULL, '2026-03-23 14:51:00', '2026-03-23 14:51:11'),
(15, 'App\\Models\\User', 5, 'auth_token', 'c4045ca12f7f1cf67ea033118bd52ded780e4788452583e5400f68d230990c8f', '[\"*\"]', '2026-03-23 14:51:03', NULL, '2026-03-23 14:51:01', '2026-03-23 14:51:03'),
(16, 'App\\Models\\User', 4, 'auth_token', 'd0bfa2d89e47b9e2782d67e3d2794f178e4df03c15adcaebcda02a1de16878d4', '[\"*\"]', '2026-03-23 14:51:30', NULL, '2026-03-23 14:51:30', '2026-03-23 14:51:30'),
(17, 'App\\Models\\User', 2, 'auth_token', '64635f2d15fecc10989f38a896e3ffb0d9986193647c365aef79eb2cd744a3af', '[\"*\"]', '2026-03-26 11:48:35', NULL, '2026-03-26 11:48:04', '2026-03-26 11:48:35'),
(18, 'App\\Models\\User', 2, 'auth_token', '6db243ce9d62d795b13874b709b54190b4a4d5d63c76cf4b1e07604e1181dfe7', '[\"*\"]', '2026-03-28 15:10:14', NULL, '2026-03-28 14:15:06', '2026-03-28 15:10:14'),
(19, 'App\\Models\\User', 2, 'auth_token', 'ef37fa8b441386bd8ea48eb85e997b6b70a126620a559cf9f0d860ac306a7989', '[\"*\"]', '2026-03-29 00:01:53', NULL, '2026-03-29 00:01:51', '2026-03-29 00:01:53'),
(21, 'App\\Models\\User', 2, 'auth_token', '2f875c29933b7491940a288cdbed67b1ead053b87aa8d2a8b1d3fb8d54340dee', '[\"*\"]', '2026-03-29 08:48:48', NULL, '2026-03-29 08:07:00', '2026-03-29 08:48:48'),
(24, 'App\\Models\\User', 2, 'auth_token', 'db0c499b577b5a61aff85b99ffe85c20e3a353544a2d93f1820ea2ff5eb2b23a', '[\"*\"]', '2026-03-29 11:56:08', NULL, '2026-03-29 11:49:19', '2026-03-29 11:56:08'),
(25, 'App\\Models\\User', 2, 'auth_token', '2f8571430fdf1b331aa4c2f565b9be0fc9afbcefbed773c1a868dca3786e872b', '[\"*\"]', '2026-03-30 13:40:45', NULL, '2026-03-30 11:55:57', '2026-03-30 13:40:45'),
(26, 'App\\Models\\User', 2, 'auth_token', '944367463863f6a9767be44009cb3e816d5bf204f20ff8b1f03af8867cb91a69', '[\"*\"]', '2026-03-30 22:08:27', NULL, '2026-03-30 21:36:22', '2026-03-30 22:08:27'),
(28, 'App\\Models\\User', 2, 'auth_token', '499a89cb9cc6aadb3b1661623735128dfe36dd75735d664acff05ca66b531688', '[\"*\"]', '2026-04-05 01:21:21', NULL, '2026-04-05 00:13:57', '2026-04-05 01:21:21'),
(29, 'App\\Models\\User', 2, 'auth_token', '7607f9b2c04414079187e978d225a4da97fc9d9de39b790c427b9ddfe08812a3', '[\"*\"]', '2026-04-05 05:32:09', NULL, '2026-04-05 04:39:41', '2026-04-05 05:32:09'),
(30, 'App\\Models\\User', 2, 'auth_token', 'fd904441b5017aefdd9d7a8fe6cefeee50f2fd0c5ec9a80ed0e33cb4543f2fc0', '[\"*\"]', '2026-04-05 08:19:53', NULL, '2026-04-05 07:55:59', '2026-04-05 08:19:53'),
(31, 'App\\Models\\User', 2, 'auth_token', '0e1a68a356b884a918281451a28c0d3f0132488c2a8455841db9ae355d648c12', '[\"*\"]', '2026-04-05 13:37:42', NULL, '2026-04-05 10:36:13', '2026-04-05 13:37:42');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subcategory_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `short_description` text DEFAULT NULL,
  `allergic_information` text DEFAULT NULL,
  `tea_type` varchar(255) DEFAULT NULL,
  `disclaimer` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `ingredients` text DEFAULT NULL,
  `features` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`features`)),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `subcategory_id`, `name`, `slug`, `short_description`, `allergic_information`, `tea_type`, `disclaimer`, `description`, `ingredients`, `features`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, NULL, 'Hello', 'hello', 'hello', 'wewe', 'wewe', 'qwerwer', 'Hello this is testing', 'heee,eee', '[{\"icon\":\"werw\",\"text\":\"qwerwer\"}]', 1, '2026-03-21 15:07:51', '2026-03-21 15:07:51');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_ingredients`
--

CREATE TABLE `product_ingredients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_nutritions`
--

CREATE TABLE `product_nutritions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `nutrient` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variant_name` varchar(255) NOT NULL,
  `size` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `sku` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `weight` decimal(8,2) DEFAULT NULL,
  `dimensions` varchar(255) DEFAULT NULL,
  `net_weight` varchar(255) DEFAULT NULL,
  `tags` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tags`)),
  `brewing_rituals` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`brewing_rituals`)),
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `variant_name`, `size`, `color`, `sku`, `price`, `stock`, `weight`, `dimensions`, `net_weight`, `tags`, `brewing_rituals`, `is_default`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'wer', '22', 'dd', '23', 432.00, 1, 32.00, '12*12*10', '100', '[\"sfsf\",\"sdfsd\",\"sdf\"]', '[{\"icon\":\"sdf\",\"text\":\"sdfsdf\"}]', 0, 1, '2026-03-21 15:07:52', '2026-03-21 15:07:52');

-- --------------------------------------------------------

--
-- Table structure for table `product_variant_images`
--

CREATE TABLE `product_variant_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `image_url` varchar(255) NOT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `review` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'web', '2026-03-12 12:33:34', '2026-03-12 12:33:34'),
(2, 'customer', 'web', '2026-03-12 12:33:39', '2026-03-12 12:33:39'),
(3, 'manager', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(4, 'staff', 'web', '2026-04-05 13:20:41', '2026-04-05 13:20:41'),
(5, 'staff', 'sanctum', '2026-04-05 13:22:48', '2026-04-05 13:22:48');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 3),
(1, 4),
(2, 1),
(2, 3),
(2, 4),
(3, 1),
(3, 3),
(3, 4),
(4, 1),
(4, 3),
(5, 1),
(5, 3),
(5, 4),
(6, 1),
(6, 3),
(7, 1),
(7, 3),
(7, 4),
(8, 1),
(8, 3),
(9, 1),
(9, 3),
(10, 1),
(11, 1),
(11, 3),
(11, 4),
(12, 1),
(12, 3),
(13, 1),
(13, 3),
(14, 1),
(15, 1),
(15, 3),
(15, 4),
(16, 1),
(16, 3),
(17, 1),
(17, 3),
(17, 4),
(18, 1),
(18, 3),
(19, 1),
(19, 3),
(20, 1),
(21, 1),
(21, 3),
(21, 4),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(25, 3),
(25, 4),
(26, 1),
(26, 3),
(27, 1),
(27, 3),
(27, 4),
(28, 1),
(28, 3),
(28, 4),
(29, 1),
(30, 1),
(30, 3),
(30, 4),
(31, 1),
(31, 3),
(32, 1),
(32, 3),
(33, 1),
(34, 1),
(34, 3),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(38, 3),
(38, 4),
(39, 1),
(39, 3),
(39, 4),
(42, 5),
(43, 5),
(44, 5),
(45, 5),
(46, 5),
(47, 5),
(48, 5),
(49, 5),
(50, 5),
(51, 5),
(52, 5),
(53, 5),
(54, 5),
(55, 5),
(56, 5),
(57, 5),
(58, 5),
(59, 5),
(66, 5),
(67, 5),
(68, 5),
(69, 5),
(77, 5),
(78, 5);

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
('LY3OLeWBgP9WXgW0ecvph10V0uDv6d2zSp1Qnle6', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiajRCSU5oTHp6NE93cWhpN25GcmFlMEZEbkhDakVENndnV0lXVXJ3SyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly9sb2NhbGhvc3QvdGhlS2F3YUNvbXBhbnkvcHVibGljL2FkbWluL2NvdXBvbnMiO3M6NToicm91dGUiO3M6MTk6ImFkbWluLmNvdXBvbnMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjExOiJhZG1pbl90b2tlbiI7czo1MToiMzF8YkI5eERrYnZ0ZG1FRk9XejIwbW90dTY5cjAwaTlMUURSUVFWOGRHQzA4ZjlmNmM2IjtzOjEwOiJhZG1pbl91c2VyIjthOjY6e3M6MjoiaWQiO2k6MjtzOjQ6Im5hbWUiO3M6MTI6IkRlZXBhayBNZWVuYSI7czo1OiJlbWFpbCI7czoxNzoiYWRtaW5AZXhhbXBsZS5jb20iO3M6NToicGhvbmUiO3M6MTA6IjkwMDkyNTUwODUiO3M6NToicm9sZXMiO2E6MTp7aTowO2E6Mjp7czoyOiJpZCI7aToxO3M6NDoibmFtZSI7czo1OiJhZG1pbiI7fX1zOjExOiJwZXJtaXNzaW9ucyI7YTozOTp7aTowO2E6Mjp7czoyOiJpZCI7aToxO3M6NDoibmFtZSI7czoxMjoiYWRtaW4uYWNjZXNzIjt9aToxO2E6Mjp7czoyOiJpZCI7aToyO3M6NDoibmFtZSI7czoxNDoiZGFzaGJvYXJkLnZpZXciO31pOjI7YToyOntzOjI6ImlkIjtpOjM7czo0OiJuYW1lIjtzOjExOiJvcmRlcnMudmlldyI7fWk6MzthOjI6e3M6MjoiaWQiO2k6NDtzOjQ6Im5hbWUiO3M6MTM6Im9yZGVycy51cGRhdGUiO31pOjQ7YToyOntzOjI6ImlkIjtpOjU7czo0OiJuYW1lIjtzOjEzOiJwYXltZW50cy52aWV3Ijt9aTo1O2E6Mjp7czoyOiJpZCI7aTo2O3M6NDoibmFtZSI7czoxNToicGF5bWVudHMudXBkYXRlIjt9aTo2O2E6Mjp7czoyOiJpZCI7aTo3O3M6NDoibmFtZSI7czoxMzoicHJvZHVjdHMudmlldyI7fWk6NzthOjI6e3M6MjoiaWQiO2k6ODtzOjQ6Im5hbWUiO3M6MTU6InByb2R1Y3RzLmNyZWF0ZSI7fWk6ODthOjI6e3M6MjoiaWQiO2k6OTtzOjQ6Im5hbWUiO3M6MTU6InByb2R1Y3RzLnVwZGF0ZSI7fWk6OTthOjI6e3M6MjoiaWQiO2k6MTA7czo0OiJuYW1lIjtzOjE1OiJwcm9kdWN0cy5kZWxldGUiO31pOjEwO2E6Mjp7czoyOiJpZCI7aToxMTtzOjQ6Im5hbWUiO3M6MTU6ImNhdGVnb3JpZXMudmlldyI7fWk6MTE7YToyOntzOjI6ImlkIjtpOjEyO3M6NDoibmFtZSI7czoxNzoiY2F0ZWdvcmllcy5jcmVhdGUiO31pOjEyO2E6Mjp7czoyOiJpZCI7aToxMztzOjQ6Im5hbWUiO3M6MTc6ImNhdGVnb3JpZXMudXBkYXRlIjt9aToxMzthOjI6e3M6MjoiaWQiO2k6MTQ7czo0OiJuYW1lIjtzOjE3OiJjYXRlZ29yaWVzLmRlbGV0ZSI7fWk6MTQ7YToyOntzOjI6ImlkIjtpOjE1O3M6NDoibmFtZSI7czoxNDoiaW52ZW50b3J5LnZpZXciO31pOjE1O2E6Mjp7czoyOiJpZCI7aToxNjtzOjQ6Im5hbWUiO3M6MTY6ImludmVudG9yeS51cGRhdGUiO31pOjE2O2E6Mjp7czoyOiJpZCI7aToxNztzOjQ6Im5hbWUiO3M6MTI6ImNvdXBvbnMudmlldyI7fWk6MTc7YToyOntzOjI6ImlkIjtpOjE4O3M6NDoibmFtZSI7czoxNDoiY291cG9ucy5jcmVhdGUiO31pOjE4O2E6Mjp7czoyOiJpZCI7aToxOTtzOjQ6Im5hbWUiO3M6MTQ6ImNvdXBvbnMudXBkYXRlIjt9aToxOTthOjI6e3M6MjoiaWQiO2k6MjA7czo0OiJuYW1lIjtzOjE0OiJjb3Vwb25zLmRlbGV0ZSI7fWk6MjA7YToyOntzOjI6ImlkIjtpOjIxO3M6NDoibmFtZSI7czoxMDoidXNlcnMudmlldyI7fWk6MjE7YToyOntzOjI6ImlkIjtpOjIyO3M6NDoibmFtZSI7czoxMjoidXNlcnMuY3JlYXRlIjt9aToyMjthOjI6e3M6MjoiaWQiO2k6MjM7czo0OiJuYW1lIjtzOjEyOiJ1c2Vycy51cGRhdGUiO31pOjIzO2E6Mjp7czoyOiJpZCI7aToyNDtzOjQ6Im5hbWUiO3M6MTI6InVzZXJzLmRlbGV0ZSI7fWk6MjQ7YToyOntzOjI6ImlkIjtpOjI1O3M6NDoibmFtZSI7czoxMjoicmV2aWV3cy52aWV3Ijt9aToyNTthOjI6e3M6MjoiaWQiO2k6MjY7czo0OiJuYW1lIjtzOjE0OiJyZXZpZXdzLmRlbGV0ZSI7fWk6MjY7YToyOntzOjI6ImlkIjtpOjI3O3M6NDoibmFtZSI7czoxMDoiY2FydHMudmlldyI7fWk6Mjc7YToyOntzOjI6ImlkIjtpOjI4O3M6NDoibmFtZSI7czoxNDoid2lzaGxpc3RzLnZpZXciO31pOjI4O2E6Mjp7czoyOiJpZCI7aToyOTtzOjQ6Im5hbWUiO3M6MTY6Indpc2hsaXN0cy5kZWxldGUiO31pOjI5O2E6Mjp7czoyOiJpZCI7aTozMDtzOjQ6Im5hbWUiO3M6MTA6ImJsb2dzLnZpZXciO31pOjMwO2E6Mjp7czoyOiJpZCI7aTozMTtzOjQ6Im5hbWUiO3M6MTI6ImJsb2dzLmNyZWF0ZSI7fWk6MzE7YToyOntzOjI6ImlkIjtpOjMyO3M6NDoibmFtZSI7czoxMjoiYmxvZ3MudXBkYXRlIjt9aTozMjthOjI6e3M6MjoiaWQiO2k6MzM7czo0OiJuYW1lIjtzOjEyOiJibG9ncy5kZWxldGUiO31pOjMzO2E6Mjp7czoyOiJpZCI7aTozNDtzOjQ6Im5hbWUiO3M6MTA6InJvbGVzLnZpZXciO31pOjM0O2E6Mjp7czoyOiJpZCI7aTozNTtzOjQ6Im5hbWUiO3M6MTI6InJvbGVzLmNyZWF0ZSI7fWk6MzU7YToyOntzOjI6ImlkIjtpOjM2O3M6NDoibmFtZSI7czoxMjoicm9sZXMudXBkYXRlIjt9aTozNjthOjI6e3M6MjoiaWQiO2k6Mzc7czo0OiJuYW1lIjtzOjEyOiJyb2xlcy5kZWxldGUiO31pOjM3O2E6Mjp7czoyOiJpZCI7aTozODtzOjQ6Im5hbWUiO3M6MTI6InByb2ZpbGUudmlldyI7fWk6Mzg7YToyOntzOjI6ImlkIjtpOjM5O3M6NDoibmFtZSI7czoxNDoicHJvZmlsZS51cGRhdGUiO319fXM6MjQ6ImFkbWluX3Byb2ZpbGVfY2hlY2tlZF9hdCI7aToxNzc1NDE2MDYxO30=', 1775416062);

-- --------------------------------------------------------

--
-- Table structure for table `shipping_methods`
--

CREATE TABLE `shipping_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `base_cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `per_kg_cost` decimal(10,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Test Customer', 'customer@example.com', '9999999999', NULL, '$2y$12$XoAz6Duts8ZEhOm5avxseeGFAQc8OVXfi1f7TnpVBj54T1AdzwY5u', NULL, '2026-03-15 19:56:06', '2026-03-15 19:56:06'),
(2, 'Deepak Meena', 'admin@example.com', '9009255085', NULL, '$2y$12$xfj/NF41oV9Lchog/G7iXOu4Rc6FdfIk4pjnjsv81.vcpaaivhfwy', NULL, '2026-03-19 13:40:59', '2026-03-19 15:36:52'),
(3, 'Test User1', 'test@example.com', '8888888888', NULL, '$2y$12$A/ukiCbyBR4ydm1nU5F1a.Uj1ishEzzigLuIz.gi3O9Ea1eTX6lwq', NULL, '2026-03-19 13:40:59', '2026-03-21 15:59:24'),
(4, 'Codex E2E User 1', 'codex-e2e-20260324015058-1@example.com', '9000000001', NULL, '$2y$12$ED98S2KAu1PzpJQLO/WV2esQFNbVRO3C8emuREoGeP6ceUG80a2ZG', NULL, '2026-03-23 14:51:00', '2026-03-23 14:51:00'),
(5, 'Codex E2E User 2', 'codex-e2e-20260324015058-2@example.com', '9000000002', NULL, '$2y$12$uD8crhep0drPPrGiV4dnn.GT9b1dOI0N6EY00M5Ido3O6T3n7lRoa', NULL, '2026-03-23 14:51:01', '2026-03-23 14:51:01');

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `address_line1` varchar(255) NOT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL DEFAULT 'India',
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_addresses`
--

INSERT INTO `user_addresses` (`id`, `user_id`, `address_line1`, `address_line2`, `city`, `state`, `pincode`, `country`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 4, 'Test Address 1', NULL, 'Delhi', 'Delhi', '110001', 'India', 1, '2026-03-23 14:51:02', '2026-03-23 14:51:02'),
(2, 5, 'Test Address 2', NULL, 'Mumbai', 'Maharashtra', '400001', 'India', 1, '2026-03-23 14:51:03', '2026-03-23 14:51:03');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

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
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `carts_user_id_unique` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cart_items_cart_id_variant_id_unique` (`cart_id`,`variant_id`),
  ADD KEY `cart_items_variant_id_foreign` (`variant_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Indexes for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `coupon_usages_coupon_id_foreign` (`coupon_id`),
  ADD KEY `coupon_usages_user_id_foreign` (`user_id`),
  ADD KEY `coupon_usages_order_id_foreign` (`order_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inventories_variant_id_unique` (`variant_id`);

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
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_address_id_foreign` (`address_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_variant_id_foreign` (`variant_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payments_transaction_id_unique` (`transaction_id`),
  ADD KEY `payments_order_id_foreign` (`order_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_subcategory_id_foreign` (`subcategory_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_ingredients`
--
ALTER TABLE `product_ingredients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_ingredients_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_nutritions`
--
ALTER TABLE `product_nutritions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_nutritions_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_variants_sku_unique` (`sku`),
  ADD KEY `product_variants_product_id_is_default_index` (`product_id`,`is_default`);

--
-- Indexes for table `product_variant_images`
--
ALTER TABLE `product_variant_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_variant_images_variant_id_sort_order_index` (`variant_id`,`sort_order`),
  ADD KEY `product_variant_images_variant_id_is_primary_index` (`variant_id`,`is_primary`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reviews_product_id_user_id_unique` (`product_id`,`user_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `shipping_methods_code_unique` (`code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wishlists_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_ingredients`
--
ALTER TABLE `product_ingredients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_nutritions`
--
ALTER TABLE `product_nutritions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_variant_images`
--
ALTER TABLE `product_variant_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shipping_methods`
--
ALTER TABLE `shipping_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD CONSTRAINT `coupon_usages_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupon_usages_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `coupon_usages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventories`
--
ALTER TABLE `inventories`
  ADD CONSTRAINT `inventories_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_address_id_foreign` FOREIGN KEY (`address_id`) REFERENCES `user_addresses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `order_items_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_ingredients`
--
ALTER TABLE `product_ingredients`
  ADD CONSTRAINT `product_ingredients_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_nutritions`
--
ALTER TABLE `product_nutritions`
  ADD CONSTRAINT `product_nutritions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_variant_images`
--
ALTER TABLE `product_variant_images`
  ADD CONSTRAINT `product_variant_images_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD CONSTRAINT `user_addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
