-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2026 at 10:09 AM
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
-- Database: `store_management_system_of_bubt`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Wareon', 'upload/brand/1863283880312530.png', '2025-08-09 07:42:51', '2026-04-23 11:39:40'),
(2, 'Invexa', 'upload/brand/1863283833841410.png', '2025-08-09 07:43:39', '2026-04-23 11:38:56'),
(3, 'Stockify', 'upload/brand/1863283803197622.png', '2025-08-09 07:44:35', '2026-04-23 11:38:27'),
(4, 'Campus Ledger', 'upload/brand/1863283459304421.png', '2026-04-23 11:33:01', '2026-04-23 11:33:01'),
(5, 'Edu Stock Pro', 'upload/brand/1863283505530748.png', '2026-04-23 11:33:43', '2026-04-23 11:33:43'),
(6, 'Uni Supply Hub', 'upload/brand/1863283541151863.jpg', '2026-04-23 11:34:17', '2026-04-23 11:34:17'),
(7, 'Campus Vault', 'upload/brand/1863283582792900.png', '2026-04-23 11:34:57', '2026-04-23 11:34:57'),
(8, 'Shikkha Store', 'upload/brand/1863283625397914.jpg', '2026-04-23 11:35:37', '2026-04-23 11:35:37'),
(9, 'Inventra', 'upload/brand/1863283740121448.png', '2026-04-23 11:37:27', '2026-04-23 11:37:27'),
(10, 'Storix', 'upload/brand/1863283919463792.png', '2026-04-23 11:40:18', '2026-04-23 11:40:18'),
(11, 'Matador', 'upload/brand/1864689991583925.png', '2026-05-09 00:09:13', '2026-05-09 00:09:13'),
(12, 'Apsara', 'upload/brand/1864690031483750.png', '2026-05-09 00:09:51', '2026-05-09 00:09:51'),
(13, 'Doms', 'upload/brand/1864690065340964.png', '2026-05-09 00:10:23', '2026-05-09 00:10:23'),
(14, 'Deli', 'upload/brand/1864690109953900.jpg', '2026-05-09 00:11:06', '2026-05-09 00:11:06'),
(15, 'Artline', 'upload/brand/1864690144777911.png', '2026-05-09 00:11:39', '2026-05-09 00:11:39'),
(16, 'A4Tech', 'upload/brand/1864690248507930.png', '2026-05-09 00:13:18', '2026-05-09 00:13:18'),
(17, 'Logitech', 'upload/brand/1864690275267169.png', '2026-05-09 00:13:43', '2026-05-09 00:13:43'),
(18, 'Western Digital', 'upload/brand/1864690308907460.png', '2026-05-09 00:14:15', '2026-05-09 00:14:15'),
(19, 'SanDisk', 'upload/brand/1864690402303056.png', '2026-05-09 00:15:44', '2026-05-09 00:15:44');

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
('laravel_cache_spatie.permission.cache', 'a:3:{s:5:\"alias\";a:5:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:10:\"group_name\";s:1:\"c\";s:4:\"name\";s:1:\"d\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:78:{i:0;a:5:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"Brand\";s:1:\"c\";s:11:\"Brand::menu\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:12;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:5:\"Brand\";s:1:\"c\";s:10:\"Brand::add\";s:1:\"d\";s:3:\"web\";}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:5:\"Brand\";s:1:\"c\";s:11:\"Brand::edit\";s:1:\"d\";s:3:\"web\";}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:5:\"Brand\";s:1:\"c\";s:13:\"Brand::delete\";s:1:\"d\";s:3:\"web\";}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:8:\"Supplier\";s:1:\"c\";s:14:\"Supplier::menu\";s:1:\"d\";s:3:\"web\";}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:8:\"Supplier\";s:1:\"c\";s:13:\"Supplier::add\";s:1:\"d\";s:3:\"web\";}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:8:\"Supplier\";s:1:\"c\";s:14:\"Supplier::edit\";s:1:\"d\";s:3:\"web\";}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:8:\"Supplier\";s:1:\"c\";s:16:\"Supplier::delete\";s:1:\"d\";s:3:\"web\";}i:8;a:5:{s:1:\"a\";i:9;s:1:\"b\";s:7:\"Product\";s:1:\"c\";s:13:\"Product::menu\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:12;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:7:\"Product\";s:1:\"c\";s:12:\"Product::add\";s:1:\"d\";s:3:\"web\";}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:7:\"Product\";s:1:\"c\";s:13:\"Product::edit\";s:1:\"d\";s:3:\"web\";}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:7:\"Product\";s:1:\"c\";s:15:\"Product::delete\";s:1:\"d\";s:3:\"web\";}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:8:\"Category\";s:1:\"c\";s:14:\"Category::menu\";s:1:\"d\";s:3:\"web\";}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:8:\"Category\";s:1:\"c\";s:13:\"Category::add\";s:1:\"d\";s:3:\"web\";}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:8:\"Category\";s:1:\"c\";s:14:\"Category::edit\";s:1:\"d\";s:3:\"web\";}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:8:\"Category\";s:1:\"c\";s:16:\"Category::delete\";s:1:\"d\";s:3:\"web\";}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:11:\"SubCategory\";s:1:\"c\";s:17:\"SubCategory::menu\";s:1:\"d\";s:3:\"web\";}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:11:\"SubCategory\";s:1:\"c\";s:16:\"SubCategory::add\";s:1:\"d\";s:3:\"web\";}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:11:\"SubCategory\";s:1:\"c\";s:17:\"SubCategory::edit\";s:1:\"d\";s:3:\"web\";}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:11:\"SubCategory\";s:1:\"c\";s:19:\"SubCategory::delete\";s:1:\"d\";s:3:\"web\";}i:20;a:4:{s:1:\"a\";i:21;s:1:\"b\";s:14:\"Damage Product\";s:1:\"c\";s:20:\"Damage Product::menu\";s:1:\"d\";s:3:\"web\";}i:21;a:4:{s:1:\"a\";i:22;s:1:\"b\";s:14:\"Damage Product\";s:1:\"c\";s:19:\"Damage Product::add\";s:1:\"d\";s:3:\"web\";}i:22;a:4:{s:1:\"a\";i:23;s:1:\"b\";s:14:\"Damage Product\";s:1:\"c\";s:20:\"Damage Product::edit\";s:1:\"d\";s:3:\"web\";}i:23;a:4:{s:1:\"a\";i:24;s:1:\"b\";s:14:\"Damage Product\";s:1:\"c\";s:22:\"Damage Product::delete\";s:1:\"d\";s:3:\"web\";}i:24;a:4:{s:1:\"a\";i:25;s:1:\"b\";s:8:\"Purchase\";s:1:\"c\";s:14:\"Purchase::menu\";s:1:\"d\";s:3:\"web\";}i:25;a:4:{s:1:\"a\";i:26;s:1:\"b\";s:8:\"Purchase\";s:1:\"c\";s:13:\"Purchase::add\";s:1:\"d\";s:3:\"web\";}i:26;a:4:{s:1:\"a\";i:27;s:1:\"b\";s:8:\"Purchase\";s:1:\"c\";s:14:\"Purchase::edit\";s:1:\"d\";s:3:\"web\";}i:27;a:4:{s:1:\"a\";i:28;s:1:\"b\";s:8:\"Purchase\";s:1:\"c\";s:16:\"Purchase::delete\";s:1:\"d\";s:3:\"web\";}i:28;a:4:{s:1:\"a\";i:29;s:1:\"b\";s:15:\"Purchase Return\";s:1:\"c\";s:21:\"Purchase Return::menu\";s:1:\"d\";s:3:\"web\";}i:29;a:4:{s:1:\"a\";i:30;s:1:\"b\";s:15:\"Purchase Return\";s:1:\"c\";s:20:\"Purchase Return::add\";s:1:\"d\";s:3:\"web\";}i:30;a:4:{s:1:\"a\";i:31;s:1:\"b\";s:15:\"Purchase Return\";s:1:\"c\";s:21:\"Purchase Return::edit\";s:1:\"d\";s:3:\"web\";}i:31;a:4:{s:1:\"a\";i:32;s:1:\"b\";s:15:\"Purchase Return\";s:1:\"c\";s:23:\"Purchase Return::delete\";s:1:\"d\";s:3:\"web\";}i:32;a:5:{s:1:\"a\";i:33;s:1:\"b\";s:11:\"Requisition\";s:1:\"c\";s:17:\"Requisition::menu\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:12;}}i:33;a:5:{s:1:\"a\";i:34;s:1:\"b\";s:11:\"Requisition\";s:1:\"c\";s:16:\"Requisition::add\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:12;}}i:34;a:5:{s:1:\"a\";i:35;s:1:\"b\";s:11:\"Requisition\";s:1:\"c\";s:17:\"Requisition::edit\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:12;}}i:35;a:5:{s:1:\"a\";i:36;s:1:\"b\";s:11:\"Requisition\";s:1:\"c\";s:19:\"Requisition::delete\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:12;}}i:36;a:5:{s:1:\"a\";i:37;s:1:\"b\";s:5:\"Issue\";s:1:\"c\";s:11:\"Issue::menu\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:12;}}i:37;a:4:{s:1:\"a\";i:38;s:1:\"b\";s:5:\"Issue\";s:1:\"c\";s:10:\"Issue::add\";s:1:\"d\";s:3:\"web\";}i:38;a:4:{s:1:\"a\";i:39;s:1:\"b\";s:5:\"Issue\";s:1:\"c\";s:11:\"Issue::edit\";s:1:\"d\";s:3:\"web\";}i:39;a:4:{s:1:\"a\";i:40;s:1:\"b\";s:5:\"Issue\";s:1:\"c\";s:13:\"Issue::delete\";s:1:\"d\";s:3:\"web\";}i:40;a:4:{s:1:\"a\";i:41;s:1:\"b\";s:12:\"Issue Return\";s:1:\"c\";s:18:\"Issue Return::menu\";s:1:\"d\";s:3:\"web\";}i:41;a:4:{s:1:\"a\";i:42;s:1:\"b\";s:12:\"Issue Return\";s:1:\"c\";s:17:\"Issue Return::add\";s:1:\"d\";s:3:\"web\";}i:42;a:4:{s:1:\"a\";i:43;s:1:\"b\";s:12:\"Issue Return\";s:1:\"c\";s:18:\"Issue Return::edit\";s:1:\"d\";s:3:\"web\";}i:43;a:4:{s:1:\"a\";i:44;s:1:\"b\";s:12:\"Issue Return\";s:1:\"c\";s:20:\"Issue Return::delete\";s:1:\"d\";s:3:\"web\";}i:44;a:4:{s:1:\"a\";i:45;s:1:\"b\";s:9:\"Quotation\";s:1:\"c\";s:15:\"Quotation::menu\";s:1:\"d\";s:3:\"web\";}i:45;a:4:{s:1:\"a\";i:46;s:1:\"b\";s:9:\"Quotation\";s:1:\"c\";s:14:\"Quotation::add\";s:1:\"d\";s:3:\"web\";}i:46;a:4:{s:1:\"a\";i:47;s:1:\"b\";s:9:\"Quotation\";s:1:\"c\";s:15:\"Quotation::edit\";s:1:\"d\";s:3:\"web\";}i:47;a:4:{s:1:\"a\";i:48;s:1:\"b\";s:9:\"Quotation\";s:1:\"c\";s:17:\"Quotation::delete\";s:1:\"d\";s:3:\"web\";}i:48;a:4:{s:1:\"a\";i:49;s:1:\"b\";s:6:\"Report\";s:1:\"c\";s:12:\"Report::menu\";s:1:\"d\";s:3:\"web\";}i:49;a:4:{s:1:\"a\";i:50;s:1:\"b\";s:6:\"Report\";s:1:\"c\";s:23:\"Report::purchase report\";s:1:\"d\";s:3:\"web\";}i:50;a:4:{s:1:\"a\";i:51;s:1:\"b\";s:6:\"Report\";s:1:\"c\";s:29:\"Report::damage product report\";s:1:\"d\";s:3:\"web\";}i:51;a:4:{s:1:\"a\";i:52;s:1:\"b\";s:6:\"Report\";s:1:\"c\";s:20:\"Report::issue report\";s:1:\"d\";s:3:\"web\";}i:52;a:4:{s:1:\"a\";i:53;s:1:\"b\";s:6:\"Report\";s:1:\"c\";s:27:\"Report::issue return report\";s:1:\"d\";s:3:\"web\";}i:53;a:4:{s:1:\"a\";i:54;s:1:\"b\";s:6:\"Report\";s:1:\"c\";s:20:\"Report::stock report\";s:1:\"d\";s:3:\"web\";}i:54;a:4:{s:1:\"a\";i:55;s:1:\"b\";s:6:\"Report\";s:1:\"c\";s:26:\"Report::fixed asset report\";s:1:\"d\";s:3:\"web\";}i:55;a:4:{s:1:\"a\";i:56;s:1:\"b\";s:6:\"Report\";s:1:\"c\";s:26:\"Report::product trx report\";s:1:\"d\";s:3:\"web\";}i:56;a:4:{s:1:\"a\";i:57;s:1:\"b\";s:6:\"Report\";s:1:\"c\";s:19:\"Report::all reports\";s:1:\"d\";s:3:\"web\";}i:57;a:5:{s:1:\"a\";i:58;s:1:\"b\";s:4:\"Chat\";s:1:\"c\";s:10:\"Chat::menu\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:12;}}i:58;a:5:{s:1:\"a\";i:59;s:1:\"b\";s:8:\"Semester\";s:1:\"c\";s:14:\"Semester::menu\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:12;}}i:59;a:4:{s:1:\"a\";i:60;s:1:\"b\";s:8:\"Semester\";s:1:\"c\";s:13:\"Semester::add\";s:1:\"d\";s:3:\"web\";}i:60;a:4:{s:1:\"a\";i:61;s:1:\"b\";s:8:\"Semester\";s:1:\"c\";s:14:\"Semester::edit\";s:1:\"d\";s:3:\"web\";}i:61;a:4:{s:1:\"a\";i:62;s:1:\"b\";s:8:\"Semester\";s:1:\"c\";s:16:\"Semester::delete\";s:1:\"d\";s:3:\"web\";}i:62;a:4:{s:1:\"a\";i:63;s:1:\"b\";s:10:\"Department\";s:1:\"c\";s:16:\"Department::menu\";s:1:\"d\";s:3:\"web\";}i:63;a:4:{s:1:\"a\";i:64;s:1:\"b\";s:10:\"Department\";s:1:\"c\";s:15:\"Department::add\";s:1:\"d\";s:3:\"web\";}i:64;a:4:{s:1:\"a\";i:65;s:1:\"b\";s:10:\"Department\";s:1:\"c\";s:16:\"Department::edit\";s:1:\"d\";s:3:\"web\";}i:65;a:4:{s:1:\"a\";i:66;s:1:\"b\";s:10:\"Department\";s:1:\"c\";s:18:\"Department::delete\";s:1:\"d\";s:3:\"web\";}i:66;a:4:{s:1:\"a\";i:67;s:1:\"b\";s:15:\"Role Permission\";s:1:\"c\";s:21:\"Role Permission::menu\";s:1:\"d\";s:3:\"web\";}i:67;a:4:{s:1:\"a\";i:68;s:1:\"b\";s:11:\"Manage User\";s:1:\"c\";s:17:\"Manage User::menu\";s:1:\"d\";s:3:\"web\";}i:68;a:4:{s:1:\"a\";i:69;s:1:\"b\";s:11:\"Manage User\";s:1:\"c\";s:16:\"Manage User::add\";s:1:\"d\";s:3:\"web\";}i:69;a:4:{s:1:\"a\";i:70;s:1:\"b\";s:11:\"Manage User\";s:1:\"c\";s:17:\"Manage User::edit\";s:1:\"d\";s:3:\"web\";}i:70;a:4:{s:1:\"a\";i:71;s:1:\"b\";s:11:\"Manage User\";s:1:\"c\";s:19:\"Manage User::delete\";s:1:\"d\";s:3:\"web\";}i:71;a:4:{s:1:\"a\";i:72;s:1:\"b\";s:5:\"Stock\";s:1:\"c\";s:15:\"Stock::quantity\";s:1:\"d\";s:3:\"web\";}i:72;a:5:{s:1:\"a\";i:73;s:1:\"b\";s:11:\"Requisition\";s:1:\"c\";s:28:\"Requisition::my requisitions\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:12;}}i:73;a:4:{s:1:\"a\";i:74;s:1:\"b\";s:11:\"Requisition\";s:1:\"c\";s:29:\"Requisition::all requisitions\";s:1:\"d\";s:3:\"web\";}i:74;a:5:{s:1:\"a\";i:75;s:1:\"b\";s:5:\"Issue\";s:1:\"c\";s:16:\"Issue::my issues\";s:1:\"d\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:12;}}i:75;a:4:{s:1:\"a\";i:76;s:1:\"b\";s:5:\"Issue\";s:1:\"c\";s:17:\"Issue::all issues\";s:1:\"d\";s:3:\"web\";}i:76;a:4:{s:1:\"a\";i:77;s:1:\"b\";s:7:\"Product\";s:1:\"c\";s:29:\"Product::Roles has permission\";s:1:\"d\";s:3:\"web\";}i:77;a:4:{s:1:\"a\";i:78;s:1:\"b\";s:7:\"Product\";s:1:\"c\";s:17:\"Product::In Stock\";s:1:\"d\";s:3:\"web\";}}s:5:\"roles\";a:1:{i:0;a:3:{s:1:\"a\";i:12;s:1:\"c\";s:4:\"DEAN\";s:1:\"d\";s:3:\"web\";}}}', 1779079915);

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
-- Table structure for table `ch_favorites`
--

