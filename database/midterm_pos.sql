-- IT0049 Midterm Project
-- Complete Point-of-Sale System for MySQL or MariaDB.

SET NAMES utf8mb4;
SET time_zone = '+08:00';
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `sales`;
DROP TABLE IF EXISTS `products`;
DROP TABLE IF EXISTS `customers`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `products` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `stock_quantity` INT NOT NULL DEFAULT 0,
  `image` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `customers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `full_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(20) DEFAULT NULL,
  `created_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `full_name` VARCHAR(100) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `avatar` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `sales` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `product_id` INT NOT NULL,
  `customer_id` INT DEFAULT NULL,
  `sold_by` INT NOT NULL,
  `quantity` INT NOT NULL,
  `total_price` DECIMAL(10,2) NOT NULL,
  `created_at` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_product_id_index` (`product_id`),
  KEY `sales_customer_id_index` (`customer_id`),
  KEY `sales_sold_by_index` (`sold_by`),
  CONSTRAINT `sales_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  CONSTRAINT `sales_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  CONSTRAINT `sales_sold_by_foreign` FOREIGN KEY (`sold_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `products` (`name`, `price`, `stock_quantity`, `image`, `created_at`) VALUES
('Wireless Barcode Scanner', 1899.00, 18, NULL, '2026-10-01 08:00:00'),
('Thermal Receipt Paper 10-Pack', 349.00, 44, NULL, '2026-10-01 08:10:00'),
('USB Cash Drawer', 2450.00, 9, NULL, '2026-10-01 08:20:00'),
('Countertop Card Reader Stand', 790.00, 15, NULL, '2026-10-01 08:30:00'),
('Inventory Label Roll', 225.00, 36, NULL, '2026-10-01 08:40:00'),
('Compact Thermal Printer', 3299.00, 7, NULL, '2026-10-01 08:50:00');

INSERT INTO `customers` (`full_name`, `email`, `phone`, `created_at`) VALUES
('Alyssa Santos', 'alyssa.santos@example.com', '0917 248 3106', '2026-10-01 09:00:00'),
('Daniel Reyes', 'daniel.reyes@example.com', '0928 517 4420', '2026-10-01 09:15:00'),
('Mikaela Cruz', 'mikaela.cruz@example.com', '0995 630 1184', '2026-10-01 09:30:00'),
('Paolo Mendoza', 'paolo.mendoza@example.com', '0918 761 9052', '2026-10-01 09:45:00'),
('Trisha Lim', 'trisha.lim@example.com', '0906 482 7731', '2026-10-01 10:00:00'),
('Gabriel Torres', 'gabriel.torres@example.com', '0927 194 6685', '2026-10-01 10:15:00');

-- Every sample staff account uses the demo password Northstar123!.
-- Only its password_hash() result is stored.
INSERT INTO `users` (`username`, `full_name`, `password`, `avatar`, `created_at`) VALUES
('admin.marc', 'Marco De Leon', '$2y$10$ViIdqAFPcoyvDX.oJaDraOIfozkI8QYEQ85KUVK9GdK37WKWoycUu', NULL, '2026-10-01 08:00:00'),
('cashier.ana', 'Ana Villanueva', '$2y$10$ViIdqAFPcoyvDX.oJaDraOIfozkI8QYEQ85KUVK9GdK37WKWoycUu', NULL, '2026-10-01 08:15:00'),
('cashier.joel', 'Joel Garcia', '$2y$10$ViIdqAFPcoyvDX.oJaDraOIfozkI8QYEQ85KUVK9GdK37WKWoycUu', NULL, '2026-10-01 08:30:00'),
('stock.ella', 'Ella Navarro', '$2y$10$ViIdqAFPcoyvDX.oJaDraOIfozkI8QYEQ85KUVK9GdK37WKWoycUu', NULL, '2026-10-01 08:45:00'),
('manager.luis', 'Luis Ramos', '$2y$10$ViIdqAFPcoyvDX.oJaDraOIfozkI8QYEQ85KUVK9GdK37WKWoycUu', NULL, '2026-10-01 09:00:00'),
('support.nica', 'Nica Flores', '$2y$10$ViIdqAFPcoyvDX.oJaDraOIfozkI8QYEQ85KUVK9GdK37WKWoycUu', NULL, '2026-10-01 09:15:00');

INSERT INTO `sales` (`product_id`, `customer_id`, `sold_by`, `quantity`, `total_price`, `created_at`) VALUES
(2, 1, 2, 2, 698.00, '2026-10-08 09:10:00'),
(1, 3, 1, 1, 1899.00, '2026-10-08 10:25:00'),
(5, NULL, 2, 4, 900.00, '2026-10-08 13:40:00'),
(4, 5, 3, 1, 790.00, '2026-10-08 15:05:00');

SET FOREIGN_KEY_CHECKS = 1;
