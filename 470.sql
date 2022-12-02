-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2022 at 10:48 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `470`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `street` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `houseNo` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `street`, `city`, `houseNo`, `remember_token`, `created_at`, `updated_at`) VALUES
(156, 'Muaz', 'syedali1998bd@gmail.com', '01301767913', NULL, '$2y$10$q7/S2cI3tAeT2UEQxhEr1.0WmjqZcjXMtjam03jXC/SFbstrvcoJK', NULL, NULL, NULL, NULL, '2022-12-02 14:06:50', '2022-12-02 14:06:50');

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
-- Table structure for table `foods`
--

CREATE TABLE `foods` (
  `id` int(100) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `price` varchar(1000) NOT NULL,
  `image` varchar(1000) NOT NULL,
  `category` varchar(1000) NOT NULL,
  `restaurant` int(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`id`, `name`, `price`, `image`, `category`, `restaurant`, `created_at`, `updated_at`) VALUES
(5, 'test', '100', '1669832207.png', 'Chinese', 7, '2022-11-30 18:16:47', '2022-11-30 18:16:47'),
(6, 'test', '100', '1669832243.png', 'Chinese', 7, '2022-11-30 18:17:23', '2022-11-30 18:17:23'),
(7, 'test', '5555', '1669841166.png', 'American', 7, '2022-11-30 20:46:06', '2022-11-30 20:46:06'),
(8, 'test', '4', '1669843352.png', 'American', 7, '2022-11-30 21:22:32', '2022-11-30 21:22:32'),
(12, 'Burger', '500', '1670010978.jpg', 'American', 14, '2022-12-02 19:56:18', '2022-12-02 19:56:18'),
(13, 'Pizza', '400', '1670011015.jpg', 'American', 14, '2022-12-02 19:56:55', '2022-12-02 19:56:55'),
(14, 'French Fries', '100', '1670011024.jpg', 'American', 14, '2022-12-02 19:57:04', '2022-12-02 19:57:04'),
(15, 'Pad Thai', '200', '1670011056.jpg', 'Thai', 16, '2022-12-02 19:57:36', '2022-12-02 19:57:36'),
(16, 'Pad See Ew', '250', '1670011077.jpg', 'Thai', 16, '2022-12-02 19:57:57', '2022-12-02 19:57:57'),
(17, 'Kuay Teow Neua', '400', '1670011093.jpg', 'Thai', 16, '2022-12-02 19:58:13', '2022-12-02 19:58:13'),
(18, 'Ba Mee Kiew', '200', '1670011109.jpg', 'Thai', 16, '2022-12-02 19:58:29', '2022-12-02 19:58:29'),
(19, 'Kung Pao Chicken', '400', '1670011237.jpg', 'Chinese', 18, '2022-12-02 20:00:37', '2022-12-02 20:00:37'),
(20, 'Spring Rolls', '500', '1670011253.jpg', 'Chinese', 18, '2022-12-02 20:00:53', '2022-12-02 20:00:53'),
(21, 'Fried Rice', '100', '1670011268.jpg', 'Chinese', 18, '2022-12-02 20:01:08', '2022-12-02 20:01:08'),
(22, 'Mapo Tofu', '500', '1670011283.jpg', 'Chinese', 18, '2022-12-02 20:01:23', '2022-12-02 20:01:23'),
(23, 'Jiaozi', '350', '1670011348.jpg', 'Chinese', 18, '2022-12-02 20:01:36', '2022-12-02 20:02:28'),
(24, 'Wonton', '500', '1670011373.jpg', 'Chinese', 18, '2022-12-02 20:02:53', '2022-12-02 20:02:53');

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE `manager` (
  `id` int(100) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `email` varchar(1000) NOT NULL,
  `phone` varchar(1000) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `admin_approval` int(11) NOT NULL DEFAULT 0,
  `role` varchar(1000) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`id`, `name`, `email`, `phone`, `password`, `admin_approval`, `role`, `updated_at`, `created_at`) VALUES
(35, 'test', 'tadmin@test.test', 'test', '$2y$10$u9sgamEtreiKexzXebV15.NrRTzGQwPI9kbYantB/iblOwhFax42S', 1, 'administrative_manager', '2022-12-01 21:54:26', '2022-12-01 21:54:26'),
(39, 'admin', 'tadmin2@test.test', '010101010', '$2y$10$zDeuJHaekpvT2y70lXT7Fu9hXf1EG3C4G7jot0WkpPc2ofTfdB9By', 1, 'administrative_manager', '2022-12-02 19:03:03', '2022-12-02 18:54:40'),
(40, 'Restaurant Manager', 'restaurantmanaget@test.com', '01301767913', '$2y$10$R0K3OIathDskNgQfGFTmfehxznkxJAX8d2rcSnlVrem4P0ugxnOSG', 0, 'restaurant_manager', '2022-12-02 19:46:13', '2022-12-02 19:46:13');

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
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `foods` longtext NOT NULL,
  `quantity` longtext NOT NULL,
  `cost` varchar(100) NOT NULL,
  `customer` int(11) NOT NULL,
  `restaurant` int(100) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `foods`, `quantity`, `cost`, `customer`, `restaurant`, `status`, `created_at`, `updated_at`) VALUES