CREATE TABLE `ch_favorites` (
  `id` char(36) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `favorite_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ch_favorites`
--

INSERT INTO `ch_favorites` (`id`, `user_id`, `favorite_id`, `created_at`, `updated_at`) VALUES
('b8281376-b3ac-4155-adff-ad2688e6a2ea', 8, 2, '2026-05-11 10:01:04', '2026-05-11 10:01:04'),
('d9d2c85b-35e9-445c-a358-fa91128f064d', 8, 19, '2026-05-11 05:45:14', '2026-05-11 05:45:14');

-- --------------------------------------------------------

--
-- Table structure for table `ch_messages`
--

CREATE TABLE `ch_messages` (
  `id` char(36) NOT NULL,
  `from_id` bigint(20) NOT NULL,
  `to_id` bigint(20) NOT NULL,
  `body` varchar(5000) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ch_messages`
--

INSERT INTO `ch_messages` (`id`, `from_id`, `to_id`, `body`, `attachment`, `seen`, `created_at`, `updated_at`) VALUES
('08d54056-57cc-4397-a674-b071a4bd1322', 18, 2, '', '{\"new_name\":\"5eb651b7-915a-4cb1-afc5-f05a916779da.png\",\"old_name\":\"images (19).png\"}', 1, '2026-05-11 09:17:38', '2026-05-11 09:17:52'),
('0afe7913-ed1f-4a50-9b65-9c94db02e643', 8, 2, 'I need marker, stapler, pencil, scale.', NULL, 1, '2026-05-11 10:00:38', '2026-05-11 10:00:40'),
('47c07280-545d-464d-a7ce-5bd329acb7ec', 2, 18, 'We will notice you as soon as possible.', NULL, 1, '2026-05-12 22:54:50', '2026-05-12 22:54:52'),
('4fa40e87-c382-4bda-8084-43c04d0ac3a2', 18, 2, 'Hello Admin. I didn&#039;t get any response.', NULL, 1, '2026-05-12 22:52:42', '2026-05-12 22:53:18'),
('5c5e9661-c457-40f6-9d76-e586d7067612', 18, 19, 'Hello', NULL, 0, '2026-05-11 09:32:16', '2026-05-11 09:32:16'),
('87122b83-2eec-4431-8fc6-b24fbb70ee6c', 8, 2, 'Hello Mr. I need some office supplies.', NULL, 1, '2026-05-11 09:50:50', '2026-05-11 09:59:35'),
('8b23eed3-4693-49ee-a0a4-e5298f755869', 2, 18, 'hello', NULL, 1, '2026-05-14 10:59:20', '2026-05-14 10:59:21'),
('98c5d75e-9ffc-44d0-8cea-065690441cef', 2, 8, 'What you want', NULL, 1, '2026-05-11 09:59:55', '2026-05-11 09:59:57'),
('b5de27b9-3ce3-4646-81fd-9f58e028859e', 2, 18, 'Hello', NULL, 1, '2026-05-11 01:31:14', '2026-05-11 01:31:47'),
('c28bed42-68fb-4883-b3ef-a945cf1b7b54', 18, 2, 'Hello', NULL, 1, '2026-05-11 01:29:58', '2026-05-11 01:30:25'),
('cbf6e0fb-e124-4bd2-b292-c9912036020a', 18, 2, 'i need some equipement', NULL, 1, '2026-05-14 10:59:32', '2026-05-14 10:59:34'),
('cc18a991-3847-4f17-ba74-1d03712a2f13', 2, 18, '', '{\"new_name\":\"ea8f06b5-fd2e-4978-84e2-e3b958992eda.jpg\",\"old_name\":\"images (9).jpg\"}', 1, '2026-05-11 09:30:16', '2026-05-11 09:30:21'),
('d394acf7-4962-47ec-ae6f-57400331eaa7', 18, 2, 'I Want to some equipment.', NULL, 1, '2026-05-11 09:40:04', '2026-05-12 22:53:18'),
('f3fd0a89-68fe-442e-89c7-16a822841890', 18, 2, 'hello', NULL, 1, '2026-05-14 10:58:26', '2026-05-14 10:58:41');

-- --------------------------------------------------------

--
-- Table structure for table `damage_products`
--

CREATE TABLE `damage_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `tracking_no` varchar(255) DEFAULT NULL,
  `note_no` varchar(255) DEFAULT NULL,
  `semester_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `damage_products`
--

INSERT INTO `damage_products` (`id`, `date`, `tracking_no`, `note_no`, `semester_id`, `notes`, `created_at`, `updated_at`) VALUES
(1, '2026-04-24', '01-2026-04-23-23', 'C-59874', 1, 'Calculator Damage 5 Pic', '2026-04-24 08:03:38', '2026-04-24 08:09:13'),
(2, '2026-05-09', '03-2026-05-09-19', '03-2026-05', 1, 'Damage Marker', '2026-05-09 11:04:53', '2026-05-09 11:04:53');

-- --------------------------------------------------------

--
-- Table structure for table `damage_product_items`
--

CREATE TABLE `damage_product_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `damage_product_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `damage_product_items`
--

INSERT INTO `damage_product_items` (`id`, `damage_product_id`, `product_id`, `qty`, `created_at`, `updated_at`) VALUES
(2, 1, 29, 3, '2026-04-24 08:09:13', '2026-04-24 08:09:13'),
(3, 2, 19, 5, '2026-05-09 11:04:53', '2026-05-09 11:04:53');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `head_of_department` varchar(255) DEFAULT NULL,
  `head_of_department_email` varchar(255) DEFAULT NULL,
  `head_of_department_phone` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `code`, `head_of_department`, `head_of_department_email`, `head_of_department_phone`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Department of Data Science & Engineering', '01', NULL, NULL, NULL, 1, '2026-04-18 11:55:37', '2026-04-21 12:19:47'),
(2, 'Department of Management', '02', NULL, NULL, NULL, 1, '2026-04-18 11:55:57', '2026-04-21 12:20:00'),
(3, 'Department of Computer Science & Engineering', '03', NULL, NULL, NULL, 1, '2026-04-18 11:56:12', '2026-04-21 12:20:11'),
(4, 'Department of Mathematics & Statistics', '04', NULL, NULL, NULL, 1, '2026-04-18 11:56:23', '2026-04-21 12:20:23'),
(5, 'Department of Law & Justice', '05', NULL, NULL, NULL, 1, '2026-04-18 11:56:33', '2026-04-21 12:20:33'),
(6, 'Department of English', '06', NULL, NULL, NULL, 1, '2026-04-18 11:56:48', '2026-04-21 12:20:43'),
(7, 'Department of Economics', '07', NULL, NULL, NULL, 1, '2026-04-18 11:57:09', '2026-04-21 12:20:57'),
(8, 'Department of Accounting', '08', NULL, NULL, NULL, 1, '2026-04-18 11:57:22', '2026-04-21 12:21:07'),
(9, 'Department of Marketing', '09', NULL, NULL, NULL, 1, '2026-04-18 11:57:36', '2026-04-21 12:21:17'),
(10, 'Department of Finance', '10', NULL, NULL, NULL, 1, '2026-04-21 12:21:34', '2026-04-21 12:21:34'),
(11, 'Department of Electrical & Electronic Engineering', '11', NULL, NULL, NULL, 1, '2026-04-21 12:21:45', '2026-04-21 12:21:45'),
(12, 'Department of Textile Engineering', '12', NULL, NULL, NULL, 1, '2026-04-21 12:21:57', '2026-04-21 12:21:57'),
(13, 'Department of Civil Engineering', '13', NULL, NULL, NULL, 1, '2026-04-21 12:22:11', '2026-04-21 12:22:11');

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
-- Table structure for table `issues`
--

CREATE TABLE `issues` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `requisition_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `issued_by` bigint(20) UNSIGNED NOT NULL,
  `semester_id` bigint(20) UNSIGNED NOT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `issues`
--

INSERT INTO `issues` (`id`, `date`, `requisition_id`, `user_id`, `issued_by`, `semester_id`, `department_id`, `notes`, `created_at`, `updated_at`) VALUES
(1, '2026-04-26', 1, 2, 2, 3, NULL, 'Paracetamol 500 mg', '2026-04-26 11:35:22', '2026-04-26 11:35:22'),
(2, '2026-04-26', NULL, 2, 2, 3, NULL, 'Office Diary', '2026-04-26 11:41:06', '2026-04-26 11:41:06'),
(3, '2026-04-26', 3, 8, 2, 2, NULL, NULL, '2026-04-26 11:48:09', '2026-04-26 11:48:09'),
(4, '2026-04-28', NULL, 12, 2, 3, 5, 'Calculator', '2026-04-28 12:13:21', '2026-04-28 12:13:21'),
(5, '2026-05-05', 4, 8, 2, 3, NULL, 'Diary', '2026-05-02 11:44:39', '2026-05-02 11:44:39'),
(6, '2026-05-09', 5, 8, 2, 2, NULL, 'I need this equipment for this semester', '2026-05-09 03:20:41', '2026-05-09 03:20:41'),
(7, '2026-05-09', 6, 18, 2, 1, NULL, NULL, '2026-05-09 06:19:40', '2026-05-09 06:19:40'),
(8, '2026-05-09', NULL, 18, 2, 1, 3, NULL, '2026-05-09 06:24:03', '2026-05-09 06:24:03'),
(9, '2026-05-17', 7, 18, 2, 2, NULL, NULL, '2026-05-16 22:51:45', '2026-05-16 22:51:45');

-- --------------------------------------------------------

--
-- Table structure for table `issue_items`
--

CREATE TABLE `issue_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `issue_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `issue_items`
--

INSERT INTO `issue_items` (`id`, `issue_id`, `product_id`, `qty`, `created_at`, `updated_at`) VALUES
(1, 1, 18, 3, '2026-04-26 11:35:22', '2026-04-26 11:35:22'),
(2, 2, 28, 1, '2026-04-26 11:41:06', '2026-04-26 11:41:06'),
(3, 3, 28, 1, '2026-04-26 11:48:09', '2026-05-10 04:43:04'),
(5, 4, 29, 1, '2026-04-28 12:25:31', '2026-04-28 12:25:31'),
(6, 5, 28, 0, '2026-05-02 11:44:40', '2026-05-16 22:55:05'),
(7, 6, 19, 1, '2026-05-09 03:20:41', '2026-05-09 03:20:41'),
(8, 6, 20, 1, '2026-05-09 03:20:41', '2026-05-09 03:20:41'),
(9, 7, 20, 1, '2026-05-09 06:19:40', '2026-05-09 06:19:40'),
(10, 7, 15, 0, '2026-05-09 06:19:40', '2026-05-09 06:19:40'),
(11, 7, 19, 1, '2026-05-09 06:19:40', '2026-05-10 04:35:07'),
(12, 8, 15, 1, '2026-05-09 06:24:03', '2026-05-09 06:24:03'),
(13, 9, 11, 1, '2026-05-16 22:51:45', '2026-05-16 22:51:45');

-- --------------------------------------------------------

--
-- Table structure for table `issue_returns`
--

CREATE TABLE `issue_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `issue_id` bigint(20) UNSIGNED DEFAULT NULL,
  `semester_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `return_date` date NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `issue_returns`
--

INSERT INTO `issue_returns` (`id`, `issue_id`, `semester_id`, `user_id`, `created_by`, `return_date`, `notes`, `created_at`, `updated_at`) VALUES
(4, 7, 1, 18, 2, '2026-05-10', 'Marker returns to the store', '2026-05-10 04:26:33', '2026-05-10 04:35:07'),
(5, 3, 2, 8, 2, '2026-05-10', 'Return diary to store', '2026-05-10 04:43:04', '2026-05-10 04:43:04'),
(6, 5, 3, 8, 2, '2026-05-17', NULL, '2026-05-16 22:55:05', '2026-05-16 22:55:05');

-- --------------------------------------------------------

--
-- Table structure for table `issue_return_items`
--

CREATE TABLE `issue_return_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `issue_return_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `condition` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `issue_return_items`
--

INSERT INTO `issue_return_items` (`id`, `issue_return_id`, `product_id`, `qty`, `condition`, `created_at`, `updated_at`) VALUES
(2, 4, 19, 1, 'good', '2026-05-10 04:35:07', '2026-05-10 04:35:07'),
(3, 5, 28, 1, 'good', '2026-05-10 04:43:04', '2026-05-10 04:43:04'),
(4, 6, 28, 1, 'good', '2026-05-16 22:55:05', '2026-05-16 22:55:05');

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
(4, '2025_04_15_164948_create_brands_table', 1),
(5, '2025_04_17_143857_create_ware_houses_table', 1),
(6, '2025_04_17_153708_create_suppliers_table', 1),
(7, '2025_04_17_164656_create_customers_table', 1),
(8, '2025_04_17_205733_create_product_categories_table', 1),
(9, '2025_04_17_220311_create_products_table', 1),
(10, '2025_04_18_180510_create_product_images_table', 1),
(11, '2025_04_30_185014_create_purchases_table', 1),
(12, '2025_04_30_185038_create_purchase_items_table', 1),
(13, '2025_05_04_184127_create_return_purchases_table', 1),
(14, '2025_05_04_184156_create_return_purchase_items_table', 1),
(15, '2025_05_04_220739_create_sales_table', 1),
(16, '2025_05_04_220756_create_sale_items_table', 1),
(17, '2025_05_06_180339_create_sale_returns_table', 1),
(18, '2025_05_06_180404_create_sale_return_items_table', 1),
(19, '2025_05_07_183335_create_transfers_table', 1),
(20, '2025_05_07_183426_create_transfer_items_table', 1),
(21, '2025_05_11_204209_create_permission_tables', 1),
(22, '2025_04_18_000001_create_subcategories_table', 2),
(23, '2025_04_18_000002_add_subcategory_to_products_table', 2),
(25, '2026_04_18_162518_create_semesters_table', 3),
(26, '2026_04_18_172058_create_departments_table', 4),
(27, '2026_04_18_000003_add_department_id_to_users_table', 5),
(28, '2026_04_19_000001_add_sku_to_products_table', 6),
(29, '2026_04_19_085221_product_role_permissions', 7),
(30, '2026_04_19_120000_add_tracking_note_file_semester_department_color_to_purchases_table', 8),
(31, '2026_04_19_120100_add_tracking_note_file_semester_department_color_to_return_purchases_table', 8),
(32, '2026_04_19_151628_purchase_roles', 9),
(33, '2026_04_19_151656_return_purchase_roles', 9),
(34, '2026_04_21_000001_add_fixed_asset_to_products_table', 10),
(35, '2026_04_22_000001_add_user_id_to_purchases_table', 11),
(36, '2026_04_24_063431_create_damage_products_table', 12),
(37, '2026_04_24_083532_create_damage_product_items_table', 12),
(38, '2026_04_24_144959_create_requisitions_table', 13),
(39, '2026_04_24_145723_create_requisition_items_table', 13),
(40, '2026_04_26_164900_create_issues_table', 14),
(41, '2026_04_26_164906_create_issue_items_table', 14),
(42, '2026_04_26_175000_add_status_to_requisitions_table', 15),
(43, '2026_05_09_000001_add_expiry_date_to_purchase_items_table', 16),
(46, '2026_05_10_000002_add_returned_qty_to_issue_items_table', 17),
(47, '2026_05_10_072323_create_issue_returns_table', 18),
(48, '2026_05_10_072442_create_issue_return_items_table', 19),
(49, '2026_05_10_142549_create_quotations_table', 20),
(50, '2026_05_10_142633_create_quotation_items_table', 20),
(51, '2026_05_11_999999_add_active_status_to_users', 21),
(52, '2026_05_11_999999_add_avatar_to_users', 21),
(53, '2026_05_11_999999_add_dark_mode_to_users', 21),
(54, '2026_05_11_999999_add_messenger_color_to_users', 21),
(55, '2026_05_11_999999_create_chatify_favorites_table', 21),
(56, '2026_05_11_999999_create_chatify_messages_table', 21),
(57, '2026_05_16_000001_add_semester_id_to_issue_returns_table', 22);

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
(1, 'App\\Models\\User', 5),
(1, 'App\\Models\\User', 19),
(2, 'App\\Models\\User', 2),
(4, 'App\\Models\\User', 20),
(6, 'App\\Models\\User', 9),
(9, 'App\\Models\\User', 11),
(9, 'App\\Models\\User', 12),
(9, 'App\\Models\\User', 13),
(9, 'App\\Models\\User', 14),
(9, 'App\\Models\\User', 15),
(9, 'App\\Models\\User', 16),
(12, 'App\\Models\\User', 7),
(12, 'App\\Models\\User', 8),
(12, 'App\\Models\\User', 10),
(12, 'App\\Models\\User', 17),
(12, 'App\\Models\\User', 18);

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_name` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `group_name`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Brand', 'Brand::menu', 'web', '2026-05-15 03:55:03', '2026-05-15 08:06:57'),
(2, 'Brand', 'Brand::add', 'web', '2026-05-15 03:55:14', '2026-05-15 12:33:48'),
(3, 'Brand', 'Brand::edit', 'web', '2026-05-15 03:55:26', '2026-05-15 12:34:17'),
(4, 'Brand', 'Brand::delete', 'web', '2026-05-15 03:55:47', '2026-05-15 12:34:27'),
(5, 'Supplier', 'Supplier::menu', 'web', '2026-05-15 08:07:15', '2026-05-15 08:07:15'),
(6, 'Supplier', 'Supplier::add', 'web', '2026-05-15 08:08:40', '2026-05-15 08:08:40'),
(7, 'Supplier', 'Supplier::edit', 'web', '2026-05-15 08:08:49', '2026-05-15 08:08:49'),
(8, 'Supplier', 'Supplier::delete', 'web', '2026-05-15 08:08:59', '2026-05-15 08:08:59'),
(9, 'Product', 'Product::menu', 'web', '2026-05-15 08:09:18', '2026-05-15 08:09:18'),
(10, 'Product', 'Product::add', 'web', '2026-05-15 08:09:50', '2026-05-15 08:38:18'),
(11, 'Product', 'Product::edit', 'web', '2026-05-15 08:38:27', '2026-05-15 08:38:27'),
(12, 'Product', 'Product::delete', 'web', '2026-05-15 08:39:04', '2026-05-15 08:39:04'),
(13, 'Category', 'Category::menu', 'web', '2026-05-15 08:39:17', '2026-05-15 08:39:17'),
(14, 'Category', 'Category::add', 'web', '2026-05-15 08:39:24', '2026-05-15 08:39:24'),
(15, 'Category', 'Category::edit', 'web', '2026-05-15 08:39:41', '2026-05-15 08:39:41'),
(16, 'Category', 'Category::delete', 'web', '2026-05-15 08:39:48', '2026-05-15 08:39:48'),
(17, 'SubCategory', 'SubCategory::menu', 'web', '2026-05-15 08:40:50', '2026-05-15 08:40:50'),
(18, 'SubCategory', 'SubCategory::add', 'web', '2026-05-15 08:40:59', '2026-05-15 08:40:59'),
(19, 'SubCategory', 'SubCategory::edit', 'web', '2026-05-15 08:41:10', '2026-05-15 08:41:10'),
(20, 'SubCategory', 'SubCategory::delete', 'web', '2026-05-15 08:41:32', '2026-05-15 08:41:32'),
(21, 'Damage Product', 'Damage Product::menu', 'web', '2026-05-15 08:41:51', '2026-05-15 08:41:51'),
(22, 'Damage Product', 'Damage Product::add', 'web', '2026-05-15 08:42:09', '2026-05-15 08:42:09'),
(23, 'Damage Product', 'Damage Product::edit', 'web', '2026-05-15 08:42:17', '2026-05-15 08:42:17'),
(24, 'Damage Product', 'Damage Product::delete', 'web', '2026-05-15 08:42:26', '2026-05-15 08:42:26'),
(25, 'Purchase', 'Purchase::menu', 'web', '2026-05-15 08:42:40', '2026-05-15 08:42:40'),
(26, 'Purchase', 'Purchase::add', 'web', '2026-05-15 08:42:51', '2026-05-15 08:42:51'),
(27, 'Purchase', 'Purchase::edit', 'web', '2026-05-15 08:43:03', '2026-05-15 08:43:03'),
(28, 'Purchase', 'Purchase::delete', 'web', '2026-05-15 08:43:18', '2026-05-15 08:43:18'),
(29, 'Purchase Return', 'Purchase Return::menu', 'web', '2026-05-15 08:43:39', '2026-05-15 08:43:39'),
(30, 'Purchase Return', 'Purchase Return::add', 'web', '2026-05-15 08:43:48', '2026-05-15 08:43:48'),
(31, 'Purchase Return', 'Purchase Return::edit', 'web', '2026-05-15 08:43:58', '2026-05-15 08:43:58'),
(32, 'Purchase Return', 'Purchase Return::delete', 'web', '2026-05-15 08:44:11', '2026-05-15 08:44:11'),
(33, 'Requisition', 'Requisition::menu', 'web', '2026-05-15 08:44:27', '2026-05-15 08:44:27'),
(34, 'Requisition', 'Requisition::add', 'web', '2026-05-15 08:47:50', '2026-05-15 08:47:50'),
(35, 'Requisition', 'Requisition::edit', 'web', '2026-05-15 08:47:58', '2026-05-15 08:47:58'),
(36, 'Requisition', 'Requisition::delete', 'web', '2026-05-15 08:48:10', '2026-05-15 08:48:10'),
(37, 'Issue', 'Issue::menu', 'web', '2026-05-15 08:48:22', '2026-05-15 08:48:22'),
(38, 'Issue', 'Issue::add', 'web', '2026-05-15 08:48:41', '2026-05-15 08:48:41'),
(39, 'Issue', 'Issue::edit', 'web', '2026-05-15 08:48:55', '2026-05-15 08:48:55'),
(40, 'Issue', 'Issue::delete', 'web', '2026-05-15 08:49:09', '2026-05-15 08:49:09'),
(41, 'Issue Return', 'Issue Return::menu', 'web', '2026-05-15 08:49:27', '2026-05-15 08:49:27'),
(42, 'Issue Return', 'Issue Return::add', 'web', '2026-05-15 08:49:37', '2026-05-15 08:49:37'),
(43, 'Issue Return', 'Issue Return::edit', 'web', '2026-05-15 08:50:05', '2026-05-15 08:50:05'),
(44, 'Issue Return', 'Issue Return::delete', 'web', '2026-05-15 08:50:18', '2026-05-15 08:50:18'),
(45, 'Quotation', 'Quotation::menu', 'web', '2026-05-15 08:50:35', '2026-05-15 08:50:35'),
(46, 'Quotation', 'Quotation::add', 'web', '2026-05-15 08:50:47', '2026-05-15 08:50:47'),
(47, 'Quotation', 'Quotation::edit', 'web', '2026-05-15 08:50:58', '2026-05-15 08:50:58'),
(48, 'Quotation', 'Quotation::delete', 'web', '2026-05-15 08:51:09', '2026-05-15 08:51:09'),
(49, 'Report', 'Report::menu', 'web', '2026-05-15 08:51:37', '2026-05-15 08:51:37'),
(50, 'Report', 'Report::purchase report', 'web', '2026-05-15 08:51:56', '2026-05-15 08:51:56'),
(51, 'Report', 'Report::damage product report', 'web', '2026-05-15 08:52:40', '2026-05-15 08:52:40'),
(52, 'Report', 'Report::issue report', 'web', '2026-05-15 08:52:56', '2026-05-15 08:52:56'),
(53, 'Report', 'Report::issue return report', 'web', '2026-05-15 08:53:15', '2026-05-15 08:53:15'),
(54, 'Report', 'Report::stock report', 'web', '2026-05-15 08:53:31', '2026-05-15 08:53:31'),
(55, 'Report', 'Report::fixed asset report', 'web', '2026-05-15 08:54:37', '2026-05-15 08:54:37'),
(56, 'Report', 'Report::product trx report', 'web', '2026-05-15 08:55:03', '2026-05-15 08:55:03'),
(57, 'Report', 'Report::all reports', 'web', '2026-05-15 08:55:19', '2026-05-15 08:55:19'),
(58, 'Chat', 'Chat::menu', 'web', '2026-05-15 08:55:37', '2026-05-15 08:55:37'),
(59, 'Semester', 'Semester::menu', 'web', '2026-05-15 08:56:12', '2026-05-15 08:56:12'),
(60, 'Semester', 'Semester::add', 'web', '2026-05-15 08:56:31', '2026-05-15 08:56:31'),
(61, 'Semester', 'Semester::edit', 'web', '2026-05-15 08:56:40', '2026-05-15 08:56:40'),
(62, 'Semester', 'Semester::delete', 'web', '2026-05-15 08:56:49', '2026-05-15 08:56:49'),
(63, 'Department', 'Department::menu', 'web', '2026-05-15 08:57:13', '2026-05-15 08:57:13'),
(64, 'Department', 'Department::add', 'web', '2026-05-15 08:57:23', '2026-05-15 08:57:23'),
(65, 'Department', 'Department::edit', 'web', '2026-05-15 08:57:33', '2026-05-15 08:57:33'),
(66, 'Department', 'Department::delete', 'web', '2026-05-15 08:57:42', '2026-05-15 08:57:42'),
(67, 'Role Permission', 'Role Permission::menu', 'web', '2026-05-15 08:58:19', '2026-05-15 08:58:19'),
(68, 'Manage User', 'Manage User::menu', 'web', '2026-05-15 08:58:58', '2026-05-15 08:58:58'),
(69, 'Manage User', 'Manage User::add', 'web', '2026-05-15 08:59:11', '2026-05-15 08:59:11'),
(70, 'Manage User', 'Manage User::edit', 'web', '2026-05-15 08:59:20', '2026-05-15 08:59:20'),
(71, 'Manage User', 'Manage User::delete', 'web', '2026-05-15 08:59:29', '2026-05-15 08:59:29'),
(72, 'Stock', 'Stock::quantity', 'web', '2026-05-15 09:00:07', '2026-05-15 09:00:07'),
(73, 'Requisition', 'Requisition::my requisitions', 'web', '2026-05-15 09:04:56', '2026-05-15 09:04:56'),
(74, 'Requisition', 'Requisition::all requisitions', 'web', '2026-05-15 09:05:12', '2026-05-15 09:05:12'),
(75, 'Issue', 'Issue::my issues', 'web', '2026-05-15 09:05:34', '2026-05-15 09:05:34'),
(76, 'Issue', 'Issue::all issues', 'web', '2026-05-15 09:05:50', '2026-05-15 09:05:50'),
(77, 'Product', 'Product::Roles has permission', 'web', '2026-05-15 12:36:22', '2026-05-15 12:36:22'),
(78, 'Product', 'Product::In Stock', 'web', '2026-05-15 12:37:04', '2026-05-15 12:37:04');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `sku` varchar(191) DEFAULT NULL,
  `image` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`image`)),
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `subcategory_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock_alert` int(11) DEFAULT 0,
  `note` text DEFAULT NULL,
  `product_qty` int(11) NOT NULL DEFAULT 0,
  `fixed_asset` tinyint(4) NOT NULL DEFAULT 0,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` varchar(255) DEFAULT 'Pending',
  `active` varchar(255) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `code`, `sku`, `image`, `category_id`, `subcategory_id`, `brand_id`, `supplier_id`, `price`, `stock_alert`, `note`, `product_qty`, `fixed_asset`, `discount`, `status`, `active`, `created_at`, `updated_at`) VALUES
(11, 'Clipboard', 'ELEC001', NULL, '[\"samsung_s23_1.jpg\",\"samsung_s23_2.jpg\"]', 4, 15, 1, NULL, NULL, NULL, 'Latest model with 8GB RAM', 12, 0, 2000.00, NULL, '1', '2025-08-09 14:56:29', '2026-05-16 22:51:45'),
(12, 'Scissors', 'FURN001', NULL, '[\"rfl_chair.jpg\"]', 9, 30, 2, NULL, NULL, NULL, 'Durable plastic chair for home and office', 79, 0, 50.00, NULL, '1', '2025-08-09 14:56:29', '2026-05-09 22:25:32'),
(13, 'Glue Stick', 'FNB001', NULL, '[\"pran_mango_juice.jpg\"]', 8, 27, 3, NULL, NULL, NULL, 'Natural mango juice, no preservatives', 1025, 0, 5.00, NULL, '1', '2025-08-09 14:56:29', '2026-05-16 22:22:48'),
(14, 'Paper Clip', 'PHAR001', NULL, '[\"square_toothpaste.jpg\"]', 8, 27, 4, NULL, NULL, NULL, 'Herbal toothpaste for sensitive teeth', 350, 0, 2.00, NULL, '1', '2025-08-09 14:56:29', '2026-05-16 22:25:37'),
(15, 'Stapler', 'FNB002', NULL, '[\"nescafe_classic.jpg\"]', 8, 26, 5, NULL, NULL, NULL, 'Instant coffee, 50g pack', 470, 0, 15.00, NULL, '1', '2025-08-09 14:56:29', '2026-05-09 22:17:05'),
(16, 'Scale Ruler', 'ELEC002', NULL, '[\"walton_tv.jpg\"]', 9, 30, 2, NULL, NULL, NULL, '32 inch HD LED TV', 105, 0, 1000.00, NULL, '1', '2025-08-09 14:56:29', '2026-05-09 22:25:32'),
(17, 'Highlighter', 'HOME001', NULL, '[\"aci_rice_cooker.jpg\"]', 8, 27, 3, NULL, NULL, NULL, '1.5 liter capacity rice cooker', 110, 0, 150.00, NULL, '1', '2025-08-09 14:56:29', '2026-05-09 22:25:32'),
(18, 'Paracetamol', 'P003', NULL, '[\"pran_chips.jpg\"]', 3, 7, 3, NULL, NULL, NULL, 'Paracetamol 500 mg', 70, 1, 1.00, NULL, '1', '2025-08-09 14:56:29', '2026-05-09 22:26:45'),
(19, 'Marker', 'ELEC003', NULL, '[\"square_led_bulb.jpg\"]', 1, 4, 2, NULL, NULL, NULL, 'Energy saving LED bulb', 52, 0, 10.00, NULL, '1', '2025-08-09 14:56:29', '2026-05-10 04:35:07'),
(20, 'Eraser', 'CONST001', NULL, '[\"rfl_pvc_pipe.jpg\"]', 4, NULL, 3, NULL, NULL, NULL, 'High quality PVC pipe 1 inch diameter', 71, 0, 5.00, NULL, '1', '2025-08-09 14:56:29', '2026-05-09 22:25:32'),
(25, 'Sharpener', 'PN-123', NULL, NULL, 4, 14, 1, NULL, NULL, NULL, 'Matador All Time Pen and Pencils', 130, 1, 0.00, NULL, '1', '2026-04-18 23:18:41', '2026-05-16 22:22:48'),
(27, 'Board Duster', 'BD-236', 'ST-OF-WA-BD-027', NULL, 4, 15, 1, NULL, NULL, NULL, 'Board Duster for University', 80, 0, 0.00, NULL, '1', '2026-04-19 01:15:12', '2026-04-21 12:40:37'),
(28, 'Office Diary', 'OD-569', 'ST-OF-WA-OD-028', NULL, 4, 15, 1, NULL, NULL, NULL, 'Office Diary for University', 301, 1, 0.00, NULL, '1', '2026-04-19 03:29:34', '2026-05-16 22:55:05'),
(29, 'Calculator', 'C-758', 'EL-LA-ST-C-029', NULL, 1, 2, 10, NULL, NULL, NULL, 'Calculator', 16, 1, 0.00, NULL, '1', '2026-04-23 11:45:20', '2026-05-10 00:29:35');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`id`, `category_name`, `category_slug`, `created_at`, `updated_at`) VALUES
(1, 'Electronics', 'electronics', NULL, NULL),
(2, 'Agricultural Products', 'agricultural-products', NULL, NULL),
(3, 'Pharmaceuticals', 'pharmaceuticals', NULL, NULL),
(4, 'Stationery', 'stationery', NULL, NULL),
(5, 'Furniture', 'furniture', NULL, NULL),
(6, 'Chemicals', 'chemicals', NULL, NULL),
(7, 'Footwear', 'footwear', NULL, NULL),
(8, 'Office Supplies', 'office-supplies', NULL, NULL),
(9, 'Academic Supplies', 'academic-supplies', NULL, NULL),
(10, 'Accessories', 'accessories', NULL, NULL),
(11, 'Computer Accessories', 'computer-accessories', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image`, `created_at`, `updated_at`) VALUES
(1, 19, 'upload/productimg/1862821821949968.jpg', '2026-04-18 09:15:27', '2026-04-18 09:15:27'),
(2, 19, 'upload/productimg/1862821822253283.jpg', '2026-04-18 09:15:28', '2026-04-18 09:15:28'),
(3, 19, 'upload/productimg/1862821822344882.jpg', '2026-04-18 09:15:28', '2026-04-18 09:15:28'),
(4, 25, 'upload/productimg/1862874873265950.jpg', '2026-04-18 23:18:43', '2026-04-18 23:18:43'),
(5, 25, 'upload/productimg/1862874875638639.jpg', '2026-04-18 23:18:43', '2026-04-18 23:18:43'),
(6, 27, 'upload/productimg/1862882203722944.jpg', '2026-04-19 01:15:13', '2026-04-19 01:15:13'),
(8, 27, 'upload/productimg/1862882204865939.jpg', '2026-04-19 01:15:13', '2026-04-19 01:15:13'),
(9, 27, 'upload/productimg/1862882204887916.jpg', '2026-04-19 01:15:13', '2026-04-19 01:15:13'),
(10, 28, 'upload/productimg/1862890657797246.jpg', '2026-04-19 03:29:34', '2026-04-19 03:29:34'),
(11, 28, 'upload/productimg/1862890657855683.jpg', '2026-04-19 03:29:34', '2026-04-19 03:29:34'),
(12, 28, 'upload/productimg/1862890657926472.jpg', '2026-04-19 03:29:34', '2026-04-19 03:29:34'),
(13, 29, 'upload/productimg/1863284236016011.jpg', '2026-04-23 11:45:20', '2026-04-23 11:45:20'),
(14, 29, 'upload/productimg/1863284236141388.jpg', '2026-04-23 11:45:20', '2026-04-23 11:45:20'),
(15, 29, 'upload/productimg/1863284236195362.jpg', '2026-04-23 11:45:20', '2026-04-23 11:45:20');

-- --------------------------------------------------------

--
-- Table structure for table `product_role_permissions`
--

CREATE TABLE `product_role_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_role_permissions`
--

INSERT INTO `product_role_permissions` (`id`, `product_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 27, 3, '2026-04-19 03:22:19', '2026-04-19 03:22:19'),
(3, 27, 9, '2026-04-19 03:22:19', '2026-04-19 03:22:19'),
(4, 27, 5, '2026-04-19 03:24:26', '2026-04-19 03:24:26'),
(5, 28, 3, '2026-04-19 03:29:34', '2026-04-19 03:29:34'),
(6, 28, 4, '2026-04-19 03:29:34', '2026-04-19 03:29:34'),
(8, 28, 8, '2026-04-19 03:29:34', '2026-04-19 03:29:34'),
(9, 28, 9, '2026-04-19 03:29:34', '2026-04-19 03:29:34'),
(10, 29, 3, '2026-04-23 11:45:20', '2026-04-23 11:45:20'),
(11, 29, 4, '2026-04-23 11:45:20', '2026-04-23 11:45:20'),
(12, 29, 9, '2026-04-23 11:45:20', '2026-04-23 11:45:20'),
(13, 25, 3, '2026-04-24 11:33:13', '2026-04-24 11:33:13'),
(14, 25, 4, '2026-04-24 11:33:13', '2026-04-24 11:33:13'),
(15, 25, 1, '2026-04-24 11:33:33', '2026-04-24 11:33:33'),
(16, 25, 2, '2026-04-24 11:33:33', '2026-04-24 11:33:33'),
(17, 20, 1, '2026-04-24 11:34:07', '2026-04-24 11:34:07'),
(18, 20, 2, '2026-04-24 11:34:07', '2026-04-24 11:34:07'),
(19, 20, 3, '2026-04-24 11:34:07', '2026-04-24 11:34:07'),
(20, 20, 4, '2026-04-24 11:34:07', '2026-04-24 11:34:07'),
(21, 19, 1, '2026-04-24 11:34:28', '2026-04-24 11:34:28'),
(22, 19, 2, '2026-04-24 11:34:28', '2026-04-24 11:34:28'),
(23, 19, 3, '2026-04-24 11:34:28', '2026-04-24 11:34:28'),
(24, 19, 4, '2026-04-24 11:34:28', '2026-04-24 11:34:28'),
(25, 18, 1, '2026-04-24 11:36:18', '2026-04-24 11:36:18'),
(26, 18, 2, '2026-04-24 11:36:18', '2026-04-24 11:36:18'),
(27, 18, 3, '2026-04-24 11:36:18', '2026-04-24 11:36:18'),
(28, 18, 4, '2026-04-24 11:36:18', '2026-04-24 11:36:18'),
(29, 18, 9, '2026-04-24 11:36:18', '2026-04-24 11:36:18'),
(30, 18, 12, '2026-04-24 11:36:18', '2026-04-24 11:36:18'),
(31, 17, 1, '2026-04-24 11:37:03', '2026-04-24 11:37:03'),
(32, 17, 2, '2026-04-24 11:37:03', '2026-04-24 11:37:03'),
(33, 17, 3, '2026-04-24 11:37:03', '2026-04-24 11:37:03'),
(34, 17, 4, '2026-04-24 11:37:03', '2026-04-24 11:37:03'),
(35, 16, 1, '2026-04-24 11:37:22', '2026-04-24 11:37:22'),
(36, 16, 2, '2026-04-24 11:37:22', '2026-04-24 11:37:22'),
(37, 16, 3, '2026-04-24 11:37:22', '2026-04-24 11:37:22'),
(38, 16, 4, '2026-04-24 11:37:22', '2026-04-24 11:37:22'),
(39, 15, 1, '2026-04-24 11:37:51', '2026-04-24 11:37:51'),
(40, 15, 2, '2026-04-24 11:37:51', '2026-04-24 11:37:51'),
(41, 15, 3, '2026-04-24 11:37:51', '2026-04-24 11:37:51'),
(42, 15, 4, '2026-04-24 11:37:51', '2026-04-24 11:37:51'),
(43, 14, 1, '2026-04-24 11:38:10', '2026-04-24 11:38:10'),
(44, 14, 2, '2026-04-24 11:38:10', '2026-04-24 11:38:10'),
(45, 14, 3, '2026-04-24 11:38:10', '2026-04-24 11:38:10'),
(46, 14, 4, '2026-04-24 11:38:10', '2026-04-24 11:38:10'),
(47, 13, 1, '2026-04-24 11:38:27', '2026-04-24 11:38:27'),
(48, 13, 2, '2026-04-24 11:38:27', '2026-04-24 11:38:27'),
(49, 13, 3, '2026-04-24 11:38:27', '2026-04-24 11:38:27'),
(50, 13, 4, '2026-04-24 11:38:27', '2026-04-24 11:38:27'),
(51, 12, 1, '2026-04-24 11:38:47', '2026-04-24 11:38:47'),
(52, 12, 2, '2026-04-24 11:38:47', '2026-04-24 11:38:47'),
(53, 12, 3, '2026-04-24 11:38:47', '2026-04-24 11:38:47'),
(54, 12, 4, '2026-04-24 11:38:47', '2026-04-24 11:38:47'),
(55, 11, 1, '2026-04-24 11:39:12', '2026-04-24 11:39:12'),
(56, 11, 2, '2026-04-24 11:39:12', '2026-04-24 11:39:12'),
(57, 11, 3, '2026-04-24 11:39:12', '2026-04-24 11:39:12'),
(58, 11, 4, '2026-04-24 11:39:12', '2026-04-24 11:39:12'),
(59, 20, 12, '2026-05-09 00:03:46', '2026-05-09 00:03:46'),
(60, 19, 12, '2026-05-09 00:04:35', '2026-05-09 00:04:35'),
(61, 15, 12, '2026-05-09 00:05:43', '2026-05-09 00:05:43'),
(62, 11, 12, '2026-05-09 00:07:33', '2026-05-09 00:07:33');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `tracking_no` varchar(255) DEFAULT NULL,
  `note_no` varchar(255) DEFAULT NULL,
  `file_upload` varchar(255) DEFAULT NULL,
  `semester_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('Received','Pending','Ordered') NOT NULL DEFAULT 'Pending',
  `note` text DEFAULT NULL,
  `grand_total` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `date`, `tracking_no`, `note_no`, `file_upload`, `semester_id`, `department_id`, `user_id`, `supplier_id`, `discount`, `shipping`, `status`, `note`, `grand_total`, `created_at`, `updated_at`) VALUES
(1, '2026-04-21', 'TN-123', 'NN-256', NULL, 3, 5, 12, 1, 1000.00, 500.00, 'Pending', NULL, 0.00, '2025-08-09 09:04:04', '2026-04-21 12:43:54'),
(2, '2026-04-21', 'P-123', 'P-2365', NULL, 1, 4, 16, 2, 50.00, 100.00, 'Received', NULL, 600.00, '2025-08-09 09:05:32', '2026-04-21 12:59:55'),
(3, '2026-04-23', '02-2026-04-23-23', NULL, NULL, 2, 2, NULL, 5, 50.00, 100.00, 'Ordered', NULL, 51.00, '2025-08-09 09:35:10', '2026-04-23 11:29:23'),
(5, '2026-04-21', 'PBO-123', 'OBP-2365', 'purchase-files/GREjlot27g6svgjYykyThoj6cigUBkSZmMODYs14.jpg', 2, 2, NULL, 5, 600.00, 300.00, 'Ordered', 'Product, Board Duster, Office Diary Order Done.', 0.00, '2026-04-19 11:52:42', '2026-04-21 12:40:37'),
(6, '2026-02-04', '04-2026-02-23-23', 'C-59874', 'purchase-files/BYhZVseWz9cplI6R6NYjw2C3ohxer1vOMQt3HLsL.jpg', 1, 1, 9, 3, 0.00, 250.00, 'Pending', 'Calculator Purchase', 3800.00, '2026-02-04 11:50:24', '2026-02-04 11:50:25'),
(7, '2026-05-09', '03-2026-05-09-19', NULL, NULL, 1, 3, 18, 5, 0.00, 200.00, 'Pending', NULL, 6500.00, '2026-05-09 07:38:58', '2026-05-09 07:38:58'),
(8, '2026-05-09', '03-2026-05-09-23', NULL, NULL, 1, 3, 18, 5, 0.00, 302.00, 'Pending', NULL, 17802.00, '2026-05-09 11:57:39', '2026-05-09 11:57:39'),
(9, '2026-05-09', '03-2026-05-09-23', NULL, NULL, 2, 3, 18, 5, 0.00, 300.00, 'Pending', NULL, 20800.00, '2026-05-09 11:59:17', '2026-05-09 11:59:17'),
(10, '2026-05-10', '03-2026-05-10-10', NULL, NULL, 3, 3, 18, 5, 0.00, 300.00, 'Pending', NULL, 15700.00, '2026-05-09 22:25:32', '2026-05-09 22:25:32'),
(11, '2026-05-10', '03-2026-05-10-10', NULL, NULL, 1, 3, 18, 5, 0.00, 100.00, 'Pending', NULL, 700.00, '2026-05-09 22:26:45', '2026-05-09 22:26:45'),
(12, '2026-05-10', '01-2026-05-10-12', NULL, NULL, 2, 1, 9, 5, 0.00, 250.00, 'Pending', NULL, 5000.00, '2026-05-10 00:29:35', '2026-05-10 00:29:35'),
(13, '2026-05-17', '13-2026-05-17-10', 'GSP-13', NULL, 2, 13, 8, 1, 0.00, 0.00, 'Pending', NULL, 2400.00, '2026-05-16 22:22:48', '2026-05-16 22:22:48');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `net_unit_cost` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `subtotal` decimal(10,2) NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchase_items`
--

