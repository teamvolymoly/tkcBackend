-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2026 at 07:39 PM
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
-- Table structure for table `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `featured_image_path` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `published_at` timestamp NULL DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `slug`, `excerpt`, `content`, `featured_image_path`, `status`, `published_at`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES
(1, 'Demo Blog Post 1', 'demo-blog-post-1', 'Short excerpt for Demo Blog Post 1', 'Demo Blog Post 1 full content for frontend blog APIs and cards.', 'https://picsum.photos/seed/blog-1/1200/800', 1, '2026-04-07 13:47:22', 'Demo Blog Post 1', 'SEO description for Demo Blog Post 1', '2026-04-08 13:47:22', '2026-04-08 13:47:22'),
(2, 'Demo Blog Post 2', 'demo-blog-post-2', 'Short excerpt for Demo Blog Post 2', 'Demo Blog Post 2 full content for frontend blog APIs and cards.', 'https://picsum.photos/seed/blog-2/1200/800', 1, '2026-04-06 13:47:22', 'Demo Blog Post 2', 'SEO description for Demo Blog Post 2', '2026-04-08 13:47:22', '2026-04-08 13:47:22'),
(3, 'Demo Blog Post 3', 'demo-blog-post-3', 'Short excerpt for Demo Blog Post 3', 'Demo Blog Post 3 full content for frontend blog APIs and cards.', 'https://picsum.photos/seed/blog-3/1200/800', 1, '2026-04-05 13:47:22', 'Demo Blog Post 3', 'SEO description for Demo Blog Post 3', '2026-04-08 13:47:22', '2026-04-08 13:47:22'),
(4, 'Demo Blog Post 4', 'demo-blog-post-4', 'Short excerpt for Demo Blog Post 4', 'Demo Blog Post 4 full content for frontend blog APIs and cards.', 'https://picsum.photos/seed/blog-4/1200/800', 1, '2026-04-04 13:47:22', 'Demo Blog Post 4', 'SEO description for Demo Blog Post 4', '2026-04-08 13:47:22', '2026-04-08 13:47:22'),
(5, 'Demo Blog Post 5', 'demo-blog-post-5', 'Short excerpt for Demo Blog Post 5', 'Demo Blog Post 5 full content for frontend blog APIs and cards.', 'https://picsum.photos/seed/blog-5/1200/800', 1, '2026-04-03 13:47:22', 'Demo Blog Post 5', 'SEO description for Demo Blog Post 5', '2026-04-08 13:47:22', '2026-04-08 13:47:22'),
(6, 'Demo Blog Post 6', 'demo-blog-post-6', 'Short excerpt for Demo Blog Post 6', 'Demo Blog Post 6 full content for frontend blog APIs and cards.', 'https://picsum.photos/seed/blog-6/1200/800', 1, '2026-04-02 13:47:22', 'Demo Blog Post 6', 'SEO description for Demo Blog Post 6', '2026-04-08 13:47:22', '2026-04-08 13:47:22'),
(7, 'Demo Blog Post 7', 'demo-blog-post-7', 'Short excerpt for Demo Blog Post 7', 'Demo Blog Post 7 full content for frontend blog APIs and cards.', 'https://picsum.photos/seed/blog-7/1200/800', 1, '2026-04-01 13:47:22', 'Demo Blog Post 7', 'SEO description for Demo Blog Post 7', '2026-04-08 13:47:22', '2026-04-08 13:47:22'),
(8, 'Demo Blog Post 8', 'demo-blog-post-8', 'Short excerpt for Demo Blog Post 8', 'Demo Blog Post 8 full content for frontend blog APIs and cards.', 'https://picsum.photos/seed/blog-8/1200/800', 1, '2026-03-31 13:47:22', 'Demo Blog Post 8', 'SEO description for Demo Blog Post 8', '2026-04-08 13:47:22', '2026-04-08 13:47:22'),
(9, 'Demo Blog Post 9', 'demo-blog-post-9', 'Short excerpt for Demo Blog Post 9', 'Demo Blog Post 9 full content for frontend blog APIs and cards.', 'https://picsum.photos/seed/blog-9/1200/800', 1, '2026-03-30 13:47:22', 'Demo Blog Post 9', 'SEO description for Demo Blog Post 9', '2026-04-08 13:47:22', '2026-04-08 13:47:22'),
(10, 'Demo Blog Post 10', 'demo-blog-post-10', 'Short excerpt for Demo Blog Post 10', 'Demo Blog Post 10 full content for frontend blog APIs and cards.', 'https://picsum.photos/seed/blog-10/1200/800', 1, '2026-03-29 13:47:22', 'Demo Blog Post 10', 'SEO description for Demo Blog Post 10', '2026-04-08 13:47:22', '2026-04-08 13:47:22');

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
('laravel_cache_spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:86:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:12:\"admin.access\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:14:\"dashboard.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:11:\"orders.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:13:\"orders.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:13:\"payments.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:15:\"payments.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:13:\"products.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:15:\"products.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:15:\"products.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:15:\"products.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:15:\"categories.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:17:\"categories.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:17:\"categories.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:17:\"categories.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:14:\"inventory.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:16:\"inventory.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:12:\"coupons.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:14:\"coupons.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:14:\"coupons.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:14:\"coupons.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:10:\"users.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:12:\"users.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:12:\"users.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:12:\"users.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:12:\"reviews.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:14:\"reviews.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:10:\"carts.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:14:\"wishlists.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:16:\"wishlists.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:10:\"blogs.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:12:\"blogs.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:12:\"blogs.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:32;a:4:{s:1:\"a\";i:33;s:1:\"b\";s:12:\"blogs.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:33;a:4:{s:1:\"a\";i:34;s:1:\"b\";s:10:\"roles.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:34;a:4:{s:1:\"a\";i:35;s:1:\"b\";s:12:\"roles.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:35;a:4:{s:1:\"a\";i:36;s:1:\"b\";s:12:\"roles.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:36;a:4:{s:1:\"a\";i:37;s:1:\"b\";s:12:\"roles.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:12:\"profile.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:14:\"profile.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:39;a:3:{s:1:\"a\";i:40;s:1:\"b\";s:12:\"admin.access\";s:1:\"c\";s:7:\"sanctum\";}i:40;a:3:{s:1:\"a\";i:41;s:1:\"b\";s:14:\"dashboard.view\";s:1:\"c\";s:7:\"sanctum\";}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:11:\"orders.view\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:13:\"orders.update\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:13:\"payments.view\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:15:\"payments.update\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:13:\"products.view\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:46;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:15:\"products.create\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:47;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:15:\"products.update\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:48;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:15:\"products.delete\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:49;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:15:\"categories.view\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:50;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:17:\"categories.create\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:51;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:17:\"categories.update\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:52;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:17:\"categories.delete\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:53;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:14:\"inventory.view\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:54;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:16:\"inventory.update\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:55;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:12:\"coupons.view\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:56;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:14:\"coupons.create\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:57;a:4:{s:1:\"a\";i:58;s:1:\"b\";s:14:\"coupons.update\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:58;a:4:{s:1:\"a\";i:59;s:1:\"b\";s:14:\"coupons.delete\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:59;a:3:{s:1:\"a\";i:60;s:1:\"b\";s:10:\"users.view\";s:1:\"c\";s:7:\"sanctum\";}i:60;a:3:{s:1:\"a\";i:61;s:1:\"b\";s:12:\"users.create\";s:1:\"c\";s:7:\"sanctum\";}i:61;a:3:{s:1:\"a\";i:62;s:1:\"b\";s:12:\"users.update\";s:1:\"c\";s:7:\"sanctum\";}i:62;a:3:{s:1:\"a\";i:63;s:1:\"b\";s:12:\"users.delete\";s:1:\"c\";s:7:\"sanctum\";}i:63;a:3:{s:1:\"a\";i:64;s:1:\"b\";s:12:\"reviews.view\";s:1:\"c\";s:7:\"sanctum\";}i:64;a:3:{s:1:\"a\";i:65;s:1:\"b\";s:14:\"reviews.delete\";s:1:\"c\";s:7:\"sanctum\";}i:65;a:4:{s:1:\"a\";i:66;s:1:\"b\";s:10:\"carts.view\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:66;a:4:{s:1:\"a\";i:67;s:1:\"b\";s:14:\"wishlists.view\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:67;a:4:{s:1:\"a\";i:68;s:1:\"b\";s:16:\"wishlists.delete\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:68;a:4:{s:1:\"a\";i:69;s:1:\"b\";s:10:\"blogs.view\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:69;a:3:{s:1:\"a\";i:70;s:1:\"b\";s:12:\"blogs.create\";s:1:\"c\";s:7:\"sanctum\";}i:70;a:3:{s:1:\"a\";i:71;s:1:\"b\";s:12:\"blogs.update\";s:1:\"c\";s:7:\"sanctum\";}i:71;a:3:{s:1:\"a\";i:72;s:1:\"b\";s:12:\"blogs.delete\";s:1:\"c\";s:7:\"sanctum\";}i:72;a:3:{s:1:\"a\";i:73;s:1:\"b\";s:10:\"roles.view\";s:1:\"c\";s:7:\"sanctum\";}i:73;a:3:{s:1:\"a\";i:74;s:1:\"b\";s:12:\"roles.create\";s:1:\"c\";s:7:\"sanctum\";}i:74;a:3:{s:1:\"a\";i:75;s:1:\"b\";s:12:\"roles.update\";s:1:\"c\";s:7:\"sanctum\";}i:75;a:3:{s:1:\"a\";i:76;s:1:\"b\";s:12:\"roles.delete\";s:1:\"c\";s:7:\"sanctum\";}i:76;a:4:{s:1:\"a\";i:77;s:1:\"b\";s:12:\"profile.view\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:77;a:4:{s:1:\"a\";i:78;s:1:\"b\";s:14:\"profile.update\";s:1:\"c\";s:7:\"sanctum\";s:1:\"r\";a:1:{i:0;i:5;}}i:78;a:4:{s:1:\"a\";i:79;s:1:\"b\";s:18:\"hero_sections.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:79;a:4:{s:1:\"a\";i:80;s:1:\"b\";s:20:\"hero_sections.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:80;a:4:{s:1:\"a\";i:81;s:1:\"b\";s:20:\"hero_sections.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:3;}}i:81;a:4:{s:1:\"a\";i:82;s:1:\"b\";s:20:\"hero_sections.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:82;a:3:{s:1:\"a\";i:83;s:1:\"b\";s:18:\"hero_sections.view\";s:1:\"c\";s:7:\"sanctum\";}i:83;a:3:{s:1:\"a\";i:84;s:1:\"b\";s:20:\"hero_sections.create\";s:1:\"c\";s:7:\"sanctum\";}i:84;a:3:{s:1:\"a\";i:85;s:1:\"b\";s:20:\"hero_sections.update\";s:1:\"c\";s:7:\"sanctum\";}i:85;a:3:{s:1:\"a\";i:86;s:1:\"b\";s:20:\"hero_sections.delete\";s:1:\"c\";s:7:\"sanctum\";}}s:5:\"roles\";a:4:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:7:\"manager\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:5:\"staff\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:5:\"staff\";s:1:\"c\";s:7:\"sanctum\";}}}', 1775762318);

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
(12, 3, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(13, 16, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(14, 17, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(15, 18, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(16, 19, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(17, 20, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(18, 21, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(19, 22, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(20, 23, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(21, 24, '2026-04-08 13:47:21', '2026-04-08 13:47:21');

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
(13, 12, 25, 2, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(14, 13, 26, 3, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(15, 14, 27, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(16, 15, 28, 2, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(17, 16, 29, 3, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(18, 17, 30, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(19, 18, 31, 2, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(20, 19, 32, 3, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(21, 20, 33, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(22, 21, 34, 2, '2026-04-08 13:47:21', '2026-04-08 13:47:21');

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
(25, 'Kahwa Blends', 'kahwa-blends', 'Demo category Kahwa Blends for frontend API testing.', 'https://picsum.photos/seed/category-0/900/900', NULL, 1, '2026-04-08 13:47:18', '2026-04-08 13:47:18'),
(26, 'Herbal Tea', 'herbal-tea', 'Demo category Herbal Tea for frontend API testing.', 'https://picsum.photos/seed/category-1/900/900', NULL, 1, '2026-04-08 13:47:18', '2026-04-08 13:47:18'),
(27, 'Green Tea', 'green-tea', 'Demo category Green Tea for frontend API testing.', 'https://picsum.photos/seed/category-2/900/900', NULL, 1, '2026-04-08 13:47:18', '2026-04-08 13:47:18'),
(28, 'Black Tea', 'black-tea', 'Demo category Black Tea for frontend API testing.', 'https://picsum.photos/seed/category-3/900/900', NULL, 1, '2026-04-08 13:47:18', '2026-04-08 13:47:18'),
(29, 'Wellness Tea', 'wellness-tea', 'Demo category Wellness Tea for frontend API testing.', 'https://picsum.photos/seed/category-4/900/900', NULL, 1, '2026-04-08 13:47:18', '2026-04-08 13:47:18'),
(30, 'Iced Tea', 'iced-tea', 'Demo category Iced Tea for frontend API testing.', 'https://picsum.photos/seed/category-5/900/900', NULL, 1, '2026-04-08 13:47:18', '2026-04-08 13:47:18'),
(31, 'Gift Boxes', 'gift-boxes', 'Demo category Gift Boxes for frontend API testing.', 'https://picsum.photos/seed/category-6/900/900', NULL, 1, '2026-04-08 13:47:18', '2026-04-08 13:47:18'),
(32, 'Tea Accessories', 'tea-accessories', 'Demo category Tea Accessories for frontend API testing.', 'https://picsum.photos/seed/category-7/900/900', NULL, 1, '2026-04-08 13:47:18', '2026-04-08 13:47:18'),
(33, 'Seasonal Editions', 'seasonal-editions', 'Demo category Seasonal Editions for frontend API testing.', 'https://picsum.photos/seed/category-8/900/900', NULL, 1, '2026-04-08 13:47:18', '2026-04-08 13:47:18'),
(34, 'Signature Tea', 'signature-tea', 'Demo category Signature Tea for frontend API testing.', 'https://picsum.photos/seed/category-9/900/900', NULL, 1, '2026-04-08 13:47:18', '2026-04-08 13:47:18'),
(35, 'Kahwa Blends Special', 'kahwa-blends-special', 'Subcategory for Kahwa Blends.', 'https://picsum.photos/seed/subcategory-0/900/900', 25, 1, '2026-04-08 13:47:18', '2026-04-08 13:47:18'),
(36, 'Herbal Tea Special', 'herbal-tea-special', 'Subcategory for Herbal Tea.', 'https://picsum.photos/seed/subcategory-1/900/900', 26, 1, '2026-04-08 13:47:18', '2026-04-08 13:47:18'),
(37, 'Green Tea Special', 'green-tea-special', 'Subcategory for Green Tea.', 'https://picsum.photos/seed/subcategory-2/900/900', 27, 1, '2026-04-08 13:47:18', '2026-04-08 13:47:18'),
(38, 'Black Tea Special', 'black-tea-special', 'Subcategory for Black Tea.', 'https://picsum.photos/seed/subcategory-3/900/900', 28, 1, '2026-04-08 13:47:18', '2026-04-08 13:47:18'),
(39, 'Wellness Tea Special', 'wellness-tea-special', 'Subcategory for Wellness Tea.', 'https://picsum.photos/seed/subcategory-4/900/900', 29, 1, '2026-04-08 13:47:18', '2026-04-08 13:47:18'),
(40, 'Iced Tea Special', 'iced-tea-special', 'Subcategory for Iced Tea.', 'https://picsum.photos/seed/subcategory-5/900/900', 30, 1, '2026-04-08 13:47:18', '2026-04-08 13:47:18'),
(41, 'Gift Boxes Special', 'gift-boxes-special', 'Subcategory for Gift Boxes.', 'https://picsum.photos/seed/subcategory-6/900/900', 31, 1, '2026-04-08 13:47:18', '2026-04-08 13:47:18'),
(42, 'Tea Accessories Special', 'tea-accessories-special', 'Subcategory for Tea Accessories.', 'https://picsum.photos/seed/subcategory-7/900/900', 32, 1, '2026-04-08 13:47:18', '2026-04-08 13:47:18'),
(43, 'Seasonal Editions Special', 'seasonal-editions-special', 'Subcategory for Seasonal Editions.', 'https://picsum.photos/seed/subcategory-8/900/900', 33, 1, '2026-04-08 13:47:18', '2026-04-08 13:47:18'),
(44, 'Signature Tea Special', 'signature-tea-special', 'Subcategory for Signature Tea.', 'https://picsum.photos/seed/subcategory-9/900/900', 34, 1, '2026-04-08 13:47:18', '2026-04-08 13:47:18');

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
  `required_completed_orders` int(10) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `discount_type`, `discount_value`, `min_order_amount`, `max_discount`, `expiry_date`, `usage_limit`, `per_user_limit`, `required_completed_orders`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'WELCOME10', 'percent', 10.00, 299.00, 150.00, '2026-06-08', 200, 5, NULL, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(3, 'DEMO02', 'percent', 7.00, 239.00, 200.00, '2026-04-25', 100, 2, NULL, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(4, 'DEMO03', 'fixed', 80.00, 259.00, NULL, '2026-04-26', 100, 2, NULL, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(5, 'DEMO04', 'percent', 9.00, 279.00, 200.00, '2026-04-27', 100, 2, NULL, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(6, 'DEMO05', 'fixed', 100.00, 299.00, NULL, '2026-04-28', 100, 2, NULL, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(7, 'DEMO06', 'percent', 11.00, 319.00, 200.00, '2026-04-29', 100, 2, NULL, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(8, 'DEMO07', 'fixed', 120.00, 339.00, NULL, '2026-04-30', 100, 2, NULL, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(9, 'DEMO08', 'percent', 13.00, 359.00, 200.00, '2026-05-01', 100, 2, 1, 1, '2026-04-08 13:47:22', '2026-04-08 13:47:22'),
(10, 'DEMO09', 'fixed', 140.00, 379.00, NULL, '2026-05-02', 100, 2, 1, 1, '2026-04-08 13:47:22', '2026-04-08 13:47:22'),
(11, 'DEMO10', 'percent', 15.00, 399.00, 200.00, '2026-05-03', 100, 2, 1, 1, '2026-04-08 13:47:22', '2026-04-08 13:47:22');

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

--
-- Dumping data for table `coupon_usages`
--

INSERT INTO `coupon_usages` (`id`, `coupon_id`, `user_id`, `order_id`, `used_at`, `created_at`, `updated_at`) VALUES
(1, 2, 17, 7, '2026-03-31 13:47:21', '2026-04-08 13:47:22', '2026-04-08 13:47:22'),
(2, 2, 20, 10, '2026-04-03 13:47:21', '2026-04-08 13:47:22', '2026-04-08 13:47:22'),
(3, 2, 23, 13, '2026-04-06 13:47:21', '2026-04-08 13:47:22', '2026-04-08 13:47:22');

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
-- Table structure for table `hero_sections`
--

CREATE TABLE `hero_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_image_path` varchar(255) DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_slug` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `hero_sections`
--

