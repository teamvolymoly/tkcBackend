-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 103.86.176.233:3306
-- Generation Time: Aug 02, 2026 at 11:32 AM
-- Server version: 11.4.12-MariaDB-ubu2404
-- PHP Version: 8.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kirayaca1_tkc`
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
(1, 'What is Kahwa? The Ancient Kashmiri Tea Loved Around the World', 'what-is-kahwa-the-ancient-kashmiri-tea-loved-around-the-world', 'Discover the story behind authentic Kashmiri Kahwa, its ingredients, health benefits, and why it has become one of the world\'s favourite wellness teas.', 'What is Kahwa?\r\n\r\nFor centuries, Kahwa has been more than just tea. Originating from the breathtaking valleys of Kashmir, this fragrant herbal infusion has been served during family gatherings, celebrations, and moments of relaxation.\r\n\r\nUnlike regular black tea, Kahwa combines green tea with premium spices and herbs that create a warm, soothing beverage.\r\n\r\nTraditional Ingredients\r\n\r\nAuthentic Kashmiri Kahwa commonly includes:\r\n\r\nGreen Tea\r\nSaffron\r\nCinnamon\r\nCardamom\r\nCloves\r\nAlmonds\r\nRose Petals (optional)\r\n\r\nEach ingredient contributes both flavour and wellness benefits.\r\n\r\nHealth Benefits\r\nRich in Antioxidants\r\n\r\nGreen tea contains powerful antioxidants that help protect your body from free radicals.\r\n\r\nSupports Digestion\r\n\r\nSpices like cardamom and cinnamon naturally support healthy digestion after meals.\r\n\r\nPromotes Relaxation\r\n\r\nThe warm aroma of saffron and spices creates a calming experience perfect for stressful days.\r\n\r\nNatural Immunity Support\r\n\r\nTraditional spices used in Kahwa have long been associated with supporting overall wellness.\r\n\r\nWhy Modern Tea Lovers Choose Kahwa\r\n\r\nPeople today are looking for healthier alternatives to sugary beverages.\r\n\r\nKahwa offers:\r\n\r\nZero artificial flavours\r\nNatural ingredients\r\nDelicate floral aroma\r\nLight caffeine\r\nWellness-focused lifestyle\r\nExperience Authentic Kahwa\r\n\r\nAt The Kahwa Co., every blend combines traditional Kashmiri heritage with premium ingredients to deliver an authentic cup every time.', 'blog/jp8FkGV9isQ7qmjahepAji3by3FVGyg7FMzgmYy7.png', 1, '2026-07-05 15:31:00', 'What is Kahwa? Benefits, Ingredients & Kashmiri Tea Guide', 'Learn everything about authentic Kashmiri Kahwa including its history, ingredients, health benefits, and why it has become a favourite wellness tea.', '2026-07-05 10:05:13', '2026-07-05 10:05:13'),
(2, '5 Incredible Health Benefits of Drinking Kahwa Every Day', '5-incredible-health-benefits-of-drinking-kahwa-every-day', 'From improving digestion to supporting immunity, discover why adding Kahwa to your daily routine can be one of the healthiest habits.', 'Why Drink Kahwa Daily?\r\n\r\nHealthy habits begin with small daily rituals.\r\n\r\nA warm cup of Kahwa is not only comforting but also packed with natural ingredients traditionally valued for wellness.\r\n\r\n1. Rich in Natural Antioxidants\r\n\r\nGreen tea helps fight oxidative stress while supporting healthy ageing.\r\n\r\n2. Aids Digestion\r\n\r\nCardamom and cinnamon have been used in traditional wellness practices to promote healthy digestion after meals.\r\n\r\n3. Supports Immunity\r\n\r\nIngredients like cloves, saffron, and cinnamon contain naturally occurring compounds associated with supporting the body\'s natural defence system.\r\n\r\n4. Helps You Relax\r\n\r\nThe comforting aroma makes Kahwa an excellent evening beverage for unwinding after a busy day.\r\n\r\n5. Healthier Than Sugary Drinks\r\n\r\nReplacing soft drinks or heavily sweetened beverages with Kahwa reduces unnecessary sugar while still providing a satisfying warm drink.\r\n\r\nBest Time to Drink Kahwa\r\nMorning\r\nAfter Lunch\r\nEvening\r\nDuring Winter\r\nAfter Heavy Meals\r\nMake Kahwa Part of Your Lifestyle\r\n\r\nWhether you\'re working from home or relaxing with family, Kahwa provides a peaceful wellness ritual inspired by centuries of Kashmiri tradition.', 'blog/dfpKsl8mguQlAMvwHc2X0SzUiwNsPjN53wPgjBNN.png', 1, '2026-07-05 16:01:00', '5 Amazing Benefits of Drinking Kahwa Every Day', 'Discover the top health benefits of drinking authentic Kashmiri Kahwa including digestion support, antioxidants, relaxation, and immunity.', '2026-07-05 10:31:37', '2026-07-05 10:31:37'),
(3, 'How to Brew the Perfect Cup of Kashmiri Kahwa at Home', 'how-to-brew-the-perfect-cup-of-kashmiri-kahwa-at-home', 'Learn the simple steps to prepare authentic Kahwa with the perfect balance of aroma, flavour, and tradition.', 'Brewing Authentic Kahwa\r\n\r\nMaking Kahwa is simple, but a few small details make all the difference.\r\n\r\nIngredients\r\n1 teaspoon Kahwa blend\r\n200 ml water\r\nHoney (optional)\r\nAlmond slices\r\nSaffron strands\r\nStep 1\r\n\r\nBring fresh water to a gentle boil.\r\n\r\nStep 2\r\n\r\nAdd one teaspoon of Kahwa blend.\r\n\r\nAllow it to simmer for 3–5 minutes.\r\n\r\nStep 3\r\n\r\nStrain the tea into your favourite cup.\r\n\r\nStep 4\r\n\r\nAdd:\r\n\r\nAlmond slices\r\nHoney (optional)\r\nA few saffron strands\r\nStep 5\r\n\r\nServe hot and enjoy slowly.\r\n\r\nBrewing Tips\r\nAvoid over-boiling.\r\nUse filtered water.\r\nNever microwave prepared Kahwa.\r\nFreshly brewed Kahwa offers the best aroma.\r\nPair It With\r\n\r\nKahwa pairs wonderfully with:\r\n\r\nDry fruits\r\nCookies\r\nBiscuits\r\nTraditional Kashmiri snacks\r\nEvening conversations\r\nA Cup Full of Tradition\r\n\r\nEvery cup of Kahwa carries generations of Kashmiri culture, bringing warmth, hospitality, and wellness together.', 'blog/l1NnWKCCeKeJ756wWYb1l3os72z9PbBr1KzFh2kD.png', 1, '2026-07-05 16:02:00', 'How to Brew Authentic Kashmiri Kahwa at Home', 'Learn how to prepare authentic Kashmiri Kahwa using simple ingredients and traditional brewing methods for the perfect cup every time.', '2026-07-05 10:32:49', '2026-07-05 10:32:49');

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
('laravel_cache_api.products.filters.v1', 'a:7:{s:10:\"categories\";a:1:{i:0;a:3:{s:2:\"id\";i:1;s:4:\"name\";s:16:\"Kahwa Loose Leaf\";s:4:\"slug\";s:16:\"kahwa-loose-leaf\";}}s:13:\"subcategories\";a:1:{i:0;a:4:{s:2:\"id\";i:2;s:4:\"name\";s:14:\"Kashmiri Kahwa\";s:4:\"slug\";s:14:\"kashmiri-kahwa\";s:11:\"category_id\";i:1;}}s:11:\"price_range\";a:2:{s:3:\"min\";d:1;s:3:\"max\";d:899;}s:14:\"rating_options\";a:3:{i:0;i:5;i:1;i:4;i:2;i:3;}s:4:\"tags\";a:2:{i:0;s:10:\"Bestseller\";i:1;s:3:\"New\";}s:8:\"caffeine\";a:2:{i:0;s:6:\"medium\";i:1;s:3:\"low\";}s:11:\"collections\";a:1:{i:0;s:6:\"Summer\";}}', 1785618068),
('laravel_cache_spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:66:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:12:\"admin.access\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:14:\"dashboard.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:11:\"orders.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:13:\"orders.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:13:\"payments.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:15:\"payments.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:13:\"products.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:15:\"products.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:15:\"products.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:15:\"products.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:15:\"categories.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:17:\"categories.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:17:\"categories.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:17:\"categories.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:14:\"inventory.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:16:\"inventory.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:12:\"coupons.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:14:\"coupons.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:14:\"coupons.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:14:\"coupons.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:10:\"users.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:12:\"users.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:12:\"users.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:12:\"users.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:12:\"reviews.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:25;a:3:{s:1:\"a\";i:26;s:1:\"b\";s:12:\"admin.access\";s:1:\"c\";s:7:\"sanctum\";}i:26;a:3:{s:1:\"a\";i:27;s:1:\"b\";s:14:\"dashboard.view\";s:1:\"c\";s:7:\"sanctum\";}i:27;a:3:{s:1:\"a\";i:28;s:1:\"b\";s:11:\"orders.view\";s:1:\"c\";s:7:\"sanctum\";}i:28;a:3:{s:1:\"a\";i:29;s:1:\"b\";s:13:\"orders.update\";s:1:\"c\";s:7:\"sanctum\";}i:29;a:3:{s:1:\"a\";i:30;s:1:\"b\";s:13:\"payments.view\";s:1:\"c\";s:7:\"sanctum\";}i:30;a:3:{s:1:\"a\";i:31;s:1:\"b\";s:15:\"payments.update\";s:1:\"c\";s:7:\"sanctum\";}i:31;a:3:{s:1:\"a\";i:32;s:1:\"b\";s:13:\"products.view\";s:1:\"c\";s:7:\"sanctum\";}i:32;a:3:{s:1:\"a\";i:33;s:1:\"b\";s:15:\"products.create\";s:1:\"c\";s:7:\"sanctum\";}i:33;a:3:{s:1:\"a\";i:34;s:1:\"b\";s:15:\"products.update\";s:1:\"c\";s:7:\"sanctum\";}i:34;a:3:{s:1:\"a\";i:35;s:1:\"b\";s:15:\"products.delete\";s:1:\"c\";s:7:\"sanctum\";}i:35;a:3:{s:1:\"a\";i:36;s:1:\"b\";s:15:\"categories.view\";s:1:\"c\";s:7:\"sanctum\";}i:36;a:3:{s:1:\"a\";i:37;s:1:\"b\";s:17:\"categories.create\";s:1:\"c\";s:7:\"sanctum\";}i:37;a:3:{s:1:\"a\";i:38;s:1:\"b\";s:17:\"categories.update\";s:1:\"c\";s:7:\"sanctum\";}i:38;a:3:{s:1:\"a\";i:39;s:1:\"b\";s:17:\"categories.delete\";s:1:\"c\";s:7:\"sanctum\";}i:39;a:3:{s:1:\"a\";i:40;s:1:\"b\";s:12:\"coupons.view\";s:1:\"c\";s:7:\"sanctum\";}i:40;a:3:{s:1:\"a\";i:41;s:1:\"b\";s:14:\"coupons.create\";s:1:\"c\";s:7:\"sanctum\";}i:41;a:3:{s:1:\"a\";i:42;s:1:\"b\";s:14:\"coupons.update\";s:1:\"c\";s:7:\"sanctum\";}i:42;a:3:{s:1:\"a\";i:43;s:1:\"b\";s:14:\"coupons.delete\";s:1:\"c\";s:7:\"sanctum\";}i:43;a:3:{s:1:\"a\";i:44;s:1:\"b\";s:10:\"users.view\";s:1:\"c\";s:7:\"sanctum\";}i:44;a:3:{s:1:\"a\";i:45;s:1:\"b\";s:12:\"users.create\";s:1:\"c\";s:7:\"sanctum\";}i:45;a:3:{s:1:\"a\";i:46;s:1:\"b\";s:12:\"users.update\";s:1:\"c\";s:7:\"sanctum\";}i:46;a:3:{s:1:\"a\";i:47;s:1:\"b\";s:12:\"users.delete\";s:1:\"c\";s:7:\"sanctum\";}i:47;a:3:{s:1:\"a\";i:48;s:1:\"b\";s:12:\"reviews.view\";s:1:\"c\";s:7:\"sanctum\";}i:48;a:3:{s:1:\"a\";i:49;s:1:\"b\";s:14:\"reviews.delete\";s:1:\"c\";s:7:\"sanctum\";}i:49;a:3:{s:1:\"a\";i:50;s:1:\"b\";s:10:\"carts.view\";s:1:\"c\";s:7:\"sanctum\";}i:50;a:3:{s:1:\"a\";i:51;s:1:\"b\";s:14:\"wishlists.view\";s:1:\"c\";s:7:\"sanctum\";}i:51;a:3:{s:1:\"a\";i:52;s:1:\"b\";s:16:\"wishlists.delete\";s:1:\"c\";s:7:\"sanctum\";}i:52;a:3:{s:1:\"a\";i:53;s:1:\"b\";s:10:\"blogs.view\";s:1:\"c\";s:7:\"sanctum\";}i:53;a:3:{s:1:\"a\";i:54;s:1:\"b\";s:12:\"blogs.create\";s:1:\"c\";s:7:\"sanctum\";}i:54;a:3:{s:1:\"a\";i:55;s:1:\"b\";s:12:\"blogs.update\";s:1:\"c\";s:7:\"sanctum\";}i:55;a:3:{s:1:\"a\";i:56;s:1:\"b\";s:12:\"blogs.delete\";s:1:\"c\";s:7:\"sanctum\";}i:56;a:3:{s:1:\"a\";i:57;s:1:\"b\";s:18:\"hero_sections.view\";s:1:\"c\";s:7:\"sanctum\";}i:57;a:3:{s:1:\"a\";i:58;s:1:\"b\";s:20:\"hero_sections.create\";s:1:\"c\";s:7:\"sanctum\";}i:58;a:3:{s:1:\"a\";i:59;s:1:\"b\";s:20:\"hero_sections.update\";s:1:\"c\";s:7:\"sanctum\";}i:59;a:3:{s:1:\"a\";i:60;s:1:\"b\";s:20:\"hero_sections.delete\";s:1:\"c\";s:7:\"sanctum\";}i:60;a:3:{s:1:\"a\";i:61;s:1:\"b\";s:10:\"roles.view\";s:1:\"c\";s:7:\"sanctum\";}i:61;a:3:{s:1:\"a\";i:62;s:1:\"b\";s:12:\"roles.create\";s:1:\"c\";s:7:\"sanctum\";}i:62;a:3:{s:1:\"a\";i:63;s:1:\"b\";s:12:\"roles.update\";s:1:\"c\";s:7:\"sanctum\";}i:63;a:3:{s:1:\"a\";i:64;s:1:\"b\";s:12:\"roles.delete\";s:1:\"c\";s:7:\"sanctum\";}i:64;a:3:{s:1:\"a\";i:65;s:1:\"b\";s:12:\"profile.view\";s:1:\"c\";s:7:\"sanctum\";}i:65;a:3:{s:1:\"a\";i:66;s:1:\"b\";s:14:\"profile.update\";s:1:\"c\";s:7:\"sanctum\";}}s:5:\"roles\";a:1:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}}}', 1785753340);

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
  `applied_coupon_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `applied_coupon_id`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, '2026-04-12 21:20:58', '2026-04-12 21:20:58'),
(2, 2, NULL, '2026-04-14 02:48:30', '2026-05-09 13:53:30'),
(3, 4, NULL, '2026-04-24 11:11:19', '2026-05-09 13:46:27'),
(4, 5, NULL, '2026-05-09 14:35:13', '2026-05-09 14:35:13'),
(5, 6, NULL, '2026-05-17 01:10:54', '2026-05-17 01:10:54'),
(6, 8, NULL, '2026-06-13 02:43:48', '2026-06-13 02:43:48'),
(7, 9, NULL, '2026-06-22 13:38:39', '2026-06-22 13:38:39'),
(8, 10, NULL, '2026-06-27 05:26:33', '2026-07-27 00:27:35');

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
(1, 1, 1, 1, '2026-04-12 21:23:09', '2026-04-23 11:25:20'),
(4, 1, 2, 1, '2026-04-23 11:25:03', '2026-04-23 11:25:03'),
(9, 3, 3, 1, '2026-05-09 13:41:27', '2026-05-09 13:41:27'),
(11, 4, 3, 1, '2026-05-10 02:49:53', '2026-05-10 02:49:53'),
(19, 7, 3, 1, '2026-06-22 13:38:39', '2026-06-22 13:38:39'),
(21, 8, 3, 1, '2026-06-27 05:26:52', '2026-07-27 07:56:12'),
(23, 6, 1, 2, '2026-08-02 05:05:52', '2026-08-02 05:06:01');

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
(1, 'Kahwa Loose Leaf', 'kahwa-loose-leaf', NULL, NULL, NULL, 1, '2026-04-12 20:24:10', '2026-04-12 20:24:10'),
(2, 'Kashmiri Kahwa', 'kashmiri-kahwa', NULL, NULL, 1, 1, '2026-04-12 20:24:34', '2026-04-13 22:27:20');

