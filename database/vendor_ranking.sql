-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Apr 2025 pada 03.51
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vendor_ranking`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Handi', 'admin@example.com', '$2y$12$Fo/EDhOBTv.qDlfOdESu6Oqw5g4E.tl6sfdv969uV947W.rhFq4ei', '2025-04-06 04:37:59', '2025-04-06 04:37:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `contracts`
--

CREATE TABLE `contracts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `evaluations`
--

CREATE TABLE `evaluations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `pesan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `message`
--

INSERT INTO `message` (`id`, `nama`, `email`, `pesan`, `created_at`, `updated_at`) VALUES
(1, 'Handi', 'handiyudha801@gmail.com', 'p', '2025-04-09 05:35:09', '2025-04-09 05:35:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2025_02_25_055342_create_vendors_table', 1),
(6, '2025_02_25_055411_create_contracts_table', 1),
(7, '2025_02_25_055421_create_evaluations_table', 1),
(8, '2025_03_30_060959_create_admins_table', 1),
(9, '2025_04_06_115113_create_tb_kriteria_table', 2),
(10, '2025_04_06_121853_create_rel_kriteria_table', 3),
(11, '2025_04_07_054047_create_nilai_alternatif_table', 4),
(12, '2025_04_07_115209_add_columns_to_vendors_table', 5),
(13, '2025_04_09_121848_add_timestamps_to_contact_table', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_alternatif`
--

CREATE TABLE `nilai_alternatif` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tahun` year(4) NOT NULL,
  `kode_alternatif` varchar(256) DEFAULT NULL,
  `kode_kriteria` varchar(16) DEFAULT NULL,
  `nilai` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `nilai_alternatif`
--

INSERT INTO `nilai_alternatif` (`id`, `tahun`, `kode_alternatif`, `kode_kriteria`, `nilai`, `created_at`, `updated_at`) VALUES
(1, '2025', 'Braga Trading Company', 'P1', 93, '2025-04-07 00:24:12', '2025-04-08 06:01:10'),
(2, '2025', 'GETINGE SOUTH EAST ASIA PTE LTD', 'P1', 77.6, '2025-04-07 00:24:12', '2025-04-07 00:24:12'),
(3, '2025', 'Java TNC', 'P1', 91, '2025-04-07 00:24:12', '2025-04-07 00:24:12'),
(4, '2025', 'Braga Trading Company', 'P2', 47, '2025-04-07 00:24:12', '2025-04-08 06:01:10'),
(5, '2025', 'GETINGE SOUTH EAST ASIA PTE LTD', 'P2', 52, '2025-04-07 00:24:12', '2025-04-07 00:24:12'),
(6, '2025', 'Java TNC', 'P2', 49, '2025-04-07 00:24:12', '2025-04-07 00:24:12'),
(7, '2025', 'Braga Trading Company', 'P3', 100, '2025-04-07 00:24:12', '2025-04-08 06:01:10'),
(8, '2025', 'GETINGE SOUTH EAST ASIA PTE LTD', 'P3', 74, '2025-04-07 00:24:12', '2025-04-07 00:24:12'),
(9, '2025', 'Java TNC', 'P3', 88, '2025-04-07 00:24:12', '2025-04-07 00:24:12'),
(10, '2025', 'Braga Trading Company', 'P4', 50, '2025-04-07 00:24:12', '2025-04-08 06:01:10'),
(11, '2025', 'GETINGE SOUTH EAST ASIA PTE LTD', 'P4', 70, '2025-04-07 00:24:12', '2025-04-07 00:24:12'),
(12, '2025', 'Java TNC', 'P4', 60, '2025-04-07 00:24:12', '2025-04-07 00:24:12'),
(13, '2025', 'Braga Trading Company', 'P5', 83.2, '2025-04-07 00:24:12', '2025-04-08 06:01:10'),
(14, '2025', 'GETINGE SOUTH EAST ASIA PTE LTD', 'P5', 88, '2025-04-07 00:24:12', '2025-04-07 00:24:12'),
(15, '2025', 'Java TNC', 'P5', 91.3, '2025-04-07 00:24:12', '2025-04-07 00:24:12'),
(16, '2025', 'Braga Trading Company', 'P6', 79, '2025-04-07 00:24:12', '2025-04-08 06:01:10'),
(17, '2025', 'GETINGE SOUTH EAST ASIA PTE LTD', 'P6', 81.5, '2025-04-07 00:24:12', '2025-04-07 00:24:12'),
(18, '2025', 'Java TNC', 'P6', 77.3, '2025-04-07 00:24:12', '2025-04-07 00:24:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rel_kriteria`
--

CREATE TABLE `rel_kriteria` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tahun` year(4) DEFAULT NULL,
  `ID1` varchar(16) DEFAULT NULL,
  `ID2` varchar(16) DEFAULT NULL,
  `nilai` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `rel_kriteria`
--

INSERT INTO `rel_kriteria` (`id`, `tahun`, `ID1`, `ID2`, `nilai`, `created_at`, `updated_at`) VALUES
(1, '2025', 'P1', 'P1', 1, NULL, NULL),
(2, '2025', 'P1', 'P2', 3, NULL, '2025-04-22 17:54:06'),
(3, '2025', 'P1', 'P3', 5, NULL, '2025-04-22 17:53:00'),
(4, '2025', 'P1', 'P4', 7, NULL, '2025-04-22 17:53:09'),
(5, '2025', 'P1', 'P5', 3, NULL, '2025-04-22 17:53:16'),
(6, '2025', 'P1', 'P6', 7, NULL, '2025-04-22 17:53:28'),
(7, '2025', 'P2', 'P1', 0.3333, NULL, '2025-04-22 17:54:06'),
(8, '2025', 'P2', 'P2', 1, NULL, NULL),
(9, '2025', 'P2', 'P3', 3, NULL, '2025-04-22 17:53:40'),
(10, '2025', 'P2', 'P4', 5, NULL, '2025-04-22 17:53:50'),
(11, '2025', 'P2', 'P5', 7, NULL, '2025-04-22 17:54:17'),
(12, '2025', 'P2', 'P6', 7, NULL, '2025-04-22 17:54:28'),
(13, '2025', 'P3', 'P1', 0.2, NULL, '2025-04-22 17:53:00'),
(14, '2025', 'P3', 'P2', 0.3333, NULL, '2025-04-22 17:53:40'),
(15, '2025', 'P3', 'P3', 1, NULL, NULL),
(16, '2025', 'P3', 'P4', 5, NULL, '2025-04-22 17:54:41'),
(17, '2025', 'P3', 'P5', 3, NULL, '2025-04-22 17:54:52'),
(18, '2025', 'P3', 'P6', 3, NULL, '2025-04-22 17:55:37'),
(19, '2025', 'P4', 'P1', 0.1429, NULL, '2025-04-22 17:53:09'),
(20, '2025', 'P4', 'P2', 0.2, NULL, '2025-04-22 17:53:50'),
(21, '2025', 'P4', 'P3', 0.2, NULL, '2025-04-22 17:54:41'),
(22, '2025', 'P4', 'P4', 1, NULL, NULL),
(23, '2025', 'P4', 'P5', 3, NULL, '2025-04-22 17:55:58'),
(24, '2025', 'P4', 'P6', 3, NULL, '2025-04-22 17:56:10'),
(25, '2025', 'P5', 'P1', 0.3333, NULL, '2025-04-22 17:53:16'),
(26, '2025', 'P5', 'P2', 0.1429, NULL, '2025-04-22 17:54:17'),
(27, '2025', 'P5', 'P3', 0.3333, NULL, '2025-04-22 17:54:52'),
(28, '2025', 'P5', 'P4', 0.3333, NULL, '2025-04-22 17:55:58'),
(29, '2025', 'P5', 'P5', 1, NULL, NULL),
(30, '2025', 'P5', 'P6', 5, NULL, '2025-04-22 17:56:23'),
(31, '2025', 'P6', 'P1', 0.1429, NULL, '2025-04-22 17:53:28'),
(32, '2025', 'P6', 'P2', 0.1429, NULL, '2025-04-22 17:54:28'),
(33, '2025', 'P6', 'P3', 0.3333, NULL, '2025-04-22 17:55:37'),
(34, '2025', 'P6', 'P4', 0.3333, NULL, '2025-04-22 17:56:10'),
(35, '2025', 'P6', 'P5', 0.2, NULL, '2025-04-22 17:56:23'),
(36, '2025', 'P6', 'P6', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kriteria`
--

CREATE TABLE `tb_kriteria` (
  `kode_kriteria` varchar(16) NOT NULL,
  `tahun` year(4) NOT NULL,
  `nama_kriteria` varchar(256) NOT NULL,
  `atribut` varchar(256) NOT NULL DEFAULT 'benefit',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tb_kriteria`
--

INSERT INTO `tb_kriteria` (`kode_kriteria`, `tahun`, `nama_kriteria`, `atribut`, `created_at`, `updated_at`) VALUES
('P1', '2025', 'Quality', 'benefit', '2025-04-06 05:14:06', '2025-04-06 05:14:06'),
('P2', '2025', 'Quantity', 'cost', '2025-04-06 05:14:06', '2025-04-06 05:14:06'),
('P3', '2025', 'Cost Saving', 'cost', '2025-04-06 05:14:06', '2025-04-06 05:14:06'),
('P4', '2025', 'Layanan Rekanan', 'benefit', '2025-04-06 05:14:06', '2025-04-06 05:14:06'),
('P5', '2025', 'Delivery', 'benefit', '2025-04-06 05:14:06', '2025-04-06 05:14:06'),
('P6', '2025', 'Lainnya', 'benefit', '2025-04-06 05:14:06', '2025-04-06 05:14:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `vendors`
--

CREATE TABLE `vendors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `background_vendor` text DEFAULT NULL,
  `No_HP` varchar(13) DEFAULT NULL,
  `nilai_akhir` decimal(8,4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `vendors`
--

INSERT INTO `vendors` (`id`, `username`, `password`, `background_vendor`, `No_HP`, `nilai_akhir`, `created_at`, `updated_at`) VALUES
(1, 'Braga Trading Company', '$2y$12$lOuyr8XyEG5WZsEOAOazru3YsrdJQsmjQfbtT69XLSyyYEbdz00MG', 'Lorem ipsum', '0895634693013', 31.0350, '2025-04-07 05:55:37', '2025-04-09 04:47:13'),
(2, 'GETINGE SOUTH EAST ASIA PTE LTD', '$2y$12$sAyZjdfxEhXznkky8AnRKOF5SCBKGGKXu2UP9Ni4WSI41kMXwsIZS', NULL, NULL, 68.5236, '2025-04-07 05:55:37', '2025-04-07 05:55:40'),
(3, 'Java TNC', '$2y$12$tP0rx.lkYAjqfrTWHDXzZeX2l99z5XKVEEV8aCc5Y7m83wIIRe3nC', NULL, NULL, 54.3497, '2025-04-07 05:55:37', '2025-04-07 05:55:40');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indeks untuk tabel `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `evaluations`
--
ALTER TABLE `evaluations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `nilai_alternatif`
--
ALTER TABLE `nilai_alternatif`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `rel_kriteria`
--
ALTER TABLE `rel_kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_kriteria`
--
ALTER TABLE `tb_kriteria`
  ADD PRIMARY KEY (`kode_kriteria`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indeks untuk tabel `vendors`
--
ALTER TABLE `vendors`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `contracts`
--
ALTER TABLE `contracts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `evaluations`
--
ALTER TABLE `evaluations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `message`
--
ALTER TABLE `message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `nilai_alternatif`
--
ALTER TABLE `nilai_alternatif`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rel_kriteria`
--
ALTER TABLE `rel_kriteria`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `vendors`
--
ALTER TABLE `vendors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
