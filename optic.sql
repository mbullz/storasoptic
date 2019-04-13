-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2019 at 04:41 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `optic`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_cleanup_trans` ()  BEGIN
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

CREATE TABLE `aruskas` (
  `id` int(11) NOT NULL,
  `carabayar_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL DEFAULT '0',
  `tipe` enum('hutang','piutang','operasional') NOT NULL DEFAULT 'operasional',
  `tgl` date NOT NULL,
  `opr` int(11) NOT NULL,
  `referensi` varchar(30) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `matauang_id` int(11) NOT NULL DEFAULT '0',
  `info` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `product_id` int(11) NOT NULL,
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
  `last_update_date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `carabayar`
--

CREATE TABLE `carabayar` (
  `carabayar_id` int(11) NOT NULL,
  `pembayaran` varchar(100) NOT NULL,
  `info` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

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

CREATE TABLE `color_type` (
  `color_type_id` int(11) NOT NULL,
  `color` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE `config` (
  `config_id` int(11) NOT NULL,
  `config` text NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`config_id`, `config`, `value`) VALUES
(1, 'company_name', 'ITC OPTIK'),
(2, 'company_address', 'Jl. Juanda 3 No. 29c , Jakarta Pusat'),
(3, 'company_telephone', 'Telp. (021) 1234567'),
(4, 'base_url', '/optic/');

-- --------------------------------------------------------

--
-- Table structure for table `divisi`
--

CREATE TABLE `divisi` (
  `kode` varchar(10) NOT NULL,
  `divisi` varchar(100) NOT NULL,
  `info` text
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

CREATE TABLE `dkeluarbarang` (
  `id` int(11) NOT NULL,
  `keluarbarang_id` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL DEFAULT '0',
  `satuan_id` int(11) NOT NULL DEFAULT '0',
  `harga` int(11) NOT NULL DEFAULT '0',
  `qty` int(11) NOT NULL DEFAULT '0',
  `tdiskon` enum('0','1') NOT NULL DEFAULT '0',
  `diskon` float NOT NULL DEFAULT '0',
  `subtotal` decimal(18,3) NOT NULL DEFAULT '0.000',
  `lensa` int(11) NOT NULL DEFAULT '0',
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
  `info` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dmasukbarang`
--