INSERT INTO `purchase_items` (`id`, `purchase_id`, `product_id`, `net_unit_cost`, `stock`, `quantity`, `discount`, `subtotal`, `expiry_date`, `created_at`, `updated_at`) VALUES
(22, 5, 25, 120.00, 90, 10, 200.00, 1000.00, '2026-09-10', '2026-04-21 12:40:37', '2026-04-21 12:40:37'),
(23, 5, 27, 150.00, 80, 30, 400.00, 4100.00, NULL, '2026-04-21 12:40:37', '2026-04-21 12:40:37'),
(24, 1, 11, 400.00, 0, 1, 0.00, 78000.00, NULL, '2026-04-21 12:43:54', '2026-04-21 12:43:54'),
(25, 2, 13, 120.00, 1005, 5, 50.00, 550.00, NULL, '2026-04-21 12:59:55', '2026-04-21 12:59:55'),
(26, 3, 14, 45.00, 310, 30, 100.00, 1250.00, NULL, '2026-04-23 11:29:23', '2026-04-23 11:29:23'),
(27, 6, 29, 750.00, 15, 5, 200.00, 3550.00, '2026-06-04', '2026-04-23 11:50:25', '2026-04-23 11:50:25'),
(28, 7, 25, 30.00, 100, 10, 0.00, 300.00, '2026-11-09', '2026-05-09 07:38:58', '2026-05-09 07:38:58'),
(29, 7, 19, 200.00, 56, 30, 0.00, 6000.00, NULL, '2026-05-09 07:38:58', '2026-05-09 07:38:58'),
(30, 8, 28, 350.00, 299, 50, 0.00, 17500.00, '2027-05-09', '2026-05-09 11:57:39', '2026-05-09 11:57:39'),
(31, 9, 15, 300.00, 470, 70, 500.00, 20500.00, NULL, '2026-05-09 11:59:17', '2026-05-09 11:59:17'),
(32, 10, 12, 150.00, 79, 50, 0.00, 7500.00, NULL, '2026-05-09 22:25:32', '2026-05-09 22:25:32'),
(33, 10, 16, 50.00, 105, 70, 0.00, 3500.00, NULL, '2026-05-09 22:25:32', '2026-05-09 22:25:32'),
(34, 10, 17, 120.00, 110, 30, 0.00, 3600.00, NULL, '2026-05-09 22:25:32', '2026-05-09 22:25:32'),
(35, 10, 20, 20.00, 71, 40, 0.00, 800.00, NULL, '2026-05-09 22:25:32', '2026-05-09 22:25:32'),
(36, 11, 18, 30.00, 70, 20, 0.00, 600.00, '2026-06-10', '2026-05-09 22:26:45', '2026-05-09 22:26:45'),
(37, 12, 29, 950.00, 16, 5, 0.00, 4750.00, '2026-08-10', '2026-05-10 00:29:35', '2026-05-10 00:29:35'),
(38, 13, 13, 50.00, 1025, 20, 0.00, 1000.00, NULL, '2026-05-16 22:22:48', '2026-05-16 22:22:48'),
(39, 13, 25, 30.00, 130, 30, 0.00, 900.00, '2026-09-17', '2026-05-16 22:22:48', '2026-05-16 22:22:48'),
(40, 13, 14, 10.00, 360, 50, 0.00, 500.00, NULL, '2026-05-16 22:22:48', '2026-05-16 22:22:48');

