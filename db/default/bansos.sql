-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 27, 2014 at 11:22 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `bansos`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bank`
--

DROP TABLE IF EXISTS `tbl_bank`;
CREATE TABLE IF NOT EXISTS `tbl_bank` (
  `bank_kode` int(3) NOT NULL auto_increment,
  `bank_nama` varchar(20) NOT NULL,
  PRIMARY KEY  (`bank_kode`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tbl_bank`
--

INSERT INTO `tbl_bank` (`bank_kode`, `bank_nama`) VALUES
(1, 'BCA'),
(2, 'BNI'),
(4, 'BRI'),
(5, 'CIMB Niaga'),
(6, 'BTN'),
(7, 'Mandiri'),
(8, 'BJB');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bansos`
--

DROP TABLE IF EXISTS `tbl_bansos`;
CREATE TABLE IF NOT EXISTS `tbl_bansos` (
  `ban_kode` int(10) NOT NULL auto_increment,
  `ban_tanggal` date NOT NULL,
  `ban_jenis` enum('Terencana','Tidak Terencana') NOT NULL,
  `jh_kode` int(3) NOT NULL,
  `ban_judul_kegiatan` varchar(75) NOT NULL,
  `ban_lokasi_kegiatan` text NOT NULL,
  `id_tb` int(3) NOT NULL,
  `ban_nama` varchar(50) NOT NULL,
  `ban_ktp` char(16) NOT NULL,
  `pimpinan` varchar(50) NOT NULL,
  `ban_jalan` varchar(50) NOT NULL,
  `ban_rt` char(3) NOT NULL,
  `ban_rw` char(3) NOT NULL,
  `kd_propinsi` char(2) NOT NULL,
  `kd_dati2` char(4) NOT NULL,
  `kd_kecamatan` char(7) NOT NULL,
  `kd_kelurahan` char(10) NOT NULL,
  `ban_kodepos` int(5) default NULL,
  `ban_tlp` varchar(14) default NULL,
  `ban_hp` varchar(14) default NULL,
  `bank_kode` int(3) NOT NULL,
  `ban_norek` varchar(15) NOT NULL,
  `ban_ren_guna` varchar(100) NOT NULL,
  `ban_besaran_bansos` double NOT NULL,
  `opd_kode` int(3) NOT NULL,
  `ban_eval_opd` enum('0','1') NOT NULL default '0',
  `ban_eval_tapd` enum('0','1') NOT NULL default '0',
  `ban_status` enum('Proses','Diterima','Ditolak','Cair') NOT NULL default 'Proses',
  `ban_cair` int(1) NOT NULL default '0',
  `mon_tgl` date default NULL,
  `mon_hasil` enum('Baik','Cukup Baik','Kurang') default NULL,
  `mon_uraian` text,
  `lpj_tgl` date default NULL,
  `lpj_uraian` text,
  `rek_anggaran` varchar(30) default NULL,
  `ctime` datetime NOT NULL default '0000-00-00 00:00:00',
  `mtime` datetime NOT NULL default '0000-00-00 00:00:00',
  `user` char(35) NOT NULL,
  PRIMARY KEY  (`ban_kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_bansos`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_berita_acara`
--

