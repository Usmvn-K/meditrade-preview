-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2026 at 05:12 PM
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
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_commissions`
--

CREATE TABLE `affiliate_commissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `affiliate_id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` decimal(12,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_leads`
--

CREATE TABLE `affiliate_leads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `affiliate_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `converted_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `affiliate_resources`
--

CREATE TABLE `affiliate_resources` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `content` text DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
  `featured_image` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'Strategic Briefing',
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `published_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `booking_date` datetime NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `total_price` decimal(15,2) DEFAULT NULL,
  `commission_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `vendor_net_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `payout_status` varchar(255) NOT NULL DEFAULT 'pending',
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `event_type` varchar(255) DEFAULT NULL,
  `event_size` varchar(255) DEFAULT NULL,
  `event_end_date` datetime DEFAULT NULL,
  `event_location` varchar(255) DEFAULT NULL,
  `event_address` varchar(255) DEFAULT NULL,
  `guest_count` int(11) DEFAULT NULL,
  `budget` decimal(12,2) DEFAULT NULL,
  `special_requests` text DEFAULT NULL,
  `booking_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`booking_data`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `cost_center` varchar(255) DEFAULT NULL,
  `approval_level` varchar(255) NOT NULL DEFAULT 'Level 1',
  `assigned_admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `corporate_pricing` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Hemani', 'hemani', NULL, '2026-06-03 15:42:33', '2026-08-06 14:58:38');

-- --------------------------------------------------------

--
-- Table structure for table `budget_requests`
--

CREATE TABLE `budget_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `service_type` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `guests` int(11) DEFAULT NULL,
  `budget` decimal(12,2) NOT NULL,
  `services_needed` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`services_needed`)),
  `selected_tier` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
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

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-7e11f374d5d4bb6ea2d019541674bd80', 'i:5;', 1790765681),
('laravel-cache-7e11f374d5d4bb6ea2d019541674bd80:timer', 'i:1790765681;', 1790765681),
('laravel-cache-admin@eventy.com|127.0.0.1', 'i:5;', 1790765681),
('laravel-cache-admin@eventy.com|127.0.0.1:timer', 'i:1790765681;', 1790765681),
('laravel-cache-ed9d36d4c647a4499b40f3d507ae3ed2', 'i:1;', 1791373454),
('laravel-cache-ed9d36d4c647a4499b40f3d507ae3ed2:timer', 'i:1791373454;', 1791373454),
('laravel-cache-f175ff6f811f3801d8b5005b2d83977b', 'i:1;', 1790763643),
('laravel-cache-f175ff6f811f3801d8b5005b2d83977b:timer', 'i:1790763643;', 1790763643);

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
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `province` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `province`, `region`, `slug`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Karachi', NULL, NULL, 'karachi', '2026-05-08 15:24:52', '2026-05-08 15:24:52', NULL),
(2, 'Lahore', NULL, NULL, 'lahore', '2026-05-08 15:24:52', '2026-05-08 15:24:52', NULL),
(3, 'Islamabad', NULL, NULL, 'islamabad', '2026-05-08 15:24:52', '2026-05-08 15:24:52', NULL),
(4, 'Faisalabad', NULL, NULL, 'faisalabad', '2026-05-08 15:24:52', '2026-05-08 15:24:52', NULL),
(5, 'Multan', NULL, NULL, 'multan', '2026-05-08 15:24:52', '2026-05-08 15:24:52', NULL),
(6, 'Dubai', NULL, NULL, 'dubai', '2026-05-08 15:24:52', '2026-05-08 15:24:52', NULL),
(7, 'London', NULL, NULL, 'london', '2026-05-08 15:24:52', '2026-05-08 15:24:52', NULL),
(8, 'New York', NULL, NULL, 'new-york', '2026-05-08 15:24:52', '2026-05-08 15:24:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `contact_inquiries`
--

CREATE TABLE `contact_inquiries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `service_type` varchar(255) DEFAULT NULL,
  `message` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
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
  `type` enum('fixed','percent') NOT NULL,
  `value` decimal(15,2) NOT NULL,
  `min_order_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) NOT NULL DEFAULT 0,
  `expires_at` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `vendor_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_packages`
--

CREATE TABLE `custom_packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `total_price` decimal(15,2) NOT NULL DEFAULT 0.00,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_package_bookings`
--

