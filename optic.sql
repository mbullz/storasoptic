-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 19, 2016 at 11:49 AM
-- Server version: 5.5.32
-- PHP Version: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `optic`
--
CREATE DATABASE IF NOT EXISTS `optic` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `optic`;

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_cleanup_trans`()
BEGIN
	delete from dmasukbarang
	where noreferensi not in (
		select referensi
		from masukbarang
	);

	delete from dkeluarbarang
	where noreferensi not in (
		select referensi
		from keluarbarang
	);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `aruskas`
--

CREATE TABLE IF NOT EXISTS `aruskas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `carabayar_id` int(11) NOT NULL,
  `tipe` enum('hutang','piutang','operasional') NOT NULL DEFAULT 'operasional',
  `tgl` date NOT NULL,
  `opr` int(11) NOT NULL,
  `referensi` varchar(30) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `matauang` varchar(10) DEFAULT 'IDR',
  `info` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `aruskas`
--

INSERT INTO `aruskas` (`id`, `carabayar_id`, `tipe`, `tgl`, `opr`, `referensi`, `jumlah`, `matauang`, `info`) VALUES
(1, 1, 'hutang', '2014-08-13', 0, 'PO-100400', 100000, 'IDR', ''),
(2, 1, 'piutang', '2014-08-14', 0, 'INV-140814001', 90000, 'IDR', ''),
(3, 2, 'piutang', '2014-11-22', 0, 'INV-141122002', 345000, 'IDR', 'BCA'),
(4, 4, 'operasional', '2014-12-18', 1, 'BO-071224', 300000, 'IDR', 'Biaya Internet # Speedy'),
(5, 1, 'piutang', '2014-12-09', 0, 'INV-141209001', 200000, 'IDR', ''),
(6, 1, 'piutang', '2014-12-16', 0, 'INV-141216001', 50000, 'IDR', 'DP'),
(7, 2, 'piutang', '2014-12-16', 1, 'INV-141216001', 100000, 'IDR', 'Cicilan 1'),
(8, 3, 'piutang', '2014-12-16', 1, 'INV-141216001', 150000, 'IDR', 'Cicilan 2'),
(9, 5, 'piutang', '2014-12-16', 1, 'INV-141216001', 50000, 'IDR', 'tes'),
(10, 2, 'piutang', '2014-12-18', 0, 'INV-141218001', 250000, 'IDR', 'BCA'),
(11, 1, 'piutang', '2014-12-18', 0, 'INV-141218002', 400000, 'IDR', 'Lunas'),
(12, 1, 'operasional', '2014-12-18', 1, 'BO-232950', 150000, 'IDR', 'Biaya Konsumsi # UANG MAKAN KARYAWAN'),
(13, 3, 'piutang', '2014-12-19', 0, 'INV-141219001', 350000, 'IDR', 'CC BCA'),
(18, 3, 'piutang', '2015-02-23', 0, 'INV-150223001', 150000, 'IDR', 'CIMB VISA'),
(15, 1, 'piutang', '2014-12-19', 0, 'INV-141219003', 50000, 'IDR', 'DP'),
(16, 1, 'operasional', '2014-12-20', 1, 'BO-140412', 150000, 'IDR', 'Biaya Konsumsi # Uang Makan Karyawan'),
(17, 1, 'piutang', '2015-02-22', 1, 'INV-141219001', 200000, 'IDR', ''),
(19, 1, 'piutang', '2015-03-06', 0, 'INV-150306001', 150000, 'IDR', ''),
(20, 1, 'piutang', '2015-03-06', 0, 'INV-150306002', 200000, 'IDR', ''),
(21, 1, 'piutang', '2015-05-04', 0, 'INV-150504001', 100000, 'IDR', ''),
(22, 2, 'piutang', '2015-05-04', 1, 'INV-150504001', 200000, 'IDR', ''),
(23, 2, 'piutang', '2015-05-04', 0, 'INV-150504002', 150000, 'IDR', ''),
(24, 2, 'piutang', '2015-05-05', 1, 'INV-150504002', 100000, 'IDR', ''),
(26, 1, 'piutang', '2015-05-15', 0, 'INV-150515002', 0, 'IDR', ''),
(27, 1, 'piutang', '2015-07-08', 0, 'INV-0000000001', 200000, 'IDR', ''),
(28, 1, 'piutang', '2015-07-08', 0, 'INV-000000001', 75000, 'IDR', ''),
(29, 1, 'piutang', '2015-07-08', 0, 'INV-000000002', 500000, 'IDR', ''),
(30, 1, 'piutang', '2015-07-08', 0, 'INV-150708001', 50000, 'IDR', '');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE IF NOT EXISTS `barang` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(10) DEFAULT NULL,
  `brand_id` int(11) NOT NULL,
  `barang` varchar(100) NOT NULL,
  `frame` varchar(30) DEFAULT NULL,
  `color` varchar(30) DEFAULT NULL,
  `qty` int(11) DEFAULT '0',
  `price` int(11) DEFAULT '0',
  `price2` int(11) DEFAULT NULL,
  `kode_harga` varchar(20) DEFAULT NULL,
  `info` text,
  `ukuran` varchar(30) DEFAULT NULL,
  `tipe` int(11) DEFAULT '1' COMMENT '1 -> Frame2 -> Softlens3 -> Lensa',
  `tgl_masuk_akhir` date DEFAULT NULL,
  `tgl_keluar_akhir` date DEFAULT NULL,
  `created_user_id` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `last_update_user_id` int(11) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`product_id`, `kode`, `brand_id`, `barang`, `frame`, `color`, `qty`, `price`, `price2`, `kode_harga`, `info`, `ukuran`, `tipe`, `tgl_masuk_akhir`, `tgl_keluar_akhir`, `created_user_id`, `created_date`, `last_update_user_id`, `last_update_date`) VALUES
