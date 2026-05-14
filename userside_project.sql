-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2026 at 08:23 AM
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
-- Database: `userside_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address_line1` varchar(255) NOT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `pincode` varchar(6) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'home',
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `full_name`, `phone`, `address_line1`, `address_line2`, `city`, `state`, `pincode`, `type`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 2, 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', NULL, 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'home', 1, '2026-04-09 11:33:54', '2026-04-09 11:33:54');

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
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
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
  `description` varchar(255) DEFAULT NULL,
  `type` enum('percentage','fixed') NOT NULL,
  `value` decimal(10,2) NOT NULL,
  `min_order_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `max_discount` decimal(10,2) DEFAULT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) NOT NULL DEFAULT 0,
  `per_user_limit` int(11) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `starts_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `description`, `type`, `value`, `min_order_amount`, `max_discount`, `usage_limit`, `used_count`, `per_user_limit`, `is_active`, `starts_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'SAVE10', 'Get 10% off on all orders', 'percentage', 10.00, 0.00, 500.00, 1, 1, 1, 1, NULL, NULL, '2026-04-09 06:10:57', '2026-04-14 07:19:16'),
(2, 'FLAT200', 'Flat ₹200 off on orders above ₹999', 'fixed', 200.00, 999.00, NULL, 100, 0, 1, 1, NULL, NULL, '2026-04-09 06:10:57', '2026-04-09 06:10:57'),
(3, 'WELCOME50', '50% off for new users (max ₹300)', 'percentage', 50.00, 0.00, 300.00, 50, 0, 1, 1, NULL, NULL, '2026-04-09 06:10:57', '2026-04-09 06:10:57'),
(4, 'CARTNOVA500', 'Flat ₹500 off on orders above ₹2999', 'fixed', 500.00, 2999.00, NULL, 20, 0, 1, 1, NULL, NULL, '2026-04-09 06:10:57', '2026-04-09 07:17:26'),
(5, 'FREESHIP', 'Free shipping + ₹100 off', 'fixed', 100.00, 499.00, NULL, NULL, 0, 2, 1, NULL, NULL, '2026-04-09 06:10:57', '2026-04-09 06:10:57');

-- --------------------------------------------------------

--
-- Table structure for table `coupon_usages`
--

CREATE TABLE `coupon_usages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupon_usages`
--

INSERT INTO `coupon_usages` (`id`, `coupon_id`, `user_id`, `order_id`, `discount_amount`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 35, 500.00, '2026-04-14 07:19:16', '2026-04-14 07:19:16');

-- --------------------------------------------------------

--
-- Table structure for table `customer_support`
--

CREATE TABLE `customer_support` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `ticket_number` varchar(20) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `admin_response` text DEFAULT NULL,
  `category` enum('order_issue','payment_problem','product_inquiry','account_help','technical_support','refund_request','general_feedback','complaint','other') NOT NULL,
  `priority` enum('low','medium','high','urgent') NOT NULL DEFAULT 'medium',
  `status` enum('open','in_progress','pending_customer','resolved','closed') NOT NULL DEFAULT 'open',
  `opened_at` timestamp NULL DEFAULT NULL,
  `first_response_at` timestamp NULL DEFAULT NULL,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `closed_at` timestamp NULL DEFAULT NULL,
  `email_notifications` tinyint(1) NOT NULL DEFAULT 1,
  `contact_preference` varchar(255) NOT NULL DEFAULT 'email',
  `order_number` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `product_id` varchar(255) DEFAULT NULL,
  `attachments` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attachments`)),
  `satisfaction_rating` tinyint(4) DEFAULT NULL,
  `feedback_comments` text DEFAULT NULL,
  `internal_notes` text DEFAULT NULL,
  `assigned_to` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_support_notifications`
--

CREATE TABLE `customer_support_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_support_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
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
-- Table structure for table `gift_cards`
--

CREATE TABLE `gift_cards` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `card_number` varchar(20) NOT NULL,
  `card_code` varchar(10) NOT NULL,
  `card_type` varchar(255) NOT NULL,
  `card_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `initial_value` decimal(10,2) NOT NULL,
  `current_balance` decimal(10,2) NOT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'USD',
  `status` enum('active','expired','used','inactive') NOT NULL DEFAULT 'active',
  `expiry_date` date DEFAULT NULL,
  `activated_at` timestamp NULL DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `priority` enum('low','medium','high') NOT NULL DEFAULT 'medium',
  `notify_expiry` tinyint(1) NOT NULL DEFAULT 1,
  `notify_low_balance` tinyint(1) NOT NULL DEFAULT 1,
  `low_balance_threshold` decimal(10,2) NOT NULL DEFAULT 10.00,
  `purchase_source` varchar(255) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `receipt_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(4, '2026_03_30_102421_create_user_table', 1),
(5, '2026_03_30_105804_create_password_reset_tokens_table', 1),
(6, '2026_03_31_085121_create_product_table', 2),
(7, '2026_03_31_085221_seed_product_table', 2),
(8, '2026_04_01_100417_create_cart_items_table', 3),
(9, '2026_04_03_055610_create_orders_table', 4),
(10, '2026_04_06_150722_add_phone_to_users_table', 5),
(11, '2026_04_06_170814_create_addresses_table', 6),
(12, '2026_04_07_121259_create_payment_methods_table', 7),
(13, '2026_04_07_122929_create_wishlists_table', 8),
(14, '2026_04_07_124801_create_gift_cards_table', 9),
(15, '2026_04_07_125741_create_customer_support_table', 10),
(16, '2026_04_07_143320_create_customer_support_notifications_table', 11),
(17, '2026_04_07_162938_add_is_admin_to_users_table', 12),
(18, '2026_04_08_145837_create_wishlists_table', 13),
(19, '2026_04_08_152624_create_reviews_table', 14),
(20, '2026_04_09_113559_create_coupons_table', 15),
(21, '2026_04_09_165512_create_addresses_table', 16),
(22, '2026_04_09_172546_create_saved_items_table', 17),
(23, '2026_04_11_145426_add_sold_count_to_products_table', 18),
(24, '2026_04_11_145735_add_views_to_products_table', 18),
(25, '2026_04_12_111631_add_payment_fields_to_orders_table', 19),
(26, '2026_04_14_201930_create_notifications_table', 20),
(27, '2026_04_16_103526_create_return_requests_table', 21),
(28, '2026_04_16_114416_add_pickup_fields_to_return_requests', 22),
(29, '2026_04_20_121012_add_user_id_to_products_table', 23);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `icon` varchar(255) NOT NULL DEFAULT '?',
  `url` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `title`, `body`, `icon`, `url`, `is_read`, `data`, `created_at`, `updated_at`) VALUES
