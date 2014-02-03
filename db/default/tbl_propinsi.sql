-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 26, 2014 at 08:45 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `bansos`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_propinsi`
--

DROP TABLE IF EXISTS `tbl_propinsi`;
CREATE TABLE IF NOT EXISTS `tbl_propinsi` (
  `kd_propinsi` char(2) NOT NULL,
  `nm_propinsi` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_propinsi`
--

INSERT INTO `tbl_propinsi` (`kd_propinsi`, `nm_propinsi`) VALUES
('11', 'NANGGROE ACEH DARUSSALAM'),
('12', 'SUMATERA BAG UTARA'),
('13', 'SUMATERA BARAT'),
('14', 'RIAU'),
('15', 'JAMBI'),
('16', 'SUMATERA BAG. SELATAN'),
('17', 'BENGKULU'),
('18', 'LAMPUNG'),
('19', 'KEP. BANGKA BELITUNG'),
('31', 'DKI JAKARTA'),
('32', 'JAWA BARAT'),
('33', 'JAWA TENGAH'),
('34', 'DI JOGJAKARTA'),
('35', 'JAWA TIMUR'),
('36', 'BANTEN'),
('51', 'BALI'),
('52', 'NUSA TENGGARA BARAT'),
('53', 'NUSA TENGGARA TIMUR'),
('61', 'KALIMANTAN BARAT'),
('62', 'KALIMANTAN TENGAH'),
('63', 'KALIMANTAN SELATAN'),
('64', 'KALIMANTAN TIMUR'),
('71', 'SULAWESI UTARA'),
('72', 'SULAWESI TENGAH'),
('73', 'SULAWESI SELATAN');