-- --------------------------------------------------------

--
-- Table structure for table `quotations`
--

CREATE TABLE `quotations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quotation_no` varchar(255) NOT NULL,
  `tracking_no` varchar(255) DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quotation_date` date NOT NULL,
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `discount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `grand_total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `notes` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotations`
--

INSERT INTO `quotations` (`id`, `quotation_no`, `tracking_no`, `supplier_id`, `quotation_date`, `subtotal`, `discount`, `grand_total`, `notes`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'QTN-20260510-0001', '10-05-2026-173201', NULL, '2026-05-10', 0.00, 0.00, 0.00, NULL, 2, '2026-05-10 11:33:06', '2026-05-10 11:33:06'),
(2, 'QTN-20260510-0002', '10-05-2026-175024', 1, '2026-05-10', 0.00, 0.00, 0.00, NULL, 2, '2026-05-10 11:51:37', '2026-05-10 11:51:37'),
(3, 'QTN-20260511-0003', '11-05-2026-044341', NULL, '2026-05-11', 0.00, 0.00, 0.00, NULL, 2, '2026-05-10 22:44:40', '2026-05-10 22:44:40'),
(4, 'QTN-20260511-0004', '11-05-2026-055829', 5, '2026-05-11', 60000.00, 0.00, 60000.00, NULL, 2, '2026-05-10 23:59:24', '2026-05-14 10:54:22'),
(5, 'QTN-20260515-0005', '15-05-2026-054243', NULL, '2026-05-15', 5400.00, 0.00, 5400.00, NULL, 2, '2026-05-14 23:43:03', '2026-05-14 23:44:10'),
(6, 'QTN-20260515-0006', '15-05-2026-055142', NULL, '2026-05-15', 8500.00, 0.00, 8500.00, NULL, 2, '2026-05-14 23:52:14', '2026-05-14 23:52:14');

