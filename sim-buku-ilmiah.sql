-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2024 at 08:46 AM
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
-- Database: `sim-buku-ilmiah`
--

-- --------------------------------------------------------

--
-- Table structure for table `babs`
--

CREATE TABLE `babs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(200) DEFAULT NULL,
  `catatan` varchar(200) DEFAULT NULL,
  `file_bab` varchar(250) DEFAULT NULL,
  `file_revieu` varchar(250) DEFAULT NULL,
  `claim` varchar(250) DEFAULT NULL,
  `author_id` bigint(20) UNSIGNED DEFAULT NULL,
  `reviewer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `buku_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deadline` datetime DEFAULT NULL,
  `uploaded_at` datetime DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bukus`
--

CREATE TABLE `bukus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `judul` varchar(250) DEFAULT NULL,
  `template` varchar(250) DEFAULT NULL,
  `total_bab` varchar(7) DEFAULT NULL,
  `jenis_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `finalisasis`
--

CREATE TABLE `finalisasis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `buku_id` bigint(20) UNSIGNED DEFAULT NULL,
  `merge` varchar(250) DEFAULT NULL,
  `isbn` varchar(250) DEFAULT NULL,
  `cover` varchar(250) DEFAULT NULL,
  `final_file` varchar(250) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `historis`
--

CREATE TABLE `historis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `detail` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jenis`
--

CREATE TABLE `jenis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis`
--

INSERT INTO `jenis` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'Fiksi', '2024-08-07 07:01:05', '2024-08-07 07:01:05'),
(2, 'Non Fiksi', '2024-08-07 07:01:05', '2024-08-07 07:01:05');

-- --------------------------------------------------------

--
-- Table structure for table `katalogs`
--

