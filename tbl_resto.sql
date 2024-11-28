-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2024 at 06:16 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resto`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_resto`
--

CREATE TABLE `tbl_resto` (
  `id_resto` int(12) NOT NULL,
  `nama_resto` varchar(100) NOT NULL,
  `jenis_resto` varchar(100) NOT NULL,
  `jenis_makanan` varchar(100) NOT NULL,
  `jam_buka` time NOT NULL,
  `jam_tutup` time NOT NULL,
  `lokasi` text NOT NULL,
  `foto` varchar(255) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_resto`
--

INSERT INTO `tbl_resto` (`id_resto`, `nama_resto`, `jenis_resto`, `jenis_makanan`, `jam_buka`, `jam_tutup`, `lokasi`, `foto`, `latitude`, `longitude`) VALUES
(101, 'Warung Dayat', 'Warung', 'Sarapan', '06:00:00', '14:00:00', 'Sekupang', '1.jpg', '1.121886', '103.967820'),
(102, 'Warung Endul', 'Warung', 'Makanan Berat', '09:00:00', '15:00:00', 'Sekupang', '2.jpg', '1.1218776', '103.9678076'),
(103, 'Gorengan Kliwon', 'Gerobak', 'Makanan Ringan', '13:00:00', '20:00:00', 'Sekupang', '3.jpg', '1.1218642', '103.9695075'),
(104, 'Bakso Bom', 'Gerobak', 'Makanan Berat', '10:00:00', '20:00:00', 'Sekupang', '4.jpg', '1.1210163', '103.9695568'),
(105, 'Ampera Gita', 'Warung', 'Makanan Berat', '10:00:00', '20:00:00', 'Sekupang', '5.jpg', '1.1234906', '103.9689291'),
(106, 'Pak Eko Fried Chicken', 'Gerobak', 'Makanan Berat', '09:00:00', '20:00:00', 'Sekupang', '6.jpg', '1.1237021', '103.9688312'),
(107, 'Icha Pentol', 'Gerobak', 'Makanan Ringan', '14:00:00', '21:00:00', 'Sekupang', '7.jpg', '1.1246789', '103.9684031'),
(108, 'Warung Jembatan Patam Lestari', 'Warung', 'Makanan Ringan, Makanan Berat', '09:00:00', '20:00:00', 'Sekupang', '8.jpg', '1.1270284', '103.9660598'),
(109, 'RM Minang Baru', 'Warung', 'Makanan Berat', '09:00:00', '20:00:00', 'Sekupang', '9.jpg', '1.1264850', '103.9677654'),
(110, 'Bude Longbud', 'Warung', 'Makanan Berat', '12:00:00', '20:00:00', 'Sekupang', '10.jpg', '1.1218769', '103.9726842'),
(111, 'RM Pendowo', 'Warung', 'Makanan Berat', '11:00:00', '17:00:00', 'Sekupang', '11.jpg', '1.1098719', '103.9654168'),
(112, 'Mie Ayam dan Bakso 89', 'Warung', 'Makanan Berat', '06:00:00', '20:30:00', 'Sekupang', '12.jpg', '1.1098089', '103.9653923'),
(113, 'Bakso dan Mie Ayam Prasmanan Osing ', 'Ruko', 'Makanan Berat', '10:00:00', '21:00:00', 'Sekupang', '13.jpg', '1.1103754\r\n', '103.9619903'),
(114, 'Batagor dan Siomay Nisa', 'Gerobak', 'Makanan Ringan', '15:00:00', '21:00:00', 'Sekupang', '14.jpg', '1.0987123', '103.9324856'),
(115, 'RM Ayuk Lina', 'Warung', 'Makanan Berat', '09:00:00', '17:00:00', 'Sekupang', '15.jpg', '1.1036537', '103.9493007'),
(116, 'Ampera Santan Balado', 'Warung', 'Makanan Berat', '09:00:00', '17:00:00', 'Sekupang', '16.jpg', '1.1031864', '103.9526609'),
(117, 'WM Taragak', 'Warung', 'Makanan Berat', '09:00:00', '21:00:00', 'Sekupang', '17.jpg', '1.1126525', '103.9786659'),
(118, 'Mini FoodCourt Tiban', 'Warung', 'Makanan Berat', '06:00:00', '22:00:00', 'Sekupang', '18.jpg', '1.1127672', '103.9837420'),
(119, 'Soto Kwali Solo', 'Warung', 'Makanan Berat', '08:00:00', '16:00:00', 'Bengkong', '19.jpg', '1.1515768', '104.0277493'),
(120, 'MP Sinar Pagi', 'Warung', 'Makanan Berat', '08:00:00', '16:00:00', 'Bengkong', '20.jpg', '1.1514056', '104.0291615'),
(121, 'Bakso Mercon Lumajang', 'Ruko', 'Makanan Berat', '08:00:00', '21:30:00', 'Bengkong', '21.jpg', '1.1548760', '104.0235838'),
(122, 'RM Minahasa', 'Ruko', 'Makanan Berat', '09:00:00', '18:00:00', 'Bengkong', '22.jpg', '1.1606452', '104.0178067'),
(123, 'Bakso Persegi', 'Warung', 'Makanan Berat', '14:00:00', '01:00:00', 'Bengkong', '23.jpg', '1.1586886', '104.0284715'),
(124, 'Warung Yuen', 'Warung', 'Makanan Berat', '11:00:00', '22:00:00', 'Bengkong', '24.jpg', '1.1603244', '104.0347888'),
(125, 'RM Mbak Ningsih', 'Ruko', 'Makanan Berat', '10:00:00', '22:00:00', 'Bengkong', '25.jpg', '1.1641445', '104.0360004'),
(126, 'Ayam Penyet Azka', 'Gerobak', 'Makanan Berat', '15:00:00', '23:00:00', 'Bengkong', '26.jpg', '1.1626779', '104.0358164'),
(127, 'Zhengda Chicken Steak', 'Ruko', 'Makanan Berat', '09:00:00', '21:00:00', 'Bengkong', '27.jpg', '1.140412', '104.037090'),
(128, 'Morning Kopitiam', 'Ruko', 'Makanan Berat', '06:00:00', '15:00:00', 'Bengkong', '28.jpg', '1.143601', '104.036933'),
(129, 'Kedai Kopi Aso', 'Ruko', 'Makanan Berat', '06:00:00', '18:00:00', 'Bengkong', '29.jpg', '1.143868', '104.036933'),
(130, 'Coffee YO\\XZ', 'Ruko', 'Makanan Berat', '06:00:00', '18:00:00', 'Bengkong', '30.jpg', '1.142048', '104.038244'),
(131, 'Bakso Ujang Mak Inyong', 'Warung', 'Makanan Berat', '06:00:00', '18:00:00', 'Bengkong', '31.jpg', '1.141601', '104.038175'),
(132, 'Pempek Cek Eka', 'Gerobak', 'Makanan Ringan', '09:00:00', '21:00:00', 'Bengkong', '32.jpg', '1.152389', '104.038332');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_resto`
--
ALTER TABLE `tbl_resto`
  ADD PRIMARY KEY (`id_resto`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_resto`
--
ALTER TABLE `tbl_resto`
  MODIFY `id_resto` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2000;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