DROP TABLE IF EXISTS `tbl_berita_acara`;
CREATE TABLE IF NOT EXISTS `tbl_berita_acara` (
  `id` int(10) NOT NULL auto_increment,
  `ba_no` varchar(35) NOT NULL,
  `ba_tgl` date NOT NULL,
  `opd_kode` int(3) NOT NULL,
  `tipe` varchar(20) NOT NULL,
  `sk_no` varchar(35) NOT NULL,
  `sk_tgl` date NOT NULL,
  `sk_tentang` varchar(100) NOT NULL,
  `kode` varchar(50) NOT NULL,
  `user` varchar(50) NOT NULL,
  `ctime` datetime default '0000-00-00 00:00:00',
  `mtime` datetime default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ba_no` (`ba_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_berita_acara`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_berita_acara_detail`
--

DROP TABLE IF EXISTS `tbl_berita_acara_detail`;
CREATE TABLE IF NOT EXISTS `tbl_berita_acara_detail` (
  `id` mediumint(9) NOT NULL auto_increment,
  `kode` varchar(50) NOT NULL,
  `besaran_opd` double NOT NULL,
  `keterangan` text,
  `hib_kode` int(10) NOT NULL,
  `status` int(1) NOT NULL default '0',
  `ctime` datetime default '0000-00-00 00:00:00',
  `mtime` datetime default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_berita_acara_detail`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_cair_bansos`
--

DROP TABLE IF EXISTS `tbl_cair_bansos`;
CREATE TABLE IF NOT EXISTS `tbl_cair_bansos` (
  `id_cair` mediumint(10) NOT NULL auto_increment,
  `tgl_cair` date NOT NULL,
  `sppbs_no` varchar(35) NOT NULL,
  `sppbs_tgl` date NOT NULL,
  `sp2d_no` varchar(35) NOT NULL,
  `sp2d_tgl` date NOT NULL,
  `ban_kode` int(10) NOT NULL,
  `ctime` datetime NOT NULL,
  `mtime` datetime NOT NULL,
  `user` char(50) NOT NULL,
  PRIMARY KEY  (`id_cair`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_cair_bansos`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_cair_hibah`
--

DROP TABLE IF EXISTS `tbl_cair_hibah`;
CREATE TABLE IF NOT EXISTS `tbl_cair_hibah` (
  `id_cair` mediumint(10) NOT NULL auto_increment,
  `tgl_cair` date NOT NULL,
  `spph_no` varchar(35) NOT NULL,
  `spph_tgl` date NOT NULL,
  `nphd_no_pemberi` varchar(75) NOT NULL,
  `nphd_no_penerima` varchar(75) NOT NULL,
  `nphd_tgl` date NOT NULL,
  `nphd_tentang` varchar(50) NOT NULL,
  `sp2d_no` varchar(35) NOT NULL,
  `sp2d_tgl` date NOT NULL,
  `hib_kode` int(10) NOT NULL,
  `ctime` datetime NOT NULL,
  `mtime` datetime NOT NULL,
  `user` char(50) NOT NULL,
  PRIMARY KEY  (`id_cair`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_cair_hibah`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_eval_tapd`
--

DROP TABLE IF EXISTS `tbl_eval_tapd`;
CREATE TABLE IF NOT EXISTS `tbl_eval_tapd` (
  `id` int(10) NOT NULL auto_increment,
  `ba_no` varchar(35) NOT NULL,
  `ba_tgl` date NOT NULL,
  `opd_kode` int(3) NOT NULL,
  `tipe` varchar(20) NOT NULL,
  `kode` varchar(50) NOT NULL,
  `ctime` datetime default '0000-00-00 00:00:00',
  `mtime` datetime default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `ba_no` (`ba_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_eval_tapd`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_eval_tapd_detail`
--

DROP TABLE IF EXISTS `tbl_eval_tapd_detail`;
CREATE TABLE IF NOT EXISTS `tbl_eval_tapd_detail` (
  `id` mediumint(9) NOT NULL auto_increment,
  `kode` varchar(50) NOT NULL,
  `besaran_tapd` double NOT NULL,
  `keterangan` text,
  `hib_kode` int(10) NOT NULL,
  `status` int(1) NOT NULL default '0',
  `ctime` datetime default '0000-00-00 00:00:00',
  `mtime` datetime default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_eval_tapd_detail`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_hibah`
--

DROP TABLE IF EXISTS `tbl_hibah`;
CREATE TABLE IF NOT EXISTS `tbl_hibah` (
  `hib_kode` int(10) NOT NULL auto_increment,
  `hib_tanggal` date NOT NULL,
  `jh_kode` int(3) NOT NULL,
  `hib_judul_kegiatan` varchar(75) NOT NULL,
  `hib_lokasi_kegiatan` text NOT NULL,
  `id_jp` int(10) NOT NULL,
  `hib_nama` varchar(50) NOT NULL,
  `pimpinan` varchar(50) NOT NULL,
  `hib_jalan` varchar(50) NOT NULL,
  `hib_rt` char(3) NOT NULL,
  `hib_rw` char(3) NOT NULL,
  `kd_propinsi` char(2) NOT NULL,
  `kd_dati2` char(4) NOT NULL,
  `kd_kecamatan` char(7) NOT NULL,
  `kd_kelurahan` char(10) NOT NULL,
  `hib_kodepos` int(5) default NULL,
  `hib_tlp` varchar(14) default NULL,
  `hib_hp` varchar(14) default NULL,
  `bank_kode` int(3) NOT NULL,
  `hib_norek` varchar(15) NOT NULL,
  `hib_ren_guna` varchar(100) NOT NULL,
  `hib_besaran_hibah` double NOT NULL,
  `opd_kode` int(3) NOT NULL,
  `hib_eval_opd` enum('0','1') NOT NULL default '0',
  `hib_eval_tapd` enum('0','1') NOT NULL default '0',
  `hib_status` enum('Proses','Diterima','Ditolak','Cair') NOT NULL default 'Proses',
  `hib_cair` int(1) NOT NULL default '0',
  `mon_tgl` date default NULL,
  `mon_hasil` enum('Baik','Cukup Baik','Kurang') default NULL,
  `mon_uraian` text,
  `lpj_tgl` date default NULL,
  `lpj_uraian` text,
  `rek_anggaran` varchar(30) default NULL,
  `ctime` datetime NOT NULL default '0000-00-00 00:00:00',
  `mtime` datetime NOT NULL default '0000-00-00 00:00:00',
  `user` char(50) NOT NULL,
  PRIMARY KEY  (`hib_kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_hibah`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_jenis_hibah`
--

DROP TABLE IF EXISTS `tbl_jenis_hibah`;
CREATE TABLE IF NOT EXISTS `tbl_jenis_hibah` (
  `jh_kode` int(3) NOT NULL auto_increment,
  `jh_jenis` varchar(10) NOT NULL,
  PRIMARY KEY  (`jh_kode`),
  KEY `jh_jenis` (`jh_jenis`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Tabel Jenis Hibah' AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_jenis_hibah`
--

INSERT INTO `tbl_jenis_hibah` (`jh_kode`, `jh_jenis`) VALUES
(2, 'Barang'),
(3, 'Jasa'),
(1, 'Uang');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jenis_pemohon`
--

DROP TABLE IF EXISTS `tbl_jenis_pemohon`;
CREATE TABLE IF NOT EXISTS `tbl_jenis_pemohon` (
  `id_jp` int(10) NOT NULL auto_increment,
  `jenis_pemohon` varchar(35) NOT NULL,
  PRIMARY KEY  (`id_jp`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tbl_jenis_pemohon`
--

INSERT INTO `tbl_jenis_pemohon` (`id_jp`, `jenis_pemohon`) VALUES
(1, 'Pemerintah'),
(2, 'Pemerintah Daerah'),
(3, 'Perusahaan Daerah'),
(4, 'Masyarakat'),
(5, 'Organisasi Kemasyarakatan');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_karakteristik_kegiatan`
--

DROP TABLE IF EXISTS `tbl_karakteristik_kegiatan`;
CREATE TABLE IF NOT EXISTS `tbl_karakteristik_kegiatan` (
  `kk_id` int(3) NOT NULL auto_increment,
  `kk_nama` varchar(50) NOT NULL,
  PRIMARY KEY  (`kk_id`),
  KEY `kk_nama` (`kk_nama`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tbl_karakteristik_kegiatan`
--

INSERT INTO `tbl_karakteristik_kegiatan` (`kk_id`, `kk_nama`) VALUES
(6, 'Bangunan Fisik'),
(8, 'Kegiatan Non Fisik'),
(1, 'Pembangunan Fisik'),
(5, 'Pembelian Barang'),
(2, 'Pemeliharaan / Renovasi'),
(7, 'Pengadaan Sarana dan Prasarana'),
(4, 'Pengembangan');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_log`
--

DROP TABLE IF EXISTS `tbl_log`;
CREATE TABLE IF NOT EXISTS `tbl_log` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(5) unsigned NOT NULL default '0',
  `ctime` datetime NOT NULL default '0000-00-00 00:00:00',
  `activity` text,
  `ip` varchar(100) NOT NULL,
  `detail` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_log`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_opd`
--

DROP TABLE IF EXISTS `tbl_opd`;
CREATE TABLE IF NOT EXISTS `tbl_opd` (
  `opd_kode` int(3) NOT NULL auto_increment,
  `opd_nama` varchar(75) NOT NULL,
  `opd_bidang` varchar(100) NOT NULL,
  `opd_kepala` varchar(50) default NULL,
  `opd_nip` varchar(15) default NULL,
  PRIMARY KEY  (`opd_kode`),
  KEY `opd_nama` (`opd_nama`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=23 ;

--
-- Dumping data for table `tbl_opd`
--

INSERT INTO `tbl_opd` (`opd_kode`, `opd_nama`, `opd_bidang`, `opd_kepala`, `opd_nip`) VALUES
(1, 'Dinas Kependudukan dan Pencatatan Sipil', 'Kependudukan dan Pencatatan Sipil', NULL, NULL),
(2, 'Kantor Kesatuan Bangsa dan Politik', 'Kesatuan Bangsa dan Politik Dalam Negeri', 'Sumanto', '422232211'),
(3, 'Bagian Pemerintahan Sekretariat Daerah', 'Pemerintahan Umum', NULL, NULL),
(4, 'Dinas Pendidikan', 'Pendidikan', 'Agus Salim', '123456789012345'),
(5, 'Dinas Kesehatan', 'Kesehatan', 'Pupung Asa', '123456789'),
(6, 'Dinas Pengawasan Bangunan dan Permukiman', 'Pekerjaan Umum Bidang Bangunan dan Permukiman', NULL, NULL),
(7, 'Dinas Kebersihan dan Pertamanan', 'Pekerjaan Umum Bidang Kebersihan dan Pertamanan', NULL, NULL),
(8, 'Dinas Bina Marga dan Sumber Daya Air', 'Pekerjaan Umum Bidang Kebinamargaan dan Sumber Daya Air', NULL, NULL),
(9, 'Dinas Lalu Lintas dan Angkutan Jalan', 'Perhubungan', NULL, NULL),
(10, 'Badan Pengelolaan Lingkungan Hidup', 'Lingkungan Hidup', NULL, NULL),
(11, 'Badan Pemberdayaan Masyarakat dan Keluarga Berencana', 'Pemberdayaan Perempuan dan KB', NULL, NULL),
(12, 'Dinas Tenaga Kerja, Sosial dan Transmigrasi', 'Sosial dan Tenaga Kerja', NULL, NULL),
(13, 'Kantor Koperasi dan Usaha Mikro, Kecil dan Menengah', 'Koperasi dan Usaha Kecil Menengah', NULL, NULL),
(14, 'Dinas Kebudayaan dan Pariwisata', 'Kebudayaan', NULL, NULL),
(15, 'Kantor Pemuda dan Olah Raga', 'Kepemudaan dan Olah Raga', NULL, NULL),
(16, 'Kantor Komunikasi dan Informatika', 'Komunikasi dan Informatika', NULL, NULL),
(17, 'Bagian Hubungan Masyarakat Sekretariat Daerah', 'Kehumasan', NULL, NULL),
(18, 'Kantor Arsip dan Perpustakaan Daerah', 'Perpustakaan', NULL, NULL),
(19, 'Dinas Perindustrian dan Perdagangan', 'Perindustrian dan Perdagangan', NULL, NULL),
(20, 'Dinas Pertanian', 'Pertanian', NULL, NULL),
(21, 'Bagian Kemasyarakatan Sekretariat Daerah', 'Keagamaan', 'Test Nama', '5432109876'),
(22, 'Bagian Perekonomian Sekretariat Daerah', 'Perusahaan Daerah', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_penandatanganan`
--

DROP TABLE IF EXISTS `tbl_penandatanganan`;
CREATE TABLE IF NOT EXISTS `tbl_penandatanganan` (
  `id` int(10) NOT NULL auto_increment,
  `jabatan` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nip` varchar(15) default NULL,
  `ctime` datetime default '0000-00-00 00:00:00',
  `mtime` datetime default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `jabatan` (`jabatan`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_penandatanganan`
--

INSERT INTO `tbl_penandatanganan` (`id`, `jabatan`, `nama`, `nip`, `ctime`, `mtime`) VALUES
(1, 'WALIKOTA BOGOR', 'DIANI BUDIARTO', '', '2013-12-26 00:55:56', '2013-12-26 01:14:26'),
(2, 'PLT. SEKRETARIS DAERAH KOTA BOGOR', 'DRS. H. ADE SARIP HIDAYAT, M.PD', '196009101980031', '2013-12-26 00:00:00', '2014-01-23 17:32:06'),
(3, 'KETUA TAPD', 'RAFFI AHMAD', '12345678910', '2013-12-26 00:00:00', '2013-12-26 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_session`
--

DROP TABLE IF EXISTS `tbl_session`;
CREATE TABLE IF NOT EXISTS `tbl_session` (
  `session_id` varchar(100) NOT NULL,
  `username` varchar(20) NOT NULL,
  `last_login` datetime NOT NULL default '0000-00-00 00:00:00',
  `last_access` int(10) unsigned NOT NULL,
  `status` tinyint(4) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `ctime` datetime NOT NULL,
  PRIMARY KEY  (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_session`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_setting`
--

DROP TABLE IF EXISTS `tbl_setting`;
CREATE TABLE IF NOT EXISTS `tbl_setting` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `kode` varchar(100) NOT NULL,
  `header_color` varchar(16) default NULL,
  `tab_color` varchar(16) default NULL,
  `page_color` varchar(16) default NULL,
  `path` varchar(255) default NULL,
  `title` varchar(255) default NULL,
  `company_name` varchar(255) default NULL,
  `ctime` datetime NOT NULL,
  `mtime` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_setting`
--

INSERT INTO `tbl_setting` (`id`, `kode`, `header_color`, `tab_color`, `page_color`, `path`, `title`, `company_name`, `ctime`, `mtime`) VALUES
(1, '131900-SET-ZfLcilU320', 'FFFFFF', '5E88B8', 'CCCCCC', '/i/payroll/header.jpg', 'Sistem Informasi Bantuan Sosial', 'Pemerintah Kota Bogor', '2013-12-01 21:00:40', '2013-12-01 21:00:46');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tim_evaluasi`
--

DROP TABLE IF EXISTS `tbl_tim_evaluasi`;
CREATE TABLE IF NOT EXISTS `tbl_tim_evaluasi` (
  `id` mediumint(10) NOT NULL auto_increment,
  `nama` varchar(50) NOT NULL,
  `nip` varchar(15) NOT NULL,
  `kode` varchar(50) NOT NULL,
  `ctime` datetime default '0000-00-00 00:00:00',
  `mtime` datetime default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `tbl_tim_evaluasi`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_tujuan_bansos`
--

DROP TABLE IF EXISTS `tbl_tujuan_bansos`;
CREATE TABLE IF NOT EXISTS `tbl_tujuan_bansos` (
  `id_tb` int(3) NOT NULL auto_increment,
  `tb` varchar(35) NOT NULL,
  `ctime` datetime NOT NULL,
  `mtime` datetime NOT NULL,
  PRIMARY KEY  (`id_tb`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tbl_tujuan_bansos`
--

INSERT INTO `tbl_tujuan_bansos` (`id_tb`, `tb`, `ctime`, `mtime`) VALUES
(1, 'Rehabilitasi Sosial', '2013-12-27 07:51:12', '2013-12-27 07:51:14'),
(2, 'Perlindungan Sosial', '2013-12-27 07:51:16', '2013-12-27 07:51:18'),
(3, 'Pemberdayaan Sosial', '2013-12-27 07:51:46', '2013-12-27 07:51:48'),
(4, 'Jaminan Sosial', '2013-12-27 00:00:00', '2013-12-27 00:00:00'),
(5, 'Penanggulangan Sosial', '2013-12-27 07:52:47', '2013-12-27 07:52:50'),
(6, 'Penanggulangan Bencana', '2013-12-27 07:52:52', '2013-12-27 07:52:55');
