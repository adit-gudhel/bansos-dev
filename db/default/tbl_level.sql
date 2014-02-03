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
-- Table structure for table `tbl_level`
--

DROP TABLE IF EXISTS `tbl_level`;
CREATE TABLE IF NOT EXISTS `tbl_level` (
  `access_level` varchar(128) NOT NULL,
  `access_detail` varchar(255) NOT NULL,
  PRIMARY KEY  (`access_level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_level`
--

INSERT INTO `tbl_level` (`access_level`, `access_detail`) VALUES
('Administrator', 'Administrator'),
('BK', 'Bagian Kemasyarakatan'),
('BPKAD', 'Badan Pengelolaan Keuangan dan Aset Daerah'),
('OPD', 'Organisasi Perangkat Daerah'),
('TAPD', 'Tim Anggaran Pemerintah Daerah');