CREATE TABLE `custom_package_bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `custom_package_id` bigint(20) UNSIGNED NOT NULL,
  `booking_date` datetime NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `total_amount` decimal(15,2) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `event_location` varchar(255) DEFAULT NULL,
  `event_address` text DEFAULT NULL,
  `guest_count` int(11) DEFAULT NULL,
  `budget` decimal(15,2) DEFAULT NULL,
  `special_requests` text DEFAULT NULL,
  `booking_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`booking_data`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_package_services`
--

CREATE TABLE `custom_package_services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `custom_package_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
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
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`id`, `title`, `description`, `icon`, `order`, `created_at`, `updated_at`) VALUES
(1, 'Browse Collections', 'Explore premium products with transparent pricing.', 'fa-magnifying-glass', 0, '2026-05-08 15:24:52', '2026-05-08 15:24:52'),
(2, 'Secure Checkout', 'Global payment options with escrow-secured protection.', 'fa-shield-check', 1, '2026-05-08 15:24:52', '2026-05-08 15:24:52'),
(3, 'Global Delivery', 'Door-to-door shipping across 150+ countries.', 'fa-truck-fast', 2, '2026-05-08 15:24:52', '2026-05-08 15:24:52');

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
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `receiver_id` bigint(20) UNSIGNED NOT NULL,
  `body` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `body`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'hello', 1, '2026-08-08 14:01:06', '2026-08-08 14:01:07');

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
(4, '2025_12_09_114601_create_services_table', 1),
(5, '2025_12_09_130401_add_vendor_fields_to_users_table', 1),
(6, '2025_12_09_142840_create_bookings_table', 1),
(7, '2025_12_09_161344_create_contact_inquiries_table', 1),
(8, '2025_12_09_161501_create_budget_requests_table', 1),
(9, '2025_12_09_162112_create_newsletters_table', 1),
(10, '2025_12_09_163832_create_service_categories_table', 1),
(11, '2025_12_09_164729_add_category_id_to_services_table', 1),
(12, '2025_12_09_165652_update_services_table_add_missing_columns', 1),
(13, '2025_12_11_103824_create_notifications_table', 1),
(14, '2025_12_11_124350_add_extra_fields_to_services_table', 1),
(15, '2025_12_11_173358_add_booking_details_to_bookings_table', 1),
(16, '2025_12_11_181709_create_cities_table', 1),
(17, '2025_12_11_181717_add_city_id_to_users_table', 1),
(18, '2025_12_11_182813_create_categories_table', 1),
(19, '2025_12_11_182816_add_category_id_to_users_table', 1),
(20, '2025_12_12_093859_create_testimonials_table', 1),
(21, '2025_12_12_104423_create_features_table', 1),
(22, '2025_12_12_104957_add_is_featured_to_services_table', 1),
(23, '2025_12_20_182311_create_reviews_table', 1),
(24, '2025_12_20_182312_create_review_likes_table', 1),
(25, '2025_12_22_133030_create_custom_packages_table', 1),
(26, '2025_12_22_133031_create_custom_package_services_table', 1),
(27, '2025_12_22_133032_create_custom_package_bookings_table', 1),
(28, '2025_12_22_140847_add_details_to_custom_package_bookings_table', 1),
(29, '2025_12_23_133221_add_selected_tier_to_budget_requests_table', 1),
(30, '2025_12_23_160622_create_service_desk_requests_table', 1),
(31, '2025_12_30_112215_add_multiple_images_to_services_table', 1),
(32, '2025_12_30_114452_add_avatar_to_users_table', 1),
(33, '2025_12_30_132819_add_reply_to_reviews_table', 1),
(34, '2025_12_30_133434_create_messages_table', 1),
(35, '2025_12_30_154529_create_favorites_table', 1),
(36, '2025_12_30_155346_create_service_availability_table', 1),
(37, '2026_01_01_140838_create_vendor_logs_table', 1),
(38, '2026_01_01_150957_create_payments_table', 1),
(39, '2026_01_01_152520_add_finance_fields_to_users_table', 1),
(40, '2026_01_01_152521_create_withdrawals_table', 1),
(41, '2026_01_01_153459_add_cached_rating_to_services_table', 1),
(42, '2026_01_01_154436_add_business_metadata_to_users_table', 1),
(43, '2026_01_01_161646_add_packages_and_addons_to_services_table', 1),
(44, '2026_01_01_162020_add_total_price_to_bookings_table', 1),
(45, '2026_01_01_162436_create_coupons_table', 1),
(46, '2026_01_01_163329_add_images_to_reviews_table', 1),
(47, '2026_01_02_170502_add_booking_id_to_reviews_table', 1),
(48, '2026_01_02_171547_add_commission_to_bookings_table', 1),
(49, '2026_05_08_204738_make_user_id_nullable_in_bookings_table', 2),
(50, '2026_01_03_140731_create_blog_posts_table', 3),
(51, '2026_01_17_230129_create_affiliate_tables', 3),
(52, '2026_02_23_211643_add_corporate_fields_to_tables', 3),
(53, '2026_02_23_212733_add_indexes_to_corporate_fields', 3),
(54, '2026_02_23_222204_add_business_fields_to_users_table', 3),
(55, '2026_02_23_222332_add_event_size_to_bookings_table', 3),
(56, '2026_02_26_013133_add_ntn_number_to_users_table', 3),
(57, '2026_05_20_210027_create_settings_table', 3),
(58, '2026_05_20_212612_add_sale_fields_to_services_table', 4),
(59, '2026_06_02_194509_create_personal_access_tokens_table', 5),
(60, '2026_06_02_200001_create_products_table', 6),
(61, '2026_06_02_200002_create_orders_table', 6),
(62, '2026_06_03_200002_create_brands_table', 7),
(63, '2026_06_03_200003_create_units_table', 7),
(64, '2026_06_03_195602_add_advanced_fields_to_products_table', 8),
(65, '2026_06_03_200000_add_advanced_fields_to_products_table', 8),
(66, '2026_06_03_200001_add_advanced_fields_to_services_table', 8),
(67, '2026_07_30_210000_add_permissions_to_users_table', 9),
(68, '2026_07_30_223210_add_image_to_service_categories_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE `newsletters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT 'purple',
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `type`, `title`, `message`, `icon`, `color`, `link`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 1, 'order', 'New Order Received!', 'An elite order has been placed by dasdas for \"Premium Classic Item 1\". Quantity: 1. Status: Awaiting Verification.', 'fa-shopping-cart', 'indigo', 'http://127.0.0.1:8000/vendor/orders', 1, '2026-05-08 16:25:53', '2026-08-08 14:29:33'),
(2, 1, 'order', 'New Order Received!', 'An elite order has been placed by asdasd for \"Premium Classic Item 1\". Quantity: 1. Status: Awaiting Verification.', 'fa-shopping-cart', 'indigo', 'http://127.0.0.1:8000/vendor/orders', 1, '2026-05-08 16:29:27', '2026-08-08 14:29:33'),
(3, 1, 'order', 'New Order Received!', 'An elite order has been placed by sameer for \"Premium Smartphones Item 3\". Quantity: 1. Status: Awaiting Verification.', 'fa-shopping-cart', 'indigo', 'http://127.0.0.1:8000/vendor/orders', 1, '2026-05-09 12:13:41', '2026-08-08 14:29:33'),
(4, 1, 'order', 'New Order Received!', 'Order placed by Store Admin for \"STAMANAX 1000mg Herbal Vitality Capsules\". Qty: 2. Total: Rs. 5,500', 'fa-shopping-cart', 'indigo', 'http://127.0.0.1:8000/vendor/orders', 1, '2026-08-03 18:25:58', '2026-08-08 14:29:33'),
(5, 1, 'order', 'Order Placed Successfully', 'Your order with 1 item(s) has been submitted. Status: Awaiting Store Approval.', 'fa-clock', 'primary', 'http://127.0.0.1:8000/my-bookings', 1, '2026-08-03 18:25:58', '2026-08-08 14:29:33'),
(6, 3, 'order', 'New Order Received!', 'Order placed by Ahmed for \"STAMANAX 1000mg Herbal Vitality Capsules\". Qty: 1. Total: Rs. 2,750', 'fa-shopping-cart', 'indigo', 'http://127.0.0.1:8000/vendor/orders', 0, '2026-08-08 13:59:25', '2026-08-08 13:59:25'),
(7, 1, 'order', 'Order Update: Cancelled', 'The store for [STAMANAX 1000mg Herbal Vitality Capsules] has updated your order status to: CANCELLED.', 'fa-circle-xmark', 'red', 'http://127.0.0.1:8000/my-bookings', 1, '2026-08-08 14:16:18', '2026-08-08 14:29:33'),
(8, 1, 'order', 'Order Record Updated', 'You have cancelled the order for Store Admin.', 'fa-check-circle', 'blue', 'http://127.0.0.1:8000/admin/bookings', 1, '2026-08-08 14:16:18', '2026-08-08 14:29:33'),
(9, 3, 'order', 'New Order Received!', 'Order placed by papa for \"STAMANAX 1000mg Herbal Vitality Capsules\". Qty: 2. Total: Rs. 5,500', 'fa-shopping-cart', 'indigo', 'http://127.0.0.1:8000/vendor/orders', 0, '2026-08-08 14:34:08', '2026-08-08 14:34:08'),
(10, 1, 'order', 'Order Placed Successfully', 'Your order with 1 item(s) has been submitted. Status: Awaiting Store Approval.', 'fa-clock', 'primary', 'http://127.0.0.1:8000/my-bookings', 0, '2026-08-08 14:34:08', '2026-08-08 14:34:08'),
(11, 3, 'order', 'New Order Received!', 'Order placed by chachu for \"STAMANAX 1000mg Herbal Vitality Capsules\". Qty: 1. Total: Rs. 2,750', 'fa-shopping-cart', 'indigo', 'http://127.0.0.1:8000/vendor/orders', 0, '2026-08-08 14:44:12', '2026-08-08 14:44:12'),
(12, 1, 'order', 'Order Placed Successfully', 'Your order with 1 item(s) has been submitted. Status: Awaiting Store Approval.', 'fa-clock', 'primary', 'http://127.0.0.1:8000/my-bookings', 0, '2026-08-08 14:44:12', '2026-08-08 14:44:12'),
(13, 1, 'order', 'Order Update: Confirmed', 'The store for [STAMANAX 1000mg Herbal Vitality Capsules] has updated your order status to: CONFIRMED.', 'fa-calendar-check', 'green', 'http://127.0.0.1:8000/my-bookings', 0, '2026-08-08 14:46:05', '2026-08-08 14:46:05'),
(14, 1, 'order', 'Order Record Updated', 'You have confirmed the order for chachu.', 'fa-check-circle', 'blue', 'http://127.0.0.1:8000/admin/bookings', 0, '2026-08-08 14:46:05', '2026-08-08 14:46:05'),
(15, 1, 'order', 'Order Update: Completed', 'The store for [STAMANAX 1000mg Herbal Vitality Capsules] has updated your order status to: COMPLETED.', 'fa-check-double', 'blue', 'http://127.0.0.1:8000/my-bookings', 0, '2026-08-08 14:46:12', '2026-08-08 14:46:12'),
(16, 1, 'order', 'Order Record Updated', 'You have completed the order for chachu.', 'fa-check-circle', 'blue', 'http://127.0.0.1:8000/admin/bookings', 0, '2026-08-08 14:46:12', '2026-08-08 14:46:12');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL,
  `status` enum('pending','confirmed','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `payment_method` enum('cod','stripe') NOT NULL DEFAULT 'cod',
  `payment_status` enum('unpaid','paid','refunded') NOT NULL DEFAULT 'unpaid',
  `shipping_name` varchar(255) NOT NULL,
  `shipping_phone` varchar(255) NOT NULL,
  `shipping_address` text NOT NULL,
  `shipping_city` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `line_total` decimal(10,2) NOT NULL,
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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `stripe_session_id` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'PKR',
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) NOT NULL DEFAULT 'stripe',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `stock_quantity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `category` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `sku` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sub_category` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `pos_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `website_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `purchase_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `promotional_discount` decimal(10,2) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `is_best_seller` tinyint(1) NOT NULL DEFAULT 0,
  `is_new_arrival` tinyint(1) NOT NULL DEFAULT 0,
  `related_products` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`related_products`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL,
  `comment` text NOT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `reply` text DEFAULT NULL,
  `replied_at` timestamp NULL DEFAULT NULL,
  `likes_count` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review_likes`