-- --------------------------------------------------------

--
-- Table structure for table `contact_queries`
--

CREATE TABLE `contact_queries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, 'KAHWA10', 'percent', 10.00, NULL, 50.00, '2026-07-23', 100, 2, NULL, 1, '2026-04-27 22:49:04', '2026-05-08 12:19:10'),
(2, 'ADM49', 'fixed', 49.00, 1.00, 49.00, '2026-07-24', 100, 100, NULL, 1, '2026-05-09 13:32:39', '2026-05-09 13:34:53');

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
(1, 'hero-sections/weFDY0Y5OsksRIXZTtKharZDFjzLdQ0Lx2j69X7u.png', 'Kashmiri Kahwa', 'kashmiri-kahwa', 1, 1, '2026-04-08 13:47:22', '2026-04-25 14:07:33'),
(2, 'hero-sections/UcyCmQ8CyrtTsCZcLbxlv750Syxn4LOvJevA1aXE.png', 'Hibiscus Kahwa', 'hibiscus-kahwa', 1, 2, '2026-04-08 13:47:22', '2026-04-11 15:16:56'),
(3, 'hero-sections/FwnWYMliWWPRUa2P4FKVlF7wWear0d7JZ3J5ng6G.png', 'Mint Kahwa', 'mint-kahwa', 1, 3, '2026-04-08 13:47:22', '2026-04-11 15:26:18'),
(4, 'hero-sections/ElGH3VHrQp7tHeXFWIc69In8sAmcndT3TET5rhxX.png', 'Blue Kahwa', 'blue-kahwa', 1, 4, '2026-04-08 13:47:22', '2026-04-11 15:26:39'),
(5, 'hero-sections/Ro2YPKmhDXDBA7PSvQ7TmITlQzUdsH9xH7csiXGP.png', 'Oolong Kahwa', 'oolong-kahwa', 1, 5, '2026-04-08 13:47:22', '2026-04-11 15:26:58');

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
(6, '2026_03_13_181121_create_categories_table', 1),
(7, '2026_03_15_072049_create_ecommerce_tables', 1),
(8, '2026_03_15_080001_add_phone_to_users_table', 1),
(9, '2026_03_15_080002_create_products_table', 1),
(10, '2026_03_15_080003_create_product_variants_table', 1),
(11, '2026_03_15_080008_create_user_addresses_table', 1),
(12, '2026_03_15_080009_create_carts_table', 1),
(13, '2026_03_15_080010_create_cart_items_table', 1),
(14, '2026_03_15_080011_create_wishlists_table', 1),
(15, '2026_03_15_080012_create_coupons_table', 1),
(16, '2026_03_15_080013_create_orders_table', 1),
(17, '2026_03_15_080014_create_order_items_table', 1),
(18, '2026_03_15_080015_create_payments_table', 1),
(19, '2026_03_15_080016_create_coupon_usages_table', 1),
(20, '2026_03_15_080017_create_reviews_table', 1),
(21, '2026_03_15_080018_create_shipping_methods_table', 1),
(22, '2026_03_20_000002_add_product_id_to_order_items_table', 1),
(23, '2026_03_22_220000_add_image_path_to_categories_table', 1),
(24, '2026_03_23_090000_add_required_completed_orders_to_coupons_table', 1),
(25, '2026_03_24_090000_drop_shipping_methods_table', 1),
(26, '2026_04_05_000001_create_blog_posts_table', 1),
(27, '2026_04_06_000001_create_hero_sections_table', 1),
(28, '2026_04_09_000001_create_contact_queries_table', 1),
(29, '2026_04_12_000001_consolidate_product_schema_to_two_tables', 1),
(30, '2026_04_14_000001_add_filters_to_products_table', 2),
(31, '2026_04_16_000001_add_customer_checkout_fields', 2),
(32, '2026_04_26_000001_drop_unused_order_return_columns', 3),
(33, '2026_04_26_000002_add_applied_coupon_id_to_carts_table', 3),
(34, '2026_05_10_000001_make_payments_order_id_nullable', 4),
(35, '2026_05_10_000002_expand_reviews_for_customer_order_items', 4),
(36, '2026_05_10_000003_adjust_review_uniques_and_default_status', 4),
(37, '2026_06_28_000001_add_brewing_rituals_to_products_table', 4),
(38, '2026_06_30_000001_create_review_images_table', 5);

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
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 2),
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
  `tracking_id` varchar(255) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `address_id`, `order_number`, `subtotal`, `discount_amount`, `shipping_amount`, `total_amount`, `coupon_code`, `status`, `payment_status`, `tracking_id`, `delivery_date`, `notes`, `created_at`, `updated_at`) VALUES
(1, 4, 4, 'TKC-361699', 699.00, 0.00, 0.00, 699.00, NULL, 'pending', 'unpaid', NULL, NULL, NULL, '2026-04-25 14:46:27', '2026-04-25 14:46:27'),
(2, 4, 4, 'TKC-624400', 699.00, 0.00, 0.00, 699.00, NULL, 'pending', 'unpaid', NULL, NULL, NULL, '2026-04-25 14:46:49', '2026-04-25 14:46:49'),
(3, 4, 4, 'TKC-932038', 699.00, 0.00, 0.00, 699.00, NULL, 'pending', 'unpaid', NULL, NULL, NULL, '2026-04-25 14:46:58', '2026-04-25 14:46:58'),
(4, 4, 4, 'TKC-796529', 1398.00, 0.00, 0.00, 1398.00, NULL, 'pending', 'unpaid', NULL, NULL, NULL, '2026-04-26 02:28:18', '2026-04-26 02:28:18'),
(5, 4, 4, 'TKC-776607', 1398.00, 0.00, 0.00, 1398.00, NULL, 'pending', 'unpaid', NULL, NULL, NULL, '2026-04-26 02:28:53', '2026-04-26 02:28:53'),
(6, 4, 4, 'TKC-564449', 1398.00, 0.00, 0.00, 1398.00, NULL, 'pending', 'unpaid', NULL, NULL, NULL, '2026-04-26 02:30:45', '2026-04-26 02:30:45'),
(7, 2, 2, 'TKC-520521', 3196.00, 0.00, 0.00, 3196.00, NULL, 'pending', 'unpaid', NULL, NULL, NULL, '2026-04-27 22:38:42', '2026-04-27 22:38:42'),
(8, 2, 2, 'TKC-199160', 3196.00, 0.00, 0.00, 3196.00, NULL, 'pending', 'unpaid', NULL, NULL, NULL, '2026-04-27 22:39:17', '2026-04-27 22:39:17'),
(9, 2, 2, 'TKC-199427', 1398.00, 50.00, 0.00, 1348.00, 'KAHWA10', 'pending', 'unpaid', NULL, NULL, NULL, '2026-05-08 14:26:32', '2026-05-08 14:26:32'),
(10, 4, 4, 'TKC-770501', 1398.00, 50.00, 0.00, 1348.00, 'KAHWA10', 'pending', 'unpaid', NULL, NULL, NULL, '2026-05-08 14:39:25', '2026-05-08 14:39:25'),
(11, 2, 2, 'TKC-697234', 1398.00, 50.00, 0.00, 1348.00, 'KAHWA10', 'pending', 'unpaid', NULL, NULL, NULL, '2026-05-08 14:46:26', '2026-05-08 14:46:26'),
(12, 2, 2, 'TKC-890287', 1398.00, 50.00, 0.00, 1348.00, 'KAHWA10', 'confirmed', 'unpaid', NULL, NULL, NULL, '2026-05-08 15:05:28', '2026-05-10 04:50:34'),
(13, 2, 2, 'TKC-769512', 1398.00, 50.00, 0.00, 1348.00, 'KAHWA10', 'pending', 'unpaid', NULL, NULL, NULL, '2026-05-08 15:13:57', '2026-05-08 15:13:57'),
(14, 2, 2, 'TKC-56118', 1398.00, 50.00, 0.00, 1348.00, 'KAHWA10', 'pending', 'unpaid', NULL, NULL, NULL, '2026-05-08 15:15:46', '2026-05-08 15:15:46'),
(15, 2, 2, 'TKC-876644', 1398.00, 50.00, 0.00, 1348.00, 'KAHWA10', 'pending', 'unpaid', NULL, NULL, NULL, '2026-05-08 15:19:43', '2026-05-08 15:19:43'),
(16, 2, 2, 'TKC-662627', 1398.00, 50.00, 0.00, 1348.00, 'KAHWA10', 'pending', 'unpaid', NULL, NULL, NULL, '2026-05-09 12:59:49', '2026-05-09 12:59:49'),
(17, 4, 4, 'TKC-804107', 1.00, 0.00, 0.00, 1.00, NULL, 'pending', 'unpaid', NULL, NULL, NULL, '2026-05-09 13:46:39', '2026-05-09 13:46:39'),
(18, 2, 2, 'TKC-827096', 1.00, 0.00, 0.00, 1.00, NULL, 'delivered', 'paid', 'TRK-035849', '2026-05-13', NULL, '2026-05-09 13:53:40', '2026-05-10 04:35:25'),
(19, 2, 2, 'TKC-365232', 1.00, 0.00, 0.00, 1.00, NULL, 'pending', 'unpaid', NULL, NULL, NULL, '2026-05-09 14:18:18', '2026-05-09 14:18:18'),
(20, 4, 4, 'TKC-361539', 1.00, 0.00, 0.00, 1.00, NULL, 'pending', 'unpaid', NULL, NULL, NULL, '2026-05-10 02:52:29', '2026-05-10 02:52:29'),
(21, 2, 2, 'TKC-123913', 1.00, 0.00, 0.00, 1.00, NULL, 'pending', 'unpaid', NULL, NULL, NULL, '2026-05-10 04:55:16', '2026-05-10 04:55:16'),
(22, 2, 2, 'TKC-337840', 1599.00, 0.00, 0.00, 1599.00, NULL, 'pending', 'unpaid', NULL, NULL, NULL, '2026-05-10 04:56:15', '2026-05-10 04:56:15'),
(23, 2, 2, 'TKC-173676', 900.00, 0.00, 0.00, 900.00, NULL, 'pending', 'unpaid', NULL, NULL, NULL, '2026-05-10 05:35:10', '2026-05-10 05:35:10'),
(24, 2, 2, 'TKC-970473', 900.00, 0.00, 0.00, 900.00, NULL, 'pending', 'unpaid', NULL, NULL, NULL, '2026-05-10 05:37:02', '2026-05-10 05:37:02'),
(25, 2, 2, 'TKC-172695', 900.00, 0.00, 0.00, 900.00, NULL, 'pending', 'unpaid', NULL, NULL, NULL, '2026-05-10 05:38:43', '2026-05-10 05:38:43'),
(26, 2, 2, 'TKC-330329', 900.00, 0.00, 0.00, 900.00, NULL, 'pending', 'unpaid', NULL, NULL, NULL, '2026-05-10 05:46:21', '2026-05-10 05:46:21'),
(27, 2, 2, 'TKC-57875', 1.00, 0.00, 0.00, 1.00, NULL, 'pending', 'unpaid', NULL, NULL, NULL, '2026-05-10 05:47:33', '2026-05-10 05:47:33'),
(28, 2, 2, 'TKC-852818', 1.00, 0.00, 0.00, 1.00, NULL, 'pending', 'unpaid', NULL, NULL, NULL, '2026-05-10 05:48:16', '2026-05-10 05:48:16'),
(29, 2, 2, 'TKC-627039', 700.00, 0.00, 0.00, 700.00, NULL, 'pending', 'unpaid', NULL, NULL, NULL, '2026-05-10 05:58:21', '2026-05-10 05:58:21'),
(30, 2, 2, 'TKC-22110', 700.00, 0.00, 0.00, 700.00, NULL, 'cancelled', 'unpaid', NULL, NULL, NULL, '2026-05-10 06:00:02', '2026-05-10 06:02:20'),
(31, 2, 2, 'TKC-44188', 1.00, 0.00, 0.00, 1.00, NULL, 'pending', 'unpaid', NULL, NULL, NULL, '2026-05-10 07:15:40', '2026-05-10 07:15:40'),
(32, 6, NULL, 'TKC-278115', 1.00, 0.00, 0.00, 1.00, NULL, 'pending', 'unpaid', NULL, NULL, NULL, '2026-05-17 01:12:05', '2026-05-17 01:12:05'),
(33, 6, NULL, 'TKC-792504', 1.00, 0.00, 0.00, 1.00, NULL, 'pending', 'unpaid', NULL, NULL, NULL, '2026-05-23 12:33:23', '2026-05-23 12:33:23'),
(34, 2, 2, 'TKC-186212', 1.00, 0.00, 0.00, 1.00, NULL, 'delivered', 'paid', 'TRK-243786', '2026-05-27', NULL, '2026-05-23 12:34:46', '2026-05-24 06:50:29'),
(35, 2, 2, 'TKC-556359', 1.00, 0.00, 0.00, 1.00, NULL, 'pending', 'unpaid', NULL, NULL, NULL, '2026-05-23 12:40:14', '2026-05-23 12:40:14');

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
(1, 1, 1, 1, 'Kashmiri Kahwa', '50 cups', 699.00, 1, '2026-04-25 14:46:27', '2026-04-25 14:46:27'),
(2, 2, 1, 1, 'Kashmiri Kahwa', '50 cups', 699.00, 1, '2026-04-25 14:46:49', '2026-04-25 14:46:49'),
(3, 3, 1, 1, 'Kashmiri Kahwa', '50 cups', 699.00, 1, '2026-04-25 14:46:58', '2026-04-25 14:46:58'),
(4, 4, 1, 1, 'Kashmiri Kahwa', '50 cups', 699.00, 2, '2026-04-26 02:28:18', '2026-04-26 02:28:18'),
(5, 5, 1, 1, 'Kashmiri Kahwa', '50 cups', 699.00, 2, '2026-04-26 02:28:53', '2026-04-26 02:28:53'),
(6, 6, 1, 1, 'Kashmiri Kahwa', '50 cups', 699.00, 2, '2026-04-26 02:30:45', '2026-04-26 02:30:45'),
(7, 7, 1, 1, 'Kashmiri Kahwa', '50 cups', 699.00, 2, '2026-04-27 22:38:42', '2026-04-27 22:38:42'),
(8, 7, 1, 2, 'Kashmiri Kahwa', '30 cups', 899.00, 2, '2026-04-27 22:38:42', '2026-04-27 22:38:42'),
(9, 8, 1, 1, 'Kashmiri Kahwa', '50 cups', 699.00, 2, '2026-04-27 22:39:17', '2026-04-27 22:39:17'),
(10, 8, 1, 2, 'Kashmiri Kahwa', '30 cups', 899.00, 2, '2026-04-27 22:39:17', '2026-04-27 22:39:17'),
(11, 9, 1, 1, 'Kashmiri Kahwa', '50 cups', 699.00, 2, '2026-05-08 14:26:32', '2026-05-08 14:26:32'),
(12, 10, 1, 1, 'Kashmiri Kahwa', '50 cups', 699.00, 2, '2026-05-08 14:39:25', '2026-05-08 14:39:25'),
(13, 11, 1, 1, 'Kashmiri Kahwa', '50 cups', 699.00, 2, '2026-05-08 14:46:26', '2026-05-08 14:46:26'),
(14, 12, 1, 1, 'Kashmiri Kahwa', '50 cups', 699.00, 2, '2026-05-08 15:05:28', '2026-05-08 15:05:28'),
(15, 13, 1, 1, 'Kashmiri Kahwa', '50 cups', 699.00, 2, '2026-05-08 15:13:57', '2026-05-08 15:13:57'),
(16, 14, 1, 1, 'Kashmiri Kahwa', '50 cups', 699.00, 2, '2026-05-08 15:15:46', '2026-05-08 15:15:46'),
(17, 15, 1, 1, 'Kashmiri Kahwa', '50 cups', 699.00, 2, '2026-05-08 15:19:43', '2026-05-08 15:19:43'),
(18, 16, 1, 1, 'Kashmiri Kahwa', '50 cups', 699.00, 2, '2026-05-09 12:59:49', '2026-05-09 12:59:49'),
(19, 17, 2, 3, 'Tester pack', '1 bag', 1.00, 1, '2026-05-09 13:46:39', '2026-05-09 13:46:39'),
(20, 18, 2, 3, 'Tester pack', '1 bag', 1.00, 1, '2026-05-09 13:53:40', '2026-05-09 13:53:40'),
(21, 19, 2, 3, 'Tester pack', '1 bag', 1.00, 1, '2026-05-09 14:18:18', '2026-05-09 14:18:18'),
(22, 20, 2, 3, 'Tester pack', '1 bag', 1.00, 1, '2026-05-10 02:52:29', '2026-05-10 02:52:29'),
(23, 21, 2, 3, 'Tester pack', '1 bag', 1.00, 1, '2026-05-10 04:55:16', '2026-05-10 04:55:16'),
(24, 22, 1, 1, 'Kashmiri Kahwa', '50 cups', 699.00, 1, '2026-05-10 04:56:15', '2026-05-10 04:56:15'),
(25, 22, 1, 2, 'Kashmiri Kahwa', '30 cups', 899.00, 1, '2026-05-10 04:56:15', '2026-05-10 04:56:15'),
(26, 22, 2, 3, 'Tester pack', '1 bag', 1.00, 1, '2026-05-10 04:56:15', '2026-05-10 04:56:15'),
(27, 23, 1, 2, 'Kashmiri Kahwa', '30 cups', 899.00, 1, '2026-05-10 05:35:10', '2026-05-10 05:35:10'),
(28, 23, 2, 3, 'Tester pack', '1 bag', 1.00, 1, '2026-05-10 05:35:10', '2026-05-10 05:35:10'),
(29, 24, 1, 2, 'Kashmiri Kahwa', '30 cups', 899.00, 1, '2026-05-10 05:37:02', '2026-05-10 05:37:02'),
(30, 24, 2, 3, 'Tester pack', '1 bag', 1.00, 1, '2026-05-10 05:37:02', '2026-05-10 05:37:02'),
(31, 25, 1, 2, 'Kashmiri Kahwa', '30 cups', 899.00, 1, '2026-05-10 05:38:43', '2026-05-10 05:38:43'),
(32, 25, 2, 3, 'Tester pack', '1 bag', 1.00, 1, '2026-05-10 05:38:43', '2026-05-10 05:38:43'),
(33, 26, 1, 2, 'Kashmiri Kahwa', '30 cups', 899.00, 1, '2026-05-10 05:46:21', '2026-05-10 05:46:21'),
(34, 26, 2, 3, 'Tester pack', '1 bag', 1.00, 1, '2026-05-10 05:46:21', '2026-05-10 05:46:21'),
(35, 27, 2, 3, 'Tester pack', '1 bag', 1.00, 1, '2026-05-10 05:47:33', '2026-05-10 05:47:33'),
(36, 28, 2, 3, 'Tester pack', '1 bag', 1.00, 1, '2026-05-10 05:48:16', '2026-05-10 05:48:16'),
(37, 29, 1, 1, 'Kashmiri Kahwa', '50 cups', 699.00, 1, '2026-05-10 05:58:21', '2026-05-10 05:58:21'),
(38, 29, 2, 3, 'Tester pack', '1 bag', 1.00, 1, '2026-05-10 05:58:21', '2026-05-10 05:58:21'),
(39, 30, 1, 1, 'Kashmiri Kahwa', '50 cups', 699.00, 1, '2026-05-10 06:00:02', '2026-05-10 06:00:02'),
(40, 30, 2, 3, 'Tester pack', '1 bag', 1.00, 1, '2026-05-10 06:00:02', '2026-05-10 06:00:02'),
(41, 31, 2, 3, 'Tester pack', '1 bag', 1.00, 1, '2026-05-10 07:15:40', '2026-05-10 07:15:40'),
(42, 32, 2, 3, 'Tester pack', '1 bag', 1.00, 1, '2026-05-17 01:12:05', '2026-05-17 01:12:05'),
(43, 33, 2, 3, 'Tester pack', '1 bag', 1.00, 1, '2026-05-23 12:33:23', '2026-05-23 12:33:23'),
(44, 34, 2, 3, 'Tester pack', '1 bag', 1.00, 1, '2026-05-23 12:34:46', '2026-05-23 12:34:46'),
(45, 35, 2, 3, 'Tester pack', '1 bag', 1.00, 1, '2026-05-23 12:40:14', '2026-05-23 12:40:14');

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
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payment_method` varchar(255) NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `gateway_order_id` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(10) NOT NULL DEFAULT 'INR',
  `status` enum('initiated','success','failed','refunded') NOT NULL DEFAULT 'initiated',
  `failure_code` varchar(255) DEFAULT NULL,
  `failure_reason` text DEFAULT NULL,
  `gateway_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gateway_payload`)),
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `payment_method`, `transaction_id`, `gateway_order_id`, `amount`, `currency`, `status`, `failure_code`, `failure_reason`, `gateway_payload`, `paid_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'razorpay', NULL, 'order_b1dafd1a62b2', 1499.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"9009255095\",\"name\":\"deepika\",\"email\":\"deepika@gmail.com\",\"address_id\":4}', NULL, '2026-04-25 14:46:27', '2026-04-25 14:46:27'),
(2, 2, 'razorpay', NULL, 'order_82026b2fc134', 1499.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"9009255095\",\"name\":\"deepika\",\"email\":\"deepika@gmail.com\",\"address_id\":4}', NULL, '2026-04-25 14:46:49', '2026-04-25 14:46:49'),
(3, 3, 'razorpay', NULL, 'order_a9fc20e1c589', 1499.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"9009255095\",\"name\":\"deepika\",\"email\":\"deepika@gmail.com\",\"address_id\":4}', NULL, '2026-04-25 14:46:58', '2026-04-25 14:46:58'),
(4, 4, 'razorpay', NULL, 'order_0250ab896fd2', 1499.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"9009255095\",\"name\":\"deepika\",\"email\":\"deepika@gmail.com\",\"address_id\":4}', NULL, '2026-04-26 02:28:18', '2026-04-26 02:28:18'),
(5, 5, 'razorpay', NULL, 'order_6b19d2973a8b', 1499.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"9009255095\",\"name\":\"deepika\",\"email\":\"deepika@gmail.com\",\"address_id\":4}', NULL, '2026-04-26 02:28:53', '2026-04-26 02:28:53'),
(6, 6, 'razorpay', NULL, 'order_e8392ffeead0', 1499.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"9009255095\",\"name\":\"deepika\",\"email\":\"deepika@gmail.com\",\"address_id\":4}', NULL, '2026-04-26 02:30:45', '2026-04-26 02:30:45'),
(7, 12, 'razorpay', NULL, 'order_Sn0IIyQTQtMDKF', 1348.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"06265880144\",\"name\":\"Rochak Malviya\",\"email\":\"rochakmalviya@gmail.com\",\"address_id\":2,\"coupon_code\":\"KAHWA10\",\"razorpay_order\":{\"amount\":134800,\"amount_due\":134800,\"amount_paid\":0,\"attempts\":0,\"created_at\":1778272528,\"currency\":\"INR\",\"entity\":\"order\",\"id\":\"order_Sn0IIyQTQtMDKF\",\"notes\":{\"internal_order_id\":\"TKC-890287\",\"user_id\":\"2\"},\"offer_id\":null,\"receipt\":\"TKC-890287\",\"status\":\"created\"}}', NULL, '2026-05-08 15:05:28', '2026-05-08 15:05:28'),
(8, 13, 'razorpay', NULL, 'order_Sn0RGofBQeRNNQ', 1348.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"06265880144\",\"name\":\"Rochak Malviya\",\"email\":\"rochakmalviya@gmail.com\",\"address_id\":2,\"coupon_code\":\"KAHWA10\",\"razorpay_order\":{\"amount\":134800,\"amount_due\":134800,\"amount_paid\":0,\"attempts\":0,\"created_at\":1778273037,\"currency\":\"INR\",\"entity\":\"order\",\"id\":\"order_Sn0RGofBQeRNNQ\",\"notes\":{\"internal_order_id\":\"TKC-769512\",\"user_id\":\"2\"},\"offer_id\":null,\"receipt\":\"TKC-769512\",\"status\":\"created\"}}', NULL, '2026-05-08 15:13:57', '2026-05-08 15:13:57'),
(9, 14, 'razorpay', NULL, 'order_Sn0TBtOVfST1GV', 1348.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"06265880144\",\"name\":\"Rochak Malviya\",\"email\":\"rochakmalviya@gmail.com\",\"address_id\":2,\"coupon_code\":\"KAHWA10\",\"razorpay_order\":{\"amount\":134800,\"amount_due\":134800,\"amount_paid\":0,\"attempts\":0,\"created_at\":1778273146,\"currency\":\"INR\",\"entity\":\"order\",\"id\":\"order_Sn0TBtOVfST1GV\",\"notes\":{\"internal_order_id\":\"TKC-56118\",\"user_id\":\"2\"},\"offer_id\":null,\"receipt\":\"TKC-56118\",\"status\":\"created\"}}', NULL, '2026-05-08 15:15:46', '2026-05-08 15:15:46'),
(10, 15, 'razorpay', NULL, 'order_Sn0XMHV3k4VM46', 1348.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"06265880144\",\"name\":\"Rochak Malviya\",\"email\":\"rochakmalviya@gmail.com\",\"address_id\":2,\"coupon_code\":\"KAHWA10\",\"razorpay_order\":{\"amount\":134800,\"amount_due\":134800,\"amount_paid\":0,\"attempts\":0,\"created_at\":1778273383,\"currency\":\"INR\",\"entity\":\"order\",\"id\":\"order_Sn0XMHV3k4VM46\",\"notes\":{\"internal_order_id\":\"TKC-876644\",\"user_id\":\"2\"},\"offer_id\":null,\"receipt\":\"TKC-876644\",\"status\":\"created\"}}', NULL, '2026-05-08 15:19:43', '2026-05-08 15:19:43'),
(11, 16, 'razorpay', NULL, 'order_SnMghw6L2JysUN', 1348.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"06265880144\",\"name\":\"Rochak Malviya\",\"email\":\"rochakmalviya@gmail.com\",\"address_id\":2,\"coupon_code\":\"KAHWA10\",\"razorpay_order\":{\"amount\":134800,\"amount_due\":134800,\"amount_paid\":0,\"attempts\":0,\"created_at\":1778351389,\"currency\":\"INR\",\"entity\":\"order\",\"id\":\"order_SnMghw6L2JysUN\",\"notes\":{\"internal_order_id\":\"TKC-662627\",\"user_id\":\"2\"},\"offer_id\":null,\"receipt\":\"TKC-662627\",\"status\":\"created\"}}', NULL, '2026-05-09 12:59:49', '2026-05-09 12:59:49'),
(12, 17, 'razorpay', NULL, 'order_SnNUAS1dNONPNM', 1.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"9009255095\",\"name\":\"deepika\",\"email\":\"deepika@gmail.com\",\"address_id\":4,\"coupon_code\":null,\"razorpay_order\":{\"amount\":100,\"amount_due\":100,\"amount_paid\":0,\"attempts\":0,\"created_at\":1778354199,\"currency\":\"INR\",\"entity\":\"order\",\"id\":\"order_SnNUAS1dNONPNM\",\"notes\":{\"internal_order_id\":\"TKC-804107\",\"user_id\":\"4\"},\"offer_id\":null,\"receipt\":\"TKC-804107\",\"status\":\"created\"}}', NULL, '2026-05-09 13:46:39', '2026-05-09 13:46:39'),
(13, 18, 'razorpay', 'pay_SnNc9wrPOgi1lU', 'order_SnNbal3JBBq5DE', 1.00, 'INR', 'success', NULL, NULL, '{\"contact\":\"06265880144\",\"name\":\"Rochak Malviya\",\"email\":\"rochakmalviya@gmail.com\",\"address_id\":2,\"coupon_code\":null,\"razorpay_order\":{\"amount\":100,\"amount_due\":100,\"amount_paid\":0,\"attempts\":0,\"created_at\":1778354620,\"currency\":\"INR\",\"entity\":\"order\",\"id\":\"order_SnNbal3JBBq5DE\",\"notes\":{\"internal_order_id\":\"TKC-827096\",\"user_id\":\"2\"},\"offer_id\":null,\"receipt\":\"TKC-827096\",\"status\":\"created\"},\"razorpay_signature\":\"403f0b4c3579c265dae73bfa0ed01cbb9f3f13bf842ae247f39c749e22d5abb7\",\"verified_at\":\"2026-05-09T19:24:27.042243Z\"}', '2026-05-09 13:54:27', '2026-05-09 13:53:40', '2026-05-09 13:54:27'),
(14, 19, 'razorpay', NULL, 'order_SnO1cCYgC9KWaB', 1.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"06265880144\",\"name\":\"Rochak Malviya\",\"email\":\"rochakmalviya@gmail.com\",\"address_id\":2,\"coupon_code\":null,\"razorpay_order\":{\"amount\":100,\"amount_due\":100,\"amount_paid\":0,\"attempts\":0,\"created_at\":1778356099,\"currency\":\"INR\",\"entity\":\"order\",\"id\":\"order_SnO1cCYgC9KWaB\",\"notes\":{\"internal_order_id\":\"TKC-365232\",\"user_id\":\"2\"},\"offer_id\":null,\"receipt\":\"TKC-365232\",\"status\":\"created\"}}', NULL, '2026-05-09 14:18:19', '2026-05-09 14:18:19'),
(15, 20, 'razorpay', NULL, 'order_SnasHKzTP18wV4', 1.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"9009255095\",\"name\":\"deepika\",\"email\":\"deepika@gmail.com\",\"address_id\":4,\"coupon_code\":null,\"razorpay_order\":{\"amount\":100,\"amount_due\":100,\"amount_paid\":0,\"attempts\":0,\"created_at\":1778401349,\"currency\":\"INR\",\"entity\":\"order\",\"id\":\"order_SnasHKzTP18wV4\",\"notes\":{\"internal_order_id\":\"TKC-361539\",\"user_id\":\"4\"},\"offer_id\":null,\"receipt\":\"TKC-361539\",\"status\":\"created\"}}', NULL, '2026-05-10 02:52:29', '2026-05-10 02:52:29'),
(16, 21, 'razorpay', NULL, 'order_SncxysMLfuPcir', 1.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"06265880144\",\"name\":\"Rochak Malviya\",\"email\":\"rochakmalviya@gmail.com\",\"address_id\":2,\"coupon_code\":null,\"razorpay_order\":{\"amount\":100,\"amount_due\":100,\"amount_paid\":0,\"attempts\":0,\"created_at\":1778408716,\"currency\":\"INR\",\"entity\":\"order\",\"id\":\"order_SncxysMLfuPcir\",\"notes\":{\"internal_order_id\":\"TKC-123913\",\"user_id\":\"2\"},\"offer_id\":null,\"receipt\":\"TKC-123913\",\"status\":\"created\"}}', NULL, '2026-05-10 04:55:16', '2026-05-10 04:55:16'),
(17, 22, 'razorpay', NULL, 'order_Sncz0h0whE08FD', 1599.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"06265880144\",\"name\":\"Rochak Malviya\",\"email\":\"rochakmalviya@gmail.com\",\"address_id\":2,\"coupon_code\":null,\"razorpay_order\":{\"amount\":159900,\"amount_due\":159900,\"amount_paid\":0,\"attempts\":0,\"created_at\":1778408775,\"currency\":\"INR\",\"entity\":\"order\",\"id\":\"order_Sncz0h0whE08FD\",\"notes\":{\"internal_order_id\":\"TKC-337840\",\"user_id\":\"2\"},\"offer_id\":null,\"receipt\":\"TKC-337840\",\"status\":\"created\"}}', NULL, '2026-05-10 04:56:15', '2026-05-10 04:56:15'),
(18, 23, 'razorpay', NULL, 'order_Snde87KFpwjPnG', 900.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"06265880144\",\"name\":\"Rochak Malviya\",\"email\":\"rochakmalviya@gmail.com\",\"address_id\":2,\"coupon_code\":null,\"razorpay_order\":{\"amount\":90000,\"amount_due\":90000,\"amount_paid\":0,\"attempts\":0,\"created_at\":1778411110,\"currency\":\"INR\",\"entity\":\"order\",\"id\":\"order_Snde87KFpwjPnG\",\"notes\":{\"internal_order_id\":\"TKC-173676\",\"user_id\":\"2\"},\"offer_id\":null,\"receipt\":\"TKC-173676\",\"status\":\"created\"}}', NULL, '2026-05-10 05:35:10', '2026-05-10 05:35:10'),
(19, 24, 'razorpay', NULL, 'order_Sndg6O4W1Z8l9z', 900.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"06265880144\",\"name\":\"Rochak Malviya\",\"email\":\"rochakmalviya@gmail.com\",\"address_id\":2,\"coupon_code\":null,\"razorpay_order\":{\"amount\":90000,\"amount_due\":90000,\"amount_paid\":0,\"attempts\":0,\"created_at\":1778411222,\"currency\":\"INR\",\"entity\":\"order\",\"id\":\"order_Sndg6O4W1Z8l9z\",\"notes\":{\"internal_order_id\":\"TKC-970473\",\"user_id\":\"2\"},\"offer_id\":null,\"receipt\":\"TKC-970473\",\"status\":\"created\"}}', NULL, '2026-05-10 05:37:02', '2026-05-10 05:37:02'),
(20, 25, 'razorpay', NULL, 'order_SndhsIX2UjzUc6', 900.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"06265880144\",\"name\":\"Rochak Malviya\",\"email\":\"rochakmalviya@gmail.com\",\"address_id\":2,\"coupon_code\":null,\"razorpay_order\":{\"amount\":90000,\"amount_due\":90000,\"amount_paid\":0,\"attempts\":0,\"created_at\":1778411323,\"currency\":\"INR\",\"entity\":\"order\",\"id\":\"order_SndhsIX2UjzUc6\",\"notes\":{\"internal_order_id\":\"TKC-172695\",\"user_id\":\"2\"},\"offer_id\":null,\"receipt\":\"TKC-172695\",\"status\":\"created\"}}', NULL, '2026-05-10 05:38:43', '2026-05-10 05:38:43'),
(21, 26, 'razorpay', NULL, 'order_SndpwhVXRpmC7R', 900.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"06265880144\",\"name\":\"Rochak Malviya\",\"email\":\"rochakmalviya@gmail.com\",\"address_id\":2,\"coupon_code\":null,\"razorpay_order\":{\"amount\":90000,\"amount_due\":90000,\"amount_paid\":0,\"attempts\":0,\"created_at\":1778411782,\"currency\":\"INR\",\"entity\":\"order\",\"id\":\"order_SndpwhVXRpmC7R\",\"notes\":{\"internal_order_id\":\"TKC-330329\",\"user_id\":\"2\"},\"offer_id\":null,\"receipt\":\"TKC-330329\",\"status\":\"created\"}}', NULL, '2026-05-10 05:46:22', '2026-05-10 05:46:22'),
(22, 27, 'razorpay', NULL, 'order_SndrD5RcQ8QpTb', 1.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"06265880144\",\"name\":\"Rochak Malviya\",\"email\":\"rochakmalviya@gmail.com\",\"address_id\":2,\"coupon_code\":null,\"razorpay_order\":{\"amount\":100,\"amount_due\":100,\"amount_paid\":0,\"attempts\":0,\"created_at\":1778411853,\"currency\":\"INR\",\"entity\":\"order\",\"id\":\"order_SndrD5RcQ8QpTb\",\"notes\":{\"internal_order_id\":\"TKC-57875\",\"user_id\":\"2\"},\"offer_id\":null,\"receipt\":\"TKC-57875\",\"status\":\"created\"}}', NULL, '2026-05-10 05:47:33', '2026-05-10 05:47:33'),
(23, 28, 'razorpay', NULL, 'order_SndrxbF8C2Gyu8', 1.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"06265880144\",\"name\":\"Rochak Malviya\",\"email\":\"rochakmalviya@gmail.com\",\"address_id\":2,\"coupon_code\":null,\"razorpay_order\":{\"amount\":100,\"amount_due\":100,\"amount_paid\":0,\"attempts\":0,\"created_at\":1778411896,\"currency\":\"INR\",\"entity\":\"order\",\"id\":\"order_SndrxbF8C2Gyu8\",\"notes\":{\"internal_order_id\":\"TKC-852818\",\"user_id\":\"2\"},\"offer_id\":null,\"receipt\":\"TKC-852818\",\"status\":\"created\"}}', NULL, '2026-05-10 05:48:16', '2026-05-10 05:48:16'),
(24, 29, 'razorpay', NULL, 'order_Sne2cU9uM6ACP4', 700.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"06265880144\",\"name\":\"Rochak Malviya\",\"email\":\"rochakmalviya@gmail.com\",\"address_id\":2,\"coupon_code\":null,\"razorpay_order\":{\"amount\":70000,\"amount_due\":70000,\"amount_paid\":0,\"attempts\":0,\"created_at\":1778412501,\"currency\":\"INR\",\"entity\":\"order\",\"id\":\"order_Sne2cU9uM6ACP4\",\"notes\":{\"internal_order_id\":\"TKC-627039\",\"user_id\":\"2\"},\"offer_id\":null,\"receipt\":\"TKC-627039\",\"status\":\"created\"}}', NULL, '2026-05-10 05:58:21', '2026-05-10 05:58:21'),
(25, 30, 'razorpay', NULL, 'order_Sne4O6MSYUzllH', 700.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"06265880144\",\"name\":\"Rochak Malviya\",\"email\":\"rochakmalviya@gmail.com\",\"address_id\":2,\"coupon_code\":null,\"razorpay_order\":{\"amount\":70000,\"amount_due\":70000,\"amount_paid\":0,\"attempts\":0,\"created_at\":1778412602,\"currency\":\"INR\",\"entity\":\"order\",\"id\":\"order_Sne4O6MSYUzllH\",\"notes\":{\"internal_order_id\":\"TKC-22110\",\"user_id\":\"2\"},\"offer_id\":null,\"receipt\":\"TKC-22110\",\"status\":\"created\"}}', NULL, '2026-05-10 06:00:02', '2026-05-10 06:00:02'),
(26, 31, 'razorpay', NULL, 'order_SnfMHvtn9l7Wkl', 1.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"06265880144\",\"name\":\"Rochak Malviya\",\"email\":\"rochakmalviya@gmail.com\",\"address_id\":2,\"coupon_code\":null,\"razorpay_order\":{\"amount\":100,\"amount_due\":100,\"amount_paid\":0,\"attempts\":0,\"created_at\":1778417140,\"currency\":\"INR\",\"entity\":\"order\",\"id\":\"order_SnfMHvtn9l7Wkl\",\"notes\":{\"internal_order_id\":\"TKC-44188\",\"user_id\":\"2\"},\"offer_id\":null,\"receipt\":\"TKC-44188\",\"status\":\"created\"}}', NULL, '2026-05-10 07:15:40', '2026-05-10 07:15:40'),
(27, 32, 'razorpay', NULL, 'order_SqKu4i0sfSdM9a', 1.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"7000795310\",\"name\":\"Ajay Gupta\",\"email\":\"ajaygupta1427@gmail.com\",\"address_id\":6,\"coupon_code\":null,\"razorpay_order\":{\"amount\":100,\"amount_due\":100,\"amount_paid\":0,\"attempts\":0,\"created_at\":1779000126,\"currency\":\"INR\",\"entity\":\"order\",\"id\":\"order_SqKu4i0sfSdM9a\",\"notes\":{\"internal_order_id\":\"TKC-278115\",\"user_id\":\"6\"},\"offer_id\":null,\"receipt\":\"TKC-278115\",\"status\":\"created\"}}', NULL, '2026-05-17 01:12:06', '2026-05-17 01:12:06'),
(28, 33, 'razorpay', NULL, 'order_SstiTO6hOT9rx4', 1.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"7000795310\",\"name\":\"Ajay Gupta\",\"email\":\"ajaygupta1427@gmail.com\",\"address_id\":6,\"coupon_code\":null,\"razorpay_order\":{\"amount\":100,\"amount_due\":100,\"amount_paid\":0,\"attempts\":0,\"created_at\":1779559403,\"currency\":\"INR\",\"entity\":\"order\",\"id\":\"order_SstiTO6hOT9rx4\",\"notes\":{\"internal_order_id\":\"TKC-792504\",\"user_id\":\"6\"},\"offer_id\":null,\"receipt\":\"TKC-792504\",\"status\":\"created\"}}', NULL, '2026-05-23 12:33:23', '2026-05-23 12:33:23'),
(29, 34, 'razorpay', 'pay_SstkOXvjJHZXJM', 'order_Sstjv9TYlHEV13', 1.00, 'INR', 'success', NULL, NULL, '{\"contact\":\"06265880144\",\"name\":\"Rochak Malviya\",\"email\":\"rochakmalviya@gmail.com\",\"address_id\":2,\"coupon_code\":null,\"razorpay_order\":{\"amount\":100,\"amount_due\":100,\"amount_paid\":0,\"attempts\":0,\"created_at\":1779559486,\"currency\":\"INR\",\"entity\":\"order\",\"id\":\"order_Sstjv9TYlHEV13\",\"notes\":{\"internal_order_id\":\"TKC-186212\",\"user_id\":\"2\"},\"offer_id\":null,\"receipt\":\"TKC-186212\",\"status\":\"created\"},\"razorpay_signature\":\"9c278b5a2018554aa0b5e40a9ff4d9b2ad72b0b2b13cafc7b33fbc03ab3a5410\",\"verified_at\":\"2026-05-23T18:05:28.955757Z\"}', '2026-05-23 12:35:28', '2026-05-23 12:34:46', '2026-05-23 12:35:28'),
(30, 35, 'razorpay', NULL, 'order_SstphxxN1O4w0a', 1.00, 'INR', 'initiated', NULL, NULL, '{\"contact\":\"06265880144\",\"name\":\"Rochak Malviya\",\"email\":\"rochakmalviya@gmail.com\",\"address_id\":2,\"coupon_code\":null,\"razorpay_order\":{\"amount\":100,\"amount_due\":100,\"amount_paid\":0,\"attempts\":0,\"created_at\":1779559814,\"currency\":\"INR\",\"entity\":\"order\",\"id\":\"order_SstphxxN1O4w0a\",\"notes\":{\"internal_order_id\":\"TKC-556359\",\"user_id\":\"2\"},\"offer_id\":null,\"receipt\":\"TKC-556359\",\"status\":\"created\"}}', NULL, '2026-05-23 12:40:14', '2026-05-23 12:40:14'),
(31, NULL, 'razorpay', NULL, 'order_SzOp3uD0MEudPi', 51.00, 'INR', 'initiated', NULL, NULL, '{\"user_id\":2,\"contact\":\"06265880144\",\"name\":\"Rochak Malviya\",\"email\":\"rochakmalviya@gmail.com\",\"address_id\":2,\"address_snapshot\":{\"label\":null,\"address_line1\":\"76, Siddhipuram colony, Indore, MP, India\",\"address_line2\":null,\"city\":\"Indore\",\"state\":\"MP\",\"pincode\":\"452009\",\"country\":\"India\"},\"coupon_code\":null,\"checkout\":{\"items\":[{\"id\":17,\"product_id\":2,\"variant_id\":3,\"name\":\"Tester pack\",\"product_name\":\"Tester pack\",\"variant\":\"1 bag\",\"variant_name\":\"1 bag\",\"qty\":1,\"quantity\":1,\"price\":1,\"line_total\":1,\"image\":\"https:\\/\\/tkc.volymoly.com\\/media\\/public\\/products\\/gallery\\/bp0OQ0DH0DNnYJOjKjKroSlkEXKAHJoCAqd5EAU9.png\"}],\"summary\":{\"subtotal\":1,\"shipping\":50,\"tax\":0,\"discount_amount\":0,\"total\":51,\"final_total\":51,\"currency\":\"INR\",\"free_shipping_threshold\":500},\"coupon\":null},\"razorpay_order\":{\"amount\":5100,\"amount_due\":5100,\"amount_paid\":0,\"attempts\":0,\"created_at\":1780978988,\"currency\":\"INR\",\"entity\":\"order\",\"id\":\"order_SzOp3uD0MEudPi\",\"notes\":{\"user_id\":\"2\"},\"offer_id\":null,\"receipt\":\"PAY-BC9F4DB5\",\"status\":\"created\"}}', NULL, '2026-06-08 22:53:08', '2026-06-08 22:53:08'),
(32, NULL, 'razorpay', NULL, 'order_T12vGrj26OTWxL', 51.00, 'INR', 'initiated', NULL, NULL, '{\"user_id\":8,\"contact\":\"6265880144\",\"name\":\"Rochak Malviya\",\"email\":\"rochak@gmail.com\",\"address_id\":7,\"address_snapshot\":{\"label\":\"Home\",\"address_line1\":\"78\",\"address_line2\":null,\"city\":\"Indore\",\"state\":\"MP\",\"pincode\":\"452009\",\"country\":\"India\"},\"coupon_code\":null,\"checkout\":{\"items\":[{\"id\":18,\"product_id\":2,\"variant_id\":3,\"name\":\"Tester pack\",\"product_name\":\"Tester pack\",\"variant\":\"1 bag\",\"variant_name\":\"1 bag\",\"qty\":1,\"quantity\":1,\"price\":1,\"line_total\":1,\"image\":\"https:\\/\\/tkc.volymoly.com\\/media\\/public\\/products\\/gallery\\/bp0OQ0DH0DNnYJOjKjKroSlkEXKAHJoCAqd5EAU9.png\"}],\"summary\":{\"subtotal\":1,\"shipping\":50,\"tax\":0,\"discount_amount\":0,\"total\":51,\"final_total\":51,\"currency\":\"INR\",\"free_shipping_threshold\":500},\"coupon\":null},\"razorpay_order\":{\"amount\":5100,\"amount_due\":5100,\"amount_paid\":0,\"attempts\":0,\"created_at\":1781338546,\"currency\":\"INR\",\"entity\":\"order\",\"id\":\"order_T12vGrj26OTWxL\",\"notes\":{\"user_id\":\"8\"},\"offer_id\":null,\"receipt\":\"PAY-569F983D\",\"status\":\"created\"}}', NULL, '2026-06-13 02:45:46', '2026-06-13 02:45:46');

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
(26, 'admin.access', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(27, 'dashboard.view', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(28, 'orders.view', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(29, 'orders.update', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(30, 'payments.view', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(31, 'payments.update', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(32, 'products.view', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(33, 'products.create', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(34, 'products.update', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(35, 'products.delete', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(36, 'categories.view', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(37, 'categories.create', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(38, 'categories.update', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(39, 'categories.delete', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(40, 'coupons.view', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(41, 'coupons.create', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(42, 'coupons.update', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(43, 'coupons.delete', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(44, 'users.view', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(45, 'users.create', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(46, 'users.update', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(47, 'users.delete', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(48, 'reviews.view', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(49, 'reviews.delete', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(50, 'carts.view', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(51, 'wishlists.view', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(52, 'wishlists.delete', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(53, 'blogs.view', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(54, 'blogs.create', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(55, 'blogs.update', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(56, 'blogs.delete', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(57, 'hero_sections.view', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(58, 'hero_sections.create', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(59, 'hero_sections.update', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(60, 'hero_sections.delete', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(61, 'roles.view', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(62, 'roles.create', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(63, 'roles.update', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(64, 'roles.delete', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(65, 'profile.view', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07'),
(66, 'profile.update', 'sanctum', '2026-04-14 00:21:07', '2026-04-14 00:21:07');

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
(6, 'App\\Models\\User', 1, 'auth_token', 'fe3f6c9ae4d1b458f22b85d266b5a65431bb305b30149dfca73a8acac6397ba2', '[\"*\"]', '2026-04-12 20:34:11', NULL, '2026-04-12 20:22:57', '2026-04-12 20:34:11'),
(7, 'App\\Models\\User', 1, 'auth_token', 'e5958d66da2e9f73d56340dbcb3841ca1e48112df6ca07d154d67f1fcbda9699', '[\"*\"]', '2026-04-12 21:04:15', NULL, '2026-04-12 21:01:13', '2026-04-12 21:04:15'),
(8, 'App\\Models\\User', 1, 'auth_token', '4af815592dc26b3d1185ddaae81a8c416ab730d03f235619ce59bbc8e04964a5', '[\"*\"]', '2026-04-12 21:03:44', NULL, '2026-04-12 21:01:57', '2026-04-12 21:03:44'),
(9, 'App\\Models\\User', 1, 'auth_token', '3ec2e5f209d92ecafcf8efb6917d4bd834b5643b89f64b7340125bd3f16b78f2', '[\"*\"]', '2026-04-13 20:03:28', NULL, '2026-04-12 21:20:16', '2026-04-13 20:03:28'),
(10, 'App\\Models\\User', 1, 'auth_token', 'fc579aff6d1bcca5e8e6df3ac646300f4d9de1e4cfe75523be812df69f8563a5', '[\"*\"]', '2026-04-13 10:18:18', NULL, '2026-04-13 10:14:14', '2026-04-13 10:18:18'),
(11, 'App\\Models\\User', 1, 'auth_token', '9d8d59cf728a772b70fecf272f0f0b3b685b6915669890559ab2e8b7f4333915', '[\"*\"]', '2026-04-13 21:33:37', NULL, '2026-04-13 20:33:57', '2026-04-13 21:33:37'),
(12, 'App\\Models\\User', 1, 'auth_token', '813af44a80a47fa4605c667019067d61be630acc00b22debd258bae0b3797c06', '[\"*\"]', '2026-04-13 22:58:26', NULL, '2026-04-13 21:52:24', '2026-04-13 22:58:26'),
(13, 'App\\Models\\User', 1, 'auth_token', '3cd6414284da42fe8145b1573958483f22d44cfd7acae7ee518ce2bf64085cfe', '[\"*\"]', '2026-04-16 18:27:25', NULL, '2026-04-13 22:41:47', '2026-04-16 18:27:25'),
(16, 'App\\Models\\User', 1, 'auth_token', 'bb8852a3cd5d6780e0f03bc6fa8a8392584177febdb899f8af105a362862c788', '[\"*\"]', '2026-04-14 00:21:18', NULL, '2026-04-14 00:05:24', '2026-04-14 00:21:18'),
(17, 'App\\Models\\User', 2, 'auth_token', '131ceb8113d9bfed57f7731dbeeaaaf589bfc158fa02be8bbded38918c483c3d', '[\"*\"]', NULL, NULL, '2026-04-14 02:47:03', '2026-04-14 02:47:03'),
(18, 'App\\Models\\User', 2, 'auth_token', '51dcc60e5ec097d3e394ad7a7befef58207e48a51f0f9b2e2bd70f118a5d22ac', '[\"*\"]', '2026-04-16 19:27:20', NULL, '2026-04-14 02:47:16', '2026-04-16 19:27:20'),
(19, 'App\\Models\\User', 1, 'auth_token', '48d26c7dde86abf73480a6b413496ef25257ee43680adef7e7540bf8e7ae101b', '[\"*\"]', '2026-04-14 03:23:52', NULL, '2026-04-14 03:15:02', '2026-04-14 03:23:52'),
(20, 'App\\Models\\User', 1, 'auth_token', '4ba9941bb650797e7bbb3d7778d99431a2bd17569c0f865520fb6e9f55310564', '[\"*\"]', '2026-04-15 01:12:42', NULL, '2026-04-15 01:03:23', '2026-04-15 01:12:42'),
(22, 'App\\Models\\User', 1, 'auth_token', '24a5835a7bee5dfe98e8e6029cd14641f842a6e8d1d878f7e6eb23bebef1fc8c', '[\"*\"]', '2026-04-16 19:19:06', NULL, '2026-04-16 18:23:15', '2026-04-16 19:19:06'),
(23, 'App\\Models\\User', 2, 'auth_token', 'f5fd6bb56302852ee7a184959b05d130a68861db24bd87f2969e87768ab70383', '[\"*\"]', NULL, NULL, '2026-04-16 18:24:10', '2026-04-16 18:24:10'),
(24, 'App\\Models\\User', 2, 'auth_token', '32603415b50a018d0cb7984591e5f100944f47788f3053adf4ac1b5df2ffa40f', '[\"*\"]', '2026-04-18 01:47:40', NULL, '2026-04-16 18:25:36', '2026-04-18 01:47:40'),
(25, 'App\\Models\\User', 2, 'auth_token', 'b8685392aec133b8663108ab6f362b8b369edef066dbcd1c9c6711cd722c4721', '[\"*\"]', '2026-04-25 10:02:05', NULL, '2026-04-16 18:28:00', '2026-04-25 10:02:05'),
(26, 'App\\Models\\User', 1, 'auth_token', 'b3061928aa4d05d802854002fb35cacd8b208e5515dac689c279699ce9e03fac', '[\"*\"]', '2026-04-23 11:38:27', NULL, '2026-04-23 11:13:43', '2026-04-23 11:38:27'),
(28, 'App\\Models\\User', 1, 'auth_token', 'f4226b240cf4aa6fe18fe7b4d03ee896fc77bbb2a77f3ecf173ec81fc33f3cd4', '[\"*\"]', '2026-04-23 11:27:39', NULL, '2026-04-23 11:27:39', '2026-04-23 11:27:39'),
(30, 'App\\Models\\User', 3, 'auth_token', 'd6a6f49dd10121a7eccb43032fd609b581aa74eca70d460cf0b4c7d20e1d0c68', '[\"*\"]', NULL, NULL, '2026-04-24 11:10:05', '2026-04-24 11:10:05'),
(31, 'App\\Models\\User', 4, 'auth_token', 'c3ce7ff30ed51aee4f852fecd380dc83a0b89244cf625f0ae41e5a78c34a367a', '[\"*\"]', NULL, NULL, '2026-04-24 11:10:47', '2026-04-24 11:10:47'),
(35, 'App\\Models\\User', 1, 'auth_token', '3004831a1172dce629db078723311b39aaf5b9f7106245cdbf0050d8e12bb83c', '[\"*\"]', '2026-04-25 14:07:33', NULL, '2026-04-25 14:05:51', '2026-04-25 14:07:33'),
(36, 'App\\Models\\User', 2, 'auth_token', '80c95cd8cb36623f6f1bde88327b7c86a1a6e465b9a015d1a5ae6b5a2ccf6f89', '[\"*\"]', '2026-08-02 04:19:53', NULL, '2026-04-25 14:40:41', '2026-08-02 04:19:53'),
(37, 'App\\Models\\User', 2, 'auth_token', 'e3003e7ae362032d950a99d478a1c745699ea422b4bd5a193f317249075230d1', '[\"*\"]', '2026-04-27 22:53:34', NULL, '2026-04-27 22:24:12', '2026-04-27 22:53:34'),
(38, 'App\\Models\\User', 2, 'auth_token', '5c196b4d2f40733e0c2e1d16cd8952803e48acd9b6dceb697075fceeeb2e9add', '[\"*\"]', NULL, NULL, '2026-04-27 22:37:14', '2026-04-27 22:37:14'),
(39, 'App\\Models\\User', 1, 'auth_token', '577811ec5a5a0fc55ee9095eae9de6334ee2bf9e4a634c6b6e60d2e69e95d591', '[\"*\"]', '2026-04-27 22:49:04', NULL, '2026-04-27 22:47:47', '2026-04-27 22:49:04'),
(40, 'App\\Models\\User', 1, 'auth_token', '2173cf48fb6a688dd8f0618d749fdf6575cd1cbc594fe6dae350d28dd352a93f', '[\"*\"]', '2026-04-27 22:50:33', NULL, '2026-04-27 22:50:19', '2026-04-27 22:50:33'),
(41, 'App\\Models\\User', 2, 'auth_token', 'c6c5f2df432fe94b9d49ae1fb217fa11605f99e05554fb9a07cdfd47ab2c3db2', '[\"*\"]', NULL, NULL, '2026-04-27 22:55:27', '2026-04-27 22:55:27'),
(42, 'App\\Models\\User', 2, 'auth_token', '37feaba180ebb3acc1829d4a9acade1d81a6a489409af59771978d97f625b484', '[\"*\"]', NULL, NULL, '2026-04-28 12:57:20', '2026-04-28 12:57:20'),
(43, 'App\\Models\\User', 1, 'auth_token', '7659d4a578c601988e6a8d867fe8b75dcc5029a7456093bf4f7c45a6f9924311', '[\"*\"]', '2026-04-28 14:03:29', NULL, '2026-04-28 14:03:28', '2026-04-28 14:03:29'),
(44, 'App\\Models\\User', 1, 'auth_token', '8967ba4b821ed22a70dea73c66b17b67fd3d4cffaf4715a3dcc1fbcf929c3ee1', '[\"*\"]', '2026-05-01 21:48:52', NULL, '2026-05-01 21:44:37', '2026-05-01 21:48:52'),
(45, 'App\\Models\\User', 1, 'auth_token', 'd44f727c8905b80323503fd731327174240dd5a966f198ee2fb86723076e1fc4', '[\"*\"]', '2026-05-04 11:49:54', NULL, '2026-05-04 11:37:16', '2026-05-04 11:49:54'),
(46, 'App\\Models\\User', 2, 'auth_token', '4c3414f159ad3d674f944416ab006b68deefce11e06f16963ddb943fb61988a4', '[\"*\"]', NULL, NULL, '2026-05-06 12:24:56', '2026-05-06 12:24:56'),
(47, 'App\\Models\\User', 1, 'auth_token', '35b23a41e0fa2874e9723c750af1a803652ae958964881e591a08ae4cc16304e', '[\"*\"]', '2026-05-06 21:35:30', NULL, '2026-05-06 21:35:11', '2026-05-06 21:35:30'),
(48, 'App\\Models\\User', 1, 'auth_token', '08938db75652eb516e98e4c71805be40f373548c6b2826ab8a0cfa637c2723e0', '[\"*\"]', '2026-05-10 05:54:02', NULL, '2026-05-08 12:04:30', '2026-05-10 05:54:02'),
(49, 'App\\Models\\User', 1, 'auth_token', '9a759ab72604d0221c59cec55f12dfa564aea0fdeb5f03ea08696197e2615a52', '[\"*\"]', '2026-05-08 13:18:20', NULL, '2026-05-08 12:17:07', '2026-05-08 13:18:20'),
(50, 'App\\Models\\User', 1, 'auth_token', '2d47690da427b703a23719f62549b105c732205d38211e3bc2aa6aa2db59c5fb', '[\"*\"]', '2026-05-08 12:52:05', NULL, '2026-05-08 12:51:21', '2026-05-08 12:52:05'),
(51, 'App\\Models\\User', 2, 'auth_token', '706ffb769f93c15b9e00d73b6024fa823d8f63bc3016127333e56f339a57f150', '[\"*\"]', '2026-05-09 13:05:24', NULL, '2026-05-08 12:52:45', '2026-05-09 13:05:24'),
(52, 'App\\Models\\User', 1, 'auth_token', 'be04717e5ff056fd4d5cfe1c265ffba390e53faed840d578cd5d88afe4db2e4b', '[\"*\"]', '2026-05-09 07:40:47', NULL, '2026-05-09 07:39:53', '2026-05-09 07:40:47'),
(53, 'App\\Models\\User', 1, 'auth_token', '9254095b554f63f9563b38b92898695c97192d863436dfa96e9ad1375a98a7e3', '[\"*\"]', '2026-05-09 08:03:28', NULL, '2026-05-09 08:03:00', '2026-05-09 08:03:28'),
(54, 'App\\Models\\User', 1, 'auth_token', 'cb909b2eab01e56083565988e09074e267b8ffa4e9f996536540e2663bea94d7', '[\"*\"]', '2026-05-09 14:00:09', NULL, '2026-05-09 12:45:52', '2026-05-09 14:00:09'),
(55, 'App\\Models\\User', 1, 'auth_token', '8972ac15687fb737b4cee85117f8b776971ba721680642a735f5a136fc33948a', '[\"*\"]', '2026-05-09 14:17:51', NULL, '2026-05-09 13:20:11', '2026-05-09 14:17:51'),
(56, 'App\\Models\\User', 5, 'auth_token', '552f4a3bb02d18473b3a6da40b4632dc4136c1eb77014f6c3808581cb6fb2aa0', '[\"*\"]', NULL, NULL, '2026-05-09 14:34:46', '2026-05-09 14:34:46'),
(59, 'App\\Models\\User', 1, 'auth_token', 'aba280aac9b8ca9e0aac7031fb2079c82072db41d21e56686b6e9345a637b47f', '[\"*\"]', '2026-05-10 05:15:32', NULL, '2026-05-10 02:54:50', '2026-05-10 05:15:32'),
(60, 'App\\Models\\User', 2, 'auth_token', '6ffe1c75ad389345cb738ddd322187e40578118714289343563df35480335d2a', '[\"*\"]', '2026-07-05 12:37:52', NULL, '2026-05-10 02:57:31', '2026-07-05 12:37:52'),
(61, 'App\\Models\\User', 1, 'auth_token', 'a78e63d2f6fee34c4dfe30ba142664b09cfd76fc2aa07e0b5d6da69219f653d9', '[\"*\"]', '2026-05-10 06:55:26', NULL, '2026-05-10 03:10:16', '2026-05-10 06:55:26'),
(62, 'App\\Models\\User', 2, 'auth_token', '0aad3f577a790d7bb606054020a9e4be6b13f681982b01e2600a255dcf9cd805', '[\"*\"]', NULL, NULL, '2026-05-10 06:58:57', '2026-05-10 06:58:57'),
(63, 'App\\Models\\User', 6, 'auth_token', '63089507d1a56e206de397c04f15be2bfa23986a8720f57eae949330075a0d01', '[\"*\"]', NULL, NULL, '2026-05-17 01:09:28', '2026-05-17 01:09:28'),
(64, 'App\\Models\\User', 6, 'auth_token', '6abc9a68005cd62cedf9671dfb9667787743fbf676e8286326fbc0ecc829f1d3', '[\"*\"]', '2026-08-02 05:10:00', NULL, '2026-05-17 01:09:41', '2026-08-02 05:10:00'),
(65, 'App\\Models\\User', 1, 'auth_token', '4f519a5738e5f42248ee73904f73ea5747779af104e2b9ec12adaebd0bfdfbec', '[\"*\"]', '2026-05-23 12:54:17', NULL, '2026-05-23 12:21:38', '2026-05-23 12:54:17'),
(66, 'App\\Models\\User', 2, 'auth_token', 'c9208579fb5a7cf94b418e367b565d26723237000df9c7b8ac68d419a77af2e7', '[\"*\"]', '2026-05-24 23:55:24', NULL, '2026-05-24 06:35:25', '2026-05-24 23:55:24'),
(67, 'App\\Models\\User', 1, 'auth_token', 'd6699534b12ae3d45e9caecbf2e39e1337a4868847a7d0785ea73cb46694e30a', '[\"*\"]', '2026-05-24 06:52:20', NULL, '2026-05-24 06:49:55', '2026-05-24 06:52:20'),
(68, 'App\\Models\\User', 1, 'auth_token', 'b1f5b24c193a4805bf4745d2160d1ac02d314e6d0d73ff567ea23cb2660e828a', '[\"*\"]', '2026-05-24 22:01:04', NULL, '2026-05-24 22:00:55', '2026-05-24 22:01:04'),
(69, 'App\\Models\\User', 1, 'auth_token', '5a1fba86cd1c91887cc9a181b7246a3f6633ff8fffa9773d4af1359af84ab57a', '[\"*\"]', '2026-05-26 00:08:51', NULL, '2026-05-26 00:05:16', '2026-05-26 00:08:51'),
(70, 'App\\Models\\User', 1, 'auth_token', '881a18003f220fba2e285ce506443f1d53ea11333d3c9a349e2c9cf9535378fc', '[\"*\"]', '2026-05-28 13:04:29', NULL, '2026-05-28 13:03:46', '2026-05-28 13:04:29'),
(72, 'App\\Models\\User', 1, 'auth_token', '6514109b454688c81e72f353a838f70d260b7854a005a6944ed405ef3501bcab', '[\"*\"]', '2026-05-28 13:13:19', NULL, '2026-05-28 13:10:04', '2026-05-28 13:13:19'),
(73, 'App\\Models\\User', 1, 'auth_token', '38c69f29cd6d29dafb47384bafc988198d939e42d325fa3f6dbe84c00baac223', '[\"*\"]', '2026-06-03 13:39:41', NULL, '2026-06-03 13:36:58', '2026-06-03 13:39:41'),
(74, 'App\\Models\\User', 1, 'auth_token', 'f29a35e5423a35a621cc72e81deb4d40ed24a6f96075ae71e604dec6a6414177', '[\"*\"]', '2026-06-05 05:47:55', NULL, '2026-06-05 05:47:13', '2026-06-05 05:47:55'),
(75, 'App\\Models\\User', 1, 'auth_token', '96a6f14e83465208d8996188f557bdd20bce02c0b77fd724eff18a2ce093b6ac', '[\"*\"]', '2026-06-05 05:50:59', NULL, '2026-06-05 05:49:49', '2026-06-05 05:50:59'),
(76, 'App\\Models\\User', 7, 'auth_token', '8911a3bd8f3285d75c69040ec9b02e94b438230380f4763a40a49011bdc6f3c7', '[\"*\"]', NULL, NULL, '2026-06-12 23:01:16', '2026-06-12 23:01:16'),
(77, 'App\\Models\\User', 8, 'auth_token', '58d9afa9147b3504d01311901cc0e99b746b78c6ac5378dc8eb32584049d14da', '[\"*\"]', NULL, NULL, '2026-06-13 02:43:18', '2026-06-13 02:43:18'),
(78, 'App\\Models\\User', 8, 'auth_token', '1d1f98a983171d7f085e2b87c73e0813af9f6f8440c520d854f77bbca8f0cd72', '[\"*\"]', '2026-06-13 02:47:05', NULL, '2026-06-13 02:43:33', '2026-06-13 02:47:05'),
(79, 'App\\Models\\User', 8, 'auth_token', '6d9b0528b0c9bb713dc1a0b7bb08c3d1bc4e3387d90f44bc3482887b22fc588d', '[\"*\"]', '2026-06-13 06:15:42', NULL, '2026-06-13 06:07:58', '2026-06-13 06:15:42'),
(80, 'App\\Models\\User', 9, 'auth_token', 'efa341ff1bf2be96643fc6d6e839e8ac14a466d6160add790ba2a5086841ccdf', '[\"*\"]', NULL, NULL, '2026-06-22 13:37:52', '2026-06-22 13:37:52'),
(81, 'App\\Models\\User', 9, 'auth_token', '60951472d9536eebc68a422a774cc26b110fd0080d22930953b34ff9e4fb5ab9', '[\"*\"]', '2026-06-22 13:40:49', NULL, '2026-06-22 13:38:11', '2026-06-22 13:40:49'),
(82, 'App\\Models\\User', 10, 'auth_token', '5b2c9df009b33c5d5878db5fc7a8abbc1ed916ab7182541953e3738fdac6e2a5', '[\"*\"]', NULL, NULL, '2026-06-27 05:25:50', '2026-06-27 05:25:50'),
(83, 'App\\Models\\User', 10, 'auth_token', '4a5936fe2ced49eedf8216a3f9d7255d4ecd9d9d77a2ccebb5ac0ece755fab2d', '[\"*\"]', '2026-07-31 05:16:44', NULL, '2026-06-27 05:26:10', '2026-07-31 05:16:44'),
(85, 'App\\Models\\User', 1, 'auth_token', 'd093ef692a136de23f1a18e64f22d7b7da25ba98c380ebf3a99f2337b785d691', '[\"*\"]', '2026-06-28 11:41:02', NULL, '2026-06-28 08:55:30', '2026-06-28 11:41:02'),
(86, 'App\\Models\\User', 1, 'auth_token', '4ab77fdc86de024e236e45942322bddd4c03739cba0b30c53d029077bd9a45c3', '[\"*\"]', '2026-06-29 11:54:06', NULL, '2026-06-29 11:43:27', '2026-06-29 11:54:06'),
(87, 'App\\Models\\User', 1, 'auth_token', '4c557947d3709398944a143af1733b4eb3f8d8c16674faa944a4aea77223d7db', '[\"*\"]', '2026-07-01 13:41:44', NULL, '2026-07-01 13:37:18', '2026-07-01 13:41:44'),
(88, 'App\\Models\\User', 1, 'auth_token', 'd5d060daa932c39e9e7284b039b5c37c0a6bc73b0a3d08f1252f4ad50c544fe0', '[\"*\"]', '2026-07-04 02:55:34', NULL, '2026-07-04 02:52:15', '2026-07-04 02:55:34'),
(89, 'App\\Models\\User', 1, 'auth_token', 'c852f31de76cc3dcb68fa5188fabad39976f9f799429df879c910a711493426c', '[\"*\"]', '2026-07-04 02:53:42', NULL, '2026-07-04 02:52:25', '2026-07-04 02:53:42'),
(90, 'App\\Models\\User', 1, 'auth_token', '8a60ae1220f2ed9f99bf82a966d906a886c9e0715cf57d6804aefd74ca320769', '[\"*\"]', '2026-07-04 12:24:13', NULL, '2026-07-04 12:05:47', '2026-07-04 12:24:13'),
(91, 'App\\Models\\User', 1, 'auth_token', '3dc36fcafecad7e6c6f5dab46c5c61b4718c4e98243c385dbccf782725dbbdc7', '[\"*\"]', '2026-07-04 12:19:25', NULL, '2026-07-04 12:19:25', '2026-07-04 12:19:25'),
(93, 'App\\Models\\User', 1, 'auth_token', '59f63a062c56ce6b61d6b8f13276942e25bc827eab1bf6b11c5c4fe791a0c8c2', '[\"*\"]', '2026-07-05 13:00:18', NULL, '2026-07-05 09:58:53', '2026-07-05 13:00:18'),
(95, 'App\\Models\\User', 1, 'auth_token', 'c4a01e324ac3940b053c19044c62285271a09569a53f982befcf577de1e955d8', '[\"*\"]', '2026-07-05 11:13:00', NULL, '2026-07-05 10:57:15', '2026-07-05 11:13:00'),
(96, 'App\\Models\\User', 8, 'auth_token', 'b1a1e3d320594eae2d9a3fbf3ef17fa1410a2398cfb55054d5a2452d91d84b1a', '[\"*\"]', NULL, NULL, '2026-07-05 11:53:26', '2026-07-05 11:53:26'),
(97, 'App\\Models\\User', 1, 'auth_token', '7a7a39374ea23145f438cc9ded1c1dd15d1adf145ea92715b89c8a2d59d737a1', '[\"*\"]', '2026-07-05 12:42:13', NULL, '2026-07-05 12:08:18', '2026-07-05 12:42:13'),
(99, 'App\\Models\\User', 2, 'auth_token', '8890336bf103353c7a0543f9f83920639e96cea2620a4e9c1cb21089888cb28d', '[\"*\"]', '2026-07-05 12:48:48', NULL, '2026-07-05 12:13:27', '2026-07-05 12:48:48'),
(100, 'App\\Models\\User', 2, 'auth_token', 'fbc94c87e0b9d71c504f1cf413e13ab54f2707195db10614a29c3e7ef31fa220', '[\"*\"]', '2026-08-02 05:12:58', NULL, '2026-07-05 12:49:04', '2026-08-02 05:12:58'),
(101, 'App\\Models\\User', 8, 'auth_token', 'cff99060a06dc5537a31814748e2c700bfb3e003a0a999cb058f569be654f71c', '[\"*\"]', '2026-08-02 05:06:08', NULL, '2026-08-02 05:05:40', '2026-08-02 05:06:08');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subcategory_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tag_line_1` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `tag_line_2` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `caffeine` varchar(255) DEFAULT NULL,
  `collection` text DEFAULT NULL,
  `image_1` varchar(255) DEFAULT NULL,
  `image_2` varchar(255) DEFAULT NULL,
  `image_3` varchar(255) DEFAULT NULL,
  `image_4` varchar(255) DEFAULT NULL,
  `image_5` varchar(255) DEFAULT NULL,
  `ingredients` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`ingredients`)),
  `faqs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`faqs`)),
  `brewing_rituals` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`brewing_rituals`)),
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `subcategory_id`, `tag_line_1`, `name`, `slug`, `tag_line_2`, `description`, `caffeine`, `collection`, `image_1`, `image_2`, `image_3`, `image_4`, `image_5`, `ingredients`, `faqs`, `brewing_rituals`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Bold, Fragrant and Comforting', 'Kashmiri Kahwa', 'kashmiri-kahwa', 'A REGAL BREW OF SAFFRON, SPICES & GREEN TEA', 'Rooted in the traditions of the Kashmir Valley, this kahwa features a fine Assam green tea base infused with saffron, nuts, and warming spices. A delicately spiced, aromatic blend made for slow sips and quiet reflection - rich in heritage and flavour.\r\n\r\nSourced from select Indian gardens and hand-blended with whole botanicals - no tea dust, no additives. Just pure ingredients and clean taste in every cup.', 'medium', 'Summer', 'products/gallery/kaKXBISTflRXKoA65AP9EMSwvtM3ipPA4UrPmLHp.png', 'products/gallery/GpAWy2xdPaLH56YKhcv4WRAplEX0Kooxy9yDtea9.png', 'products/gallery/rz60Xs7AcHvxfnPGunRG1emxp0yqLYICMpYd3uMy.png', 'products/gallery/SlrZBfqI5RswMcBeR3dT1nO5s2OuqfilFn2MfzF3.png', 'products/gallery/AMqcXFlbcEHbHwrjpfmsByZMnlYcUJ2L0ZutFJOk.png', '[{\"name\":\"Chamomile Flower\",\"image\":\"products\\/ingredients\\/w5NJohXlnC26M4prZDfuRgaoTdUW9P8q8gya18cf.avif\"},{\"name\":\"Chamomile Flower 1\",\"image\":\"products\\/ingredients\\/kC3ZaT1qXOKBxo54uyhOq0Ho9cAxY52Zy7Vw3AM1.avif\"}]', '[{\"question\":\"Deepak Kaha he api ?\",\"answer\":\"Need Answer ASAP\"},{\"question\":\"FAQs testing\",\"answer\":\"Yes\"}]', '{\"hot_brew\":[{\"ritual\":\"1 Tsp \\/ 2 g\",\"image\":\"products\\/rituals\\/bKRtQ49Zuz8WZztDJEi8zzdVxaGLtL4gDZ1e7EY4.svg\"},{\"ritual\":\"testing 1\",\"image\":\"products\\/rituals\\/7GLc9Ho914bFQYUQXQxqBCEbZOzBZNaJvvuWKeO4.svg\"},{\"ritual\":\"wait\",\"image\":\"products\\/rituals\\/LKf5lc67zA9LMueumzvO7BmLgwW1sy9QVDZWNbOy.png\"}],\"iced_brew\":[{\"ritual\":\"1 Tsp \\/ 2 g\",\"image\":\"products\\/rituals\\/RBjzzLZydyEbaKwceZlRbBC1lEBc8H9DsarGCPZ7.png\"},{\"ritual\":\"2 KKPadjfskdjfsdjkhfks dhfhsdfhasdjhfsdfkhsdjfsd jkfsdfsdfhsgdjfgsdjhfgjsdhgfjahsdgf hsdgfjhsdfjasdh\",\"image\":\"products\\/rituals\\/4T3z03IX0GZ4YOBmMYwgAI93hCAzaOEm7H3WRK0A.svg\"}]}', 1, '2026-04-12 20:30:27', '2026-07-01 13:41:44'),
(2, 1, 2, 'Bold, Fragrant and Comforting', 'Tester pack', 'tester-pack', 'A REGAL BREW OF SAFFRON, SPICES & GREEN TEA', 'this is a Rs 1 tester pack', 'low', 'Summer', 'products/gallery/bp0OQ0DH0DNnYJOjKjKroSlkEXKAHJoCAqd5EAU9.png', NULL, NULL, NULL, NULL, '[]', '[]', '[]', 1, '2026-05-09 13:24:27', '2026-05-09 13:24:27');

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `sku` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `discount_price` decimal(10,2) DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `brewing_rituals` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`brewing_rituals`)),
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `name`, `sku`, `price`, `discount_price`, `weight`, `brewing_rituals`, `is_default`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '50 cups', '1212', 699.00, 749.00, '100 g', '[{\"ritual\":\"1 Tsp \\/ 2 g\",\"image\":\"products\\/rituals\\/bKRtQ49Zuz8WZztDJEi8zzdVxaGLtL4gDZ1e7EY4.svg\"},{\"ritual\":\"1 Tsp \\/ 2 g\",\"image\":\"products\\/rituals\\/RBjzzLZydyEbaKwceZlRbBC1lEBc8H9DsarGCPZ7.png\"}]', 1, 1, '2026-04-12 20:30:27', '2026-07-01 13:41:44'),
(2, 1, '30 cups', '2501', 899.00, NULL, '60g', '[]', 0, 1, '2026-04-15 01:11:58', '2026-07-01 13:41:44'),
(3, 2, '1 bag', '001', 1.00, 49.00, '1.2', '[]', 1, 1, '2026-05-09 13:24:27', '2026-05-09 13:30:02');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `variant_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `review` text DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `variant_id`, `user_id`, `order_id`, `order_item_id`, `rating`, `title`, `review`, `status`, `created_at`, `updated_at`) VALUES
(2, 2, 3, 2, 18, 20, 5, 'Maja aagay', 'mast tea he.', 'approved', '2026-07-05 12:50:30', '2026-07-05 13:00:18');

