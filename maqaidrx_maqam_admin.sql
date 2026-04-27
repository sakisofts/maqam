-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 27, 2026 at 08:57 AM
-- Server version: 10.11.11-MariaDB-ubu2204
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maqaidrx_maqam_admin`
--

-- --------------------------------------------------------

--
-- Table structure for table `adverts`
--

CREATE TABLE `adverts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `endDateTime` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `adverts`
--

INSERT INTO `adverts` (`id`, `image`, `title`, `description`, `endDateTime`, `created_at`, `updated_at`) VALUES
(9, '1731658773.jpg', 'We\'re now accredited', 'TRAVEL AGENT OF IATA', '2025-01-01 00:00:00', '2024-11-15 13:19:33', '2024-11-15 13:28:20'),
(8, '1731524488.jpg', 'Hajj or Umrah Surprise', 'Do it for your beloved one now!', '2025-01-01 00:00:00', '2024-11-14 00:01:28', '2024-11-14 00:02:45');

-- --------------------------------------------------------

--
-- Table structure for table `amenities`
--

CREATE TABLE `amenities` (
  `id` bigint(20) NOT NULL,
  `amenity` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `charges` bigint(20) DEFAULT 0,
  `currency` varchar(10) DEFAULT 'USD'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `amenities`
--

INSERT INTO `amenities` (`id`, `amenity`, `created_by`, `created_at`, `charges`, `currency`) VALUES
(1, 'Prayer Guidance Services', 1, '2025-05-09 20:49:37', 0, 'USD'),
(2, 'Multilingual Religious Guides', 1, '2025-05-09 20:49:37', 0, 'USD'),
(3, 'Qibla Direction Indicator', 1, '2025-05-09 20:49:37', 0, 'USD'),
(4, 'Zamzam Water Supply', 1, '2025-05-09 20:49:37', 0, 'USD'),
(5, 'Ihram Clothing Provision', 1, '2025-05-09 20:49:37', 10, 'USD'),
(6, 'Halal Food Services', 1, '2025-05-09 20:49:37', 0, 'USD'),
(7, 'Daily Prayer Schedule Notifications', 1, '2025-05-09 20:49:37', 0, 'USD'),
(8, 'Air-conditioned Accommodation', 1, '2025-05-09 20:49:37', 0, 'USD'),
(9, 'Medical Services', 1, '2025-05-09 20:49:37', 0, 'USD'),
(10, 'Wheelchair Assistance', 1, '2025-05-09 20:49:37', 0, 'USD'),
(11, 'Transportation to Holy Sites', 1, '2025-05-09 20:49:37', 0, 'USD'),
(12, 'Personal Guide Services', 1, '2025-05-09 20:49:37', 0, 'USD'),
(13, 'Quran and Prayer Book Provision', 1, '2025-05-09 20:49:37', 0, 'USD'),
(14, 'Translation Services', 1, '2025-05-09 20:49:37', 0, 'USD'),
(15, 'Women\'s Prayer Area Access', 1, '2025-05-09 20:49:37', 0, 'USD'),
(16, 'Elderly Care Services', 1, '2025-05-09 20:49:37', 0, 'USD'),
(17, 'Lost Pilgrim Assistance', 1, '2025-05-09 20:49:37', 0, 'USD'),
(18, 'Luggage Transportation', 1, '2025-05-09 20:49:37', 0, 'USD'),
(19, 'Free WiFi for Religious Apps', 1, '2025-05-09 20:49:37', 0, 'USD'),
(20, 'Hajj Ritual Instruction', 1, '2025-05-09 20:49:37', 0, 'USD'),
(21, 'Hajj Smartphone App', 1, '2025-05-09 20:49:37', 0, 'USD'),
(22, 'Tent Accommodation in Mina', 1, '2025-05-09 20:49:37', 0, 'USD'),
(23, 'Arafat Day Support Services', 1, '2025-05-09 20:49:37', 0, 'USD'),
(24, 'Muzdalifah Stay Facilities', 1, '2025-05-09 20:49:37', 0, 'USD'),
(25, 'Jamarat Ritual Assistance', 1, '2025-05-09 20:49:37', 0, 'USD'),
(26, 'Proximity to Masjid al-Haram', 1, '2025-05-09 20:49:37', 0, 'USD'),
(27, 'Proximity to Masjid al-Nabawi', 1, '2025-05-09 20:49:37', 0, 'USD'),
(28, 'Shuttle Service to Holy Sites', 1, '2025-05-09 20:49:37', 0, 'USD'),
(29, 'Makkah Map and Guidance', 1, '2025-05-09 20:49:37', 0, 'USD'),
(30, 'Madinah Visit Arrangements', 1, '2025-05-09 20:49:37', 0, 'USD'),
(31, 'Hydration Stations', 1, '2025-05-09 20:49:37', 0, 'USD'),
(32, 'Cooling Mist Systems', 1, '2025-05-09 20:49:37', 0, 'USD'),
(33, '24/7 Customer Support', 1, '2025-05-09 20:49:37', 0, 'USD'),
(34, 'Hajj Visa Processing Assistance', 1, '2025-05-09 20:49:37', 0, 'USD'),
(35, 'Group Leader Services', 1, '2025-05-09 20:49:37', 0, 'USD'),
(36, 'Special Meals for Dietary Restrictions', 1, '2025-05-09 20:49:37', 0, 'USD'),
(37, 'Emergency Contact Service', 1, '2025-05-09 20:49:37', 0, 'USD'),
(38, 'Identification Wristbands', 1, '2025-05-09 20:49:37', 0, 'USD'),
(39, 'Cultural Orientation Sessions', 1, '2025-05-09 20:49:37', 0, 'USD'),
(40, 'VIP Tawaf Access', 1, '2025-05-09 20:49:37', 20, 'USD');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userId` bigint(20) UNSIGNED NOT NULL,
  `packageId` bigint(20) UNSIGNED NOT NULL,
  `paymentOption` varchar(255) DEFAULT NULL,
  `travelDocument` varchar(255) DEFAULT NULL,
  `bookingType` varchar(119) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_archived` tinyint(1) DEFAULT 0,
  `created_by` bigint(20) DEFAULT NULL,
  `status` varchar(255) DEFAULT 'Pending',
  `c_year` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `userId`, `packageId`, `paymentOption`, `travelDocument`, `bookingType`, `created_at`, `updated_at`, `name`, `email`, `is_archived`, `created_by`, `status`, `c_year`) VALUES
(140, 162, 16, NULL, '100006443555', 'individual', '2025-05-17 14:11:20', '2025-05-17 14:11:20', 'Kabugo Sumayah', 'sumayyahkabugo@gmail.com', 0, 1, 'Pending', '2025'),
(141, 163, 18, NULL, '100006443555', 'individual', '2025-05-17 16:19:21', '2025-05-17 16:19:21', 'Ssekikubo Yasin Kisule', 'yasinkisuulessekikubo@gmail.com', 0, 1, 'Pending', '2025');

-- --------------------------------------------------------

--
-- Table structure for table `booking_payments`
--

CREATE TABLE `booking_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `bookingId` bigint(20) UNSIGNED NOT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `payment_status` varchar(191) DEFAULT NULL,
  `paymentOption` varchar(119) DEFAULT NULL,
  `currency` varchar(119) DEFAULT NULL,
  `rate` varchar(119) DEFAULT NULL,
  `actual_amount` varchar(119) DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `issuedBy` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booking_payments`
--

INSERT INTO `booking_payments` (`id`, `bookingId`, `amount`, `payment_status`, `paymentOption`, `currency`, `rate`, `actual_amount`, `transaction_id`, `created_at`, `updated_at`, `issuedBy`) VALUES
(301, 137, '2000', NULL, 'AIRTEL Merchant', 'UGX', NULL, '2000', 'txn682728a537617', NULL, NULL, NULL),
(302, 137, '1000', NULL, 'AIRTEL Merchant', 'UGX', NULL, '1000', 'txn68272b2971e87', NULL, NULL, NULL),
(303, 137, '1000', 'completed', 'AIRTEL Merchant', 'UGX', NULL, '1000', 'txn68272f7ad886c', NULL, NULL, NULL),
(304, 140, '1000', 'pending', 'cash', 'USD', '3790', '3790000.00', 'TRX-6828ad3b0ca12', '2025-05-17 00:00:00', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` bigint(20) NOT NULL,
  `device_name` varchar(255) NOT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `event_type_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `registration_deadline` date NOT NULL,
  `visa_deadline` date NOT NULL,
  `max_capacity` int(11) NOT NULL,
  `status` enum('Upcoming','Active','Completed','Cancelled') NOT NULL DEFAULT 'Upcoming',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `event_type`
--

CREATE TABLE `event_type` (
  `id` int(11) NOT NULL,
  `name` enum('Hajj','Umrah') NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_type`
--

INSERT INTO `event_type` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Hajj', 'Annual Islamic pilgrimage to Mecca', 1746724320, 1746724320),
(2, 'Umrah', 'Lesser pilgrimage performed by Muslims to Mecca', 1746724320, 1746724320);

-- --------------------------------------------------------

--
-- Table structure for table `maqam_exes`
--

CREATE TABLE `maqam_exes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `thumbnail` varchar(255) NOT NULL,
  `videoLink` varchar(1000) NOT NULL,
  `description` varchar(255) NOT NULL,
  `detail` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `maqam_exes`
--

INSERT INTO `maqam_exes` (`id`, `thumbnail`, `videoLink`, `description`, `detail`, `created_at`, `updated_at`) VALUES
(3, '1718792520.jpg', 'https://youtu.be/hCf5nUkY14U?si=bXsEjmMqZadoe_ID', 'STATE OF CONSECRATION | January Umrah 2024', 'STATE OF CONSECRATION | January Umrah 2024', '2024-04-03 19:09:15', '2024-06-19 14:22:00'),
(4, '1712157025.jpg', 'https://youtu.be/tLSNMC0ySDY?si=9p6ujGZ5zhu57Xvo', 'TIPS AND BRIEF ABOUT UMRAH | Imam Ahmad Sulaiman Kyeyune', 'vfdjkfbdgfn vbfgnrh', '2024-04-03 19:10:25', '2024-04-27 22:19:05');

-- --------------------------------------------------------

--
-- Table structure for table `master_package`
--

CREATE TABLE `master_package` (
  `id` bigint(20) NOT NULL,
  `package_name` varchar(255) DEFAULT NULL,
  `package_image` varchar(255) DEFAULT NULL,
  `descript` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `reservation_fee` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `currency` varchar(10) DEFAULT 'USD'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `master_package`
--

INSERT INTO `master_package` (`id`, `package_name`, `package_image`, `descript`, `created_at`, `reservation_fee`, `created_by`, `currency`) VALUES
(3, 'December Umrah', NULL, NULL, '2025-05-17 12:31:55', 2900, 1, 'USD'),
(4, 'October Umrah', NULL, NULL, '2025-05-17 12:49:30', 2250, 1, 'USD'),
(5, 'Kids Umrah', NULL, NULL, '2025-05-17 12:53:32', 1650, 1, 'USD'),
(6, 'August Umrah', NULL, NULL, '2025-05-17 12:56:37', 2250, 1, 'USD'),
(7, 'Black Umrah', NULL, NULL, '2025-05-17 12:57:37', 1200, 1, 'USD'),
(8, 'Hajj', NULL, 'Fulfill the fifth pillar of Islam with our Hajj package', '2025-05-17 12:58:08', 5900, 1, 'USD'),
(9, 'Ramadhan Umrah', NULL, NULL, '2025-05-17 12:58:49', 2900, 1, 'USD'),
(10, 'January Umrah', NULL, NULL, '2025-05-17 12:59:25', 2000, 1, 'USD');

-- --------------------------------------------------------

--
-- Table structure for table `oneTimeServices`
--

CREATE TABLE `oneTimeServices` (
  `id` bigint(20) NOT NULL,
  `client_id` bigint(20) DEFAULT NULL,
  `services` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`services`)),
  `total_charge` bigint(20) DEFAULT NULL,
  `status` enum('Pending','Paid','Closed') NOT NULL DEFAULT 'Pending',
  `created_at` datetime DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `oneTimeServices`
--

INSERT INTO `oneTimeServices` (`id`, `client_id`, `services`, `total_charge`, `status`, `created_at`, `created_by`) VALUES
(1, 162, '[\"identificationWristbands\",\"ihramClothingProvision\"]', 10, 'Pending', '2025-05-19 06:24:24', 1);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `standardPrice` varchar(255) DEFAULT NULL,
  `economyPrice` varchar(255) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `dateRange` varchar(255) NOT NULL,
  `endDateTime` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `packageImage` varchar(255) DEFAULT NULL,
  `package_year` varchar(255) DEFAULT NULL,
  `mpId` bigint(20) DEFAULT NULL,
  `is_archived` tinyint(1) DEFAULT 0,
  `amenity` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`amenity`)),
  `status` varchar(255) DEFAULT NULL,
  `currency` varchar(10) DEFAULT 'USD'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `category`, `type`, `description`, `standardPrice`, `economyPrice`, `title`, `dateRange`, `endDateTime`, `created_at`, `updated_at`, `packageImage`, `package_year`, `mpId`, `is_archived`, `amenity`, `status`, `currency`) VALUES
