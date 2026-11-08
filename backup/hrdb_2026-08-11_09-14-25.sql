-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: hrdb
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_logs` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `activity` text NOT NULL,
  `module` varchar(50) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `log_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (1,10,'Updated document \"ok\" to Approved',NULL,NULL,'2026-07-13 09:46:19'),(2,10,'Updated document \"ok\" to Approved',NULL,NULL,'2026-07-13 09:48:51'),(3,10,'Updated document \"ok\" to Approved',NULL,NULL,'2026-07-13 09:48:53'),(4,10,'Updated document \"ok\" to Rejected',NULL,NULL,'2026-07-13 09:49:06'),(5,6,'Updated document \"ok\" to Rejected',NULL,NULL,'2026-07-13 09:50:37'),(6,6,'Updated document \"ok\" to Rejected',NULL,NULL,'2026-07-13 10:52:39'),(7,10,'Updated document \"title\" to Pending',NULL,NULL,'2026-07-13 22:32:03'),(8,10,'Updated document \"ok\" to Approved',NULL,NULL,'2026-07-13 22:32:23'),(9,10,'Updated document \"ok\" to Approved',NULL,NULL,'2026-07-13 22:32:25'),(10,11,'Updated document \"sakto ni sa maam?\" to Approved',NULL,NULL,'2026-07-19 09:23:03'),(11,11,'Updated document \"sakto ni sa maam?\" to Approved',NULL,NULL,'2026-07-19 10:18:11'),(12,11,'Updated document \"title\" to Rejected',NULL,NULL,'2026-07-19 10:19:20'),(13,11,'Updated document \"title\" to Approved',NULL,NULL,'2026-07-19 10:19:28'),(14,13,'Updated document \"te maam?\" to Approved',NULL,NULL,'2026-07-20 03:04:26'),(15,10,'Updated document \"sakto ni sa maam?\" to Approved',NULL,NULL,'2026-07-20 13:39:24'),(16,12,'Updated document \'ELigibilty Certificate\' to Returned',NULL,NULL,'2026-07-21 04:51:53'),(17,12,'Updated document \'dpcr ah\' to Pending',NULL,NULL,'2026-07-21 05:04:40'),(18,12,'Updated document \'dga\' to Approved',NULL,NULL,'2026-07-22 03:19:23'),(19,10,'Updated document \'PDS\' to Rejected',NULL,NULL,'2026-07-27 04:11:13'),(20,10,'Updated document \'dga\' to Approved',NULL,NULL,'2026-07-27 04:11:14'),(21,11,'Updated document \'ghg\' to Approved',NULL,NULL,'2026-07-27 06:41:23'),(22,10,'Posted a submission deadline for \"DPCR\" (August 7, 2026)','Deadlines',NULL,'2026-07-30 10:02:21'),(23,10,'Posted a submission deadline for \"DPCR\" (August 7, 2026)','Deadlines',NULL,'2026-07-30 10:09:39'),(24,10,'Posted a submission deadline for \"DTR Monthly\" (July 30, 2026)','Deadlines',NULL,'2026-07-30 10:42:19'),(25,10,'Posted a submission deadline for \"DTR Monthly\" (July 30, 2026)','Deadlines',NULL,'2026-07-30 11:16:40'),(26,10,'Posted a submission deadline for \"Eligibility Certificate\" (July 30, 2026)','Deadlines',NULL,'2026-07-30 11:18:09'),(27,10,'Posted a submission deadline for \"Diploma\" (August 6, 2026)','Deadlines',NULL,'2026-07-30 11:19:48'),(28,10,'Manually sent reminder for \"Diploma\" to 8 faculty','Deadlines',NULL,'2026-07-30 11:20:26'),(29,10,'Posted a submission deadline for \"Diploma\" (August 6, 2026)','Deadlines',NULL,'2026-07-30 11:20:50'),(30,14,'Created database backup: hrdb_2026-08-11_09-12-24.sql','Database Maintenance',NULL,'2026-08-11 07:12:25'),(31,14,'Created database backup: hrdb_2026-08-11_09-12-52.sql','Database Maintenance',NULL,'2026-08-11 07:12:52'),(32,14,'Created database backup: hrdb_2026-08-11_09-14-19.sql','Database Maintenance',NULL,'2026-08-11 07:14:19');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `announcements` (
  `announcement_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`announcement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
INSERT INTO `announcements` VALUES (1,'meeting','may meeting alas 2 rum an ah','2026-07-20 07:51:02');
/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `backup_logs`
--

DROP TABLE IF EXISTS `backup_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backup_logs` (
  `backup_id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `action` varchar(20) NOT NULL,
  `performed_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`backup_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup_logs`
--

LOCK TABLES `backup_logs` WRITE;
/*!40000 ALTER TABLE `backup_logs` DISABLE KEYS */;
INSERT INTO `backup_logs` VALUES (1,'hrdb_2026-08-11_09-12-24.sql','backup',14,'2026-08-11 07:12:25'),(2,'hrdb_2026-08-11_09-12-52.sql','backup',14,'2026-08-11 07:12:52'),(3,'hrdb_2026-08-11_09-14-19.sql','backup',14,'2026-08-11 07:14:19');
/*!40000 ALTER TABLE `backup_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `document_categories`
--

DROP TABLE IF EXISTS `document_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `document_categories` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document_categories`
--

LOCK TABLES `document_categories` WRITE;
/*!40000 ALTER TABLE `document_categories` DISABLE KEYS */;
INSERT INTO `document_categories` VALUES (1,'PDS'),(2,'IPCR'),(3,'UPCR'),(4,'DPCR'),(5,'Service Credit Accomplishment Report'),(6,'Year-End Faculty Clearance'),(7,'Clearance Per Job Order Employees'),(8,'Part-Time Faculty Clearance'),(9,'DTR Monthly'),(10,'DTR Yearly'),(11,'Faculty Profile'),(12,'Job Application'),(13,'Request for Personnel Records'),(14,'Transcript of Records'),(15,'Diploma'),(16,'Medical Certificate'),(17,'Marriage Certificate'),(18,'Service Record'),(19,'Job Description - JOCOS'),(20,'Eligibility Certificate'),(21,'License'),(22,'Rating'),(23,'Individual Professional Development Plan'),(24,'Learning Needs Assessment'),(25,'Learning Application Report'),(26,'Travel Narrative Report');
/*!40000 ALTER TABLE `document_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `document_reviews`
--

DROP TABLE IF EXISTS `document_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `document_reviews` (
  `review_id` int(11) NOT NULL AUTO_INCREMENT,
  `document_id` int(11) NOT NULL,
  `reviewer_id` int(11) NOT NULL,
  `reviewer_role` varchar(20) DEFAULT NULL,
  `action_taken` varchar(100) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `review_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`review_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document_reviews`
--

LOCK TABLES `document_reviews` WRITE;
/*!40000 ALTER TABLE `document_reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `document_reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents` (
  `document_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `deadline_id` int(11) DEFAULT NULL,
  `document_title` varchar(255) NOT NULL,
  `faculty_comment` text DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_size` int(11) DEFAULT NULL,
  `remarks` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `hr_remarks` text DEFAULT NULL,
  PRIMARY KEY (`document_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents`
--

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
INSERT INTO `documents` VALUES (1,3,20,NULL,'title',NULL,'1781595459_Untitled design (1).pdf','../uploads/1781595459_Untitled design (1).pdf',NULL,NULL,'Approved','2026-06-16 07:37:39','ok sya but you need to imporove more'),(2,6,9,NULL,'title',NULL,'1781597251_infographic.png','../uploads/1781597251_infographic.png',NULL,NULL,'Approved','2026-06-16 08:07:31','nami mn'),(3,6,18,NULL,'service record',NULL,'1783314455_anon.jpg','../uploads/1783314455_anon.jpg',NULL,NULL,'Approved','2026-07-06 05:07:35','sge'),(4,6,7,NULL,'ok',NULL,'1783315657_Untitled design.png','../uploads/1783315657_Untitled design.png',NULL,NULL,'Approved','2026-07-06 05:27:37','hayop ka'),(5,11,9,NULL,'sakto ni sa maam?',NULL,'1784452948_isatumc.jpg','../uploads/1784452948_isatumc.jpg',NULL,NULL,'Approved','2026-07-19 09:22:28','yes Maam ok gid sya'),(7,12,1,NULL,'PDS',NULL,'1784607841_2015-SALN-Form SeroWan 2024.doc','../uploads/1784607841_2015-SALN-Form SeroWan 2024.doc',NULL,NULL,'Rejected','2026-07-21 04:24:01','wat es des?'),(8,12,20,NULL,'ELigibilty Certificate','paki check maam kun sakto','1784609405_Applications of Chemistry.docx','../uploads/1784609405_Applications of Chemistry.docx',NULL,NULL,'Returned','2026-07-21 04:50:05','yes maam pwede mo na submit'),(9,12,4,NULL,'dpcr ah','check b boss','1784610210_Male Teacher DEPED - Copy.png','../uploads/1784610210_Male Teacher DEPED - Copy.png',NULL,NULL,'Pending','2026-07-21 05:03:30','sktoo oah'),(10,12,9,NULL,'dga','fadsfdgd','1784690349_8c5081f1d800f54a3b2620c9e8b0529a.jpg','../uploads/1784690349_8c5081f1d800f54a3b2620c9e8b0529a.jpg',NULL,NULL,'Approved','2026-07-22 03:19:09','hgy'),(11,11,9,NULL,'ghg','','1785134454_duplex-house-construction-cost-india.jpg','../uploads/1785134454_duplex-house-construction-cost-india.jpg',NULL,NULL,'Approved','2026-07-27 06:40:54','');
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(30) DEFAULT 'general',
  `is_read` tinyint(4) DEFAULT 0,
  `email_sent` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`notification_id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,6,'Your document \"service record\" has been Pending by HR.','general',0,0,'2026-07-06 05:23:20'),(2,6,'Your document \"service record\" has been Approved by HR.','general',0,0,'2026-07-06 05:24:04'),(3,6,'Your document \"service record\" has been Approved by HR.','general',0,0,'2026-07-06 05:26:02'),(4,6,'Your document \"service record\" has been Approved by HR.','general',0,0,'2026-07-06 05:27:47'),(5,6,'Your document \"ok\" has been Approved by HR.','general',0,0,'2026-07-06 05:27:52'),(6,6,'Your document \"ok\" has been Approved by HR.','general',0,0,'2026-07-13 09:46:19'),(7,6,'Your document \"ok\" has been Approved by HR.','general',0,0,'2026-07-13 09:48:51'),(8,6,'Your document \"ok\" has been Approved by HR.','general',0,0,'2026-07-13 09:48:53'),(9,6,'Your document \"ok\" has been Rejected by HR.','general',0,0,'2026-07-13 09:49:06'),(10,6,'Your document \"ok\" has been Rejected by HR.','general',0,0,'2026-07-13 09:50:37'),(11,6,'Your document \"ok\" has been Rejected by HR.','general',0,0,'2026-07-13 10:52:39'),(12,3,'Your document \"title\" has been Pending by HR.','general',0,0,'2026-07-13 22:32:03'),(13,6,'Your document \"ok\" has been Approved by HR.','general',0,0,'2026-07-13 22:32:23'),(14,6,'Your document \"ok\" has been Approved by HR.','general',0,0,'2026-07-13 22:32:25'),(15,11,'Your document \"sakto ni sa maam?\" has been Approved by HR.','general',1,0,'2026-07-19 09:23:03'),(16,11,'Your document \"sakto ni sa maam?\" has been Approved by HR.','general',1,0,'2026-07-19 10:18:11'),(17,3,'Your document \"title\" has been Rejected by HR.','general',0,0,'2026-07-19 10:19:20'),(18,3,'Your document \"title\" has been Approved by HR.','general',0,0,'2026-07-19 10:19:28'),(20,11,'Your document \"sakto ni sa maam?\" has been Approved by HR.','general',1,0,'2026-07-20 13:39:24'),(21,12,'Your document \'ELigibilty Certificate\' has been Returned by HR.','general',1,0,'2026-07-21 04:51:53'),(22,12,'Your document \'dpcr ah\' has been Pending by HR.','general',1,0,'2026-07-21 05:04:40'),(23,12,'Your document \'dga\' has been Approved by HR.','general',1,0,'2026-07-22 03:19:23'),(24,12,'Your document \'PDS\' has been Rejected by HR.','general',1,0,'2026-07-27 04:11:13'),(25,12,'Your document \'dga\' has been Approved by HR.','general',1,0,'2026-07-27 04:11:14'),(26,11,'Your document \'ghg\' has been Approved by HR.','general',1,0,'2026-07-27 06:41:23'),(27,11,'New deadline: submit your \"DPCR\" by August 7, 2026, 4:00 PM.','deadline',1,0,'2026-07-30 10:02:21'),(28,12,'New deadline: submit your \"DPCR\" by August 7, 2026, 4:00 PM.','deadline',0,0,'2026-07-30 10:02:21'),(29,15,'New deadline: submit your \"DPCR\" by August 7, 2026, 4:00 PM.','deadline',0,0,'2026-07-30 10:02:21'),(30,17,'New deadline: submit your \"DPCR\" by August 7, 2026, 4:00 PM.','deadline',1,0,'2026-07-30 10:02:21'),(31,18,'New deadline: submit your \"DPCR\" by August 7, 2026, 4:00 PM.','deadline',0,0,'2026-07-30 10:02:21'),(32,19,'New deadline: submit your \"DPCR\" by August 7, 2026, 4:00 PM.','deadline',0,0,'2026-07-30 10:02:21'),(33,20,'New deadline: submit your \"DPCR\" by August 7, 2026, 4:00 PM.','deadline',0,0,'2026-07-30 10:02:21'),(34,11,'New deadline: submit your \"DPCR\" by August 7, 2026, 4:00 PM.','deadline',1,0,'2026-07-30 10:09:39'),(35,12,'New deadline: submit your \"DPCR\" by August 7, 2026, 4:00 PM.','deadline',0,0,'2026-07-30 10:09:39'),(36,15,'New deadline: submit your \"DPCR\" by August 7, 2026, 4:00 PM.','deadline',0,0,'2026-07-30 10:09:39'),(37,17,'New deadline: submit your \"DPCR\" by August 7, 2026, 4:00 PM.','deadline',1,0,'2026-07-30 10:09:39'),(38,18,'New deadline: submit your \"DPCR\" by August 7, 2026, 4:00 PM.','deadline',0,0,'2026-07-30 10:09:39'),(39,19,'New deadline: submit your \"DPCR\" by August 7, 2026, 4:00 PM.','deadline',0,0,'2026-07-30 10:09:39'),(40,20,'New deadline: submit your \"DPCR\" by August 7, 2026, 4:00 PM.','deadline',0,0,'2026-07-30 10:09:39'),(41,11,'New deadline: submit your \"DTR Monthly\" by July 30, 2026, 6:44 PM.','deadline',1,1,'2026-07-30 10:41:58'),(42,12,'New deadline: submit your \"DTR Monthly\" by July 30, 2026, 6:44 PM.','deadline',0,1,'2026-07-30 10:41:58'),(43,15,'New deadline: submit your \"DTR Monthly\" by July 30, 2026, 6:44 PM.','deadline',0,1,'2026-07-30 10:41:58'),(44,17,'New deadline: submit your \"DTR Monthly\" by July 30, 2026, 6:44 PM.','deadline',1,1,'2026-07-30 10:41:58'),(45,18,'New deadline: submit your \"DTR Monthly\" by July 30, 2026, 6:44 PM.','deadline',0,1,'2026-07-30 10:41:58'),(46,19,'New deadline: submit your \"DTR Monthly\" by July 30, 2026, 6:44 PM.','deadline',0,1,'2026-07-30 10:41:58'),(47,20,'New deadline: submit your \"DTR Monthly\" by July 30, 2026, 6:44 PM.','deadline',0,1,'2026-07-30 10:41:58'),(48,21,'New deadline: submit your \"DTR Monthly\" by July 30, 2026, 6:44 PM.','deadline',1,1,'2026-07-30 10:41:58'),(49,11,'New deadline: submit your \"DTR Monthly\" by July 30, 2026, 6:44 PM.','deadline',1,1,'2026-07-30 11:16:16'),(50,12,'New deadline: submit your \"DTR Monthly\" by July 30, 2026, 6:44 PM.','deadline',0,1,'2026-07-30 11:16:16'),(51,15,'New deadline: submit your \"DTR Monthly\" by July 30, 2026, 6:44 PM.','deadline',0,1,'2026-07-30 11:16:16'),(52,17,'New deadline: submit your \"DTR Monthly\" by July 30, 2026, 6:44 PM.','deadline',1,1,'2026-07-30 11:16:16'),(53,18,'New deadline: submit your \"DTR Monthly\" by July 30, 2026, 6:44 PM.','deadline',0,1,'2026-07-30 11:16:16'),(54,19,'New deadline: submit your \"DTR Monthly\" by July 30, 2026, 6:44 PM.','deadline',0,1,'2026-07-30 11:16:16'),(55,20,'New deadline: submit your \"DTR Monthly\" by July 30, 2026, 6:44 PM.','deadline',0,1,'2026-07-30 11:16:16'),(56,21,'New deadline: submit your \"DTR Monthly\" by July 30, 2026, 6:44 PM.','deadline',1,1,'2026-07-30 11:16:16'),(57,11,'New deadline: submit your \"Eligibility Certificate\" by July 30, 2026, 7:18 PM.','deadline',1,1,'2026-07-30 11:17:46'),(58,12,'New deadline: submit your \"Eligibility Certificate\" by July 30, 2026, 7:18 PM.','deadline',0,1,'2026-07-30 11:17:46'),(59,15,'New deadline: submit your \"Eligibility Certificate\" by July 30, 2026, 7:18 PM.','deadline',0,1,'2026-07-30 11:17:46'),(60,17,'New deadline: submit your \"Eligibility Certificate\" by July 30, 2026, 7:18 PM.','deadline',1,1,'2026-07-30 11:17:46'),(61,18,'New deadline: submit your \"Eligibility Certificate\" by July 30, 2026, 7:18 PM.','deadline',0,1,'2026-07-30 11:17:46'),(62,19,'New deadline: submit your \"Eligibility Certificate\" by July 30, 2026, 7:18 PM.','deadline',0,1,'2026-07-30 11:17:46'),(63,20,'New deadline: submit your \"Eligibility Certificate\" by July 30, 2026, 7:18 PM.','deadline',0,1,'2026-07-30 11:17:46'),(64,21,'New deadline: submit your \"Eligibility Certificate\" by July 30, 2026, 7:18 PM.','deadline',1,1,'2026-07-30 11:17:46'),(65,11,'New deadline: submit your \"Diploma\" by August 6, 2026, 7:21 PM.','deadline',1,1,'2026-07-30 11:19:25'),(66,12,'New deadline: submit your \"Diploma\" by August 6, 2026, 7:21 PM.','deadline',0,1,'2026-07-30 11:19:25'),(67,15,'New deadline: submit your \"Diploma\" by August 6, 2026, 7:21 PM.','deadline',0,1,'2026-07-30 11:19:25'),(68,17,'New deadline: submit your \"Diploma\" by August 6, 2026, 7:21 PM.','deadline',1,1,'2026-07-30 11:19:25'),(69,18,'New deadline: submit your \"Diploma\" by August 6, 2026, 7:21 PM.','deadline',0,1,'2026-07-30 11:19:25'),(70,19,'New deadline: submit your \"Diploma\" by August 6, 2026, 7:21 PM.','deadline',0,1,'2026-07-30 11:19:25'),(71,20,'New deadline: submit your \"Diploma\" by August 6, 2026, 7:21 PM.','deadline',0,1,'2026-07-30 11:19:25'),(72,21,'New deadline: submit your \"Diploma\" by August 6, 2026, 7:21 PM.','deadline',1,1,'2026-07-30 11:19:25'),(73,11,'Reminder: you still haven\'t submitted \"Diploma\". Deadline is August 6, 2026, 7:21 PM.','deadline_reminder',1,0,'2026-07-30 11:20:02'),(74,12,'Reminder: you still haven\'t submitted \"Diploma\". Deadline is August 6, 2026, 7:21 PM.','deadline_reminder',0,0,'2026-07-30 11:20:02'),(75,15,'Reminder: you still haven\'t submitted \"Diploma\". Deadline is August 6, 2026, 7:21 PM.','deadline_reminder',0,0,'2026-07-30 11:20:02'),(76,17,'Reminder: you still haven\'t submitted \"Diploma\". Deadline is August 6, 2026, 7:21 PM.','deadline_reminder',1,0,'2026-07-30 11:20:02'),(77,18,'Reminder: you still haven\'t submitted \"Diploma\". Deadline is August 6, 2026, 7:21 PM.','deadline_reminder',0,0,'2026-07-30 11:20:02'),(78,19,'Reminder: you still haven\'t submitted \"Diploma\". Deadline is August 6, 2026, 7:21 PM.','deadline_reminder',0,0,'2026-07-30 11:20:02'),(79,20,'Reminder: you still haven\'t submitted \"Diploma\". Deadline is August 6, 2026, 7:21 PM.','deadline_reminder',0,0,'2026-07-30 11:20:02'),(80,21,'Reminder: you still haven\'t submitted \"Diploma\". Deadline is August 6, 2026, 7:21 PM.','deadline_reminder',1,0,'2026-07-30 11:20:02'),(81,11,'New deadline: submit your \"Diploma\" by August 6, 2026, 7:21 PM.','deadline',1,1,'2026-07-30 11:20:28'),(82,12,'New deadline: submit your \"Diploma\" by August 6, 2026, 7:21 PM.','deadline',0,1,'2026-07-30 11:20:28'),(83,15,'New deadline: submit your \"Diploma\" by August 6, 2026, 7:21 PM.','deadline',0,1,'2026-07-30 11:20:28'),(84,17,'New deadline: submit your \"Diploma\" by August 6, 2026, 7:21 PM.','deadline',1,1,'2026-07-30 11:20:28'),(85,18,'New deadline: submit your \"Diploma\" by August 6, 2026, 7:21 PM.','deadline',0,1,'2026-07-30 11:20:28'),(86,19,'New deadline: submit your \"Diploma\" by August 6, 2026, 7:21 PM.','deadline',0,1,'2026-07-30 11:20:28'),(87,20,'New deadline: submit your \"Diploma\" by August 6, 2026, 7:21 PM.','deadline',0,1,'2026-07-30 11:20:28'),(88,21,'New deadline: submit your \"Diploma\" by August 6, 2026, 7:21 PM.','deadline',1,1,'2026-07-30 11:20:28'),(89,11,'Reminder: you still haven\'t submitted \"Diploma\". Deadline is August 6, 2026, 7:21 PM.','deadline_reminder',0,0,'2026-07-30 11:44:28'),(90,12,'Reminder: you still haven\'t submitted \"Diploma\". Deadline is August 6, 2026, 7:21 PM.','deadline_reminder',0,0,'2026-07-30 11:44:28'),(91,15,'Reminder: you still haven\'t submitted \"Diploma\". Deadline is August 6, 2026, 7:21 PM.','deadline_reminder',0,0,'2026-07-30 11:44:28'),(92,17,'Reminder: you still haven\'t submitted \"Diploma\". Deadline is August 6, 2026, 7:21 PM.','deadline_reminder',1,0,'2026-07-30 11:44:28'),(93,18,'Reminder: you still haven\'t submitted \"Diploma\". Deadline is August 6, 2026, 7:21 PM.','deadline_reminder',0,0,'2026-07-30 11:44:28'),(94,19,'Reminder: you still haven\'t submitted \"Diploma\". Deadline is August 6, 2026, 7:21 PM.','deadline_reminder',0,0,'2026-07-30 11:44:28'),(95,20,'Reminder: you still haven\'t submitted \"Diploma\". Deadline is August 6, 2026, 7:21 PM.','deadline_reminder',0,0,'2026-07-30 11:44:28'),(96,21,'Reminder: you still haven\'t submitted \"Diploma\". Deadline is August 6, 2026, 7:21 PM.','deadline_reminder',1,0,'2026-07-30 11:44:28');
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `requirements_tracker`
--

DROP TABLE IF EXISTS `requirements_tracker`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `requirements_tracker` (
  `tracker_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `requirement_status` varchar(20) DEFAULT 'Missing',
  PRIMARY KEY (`tracker_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `requirements_tracker`
--

LOCK TABLES `requirements_tracker` WRITE;
/*!40000 ALTER TABLE `requirements_tracker` DISABLE KEYS */;
/*!40000 ALTER TABLE `requirements_tracker` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `submission_deadlines`
--

DROP TABLE IF EXISTS `submission_deadlines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `submission_deadlines` (
  `deadline_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `deadline_date` date NOT NULL,
  `deadline_time` time NOT NULL,
  `message` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) DEFAULT 'Active',
  `weekly_reminder` tinyint(1) NOT NULL DEFAULT 0,
  `last_reminder_sent` datetime DEFAULT NULL,
  PRIMARY KEY (`deadline_id`),
  KEY `category_id` (`category_id`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submission_deadlines`
--

LOCK TABLES `submission_deadlines` WRITE;
/*!40000 ALTER TABLE `submission_deadlines` DISABLE KEYS */;
INSERT INTO `submission_deadlines` VALUES (1,4,'2026-08-07','16:00:00','',10,'2026-07-30 10:02:21','Active',0,NULL),(2,4,'2026-08-07','16:00:00','',10,'2026-07-30 10:09:39','Active',0,NULL),(3,9,'2026-07-30','18:44:00','',10,'2026-07-30 10:41:58','Active',0,NULL),(4,9,'2026-07-30','18:44:00','',10,'2026-07-30 11:16:16','Active',0,NULL),(5,20,'2026-07-30','19:18:00','',10,'2026-07-30 11:17:46','Active',0,NULL),(6,15,'2026-08-06','19:21:00','',10,'2026-07-30 11:19:25','Active',1,'2026-07-30 19:20:26'),(7,15,'2026-08-06','19:21:00','',10,'2026-07-30 11:20:28','Active',1,'2026-07-30 19:44:47');
/*!40000 ALTER TABLE `submission_deadlines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_logs`
--

DROP TABLE IF EXISTS `system_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_logs` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `event` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `performed_by` varchar(100) DEFAULT NULL,
  `log_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_logs`
--

LOCK TABLES `system_logs` WRITE;
/*!40000 ALTER TABLE `system_logs` DISABLE KEYS */;
INSERT INTO `system_logs` VALUES (1,'System Initialized','HR Document Management System has been installed.','System','2026-07-21 15:59:25');
/*!40000 ALTER TABLE `system_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_settings`
--

DROP TABLE IF EXISTS `system_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `system_name` varchar(255) DEFAULT NULL,
  `school_name` varchar(255) DEFAULT NULL,
  `campus` varchar(255) DEFAULT NULL,
  `official_email` varchar(255) DEFAULT NULL,
  `smtp_host` varchar(100) DEFAULT 'smtp.gmail.com',
  `smtp_port` int(5) DEFAULT 587,
  `smtp_username` varchar(150) DEFAULT NULL,
  `smtp_app_password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_settings`
--

LOCK TABLES `system_settings` WRITE;
/*!40000 ALTER TABLE `system_settings` DISABLE KEYS */;
INSERT INTO `system_settings` VALUES (1,'ISAT U HR Document Management System','Iloilo Science and Technology University','Miagao Campus','','smtp.gmail.com',587,'gabadaljohncarlo6@gmail.com','fcbd kkbe fulw vcgv');
/*!40000 ALTER TABLE `system_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(50) DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL,
  `department` varchar(150) DEFAULT NULL,
  `position_title` varchar(150) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (10,'1111','hr','hr','hr','hr@gmail.com','$2y$10$orMyZwCfai4cAbUCuHh/iuKtdayfsM33W93zA5UGATO0s6TIrh1IW','hr','Others',NULL,NULL,NULL,NULL,'Active','2026-07-13 07:53:52'),(11,'2024-1234-F','Michael ','Aguilar','Atilano','michael@gmail.com','$2y$10$ffbMOmSWgSy3hNgR06/Bw.KXqteNUHz/4v1zMrARPysGD3Mpnt88S','faculty','Education',NULL,'profile_11_1785410828.jpg',NULL,NULL,'Active','2026-07-19 09:10:38'),(12,'2023-1423','Gian Alexic','Esleyer','Ecle','gian@gmail.com','$2y$10$49WG4I0q4ze4p6ajG5LQDuSLNEDQt2OhQTWWWE1n8LkkEZUX.XyvW','faculty','HBM','',NULL,NULL,NULL,'Active','2026-07-19 09:11:17'),(14,'2021323','Ramon','N.','Emmanuel','admin@gmail.com','$2y$10$zGiN9SAHCM1/BIR5dyz09e.jnjPSz4F2Xd1XU3kj.sf1raTOk8NUG','admin','Others','Administrator',NULL,NULL,NULL,'Active','2026-07-20 03:11:01'),(15,'2023-4111-M','John','Carlo','Gabadal','carlo@gmail.com','$2y$10$W0xzLYUZZ.7wjlvMmw9gEOyV3ZqnTdeLctvk8pO2QS8DGLzKsACoC','faculty','Computer Studies',NULL,NULL,NULL,NULL,'Active','2026-07-21 06:10:09'),(16,'20213232','Kieavane','Carlo','Gabadal','kievanne@gmail.com','$2y$10$ONHrvNM/R/RT12rCKRKw4ORogYM03LoTWjX7vNqbCIikMvCdDiyKG','faculty','Others','',NULL,NULL,NULL,'Inactive','2026-07-21 09:52:39'),(17,'123','Emmanuel','Pogi','Tanagras','emmanuel@gmail.com','$2y$10$0blJPlpNAu8ueChNwfUiP.o1W8Ff6FTi9THNZ/XuAkaxcU3FK.2J6','faculty','Others',NULL,NULL,NULL,NULL,'Active','2026-07-21 09:56:56'),(18,'344738','Judifer John','Gito','Legaspi','judifer@gmail.com','$2y$10$C5pHKp7XizJTLt9VgIXWOuMjE7pDAB.tJNCAeb.usTfFjeyNyYTAe','faculty','Computer Studies',NULL,NULL,NULL,NULL,'Active','2026-07-21 15:02:00'),(19,'83737','Hance ','Manuel','Tipolo','hance@gmail.com','$2y$10$JsF8L4RiflDfNs2YVWHJFee9b1wHI.J8GIOps4SWlUq15NUMYhcja','faculty','Computer Studies',NULL,NULL,NULL,NULL,'Active','2026-07-24 07:24:30'),(20,'3032-4224-M','Rico','Mans','Dumaguin','rico@gmail.com','$2y$10$vDN2Oafqy91/tCcwgJj9D.4Y0oIzk/zUjHdAM3RygAYLLTvZw3rfu','faculty','BindTech',NULL,NULL,NULL,NULL,'Active','2026-07-30 09:45:08'),(21,'2023-4111-F','Jose','Protacio','Rizal','gabadaljohncarlo3@gmail.com','$2y$10$yjc1zQs/WVqL7MhrkFY8reXUbYxr9h5Xw3DHUuMOUgUWsCh6qK4gy','faculty','Not Teaching',NULL,'profile_21_1785412038.jpg',NULL,NULL,'Active','2026-07-30 10:39:42'),(22,'2023-4111-z','John','Carlo','Gabadal','gabadaljohncarlo6@gmail.com','$2y$10$JjrhEdj3B5iZuvoW0y6tOOD9k6iZwNp9ZCUpjmin4kHPaEKkoOxdG','faculty','Computer Studies',NULL,NULL,NULL,NULL,'Active','2026-07-30 11:46:47');
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

-- Dump completed on 2026-08-11 15:14:26