(1, 'NA001', 1, 'TES1', 'METAL FRAME', 'BLUE', 1, 100000, 200000, '12345', 'PT. BEVERLY HILLS SPEKTA', '', 1, '2014-08-13', '0000-00-00', 1, '2014-09-09 07:10:15', 5, '2014-09-11 22:29:14'),
(2, '', 6, 'ADIDAS-01', 'FRAMELESS', 'YELLOW', 2, 100000, 300000, 'TG''', 'PT. BEVERLY HILLS SPEKTA', '', 1, '2014-09-09', '2014-12-08', 1, '2014-09-09 17:35:04', 5, '2014-09-11 22:28:29'),
(5, '', 2, 'GUCCI-01', 'FRAMELESS', 'YELLOW', 1, 0, 150000, '', '', '', 1, '2014-09-11', '0000-00-00', 1, '2014-09-11 23:22:30', NULL, NULL),
(6, '', 2, 'GUCCI-02', 'FRAMELESS', 'RED', 0, 100000, 0, 'GC''', '', '', 1, '2014-09-12', NULL, 1, '2014-09-12 01:09:09', NULL, NULL),
(7, '', 6, 'AD-01', 'METAL FRAME', 'BLUE', 3, 50000, 350000, 'LM', 'MR A', '', 1, '2014-09-26', NULL, 1, '2014-09-26 22:18:05', NULL, NULL),
(52, '', 14, 'RAYBAN-006', 'METAL FRAME', 'C1', 4, 300000, 1000000, '', 'BY SYSTEM', '', 1, '2015-02-21', '0000-00-00', 1, '2015-02-21 11:52:48', NULL, '0000-00-00 00:00:00'),
(51, '', 14, 'RAYBAN-005', 'FRAMELESS', 'C1', 4, 300000, 1000000, '', 'BY SYSTEM', '', 1, '2015-02-21', '0000-00-00', 1, '2015-02-21 11:52:48', NULL, '0000-00-00 00:00:00'),
(50, '', 14, 'RAYBAN-004', 'SUNGLASSES', 'YELLOW', 4, 300000, 1000000, '', 'BY SYSTEM', '', 1, '2015-02-21', '0000-00-00', 1, '2015-02-21 11:52:48', NULL, '0000-00-00 00:00:00'),
(49, '', 14, 'RAYBAN-003', 'PLASTIC FRAME', 'RED', 3, 300000, 1000000, '', 'BY SYSTEM', '', 1, '2015-02-21', '0000-00-00', 1, '2015-02-21 11:52:48', NULL, '0000-00-00 00:00:00'),
(48, '', 14, 'RAYBAN-002', 'METAL FRAME', 'BROWN', 1, 300000, 1000000, '', 'BY SYSTEM', '', 1, '2015-02-21', '2015-07-08', 1, '2015-02-21 11:52:48', NULL, '0000-00-00 00:00:00'),
(47, '', 14, 'RAYBAN-001', 'FRAMELESS', 'BLUE', 1, 300000, 1000000, '', 'BY SYSTEM', '', 1, '2015-02-21', '2015-05-04', 1, '2015-02-21 11:52:48', NULL, '0000-00-00 00:00:00'),
(46, '', 2, 'GUCCI-10', 'FRAMELESS', 'RED', 1, 100000, 500000, 'LM', 'MR A', '', 1, '2014-12-18', '0000-00-00', 1, '2014-12-18 19:39:42', NULL, '0000-00-00 00:00:00'),
(45, '', 13, 'AIRWARE', 'POLYCARBONATE', '', 0, 0, 0, '', '', '', 3, '2014-12-16', NULL, 1, '2014-12-16 21:32:27', NULL, NULL),
(44, '', 13, 'AIRWARE', 'POLYCARBONATE', '', 0, 0, 0, '', 'MR A', '', 3, '2014-12-16', NULL, 1, '2014-12-16 11:08:13', NULL, NULL),
(43, '', 13, 'AIRWARE', 'POLYCARBONATE', '', 0, 0, 0, '', '8', '', 3, '2014-12-15', NULL, 1, '2014-12-15 21:47:10', NULL, NULL),
(42, '', 13, 'ESSILOR', '', '', 0, 0, 0, '', '', '', 3, '2014-12-15', NULL, 1, '2014-12-15 21:30:33', NULL, NULL),
(21, 'NI001', 11, 'NIKE001', 'SUNGLASSES', 'BROWN', 1, 100000, 300000, 'LP', 'PT. NIKE', '', 1, '2014-11-29', NULL, 1, '2014-11-29 13:33:17', NULL, NULL),
(39, '', 2, 'GUCCI-03', 'FRAMELESS', 'RED', 1, 50000, 250000, 'DLP', 'PT. BEVERLY HILLS SPEKTA', '', 1, '2014-12-08', '0000-00-00', 1, '2014-12-08 22:16:43', NULL, '0000-00-00 00:00:00'),
(40, '', 11, 'NIKE-02', 'METAL FRAME', 'BLUE', 1, 100000, 400000, 'E', 'MR A', '', 1, '2014-12-08', '0000-00-00', 1, '2014-12-08 22:16:43', NULL, '0000-00-00 00:00:00'),
(59, '', 15, 'HK-002', 'FRAMELESS', 'BROWN', 4, 100000, 400000, '', 'BY SYSTEM', '', 1, '2015-03-20', '2015-05-15', 1, '2015-03-20 22:15:36', NULL, '0000-00-00 00:00:00'),
(53, '', 14, 'RAYBAN-007', 'PLASTIC FRAME', 'C2', 5, 300000, 1000000, '', 'BY SYSTEM', '', 1, '2015-02-21', '0000-00-00', 1, '2015-02-21 11:52:48', NULL, '0000-00-00 00:00:00'),
(54, '', 14, 'RAYBAN-008', 'SUNGLASSES', 'C2', 5, 300000, 1000000, '', 'BY SYSTEM', '', 1, '2015-02-21', '0000-00-00', 1, '2015-02-21 11:52:48', NULL, '0000-00-00 00:00:00'),
(55, '', 14, 'RAYBAN-009', 'FRAMELESS', 'C3', 5, 300000, 1000000, '', 'BY SYSTEM', '', 1, '2015-02-21', '0000-00-00', 1, '2015-02-21 11:52:48', NULL, '0000-00-00 00:00:00'),
(56, '', 14, 'RAYBAN-010', 'METAL FRAME', 'C3', 6, 300000, 1000000, '', 'BY SYSTEM', '', 1, '2015-02-21', '0000-00-00', 1, '2015-02-21 11:52:48', NULL, '0000-00-00 00:00:00'),
(57, '', 10, 'SOFTLENS 1', '2015-03-31', 'BLUE', 5, 25000, 50000, '', 'BY SYSTEM', '', 2, '2015-03-12', '0000-00-00', 1, '2015-03-12 17:58:42', NULL, '0000-00-00 00:00:00'),
(58, '', 15, 'HK-001', 'METAL FRAME', 'PINK', 6, 300000, 700000, '', 'MR AB', '', 1, '2015-03-12', '2015-05-15', 1, '2015-03-12 21:54:56', NULL, '0000-00-00 00:00:00'),
(60, '', 15, 'HK-003', 'PLASTIC FRAME', 'PINK', 2, 100000, 400000, '', 'BY SYSTEM', '', 1, '2015-03-20', '2015-07-08', 1, '2015-03-20 22:18:20', NULL, '0000-00-00 00:00:00'),
(61, '', 15, 'HK-005', 'SUNGLASSES', 'RED', 2, 300000, 700000, 'T', 'MR AB', '', 1, '2015-03-20', '0000-00-00', 1, '2015-03-21 15:51:50', NULL, '0000-00-00 00:00:00'),
(62, '', 10, 'EXO', '-2', 'RED', 10, 50000, 150000, 'ABC', 'PT. BEVERLY HILLS SPEKTA', '2015-07-31', 2, '2015-07-06', '0000-00-00', 1, '2015-07-06 17:50:25', NULL, '0000-00-00 00:00:00'),
(63, '', 16, 'AIR MPS', '', '', 19, 30000, 75000, 'DEF', 'MR AB', '', 4, '2015-07-06', '2015-07-08', 1, '2015-07-06 19:18:28', NULL, '0000-00-00 00:00:00'),
(64, '', 10, 'HAHA', '3', 'GOLD', 19, 50000, 150000, 'GHI', 'MR AB', '2015-07-31', 2, '2015-07-08', '2015-07-08', 1, '2015-07-08 16:38:31', NULL, '0000-00-00 00:00:00'),
(65, '', 13, 'TESTES', '2', '1', 10, 10000, 20000, 'JKL', 'MR AB', '', 3, '2015-07-08', '0000-00-00', 1, '2015-07-08 16:42:16', NULL, '0000-00-00 00:00:00'),
(66, '', 10, 'ASDF', '-3', 'RED', 1, 0, 50000, '', 'MR AB', '2015-07-31', 2, '2015-07-08', '0000-00-00', 1, '2015-07-08 17:38:08', NULL, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `carabayar`
--

CREATE TABLE IF NOT EXISTS `carabayar` (
  `carabayar_id` int(11) NOT NULL AUTO_INCREMENT,
  `pembayaran` varchar(100) NOT NULL,
  `info` text,
  PRIMARY KEY (`carabayar_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `carabayar`
--

INSERT INTO `carabayar` (`carabayar_id`, `pembayaran`, `info`) VALUES
(1, 'CASH', 'CASH'),
(2, 'DEBIT', 'DEBIT'),
(3, 'CREDIT CARD', 'CREDIT CARD'),
(4, 'TRANSFER', 'TRANSFER'),
(5, 'GIRO', 'GIRO');

-- --------------------------------------------------------

--
-- Table structure for table `color_type`
--

CREATE TABLE IF NOT EXISTS `color_type` (
  `color_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `color` varchar(50) NOT NULL,
  PRIMARY KEY (`color_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `color_type`
--

INSERT INTO `color_type` (`color_type_id`, `color`) VALUES
(1, 'BLUE'),
(2, 'YELLOW'),
(3, 'RED'),
(4, 'BROWN'),
(5, 'C1'),
(6, 'C2'),
(7, 'C3'),
(8, 'PINK'),
(9, 'GOLD');

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `config_id` int(11) NOT NULL AUTO_INCREMENT,
  `config` text NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`config_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`config_id`, `config`, `value`) VALUES
(1, 'company_name', 'EFATA Optical'),
(2, 'company_address', 'Jl. Juanda 3 No. 29c , Jakarta Pusat'),
(3, 'company_telephone', 'Telp. (021) 1234567'),
(4, 'base_url', 'optic');

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE IF NOT EXISTS `divisi` (
  `kode` varchar(10) NOT NULL,
  `divisi` varchar(100) NOT NULL,
  `info` text,
  PRIMARY KEY (`kode`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `divisi`
--

INSERT INTO `divisi` (`kode`, `divisi`, `info`) VALUES
('ADM', 'Administrasi', 'Divisi Administrasi'),
('FIN', 'Finance', 'Divisi Finance / Keuangan'),
('HRD', 'HRD & Personalia', 'Divisi HRD &amp; Personalia');

-- --------------------------------------------------------

--
-- Table structure for table `dkeluarbarang`
--

CREATE TABLE IF NOT EXISTS `dkeluarbarang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT NULL,
  `satuan_id` int(11) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `tdiskon` enum('0','1') DEFAULT '0',
  `diskon` float DEFAULT '0',
  `subtotal` varchar(10) DEFAULT NULL,
  `noreferensi` varchar(30) NOT NULL,
  `lensa` varchar(30) DEFAULT NULL,
  `rSph` int(11) DEFAULT NULL,
  `rCyl` int(11) DEFAULT NULL,
  `rAxis` int(11) DEFAULT NULL,
  `rAdd` int(11) DEFAULT NULL,
  `rPd` int(11) DEFAULT NULL,
  `lSph` int(11) DEFAULT NULL,
  `lCyl` int(11) DEFAULT NULL,
  `lAxis` int(11) DEFAULT NULL,
  `lAdd` int(11) DEFAULT NULL,
  `lPd` int(11) DEFAULT NULL,
  `tipe` int(11) NOT NULL,
  `harga_lensa` int(11) DEFAULT NULL,
  `special_order` enum('0','1') DEFAULT '0',
  `special_order_done` enum('0','1') DEFAULT '0',
  `info` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=70 ;

--
-- Dumping data for table `dkeluarbarang`
--

INSERT INTO `dkeluarbarang` (`id`, `product_id`, `satuan_id`, `harga`, `qty`, `tdiskon`, `diskon`, `subtotal`, `noreferensi`, `lensa`, `rSph`, `rCyl`, `rAxis`, `rAdd`, `rPd`, `lSph`, `lCyl`, `lAxis`, `lAdd`, `lPd`, `tipe`, `harga_lensa`, `special_order`, `special_order_done`, `info`) VALUES
(57, 47, 1, 1000000, 1, '0', 0, '1000000', 'INV-150504002', '42', 0, 0, 0, 0, 56, 0, 0, 0, 0, 56, 5, 50000, '0', '0', ''),
(48, 48, 1, 0, 1, '0', 0, '0', 'PCB-150312001', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, '0', '0', ''),
(56, 58, 1, 700000, 1, '0', 0, '700000', 'INV-150504001', '', 0, 0, 0, 0, 56, 0, 0, 0, 0, 56, 1, 0, '0', '0', ''),
(46, 47, 1, 1000000, 1, '0', 0, '1000000', 'INV-150306002', '42', 0, 0, 0, 0, 56, 0, 0, 0, 0, 56, 5, 75000, '0', '0', ''),
(45, 21, 1, 300000, 1, '0', 0, '300000', 'INV-150306001', '42', 0, 0, 0, 0, 56, 0, 0, 0, 0, 56, 5, 50000, '0', '0', ''),
(35, 40, 1, 400000, 1, '0', 50000, '350000', 'INV-141219003', '44', 0, 0, 0, 0, 56, 0, 0, 0, 0, 56, 5, 100000, '1', '0', ''),
(39, 56, 1, 1000000, 1, '0', 0, '1000000', 'INV-150223001', '42', 0, 0, 0, 0, 56, 0, 0, 0, 0, 56, 5, 0, '0', '0', ''),
(33, 46, 1, 500000, 1, '0', 0, '500000', 'INV-141219001', '42', 0, 0, 0, 0, 56, 0, 0, 0, 0, 56, 5, 50000, '0', '0', ''),
(60, 59, 1, 400000, 1, '0', 0, '400000', 'INV-150515001', '42', 0, 0, 0, 0, 56, 0, 0, 0, 0, 56, 5, 75000, '0', '0', ''),
(61, 58, 1, 700000, 1, '0', 0, '700000', 'INV-150515002', '42', 0, 0, 0, 0, 56, 0, 0, 0, 0, 56, 5, 50000, '0', '0', ''),
(68, 48, 1, 1000000, 1, '0', 0, '1000000', 'INV-000000002', '', 0, 0, 0, 0, 56, 0, 0, 0, 0, 56, 1, 0, '0', '0', ''),
(67, 63, 1, 75000, 1, '0', 0, '75000', 'INV-000000001', '', 0, 0, 0, 0, 56, 0, 0, 0, 0, 56, 4, 0, '0', '0', ''),
(69, 64, 1, 150000, 1, '0', 0, '150000', 'INV-150708001', '', 0, 0, 0, 0, 56, 0, 0, 0, 0, 56, 2, 0, '0', '0', '');

-- --------------------------------------------------------

--
-- Table structure for table `dmasukbarang`
--

CREATE TABLE IF NOT EXISTS `dmasukbarang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `satuan_id` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `tdiskon` enum('0','1') NOT NULL DEFAULT '0',
  `diskon` float NOT NULL DEFAULT '0',
  `subtotal` varchar(11) NOT NULL,
  `noreferensi` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `dmasukbarang`
--

INSERT INTO `dmasukbarang` (`id`, `product_id`, `satuan_id`, `harga`, `qty`, `tdiskon`, `diskon`, `subtotal`, `noreferensi`) VALUES
(1, 39, 1, 50000, 1, '0', 0, '50000', 'PO-08122216430'),
(2, 40, 1, 100000, 2, '0', 0, '200000', 'PO-08122216431'),
(3, 41, 1, 50000, 3, '0', 0, '150000', 'PO-08122216430'),
(4, 46, 1, 100000, 5, '0', 0, '500000', 'PO-18121939420'),
(5, 7, 1, 50000, 4, '0', 0, '200000', 'PO-21020959190'),
(6, 47, 1, 300000, 3, '0', 0, '900000', 'PO-21021152480'),
(7, 48, 1, 300000, 3, '0', 0, '900000', 'PO-21021152480'),
(8, 49, 1, 300000, 3, '0', 0, '900000', 'PO-21021152480'),
(9, 50, 1, 300000, 4, '0', 0, '1200000', 'PO-21021152480'),
(10, 51, 1, 300000, 4, '0', 0, '1200000', 'PO-21021152480'),
(11, 52, 1, 300000, 4, '0', 0, '1200000', 'PO-21021152480'),
(12, 53, 1, 300000, 5, '0', 0, '1500000', 'PO-21021152480'),
(13, 54, 1, 300000, 5, '0', 0, '1500000', 'PO-21021152480'),
(14, 55, 1, 300000, 5, '0', 0, '1500000', 'PO-21021152480'),
(15, 56, 1, 300000, 6, '0', 0, '1800000', 'PO-21021152480'),
(16, 57, 1, 25000, 5, '0', 0, '125000', 'PO-12031758420'),
(17, 58, 1, 300000, 8, '0', 0, '2400000', 'PO-12032154560'),
(18, 59, 1, 100000, 5, '0', 0, '500000', 'PO-20032215360'),
(19, 60, 1, 100000, 3, '0', 0, '300000', 'PO-20032218200'),
(20, 61, 1, 300000, 2, '0', 0, '600000', 'PO-21031551500'),
(21, 62, 1, 50000, 10, '0', 0, '500000', 'PO-06071750250'),
(22, 63, 1, 30000, 20, '0', 0, '600000', 'PO-06071918280'),
(23, 64, 1, 50000, 20, '0', 0, '1000000', 'PO-08071638310'),
(24, 65, 1, 10000, 10, '0', 0, '100000', 'PO-08071642160'),
(25, 66, 1, 0, 1, '0', 0, '0', 'PO-08071738080');

-- --------------------------------------------------------

--
-- Table structure for table `frame_type`
--

CREATE TABLE IF NOT EXISTS `frame_type` (
  `frame_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `frame` varchar(50) NOT NULL,
  PRIMARY KEY (`frame_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `frame_type`
--

INSERT INTO `frame_type` (`frame_type_id`, `frame`) VALUES
(1, 'METAL FRAME'),
(2, 'FRAMELESS'),
(3, 'PLASTIC FRAME'),
(4, 'SUNGLASSES'),
(5, '2015-03-31');

-- --------------------------------------------------------

--
-- Table structure for table `gudang`
--

CREATE TABLE IF NOT EXISTS `gudang` (
  `kode` varchar(10) NOT NULL,
  `gudang` varchar(100) NOT NULL,
  `info` text,
  PRIMARY KEY (`kode`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gudang`
--

INSERT INTO `gudang` (`kode`, `gudang`, `info`) VALUES
('GDG_A', 'Gudang A', 'Info Gudang A');

-- --------------------------------------------------------

--
-- Table structure for table `jenisbarang`
--

CREATE TABLE IF NOT EXISTS `jenisbarang` (
  `brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(10) DEFAULT NULL,
  `jenis` varchar(100) NOT NULL,
  `info` text,
  `tipe` int(11) DEFAULT '1',
  PRIMARY KEY (`brand_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `jenisbarang`
--

INSERT INTO `jenisbarang` (`brand_id`, `kode`, `jenis`, `info`, `tipe`) VALUES
(1, 'Z0001', 'ZARA', 'DELETED', 1),
(2, 'GC001', 'GUCCI', '', 1),
(6, 'ADS001', 'ADIDAS', 'PT. BEVERLY HILLS SPEKTA', 1),
(10, '', 'BRAND SOFTLENS', 'MR AB', 2),
(11, '', 'NIKE', '', 1),
(12, '', 'LEVIS', 'PT. BEVERLY HILLS SPEKTA', 1),
(13, '', 'ESSILOR', '', 3),
(14, '', 'RAYBAN', 'DELETED', 1),
(15, '', 'HELLO KITTY', 'MR AB', 1),
(16, '', 'BRAND ACC', 'PT. BEVERLY HILLS SPEKTA', 4),
(21, 'ABC', 'TEST SOFTLENS 1', 'DELETED', 2);

-- --------------------------------------------------------

--
-- Table structure for table `jeniskontak`
--

CREATE TABLE IF NOT EXISTS `jeniskontak` (
  `kode` varchar(10) NOT NULL,
  `klasifikasi` enum('customer','supplier','karyawan','sales','cabang') NOT NULL,
  `jenis` varchar(100) NOT NULL,
  `info` text,
  PRIMARY KEY (`kode`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jeniskontak`
--

INSERT INTO `jeniskontak` (`kode`, `klasifikasi`, `jenis`, `info`) VALUES
('T001', 'karyawan', 'Karyawan Tetap', '-'),
('T002', 'karyawan', 'Karyawan Kontrak', ''),
('C001', 'customer', 'Customer', ''),
('T003', 'sales', 'Karyawan Sales (PM)', '-'),
('S0001', 'supplier', 'Supplier 1', 'Info Jenis Kontak Supplier'),
('B001', 'cabang', 'Cabang', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `keluarbarang`
--

CREATE TABLE IF NOT EXISTS `keluarbarang` (
  `referensi` varchar(30) NOT NULL,
  `tgl` date NOT NULL,
  `jtempo` date DEFAULT NULL,
  `client` int(11) NOT NULL,
  `sales` int(11) DEFAULT NULL,
  `matauang` varchar(10) NOT NULL,
  `total` int(11) NOT NULL DEFAULT '0',
  `info` text,
  `lunas` enum('0','1') NOT NULL DEFAULT '0',
  `tipe_pembayaran` enum('Cash','Jatuh Tempo') DEFAULT 'Cash',
  PRIMARY KEY (`referensi`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `keluarbarang`
--

INSERT INTO `keluarbarang` (`referensi`, `tgl`, `jtempo`, `client`, `sales`, `matauang`, `total`, `info`, `lunas`, `tipe_pembayaran`) VALUES
('INV-141219001', '2014-12-19', '0000-00-00', 3, 5, 'IDR', 550000, '', '1', 'Cash'),
('INV-150223001', '2015-02-23', '0000-00-00', 3, 5, 'IDR', 1000000, '', '0', 'Cash'),
('INV-141219003', '2014-12-19', '0000-00-00', 3, 5, 'IDR', 450000, '', '0', 'Cash'),
('INV-150306001', '2015-03-06', '0000-00-00', 3, 5, 'IDR', 350000, '', '0', 'Cash'),
('INV-150306002', '2015-03-06', '0000-00-00', 3, 5, 'IDR', 1075000, '', '0', 'Cash'),
('PCB-150312001', '2015-03-12', NULL, 6, 0, '', 0, 'Pindah Cabang', '1', 'Cash'),
('INV-150504001', '2015-05-04', '0000-00-00', 3, 5, 'IDR', 700000, '', '0', 'Cash'),
('INV-150504002', '2015-05-04', '0000-00-00', 3, 5, 'IDR', 1050000, '', '0', 'Cash'),
('INV-150515001', '2015-05-15', '0000-00-00', 3, 5, 'IDR', 475000, '', '0', 'Cash'),
('INV-150515002', '2015-05-15', '0000-00-00', 3, 5, 'IDR', 750000, '', '0', 'Cash'),
('INV-000000001', '2015-07-08', '0000-00-00', 3, 1, 'IDR', 75000, '', '1', 'Cash'),
('INV-000000002', '2015-07-08', '0000-00-00', 3, 1, 'IDR', 1000000, '', '0', 'Cash'),
('INV-150708001', '2015-07-08', '0000-00-00', 3, 1, 'IDR', 150000, '', '0', 'Cash');

-- --------------------------------------------------------

--
-- Table structure for table `kirimbarang`
--

CREATE TABLE IF NOT EXISTS `kirimbarang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl` date NOT NULL,
  `noreferensi` varchar(30) NOT NULL,
  `product_id` int(11) NOT NULL,
  `satuan_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `gudang` varchar(10) NOT NULL,
  `info` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `kirimbarang`
--

INSERT INTO `kirimbarang` (`id`, `tgl`, `noreferensi`, `product_id`, `satuan_id`, `qty`, `gudang`, `info`) VALUES
(1, '2014-12-08', 'INV-141122001', 2, 1, 1, 'GDG_A', 'Sudah Terkirim'),
(2, '0000-00-00', 'INV-150306002', 47, 1, 1, 'GDG_A', ''),
(3, '2015-05-04', 'INV-150504001', 58, 1, 1, 'GDG_A', ''),
(4, '2015-05-04', 'INV-150504002', 47, 1, 1, 'GDG_A', ''),
(5, '2015-05-15', 'INV-150515001', 59, 1, 1, 'GDG_A', ''),
(6, '2015-05-15', 'INV-150515002', 58, 1, 1, 'GDG_A', ''),
(7, '2015-07-08', 'INV-0000000001', 60, 1, 1, 'GDG_A', ''),
(8, '2015-07-08', 'INV-000000001', 63, 1, 1, 'GDG_A', ''),
(9, '2015-07-08', 'INV-000000002', 48, 1, 1, 'GDG_A', ''),
(10, '2015-07-08', 'INV-150708001', 64, 1, 1, 'GDG_A', '');

-- --------------------------------------------------------

--
-- Table structure for table `kirimbarang_r`
--

CREATE TABLE IF NOT EXISTS `kirimbarang_r` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl` date NOT NULL,
  `noreferensi` varchar(30) NOT NULL,
  `product_id` int(11) NOT NULL,
  `satuan_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `gudang` varchar(10) NOT NULL,
  `info` text,
  `processed` enum('true','false') NOT NULL DEFAULT 'false',
  `processed_info` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='return terima barang' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `kirimbarang_r`
--

INSERT INTO `kirimbarang_r` (`id`, `tgl`, `noreferensi`, `product_id`, `satuan_id`, `qty`, `gudang`, `info`, `processed`, `processed_info`) VALUES
(1, '2014-12-08', 'INV-141122001', 2, 1, 1, 'GDG_A', 'Rusak', 'true', 'Replacement');

-- --------------------------------------------------------

--
-- Table structure for table `kontak`
--

CREATE TABLE IF NOT EXISTS `kontak` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `pass` varchar(50) DEFAULT NULL,
  `gender` tinyint(4) DEFAULT NULL,
  `akses` text,
  `jenis` varchar(10) NOT NULL,
  `kontak` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `kperson` varchar(100) DEFAULT NULL,
  `pinbb` varchar(30) DEFAULT NULL,
  `mulai` date NOT NULL,
  `aktif` enum('0','1') NOT NULL DEFAULT '0',
  `jabatan` varchar(100) NOT NULL,
  `notlp` varchar(30) DEFAULT NULL,
  `notlp2` varchar(30) DEFAULT NULL,
  `hp` varchar(30) DEFAULT NULL,
  `fax` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `info` text,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `kontak`
--

INSERT INTO `kontak` (`user_id`, `pass`, `gender`, `akses`, `jenis`, `kontak`, `alamat`, `kperson`, `pinbb`, `mulai`, `aktif`, `jabatan`, `notlp`, `notlp2`, `hp`, `fax`, `email`, `info`) VALUES
(1, 'e10adc3949ba59abbe56e057f20f883e', 1, 'user,add_user,edit_user,delete_user,lokasigudang,add_lokasigudang,edit_lokasigudang,delete_lokasigudang,matauang,add_matauang,edit_matauang,delete_matauang,satuan,add_satuan,edit_satuan,delete_satuan,jenisbarang,add_jenisbarang,edit_jenisbarang,delete_jenisbarang,masterbarang,add_masterbarang,edit_masterbarang,delete_masterbarang,jeniskontak,add_jeniskontak,edit_jeniskontak,delete_jeniskontak,masterkontak,add_masterkontak,edit_masterkontak,delete_masterkontak,detail_masterkontak,targetpenjualan,add_targetpenjualan,edit_targetpenjualan,delete_targetpenjualan,stokbarang,add_stokbarang,edit_stokbarang,delete_stokbarang,invoicepembelian,add_invoicepembelian,edit_invoicepembelian,delete_invoicepembelian,barangmasuk_invoicepembelian,edit_barangmasuk,delete_barangmasuk,barangreturmasuk,barangreturmasuk_invoicepembelian,edit_barangreturmasuk,delete_barangreturmasuk,invoicepenjualan,add_invoicepenjualan,edit_invoicepenjualan,delete_invoicepenjualan,barangkeluar_invoicepenjualan,edit_barangkeluar,delete_barangkeluar,barangreturkeluar,barangreturkeluar_invoicepenjualan,edit_barangreturkeluar,delete_barangreturkeluar,hutangjtempo,pembayaranhutang,add_pembayaranhutang,edit_pembayaranhutang,delete_pembayaranhutang,piutangjtempo,pembayaranpiutang,add_pembayaranpiutang,edit_pembayaranpiutang,delete_pembayaranpiutang,biayaops,add_biayaops,edit_biayaops,delete_biayaops,cbayar,add_cbayar,edit_cbayar,delete_cbayar,reportjualper_pm,reportjualper_customer,reportjualper_barang,reportrugilaba,report_masterbarang,report_kartustock,specialorder,', 'T001', 'Admin', '-', '', 'Indonesia', '2007-06-01', '1', 'Administrator', '081234567890', '', '', '-', 'admin@email.com', 'Admin'),
(2, '', 1, '', 'C001', 'General Customer', '-', '', '', '2014-01-09', '1', '', '0123456789', '0987654321', '', '', 'customer@optik.com', ''),
(3, '', 1, '', 'C001', 'fendy', 'Jl. Budi Mulia Gg: E no.4', '', '', '2014-03-04', '1', '', '0216412904', '081310552809', '', '', 'fendylord@gmail.com', 'Wirausahawan'),
(4, '', 1, '', 'S0001', 'PT. BEVERLY HILLS SPEKTA', 'Kelapa Gading', '', '', '2014-03-04', '1', '', '021-4210123', '08151001000', '', '', 'beverlyhills@yahoo.com', 'Givenchy, MercedesBenz, Timberland'),
(5, '4fd0468a4a55bee61e0426ac6ad18d18', 1, 'user,add_user,edit_user,delete_user,lokasigudang,add_lokasigudang,edit_lokasigudang,delete_lokasigudang,matauang,add_matauang,edit_matauang,delete_matauang,satuan,add_satuan,edit_satuan,delete_satuan,jenisbarang,add_jenisbarang,edit_jenisbarang,delete_jenisbarang,masterbarang,add_masterbarang,edit_masterbarang,delete_masterbarang,jeniskontak,add_jeniskontak,edit_jeniskontak,delete_jeniskontak,masterkontak,add_masterkontak,edit_masterkontak,delete_masterkontak,detail_masterkontak,targetpenjualan,add_targetpenjualan,edit_targetpenjualan,delete_targetpenjualan,stokbarang,add_stokbarang,edit_stokbarang,delete_stokbarang,invoicepembelian,add_invoicepembelian,edit_invoicepembelian,delete_invoicepembelian,barangmasuk_invoicepembelian,edit_barangmasuk,delete_barangmasuk,barangreturmasuk,barangreturmasuk_invoicepembelian,edit_barangreturmasuk,delete_barangreturmasuk,invoicepenjualan,add_invoicepenjualan,edit_invoicepenjualan,delete_invoicepenjualan,barangkeluar_invoicepenjualan,edit_barangkeluar,delete_barangkeluar,barangreturkeluar,barangreturkeluar_invoicepenjualan,edit_barangreturkeluar,delete_barangreturkeluar,hutangjtempo,pembayaranhutang,add_pembayaranhutang,edit_pembayaranhutang,delete_pembayaranhutang,piutangjtempo,pembayaranpiutang,add_pembayaranpiutang,edit_pembayaranpiutang,delete_pembayaranpiutang,biayaops,add_biayaops,edit_biayaops,delete_biayaops,cbayar,add_cbayar,edit_cbayar,delete_cbayar,reportjualper_pm,reportjualper_customer,reportjualper_barang,reportrugilaba,report_masterbarang,report_kartustock,', 'T001', 'mbullz', 'Binus', '', '277FC9E8', '2014-08-04', '1', '', '12345', '67890', '', '', 'm_bull_z@yahoo.com', 'Programmer'),
(6, NULL, NULL, NULL, 'B001', 'Cabang A', '', NULL, NULL, '2014-09-27', '1', '', NULL, NULL, NULL, NULL, NULL, NULL),
(8, NULL, 0, NULL, 'S0001', 'MR AB', 'CHINA TOWN', '', '12345678', '2014-12-07', '1', '', '12345', '12345', '', '', 'mrab@gmail.com', 'Info'),
(10, NULL, NULL, NULL, 'S0001', 'BY SYSTEM', '', NULL, NULL, '2015-02-21', '1', '', NULL, NULL, NULL, NULL, NULL, NULL),
(11, '', 0, '', 'C001', 'Tes1', '', '', '', '2015-02-21', '1', '', '1234567', '', '', '', '', ''),
(13, '4fd0468a4a55bee61e0426ac6ad18d18', 1, '', 'T002', 'Tes2', 'Jalan Tes2', '', '', '2015-02-23', '1', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `masukbarang`
--

CREATE TABLE IF NOT EXISTS `masukbarang` (
  `referensi` varchar(30) NOT NULL,
  `tgl` date NOT NULL,
  `jtempo` date DEFAULT NULL,
  `sales` int(11) DEFAULT '0',
  `supplier` int(11) NOT NULL,
  `matauang` varchar(10) NOT NULL,
  `total` int(11) NOT NULL DEFAULT '0',
  `info` text,
  `lunas` enum('0','1') DEFAULT '0',
  `tipe_pembayaran` enum('Cash','Jatuh Tempo') NOT NULL DEFAULT 'Cash',
  PRIMARY KEY (`referensi`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `masukbarang`
--

INSERT INTO `masukbarang` (`referensi`, `tgl`, `jtempo`, `sales`, `supplier`, `matauang`, `total`, `info`, `lunas`, `tipe_pembayaran`) VALUES
('PO-08122216430', '2014-12-08', '1900-01-01', 0, 4, 'IDR', 0, '', '1', 'Cash'),
('PO-08122216431', '2014-12-08', '1900-01-01', 0, 8, 'IDR', 0, '', '1', 'Cash'),
('PO-18121939420', '2014-12-18', '1900-01-01', 0, 8, 'IDR', 0, '', '1', 'Cash'),
('PO-21020959190', '2015-02-21', '1900-01-01', 0, 10, 'IDR', 0, '', '1', 'Cash'),
('PO-21021152480', '2015-02-21', '1900-01-01', 0, 10, 'IDR', 0, '', '1', 'Cash'),
('PO-12031758420', '2015-03-12', '1900-01-01', 0, 10, 'IDR', 0, '', '1', 'Cash'),
('PO-12032154560', '2015-03-12', '1900-01-01', 0, 8, 'IDR', 0, '', '1', 'Cash'),
('PO-20032215360', '2015-03-20', '1900-01-01', 0, 10, 'IDR', 0, '', '1', 'Cash'),
('PO-20032218200', '2015-03-20', '1900-01-01', 0, 10, 'IDR', 0, '', '1', 'Cash'),
('PO-21031551500', '2015-03-20', '1900-01-01', 0, 8, 'IDR', 0, '', '0', 'Cash'),
('PO-06071750250', '2015-07-06', '1900-01-01', 0, 4, 'IDR', 0, '', '0', 'Cash'),
('PO-06071918280', '2015-07-06', '1900-01-01', 0, 8, 'IDR', 0, '', '0', 'Cash'),
('PO-08071638310', '2015-07-08', '1900-01-01', 0, 8, 'IDR', 0, '', '0', 'Cash'),
('PO-08071642160', '2015-07-08', '1900-01-01', 0, 8, 'IDR', 0, '', '0', 'Cash'),
('PO-08071737230', '2015-07-08', '1900-01-01', 0, 8, 'IDR', 0, '', '0', 'Cash'),
('PO-08071738080', '2015-07-08', '1900-01-01', 0, 8, 'IDR', 0, '', '0', 'Cash');

-- --------------------------------------------------------

--
-- Table structure for table `matauang`
--

CREATE TABLE IF NOT EXISTS `matauang` (
  `kode` varchar(10) NOT NULL,
  `matauang` varchar(100) NOT NULL,
  `info` text,
  PRIMARY KEY (`kode`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `matauang`
--

INSERT INTO `matauang` (`kode`, `matauang`, `info`) VALUES
('IDR', 'Rupiah', 'Mata Uang Rupiah');

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE IF NOT EXISTS `satuan` (
  `satuan_id` int(11) NOT NULL AUTO_INCREMENT,
  `satuan` varchar(100) NOT NULL,
  `info` text,
  PRIMARY KEY (`satuan_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`satuan_id`, `satuan`, `info`) VALUES
(1, 'pcs', 'Pcs'),
(2, 'KILO', 'KILO');

-- --------------------------------------------------------

--
-- Table structure for table `stokbarang`
--

CREATE TABLE IF NOT EXISTS `stokbarang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gudang` varchar(10) NOT NULL,
  `product_id` int(11) NOT NULL,
  `satuan_id` int(11) NOT NULL,
  `qty` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `stokbarang`
--

INSERT INTO `stokbarang` (`id`, `gudang`, `product_id`, `satuan_id`, `qty`) VALUES
(1, 'GDG_A', 2, 1, 2),
(2, 'GDG_A', 47, 1, -1),
(3, 'GDG_A', 58, 1, -1),
(4, 'GDG_A', 59, 1, 0),
(5, 'GDG_A', 60, 1, 0),
(6, 'GDG_A', 63, 1, 0),
(7, 'GDG_A', 48, 1, 0),
(8, 'GDG_A', 64, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `subkontak`
--

CREATE TABLE IF NOT EXISTS `subkontak` (
  `kode` varchar(10) NOT NULL,
  `kontak` varchar(10) NOT NULL,
  `alamat` text NOT NULL,
  `kodepos` varchar(8) NOT NULL,
  `kota` varchar(100) NOT NULL,
  `propinsi` varchar(100) NOT NULL,
  `negara` varchar(100) NOT NULL,
  `notlp` varchar(30) DEFAULT NULL,
  `fax` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `targetpm`
--

CREATE TABLE IF NOT EXISTS `targetpm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kontak` varchar(10) NOT NULL,
  `periode` varchar(8) NOT NULL,
  `target` int(11) NOT NULL DEFAULT '0',
  `info` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `targetpm_d`
--

CREATE TABLE IF NOT EXISTS `targetpm_d` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `barang` varchar(10) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` varchar(11) NOT NULL,
  `kontak` varchar(10) NOT NULL,
  `periode` varchar(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `terimabarang`
--

CREATE TABLE IF NOT EXISTS `terimabarang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl` date NOT NULL,
  `noreferensi` varchar(30) NOT NULL,
  `product_id` int(11) NOT NULL,
  `satuan_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `gudang` varchar(10) NOT NULL,
  `info` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `terimabarang_r`
--

CREATE TABLE IF NOT EXISTS `terimabarang_r` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl` date NOT NULL,
  `noreferensi` varchar(30) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `satuan_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `gudang` varchar(10) NOT NULL,
  `info` text,
  `processed` enum('true','false') NOT NULL DEFAULT 'false',
  `processed_info` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='return terima barang' AUTO_INCREMENT=6 ;

--
-- Dumping data for table `terimabarang_r`
--

INSERT INTO `terimabarang_r` (`id`, `tgl`, `noreferensi`, `product_id`, `satuan_id`, `qty`, `gudang`, `info`, `processed`, `processed_info`) VALUES
(1, '2014-12-08', '', 11, 1, 1, 'GDG_A', 'Rusak Tangkai', 'true', 'Done OK'),
(2, '2014-12-18', '', 40, 1, 1, 'GDG_A', 'Rusak', 'false', ''),
(3, '2015-02-21', '', 46, 1, 1, 'GDG_A', 'Rusak', 'false', ''),
(4, '2015-02-21', '', 7, 1, 2, 'GDG_A', 'Cacat', 'false', ''),
(5, '2015-02-21', '', 41, 1, 1, 'GDG_A', 'Cacat', 'false', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