(17, 'tour', 'group', '', '2250', '2250', 'August Umrah 2025', '2025-08-28 - 2025-09-06', '2025-08-28 00:00:00', '2025-05-17 13:17:59', NULL, NULL, '2025', 6, 1, '\"\"', NULL, 'USD'),
(18, 'tour', 'group', '', '1650', '1650', 'Kids Umrah 2025', '2025-08-28 - 2025-09-04', '2025-08-28 00:00:00', '2025-05-17 13:25:39', NULL, NULL, '2025', 5, 1, '\"\"', NULL, 'USD'),
(16, 'tour', 'group', 'Up to 45% OFF our standard price. This is your chance to fulfill your spiritual dreams at an unbeatable value.', '1200', '1200', 'Black Umrah 2025', '2025-07-17 - 2025-07-23', '2025-07-17 00:00:00', '2025-05-17 13:15:39', NULL, NULL, '2025', 7, 1, '\"\"', NULL, 'USD');

-- --------------------------------------------------------

--
-- Table structure for table `package_category`
--

CREATE TABLE `package_category` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `payment_number` varchar(50) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` datetime NOT NULL,
  `payment_method` enum('Cash','Credit Card','Bank Transfer','PayPal','Other') NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `payment_status` enum('Pending','Completed','Failed','Refunded') NOT NULL DEFAULT 'Pending',
  `payment_type` enum('Deposit','Installment','Full Payment','Additional Service') NOT NULL,
  `notes` text DEFAULT NULL,
  `receipt_number` varchar(50) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `from_currency` varchar(255) DEFAULT NULL,
  `to_currency` varchar(255) DEFAULT NULL,
  `conversional_rate` varchar(255) DEFAULT NULL,
  `rate` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `payment_number`, `reservation_id`, `amount`, `payment_date`, `payment_method`, `transaction_id`, `payment_status`, `payment_type`, `notes`, `receipt_number`, `created_at`, `updated_at`, `from_currency`, `to_currency`, `conversional_rate`, `rate`, `created_by`) VALUES
(1, 'RSV-2025-0001', 1, 100.00, '2025-05-18 00:00:00', 'Cash', NULL, 'Pending', 'Installment', '', 'No-2025-0001', 2025, 2025, NULL, NULL, NULL, NULL, NULL),
(2, 'RSV-2025-0002', 1, 100.00, '2025-05-18 00:00:00', 'Cash', NULL, 'Pending', 'Installment', '', 'No-2025-0001', 2025, 2025, NULL, NULL, NULL, NULL, NULL),
(3, 'RSV-2025-0003', 1, 50.00, '2025-05-19 00:00:00', 'Cash', NULL, 'Pending', 'Installment', '', 'No-2025-0001', 2025, 2025, NULL, NULL, NULL, NULL, NULL),
(4, 'OTS-2025-0001', 1, 10.00, '2025-05-31 00:00:00', 'Cash', 'ots', 'Pending', 'Full Payment', '', 'No-2025-0001', 2025, 2025, 'USD', 'UGX', '1 USD = UGX 3,700', '3700', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payment_plan`
--