(6, 2, 'order_confirmed', 'Order Confirmed! 🎉', 'Your order #CNV-260414-69DE759307BE0-500 has been placed. Total: ₹134,900', '✅', 'http://127.0.0.1:8000/orders/CNV-260414-69DE759307BE0-500', 0, '[]', '2026-04-14 17:12:51', '2026-04-14 17:12:51'),
(7, 2, 'order_confirmed', 'Order Confirmed! ✅', '✅ Your order #AMZ-69DDD30C245A2-638 has been confirmed!', '✅', 'http://127.0.0.1:8000/orders/AMZ-69DDD30C245A2-638', 0, '[]', '2026-04-15 05:57:00', '2026-04-15 05:57:00'),
(8, 2, 'order_confirmed', 'Order Confirmed! 🎉', 'Your order #CNV-260415-69DF2CCCCEA99-405 has been placed. Total: ₹64,999', '✅', 'http://127.0.0.1:8000/orders/CNV-260415-69DF2CCCCEA99-405', 0, '[]', '2026-04-15 06:14:36', '2026-04-15 06:14:36'),
(9, 2, 'order_confirmed', 'Order Confirmed! 🎉', 'Your order #CNV-260415-69DF2CEC1419A-482 has been placed. Total: ₹134,900', '✅', 'http://127.0.0.1:8000/orders/CNV-260415-69DF2CEC1419A-482', 0, '[]', '2026-04-15 06:15:08', '2026-04-15 06:15:08'),
(10, 2, 'order_confirmed', 'Order Confirmed! 🎉', 'Your order #CNV-260415-69DF2DAA55638-563 has been placed. Total: ₹44,900', '✅', 'http://127.0.0.1:8000/orders/CNV-260415-69DF2DAA55638-563', 0, '[]', '2026-04-15 06:18:18', '2026-04-15 06:18:18'),
(11, 2, 'order_confirmed', 'Order Confirmed! ✅', '✅ Your order #CNV-260415-69DF2E50B3676-114 has been confirmed!', '✅', 'http://127.0.0.1:8000/orders/CNV-260415-69DF2E50B3676-114', 0, '[]', '2026-04-15 06:27:37', '2026-04-15 06:27:37'),
(12, 2, 'order_confirmed', 'Order Confirmed! 🎉', 'Your order #CNV-260415-69DF3040B16A2-440 has been placed. Total: ₹49,990', '✅', 'http://127.0.0.1:8000/orders/CNV-260415-69DF3040B16A2-440', 0, '[]', '2026-04-15 06:29:20', '2026-04-15 06:29:20'),
(13, 2, 'order_confirmed', 'Order Confirmed! ✅', '✅ Your order #CNV-260415-69DF3040B16A2-440 has been confirmed!', '✅', 'http://127.0.0.1:8000/orders/CNV-260415-69DF3040B16A2-440', 0, '[]', '2026-04-15 06:30:08', '2026-04-15 06:30:08'),
(14, 2, 'order_shipped', 'Order Shipped! 🚚', '🚚 Your order #CNV-260415-69DF3040B16A2-440 has been shipped and is on its way!', '🚚', 'http://127.0.0.1:8000/orders/CNV-260415-69DF3040B16A2-440', 0, '[]', '2026-04-15 06:31:54', '2026-04-15 06:31:54'),
(15, 2, 'order_delivered', 'Order Delivered! 🏠', '🏠 Your order #CNV-260415-69DF3040B16A2-440 has been delivered. Enjoy!', '🏠', 'http://127.0.0.1:8000/orders/CNV-260415-69DF3040B16A2-440', 0, '[]', '2026-04-15 06:32:39', '2026-04-15 06:32:39'),
(16, 2, 'order_confirmed', 'Order Confirmed! ✅', '✅ Your order #CNV-260415-69DF7FB207F39-432 has been confirmed!', '✅', 'http://127.0.0.1:8000/orders/CNV-260415-69DF7FB207F39-432', 0, '[]', '2026-04-16 06:39:19', '2026-04-16 06:39:19'),
(17, 2, 'order_shipped', 'Order Shipped! 🚚', '🚚 Your order #CNV-260415-69DF7FB207F39-432 has been shipped and is on its way!', '🚚', 'http://127.0.0.1:8000/orders/CNV-260415-69DF7FB207F39-432', 0, '[]', '2026-04-16 06:39:52', '2026-04-16 06:39:52'),
(18, 2, 'order_delivered', 'Order Delivered! 🏠', '🏠 Your order #CNV-260415-69DF7FB207F39-432 has been delivered. Enjoy!', '🏠', 'http://127.0.0.1:8000/orders/CNV-260415-69DF7FB207F39-432', 0, '[]', '2026-04-16 06:40:00', '2026-04-16 06:40:00'),
(19, 3, 'order_confirmed', 'Order Confirmed! 🎉', 'Your order #CNV-260420-69E5AB3DAEA6B-684 has been placed. Total: ₹134,900', '✅', 'http://127.0.0.1:8000/orders/CNV-260420-69E5AB3DAEA6B-684', 0, '[]', '2026-04-20 04:27:41', '2026-04-20 04:27:41'),
(20, 3, 'order_confirmed', 'Order Confirmed! ✅', '✅ Your order #CNV-260422-69E87D584D722-979 has been confirmed!', '✅', 'http://127.0.0.1:8000/orders/CNV-260422-69E87D584D722-979', 0, '[]', '2026-04-22 08:01:54', '2026-04-22 08:01:54'),
(21, 3, 'order_shipped', 'Order Shipped! 🚚', '🚚 Your order #CNV-260422-69E87D584D722-979 has been shipped and is on its way!', '🚚', 'http://127.0.0.1:8000/orders/CNV-260422-69E87D584D722-979', 0, '[]', '2026-04-22 08:09:38', '2026-04-22 08:09:38'),
(22, 3, 'order_delivered', 'Order Delivered! 🏠', '🏠 Your order #CNV-260422-69E87D584D722-979 has been delivered. Enjoy!', '🏠', 'http://127.0.0.1:8000/orders/CNV-260422-69E87D584D722-979', 0, '[]', '2026-04-22 08:10:37', '2026-04-22 08:10:37'),
(23, 3, 'order_cancelled', 'Order Cancelled ❌', '❌ Your order #CNV-260422-69E87861163B3-850 has been cancelled.', '❌', 'http://127.0.0.1:8000/orders/CNV-260422-69E87861163B3-850', 0, '[]', '2026-04-22 08:29:19', '2026-04-22 08:29:19'),
(24, 3, 'order_confirmed', 'Order Confirmed! ✅', '✅ Your order #CNV-260420-69E5AB3DAEA6B-684 has been confirmed!', '✅', 'http://127.0.0.1:8000/orders/CNV-260420-69E5AB3DAEA6B-684', 0, '[]', '2026-04-22 08:30:34', '2026-04-22 08:30:34'),
(25, 3, 'order_shipped', 'Order Shipped! 🚚', '🚚 Your order #CNV-260420-69E5AB3DAEA6B-684 has been shipped and is on its way!', '🚚', 'http://127.0.0.1:8000/orders/CNV-260420-69E5AB3DAEA6B-684', 0, '[]', '2026-04-22 08:30:44', '2026-04-22 08:30:44'),
(26, 3, 'order_delivered', 'Order Delivered! 🏠', '🏠 Your order #CNV-260420-69E5AB3DAEA6B-684 has been delivered. Enjoy!', '🏠', 'http://127.0.0.1:8000/orders/CNV-260420-69E5AB3DAEA6B-684', 0, '[]', '2026-04-22 08:30:49', '2026-04-22 08:30:49');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `full_name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address_line1` varchar(255) NOT NULL,
  `address_line2` varchar(255) DEFAULT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `pincode` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL DEFAULT 'cod',
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `razorpay_order_id` varchar(255) DEFAULT NULL,
  `razorpay_payment_id` varchar(255) DEFAULT NULL,
  `razorpay_signature` varchar(255) DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `delivery_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL,
  `notes` text DEFAULT NULL,
  `placed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_number`, `status`, `full_name`, `phone`, `address_line1`, `address_line2`, `city`, `state`, `pincode`, `payment_method`, `payment_status`, `razorpay_order_id`, `razorpay_payment_id`, `razorpay_signature`, `subtotal`, `discount`, `delivery_charge`, `total`, `notes`, `placed_at`, `created_at`, `updated_at`) VALUES
(1, 2, 'AMZ-69CF59CE24FC1-771', 'cancelled', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', NULL, 'AHMEDABAD', 'Gujarat', '380013', 'cod', 'cancelled', NULL, NULL, NULL, 250299.00, 20300.00, 0.00, 250299.00, NULL, '2026-04-03 00:40:22', '2026-04-03 00:40:22', '2026-04-03 01:01:47'),
(2, 2, 'AMZ-69CF5E28D03EE-248', 'pending', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', NULL, 'AHMEDABAD', 'Gujarat', '380013', 'cod', 'pending', NULL, NULL, NULL, 258290.00, 21500.00, 0.00, 258290.00, NULL, '2026-04-03 00:58:56', '2026-04-03 00:58:56', '2026-04-03 00:58:56'),
(3, 2, 'AMZ-69CF5F095E703-884', 'pending', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'AHMEDABAD', 'Gujarat', '380013', 'cod', 'pending', NULL, NULL, NULL, 8995.00, 3000.00, 0.00, 8995.00, NULL, '2026-04-03 01:02:41', '2026-04-03 01:02:41', '2026-04-03 01:02:41'),
(4, 2, 'AMZ-69CF61293C3B7-109', 'cancelled', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'AHMEDABAD', 'Gujarat', '380013', 'cod', 'cancelled', NULL, NULL, NULL, 49596.00, 7700.00, 0.00, 49596.00, NULL, '2026-04-03 01:11:45', '2026-04-03 01:11:45', '2026-04-03 11:18:49'),
(5, 2, 'AMZ-69CF62D6847B4-908', 'pending', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'AHMEDABAD', 'Gujarat', '380013', 'cod', 'pending', NULL, NULL, NULL, 134900.00, 15000.00, 0.00, 134900.00, NULL, '2026-04-03 06:48:54', '2026-04-03 06:48:54', '2026-04-03 06:48:54'),
(6, 2, 'AMZ-69CFA20809131-729', 'confirmed', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'AHMEDABAD', 'Gujarat', '380013', 'card', 'paid', NULL, NULL, NULL, 9995.00, 3000.00, 0.00, 9995.00, NULL, '2026-04-03 11:18:32', '2026-04-03 11:18:32', '2026-04-03 11:18:32'),
(7, 2, 'AMZ-69CFAA9F91B41-396', 'cancelled', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'AHMEDABAD', 'Gujarat', '380013', 'card', 'refund_initiated', NULL, NULL, NULL, 114900.00, 5000.00, 0.00, 114900.00, NULL, '2026-04-03 11:55:11', '2026-04-03 11:55:11', '2026-04-03 11:55:38'),
(8, 2, 'AMZ-69D37881AA7F6-367', 'cancelled', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'AHMEDABAD', 'Gujarat', '380013', 'cod', 'cancelled', NULL, NULL, NULL, 49990.00, 5000.00, 0.00, 49990.00, NULL, '2026-04-06 09:10:25', '2026-04-06 09:10:25', '2026-04-06 09:11:20'),
(9, 2, 'AMZ-69D37B4210B32-984', 'pending', 'MAHEK PANKAJ SHAH', '0932802906', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'cod', 'pending', NULL, NULL, NULL, 44900.00, 5000.00, 0.00, 44900.00, NULL, '2026-04-06 09:22:10', '2026-04-06 09:22:10', '2026-04-06 09:22:10'),
(10, 2, 'AMZ-69D37CE0301AD-506', 'pending', 'MAHEK PANKAJ SHAH', '0932802906', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'cod', 'pending', NULL, NULL, NULL, 1599.00, 700.00, 0.00, 1599.00, NULL, '2026-04-06 09:29:04', '2026-04-06 09:29:04', '2026-04-06 09:29:04'),
(11, 2, 'AMZ-69D39D0BEDAFA-397', 'pending', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'AHMEDABAD', 'Gujarat', '380013', 'cod', 'pending', NULL, NULL, NULL, 134900.00, 15000.00, 0.00, 134900.00, NULL, '2026-04-06 11:46:19', '2026-04-06 11:46:19', '2026-04-06 11:46:19'),
(12, 2, 'AMZ-69D3A067BB2E5-440', 'pending', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'AHMEDABAD', 'Gujarat', '380013', 'cod', 'pending', NULL, NULL, NULL, 114900.00, 5000.00, 0.00, 114900.00, NULL, '2026-04-06 12:00:39', '2026-04-06 12:00:39', '2026-04-06 12:00:39'),
(13, 2, 'AMZ-69D5F3956F0D6-541', 'pending', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'AHMEDABAD', 'Gujarat', '380013', 'cod', 'pending', NULL, NULL, NULL, 149970.00, 15000.00, 0.00, 149970.00, NULL, '2026-04-08 06:20:05', '2026-04-08 06:20:05', '2026-04-08 06:20:05'),
(14, 2, 'AMZ-69D5F7C0E7230-432', 'pending', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'AHMEDABAD', 'Gujarat', '380013', 'cod', 'pending', NULL, NULL, NULL, 499.00, 300.00, 40.00, 539.00, NULL, '2026-04-08 06:37:52', '2026-04-08 06:37:52', '2026-04-08 06:37:52'),
(15, 2, 'AMZ-69D5F8FD0E731-786', 'confirmed', 'MAHEK PANKAJ SHAH', '0932802906', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'card', 'paid', NULL, NULL, NULL, 134900.00, 15000.00, 0.00, 134900.00, NULL, '2026-04-08 06:43:09', '2026-04-08 06:43:09', '2026-04-08 06:43:09'),
(16, 2, 'AMZ-69D5FE0A2A56A-153', 'pending', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'AHMEDABAD', 'Gujarat', '380013', 'cod', 'pending', NULL, NULL, NULL, 499.00, 300.00, 40.00, 539.00, NULL, '2026-04-08 07:04:42', '2026-04-08 07:04:42', '2026-04-08 07:04:42'),
(17, 2, 'AMZ-69D6021788B26-450', 'pending', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'AHMEDABAD', 'Gujarat', '380013', 'cod', 'pending', NULL, NULL, NULL, 89900.00, 10000.00, 0.00, 89900.00, NULL, '2026-04-08 07:21:59', '2026-04-08 07:21:59', '2026-04-08 07:21:59'),
(18, 2, 'AMZ-69D6052B345A1-873', 'pending', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'AHMEDABAD', 'Haryana', '380013', 'cod', 'pending', NULL, NULL, NULL, 89900.00, 10000.00, 0.00, 89900.00, NULL, '2026-04-08 07:35:07', '2026-04-08 07:35:07', '2026-04-08 07:35:07'),
(19, 2, 'AMZ-69D74AE262B20-339', 'pending', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'AHMEDABAD', 'Gujarat', '380013', 'cod', 'pending', NULL, NULL, NULL, 49990.00, 5000.00, 0.00, 49990.00, NULL, '2026-04-09 06:44:50', '2026-04-09 06:44:50', '2026-04-09 06:44:50'),
(20, 2, 'AMZ-69D7530B265C1-873', 'pending', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'AHMEDABAD', 'Goa', '380013', 'cod', 'pending', NULL, NULL, NULL, 135399.00, 15300.00, 0.00, 135399.00, NULL, '2026-04-09 07:19:39', '2026-04-09 07:19:39', '2026-04-09 07:19:39'),
(21, 2, 'AMZ-69D756E16FA90-575', 'pending', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'AHMEDABAD', 'Goa', '380013', 'cod', 'pending', NULL, NULL, NULL, 399.00, 200.00, 40.00, 439.00, NULL, '2026-04-09 07:36:01', '2026-04-09 07:36:01', '2026-04-09 07:36:01'),
(22, 2, 'AMZ-69D7594E04C1A-514', 'pending', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'AHMEDABAD', 'Goa', '380013', 'cod', 'pending', NULL, NULL, NULL, 399.00, 200.00, 40.00, 439.00, NULL, '2026-04-09 07:46:22', '2026-04-09 07:46:22', '2026-04-09 07:46:22'),
(23, 2, 'AMZ-69D77D5A99A04-161', 'pending', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'AHMEDABAD', 'Goa', '380013', 'cod', 'pending', NULL, NULL, NULL, 49990.00, 5000.00, 0.00, 49990.00, NULL, '2026-04-09 10:20:10', '2026-04-09 10:20:10', '2026-04-09 10:20:10'),
(25, 2, 'AMZ-69D78EDFB461E-231', 'pending', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'AHMEDABAD', 'Manipur', '380013', 'cod', 'pending', NULL, NULL, NULL, 49990.00, 5000.00, 0.00, 49990.00, NULL, '2026-04-09 11:34:55', '2026-04-09 11:34:55', '2026-04-09 11:34:55'),
(26, 2, 'AMZ-69D790BBEEB87-418', 'pending', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'AHMEDABAD', 'Karnataka', '380013', 'cod', 'pending', NULL, NULL, NULL, 159890.00, 25000.00, 0.00, 159890.00, NULL, '2026-04-09 11:42:51', '2026-04-09 11:42:51', '2026-04-09 11:42:51'),
(27, 2, 'AMZ-69D7A07C9D894-586', 'pending', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'AHMEDABAD', 'Karnataka', '380013', 'cod', 'pending', NULL, NULL, NULL, 9999.00, 4000.00, 0.00, 9999.00, NULL, '2026-04-09 12:50:04', '2026-04-09 12:50:04', '2026-04-09 12:50:04'),
(28, 2, 'AMZ-69DB4CC39D581-603', 'pending', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'AHMEDABAD', 'Karnataka', '380013', 'cod', 'pending', NULL, NULL, NULL, 189889.00, 18000.00, 0.00, 189889.00, NULL, '2026-04-12 07:41:55', '2026-04-12 07:41:55', '2026-04-12 07:41:55'),
(29, 2, 'AMZ-69DCE007AB3CB-469', 'pending', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'AHMEDABAD', 'Chhattisgarh', '380013', 'cod', 'pending', NULL, NULL, NULL, 49990.00, 5000.00, 0.00, 49990.00, NULL, '2026-04-13 12:22:31', '2026-04-13 12:22:31', '2026-04-13 12:22:31'),
(30, 2, 'AMZ-69DCE43A44E33-923', 'confirmed', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'AHMEDABAD', 'Arunachal Pradesh', '380013', 'razorpay', 'paid', NULL, NULL, NULL, 49990.00, 5000.00, 0.00, 49990.00, NULL, '2026-04-13 12:40:26', '2026-04-13 12:40:26', '2026-04-13 12:40:26'),
(31, 2, 'AMZ-69DCE6BF66172-605', 'confirmed', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'AHMEDABAD', 'Arunachal Pradesh', '380013', 'razorpay', 'paid', NULL, NULL, NULL, 134900.00, 15000.00, 0.00, 134900.00, NULL, '2026-04-13 12:51:11', '2026-04-13 12:51:11', '2026-04-13 12:51:11'),
(32, 2, 'AMZ-69DDC078E5A11-176', 'confirmed', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'AHMEDABAD', 'Arunachal Pradesh', '380013', 'razorpay', 'paid', NULL, NULL, NULL, 44900.00, 5000.00, 0.00, 44900.00, NULL, '2026-04-14 04:20:08', '2026-04-14 04:20:08', '2026-04-14 04:20:08'),
(33, 2, 'AMZ-69DDCDF1294C2-517', 'pending', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', NULL, 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'cod', 'pending', NULL, NULL, NULL, 44900.00, 5000.00, 0.00, 44900.00, NULL, '2026-04-14 05:17:37', '2026-04-14 05:17:37', '2026-04-14 05:17:37'),
(34, 2, 'AMZ-69DDD30C245A2-638', 'confirmed', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', NULL, 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'cod', 'pending', NULL, NULL, NULL, 499.00, 300.00, 40.00, 539.00, NULL, '2026-04-14 05:39:24', '2026-04-14 05:39:24', '2026-04-15 05:57:00'),
(35, 2, 'AMZ-69DDEA74A358B-663', 'confirmed', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'Ahmedabad (M Corp.) (Part)', 'Karnataka', '380013', 'razorpay', 'paid', NULL, NULL, NULL, 179800.00, 500.00, 0.00, 179300.00, NULL, '2026-04-14 07:19:16', '2026-04-14 07:19:16', '2026-04-14 07:19:16'),
(36, 2, 'AMZ-69DE45161425B-353', 'shipped', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', NULL, 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'razorpay', 'paid', NULL, NULL, NULL, 499.00, 0.00, 40.00, 539.00, NULL, '2026-04-14 13:45:58', '2026-04-14 13:45:58', '2026-04-14 14:15:40'),
(37, 2, 'AMZ-69DE4CB344E68-888', 'confirmed', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'razorpay', 'paid', NULL, NULL, NULL, 44900.00, 0.00, 0.00, 44900.00, NULL, '2026-04-14 14:18:27', '2026-04-14 14:18:27', '2026-04-14 14:18:27'),
(38, 2, 'AMZ-69DE58FC90068-398', 'confirmed', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'razorpay', 'paid', NULL, NULL, NULL, 9999.00, 0.00, 0.00, 9999.00, NULL, '2026-04-14 15:10:52', '2026-04-14 15:10:52', '2026-04-14 15:10:52'),
(39, 2, 'CNV-260414-69DE759307BE0-500', 'cancelled', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'cod', 'cancelled', NULL, NULL, NULL, 134900.00, 15000.00, 0.00, 134900.00, NULL, '2026-04-14 17:12:51', '2026-04-14 17:12:51', '2026-04-14 17:14:15'),
(40, 2, 'CNV-260414-69DE7841591F2-893', 'confirmed', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'razorpay', 'paid', NULL, NULL, NULL, 44900.00, 0.00, 0.00, 44900.00, NULL, '2026-04-14 17:24:17', '2026-04-14 17:24:17', '2026-04-14 17:24:17'),
(41, 2, 'CNV-260414-69DE7BB6ADDB6-379', 'confirmed', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'razorpay', 'paid', NULL, NULL, NULL, 89900.00, 0.00, 0.00, 89900.00, NULL, '2026-04-14 17:39:02', '2026-04-14 17:39:02', '2026-04-14 17:39:02'),
(42, 2, 'CNV-260414-69DE80164F615-913', 'confirmed', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'razorpay', 'paid', NULL, NULL, NULL, 124999.00, 0.00, 0.00, 124999.00, NULL, '2026-04-14 17:57:42', '2026-04-14 17:57:42', '2026-04-14 17:57:42'),
(43, 2, 'CNV-260414-69DE8057BC542-247', 'confirmed', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'razorpay', 'paid', NULL, NULL, NULL, 134900.00, 0.00, 0.00, 134900.00, NULL, '2026-04-14 17:58:47', '2026-04-14 17:58:47', '2026-04-14 17:58:47'),
(44, 2, 'CNV-260414-69DE80A3E5304-174', 'confirmed', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'razorpay', 'paid', NULL, NULL, NULL, 134900.00, 0.00, 0.00, 134900.00, NULL, '2026-04-14 18:00:03', '2026-04-14 18:00:03', '2026-04-14 18:00:03'),
(45, 2, 'CNV-260415-69DF2946AB0CD-990', 'pending', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'razorpay', 'paid', NULL, NULL, NULL, 8490.00, 0.00, 0.00, 8490.00, NULL, '2026-04-15 05:59:34', '2026-04-15 05:59:34', '2026-04-15 05:59:34'),
(46, 2, 'CNV-260415-69DF2CCCCEA99-405', 'pending', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'cod', 'pending', NULL, NULL, NULL, 64999.00, 5000.00, 0.00, 64999.00, NULL, '2026-04-15 06:14:36', '2026-04-15 06:14:36', '2026-04-15 06:14:36'),
(47, 2, 'CNV-260415-69DF2CEC1419A-482', 'pending', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'cod', 'pending', NULL, NULL, NULL, 134900.00, 15000.00, 0.00, 134900.00, NULL, '2026-04-15 06:15:08', '2026-04-15 06:15:08', '2026-04-15 06:15:08'),
(48, 2, 'CNV-260415-69DF2DAA55638-563', 'pending', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'cod', 'pending', NULL, NULL, NULL, 44900.00, 5000.00, 0.00, 44900.00, NULL, '2026-04-15 06:18:18', '2026-04-15 06:18:18', '2026-04-15 06:18:18'),
(49, 2, 'CNV-260415-69DF2E50B3676-114', 'confirmed', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'razorpay', 'paid', NULL, NULL, NULL, 499.00, 0.00, 40.00, 539.00, NULL, '2026-04-15 06:21:04', '2026-04-15 06:21:04', '2026-04-15 06:27:37'),
(50, 2, 'CNV-260415-69DF3040B16A2-440', 'returned', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'cod', 'pending', NULL, NULL, NULL, 49990.00, 5000.00, 0.00, 49990.00, NULL, '2026-04-15 06:29:20', '2026-04-15 06:29:20', '2026-04-16 06:43:28'),
(51, 2, 'CNV-260415-69DF7FB207F39-432', 'returned', 'MAHEK PANKAJ SHAH', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'razorpay', 'paid', NULL, NULL, NULL, 229800.00, 0.00, 0.00, 229800.00, NULL, '2026-04-15 12:08:18', '2026-04-15 12:08:18', '2026-04-16 06:43:06'),
(52, 3, 'CNV-260417-69E210AB5ABC5-449', 'pending', 'Radhe', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'razorpay', 'paid', NULL, NULL, NULL, 180299.00, 0.00, 0.00, 180299.00, NULL, '2026-04-17 10:51:23', '2026-04-17 10:51:23', '2026-04-17 10:51:23'),
(53, 3, 'CNV-260417-69E21D5275347-849', 'pending', 'Radhe', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'razorpay', 'paid', NULL, NULL, NULL, 44900.00, 0.00, 0.00, 44900.00, NULL, '2026-04-17 11:45:22', '2026-04-17 11:45:22', '2026-04-17 11:45:22'),
(54, 3, 'CNV-260417-69E225AD1785F-934', 'pending', 'Radhe', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'razorpay', 'paid', NULL, NULL, NULL, 499.00, 0.00, 40.00, 539.00, NULL, '2026-04-17 12:21:01', '2026-04-17 12:21:01', '2026-04-17 12:21:01'),
(55, 3, 'CNV-260420-69E5AAD114F00-791', 'cancelled', 'Radhe', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'razorpay', 'refund_initiated', NULL, NULL, NULL, 134900.00, 0.00, 0.00, 134900.00, NULL, '2026-04-20 04:25:53', '2026-04-20 04:25:53', '2026-04-22 08:31:15'),
(56, 3, 'CNV-260420-69E5AB3DAEA6B-684', 'delivered', 'Radhe', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'cod', 'pending', NULL, NULL, NULL, 134900.00, 15000.00, 0.00, 134900.00, NULL, '2026-04-20 04:27:41', '2026-04-20 04:27:41', '2026-04-22 08:30:49'),
(57, 3, 'CNV-260422-69E87861163B3-850', 'cancelled', 'Radhe', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'razorpay', 'paid', NULL, NULL, NULL, 134900.00, 0.00, 0.00, 134900.00, NULL, '2026-04-22 07:27:29', '2026-04-22 07:27:29', '2026-04-22 08:29:19'),
(58, 3, 'CNV-260422-69E87D584D722-979', 'returned', 'Radhe', '9327850406', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', '19 DREAMLAND PARK SOCIETY OPP PATHIK SOCIETY NARANPURA CHAR RASTA', 'Ahmedabad (M Corp.) (Part)', 'Gujarat', '380013', 'razorpay', 'paid', NULL, NULL, NULL, 134900.00, 0.00, 0.00, 134900.00, NULL, '2026-04-22 07:48:40', '2026-04-22 07:48:40', '2026-04-22 08:26:21');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_brand` varchar(255) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `original_price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `product_brand`, `product_image`, `price`, `original_price`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 7, 'Atomic Habits by James Clear', 'Penguin', 'images/products/atomic-habits.jpg', 499.00, 799.00, 1, 499.00, '2026-04-03 00:40:22', '2026-04-03 00:40:22'),
(2, 1, 1, 'Apple iPhone 15 Pro Max 256GB', 'Apple', 'images/products/iphone15.jpg', 134900.00, 149900.00, 1, 134900.00, '2026-04-03 00:40:22', '2026-04-03 00:40:22'),
(3, 1, 4, 'Apple MacBook Air M3 13-inch', 'Apple', 'images/products/macbook-air.jpg', 114900.00, 119900.00, 1, 114900.00, '2026-04-03 00:40:22', '2026-04-03 00:40:22'),
(4, 2, 4, 'Apple MacBook Air M3 13-inch', 'Apple', 'images/products/macbook-air.jpg', 114900.00, 119900.00, 1, 114900.00, '2026-04-03 00:58:56', '2026-04-03 00:58:56'),
(5, 2, 34, 'Ray-Ban Aviator Sunglasses', 'Ray-Ban', 'images/products/rayban.jpg', 8490.00, 9990.00, 1, 8490.00, '2026-04-03 00:58:56', '2026-04-03 00:58:56'),
(6, 2, 1, 'Apple iPhone 15 Pro Max 256GB', 'Apple', 'images/products/iphone15.jpg', 134900.00, 149900.00, 1, 134900.00, '2026-04-03 00:58:56', '2026-04-03 00:58:56'),
(7, 3, 12, 'Philips Air Fryer HD9200', 'Philips', 'images/products/philips-airfryer.jpg', 8995.00, 11995.00, 1, 8995.00, '2026-04-03 01:02:41', '2026-04-03 01:02:41'),
(8, 4, 17, 'Apple Watch Series 9 GPS 45mm', 'Apple', 'images/products/apple-watch.jpg', 44900.00, 49900.00, 1, 44900.00, '2026-04-03 01:11:45', '2026-04-03 01:11:45'),
(9, 4, 40, 'Fabindia Womens Kurta', 'Fabindia', 'images/products/fabindia-kurta.jpg', 1599.00, 2299.00, 1, 1599.00, '2026-04-03 01:11:45', '2026-04-03 01:11:45'),
(10, 4, 52, 'Strauss Adjustable Dumbbell 10kg', 'Strauss', 'images/products/dumbbell.jpg', 1499.00, 2499.00, 1, 1499.00, '2026-04-03 01:11:45', '2026-04-03 01:11:45'),
(11, 4, 49, 'Cosco Football Size 5', 'Cosco', 'images/products/cosco-football.jpg', 799.00, 1299.00, 2, 1598.00, '2026-04-03 01:11:45', '2026-04-03 01:11:45'),
(12, 5, 1, 'Apple iPhone 15 Pro Max 256GB', 'Apple', 'images/products/iphone15.jpg', 134900.00, 149900.00, 1, 134900.00, '2026-04-03 06:48:54', '2026-04-03 06:48:54'),
(13, 6, 10, 'Nike Air Max 270 Sneakers', 'Nike', 'images/products/nike-airmax.png', 9995.00, 12995.00, 1, 9995.00, '2026-04-03 11:18:32', '2026-04-03 11:18:32'),
(14, 7, 4, 'Apple MacBook Air M3 13-inch', 'Apple', 'images/products/macbook-air.jpg', 114900.00, 119900.00, 1, 114900.00, '2026-04-03 11:55:11', '2026-04-03 11:55:11'),
(15, 8, 19, 'Sony PlayStation 5 Slim', 'Sony', 'images/products/ps5.jpg', 49990.00, 54990.00, 1, 49990.00, '2026-04-06 09:10:25', '2026-04-06 09:10:25'),
(16, 9, 17, 'Apple Watch Series 9 GPS 45mm', 'Apple', 'images/products/apple-watch.jpg', 44900.00, 49900.00, 1, 44900.00, '2026-04-06 09:22:10', '2026-04-06 09:22:10'),
(17, 10, 40, 'Fabindia Womens Kurta', 'Fabindia', 'images/products/fabindia-kurta.jpg', 1599.00, 2299.00, 1, 1599.00, '2026-04-06 09:29:04', '2026-04-06 09:29:04'),
(18, 11, 1, 'Apple iPhone 15 Pro Max 256GB', 'Apple', 'images/products/iphone15.jpg', 134900.00, 149900.00, 1, 134900.00, '2026-04-06 11:46:19', '2026-04-06 11:46:19'),
(19, 12, 4, 'Apple MacBook Air M3 13-inch', 'Apple', 'images/products/macbook-air.jpg', 114900.00, 119900.00, 1, 114900.00, '2026-04-06 12:00:39', '2026-04-06 12:00:39'),
(20, 13, 19, 'Sony PlayStation 5 Slim', 'Sony', 'images/products/ps5.jpg', 49990.00, 54990.00, 3, 149970.00, '2026-04-08 06:20:05', '2026-04-08 06:20:05'),
(21, 14, 7, 'Atomic Habits by James Clear', 'Penguin', 'images/products/atomic-habits.jpg', 499.00, 799.00, 1, 499.00, '2026-04-08 06:37:52', '2026-04-08 06:37:52'),
(22, 15, 1, 'Apple iPhone 15 Pro Max 256GB', 'Apple', 'images/products/iphone15.jpg', 134900.00, 149900.00, 1, 134900.00, '2026-04-08 06:43:09', '2026-04-08 06:43:09'),
(23, 16, 7, 'Atomic Habits by James Clear', 'Penguin', 'images/products/atomic-habits.jpg', 499.00, 799.00, 1, 499.00, '2026-04-08 07:04:42', '2026-04-08 07:04:42'),
(24, 17, 14, 'Apple iPad Air M2 11-inch', 'Apple', 'images/products/ipad-air.jpg', 89900.00, 99900.00, 1, 89900.00, '2026-04-08 07:21:59', '2026-04-08 07:21:59'),
(25, 18, 14, 'Apple iPad Air M2 11-inch', 'Apple', 'images/products/ipad-air.jpg', 89900.00, 99900.00, 1, 89900.00, '2026-04-08 07:35:07', '2026-04-08 07:35:07'),
(26, 19, 19, 'Sony PlayStation 5 Slim', 'Sony', 'images/products/ps5.jpg', 49990.00, 54990.00, 1, 49990.00, '2026-04-09 06:44:50', '2026-04-09 06:44:50'),
(27, 20, 7, 'Atomic Habits by James Clear', 'Penguin', 'images/products/atomic-habits.jpg', 499.00, 799.00, 1, 499.00, '2026-04-09 07:19:39', '2026-04-09 07:19:39'),
(28, 20, 1, 'Apple iPhone 15 Pro Max 256GB', 'Apple', 'images/products/iphone15.jpg', 134900.00, 149900.00, 1, 134900.00, '2026-04-09 07:19:39', '2026-04-09 07:19:39'),
(29, 21, 25, 'The Psychology of Money', 'Jaico', 'images/products/psychology-money.jpg', 399.00, 599.00, 1, 399.00, '2026-04-09 07:36:01', '2026-04-09 07:36:01'),
(30, 22, 25, 'The Psychology of Money', 'Jaico', 'images/products/psychology-money.jpg', 399.00, 599.00, 1, 399.00, '2026-04-09 07:46:22', '2026-04-09 07:46:22'),
(31, 23, 19, 'Sony PlayStation 5 Slim', 'Sony', 'images/products/ps5.jpg', 49990.00, 54990.00, 1, 49990.00, '2026-04-09 10:20:10', '2026-04-09 10:20:10'),
(33, 25, 19, 'Sony PlayStation 5 Slim', 'Sony', 'images/products/ps5.jpg', 49990.00, 54990.00, 1, 49990.00, '2026-04-09 11:34:55', '2026-04-09 11:34:55'),
(34, 26, 1, 'Apple iPhone 15 Pro Max 256GB', 'Apple', 'images/products/iphone15.jpg', 134900.00, 149900.00, 1, 134900.00, '2026-04-09 11:42:51', '2026-04-09 11:42:51'),
(35, 26, 3, 'Sony WH-1000XM5 Headphones', 'Sony', 'images/products/sony-headphones.jpg', 24990.00, 34990.00, 1, 24990.00, '2026-04-09 11:42:51', '2026-04-09 11:42:51'),
(36, 27, 16, 'JBL Flip 6 Bluetooth Speaker', 'JBL', 'images/products/jbl-flip6.jpg', 9999.00, 13999.00, 1, 9999.00, '2026-04-09 12:50:04', '2026-04-09 12:50:04'),
(37, 28, 22, 'Mi 43-inch Full HD Smart TV', 'Xiaomi', 'images/products/mi-tv.jpg', 24999.00, 32999.00, 1, 24999.00, '2026-04-12 07:41:55', '2026-04-12 07:41:55'),
(38, 28, 4, 'Apple MacBook Air M3 13-inch', 'Apple', 'images/products/macbook-air.jpg', 114900.00, 119900.00, 1, 114900.00, '2026-04-12 07:41:55', '2026-04-12 07:41:55'),
(39, 28, 19, 'Sony PlayStation 5 Slim', 'Sony', 'images/products/ps5.jpg', 49990.00, 54990.00, 1, 49990.00, '2026-04-12 07:41:55', '2026-04-12 07:41:55'),
(40, 29, 19, 'Sony PlayStation 5 Slim', 'Sony', 'images/products/ps5.jpg', 49990.00, 54990.00, 1, 49990.00, '2026-04-13 12:22:31', '2026-04-13 12:22:31'),
(41, 30, 19, 'Sony PlayStation 5 Slim', 'Sony', 'images/products/ps5.jpg', 49990.00, 54990.00, 1, 49990.00, '2026-04-13 12:40:26', '2026-04-13 12:40:26'),
(42, 31, 1, 'Apple iPhone 15 Pro Max 256GB', 'Apple', 'images/products/iphone15.jpg', 134900.00, 149900.00, 1, 134900.00, '2026-04-13 12:51:11', '2026-04-13 12:51:11'),
(43, 32, 17, 'Apple Watch Series 9 GPS 45mm', 'Apple', 'images/products/apple-watch.jpg', 44900.00, 49900.00, 1, 44900.00, '2026-04-14 04:20:09', '2026-04-14 04:20:09'),
(44, 33, 17, 'Apple Watch Series 9 GPS 45mm', 'Apple', 'images/products/apple-watch.jpg', 44900.00, 49900.00, 1, 44900.00, '2026-04-14 05:17:37', '2026-04-14 05:17:37'),
(45, 34, 7, 'Atomic Habits by James Clear', 'Penguin', 'images/products/atomic-habits.jpg', 499.00, 799.00, 1, 499.00, '2026-04-14 05:39:24', '2026-04-14 05:39:24'),
(46, 35, 1, 'Apple iPhone 15 Pro Max 256GB', 'Apple', 'images/products/iphone15.jpg', 134900.00, 149900.00, 1, 134900.00, '2026-04-14 07:19:16', '2026-04-14 07:19:16'),
(47, 35, 17, 'Apple Watch Series 9 GPS 45mm', 'Apple', 'images/products/apple-watch.jpg', 44900.00, 49900.00, 1, 44900.00, '2026-04-14 07:19:16', '2026-04-14 07:19:16'),
(48, 36, 7, 'Atomic Habits by James Clear', 'Penguin', 'images/products/atomic-habits.jpg', 499.00, 799.00, 1, 499.00, '2026-04-14 13:45:58', '2026-04-14 13:45:58'),
(49, 37, 17, 'Apple Watch Series 9 GPS 45mm', 'Apple', 'images/products/apple-watch.jpg', 44900.00, 49900.00, 1, 44900.00, '2026-04-14 14:18:27', '2026-04-14 14:18:27'),
(50, 38, 16, 'JBL Flip 6 Bluetooth Speaker', 'JBL', 'images/products/jbl-flip6.jpg', 9999.00, 13999.00, 1, 9999.00, '2026-04-14 15:10:52', '2026-04-14 15:10:52'),
(51, 39, 1, 'Apple iPhone 15 Pro Max 256GB', 'Apple', 'images/products/iphone15.jpg', 134900.00, 149900.00, 1, 134900.00, '2026-04-14 17:12:51', '2026-04-14 17:12:51'),
(52, 40, 17, 'Apple Watch Series 9 GPS 45mm', 'Apple', 'images/products/apple-watch.jpg', 44900.00, 49900.00, 1, 44900.00, '2026-04-14 17:24:17', '2026-04-14 17:24:17'),
(53, 41, 14, 'Apple iPad Air M2 11-inch', 'Apple', 'images/products/ipad-air.jpg', 89900.00, 99900.00, 1, 89900.00, '2026-04-14 17:39:02', '2026-04-14 17:39:02'),
(54, 42, 2, 'Samsung Galaxy S24 Ultra 512GB', 'Samsung', 'images/products/samsung-s24.jpg', 124999.00, 134999.00, 1, 124999.00, '2026-04-14 17:57:42', '2026-04-14 17:57:42'),
(55, 43, 1, 'Apple iPhone 15 Pro Max 256GB', 'Apple', 'images/products/iphone15.jpg', 134900.00, 149900.00, 1, 134900.00, '2026-04-14 17:58:47', '2026-04-14 17:58:47'),
(56, 44, 1, 'Apple iPhone 15 Pro Max 256GB', 'Apple', 'images/products/iphone15.jpg', 134900.00, 149900.00, 1, 134900.00, '2026-04-14 18:00:03', '2026-04-14 18:00:03'),
(57, 45, 34, 'Ray-Ban Aviator Sunglasses', 'Ray-Ban', 'images/products/rayban.jpg', 8490.00, 9990.00, 1, 8490.00, '2026-04-15 05:59:34', '2026-04-15 05:59:34'),
(58, 46, 13, 'OnePlus 12 5G 256GB', 'OnePlus', 'images/products/oneplus12.jpg', 64999.00, 69999.00, 1, 64999.00, '2026-04-15 06:14:36', '2026-04-15 06:14:36'),
(59, 47, 1, 'Apple iPhone 15 Pro Max 256GB', 'Apple', 'images/products/iphone15.jpg', 134900.00, 149900.00, 1, 134900.00, '2026-04-15 06:15:08', '2026-04-15 06:15:08'),
(60, 48, 17, 'Apple Watch Series 9 GPS 45mm', 'Apple', 'images/products/apple-watch.jpg', 44900.00, 49900.00, 1, 44900.00, '2026-04-15 06:18:18', '2026-04-15 06:18:18'),
(61, 49, 7, 'Atomic Habits by James Clear', 'Penguin', 'images/products/atomic-habits.jpg', 499.00, 799.00, 1, 499.00, '2026-04-15 06:21:04', '2026-04-15 06:21:04'),
(62, 50, 19, 'Sony PlayStation 5 Slim', 'Sony', 'images/products/ps5.jpg', 49990.00, 54990.00, 1, 49990.00, '2026-04-15 06:29:20', '2026-04-15 06:29:20'),
(63, 51, 4, 'Apple MacBook Air M3 13-inch', 'Apple', 'images/products/macbook-air.jpg', 114900.00, 119900.00, 2, 229800.00, '2026-04-15 12:08:18', '2026-04-15 12:08:18'),
(64, 52, 7, 'Atomic Habits by James Clear', 'Penguin', 'images/products/atomic-habits.jpg', 499.00, 799.00, 1, 499.00, '2026-04-17 10:51:23', '2026-04-17 10:51:23'),
(65, 52, 1, 'Apple iPhone 15 Pro Max 256GB', 'Apple', 'images/products/iphone15.jpg', 134900.00, 149900.00, 1, 134900.00, '2026-04-17 10:51:23', '2026-04-17 10:51:23'),
(66, 52, 17, 'Apple Watch Series 9 GPS 45mm', 'Apple', 'images/products/apple-watch.jpg', 44900.00, 49900.00, 1, 44900.00, '2026-04-17 10:51:23', '2026-04-17 10:51:23'),
(67, 53, 17, 'Apple Watch Series 9 GPS 45mm', 'Apple', 'images/products/apple-watch.jpg', 44900.00, 49900.00, 1, 44900.00, '2026-04-17 11:45:22', '2026-04-17 11:45:22'),
(68, 54, 7, 'Atomic Habits by James Clear', 'Penguin', 'images/products/atomic-habits.jpg', 499.00, 799.00, 1, 499.00, '2026-04-17 12:21:01', '2026-04-17 12:21:01'),
(69, 55, 1, 'Apple iPhone 15 Pro Max 256GB', 'Apple', 'images/products/iphone15.jpg', 134900.00, 149900.00, 1, 134900.00, '2026-04-20 04:25:53', '2026-04-20 04:25:53'),
(70, 56, 1, 'Apple iPhone 15 Pro Max 256GB', 'Apple', 'images/products/iphone15.jpg', 134900.00, 149900.00, 1, 134900.00, '2026-04-20 04:27:41', '2026-04-20 04:27:41'),
(71, 57, 1, 'Apple iPhone 15 Pro Max 256GB', 'Apple', 'images/products/iphone15.jpg', 134900.00, 149900.00, 1, 134900.00, '2026-04-22 07:27:29', '2026-04-22 07:27:29'),
(72, 58, 1, 'Apple iPhone 15 Pro Max 256GB', 'Apple', 'images/products/iphone15.jpg', 134900.00, 149900.00, 1, 134900.00, '2026-04-22 07:48:40', '2026-04-22 07:48:40');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
('mahek.shah240604@gmail.com', '$2y$12$ItymIou4bjCino9ifeXP5.S516yNIG3l7USi00HCHsjptM2o3Uvnm', '2026-04-15 11:58:55');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` enum('credit_card','debit_card','paypal','upi','net_banking','wallet') NOT NULL DEFAULT 'credit_card',
  `card_number` varchar(255) DEFAULT NULL,
  `cardholder_name` varchar(255) DEFAULT NULL,
  `card_expiry_month` varchar(255) DEFAULT NULL,
  `card_expiry_year` varchar(255) DEFAULT NULL,
  `card_type` varchar(255) DEFAULT NULL,
  `paypal_email` varchar(255) DEFAULT NULL,
  `upi_id` varchar(255) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `bank_account_number` varchar(255) DEFAULT NULL,
  `wallet_provider` varchar(255) DEFAULT NULL,
  `wallet_number` varchar(255) DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `nickname` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `original_price` decimal(10,2) DEFAULT NULL,
  `discount` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `rating` decimal(2,1) NOT NULL DEFAULT 0.0,
  `reviews_count` int(11) NOT NULL DEFAULT 0,
  `is_prime` tinyint(1) NOT NULL DEFAULT 0,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sold_count` int(11) NOT NULL DEFAULT 0,
  `views` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `user_id`, `name`, `description`, `category`, `brand`, `price`, `original_price`, `discount`, `image`, `stock`, `rating`, `reviews_count`, `is_prime`, `is_featured`, `created_at`, `updated_at`, `sold_count`, `views`) VALUES
(1, 0, 'Apple iPhone 15 Pro Max 256GB', 'Latest Apple iPhone with A17 Pro chip, titanium design, 48MP camera system.', 'Electronics', 'Apple', 134900.00, 149900.00, 10, 'images/products/iphone15.jpg', 34, 4.8, 2341, 1, 1, '2026-03-31 03:28:57', '2026-04-22 08:31:15', 0, 43),
(2, 0, 'Samsung Galaxy S24 Ultra 512GB', 'Galaxy AI, built-in S Pen, 200MP camera, Snapdragon 8 Gen 3.', 'Electronics', 'Samsung', 124999.00, 134999.00, 7, 'images/products/samsung-s24.jpg', 34, 4.7, 1876, 1, 1, '2026-03-31 03:28:57', '2026-04-14 17:57:42', 0, 0),
(3, 0, 'Sony WH-1000XM5 Headphones', 'Industry leading noise cancellation, 30hr battery, multipoint connection.', 'Electronics', 'Sony', 24990.00, 34990.00, 29, 'images/products/sony-headphones.jpg', 79, 4.6, 5432, 0, 0, '2026-03-31 03:28:57', '2026-04-09 11:42:51', 0, 0),
(4, 0, 'Apple MacBook Air M3 13-inch', 'Supercharged by M3 chip, 18-hour battery life, 8GB RAM, 256GB SSD.', 'Electronics', 'Apple', 114900.00, 119900.00, 4, 'images/products/macbook-air.jpg', 20, 4.9, 987, 1, 1, '2026-03-31 03:28:57', '2026-04-17 09:46:14', 0, 14),
(5, 0, 'boAt Rockerz 450 Bluetooth Headphones', '40mm dynamic drivers, 15hr playback, foldable design, built-in mic.', 'Electronics', 'boAt', 1299.00, 3990.00, 67, 'images/products/boat-rockerz.jpg', 200, 4.1, 89432, 1, 0, '2026-03-31 03:28:57', '2026-03-31 03:28:57', 0, 0),
(6, 0, 'Logitech MX Master 3S Mouse', '8K DPI sensor, ultra-fast scrolling, ergonomic design, USB-C charging.', 'Electronics', 'Logitech', 8995.00, 10995.00, 18, 'images/products/logitech-mouse.jpg', 60, 4.7, 3210, 0, 0, '2026-03-31 03:28:57', '2026-03-31 03:28:57', 0, 0),
(7, 0, 'Atomic Habits by James Clear', 'Tiny changes, remarkable results. #1 New York Times bestseller.', 'Books', 'Penguin', 499.00, 799.00, 38, 'images/products/atomic-habits.jpg', 492, 4.8, 45231, 1, 1, '2026-03-31 03:28:57', '2026-04-17 12:21:01', 0, 6),
(8, 0, 'Rich Dad Poor Dad', 'What the rich teach their kids about money that the poor and middle class do not.', 'Books', 'Manjul', 299.00, 450.00, 34, 'images/products/rich-dad.jpg', 300, 4.6, 32100, 1, 0, '2026-03-31 03:28:57', '2026-03-31 03:28:57', 0, 0),
(9, 0, 'Levi\'s Men\'s 511 Slim Jeans', 'Slim fit jeans, sits below waist, slim through hip and thigh.', 'Fashion', 'Levi\'s', 2699.00, 3999.00, 33, 'images/products/levis-jeans.jpg', 150, 4.3, 12543, 0, 0, '2026-03-31 03:28:57', '2026-03-31 03:28:57', 0, 0),
(10, 0, 'Nike Air Max 270 Sneakers', 'Max Air unit in the heel for all-day comfort. Breathable mesh upper.', 'Fashion', 'Nike', 9995.00, 12995.00, 23, 'images/products/nike-airmax.png', 89, 4.5, 8765, 1, 1, '2026-03-31 03:28:57', '2026-04-03 11:18:32', 0, 0),
(11, 0, 'Instant Pot Duo 7-in-1 Electric Pressure Cooker', '7-in-1: pressure cooker, slow cooker, rice cooker, steamer, sauté, yogurt maker & warmer.', 'Home & Kitchen', 'Instant Pot', 6999.00, 9999.00, 30, 'images/products/instant-pot.jpg', 45, 4.6, 23456, 1, 0, '2026-03-31 03:28:57', '2026-03-31 03:28:57', 0, 0),
(12, 0, 'Philips Air Fryer HD9200', 'Rapid Air technology, 1400W, 4.1L capacity, dishwasher safe parts.', 'Home & Kitchen', 'Philips', 8995.00, 11995.00, 25, 'images/products/philips-airfryer.jpg', 54, 4.4, 7654, 0, 0, '2026-03-31 03:28:57', '2026-04-03 01:02:41', 0, 0),
(13, 0, 'OnePlus 12 5G 256GB', 'Snapdragon 8 Gen 3, 50MP Hasselblad camera, 100W fast charging.', 'Electronics', 'OnePlus', 64999.00, 69999.00, 7, 'images/products/oneplus12.jpg', 59, 4.6, 3421, 1, 1, '2026-04-01 09:40:32', '2026-04-15 06:14:36', 0, 1),
(14, 0, 'Apple iPad Air M2 11-inch', 'M2 chip, Liquid Retina display, USB-C, 5G capable, 256GB.', 'Electronics', 'Apple', 89900.00, 99900.00, 10, 'images/products/ipad-air.jpg', 37, 4.7, 1234, 1, 1, '2026-04-01 09:40:32', '2026-04-14 17:39:02', 0, 0),
(15, 0, 'Samsung 55-inch 4K Smart TV', 'Crystal 4K UHD, HDR, PurColor, Built-in Alexa.', 'Electronics', 'Samsung', 54990.00, 74990.00, 27, 'images/products/samsung-tv.jpg', 25, 4.5, 8765, 0, 1, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(16, 0, 'JBL Flip 6 Bluetooth Speaker', 'IP67 waterproof, 12 hours playtime, powerful bass.', 'Electronics', 'JBL', 9999.00, 13999.00, 29, 'images/products/jbl-flip6.jpg', 148, 4.6, 12345, 1, 1, '2026-04-01 09:40:32', '2026-04-14 18:01:16', 0, 1),
(17, 0, 'Apple Watch Series 9 GPS 45mm', 'S9 chip, Double Tap gesture, Always-On Retina display.', 'Electronics', 'Apple', 44900.00, 49900.00, 10, 'images/products/apple-watch.jpg', 26, 4.8, 2109, 1, 1, '2026-04-01 09:40:32', '2026-04-17 11:45:22', 0, 3),
(18, 0, 'Lenovo IdeaPad Slim 5 Laptop', 'Intel Core i5 13th Gen, 16GB RAM, 512GB SSD, 15.6-inch FHD.', 'Electronics', 'Lenovo', 62990.00, 75990.00, 17, 'images/products/lenovo-laptop.jpg', 30, 4.4, 987, 0, 1, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(19, 0, 'Sony PlayStation 5 Slim', '1TB SSD, DualSense controller, 4K gaming, ray tracing.', 'Electronics', 'Sony', 49990.00, 54990.00, 9, 'images/products/ps5.jpg', 5, 4.9, 8765, 1, 1, '2026-04-01 09:40:32', '2026-04-17 09:22:27', 0, 17),
(20, 0, 'boAt Airdopes 141 TWS Earbuds', '42H total playback, ENx technology, IPX4 water resistant.', 'Electronics', 'boAt', 1299.00, 2990.00, 57, 'images/products/boat-earbuds.jpg', 300, 4.1, 67890, 1, 0, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(21, 0, 'Canon EOS R50 Mirrorless Camera', '24.2MP APS-C sensor, 4K video, Dual Pixel CMOS AF.', 'Electronics', 'Canon', 74990.00, 84990.00, 12, 'images/products/canon-camera.jpg', 20, 4.7, 543, 0, 0, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(22, 0, 'Mi 43-inch Full HD Smart TV', 'Full HD display, PatchWall UI, Dolby Audio, Chromecast.', 'Electronics', 'Xiaomi', 24999.00, 32999.00, 24, 'images/products/mi-tv.jpg', 44, 4.3, 23456, 1, 0, '2026-04-01 09:40:32', '2026-04-12 07:41:55', 0, 0),
(23, 0, 'Noise ColorFit Ultra 3 Smartwatch', '1.96-inch AMOLED, Bluetooth calling, health tracking, IP68.', 'Electronics', 'Noise', 3499.00, 6999.00, 50, 'images/products/noise-watch.jpg', 200, 4.0, 34567, 1, 0, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(24, 0, 'WD 2TB External Hard Drive', 'USB 3.0, plug and play, password protection, PC and Mac.', 'Electronics', 'WD', 5499.00, 6999.00, 21, 'images/products/wd-harddrive.jpg', 120, 4.4, 8901, 0, 0, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(25, 0, 'The Psychology of Money', 'Timeless lessons on wealth, greed, and happiness by Morgan Housel.', 'Books', 'Jaico', 399.00, 599.00, 33, 'images/products/psychology-money.jpg', 398, 4.7, 28901, 1, 1, '2026-04-01 09:40:32', '2026-04-09 07:46:22', 0, 0),
(26, 0, 'The Alchemist by Paulo Coelho', 'A fable about following your dream. Best-selling book worldwide.', 'Books', 'HarperCollins', 299.00, 399.00, 25, 'images/products/alchemist.jpg', 500, 4.7, 45678, 1, 1, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(27, 0, 'Zero to One by Peter Thiel', 'Notes on startups, or how to build the future.', 'Books', 'Virgin Books', 499.00, 699.00, 29, 'images/products/zero-to-one.jpg', 350, 4.5, 15432, 0, 0, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(28, 0, 'Think and Grow Rich', 'Napoleon Hill classic on success mindset and wealth creation.', 'Books', 'Fingerprint', 199.00, 350.00, 43, 'images/products/think-grow-rich.jpg', 600, 4.5, 32109, 1, 0, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(29, 0, 'Deep Work by Cal Newport', 'Rules for focused success in a distracted world.', 'Books', 'Hachette', 449.00, 649.00, 31, 'images/products/deep-work.jpg', 300, 4.6, 18765, 1, 0, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(30, 0, 'Ikigai The Japanese Secret', 'The Japanese secret to a long and happy life.', 'Books', 'Arrow', 299.00, 399.00, 25, 'images/products/ikigai.jpg', 450, 4.6, 23456, 0, 1, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(31, 0, 'Cant Hurt Me by David Goggins', 'Master your mind and defy the odds. Inspiring true story.', 'Books', 'Lioncrest', 599.00, 799.00, 25, 'images/products/cant-hurt-me.jpg', 200, 4.8, 9876, 1, 0, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(32, 0, 'The Lean Startup by Eric Ries', 'How constant innovation creates radically successful businesses.', 'Books', 'Penguin', 399.00, 549.00, 27, 'images/products/lean-startup.jpg', 250, 4.4, 12345, 1, 0, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(33, 0, 'Puma Mens Running Shoes', 'Softride technology, breathable mesh, lightweight sole.', 'Fashion', 'Puma', 3999.00, 5999.00, 33, 'images/products/puma-shoes.jpg', 120, 4.4, 6543, 0, 1, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(34, 0, 'Ray-Ban Aviator Sunglasses', 'Classic pilot frame, UV400 protection, green G-15 lens.', 'Fashion', 'Ray-Ban', 8490.00, 9990.00, 15, 'images/products/rayban.jpg', 58, 4.6, 5678, 1, 1, '2026-04-01 09:40:32', '2026-04-15 05:59:34', 0, 0),
(35, 0, 'Allen Solly Mens Formal Shirt', 'Regular fit, 100% cotton, wrinkle-free, multiple colors.', 'Fashion', 'Allen Solly', 1299.00, 2199.00, 41, 'images/products/allen-solly-shirt.jpg', 200, 4.3, 8765, 1, 0, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(36, 0, 'HM Womens Casual Dress', 'Floral print, V-neck, midi length, soft woven fabric.', 'Fashion', 'H&M', 1799.00, 2499.00, 28, 'images/products/hm-dress.jpg', 150, 4.2, 4321, 0, 0, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(37, 0, 'Wildcraft Backpack 40L', 'Waterproof, laptop compartment, ergonomic straps.', 'Fashion', 'Wildcraft', 1999.00, 3499.00, 43, 'images/products/wildcraft-bag.jpg', 180, 4.4, 9876, 1, 0, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(38, 0, 'Adidas Mens Track Pants', '100% polyester, elastic waistband, moisture-wicking.', 'Fashion', 'Adidas', 2499.00, 3499.00, 29, 'images/products/adidas-trackpants.jpg', 140, 4.2, 7654, 1, 0, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(39, 0, 'Fossil Mens Analogue Watch', 'Stainless steel, leather strap, chronograph, water resistant.', 'Fashion', 'Fossil', 11995.00, 14995.00, 20, 'images/products/fossil-watch.jpg', 45, 4.5, 4567, 0, 1, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(40, 0, 'Fabindia Womens Kurta', 'Handcrafted cotton, traditional print, comfortable fit.', 'Fashion', 'Fabindia', 1599.00, 2299.00, 30, 'images/products/fabindia-kurta.jpg', 99, 4.3, 3456, 1, 0, '2026-04-01 09:40:32', '2026-04-06 09:29:04', 0, 0),
(41, 0, 'Prestige 5L Pressure Cooker', 'Hard anodised aluminum, gasket release system, includes separator.', 'Home & Kitchen', 'Prestige', 1999.00, 2999.00, 33, 'images/products/prestige-cooker.jpg', 200, 4.5, 34567, 1, 0, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(42, 0, 'Bajaj 750W Mixer Grinder', '3 jars, Insta-fresh juicer, 3 speed control, 2 year warranty.', 'Home & Kitchen', 'Bajaj', 2699.00, 3999.00, 32, 'images/products/bajaj-mixer.jpg', 150, 4.3, 23456, 0, 0, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(43, 0, 'Milton Thermosteel Flask 1L', '18/8 stainless steel, 24hr hot and cold, leak proof.', 'Home & Kitchen', 'Milton', 799.00, 1299.00, 38, 'images/products/milton-flask.jpg', 300, 4.5, 45678, 1, 0, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(44, 0, 'Pigeon Electric Kettle 1.5L', 'Auto shut-off, concealed heating element, cool touch handle, 1500W.', 'Home & Kitchen', 'Pigeon', 699.00, 1299.00, 46, 'images/products/pigeon-kettle.jpg', 250, 4.2, 56789, 1, 0, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(45, 0, 'Amazon Echo Dot 5th Gen', 'Built-in Alexa, improved audio, temperature sensor.', 'Home & Kitchen', 'Amazon', 4999.00, 5499.00, 9, 'images/products/echo-dot.jpg', 100, 4.4, 12345, 0, 1, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(46, 0, 'Havells Water Purifier RO UV', '7L storage, mineral fortification, 6 stage purification.', 'Home & Kitchen', 'Havells', 12990.00, 17990.00, 28, 'images/products/havells-purifier.jpg', 40, 4.4, 5678, 1, 1, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(47, 0, 'Dyson V12 Cordless Vacuum', 'Laser detects invisible dust, LCD screen, 60 min run time.', 'Home & Kitchen', 'Dyson', 54900.00, 62900.00, 13, 'images/products/dyson-vacuum.jpg', 20, 4.7, 2345, 1, 1, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(48, 0, 'Wipro 9W LED Bulb Pack of 10', 'Cool white, 6500K, energy saving, 2 year warranty.', 'Home & Kitchen', 'Wipro', 499.00, 799.00, 38, 'images/products/wipro-bulb.jpg', 500, 4.3, 67890, 0, 0, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(49, 0, 'Cosco Football Size 5', 'FIFA approved, PU material, all weather use, hand stitched.', 'Sports', 'Cosco', 799.00, 1299.00, 38, 'images/products/cosco-football.jpg', 200, 4.2, 5678, 1, 0, '2026-04-01 09:40:32', '2026-04-03 11:18:49', 0, 0),
(50, 0, 'Boldfit Yoga Mat 6mm', 'Non-slip, eco-friendly TPE, carry strap included, 183x61cm.', 'Sports', 'Boldfit', 999.00, 1999.00, 50, 'images/products/yoga-mat.jpg', 300, 4.3, 12345, 1, 0, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(51, 0, 'Nivia Carbonite Badminton Racket', 'Carbon fibre frame, 85g weight, includes full cover.', 'Sports', 'Nivia', 1299.00, 1999.00, 35, 'images/products/badminton-racket.jpg', 150, 4.1, 8765, 0, 0, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(52, 0, 'Strauss Adjustable Dumbbell 10kg', 'Chrome plated, adjustable weight plates, anti-slip grip.', 'Sports', 'Strauss', 1499.00, 2499.00, 40, 'images/products/dumbbell.jpg', 100, 4.4, 9876, 1, 1, '2026-04-01 09:40:32', '2026-04-03 11:18:49', 0, 0),
(53, 0, 'Vector X Cricket Bat Full Size', 'English willow, full size, premium handle, weight 1.2kg.', 'Sports', 'Vector X', 2499.00, 3999.00, 38, 'images/products/cricket-bat.jpg', 80, 4.2, 4321, 1, 0, '2026-04-01 09:40:32', '2026-04-01 09:40:32', 0, 0),
(56, 3, 'Graceful Boat Neck A-Line Dress for a Feminine Look', 'Feel confident and elegant in this beautiful boat neck A-line dress. The flowy silhouette and soft design make it perfect for everyday wear or special moments. A timeless piece you’ll reach for again and again. 🌷', 'Fashion', 'Etsy', 1200.00, 1500.00, 20, 'images/products/1776668979_Graceful Boat Neck A-Line Dress for a Feminine Look.jpg', 5, 4.0, 1, 1, 0, '2026-04-20 07:09:39', '2026-04-20 07:12:17', 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `return_requests`
--

CREATE TABLE `return_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reason` varchar(255) NOT NULL,
  `message` text DEFAULT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pickup_address` varchar(255) DEFAULT NULL,
  `pickup_date` date DEFAULT NULL,
  `pickup_status` varchar(255) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `return_requests`