--

CREATE TABLE `review_likes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `review_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `short_description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `pos_price` decimal(10,2) DEFAULT NULL,
  `website_price` decimal(10,2) DEFAULT NULL,
  `purchase_price` decimal(10,2) DEFAULT NULL,
  `is_on_sale` tinyint(1) NOT NULL DEFAULT 0,
  `sale_price` decimal(12,2) DEFAULT NULL,
  `promotional_discount` decimal(10,2) DEFAULT NULL,
  `packages` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`packages`)),
  `add_ons` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`add_ons`)),
  `related_products` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`related_products`)),
  `price_type` varchar(255) NOT NULL DEFAULT 'fixed',
  `protocol` varchar(255) NOT NULL DEFAULT 'simple',
  `location` varchar(255) DEFAULT NULL,
  `extra_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`extra_data`)),
  `image` varchar(255) DEFAULT NULL,
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `featured_image_index` int(11) DEFAULT 0,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `cached_rating` decimal(3,2) NOT NULL DEFAULT 0.00,
  `reviews_count` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sub_category` varchar(255) DEFAULT NULL,
  `brand` varchar(255) DEFAULT NULL,
  `unit` varchar(255) DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_best_seller` tinyint(1) NOT NULL DEFAULT 0,
  `is_new_arrival` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `user_id`, `name`, `description`, `short_description`, `price`, `pos_price`, `website_price`, `purchase_price`, `is_on_sale`, `sale_price`, `promotional_discount`, `packages`, `add_ons`, `related_products`, `price_type`, `protocol`, `location`, `extra_data`, `image`, `images`, `featured_image_index`, `status`, `cached_rating`, `reviews_count`, `created_at`, `updated_at`, `category_id`, `sub_category`, `brand`, `unit`, `is_featured`, `is_best_seller`, `is_new_arrival`) VALUES
