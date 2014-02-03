-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 27, 2014 at 11:20 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `bansos`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menu`
--

DROP TABLE IF EXISTS `tbl_menu`;
CREATE TABLE IF NOT EXISTS `tbl_menu` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `nomorurut` int(10) unsigned default NULL,
  `level` int(10) unsigned default NULL,
  `referensi` int(10) unsigned default NULL,
  `judul` varchar(255) default NULL,
  `url` varchar(50) default NULL,
  `keterangan` varchar(255) default NULL,
  `target` varchar(50) default NULL,
  `image` varchar(50) default NULL,
  `bobot` float default NULL,
  `ctime` date default NULL,
  `tampil` tinyint(1) default NULL,
  `hirarki` tinyint(1) default NULL,
  `basishirarki` varchar(100) default NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `nomorurut` (`nomorurut`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `tbl_menu`
--

INSERT INTO `tbl_menu` (`id`, `nomorurut`, `level`, `referensi`, `judul`, `url`, `keterangan`, `target`, `image`, `bobot`, `ctime`, `tampil`, `hirarki`, `basishirarki`) VALUES
(1, 1, 0, 0, 'Setting', '', 'Setting', 'mainFrame', '', 4, '2013-03-14', 1, 0, ''),
(2, 2, 1, 1, 'User', '/admin/user.php', 'User', 'mainFrame', NULL, 10, '2013-03-14', 1, 0, NULL),
(3, 3, 1, 1, 'Menu', '/admin/menu.php', 'Menu', 'mainFrame', NULL, 20, '2013-03-14', 1, 0, NULL),
(4, 4, 1, 1, 'Inquiry Access', '/admin/inquiry_access.php', 'Inquiry Access', 'mainFrame', NULL, 40, '2013-03-14', 1, 0, NULL),
(5, 5, 1, 1, 'Function Access', '/admin/function_access.php', 'Function Access', 'mainFrame', NULL, 30, '2013-03-14', 1, 0, NULL),
(6, 6, 0, 0, 'Log Out', '/index.php?act=logout', 'Log Out', '_top', '/img/logout.gif', 100, '2013-03-14', 1, 0, NULL),
(8, 7, 0, 0, 'Pelayanan', '', 'Pelayanan', 'mainFrame', NULL, 1, '2013-03-15', 1, 1, NULL),
(9, 8, 1, 7, 'Hibah', '', 'Hibah', 'mainFrame', NULL, 1, '2013-03-15', 1, 0, NULL),
(10, 9, 2, 8, 'Pendaftaran Hibah', '/hibah.php?act=add', 'Pendaftaran Hibah', 'mainFrame', NULL, 1, '2013-03-15', 1, 0, NULL),
(11, 10, 2, 8, 'Data Pemohon Hibah', '/hibah.php', 'Data Pemohon Hibah', 'mainFrame', NULL, 2, '2013-03-15', 1, 0, NULL),
(12, 11, 0, 0, 'Referensi', '', 'Referensi', 'mainFrame', NULL, 2, '2013-03-16', 1, 0, NULL),
(13, 12, 1, 11, 'Data OPD', '/referensi/opd.php', 'Data OPD', 'mainFrame', NULL, 1, '2013-03-16', 1, 0, NULL),
(14, 13, 1, 11, 'Wilayah Administrasi', '/referensi/administrasi.php', 'Wilayah Administrasi', 'mainFrame', '', 4, '2013-03-16', 1, 0, ''),
(16, 15, 1, 7, 'Bantuan Sosial', '', 'Bantuan Sosial', 'mainFrame', NULL, 2, '2013-03-19', 1, 0, NULL),
(17, 16, 2, 15, 'Pendaftaran Bantuan Sosial', '/bansos.php?act=add', 'Pendaftaran Bantuan Sosial', 'mainFrame', NULL, 1, '2013-03-22', 1, 0, NULL),
(18, 17, 2, 15, 'Data Pemohon Bantuan Sosial', '/bansos.php', 'Data Pemohon Bantuan Sosial', 'mainFrame', NULL, 2, '2013-12-01', 1, 0, NULL),
(19, 18, 2, 8, 'Evaluasi Hibah OPD', '/evaluasi_hibah_opd.php', 'Evaluasi Hibah OPD', 'mainFrame', NULL, 3, '2013-12-02', 1, 0, NULL),
(20, 19, 1, 11, 'Data Bank', '/referensi/bank.php', 'Data Bank', 'mainFrame', NULL, 2, '2013-12-23', 1, 0, NULL),
(21, 20, 2, 8, 'Pertimbangan Hibah TAPD', '/evaluasi_hibah_tapd.php', 'Pertimbangan Hibah TAPD', 'mainFrame', NULL, 4, '2013-12-24', 1, 0, NULL),
(22, 21, 1, 11, 'Penandatanganan', '/referensi/penandatanganan.php', 'Penandatanganan', 'mainFrame', '', 5, NULL, 1, 0, ''),
(23, 22, 2, 8, 'Daftar Nama Penerima Hibah', '/penerima_hibah.php', 'Daftar Nama Penerima Hibah', 'mainFrame', '', 6, NULL, 1, 0, ''),
(24, 23, 2, 8, 'Pencairan Hibah', '/pencairan_hibah.php', 'Pencairan Hibah', 'mainFrame', '', 7, NULL, 1, 0, ''),
(25, 24, 2, 15, 'Evaluasi Bantuan Sosial OPD', '/evaluasi_bansos_opd.php', 'Evaluasi Bantuan Sosial OPD', 'mainFrame', NULL, 3, NULL, 1, 0, NULL),
(26, 25, 2, 15, 'Pertimbangan Bantuan Sosial TAPD', '/evaluasi_bansos_tapd.php', 'Pertimbangan Bantuan Sosial TAPD', 'mainFrame', '', 4, NULL, 1, 0, ''),
(27, 26, 2, 15, 'Daftar Nama Penerima Bantuan Sosial', '/penerima_bansos.php', 'Daftar Nama Penerima Bantuan Sosial', 'mainFrame', '', 6, NULL, 1, 0, ''),
(28, 27, 2, 15, 'Pencairan Bantuan Sosial', '/pencairan_bansos.php', 'Pencairan Bantuan Sosial', 'mainFrame', '', 7, NULL, 1, 0, ''),
(29, 28, 2, 8, 'Monitoring dan Evaluasi Hibah', '/monev_hibah.php', 'Monitoring dan Evaluasi Hibah', 'mainFrame', '', 8, NULL, 1, 0, ''),
(30, 29, 2, 15, 'Monitoring dan Evaluasi Bantuan Sosial', '/monev_bansos.php', 'Monitoring dan Evaluasi Bantuan Sosial', 'mainFrame', '', 8, NULL, 1, 0, ''),
(31, 30, 2, 8, 'LPJ Hibah', '/lpj_hibah.php', 'LPJ Hibah', 'mainFrame', '', 9, NULL, 1, 0, ''),
(32, 31, 2, 15, 'LPJ Bansos', '/lpj_bansos.php', 'LPJ Bansos', 'mainFrame', '', 9, NULL, 1, 0, ''),
(33, 32, 1, 11, 'Data Rekening', '/referensi/rekening.php', 'Data Rekening', 'mainFrame', '', 3, NULL, 1, 0, ''),
(34, 33, 0, 0, 'Laporan', '', 'Laporan', 'mainFrame', '', 3, NULL, 1, 0, ''),
(35, 34, 1, 33, 'Laporan Hibah dan Bantuan Sosial', '/reports/basic_reports.php', 'Laporan Hibah dan Bantuan Sosial', 'mainFrame', '', 1, NULL, 1, 0, ''),
(36, 35, 0, 0, 'Ganti Password', '/admin/ganti_password.php?act=update', 'Ganti Password', 'mainFrame', '/images/button_lock_s.gif', 5, NULL, 1, 0, ''),
(39, 36, 1, 7, 'Export Data', '/export_data.php', 'Export Data', 'mainFrame', '', 3, NULL, 1, 0, ''),
(40, 37, 1, 33, 'Laporan Pencairan', '/reports/laporan_pencairan.php', 'Laporan Pencairan', 'mainFrame', '', 2, NULL, 1, 0, ''),
(41, 38, 2, 8, 'Input Data Rekening Hibah', '/rekening_hibah.php', 'Input Data Rekening Hibah', 'mainFrame', '', 5, NULL, 1, 0, ''),
(42, 39, 2, 15, 'Input Data Rekening Bantuan Sosial', '/rekening_bansos.php', 'Input Data Rekening Bantuan Sosial', 'mainFrame', '', 5, NULL, 1, 0, ''),
(43, 40, 1, 33, 'Laporan Pertanggungjawaban', '/reports/laporan_pertanggungjawaban.php', 'Laporan Pertanggungjawaban', 'mainFrame', '', 3, NULL, 1, 0, '');
