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
-- Table structure for table `tbl_inquiry_access`
--

DROP TABLE IF EXISTS `tbl_inquiry_access`;
CREATE TABLE IF NOT EXISTS `tbl_inquiry_access` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `access_name` varchar(255) NOT NULL default '',
  `inquiry_name` varchar(255) NOT NULL default '',
  `inquiry_access` text NOT NULL,
  `ctime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `ctime` (`ctime`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tbl_inquiry_access`
--

INSERT INTO `tbl_inquiry_access` (`id`, `access_name`, `inquiry_name`, `inquiry_access`, `ctime`) VALUES
(1, 'Administrator', 'BK', 'Yes', '0000-00-00 00:00:00'),
(2, 'Administrator', 'OPD', 'Yes', '0000-00-00 00:00:00'),
(3, 'Administrator', 'TAPD', 'Yes', '0000-00-00 00:00:00'),
(4, 'BK', 'BK', 'Yes', '0000-00-00 00:00:00'),
(5, 'OPD', 'OPD', 'Yes', '0000-00-00 00:00:00'),
(6, 'TAPD', 'TAPD', 'Yes', '0000-00-00 00:00:00'),
(8, 'BPKAD', 'BPKAD', 'Yes', '0000-00-00 00:00:00');