CREATE TABLE `dmasukbarang` (
  `id` int(11) NOT NULL,
  `masukbarang_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `satuan_id` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `tdiskon` enum('0','1') NOT NULL DEFAULT '0',
  `diskon` float NOT NULL DEFAULT '0',
  `subtotal` varchar(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `frame_type`
--

CREATE TABLE `frame_type` (
  `frame_type_id` int(11) NOT NULL,
  `frame` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `frame_type`
--

INSERT INTO `frame_type` (`frame_type_id`, `frame`) VALUES
(1, 'METAL FRAME'),
(2, 'FRAMELESS'),
(3, 'PLASTIC FRAME'),
(4, 'SUNGLASSES');

-- --------------------------------------------------------

--
-- Table structure for table `gudang`
--

CREATE TABLE `gudang` (
  `gudang_id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `gudang` varchar(100) NOT NULL,
  `info` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gudang`
--

INSERT INTO `gudang` (`gudang_id`, `kode`, `gudang`, `info`) VALUES
(1, 'GDG_A', 'Gudang A', 'Gudang A');

-- --------------------------------------------------------

--
-- Table structure for table `jenisbarang`
--

CREATE TABLE `jenisbarang` (
  `brand_id` int(11) NOT NULL,
  `kode` varchar(10) DEFAULT NULL,
  `jenis` varchar(100) NOT NULL,
  `info` text,
  `tipe` int(11) DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jeniskontak`
--

CREATE TABLE `jeniskontak` (
  `kode` varchar(10) NOT NULL,
  `klasifikasi` enum('customer','supplier','karyawan','sales','cabang') NOT NULL,
  `jenis` varchar(100) NOT NULL,
  `info` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jeniskontak`
--

INSERT INTO `jeniskontak` (`kode`, `klasifikasi`, `jenis`, `info`) VALUES
('T001', 'karyawan', 'Karyawan', 'Karyawan'),
('C001', 'customer', 'Customer', 'Customer'),
('T002', 'sales', 'Sales', 'Sales'),
('S001', 'supplier', 'Supplier', 'Supplier'),
('B001', 'cabang', 'Cabang', 'Cabang');

-- --------------------------------------------------------

--
-- Table structure for table `keluarbarang`
--

CREATE TABLE `keluarbarang` (
  `keluarbarang_id` int(11) NOT NULL,
  `referensi` varchar(30) NOT NULL,
  `tgl` date NOT NULL,
  `jtempo` date DEFAULT NULL,
  `client` int(11) NOT NULL DEFAULT '0',
  `sales` int(11) NOT NULL DEFAULT '0',
  `matauang_id` int(11) NOT NULL DEFAULT '0',
  `tdiskon` enum('0','1') NOT NULL DEFAULT '1',
  `diskon` decimal(18,3) NOT NULL DEFAULT '0.000',
  `ppn` float NOT NULL DEFAULT '0',
  `total` decimal(18,3) NOT NULL DEFAULT '0.000',
  `info` text,
  `lunas` enum('0','1') NOT NULL DEFAULT '0',
  `tipe_pembayaran` enum('Cash','Jatuh Tempo') NOT NULL DEFAULT 'Cash',
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kirimbarang`
--

CREATE TABLE `kirimbarang` (
  `id` int(11) NOT NULL,
  `keluarbarang_id` int(11) NOT NULL DEFAULT '0',
  `tgl` date NOT NULL,
  `product_id` int(11) NOT NULL,
  `satuan_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `gudang_id` int(11) NOT NULL DEFAULT '0',
  `info` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kirimbarang_r`
--

CREATE TABLE `kirimbarang_r` (
  `id` int(11) NOT NULL,
  `kirimbarang_id` int(11) NOT NULL DEFAULT '0',
  `keluarbarang_id` int(11) NOT NULL DEFAULT '0',
  `tgl` date NOT NULL,
  `product_id` int(11) NOT NULL,
  `satuan_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `gudang_id` int(11) NOT NULL,
  `info` text,
  `processed` enum('true','false') NOT NULL DEFAULT 'false',
  `processed_info` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='return terima barang';

-- --------------------------------------------------------

--
-- Table structure for table `kontak`
--

CREATE TABLE `kontak` (
  `user_id` int(11) NOT NULL,
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
  `info` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kontak`
--

INSERT INTO `kontak` (`user_id`, `pass`, `gender`, `akses`, `jenis`, `kontak`, `alamat`, `kperson`, `pinbb`, `mulai`, `aktif`, `jabatan`, `notlp`, `notlp2`, `hp`, `fax`, `email`, `info`) VALUES
(1, '21232f297a57a5a743894a0e4a801fc3', 1, 'user,add_user,edit_user,delete_user,lokasigudang,add_lokasigudang,edit_lokasigudang,delete_lokasigudang,matauang,add_matauang,edit_matauang,delete_matauang,satuan,add_satuan,edit_satuan,delete_satuan,jenisbarang,add_jenisbarang,edit_jenisbarang,delete_jenisbarang,masterbarang,add_masterbarang,edit_masterbarang,delete_masterbarang,jeniskontak,add_jeniskontak,edit_jeniskontak,delete_jeniskontak,masterkontak,add_masterkontak,edit_masterkontak,delete_masterkontak,detail_masterkontak,targetpenjualan,add_targetpenjualan,edit_targetpenjualan,delete_targetpenjualan,stokbarang,add_stokbarang,edit_stokbarang,delete_stokbarang,invoicepembelian,add_invoicepembelian,edit_invoicepembelian,delete_invoicepembelian,barangmasuk_invoicepembelian,edit_barangmasuk,delete_barangmasuk,barangreturmasuk,barangreturmasuk_invoicepembelian,edit_barangreturmasuk,delete_barangreturmasuk,invoicepenjualan,add_invoicepenjualan,edit_invoicepenjualan,delete_invoicepenjualan,barangkeluar_invoicepenjualan,edit_barangkeluar,delete_barangkeluar,barangreturkeluar,barangreturkeluar_invoicepenjualan,edit_barangreturkeluar,delete_barangreturkeluar,hutangjtempo,pembayaranhutang,add_pembayaranhutang,edit_pembayaranhutang,delete_pembayaranhutang,piutangjtempo,pembayaranpiutang,add_pembayaranpiutang,edit_pembayaranpiutang,delete_pembayaranpiutang,biayaops,add_biayaops,edit_biayaops,delete_biayaops,cbayar,add_cbayar,edit_cbayar,delete_cbayar,reportjualper_pm,reportjualper_customer,reportjualper_barang,reportrugilaba,report_masterbarang,report_kartustock,specialorder,', 'T001', 'Admin', '', '', '', '2007-06-01', '1', 'Administrator', '', '', '', '', '', 'Admin'),
(2, '', 1, '', 'C001', 'GENERAL CUSTOMER', '', '', '', '2014-01-09', '1', '', '', '', '', '', '', ''),
(5, 'ee11cbb19052e40b07aac0ca060c23ee', 1, 'user,add_user,edit_user,delete_user,lokasigudang,add_lokasigudang,edit_lokasigudang,delete_lokasigudang,matauang,add_matauang,edit_matauang,delete_matauang,satuan,add_satuan,edit_satuan,delete_satuan,jenisbarang,add_jenisbarang,edit_jenisbarang,delete_jenisbarang,masterbarang,add_masterbarang,edit_masterbarang,delete_masterbarang,jeniskontak,add_jeniskontak,edit_jeniskontak,delete_jeniskontak,masterkontak,add_masterkontak,edit_masterkontak,delete_masterkontak,detail_masterkontak,targetpenjualan,add_targetpenjualan,edit_targetpenjualan,delete_targetpenjualan,stokbarang,add_stokbarang,edit_stokbarang,delete_stokbarang,invoicepembelian,add_invoicepembelian,edit_invoicepembelian,delete_invoicepembelian,barangmasuk_invoicepembelian,edit_barangmasuk,delete_barangmasuk,barangreturmasuk,barangreturmasuk_invoicepembelian,edit_barangreturmasuk,delete_barangreturmasuk,invoicepenjualan,add_invoicepenjualan,edit_invoicepenjualan,delete_invoicepenjualan,barangkeluar_invoicepenjualan,edit_barangkeluar,delete_barangkeluar,barangreturkeluar,barangreturkeluar_invoicepenjualan,edit_barangreturkeluar,delete_barangreturkeluar,hutangjtempo,pembayaranhutang,add_pembayaranhutang,edit_pembayaranhutang,delete_pembayaranhutang,piutangjtempo,pembayaranpiutang,add_pembayaranpiutang,edit_pembayaranpiutang,delete_pembayaranpiutang,biayaops,add_biayaops,edit_biayaops,delete_biayaops,cbayar,add_cbayar,edit_cbayar,delete_cbayar,reportjualper_pm,reportjualper_customer,reportjualper_barang,reportrugilaba,report_masterbarang,report_kartustock,', 'T001', 'User', '', '', '', '2019-01-01', '1', '', '', '', '', '', '', ''),
(6, NULL, NULL, NULL, 'B001', 'CABANG A', '', NULL, NULL, '2014-09-27', '1', '', NULL, NULL, NULL, NULL, NULL, NULL),
(10, NULL, NULL, NULL, 'S001', 'BY SYSTEM', '', NULL, NULL, '2015-02-21', '1', '', NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `masukbarang`
--

CREATE TABLE `masukbarang` (
  `masukbarang_id` int(11) NOT NULL,
  `referensi` varchar(30) NOT NULL,
  `tgl` date NOT NULL,
  `jtempo` date DEFAULT NULL,
  `sales` int(11) DEFAULT '0',
  `supplier` int(11) NOT NULL,
  `matauang_id` int(11) NOT NULL DEFAULT '0',
  `total` int(11) NOT NULL DEFAULT '0',
  `info` text,
  `lunas` enum('0','1') DEFAULT '0',
  `tipe_pembayaran` enum('Cash','Jatuh Tempo') NOT NULL DEFAULT 'Cash',
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `matauang`
--

CREATE TABLE `matauang` (
  `matauang_id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `matauang` varchar(100) NOT NULL,
  `info` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `matauang`
--

INSERT INTO `matauang` (`matauang_id`, `kode`, `matauang`, `info`) VALUES
(1, 'IDR', 'Rupiah', 'Rupiah');

-- --------------------------------------------------------

--
-- Table structure for table `satuan`
--

CREATE TABLE `satuan` (
  `satuan_id` int(11) NOT NULL,
  `satuan` varchar(100) NOT NULL,
  `info` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `satuan`
--

INSERT INTO `satuan` (`satuan_id`, `satuan`, `info`) VALUES
(1, 'PCS', 'PCS');

-- --------------------------------------------------------

--
-- Table structure for table `stokbarang`
--

CREATE TABLE `stokbarang` (
  `id` int(11) NOT NULL,
  `gudang_id` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL,
  `satuan_id` int(11) NOT NULL,
  `qty` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subkontak`
--

CREATE TABLE `subkontak` (
  `kode` varchar(10) NOT NULL,
  `kontak` varchar(10) NOT NULL,
  `alamat` text NOT NULL,
  `kodepos` varchar(8) NOT NULL,
  `kota` varchar(100) NOT NULL,
  `propinsi` varchar(100) NOT NULL,
  `negara` varchar(100) NOT NULL,
  `notlp` varchar(30) DEFAULT NULL,
  `fax` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `targetpm`
--

CREATE TABLE `targetpm` (
  `id` int(11) NOT NULL,
  `kontak` varchar(10) NOT NULL,
  `periode` varchar(8) NOT NULL,
  `target` int(11) NOT NULL DEFAULT '0',
  `info` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `targetpm_d`
--

CREATE TABLE `targetpm_d` (
  `id` int(11) NOT NULL,
  `barang` varchar(10) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` varchar(11) NOT NULL,
  `kontak` varchar(10) NOT NULL,
  `periode` varchar(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `terimabarang`
--

CREATE TABLE `terimabarang` (
  `id` int(11) NOT NULL,
  `masukbarang_id` int(11) NOT NULL DEFAULT '0',
  `tgl` date NOT NULL,
  `noreferensi` varchar(30) NOT NULL,
  `product_id` int(11) NOT NULL,
  `satuan_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `gudang_id` int(11) NOT NULL,
  `info` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `terimabarang_r`
--

CREATE TABLE `terimabarang_r` (
  `id` int(11) NOT NULL,
  `terimabarang_id` int(11) NOT NULL DEFAULT '0',
  `masukbarang_id` int(11) NOT NULL DEFAULT '0',
  `tgl` date NOT NULL,
  `product_id` int(11) NOT NULL,
  `satuan_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `gudang_id` int(11) NOT NULL,
  `info` text,
  `processed` enum('true','false') NOT NULL DEFAULT 'false',
  `processed_info` text
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='return terima barang';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aruskas`
--
ALTER TABLE `aruskas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `carabayar`
--
ALTER TABLE `carabayar`
  ADD PRIMARY KEY (`carabayar_id`);

--
-- Indexes for table `color_type`
--
ALTER TABLE `color_type`
  ADD PRIMARY KEY (`color_type_id`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`config_id`);

--
-- Indexes for table `divisi`
--
ALTER TABLE `divisi`
  ADD PRIMARY KEY (`kode`);

--
-- Indexes for table `dkeluarbarang`
--
ALTER TABLE `dkeluarbarang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dmasukbarang`
--
ALTER TABLE `dmasukbarang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frame_type`
--
ALTER TABLE `frame_type`
  ADD PRIMARY KEY (`frame_type_id`);

--
-- Indexes for table `gudang`
--
ALTER TABLE `gudang`
  ADD PRIMARY KEY (`gudang_id`);

--
-- Indexes for table `jenisbarang`
--
ALTER TABLE `jenisbarang`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `jeniskontak`
--
ALTER TABLE `jeniskontak`
  ADD PRIMARY KEY (`kode`);

--
-- Indexes for table `keluarbarang`
--
ALTER TABLE `keluarbarang`
  ADD PRIMARY KEY (`keluarbarang_id`);

--
-- Indexes for table `kirimbarang`
--
ALTER TABLE `kirimbarang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kirimbarang_r`
--
ALTER TABLE `kirimbarang_r`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `masukbarang`
--
ALTER TABLE `masukbarang`
  ADD PRIMARY KEY (`masukbarang_id`);

--
-- Indexes for table `matauang`
--
ALTER TABLE `matauang`
  ADD PRIMARY KEY (`matauang_id`);

--
-- Indexes for table `satuan`
--
ALTER TABLE `satuan`
  ADD PRIMARY KEY (`satuan_id`);

--
-- Indexes for table `stokbarang`
--
ALTER TABLE `stokbarang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subkontak`
--
ALTER TABLE `subkontak`
  ADD PRIMARY KEY (`kode`);

--
-- Indexes for table `targetpm`
--
ALTER TABLE `targetpm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `targetpm_d`
--
ALTER TABLE `targetpm_d`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terimabarang`
--
ALTER TABLE `terimabarang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terimabarang_r`
--
ALTER TABLE `terimabarang_r`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aruskas`
--
ALTER TABLE `aruskas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `carabayar`
--
ALTER TABLE `carabayar`
  MODIFY `carabayar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `color_type`
--
ALTER TABLE `color_type`
  MODIFY `color_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `config`
--
ALTER TABLE `config`
  MODIFY `config_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `dkeluarbarang`
--
ALTER TABLE `dkeluarbarang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dmasukbarang`
--
ALTER TABLE `dmasukbarang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `frame_type`
--
ALTER TABLE `frame_type`
  MODIFY `frame_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `gudang`
--
ALTER TABLE `gudang`
  MODIFY `gudang_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `jenisbarang`
--
ALTER TABLE `jenisbarang`
  MODIFY `brand_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `keluarbarang`
--
ALTER TABLE `keluarbarang`
  MODIFY `keluarbarang_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `kirimbarang`
--
ALTER TABLE `kirimbarang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `kirimbarang_r`
--
ALTER TABLE `kirimbarang_r`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `kontak`
--
ALTER TABLE `kontak`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `masukbarang`
--
ALTER TABLE `masukbarang`
  MODIFY `masukbarang_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `matauang`
--
ALTER TABLE `matauang`
  MODIFY `matauang_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `satuan`
--
ALTER TABLE `satuan`
  MODIFY `satuan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `stokbarang`
--
ALTER TABLE `stokbarang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `targetpm`
--
ALTER TABLE `targetpm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `targetpm_d`
--
ALTER TABLE `targetpm_d`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `terimabarang`
--
ALTER TABLE `terimabarang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `terimabarang_r`
--
ALTER TABLE `terimabarang_r`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
