-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 12, 2014 at 08:41 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `bansos`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_dncpbh_opd`
--
CREATE TABLE IF NOT EXISTS `v_dncpbh_opd` (
`opd` varchar(75)
,`jenis` varchar(10)
,`nama` varchar(50)
,`hib_kode` int(10)
,`alamat` varchar(66)
,`kelurahan` varchar(200)
,`kecamatan` varchar(200)
,`kota` varchar(200)
,`propinsi` varchar(200)
,`kodepos` int(5)
,`rencana_penggunaan` varchar(100)
,`permohonan` double
,`hasil_evaluasi_opd` double
,`keterangan` text
,`status_opd` int(1)
,`kode` varchar(50)
,`tipe` varchar(20)
,`no_ba` varchar(35)
,`tgl_ba` date
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v_dncpbh_tapd`
--
CREATE TABLE IF NOT EXISTS `v_dncpbh_tapd` (
`opd` varchar(75)
,`jenis` varchar(10)
,`nama` varchar(50)
,`hib_kode` int(10)
,`alamat` varchar(66)
,`kelurahan` varchar(200)
,`kecamatan` varchar(200)
,`kota` varchar(200)
,`propinsi` varchar(200)
,`kodepos` int(5)
,`rencana_penggunaan` varchar(100)
,`permohonan` double
,`hasil_evaluasi_opd` double
,`hasil_evaluasi_tapd` double
,`keterangan` text
,`status_opd` int(1)
,`status_tapd` int(1)
,`kode` varchar(50)
,`tipe` varchar(20)
,`no_ba` varchar(35)
,`tgl_ba` date
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v_dncpbs_opd`
--
CREATE TABLE IF NOT EXISTS `v_dncpbs_opd` (
`opd` varchar(75)
,`jenis` varchar(10)
,`nama` varchar(50)
,`ktp` char(16)
,`ban_kode` int(10)
,`alamat` varchar(66)
,`kelurahan` varchar(200)
,`kecamatan` varchar(200)
,`kota` varchar(200)
,`propinsi` varchar(200)
,`kodepos` int(5)
,`rencana_penggunaan` varchar(100)
,`permohonan` double
,`hasil_evaluasi_opd` double
,`keterangan` text
,`status_opd` int(1)
,`kode` varchar(50)
,`tipe` varchar(20)
,`no_ba` varchar(35)
,`tgl_ba` date
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v_dncpbs_tapd`
--
CREATE TABLE IF NOT EXISTS `v_dncpbs_tapd` (
`opd` varchar(75)
,`jenis` varchar(10)
,`nama` varchar(50)
,`ktp` char(16)
,`ban_kode` int(10)
,`alamat` varchar(66)
,`kelurahan` varchar(200)
,`kecamatan` varchar(200)
,`kota` varchar(200)
,`propinsi` varchar(200)
,`kodepos` int(5)
,`rencana_penggunaan` varchar(100)
,`permohonan` double
,`hasil_evaluasi_opd` double
,`hasil_evaluasi_tapd` double
,`keterangan` text
,`status_opd` int(1)
,`status_tapd` int(1)
,`kode` varchar(50)
,`tipe` varchar(20)
,`no_ba` varchar(35)
,`tgl_ba` date
);
-- --------------------------------------------------------

--
-- Structure for view `v_dncpbh_opd`
--
DROP TABLE IF EXISTS `v_dncpbh_opd`;

DROP VIEW IF EXISTS `v_dncpbh_opd`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bansos`.`v_dncpbh_opd` AS select `a`.`opd_nama` AS `opd`,`b`.`jh_jenis` AS `jenis`,`c`.`hib_nama` AS `nama`,`c`.`hib_kode` AS `hib_kode`,concat(`c`.`hib_jalan`,_utf8' RT.',`c`.`hib_rt`,_utf8' / RW.',`c`.`hib_rw`) AS `alamat`,`d`.`nm_kelurahan` AS `kelurahan`,`e`.`nm_kecamatan` AS `kecamatan`,`f`.`nm_dati2` AS `kota`,`g`.`nm_propinsi` AS `propinsi`,`c`.`hib_kodepos` AS `kodepos`,`c`.`hib_ren_guna` AS `rencana_penggunaan`,`c`.`hib_besaran_hibah` AS `permohonan`,`h`.`besaran_opd` AS `hasil_evaluasi_opd`,`h`.`keterangan` AS `keterangan`,`h`.`status` AS `status_opd`,`h`.`kode` AS `kode`,`i`.`tipe` AS `tipe`,`i`.`ba_no` AS `no_ba`,`i`.`ba_tgl` AS `tgl_ba` from ((((((((`bansos`.`tbl_opd` `a` join `bansos`.`tbl_jenis_hibah` `b`) join `bansos`.`tbl_hibah` `c`) join `bansos`.`tbl_kelurahan` `d`) join `bansos`.`tbl_kecamatan` `e`) join `bansos`.`tbl_dati2` `f`) join `bansos`.`tbl_propinsi` `g`) join `bansos`.`tbl_berita_acara_detail` `h`) join `bansos`.`tbl_berita_acara` `i`) where ((`c`.`opd_kode` = `a`.`opd_kode`) and (`c`.`jh_kode` = `b`.`jh_kode`) and (`c`.`kd_kelurahan` = convert(`d`.`kd_kelurahan` using utf8)) and (`c`.`kd_kecamatan` = convert(`e`.`kd_kecamatan` using utf8)) and (`c`.`kd_dati2` = convert(`f`.`kd_dati2` using utf8)) and (`c`.`kd_propinsi` = convert(`g`.`kd_propinsi` using utf8)) and (`c`.`hib_kode` = `h`.`hib_kode`) and (`h`.`kode` = `i`.`kode`) and (`i`.`tipe` = _utf8'HIBAH'));

-- --------------------------------------------------------

--
-- Structure for view `v_dncpbh_tapd`
--
DROP TABLE IF EXISTS `v_dncpbh_tapd`;

DROP VIEW IF EXISTS `v_dncpbh_tapd`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bansos`.`v_dncpbh_tapd` AS select `a`.`opd_nama` AS `opd`,`b`.`jh_jenis` AS `jenis`,`c`.`hib_nama` AS `nama`,`c`.`hib_kode` AS `hib_kode`,concat(`c`.`hib_jalan`,_utf8' RT.',`c`.`hib_rt`,_utf8' / RW.',`c`.`hib_rw`) AS `alamat`,`d`.`nm_kelurahan` AS `kelurahan`,`e`.`nm_kecamatan` AS `kecamatan`,`f`.`nm_dati2` AS `kota`,`g`.`nm_propinsi` AS `propinsi`,`c`.`hib_kodepos` AS `kodepos`,`c`.`hib_ren_guna` AS `rencana_penggunaan`,`c`.`hib_besaran_hibah` AS `permohonan`,`h`.`besaran_opd` AS `hasil_evaluasi_opd`,`j`.`besaran_tapd` AS `hasil_evaluasi_tapd`,`j`.`keterangan` AS `keterangan`,`h`.`status` AS `status_opd`,`j`.`status` AS `status_tapd`,`j`.`kode` AS `kode`,`k`.`tipe` AS `tipe`,`k`.`ba_no` AS `no_ba`,`k`.`ba_tgl` AS `tgl_ba` from ((((((((((`bansos`.`tbl_opd` `a` join `bansos`.`tbl_jenis_hibah` `b`) join `bansos`.`tbl_hibah` `c`) join `bansos`.`tbl_kelurahan` `d`) join `bansos`.`tbl_kecamatan` `e`) join `bansos`.`tbl_dati2` `f`) join `bansos`.`tbl_propinsi` `g`) join `bansos`.`tbl_berita_acara_detail` `h`) join `bansos`.`tbl_berita_acara` `i`) join `bansos`.`tbl_eval_tapd_detail` `j`) join `bansos`.`tbl_eval_tapd` `k`) where ((`c`.`opd_kode` = `a`.`opd_kode`) and (`c`.`jh_kode` = `b`.`jh_kode`) and (`c`.`kd_kelurahan` = convert(`d`.`kd_kelurahan` using utf8)) and (`c`.`kd_kecamatan` = convert(`e`.`kd_kecamatan` using utf8)) and (`c`.`kd_dati2` = convert(`f`.`kd_dati2` using utf8)) and (`c`.`kd_propinsi` = convert(`g`.`kd_propinsi` using utf8)) and (`c`.`hib_kode` = `h`.`hib_kode`) and (`h`.`kode` = `i`.`kode`) and (`i`.`tipe` = _utf8'HIBAH') and (`c`.`hib_kode` = `j`.`hib_kode`) and (`j`.`kode` = `k`.`kode`) and (`k`.`tipe` = _utf8'HIBAH'));

-- --------------------------------------------------------

--
-- Structure for view `v_dncpbs_opd`
--
DROP TABLE IF EXISTS `v_dncpbs_opd`;

DROP VIEW IF EXISTS `v_dncpbs_opd`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bansos`.`v_dncpbs_opd` AS select `a`.`opd_nama` AS `opd`,`b`.`jh_jenis` AS `jenis`,`c`.`ban_nama` AS `nama`,`c`.`ban_ktp` AS `ktp`,`c`.`ban_kode` AS `ban_kode`,concat(`c`.`ban_jalan`,_utf8' RT.',`c`.`ban_rt`,_utf8' / RW.',`c`.`ban_rw`) AS `alamat`,`d`.`nm_kelurahan` AS `kelurahan`,`e`.`nm_kecamatan` AS `kecamatan`,`f`.`nm_dati2` AS `kota`,`g`.`nm_propinsi` AS `propinsi`,`c`.`ban_kodepos` AS `kodepos`,`c`.`ban_ren_guna` AS `rencana_penggunaan`,`c`.`ban_besaran_bansos` AS `permohonan`,`h`.`besaran_opd` AS `hasil_evaluasi_opd`,`h`.`keterangan` AS `keterangan`,`h`.`status` AS `status_opd`,`h`.`kode` AS `kode`,`i`.`tipe` AS `tipe`,`i`.`ba_no` AS `no_ba`,`i`.`ba_tgl` AS `tgl_ba` from ((((((((`bansos`.`tbl_opd` `a` join `bansos`.`tbl_jenis_hibah` `b`) join `bansos`.`tbl_bansos` `c`) join `bansos`.`tbl_kelurahan` `d`) join `bansos`.`tbl_kecamatan` `e`) join `bansos`.`tbl_dati2` `f`) join `bansos`.`tbl_propinsi` `g`) join `bansos`.`tbl_berita_acara_detail` `h`) join `bansos`.`tbl_berita_acara` `i`) where ((`c`.`opd_kode` = `a`.`opd_kode`) and (`c`.`jh_kode` = `b`.`jh_kode`) and (`c`.`kd_kelurahan` = convert(`d`.`kd_kelurahan` using utf8)) and (`c`.`kd_kecamatan` = convert(`e`.`kd_kecamatan` using utf8)) and (`c`.`kd_dati2` = convert(`f`.`kd_dati2` using utf8)) and (`c`.`kd_propinsi` = convert(`g`.`kd_propinsi` using utf8)) and (`h`.`hib_kode` = `c`.`ban_kode`) and (`h`.`kode` = `i`.`kode`) and (`i`.`tipe` = _utf8'BANSOS'));

-- --------------------------------------------------------

--
-- Structure for view `v_dncpbs_tapd`
--
DROP TABLE IF EXISTS `v_dncpbs_tapd`;

DROP VIEW IF EXISTS `v_dncpbs_tapd`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `bansos`.`v_dncpbs_tapd` AS select `a`.`opd_nama` AS `opd`,`b`.`jh_jenis` AS `jenis`,`c`.`ban_nama` AS `nama`,`c`.`ban_ktp` AS `ktp`,`c`.`ban_kode` AS `ban_kode`,concat(`c`.`ban_jalan`,_utf8' RT.',`c`.`ban_rt`,_utf8' / RW.',`c`.`ban_rw`) AS `alamat`,`d`.`nm_kelurahan` AS `kelurahan`,`e`.`nm_kecamatan` AS `kecamatan`,`f`.`nm_dati2` AS `kota`,`g`.`nm_propinsi` AS `propinsi`,`c`.`ban_kodepos` AS `kodepos`,`c`.`ban_ren_guna` AS `rencana_penggunaan`,`c`.`ban_besaran_bansos` AS `permohonan`,`h`.`besaran_opd` AS `hasil_evaluasi_opd`,`j`.`besaran_tapd` AS `hasil_evaluasi_tapd`,`j`.`keterangan` AS `keterangan`,`h`.`status` AS `status_opd`,`j`.`status` AS `status_tapd`,`j`.`kode` AS `kode`,`k`.`tipe` AS `tipe`,`k`.`ba_no` AS `no_ba`,`k`.`ba_tgl` AS `tgl_ba` from ((((((((((`bansos`.`tbl_opd` `a` join `bansos`.`tbl_jenis_hibah` `b`) join `bansos`.`tbl_bansos` `c`) join `bansos`.`tbl_kelurahan` `d`) join `bansos`.`tbl_kecamatan` `e`) join `bansos`.`tbl_dati2` `f`) join `bansos`.`tbl_propinsi` `g`) join `bansos`.`tbl_berita_acara_detail` `h`) join `bansos`.`tbl_berita_acara` `i`) join `bansos`.`tbl_eval_tapd_detail` `j`) join `bansos`.`tbl_eval_tapd` `k`) where ((`c`.`opd_kode` = `a`.`opd_kode`) and (`c`.`jh_kode` = `b`.`jh_kode`) and (`c`.`kd_kelurahan` = convert(`d`.`kd_kelurahan` using utf8)) and (`c`.`kd_kecamatan` = convert(`e`.`kd_kecamatan` using utf8)) and (`c`.`kd_dati2` = convert(`f`.`kd_dati2` using utf8)) and (`c`.`kd_propinsi` = convert(`g`.`kd_propinsi` using utf8)) and (`c`.`ban_kode` = `h`.`hib_kode`) and (`h`.`kode` = `i`.`kode`) and (`i`.`tipe` = _utf8'BANSOS') and (`c`.`ban_kode` = `j`.`hib_kode`) and (`j`.`kode` = `k`.`kode`) and (`k`.`tipe` = _utf8'BANSOS'));
