-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 03, 2011 at 06:29 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `phantacdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_guests`
--

CREATE TABLE IF NOT EXISTS `active_guests` (
  `ip` varchar(15) NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  PRIMARY KEY (`ip`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `active_guests`
--


-- --------------------------------------------------------

--
-- Table structure for table `active_users`
--

CREATE TABLE IF NOT EXISTS `active_users` (
  `username` varchar(30) NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `active_users`
--

INSERT INTO `active_users` (`username`, `timestamp`) VALUES
('John', 1299172123);

-- --------------------------------------------------------

--
-- Table structure for table `banned_users`
--

CREATE TABLE IF NOT EXISTS `banned_users` (
  `username` varchar(30) NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banned_users`
--


-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(255) NOT NULL,
  `username` varchar(30) NOT NULL DEFAULT '',
  `userip` varchar(15) NOT NULL DEFAULT '',
  `ddosdip` varchar(15) NOT NULL DEFAULT '',
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `username`, `userip`, `ddosdip`, `date`) VALUES
(54, 'ghfghfgh', '::1', '22.22.22.22', '2011-03-02'),
(1, 'john', '::1', '22.22.22.22', '2011-03-02');

-- --------------------------------------------------------

--
-- Table structure for table `private_msgs`
--

CREATE TABLE IF NOT EXISTS `private_msgs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `to_id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `time_sent` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `opened` enum('0','1') NOT NULL,
  `recipientDelete` enum('0','1') NOT NULL,
  `senderDelete` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `private_msgs`
--


-- --------------------------------------------------------

--
-- Table structure for table `privshells`
--

CREATE TABLE IF NOT EXISTS `privshells` (
  `URL` varchar(9001) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `privshells`
--

INSERT INTO `privshells` (`URL`) VALUES
('google.com');

-- --------------------------------------------------------

--
-- Table structure for table `sqlshells`
--

CREATE TABLE IF NOT EXISTS `sqlshells` (
  `URL` varchar(1000) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sqlshells`
--

INSERT INTO `sqlshells` (`URL`) VALUES
('google.com');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(30) NOT NULL,
  `password` varchar(32) DEFAULT NULL,
  `userid` varchar(32) DEFAULT NULL,
  `userlevel` tinyint(1) unsigned NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `lastlogged` date DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;