-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Jul 2019 pada 06.02
-- Versi server: 10.1.37-MariaDB
-- Versi PHP: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `atkmaa`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `atk_awal`
--

CREATE TABLE `atk_awal` (
  `id_atk_awal` int(5) NOT NULL,
  `id_gudang_brg` varchar(5) DEFAULT NULL,
  `id_barang` varchar(5) DEFAULT NULL,
  `pic` varchar(50) DEFAULT NULL,
  `jml` int(5) DEFAULT NULL,
  `harga` float DEFAULT NULL,
  `bulan` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `atk_awal`
--

INSERT INTO `atk_awal` (`id_atk_awal`, `id_gudang_brg`, `id_barang`, `pic`, `jml`, `harga`, `bulan`, `created_at`) VALUES
(1, 'GD001', 'BR001', 'KPNO', 50, 15000, '2019-08-19', '2019-07-19 03:26:10'),
(2, 'GD002', 'BR002', 'KCU', 100, 20000, '2019-08-19', '2019-07-19 03:26:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `atk_barang`
--

CREATE TABLE `atk_barang` (
  `id_barang` varchar(5) NOT NULL,
  `nm_barang` varchar(100) DEFAULT NULL,
  `id_satuan` varchar(5) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `atk_barang`
--

INSERT INTO `atk_barang` (`id_barang`, `nm_barang`, `id_satuan`, `created_at`) VALUES
('BR001', 'AMPLOP', 'ST001', NULL),
('BR002', 'FORM CIF', 'ST001', NULL),
('BR003', 'BUKTI TANDA', 'ST002', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `atk_gudang`
--

CREATE TABLE `atk_gudang` (
  `id_gudang_brg` varchar(5) NOT NULL,
  `id_barang` varchar(5) DEFAULT NULL,
  `pic` varchar(5) DEFAULT NULL,
  `jml` int(5) DEFAULT NULL,
  `harga` float DEFAULT NULL,
  `min` int(5) DEFAULT NULL,
  `max` int(5) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `atk_gudang`
--

INSERT INTO `atk_gudang` (`id_gudang_brg`, `id_barang`, `pic`, `jml`, `harga`, `min`, `max`, `created_at`) VALUES
('GD001', 'BR001', 'KPNO', 50, 15000, 10, 100, NULL),
('GD002', 'BR002', 'KCU', 200, 20000, 20, 200, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `atk_pemakaian`
--

CREATE TABLE `atk_pemakaian` (
  `id_pemakaian` varchar(5) NOT NULL,
  `id_gudang_brg` varchar(5) DEFAULT NULL,
  `jml_pemakaian` int(5) DEFAULT NULL,
  `harga_pemakaian` float DEFAULT NULL,
  `ket_pemakaian` text,
  `bln_pemakaian` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `atk_satuans`
--

CREATE TABLE `atk_satuans` (
  `id_satuan` varchar(5) DEFAULT NULL,
  `nm_satuan` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `atk_satuans`
--

INSERT INTO `atk_satuans` (`id_satuan`, `nm_satuan`, `created_at`, `updated_at`) VALUES
('ST-1', 'BUKU', '2019-07-19 03:05:54', '2019-07-19 03:05:54'),
('ST-2', 'IKAT', '2019-07-19 20:37:19', '2019-07-19 20:37:19'),
('ST-3', 'TALI', '2019-07-19 20:58:05', '2019-07-19 20:58:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `atk_tambah`
--

CREATE TABLE `atk_tambah` (
  `id_atk_tambah` varchar(5) NOT NULL,
  `id_gudang_brg` varchar(5) DEFAULT NULL,
  `id_barang` varchar(5) DEFAULT NULL,
  `jml_beli` int(5) DEFAULT NULL,
  `harga_beli` float DEFAULT NULL,
  `bulan_beli` date DEFAULT NULL,
  `pic_beli` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `atk_tambah`
--

INSERT INTO `atk_tambah` (`id_atk_tambah`, `id_gudang_brg`, `id_barang`, `jml_beli`, `harga_beli`, `bulan_beli`, `pic_beli`, `created_at`) VALUES
('TB001', 'GD002', 'BR002', 100, 20000, '2019-08-08', 'KCU', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'eko', 'eko@gmail.com', NULL, '$2y$10$6CEiCFnRw9DzaAeoO/pohOXpvBKxFPW0efx5pTq5l9sDHqgwuWs1u', NULL, '2019-07-17 00:44:34', '2019-07-17 00:44:34');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `atk_awal`
--
ALTER TABLE `atk_awal`
  ADD PRIMARY KEY (`id_atk_awal`);

--
-- Indeks untuk tabel `atk_barang`
--
ALTER TABLE `atk_barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indeks untuk tabel `atk_gudang`
--
ALTER TABLE `atk_gudang`
  ADD PRIMARY KEY (`id_gudang_brg`);

--
-- Indeks untuk tabel `atk_pemakaian`
--
ALTER TABLE `atk_pemakaian`
  ADD PRIMARY KEY (`id_pemakaian`);

--
-- Indeks untuk tabel `atk_tambah`
--
ALTER TABLE `atk_tambah`
  ADD PRIMARY KEY (`id_atk_tambah`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `atk_awal`
--
ALTER TABLE `atk_awal`
  MODIFY `id_atk_awal` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