-- --------------------------------------------------------

--
-- Table structure for table `quotation_items`
--

CREATE TABLE `quotation_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quotation_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_code` varchar(255) DEFAULT NULL,
  `qty` int(11) NOT NULL DEFAULT 0,
  `price` decimal(15,2) DEFAULT NULL,
  `total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quotation_items`
--

INSERT INTO `quotation_items` (`id`, `quotation_id`, `product_id`, `product_name`, `product_code`, `qty`, `price`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 27, 'Board Duster', 'BD-236', 0, 0.00, 0.00, '2026-05-10 11:33:06', '2026-05-10 11:33:06'),
(2, 1, 19, 'Marker', 'ELEC003', 0, 0.00, 0.00, '2026-05-10 11:33:06', '2026-05-10 11:33:06'),
(3, 1, 14, 'Paper Clip', 'PHAR001', 0, 0.00, 0.00, '2026-05-10 11:33:06', '2026-05-10 11:33:06'),
(4, 1, 25, 'Sharpener', 'PN-123', 0, 0.00, 0.00, '2026-05-10 11:33:06', '2026-05-10 11:33:06'),
(5, 1, 12, 'Scissors', 'FURN001', 0, 0.00, 0.00, '2026-05-10 11:33:06', '2026-05-10 11:33:06'),
(6, 1, 11, 'Clipboard', 'ELEC001', 0, 0.00, 0.00, '2026-05-10 11:33:06', '2026-05-10 11:33:06'),
(7, 1, 13, 'Glue Stick', 'FNB001', 0, 0.00, 0.00, '2026-05-10 11:33:06', '2026-05-10 11:33:06'),
(8, 1, 29, 'Calculator', 'C-758', 0, 0.00, 0.00, '2026-05-10 11:33:06', '2026-05-10 11:33:06'),
(9, 2, 14, 'Paper Clip', 'PHAR001', 50, 0.00, 0.00, '2026-05-10 11:51:37', '2026-05-10 11:51:37'),
(10, 2, 20, 'Eraser', 'CONST001', 20, 0.00, 0.00, '2026-05-10 11:51:37', '2026-05-10 11:51:37'),
(11, 2, 16, 'Scale Ruler', 'ELEC002', 30, 0.00, 0.00, '2026-05-10 11:51:37', '2026-05-10 11:51:37'),
(12, 2, 17, 'Highlighter', 'HOME001', 50, 0.00, 0.00, '2026-05-10 11:51:37', '2026-05-10 11:51:37'),
(13, 3, 15, 'Stapler', 'FNB002', 0, 0.00, 0.00, '2026-05-10 22:44:40', '2026-05-10 22:44:40'),
(14, 3, 16, 'Scale Ruler', 'ELEC002', 0, 0.00, 0.00, '2026-05-10 22:44:40', '2026-05-10 22:44:40'),
(15, 3, 11, 'Clipboard', 'ELEC001', 0, 0.00, 0.00, '2026-05-10 22:44:40', '2026-05-10 22:44:40'),
(18, 4, 27, 'Board Duster', 'BD-236', 120, 200.00, 24000.00, '2026-05-14 10:54:22', '2026-05-14 10:54:22'),
(19, 4, 19, 'Marker', 'ELEC003', 240, 150.00, 36000.00, '2026-05-14 10:54:22', '2026-05-14 10:54:22'),
(22, 5, 13, 'Glue Stick', 'FNB001', 20, 120.00, 2400.00, '2026-05-14 23:44:10', '2026-05-14 23:44:10'),
(23, 5, 15, 'Stapler', 'FNB002', 10, 300.00, 3000.00, '2026-05-14 23:44:10', '2026-05-14 23:44:10'),
(24, 6, 19, 'Marker', 'ELEC003', 20, 200.00, 4000.00, '2026-05-14 23:52:14', '2026-05-14 23:52:14'),
(25, 6, 27, 'Board Duster', 'BD-236', 30, 150.00, 4500.00, '2026-05-14 23:52:14', '2026-05-14 23:52:14');