INSERT INTO `hero_sections` (`id`, `product_image_path`, `product_name`, `product_slug`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(2, 'https://picsum.photos/seed/variant-0-0-1/1000/1000', 'Hibiscus Kahwa', 'hibiscus-kahwa', 1, 0, '2026-04-08 13:47:22', '2026-04-08 13:47:22'),
(3, 'https://picsum.photos/seed/variant-1-0-1/1000/1000', 'Mint Kahwa', 'mint-kahwa', 1, 1, '2026-04-08 13:47:22', '2026-04-08 13:47:22'),
(4, 'https://picsum.photos/seed/variant-2-0-1/1000/1000', 'Kashmiri Kahwa', 'kashmiri-kahwa', 1, 2, '2026-04-08 13:47:22', '2026-04-08 13:47:22'),
(5, 'https://picsum.photos/seed/variant-3-0-1/1000/1000', 'Oolong Kahwa', 'oolong-kahwa', 1, 3, '2026-04-08 13:47:22', '2026-04-08 13:47:22'),
(6, 'https://picsum.photos/seed/variant-4-0-1/1000/1000', 'Chamomile Tea', 'chamomile-tea', 1, 4, '2026-04-08 13:47:22', '2026-04-08 13:47:22'),
(7, 'https://picsum.photos/seed/variant-5-0-1/1000/1000', 'Detox Green Tea', 'detox-green-tea', 1, 5, '2026-04-08 13:47:22', '2026-04-08 13:47:22'),
(8, 'https://picsum.photos/seed/variant-6-0-1/1000/1000', 'Immunity Blend', 'immunity-blend', 1, 6, '2026-04-08 13:47:22', '2026-04-08 13:47:22'),
(9, 'https://picsum.photos/seed/variant-7-0-1/1000/1000', 'Saffron Elixir', 'saffron-elixir', 1, 7, '2026-04-08 13:47:22', '2026-04-08 13:47:22'),
(10, 'https://picsum.photos/seed/variant-8-0-1/1000/1000', 'Rose Herbal Infusion', 'rose-herbal-infusion', 1, 8, '2026-04-08 13:47:22', '2026-04-08 13:47:22'),
(11, 'https://picsum.photos/seed/variant-9-0-1/1000/1000', 'Lemongrass Refresh', 'lemongrass-refresh', 1, 9, '2026-04-08 13:47:22', '2026-04-08 13:47:22');

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
(23, 25, 23, 0, 'default', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(24, 26, 28, 0, 'default', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(25, 27, 26, 0, 'default', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(26, 28, 31, 0, 'default', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(27, 29, 29, 0, 'default', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(28, 30, 34, 0, 'default', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(29, 31, 32, 0, 'default', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(30, 32, 37, 0, 'default', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(31, 33, 35, 0, 'default', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(32, 34, 40, 0, 'default', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(33, 35, 38, 0, 'default', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(34, 36, 43, 0, 'default', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(35, 37, 41, 0, 'default', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(36, 38, 46, 0, 'default', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(37, 39, 44, 0, 'default', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(38, 40, 49, 0, 'default', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(39, 41, 47, 0, 'default', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(40, 42, 52, 0, 'default', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(41, 43, 50, 0, 'default', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(42, 44, 55, 0, 'default', '2026-04-08 13:47:21', '2026-04-08 13:47:21');

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
(30, '2026_03_22_220000_add_image_path_to_categories_table', 7),
(31, '2026_03_23_090000_add_required_completed_orders_to_coupons_table', 8),
(32, '2026_03_24_090000_drop_shipping_methods_table', 8),
(33, '2026_03_24_100000_drop_product_images_table', 8),
(34, '2026_04_05_000001_create_blog_posts_table', 8),
(35, '2026_04_06_000001_create_hero_sections_table', 8),
(36, '2026_04_08_000001_add_compare_price_to_product_variants_table', 9),
(37, '2026_04_08_000002_add_image_path_to_product_ingredients_table', 9);

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
(2, 'App\\Models\\User', 5),
(2, 'App\\Models\\User', 6),
(2, 'App\\Models\\User', 7),
(2, 'App\\Models\\User', 8),
(2, 'App\\Models\\User', 9),
(2, 'App\\Models\\User', 10),
(2, 'App\\Models\\User', 11),
(2, 'App\\Models\\User', 12),
(2, 'App\\Models\\User', 13),
(2, 'App\\Models\\User', 14),
(2, 'App\\Models\\User', 15),
(2, 'App\\Models\\User', 16),
(2, 'App\\Models\\User', 17),
(2, 'App\\Models\\User', 18),
(2, 'App\\Models\\User', 19),
(2, 'App\\Models\\User', 20),
(2, 'App\\Models\\User', 21),
(2, 'App\\Models\\User', 22),
(2, 'App\\Models\\User', 23),
(2, 'App\\Models\\User', 24);

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
(5, 3, 15, 'ORD-DEMO-0001', 818.00, 0.00, 0.00, 818.00, NULL, 'confirmed', 'paid', 'Demo order for frontend API testing.', '2026-03-29 13:47:21', '2026-03-30 13:47:21'),
(6, 16, 16, 'ORD-DEMO-0002', 759.00, 0.00, 0.00, 759.00, NULL, 'processing', 'unpaid', 'Demo order for frontend API testing.', '2026-03-30 13:47:21', '2026-03-31 13:47:21'),
(7, 17, 17, 'ORD-DEMO-0003', 838.00, 50.00, 0.00, 788.00, 'WELCOME10', 'shipped', 'paid', 'Demo order for frontend API testing.', '2026-03-31 13:47:21', '2026-04-01 13:47:21'),
(8, 18, 18, 'ORD-DEMO-0004', 769.00, 0.00, 0.00, 769.00, NULL, 'delivered', 'paid', 'Demo order for frontend API testing.', '2026-04-01 13:47:21', '2026-04-02 13:47:21'),
(9, 19, 19, 'ORD-DEMO-0005', 858.00, 0.00, 0.00, 858.00, NULL, 'pending', 'unpaid', 'Demo order for frontend API testing.', '2026-04-02 13:47:21', '2026-04-03 13:47:21'),
(10, 20, 20, 'ORD-DEMO-0006', 779.00, 50.00, 0.00, 729.00, 'WELCOME10', 'confirmed', 'paid', 'Demo order for frontend API testing.', '2026-04-03 13:47:21', '2026-04-04 13:47:21'),
(11, 21, 21, 'ORD-DEMO-0007', 878.00, 0.00, 0.00, 878.00, NULL, 'processing', 'unpaid', 'Demo order for frontend API testing.', '2026-04-04 13:47:21', '2026-04-05 13:47:21'),
(12, 22, 22, 'ORD-DEMO-0008', 789.00, 0.00, 0.00, 789.00, NULL, 'shipped', 'paid', 'Demo order for frontend API testing.', '2026-04-05 13:47:21', '2026-04-06 13:47:21'),
(13, 23, 23, 'ORD-DEMO-0009', 898.00, 50.00, 0.00, 848.00, 'WELCOME10', 'delivered', 'paid', 'Demo order for frontend API testing.', '2026-04-06 13:47:21', '2026-04-07 13:47:21'),
(14, 24, 24, 'ORD-DEMO-0010', 799.00, 0.00, 0.00, 799.00, NULL, 'pending', 'unpaid', 'Demo order for frontend API testing.', '2026-04-07 13:47:21', '2026-04-08 13:47:21');

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
(5, 5, 15, 25, 'Hibiscus Kahwa', '100g', 409.00, 2, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(6, 6, 15, 26, 'Hibiscus Kahwa', '200g', 759.00, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(7, 7, 16, 27, 'Mint Kahwa', '100g', 419.00, 2, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(8, 8, 16, 28, 'Mint Kahwa', '200g', 769.00, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(9, 9, 17, 29, 'Kashmiri Kahwa', '100g', 429.00, 2, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(10, 10, 17, 30, 'Kashmiri Kahwa', '200g', 779.00, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(11, 11, 18, 31, 'Oolong Kahwa', '100g', 439.00, 2, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(12, 12, 18, 32, 'Oolong Kahwa', '200g', 789.00, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(13, 13, 19, 33, 'Chamomile Tea', '100g', 449.00, 2, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(14, 14, 19, 34, 'Chamomile Tea', '200g', 799.00, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21');

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
(5, 5, 'cod', 'TXN-DEMO-00001', 818.00, 'success', '{\"source\":\"demo-seeder\",\"order\":\"ORD-DEMO-0001\"}', '2026-03-30 13:47:21', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(6, 6, 'razorpay', 'TXN-DEMO-00002', 759.00, 'initiated', '{\"source\":\"demo-seeder\",\"order\":\"ORD-DEMO-0002\"}', NULL, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(7, 7, 'cod', 'TXN-DEMO-00003', 788.00, 'success', '{\"source\":\"demo-seeder\",\"order\":\"ORD-DEMO-0003\"}', '2026-04-01 13:47:21', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(8, 8, 'razorpay', 'TXN-DEMO-00004', 769.00, 'success', '{\"source\":\"demo-seeder\",\"order\":\"ORD-DEMO-0004\"}', '2026-04-02 13:47:21', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(9, 9, 'cod', 'TXN-DEMO-00005', 858.00, 'initiated', '{\"source\":\"demo-seeder\",\"order\":\"ORD-DEMO-0005\"}', NULL, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(10, 10, 'razorpay', 'TXN-DEMO-00006', 729.00, 'success', '{\"source\":\"demo-seeder\",\"order\":\"ORD-DEMO-0006\"}', '2026-04-04 13:47:21', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(11, 11, 'cod', 'TXN-DEMO-00007', 878.00, 'initiated', '{\"source\":\"demo-seeder\",\"order\":\"ORD-DEMO-0007\"}', NULL, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(12, 12, 'razorpay', 'TXN-DEMO-00008', 789.00, 'success', '{\"source\":\"demo-seeder\",\"order\":\"ORD-DEMO-0008\"}', '2026-04-06 13:47:21', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(13, 13, 'cod', 'TXN-DEMO-00009', 848.00, 'success', '{\"source\":\"demo-seeder\",\"order\":\"ORD-DEMO-0009\"}', '2026-04-07 13:47:21', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(14, 14, 'razorpay', 'TXN-DEMO-00010', 799.00, 'initiated', '{\"source\":\"demo-seeder\",\"order\":\"ORD-DEMO-0010\"}', NULL, '2026-04-08 13:47:21', '2026-04-08 13:47:21');

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
(78, 'profile.update', 'sanctum', '2026-04-05 13:22:07', '2026-04-05 13:22:07'),
(79, 'hero_sections.view', 'web', '2026-04-05 14:31:34', '2026-04-05 14:31:34'),
(80, 'hero_sections.create', 'web', '2026-04-05 14:31:34', '2026-04-05 14:31:34'),
(81, 'hero_sections.update', 'web', '2026-04-05 14:31:34', '2026-04-05 14:31:34'),
(82, 'hero_sections.delete', 'web', '2026-04-05 14:31:34', '2026-04-05 14:31:34'),
(83, 'hero_sections.view', 'sanctum', '2026-04-08 13:36:36', '2026-04-08 13:36:36'),
(84, 'hero_sections.create', 'sanctum', '2026-04-08 13:36:36', '2026-04-08 13:36:36'),
(85, 'hero_sections.update', 'sanctum', '2026-04-08 13:36:36', '2026-04-08 13:36:36'),
(86, 'hero_sections.delete', 'sanctum', '2026-04-08 13:36:36', '2026-04-08 13:36:36');

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
(31, 'App\\Models\\User', 2, 'auth_token', '0e1a68a356b884a918281451a28c0d3f0132488c2a8455841db9ae355d648c12', '[\"*\"]', '2026-04-05 13:37:42', NULL, '2026-04-05 10:36:13', '2026-04-05 13:37:42'),
(34, 'App\\Models\\User', 2, 'auth_token', 'efef89023ce154fadb049f37917a7f687da70d6fc2b57506aaa1ec44f9882079', '[\"*\"]', '2026-04-05 21:57:36', NULL, '2026-04-05 20:49:41', '2026-04-05 21:57:36'),
(36, 'App\\Models\\User', 2, 'auth_token', 'b2644e9fc5a732a1d61d595a511ef00642aedfc28e231e696eec22f3346ffc7c', '[\"*\"]', '2026-04-05 22:22:00', NULL, '2026-04-05 22:21:59', '2026-04-05 22:22:00'),
(37, 'App\\Models\\User', 2, 'auth_token', 'c133d8cfe27cb909b0b1f78d888a7b21096dedc0de7baf5be355ca0cb64a36da', '[\"*\"]', '2026-04-06 22:54:39', NULL, '2026-04-06 10:45:11', '2026-04-06 22:54:39'),
(38, 'App\\Models\\User', 2, 'auth_token', '2cdb0a981688bd60dc1f01e3fdb24e3b4c63c83b5fa32428b0abd7c9dff082d2', '[\"*\"]', '2026-04-06 10:54:31', NULL, '2026-04-06 10:52:10', '2026-04-06 10:54:31'),
(39, 'App\\Models\\User', 6, 'auth_token', 'ea04c99a58e355ef13e3d16d5e422dccf0fde4d4e6a4fe89ccdff881cf5eba01', '[\"*\"]', NULL, NULL, '2026-04-06 10:52:21', '2026-04-06 10:52:21'),
(40, 'App\\Models\\User', 2, 'auth_token', '0581954573a4db0f48d58035ac6a7dc958000928fd33d50b6b942791d70d87bc', '[\"*\"]', '2026-04-07 12:07:20', NULL, '2026-04-06 11:35:34', '2026-04-07 12:07:20'),
(42, 'App\\Models\\User', 2, 'auth_token', 'd01fa2a794c9ccd373950e94b8fa7ecd7950e68a7b670beb4b0e9030f80373c0', '[\"*\"]', '2026-04-06 23:35:11', NULL, '2026-04-06 11:49:50', '2026-04-06 23:35:11'),
(43, 'App\\Models\\User', 2, 'auth_token', '64b9d4969bcc38ded4591371678c8155cf3f471a0db73197717a0b974c2ad5ea', '[\"*\"]', NULL, NULL, '2026-04-06 22:38:13', '2026-04-06 22:38:13'),
(44, 'App\\Models\\User', 2, 'auth_token', 'b689d23a974310ae1a6c18dd96d29311dc3605a0c4e8d22cf750b6e48942d6ae', '[\"*\"]', '2026-04-07 12:06:42', NULL, '2026-04-07 12:00:02', '2026-04-07 12:06:42'),
(45, 'App\\Models\\User', 2, 'auth_token', 'f81514a63b42d2530f184d2ef5bbd26fdb44141ae2755dd26c4777f64699ece1', '[\"*\"]', '2026-04-07 13:51:43', NULL, '2026-04-07 12:36:12', '2026-04-07 13:51:43'),
(46, 'App\\Models\\User', 2, 'auth_token', 'b3d495071a7c5d27a27888c4c38a800d59b6ef1a1e86826c687df9ace0ab4486', '[\"*\"]', '2026-04-07 21:56:26', NULL, '2026-04-07 20:18:32', '2026-04-07 21:56:26'),
(47, 'App\\Models\\User', 2, 'auth_token', 'd73e37d7b6b9e480d93964023f3f15d35b3aa60213eb1c89434b366e8ead38af', '[\"*\"]', '2026-04-08 13:50:00', NULL, '2026-04-08 12:08:33', '2026-04-08 13:50:00'),
(48, 'App\\Models\\User', 2, 'auth_token', '3abeaa8dd407f7d32ea923fefa5452cf5d112e1a57d67fce1eca46eccbcf1cd3', '[\"*\"]', '2026-04-08 22:30:15', NULL, '2026-04-08 22:30:05', '2026-04-08 22:30:15'),
(49, 'App\\Models\\User', 2, 'auth_token', '804143dfa3702654b93b5107bb83cb6884a6d492b229c8cc5d80b821730bcc3d', '[\"*\"]', '2026-04-09 19:49:07', NULL, '2026-04-09 19:26:08', '2026-04-09 19:49:07');

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
(15, 25, 35, 'Hibiscus Kahwa', 'hibiscus-kahwa', 'Hibiscus Kahwa short description for product listing and product detail page.', 'Contains almonds and spices.', 'With almonds & cardamom', 'This is demo data intended for frontend and API testing.', 'Hibiscus Kahwa is a richly layered demo product description designed to exercise product detail APIs, listings, and checkout flows.', 'Chamomile Flower, Green Tea, Lemongrass, Orange Peel, Peppermint', '[{\"icon\":\"leaf\",\"text\":\"Premium botanical blend\"},{\"icon\":\"cup\",\"text\":\"Balanced everyday ritual\"}]', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(16, 26, 36, 'Mint Kahwa', 'mint-kahwa', 'Mint Kahwa short description for product listing and product detail page.', 'Contains natural botanicals.', 'Herbal infusion', 'This is demo data intended for frontend and API testing.', 'Mint Kahwa is a richly layered demo product description designed to exercise product detail APIs, listings, and checkout flows.', 'Chamomile Flower, Green Tea, Lemongrass, Orange Peel, Peppermint', '[{\"icon\":\"leaf\",\"text\":\"Premium botanical blend\"},{\"icon\":\"cup\",\"text\":\"Balanced everyday ritual\"}]', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(17, 27, 37, 'Kashmiri Kahwa', 'kashmiri-kahwa', 'Kashmiri Kahwa short description for product listing and product detail page.', 'Contains almonds and spices.', 'With almonds & cardamom', 'This is demo data intended for frontend and API testing.', 'Kashmiri Kahwa is a richly layered demo product description designed to exercise product detail APIs, listings, and checkout flows.', 'Chamomile Flower, Green Tea, Lemongrass, Orange Peel, Peppermint', '[{\"icon\":\"leaf\",\"text\":\"Premium botanical blend\"},{\"icon\":\"cup\",\"text\":\"Balanced everyday ritual\"}]', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(18, 28, 38, 'Oolong Kahwa', 'oolong-kahwa', 'Oolong Kahwa short description for product listing and product detail page.', 'Contains natural botanicals.', 'Herbal infusion', 'This is demo data intended for frontend and API testing.', 'Oolong Kahwa is a richly layered demo product description designed to exercise product detail APIs, listings, and checkout flows.', 'Chamomile Flower, Green Tea, Lemongrass, Orange Peel, Peppermint', '[{\"icon\":\"leaf\",\"text\":\"Premium botanical blend\"},{\"icon\":\"cup\",\"text\":\"Balanced everyday ritual\"}]', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(19, 29, 39, 'Chamomile Tea', 'chamomile-tea', 'Chamomile Tea short description for product listing and product detail page.', 'Contains almonds and spices.', 'With almonds & cardamom', 'This is demo data intended for frontend and API testing.', 'Chamomile Tea is a richly layered demo product description designed to exercise product detail APIs, listings, and checkout flows.', 'Chamomile Flower, Green Tea, Lemongrass, Orange Peel, Peppermint', '[{\"icon\":\"leaf\",\"text\":\"Premium botanical blend\"},{\"icon\":\"cup\",\"text\":\"Balanced everyday ritual\"}]', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(20, 30, 40, 'Detox Green Tea', 'detox-green-tea', 'Detox Green Tea short description for product listing and product detail page.', 'Contains natural botanicals.', 'Herbal infusion', 'This is demo data intended for frontend and API testing.', 'Detox Green Tea is a richly layered demo product description designed to exercise product detail APIs, listings, and checkout flows.', 'Chamomile Flower, Green Tea, Lemongrass, Orange Peel, Peppermint', '[{\"icon\":\"leaf\",\"text\":\"Premium botanical blend\"},{\"icon\":\"cup\",\"text\":\"Balanced everyday ritual\"}]', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(21, 31, 41, 'Immunity Blend', 'immunity-blend', 'Immunity Blend short description for product listing and product detail page.', 'Contains almonds and spices.', 'With almonds & cardamom', 'This is demo data intended for frontend and API testing.', 'Immunity Blend is a richly layered demo product description designed to exercise product detail APIs, listings, and checkout flows.', 'Chamomile Flower, Green Tea, Lemongrass, Orange Peel, Peppermint', '[{\"icon\":\"leaf\",\"text\":\"Premium botanical blend\"},{\"icon\":\"cup\",\"text\":\"Balanced everyday ritual\"}]', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(22, 32, 42, 'Saffron Elixir', 'saffron-elixir', 'Saffron Elixir short description for product listing and product detail page.', 'Contains natural botanicals.', 'Herbal infusion', 'This is demo data intended for frontend and API testing.', 'Saffron Elixir is a richly layered demo product description designed to exercise product detail APIs, listings, and checkout flows.', 'Chamomile Flower, Green Tea, Lemongrass, Orange Peel, Peppermint', '[{\"icon\":\"leaf\",\"text\":\"Premium botanical blend\"},{\"icon\":\"cup\",\"text\":\"Balanced everyday ritual\"}]', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(23, 33, 43, 'Rose Herbal Infusion', 'rose-herbal-infusion', 'Rose Herbal Infusion short description for product listing and product detail page.', 'Contains almonds and spices.', 'With almonds & cardamom', 'This is demo data intended for frontend and API testing.', 'Rose Herbal Infusion is a richly layered demo product description designed to exercise product detail APIs, listings, and checkout flows.', 'Chamomile Flower, Green Tea, Lemongrass, Orange Peel, Peppermint', '[{\"icon\":\"leaf\",\"text\":\"Premium botanical blend\"},{\"icon\":\"cup\",\"text\":\"Balanced everyday ritual\"}]', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(24, 34, 44, 'Lemongrass Refresh', 'lemongrass-refresh', 'Lemongrass Refresh short description for product listing and product detail page.', 'Contains natural botanicals.', 'Herbal infusion', 'This is demo data intended for frontend and API testing.', 'Lemongrass Refresh is a richly layered demo product description designed to exercise product detail APIs, listings, and checkout flows.', 'Chamomile Flower, Green Tea, Lemongrass, Orange Peel, Peppermint', '[{\"icon\":\"leaf\",\"text\":\"Premium botanical blend\"},{\"icon\":\"cup\",\"text\":\"Balanced everyday ritual\"}]', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21');

-- --------------------------------------------------------

--
-- Table structure for table `product_ingredients`
--

CREATE TABLE `product_ingredients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_ingredients`
--

INSERT INTO `product_ingredients` (`id`, `product_id`, `name`, `value`, `image_path`, `sort_order`, `created_at`, `updated_at`) VALUES
(41, 15, 'Chamomile Flower', 'Chamomile Flower', 'https://picsum.photos/seed/ingredient-0-0/600/600', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(42, 15, 'Green Tea', 'Green Tea', 'https://picsum.photos/seed/ingredient-0-1/600/600', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(43, 15, 'Lemongrass', 'Lemongrass', 'https://picsum.photos/seed/ingredient-0-2/600/600', 2, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(44, 15, 'Orange Peel', 'Orange Peel', 'https://picsum.photos/seed/ingredient-0-3/600/600', 3, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(45, 16, 'Chamomile Flower', 'Chamomile Flower', 'https://picsum.photos/seed/ingredient-1-0/600/600', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(46, 16, 'Green Tea', 'Green Tea', 'https://picsum.photos/seed/ingredient-1-1/600/600', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(47, 16, 'Lemongrass', 'Lemongrass', 'https://picsum.photos/seed/ingredient-1-2/600/600', 2, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(48, 16, 'Orange Peel', 'Orange Peel', 'https://picsum.photos/seed/ingredient-1-3/600/600', 3, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(49, 17, 'Chamomile Flower', 'Chamomile Flower', 'https://picsum.photos/seed/ingredient-2-0/600/600', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(50, 17, 'Green Tea', 'Green Tea', 'https://picsum.photos/seed/ingredient-2-1/600/600', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(51, 17, 'Lemongrass', 'Lemongrass', 'https://picsum.photos/seed/ingredient-2-2/600/600', 2, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(52, 17, 'Orange Peel', 'Orange Peel', 'https://picsum.photos/seed/ingredient-2-3/600/600', 3, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(53, 18, 'Chamomile Flower', 'Chamomile Flower', 'https://picsum.photos/seed/ingredient-3-0/600/600', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(54, 18, 'Green Tea', 'Green Tea', 'https://picsum.photos/seed/ingredient-3-1/600/600', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(55, 18, 'Lemongrass', 'Lemongrass', 'https://picsum.photos/seed/ingredient-3-2/600/600', 2, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(56, 18, 'Orange Peel', 'Orange Peel', 'https://picsum.photos/seed/ingredient-3-3/600/600', 3, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(57, 19, 'Chamomile Flower', 'Chamomile Flower', 'https://picsum.photos/seed/ingredient-4-0/600/600', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(58, 19, 'Green Tea', 'Green Tea', 'https://picsum.photos/seed/ingredient-4-1/600/600', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(59, 19, 'Lemongrass', 'Lemongrass', 'https://picsum.photos/seed/ingredient-4-2/600/600', 2, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(60, 19, 'Orange Peel', 'Orange Peel', 'https://picsum.photos/seed/ingredient-4-3/600/600', 3, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(61, 20, 'Chamomile Flower', 'Chamomile Flower', 'https://picsum.photos/seed/ingredient-5-0/600/600', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(62, 20, 'Green Tea', 'Green Tea', 'https://picsum.photos/seed/ingredient-5-1/600/600', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(63, 20, 'Lemongrass', 'Lemongrass', 'https://picsum.photos/seed/ingredient-5-2/600/600', 2, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(64, 20, 'Orange Peel', 'Orange Peel', 'https://picsum.photos/seed/ingredient-5-3/600/600', 3, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(65, 21, 'Chamomile Flower', 'Chamomile Flower', 'https://picsum.photos/seed/ingredient-6-0/600/600', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(66, 21, 'Green Tea', 'Green Tea', 'https://picsum.photos/seed/ingredient-6-1/600/600', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(67, 21, 'Lemongrass', 'Lemongrass', 'https://picsum.photos/seed/ingredient-6-2/600/600', 2, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(68, 21, 'Orange Peel', 'Orange Peel', 'https://picsum.photos/seed/ingredient-6-3/600/600', 3, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(69, 22, 'Chamomile Flower', 'Chamomile Flower', 'https://picsum.photos/seed/ingredient-7-0/600/600', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(70, 22, 'Green Tea', 'Green Tea', 'https://picsum.photos/seed/ingredient-7-1/600/600', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(71, 22, 'Lemongrass', 'Lemongrass', 'https://picsum.photos/seed/ingredient-7-2/600/600', 2, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(72, 22, 'Orange Peel', 'Orange Peel', 'https://picsum.photos/seed/ingredient-7-3/600/600', 3, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(73, 23, 'Chamomile Flower', 'Chamomile Flower', 'https://picsum.photos/seed/ingredient-8-0/600/600', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(74, 23, 'Green Tea', 'Green Tea', 'https://picsum.photos/seed/ingredient-8-1/600/600', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(75, 23, 'Lemongrass', 'Lemongrass', 'https://picsum.photos/seed/ingredient-8-2/600/600', 2, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(76, 23, 'Orange Peel', 'Orange Peel', 'https://picsum.photos/seed/ingredient-8-3/600/600', 3, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(77, 24, 'Chamomile Flower', 'Chamomile Flower', 'https://picsum.photos/seed/ingredient-9-0/600/600', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(78, 24, 'Green Tea', 'Green Tea', 'https://picsum.photos/seed/ingredient-9-1/600/600', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(79, 24, 'Lemongrass', 'Lemongrass', 'https://picsum.photos/seed/ingredient-9-2/600/600', 2, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(80, 24, 'Orange Peel', 'Orange Peel', 'https://picsum.photos/seed/ingredient-9-3/600/600', 3, '2026-04-08 13:47:21', '2026-04-08 13:47:21');

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

--
-- Dumping data for table `product_nutritions`
--

INSERT INTO `product_nutritions` (`id`, `product_id`, `nutrient`, `value`, `unit`, `created_at`, `updated_at`) VALUES
(41, 15, 'Energy', '8', 'kcal', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(42, 15, 'Carbohydrate', '2', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(43, 15, 'Sugar', '1', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(44, 15, 'Protein', '1', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(45, 16, 'Energy', '9', 'kcal', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(46, 16, 'Carbohydrate', '3', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(47, 16, 'Sugar', '1', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(48, 16, 'Protein', '1', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(49, 17, 'Energy', '10', 'kcal', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(50, 17, 'Carbohydrate', '4', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(51, 17, 'Sugar', '1', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(52, 17, 'Protein', '1', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(53, 18, 'Energy', '11', 'kcal', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(54, 18, 'Carbohydrate', '5', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(55, 18, 'Sugar', '2', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(56, 18, 'Protein', '2', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(57, 19, 'Energy', '12', 'kcal', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(58, 19, 'Carbohydrate', '6', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(59, 19, 'Sugar', '3', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(60, 19, 'Protein', '2', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(61, 20, 'Energy', '13', 'kcal', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(62, 20, 'Carbohydrate', '7', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(63, 20, 'Sugar', '4', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(64, 20, 'Protein', '3', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(65, 21, 'Energy', '14', 'kcal', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(66, 21, 'Carbohydrate', '8', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(67, 21, 'Sugar', '5', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(68, 21, 'Protein', '3', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(69, 22, 'Energy', '15', 'kcal', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(70, 22, 'Carbohydrate', '9', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(71, 22, 'Sugar', '6', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(72, 22, 'Protein', '4', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(73, 23, 'Energy', '16', 'kcal', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(74, 23, 'Carbohydrate', '10', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(75, 23, 'Sugar', '7', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(76, 23, 'Protein', '4', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(77, 24, 'Energy', '17', 'kcal', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(78, 24, 'Carbohydrate', '11', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(79, 24, 'Sugar', '8', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(80, 24, 'Protein', '5', 'g', '2026-04-08 13:47:21', '2026-04-08 13:47:21');

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
  `compare_price` decimal(10,2) DEFAULT NULL,
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

INSERT INTO `product_variants` (`id`, `product_id`, `variant_name`, `size`, `color`, `sku`, `price`, `compare_price`, `stock`, `weight`, `dimensions`, `net_weight`, `tags`, `brewing_rituals`, `is_default`, `status`, `created_at`, `updated_at`) VALUES
(25, 15, '100g', '100g', NULL, 'TKC-01-1', 409.00, 509.00, 23, 100.00, '10x10x18 cm', '100g', '[\"50 cups\",\"best seller\"]', '[{\"group\":\"Hot Brew\",\"title\":\"Tea\",\"icon\":\"leaf\",\"text\":\"1 tsp \\/ 2 g\",\"value\":\"1 tsp \\/ 2 g\"},{\"group\":\"Hot Brew\",\"title\":\"Water\",\"icon\":\"cup\",\"text\":\"200ml\",\"value\":\"200ml\"},{\"group\":\"Hot Brew\",\"title\":\"Steep\",\"icon\":\"timer\",\"text\":\"3 - 5 mins\",\"value\":\"3 - 5 mins\"},{\"group\":\"Iced Brew\",\"title\":\"Serve\",\"icon\":\"glass\",\"text\":\"Refrigerate and add ice\",\"value\":\"Serve chilled\"}]', 1, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(26, 15, '200g', '200g', NULL, 'TKC-01-2', 759.00, 859.00, 28, 200.00, '10x10x18 cm', '200g', '[\"100 cups\",\"best seller\"]', '[{\"group\":\"Hot Brew\",\"title\":\"Tea\",\"icon\":\"leaf\",\"text\":\"1 tsp \\/ 2 g\",\"value\":\"1 tsp \\/ 2 g\"},{\"group\":\"Hot Brew\",\"title\":\"Water\",\"icon\":\"cup\",\"text\":\"200ml\",\"value\":\"200ml\"},{\"group\":\"Hot Brew\",\"title\":\"Steep\",\"icon\":\"timer\",\"text\":\"3 - 5 mins\",\"value\":\"3 - 5 mins\"},{\"group\":\"Iced Brew\",\"title\":\"Serve\",\"icon\":\"glass\",\"text\":\"Refrigerate and add ice\",\"value\":\"Serve chilled\"}]', 0, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(27, 16, '100g', '100g', NULL, 'TKC-02-1', 419.00, 519.00, 26, 100.00, '10x10x18 cm', '100g', '[\"50 cups\",\"best seller\"]', '[{\"group\":\"Hot Brew\",\"title\":\"Tea\",\"icon\":\"leaf\",\"text\":\"1 tsp \\/ 2 g\",\"value\":\"1 tsp \\/ 2 g\"},{\"group\":\"Hot Brew\",\"title\":\"Water\",\"icon\":\"cup\",\"text\":\"200ml\",\"value\":\"200ml\"},{\"group\":\"Hot Brew\",\"title\":\"Steep\",\"icon\":\"timer\",\"text\":\"3 - 5 mins\",\"value\":\"3 - 5 mins\"},{\"group\":\"Iced Brew\",\"title\":\"Serve\",\"icon\":\"glass\",\"text\":\"Refrigerate and add ice\",\"value\":\"Serve chilled\"}]', 1, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(28, 16, '200g', '200g', NULL, 'TKC-02-2', 769.00, 869.00, 31, 200.00, '10x10x18 cm', '200g', '[\"100 cups\",\"best seller\"]', '[{\"group\":\"Hot Brew\",\"title\":\"Tea\",\"icon\":\"leaf\",\"text\":\"1 tsp \\/ 2 g\",\"value\":\"1 tsp \\/ 2 g\"},{\"group\":\"Hot Brew\",\"title\":\"Water\",\"icon\":\"cup\",\"text\":\"200ml\",\"value\":\"200ml\"},{\"group\":\"Hot Brew\",\"title\":\"Steep\",\"icon\":\"timer\",\"text\":\"3 - 5 mins\",\"value\":\"3 - 5 mins\"},{\"group\":\"Iced Brew\",\"title\":\"Serve\",\"icon\":\"glass\",\"text\":\"Refrigerate and add ice\",\"value\":\"Serve chilled\"}]', 0, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(29, 17, '100g', '100g', NULL, 'TKC-03-1', 429.00, 529.00, 29, 100.00, '10x10x18 cm', '100g', '[\"50 cups\",\"best seller\"]', '[{\"group\":\"Hot Brew\",\"title\":\"Tea\",\"icon\":\"leaf\",\"text\":\"1 tsp \\/ 2 g\",\"value\":\"1 tsp \\/ 2 g\"},{\"group\":\"Hot Brew\",\"title\":\"Water\",\"icon\":\"cup\",\"text\":\"200ml\",\"value\":\"200ml\"},{\"group\":\"Hot Brew\",\"title\":\"Steep\",\"icon\":\"timer\",\"text\":\"3 - 5 mins\",\"value\":\"3 - 5 mins\"},{\"group\":\"Iced Brew\",\"title\":\"Serve\",\"icon\":\"glass\",\"text\":\"Refrigerate and add ice\",\"value\":\"Serve chilled\"}]', 1, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(30, 17, '200g', '200g', NULL, 'TKC-03-2', 779.00, 879.00, 34, 200.00, '10x10x18 cm', '200g', '[\"100 cups\",\"best seller\"]', '[{\"group\":\"Hot Brew\",\"title\":\"Tea\",\"icon\":\"leaf\",\"text\":\"1 tsp \\/ 2 g\",\"value\":\"1 tsp \\/ 2 g\"},{\"group\":\"Hot Brew\",\"title\":\"Water\",\"icon\":\"cup\",\"text\":\"200ml\",\"value\":\"200ml\"},{\"group\":\"Hot Brew\",\"title\":\"Steep\",\"icon\":\"timer\",\"text\":\"3 - 5 mins\",\"value\":\"3 - 5 mins\"},{\"group\":\"Iced Brew\",\"title\":\"Serve\",\"icon\":\"glass\",\"text\":\"Refrigerate and add ice\",\"value\":\"Serve chilled\"}]', 0, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(31, 18, '100g', '100g', NULL, 'TKC-04-1', 439.00, 539.00, 32, 100.00, '10x10x18 cm', '100g', '[\"50 cups\",\"best seller\"]', '[{\"group\":\"Hot Brew\",\"title\":\"Tea\",\"icon\":\"leaf\",\"text\":\"1 tsp \\/ 2 g\",\"value\":\"1 tsp \\/ 2 g\"},{\"group\":\"Hot Brew\",\"title\":\"Water\",\"icon\":\"cup\",\"text\":\"200ml\",\"value\":\"200ml\"},{\"group\":\"Hot Brew\",\"title\":\"Steep\",\"icon\":\"timer\",\"text\":\"3 - 5 mins\",\"value\":\"3 - 5 mins\"},{\"group\":\"Iced Brew\",\"title\":\"Serve\",\"icon\":\"glass\",\"text\":\"Refrigerate and add ice\",\"value\":\"Serve chilled\"}]', 1, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(32, 18, '200g', '200g', NULL, 'TKC-04-2', 789.00, 889.00, 37, 200.00, '10x10x18 cm', '200g', '[\"100 cups\",\"best seller\"]', '[{\"group\":\"Hot Brew\",\"title\":\"Tea\",\"icon\":\"leaf\",\"text\":\"1 tsp \\/ 2 g\",\"value\":\"1 tsp \\/ 2 g\"},{\"group\":\"Hot Brew\",\"title\":\"Water\",\"icon\":\"cup\",\"text\":\"200ml\",\"value\":\"200ml\"},{\"group\":\"Hot Brew\",\"title\":\"Steep\",\"icon\":\"timer\",\"text\":\"3 - 5 mins\",\"value\":\"3 - 5 mins\"},{\"group\":\"Iced Brew\",\"title\":\"Serve\",\"icon\":\"glass\",\"text\":\"Refrigerate and add ice\",\"value\":\"Serve chilled\"}]', 0, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(33, 19, '100g', '100g', NULL, 'TKC-05-1', 449.00, 549.00, 35, 100.00, '10x10x18 cm', '100g', '[\"50 cups\",\"best seller\"]', '[{\"group\":\"Hot Brew\",\"title\":\"Tea\",\"icon\":\"leaf\",\"text\":\"1 tsp \\/ 2 g\",\"value\":\"1 tsp \\/ 2 g\"},{\"group\":\"Hot Brew\",\"title\":\"Water\",\"icon\":\"cup\",\"text\":\"200ml\",\"value\":\"200ml\"},{\"group\":\"Hot Brew\",\"title\":\"Steep\",\"icon\":\"timer\",\"text\":\"3 - 5 mins\",\"value\":\"3 - 5 mins\"},{\"group\":\"Iced Brew\",\"title\":\"Serve\",\"icon\":\"glass\",\"text\":\"Refrigerate and add ice\",\"value\":\"Serve chilled\"}]', 1, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(34, 19, '200g', '200g', NULL, 'TKC-05-2', 799.00, 899.00, 40, 200.00, '10x10x18 cm', '200g', '[\"100 cups\",\"best seller\"]', '[{\"group\":\"Hot Brew\",\"title\":\"Tea\",\"icon\":\"leaf\",\"text\":\"1 tsp \\/ 2 g\",\"value\":\"1 tsp \\/ 2 g\"},{\"group\":\"Hot Brew\",\"title\":\"Water\",\"icon\":\"cup\",\"text\":\"200ml\",\"value\":\"200ml\"},{\"group\":\"Hot Brew\",\"title\":\"Steep\",\"icon\":\"timer\",\"text\":\"3 - 5 mins\",\"value\":\"3 - 5 mins\"},{\"group\":\"Iced Brew\",\"title\":\"Serve\",\"icon\":\"glass\",\"text\":\"Refrigerate and add ice\",\"value\":\"Serve chilled\"}]', 0, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(35, 20, '100g', '100g', NULL, 'TKC-06-1', 459.00, 559.00, 38, 100.00, '10x10x18 cm', '100g', '[\"50 cups\",\"best seller\"]', '[{\"group\":\"Hot Brew\",\"title\":\"Tea\",\"icon\":\"leaf\",\"text\":\"1 tsp \\/ 2 g\",\"value\":\"1 tsp \\/ 2 g\"},{\"group\":\"Hot Brew\",\"title\":\"Water\",\"icon\":\"cup\",\"text\":\"200ml\",\"value\":\"200ml\"},{\"group\":\"Hot Brew\",\"title\":\"Steep\",\"icon\":\"timer\",\"text\":\"3 - 5 mins\",\"value\":\"3 - 5 mins\"},{\"group\":\"Iced Brew\",\"title\":\"Serve\",\"icon\":\"glass\",\"text\":\"Refrigerate and add ice\",\"value\":\"Serve chilled\"}]', 1, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(36, 20, '200g', '200g', NULL, 'TKC-06-2', 809.00, 909.00, 43, 200.00, '10x10x18 cm', '200g', '[\"100 cups\",\"best seller\"]', '[{\"group\":\"Hot Brew\",\"title\":\"Tea\",\"icon\":\"leaf\",\"text\":\"1 tsp \\/ 2 g\",\"value\":\"1 tsp \\/ 2 g\"},{\"group\":\"Hot Brew\",\"title\":\"Water\",\"icon\":\"cup\",\"text\":\"200ml\",\"value\":\"200ml\"},{\"group\":\"Hot Brew\",\"title\":\"Steep\",\"icon\":\"timer\",\"text\":\"3 - 5 mins\",\"value\":\"3 - 5 mins\"},{\"group\":\"Iced Brew\",\"title\":\"Serve\",\"icon\":\"glass\",\"text\":\"Refrigerate and add ice\",\"value\":\"Serve chilled\"}]', 0, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(37, 21, '100g', '100g', NULL, 'TKC-07-1', 469.00, 569.00, 41, 100.00, '10x10x18 cm', '100g', '[\"50 cups\",\"best seller\"]', '[{\"group\":\"Hot Brew\",\"title\":\"Tea\",\"icon\":\"leaf\",\"text\":\"1 tsp \\/ 2 g\",\"value\":\"1 tsp \\/ 2 g\"},{\"group\":\"Hot Brew\",\"title\":\"Water\",\"icon\":\"cup\",\"text\":\"200ml\",\"value\":\"200ml\"},{\"group\":\"Hot Brew\",\"title\":\"Steep\",\"icon\":\"timer\",\"text\":\"3 - 5 mins\",\"value\":\"3 - 5 mins\"},{\"group\":\"Iced Brew\",\"title\":\"Serve\",\"icon\":\"glass\",\"text\":\"Refrigerate and add ice\",\"value\":\"Serve chilled\"}]', 1, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(38, 21, '200g', '200g', NULL, 'TKC-07-2', 819.00, 919.00, 46, 200.00, '10x10x18 cm', '200g', '[\"100 cups\",\"best seller\"]', '[{\"group\":\"Hot Brew\",\"title\":\"Tea\",\"icon\":\"leaf\",\"text\":\"1 tsp \\/ 2 g\",\"value\":\"1 tsp \\/ 2 g\"},{\"group\":\"Hot Brew\",\"title\":\"Water\",\"icon\":\"cup\",\"text\":\"200ml\",\"value\":\"200ml\"},{\"group\":\"Hot Brew\",\"title\":\"Steep\",\"icon\":\"timer\",\"text\":\"3 - 5 mins\",\"value\":\"3 - 5 mins\"},{\"group\":\"Iced Brew\",\"title\":\"Serve\",\"icon\":\"glass\",\"text\":\"Refrigerate and add ice\",\"value\":\"Serve chilled\"}]', 0, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(39, 22, '100g', '100g', NULL, 'TKC-08-1', 479.00, 579.00, 44, 100.00, '10x10x18 cm', '100g', '[\"50 cups\",\"best seller\"]', '[{\"group\":\"Hot Brew\",\"title\":\"Tea\",\"icon\":\"leaf\",\"text\":\"1 tsp \\/ 2 g\",\"value\":\"1 tsp \\/ 2 g\"},{\"group\":\"Hot Brew\",\"title\":\"Water\",\"icon\":\"cup\",\"text\":\"200ml\",\"value\":\"200ml\"},{\"group\":\"Hot Brew\",\"title\":\"Steep\",\"icon\":\"timer\",\"text\":\"3 - 5 mins\",\"value\":\"3 - 5 mins\"},{\"group\":\"Iced Brew\",\"title\":\"Serve\",\"icon\":\"glass\",\"text\":\"Refrigerate and add ice\",\"value\":\"Serve chilled\"}]', 1, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(40, 22, '200g', '200g', NULL, 'TKC-08-2', 829.00, 929.00, 49, 200.00, '10x10x18 cm', '200g', '[\"100 cups\",\"best seller\"]', '[{\"group\":\"Hot Brew\",\"title\":\"Tea\",\"icon\":\"leaf\",\"text\":\"1 tsp \\/ 2 g\",\"value\":\"1 tsp \\/ 2 g\"},{\"group\":\"Hot Brew\",\"title\":\"Water\",\"icon\":\"cup\",\"text\":\"200ml\",\"value\":\"200ml\"},{\"group\":\"Hot Brew\",\"title\":\"Steep\",\"icon\":\"timer\",\"text\":\"3 - 5 mins\",\"value\":\"3 - 5 mins\"},{\"group\":\"Iced Brew\",\"title\":\"Serve\",\"icon\":\"glass\",\"text\":\"Refrigerate and add ice\",\"value\":\"Serve chilled\"}]', 0, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(41, 23, '100g', '100g', NULL, 'TKC-09-1', 489.00, 589.00, 47, 100.00, '10x10x18 cm', '100g', '[\"50 cups\",\"best seller\"]', '[{\"group\":\"Hot Brew\",\"title\":\"Tea\",\"icon\":\"leaf\",\"text\":\"1 tsp \\/ 2 g\",\"value\":\"1 tsp \\/ 2 g\"},{\"group\":\"Hot Brew\",\"title\":\"Water\",\"icon\":\"cup\",\"text\":\"200ml\",\"value\":\"200ml\"},{\"group\":\"Hot Brew\",\"title\":\"Steep\",\"icon\":\"timer\",\"text\":\"3 - 5 mins\",\"value\":\"3 - 5 mins\"},{\"group\":\"Iced Brew\",\"title\":\"Serve\",\"icon\":\"glass\",\"text\":\"Refrigerate and add ice\",\"value\":\"Serve chilled\"}]', 1, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(42, 23, '200g', '200g', NULL, 'TKC-09-2', 839.00, 939.00, 52, 200.00, '10x10x18 cm', '200g', '[\"100 cups\",\"best seller\"]', '[{\"group\":\"Hot Brew\",\"title\":\"Tea\",\"icon\":\"leaf\",\"text\":\"1 tsp \\/ 2 g\",\"value\":\"1 tsp \\/ 2 g\"},{\"group\":\"Hot Brew\",\"title\":\"Water\",\"icon\":\"cup\",\"text\":\"200ml\",\"value\":\"200ml\"},{\"group\":\"Hot Brew\",\"title\":\"Steep\",\"icon\":\"timer\",\"text\":\"3 - 5 mins\",\"value\":\"3 - 5 mins\"},{\"group\":\"Iced Brew\",\"title\":\"Serve\",\"icon\":\"glass\",\"text\":\"Refrigerate and add ice\",\"value\":\"Serve chilled\"}]', 0, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(43, 24, '100g', '100g', NULL, 'TKC-10-1', 499.00, 599.00, 50, 100.00, '10x10x18 cm', '100g', '[\"50 cups\",\"best seller\"]', '[{\"group\":\"Hot Brew\",\"title\":\"Tea\",\"icon\":\"leaf\",\"text\":\"1 tsp \\/ 2 g\",\"value\":\"1 tsp \\/ 2 g\"},{\"group\":\"Hot Brew\",\"title\":\"Water\",\"icon\":\"cup\",\"text\":\"200ml\",\"value\":\"200ml\"},{\"group\":\"Hot Brew\",\"title\":\"Steep\",\"icon\":\"timer\",\"text\":\"3 - 5 mins\",\"value\":\"3 - 5 mins\"},{\"group\":\"Iced Brew\",\"title\":\"Serve\",\"icon\":\"glass\",\"text\":\"Refrigerate and add ice\",\"value\":\"Serve chilled\"}]', 1, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(44, 24, '200g', '200g', NULL, 'TKC-10-2', 849.00, 949.00, 55, 200.00, '10x10x18 cm', '200g', '[\"100 cups\",\"best seller\"]', '[{\"group\":\"Hot Brew\",\"title\":\"Tea\",\"icon\":\"leaf\",\"text\":\"1 tsp \\/ 2 g\",\"value\":\"1 tsp \\/ 2 g\"},{\"group\":\"Hot Brew\",\"title\":\"Water\",\"icon\":\"cup\",\"text\":\"200ml\",\"value\":\"200ml\"},{\"group\":\"Hot Brew\",\"title\":\"Steep\",\"icon\":\"timer\",\"text\":\"3 - 5 mins\",\"value\":\"3 - 5 mins\"},{\"group\":\"Iced Brew\",\"title\":\"Serve\",\"icon\":\"glass\",\"text\":\"Refrigerate and add ice\",\"value\":\"Serve chilled\"}]', 0, 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21');

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

--
-- Dumping data for table `product_variant_images`
--

INSERT INTO `product_variant_images` (`id`, `variant_id`, `image_path`, `is_primary`, `image_url`, `sort_order`, `created_at`, `updated_at`) VALUES
(43, 25, 'https://picsum.photos/seed/variant-0-0-1/1000/1000', 1, 'https://picsum.photos/seed/variant-0-0-1/1000/1000', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(44, 25, 'https://picsum.photos/seed/variant-0-0-2/1000/1000', 0, 'https://picsum.photos/seed/variant-0-0-2/1000/1000', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(45, 26, 'https://picsum.photos/seed/variant-0-1-1/1000/1000', 1, 'https://picsum.photos/seed/variant-0-1-1/1000/1000', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(46, 26, 'https://picsum.photos/seed/variant-0-1-2/1000/1000', 0, 'https://picsum.photos/seed/variant-0-1-2/1000/1000', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(47, 27, 'https://picsum.photos/seed/variant-1-0-1/1000/1000', 1, 'https://picsum.photos/seed/variant-1-0-1/1000/1000', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(48, 27, 'https://picsum.photos/seed/variant-1-0-2/1000/1000', 0, 'https://picsum.photos/seed/variant-1-0-2/1000/1000', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(49, 28, 'https://picsum.photos/seed/variant-1-1-1/1000/1000', 1, 'https://picsum.photos/seed/variant-1-1-1/1000/1000', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(50, 28, 'https://picsum.photos/seed/variant-1-1-2/1000/1000', 0, 'https://picsum.photos/seed/variant-1-1-2/1000/1000', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(51, 29, 'https://picsum.photos/seed/variant-2-0-1/1000/1000', 1, 'https://picsum.photos/seed/variant-2-0-1/1000/1000', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(52, 29, 'https://picsum.photos/seed/variant-2-0-2/1000/1000', 0, 'https://picsum.photos/seed/variant-2-0-2/1000/1000', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(53, 30, 'https://picsum.photos/seed/variant-2-1-1/1000/1000', 1, 'https://picsum.photos/seed/variant-2-1-1/1000/1000', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(54, 30, 'https://picsum.photos/seed/variant-2-1-2/1000/1000', 0, 'https://picsum.photos/seed/variant-2-1-2/1000/1000', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(55, 31, 'https://picsum.photos/seed/variant-3-0-1/1000/1000', 1, 'https://picsum.photos/seed/variant-3-0-1/1000/1000', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(56, 31, 'https://picsum.photos/seed/variant-3-0-2/1000/1000', 0, 'https://picsum.photos/seed/variant-3-0-2/1000/1000', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(57, 32, 'https://picsum.photos/seed/variant-3-1-1/1000/1000', 1, 'https://picsum.photos/seed/variant-3-1-1/1000/1000', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(58, 32, 'https://picsum.photos/seed/variant-3-1-2/1000/1000', 0, 'https://picsum.photos/seed/variant-3-1-2/1000/1000', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(59, 33, 'https://picsum.photos/seed/variant-4-0-1/1000/1000', 1, 'https://picsum.photos/seed/variant-4-0-1/1000/1000', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(60, 33, 'https://picsum.photos/seed/variant-4-0-2/1000/1000', 0, 'https://picsum.photos/seed/variant-4-0-2/1000/1000', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(61, 34, 'https://picsum.photos/seed/variant-4-1-1/1000/1000', 1, 'https://picsum.photos/seed/variant-4-1-1/1000/1000', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(62, 34, 'https://picsum.photos/seed/variant-4-1-2/1000/1000', 0, 'https://picsum.photos/seed/variant-4-1-2/1000/1000', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(63, 35, 'https://picsum.photos/seed/variant-5-0-1/1000/1000', 1, 'https://picsum.photos/seed/variant-5-0-1/1000/1000', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(64, 35, 'https://picsum.photos/seed/variant-5-0-2/1000/1000', 0, 'https://picsum.photos/seed/variant-5-0-2/1000/1000', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(65, 36, 'https://picsum.photos/seed/variant-5-1-1/1000/1000', 1, 'https://picsum.photos/seed/variant-5-1-1/1000/1000', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(66, 36, 'https://picsum.photos/seed/variant-5-1-2/1000/1000', 0, 'https://picsum.photos/seed/variant-5-1-2/1000/1000', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(67, 37, 'https://picsum.photos/seed/variant-6-0-1/1000/1000', 1, 'https://picsum.photos/seed/variant-6-0-1/1000/1000', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(68, 37, 'https://picsum.photos/seed/variant-6-0-2/1000/1000', 0, 'https://picsum.photos/seed/variant-6-0-2/1000/1000', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(69, 38, 'https://picsum.photos/seed/variant-6-1-1/1000/1000', 1, 'https://picsum.photos/seed/variant-6-1-1/1000/1000', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(70, 38, 'https://picsum.photos/seed/variant-6-1-2/1000/1000', 0, 'https://picsum.photos/seed/variant-6-1-2/1000/1000', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(71, 39, 'https://picsum.photos/seed/variant-7-0-1/1000/1000', 1, 'https://picsum.photos/seed/variant-7-0-1/1000/1000', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(72, 39, 'https://picsum.photos/seed/variant-7-0-2/1000/1000', 0, 'https://picsum.photos/seed/variant-7-0-2/1000/1000', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(73, 40, 'https://picsum.photos/seed/variant-7-1-1/1000/1000', 1, 'https://picsum.photos/seed/variant-7-1-1/1000/1000', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(74, 40, 'https://picsum.photos/seed/variant-7-1-2/1000/1000', 0, 'https://picsum.photos/seed/variant-7-1-2/1000/1000', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(75, 41, 'https://picsum.photos/seed/variant-8-0-1/1000/1000', 1, 'https://picsum.photos/seed/variant-8-0-1/1000/1000', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(76, 41, 'https://picsum.photos/seed/variant-8-0-2/1000/1000', 0, 'https://picsum.photos/seed/variant-8-0-2/1000/1000', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(77, 42, 'https://picsum.photos/seed/variant-8-1-1/1000/1000', 1, 'https://picsum.photos/seed/variant-8-1-1/1000/1000', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(78, 42, 'https://picsum.photos/seed/variant-8-1-2/1000/1000', 0, 'https://picsum.photos/seed/variant-8-1-2/1000/1000', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(79, 43, 'https://picsum.photos/seed/variant-9-0-1/1000/1000', 1, 'https://picsum.photos/seed/variant-9-0-1/1000/1000', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(80, 43, 'https://picsum.photos/seed/variant-9-0-2/1000/1000', 0, 'https://picsum.photos/seed/variant-9-0-2/1000/1000', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(81, 44, 'https://picsum.photos/seed/variant-9-1-1/1000/1000', 1, 'https://picsum.photos/seed/variant-9-1-1/1000/1000', 0, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(82, 44, 'https://picsum.photos/seed/variant-9-1-2/1000/1000', 0, 'https://picsum.photos/seed/variant-9-1-2/1000/1000', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21');

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

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `rating`, `review`, `created_at`, `updated_at`) VALUES
(4, 15, 3, 2, 'Demo review 1 for product API, reviews list, and product detail page testing.', '2026-03-30 13:47:22', '2026-03-30 13:47:22'),
(5, 16, 16, 3, 'Demo review 2 for product API, reviews list, and product detail page testing.', '2026-03-31 13:47:22', '2026-03-31 13:47:22'),
(6, 17, 17, 4, 'Demo review 3 for product API, reviews list, and product detail page testing.', '2026-04-01 13:47:22', '2026-04-01 13:47:22'),
(7, 18, 18, 5, 'Demo review 4 for product API, reviews list, and product detail page testing.', '2026-04-02 13:47:22', '2026-04-02 13:47:22'),
(8, 19, 19, 1, 'Demo review 5 for product API, reviews list, and product detail page testing.', '2026-04-03 13:47:22', '2026-04-03 13:47:22'),
(9, 20, 20, 2, 'Demo review 6 for product API, reviews list, and product detail page testing.', '2026-04-04 13:47:22', '2026-04-04 13:47:22'),
(10, 21, 21, 3, 'Demo review 7 for product API, reviews list, and product detail page testing.', '2026-04-05 13:47:22', '2026-04-05 13:47:22'),
(11, 22, 22, 4, 'Demo review 8 for product API, reviews list, and product detail page testing.', '2026-04-06 13:47:22', '2026-04-06 13:47:22'),
(12, 23, 23, 5, 'Demo review 9 for product API, reviews list, and product detail page testing.', '2026-04-07 13:47:22', '2026-04-07 13:47:22'),
(13, 24, 24, 1, 'Demo review 10 for product API, reviews list, and product detail page testing.', '2026-04-08 13:47:22', '2026-04-08 13:47:22');

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
(78, 5),
(79, 1),
(79, 3),
(79, 4),
(80, 1),
(80, 3),
(81, 1),
(81, 3),
(82, 1);

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
('2PdQhea9Gla3UxeX91k8ZZ04926CZdfFVOq9zxM0', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiU1lYSUFmQmpRRTN6S1RBYVZ3UHlGUUdBbUw1WVVtTG1FRXl4bkI0RCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTQ6Imh0dHA6Ly9sb2NhbGhvc3QvdGhlS2F3YUNvbXBhbnkvcHVibGljL2FkbWluL2FuYWx5dGljcyI7czo1OiJyb3V0ZSI7czoxNToiYWRtaW4uYW5hbHl0aWNzIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxMToiYWRtaW5fdG9rZW4iO3M6NTE6IjQ4fHdYcDRzSEJvZUFGU05Kdm54ZG1yekt4SDV5VE12YVdhMDVlaUtLbVgzZWU5M2UwZiI7czoxMDoiYWRtaW5fdXNlciI7YTo3OntzOjI6ImlkIjtpOjI7czo0OiJuYW1lIjtzOjU6IkFkbWluIjtzOjU6ImVtYWlsIjtzOjE3OiJhZG1pbkBleGFtcGxlLmNvbSI7czo1OiJwaG9uZSI7czoxMDoiOTAwOTI1NTA4NSI7czoxMDoiY3JlYXRlZF9hdCI7czoyNzoiMjAyNi0wMy0xOVQxOToxMDo1OS4wMDAwMDBaIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjI3OiIyMDI2LTA0LTA2VDE3OjE4OjEwLjAwMDAwMFoiO3M6NToicm9sZXMiO2E6MTp7aTowO2E6Mjp7czoyOiJpZCI7aToxO3M6NDoibmFtZSI7czo1OiJhZG1pbiI7fX19czoyNDoiYWRtaW5fcHJvZmlsZV9jaGVja2VkX2F0IjtpOjE3NzU3MDcyMDY7fQ==', 1775707215),
('m5yjlsrty1H0MGGkYhlADstURjTXa9fCRCbuZwHV', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiSTVhNm9aOTViUkREeUNUcTZ3b1REcXdqUTJFS2RZRlYzRlZ0S0s4byI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTY6Imh0dHA6Ly9sb2NhbGhvc3QvdGhlS2F3YUNvbXBhbnkvcHVibGljL2FkbWluL3Byb2R1Y3RzLzE1IjtzOjU6InJvdXRlIjtzOjE5OiJhZG1pbi5wcm9kdWN0cy5zaG93Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxMToiYWRtaW5fdG9rZW4iO3M6NTE6IjQ3fGs1ZXdTN0lFWllIM0thOGZIT0pnOWtLMm5TemVkZ1V4UGJ6eFRDWXo3NDYyNzlmNSI7czoxMDoiYWRtaW5fdXNlciI7YTo3OntzOjI6ImlkIjtpOjI7czo0OiJuYW1lIjtzOjU6IkFkbWluIjtzOjU6ImVtYWlsIjtzOjE3OiJhZG1pbkBleGFtcGxlLmNvbSI7czo1OiJwaG9uZSI7czoxMDoiOTAwOTI1NTA4NSI7czoxMDoiY3JlYXRlZF9hdCI7czoyNzoiMjAyNi0wMy0xOVQxOToxMDo1OS4wMDAwMDBaIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjI3OiIyMDI2LTA0LTA2VDE3OjE4OjEwLjAwMDAwMFoiO3M6NToicm9sZXMiO2E6MTp7aTowO2E6Mjp7czoyOiJpZCI7aToxO3M6NDoibmFtZSI7czo1OiJhZG1pbiI7fX19czoyNDoiYWRtaW5fcHJvZmlsZV9jaGVja2VkX2F0IjtpOjE3NzU2NzU5MTc7fQ==', 1775676000),
('sacSHdtKLGD7eBXIbhzpodk1GgBf6nIEmLUb5DE4', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiNlVRMUpPZnZVcGE3bWIwUTQ4ZjA1NXhIS0pKTDMyTWREUm91UzJEYiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjU6Imh0dHA6Ly9sb2NhbGhvc3QvdGhlS2F3YUNvbXBhbnkvcHVibGljL2FkbWluL2hlcm8tc2VjdGlvbnMvMS9lZGl0IjtzOjU6InJvdXRlIjtzOjI0OiJhZG1pbi5oZXJvLXNlY3Rpb25zLmVkaXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjExOiJhZG1pbl90b2tlbiI7czo1MToiNDZ8c2dlMjJwZ0dIR0pBT3oyeUNWVlRNTk1rdlFHQ1J0YXZ2aUxxZFNMb2U4NWUzNGM0IjtzOjEwOiJhZG1pbl91c2VyIjthOjc6e3M6MjoiaWQiO2k6MjtzOjQ6Im5hbWUiO3M6NToiQWRtaW4iO3M6NToiZW1haWwiO3M6MTc6ImFkbWluQGV4YW1wbGUuY29tIjtzOjU6InBob25lIjtzOjEwOiI5MDA5MjU1MDg1IjtzOjEwOiJjcmVhdGVkX2F0IjtzOjI3OiIyMDI2LTAzLTE5VDE5OjEwOjU5LjAwMDAwMFoiO3M6MTA6InVwZGF0ZWRfYXQiO3M6Mjc6IjIwMjYtMDQtMDZUMTc6MTg6MTAuMDAwMDAwWiI7czo1OiJyb2xlcyI7YToxOntpOjA7YToyOntzOjI6ImlkIjtpOjE7czo0OiJuYW1lIjtzOjU6ImFkbWluIjt9fX1zOjI0OiJhZG1pbl9wcm9maWxlX2NoZWNrZWRfYXQiO2k6MTc3NTYxODc2MDt9', 1775618786),
('T8715hL8LZCQjVygGRG5rJP2Ay1uteOvFuFYuIyZ', NULL, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoidGpCNDZCWXlEZER1OE9RTzVjRzFrbFNGNjdwOHg5dzBRc3FWSnZQeiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTQ6Imh0dHA6Ly9sb2NhbGhvc3QvdGhlS2F3YUNvbXBhbnkvcHVibGljL2FkbWluL2ludmVudG9yeSI7czo1OiJyb3V0ZSI7czoyMToiYWRtaW4uaW52ZW50b3J5LmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxMToiYWRtaW5fdG9rZW4iO3M6NTE6IjQ5fGd1d0NuQXc1U1B0Mm1zZzJ3WDZtdnB2SExwTUNoN1pzUmJ3cWxzRDc3Mjc2NTZhZCI7czoxMDoiYWRtaW5fdXNlciI7YTo3OntzOjI6ImlkIjtpOjI7czo0OiJuYW1lIjtzOjU6IkFkbWluIjtzOjU6ImVtYWlsIjtzOjE3OiJhZG1pbkBleGFtcGxlLmNvbSI7czo1OiJwaG9uZSI7czoxMDoiOTAwOTI1NTA4NSI7czoxMDoiY3JlYXRlZF9hdCI7czoyNzoiMjAyNi0wMy0xOVQxOToxMDo1OS4wMDAwMDBaIjtzOjEwOiJ1cGRhdGVkX2F0IjtzOjI3OiIyMDI2LTA0LTA2VDE3OjE4OjEwLjAwMDAwMFoiO3M6NToicm9sZXMiO2E6MTp7aTowO2E6Mjp7czoyOiJpZCI7aToxO3M6NDoibmFtZSI7czo1OiJhZG1pbiI7fX19czoyNDoiYWRtaW5fcHJvZmlsZV9jaGVja2VkX2F0IjtpOjE3NzU3ODM5NDY7fQ==', 1775783948);

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
(2, 'Admin', 'admin@example.com', '9009255085', NULL, '$2y$12$xfj/NF41oV9Lchog/G7iXOu4Rc6FdfIk4pjnjsv81.vcpaaivhfwy', NULL, '2026-03-19 13:40:59', '2026-04-06 11:48:10'),
(3, 'Test User1', 'test@example.com', '8888888888', NULL, '$2y$12$A/ukiCbyBR4ydm1nU5F1a.Uj1ishEzzigLuIz.gi3O9Ea1eTX6lwq', NULL, '2026-03-19 13:40:59', '2026-03-21 15:59:24'),
(16, 'Customer 1', 'customer1@example.com', '9000000001', NULL, '$2y$12$gIWBzeCw6blof1otq4Vcf.2LXLL/j7yxtvPhVsjOYkCWNBGnAfZ1G', NULL, '2026-04-08 13:47:18', '2026-04-08 13:47:18'),
(17, 'Customer 2', 'customer2@example.com', '9000000002', NULL, '$2y$12$gkJ3pEXFZnk8MlNd8s1X1O9qRi7YZnwar.acmkN.VJhWnqg9kBSzy', NULL, '2026-04-08 13:47:19', '2026-04-08 13:47:19'),
(18, 'Customer 3', 'customer3@example.com', '9000000003', NULL, '$2y$12$M5YHUypnE3.iolkmuZQNzuPm.PDtoGNQj5g3ypg87osdeuLJ/aQju', NULL, '2026-04-08 13:47:19', '2026-04-08 13:47:19'),
(19, 'Customer 4', 'customer4@example.com', '9000000004', NULL, '$2y$12$dnq/ES5EoQjAXdmaNUgTnOYetV/vgiADXijLgwRPErUkp/bk/ZBrm', NULL, '2026-04-08 13:47:19', '2026-04-08 13:47:19'),
(20, 'Customer 5', 'customer5@example.com', '9000000005', NULL, '$2y$12$EjpmliiUn2yzWGPfO3DpFeva6.YxQv370O2qUfV1WdJT4IzHNuDly', NULL, '2026-04-08 13:47:20', '2026-04-08 13:47:20'),
(21, 'Customer 6', 'customer6@example.com', '9000000006', NULL, '$2y$12$qplBTn2eWhHd7oq0RupvdOQBHZt94D9DAFIxMML58yGo8v8wb1reG', NULL, '2026-04-08 13:47:20', '2026-04-08 13:47:20'),
(22, 'Customer 7', 'customer7@example.com', '9000000007', NULL, '$2y$12$uXVe3Z47NS7GNZPUZup3w.ip7oUipGk9Gui1kP75BkewtiXOnFD2i', NULL, '2026-04-08 13:47:20', '2026-04-08 13:47:20'),
(23, 'Customer 8', 'customer8@example.com', '9000000008', NULL, '$2y$12$CICT4IxTMbGph5Jq/eG8bej7d4RJtg5ErXldFeqKd5xFqrtwRoat.', NULL, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(24, 'Customer 9', 'customer9@example.com', '9000000009', NULL, '$2y$12$LA3kRGhRoJI7MV47E3RBCeWsjkuJ99b/TxV3siSczUU8Anj9xXQ7.', NULL, '2026-04-08 13:47:21', '2026-04-08 13:47:21');

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
(15, 3, '10 Demo Street', 'Near Sample Market', 'Delhi', 'Delhi', '110001', 'India', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(16, 16, '11 Demo Street', 'Near Sample Market', 'Noida', 'Uttar Pradesh', '110002', 'India', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(17, 17, '12 Demo Street', 'Near Sample Market', 'Gurugram', 'Haryana', '110003', 'India', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(18, 18, '13 Demo Street', 'Near Sample Market', 'Jaipur', 'Rajasthan', '110004', 'India', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(19, 19, '14 Demo Street', 'Near Sample Market', 'Mumbai', 'Maharashtra', '110005', 'India', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(20, 20, '15 Demo Street', 'Near Sample Market', 'Delhi', 'Delhi', '110006', 'India', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(21, 21, '16 Demo Street', 'Near Sample Market', 'Noida', 'Uttar Pradesh', '110007', 'India', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(22, 22, '17 Demo Street', 'Near Sample Market', 'Gurugram', 'Haryana', '110008', 'India', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(23, 23, '18 Demo Street', 'Near Sample Market', 'Jaipur', 'Rajasthan', '110009', 'India', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(24, 24, '19 Demo Street', 'Near Sample Market', 'Mumbai', 'Maharashtra', '110010', 'India', 1, '2026-04-08 13:47:21', '2026-04-08 13:47:21');

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
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(11, 3, 15, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(12, 16, 16, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(13, 17, 17, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(14, 18, 18, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(15, 19, 19, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(16, 20, 20, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(17, 21, 21, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(18, 22, 22, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(19, 23, 23, '2026-04-08 13:47:21', '2026-04-08 13:47:21'),
(20, 24, 24, '2026-04-08 13:47:21', '2026-04-08 13:47:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_posts_slug_unique` (`slug`),
  ADD KEY `blog_posts_published_at_index` (`published_at`);

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
-- Indexes for table `hero_sections`
--
ALTER TABLE `hero_sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hero_sections_product_slug_unique` (`product_slug`);

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
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hero_sections`
--
ALTER TABLE `hero_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `product_ingredients`
--
ALTER TABLE `product_ingredients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `product_nutritions`
--
ALTER TABLE `product_nutritions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `product_variant_images`
--
ALTER TABLE `product_variant_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
