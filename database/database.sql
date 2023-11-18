-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 18, 2023 at 11:27 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crudlaundry`
--
CREATE DATABASE IF NOT EXISTS `crudlaundry` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `crudlaundry`;

-- --------------------------------------------------------

--
-- Table structure for table `jenis`
--

DROP TABLE IF EXISTS `jenis`;
CREATE TABLE IF NOT EXISTS `jenis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis` varchar(255) NOT NULL,
  `harga` decimal(20,0) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis`
--

INSERT INTO `jenis` (`id`, `jenis`, `harga`) VALUES
(1, 'Cuci Basah', '5000'),
(2, 'Cuci Kering', '7000'),
(3, 'Cuci Setrika', '10000');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE IF NOT EXISTS `transaksi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `waktu_terima` datetime NOT NULL,
  `kg` decimal(10,1) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `waktu_selesai` datetime NOT NULL,
  `keterangan` text NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jenis` (`id_jenis`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level_user` varchar(255) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `level_user`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_penjualan`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `v_penjualan`;
CREATE TABLE IF NOT EXISTS `v_penjualan` (
`id` int(11)
,`waktu_terima` datetime
,`jenis` varchar(255)
,`harga` decimal(20,0)
,`kg` decimal(10,1)
,`total` decimal(30,1)
,`waktu_selesai` datetime
,`keterangan` text
,`status` int(1)
);

-- --------------------------------------------------------

--
-- Structure for view `v_penjualan`
--
DROP TABLE IF EXISTS `v_penjualan`;

DROP VIEW IF EXISTS `v_penjualan`;
CREATE OR REPLACE VIEW `v_penjualan`  AS SELECT `transaksi`.`id` AS `id`, `transaksi`.`waktu_terima` AS `waktu_terima`, `jenis`.`jenis` AS `jenis`, `jenis`.`harga` AS `harga`, `transaksi`.`kg` AS `kg`, `transaksi`.`kg`* `jenis`.`harga` AS `total`, `transaksi`.`waktu_selesai` AS `waktu_selesai`, `transaksi`.`keterangan` AS `keterangan`, `transaksi`.`status` AS `status` FROM (`transaksi` left join `jenis` on(`transaksi`.`id_jenis` = `jenis`.`id`)) ORDER BY `transaksi`.`id` DESC  ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_jenis`) REFERENCES `jenis` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