-- --------------------------------------------------------

--
-- Table structure for table `requisitions`
--

CREATE TABLE `requisitions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `semester_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('pending','issued') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `requisitions`
--

INSERT INTO `requisitions` (`id`, `date`, `user_id`, `semester_id`, `department_id`, `notes`, `status`, `created_at`, `updated_at`) VALUES
(1, '2026-04-24', 2, 3, NULL, 'Paracetamol 500 mg', 'issued', '2026-04-24 11:49:17', '2026-04-26 11:35:22'),
(3, '2026-04-26', 8, 2, NULL, NULL, 'issued', '2026-04-26 11:46:54', '2026-04-26 11:48:09'),
(4, '2026-05-02', 8, 3, NULL, 'Diary', 'issued', '2026-05-02 11:43:11', '2026-05-02 11:44:40'),
(5, '2026-05-09', 8, 2, NULL, 'I need this equipment for this semester', 'issued', '2026-05-09 00:25:17', '2026-05-09 03:20:41'),
(6, '2026-05-09', 18, 1, NULL, NULL, 'issued', '2026-05-09 06:18:00', '2026-05-09 06:19:40'),
(7, '2026-05-17', 18, 2, NULL, NULL, 'issued', '2026-05-16 22:41:23', '2026-05-16 22:51:45');

-- --------------------------------------------------------

--
-- Table structure for table `requisition_items`
--

CREATE TABLE `requisition_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `requisition_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `requisition_items`
--

INSERT INTO `requisition_items` (`id`, `requisition_id`, `product_id`, `qty`, `created_at`, `updated_at`) VALUES
(6, 1, 18, 3, '2026-04-26 11:27:18', '2026-04-26 11:27:18'),
(10, 3, 28, 2, '2026-04-26 11:47:20', '2026-04-26 11:47:20'),
(13, 4, 28, 1, '2026-05-02 11:44:24', '2026-05-02 11:44:24'),
(17, 5, 19, 1, '2026-05-09 03:20:41', '2026-05-09 03:20:41'),
(18, 5, 15, 0, '2026-05-09 03:20:41', '2026-05-09 03:20:41'),
(19, 5, 20, 1, '2026-05-09 03:20:41', '2026-05-09 03:20:41'),
(20, 6, 20, 2, '2026-05-09 06:18:00', '2026-05-09 06:18:00'),
(21, 6, 15, 1, '2026-05-09 06:18:00', '2026-05-09 06:18:00'),
(22, 6, 19, 3, '2026-05-09 06:18:00', '2026-05-09 06:18:00'),
(23, 7, 11, 3, '2026-05-16 22:41:23', '2026-05-16 22:41:23');

-- --------------------------------------------------------

--
-- Table structure for table `return_purchases`
--

CREATE TABLE `return_purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `tracking_no` varchar(255) DEFAULT NULL,
  `note_no` varchar(255) DEFAULT NULL,
  `file_upload` varchar(255) DEFAULT NULL,
  `semester_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('Return','Pending','Ordered') NOT NULL DEFAULT 'Pending',
  `note` text DEFAULT NULL,
  `grand_total` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `return_purchases`
--

INSERT INTO `return_purchases` (`id`, `date`, `tracking_no`, `note_no`, `file_upload`, `semester_id`, `department_id`, `supplier_id`, `discount`, `shipping`, `status`, `note`, `grand_total`, `created_at`, `updated_at`) VALUES
(1, '2025-08-09', NULL, NULL, NULL, NULL, NULL, 5, 0.00, 0.00, 'Return', NULL, 850.00, '2025-08-09 09:37:12', '2025-08-09 09:37:12'),
(2, '2026-04-19', 'PBO-123', 'OBP-2365', 'return-purchase-files/eXBxjYqNYtxmKb5BGlFLtz4LZp6Gh5pOEFSC6vJ3.jpg', 3, 1, 5, 200.00, 300.00, 'Return', 'Return Product, Duster', 1601.00, '2026-04-19 12:51:23', '2026-04-19 12:58:17'),
(3, '2026-04-19', 'P-123', 'P-2365', 'return-purchase-files/VUnvsWIZFjXk3tlZDnxBfWXRwTX6u8No9rpamDda.webp', 3, 1, 5, 0.00, 300.00, 'Return', 'Return.', 45300.00, '2026-04-19 13:06:19', '2026-04-19 13:06:19'),
(4, '2026-05-17', '17-05-2026', 'P-17', NULL, 2, NULL, 1, 0.00, 0.00, 'Pending', NULL, 100.00, '2026-05-16 22:25:37', '2026-05-16 22:25:37');

-- --------------------------------------------------------

--
-- Table structure for table `return_purchase_items`
--

CREATE TABLE `return_purchase_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `return_purchase_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `net_unit_cost` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `return_purchase_items`
--