--

INSERT INTO `return_requests` (`id`, `order_id`, `user_id`, `order_item_id`, `reason`, `message`, `status`, `created_at`, `updated_at`, `pickup_address`, `pickup_date`, `pickup_status`) VALUES
(1, 50, 2, NULL, 'Not liked', NULL, 'approved', '2026-04-16 05:39:19', '2026-04-16 06:43:28', NULL, '2026-04-18', 'scheduled'),
(2, 51, 2, NULL, 'Wrong item', 'I received the wrong item. Please arrange a return.', 'approved', '2026-04-16 06:42:39', '2026-04-16 06:43:06', '19 dreamlend park soc,naranpura ahemdedabad', '2026-04-18', 'scheduled'),
(3, 58, 3, NULL, 'Damaged', 'I have received a damaged mobile phone. Kindly initiate a return request and process a refund or replacement at the earliest.', 'approved', '2026-04-22 08:18:04', '2026-04-22 08:26:21', '19 dreamlend park soc,naranpura ahemdedabad', '2026-04-24', 'scheduled');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `body` text DEFAULT NULL,
  `helpful_count` int(11) NOT NULL DEFAULT 0,
  `verified_purchase` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `rating`, `title`, `body`, `helpful_count`, `verified_purchase`, `created_at`, `updated_at`) VALUES
