-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Mar 2021 pada 05.43
-- Versi server: 10.4.14-MariaDB
-- Versi PHP: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bayes`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `beasiswa`
--

CREATE TABLE `beasiswa` (
  `id` int(11) NOT NULL,
  `penghasilan_ortu` enum('< 500.000','500.000 - 1.000.000','> 1.000.000') NOT NULL,
  `yatim_piatu` enum('Ya','Tidak') NOT NULL,
  `kondisi_rumah` enum('Layak','Cukup','Kurang') NOT NULL,
  `penerima_pkh` enum('Ya','Tidak') NOT NULL,
  `beasiswa_smp` enum('Ya','Tidak') NOT NULL,
  `label` enum('Ya','Tidak') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `beasiswa`
--

INSERT INTO `beasiswa` (`id`, `penghasilan_ortu`, `yatim_piatu`, `kondisi_rumah`, `penerima_pkh`, `beasiswa_smp`, `label`) VALUES
(1, '< 500.000', 'Tidak', 'Layak', 'Tidak', 'Tidak', 'Ya'),
(2, '< 500.000', 'Ya', 'Cukup', 'Tidak', 'Ya', 'Tidak'),
(3, '< 500.000', 'Ya', 'Kurang', 'Tidak', 'Tidak', 'Ya'),
(4, '< 500.000', 'Ya', 'Kurang', 'Tidak', 'Tidak', 'Ya'),
(5, '< 500.000', 'Ya', 'Cukup', 'Tidak', 'Tidak', 'Ya'),
(6, '< 500.000', 'Tidak', 'Kurang', 'Ya', 'Ya', 'Tidak'),
(7, '< 500.000', 'Tidak', 'Kurang', 'Tidak', 'Tidak', 'Tidak'),
(8, '< 500.000', 'Ya', 'Kurang', 'Tidak', 'Tidak', 'Ya'),
(9, '< 500.000', 'Tidak', 'Cukup', 'Tidak', 'Ya', 'Tidak'),
(10, '< 500.000', 'Ya', 'Layak', 'Ya', 'Tidak', 'Ya'),
(11, '< 500.000', 'Ya', 'Kurang', 'Tidak', 'Tidak', 'Ya'),
(12, '< 500.000', 'Tidak', 'Layak', 'Tidak', 'Tidak', 'Tidak'),
(13, '< 500.000', 'Ya', 'Cukup', 'Tidak', 'Tidak', 'Ya'),
(14, '< 500.000', 'Tidak', 'Kurang', 'Tidak', 'Ya', 'Tidak');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `beasiswa`
--
ALTER TABLE `beasiswa`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `beasiswa`
--
ALTER TABLE `beasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