(6, 2, 'Ergonomic Office Chair', 'Lumbar support, breathable mesh, adjustable armrests for all-day comfort.', NULL, 28000.00, NULL, NULL, NULL, 0, NULL, NULL, '[]', '[]', NULL, 'fixed', 'simple', 'Nationwide Delivery', NULL, 'https://images.unsplash.com/photo-1505843490538-5133c6c7d0e1?w=800&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1505843490538-5133c6c7d0e1?w=800&q=80\"]', 0, 'active', 0.00, 0, '2026-05-16 12:02:53', '2026-06-08 23:54:41', NULL, NULL, NULL, NULL, 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `service_availability`
--

CREATE TABLE `service_availability` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` bigint(20) UNSIGNED NOT NULL,
  `unavailable_date` date NOT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `service_categories`
--

CREATE TABLE `service_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT '#1e3a5f',
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `service_categories`
--

INSERT INTO `service_categories` (`id`, `name`, `slug`, `icon`, `image`, `description`, `color`, `parent_id`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(8, 'Hair Tools', 'organic-herbal-teas', 'fa-scissors', 'https://images.unsplash.com/photo-1576092768241-dec231879fc3?q=80&w=1200&auto=format&fit=crop', '100% pure loose leaf green teas, chamomile, peppermint, and detox herbal infusions.', '#D4AF37', NULL, 1, 1, '2026-08-03 16:40:58', '2026-08-03 16:40:58'),
(9, 'Hair Care', 'essential-oils-aroma', 'fa-pump-soap', 'https://images.unsplash.com/photo-1608248597260-6521e8e1218a?q=80&w=1200&auto=format&fit=crop', 'Cold-pressed lavender, eucalyptus, tea tree, and therapeutic essential oil drops.', '#D4AF37', NULL, 1, 2, '2026-08-03 16:40:58', '2026-08-03 16:40:58'),
(10, 'Beauty & Makeup', 'botanical-skincare', 'fa-eye-dropper', 'https://images.unsplash.com/photo-1556228720-195a672e8a03?q=80&w=1200&auto=format&fit=crop', 'Chemical-free facial serums, organic aloe gels, rose water, and herbal clay masks.', '#D4AF37', NULL, 1, 3, '2026-08-03 16:40:58', '2026-08-03 16:40:58'),
(11, 'Salon Equipment', 'herbal-health-remedies', 'fa-chair', 'https://images.unsplash.com/photo-1540420773420-3366772f4999?q=80&w=1200&auto=format&fit=crop', 'Traditional ayurvedic formulations, unrefined honey remedies, and herbal elixirs.', '#D4AF37', NULL, 1, 4, '2026-08-03 16:40:58', '2026-08-03 16:40:58'),
(12, 'Professional Essentials', 'raw-herbs-spices', 'fa-gear', 'https://images.unsplash.com/photo-1509358271058-acd05cc93898?q=80&w=1200&auto=format&fit=crop', 'Direct farm-sourced organic turmeric, cinnamon sticks, saffron, and dried roots.', '#4B5563', NULL, 1, 5, '2026-08-03 16:40:58', '2026-08-03 16:40:58'),
(13, 'Offers & Deals', 'natural-hair-care-oils', 'fa-fire', 'https://images.unsplash.com/photo-1522337360788-8b13dee7a37e?q=80&w=1200&auto=format&fit=crop', 'Pure onion oil, black seed oil, coconut oil, and 21-herb anti-hairfall blends.', '#EF4444', NULL, 1, 6, '2026-08-03 16:40:58', '2026-08-03 16:40:58'),
(14, 'Best Sellers', 'immunity-detox', 'fa-star', 'https://images.unsplash.com/photo-1615485290382-441e4d049cb5?q=80&w=1200&auto=format&fit=crop', 'Natural wellness supplements, moringa powder, and organic immunity boosters.', '#D4AF37', NULL, 1, 7, '2026-08-03 16:40:58', '2026-08-03 16:40:58'),
(15, 'Accessories', 'aromatic-incense-resins', 'fa-box-open', 'https://images.unsplash.com/photo-1602928321679-560bb453f190?q=80&w=1200&auto=format&fit=crop', 'Natural bakhoor, organic frankincense resins, and herbal aroma diffuser sticks.', '#D4AF37', NULL, 1, 8, '2026-08-03 16:40:58', '2026-08-03 16:40:58');

-- --------------------------------------------------------

--
-- Table structure for table `service_desk_requests`
--

CREATE TABLE `service_desk_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reference` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `service_type` varchar(255) NOT NULL,
  `desk_type` varchar(255) NOT NULL,
  `priority` varchar(255) NOT NULL DEFAULT 'medium',
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `event_location` varchar(255) DEFAULT NULL,
  `event_address` varchar(255) DEFAULT NULL,
  `event_date` datetime DEFAULT NULL,
  `guest_count` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
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
('prC6aSlke2wDLNJHqwYq0Hlsma84NbEGLiSrYS7H', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/155.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNnRFN212OVB3SkI2cExMYk5aekxJWTNDc09hbEZLZkZpNjNJcnZiMiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1792257311),
('teDR35S2WGVvGFA25bGfbasRC2SyBxduRWpLbBbt', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/154.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidnFNZ0dpQk12cnNCWWV2Um41ZE8zVm9OYzBhYXhmeEhoajBweUh2TyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC91bnJlYWQtbWVzc2FnZXMtY291bnQiO3M6NToicm91dGUiO3M6MjE6Im1lc3NhZ2VzLnVucmVhZC1jb3VudCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1791381106);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'AJ SALONIA', '2026-05-20 16:10:10', '2026-09-30 10:56:03'),
(2, 'site_logo', '/uploads/settings/1790765763_logo_WhatsApp Image 2026-09-29 at 3.54.09 PM.jpeg', '2026-07-30 14:29:08', '2026-09-30 10:56:03'),
(3, 'site_slogan', 'Professional Salon Tools & Beauty Equipment', '2026-07-30 14:44:54', '2026-09-30 10:56:03'),
(4, 'site_tagline', 'Your premium destination for elite electronics, luxury fashion, and high-performance assets. Experience worldwide delivery excellence.  Shop Collections', '2026-07-30 14:44:54', '2026-07-30 16:11:17'),
(5, 'site_description', 'Your one-stop destination for high-quality salon accessories and professional beauty tools.', '2026-07-30 14:44:54', '2026-07-30 14:45:46'),
(6, 'meta_description', '', '2026-07-30 14:44:54', '2026-09-30 10:56:03'),
(7, 'contact_email', '', '2026-07-30 14:44:54', '2026-07-30 15:11:21'),
(8, 'contact_phone', '', '2026-07-30 14:44:54', '2026-07-30 15:11:21'),
(9, 'contact_address', 'fdfwe2e', '2026-07-30 14:44:54', '2026-07-30 15:10:17'),
(10, 'social_facebook', '', '2026-07-30 14:44:54', '2026-07-30 14:44:54'),
(11, 'social_instagram', '', '2026-07-30 14:44:54', '2026-07-30 14:44:54'),
(12, 'social_linkedin', '', '2026-07-30 14:44:54', '2026-07-30 14:44:54'),
(13, 'social_tiktok', '', '2026-07-30 14:44:54', '2026-07-30 14:44:54'),
(14, 'social_youtube', '', '2026-07-30 14:44:54', '2026-07-30 14:44:54'),
(15, 'social_whatsapp', '', '2026-07-30 14:44:54', '2026-07-30 14:44:54'),
(16, 'fashion_heading', '', '2026-07-30 16:17:21', '2026-07-30 17:37:42'),
(17, 'fashion_subtitle', '', '2026-07-30 16:17:21', '2026-07-30 17:37:42'),
(18, 'fashion_btn_text', '', '2026-07-30 16:17:21', '2026-07-30 17:37:42'),
(19, 'tech_heading', 'SALON ACCESSORIES & EQUIPMENT', '2026-07-30 16:17:21', '2026-08-03 16:50:06'),
(20, 'tech_subtitle', 'Everything you need to provide the best service to your clients.', '2026-07-30 16:17:21', '2026-08-03 16:50:06'),
(21, 'tech_btn_text', 'SHOP ALL SUPPLIES', '2026-07-30 16:17:21', '2026-08-03 16:50:06'),
(22, 'enterprise_tag', 'BULK & WHOLESALE HERBAL CARE', '2026-07-30 16:17:21', '2026-08-03 16:50:06'),
(23, 'enterprise_heading', 'RAW HERBS & WHOLESALE SUPPLIES', '2026-07-30 16:17:21', '2026-08-03 16:50:06'),
(24, 'enterprise_subtitle', 'Direct farm-sourced organic herbs, bulk essential oils, and botanical formulations.', '2026-07-30 16:17:21', '2026-08-03 16:50:06'),
(25, 'newsletter_heading', 'JOIN THE ELITE CIRCLE', '2026-07-30 16:17:21', '2026-07-30 16:17:21'),
(26, 'newsletter_subtitle', 'Get exclusive access to limited drops, flash sales, and premium lifestyle assets.', '2026-07-30 16:17:21', '2026-07-30 16:17:21'),
(27, 'theme_primary_color', '#000000', '2026-07-30 16:24:35', '2026-07-30 16:32:07'),
(28, 'theme_secondary_color', '#D4AF37', '2026-07-30 16:24:35', '2026-07-30 16:24:35'),
(29, 'theme_font_family', 'Plus Jakarta Sans', '2026-07-30 16:24:35', '2026-07-30 16:24:35'),
(30, 'admin_sidebar_bg', '#021840', '2026-07-30 16:24:35', '2026-07-30 17:01:24'),
(31, 'admin_dashboard_title', 'Management Control Center', '2026-07-30 16:24:35', '2026-07-30 16:24:35'),
(32, 'services_page_tag', 'Strategic Asset Portfolio v4.0.0', '2026-07-30 16:30:29', '2026-07-30 16:30:29'),
(33, 'services_page_heading', 'Asset Portfolio', '2026-07-30 16:30:29', '2026-07-30 16:30:29'),
(34, 'services_page_subtitle', 'Curating Pakistan\'s most sophisticated network of premium vendors and logistical architects for high-stakes execution.', '2026-07-30 16:30:29', '2026-07-30 16:30:29'),
(35, 'contact_page_heading', 'Get In Touch', '2026-07-30 16:30:29', '2026-07-30 16:30:29'),
(36, 'contact_page_subtitle', 'Dedicated service desks and expert teams ready to assist you with any inquiry, anytime, anywhere.', '2026-07-30 16:30:29', '2026-07-30 16:30:29'),
(37, 'contact_page_badge', '24/7 Support Available', '2026-07-30 16:30:29', '2026-07-30 16:30:29'),
(38, 'btn_primary_bg', '#000000', '2026-07-30 17:37:42', '2026-07-30 17:37:42'),
(39, 'btn_primary_text', '#ffffff', '2026-07-30 17:37:42', '2026-07-30 17:37:42'),
(40, 'btn_secondary_bg', '#dc2626', '2026-07-30 17:37:42', '2026-07-30 17:37:42'),
(41, 'btn_secondary_text', '#ffffff', '2026-07-30 17:37:42', '2026-07-30 17:37:42'),
(42, 'trending_tag', 'Professional Salon Tools', '2026-07-30 17:37:42', '2026-07-30 17:37:42'),
(43, 'trending_heading', 'Salon Equipment Categories', '2026-07-30 17:37:42', '2026-07-30 17:37:42'),
(44, 'fashion_btn_bg', '#000000', '2026-07-30 17:37:42', '2026-07-30 17:37:42'),
(45, 'tech_btn_bg', '#15803d', '2026-07-30 17:37:42', '2026-08-03 16:50:06'),
(46, 'featured_section_tag', 'Featured Equipment', '2026-08-08 14:30:24', '2026-08-08 14:30:24'),
(47, 'featured_section_heading', 'Premium Quality Scissors', '2026-08-08 14:30:24', '2026-08-08 14:30:24'),
(48, 'featured_section_subtitle', 'Elevate your craft with our top-tier salon scissors.', '2026-08-08 14:30:24', '2026-08-08 14:30:24'),
(49, 'featured_product_title', 'AJ SALONIA Professional Scissors', '2026-08-08 14:30:24', '2026-09-06 14:20:13'),
(50, 'featured_product_desc', 'High quality professional salon scissors.', '2026-08-08 14:30:24', '2026-08-08 14:30:24'),
(51, 'featured_price', '1200', '2026-08-08 14:30:24', '2026-09-06 14:20:13'),
(52, 'featured_old_price', '1500', '2026-08-08 14:30:24', '2026-09-06 14:20:13'),
(53, 'featured_discount_tag', 'Save 20% OFF', '2026-08-08 14:30:24', '2026-08-08 14:31:51'),
(54, 'featured_video_1_label', 'Marble Showcase', '2026-08-08 14:30:24', '2026-08-08 14:30:24'),
(55, 'featured_video_2_label', 'HABIBI NATURAL HONEY', '2026-08-08 14:30:24', '2026-09-06 14:30:48'),
(56, 'featured_badge_1', '100% Pure - Organic Sourced', '2026-08-08 14:30:24', '2026-08-08 14:30:24'),
(57, 'featured_badge_2', 'Lab Tested - Certified Quality', '2026-08-08 14:30:24', '2026-08-08 14:30:24'),
(58, 'featured_badge_3', 'Fast Acting - Max Absorption', '2026-08-08 14:30:24', '2026-08-08 14:30:24'),
(59, 'featured_badge_4', 'Zero Chemicals - No Preservatives', '2026-08-08 14:30:24', '2026-08-08 14:30:24'),
(60, 'featured_btn_link', '/services/19', '2026-08-08 14:30:24', '2026-09-06 14:20:13'),
(61, 'featured_video_1', '/uploads/videos/7rKaEaHzq2Uf5HtqOLa1jFdbsTMhF0q1Pqqnjjy0.mp4', '2026-08-08 14:30:24', '2026-09-06 14:16:21'),
(62, 'featured_video_2', '/uploads/videos/1788705048_v2_Generating_branding_video_for_honey_202609061930.mp4', '2026-08-08 14:30:24', '2026-09-06 14:30:48'),
(63, 'featured_product_title_2', 'HABIBI HERBAL HONEY', '2026-09-06 14:58:35', '2026-09-06 14:58:35'),
(64, 'featured_product_desc_2', 'Premium cold-pressed natural extract formulated with 100% pure organic herbal botanicals. Formulated for maximum strength, purity, and daily restoration.', '2026-09-06 14:58:35', '2026-09-06 14:58:35'),
(65, 'featured_price_2', '1200', '2026-09-06 14:58:35', '2026-09-06 14:58:35'),
(66, 'featured_old_price_2', '1500', '2026-09-06 14:58:35', '2026-09-06 14:58:35'),
(67, 'featured_discount_tag_2', 'SAVE 20% OFF', '2026-09-06 14:58:35', '2026-09-06 14:58:35'),
(68, 'featured_badge_1_2', '100% Pure - Organic Sourced', '2026-09-06 14:58:35', '2026-09-06 14:58:35'),
(69, 'featured_badge_2_2', 'Lab Tested - Certified Quality', '2026-09-06 14:58:35', '2026-09-06 14:58:35'),
(70, 'featured_badge_3_2', 'Fast Acting - Max Absorption', '2026-09-06 14:58:35', '2026-09-06 14:58:35'),
(71, 'featured_badge_4_2', 'Zero Chemicals - No Preservatives', '2026-09-06 14:58:35', '2026-09-06 14:58:35');

-- --------------------------------------------------------

--
-- Table structure for table `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `quote` text NOT NULL,
  `stars` int(11) NOT NULL DEFAULT 5,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `role`, `quote`, `stars`, `created_at`, `updated_at`) VALUES
(1, 'Sarah Ahmed', 'Premium Customer', 'Exceptional quality and authentic luxury. The delivery was remarkably fast.', 5, '2026-05-08 15:24:52', '2026-05-08 15:24:52'),
(2, 'Ali Khan', 'Corporate Partner', 'The wholesale experience is unparalleled. Perfect for corporate gifting.', 5, '2026-05-08 15:24:52', '2026-05-08 15:24:52'),
(3, 'Fatima Hassan', 'Loyal Customer', 'Verified products and excellent support. Best shopping experience in Pakistan.', 5, '2026-05-08 15:24:52', '2026-05-08 15:24:52');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `symbol` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `symbol`, `created_at`, `updated_at`) VALUES
(1, 'pc', 'asdasd', '2026-06-03 15:42:48', '2026-06-03 15:42:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `business_name` varchar(255) DEFAULT NULL,
  `business_type` varchar(255) DEFAULT NULL,
  `ntn_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `balance` decimal(12,2) NOT NULL DEFAULT 0.00,
  `commission_rate` decimal(5,2) NOT NULL DEFAULT 10.00,
  `bio` text DEFAULT NULL,
  `social_links` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`social_links`)),
  `business_hours` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`business_hours`)),
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions`)),
  `vendor_type` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `city_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `business_name`, `business_type`, `ntn_number`, `email`, `avatar`, `balance`, `commission_rate`, `bio`, `social_links`, `business_hours`, `email_verified_at`, `password`, `role`, `permissions`, `vendor_type`, `is_verified`, `remember_token`, `created_at`, `updated_at`, `city_id`, `category_id`) VALUES
