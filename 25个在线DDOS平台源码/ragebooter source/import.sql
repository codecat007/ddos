-- MySQL dump 10.13  Distrib 5.5.24, for Linux (x86_64)
--
-- Host: localhost    Database: elitemod_booter
-- ------------------------------------------------------
-- Server version	5.5.24-cll

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `blacklist`
--

DROP TABLE IF EXISTS `blacklist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blacklist` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `IP` varchar(15) NOT NULL,
  `note` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blacklist`
--

LOCK TABLES `blacklist` WRITE;
/*!40000 ALTER TABLE `blacklist` DISABLE KEYS */;
/*!40000 ALTER TABLE `blacklist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fe`
--

DROP TABLE IF EXISTS `fe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fe` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `type` varchar(1) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `note` text NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fe`
--

LOCK TABLES `fe` WRITE;
/*!40000 ALTER TABLE `fe` DISABLE KEYS */;
INSERT INTO `fe` (`ID`, `userID`, `type`, `ip`, `note`) VALUES (1,12,'e','110.175.100.136','Auspride018'),(2,13,'e','94.197.11.24',''),(3,8,'f','50.138.30.101','Nely'),(4,8,'f','50.55.247.24','Brittany'),(5,8,'f','98.94.78.64','channa'),(6,8,'f','108.210.196.40','Hector'),(7,8,'f','70.100.180.240','Kimmie'),(8,8,'f','50.33.227.18','Karissa'),(9,8,'f','108.214.117.105','Lilla');
/*!40000 ALTER TABLE `fe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gateway`
--

DROP TABLE IF EXISTS `gateway`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gateway` (
  `email` varchar(1024) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gateway`
--

LOCK TABLES `gateway` WRITE;
/*!40000 ALTER TABLE `gateway` DISABLE KEYS */;
INSERT INTO `gateway` (`email`) VALUES ('iamvicious@live.co.uk');
/*!40000 ALTER TABLE `gateway` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `iplogs`
--

DROP TABLE IF EXISTS `iplogs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `iplogs` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `userID` int(11) NOT NULL,
  `logged` varchar(15) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `iplogs`
--

LOCK TABLES `iplogs` WRITE;
/*!40000 ALTER TABLE `iplogs` DISABLE KEYS */;
INSERT INTO `iplogs` (`ID`, `userID`, `logged`, `date`) VALUES (3,12,'138.217.213.120',1343230058),(4,17,'203.142.149.165',1343437327);
/*!40000 ALTER TABLE `iplogs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs` (
  `user` varchar(15) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `port` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `method` varchar(10) NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` (`user`, `ip`, `port`, `time`, `method`, `date`) VALUES ('Admin','91.212.182.36',27000,120,'UDP',1343282197),('Ameer','71.238.177.60',80,180,'UDP',1343282696),('Admin','75.65.6.84',80,60,'SSYN',1343441306),('Admin','75.65.6.84',80,60,'UDP',1343441383);
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `detail` text NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` (`ID`, `title`, `detail`, `date`) VALUES (8,'Derpy Derp Durp','Da Derpy Derp Hacked Da Siet, DA DERPA HERP.',1343281954),(7,'Payment System','I regret to inform you that our current payment system is down and currently not working. If you wish to buy, the ideal way to get in contact would be via private message.\r\nContacts:\r\nHackforums: God\r\nSkype: C.elticfc\r\nAIM: Celticfc\r\nEmail: admin@ogbooter.info\r\n',1343131466),(5,'Welcome to OG Booter!','We would like to thank you for purchasing OG Booter, as the more customers we get, the better service you will receive. Secondly, we are implementing new features, so please do not worry if the site goes offline, as your membership will not be affected. Once again, thanks for purchasing, and have fun with the features available. ',1342885621);
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `paid` float NOT NULL,
  `plan` int(11) NOT NULL,
  `user` int(15) NOT NULL,
  `email` varchar(60) NOT NULL,
  `tid` varchar(30) NOT NULL,
  `date` int(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plans`
--

DROP TABLE IF EXISTS `plans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plans` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `mbt` int(11) NOT NULL,
  `unit` varchar(10) NOT NULL,
  `length` int(11) NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plans`
--

LOCK TABLES `plans` WRITE;
/*!40000 ALTER TABLE `plans` DISABLE KEYS */;
INSERT INTO `plans` (`ID`, `name`, `description`, `mbt`, `unit`, `length`, `price`) VALUES (17,'Silver Lifetime','Lifetime of Silver Booting. ',220,'Years',10,17),(16,'Premium 3 Months','3 Months of Premium Booting.',500,'Months',3,15),(19,'Premium Lifetime','Lifetime of premium boots',600,'Years',10,25),(13,'Premium 1 Month','1 Month of Premium Booting. ',500,'Months',1,7),(14,'Silver 3 Months','3 Months of Silver Booting.',180,'Months',3,180),(12,'Silver 1 Month','1 Month of Silver Booting. ',180,'Months',1,5),(11,'1 Day Trial','1 day trial to test the service. ',120,'Days',1,3);
/*!40000 ALTER TABLE `plans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skype_api`
--

DROP TABLE IF EXISTS `skype_api`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skype_api` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `ip` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skype_api`
--

LOCK TABLES `skype_api` WRITE;
/*!40000 ALTER TABLE `skype_api` DISABLE KEYS */;
INSERT INTO `skype_api` (`id`, `ip`) VALUES (2,'93.114.45.84 ');
/*!40000 ALTER TABLE `skype_api` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(15) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(50) NOT NULL,
  `rank` int(11) NOT NULL DEFAULT '0',
  `membership` int(11) NOT NULL,
  `expire` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `ID` (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`ID`, `username`, `password`, `email`, `rank`, `membership`, `expire`, `status`) VALUES (1,'Admin','0ab2b7ae42dae25d8b116d803ee580eda7ab6189','payments@hybird-host.com',1,19,1658970258,0),(18,'leey','4c0d2b951ffabd6f9a10489dc40fc356ec1d26d5','leey@hybrid-host.com',1,19,1658974045,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'rageboot_ohno'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2012-07-27 23:36:15
