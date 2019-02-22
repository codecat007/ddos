-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 26, 2011 at 03:26 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dbprepare`
--

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `booter_name` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `config`
--

INSERT INTO `config` (`booter_name`) VALUES
('Your Booter');

-- --------------------------------------------------------

--
-- Table structure for table `getshells`
--

CREATE TABLE IF NOT EXISTS `getshells` (
  `URL` varchar(1000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `getshells`
--


-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `username` text NOT NULL,
  `ip` text NOT NULL,
  `time` text NOT NULL,
  `port` text NOT NULL,
  `date` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logs`
--


-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(1000) NOT NULL,
  `message` text NOT NULL,
  `date` varchar(1000) NOT NULL,
  `author` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `message`, `date`, `author`) VALUES
(1, 'Hello HackForums!', 'This is prodigy, testing my booters news system!', '01-26-2011, 02:36:04 pm', 'Test3');

-- --------------------------------------------------------

--
-- Table structure for table `postshells`
--

CREATE TABLE IF NOT EXISTS `postshells` (
  `URL` varchar(9001) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `postshells`
--


-- --------------------------------------------------------

--
-- Table structure for table `slowloris`
--

CREATE TABLE IF NOT EXISTS `slowloris` (
  `URL` varchar(1000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `slowloris`
--


-- --------------------------------------------------------

--
-- Table structure for table `updates`
--

CREATE TABLE IF NOT EXISTS `updates` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `message` varchar(1000) NOT NULL,
  `date` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `updates`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `md5_id` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `full_name` tinytext COLLATE latin1_general_ci NOT NULL,
  `user_name` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `user_email` varchar(220) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `user_level` tinyint(4) NOT NULL DEFAULT '1',
  `pwd` varchar(220) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `address` text COLLATE latin1_general_ci NOT NULL,
  `country` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `tel` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `fax` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `website` text COLLATE latin1_general_ci NOT NULL,
  `date` varchar(1000) COLLATE latin1_general_ci NOT NULL,
  `users_ip` varchar(200) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `approved` int(1) NOT NULL DEFAULT '0',
  `activation_code` int(10) NOT NULL DEFAULT '0',
  `banned` int(1) NOT NULL DEFAULT '0',
  `ckey` varchar(220) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `ctime` varchar(220) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `myAttacks` varchar(5000) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_email` (`user_email`),
  FULLTEXT KEY `idx_search` (`full_name`,`address`,`user_email`,`user_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `users`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