INSERT INTO `return_purchase_items` (`id`, `return_purchase_id`, `product_id`, `net_unit_cost`, `stock`, `quantity`, `discount`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 14, 45.00, 350, 20, 50.00, 850.00, '2025-08-09 09:37:12', '2025-08-09 09:37:12'),
(4, 2, 25, 150.00, 120, 10, 0.00, 1500.00, '2026-04-19 12:58:17', '2026-04-19 12:58:17'),
(5, 2, 27, 120.00, 80, 10, 0.00, 1200.00, '2026-04-19 12:58:17', '2026-04-19 12:58:17'),
(6, 3, 25, 1500.00, 150, 30, 0.00, 45000.00, '2026-04-19 13:06:19', '2026-04-19 13:06:19'),
(7, 4, 14, 10.00, 370, 10, 0.00, 100.00, '2026-05-16 22:25:37', '2026-05-16 22:25:37');

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
(1, 'Super Admin', 'web', '2025-08-12 08:21:02', '2025-08-12 08:21:02'),
(2, 'Admin', 'web', '2025-08-12 08:23:38', '2025-08-12 08:23:38'),
(3, 'Store Manager', 'web', '2026-04-19 03:10:29', '2026-04-19 03:10:29'),
(4, 'Assistant Manager', 'web', '2026-04-19 03:10:38', '2026-04-19 03:10:38'),
(5, 'Stock Clerk/Warehouse Associate', 'web', '2026-04-19 03:11:00', '2026-04-19 03:11:00'),
(6, 'Accountant/Finance Officer', 'web', '2026-04-19 03:11:15', '2026-04-19 03:11:15'),
(7, 'System Administrator', 'web', '2026-04-19 03:11:25', '2026-04-19 03:11:25'),
(8, 'Procurement Officer', 'web', '2026-04-19 03:11:35', '2026-04-19 03:11:35'),
(9, 'Assistant Professor', 'web', '2026-04-19 03:11:59', '2026-04-20 10:58:29'),
(10, 'Staff', 'web', '2026-04-19 03:12:38', '2026-04-19 03:12:38'),
(11, 'Chairman', 'web', '2026-04-20 10:58:39', '2026-04-20 10:58:39'),
(12, 'DEAN', 'web', '2026-04-20 10:58:47', '2026-04-20 10:58:47');

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
(1, 12),
(9, 12),
(33, 12),
(34, 12),
(35, 12),
(36, 12),
(37, 12),
(58, 12),
(59, 12),
(73, 12),
(75, 12);

-- --------------------------------------------------------

--
-- Table structure for table `semesters`
--

CREATE TABLE `semesters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `semesters`
--

INSERT INTO `semesters` (`id`, `name`, `slug`, `code`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Fall Semester -  2026', NULL, '001', 1, '2026-04-18 11:10:15', '2026-04-20 10:53:29'),
(2, 'Summer Semester - 2026', NULL, '002', 1, '2026-04-18 11:14:57', '2026-04-21 12:15:57'),
(3, 'Spring Semester - 2026', NULL, '003', 1, '2026-04-18 11:16:47', '2026-04-21 12:16:27');

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
('BgRcoz0jEO3Ab85er2iNNCRpCs0kpziw3Wz2FHpx', 18, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiODVHYmRQRXNaVWxoTkprMFo0b2h1a00zZ1RVdlY0ajU2eXJkcWJKWiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxODt9', 1778993545),
('rGs2bCOBJbWnmHdIGWYVvKhK8iznUefduVQ3FkXs', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT; Windows NT 10.0; en-US) WindowsPowerShell/5.1.19041.7291', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieUd5NFU3clRIUVlpdERHb1l0MUF5UGN4ejdxUnJIVFpRQ3RFYmxSOCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZXF1aXNpdGlvbi9wcm9kdWN0L3NlYXJjaD9xdWVyeT1jbCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1778992272),
('tWelUJhN57t3eYXTkri5Z103x2q4PLBJTkUNyfyf', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVHprZ0xscHJ1OG5mSEF4ZUJ6YUVPZm5kem5uWFBrRVpmWHRxMjNjZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1778993743);

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `subcategory_name` varchar(255) NOT NULL,
  `subcategory_slug` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `category_id`, `subcategory_name`, `subcategory_slug`, `created_at`, `updated_at`) VALUES
(1, 1, 'Mobile Phones', 'mobile-phones', NULL, NULL),
(2, 1, 'Laptops & Computers', 'laptops-&-computers', NULL, NULL),
(3, 1, 'Accessories (Chargers, Headphones)', 'accessories-(chargers,-headphones)', NULL, NULL),
(4, 1, 'Home Appliances (TV, Fridge, AC)', 'home-appliances-(tv,-fridge,-ac)', NULL, NULL),
(5, 1, 'Networking Devices (Router, Switch)', 'networking-devices-(router,-switch)', NULL, NULL),
(6, 1, 'Cameras & Security Systems', 'cameras-&-security-systems', NULL, NULL),
(7, 3, 'Tablets & Capsules', 'tablets-&-capsules', NULL, NULL),
(8, 3, 'Syrups', 'syrups', NULL, NULL),
(9, 3, 'Injections', 'injections', NULL, NULL),
(10, 3, 'Medical Devices (Thermometer, BP Machine)', 'medical-devices-(thermometer,-bp-machine)', NULL, NULL),
(11, 3, 'Surgical Items', 'surgical-items', NULL, NULL),
(12, 3, 'Herbal Medicine', 'herbal-medicine', NULL, NULL),
(13, 4, 'Notebooks & Paper', 'notebooks-&-paper', NULL, NULL),
(14, 4, 'Pens & Pencils', 'pens-&-pencils', NULL, NULL),
(15, 4, 'Office Supplies (Stapler, Clips)', 'office-supplies-(stapler,-clips)', NULL, NULL),
(16, 4, 'Art Supplies', 'art-supplies', NULL, NULL),
(17, 4, 'Printer Accessories (Ink, Toner)', 'printer-accessories-(ink,-toner)', NULL, NULL),
(18, 5, 'Office Furniture', 'office-furniture', NULL, NULL),
(19, 5, 'Cabinets', 'cabinets', NULL, NULL),
(20, 5, 'Shelves', 'shelves', NULL, NULL),
(23, 8, 'Whiteboard Accessories', 'whiteboard-accessories', NULL, NULL),
(24, 8, 'Whiteboard Cleaner', 'whiteboard-cleaner', NULL, NULL),
(25, 8, 'Stapling Tools', 'stapling-tools', NULL, NULL),
(26, 8, 'Staple Accessories', 'staple-accessories', NULL, NULL),
(27, 8, 'Document Storage', 'document-storage', NULL, NULL),
(28, 8, 'Writing Board', 'writing-board', NULL, NULL),
(29, 9, 'Engineering Paper', 'engineering-paper', NULL, NULL),
(30, 9, 'Assignment Materials', 'assignment-materials', NULL, NULL),
(31, 9, 'Writing Pad', 'writing-pad', NULL, NULL),
(32, 10, 'ID Accessories', 'id-accessories', NULL, NULL),
(33, 11, 'Computer Mouse', 'computer-mouse', NULL, NULL),
(34, 11, 'Keyboard', 'keyboard', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `email`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Matador Group', 'matador@gmail.com', '01713000001', 'Akij House, 198 Bir Uttam Mir Shawkat Sarak, Tejgaon, Dhaka', '2025-08-09 07:51:21', '2026-05-10 10:31:12'),
(2, 'Navana Stationery', 'navana@gmail.com', '01713000002', 'PRAN Industrial Park, Palash, Narsingdi', '2025-08-09 07:51:54', '2026-05-10 10:31:43'),
(3, 'Deli Bangladesh', 'deli@gmail.bd.com', '01713000003', 'ACI Centre, 245 Tejgaon I/A, Dhaka', '2025-08-09 07:52:31', '2026-05-10 10:30:35'),
(4, 'Square Toiletries Ltd.', 'supply@squaregroup.com', '01713000004', 'Square Centre, 48 Mohakhali, Dhaka', '2025-08-09 07:53:10', '2025-08-09 07:53:10'),
(5, 'Doms Bangladesh', 'doms@gmail.com.bd', '01713000005', 'Fresh Villa, Gulshan Avenue, Dhaka', '2025-08-09 07:53:39', '2026-05-10 10:30:07'),
(6, 'Bashundhara Paper Mills', 'bashundhara@gmail.com', '01713000075', 'Purbachal, Dhaka', '2026-05-10 10:32:26', '2026-05-10 10:32:26'),
(7, 'Wildcraft Bangladesh', 'wildcraft@gmail.com', '01710000067', 'Dhaka', '2026-05-10 10:33:13', '2026-05-10 10:33:13'),
(8, 'Smart Technologies BD', 'smartechnologies@gmail.com', '017130000035', 'Dhaka', '2026-05-10 10:33:54', '2026-05-10 10:33:54'),
(9, 'Star Tech', 'startech@gmail.com', '01710000054', 'Dhaka', '2026-05-10 10:34:26', '2026-05-10 10:34:26'),
(10, 'Super Star Group', 'superstar@gmail.com', '01713000061', 'Dhaka', '2026-05-10 10:34:54', '2026-05-10 10:34:54'),
(11, 'Casio Bangladesh', 'casio@gmail.com', '01713000058', 'Dhaka', '2026-05-10 10:35:23', '2026-05-10 10:35:23'),
(12, 'Fresh Tissue', 'fresh@gmail.com', '01713000587', 'Dhaka', '2026-05-10 10:36:14', '2026-05-10 10:36:14'),
(13, 'Ryans Computers', 'ryanscomputers@gmail.com', '01713000587', 'Dhaka', '2026-05-10 10:37:04', '2026-05-10 10:37:04'),
(14, 'Global Brand Pvt Ltd', 'globalbrandltd@gmail.com', '01713000364', 'Dhaka', '2026-05-10 10:37:37', '2026-05-10 10:37:37'),
(15, 'Navneet Bangladesh', 'navneet@gmail.com', '01713000958', 'Dhaka', '2026-05-10 10:38:15', '2026-05-10 10:38:15'),
(16, 'Double A Bangladesh', 'doublea@gmail.com', '01710000587', 'Dhaka', '2026-05-10 10:38:55', '2026-05-10 10:38:55'),
(17, '3M Bangladesh', '3mbangladesh@gmail.com', '01710000968', 'Dhaka', '2026-05-10 10:39:30', '2026-05-10 10:39:30'),
(18, 'Fevicol Bangladesh', 'fevicol@gmail.com', '01713000457', 'Dhaka', '2026-05-10 10:40:05', '2026-05-10 10:40:05'),
(19, 'Kangaro Bangladesh', 'kangaro@gmail.com', '01710000569', 'Dhaka', '2026-05-10 10:40:38', '2026-05-10 10:40:38'),
(20, 'Faber-Castell Bangladesh', 'fabercastell@gmail.com', '01710000698', 'Dhaka', '2026-05-10 10:41:20', '2026-05-10 10:41:20'),
(21, 'Momen Stationery', 'momenstationery@gmail.com', '01710000258', 'Dhaka', '2026-05-10 10:41:54', '2026-05-10 10:41:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `status` varchar(255) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `active_status` tinyint(1) NOT NULL DEFAULT 0,
  `avatar` varchar(255) NOT NULL DEFAULT 'avatar.png',
  `dark_mode` tinyint(1) NOT NULL DEFAULT 0,
  `messenger_color` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `photo`, `phone`, `address`, `department_id`, `role`, `status`, `remember_token`, `created_at`, `updated_at`, `active_status`, `avatar`, `dark_mode`, `messenger_color`) VALUES
(1, 'Test User', 'test@example.com', '2025-07-23 08:50:23', '$2y$12$/TwQMK22Whk4wK1DUlTnzeLkv2wsVqdnLV/Zq9SwlvbRyWxa0FiPC', NULL, NULL, NULL, NULL, 'user', '1', 'rmTCxgCo5T', '2025-07-23 08:50:23', '2025-07-23 08:50:23', 0, 'avatar.png', 0, NULL),
(2, 'Admin', 'admin@gmail.com', '2025-07-23 14:54:39', '$2y$12$9Tj1iLmahV6dOZUesUT93uJ2XIgTZIcLq/4/ZwfVOpKlldA3QPkTu', '1755009448.png', NULL, NULL, 7, 'admin', '1', 'fDOlbmQMrjj6teNgT9exAdOeeSi4yGBIcmMmUa454VZxzFYfDvYdcz7HR6pt', '2025-07-23 08:51:59', '2026-05-14 10:58:10', 1, 'avatar.png', 0, '#3F51B5'),
(5, 'Sakib', 'sakib@gmail.com', NULL, '$2y$12$UDklzywveVvuF8k.rPlXouXQTRKcpt7zKy6NIEkW1jC1GSQPMB5VG', NULL, NULL, NULL, 8, 'admin', '1', NULL, '2026-04-18 12:50:16', '2026-04-18 12:50:16', 0, 'avatar.png', 0, NULL),
(7, 'Ayon', 'ayon@gmail.com', NULL, '$2y$12$YRse7R89XRBG409UjQrl9.h5CgxvBcHTPCN5YwkL/sYEtQuu7Y3g.', '1777049313.jpg', NULL, NULL, 3, 'admin', '1', NULL, '2026-04-21 12:24:10', '2026-04-24 10:48:33', 0, 'avatar.png', 0, NULL),
(8, 'Ariyan', 'ariyan@gmail.com', NULL, '$2y$12$2fcStRHRN4.0ZPQ0tF/laeN6t4in3KWewHNtjgj1SeKpa.xRMvuge', '1777225118.jpg', NULL, NULL, 13, 'admin', '1', NULL, '2026-04-21 12:27:03', '2026-05-11 10:11:52', 0, 'avatar.png', 0, NULL),
(9, 'Md Rahman', 'md.rahman@company.bd', NULL, '$2y$12$lyteG.GlFcGTYEKJs0Ttj.1PhY2Lqt101yjhMsjIjuR7/4tjt7B.q', NULL, NULL, NULL, 1, 'admin', '1', NULL, '2026-04-21 12:29:23', '2026-04-21 12:29:23', 0, 'avatar.png', 0, NULL),
(10, 'Karim Hassan', 'karim.hassan@company.bd', NULL, '$2y$12$i2ya3SJMUPSzj85ZsDFDXeNpXKepkiR83vfQ6BSukBZG2miY5EbXm', NULL, NULL, NULL, 13, 'admin', '1', NULL, '2026-04-21 12:29:54', '2026-04-21 12:29:54', 0, 'avatar.png', 0, NULL),
(11, 'Abdul Hasib', 'abdul.hasib@company.bd', NULL, '$2y$12$8vV4RiU/WtqAaMT4V15OoOICg/8OjdUWsV61e1hkLPDVqaAB9d9la', NULL, NULL, NULL, 10, 'admin', '1', NULL, '2026-04-21 12:30:25', '2026-04-21 12:30:25', 0, 'avatar.png', 0, NULL),
(12, 'Rifat Hasan', 'rifat.hasan@company.bd', NULL, '$2y$12$yGZ4foWBGjoiiNbAlPQesO7vJOn0xJoYfm/wSn20spIu0EnpJsAKy', NULL, NULL, NULL, 5, 'admin', '1', NULL, '2026-04-21 12:30:48', '2026-04-21 12:30:48', 0, 'avatar.png', 0, NULL),
(13, 'Nasrin Sultana', 'nasrin.sultana@company.bd', NULL, '$2y$12$j/EV.pUK7nQTePGSJHLq/eIUfsypP/arRUWxeyPbvd4ux/U1jhcLa', NULL, NULL, NULL, 3, 'admin', '1', NULL, '2026-04-21 12:31:08', '2026-04-21 12:31:08', 0, 'avatar.png', 0, NULL),
(14, 'Imran Khan', 'imran.khan@company.bd', NULL, '$2y$12$73TJZF3z1NLGZM3NG15Vd.YA4zomvaeijHZfkdNmeyCzS7.Tgzks2', NULL, NULL, NULL, 2, 'admin', '1', NULL, '2026-04-21 12:31:32', '2026-04-21 12:31:32', 0, 'avatar.png', 0, NULL),
(15, 'Ayesha Dey', 'ayesha.dey@company.bd', NULL, '$2y$12$zagzP4b1QpK25YYxNvXThe.b.Mabo14MFKX3O.tgvhJGi5CFumuBW', NULL, NULL, NULL, 9, 'admin', '1', NULL, '2026-04-21 12:32:00', '2026-04-21 12:32:00', 0, 'avatar.png', 0, NULL),
(16, 'BadhonRoy', 'badhon.roy@company.bd', NULL, '$2y$12$Mc7zoB.gr3t24ZR1JqsOAeVwEU26LKbS9O7W9fMCB3IcMscLCYkR2', NULL, NULL, NULL, 4, 'admin', '1', NULL, '2026-04-21 12:32:26', '2026-04-21 12:32:26', 0, 'avatar.png', 0, NULL),
(17, 'LubnaHaque', 'lubna.haque@company.bd', NULL, '$2y$12$rhZeeGMBl2zkOyJZh0.8audz5qYn91tjBQUJCsMbCW9CKRS3n93hO', NULL, NULL, NULL, 8, 'admin', '1', NULL, '2026-04-21 12:32:53', '2026-04-21 12:32:53', 0, 'avatar.png', 0, NULL),
(18, 'Dean', 'dean@gmail.com', NULL, '$2y$12$Y8qq3N6tHr5GuLzj75fFaumeXfNSFnFJeqaVJlaVqy5RlccfCpbDC', '1778328996.jpg', NULL, NULL, 3, 'admin', '1', NULL, '2026-05-09 06:15:30', '2026-05-14 11:35:22', 1, 'avatar.png', 0, NULL),
(19, 'Super Admin', 'superadmin@gmail.com', NULL, '$2y$12$RqP/zkjPZuTeNo9hzka.8erwBTGlKPvkgb9ahcDW81ORz0wF.VeY2', '1778492920.jpg', NULL, NULL, 3, 'admin', '1', NULL, '2026-05-11 03:18:56', '2026-05-11 04:37:20', 1, 'avatar.png', 0, NULL),
(20, 'Assistant Manager', 'assistantmanager@gmail.com', NULL, '$2y$12$OiU1Ex882hlEyFft8Bfb4O8xjQ6xnN.jGNNSa1aCwVjEN2bPX/AQ2', NULL, NULL, NULL, 8, 'admin', '1', NULL, '2026-05-11 04:58:41', '2026-05-11 04:58:41', 0, 'avatar.png', 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
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
-- Indexes for table `ch_favorites`
--
ALTER TABLE `ch_favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ch_messages`
--
ALTER TABLE `ch_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `damage_products`
--
ALTER TABLE `damage_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `damage_products_semester_id_foreign` (`semester_id`);

--
-- Indexes for table `damage_product_items`
--
ALTER TABLE `damage_product_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `damage_product_items_damage_product_id_foreign` (`damage_product_id`),
  ADD KEY `damage_product_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `issues`
--
ALTER TABLE `issues`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issues_requisition_id_foreign` (`requisition_id`),
  ADD KEY `issues_user_id_foreign` (`user_id`),
  ADD KEY `issues_issued_by_foreign` (`issued_by`),
  ADD KEY `issues_semester_id_foreign` (`semester_id`),
  ADD KEY `issues_department_id_foreign` (`department_id`);

