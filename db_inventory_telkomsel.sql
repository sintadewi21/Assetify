-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2026 at 07:13 PM
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
-- Database: `db_inventory_telkomsel`
--

-- --------------------------------------------------------

--
-- Table structure for table `borrowings`
--

CREATE TABLE `borrowings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `borrower_name` varchar(255) NOT NULL,
  `borrow_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected','Returned','Overdue') NOT NULL DEFAULT 'Pending',
  `reject_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `borrowings`
--

INSERT INTO `borrowings` (`id`, `user_id`, `borrower_name`, `borrow_date`, `due_date`, `return_date`, `status`, `reject_reason`, `created_at`, `updated_at`) VALUES
(1, 1, 'sinta cakep', '2026-07-08', '2026-07-15', '2026-07-08', 'Returned', NULL, '2026-07-08 03:23:31', '2026-07-08 05:47:03'),
(2, 1, 'Sinta mode admin', '2026-05-08', '2026-06-15', NULL, 'Rejected', 'Loan cancelled due to being overdue.', '2026-07-08 05:47:45', '2026-07-08 05:58:00');

-- --------------------------------------------------------

--
-- Table structure for table `borrowing_details`
--

CREATE TABLE `borrowing_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `borrowing_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `borrowing_details`
--

INSERT INTO `borrowing_details` (`id`, `borrowing_id`, `product_id`, `qty`, `created_at`, `updated_at`) VALUES
(1, 1, 10, 1, '2026-07-08 03:23:31', '2026-07-08 03:23:31'),
(2, 2, 11, 1, '2026-07-08 05:47:45', '2026-07-08 05:47:45'),
(3, 2, 3, 1, '2026-07-08 05:47:45', '2026-07-08 05:47:45');

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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Elektronik', '2026-07-05 13:45:50', '2026-07-05 13:45:50'),
(2, 'Alat Tulis Kantor (ATK)', '2026-07-05 13:45:50', '2026-07-05 13:45:50'),
(3, 'Fasilitas Ruangan', '2026-07-05 13:45:50', '2026-07-05 13:45:50');

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
(1, '0000_07_02_164307_create_roles_tabl', 1),
(2, '0001_01_01_000000_create_users_table', 1),
(3, '0001_01_01_000001_create_cache_table', 1),
(4, '0001_01_01_000002_create_jobs_table', 1),
(5, '2026_07_02_164318_create_categories_table', 1),
(6, '2026_07_02_164331_create_products_table', 1),
(7, '2026_07_02_164342_create_borrowings_table', 1),
(8, '2026_07_02_164353_create_borrowings_details_table', 1),
(9, '2026_07_02_164354_create_custom_notifications_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 5, 'New Loan Request', 'Staff \"Admin1\" requested a loan for \"sinta cakep\".', 0, '2026-07-08 03:23:31', '2026-07-08 03:23:31'),
(2, 1, 'Loan Request Approved', 'Your loan request for \"sinta cakep\" has been approved!', 0, '2026-07-08 05:46:57', '2026-07-08 05:46:57'),
(3, 5, 'New Loan Request', 'Staff \"Admin1\" requested a loan for \"Sinta mode admin\".', 0, '2026-07-08 05:47:45', '2026-07-08 05:47:45'),
(4, 1, 'Loan Request Approved', 'Your loan request for \"Sinta mode admin\" has been approved!', 0, '2026-07-08 05:47:48', '2026-07-08 05:47:48'),
(5, 1, 'Overdue Return Warning', 'Please contact borrower \"Sinta mode admin\" immediately. The loan for items (due on 15 Jun 2026) is overdue.', 0, '2026-07-08 05:48:00', '2026-07-08 05:48:00');

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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `condition` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `code`, `name`, `stock`, `location`, `condition`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 'AFT-ELC-001', 'Laptop ASUS Vivobook', 10, 'Ruang Staf Lantai 2', 'Bagus', 'products/qGZ0czC0z1Ef6gqai2p3Loj2JtrGUg2sznEZIfIo.png', '2026-07-05 13:45:50', '2026-07-05 06:47:26'),
(2, 1, 'AFT-ELC-002', 'Projector Epson', 5, 'Ruang Rapat Utama', 'Bagus', 'products/mS5gCSLYoFl0w6ybN6nafp7QAW0Y9LQeeqVRh7nX.png', '2026-07-05 13:45:50', '2026-07-05 06:54:58'),
(3, 1, 'AFT-ELC-003', 'Printer Canon Pixma', 4, 'Ruang Administrasi', 'Bagus', 'products/RLgSFOOtkBT9aGgrfiKUJdsB98UKU3K1ONEpw66h.png', '2026-07-05 13:45:50', '2026-07-08 05:58:00'),
(4, 1, 'AFT-ELC-004', 'Mouse Wireless Logitech', 15, 'Gudang Inventaris', 'Bagus', 'products/UYrAHinu8JIHGafGNprqHdoyupwaAq5XsGqbkIBx.png', '2026-07-05 13:45:50', '2026-07-05 07:00:44'),
(5, 1, 'AFT-ELC-005', 'Keyboard Logitech', 12, 'Gudang Inventaris', 'Bagus', 'products/XVdKJtC8Lnb7pRFCNrivJ1Hkf7UnPfdJSAVIGGS0.png', '2026-07-05 13:45:50', '2026-07-07 22:27:00'),
(6, 2, 'AFT-ATK-001', 'Papan Tulis Whiteboard', 6, 'Ruang Kelas 1', 'Rusak Ringan', 'products/7l2FzMmBT6pLW7dSqYPXzFIXqi6jtKz9Bu2eeArL.png', '2026-07-05 13:45:50', '2026-07-07 22:30:20'),
(7, 2, 'AFT-ATK-002', 'Paper Shredder Penghancur Kertas', 3, 'Ruang Arsip', 'Bagus', 'products/rXJH0jgVv7oLav2tDfC1qSuCFeGy693FUz6ZFxbh.png', '2026-07-05 13:45:50', '2026-07-07 22:29:54'),
(8, 2, 'AFT-ATK-003', 'Stapler Besar Kangaro', 8, 'Meja Resepsionis', 'Bagus', 'products/hEkz1eKwoXc8nYiBNxVoBMys3fC5JcIuE3gsOXcJ.png', '2026-07-05 13:45:50', '2026-07-07 22:30:38'),
(9, 2, 'AFT-ATK-004', 'Pemotong Kertas Paper Cutter', 4, 'Ruang Administrasi', 'Bagus', 'products/diKzJ5vdCw9iIVuPMN3mKnV6yu4ozUY7ZF9ejkb5.png', '2026-07-05 13:45:50', '2026-07-07 22:30:54'),
(10, 3, 'AFT-FAS-001', 'Kursi Kerja Kantor Roda', 25, 'Ruang Kerja Utama', 'Rusak Berat', 'products/NmiclUHEOop7rEvx8iWXDnVUAtMmVwRMsyIt7U0X.png', '2026-07-05 13:45:50', '2026-07-08 05:47:03'),
(11, 3, 'AFT-FAS-002', 'Meja Kayu Kerja', 7, 'Ruang Kerja Utama', 'Rusak Berat', 'products/K42ZFts2fxSgMQh2e7NeSQw22OUqt11eyXLEe0Sg.png', '2026-07-05 13:45:50', '2026-07-08 05:58:00'),
(12, 3, 'AFT-FAS-003', 'Dispenser Air Sharp', 3, 'Pantry Lantai 2', 'Rusak Ringan', 'products/Il6O3kHFA8S1LbqMh1QLDHZegL8VcQTivX9hLIsu.png', '2026-07-05 13:45:50', '2026-07-07 22:33:56'),
(13, 3, 'AFT-FAS-004', 'Kipas Angin Berdiri Cosmos', 5, 'Ruang Tamu', 'Bagus', 'products/st0YhixOa50RwLelKvpVCbMATntw9qbUuXVqTpZv.png', '2026-07-05 13:45:50', '2026-07-07 22:34:11');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', '2026-07-05 06:43:53', '2026-07-05 06:43:53'),
(2, 'Staff', '2026-07-05 06:43:53', '2026-07-05 06:43:53'),
(3, 'Manager', '2026-07-05 06:43:53', '2026-07-05 06:43:53');

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
('MhmuIXVdfhsbIyJZgioeawt8CVqF5UsG5HMiHJaf', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoid0I5bUJLbXFJS3N1OFpPanIySGpaclZyTFFnMGtaeUtlRmxRcjJTVCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2FucyI7czo1OiJyb3V0ZSI7czoxMToibG9hbnMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1783517309);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'staff',
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Admin1', 'admin1@gmail.com', NULL, '$2y$12$c440FGwL5wp8AoOZdhFOvufiTuwX1gAz.bha0bo5ZF3tbBSQ1QK.i', NULL, '2026-07-05 06:43:54', '2026-07-05 06:43:54'),
(2, 'admin', 'Admin2', 'admin2@gmail.com', NULL, '$2y$12$kyYvBNhyJmUtChmzseRKA.Pok8Iaa0m9QWCW3RQeSBAa.eDSPuN.q', NULL, '2026-07-05 06:43:54', '2026-07-05 06:43:54'),
(3, 'admin', 'Admin3', 'admin3@gmail.com', NULL, '$2y$12$Mvt2wQeue.UDYE/VFINFlOXamIyZZIe53IjtH5nBxz0GE06p9sdZ6', NULL, '2026-07-05 06:43:55', '2026-07-05 06:43:55'),
(4, 'staff', 'Staff Inventory', 'staff@gmail.com', NULL, '$2y$12$cRpQGzkLWxgqv5lTLxrFp.D40jaXuhAoNa/M5HIkGtniK0QWAJtTy', NULL, '2026-07-05 06:43:55', '2026-07-05 06:43:55'),
(5, 'manager', 'Manager Inventory', 'manager@gmail.com', NULL, '$2y$12$yxT94A8nObl7LHwgjkwdruN2Jar8GJUGm8hH5vCpjQ4qDF8IqtKU6', NULL, '2026-07-05 06:43:56', '2026-07-05 06:43:56'),
(6, 'staff', 'sinta cakep', 'sinta1@gmail.com', NULL, '$2y$12$DP6UuDhZoXR1PyVNXOFVXezeiOEgbpepWjl5TUpp.BZcyA4kuIoou', 'XV5PFsNuhMmAk1OQy9WniaanDb19u1Du3sjhvORLUBwuZ6uLlJIW5JoSPxal', '2026-07-07 21:50:00', '2026-07-07 22:03:16'),
(7, 'staff', 'sinta cakep banget', 'sintacakep@gmail.com', NULL, '$2y$12$fE4Zw2kon5VaqOBiCTXFUeRIjpGg6tRwt05GVUx8iKmWoCM7JJdZy', NULL, '2026-07-07 22:05:15', '2026-07-07 22:05:15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borrowings_user_id_foreign` (`user_id`);

--
-- Indexes for table `borrowing_details`
--
ALTER TABLE `borrowing_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `borrowing_details_borrowing_id_foreign` (`borrowing_id`),
  ADD KEY `borrowing_details_product_id_foreign` (`product_id`);

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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_code_unique` (`code`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `borrowings`
--
ALTER TABLE `borrowings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `borrowing_details`
--
ALTER TABLE `borrowing_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `borrowings`
--
ALTER TABLE `borrowings`
  ADD CONSTRAINT `borrowings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `borrowing_details`
--
ALTER TABLE `borrowing_details`
  ADD CONSTRAINT `borrowing_details_borrowing_id_foreign` FOREIGN KEY (`borrowing_id`) REFERENCES `borrowings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `borrowing_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
