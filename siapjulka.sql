-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Okt 2021 pada 02.30
-- Versi server: 10.4.21-MariaDB
-- Versi PHP: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `siapjulka`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensis`
--

CREATE TABLE `absensis` (
  `id_absensi` bigint(20) UNSIGNED NOT NULL,
  `id_pertemuan` bigint(20) UNSIGNED DEFAULT NULL,
  `id_seksi` bigint(20) UNSIGNED DEFAULT NULL,
  `id_user` bigint(20) UNSIGNED DEFAULT NULL,
  `imei_absensi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qrcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qrcode_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verifikasi` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `admins`
--

CREATE TABLE `admins` (
  `kode_admin` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nama_admin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip_admin` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `admins`
--

INSERT INTO `admins` (`kode_admin`, `user_id`, `nama_admin`, `nip_admin`, `created_at`, `updated_at`) VALUES
('5335', 1, 'Delsina Faiza, S.t.,M.t.', '198304132009122002', '2021-10-18 21:07:10', '2021-10-18 21:07:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dosens`
--

CREATE TABLE `dosens` (
  `kode_dosen` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nama_dosen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip_dosen` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `dosens`
--

INSERT INTO `dosens` (`kode_dosen`, `user_id`, `nama_dosen`, `nip_dosen`, `created_at`, `updated_at`) VALUES
('5318', 2, 'Drs. Denny Kurniadi, M.Kom', '196306061989031001', '2021-10-18 21:10:09', '2021-10-18 21:10:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `grups`
--

CREATE TABLE `grups` (
  `kode_grup` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_grup` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusans`
--

CREATE TABLE `jurusans` (
  `kode_jurusan` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_jurusan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jurusans`
--

INSERT INTO `jurusans` (`kode_jurusan`, `nama_jurusan`, `status`, `created_at`, `updated_at`) VALUES
('D3-PTE', 'D3 Teknik Elektronika', 1, '2021-10-18 21:11:51', '2021-10-18 21:11:51'),
('S1-PTE', 'Pendidikan Teknik Elektronika', 1, '2021-10-18 21:11:33', '2021-10-18 21:11:33'),
('S1-PTIK', 'Pendidikan Teknik Informatika dan Komputer', 1, '2021-10-18 21:11:13', '2021-10-18 21:11:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswas`
--

CREATE TABLE `mahasiswas` (
  `nim` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tahun` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nama_mahasiswa` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_jurusan` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_grup` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `imei_mahasiswa` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `mahasiswas`
--

INSERT INTO `mahasiswas` (`nim`, `tahun`, `user_id`, `nama_mahasiswa`, `kode_jurusan`, `kode_grup`, `imei_mahasiswa`, `created_at`, `updated_at`) VALUES
('16076040', '2016', 3, 'AHMAD IMAM', 'S1-PTIK', NULL, NULL, '2021-10-18 21:12:20', '2021-10-18 21:12:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `matakuliahs`
--

CREATE TABLE `matakuliahs` (
  `kode_mk` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_mk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_jurusan` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sks` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `matakuliahs`
--

INSERT INTO `matakuliahs` (`kode_mk`, `nama_mk`, `kode_jurusan`, `sks`, `status`, `created_at`, `updated_at`) VALUES
('TIK111', 'Praktikum Algoritma dan Struktur Data', 'S1-PTIK', '2', 1, '2021-10-18 21:13:07', '2021-10-18 21:13:14'),
('TIK166', 'Bahasa Inggris Teknik', 'S1-PTIK', '2', 1, '2021-10-18 21:13:39', '2021-10-18 21:13:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(55, '2014_10_12_000000_create_users_table', 1),
(56, '2014_10_12_100000_create_password_resets_table', 1),
(57, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(58, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(59, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(60, '2016_06_01_000004_create_oauth_clients_table', 1),
(61, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(62, '2021_03_06_084012_create_dosens_table', 1),
(63, '2021_03_13_000230_create_admins_table', 1),
(64, '2021_04_09_152332_create_jurusans_table', 1),
(65, '2021_04_09_153426_create_grups_table', 1),
(66, '2021_04_09_153531_create_mahasiswas_table', 1),
(67, '2021_04_11_003527_create_matakuliahs_table', 1),
(68, '2021_04_11_005414_create_ruangs_table', 1),
(69, '2021_04_11_005623_create_seksis_table', 1),
(70, '2021_04_11_005625_create_pertemuans_table', 1),
(71, '2021_06_23_030536_create_participants_table', 1),
(72, '2021_07_05_020747_create_absensis_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `participants`
--

CREATE TABLE `participants` (
  `id_participant` bigint(20) UNSIGNED NOT NULL,
  `id_seksi` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `imei_participant` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `participants`
--

INSERT INTO `participants` (`id_participant`, `id_seksi`, `user_id`, `imei_participant`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 1, 3, NULL, 1, '2021-10-18 23:20:25', '2021-10-18 23:20:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pertemuans`
--

CREATE TABLE `pertemuans` (
  `id_pertemuan` bigint(20) UNSIGNED NOT NULL,
  `id_seksi` bigint(20) UNSIGNED DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `materi` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruangs`
--

CREATE TABLE `ruangs` (
  `kode_ruang` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_ruang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ruangs`
--

INSERT INTO `ruangs` (`kode_ruang`, `nama_ruang`, `status`, `created_at`, `updated_at`) VALUES
('FTK02101', 'Ruang Kuliah Teater (E30)', 1, '2021-10-18 21:14:02', '2021-10-18 21:14:02'),
('FTK04123', 'Lab. Pemograman Multimedia (E60K)', 1, '2021-10-18 21:14:19', '2021-10-18 21:14:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `seksis`
--

CREATE TABLE `seksis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_seksi` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_jurusan` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_mk` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_dosen` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kode_ruang` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hari` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jadwal_mulai` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jadwal_selesai` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `seksis`
--

INSERT INTO `seksis` (`id`, `kode_seksi`, `token`, `kode_jurusan`, `kode_mk`, `kode_dosen`, `kode_ruang`, `hari`, `jadwal_mulai`, `jadwal_selesai`, `status`, `created_at`, `updated_at`) VALUES
(1, '202110760001', 'gOaeAd', 'S1-PTIK', 'TIK111', '5318', 'FTK02101', 'Senin', '07:00', '08:50', 1, '2021-10-18 21:14:53', '2021-10-18 21:14:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `level` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imei` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `nama`, `jk`, `email_verified_at`, `password`, `status`, `level`, `avatar`, `imei`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '5335', 'Delsina Faiza, S.t.,M.t.', 'Perempuan', NULL, '$2y$10$MKzXvH2bqCKBwbQ1LzKMDO8NKmhKbzlfmfIxtZ8GfjL35xnCr7YQq', 1, 'admin', 'default.jpg', NULL, NULL, '2021-10-18 21:07:10', '2021-10-18 21:07:10'),
(2, '5318', 'Drs. Denny Kurniadi, M.Kom', 'Laki-laki', NULL, '$2y$10$11g5fLqm9g4uWMgGerp4ke2vbg4KUhqMDLwPYHff1SGQI6RYakxAW', 1, 'dosen', 'default.jpg', NULL, NULL, '2021-10-18 21:10:09', '2021-10-18 21:10:09'),
(3, '16076040', 'AHMAD IMAM', 'Laki-laki', NULL, '$2y$10$LCcJuIvA1S9YREl1FDh.X.lC8K0HK47F4jHDg6FhQfWRhxttGbmJC', 1, 'mahasiswa', 'default.jpg', NULL, NULL, '2021-10-18 21:12:20', '2021-10-18 21:12:20');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensis`
--
ALTER TABLE `absensis`
  ADD PRIMARY KEY (`id_absensi`),
  ADD UNIQUE KEY `absensis_imei_absensi_unique` (`imei_absensi`),
  ADD KEY `absensis_id_pertemuan_foreign` (`id_pertemuan`),
  ADD KEY `absensis_id_seksi_foreign` (`id_seksi`),
  ADD KEY `absensis_id_user_foreign` (`id_user`);

--
-- Indeks untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`kode_admin`),
  ADD KEY `admins_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `dosens`
--
ALTER TABLE `dosens`
  ADD PRIMARY KEY (`kode_dosen`),
  ADD KEY `dosens_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `grups`
--
ALTER TABLE `grups`
  ADD PRIMARY KEY (`kode_grup`);

--
-- Indeks untuk tabel `jurusans`
--
ALTER TABLE `jurusans`
  ADD PRIMARY KEY (`kode_jurusan`);

--
-- Indeks untuk tabel `mahasiswas`
--
ALTER TABLE `mahasiswas`
  ADD PRIMARY KEY (`nim`),
  ADD UNIQUE KEY `mahasiswas_imei_mahasiswa_unique` (`imei_mahasiswa`),
  ADD KEY `mahasiswas_user_id_foreign` (`user_id`),
  ADD KEY `mahasiswas_kode_jurusan_foreign` (`kode_jurusan`),
  ADD KEY `mahasiswas_kode_grup_foreign` (`kode_grup`);

--
-- Indeks untuk tabel `matakuliahs`
--
ALTER TABLE `matakuliahs`
  ADD PRIMARY KEY (`kode_mk`),
  ADD KEY `matakuliahs_kode_jurusan_foreign` (`kode_jurusan`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indeks untuk tabel `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indeks untuk tabel `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indeks untuk tabel `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indeks untuk tabel `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id_participant`),
  ADD KEY `participants_id_seksi_foreign` (`id_seksi`),
  ADD KEY `participants_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `pertemuans`
--
ALTER TABLE `pertemuans`
  ADD PRIMARY KEY (`id_pertemuan`),
  ADD KEY `pertemuans_id_seksi_foreign` (`id_seksi`);

--
-- Indeks untuk tabel `ruangs`
--
ALTER TABLE `ruangs`
  ADD PRIMARY KEY (`kode_ruang`);

--
-- Indeks untuk tabel `seksis`
--
ALTER TABLE `seksis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `seksis_kode_seksi_unique` (`kode_seksi`),
  ADD KEY `seksis_kode_jurusan_foreign` (`kode_jurusan`),
  ADD KEY `seksis_kode_mk_foreign` (`kode_mk`),
  ADD KEY `seksis_kode_dosen_foreign` (`kode_dosen`),
  ADD KEY `seksis_kode_ruang_foreign` (`kode_ruang`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_imei_unique` (`imei`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensis`
--
ALTER TABLE `absensis`
  MODIFY `id_absensi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT untuk tabel `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `participants`
--
ALTER TABLE `participants`
  MODIFY `id_participant` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pertemuans`
--
ALTER TABLE `pertemuans`
  MODIFY `id_pertemuan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `seksis`
--
ALTER TABLE `seksis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensis`
--
ALTER TABLE `absensis`
  ADD CONSTRAINT `absensis_id_pertemuan_foreign` FOREIGN KEY (`id_pertemuan`) REFERENCES `pertemuans` (`id_pertemuan`) ON DELETE CASCADE,
  ADD CONSTRAINT `absensis_id_seksi_foreign` FOREIGN KEY (`id_seksi`) REFERENCES `seksis` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `absensis_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `dosens`
--
ALTER TABLE `dosens`
  ADD CONSTRAINT `dosens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `mahasiswas`
--
ALTER TABLE `mahasiswas`
  ADD CONSTRAINT `mahasiswas_kode_grup_foreign` FOREIGN KEY (`kode_grup`) REFERENCES `grups` (`kode_grup`) ON DELETE CASCADE,
  ADD CONSTRAINT `mahasiswas_kode_jurusan_foreign` FOREIGN KEY (`kode_jurusan`) REFERENCES `jurusans` (`kode_jurusan`) ON DELETE CASCADE,
  ADD CONSTRAINT `mahasiswas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `matakuliahs`
--
ALTER TABLE `matakuliahs`
  ADD CONSTRAINT `matakuliahs_kode_jurusan_foreign` FOREIGN KEY (`kode_jurusan`) REFERENCES `jurusans` (`kode_jurusan`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `participants_id_seksi_foreign` FOREIGN KEY (`id_seksi`) REFERENCES `seksis` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `participants_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pertemuans`
--
ALTER TABLE `pertemuans`
  ADD CONSTRAINT `pertemuans_id_seksi_foreign` FOREIGN KEY (`id_seksi`) REFERENCES `seksis` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `seksis`
--
ALTER TABLE `seksis`
  ADD CONSTRAINT `seksis_kode_dosen_foreign` FOREIGN KEY (`kode_dosen`) REFERENCES `dosens` (`kode_dosen`) ON DELETE CASCADE,
  ADD CONSTRAINT `seksis_kode_jurusan_foreign` FOREIGN KEY (`kode_jurusan`) REFERENCES `jurusans` (`kode_jurusan`) ON DELETE CASCADE,
  ADD CONSTRAINT `seksis_kode_mk_foreign` FOREIGN KEY (`kode_mk`) REFERENCES `matakuliahs` (`kode_mk`) ON DELETE CASCADE,
  ADD CONSTRAINT `seksis_kode_ruang_foreign` FOREIGN KEY (`kode_ruang`) REFERENCES `ruangs` (`kode_ruang`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
