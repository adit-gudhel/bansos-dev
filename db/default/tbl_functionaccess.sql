-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 27, 2014 at 11:19 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `bansos`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_functionaccess`
--

DROP TABLE IF EXISTS `tbl_functionaccess`;
CREATE TABLE IF NOT EXISTS `tbl_functionaccess` (
  `name` varchar(255) default NULL,
  `read_priv` int(4) default NULL,
  `edit_priv` int(4) default NULL,
  `delete_priv` int(4) default NULL,
  `add_priv` int(4) default NULL,
  `url` varchar(255) default NULL,
  `id` int(4) default NULL,
  `menu_id` int(4) default NULL,
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_functionaccess`
--

INSERT INTO `tbl_functionaccess` (`name`, `read_priv`, `edit_priv`, `delete_priv`, `add_priv`, `url`, `id`, `menu_id`) VALUES
('BK', 1, 1, 1, 1, '', NULL, 7),
('BK', 1, 1, 1, 1, '', NULL, 8),
('BK', 1, 1, 1, 1, '/hibah.php?act=add', NULL, 9),
('BK', 1, 1, 1, 1, '/hibah.php', NULL, 10),
('BK', 1, 1, 1, 1, '', NULL, 15),
('BK', 1, 1, 1, 1, '/bansos.php?act=add', NULL, 16),
('BK', 1, 1, 1, 1, '/bansos.php', NULL, 17),
('BK', 1, 1, 1, 1, '', NULL, 33),
('BK', 1, 1, 1, 1, '/reports/basic_reports.php', NULL, 34),
('BK', 1, 1, 1, 1, '/admin/ganti_password.php', NULL, 35),
('BK', 1, 1, 1, 1, '/index.php?act=logout', NULL, 6),
('OPD', 1, 1, 1, 1, '', NULL, 7),
('OPD', 1, 1, 1, 1, '', NULL, 8),
('OPD', 1, NULL, NULL, NULL, '/hibah.php', NULL, 10),
('OPD', 1, 1, 1, 1, '/evaluasi_hibah_opd.php', NULL, 18),
('OPD', 1, 1, 1, 1, '', NULL, 15),
('OPD', 1, NULL, NULL, NULL, '/bansos.php', NULL, 17),
('OPD', 1, 1, 1, 1, '/evaluasi_bansos_opd.php', NULL, 24),
('OPD', 1, 1, 1, 1, '', NULL, 11),
('OPD', 1, 1, 1, 1, '/referensi/opd.php', NULL, 12),
('OPD', 1, 1, 1, 1, '/referensi/administrasi.php', NULL, 13),
('OPD', 1, 1, 1, 1, '/admin/ganti_password.php?act=update', NULL, 35),
('OPD', 1, 1, 1, 1, '/index.php?act=logout', NULL, 6),
('TAPD', 1, 1, 1, 1, '', NULL, 7),
('TAPD', 1, 1, 1, 1, '', NULL, 8),
('TAPD', 1, 1, 1, 1, '/evaluasi_hibah_tapd.php', NULL, 20),
('TAPD', 1, 1, 1, 1, '', NULL, 15),
('TAPD', 1, 1, 1, 1, '/evaluasi_bansos_tapd.php', NULL, 25),
('TAPD', 1, 1, 1, 1, '', NULL, 11),
('TAPD', 1, 1, 1, 1, '/referensi/penandatanganan.php', NULL, 21),
('TAPD', 1, 1, 1, 1, '/admin/ganti_password.php?act=update', NULL, 35),
('TAPD', 1, 1, 1, 1, '/index.php?act=logout', NULL, 6),
('BPKAD', 1, 1, 1, 1, '', NULL, 7),
('BPKAD', 1, 1, 1, 1, '', NULL, 8),
('BPKAD', 1, 1, 1, 1, '/rekening_hibah.php', NULL, 38),
('BPKAD', 1, 1, 1, 1, '/penerima_hibah.php', NULL, 22),
('BPKAD', 1, 1, 1, 1, '/pencairan_hibah.php', NULL, 23),
('BPKAD', 1, 1, 1, 1, '', NULL, 15),
('BPKAD', 1, 1, 1, 1, '/rekening_bansos.php', NULL, 39),
('BPKAD', 1, 1, 1, 1, '/penerima_bansos.php', NULL, 26),
('BPKAD', 1, 1, 1, 1, '/pencairan_bansos.php', NULL, 27),
('BPKAD', 1, 1, 1, 1, '', NULL, 11),
('BPKAD', 1, 1, 1, 1, '/referensi/rekening.php', NULL, 32),
('BPKAD', 1, 1, 1, 1, '', NULL, 33),
('BPKAD', 1, 1, 1, 1, '/reports/laporan_pencairan.php', NULL, 37),
('BPKAD', 1, 1, 1, 1, '/admin/ganti_password.php?act=update', NULL, 35),
('BPKAD', 1, 1, 1, 1, '/index.php?act=logout', NULL, 6),
('Administrator', 1, 1, 1, 1, '', NULL, 7),
('Administrator', 1, 1, 1, 1, '', NULL, 8),
('Administrator', 1, 1, 1, 1, '/hibah.php?act=add', NULL, 9),
('Administrator', 1, 1, 1, 1, '/hibah.php', NULL, 10),
('Administrator', 1, 1, 1, 1, '/evaluasi_hibah_opd.php', NULL, 18),
('Administrator', 1, 1, 1, 1, '/evaluasi_hibah_tapd.php', NULL, 20),
('Administrator', 1, 1, 1, 1, '/rekening_hibah.php', NULL, 38),
('Administrator', 1, 1, 1, 1, '/penerima_hibah.php', NULL, 22),
('Administrator', 1, 1, 1, 1, '/pencairan_hibah.php', NULL, 23),
('Administrator', 1, 1, 1, 1, '/monev_hibah.php', NULL, 28),
('Administrator', 1, 1, 1, 1, '/lpj_hibah.php', NULL, 30),
('Administrator', 1, 1, 1, 1, '', NULL, 15),
('Administrator', 1, 1, 1, 1, '/bansos.php?act=add', NULL, 16),
('Administrator', 1, 1, 1, 1, '/bansos.php', NULL, 17),
('Administrator', 1, 1, 1, 1, '/evaluasi_bansos_opd.php', NULL, 24),
('Administrator', 1, 1, 1, 1, '/evaluasi_bansos_tapd.php', NULL, 25),
('Administrator', 1, 1, 1, 1, '/rekening_bansos.php', NULL, 39),
('Administrator', 1, 1, 1, 1, '/penerima_bansos.php', NULL, 26),
('Administrator', 1, 1, 1, 1, '/pencairan_bansos.php', NULL, 27),
('Administrator', 1, 1, 1, 1, '/monev_bansos.php', NULL, 29),
('Administrator', 1, 1, 1, 1, '/lpj_bansos.php', NULL, 31),
('Administrator', 1, 1, 1, 1, '/export_data.php', NULL, 36),
('Administrator', 1, 1, 1, 1, '', NULL, 11),
('Administrator', 1, 1, 1, 1, '/referensi/opd.php', NULL, 12),
('Administrator', 1, 1, 1, 1, '/referensi/bank.php', NULL, 19),
('Administrator', 1, 1, 1, 1, '/referensi/rekening.php', NULL, 32),
('Administrator', 1, 1, 1, 1, '/referensi/administrasi.php', NULL, 13),
('Administrator', 1, 1, 1, 1, '/referensi/penandatanganan.php', NULL, 21),
('Administrator', 1, 1, 1, 1, '', NULL, 33),
('Administrator', 1, 1, 1, 1, '/reports/basic_reports.php', NULL, 34),
('Administrator', 1, 1, 1, 1, '/reports/laporan_pencairan.php', NULL, 37),
('Administrator', 1, 1, 1, 1, '/reports/laporan_pertanggungjawaban.php', NULL, 40),
('Administrator', 1, 1, 1, 1, '', NULL, 1),
('Administrator', 1, 1, 1, 1, '/admin/user.php', NULL, 2),
('Administrator', 1, 1, 1, 1, '/admin/menu.php', NULL, 3),
('Administrator', 1, 1, 1, 1, '/admin/function_access.php', NULL, 5),
('Administrator', 1, 1, 1, 1, '/admin/inquiry_access.php', NULL, 4),
('Administrator', 1, 1, 1, 1, '/admin/ganti_password.php?act=update', NULL, 35),
('Administrator', 1, 1, 1, 1, '/index.php?act=logout', NULL, 6);