(1, 'Store Admin', NULL, NULL, NULL, 'admin@store.com', NULL, 0.00, 10.00, NULL, NULL, NULL, '2026-05-08 15:24:51', '$2y$12$iTlE0Rrs04VME6y15h620.2ia717h0h5wvEyzPACKD8YmvkzWDlP6', 'admin', NULL, NULL, 0, NULL, '2026-05-08 15:24:51', '2026-05-08 15:24:51', NULL, NULL),
(2, 'Admin User', NULL, NULL, NULL, 'admin@eventy.pk', NULL, 0.00, 10.00, NULL, NULL, NULL, NULL, '$2y$12$0HZqXtzUEVXOYdlVyGNfd.Al9s6.VVMDCqPx5lam4iFhA8OCDnQei', 'admin', NULL, NULL, 0, NULL, '2026-05-16 11:10:00', '2026-05-16 11:10:00', NULL, NULL),
(3, 'Vendor One', NULL, NULL, NULL, 'vendor@eventy.pk', NULL, 5625.00, 10.00, NULL, NULL, NULL, NULL, '$2y$12$atT0QItGVUwnY8dSTNugceqEU0SAzh6sWLv16v/nugHVp27gXF1DW', 'vendor', NULL, NULL, 1, NULL, '2026-05-16 11:10:00', '2026-08-08 14:46:12', NULL, NULL),
(4, 'Test User', NULL, NULL, NULL, 'user@eventy.pk', NULL, 0.00, 10.00, NULL, NULL, NULL, NULL, '$2y$12$tFPQbXcSxRxTYptGzzpqZO1OL3mGElsbEr8GkNmcKbyBB1HmyZg2m', 'user', NULL, NULL, 0, NULL, '2026-05-16 11:10:01', '2026-05-16 11:10:01', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendor_logs`
--

CREATE TABLE `vendor_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vendor_id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `action` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `vendor_logs`
--

INSERT INTO `vendor_logs` (`id`, `vendor_id`, `booking_id`, `action`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'received', 'Vendor received a new order (Booking #1)', '2026-05-08 16:25:19', '2026-05-08 16:25:19'),
(2, 1, 2, 'received', 'Vendor received a new order (Booking #2)', '2026-05-08 16:25:53', '2026-05-08 16:25:53'),
(3, 1, 3, 'received', 'Vendor received a new order (Booking #3)', '2026-05-08 16:29:27', '2026-05-08 16:29:27'),
(4, 1, 4, 'received', 'Vendor received a new order (Booking #4)', '2026-05-09 12:13:41', '2026-05-09 12:13:41'),
(5, 1, 1, 'received', 'Vendor received a new order (Booking #1)', '2026-08-03 18:25:58', '2026-08-03 18:25:58'),
(6, 3, 2, 'received', 'Vendor received a new order (Booking #2)', '2026-08-08 13:59:25', '2026-08-08 13:59:25'),
(7, 1, 1, 'cancelled', 'Order Cancelled (Booking #1)', '2026-08-08 14:16:16', '2026-08-08 14:16:16'),
(8, 3, 3, 'received', 'Vendor received a new order (Booking #3)', '2026-08-08 14:34:08', '2026-08-08 14:34:08'),
(9, 3, 4, 'received', 'Vendor received a new order (Booking #4)', '2026-08-08 14:44:12', '2026-08-08 14:44:12'),
(10, 3, 4, 'confirmed', 'Order Confirmed (Booking #4)', '2026-08-08 14:46:02', '2026-08-08 14:46:02'),
(11, 3, 4, 'completed', 'Order Completed (Booking #4)', '2026-08-08 14:46:09', '2026-08-08 14:46:09');

-- --------------------------------------------------------

--
-- Table structure for table `withdrawals`
--

CREATE TABLE `withdrawals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `affiliate_commissions`
--
ALTER TABLE `affiliate_commissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `affiliate_commissions_affiliate_id_foreign` (`affiliate_id`),
  ADD KEY `affiliate_commissions_booking_id_foreign` (`booking_id`);

--
-- Indexes for table `affiliate_leads`
--
ALTER TABLE `affiliate_leads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `affiliate_leads_affiliate_id_foreign` (`affiliate_id`),
  ADD KEY `affiliate_leads_converted_user_id_foreign` (`converted_user_id`);

--
-- Indexes for table `affiliate_resources`
--
ALTER TABLE `affiliate_resources`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `blog_posts_slug_unique` (`slug`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_user_id_foreign` (`user_id`),
  ADD KEY `bookings_service_id_foreign` (`service_id`),
  ADD KEY `bookings_vendor_id_foreign` (`vendor_id`),
  ADD KEY `bookings_assigned_admin_id_foreign` (`assigned_admin_id`),
  ADD KEY `bookings_status_index` (`status`),
  ADD KEY `bookings_booking_date_index` (`booking_date`),
  ADD KEY `bookings_total_price_index` (`total_price`),
  ADD KEY `bookings_event_type_index` (`event_type`),
  ADD KEY `bookings_department_index` (`department`),
  ADD KEY `bookings_approval_level_index` (`approval_level`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_name_unique` (`name`),
  ADD UNIQUE KEY `brands_slug_unique` (`slug`);

--
-- Indexes for table `budget_requests`
--
ALTER TABLE `budget_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `budget_requests_user_id_foreign` (`user_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cities_slug_unique` (`slug`),
  ADD KEY `cities_province_index` (`province`),
  ADD KEY `cities_region_index` (`region`);

--
-- Indexes for table `contact_inquiries`
--
ALTER TABLE `contact_inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`),
  ADD KEY `coupons_vendor_id_foreign` (`vendor_id`);

--
-- Indexes for table `custom_packages`
--
ALTER TABLE `custom_packages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custom_packages_user_id_foreign` (`user_id`);

--
-- Indexes for table `custom_package_bookings`
--
ALTER TABLE `custom_package_bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custom_package_bookings_user_id_foreign` (`user_id`),
  ADD KEY `custom_package_bookings_custom_package_id_foreign` (`custom_package_id`);

--
-- Indexes for table `custom_package_services`
--
ALTER TABLE `custom_package_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custom_package_services_custom_package_id_foreign` (`custom_package_id`),
  ADD KEY `custom_package_services_service_id_foreign` (`service_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `favorites_user_id_service_id_unique` (`user_id`,`service_id`),
  ADD KEY `favorites_service_id_foreign` (`service_id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
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
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_sender_id_foreign` (`sender_id`),
  ADD KEY `messages_receiver_id_foreign` (`receiver_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletters`
--
ALTER TABLE `newsletters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `newsletters_email_unique` (`email`);

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
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_booking_id_foreign` (`booking_id`),
  ADD KEY `payments_user_id_foreign` (`user_id`);

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
  ADD UNIQUE KEY `products_sku_unique` (`sku`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reviews_booking_id_unique` (`booking_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_service_id_foreign` (`service_id`);

--
-- Indexes for table `review_likes`
--
ALTER TABLE `review_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `review_likes_user_id_review_id_unique` (`user_id`,`review_id`),
  ADD KEY `review_likes_review_id_foreign` (`review_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_user_id_foreign` (`user_id`),
  ADD KEY `services_category_id_foreign` (`category_id`);

--
-- Indexes for table `service_availability`
--
ALTER TABLE `service_availability`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_availability_service_id_unavailable_date_unique` (`service_id`,`unavailable_date`);

--
-- Indexes for table `service_categories`
--
ALTER TABLE `service_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_categories_slug_unique` (`slug`),
  ADD KEY `service_categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `service_desk_requests`
--
ALTER TABLE `service_desk_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `service_desk_requests_reference_unique` (`reference`),
  ADD KEY `service_desk_requests_user_id_foreign` (`user_id`),
  ADD KEY `service_desk_requests_booking_id_foreign` (`booking_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `units_name_unique` (`name`),
  ADD UNIQUE KEY `units_symbol_unique` (`symbol`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_city_id_foreign` (`city_id`),
  ADD KEY `users_category_id_foreign` (`category_id`);

--
-- Indexes for table `vendor_logs`
--
ALTER TABLE `vendor_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vendor_logs_vendor_id_foreign` (`vendor_id`),
  ADD KEY `vendor_logs_booking_id_foreign` (`booking_id`);

--
-- Indexes for table `withdrawals`
--
ALTER TABLE `withdrawals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `withdrawals_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `affiliate_commissions`
--
ALTER TABLE `affiliate_commissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `affiliate_leads`
--
ALTER TABLE `affiliate_leads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `affiliate_resources`
--
ALTER TABLE `affiliate_resources`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `budget_requests`
--
ALTER TABLE `budget_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contact_inquiries`
--
ALTER TABLE `contact_inquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_packages`
--
ALTER TABLE `custom_packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_package_bookings`
--
ALTER TABLE `custom_package_bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_package_services`
--
ALTER TABLE `custom_package_services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `newsletters`
--
ALTER TABLE `newsletters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review_likes`
--
ALTER TABLE `review_likes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `service_availability`
--
ALTER TABLE `service_availability`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `service_categories`
--
ALTER TABLE `service_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `service_desk_requests`
--
ALTER TABLE `service_desk_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vendor_logs`
--
ALTER TABLE `vendor_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `withdrawals`
--
ALTER TABLE `withdrawals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `affiliate_commissions`
--
ALTER TABLE `affiliate_commissions`
  ADD CONSTRAINT `affiliate_commissions_affiliate_id_foreign` FOREIGN KEY (`affiliate_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `affiliate_commissions_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `affiliate_leads`
--
ALTER TABLE `affiliate_leads`
  ADD CONSTRAINT `affiliate_leads_affiliate_id_foreign` FOREIGN KEY (`affiliate_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `affiliate_leads_converted_user_id_foreign` FOREIGN KEY (`converted_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_assigned_admin_id_foreign` FOREIGN KEY (`assigned_admin_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `bookings_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `budget_requests`
--
ALTER TABLE `budget_requests`
  ADD CONSTRAINT `budget_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `coupons`
--
ALTER TABLE `coupons`
  ADD CONSTRAINT `coupons_vendor_id_foreign` FOREIGN KEY (`vendor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `custom_packages`
--
ALTER TABLE `custom_packages`
  ADD CONSTRAINT `custom_packages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `custom_package_bookings`
--
ALTER TABLE `custom_package_bookings`
  ADD CONSTRAINT `custom_package_bookings_custom_package_id_foreign` FOREIGN KEY (`custom_package_id`) REFERENCES `custom_packages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `custom_package_bookings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `custom_package_services`
--
ALTER TABLE `custom_package_services`
  ADD CONSTRAINT `custom_package_services_custom_package_id_foreign` FOREIGN KEY (`custom_package_id`) REFERENCES `custom_packages` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `custom_package_services_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

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
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `review_likes`
--
ALTER TABLE `review_likes`
  ADD CONSTRAINT `review_likes_review_id_foreign` FOREIGN KEY (`review_id`) REFERENCES `reviews` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `review_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `services_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_availability`
--
ALTER TABLE `service_availability`
  ADD CONSTRAINT `service_availability_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_categories`
--
ALTER TABLE `service_categories`
  ADD CONSTRAINT `service_categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `service_categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `service_desk_requests`
--
ALTER TABLE `service_desk_requests`
  ADD CONSTRAINT `service_desk_requests_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `service_desk_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `service_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