CREATE TABLE `katalogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `final_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
(25, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(26, '2024_07_25_003510_create_users_table', 1),
(27, '2024_07_25_003514_create_statuses_table', 1),
(28, '2024_08_01_080453_create_jenis_table', 1),
(29, '2024_08_01_080624_create_bukus_table', 1),
(30, '2024_08_01_080900_create_finalisasis_table', 1),
(31, '2024_08_01_080913_create_produksis_table', 1),
(32, '2024_08_01_082054_create_notifikasis_table', 1),
(33, '2024_08_01_082319_create_historis_table', 1),
(34, '2024_08_01_083331_create_katalogs_table', 1),
(35, '2024_08_01_083344_create_royaltis_table', 1),
(36, '2024_08_01_085529_create_babs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifikasis`
--

CREATE TABLE `notifikasis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `data` text NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
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
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produksis`
--

CREATE TABLE `produksis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `final_id` bigint(20) UNSIGNED DEFAULT NULL,
  `eksemplar` varchar(20) DEFAULT NULL,
  `biaya_produksi` varchar(20) DEFAULT NULL,
  `harga_jual` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `royaltis`
--

CREATE TABLE `royaltis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `produksi_id` bigint(20) UNSIGNED DEFAULT NULL,
  `persentase` varchar(20) DEFAULT NULL,
  `total_royalti` varchar(20) DEFAULT NULL,
  `royalti_bab` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `option` varchar(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `option`, `created_at`, `updated_at`) VALUES
(1, 'Pending', '2024-08-07 07:01:05', '2024-08-07 07:01:05'),
(2, 'Available', '2024-08-07 07:01:05', '2024-08-07 07:01:05'),
(3, 'Approve', '2024-08-07 07:01:05', '2024-08-07 07:01:05'),
(4, 'Claimed', '2024-08-07 07:01:05', '2024-08-07 07:01:05'),
(5, 'Revisi', '2024-08-07 07:01:05', '2024-08-07 07:01:05'),
(6, 'Selected', '2024-08-07 07:01:05', '2024-08-07 07:01:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `contact` varchar(30) DEFAULT NULL,
  `user_role` enum('SUPER ADMIN','ADMIN','REVIEWER','AUTHOR') DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `contact`, `user_role`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Dio', 'admin@admin.com', '$2y$10$8ckHRyW1vlYrQP3e1/xll.VrV5/VC7acPO.lN/EB0Tg8G0soRnAt2', NULL, 'ADMIN', '2024-08-07 07:01:05', '2024-08-07 07:01:05'),
(2, NULL, 'Galang', 'reviewer@reviewer.com', '$2y$10$zrZ0ThtCY5hvONa9Zqmx9e8oteIdS8IfAxz01J4BKkxyX2QDjGYGq', NULL, 'REVIEWER', '2024-08-07 07:01:05', '2024-08-07 07:01:05'),
(3, NULL, 'Firmansyah', 'author@author.com', '$2y$10$gfwXN.hQkKhGXKhRLTMAo.sCdwhFZY1p4QI8dKYk4GHOgU1ZT9WFq', NULL, 'AUTHOR', '2024-08-07 07:01:05', '2024-08-07 07:01:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `babs`
--
ALTER TABLE `babs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `babs_author_id_foreign` (`author_id`),
  ADD KEY `babs_reviewer_id_foreign` (`reviewer_id`),
  ADD KEY `babs_buku_id_foreign` (`buku_id`),
  ADD KEY `babs_status_id_foreign` (`status_id`);

--
-- Indexes for table `bukus`
--
ALTER TABLE `bukus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bukus_jenis_id_foreign` (`jenis_id`);

--
-- Indexes for table `finalisasis`
--
ALTER TABLE `finalisasis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `finalisasis_buku_id_foreign` (`buku_id`);

--
-- Indexes for table `historis`
--
ALTER TABLE `historis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `katalogs`
--
ALTER TABLE `katalogs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `katalogs_final_id_foreign` (`final_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifikasis`
--
ALTER TABLE `notifikasis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifikasis_user_id_foreign` (`user_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `produksis`
--
ALTER TABLE `produksis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produksis_final_id_foreign` (`final_id`);

--
-- Indexes for table `royaltis`
--
ALTER TABLE `royaltis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `royaltis_produksi_id_foreign` (`produksi_id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `babs`
--
ALTER TABLE `babs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bukus`
--
ALTER TABLE `bukus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `finalisasis`
--
ALTER TABLE `finalisasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `historis`
--
ALTER TABLE `historis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jenis`
--
ALTER TABLE `jenis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `katalogs`
--
ALTER TABLE `katalogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `notifikasis`
--
ALTER TABLE `notifikasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produksis`
--
ALTER TABLE `produksis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `royaltis`
--
ALTER TABLE `royaltis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `babs`
--
ALTER TABLE `babs`
  ADD CONSTRAINT `babs_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `babs_buku_id_foreign` FOREIGN KEY (`buku_id`) REFERENCES `bukus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `babs_reviewer_id_foreign` FOREIGN KEY (`reviewer_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `babs_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `statuses` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `bukus`
--
ALTER TABLE `bukus`
  ADD CONSTRAINT `bukus_jenis_id_foreign` FOREIGN KEY (`jenis_id`) REFERENCES `jenis` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `finalisasis`
--
ALTER TABLE `finalisasis`
  ADD CONSTRAINT `finalisasis_buku_id_foreign` FOREIGN KEY (`buku_id`) REFERENCES `bukus` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `katalogs`
--
ALTER TABLE `katalogs`
  ADD CONSTRAINT `katalogs_final_id_foreign` FOREIGN KEY (`final_id`) REFERENCES `finalisasis` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `notifikasis`
--
ALTER TABLE `notifikasis`
  ADD CONSTRAINT `notifikasis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `produksis`
--
ALTER TABLE `produksis`
  ADD CONSTRAINT `produksis_final_id_foreign` FOREIGN KEY (`final_id`) REFERENCES `finalisasis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `royaltis`
--
ALTER TABLE `royaltis`
  ADD CONSTRAINT `royaltis_produksi_id_foreign` FOREIGN KEY (`produksi_id`) REFERENCES `produksis` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