CREATE TABLE `payment_plan` (
  `id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `total_installments` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_plan_installment`
--

CREATE TABLE `payment_plan_installment` (
  `id` int(11) NOT NULL,
  `payment_plan_id` int(11) NOT NULL,
  `installment_number` int(11) NOT NULL,
  `due_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('Pending','Paid','Overdue') NOT NULL DEFAULT 'Pending',
  `payment_id` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(11) NOT NULL,
  `reservation_number` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `reservation_date` datetime NOT NULL,
  `number_of_pilgrims` int(11) NOT NULL DEFAULT 1,
  `status` enum('Pending','Confirmed','Cancelled','Completed') NOT NULL DEFAULT 'Pending',
  `total_amount` decimal(10,2) NOT NULL,
  `amount_paid` decimal(10,2) NOT NULL DEFAULT 0.00,
  `balance_due` decimal(10,2) NOT NULL,
  `payment_deadline` date NOT NULL,
  `special_requests` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`id`, `reservation_number`, `user_id`, `package_id`, `reservation_date`, `number_of_pilgrims`, `status`, `total_amount`, `amount_paid`, `balance_due`, `payment_deadline`, `special_requests`, `created_at`, `updated_at`) VALUES
(1, 'RES-99847710-084', 163, 5, '2025-05-19 07:36:33', 1, 'Confirmed', 1650.00, 1250.00, 400.00, '2025-08-07', NULL, '2025-05-19 07:36:33', '2025-05-19 07:36:33');

-- --------------------------------------------------------

--
-- Table structure for table `reservation_pilgrim`
--

CREATE TABLE `reservation_pilgrim` (
  `id` int(11) NOT NULL,
  `reservation_id` int(11) NOT NULL,
  `pilgrim_id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `packageId` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `packageId`, `name`, `description`, `image`, `created_at`, `updated_at`) VALUES
(74, 15, 'Accomodation', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus suscipit justo at facilisis. Cras hendrerit nibh turpis, ac vestibulum lacus gravida at. Sed et leo vitae sapien ornare sodales eget in eros. Maecenas dignissim eget erat tempor maximus.', '681dc79520531_1746782101.jpg', '2025-05-09 09:15:01', '2025-05-09 09:15:01'),
(75, 15, 'visaProcessing', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus suscipit justo at facilisis. Cras hendrerit nibh turpis, ac vestibulum lacus gravida at. Sed et leo vitae sapien ornare sodales eget in eros. Maecenas dignissim eget erat tempor maximus.', '681dc79520cc5_1746782101.jpg', '2025-05-09 09:15:01', '2025-05-09 09:15:01'),
(76, 15, 'returnFlight', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus suscipit justo at facilisis. Cras hendrerit nibh turpis, ac vestibulum lacus gravida at. Sed et leo vitae sapien ornare sodales eget in eros. Maecenas dignissim eget erat tempor maximus.', '681dc79520f8c_1746782101.jpg', '2025-05-09 09:15:01', '2025-05-09 09:15:01'),
(77, 15, 'groundTransport', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus suscipit justo at facilisis. Cras hendrerit nibh turpis, ac vestibulum lacus gravida at. Sed et leo vitae sapien ornare sodales eget in eros. Maecenas dignissim eget erat tempor maximus.', '681dc795211dc_1746782101.jpg', '2025-05-09 09:15:01', '2025-05-09 09:15:01'),
(78, 15, 'historicalSitesTour', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus suscipit justo at facilisis. Cras hendrerit nibh turpis, ac vestibulum lacus gravida at. Sed et leo vitae sapien ornare sodales eget in eros. Maecenas dignissim eget erat tempor maximus.', '681dc79521456_1746782101.png', '2025-05-09 09:15:01', '2025-05-09 09:15:01'),
(79, 15, 'breakfast_iftar', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus suscipit justo at facilisis. Cras hendrerit nibh turpis, ac vestibulum lacus gravida at. Sed et leo vitae sapien ornare sodales eget in eros. Maecenas dignissim eget erat tempor maximus.', '681dc795215f4_1746782101.jpg', '2025-05-09 09:15:01', '2025-05-09 09:15:01'),
(80, 15, 'train', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc dapibus suscipit justo at facilisis. Cras hendrerit nibh turpis, ac vestibulum lacus gravida at. Sed et leo vitae sapien ornare sodales eget in eros. Maecenas dignissim eget erat tempor maximus.', '681dc79521939_1746782101.jpg', '2025-05-09 09:15:01', '2025-05-09 09:15:01');

-- --------------------------------------------------------

--
-- Table structure for table `sonda_mpolas`
--

CREATE TABLE `sonda_mpolas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `identificationType` varchar(255) DEFAULT NULL,
  `nin_or_passport` varchar(255) DEFAULT NULL,
  `dateOfExpiry` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `otherPhone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `savingFor` varchar(255) DEFAULT NULL,
  `umrahSavingTarget` varchar(255) DEFAULT NULL,
  `hajjSavingTarget` varchar(255) DEFAULT NULL,
  `targetAmount` varchar(255) DEFAULT NULL,
  `gender` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `dob` varchar(255) DEFAULT NULL,
  `placeOfBirth` varchar(255) DEFAULT NULL,
  `fatherName` varchar(255) DEFAULT NULL,
  `motherName` varchar(255) DEFAULT NULL,
  `maritalStatus` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `residence` varchar(255) DEFAULT NULL,
  `district` varchar(255) DEFAULT NULL,
  `county` varchar(255) DEFAULT NULL,
  `subcounty` varchar(255) DEFAULT NULL,
  `parish` varchar(255) DEFAULT NULL,
  `village` varchar(255) DEFAULT NULL,
  `nextOfKin` varchar(255) DEFAULT NULL,
  `relationship` varchar(255) DEFAULT NULL,
  `nextOfKinAddress` varchar(255) DEFAULT NULL,
  `mobileNo` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `reference` varchar(255) DEFAULT NULL,
  `process_status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `system_user` bigint(20) UNSIGNED DEFAULT NULL,
  `balance` bigint(20) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sonda_mpolas`
--

INSERT INTO `sonda_mpolas` (`id`, `name`, `identificationType`, `nin_or_passport`, `dateOfExpiry`, `phone`, `otherPhone`, `email`, `savingFor`, `umrahSavingTarget`, `hajjSavingTarget`, `targetAmount`, `gender`, `occupation`, `position`, `dob`, `placeOfBirth`, `fatherName`, `motherName`, `maritalStatus`, `country`, `nationality`, `residence`, `district`, `county`, `subcounty`, `parish`, `village`, `nextOfKin`, `relationship`, `nextOfKinAddress`, `mobileNo`, `image`, `reference`, `process_status`, `created_at`, `updated_at`, `created_by`, `system_user`, `balance`) VALUES
(85, 'BUYINZA MUZAMIRU', 'NIN', 'CM86049102HD7J', '28/06/2025', '+256703311852', NULL, 'buyinzamuzamiru741@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '14/04/1986', 'Mayuge district', 'Hajji Byansi Bruhan', 'Nakisige Nuubu', 'married', 'Uganda', 'Ugandan', 'Buluza', 'Iganga', 'Kigulu', 'Nakigo', 'Kabira', 'Buluza', 'Hajji Byansi Bruhan', 'Father', 'Mayuge district', '+2560758449427', '68452e22099fc.jpeg', 'SM/UO/1', 'pending', '2025-06-08 09:30:58', '2025-06-08 09:30:58', 90, 90, 0),
(86, 'BUYINZA MUZAMIRU', 'NIN', 'CM86049102HD7J', '28/06/2025', '+256703311852', NULL, 'buyinzamuzamiru741@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '14/04/1986', 'Mayuge district', 'Hajji Byansi Bruhan', 'Nakisige Nuubu', 'married', 'Uganda', 'Ugandan', 'Buluza', 'Iganga', 'Kigulu', 'Nakigo', 'Kabira', 'Buluza', 'Hajji Byansi Bruhan', 'Father', 'Mayuge district', '+2560758449427', '68452e235680a.jpeg', 'SM/UO/2', 'pending', '2025-06-08 09:30:59', '2025-06-08 09:30:59', 90, 90, 0),
(87, 'BUYINZA MUZAMIRU', 'NIN', 'CM86049102HD7J', '28/06/2025', '+256703311852', NULL, 'buyinzamuzamiru741@gmail.com', 'Hajj', 'otherMonths_8400000', 'Class_B_21500000', '21500000', 'MALE', NULL, NULL, '14/04/1986', 'Mayuge district', 'Hajji Byansi Bruhan', 'Nakisige Nuubu', 'married', 'Uganda', 'Ugandan', 'Buluza', 'Iganga', 'Kigulu', 'Nakigo', 'Kabira', 'Buluza', 'Hajji Byansi Bruhan', 'Father', 'Mayuge district', '+2560758449427', '68452e86edff3.jpeg', 'SM/HB/3', 'pending', '2025-06-08 09:32:38', '2025-06-08 09:32:38', 90, 90, 0),
(88, 'BUYINZA MUZAMIRU', 'NIN', 'CM86049102HD7J', '28/06/2025', '+256703311852', NULL, 'buyinzamuzamiru741@gmail.com', 'Hajj', 'otherMonths_8400000', 'Class_B_21500000', '21500000', 'MALE', NULL, NULL, '14/04/1986', 'Mayuge district', 'Hajji Byansi Bruhan', 'Nakisige Nuubu', 'married', 'Uganda', 'Ugandan', 'Buluza', 'Iganga', 'Kigulu', 'Nakigo', 'Kabira', 'Buluza', 'Hajji Byansi Bruhan', 'Father', 'Mayuge district', '+2560758449427', '68452e92ac36d.jpeg', 'SM/HB/4', 'pending', '2025-06-08 09:32:50', '2025-06-08 09:32:50', 90, 90, 0),
(89, 'BUYINZA MUZAMIRU', 'NIN', 'CM86049102HD7J', '28/06/2025', '+256703311852', NULL, 'buyinzamuzamiru741@gmail.com', 'Hajj', 'otherMonths_8400000', 'Class_B_21500000', '21500000', 'MALE', NULL, NULL, '14/04/1986', 'Mayuge district', 'Hajji Byansi Bruhan', 'Nakisige Nuubu', 'married', 'Uganda', 'Ugandan', 'Buluza', 'Iganga', 'Kigulu', 'Nakigo', 'Kabira', 'Buluza', 'Hajji Byansi Bruhan', 'Father', 'Mayuge district', '+2560758449427', '68452e9b67af0.jpeg', 'SM/HB/5', 'pending', '2025-06-08 09:32:59', '2025-06-08 09:32:59', 90, 90, 0),
(90, 'Kisitu Juma', 'NIN', 'CM9605210AMCCG', '28/01/2035', '+256700948041', NULL, 'jumakisitu1@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '19/07/1996', 'Nakaseke Hospital', 'Sekabira Hamidu', 'Meeme Margaret', 'Married', 'Uganda', 'Ugandan', 'Mutungo', 'Kampala', 'Uganda', 'Nakawa East', 'Mutungo', 'Zone 3', 'Ndugwa Marriam', 'Wife', 'Mutungo', '+256752668024', '68592b837dff9.jpeg', 'SM/UO/6', 'pending', '2025-06-23 13:25:07', '2025-06-23 13:25:07', 135, 135, 0),
(91, 'Kisitu Juma', 'NIN', 'CM9605210AMCCG', '28/01/2035', '+256700948041', NULL, 'jumakisitu1@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '19/07/1996', 'Nakaseke Hospital', 'Sekabira Hamidu', 'Meeme Margaret', 'Married', 'Uganda', 'Ugandan', 'Mutungo', 'Kampala', 'Uganda', 'Nakawa East', 'Mutungo', 'Zone 3', 'Ndugwa Marriam', 'Wife', 'Mutungo', '+256752668024', '68592b85997a1.jpeg', 'SM/UO/7', 'pending', '2025-06-23 13:25:09', '2025-06-23 13:25:09', 135, 135, 0),
(92, 'Kisitu Juma', 'NIN', 'CM9605210AMCCG', '28/01/2035', '+256700948041', NULL, 'jumakisitu1@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '19/07/1996', 'Nakaseke Hospital', 'Sekabira Hamidu', 'Meeme Margaret', 'Married', 'Uganda', 'Ugandan', 'Mutungo', 'Kampala', 'Uganda', 'Nakawa East', 'Mutungo', 'Zone 3', 'Ndugwa Marriam', 'Wife', 'Mutungo', '+256752668024', '68592b86257ec.jpeg', 'SM/UO/8', 'pending', '2025-06-23 13:25:10', '2025-06-23 13:25:10', 135, 135, 0),
(93, 'MUSIITWA ASADUUSAMA', 'Passport', 'B00507778', '27/11/2030', '+256752856608', NULL, 'usamaasadu12@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '22/11/1997', 'Mulago', 'Kate Patrick', 'Nabbosa Hafuswa', 'single', 'uganda', 'ugandan', 'kawempe', 'kampala', 'kawempe division', 'kawempe division', 'kawempe 1', 'kakungulu', 'Nabbosa Hafuswa', 'mother', 'kawempe tula', '+2567070882907', '6874ee46a7a2c.jpeg', 'SM/UO/9', 'pending', '2025-07-14 14:47:18', '2025-07-14 14:47:18', 51, 51, 0),
(94, 'MUSIITWA ASADUUSAMA', 'Passport', 'B00507778', '27/11/2030', '+256752856608', NULL, 'usamaasadu12@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '22/11/1997', 'Mulago', 'Kate Patrick', 'Nabbosa Hafuswa', 'single', 'uganda', 'ugandan', 'kawempe', 'kampala', 'kawempe division', 'kawempe division', 'kawempe 1', 'kakungulu', 'Nabbosa Hafuswa', 'mother', 'kawempe tula', '+2567070882907', '6874ee9ec73dd.jpeg', 'SM/UO/10', 'pending', '2025-07-14 14:48:46', '2025-07-14 14:48:46', 51, 51, 0),
(95, 'MUSIITWA ASADUUSAMA', 'Passport', 'B00507778', '27/11/2030', '+256752856608', NULL, 'usamaasadu12@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '22/11/1997', 'Mulago', 'Kate Patrick', 'Nabbosa Hafuswa', 'single', 'uganda', 'ugandan', 'kawempe', 'kampala', 'kawempe division', 'kawempe division', 'kawempe 1', 'kakungulu', 'Nabbosa Hafuswa', 'mother', 'kawempe tula', '+2567070882907', '6874ee9fe19d8.jpeg', 'SM/UO/11', 'pending', '2025-07-14 14:48:47', '2025-07-14 14:48:47', 51, 51, 0),
(96, 'MUSIITWA ASADUUSAMA', 'Passport', 'B00507778', '27/11/2030', '+256752856608', NULL, 'usamaasadu12@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '22/11/1997', 'Mulago', 'Kate Patrick', 'Nabbosa Hafuswa', 'single', 'uganda', 'ugandan', 'kawempe', 'kampala', 'kawempe division', 'kawempe division', 'kawempe 1', 'kakungulu', 'Nabbosa Hafuswa', 'mother', 'kawempe tula', '+2567070882907', '6874eeb44e119.jpeg', 'SM/UO/12', 'pending', '2025-07-14 14:49:08', '2025-07-14 14:49:08', 51, 51, 0),
(97, 'MUSIITWA ASADUUSAMA', 'Passport', 'B00507778', '27/11/2030', '+256752856608', NULL, 'usamaasadu12@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '22/11/1997', 'Mulago', 'Kate Patrick', 'Nabbosa Hafuswa', 'single', 'uganda', 'ugandan', 'kawempe', 'kampala', 'kawempe division', 'kawempe division', 'kawempe 1', 'kakungulu', 'Nabbosa Hafuswa', 'mother', 'kawempe tula', '+2567070882907', '6874eec111cd5.jpeg', 'SM/UO/13', 'pending', '2025-07-14 14:49:21', '2025-07-14 14:49:21', 51, 51, 0),
(98, 'MUSIITWA ASADUUSAMA', 'Passport', 'B00507778', '27/11/2030', '+256752856608', NULL, 'usamaasadu12@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '22/11/1997', 'Mulago', 'Kate Patrick', 'Nabbosa Hafuswa', 'single', 'uganda', 'ugandan', 'kawempe', 'kampala', 'kawempe division', 'kawempe division', 'kawempe 1', 'kakungulu', 'Nabbosa Hafuswa', 'mother', 'kawempe tula', '+2567070882907', '6874eedc4a4d5.jpeg', 'SM/UO/14', 'pending', '2025-07-14 14:49:48', '2025-07-14 14:49:48', 51, 51, 0),
(99, 'MUSIITWA ASADUUSAMA', 'Passport', 'B00507778', '27/11/2030', '+256752856608', NULL, 'usamaasadu12@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '22/11/1997', 'Mulago', 'Kate Patrick', 'Nabbosa Hafuswa', 'single', 'uganda', 'ugandan', 'kawempe', 'kampala', 'kawempe division', 'kawempe division', 'kawempe 1', 'kakungulu', 'Nabbosa Hafuswa', 'mother', 'kawempe tula', '+2567070882907', '6874eee8dc79f.jpeg', 'SM/UO/15', 'pending', '2025-07-14 14:50:00', '2025-07-14 14:50:00', 51, 51, 0),
(100, 'MUSIITWA ASADUUSAMA', 'Passport', 'B00507778', '27/11/2030', '+256752856608', NULL, 'usamaasadu12@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '22/11/1997', 'Mulago', 'Kate Patrick', 'Nabbosa Hafuswa', 'single', 'uganda', 'ugandan', 'kawempe', 'kampala', 'kawempe division', 'kawempe division', 'kawempe 1', 'kakungulu', 'Nabbosa Hafuswa', 'mother', 'kawempe tula', '+2567070882907', '6874eef62da35.jpeg', 'SM/UO/16', 'pending', '2025-07-14 14:50:14', '2025-07-14 14:50:14', 51, 51, 0),
(101, 'MUSIITWA ASADUUSAMA', 'Passport', 'B00507778', '27/11/2030', '+256752856608', NULL, 'usamaasadu12@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '22/11/1997', 'MULAGO', 'KATE PATRICK', 'NABBOSA HAFUSWA', 'SINGLE', 'UGANDA', 'UGANDAN', 'KAMPALA', 'KAMPALA', 'KAWEMPE DIVISION', 'KAWEMPE DIVISION', 'KAWEMPE 1', 'KAKUNGULU', 'NABBOSA HAFUSWA', 'MOTHER', 'KAWEMPE TULA', '+2567070882907', '6874efd0b83a4.jpeg', 'SM/UO/17', 'pending', '2025-07-14 14:53:52', '2025-07-14 14:53:52', 51, 51, 0),
(102, 'MUSIITWA ASADUUSAMA', 'Passport', 'B00507778', '27/11/2030', '+256752856608', NULL, 'usamaasadu12@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '22/11/1997', 'MULAGO', 'KATE PATRICK', 'NABBOSA HAFUSWA', 'SINGLE', 'UGANDA', 'UGANDAN', 'KAMPALA', 'KAMPALA', 'KAWEMPE DIVISION', 'KAWEMPE DIVISION', 'KAWEMPE 1', 'KAKUNGULU', 'NABBOSA HAFUSWA', 'MOTHER', 'KAWEMPE TULA', '+2567070882907', '6874efe2ace80.jpeg', 'SM/UO/18', 'pending', '2025-07-14 14:54:10', '2025-07-14 14:54:10', 51, 51, 0),
(103, 'MUSIITWA ASADUUSAMA', 'Passport', 'B00507778', '27/11/2030', '+256752856608', NULL, 'usamaasadu12@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '22/11/1997', 'MULAGO', 'KATE PATRICK', 'NABBOSA HAFUSWA', 'SINGLE', 'UGANDA', 'UGANDAN', 'KAMPALA', 'KAMPALA', 'KAWEMPE DIVISION', 'KAWEMPE DIVISION', 'KAWEMPE 1', 'KAKUNGULU', 'NABBOSA HAFUSWA', 'MOTHER', 'KAWEMPE TULA', '+2567070882907', '6874f00c41674.jpeg', 'SM/UO/19', 'pending', '2025-07-14 14:54:52', '2025-07-14 14:54:52', 51, 51, 0),
(104, 'MUSIITWA ASADUUSAMA', 'Passport', 'B00507778', '27/11/2030', '+256752856608', NULL, 'usamaasadu12@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '22/11/1997', 'MULAGO', 'SIRAJE KATE', 'NABBOSA HAFUSWA', 'SINGLE', 'UGANDA', 'UGANDAN', 'KAMPALA', 'KAMPALA', 'KAWEMPE DIVISION', 'KAWEMPE DIVISION', 'KAWEMPE 1', 'KAKUNGULU', 'NABBOSA HAFUSWA', 'MOTHER', 'KAWEMPE TULA', '+2567070882907', '6874f02d23b96.jpeg', 'SM/UO/20', 'pending', '2025-07-14 14:55:25', '2025-07-14 14:55:25', 51, 51, 0),
(105, 'MUSIITWA ASADUUSAMA', 'Passport', 'B00507778', '27/11/2030', '+256752856608', NULL, 'usamaasadu12@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '22/11/1997', 'MULAGO', 'SIRAJE KATE', 'NABBOSA HAFUSWA', 'SINGLE', 'UGANDA', 'UGANDAN', 'KAMPALA', 'KAMPALA', 'KAWEMPE DIVISION', 'KAWEMPE DIVISION', 'KAWEMPE 1', 'KAKUNGULU', 'NABBOSA HAFUSWA', 'MOTHER', 'KAWEMPE TULA', '+2567070882907', '6874f02eaf24b.jpeg', 'SM/UO/21', 'pending', '2025-07-14 14:55:26', '2025-07-14 14:55:26', 51, 51, 0),
(106, 'MUSIITWA ASADUUSAMA', 'Passport', 'B00507778', '27/11/2030', '+256752856608', NULL, 'usamaasadu12@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '22/11/1997', 'MULAGO', 'SIRAJE KATE', 'NABBOSA HAFUSWA', 'SINGLE', 'UGANDA', 'UGANDAN', 'KAMPALA', 'KAMPALA', 'KAWEMPE DIVISION', 'KAWEMPE DIVISION', 'KAWEMPE 1', 'KAKUNGULU', 'NABBOSA HAFUSWA', 'MOTHER', 'KAWEMPE TULA', '+2567070882907', '6874f03e487fd.jpeg', 'SM/UO/22', 'pending', '2025-07-14 14:55:42', '2025-07-14 14:55:42', 51, 51, 0),
(107, 'MUSIITWA ASADUUSAMA', 'Passport', 'B00507778', '27/11/2030', '+256752856608', NULL, 'usamaasadu12@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '22/11/1997', 'MULAGO', 'SIRAJE KATE', 'NABBOSA HAFUSWA', 'SINGLE', 'UGANDA', 'UGANDAN', 'KAMPALA', 'KAMPALA', 'KAWEMPE DIVISION', 'KAWEMPE DIVISION', 'KAWEMPE 1', 'KAKUNGULU', 'NABBOSA HAFUSWA', 'MOTHER', 'KAWEMPE TULA', '+2567070882907', '6874f04f69ec4.jpeg', 'SM/UO/23', 'pending', '2025-07-14 14:55:59', '2025-07-14 14:55:59', 51, 51, 0),
(108, 'MUSIITWA ASADUUSAMA', 'Passport', 'B00507778', '27/11/2030', '+256752856608', NULL, 'usamaasadu12@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '22/11/1997', 'MULAGO', 'SIRAJE KATE', 'NABBOSA HAFUSWA', 'SINGLE', 'UGANDA', 'UGANDAN', 'KAMPALA', 'KAMPALA', 'KAWEMPE DIVISION', 'KAWEMPE DIVISION', 'KAWEMPE 1', 'KAKUNGULU', 'NABBOSA HAFUSWA', 'MOTHER', 'KAWEMPE TULA', '+2567070882907', '6874f059629cd.jpeg', 'SM/UO/24', 'pending', '2025-07-14 14:56:09', '2025-07-14 14:56:09', 51, 51, 0),
(109, 'MUSIITWA ASADUUSAMA', 'Passport', 'B00507778', '27/11/2030', '+256752856608', NULL, 'usamaasadu12@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '22/11/1997', 'MULAGO', 'SIRAJE KATE', 'NABBOSA HAFUSWA', 'SINGLE', 'UGANDA', 'UGANDAN', 'KAMPALA', 'KAMPALA', 'KAWEMPE DIVISION', 'KAWEMPE DIVISION', 'KAWEMPE 1', 'KAKUNGULU', 'NABBOSA HAFUSWA', 'MOTHER', 'KAWEMPE TULA', '+2567070882907', '6874f05962e7e.jpeg', 'SM/UO/25', 'pending', '2025-07-14 14:56:09', '2025-07-14 14:56:09', 51, 51, 0),
(110, 'MUSIITWA ASADUUSAMA', 'Passport', 'B00507778', '27/11/2030', '+256752856608', NULL, 'usamaasadu12@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '22/11/1997', 'MULAGO', 'SIRAJE KATE', 'NABBOSA HAFUSWA', 'SINGLE', 'UGANDA', 'UGANDAN', 'KAMPALA', 'KAMPALA', 'KAWEMPE DIVISION', 'KAWEMPE DIVISION', 'KAWEMPE 1', 'KAKUNGULU', 'NABBOSA HAFUSWA', 'MOTHER', 'KAWEMPE TULA', '+2567070882907', '6874f05964bf6.jpeg', 'SM/UO/26', 'pending', '2025-07-14 14:56:09', '2025-07-14 14:56:09', 51, 51, 0),
(111, 'MUSIITWA ASADUUSAMA', 'Passport', 'B00507778', '27/11/2030', '+256752856608', NULL, 'usamaasadu12@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '22/11/1997', 'MULAGO', 'SIRAJE KATE', 'NABBOSA HAFUSWA', 'SINGLE', 'UGANDA', 'UGANDAN', 'KAMPALA', 'KAMPALA', 'KAWEMPE DIVISION', 'KAWEMPE DIVISION', 'KAWEMPE 1', 'KAKUNGULU', 'NABBOSA HAFUSWA', 'MOTHER', 'KAWEMPE TULA', '+2567070882907', '6874f0596389e.jpeg', 'SM/UO/27', 'pending', '2025-07-14 14:56:09', '2025-07-14 14:56:09', 51, 51, 0),
(112, 'MUSIITWA ASADUUSAMA', 'Passport', 'B00507778', '27/11/2030', '+256752856608', NULL, 'usamaasadu12@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '22/11/1997', 'MULAGO', 'SIRAJE KATE', 'NABBOSA HAFUSWA', 'SINGLE', 'UGANDA', 'UGANDAN', 'KAMPALA', 'KAMPALA', 'KAWEMPE DIVISION', 'KAWEMPE DIVISION', 'KAWEMPE 1', 'KAKUNGULU', 'NABBOSA HAFUSWA', 'MOTHER', 'KAWEMPE TULA', '+2567070882907', '6874f05a01ca7.jpeg', 'SM/UO/28', 'pending', '2025-07-14 14:56:10', '2025-07-14 14:56:10', 51, 51, 0),
(113, 'MUSIITWA ASADUUSAMA', 'Passport', 'B00507778', '27/11/2030', '+256752856608', NULL, 'usamaasadu12@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '22/11/1997', 'MULAGO', 'SIRAJE KATE', 'NABBOSA HAFUSWA', 'SINGLE', 'UGANDA', 'UGANDAN', 'KAMPALA', 'KAMPALA', 'KAWEMPE DIVISION', 'KAWEMPE DIVISION', 'KAWEMPE 1', 'KAKUNGULU', 'NABBOSA HAFUSWA', 'MOTHER', 'KAWEMPE TULA', '+2567070882907', '6874f05dabd90.jpeg', 'SM/UO/29', 'pending', '2025-07-14 14:56:13', '2025-07-14 14:56:13', 51, 51, 0),
(114, 'MUSIITWA ASADUUSAMA', 'Passport', 'B00507778', '27/11/2030', '+256752856608', NULL, 'usamaasadu12@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '22/11/1997', 'MULAGO', 'SIRAJE KATE', 'NABBOSA HAFUSWA', 'SINGLE', 'UGANDA', 'UGANDAN', 'KAMPALA', 'KAMPALA', 'KAWEMPE DIVISION', 'KAWEMPE DIVISION', 'KAWEMPE 1', 'KAKUNGULU', 'NABBOSA HAFUSWA', 'MOTHER', 'KAWEMPE TULA', '+2567070882907', '6874f05ef3a81.jpeg', 'SM/UO/30', 'pending', '2025-07-14 14:56:15', '2025-07-14 14:56:15', 51, 51, 0),
(115, 'Bewayo Ibrahim', 'Passport', 'A00033435', '03/03/2029', '+256702817005', NULL, 'ibrahimbewayo@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '01/01/1990', 'Jinja', 'Musisi Abdul Hakim', 'Basilika Aminah', 'Single', 'Uganda', 'Ugandan', 'Kitete', 'Mukono', 'Uganda', 'Mukono municipality', 'kitete', 'Kitete', 'Basilika Aminah', 'mother', 'Kikondo Nyenga Buikwe district', '+256770805125', '68870a8615c1b.jpeg', 'SM/UO/31', 'pending', '2025-07-28 08:28:38', '2025-07-28 08:28:38', 114, 114, 0),
(116, 'Bewayo Ibrahim', 'Passport', 'A00033435', '03/03/2029', '+256702817005', NULL, 'ibrahimbewayo@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '01/01/1990', 'Jinja', 'Musisi Abdul Hakim', 'Basilika Aminah', 'Single', 'Uganda', 'Ugandan', 'Kitete', 'Mukono', 'Uganda', 'Mukono municipality', 'kitete', 'Kitete', 'Basilika Aminah', 'mother', 'Kikondo Nyenga Buikwe district', '+256770805125', '68870a96295ff.jpeg', 'SM/UO/32', 'pending', '2025-07-28 08:28:54', '2025-07-28 08:28:54', 114, 114, 0),
(117, 'Bewayo Ibrahim', 'Passport', 'A00033435', '03/03/2029', '+256702817005', NULL, 'ibrahimbewayo@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '01/01/1990', 'Jinja', 'Musisi Abdul Hakim', 'Basilika Aminah', 'Single', 'Uganda', 'Ugandan', 'Kitete', 'Mukono', 'Uganda', 'Mukono municipality', 'kitete', 'Kitete', 'Basilika Aminah', 'mother', 'Kikondo Nyenga Buikwe district', '+256770805125', '68870ab374b6b.jpeg', 'SM/UO/33', 'pending', '2025-07-28 08:29:23', '2025-07-28 08:29:23', 114, 114, 0),
(118, 'Bewayo Ibrahim', 'Passport', 'A00033435', '03/03/2029', '+256702817005', NULL, 'ibrahimbewayo@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '01/01/1990', 'Jinja', 'Musisi Abdul Hakim', 'Basilika Aminah', 'Single', 'Uganda', 'Ugandan', 'Kitete', 'Mukono', 'Uganda', 'Mukono municipality', 'kitete', 'Kitete', 'Basilika Aminah', 'mother', 'Kikondo Nyenga Buikwe district', '+256770805125', '68870ac437cf4.jpeg', 'SM/UO/34', 'pending', '2025-07-28 08:29:40', '2025-07-28 08:29:40', 114, 114, 0),
(119, 'Bewayo Ibrahim', 'Passport', 'A00033435', '03/03/2029', '+256702817005', NULL, 'ibrahimbewayo@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '01/01/1990', 'Jinja', 'Musisi Abdul Hakim', 'Basilika Aminah', 'Single', 'Uganda', 'Ugandan', 'Kitete', 'Mukono', 'Uganda', 'Mukono municipality', 'kitete', 'Kitete', 'Basilika Aminah', 'mother', 'Kikondo Nyenga Buikwe district', '+256770805125', '68870ae98947a.jpeg', 'SM/UO/35', 'pending', '2025-07-28 08:30:17', '2025-07-28 08:30:17', 114, 114, 0),
(120, 'kasozi abdulmajid', 'NIN', 'CM0005210TRYDC', '30/10/2029', '+256742051295', NULL, 'kasozihussein16@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '11/07/2000', 'kawempe', 'kasozi hussein', 'Sarah mwebe kasozi', 'single', 'uganda', 'ugandan', 'najjanankumbi', 'Kampala', 'kabowa', 'stella', 'kabowa 1', 'najjanankumbi', 'nalumansi hamidah', 'friend', 'masajja', '+256706734593', '6888da8d1d03e.jpeg', 'SM/UO/36', 'pending', '2025-07-29 17:28:29', '2025-07-29 17:28:29', 53, 53, 0),
(121, 'kasozi abdulmajid', 'NIN', 'CM0005210TRYDC', '30/10/2029', '+256742051295', NULL, 'kasozihussein16@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '11/07/2000', 'kawempe', 'kasozi hussein', 'Sarah mwebe kasozi', 'single', 'uganda', 'ugandan', 'najjanankumbi', 'Kampala', 'kabowa', 'stella', 'kabowa 1', 'najjanankumbi', 'nalumansi hamidah', 'friend', 'masajja', '+256706734593', '6888da8d1cda8.jpeg', 'SM/UO/36', 'pending', '2025-07-29 17:28:29', '2025-07-29 17:28:29', 53, 53, 0),
(122, 'kasozi abdulmajid', 'NIN', 'CM0005210TRYDC', '30/10/2029', '+256742051295', NULL, 'kasozihussein16@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '11/07/2000', 'kawempe', 'kasozi hussein', 'Sarah mwebe kasozi', 'single', 'uganda', 'ugandan', 'najjanankumbi', 'Kampala', 'kabowa', 'stella', 'kabowa 1', 'najjanankumbi', 'nalumansi hamidah', 'friend', 'masajja', '+256706734593', '6888dadd7bdd9.jpeg', 'SM/UO/38', 'pending', '2025-07-29 17:29:49', '2025-07-29 17:29:49', 53, 53, 0),
(123, 'kasozi abdulmajid', 'NIN', 'CM0005210TRYDC', '30/10/2029', '+256742051295', NULL, 'kasozihussein16@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '11/07/2000', 'kawempe', 'kasozi hussein', 'Sarah mwebe kasozi', 'single', 'uganda', 'ugandan', 'najjanankumbi', 'Kampala', 'kabowa', 'stella', 'kabowa 1', 'najjanankumbi', 'nalumansi hamidah', 'friend', 'masajja', '+256706734593', '6888daf0f4147.jpeg', 'SM/UO/39', 'pending', '2025-07-29 17:30:09', '2025-07-29 17:30:09', 53, 53, 0),
(124, 'kasozi abdulmajid', 'NIN', 'CM0005210TRYDC', '30/10/2029', '+256742051295', NULL, 'kasozihussein16@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '11/07/2000', 'kawempe', 'kasozi hussein', 'Sarah mwebe kasozi', 'single', 'uganda', 'ugandan', 'najjanankumbi', 'Kampala', 'kabowa', 'stella', 'kabowa 1', 'najjanankumbi', 'nalumansi hamidah', 'friend', 'masajja', '+256706734593', '6888daf5c77d2.jpeg', 'SM/UO/40', 'pending', '2025-07-29 17:30:13', '2025-07-29 17:30:13', 53, 53, 0),
(125, 'kasozi abdulmajid', 'NIN', 'CM0005210TRYDC', '30/10/2029', '+256742051295', NULL, 'kasozihussein16@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '11/07/2000', 'kawempe', 'kasozi hussein', 'Sarah mwebe kasozi', 'single', 'uganda', 'ugandan', 'najjanankumbi', 'Kampala', 'kabowa', 'stella', 'kabowa 1', 'najjanankumbi', 'nalumansi hamidah', 'friend', 'masajja', '+256706734593', '6888daf5cc311.jpeg', 'SM/UO/41', 'pending', '2025-07-29 17:30:13', '2025-07-29 17:30:13', 53, 53, 0),
(126, 'kasozi abdulmajid', 'NIN', 'CM0005210TRYDC', '30/10/2029', '+256742051295', NULL, 'kasozihussein16@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '11/07/2000', 'kawempe', 'kasozi hussein', 'Sarah mwebe kasozi', 'single', 'uganda', 'ugandan', 'najjanankumbi', 'Kampala', 'kabowa', 'stella', 'kabowa 1', 'najjanankumbi', 'nalumansi hamidah', 'friend', 'masajja', '+256706734593', '6888daf5d4a20.jpeg', 'SM/UO/42', 'pending', '2025-07-29 17:30:13', '2025-07-29 17:30:13', 53, 53, 0),
(127, 'kasozi abdulmajid', 'NIN', 'CM0005210TRYDC', '30/10/2029', '+256742051295', NULL, 'kasozihussein16@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '11/07/2000', 'kawempe', 'kasozi hussein', 'Sarah mwebe kasozi', 'single', 'uganda', 'ugandan', 'najjanankumbi', 'Kampala', 'kabowa', 'stella', 'kabowa 1', 'najjanankumbi', 'nalumansi hamidah', 'friend', 'masajja', '+256706734593', '6888daf638f10.jpeg', 'SM/UO/43', 'pending', '2025-07-29 17:30:14', '2025-07-29 17:30:14', 53, 53, 0),
(128, 'kasozi abdulmajid', 'NIN', 'CM0005210TRYDC', '30/10/2029', '+256742051295', NULL, 'kasozihussein16@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '11/07/2000', 'kawempe', 'kasozi hussein', 'Sarah mwebe kasozi', 'single', 'uganda', 'ugandan', 'najjanankumbi', 'Kampala', 'kabowa', 'stella', 'kabowa 1', 'najjanankumbi', 'nalumansi hamidah', 'friend', 'masajja', '+256706734593', '6888daf6ad35f.jpeg', 'SM/UO/44', 'pending', '2025-07-29 17:30:14', '2025-07-29 17:30:14', 53, 53, 0),
(129, 'kasozi abdulmajid', 'NIN', 'CM0005210TRYDC', '30/10/2029', '+256742051295', NULL, 'kasozihussein16@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '11/07/2000', 'kawempe', 'kasozi hussein', 'Sarah mwebe kasozi', 'single', 'uganda', 'ugandan', 'najjanankumbi', 'Kampala', 'kabowa', 'stella', 'kabowa 1', 'najjanankumbi', 'nalumansi hamidah', 'friend', 'masajja', '+256706734593', '6888daf6c320b.jpeg', 'SM/UO/45', 'pending', '2025-07-29 17:30:14', '2025-07-29 17:30:14', 53, 53, 0),
(130, 'kasozi abdulmajid', 'NIN', 'CM0005210TRYDC', '30/10/2029', '+256742051295', NULL, 'kasozihussein16@gmail.com', 'Umrah', 'otherMonths_8400000', NULL, '8400000', 'MALE', NULL, NULL, '11/07/2000', 'kawempe', 'kasozi hussein', 'Sarah mwebe kasozi', 'single', 'uganda', 'ugandan', 'najjanankumbi', 'Kampala', 'kabowa', 'stella', 'kabowa 1', 'najjanankumbi', 'nalumansi hamidah', 'friend', 'masajja', '+256706734593', '6888daf6cc96d.jpeg', 'SM/UO/46', 'pending', '2025-07-29 17:30:14', '2025-07-29 17:30:14', 53, 53, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sonda_mpola_payments`
--

CREATE TABLE `sonda_mpola_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sondaMpolaId` bigint(20) UNSIGNED DEFAULT NULL,
  `amount` varchar(255) DEFAULT NULL,
  `payment_option` varchar(255) DEFAULT NULL,
  `payment_status` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `rate` varchar(255) DEFAULT NULL,
  `actual_amount` varchar(255) DEFAULT NULL,
  `balance` varchar(255) DEFAULT NULL,
  `target_amount_status` varchar(255) DEFAULT NULL,
  `receipted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `issuedBy` bigint(20) UNSIGNED DEFAULT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Triggers `sonda_mpola_payments`
--
DELIMITER $$
CREATE TRIGGER `balance_update` AFTER INSERT ON `sonda_mpola_payments` FOR EACH ROW BEGIN
    DECLARE bal DECIMAL(10,2);
    DECLARE tag DECIMAL(10,2);
    
    SELECT balance, targetAmount INTO bal, tag 
    FROM sonda_mpolas 
    WHERE id = NEW.sondaMpolaId;
    
    IF bal < tag THEN
        UPDATE sonda_mpolas 
        SET balance = balance + NEW.amount 
        WHERE id = NEW.sondaMpolaId;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `reference` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `currency` varchar(3) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `payment_status` varchar(255) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `callback_data` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `transaction_id`, `reference`, `phone`, `amount`, `currency`, `description`, `type`, `status`, `payment_status`, `message`, `callback_data`, `created_at`, `updated_at`) VALUES
(57, 'txn681b213183368', 'test 1', '0706218827', 1500.00, 'UGX', 'Success.', 'collection', 'completed', 'Settled', 'Success.', '{\"transaction\":{\"status_code\":\"TS\",\"code\":\"DP00800001001\",\"airtel_money_id\":\"18432759761\",\"id\":\"txn681b213183368\",\"message\":\"PAID UGX 1500 to TEST WALLET Charge UGX 120, TID 18432759761. Bal UGX 187725 Date: 07-May-2025 12:00. https:\\/\\/bit.ly\\/3ZgpiNw\"},\"hash\":\"1jcqe1GR3nASBX1zL8M8cpZuoboARU8j+F4jEFpj6rI=\"}', '2025-05-07 09:00:34', '2025-05-07 09:00:45'),
(59, 'txn681b220b4174e', 'test 1', '0706218827', 1500.00, 'UGX', 'Success.', 'collection', 'completed', 'Settled', 'Success.', '{\"transaction\":{\"status_code\":\"TS\",\"code\":\"DP00800001001\",\"airtel_money_id\":\"18432759794\",\"id\":\"txn681b220b4174e\",\"message\":\"PAID UGX 1500 to TEST WALLET Charge UGX 23, TID 18432759794. Bal UGX 186203 Date: 07-May-2025 12:04. https:\\/\\/bit.ly\\/3ZgpiNw\"},\"hash\":\"d88jil5\\/pMg\\/9+UvyLImKdvzyXmGRKqyWF5i44IBjFM=\"}', '2025-05-07 09:04:12', '2025-05-07 09:04:18'),
(61, 'txn681b22ca0faed', 'test 1', '0706218827', 2000.00, 'UGX', 'Success.', 'collection', 'completed', 'Settled', 'Success.', '{\"transaction\":{\"status_code\":\"TF\",\"code\":\"DP00800001000\",\"airtel_money_id\":\"18432759820\",\"id\":\"txn681b22ca0faed\",\"message\":\"Transaction Failed with TXN Id : 18432759820, Dear customer,payer is barred as sender. Please call 185 for help.Thank you.\"},\"hash\":\"3E5Z2p2nVgcpX0nleGcyvUOvvqa7al5nPm5YEllty\\/A=\"}', '2025-05-07 09:07:22', '2025-05-07 09:07:30'),
(63, 'txn681b238a58c33', 'test 1', '0706218827', 2500.00, 'UGX', 'Success.', 'collection', 'completed', 'Settled', 'Success.', '{\"transaction\":{\"status_code\":\"TS\",\"code\":\"DP00800001001\",\"airtel_money_id\":\"18432759845\",\"id\":\"txn681b238a58c33\",\"message\":\"PAID UGX 2500 to TEST WALLET Charge UGX 38, TID 18432759845. Bal UGX 183665 Date: 07-May-2025 12:10. https:\\/\\/bit.ly\\/3ZgpiNw\"},\"hash\":\"eoed1IkEKD81XvQ2hVherxFyyPv4WQR9QkaBmkX0WdM=\"}', '2025-05-07 09:10:35', '2025-05-07 09:10:45'),
(65, 'txn681b2406e9249', 'test 1', '0706218827', 2000.00, 'UGX', 'Success.', 'collection', 'completed', 'Settled', 'Success.', '{\"transaction\":{\"status_code\":\"TF\",\"code\":\"DP00800001002\",\"airtel_money_id\":\"18432759855\",\"id\":\"txn681b2406e9249\",\"message\":\"The PIN you have entered is incorrect. Please enter correct PIN. 3 unsuccessful attempts will lock your account\"},\"hash\":\"+9UPcN9IS32YA3Dd11AvBcvDvk9nwARgRa5GqLKbrro=\"}', '2025-05-07 09:12:40', '2025-05-07 09:12:47'),
(67, 'txn681b2460246be', 'test 1', '0706218827', 5000000.00, 'UGX', 'Success.', 'collection', 'completed', 'Settled', 'Success.', '{\"transaction\":{\"status_code\":\"TF\",\"code\":\"DP00800001007\",\"airtel_money_id\":\"18432759861\",\"id\":\"txn681b2460246be\",\"message\":\"Transaction Failed with TXN Id : 18432759861, You have insufficient money on your a\\/c. Dial 185710# to confirm Quick Loan eligibility to complete transaction.\"},\"hash\":\"8FDpsosgqo6gpLHF3oT\\/+FWp\\/6kN5qwEeKMIcmn7n44=\"}', '2025-05-07 09:14:09', '2025-05-07 09:14:22'),
(69, 'txn681b262ec976d', 'test 1', '0706218827', 500.00, 'UGX', 'Success.', 'collection', 'completed', 'Settled', 'Success.', '{\"transaction\":{\"status_code\":\"TF\",\"code\":\"DP00800001002\",\"airtel_money_id\":\"18432759934\",\"id\":\"txn681b262ec976d\",\"message\":\"The PIN you have entered is incorrect. This is your last attempt, on entering a wrong PIN again account will be locked.\"},\"hash\":\"nZ0SORGynHyHpboXMIgM6VZ7zyI925LtBuN4Iqu8hnA=\"}', '2025-05-07 09:21:51', '2025-05-07 09:22:09'),
(70, 'txn681b263d2ccd2', 'test 1', '0706218827', 200.00, 'UGX', 'Success.', 'collection', 'completed', 'Settled', 'Success.', '{\"transaction\":{\"status_code\":\"TS\",\"code\":\"DP00800001001\",\"airtel_money_id\":\"18432759966\",\"id\":\"txn681b263d2ccd2\",\"message\":\"PAID UGX 200 to TEST WALLET Charge UGX 3, TID 18432759966. Bal UGX 194260 Date: 07-May-2025 12:24. https:\\/\\/bit.ly\\/3ZgpiNw\"},\"hash\":\"UX8xi7PU5fMYnYJAWMZBXoalyqvjy0R2HA16l3JknW0=\"}', '2025-05-07 09:22:06', '2025-05-07 09:24:12'),
(72, 'txn681b269bcf89f', 'test 1', '0706218827', 200.00, 'UGX', 'Success.', 'collection', 'completed', 'Settled', 'Success.', '{\"transaction\":{\"status_code\":\"TS\",\"code\":\"DP00800001001\",\"airtel_money_id\":\"18432759965\",\"id\":\"txn681b269bcf89f\",\"message\":\"PAID UGX 200 to TEST WALLET Charge UGX 3, TID 18432759965. Bal UGX 194463 Date: 07-May-2025 12:23. https:\\/\\/bit.ly\\/3ZgpiNw\"},\"hash\":\"gJLWzNEP0y22jNBr+H96aGmt38dqaD1osLB2FhS9F40=\"}', '2025-05-07 09:23:40', '2025-05-07 09:23:48'),
(75, 'txn681b301aaa24e', 'test 1', '0706218827', 500.68, 'UGX', 'Success.', 'collection', 'completed', 'Settled', 'Success.', '{\"transaction\":{\"status_code\":\"TF\",\"code\":\"DP00800001004\",\"airtel_money_id\":\"18432760178\",\"id\":\"txn681b301aaa24e\",\"message\":\"Transaction Failed with TXN Id : 18432760178, Dear customer, the transaction amount you entered is not allowed.Thank you.\"},\"hash\":\"PQ0NKugZvpOVkBA6QUlydz7AARyeyzppXdvA01wVSMA=\"}', '2025-05-07 10:04:11', '2025-05-07 10:04:19'),
(76, 'txn681b30ca6d285', 'test 1', '0756913885', 1000.00, 'UGX', 'Success.', 'collection', 'completed', 'Settled', 'Success.', '{\"transaction\":{\"status_code\":\"TF\",\"code\":\"DP00800001010\",\"airtel_money_id\":\"18432760184\",\"id\":\"txn681b30ca6d285\",\"message\":\"Initiator is invalid\"},\"hash\":\"IFNnUKSayL\\/HzC\\/2bHuEUFmrdMJDZZZBhhGBxRFsjAQ=\"}', '2025-05-07 10:07:07', '2025-05-07 10:07:22'),
(77, 'txn681b3139610d6', 'test 1', '0706218827', 5000001.00, 'UGX', 'Success.', 'collection', 'completed', 'Settled', 'Success.', '{\"transaction\":{\"status_code\":\"TF\",\"code\":\"DP00800001000\",\"airtel_money_id\":\"18432760191\",\"id\":\"txn681b3139610d6\",\"message\":\"Transaction Failed with TXN Id : 18432760191, Amount entered is not within the allowed range. Please enter the correct amount.\"},\"hash\":\"282Ww1DPalMrgolw1A5TKxiPOYGgrAA31yDMkiUbqBc=\"}', '2025-05-07 10:08:58', '2025-05-07 10:09:12'),
(79, 'txn68272b2971e87', 'test 1', '0756913885', 1000.00, 'UGX', 'Success.', 'collection', 'success', 'pending', 'Success.', NULL, '2025-05-16 12:10:21', '2025-05-16 12:10:21'),
(80, 'txn68272f7ad886c', 'test 1', '0756913885', 1000.00, 'UGX', 'Success.', 'collection', 'completed', 'Settled', 'Success.', '{\"transaction\":{\"status_code\":\"TS\",\"code\":\"DP00800001001\",\"airtel_money_id\":\"123345272769\",\"id\":\"txn68272f7ad886c\",\"message\":\"PAID.TID 123345272769. UGX 1,000 to MAQAM TRAVELS SMC LTD Charge UGX 0. Bal UGX 69,436. 16-May-2025 15:28\"}}', '2025-05-16 12:28:46', '2025-05-16 12:28:58');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(119) DEFAULT NULL,
  `email` varchar(119) DEFAULT NULL,
  `phone` varchar(119) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(119) DEFAULT NULL,
  `role` bigint(20) UNSIGNED NOT NULL,
  `gender` varchar(119) DEFAULT NULL,
  `dob` varchar(119) DEFAULT NULL,
  `nationality` varchar(119) DEFAULT NULL,
  `residence` varchar(119) DEFAULT NULL,
  `NIN_or_Passport` varchar(119) DEFAULT NULL,
  `passportPhoto` varchar(119) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `password_changed_at` timestamp NULL DEFAULT current_timestamp(),
  `email_change_token` varchar(255) DEFAULT NULL,
  `notify_login` tinyint(1) DEFAULT 0,
  `notify_updates` tinyint(1) DEFAULT 0,
  `notify_news` tinyint(1) DEFAULT 0,
  `new_email` varchar(255) DEFAULT NULL,
  `web_notify_login` tinyint(1) DEFAULT 0,
  `web_notify_updates` tinyint(1) DEFAULT 0,
  `web_notify_messages` tinyint(1) DEFAULT 0,
  `web_notify_news` tinyint(1) DEFAULT 0,
  `push_notify_login` tinyint(1) DEFAULT 0,
  `push_notify_updates` tinyint(1) DEFAULT 0,
  `push_notify_messages` tinyint(1) DEFAULT 0,
  `push_notify_news` tinyint(1) DEFAULT 0,
  `two_factor_enabled` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `role`, `gender`, `dob`, `nationality`, `residence`, `NIN_or_Passport`, `passportPhoto`, `remember_token`, `created_at`, `updated_at`, `status`, `password_changed_at`, `email_change_token`, `notify_login`, `notify_updates`, `notify_news`, `new_email`, `web_notify_login`, `web_notify_updates`, `web_notify_messages`, `web_notify_news`, `push_notify_login`, `push_notify_updates`, `push_notify_messages`, `push_notify_news`, `two_factor_enabled`) VALUES
(1, 'RUTANANNA ARNOLD', 'arnoldrutanana@gmail.com', 'qwerty', NULL, '$2y$10$0D.d.5HUBx7NyKHx.3mrnetrdTlLNyCQBgTUIzv9gwWGRQfXkH1py', 1, 'MALE', '2024-09-01', 'UGANDAN', 'MUNYOYO', 'CM345DFGFD', '', NULL, '2024-03-20 13:18:23', '2024-03-20 13:18:23', 0, '2025-04-25 09:07:57', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(34, 'Kalanzi Ibrahim', 'kalanziibrahim4@gmail.com', '0757076153', NULL, '$2y$10$F0smYehDXlt0sE4t6FD8ReEeIcS8I1yleOcrFd6DeFa4EYlNzWUZm', 1, 'male', '2000-04-24', 'Uganda', 'Kisaasi', '100006443555', NULL, NULL, '2024-09-11 04:43:56', '2024-09-11 04:43:56', 0, '2025-04-25 09:07:57', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(211, 'SSEKASAMBA IBRAHIM', 'Ssekasamba43@gmail.com', '+256704082734', NULL, '$2y$10$StTowHX9sr9Ieg5Uckf1D.tzUBKmKbZV5tlMnID88vUKNqfcTYaQO', 3, 'MALE', '05/12/2004', 'UGANDAN', 'KAMPALA', 'CM04068108VRVH', '6974cd1777683.jpeg', NULL, '2026-01-24 16:45:59', '2026-01-24 16:45:59', 0, '2026-01-24 13:45:59', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(210, 'WNIA HUSSEIN', 'wniahussein@gmail.com', '+256+9647701226470', NULL, '$2y$10$tjb9/IV/HoIJinldSm7AC.4EyvqHTCUQyCIx73uil7CDz3QeWueHq', 3, 'FEMALE', '25/07/1989', '198984852063', 'SULAIMANYAH', 'B25338954', '6964e8b27d275.jpeg', NULL, '2026-01-12 15:27:30', '2026-01-12 15:27:30', 0, '2026-01-12 12:27:30', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(209, 'WNIA', 'wnia.wena@gmail.com', '+9647717352829', NULL, '$2y$10$iPhTKRHkAROCSxRtCvUZlO6kfE4z/1u6v0Gwkv.9Kq5UIVC1EhL9u', 3, 'FEMALE', '25/07/1989', '198984852063', 'SULAIMANYAH', 'B25338954', '6964e8569f947.jpeg', NULL, '2026-01-12 15:25:58', '2026-01-12 15:25:58', 0, '2026-01-12 12:25:58', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(208, 'NANTALE PHIONAH', 'fyownah965@gmail.com', '+256708499947', NULL, '$2y$10$Ic7fYQB8lJL2FRy1ji6YEO9WxEyM9yUHMRYyjA4yy8HOa4lBqS8yq', 3, 'FEMALE', '09/12/2002', 'UGANDAN', 'BUZIGA', 'B00309981', '695660aa08324.jpeg', NULL, '2026-01-01 14:55:22', '2026-01-01 14:55:22', 0, '2026-01-01 11:55:22', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(207, 'SIRAJE KIZITO', 'sirajek145@gmsil.com', '+256706700165', NULL, '$2y$10$EXUBuKWKPe.YX.E4P4ozruy/daDWoxBHalNEuOwPimvSO/9GS6brq', 3, 'MALE', '20/08/1990', 'UGANDAN', 'WAKISA', 'CM90024105Q98A', '6920d1c69bf3e.jpeg', NULL, '2025-11-21 23:55:34', '2025-11-21 23:55:34', 0, '2025-11-21 20:55:34', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(206, 'KAVUMA MAGIDAH', 'kmagidah3@gmail.com', '+256709303301', NULL, '$2y$10$.HPLRkwgUu9fcrBSW0tsEesBmy4wtyA8XlKUGLtlNXXWtrkZNcN2W', 3, 'FEMALE', '26/03/1999', 'UGANDA', 'KIRA', 'CF9912510072AJ', '6912c832d28e8.jpeg', NULL, '2025-11-11 08:22:58', '2025-11-11 08:22:58', 0, '2025-11-11 05:22:58', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(205, 'NAMITALA EMILLY MARIAM', 'emily.nm87@gmail.com', '+256705175884', NULL, '$2y$10$diH8Tb9P2izF.hwdNGQy2OfkixOdJcp9lh0R4pipbT5VzHLnier8C', 3, 'FEMALE', '23/06/1994', 'UGANDAN', 'MAKINDYE', 'CF94047100ZULF', '69038323b2c17.jpeg', NULL, '2025-10-30 18:24:19', '2025-10-30 18:24:19', 0, '2025-10-30 15:24:19', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(204, 'MATOVU IBRAHIM', 'reinzibrahim@gmail.com', '+966552159239', NULL, '$2y$10$oehVDRl.FMaH/DESVhw8oOkF5lxx04abDusdI3XXRsTxglaHbEJOy', 3, 'MALE', '15/03/2001', 'UGANDAN', 'SAUDI ARABIA', 'B00499232', '690231e612da4.jpeg', NULL, '2025-10-29 18:25:26', '2025-10-29 18:25:26', 0, '2025-10-29 15:25:26', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(203, 'SHAMSA NASABU', 'shamsakamira51@gmail.com', '+256783493151', NULL, '$2y$10$rHMA5v1dEJP70zaxia2UuO8uI/c49Gz/sRiD0ezZgY199wIssBPVm', 3, 'FEMALE', '26/12/2000', 'UGANDAN', 'BUDDO', 'CF0000810F5Y3E', '68efda16d4306.jpeg', NULL, '2025-10-15 20:29:58', '2025-10-15 20:29:58', 0, '2025-10-15 17:29:58', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(202, 'MABUYA MUBARAQ', 'mubaraqmabuya@gmail.com', '+256755901303', NULL, '$2y$10$x9XTGgOA6wFHl9Gm1WHpGOlqbKgmRmcOuj3Qb/DV0AldpnS.L2QMq', 3, 'MALE', '07/01/2001', 'UGANDAN', 'NAALYA', 'B00505969', '68ef6b0a1c07b.jpeg', NULL, '2025-10-15 12:36:10', '2025-10-15 12:36:10', 0, '2025-10-15 09:36:10', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(201, 'BASEKA HIKMAT', 'ikmatbakirisa@gmail.com', '+256701806395', NULL, '$2y$10$1XpcorZhcRYeCrDnQfp5leOJ6sZOjp3guytOuamSaL6pDsBZGKoDG', 3, 'FEMALE', '15/07/2003', 'UGANDAN', 'WAKISO', 'CF0301210CFPG', '68ed3352c8615.jpeg', NULL, '2025-10-13 20:13:54', '2025-10-13 20:13:54', 0, '2025-10-13 17:13:54', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(200, 'TAHIR IQBAL', 'Iqbaltahir008@gmail.com', '+9203341057624', NULL, '$2y$10$gFBz/mXscCHt6aPVxhUTzexXybNM94H0SNQshANcazxf8tcOdB1eK', 3, 'MALE', '16/09/2004', 'PAKISTAN', 'ATTOCK CITY', 'XD1341102', '68eae4d1cf8ab.jpeg', NULL, '2025-10-12 02:14:25', '2025-10-12 02:14:25', 0, '2025-10-11 23:14:25', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(199, 'SARAH NALUBEGA', 'meryer388@gmail.com', '+256703503570', NULL, '$2y$10$WTMbEmuDIag9XaA.3HQfZulbw81D7t.BMWQmExdzpTP1kCgpuv6mG', 3, 'FEMALE', '23/07/1981', 'UGANDAN', 'UGANDA', 'CF8102410585TF', '68d8a4901189b.jpeg', NULL, '2025-09-28 05:59:28', '2025-09-28 05:59:28', 0, '2025-09-28 02:59:28', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(198, 'ARAFAT HUSSEIN AL-AZHARY', 'arftxx6@gmail.com', '+256754638215', NULL, '$2y$10$rCjzLUUJkHGVHZ3NhBL9XO6CbfxdmGzUYSsI.f0WCHOmWJsjwP2b.', 3, 'MALE', '16/09/1999', 'UGANDA', 'EGYPT', 'B00137323', '68cc22f62d5b7.jpeg', NULL, '2025-09-18 18:19:18', '2025-09-18 18:19:18', 0, '2025-09-18 15:19:18', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(197, 'MAHAMAHRORLEE ARBUBAKA', 'suarasalam@yahoo.com', '+66960283728', NULL, '$2y$10$v9IikVzJKsGAQWhThWU9YueVU0F445w9NK13pxh281jN8Y2pKYvJm', 3, 'MALE', '23/07/1974', 'THAI', 'THAILAND', 'ac2948493', '68c19caeb14ca.jpeg', NULL, '2025-09-10 18:43:42', '2025-09-10 18:43:42', 0, '2025-09-10 15:43:42', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(196, 'NSUBUGA DAUDA', 'divans0702786140@gmail.com', '+256703118648', NULL, '$2y$10$LZB6TcxluqroHeH4k//vj.N7fZktE.1SmSrLcZxGOIG6FuHXWczw6', 3, 'MALE', '13/01/2000', 'UGANDAN', 'CHINA', 'A00882549', '68a9d35b4f7ae.jpeg', NULL, '2025-08-23 17:42:35', '2025-08-23 17:42:35', 0, '2025-08-23 14:42:35', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(195, 'NABATANZI FATUMAH', 'fatfai57@gmail.com', '+2560708185596', NULL, '$2y$10$Zi5BnrBd4Mv82tFLwhkH.equ7.poEeuwmMc5EApKI7uuoOXzz3LOG', 3, 'FEMALE', '28/08/2000', 'UGANDAN', 'KABUUMA VILLAGE', 'CF0002310JMFCE', '68a0b17e83e02.jpeg', NULL, '2025-08-16 19:27:42', '2025-08-16 19:27:42', 0, '2025-08-16 16:27:42', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(194, 'KASULE SADAM', 'skasule04@gmail.com', '+256743152276', NULL, '$2y$10$4IWlV5nmXlCnfUBWWoPl.Of5W75sZvfcO0e7r7jbrC3jrHPVNHn76', 3, 'MALE', '21/08/2002', 'UGANDAN', 'KISAASI', 'A00839993', '6890fbc0002cc.jpeg', NULL, '2025-08-04 21:28:16', '2025-08-04 21:28:16', 0, '2025-08-04 18:28:16', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(193, 'AMINA SANI ABUBAKAR', 'aminasaniabubakar58@gmail.com', '+2347032301917', NULL, '$2y$10$AlqzNt2fBZd/GL8GSWLD..ojloDWOW5J/2wJDIfWhNz34Hcwt2qOK', 3, 'MALE', '22/03/1990', 'NIGERIAN', 'BAUCHI STATE', '92137843761', '68907758aa0f8.jpeg', NULL, '2025-08-04 12:03:20', '2025-08-04 12:03:20', 0, '2025-08-04 09:03:20', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(192, 'NAKALEMBE SARAH SSEKABIRA', 'nakalembesarah495@gmail.com', '+256754367177', NULL, '$2y$10$Ym.8dMYSoO8JZcXdx7753OlHE9DBN0iSz59Oy4v.1zmSq7pLlKx2S', 3, 'FEMALE', '13/03/2001', 'UGANDAN', 'KISAASI', 'CF01119100M49L', '688732a2296c5.jpeg', NULL, '2025-07-28 11:19:46', '2025-07-28 11:19:46', 0, '2025-07-28 08:19:46', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(191, 'SSEBANTE  GADAFI SULIAMAN', 'gadafi.Suliaman @icloud.com', '+256755545029', NULL, '$2y$10$oafeviTvV4n2qAwjB3RvwuYV/bT1xanpb4uiN1Q/TWgcE2lVgkCKW', 3, 'MALE', '01/01/2003', 'UGANDAN', 'NALUVULE', 'B00334409', '68836a403b007.jpeg', NULL, '2025-07-25 14:28:00', '2025-07-25 14:28:00', 0, '2025-07-25 11:28:00', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(190, 'USAAMA TAMALE', 'tamaleusaama@gmail.com', '+256743589009', NULL, '$2y$10$sNcTx.R0CJFDLT.rY3ZFbu3vK/BQuNOQhPxMDXfYj/n7mQIV0u1KK', 3, 'MALE', '19/11/1992', 'UGANDAN', 'KAMPALA', 'CM920121014Y3G', '6877d1d7c4975.jpeg', NULL, '2025-07-16 19:22:47', '2025-07-16 19:22:47', 0, '2025-07-16 16:22:47', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(189, 'UMAR FAROOQ', 'malikumarfarooqjahanian@gmail.com', '+923066470733', NULL, '$2y$10$mzkw6TaCYSRrVehCwTcDI.RzhEgxTsP1CYjXq7EivOSLS9jhDNgVi', 3, 'MALE', '06/09/2001', 'PAKISTAN', 'PAKISTAN', 'CJ8962972', '68754a873981e.jpeg', NULL, '2025-07-14 21:20:55', '2025-07-14 21:20:55', 0, '2025-07-14 18:20:55', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(188, 'ABDULNAIM TWAHA', 'abdulnaeemtwaha01@gmail.com', '+256708991128', NULL, '$2y$10$GfCl3L6Z6iGu1AfDUT1UuOx8O1P8pDZTk2y4y1KyKQsORRIlLeYIq', 3, 'MALE', '17/07/2009', 'UGANDAN', 'KAWANDA', '0000000', '6870fbe3c9113.jpeg', NULL, '2025-07-11 14:56:19', '2025-07-11 14:56:19', 0, '2025-07-11 11:56:19', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(187, 'KAAYABULA SADAT', 'kagamesadat01@icloud.com', '+256755938974', NULL, '$2y$10$W/YtbIB0j0RXw.okJyInUO1n7SHNZsWkrep3GskDnWus.og.vMzta', 3, 'MALE', '06/06/2001', 'UGANDAN', 'KAMPALA', 'B00082057', '6870f35d64d11.jpeg', NULL, '2025-07-11 14:19:57', '2025-07-11 14:19:57', 0, '2025-07-11 11:19:57', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(186, 'SADAT KASUJJA', 'husseinsadat46@gmail.com', '+256701966507', NULL, '$2y$10$EvdCxXmDwbQDIFgbxpUYB.qrj4o2TSq01JJSRu6RtpAL8gYAc.cNu', 3, 'MALE', '28/04/2001', 'UGANDAN', 'KAMPALA', 'CM0101210C2CTA', '686fb4507e72a.jpeg', NULL, '2025-07-10 15:38:40', '2025-07-10 15:38:40', 0, '2025-07-10 12:38:40', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(185, 'JAMAL RASHID', 'malshedz@gmail.com', '+256701778686', NULL, '$2y$10$jARRm51QscE4T.sB8sW/y.i6AAPSQQ5nuEhdHWr5KNJHNWu4xImF.', 3, 'MALE', '26/11/1986', 'UGANDAN', 'BUIKWE', 'CM86010102AU1G', '686f76a115a2a.jpeg', NULL, '2025-07-10 11:15:29', '2025-07-10 11:15:29', 0, '2025-07-10 08:15:29', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(184, 'ISSA MUTWALIBI', 'issaberryzanis@gmail.com', '+256703951838', NULL, '$2y$10$4aOYU8z/ZJEQehGugJXm9Oy8K15xj3nXJIk5yTjoo8Zo2bJmYAK8G', 3, 'MALE', '07/07/1996', 'UGANDAN', 'MALABA TOWN COUNCIL', 'CM96051103LJNA', '686d7b93ee442.jpeg', NULL, '2025-07-08 23:12:03', '2025-07-08 23:12:03', 0, '2025-07-08 20:12:04', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(183, 'KAFUUMA MIDRAGE', 'midbinisma@gmail.com', '+256701941089', NULL, '$2y$10$0uk0QcyBjV0tJbDOvwyYuu4Wx/kA/8rV5aWp8UBFE0Nz5/0LT2pca', 3, 'MALE', '10/05/2002', 'UGANDAN', 'KINONI', 'cm02105109nc7k', '686c008f344ab.jpeg', NULL, '2025-07-07 20:14:55', '2025-07-07 20:14:55', 0, '2025-07-07 17:14:55', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(182, 'NALULE NAHIYA', 'Nalulenahiya2002@gmail.com', '+256+256708952311', NULL, '$2y$10$hw.xxd9meHnkuWUu8GaPdeEXwM2h0aNlORkeo1/hS.8CupvBqGwGa', 3, 'FEMALE', '17/11/2002', 'UGANDAN', 'NAKWERO', 'A00007480', '6867045a690e0.jpeg', NULL, '2025-07-04 01:29:46', '2025-07-04 01:29:46', 0, '2025-07-03 22:29:46', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(181, 'MUSA AJIB MUSA', 'ajibmusa1@gmail.com', '+256392003112', NULL, '$2y$10$XNkvUfkA4Mwx..HlXuVIoOgGIexPDp0aqRRoZEShVoMuK5eD/4eqC', 3, 'MALE', '09/07/2002', 'UGANDAN', 'UGANDA', 'B6439003', '686523303bae5.jpeg', NULL, '2025-07-02 15:16:48', '2025-07-02 15:16:48', 0, '2025-07-02 12:16:48', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(180, 'SAAD HISHAM', 'hishammahmoudsaad1@gmail.com', '+256701391494', NULL, '$2y$10$iSox3o/MABBXCnaF8up2GOQe1mqvb0xFumuXSI6z2Yqkq.1BHcraK', 3, 'MALE', '27/05/1995', 'UGANDAN', 'KASESE', 'A01016124', '686436c3cc894.jpeg', NULL, '2025-07-01 22:28:03', '2025-07-01 22:28:03', 0, '2025-07-01 19:28:03', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(179, 'BATAMBUZE HASSAN', 'hassanbatambuze@gmail.com', '+256757207407', NULL, '$2y$10$QdY1lEkWjVJF27kQpLDBX.sz3aFLV06RWTZMwEpFnOFqNkq2c/Pqq', 3, 'MALE', '16/07/1996', 'UGANDAN', 'BUGIRI', 'CM960411042GKG', '6863fd1caca02.jpeg', NULL, '2025-07-01 18:22:04', '2025-07-01 18:22:04', 0, '2025-07-01 15:22:04', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(178, 'KYEYUNE ABDULLAH', 'abukyeyune1@gmail.com', '+256768578761', NULL, '$2y$10$Vn1gXtN21u6JmjDN1rNC/ekntU1bdoxEMtiHVgUFQbkJzVHMwEy2q', 3, 'MALE', '21/10/2001', 'UGANDAN', 'BUNGA', 'CM0103210Q6MJ', '686251ce57a68.jpeg', NULL, '2025-06-30 11:58:54', '2025-06-30 11:58:54', 0, '2025-06-30 08:58:54', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(177, 'LUZINDA FALISI', 'lpharys@gmail.com', '+256755247630', NULL, '$2y$10$1WqPEsnioXkGN06Lij1V8esaxtdjwXzDwXZ4EtXVdp31QBigVx14S', 3, 'MALE', '10/06/1993', 'UGANDAN', 'MUYENGA-BUKASA', 'CM93052101621H', '68622789c7391.jpeg', NULL, '2025-06-30 08:58:33', '2025-06-30 08:58:33', 0, '2025-06-30 05:58:33', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(176, 'JINGO FAIZAL', 'faizaljingo2@gmail.com', '+256701798310', NULL, '$2y$10$tyMEg8NorV5wNVOjhwXIXuWyrDlXmfw00rJBicHlrz8c3VlWiq7WK', 3, 'MALE', '25/11/1996', 'UGANDAN', 'LUSANJA', 'CM9602310138DD', '686210d8098b0.jpeg', NULL, '2025-06-30 07:21:44', '2025-06-30 07:21:44', 0, '2025-06-30 04:21:44', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(175, 'DDAMULIRA KATO', 'damzkato2007@gmail.com', '+256709274020', NULL, '$2y$10$CH0GgyfpuO7ZW98Wyxfxbu90xGBF6pmFR0xAw5qkASeswCI6vm7n6', 3, 'MALE', '14/05/2007', 'UGANDAN', 'KAWEMPE', 'CFSIDV007336826E', '6861806e96376.jpeg', NULL, '2025-06-29 21:05:34', '2025-06-29 21:05:34', 0, '2025-06-29 18:05:34', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(174, 'SSENGONZI ASUMAN', 'seasasuman047@gmail.com', '+2560701825371', NULL, '$2y$10$F5heUdOmYFCRvy3whPABOe5bw.ufUqE3kyGqWEfwtHOtKBsioA/Ha', 3, 'MALE', '15/05/2000', 'UGANDAN', 'NDEJJE', 'CM0002310K1GWL', '685a6d3ec00ad.jpeg', NULL, '2025-06-24 12:17:50', '2025-06-24 12:17:50', 0, '2025-06-24 09:17:50', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(173, 'ABDALLAH BALUKU SAHULA', 'abdalabarlook@gmail.com', '+256787883737', NULL, '$2y$10$m3CQy98sqgA7uBJ1cuqzo.dLHs/PfC8HKhx6RnV89HtGty7tmtMLG', 3, 'MALE', '15/04/1998', 'UGANDAN', 'NTANDI BUNDIBUGYO', 'CM98003102MFYD', '6859363f4cc1e.jpeg', NULL, '2025-06-23 14:10:55', '2025-06-23 14:10:55', 0, '2025-06-23 11:10:55', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(172, 'UTHMAN SANI ABUBAKAR', 'uthmansaniabubakar@gmail.com', '+2349166864407', NULL, '$2y$10$P394jTkiM6R9Ga4.XSuHxutSrROEFkaJKodA3oqQgrAD6.E5bR3I2', 3, 'MALE', '05/10/2007', 'NIGERIAN', 'BAUCHI STATE', '39012772857', '685846ef96c0f.jpeg', NULL, '2025-06-22 21:09:51', '2025-06-22 21:09:51', 0, '2025-06-22 18:09:51', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(171, 'ZAINAB MUHAMMAD NAMYENYA', 'kibirigezainab45@gmail.com', '+447731702159', NULL, '$2y$10$SoQ89jb183JXa7VpEG3I2.thugbVIBwNrqc8e6xZuFC57jDxdnLx.', 3, 'FEMALE', '04/05/1993', 'UGANDAN', 'UNITED KINGDOM', 'A00589549', '685021e35e5dd.jpeg', NULL, '2025-06-16 16:53:39', '2025-06-16 16:53:39', 0, '2025-06-16 13:53:39', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(170, 'LUYINDA MICHEAL LUYONDE', 'LUYINDAMICHEAL8@GMAIL.COM', '+256702745419', NULL, '$2y$10$RF819VJr/b43rtYL6mHAMOKeQVRiWxkcbYcpeSl45GB5riK6w/2Ba', 3, 'MALE', '28/03/1998', 'UGANDAN', 'UGANDAN', 'CM98052106P9CJ', '684dca0919eae.jpeg', NULL, '2025-06-14 22:14:17', '2025-06-14 22:14:17', 0, '2025-06-14 19:14:17', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(169, 'MAGALA MUZAMIR', 'magalamuzamir@gmail.com', '+256759033603', NULL, '$2y$10$czfK.1wwRFHjGrOpYqmeSOzJ//Q2RX5Aoyl1lSd1J./pOwv2XN5fa', 3, 'MALE', '07/08/1987', 'UGANDAN', 'UGANDA', 'B00168143', '683bf344618d1.jpeg', NULL, '2025-06-01 09:29:24', '2025-06-01 09:29:24', 0, '2025-06-01 06:29:24', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(168, 'MUHAMMAD LUBEGA', 'muldeaniii@gmail.com', '+256703994435', NULL, '$2y$10$VTO9chYxJag/rZFQnI5xteBbLH/g4kOYQRs1y7g5pGmKyLJFTwqw2', 3, 'MALE', '14/04/1981', 'UGANDAN', 'NANFABO RD', 'CM8102310AJ16C', '6832ffea8c5be.jpeg', NULL, '2025-05-25 14:32:58', '2025-05-25 14:32:58', 0, '2025-05-25 11:32:58', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(167, 'LUKYAMUZI AHMED', 'ahmedlukyamuzi4@gmail.com', '+256743683665', NULL, '$2y$10$7p7wJ/UI2qoODyqraijAre7xpHd03D5YEXLPRlkxqN34FY44Am/BO', 3, 'MALE', '14/03/1993', 'UGANDAN', 'KABOWA', 'CM9302710CXT4A', '682afb10e95b9.jpeg', NULL, '2025-05-19 12:34:08', '2025-05-19 12:34:08', 0, '2025-05-19 09:34:09', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(166, 'KIGOZI IMRAN KAWEESA', 'kigoziimran6@gmail.com', '+256754505717', NULL, '$2y$10$NpHgqwU9NOlqjaJ3ZZT6s.RVu.KvPoV7nK.0h0HpvD5rBEDU9D5mu', 3, 'MALE', '17/02/2007', 'UGANDA', 'KAMPALA', 'B00527413', '682adbaddec49.jpeg', NULL, '2025-05-19 10:20:13', '2025-05-19 10:20:13', 0, '2025-05-19 07:20:13', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(165, 'SHARIFAH NALWOGA', 'sharifahbkka@icloud.com', '+256708921571', NULL, '$2y$10$2.zYa.S8NunH9dt9nndl3.KR0qoIDnEhCRi0OGv6iXGkuk0nlbeFq', 3, 'FEMALE', '17/09/1997', 'UGANDAN', 'MATUGGA', 'CF9702310JDF3C', '6829b4a1ad9af.jpeg', NULL, '2025-05-18 13:21:21', '2025-05-18 13:21:21', 0, '2025-05-18 10:21:21', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(164, 'FAISAL YUSUF GOLOBA', 'faisalyusuf653@gmail.com', '+256777994538', NULL, '$2y$10$ZvHI0JRADIu6OvTtip3Vw.h5H5OF4OsBEFZPjW5Rf5ICEgAfLvJ.a', 3, 'MALE', '15/07/2006', 'UGANDAN', 'DUBAI', 'B00522606', '68297d7984fcb.jpeg', NULL, '2025-05-18 09:26:01', '2025-05-18 09:26:01', 0, '2025-05-18 06:26:01', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(163, 'Ssekikubo Yasin Kisule', 'yasinkisuulessekikubo@gmail.com', '0740827009', NULL, '$2y$13$TSVmcrmENx44h.F9QSlyyurrWb5BkLjjJ1.FTsoy3AkMZt7QdIoWi', 3, 'male', '1999-12-15', 'Ugandan', 'Kisaasi', '100006443555', NULL, NULL, NULL, NULL, 0, '2025-05-17 16:18:45', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(162, 'Kabugo Sumayah', 'sumayyahkabugo@gmail.com', '0757682429', NULL, '$2y$13$GDI/hm.bbImP.9JxodpOp.zLxyqp2snoTvA55C7ARzseVpd9snb06', 3, 'female', '2000-04-24', 'Ugandan', 'Kyebando', '100006443555', NULL, NULL, NULL, NULL, 0, '2025-05-17 11:41:04', NULL, 0, 0, 0, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `id` bigint(20) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `userId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `Role` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_roles`
--

INSERT INTO `user_roles` (`id`, `Role`, `created_at`, `updated_at`) VALUES
(1, 'Admin', NULL, NULL),
(2, 'Manager', NULL, NULL),
(3, 'Client', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adverts`
--
ALTER TABLE `adverts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `amenities`
--
ALTER TABLE `amenities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bookings_userid_foreign` (`userId`),
  ADD KEY `bookings_packageid_foreign` (`packageId`);

--
-- Indexes for table `booking_payments`
--
ALTER TABLE `booking_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_payments_bookingid_foreign` (`bookingId`),
  ADD KEY `fk_issuedBy` (`issuedBy`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_type_id` (`event_type_id`);

--
-- Indexes for table `event_type`
--
ALTER TABLE `event_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `maqam_exes`
--
ALTER TABLE `maqam_exes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `master_package`
--
ALTER TABLE `master_package`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oneTimeServices`
--
ALTER TABLE `oneTimeServices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `package_category`
--
ALTER TABLE `package_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `payment_number` (`payment_number`);

--
-- Indexes for table `payment_plan`
--
ALTER TABLE `payment_plan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_plan_installment`
--
ALTER TABLE `payment_plan_installment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reservation_number` (`reservation_number`);

--
-- Indexes for table `reservation_pilgrim`
--
ALTER TABLE `reservation_pilgrim`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_packageid_foreign` (`packageId`);

--
-- Indexes for table `sonda_mpolas`
--
ALTER TABLE `sonda_mpolas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_created_by` (`created_by`),
  ADD KEY `fk_system_user` (`system_user`);

--
-- Indexes for table `sonda_mpola_payments`
--
ALTER TABLE `sonda_mpola_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sondaMpolaId` (`sondaMpolaId`),
  ADD KEY `receipted_by` (`receipted_by`),
  ADD KEY `issuedBy` (`issuedBy`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_id` (`transaction_id`),
  ADD KEY `idx_transaction_transaction_id` (`transaction_id`),
  ADD KEY `idx_transaction_reference` (`reference`),
  ADD KEY `idx_transaction_type_status` (`type`,`status`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_phone_unique` (`phone`),
  ADD KEY `users_role_foreign` (`role`);

--
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adverts`
--
ALTER TABLE `adverts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `amenities`
--
ALTER TABLE `amenities`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=142;

--
-- AUTO_INCREMENT for table `booking_payments`
--
ALTER TABLE `booking_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=305;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `event_type`
--
ALTER TABLE `event_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `maqam_exes`
--
ALTER TABLE `maqam_exes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `master_package`
--
ALTER TABLE `master_package`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `oneTimeServices`
--
ALTER TABLE `oneTimeServices`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `package_category`
--
ALTER TABLE `package_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payment_plan`
--
ALTER TABLE `payment_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_plan_installment`
--
ALTER TABLE `payment_plan_installment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `reservation_pilgrim`
--
ALTER TABLE `reservation_pilgrim`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `sonda_mpolas`
--
ALTER TABLE `sonda_mpolas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `sonda_mpola_payments`
--
ALTER TABLE `sonda_mpola_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT for table `user_profile`
--
ALTER TABLE `user_profile`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_roles`
--
ALTER TABLE `user_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`event_type_id`) REFERENCES `event_type` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
