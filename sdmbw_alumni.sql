-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2026 at 06:35 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sdmbw_alumni`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_logs`
--

CREATE TABLE `admin_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `admin_id` bigint UNSIGNED NOT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `target_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `target_id` bigint UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_logs`
--

INSERT INTO `admin_logs` (`id`, `admin_id`, `action`, `target_type`, `target_id`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'verify_alumni', 'alumni', 1, 'Mengubah status verifikasi Tono Sutanto ke verified', '2026-02-16 17:14:30', '2026-02-16 17:14:30');

-- --------------------------------------------------------

--
-- Table structure for table `alumni`
--

CREATE TABLE `alumni` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `nisn` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `angkatan_id` bigint UNSIGNED NOT NULL,
  `tahun_lulus` year NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `no_hp` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `show_no_hp` tinyint NOT NULL DEFAULT '0',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harapan` text COLLATE utf8mb4_unicode_ci,
  `status_verifikasi` enum('pending','verified','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `is_profile_complete` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alumni`
--

INSERT INTO `alumni` (`id`, `user_id`, `nisn`, `nama_lengkap`, `angkatan_id`, `tahun_lulus`, `alamat`, `no_hp`, `show_no_hp`, `email`, `harapan`, `status_verifikasi`, `is_profile_complete`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 2, '1234567890', 'Tono Sutanto', 1, '2017', 'wqerwetuterwter', '09878675689079', 1, 'Tono123@gmail.com', 'Semoga SDMBW Terus Maju Dan Menciptakan Generasi Hebat', 'verified', 1, '2026-02-16 17:11:22', '2026-02-17 05:48:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `alumni_fotos`
--

CREATE TABLE `alumni_fotos` (
  `id` bigint UNSIGNED NOT NULL,
  `alumni_id` bigint UNSIGNED NOT NULL,
  `path_file` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'profil',
  `deskripsi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_main` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alumni_fotos`
--

INSERT INTO `alumni_fotos` (`id`, `alumni_id`, `path_file`, `kategori`, `deskripsi`, `is_main`, `created_at`, `updated_at`) VALUES
(3, 1, 'foto_alumni/alumni_1_1771265424.jpg', 'profil', NULL, 1, '2026-02-16 18:10:24', '2026-02-16 18:10:24');

-- --------------------------------------------------------

--
-- Table structure for table `alumni_pekerjaan`
--

CREATE TABLE `alumni_pekerjaan` (
  `id` bigint UNSIGNED NOT NULL,
  `alumni_id` bigint UNSIGNED NOT NULL,
  `nama_perusahaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_current` tinyint NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `alumni_pendidikan`
--

CREATE TABLE `alumni_pendidikan` (
  `id` bigint UNSIGNED NOT NULL,
  `alumni_id` bigint UNSIGNED NOT NULL,
  `jenjang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'SMP/MTS, SMA/MA/SMK, Perguruan Tinggi',
  `nama_instansi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'Nama sekolah/kampus',
  `program_studi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Program studi / Jurusan (khusus Perguruan Tinggi)',
  `tahun_masuk` year DEFAULT NULL,
  `tahun_lulus` year DEFAULT NULL,
  `is_ongoing` tinyint NOT NULL DEFAULT '0' COMMENT '1 = masih belajar, 0 = sudah lulus',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `alumni_pendidikan`
--

INSERT INTO `alumni_pendidikan` (`id`, `alumni_id`, `jenjang`, `nama_instansi`, `program_studi`, `tahun_masuk`, `tahun_lulus`, `is_ongoing`, `created_at`, `updated_at`) VALUES
(16, 1, 'SMP/MTS', 'SMPN 01 MAJU', NULL, '2017', '2020', 0, '2026-02-17 05:48:49', '2026-02-17 05:48:49'),
(17, 1, 'SMA/MA/SMK', 'SMAN 01 MAJU', NULL, '2020', '2023', 0, '2026-02-17 05:48:49', '2026-02-17 05:48:49'),
(18, 1, 'Perguruan Tinggi', 'Universitas Muria Kudus', 'Teknik Elektro', '2023', NULL, 1, '2026-02-17 05:48:49', '2026-02-17 05:48:49');

-- --------------------------------------------------------

--
-- Table structure for table `angkatan`
--

CREATE TABLE `angkatan` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_angkatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun_ajaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('AKTIF','LULUS') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'AKTIF',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `angkatan`
--

INSERT INTO `angkatan` (`id`, `nama_angkatan`, `tahun_ajaran`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Angkatan 1', '2016-2017', 'LULUS', '2026-02-16 16:57:27', '2026-02-16 16:57:27'),
(2, 'Angkatan 2', '2017-2018', 'LULUS', '2026-02-16 16:57:27', '2026-02-16 16:57:27'),
(3, 'Angkatan 3', '2018-2019', 'LULUS', '2026-02-16 16:57:27', '2026-02-16 16:57:27'),
(4, 'Angkatan 4', '2019-2020', 'LULUS', '2026-02-16 16:57:27', '2026-02-16 16:57:27'),
(5, 'Angkatan 5', '2020-2021', 'LULUS', '2026-02-16 16:57:27', '2026-02-16 16:57:27'),
(6, 'Angkatan 6', '2021-2022', 'LULUS', '2026-02-16 16:57:27', '2026-02-16 16:57:27'),
(7, 'Angkatan 7', '2022-2023', 'LULUS', '2026-02-16 16:57:27', '2026-02-16 16:57:27'),
(8, 'Angkatan 8', '2023-2024', 'LULUS', '2026-02-16 16:57:27', '2026-02-16 16:57:27'),
(9, 'Angkatan 9', '2024-2025', 'LULUS', '2026-02-16 16:57:27', '2026-02-16 16:57:27'),
(10, 'Angkatan 10', '2025-2026', 'AKTIF', '2026-02-16 16:57:27', '2026-02-16 16:57:27');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '2026_01_21_141507_create_angkatan_table', 1),
(4, '2026_01_21_141527_create_alumni_table', 1),
(5, '2026_01_21_141542_create_admin_logs_table', 1),
(6, '2026_01_24_220816_add_aktif_to_angkatan_status_enum', 1),
(7, '2026_01_26_061250_change_belum_lulus_to_aktif_in_angkatan', 1),
(8, '2026_01_26_062551_reset_angkatan_ids', 1),
(9, '2026_02_04_230953_create_alumni_pendidikan_table', 1),
(10, '2026_02_04_231141_create_alumni_fotos_table', 1),
(11, '2026_02_05_092039_add_program_studi_to_alumni_pendidikan_table', 1),
(12, '2026_02_07_164618_add_no_wa_and_show_columns_to_alumni_table', 1),
(13, '2026_02_07_172837_create_alumni_pekerjaan_table', 1),
(14, '2026_02_08_000125_drop_no_wa_and_show_no_wa_from_alumni_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('odkqKrOHXUiEyPQcwzC5ASdDb60NyHcdCpD3fORJ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQlUxakhmT2xpaHpUOHY4RjVQNXdkTUhVNjZEZjg0RmhWbkJzemVQZCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czoxMzoibGFuZGluZy5pbmRleCI7fX0=', 1771307403);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nisn` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','alumni') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'alumni',
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `last_login_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nisn`, `role`, `is_active`, `last_login_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'adminalumnibw', '$2y$12$9/9HLmx1Kh0BkOVjUGMSaeLxLwRjcRWXMfQpB4G8kaEid3CXVha7W', '0000000000', 'admin', 1, '2026-02-17 05:49:16', NULL, '2026-02-16 16:57:38', '2026-02-17 05:49:16'),
(2, 'tono', '$2y$12$TvENqpBjNADNbqHy32rkKuwqWEVXtj4d8.gH2bfQnasqt6LDGbkxq', '1234567890', 'alumni', 1, '2026-02-17 01:46:53', NULL, '2026-02-16 17:11:22', '2026-02-17 01:46:53');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin_logs_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `alumni`
--
ALTER TABLE `alumni`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alumni_nisn_unique` (`nisn`),
  ADD KEY `alumni_user_id_foreign` (`user_id`),
  ADD KEY `alumni_angkatan_id_foreign` (`angkatan_id`);

--
-- Indexes for table `alumni_fotos`
--
ALTER TABLE `alumni_fotos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumni_fotos_alumni_id_index` (`alumni_id`),
  ADD KEY `alumni_fotos_is_main_index` (`is_main`),
  ADD KEY `alumni_fotos_kategori_index` (`kategori`);

--
-- Indexes for table `alumni_pekerjaan`
--
ALTER TABLE `alumni_pekerjaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumni_pekerjaan_alumni_id_foreign` (`alumni_id`);

--
-- Indexes for table `alumni_pendidikan`
--
ALTER TABLE `alumni_pendidikan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alumni_pendidikan_alumni_id_foreign` (`alumni_id`);

--
-- Indexes for table `angkatan`
--
ALTER TABLE `angkatan`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`username`);

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
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_nisn_unique` (`nisn`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_logs`
--
ALTER TABLE `admin_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `alumni`
--
ALTER TABLE `alumni`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `alumni_fotos`
--
ALTER TABLE `alumni_fotos`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `alumni_pekerjaan`
--
ALTER TABLE `alumni_pekerjaan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `alumni_pendidikan`
--
ALTER TABLE `alumni_pendidikan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `angkatan`
--
ALTER TABLE `angkatan`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD CONSTRAINT `admin_logs_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `alumni`
--
ALTER TABLE `alumni`
  ADD CONSTRAINT `alumni_angkatan_id_foreign` FOREIGN KEY (`angkatan_id`) REFERENCES `angkatan` (`id`) ON DELETE RESTRICT,
  ADD CONSTRAINT `alumni_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `alumni_fotos`
--
ALTER TABLE `alumni_fotos`
  ADD CONSTRAINT `alumni_fotos_alumni_id_foreign` FOREIGN KEY (`alumni_id`) REFERENCES `alumni` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `alumni_pekerjaan`
--
ALTER TABLE `alumni_pekerjaan`
  ADD CONSTRAINT `alumni_pekerjaan_alumni_id_foreign` FOREIGN KEY (`alumni_id`) REFERENCES `alumni` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `alumni_pendidikan`
--
ALTER TABLE `alumni_pendidikan`
  ADD CONSTRAINT `alumni_pendidikan_alumni_id_foreign` FOREIGN KEY (`alumni_id`) REFERENCES `alumni` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