(44, '20,19', '3,1', '1900', 156, 18, 'pending', '2022-12-02 20:06:56', '2022-12-02 20:06:56'),
(45, '12,13,14', '4,1,2', '2600', 156, 14, 'pending', '2022-12-02 20:07:05', '2022-12-02 20:07:05'),
(46, '18,17', '3,3', '1800', 156, 16, 'pending', '2022-12-02 20:07:14', '2022-12-02 20:07:14'),
(47, '20', '2', '1000', 156, 18, 'pending', '2022-12-02 20:25:17', '2022-12-02 20:25:17'),
(48, '16,17', '2,2', '1300', 156, 16, 'pending', '2022-12-02 20:27:31', '2022-12-02 20:27:31'),
(49, '16,17', '2,3', '1700', 156, 16, 'pending', '2022-12-02 20:34:05', '2022-12-02 20:34:05'),
(50, '15', '10', '2000', 156, 16, 'pending', '2022-12-02 20:35:01', '2022-12-02 20:35:01'),
(51, '19,21,23', '2,3,1', '1450', 156, 18, 'pending', '2022-12-02 20:54:01', '2022-12-02 20:54:01'),
(52, '19,23', '3,1', '1550', 156, 18, 'pending', '2022-12-02 20:58:06', '2022-12-02 20:58:06'),
(53, '21,23', '3,4', '1700', 156, 18, 'pending', '2022-12-02 21:03:45', '2022-12-02 21:03:45'),
(54, '20,21,22,23,24', '2,5,2,1,4', '4850', 156, 18, 'pending', '2022-12-02 21:09:06', '2022-12-02 21:09:06'),
(55, '21,22', '4,1', '900', 156, 18, 'pending', '2022-12-02 21:16:54', '2022-12-02 21:16:54'),
(56, '21', '3', '300', 156, 18, 'pending', '2022-12-02 21:19:09', '2022-12-02 21:19:09'),
(57, '21', '5', '500', 156, 18, 'pending', '2022-12-02 21:19:52', '2022-12-02 21:19:52'),
(58, '19,20,21', '4,3,1', '3200', 156, 18, 'pending', '2022-12-02 21:26:25', '2022-12-02 21:26:25');

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
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `category` varchar(1000) NOT NULL,
  `image` varchar(1000) NOT NULL,
  `restaurant_owner` int(100) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`id`, `name`, `category`, `image`, `restaurant_owner`, `updated_at`, `created_at`) VALUES
(14, 'Amrican Restaurant', 'American', '1670012957.jpg', 40, '2022-12-02 20:29:17', '2022-12-02 19:49:14'),
(16, 'Thai Restaurant', 'Thai', '1670012984.jpg', 40, '2022-12-02 20:29:44', '2022-12-02 19:49:39'),
(18, 'Chinese Restaurant', 'Chinese', '1670013014.jpg', 40, '2022-12-02 20:30:14', '2022-12-02 19:53:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
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
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `manager`
--
ALTER TABLE `manager`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
