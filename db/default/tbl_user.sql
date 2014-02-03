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
-- Table structure for table `tbl_user`
--

DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(40) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `access_level` varchar(128) NOT NULL,
  `status` tinyint(4) NOT NULL default '0',
  `last_login` datetime NOT NULL,
  `ip` varchar(32) NOT NULL,
  `inquiry_access` varchar(200) NOT NULL,
  `opd_kode` int(3) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `password`, `full_name`, `access_level`, `status`, `last_login`, `ip`, `inquiry_access`, `opd_kode`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrator', 'Administrator', 0, '2014-01-27 22:13:40', '127.0.0.1', 'Administrator', 0),
(2, 'bk', '7e7ec59d1f4b21021577ff562dc3d48b', 'Bagian Kemasyarakatan', 'BK', 0, '2014-01-27 07:43:19', '127.0.0.1', 'BK', 0),
(3, 'tapd', '5e17375c07ee0049d015948c11ad2112', 'Tim Anggaran Pemerintah Daerah', 'TAPD', 0, '2014-01-27 21:01:16', '127.0.0.1', 'TAPD', 0),
(4, 'bpkad', '8a7b37ac7e5d37ff06b1268ac9afffe4', 'Badan Pengelola Keuangan dan Aset Daerah', 'BPKAD', 0, '2014-01-27 21:12:41', '127.0.0.1', 'BPKAD', 0),
(5, 'disdukcapil', 'cfdb3e16f01e3de95940f26a0de9d724', 'Dinas Kependudukan dan Pencatatan Sipil', 'OPD', 0, '2014-01-13 17:49:51', '127.0.0.1', 'OPD', 1),
(6, 'kesbang', '7d128bcbd4be59021fcb3ba6e5fb6f35', 'Kantor Kesatuan Bangsa dan Politik', 'OPD', 0, '0000-00-00 00:00:00', '', 'OPD', 2),
(7, 'pem_sekda', 'ea83641146699c9cae2ac93604e27847', 'Bagian Pemerintahan Sekretariat Daerah', 'OPD', 0, '0000-00-00 00:00:00', '', 'OPD', 3),
(8, 'dindik', '58416520d39dfab9d687a758d6a46863', 'Dinas Pendidkan', 'OPD', 0, '2014-01-27 17:27:21', '127.0.0.1', 'OPD', 4),
(9, 'dinkes', 'd1c7e93048a30d60d970e18407699c25', 'Dinas Kesehatan', 'OPD', 0, '2014-01-13 19:43:26', '127.0.0.1', 'OPD', 5),
(10, 'wasbangkim', 'cf326a181a58b84291870abeb56c4dbd', 'Dinas Pengawasan Bangunan dan Permukiman', 'OPD', 0, '0000-00-00 00:00:00', '', 'OPD', 6),
(11, 'dkp', 'e6c2ee4aac968c19f61eeaab09401374', 'Dinas Kebersihan dan Pertamanan', 'OPD', 0, '0000-00-00 00:00:00', '', 'OPD', 7),
(12, 'dbmsda', '347d820893f0104c7a092a1870ac7df5', 'Dinas Bina Marga dan Sumber Daya Air', 'OPD', 0, '0000-00-00 00:00:00', '', 'OPD', 8),
(13, 'dllaj', 'e43f4e39cf6865e196f76e9403bfcc08', 'Dinas Lalu Lintas dan Angkutan Jalan', 'OPD', 0, '0000-00-00 00:00:00', '', 'OPD', 9),
(14, 'bplh', '60cbde6079ded3d3840875bba0a71c2b', 'Badan Pengelolaan Lingkungan Hidup', 'OPD', 0, '0000-00-00 00:00:00', '', 'OPD', 10),
(15, 'bpmkb', '6da82831d7ef2e7e6848ab304c4f5fb0', 'Badan Pemberdayaan Masyarakat dan Keluarga Berenca', 'OPD', 0, '0000-00-00 00:00:00', '', 'OPD', 11),
(16, 'disnaker', 'afb9879105b166ef56d62cc9962307d5', 'Dinas Tenaga Kerja, Sosial dan Transmigrasi', 'OPD', 0, '0000-00-00 00:00:00', '', 'OPD', 12),
(17, 'kkukm', 'b4b8f9d73460f1192b1fdb0a744d1cd9', 'Kantor Koperasi dan Usaha Mikro, Kecil dan Menenga', 'OPD', 0, '0000-00-00 00:00:00', '', 'OPD', 13),
(18, 'dinpar', '9c278f756c9939a7e0330debc60d8ed8', 'Dinas Kebudayaan dan Pariwisata', 'OPD', 0, '0000-00-00 00:00:00', '', 'OPD', 14),
(19, 'kpo', 'fd9021a27ccbe2d886e9559bdebc8b48', 'Kantor Pemuda dan Olah Raga', 'OPD', 0, '0000-00-00 00:00:00', '', 'OPD', 15),
(20, 'kominfo', 'dc2f4ef676263fe9dde73a9ae6299258', 'Kantor Komunikasi dan Informatika', 'OPD', 0, '2014-01-13 19:52:58', '127.0.0.1', 'OPD', 16),
(21, 'humas_sekda', '7ba398f3521a1aa9a6b569af3990facc', 'Bagian Hubungan Masyarakat Sekretariat Daerah', 'OPD', 0, '0000-00-00 00:00:00', '', 'OPD', 17),
(22, 'kapd', '80fe9887901e669d61b6575d0e407c88', 'Kantor Arsip dan Perpustakaan Daerah', 'OPD', 0, '0000-00-00 00:00:00', '', 'OPD', 18),
(23, 'deperindag', '69b1720fca2b532d1fde4a4b8b20e9a4', 'Dinas Perindustrian dan Perdagangan', 'OPD', 0, '0000-00-00 00:00:00', '', 'OPD', 19),
(24, 'dinpertanian', 'b4a08357ef4261cbc841ac61a49cbf50', 'Dinas Pertanian', 'OPD', 0, '0000-00-00 00:00:00', '', 'OPD', 20),
(25, 'bk_sekda', 'ff2898efa887bf0269d71eb8ee5ea8ed', 'Bagian Kemasyarakatan Sekretariat Daerah', 'OPD', 0, '2014-01-27 07:43:41', '127.0.0.1', 'OPD', 21),
(26, 'bp_sekda', '7aa6d9b18923e7841de3890538c92771', 'Bagian Perekonomian Sekretariat Daerah', 'OPD', 0, '0000-00-00 00:00:00', '', 'OPD', 22);