--
-- Indexes for table `issue_items`
--
ALTER TABLE `issue_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issue_items_issue_id_foreign` (`issue_id`),
  ADD KEY `issue_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `issue_returns`
--
ALTER TABLE `issue_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issue_returns_issue_id_foreign` (`issue_id`),
  ADD KEY `issue_returns_user_id_foreign` (`user_id`),
  ADD KEY `issue_returns_created_by_foreign` (`created_by`),
  ADD KEY `issue_returns_semester_id_foreign` (`semester_id`);

--
-- Indexes for table `issue_return_items`
--
ALTER TABLE `issue_return_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issue_return_items_issue_return_id_foreign` (`issue_return_id`),
  ADD KEY `issue_return_items_product_id_foreign` (`product_id`);

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_brand_id_foreign` (`brand_id`),
  ADD KEY `products_supplier_id_foreign` (`supplier_id`),
  ADD KEY `products_subcategory_id_foreign` (`subcategory_id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_role_permissions`
--
ALTER TABLE `product_role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_role_permissions_product_id_role_id_unique` (`product_id`,`role_id`),
  ADD KEY `product_role_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchases_supplier_id_foreign` (`supplier_id`),
  ADD KEY `purchases_semester_id_foreign` (`semester_id`),
  ADD KEY `purchases_department_id_foreign` (`department_id`),
  ADD KEY `purchases_user_id_foreign` (`user_id`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchase_items_purchase_id_foreign` (`purchase_id`),
  ADD KEY `purchase_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `quotations`
--
ALTER TABLE `quotations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `quotations_quotation_no_unique` (`quotation_no`),
  ADD KEY `quotations_supplier_id_foreign` (`supplier_id`),
  ADD KEY `quotations_created_by_foreign` (`created_by`);

--
-- Indexes for table `quotation_items`
--
ALTER TABLE `quotation_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quotation_items_quotation_id_foreign` (`quotation_id`),
  ADD KEY `quotation_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `requisitions`
--
ALTER TABLE `requisitions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requisitions_user_id_foreign` (`user_id`),
  ADD KEY `requisitions_semester_id_foreign` (`semester_id`),
  ADD KEY `requisitions_department_id_foreign` (`department_id`);

--
-- Indexes for table `requisition_items`
--
ALTER TABLE `requisition_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requisition_items_requisition_id_foreign` (`requisition_id`),
  ADD KEY `requisition_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `return_purchases`
--
ALTER TABLE `return_purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `return_purchases_supplier_id_foreign` (`supplier_id`),
  ADD KEY `return_purchases_semester_id_foreign` (`semester_id`),
  ADD KEY `return_purchases_department_id_foreign` (`department_id`);

--
-- Indexes for table `return_purchase_items`
--
ALTER TABLE `return_purchase_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `return_purchase_items_return_purchase_id_foreign` (`return_purchase_id`),
  ADD KEY `return_purchase_items_product_id_foreign` (`product_id`);

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
-- Indexes for table `semesters`
--
ALTER TABLE `semesters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subcategories_category_id_foreign` (`category_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `suppliers_email_unique` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_department_id_foreign` (`department_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `damage_products`
--
ALTER TABLE `damage_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `damage_product_items`
--
ALTER TABLE `damage_product_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issues`
--
ALTER TABLE `issues`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `issue_items`
--
ALTER TABLE `issue_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `issue_returns`
--
ALTER TABLE `issue_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `issue_return_items`
--
ALTER TABLE `issue_return_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `product_role_permissions`
--
ALTER TABLE `product_role_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `quotations`
--
ALTER TABLE `quotations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `quotation_items`
--
ALTER TABLE `quotation_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `requisitions`
--
ALTER TABLE `requisitions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `requisition_items`
--
ALTER TABLE `requisition_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `return_purchases`
--
ALTER TABLE `return_purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `return_purchase_items`
--
ALTER TABLE `return_purchase_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `semesters`
--
ALTER TABLE `semesters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `damage_products`
--
ALTER TABLE `damage_products`
  ADD CONSTRAINT `damage_products_semester_id_foreign` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `damage_product_items`
--
ALTER TABLE `damage_product_items`
  ADD CONSTRAINT `damage_product_items_damage_product_id_foreign` FOREIGN KEY (`damage_product_id`) REFERENCES `damage_products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `damage_product_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `issues`
--
ALTER TABLE `issues`
  ADD CONSTRAINT `issues_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `issues_issued_by_foreign` FOREIGN KEY (`issued_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `issues_requisition_id_foreign` FOREIGN KEY (`requisition_id`) REFERENCES `requisitions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `issues_semester_id_foreign` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `issues_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `issue_items`
--
ALTER TABLE `issue_items`
  ADD CONSTRAINT `issue_items_issue_id_foreign` FOREIGN KEY (`issue_id`) REFERENCES `issues` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `issue_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `issue_returns`
--
ALTER TABLE `issue_returns`
  ADD CONSTRAINT `issue_returns_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `issue_returns_issue_id_foreign` FOREIGN KEY (`issue_id`) REFERENCES `issues` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `issue_returns_semester_id_foreign` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `issue_returns_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `issue_return_items`
--
ALTER TABLE `issue_return_items`
  ADD CONSTRAINT `issue_return_items_issue_return_id_foreign` FOREIGN KEY (`issue_return_id`) REFERENCES `issue_returns` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `issue_return_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

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
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_role_permissions`
--
ALTER TABLE `product_role_permissions`
  ADD CONSTRAINT `product_role_permissions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_role_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `purchases_semester_id_foreign` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `purchases_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `quotations`
--
ALTER TABLE `quotations`
  ADD CONSTRAINT `quotations_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quotations_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `quotation_items`
--
ALTER TABLE `quotation_items`
  ADD CONSTRAINT `quotation_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `quotation_items_quotation_id_foreign` FOREIGN KEY (`quotation_id`) REFERENCES `quotations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `requisitions`
--
ALTER TABLE `requisitions`
  ADD CONSTRAINT `requisitions_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `requisitions_semester_id_foreign` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `requisitions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `requisition_items`
--
ALTER TABLE `requisition_items`
  ADD CONSTRAINT `requisition_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `requisition_items_requisition_id_foreign` FOREIGN KEY (`requisition_id`) REFERENCES `requisitions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `return_purchases`
--
ALTER TABLE `return_purchases`
  ADD CONSTRAINT `return_purchases_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `return_purchases_semester_id_foreign` FOREIGN KEY (`semester_id`) REFERENCES `semesters` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `product_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