(1, 3, 56, 4, 'Customer Reviews', 'Perfect fit and beautiful design. I love it!;)', 0, 0, '2026-04-20 07:12:16', '2026-04-20 07:12:16');

-- --------------------------------------------------------

--
-- Table structure for table `saved_items`
--

CREATE TABLE `saved_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `saved_items`
--

INSERT INTO `saved_items` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2026-04-09 12:22:35', '2026-04-09 12:22:35'),
(2, 2, 7, '2026-04-09 12:38:55', '2026-04-09 12:38:55'),
(3, 2, 26, '2026-04-09 12:49:18', '2026-04-09 12:49:18'),
(4, 2, 16, '2026-04-14 18:00:36', '2026-04-14 18:00:36'),
(5, 2, 13, '2026-04-14 18:01:36', '2026-04-14 18:01:36'),
(6, 3, 1, '2026-04-22 07:20:24', '2026-04-22 07:20:24');

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
('BTxiCg5egFlDtMPo5eXYOZ9PIMXUEWXsG2KYYWOt', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36 Edg/147.0.0.0', 'YTo0OntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im5ldyI7YTowOnt9czozOiJvbGQiO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiRlNzNms4ZVNDcjhkNlFtaWRpdzlYSGVhbm04c2p5UU9zZHE0c1E5ciI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ub3RpZmljYXRpb25zL2NvdW50IjtzOjU6InJvdXRlIjtzOjE5OiJub3RpZmljYXRpb25zLmNvdW50Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6Mzt9', 1776859664);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `is_admin`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(2, 'MAHEK PANKAJ SHAH', 'mahek.shah240604@gmail.com', '9327850406', 0, '2026-03-30 06:03:04', '$2y$12$LhfsdP/EJZ2dehmEg3RMieazbOPmlppqnedhM/KcLBSNvOMgabrp.', 'CbcW2Vap8XhogWwBuWFl8nXEkLZJcewfb0u9eZVvSEW34qoWPilpDfsv739M', '2026-03-30 06:03:04', '2026-04-06 11:02:57'),
(3, 'Radhe', 'mahek.s2404@gmail.com', '9327850406', 1, '2026-04-17 08:56:43', '$2y$12$Lwb3egvs1as5/utVRYkOD.ZbbZxfPENhpQO4Neu1vMqr3UgeHtu9C', 'vLI2sq2nimqeZsBKXUOOZKES4eVrcjIggvr0yid5CXkI9qOObArWxXnntwmY', '2026-04-17 08:56:43', '2026-04-17 08:58:37');

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
(59, 2, 46, '2026-04-11 07:11:49', '2026-04-11 07:11:49'),
(60, 2, 11, '2026-04-11 07:11:52', '2026-04-11 07:11:52'),
(61, 2, 25, '2026-04-11 10:38:42', '2026-04-11 10:38:42'),
(67, 2, 16, '2026-04-14 18:00:28', '2026-04-14 18:00:28'),
(70, 2, 17, '2026-04-15 11:33:13', '2026-04-15 11:33:13'),
(71, 2, 1, '2026-04-15 11:33:17', '2026-04-15 11:33:17'),
(72, 2, 19, '2026-04-15 11:33:20', '2026-04-15 11:33:20'),
(79, 3, 14, '2026-04-22 08:38:32', '2026-04-22 08:38:32'),
(80, 3, 7, '2026-04-22 08:38:37', '2026-04-22 08:38:37'),
(81, 3, 25, '2026-04-22 08:38:43', '2026-04-22 08:38:43');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cart_items_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`);

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
-- Indexes for table `customer_support`
--
ALTER TABLE `customer_support`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customer_support_ticket_number_unique` (`ticket_number`),
  ADD KEY `customer_support_assigned_to_foreign` (`assigned_to`),
  ADD KEY `customer_support_user_id_status_index` (`user_id`,`status`),
  ADD KEY `customer_support_ticket_number_index` (`ticket_number`),
  ADD KEY `customer_support_category_index` (`category`),
  ADD KEY `customer_support_priority_index` (`priority`),
  ADD KEY `customer_support_status_opened_at_index` (`status`,`opened_at`);

--
-- Indexes for table `customer_support_notifications`
--
ALTER TABLE `customer_support_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_support_notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gift_cards`
--
ALTER TABLE `gift_cards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `gift_cards_card_number_unique` (`card_number`),
  ADD UNIQUE KEY `gift_cards_card_code_unique` (`card_code`),
  ADD KEY `gift_cards_user_id_status_index` (`user_id`,`status`),
  ADD KEY `gift_cards_expiry_date_index` (`expiry_date`),
  ADD KEY `gift_cards_card_type_index` (`card_type`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_methods_user_id_foreign` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `return_requests`
--
ALTER TABLE `return_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `return_requests_order_id_foreign` (`order_id`),
  ADD KEY `return_requests_user_id_foreign` (`user_id`),
  ADD KEY `return_requests_order_item_id_foreign` (`order_item_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reviews_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`);

--
-- Indexes for table `saved_items`
--
ALTER TABLE `saved_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `saved_items_user_id_foreign` (`user_id`),
  ADD KEY `saved_items_product_id_foreign` (`product_id`);

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
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer_support`
--
ALTER TABLE `customer_support`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_support_notifications`
--
ALTER TABLE `customer_support_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gift_cards`
--
ALTER TABLE `gift_cards`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `return_requests`
--
ALTER TABLE `return_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `saved_items`
--
ALTER TABLE `saved_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `coupon_usages`
--
ALTER TABLE `coupon_usages`
  ADD CONSTRAINT `coupon_usages_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `coupon_usages_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `coupon_usages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_support`
--
ALTER TABLE `customer_support`
  ADD CONSTRAINT `customer_support_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `customer_support_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `customer_support_notifications`
--
ALTER TABLE `customer_support_notifications`
  ADD CONSTRAINT `customer_support_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `gift_cards`
--
ALTER TABLE `gift_cards`
  ADD CONSTRAINT `gift_cards_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD CONSTRAINT `payment_methods_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `return_requests`
--
ALTER TABLE `return_requests`
  ADD CONSTRAINT `return_requests_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `return_requests_order_item_id_foreign` FOREIGN KEY (`order_item_id`) REFERENCES `order_items` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `return_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `saved_items`
--
ALTER TABLE `saved_items`
  ADD CONSTRAINT `saved_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `saved_items_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
