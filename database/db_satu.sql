-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Apr 2025 pada 14.57
-- Versi server: 10.4.8-MariaDB
-- Versi PHP: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_satu`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_app`
--

CREATE TABLE `t_app` (
  `id_app` int(11) NOT NULL,
  `app_name` varchar(50) NOT NULL,
  `url` varchar(100) NOT NULL,
  `cipher_name` varchar(50) NOT NULL,
  `cipher_mode` varchar(50) NOT NULL,
  `cipher_key` varchar(255) NOT NULL,
  `app_image` varchar(255) DEFAULT NULL,
  `is_active` int(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_app`
--

INSERT INTO `t_app` (`id_app`, `app_name`, `url`, `cipher_name`, `cipher_mode`, `cipher_key`, `app_image`, `is_active`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(16, 'SIHIMA-UNMA', 'http://localhost/SIHIMA/Auth/verify_v2/', 'aes-256', 'ctr', '4CrgnHEzNVogONMBKm4xnvbmLsMTIqfK', NULL, 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_app_user`
--

CREATE TABLE `t_app_user` (
  `id` int(11) NOT NULL,
  `id_level` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_app_user`
--

INSERT INTO `t_app_user` (`id`, `id_level`, `id_user`) VALUES
(1, 105, 180137);

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_cipher`
--

CREATE TABLE `t_cipher` (
  `cipher_name` varchar(50) NOT NULL,
  `cipher_mode` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_cipher`
--

INSERT INTO `t_cipher` (`cipher_name`, `cipher_mode`) VALUES
('aes-128', 'cbc|ctr|cfb|cfb8|ofb|ecb|xts'),
('aes-192', 'cbc|ctr|cfb|cfb8|ofb|ecb|xts'),
('aes-256', 'cbc|ctr|cfb|cfb8|ofb|ecb|xts');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_level`
--

CREATE TABLE `t_level` (
  `id_level` int(11) NOT NULL,
  `id_app` int(11) NOT NULL,
  `app_level` int(11) NOT NULL,
  `level_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_level`
--

INSERT INTO `t_level` (`id_level`, `id_app`, `app_level`, `level_name`) VALUES
(105, 16, 1, 'MAHASISWA'),
(106, 16, 2, 'KAPRODI');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_user`
--

CREATE TABLE `t_user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `title` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `t_user`
--

INSERT INTO `t_user` (`id_user`, `username`, `password`, `title`) VALUES
(1, 'admin', 'admin', 'SUPER ADMIN');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `t_app`
--
ALTER TABLE `t_app`
  ADD PRIMARY KEY (`id_app`);

--
-- Indeks untuk tabel `t_app_user`
--
ALTER TABLE `t_app_user`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `t_cipher`
--
ALTER TABLE `t_cipher`
  ADD PRIMARY KEY (`cipher_name`);

--
-- Indeks untuk tabel `t_level`
--
ALTER TABLE `t_level`
  ADD PRIMARY KEY (`id_level`);

--
-- Indeks untuk tabel `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `t_app`
--
ALTER TABLE `t_app`
  MODIFY `id_app` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `t_app_user`
--
ALTER TABLE `t_app_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `t_level`
--
ALTER TABLE `t_level`
  MODIFY `id_level` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT untuk tabel `t_user`
--
ALTER TABLE `t_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=180139;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
