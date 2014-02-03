-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 28, 2014 at 04:18 PM
-- Server version: 5.5.35
-- PHP Version: 5.3.10-1ubuntu3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bansos`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rekening`
--

DROP TABLE IF EXISTS `tbl_rekening`;
CREATE TABLE IF NOT EXISTS `tbl_rekening` (
  `no_rek` varchar(30) NOT NULL,
  `uraian` varchar(125) NOT NULL,
  `keterangan` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`no_rek`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_rekening`
--

INSERT INTO `tbl_rekening` (`no_rek`, `uraian`, `keterangan`) VALUES
('5.1.1.01.01', 'Belanja Hibah Kepada Masyarakat', '5.1.1.01.01 - Belanja Hibah Kepada Masyarakat'),
('5.1.4.01.01', 'Belanja Hibah Kepada Pemerintah Pusat', '5.1.4.01.01 - Belanja Hibah Kepada Pemerintah Pusat'),
('5.1.4.05.01', 'Belanja Hibah Kepada Badan/Lembaga/Organisasi Bidang Pendidikan', '5.1.4.05.01 - Belanja Hibah Kepada Badan/Lembaga/Organisasi Bidang Pendidikan'),
('5.1.4.05.02', 'Belanja Hibah Kepada Badan/Lembaga/Organisasi Bidang Kesehatan', '5.1.4.05.02 - Belanja Hibah Kepada Badan/Lembaga/Organisasi Bidang Kesehatan'),
('5.1.4.05.03', 'Belanja Hibah Kepada Badan/Lembaga/Organisasi Bidang Pemberdayaan Masyarakat', '5.1.4.05.03 - Belanja Hibah Kepada Badan/Lembaga/Organisasi Bidang Pemberdayaan Masyarakat'),
('5.1.4.05.05', 'Belanja Hibah Kepada Badan/Lembaga/Organisasi Bidang Keagamaan', '5.1.4.05.05 - Belanja Hibah Kepada Badan/Lembaga/Organisasi Bidang Keagamaan'),
('5.1.4.05.06', 'Belanja Hibah Kepada Badan/Lembaga/Organisasi Bidang Pemuda Olahraga', '5.1.4.05.06 - Belanja Hibah Kepada Badan/Lembaga/Organisasi Bidang Pemuda Olahraga'),
('5.1.4.05.07', 'Belanja Hibah Kepada Badan/Lembaga/Organisasi Bidang Kesatuan Bangsa dan Politik', '5.1.4.05.07 - Belanja Hibah Kepada Badan/Lembaga/Organisasi Bidang Kesatuan Bangsa dan Politik'),
('5.1.4.05.08', 'Belanja Hibah Kepada Badan/Lembaga/Organisasi Bidang Kebudayaan', '5.1.4.05.08 - Belanja Hibah Kepada Badan/Lembaga/Organisasi Bidang Kebudayaan'),
('5.1.4.06.01', 'Belanja Hibah Kepada Kelompok Masyarakat Bidang Pendidikan', '5.1.4.06.01 - Belanja Hibah Kepada Kelompok Masyarakat Bidang Pendidikan'),
('5.1.4.06.02', 'Belanja Hibah Kepada Kelompok Masyarakat Bidang Kesehatan', '5.1.4.06.02 - Belanja Hibah Kepada Kelompok Masyarakat Bidang Kesehatan'),
('5.1.4.06.03', 'Belanja Hibah Kepada Kelompok Masyarakat Bidang Pemberdayaan', '5.1.4.06.03 - Belanja Hibah Kepada Kelompok Masyarakat Bidang Pemberdayaan'),
('5.1.4.06.04', 'Belanja Hibah Kepada Kelompok Masyarakat Bidang Koperasi dan UKM', '5.1.4.06.04 - Belanja Hibah Kepada Kelompok Masyarakat Bidang Koperasi dan UKM'),
('5.1.4.06.06', 'Belanja Hibah Kepada Kelompok Masyarakat Bidang Pemuda dan Olahraga', '5.1.4.06.06 - Belanja Hibah Kepada Kelompok Masyarakat Bidang Pemuda dan Olahraga'),
('5.1.4.07.01', 'Belanja Hibah Dana BOS ke SD Swasta', '5.1.4.07.01 - Belanja Hibah Dana BOS ke SD Swasta'),
('5.1.4.07.02', 'Belanja Hibah Dana BOS ke SMP Swasta', '5.1.4.07.02 - Belanja Hibah Dana BOS ke SMP Swasta'),
('5.1.4.07.03', 'Belanja Hibah Dana BOS ke MI Swasta', '5.1.4.07.03 - Belanja Hibah Dana BOS ke MI Swasta'),
('5.1.4.08.01', 'Belanja Hibah Penyelenggaraan Pemilu Walikota dan Wakil Walikota', '5.1.4.08.01 - Belanja Hibah Penyelenggaraan Pemilu Walikota dan Wakil Walikota'),
('5.1.4.08.02', 'Belanja Hibah Belanja Hibah Pengamanan Pemilu Walikota dan Wakil Walikota', '5.1.4.08.02 - Belanja Hibah Belanja Hibah Pengamanan Pemilu Walikota dan Wakil Walikota');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