-- --------------------------------------------------------

--
-- Table structure for table `review_images`
--

CREATE TABLE `review_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `review_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `sort_order` smallint(5) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `review_images`
--

INSERT INTO `review_images` (`id`, `review_id`, `image_path`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 2, 'reviews/m9saDTW8UfREsTG6eKMS2Kq65cSHDBKPZrMibfNn.png', 0, '2026-07-05 12:50:30', '2026-07-05 12:50:30'),
(2, 2, 'reviews/BLz7u9BxZpbDg0PMSnKLTcRDFbOzwzMFJlyFIOfy.png', 1, '2026-07-05 12:50:30', '2026-07-05 12:50:30'),
(3, 2, 'reviews/Yd1XwFDDqY2SRl9fD9I7R7mFc1QAHrEeiVZFD3cX.png', 2, '2026-07-05 12:50:30', '2026-07-05 12:50:30'),
(4, 2, 'reviews/gV5teLOCrq3bzujGOnRTFyrVuvwJefgp1cVMDSns.png', 3, '2026-07-05 12:50:30', '2026-07-05 12:50:30'),
(5, 2, 'reviews/XTywrXl3HudB7m1prTVmu3Q4uFmeG6REIJN4X7rm.png', 4, '2026-07-05 12:50:30', '2026-07-05 12:50:30'),
(6, 2, 'reviews/F0o5ScLaQluWuLfZ6lQfR9GHQ3WrQ2CNuBBEklwO.png', 5, '2026-07-05 12:50:30', '2026-07-05 12:50:30');

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
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1);

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
('0DHN9p4Njo2glhiOQsD0YnStqWW3FqztwiKHx4Lb', NULL, '58.84.60.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUWFyeGJhM1VwR3RVQnlJTE51UUh2QkZ3bmhvOGVITGNzRjd5VkRtRiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvZ2FsbGVyeS9icDBPUTBESDBETm5ZSk9qS2pLcm9TbGtFWEtBSEpvQ0FxZDVFQVU5LnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664317),
('14O92lL6KPcDWtCJCUiE37EIIn9YsRu8PqUoUgAU', NULL, '49.43.0.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieU9JMnNodFBmY1ZUdFFzT1dkeER5YWVOVGd3RzhDSzdKZnpMdE0wWCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODc6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvYmxvZy9kZnBLc2w4bWd1UWxBTXZ3SGMyWDBTelVpd05zUGpONTN3UGdqQk5OLnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664345),
('1O7DaZGoOj85Xywv0kyMNy0yO0PfNUh5gwxc02VS', NULL, '58.84.60.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ2pBanRqM3RZWlE1a1VpSnU2VjFYMHd0MWJFWUZZajFSM3dGc24yZCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvZ2FsbGVyeS9TbHJaQmZxSTVSc3dNY0JlUjNkVDFuTzVzMk91cWZpbEZuMk1mekYzLnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664429),
('1u9LkdLPtAU10SXEnTfz7rKv4iKnglBnuy5hh8G1', NULL, '106.222.219.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV29ZRmN5d24yb2NhNm9XbkY2UktxSjBrWlI1UEpMQVN4MVBYZERBTCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTY6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvaGVyby1zZWN0aW9ucy9FbEdIM1ZIclFwN3RIZVhGV0ljNjlJbjhzQW1jbmRUM1RFVDVyaHhYLnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785667103),
('2LDBs3dh2xzJmwpL3kpMSftb2ZnhH2jkbulYqJnE', NULL, '106.222.219.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV0p6dkF3NmRRckFhaU1rRU1SMEVRQTVpWXBndVVqZGgyVjJBMk93TCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvZ2FsbGVyeS9icDBPUTBESDBETm5ZSk9qS2pLcm9TbGtFWEtBSEpvQ0FxZDVFQVU5LnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785667107),
('3B9229MQxyk9Xi7l7QbanGTx82ULVBt3XjZ73fGs', NULL, '58.84.60.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOVRGY2d5akdIeFBsVkd0eWFFZVMyYUNueUN4OUVlM1R0dmwzQnlmOCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODc6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvYmxvZy9kZnBLc2w4bWd1UWxBTXZ3SGMyWDBTelVpd05zUGpONTN3UGdqQk5OLnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664318),
('3iBoe8G9gJgT864UyZcKyVFMbCzGchuKGJJs9zck', NULL, '106.222.219.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidkx3VGEwTkhQblRUY3V0alE5M3VCNkRCbUVETWhJYlIyalJNdnNvMCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTY6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvaGVyby1zZWN0aW9ucy93ZUZEWTBZNU9za3NSSVhaVHRLaGFyWkRGanpMZFEwTHgyajY5WDd1LnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785667103),
('4715JHxiejLABpoVPbE8yuUgAnlHFYIxfUYsMqy4', NULL, '58.84.60.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUnBOTFBkNmQ3ZjBheVhSbFpLQVdVZnpMVm0yM1lwcEV0ajNScTlMVCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvcml0dWFscy80VDN6MDNJWDBHWjRZT0JtTVl3Z0FJOTNoQ0F6YU9FbTdIM1dSSzBBLnN2ZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785665192),
('5xY29xjR1QS7SvRYIagEzH6qqqMQxe8utbG0sSLP', NULL, '106.222.219.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM1JmS3g1OEVrQ3N2TXF3R0M2WElhbkNuUXJBVUEwTVNZTmVWcUhpaSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODc6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvYmxvZy9sMU5uV0tDQ2VLZUo3NTZ3V1liMWwzb3M3Mno5UGJCcjFLekZoMmtELnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785667103),
('5ZykdBVHusBnK6sO4MUA1PQJ9VUD3XRg57dZyrKd', NULL, '58.84.60.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoielZvaHB0YkRIa1RlSExCS05yWndNdGxUQU1RWEZtdVBqOXpZajRpSSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTA0OiJodHRwczovL3RrYy52b2x5bW9seS5jb20vbWVkaWEvcHVibGljL3Byb2R1Y3RzL2luZ3JlZGllbnRzL2tDM1phVDFxWE9LQnhvNTR1eWhPcTBIbzljQXhZNTJaeTdWdzNBTTEuYXZpZiI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785665535),
('68YDMkeOh5MxkvHaG1cZg41Ln0Tv1CLIseyo5Gvu', NULL, '106.222.219.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVDJMMEh4bHZkekd0ajVJODZERlZ3M3IyRzl6SmdQOFpGSTFINlJOViI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvZ2FsbGVyeS9yejYwWHM3QWNIdnhmblBHdW5SRzFlbXhwMHlxTFlJQ01wWWQzdU15LnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785667203),
('6jgLVTb9tn2fMFcAXhHLM9PqyT4ijBHtxwbfpBVn', NULL, '106.222.219.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZWFSVHo1dGt4eWp2SkY4Uk00bVNpZlI3MFpvSnlTOExIcHVMeDNPQyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvcml0dWFscy80VDN6MDNJWDBHWjRZT0JtTVl3Z0FJOTNoQ0F6YU9FbTdIM1dSSzBBLnN2ZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785667221),
('8vYoaobzRlt45ikdJiokhQPjLsMOAKIrPE47sbYI', NULL, '106.222.219.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibld0UFVIUkhaN2NqVFYzekJqQldHWkNNdVpFTU80SEdESDFiZ2gxTiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTA0OiJodHRwczovL3RrYy52b2x5bW9seS5jb20vbWVkaWEvcHVibGljL3Byb2R1Y3RzL2luZ3JlZGllbnRzL2tDM1phVDFxWE9LQnhvNTR1eWhPcTBIbzljQXhZNTJaeTdWdzNBTTEuYXZpZiI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785667223),
('aXFtuIsV7a9UItDhvhfiYxgXXvYje6V5yPEnXbx0', NULL, '106.222.219.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRXBiYWE4R1djd3pRUWRWRk1qWUZuTGdlWENtN0p0MnpHaGFjMENxTCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODc6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvYmxvZy9kZnBLc2w4bWd1UWxBTXZ3SGMyWDBTelVpd05zUGpONTN3UGdqQk5OLnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785667103),
('AXrJI6OgwNMnmaGHf1ukGMN1frMz3OkpdL8xdbL0', NULL, '58.84.60.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVVFLTURNaGdsRDVsU2Q4cUludTFGM0N5RGRCVHlWdjJSTWVRQTBWUSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODc6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvYmxvZy9sMU5uV0tDQ2VLZUo3NTZ3V1liMWwzb3M3Mno5UGJCcjFLekZoMmtELnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664317),
('b7JsPf8XcvWYZ55xaCWFe49ADwq6UeFc13RpM0Bk', NULL, '49.43.0.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT3FJNW45ZFllbFV1ZnpXWGlaVnhsekdldHRGSFJwNGhTMWxYOHVsRyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTY6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvaGVyby1zZWN0aW9ucy9VY3lDbVE4Q3lydFRzQ1pjTGJ4bHY3NTBTeXhuNExPdkpldkExYVhFLnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664344),
('bE06Ti6OsLuynGUQCA4dcdoLdgpoAIe5mJ3zU6sD', NULL, '58.84.60.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ010Uk8zTHZmeVJYN29mb0dKMkVLY2x0YVNRa0pQZVpWVTZhbERFNCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvcml0dWFscy9SQmp6ekxaeWR5RWJhS3djZVpsUmJCQzFsRUJjOEg5RHNhckdDUFo3LnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785665192),
('BOLVPU4ktLBBupvdz4lZATK5bjzPbZUOUMkCSJxL', NULL, '106.222.219.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZmY4OWRuem43OGxQekwxZnk0b09aR0NvMm1VS0E5aUFQWTlOcllrWCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvcml0dWFscy83R0xjOUhvOTE0YkZRWVVRWFF4cUJDRWJaT3pCWk5hSnZ2dVdLZU80LnN2ZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785667221),
('Cuo05aH2dTgDtcJGBMvRu8p4n6Jjq6qMqwv2KZTr', NULL, '49.44.86.139', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZktHbXZKZmx5NkQ4R1A5eU8wd1Q0QnduTlFsT21RRWtqUUFkUzNqTSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTg6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvbG9nby9MT0dPX1RLQy0wMS5wbmciO3M6NToicm91dGUiO3M6MTI6Im1lZGlhLnB1YmxpYyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1785661267),
('dBRJCAkHTdjZh8Nt8ZAb2VIFScGfL3BRuUPYdYUs', NULL, '58.84.60.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOUduZ0x5VUkxbXdSdlRIbWNYM09PTm1yNjJqOG14S1d0bllMUEVLVSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvZ2FsbGVyeS9BTXFjWEZsYmNFSGJId3JqcGZtc0J5Wk1ubFljVUoyTDBadXRGSk9rLnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664429),
('DGGpOfy27BTSmE8kKEchLPKKPacz9QxXuSCUAW1Z', NULL, '106.222.219.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRDZzUnFtaVRBMzVlclpUR0JUV09jUnRBTHY2S0h4R040dzJJWm80YyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvcml0dWFscy9SQmp6ekxaeWR5RWJhS3djZVpsUmJCQzFsRUJjOEg5RHNhckdDUFo3LnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785667221),
('dOsTl3X07rZUzKTW29dCqzcii5CoOxw0hxg4JrmM', NULL, '58.84.60.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMGtJSmp2RFFScXNiUjc3cG81UjFiVjlYQldvelpTalc2S09RQkRDQyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvZ2FsbGVyeS9rYUtYQklTVGZsUlhLb0E2NUFQOUVNU3d2dE0zaXBQQTRVclBtTEhwLnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664317),
('frmQNUlrF5VWjQAplfJsrLlQ7y8hz5adf3ArHOPt', NULL, '58.84.60.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiamdubTVSNnJrdkdpT29uT3lndkJwQjAxWTNJSTNOd0UyTEhNMlBHdCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTA0OiJodHRwczovL3RrYy52b2x5bW9seS5jb20vbWVkaWEvcHVibGljL3Byb2R1Y3RzL2luZ3JlZGllbnRzL3c1TkpvaFhsbkMyNk00cHJaRGZ1Umdhb1RkVVc5UDhxOGd5YTE4Y2YuYXZpZiI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785665535),
('GLnYz3Prdjk6ZV5O1m0QWMEXYWgjXxsj6TpV8ddf', NULL, '49.43.0.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidXFzTWluakxlNWN1S01IU2hQdjVhakJubjNjMHhRUDlXN082RVZKcSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvZ2FsbGVyeS9icDBPUTBESDBETm5ZSk9qS2pLcm9TbGtFWEtBSEpvQ0FxZDVFQVU5LnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664345),
('GMQWtQ5LHNl5FK0MFEPP34QHA5ywVXvRz43xe0hw', NULL, '106.222.219.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQTd2VUV5emJOWEVtem9hRlZnZElySUpyMHhyeGxiOFlDQzNXYTFCRiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvZ2FsbGVyeS9TbHJaQmZxSTVSc3dNY0JlUjNkVDFuTzVzMk91cWZpbEZuMk1mekYzLnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785667203),
('HHKILyFwmKAQTTaDlx0iFkEfumNoBEBRu9xt57UB', NULL, '49.43.0.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWG1nOWhPcWk0ekVCS1g5MlhVWlZYODZIc0JORjFBWk10aVdHYjZMTiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTc6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvbG9naW4vbG9naW5faW1nLnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785661257),
('hvI3HVsvlFFV5fCWyD042UmdvWl3ER4sYQdEunmw', NULL, '49.43.0.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ0ljWFhKaXN1dFU4UkNLblBMa1ZPakRQZUZsZFBnR0NTQ2RrUm82ZSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODc6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvYmxvZy9qcDhGa0dWOWlzUTdxbWphaGVwQWppM2J5M0ZWR3lnN0ZNemdtWXk3LnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664345),
('HwKuhQkNF5OyfSVVGZQaLOGy9dAboK4QqePyBkha', NULL, '58.84.60.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU2pER3M3NGdKaFNQSGxJb2xieU1tSmxKUlVNY0xUWTJWZDNJUUJaWCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTY6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvaGVyby1zZWN0aW9ucy93ZUZEWTBZNU9za3NSSVhaVHRLaGFyWkRGanpMZFEwTHgyajY5WDd1LnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664316),
('i7watjFXfgCBo4zg9STVLYlWCShDmuoh8hNbizrg', NULL, '49.43.0.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQnpWajJ4eFRFRW9tam10aEx1MlJmZVMwTjlXenN6Z0Q2cmNra0FqMiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvZ2FsbGVyeS9HcEFXeTJ4ZFBhTEg1NllLaGN2NFdSQXBsRVgwS29veHk5eUR0ZWE5LnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664346),
('I7xE5RpxRm5yj5GKFjqJ7p5UNgoeYAKuEbYx8MbL', NULL, '182.79.253.136', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNTlRRFVOMWlOb2xxaVgxTDZiS3FFMzFqd0haSnZsQk04UEd2a0lzYSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTg6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvbG9nby9MT0dPX1RLQy0wMS5wbmciO3M6NToicm91dGUiO3M6MTI6Im1lZGlhLnB1YmxpYyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1785661262),
('iNihwNyxLtImKWoZtczHTTZFJI00NlicD44ARhsM', NULL, '106.222.219.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ05GOUE3UTl2RDNOeXh2Vndjcm5TM01Qd0R3UXd5aG94UXFlRHd6dSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvZ2FsbGVyeS9BTXFjWEZsYmNFSGJId3JqcGZtc0J5Wk1ubFljVUoyTDBadXRGSk9rLnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785667204),
('j83739YsW3Z2UMGCndBSsHJnduncxKYKHDbFE8l0', NULL, '103.86.176.233', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/148.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVUVwWkRsV0ltS1hvMGEwQ3lZWnFwbzRlNTVMTE1PTGtsQWNGNHVJVyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTg6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvbG9nby9MT0dPX1RLQy0wMS5wbmciO3M6NToicm91dGUiO3M6MTI6Im1lZGlhLnB1YmxpYyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1785669399),
('jJ7G1erHNDdCDXlmRM3wOZPIqOhPhDAh6SReP7Td', NULL, '58.84.60.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZUZ6cjNnUk1YZ1phZk1RU1g3Mk81MjZnc2FHU2tYR09pdldsUHh4aiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvZ2FsbGVyeS9yejYwWHM3QWNIdnhmblBHdW5SRzFlbXhwMHlxTFlJQ01wWWQzdU15LnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664429),
('jNI09qHTlvdh76iUwhfpQaulMX1MMJ0CKpSQZvql', NULL, '106.222.219.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN0F2aGVXU2VLQW80Q21oOGlHbXZCaldkc3dxck9keHgzbk9CbGVoayI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvcml0dWFscy9iS1J0UTQ5WnV6OFdaenRESkVpOHp6ZFZ4YUdMdEw0Z0RaMWU3RVk0LnN2ZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785667221),
('jZdMeea3z06ULPtYmluwz950E6sFAyzr7hI3cJZq', NULL, '58.84.60.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibzNSRGFVRk9jTFZWdXl0UnVVZGFWSEJZRUN4dEdJdjNUcFJSSGRncyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTY6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvaGVyby1zZWN0aW9ucy9FbEdIM1ZIclFwN3RIZVhGV0ljNjlJbjhzQW1jbmRUM1RFVDVyaHhYLnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664316),
('KQL0YMO6Tcd6AtlKWhBiVzniCduBXPVkTwEiCiii', NULL, '106.222.219.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoickFIVnVLc3VPcHlLeXFLdU5VM0dIWEl2RlFONWV5a1hoN3pIcUhmeiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvZ2FsbGVyeS9HcEFXeTJ4ZFBhTEg1NllLaGN2NFdSQXBsRVgwS29veHk5eUR0ZWE5LnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785667108),
('kRIDgtSQxxR4IcyUDvZoLvgr91g2dCiKLqR7P7EE', NULL, '106.222.219.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTnlGU2NlV01QOTczUHhnand2TzhaOTA4SmJ1bHhmVWVrQUhyb1BxdSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTY6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvaGVyby1zZWN0aW9ucy9Gd25XWU1saVdXUFJVYTJQNEZLVmxGN3dXZWFyMGQ3SlozSjVuZzZHLnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785667103),
('kuVWTsT9Kl6EtVWiKUK5vHdWYUG9R92BqnVMJ3lj', NULL, '49.43.0.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN2xSc3BjQkU0Z3RNU0pWZVdZaUV2b3cwdTVzZnJrS2xMenBEajVVVyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTY6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvaGVyby1zZWN0aW9ucy9SbzJZUEttaERYREJBN1BTdlE3VG1JVGxRelVkc0g5eEg3Y3NpWEdQLnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664345),
('KYCzQmswQ91XVpjJyZnwfbEvRpIM88X06hU9EivI', NULL, '106.222.219.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQ24yd3k4T3pYbkhnWVVlRTNlMzBxb0FrYTRhazVCd2ZYcUlMTkp3RCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTY6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvaGVyby1zZWN0aW9ucy9SbzJZUEttaERYREJBN1BTdlE3VG1JVGxRelVkc0g5eEg3Y3NpWEdQLnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785667103),
('l9PUJlyt94lVBLO6ReMS4FDD8MFYbOPZ3yYAQ4Uh', NULL, '106.222.219.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZWdDUEFnVDc4cXRCQlNMb3RFMk5uaHZydXdVVEhtWDM0R0Jqc0VrbSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvZ2FsbGVyeS9rYUtYQklTVGZsUlhLb0E2NUFQOUVNU3d2dE0zaXBQQTRVclBtTEhwLnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785667107),
('LBY1caSH0ruiIE1pQIBub8oQ4oVD3ncvk6faUx3N', NULL, '153.52.205.205', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/130.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieHBDMFZhQzdSTzNlVTBMb01VQmV5UnhDMUhTUW80cTFOeTJMMUFyUCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvZ2FsbGVyeS9icDBPUTBESDBETm5ZSk9qS2pLcm9TbGtFWEtBSEpvQ0FxZDVFQVU5LnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785656004),
('lk1YilO3SgrMTEf8O2QA3eoqf1JUad8ZXagywTvP', NULL, '58.84.60.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZzhoWUxjWE5ja1JjVFpEMkgyMGx0bHVvbkhIRVBMNUpEQVJYZHRpdCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTY6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvaGVyby1zZWN0aW9ucy9Gd25XWU1saVdXUFJVYTJQNEZLVmxGN3dXZWFyMGQ3SlozSjVuZzZHLnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664316),
('LqyBlyZQaNoqO7VYVwvpmc3OMVHPIj0e4Xg00VW3', NULL, '106.222.219.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiMFFrMllOaHR6UngxM012cXVQODZReUZoa2xpRFMxZ0RRcmtydkV0VCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTY6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvaGVyby1zZWN0aW9ucy9VY3lDbVE4Q3lydFRzQ1pjTGJ4bHY3NTBTeXhuNExPdkpldkExYVhFLnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785667103),
('mTwwDyR3ZKG1wVodD0nB5tR6txLHmRST6blKzvVh', NULL, '49.43.0.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibVFtSW5rV3FHRE14eE5WV3RlZXBIaml6T2N6bDFUTW1PQWkzNzYyaiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvZ2FsbGVyeS9rYUtYQklTVGZsUlhLb0E2NUFQOUVNU3d2dE0zaXBQQTRVclBtTEhwLnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664346),
('nc3kvQfGQ9nsjWGJH4GITqrSz8V0reCtXsBCsIw2', NULL, '58.84.60.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicUFIbGR1bnpPZmJNQVIyYmkyVFRYSHpzOGhTaFNrbmM0QlREZkFQayI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTY6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvaGVyby1zZWN0aW9ucy9VY3lDbVE4Q3lydFRzQ1pjTGJ4bHY3NTBTeXhuNExPdkpldkExYVhFLnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664316),
('NcR81UkrNKvl0ko8qBPHPmdcj5evqMBeHhYxtnp0', NULL, '49.43.0.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSTg1M3ZCMzM3bDBSVFdPU3prWGRlTTlTMzdoeUFqTXZVb3dtbjNubSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvZ2FsbGVyeS9yejYwWHM3QWNIdnhmblBHdW5SRzFlbXhwMHlxTFlJQ01wWWQzdU15LnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664433),
('NROZqA8NO8kKfutD19FtWpyXXeaeHohjlyym2VIW', NULL, '42.106.160.203', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiazZ2Rzlsb2ZwS1g1encxOERsaEVma3hSaHpWVVFwemxvdHYzUnF5dCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTg6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvbG9nby9MT0dPX1RLQy0wMS5wbmciO3M6NToicm91dGUiO3M6MTI6Im1lZGlhLnB1YmxpYyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1785661264),
('RcDftBhZtiYtFfmJR2ci5rQRYjpPZ92XOACE0U17', NULL, '58.84.60.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT2xMV0h5clNvS1lkY2lYbTV6Y29pc3hpUXUxRUh5MWhTYUVSN29adiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvcml0dWFscy9MS2Y1bGM2N3pBOUxNdWV1bXp2TzdCbUxnd1cxc3k5UVZEWldOYk95LnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785665192),
('RV928sxMcIfBMS4LwW9asQgZnBs0TNO1CoUnYc90', NULL, '58.84.60.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZm1jSzgwNW5FNk9WRTFWR2lVVzVjRG50N0lWSloySUphdTRyM0Z4YyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvcml0dWFscy9iS1J0UTQ5WnV6OFdaenRESkVpOHp6ZFZ4YUdMdEw0Z0RaMWU3RVk0LnN2ZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785665192),
('sgc8ppdRNJTTkkl1O2KTlxSTFbH8NotMtguTaxi3', NULL, '49.43.0.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiM3JFaW9GQTdCeGlweTZQenRSQVczeFNKZnNLNEZaM2pObkFCc01kTCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODc6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvYmxvZy9sMU5uV0tDQ2VLZUo3NTZ3V1liMWwzb3M3Mno5UGJCcjFLekZoMmtELnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664344),
('SwLPbpk78WhTnJTxS7q3xEvQkMxivybFnPTT5sVN', NULL, '49.43.0.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYjNzcHlMYWRYZUs0Q3pReWk1S1R3QmhEVlBaSVRsdjVGYmFKUlNMQiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTY6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvaGVyby1zZWN0aW9ucy9Gd25XWU1saVdXUFJVYTJQNEZLVmxGN3dXZWFyMGQ3SlozSjVuZzZHLnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664345),
('SxGH7S46iNKkEtPY2W5VTKqzVovaKouBLbQWYHp3', NULL, '49.43.0.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidnlaaUZKZ2tvMEJxZDR0MDhCZ2JHckswYnFhbWd3bldDUTVFWFdlbiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTY6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvaGVyby1zZWN0aW9ucy9FbEdIM1ZIclFwN3RIZVhGV0ljNjlJbjhzQW1jbmRUM1RFVDVyaHhYLnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664344),
('urkHoHkYOujlLsfBR8osiJRJvOsSXGb4JYGwll9E', NULL, '49.43.0.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTmxqTW1YQU1MMGxKUXpDMDNRVlAyS01rNGQ5dHQwc3BnRGpIV3JjRyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvZ2FsbGVyeS9BTXFjWEZsYmNFSGJId3JqcGZtc0J5Wk1ubFljVUoyTDBadXRGSk9rLnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664433),
('vElTyOs2jdr4YA2jkE3h3hN5urJAVvyQwZ33pyW3', NULL, '58.84.60.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV202cUtOZHlzc1BIeUlneExBMUJBWldtdDhndnN6aFlpV2c5RkhUbSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTY6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvaGVyby1zZWN0aW9ucy9SbzJZUEttaERYREJBN1BTdlE3VG1JVGxRelVkc0g5eEg3Y3NpWEdQLnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664316),
('VFtm8tftwyiO1t99xJtm5IOd4gNiuknIGCbRbyNK', NULL, '106.222.219.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUUNERWJuUFVRSUNjVWZqeUt4YVhqUjNKUG0zV29HNHFsQjFEMVpsNiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvcml0dWFscy9MS2Y1bGM2N3pBOUxNdWV1bXp2TzdCbUxnd1cxc3k5UVZEWldOYk95LnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785667221),
('vt7YseHxJKp12WAvZZVwObZzRltkBJ5ep08TJs8A', NULL, '106.222.219.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibU5EeGV1SzU5TjRmMzBjaDBFaUlvbnBmZEdiNWdieXJXREdBU1dnSCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODc6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvYmxvZy9qcDhGa0dWOWlzUTdxbWphaGVwQWppM2J5M0ZWR3lnN0ZNemdtWXk3LnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785667103),
('wm2VKJDUbTosIoLJAH6jEN7S0OfrM9TKUvjci68t', NULL, '49.43.0.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNkxNeFU5a3dia3FKUnZHajBwOHZNUTUwanNqeUJHbXVmdWFCVVkwciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTY6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvaGVyby1zZWN0aW9ucy93ZUZEWTBZNU9za3NSSVhaVHRLaGFyWkRGanpMZFEwTHgyajY5WDd1LnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664344),
('Y1mBRNGVLGxTLtjbcUQAKUQGY990qY8gq4eKgl29', NULL, '106.222.219.2', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibGpLeVdacjk2RldzUHZJb0pydlhmN0lxNkIydTBYeWtPME5QTElpZSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTA0OiJodHRwczovL3RrYy52b2x5bW9seS5jb20vbWVkaWEvcHVibGljL3Byb2R1Y3RzL2luZ3JlZGllbnRzL3c1TkpvaFhsbkMyNk00cHJaRGZ1Umdhb1RkVVc5UDhxOGd5YTE4Y2YuYXZpZiI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785667223),
('YkgD1qqNj4ZZHJlDXXPANc2xaSCvGh2mpwi7lBYq', NULL, '58.84.60.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTUlJZm16a24yYXgyNzRTdFFuUTZMQWFTZzRRbktBQm9OdGFsWVhaQSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvcml0dWFscy83R0xjOUhvOTE0YkZRWVVRWFF4cUJDRWJaT3pCWk5hSnZ2dVdLZU80LnN2ZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785665192),
('YOwrgNvWAezjJInIV6KI9Tpcmh8Q1hy8f3D5gCVm', NULL, '58.84.60.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiOFhZa2wzZng0eTcwT3p0NXlNREZWUTNORGZmTlBCV3JCZDNYWmliNiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvZ2FsbGVyeS9HcEFXeTJ4ZFBhTEg1NllLaGN2NFdSQXBsRVgwS29veHk5eUR0ZWE5LnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664318),
('z6PnZECX7AQzMnsqQJUhwrpJQCdS4gFyShNH7lfF', NULL, '58.84.60.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicFNRVmFBblQ1Zk93UnVaNjRPcDF4OWJqNHhqanRENk1sdnJ1NHVlZSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6ODc6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvYmxvZy9qcDhGa0dWOWlzUTdxbWphaGVwQWppM2J5M0ZWR3lnN0ZNemdtWXk3LnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664318),
('ZWUD8GTpXpZJO2SjnhTf069M0JYvA00aKvz0wcts', NULL, '49.43.0.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibHBlZWJTT2RkV1JwWTFIamwyZ1NIQjQzb0hYc3FmTTZBcjJLVnZHbCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6OTk6Imh0dHBzOi8vdGtjLnZvbHltb2x5LmNvbS9tZWRpYS9wdWJsaWMvcHJvZHVjdHMvZ2FsbGVyeS9TbHJaQmZxSTVSc3dNY0JlUjNkVDFuTzVzMk91cWZpbEZuMk1mekYzLnBuZyI7czo1OiJyb3V0ZSI7czoxMjoibWVkaWEucHVibGljIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1785664433);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `delivery_phone` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `delivery_phone`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@example.com', '9009255085', NULL, NULL, '$2y$12$xfj/NF41oV9Lchog/G7iXOu4Rc6FdfIk4pjnjsv81.vcpaaivhfwy', NULL, '2026-03-19 13:40:59', '2026-04-06 11:48:10'),
(2, 'Rochak Malviya', 'rochakmalviya@gmail.com', '06265880144', NULL, NULL, '$2y$12$QXvbhZsvfF0hAxhud9JQhujGZEFyUC.TywdiOXGN0Lk6mSdg.A7Nq', NULL, '2026-04-14 02:47:03', '2026-04-25 10:14:12'),
(3, 'Demo User', 'demo@example.com', '9876543210', NULL, NULL, '$2y$12$hXi3T6bGQkkGhhF0PAdgteLOA/Foks6A8p5rys2XA8R0lwCPGvkQy', NULL, '2026-04-24 11:10:05', '2026-04-24 11:10:05'),
(4, 'deepika', 'deepika@gmail.com', '9009255095', NULL, NULL, '$2y$12$eb.ZD5hn2jPcMnutLAK67ugQcZwJ4apcBV5ASaF66ETlOutkfEqY.', NULL, '2026-04-24 11:10:47', '2026-04-24 11:10:47'),
(5, 'billu barber', 'billu@gmail.com', '7776767676', NULL, NULL, '$2y$12$I.Q0qD4Vt1dnozF2p1XI6O8ZpSPCSqsDPqScKBBgmiI8q2qGvZw.6', NULL, '2026-05-09 14:34:46', '2026-05-09 14:34:46'),
(6, 'Ajay Gupta', 'ajaygupta1427@gmail.com', '7000795310', NULL, NULL, '$2y$12$TflHJXDRpBoOBgjYyJjoY.ZnOoWz65Z4hcc9rdYC4R6/TlK7gRzri', NULL, '2026-05-17 01:09:28', '2026-05-17 01:09:28'),
(7, 'Deepak Meena', 'deepakmeena900@gmail.com', '1234567890', NULL, NULL, '$2y$12$BHIOiDONSQU9Nyt6Zzn6j.di/X3uVQjeBYwP/8fZ4U37gLrMPQl.i', NULL, '2026-06-12 23:01:16', '2026-06-12 23:01:16'),
(8, 'Rochak Malviya', 'rochak@gmail.com', '6265880144', NULL, NULL, '$2y$12$7iWiB68ovhKmdFb0lPIuduNSJoBv0fjXcpTbA1vF7tA2TAaSwIbF.', NULL, '2026-06-13 02:43:18', '2026-06-13 02:43:18'),
(9, 'Pranjal Kosta', 'kostapranjal234@gmail.com', '9617036380', NULL, NULL, '$2y$12$GO4CTYhVDkDZxVvQ5eZ6kuJzzGXJA5D92Az8HPzA1SiCKWJGcLNa.', NULL, '2026-06-22 13:37:52', '2026-06-22 13:37:52'),
(10, 'Ajay Gupta', 'ajay@gmail.com', '7000795310', NULL, NULL, '$2y$12$Oc1jP0P7XryQxFTGcfEUiu2Oitx.nXBop08216eirK7pvyn/nKvhy', NULL, '2026-06-27 05:25:50', '2026-06-27 05:25:50');

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(255) DEFAULT NULL,
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

INSERT INTO `user_addresses` (`id`, `user_id`, `label`, `address_line1`, `address_line2`, `city`, `state`, `pincode`, `country`, `is_default`, `created_at`, `updated_at`) VALUES
(2, 2, NULL, '76, Siddhipuram colony, Indore, MP, India', NULL, 'Indore', 'MP', '452009', 'India', 0, '2026-04-14 03:15:33', '2026-04-16 18:25:52'),
(3, 4, 'Home', 'geeta bhawan 1', 'geeta bhawan 2', 'Indore', 'Dewas', '452201', 'India', 0, '2026-04-24 11:12:04', '2026-04-24 11:23:28'),
(4, 4, 'office', 'wordcup 1', 'wordcup 2', 'indore', 'Dewas', '452016', 'India', 1, '2026-04-24 11:22:58', '2026-04-24 11:23:29'),
(5, 5, 'Home', '76, Siddhipuram colony, Indore, MP, India', NULL, 'Indore', 'MP', '452009', 'India', 1, '2026-05-10 02:50:30', '2026-05-10 02:50:30'),
(7, 8, 'Home', '78', NULL, 'Indore', 'MP', '452009', 'India', 1, '2026-06-13 02:45:37', '2026-06-13 02:45:37');

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
  ADD UNIQUE KEY `carts_user_id_unique` (`user_id`),
  ADD KEY `carts_applied_coupon_id_foreign` (`applied_coupon_id`);

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
  ADD KEY `categories_parent_id_index` (`parent_id`);

--
-- Indexes for table `contact_queries`
--
ALTER TABLE `contact_queries`
  ADD PRIMARY KEY (`id`);

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
  ADD UNIQUE KEY `payments_gateway_order_id_unique` (`gateway_order_id`),
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
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_variants_sku_unique` (`sku`),
  ADD KEY `product_variants_product_id_foreign` (`product_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reviews_product_id_user_id_unique` (`product_id`,`user_id`),
  ADD UNIQUE KEY `reviews_user_id_order_item_id_unique` (`user_id`,`order_item_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`);

--
-- Indexes for table `review_images`
--
ALTER TABLE `review_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `review_images_review_id_foreign` (`review_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_queries`
--
ALTER TABLE `contact_queries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT for table `hero_sections`
--
ALTER TABLE `hero_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `review_images`
--
ALTER TABLE `review_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
  ADD CONSTRAINT `carts_applied_coupon_id_foreign` FOREIGN KEY (`applied_coupon_id`) REFERENCES `coupons` (`id`) ON DELETE SET NULL,
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
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `products_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `review_images`
--
ALTER TABLE `review_images`
  ADD CONSTRAINT `review_images_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE;

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
