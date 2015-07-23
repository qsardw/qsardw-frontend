-- MySQL dump 10.13  Distrib 5.5.44, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: qsardw
-- ------------------------------------------------------
-- Server version	5.5.44-0ubuntu0.14.04.1-log

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
-- Table structure for table `dataset`
--

DROP TABLE IF EXISTS `dataset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dataset` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dataset_name` varchar(255) NOT NULL,
  `description` mediumtext NOT NULL,
  `original_file` varchar(255) NOT NULL,
  `file_type` int(10) unsigned NOT NULL,
  `initial_molecules` int(10) unsigned NOT NULL DEFAULT '0',
  `distinct_molecules` int(10) unsigned NOT NULL DEFAULT '0',
  `is_cleaned` tinyint(1) NOT NULL DEFAULT '0',
  `owner` int(10) unsigned NOT NULL,
  `created_on` datetime NOT NULL,
  `multiple_molecules_strategy` int(10) unsigned NOT NULL DEFAULT '1',
  `on_duplicates_strategy` int(10) unsigned NOT NULL DEFAULT '1',
  `status` int(10) unsigned NOT NULL DEFAULT '0',
  `visibility` int(10) unsigned NOT NULL DEFAULT '1',
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dataset`
--

LOCK TABLES `dataset` WRITE;
/*!40000 ALTER TABLE `dataset` DISABLE KEYS */;
/*!40000 ALTER TABLE `dataset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dataset_errors`
--

DROP TABLE IF EXISTS `dataset_errors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dataset_errors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dataset` int(10) unsigned NOT NULL,
  `molecule` int(11) NOT NULL DEFAULT '0',
  `error_message` text NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_dataset_errors_dataset_id_idx` (`dataset`),
  CONSTRAINT `fk_dataset_errors_dataset_id` FOREIGN KEY (`dataset`) REFERENCES `dataset` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dataset_errors`
--

LOCK TABLES `dataset_errors` WRITE;
/*!40000 ALTER TABLE `dataset_errors` DISABLE KEYS */;
/*!40000 ALTER TABLE `dataset_errors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dataset_processed_molecules`
--

DROP TABLE IF EXISTS `dataset_processed_molecules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dataset_processed_molecules` (
  `dataset` int(10) unsigned NOT NULL,
  `molecule` int(10) unsigned NOT NULL,
  `processed_status` int(10) unsigned NOT NULL DEFAULT '1',
  `inchi_key` varchar(255) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`dataset`,`molecule`,`processed_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dataset_processed_molecules`
--

LOCK TABLES `dataset_processed_molecules` WRITE;
/*!40000 ALTER TABLE `dataset_processed_molecules` DISABLE KEYS */;
/*!40000 ALTER TABLE `dataset_processed_molecules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dataset_raw_molecules`
--

DROP TABLE IF EXISTS `dataset_raw_molecules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dataset_raw_molecules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dataset` int(10) unsigned NOT NULL,
  `molecule_number` int(10) unsigned NOT NULL,
  `smile` text NOT NULL,
  `inchi` text NOT NULL,
  `inchi_key` varchar(255) NOT NULL,
  `source_id` varchar(255) NOT NULL,
  `source_publication` varchar(255) NOT NULL,
  `source_name` varchar(255) NOT NULL,
  `is_duplicated` tinyint(1) NOT NULL DEFAULT '0',
  `status` int(10) unsigned NOT NULL,
  `molecules_group` int(10) unsigned DEFAULT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_dataset_raw_molecules_dataset_idx` (`dataset`),
  KEY `idx_dataset_molecule` (`dataset`,`molecule_number`),
  KEY `idx_dataset_inchi_key` (`dataset`,`inchi_key`),
  CONSTRAINT `fk_dataset_raw_molecules_dataset` FOREIGN KEY (`dataset`) REFERENCES `dataset` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dataset_raw_molecules`
--

LOCK TABLES `dataset_raw_molecules` WRITE;
/*!40000 ALTER TABLE `dataset_raw_molecules` DISABLE KEYS */;
/*!40000 ALTER TABLE `dataset_raw_molecules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dataset_raw_molecules_groups`
--

DROP TABLE IF EXISTS `dataset_raw_molecules_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dataset_raw_molecules_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dataset` int(10) unsigned NOT NULL,
  `group_smile` text NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dataset_raw_molecules_groups`
--

LOCK TABLES `dataset_raw_molecules_groups` WRITE;
/*!40000 ALTER TABLE `dataset_raw_molecules_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `dataset_raw_molecules_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `duplicated_molecules_strategy`
--

DROP TABLE IF EXISTS `duplicated_molecules_strategy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `duplicated_molecules_strategy` (
  `id` int(10) unsigned NOT NULL,
  `strategy_name` varchar(255) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `duplicated_molecules_strategy`
--

LOCK TABLES `duplicated_molecules_strategy` WRITE;
/*!40000 ALTER TABLE `duplicated_molecules_strategy` DISABLE KEYS */;
INSERT INTO `duplicated_molecules_strategy` VALUES (1,'Manual review','2014-02-26 22:00:30'),(2,'Discard all duplicates','2014-02-26 22:00:30'),(3,'Keep first moleculed found','2014-02-26 22:00:30');
/*!40000 ALTER TABLE `duplicated_molecules_strategy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_name` varchar(45) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'Default group','2015-07-23 11:00:50');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `multiple_molecules_strategy`
--

DROP TABLE IF EXISTS `multiple_molecules_strategy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `multiple_molecules_strategy` (
  `id` int(10) unsigned NOT NULL,
  `strategy_name` varchar(255) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `multiple_molecules_strategy`
--

LOCK TABLES `multiple_molecules_strategy` WRITE;
/*!40000 ALTER TABLE `multiple_molecules_strategy` DISABLE KEYS */;
INSERT INTO `multiple_molecules_strategy` VALUES (1,'Manual review','2014-03-30 21:16:50'),(2,'Biggest molecule automatic selection','2014-02-26 21:53:00');
/*!40000 ALTER TABLE `multiple_molecules_strategy` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `objects_visibility`
--

DROP TABLE IF EXISTS `objects_visibility`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `objects_visibility` (
  `id` int(10) unsigned NOT NULL,
  `visibility_name` varchar(255) NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `objects_visibility`
--

LOCK TABLES `objects_visibility` WRITE;
/*!40000 ALTER TABLE `objects_visibility` DISABLE KEYS */;
INSERT INTO `objects_visibility` VALUES (1,'Private','2014-03-10 22:08:41'),(2,'Group only','2014-03-10 22:08:41'),(3,'Public','2014-03-10 22:08:41');
/*!40000 ALTER TABLE `objects_visibility` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` varchar(255) NOT NULL,
  `complete_name` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `user_group` int(10) unsigned NOT NULL,
  `ts` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_unique_username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'test@test.com','25e4ee4e9229397b6b17776bfceaf8e7','ROLE_ADMIN','Admin','/images/user.png',1,'2015-07-23 11:02:42');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-07-23 13:03:28
