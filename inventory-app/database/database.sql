-- -------------------------------------------------------------
-- PT Telkomsel Inventory Management System (InLife)
-- Database Schema SQL Dump (Auto-generated)
-- -------------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 0;

-- -------------------------------------------------------------
-- Table: roles
-- -------------------------------------------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed data for roles
INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES ('1', 'Admin', '2026-07-05 13:43:53', '2026-07-05 13:43:53');
INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES ('2', 'Staff', '2026-07-05 13:43:53', '2026-07-05 13:43:53');
INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES ('3', 'Manager', '2026-07-05 13:43:53', '2026-07-05 13:43:53');

-- -------------------------------------------------------------
-- Table: users
-- -------------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(255) NOT NULL DEFAULT 'staff',
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed data for users
INSERT INTO `users` (`id`, `role`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('1', 'admin', 'Admin1', 'admin1@gmail.com', NULL, '$2y$12$c440FGwL5wp8AoOZdhFOvufiTuwX1gAz.bha0bo5ZF3tbBSQ1QK.i', NULL, '2026-07-05 13:43:54', '2026-07-05 13:43:54');
INSERT INTO `users` (`id`, `role`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('2', 'admin', 'Admin2', 'admin2@gmail.com', NULL, '$2y$12$kyYvBNhyJmUtChmzseRKA.Pok8Iaa0m9QWCW3RQeSBAa.eDSPuN.q', NULL, '2026-07-05 13:43:54', '2026-07-05 13:43:54');
INSERT INTO `users` (`id`, `role`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('3', 'admin', 'Admin3', 'admin3@gmail.com', NULL, '$2y$12$Mvt2wQeue.UDYE/VFINFlOXamIyZZIe53IjtH5nBxz0GE06p9sdZ6', NULL, '2026-07-05 13:43:55', '2026-07-05 13:43:55');
INSERT INTO `users` (`id`, `role`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('4', 'staff', 'Staff Inventory', 'staff@gmail.com', NULL, '$2y$12$cRpQGzkLWxgqv5lTLxrFp.D40jaXuhAoNa/M5HIkGtniK0QWAJtTy', NULL, '2026-07-05 13:43:55', '2026-07-05 13:43:55');
INSERT INTO `users` (`id`, `role`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('5', 'manager', 'Manager Inventory', 'manager@gmail.com', NULL, '$2y$12$yxT94A8nObl7LHwgjkwdruN2Jar8GJUGm8hH5vCpjQ4qDF8IqtKU6', NULL, '2026-07-05 13:43:56', '2026-07-05 13:43:56');

-- -------------------------------------------------------------
-- Table: categories
-- -------------------------------------------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed data for categories
INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES ('1', 'Elektronik', '2026-07-05 20:45:50', '2026-07-05 20:45:50');
INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES ('2', 'Alat Tulis Kantor (ATK)', '2026-07-05 20:45:50', '2026-07-05 20:45:50');
INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES ('3', 'Fasilitas Ruangan', '2026-07-05 20:45:50', '2026-07-05 20:45:50');

-- -------------------------------------------------------------
-- Table: products
-- -------------------------------------------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `stock` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `condition` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_code_unique` (`code`),
  KEY `products_category_id_foreign` (`category_id`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed data for products
INSERT INTO `products` (`id`, `category_id`, `code`, `name`, `stock`, `location`, `condition`, `image`, `created_at`, `updated_at`) VALUES ('1', '1', 'AFT-ELC-001', 'Laptop ASUS Vivobook', '10', 'Ruang Staf Lantai 2', 'Bagus', 'products/qGZ0czC0z1Ef6gqai2p3Loj2JtrGUg2sznEZIfIo.png', '2026-07-05 20:45:50', '2026-07-05 13:47:26');
INSERT INTO `products` (`id`, `category_id`, `code`, `name`, `stock`, `location`, `condition`, `image`, `created_at`, `updated_at`) VALUES ('2', '1', 'AFT-ELC-002', 'Projector Epson', '5', 'Ruang Rapat Utama', 'Bagus', 'products/mS5gCSLYoFl0w6ybN6nafp7QAW0Y9LQeeqVRh7nX.png', '2026-07-05 20:45:50', '2026-07-05 13:54:58');
INSERT INTO `products` (`id`, `category_id`, `code`, `name`, `stock`, `location`, `condition`, `image`, `created_at`, `updated_at`) VALUES ('3', '1', 'AFT-ELC-003', 'Printer Canon Pixma', '4', 'Ruang Administrasi', 'Rusak Ringan', 'products/RLgSFOOtkBT9aGgrfiKUJdsB98UKU3K1ONEpw66h.png', '2026-07-05 20:45:50', '2026-07-05 13:57:36');
INSERT INTO `products` (`id`, `category_id`, `code`, `name`, `stock`, `location`, `condition`, `image`, `created_at`, `updated_at`) VALUES ('4', '1', 'AFT-ELC-004', 'Mouse Wireless Logitech', '15', 'Gudang Inventaris', 'Bagus', 'products/UYrAHinu8JIHGafGNprqHdoyupwaAq5XsGqbkIBx.png', '2026-07-05 20:45:50', '2026-07-05 14:00:44');
INSERT INTO `products` (`id`, `category_id`, `code`, `name`, `stock`, `location`, `condition`, `image`, `created_at`, `updated_at`) VALUES ('5', '1', 'AFT-ELC-005', 'Keyboard Logitech', '12', 'Gudang Inventaris', 'Baik', NULL, '2026-07-05 20:45:50', '2026-07-05 20:45:50');
INSERT INTO `products` (`id`, `category_id`, `code`, `name`, `stock`, `location`, `condition`, `image`, `created_at`, `updated_at`) VALUES ('6', '2', 'AFT-ATK-001', 'Papan Tulis Whiteboard', '6', 'Ruang Kelas 1', 'Baik', NULL, '2026-07-05 20:45:50', '2026-07-05 20:45:50');
INSERT INTO `products` (`id`, `category_id`, `code`, `name`, `stock`, `location`, `condition`, `image`, `created_at`, `updated_at`) VALUES ('7', '2', 'AFT-ATK-002', 'Paper Shredder Penghancur Kertas', '3', 'Ruang Arsip', 'Baik', NULL, '2026-07-05 20:45:50', '2026-07-05 20:45:50');
INSERT INTO `products` (`id`, `category_id`, `code`, `name`, `stock`, `location`, `condition`, `image`, `created_at`, `updated_at`) VALUES ('8', '2', 'AFT-ATK-003', 'Stapler Besar Kangaro', '8', 'Meja Resepsionis', 'Baik', NULL, '2026-07-05 20:45:50', '2026-07-05 20:45:50');
INSERT INTO `products` (`id`, `category_id`, `code`, `name`, `stock`, `location`, `condition`, `image`, `created_at`, `updated_at`) VALUES ('9', '2', 'AFT-ATK-004', 'Pemotong Kertas Paper Cutter', '4', 'Ruang Administrasi', 'Baik', NULL, '2026-07-05 20:45:50', '2026-07-05 20:45:50');
INSERT INTO `products` (`id`, `category_id`, `code`, `name`, `stock`, `location`, `condition`, `image`, `created_at`, `updated_at`) VALUES ('10', '3', 'AFT-FAS-001', 'Kursi Kerja Kantor Roda', '25', 'Ruang Kerja Utama', 'Baik', NULL, '2026-07-05 20:45:50', '2026-07-05 20:45:50');
INSERT INTO `products` (`id`, `category_id`, `code`, `name`, `stock`, `location`, `condition`, `image`, `created_at`, `updated_at`) VALUES ('11', '3', 'AFT-FAS-002', 'Meja Kayu Kerja', '20', 'Ruang Kerja Utama', 'Baik', NULL, '2026-07-05 20:45:50', '2026-07-05 20:45:50');
INSERT INTO `products` (`id`, `category_id`, `code`, `name`, `stock`, `location`, `condition`, `image`, `created_at`, `updated_at`) VALUES ('12', '3', 'AFT-FAS-003', 'Dispenser Air Sharp', '3', 'Pantry Lantai 2', 'Baik', NULL, '2026-07-05 20:45:50', '2026-07-05 20:45:50');
INSERT INTO `products` (`id`, `category_id`, `code`, `name`, `stock`, `location`, `condition`, `image`, `created_at`, `updated_at`) VALUES ('13', '3', 'AFT-FAS-004', 'Kipas Angin Berdiri Cosmos', '5', 'Ruang Tamu', 'Baik', NULL, '2026-07-05 20:45:50', '2026-07-05 20:45:50');

-- -------------------------------------------------------------
-- Table: borrowings
-- -------------------------------------------------------------
DROP TABLE IF EXISTS `borrowings`;
CREATE TABLE `borrowings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `borrower_name` varchar(255) NOT NULL,
  `borrow_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected','Returned','Overdue') NOT NULL DEFAULT 'Pending',
  `reject_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `borrowings_user_id_foreign` (`user_id`),
  CONSTRAINT `borrowings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- Table: borrowing_details
-- -------------------------------------------------------------
DROP TABLE IF EXISTS `borrowing_details`;
CREATE TABLE `borrowing_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `borrowing_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `borrowing_details_borrowing_id_foreign` (`borrowing_id`),
  KEY `borrowing_details_product_id_foreign` (`product_id`),
  CONSTRAINT `borrowing_details_borrowing_id_foreign` FOREIGN KEY (`borrowing_id`) REFERENCES `borrowings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `borrowing_details_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- Table: notifications
-- -------------------------------------------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_foreign` (`user_id`),
  CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
