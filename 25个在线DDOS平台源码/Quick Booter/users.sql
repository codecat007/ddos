-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 11, 2012 at 05:04 PM
-- Server version: 5.5.24
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `booter`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `member_id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` text NOT NULL,
  `group` int(5) NOT NULL,
  `membership` int(11) NOT NULL DEFAULT '0',
  `email` text NOT NULL,
  `expire_date` int(15) NOT NULL DEFAULT '0',
  `date_created` int(20) NOT NULL,
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`member_id`, `username`, `password`, `group`, `membership`, `email`, `expire_date`, `date_created`) VALUES
(1, 'admin', '6351bf9dce654515bf1ddbd6426dfa97', 1, 1, '', 0, 0),
(4, 'fake', 'b1282c1dbc170a3f4bf470b7edb080c3', 2, 0, 'fake@gmail.com', 0, 1341958897),
(5, 'Lol', 'e3d704f3542b44a621ebed70dc0efe13', 1, 0, 'email_test9@hotmail.com', 0, 1341959275),
(6, 'test', 'b292c311741b947ee1d8c94d391f1904', 2, 0, 'testing@gmail.com', 0, 1341963923),
(7, 'fakename', '2fdfdf0fbbce603cf24c0eee7dabf28c', 2, 0, 'fakename@gmail.com', 0, 1342016038),
(8, 'Ferrari', 'a6e7cca13cc85e5825ef8f39ca0e22f7', 1, 0, 'miles.collier@live.com', 0, 1342022166),
(9, 'a', '8f036369a5cd26454949e594fb9e0a2d', 2, 0, 'ok@gmail.com', 0, 1342031301),
(10, 'test12', '60474c9c10d7142b7508ce7a50acf414', 2, 0, 'hfebook@hotmail.com', 0, 1342043864);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
