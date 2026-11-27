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
) ENGINE=InnoDB AUTO_INCREMENT=335 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (1,10,'Updated document \"ok\" to Approved',NULL,NULL,'2026-07-13 09:46:19'),(2,10,'Updated document \"ok\" to Approved',NULL,NULL,'2026-07-13 09:48:51'),(3,10,'Updated document \"ok\" to Approved',NULL,NULL,'2026-07-13 09:48:53'),(4,10,'Updated document \"ok\" to Rejected',NULL,NULL,'2026-07-13 09:49:06'),(5,6,'Updated document \"ok\" to Rejected',NULL,NULL,'2026-07-13 09:50:37'),(6,6,'Updated document \"ok\" to Rejected',NULL,NULL,'2026-07-13 10:52:39'),(7,10,'Updated document \"title\" to Pending',NULL,NULL,'2026-07-13 22:32:03'),(8,10,'Updated document \"ok\" to Approved',NULL,NULL,'2026-07-13 22:32:23'),(9,10,'Updated document \"ok\" to Approved',NULL,NULL,'2026-07-13 22:32:25'),(10,11,'Updated document \"sakto ni sa maam?\" to Approved',NULL,NULL,'2026-07-19 09:23:03'),(11,11,'Updated document \"sakto ni sa maam?\" to Approved',NULL,NULL,'2026-07-19 10:18:11'),(12,11,'Updated document \"title\" to Rejected',NULL,NULL,'2026-07-19 10:19:20'),(13,11,'Updated document \"title\" to Approved',NULL,NULL,'2026-07-19 10:19:28'),(14,13,'Updated document \"te maam?\" to Approved',NULL,NULL,'2026-07-20 03:04:26'),(15,10,'Updated document \"sakto ni sa maam?\" to Approved',NULL,NULL,'2026-07-20 13:39:24'),(16,12,'Updated document \'ELigibilty Certificate\' to Returned',NULL,NULL,'2026-07-21 04:51:53'),(17,12,'Updated document \'dpcr ah\' to Pending',NULL,NULL,'2026-07-21 05:04:40'),(18,12,'Updated document \'dga\' to Approved',NULL,NULL,'2026-07-22 03:19:23'),(19,10,'Updated document \'PDS\' to Rejected',NULL,NULL,'2026-07-27 04:11:13'),(20,10,'Updated document \'dga\' to Approved',NULL,NULL,'2026-07-27 04:11:14'),(21,11,'Updated document \'ghg\' to Approved',NULL,NULL,'2026-07-27 06:41:23'),(22,10,'Posted a submission deadline for \"DPCR\" (August 7, 2026)','Deadlines',NULL,'2026-07-30 10:02:21'),(23,10,'Posted a submission deadline for \"DPCR\" (August 7, 2026)','Deadlines',NULL,'2026-07-30 10:09:39'),(24,10,'Posted a submission deadline for \"DTR Monthly\" (July 30, 2026)','Deadlines',NULL,'2026-07-30 10:42:19'),(25,10,'Posted a submission deadline for \"DTR Monthly\" (July 30, 2026)','Deadlines',NULL,'2026-07-30 11:16:40'),(26,10,'Posted a submission deadline for \"Eligibility Certificate\" (July 30, 2026)','Deadlines',NULL,'2026-07-30 11:18:09'),(27,10,'Posted a submission deadline for \"Diploma\" (August 6, 2026)','Deadlines',NULL,'2026-07-30 11:19:48'),(28,10,'Manually sent reminder for \"Diploma\" to 8 faculty','Deadlines',NULL,'2026-07-30 11:20:26'),(29,10,'Posted a submission deadline for \"Diploma\" (August 6, 2026)','Deadlines',NULL,'2026-07-30 11:20:50'),(30,14,'Created database backup: hrdb_2026-08-11_09-12-24.sql','Database Maintenance',NULL,'2026-08-11 07:12:25'),(31,14,'Created database backup: hrdb_2026-08-11_09-12-52.sql','Database Maintenance',NULL,'2026-08-11 07:12:52'),(32,14,'Created database backup: hrdb_2026-08-11_09-14-19.sql','Database Maintenance',NULL,'2026-08-11 07:14:19'),(33,14,'Created database backup: hrdb_2026-08-11_09-14-25.sql','Database Maintenance',NULL,'2026-08-11 07:14:26'),(34,11,'Updated document \'ghg\' to Approved',NULL,NULL,'2026-08-22 06:39:17'),(35,11,'Archived document (ID: 1)','Documents',NULL,'2026-08-22 06:44:24'),(36,11,'Archived document (ID: 11)','Documents',NULL,'2026-08-22 06:44:30'),(37,11,'Archived document (ID: 4)','Documents',NULL,'2026-08-22 06:44:45'),(38,11,'Archived document (ID: 2)','Documents',NULL,'2026-08-22 06:45:19'),(39,11,'Updated document \'upcr nalko\' to Approved',NULL,NULL,'2026-08-25 12:21:45'),(40,14,'Logged in','Authentication','::1','2026-08-28 07:15:45'),(41,10,'Logged in','Authentication','::1','2026-08-28 07:15:55'),(42,11,'Logged in','Authentication','::1','2026-08-28 07:19:40'),(43,14,'Logged in','Authentication','::1','2026-08-30 16:45:35'),(44,14,'Permanently deleted account: Jose Rizal (was Employee ID: 2023-4111-F)','User Management',NULL,'2026-08-30 16:46:26'),(45,14,'Permanently deleted account: Kieavane Gabadal (was Employee ID: 20213232)','User Management',NULL,'2026-08-30 16:46:36'),(46,14,'Updated user: Admin R','User Management',NULL,'2026-08-30 16:47:38'),(47,14,'Updated user: Admin R','User Management',NULL,'2026-08-30 16:47:42'),(48,14,'Set Admin R to Active','User Management',NULL,'2026-08-30 16:48:05'),(49,12,'Logged in','Authentication','::1','2026-08-30 16:51:20'),(50,11,'Logged in','Authentication','::1','2026-08-30 16:53:20'),(51,11,'Logged out','Authentication','::1','2026-08-30 16:55:41'),(52,11,'Logged in','Authentication','::1','2026-08-30 16:55:56'),(53,11,'Logged out','Authentication','::1','2026-08-30 16:57:08'),(54,12,'Logged in','Authentication','::1','2026-08-30 16:57:14'),(55,12,'Logged out','Authentication','::1','2026-08-30 16:57:58'),(56,14,'Logged in','Authentication','::1','2026-08-30 16:58:16'),(57,22,'Logged in','Authentication','::1','2026-08-30 16:58:59'),(58,10,'Logged in','Authentication','::1','2026-08-30 16:59:16'),(59,10,'Updated document \'certificate nako maam\' to Approved',NULL,NULL,'2026-08-30 17:00:39'),(60,10,'Updated document \'dpcr ah\' to Rejected',NULL,NULL,'2026-08-30 17:01:43'),(61,10,'Posted a submission deadline for \"DTR Monthly\" (August 31, 2026)','Deadlines',NULL,'2026-08-30 17:03:55'),(62,10,'Posted announcement: Announcement from hr','Announcements',NULL,'2026-08-30 17:04:43'),(63,10,'Logged out','Authentication','::1','2026-08-30 17:09:14'),(64,22,'Logged in','Authentication','::1','2026-08-30 17:09:18'),(65,10,'Logged in','Authentication','::1','2026-08-30 17:09:59'),(66,10,'Posted a submission deadline for \"DPCR\" (August 31, 2026)','Deadlines',NULL,'2026-08-30 17:11:13'),(67,10,'Posted a submission deadline for \"DPCR\" (August 31, 2026)','Deadlines',NULL,'2026-08-30 17:12:15'),(68,10,'Logged out','Authentication','::1','2026-08-30 17:12:48'),(69,22,'Logged in','Authentication','::1','2026-08-30 17:13:09'),(70,14,'Logged in','Authentication','::1','2026-08-31 10:29:13'),(71,14,'Authorized Employee ID for registration: 2023-1234-M','User Management',NULL,'2026-08-31 10:30:12'),(72,23,'New faculty account registered','Authentication','::1','2026-08-31 10:34:35'),(73,12,'Logged in','Authentication','::1','2026-08-31 10:37:05'),(74,10,'Logged in','Authentication','::1','2026-08-31 10:37:19'),(75,10,'Updated document \'fyufuf\' to Approved',NULL,NULL,'2026-08-31 10:38:02'),(76,10,'Permanently deleted account: Emmanuel Tanagras (was Employee ID: 123)','User Management',NULL,'2026-08-31 10:40:03'),(77,14,'Logged in','Authentication','::1','2026-09-01 06:24:34'),(78,11,'Logged in','Authentication','::1','2026-09-01 06:24:43'),(79,10,'Logged in','Authentication','::1','2026-09-01 06:24:51'),(80,11,'Logged in','Authentication','::1','2026-10-09 03:59:19'),(81,22,'Logged in','Authentication','::1','2026-10-09 13:41:19'),(82,22,'Logged out','Authentication','::1','2026-10-09 13:41:56'),(83,11,'Logged in','Authentication','::1','2026-10-25 06:10:58'),(84,14,'Logged in','Authentication','::1','2026-10-25 06:28:20'),(85,14,'Logged in','Authentication','::1','2026-10-25 07:01:02'),(86,22,'Logged in','Authentication','::1','2026-10-25 07:04:35'),(87,10,'Logged in','Authentication','::1','2026-10-25 07:05:04'),(88,10,'Updated document \'Job Application\' to Approved',NULL,NULL,'2026-10-25 07:17:44'),(89,10,'Updated document \'dtr ko ah\' to Rejected',NULL,NULL,'2026-10-25 07:18:23'),(90,10,'Logged out','Authentication','::1','2026-10-25 07:19:23'),(91,11,'Logged in','Authentication','::1','2026-10-25 07:20:12'),(92,11,'Updated document \'dtr\' to Approved',NULL,NULL,'2026-10-25 07:22:02'),(93,11,'Logged in','Authentication','::1','2026-11-03 06:43:14'),(94,14,'Logged in','Authentication','::1','2026-11-03 06:44:13'),(95,10,'Logged in','Authentication','::1','2026-11-03 06:44:31'),(96,10,'Updated document \'hjfjf\' to Approved',NULL,NULL,'2026-11-03 09:03:59'),(97,10,'Updated document \'hjfjf\' to Approved',NULL,NULL,'2026-11-03 09:04:07'),(98,10,'Updated document \'hjfjf\' to Approved',NULL,NULL,'2026-11-03 09:04:13'),(99,10,'Updated document \'hjfjf\' to Approved',NULL,NULL,'2026-11-03 09:04:21'),(100,10,'Updated document \'hjfjf\' to Approved',NULL,NULL,'2026-11-03 09:04:28'),(101,10,'Updated document \'hjfjf\' to Approved',NULL,NULL,'2026-11-03 09:04:34'),(102,10,'Updated document \'DTR\' to Approved',NULL,NULL,'2026-11-03 09:18:26'),(103,14,'Logged in','Authentication','::1','2026-11-04 01:59:37'),(104,10,'Logged in','Authentication','::1','2026-11-04 01:59:57'),(105,10,'Authorized Employee ID for registration: 2023-6360-M','User Management',NULL,'2026-11-04 02:01:50'),(106,24,'New faculty account registered','Authentication','::1','2026-11-04 02:02:44'),(107,24,'Logged in','Authentication','::1','2026-11-04 02:05:20'),(108,10,'Logged in','Authentication','::1','2026-11-04 02:10:00'),(109,10,'Updated document \'DTR\' to Rejected',NULL,NULL,'2026-11-04 02:41:51'),(110,10,'Updated document \'dtr ko ah\' to Approved',NULL,NULL,'2026-11-04 02:42:27'),(111,14,'Logged in','Authentication','::1','2026-11-07 05:44:21'),(112,10,'Logged in','Authentication','::1','2026-11-07 05:44:39'),(113,10,'Updated document \'dtr ko ah\' to Approved',NULL,NULL,'2026-11-07 06:35:57'),(114,10,'Updated document \'dtr ko ah\' to Pending',NULL,NULL,'2026-11-07 06:36:24'),(115,10,'Logged out','Authentication','::1','2026-11-07 06:38:00'),(116,14,'Logged in','Authentication','::1','2026-11-07 06:38:15'),(117,22,'Logged in','Authentication','::1','2026-11-07 06:41:32'),(118,22,'Updated document \'certificate nako maam\' to Approved',NULL,NULL,'2026-11-07 06:49:08'),(119,22,'Logged in','Authentication','::1','2026-11-08 06:08:04'),(120,14,'Logged in','Authentication','::1','2026-11-08 06:09:56'),(121,10,'Logged in','Authentication','::1','2026-11-08 06:10:10'),(122,10,'Sent file \'morgandtr.docx\' to John Gabadal for document \'certificate nako maam\'',NULL,NULL,'2026-11-08 06:35:59'),(123,10,'Logged out','Authentication','::1','2026-11-08 06:36:26'),(124,22,'Logged in','Authentication','::1','2026-11-08 06:37:07'),(125,22,'Updated document \'certificate nako maam\' to Rejected',NULL,NULL,'2026-11-08 07:21:07'),(126,22,'Updated document \'certificate nako maam\' to Rejected',NULL,NULL,'2026-11-08 07:21:17'),(127,22,'Updated document \'certificate nako maam\' to Approved',NULL,NULL,'2026-11-08 07:22:00'),(128,14,'Logged in','Authentication','::1','2026-11-08 07:22:50'),(129,14,'Posted announcement: Meeting For the Capstone','Announcements',NULL,'2026-11-08 07:35:38'),(130,14,'Logged out','Authentication','::1','2026-11-08 07:36:58'),(131,10,'Logged in','Authentication','::1','2026-11-08 07:37:06'),(132,10,'Posted a submission deadline for \"Faculty Profile\" (November 12, 2026)','Deadlines',NULL,'2026-11-08 07:45:42'),(133,10,'Logged out','Authentication','::1','2026-11-08 07:56:00'),(134,22,'Logged in','Authentication','::1','2026-11-08 07:56:38'),(135,10,'Logged in','Authentication','::1','2026-11-08 07:56:59'),(136,14,'Logged in','Authentication','::1','2026-11-09 01:31:09'),(137,10,'Logged in','Authentication','::1','2026-11-09 01:32:11'),(138,11,'Logged in','Authentication','::1','2026-11-09 01:39:29'),(139,10,'Logged in','Authentication','::1','2026-11-09 05:08:53'),(140,10,'Logged out','Authentication','::1','2026-11-09 05:27:58'),(141,14,'Logged in','Authentication','::1','2026-11-09 05:28:33'),(142,11,'Logged in','Authentication','::1','2026-11-09 05:30:19'),(143,11,'Posted announcement: bsan ano','Announcements',NULL,'2026-11-09 05:31:36'),(144,14,'Logged in','Authentication','::1','2026-11-09 05:37:09'),(145,14,'Logged in','Authentication','::1','2026-11-09 05:37:48'),(146,14,'Logged out','Authentication','::1','2026-11-09 05:38:36'),(147,10,'Logged in','Authentication','::1','2026-11-09 05:38:45'),(148,10,'Logged out','Authentication','::1','2026-11-09 05:49:55'),(149,14,'Logged in','Authentication','::1','2026-11-09 05:50:45'),(150,14,'Authorized Employee ID for registration: 2023-4111-L','User Management',NULL,'2026-11-09 05:51:10'),(151,25,'New faculty account registered','Authentication','::1','2026-11-09 05:53:10'),(152,25,'Logged in','Authentication','::1','2026-11-09 05:54:21'),(153,10,'Logged in','Authentication','::1','2026-11-09 05:55:48'),(154,10,'Posted a submission deadline for \"PDS\" (November 18, 2026)','Deadlines',NULL,'2026-11-09 05:57:08'),(155,14,'Logged in','Authentication','::1','2026-11-09 06:00:42'),(156,14,'Logged out','Authentication','::1','2026-11-09 06:13:34'),(157,10,'Logged in','Authentication','::1','2026-11-10 05:56:39'),(158,14,'Logged in','Authentication','::1','2026-11-10 05:56:52'),(159,11,'Logged in','Authentication','::1','2026-11-10 05:57:48'),(160,14,'Posted announcement: Deadline of Submission of PDS','Announcements',NULL,'2026-11-10 06:08:56'),(161,14,'Authorized Employee ID for registration: 2022-4111-M','User Management',NULL,'2026-11-10 06:26:41'),(162,11,'Logged out','Authentication','::1','2026-11-10 06:27:01'),(163,26,'New faculty account registered','Authentication','::1','2026-11-10 06:28:27'),(164,12,'Logged in','Authentication','::1','2026-11-10 08:38:58'),(165,10,'Updated document \'PDS\' to Approved',NULL,NULL,'2026-11-10 08:40:31'),(166,14,'Logged in','Authentication','::1','2026-11-11 02:40:48'),(167,10,'Logged in','Authentication','::1','2026-11-11 02:41:00'),(168,14,'Logged in','Authentication','::1','2026-11-11 02:43:29'),(169,12,'Logged in','Authentication','::1','2026-11-11 02:46:34'),(170,14,'Authorized Employee ID for registration: 2023-4222-M','User Management',NULL,'2026-11-11 02:49:51'),(171,14,'Logged out','Authentication','::1','2026-11-11 02:50:00'),(172,27,'New faculty account registered','Authentication','::1','2026-11-11 02:50:50'),(173,14,'Logged in','Authentication','::1','2026-11-11 02:54:46'),(174,10,'Logged in','Authentication','::1','2026-11-11 04:46:42'),(175,14,'Logged in','Authentication','::1','2026-11-11 04:47:28'),(176,11,'Logged in','Authentication','::1','2026-11-11 04:50:40'),(177,10,'Logged in','Authentication','::1','2026-11-11 04:53:01'),(178,10,'Logged out','Authentication','::1','2026-11-11 04:56:14'),(179,22,'Logged in','Authentication','::1','2026-11-11 13:20:28'),(180,14,'Logged in','Authentication','::1','2026-11-11 13:21:00'),(181,14,'Logged in','Authentication','::1','2026-11-12 02:01:14'),(182,10,'Logged in','Authentication','::1','2026-11-12 02:02:23'),(183,12,'Logged in','Authentication','::1','2026-11-12 02:14:38'),(184,10,'Posted a submission deadline for \"IPCR\" (November 20, 2026)','Deadlines',NULL,'2026-11-12 02:19:50'),(185,10,'Logged out','Authentication','::1','2026-11-12 02:23:05'),(186,12,'Logged in','Authentication','::1','2026-11-12 05:04:08'),(187,14,'Logged out','Authentication','::1','2026-11-12 05:04:44'),(188,10,'Logged in','Authentication','::1','2026-11-12 05:04:51'),(189,12,'Logged out','Authentication','::1','2026-11-12 05:05:12'),(190,14,'Logged in','Authentication','::1','2026-11-12 05:05:16'),(191,10,'Logged in','Authentication','::1','2026-11-12 05:24:55'),(192,14,'Logged in','Authentication','::1','2026-11-12 05:25:55'),(193,12,'Logged in','Authentication','::1','2026-11-12 05:26:28'),(194,12,'Logged out','Authentication','::1','2026-11-12 08:14:53'),(195,10,'Logged in','Authentication','::1','2026-11-13 02:00:33'),(196,14,'Logged in','Authentication','::1','2026-11-13 02:00:52'),(197,12,'Logged in','Authentication','::1','2026-11-13 02:25:17'),(198,12,'Logged out','Authentication','::1','2026-11-13 02:30:53'),(199,14,'Authorized Employee ID for registration: 2020-2020-M','User Management',NULL,'2026-11-13 02:31:40'),(200,28,'New faculty account registered','Authentication','::1','2026-11-13 02:34:09'),(201,28,'Logged in','Authentication','::1','2026-11-13 02:35:50'),(202,10,'Posted a submission deadline for \"IPCR\" (November 16, 2026)','Deadlines',NULL,'2026-11-13 02:41:02'),(203,10,'Posted a submission deadline for \"IPCR\" (November 16, 2026)','Deadlines',NULL,'2026-11-13 02:44:47'),(204,10,'Updated document \'iprr\' to Approved',NULL,NULL,'2026-11-13 02:47:13'),(205,10,'Updated document \'iprr\' to Rejected',NULL,NULL,'2026-11-13 02:47:49'),(206,14,'Logged in','Authentication','::1','2026-11-13 12:09:15'),(207,10,'Logged in','Authentication','::1','2026-11-13 12:09:35'),(208,14,'Authorized Employee ID for registration: 2024-2995-M','User Management',NULL,'2026-11-13 12:10:11'),(209,29,'New faculty account registered','Authentication','::1','2026-11-13 12:12:15'),(210,29,'Logged in','Authentication','::1','2026-11-13 12:15:02'),(211,12,'Logged in','Authentication','::1','2026-11-13 13:08:49'),(212,11,'Logged in','Authentication','::1','2026-11-13 13:09:29'),(213,12,'Logged in','Authentication','::1','2026-11-13 13:13:46'),(214,12,'Logged in','Authentication','::1','2026-11-13 13:15:00'),(215,12,'Changed own password','Authentication',NULL,'2026-11-13 13:26:09'),(216,12,'Logged out','Authentication','::1','2026-11-13 13:26:20'),(217,22,'Logged in','Authentication','::1','2026-11-13 13:28:05'),(218,22,'Logged out','Authentication','::1','2026-11-13 13:28:17'),(219,14,'Archived document (ID: 28)','Documents',NULL,'2026-11-13 16:41:37'),(220,29,'Logged in','Authentication','::1','2026-11-13 17:23:06'),(221,29,'Logged out','Authentication','::1','2026-11-13 17:44:12'),(222,29,'Logged in','Authentication','::1','2026-11-13 17:47:36'),(223,14,'Logged in','Authentication','::1','2026-11-15 01:53:39'),(224,10,'Logged in','Authentication','::1','2026-11-15 01:54:38'),(225,14,'Authorized Employee ID for registration: 1111-1111-M','User Management',NULL,'2026-11-15 01:57:12'),(226,30,'New faculty account registered','Authentication','::1','2026-11-15 01:58:15'),(227,30,'Logged in','Authentication','::1','2026-11-15 01:59:28'),(228,14,'Set Judifer John Legaspi to Inactive','User Management',NULL,'2026-11-15 02:30:31'),(229,14,'Set Judifer John Legaspi to Active','User Management',NULL,'2026-11-15 02:30:49'),(230,14,'Set Jose Pakyaw to Inactive','User Management',NULL,'2026-11-15 02:31:01'),(231,30,'Logged out','Authentication','::1','2026-11-15 02:31:10'),(232,30,'Logged in','Authentication','::1','2026-11-15 02:31:48'),(233,14,'Logged in','Authentication','::1','2026-11-15 03:16:01'),(234,14,'Set Jose Pakyaw to Active','User Management',NULL,'2026-11-15 03:16:36'),(235,30,'Logged in','Authentication','::1','2026-11-15 03:17:28'),(236,10,'Logged in','Authentication','::1','2026-11-15 03:18:32'),(237,14,'Posted announcement: Meeting','Announcements',NULL,'2026-11-15 03:21:16'),(238,14,'Uploaded template \"Temple for DPCR\"','Templates',NULL,'2026-11-15 03:24:07'),(239,30,'Logged out','Authentication','::1','2026-11-15 03:31:51'),(240,30,'Logged in','Authentication','::1','2026-11-15 03:41:55'),(241,10,'Updated document \'service record\' to Approved',NULL,NULL,'2026-11-15 03:43:09'),(242,10,'Updated document \'service record\' to Approved',NULL,NULL,'2026-11-15 03:43:13'),(243,10,'Updated document \'service record\' to Approved',NULL,NULL,'2026-11-15 03:44:25'),(244,10,'Updated document \'iprr\' to Approved',NULL,NULL,'2026-11-15 03:45:54'),(245,10,'Updated document \'DPRdfds\' to Approved',NULL,NULL,'2026-11-15 03:46:37'),(246,10,'Updated document \'DPRdfds\' to Approved',NULL,NULL,'2026-11-15 03:48:19'),(247,10,'Updated document \'DTR\' to Approved',NULL,NULL,'2026-11-15 03:48:32'),(248,14,'Logged in','Authentication','::1','2026-11-18 13:35:10'),(249,10,'Logged in','Authentication','::1','2026-11-18 13:35:40'),(250,30,'Logged in','Authentication','::1','2026-11-18 13:42:55'),(251,14,'Logged out','Authentication','::1','2026-11-18 14:32:59'),(252,14,'Logged in','Authentication','::1','2026-11-18 14:36:06'),(253,14,'Authorized Employee ID for registration: 12345678','User Management',NULL,'2026-11-18 14:38:09'),(254,14,'Logged out','Authentication','::1','2026-11-18 14:38:17'),(255,14,'Logged in','Authentication','::1','2026-11-18 14:43:19'),(256,14,'Updated user: John Abdul','User Management',NULL,'2026-11-18 14:43:46'),(257,14,'Logged out','Authentication','::1','2026-11-18 14:43:54'),(258,31,'New faculty account registered','Authentication','::1','2026-11-18 14:44:19'),(259,31,'Logged in','Authentication','::1','2026-11-18 14:45:07'),(260,30,'Logged out','Authentication','::1','2026-11-18 14:46:39'),(261,10,'Logged in','Authentication','::1','2026-11-18 14:46:45'),(262,10,'Logged out','Authentication','::1','2026-11-18 14:46:55'),(263,14,'Logged in','Authentication','::1','2026-11-18 14:47:01'),(264,10,'Updated document \'My Job application\' to Approved',NULL,NULL,'2026-11-18 14:47:29'),(265,10,'Updated document \'My Job application\' to Approved',NULL,NULL,'2026-11-18 14:47:46'),(266,10,'Updated document \'PDS ko\' to Approved',NULL,NULL,'2026-11-18 14:48:59'),(267,10,'Updated document \'sAMPL\' to Approved',NULL,NULL,'2026-11-18 14:49:04'),(268,10,'Updated document \'Diploma\' to Approved',NULL,NULL,'2026-11-18 14:49:09'),(269,10,'Updated document \'DTR\' to Approved',NULL,NULL,'2026-11-18 14:49:14'),(270,10,'Updated document \'dtr\' to Approved',NULL,NULL,'2026-11-18 14:49:20'),(271,10,'Updated document \'dtr ko ah\' to Approved',NULL,NULL,'2026-11-18 14:49:25'),(272,14,'Logged in','Authentication','::1','2026-11-20 13:10:20'),(273,10,'Logged in','Authentication','::1','2026-11-20 13:10:55'),(274,31,'Logged in','Authentication','::1','2026-11-20 13:19:08'),(275,31,'Logged out','Authentication','::1','2026-11-20 13:26:21'),(276,14,'Logged in','Authentication','::1','2026-11-20 13:35:20'),(277,14,'Permanently deleted account: John Abdul (was Employee ID: 2023-1234-M)','User Management',NULL,'2026-11-20 13:36:03'),(278,10,'Uploaded template \"temple for Profile\"','Templates',NULL,'2026-11-20 14:34:49'),(279,29,'Logged in','Authentication','::1','2026-11-20 14:37:57'),(280,14,'Posted announcement: GENERAL PTA MEETING','Announcements',NULL,'2026-11-20 14:41:21'),(281,29,'Logged out','Authentication','::1','2026-11-20 18:21:34'),(282,11,'Logged in','Authentication','::1','2026-11-20 18:23:54'),(283,10,'Logged out','Authentication','::1','2026-11-20 18:49:21'),(284,14,'Logged in','Authentication','::1','2026-11-21 01:53:52'),(285,14,'Created database backup: hrdb_2026-11-21_02-56-35.sql','Database Maintenance',NULL,'2026-11-21 01:56:36'),(286,10,'Logged in','Authentication','::1','2026-11-21 02:01:50'),(287,10,'Updated document \'My Job application\' to Pending',NULL,NULL,'2026-11-21 02:12:46'),(288,10,'Updated document \'My Job application\' to Approved',NULL,NULL,'2026-11-21 02:12:53'),(289,10,'Updated document \'dpcr ah\' to Approved',NULL,NULL,'2026-11-21 02:24:30'),(290,14,'Logged out','Authentication','::1','2026-11-21 02:57:09'),(291,11,'Logged in','Authentication','127.0.0.1','2026-11-21 03:12:43'),(292,14,'Logged in','Authentication','::1','2026-11-21 05:17:06'),(293,14,'Logged in','Authentication','::1','2026-11-21 10:17:54'),(294,10,'Logged in','Authentication','::1','2026-11-21 10:18:42'),(295,31,'Logged in','Authentication','::1','2026-11-21 10:21:49'),(296,31,'Logged in','Authentication','::1','2026-11-25 12:15:44'),(297,14,'Logged in','Authentication','::1','2026-11-25 12:16:38'),(298,10,'Logged in','Authentication','::1','2026-11-25 12:17:07'),(299,14,'Set Jose Pakyaw to Active','User Management',NULL,'2026-11-25 12:18:18'),(300,14,'Permanently deleted account: John Gabadal (was Employee ID: 2023-4111-M)','User Management',NULL,'2026-11-25 12:18:49'),(301,14,'Permanently deleted account: Rico Dumaguin (was Employee ID: 3032-4224-M)','User Management',NULL,'2026-11-25 12:19:10'),(302,14,'Permanently deleted account: JOhn Gabs (was Employee ID: 2022-4111-M)','User Management',NULL,'2026-11-25 12:19:22'),(303,14,'Permanently deleted account: miKEL pogi (was Employee ID: 2023-4222-M)','User Management',NULL,'2026-11-25 12:19:41'),(304,14,'Permanently deleted account: Jose Pakyaw (was Employee ID: 1111-1111-M)','User Management',NULL,'2026-11-25 12:20:19'),(305,14,'Authorized Employee ID for registration: 123123','User Management',NULL,'2026-11-25 12:20:46'),(306,14,'Logged out','Authentication','::1','2026-11-25 12:20:55'),(307,14,'Logged in','Authentication','::1','2026-11-25 12:25:23'),(308,14,'Updated user: Michael  Atilano','User Management',NULL,'2026-11-25 12:25:59'),(309,31,'Logged out','Authentication','::1','2026-11-25 12:26:15'),(310,11,'Logged in','Authentication','::1','2026-11-25 12:26:48'),(311,14,'Created database backup: hrdb_2026-11-25_13-29-04.sql','Database Maintenance',NULL,'2026-11-25 12:29:05'),(312,10,'Logged out','Authentication','::1','2026-11-25 12:35:49'),(313,31,'Logged in','Authentication','::1','2026-11-25 12:36:25'),(314,11,'Sent file \'Formal Studio Portrait.png\' to John Carlo Gabadal for document \'DPCR\'',NULL,NULL,'2026-11-25 12:39:40'),(315,14,'Logged in','Authentication','::1','2026-11-25 12:41:59'),(316,14,'Posted announcement: MEETING ','Announcements',NULL,'2026-11-25 12:47:31'),(317,11,'Posted a submission deadline for \"Diploma\" (November 26, 2026)','Deadlines',NULL,'2026-11-25 12:51:12'),(318,14,'Logged in','Authentication','::1','2026-11-26 03:14:42'),(319,10,'Logged in','Authentication','::1','2026-11-26 03:15:03'),(320,31,'Logged in','Authentication','::1','2026-11-26 03:17:28'),(321,10,'Updated document \'DPCR\' to Approved',NULL,NULL,'2026-11-26 03:23:13'),(322,31,'Logged in','Authentication','::1','2026-11-26 16:26:35'),(323,14,'Logged in','Authentication','::1','2026-11-26 16:26:53'),(324,10,'Logged in','Authentication','::1','2026-11-26 16:27:14'),(325,14,'Logged in','Authentication','::1','2026-11-26 16:28:17'),(326,14,'Logged in','Authentication','::1','2026-11-26 17:17:22'),(327,14,'Logged in','Authentication','::1','2026-11-26 17:32:36'),(328,14,'Logged in','Authentication','::1','2026-11-26 17:33:20'),(329,14,'Logged in','Authentication','::1','2026-11-26 18:03:41'),(330,14,'Logged in','Authentication','::1','2026-11-26 18:05:12'),(331,14,'Logged in','Authentication','::1','2026-11-26 18:08:43'),(332,14,'Set Allen Elmaguin to Inactive','User Management',NULL,'2026-11-26 18:12:23'),(333,14,'Set Allen Elmaguin to Active','User Management',NULL,'2026-11-26 18:12:45'),(334,14,'Logged in','Authentication','::1','2026-11-26 18:17:51');
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
INSERT INTO `announcements` VALUES (1,'meeting','may meeting alas 2 rum an ah','2026-07-20 07:51:02'),(2,'Announcement from hr','Palihog dw update kng inyu dtr, matsala','2026-08-30 17:04:20'),(3,'Meeting For the Capstone','rum an ah alas 2','2026-11-08 07:34:53'),(4,'bsan ano','bsan ano lng mn','2026-11-09 05:31:11'),(5,'Deadline of Submission of PDS','please be reminded of your submission of your PDS at HRMO','2026-11-10 06:08:27'),(6,'Meeting','may meting ta mag nonoy kag nene. Please attend gid kita\r\n','2026-11-15 03:20:42'),(7,'GENERAL PTA MEETING','palihog ko sa tanan nga parents nga mag attend sang atun nga meeting nga i padaunon sa octobre 22, 2026 alas dose sa kaagahon, madamo nga salmat. OK kayu\r\n','2026-11-20 14:40:47'),(8,'MEETING ','hello, goodmorning\r\n','2026-11-25 12:47:06');
/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `authorized_employee_ids`
--

DROP TABLE IF EXISTS `authorized_employee_ids`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `authorized_employee_ids` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` varchar(50) NOT NULL,
  `department` varchar(100) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_claimed` tinyint(1) NOT NULL DEFAULT 0,
  `claimed_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `employee_id_unique` (`employee_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `authorized_employee_ids`
--

LOCK TABLES `authorized_employee_ids` WRITE;
/*!40000 ALTER TABLE `authorized_employee_ids` DISABLE KEYS */;
INSERT INTO `authorized_employee_ids` VALUES (1,'2023-1234-M','',14,'2026-08-31 10:30:12',1,'2026-08-31 18:34:35'),(2,'2023-6360-M','Computer Studies',10,'2026-11-04 02:01:50',1,'2026-11-04 10:02:44'),(3,'2023-4111-L','',14,'2026-11-09 05:51:10',1,'2026-11-09 13:53:10'),(4,'2022-4111-M','Others',14,'2026-11-10 06:26:41',1,'2026-11-10 14:28:27'),(5,'2023-4222-M','Computer Studies',14,'2026-11-11 02:49:51',1,'2026-11-11 10:50:50'),(6,'2020-2020-M','Computer Studies',14,'2026-11-13 02:31:40',1,'2026-11-13 10:34:09'),(7,'2024-2995-M','BindTech',14,'2026-11-13 12:10:10',1,'2026-11-13 20:12:15'),(8,'1111-1111-M','',14,'2026-11-15 01:57:12',1,'2026-11-15 09:58:15'),(9,'12345678','',14,'2026-11-18 14:38:09',1,'2026-11-18 22:44:19'),(10,'123123','',14,'2026-11-25 12:20:46',0,NULL);
/*!40000 ALTER TABLE `authorized_employee_ids` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup_logs`
--

LOCK TABLES `backup_logs` WRITE;
/*!40000 ALTER TABLE `backup_logs` DISABLE KEYS */;
INSERT INTO `backup_logs` VALUES (1,'hrdb_2026-08-11_09-12-24.sql','backup',14,'2026-08-11 07:12:25'),(2,'hrdb_2026-08-11_09-12-52.sql','backup',14,'2026-08-11 07:12:52'),(3,'hrdb_2026-08-11_09-14-19.sql','backup',14,'2026-08-11 07:14:19'),(4,'hrdb_2026-08-11_09-14-25.sql','backup',14,'2026-08-11 07:14:26'),(5,'hrdb_2026-11-21_02-56-35.sql','backup',14,'2026-11-21 01:56:36'),(6,'hrdb_2026-11-25_13-29-04.sql','backup',14,'2026-11-25 12:29:05');
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
  `is_archived` tinyint(1) NOT NULL DEFAULT 0,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `hr_remarks` text DEFAULT NULL,
  PRIMARY KEY (`document_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents`
--

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
INSERT INTO `documents` VALUES (1,3,20,NULL,'title',NULL,'1781595459_Untitled design (1).pdf','../uploads/1781595459_Untitled design (1).pdf',1215752,NULL,'Approved',1,'2026-06-16 07:37:39','ok sya but you need to imporove more'),(2,6,9,NULL,'title',NULL,'1781597251_infographic.png','../uploads/1781597251_infographic.png',424977,NULL,'Approved',1,'2026-06-16 08:07:31','nami mn'),(3,6,18,NULL,'service record',NULL,'1783314455_anon.jpg','../uploads/1783314455_anon.jpg',2837694,NULL,'Approved',0,'2026-07-06 05:07:35','sge'),(4,6,7,NULL,'ok',NULL,'1783315657_Untitled design.png','../uploads/1783315657_Untitled design.png',3217286,NULL,'Approved',1,'2026-07-06 05:27:37','hayop ka'),(5,11,9,NULL,'sakto ni sa maam?',NULL,'1784452948_isatumc.jpg','../uploads/1784452948_isatumc.jpg',10212,NULL,'Approved',0,'2026-07-19 09:22:28','yes Maam ok gid sya'),(7,12,1,NULL,'PDS',NULL,'1784607841_2015-SALN-Form SeroWan 2024.doc','../uploads/1784607841_2015-SALN-Form SeroWan 2024.doc',105472,NULL,'Approved',0,'2026-07-21 04:24:01','wat es des?'),(8,12,20,NULL,'ELigibilty Certificate','paki check maam kun sakto','1784609405_Applications of Chemistry.docx','../uploads/1784609405_Applications of Chemistry.docx',34882,NULL,'Returned',0,'2026-07-21 04:50:05','yes maam pwede mo na submit'),(9,12,4,NULL,'dpcr ah','check b boss','1784610210_Male Teacher DEPED - Copy.png','../uploads/1784610210_Male Teacher DEPED - Copy.png',876011,NULL,'Approved',0,'2026-07-21 05:03:30',''),(10,12,9,NULL,'dga','fadsfdgd','1784690349_8c5081f1d800f54a3b2620c9e8b0529a.jpg','../uploads/1784690349_8c5081f1d800f54a3b2620c9e8b0529a.jpg',46571,NULL,'Approved',0,'2026-07-22 03:19:09','hgy'),(11,11,9,NULL,'ghg','','1785134454_duplex-house-construction-cost-india.jpg','../uploads/1785134454_duplex-house-construction-cost-india.jpg',59188,NULL,'Approved',1,'2026-07-27 06:40:54',''),(12,11,3,NULL,'upcr nalko','sending here my cpr madam','1787660468_668e858c-e980-42ac-8dea-9203948d0aa6 - Copy.jpg','../uploads/1787660468_668e858c-e980-42ac-8dea-9203948d0aa6 - Copy.jpg',30240,NULL,'Approved',0,'2026-08-25 12:21:08','okay.'),(13,10,17,NULL,'certificate nako maam','hello maam','1788109222_Lab_Activity_2_Gabadal Pogi sabe mama.pdf','../uploads/1788109222_Lab_Activity_2_Gabadal Pogi sabe mama.pdf',120191,NULL,'Approved',0,'2026-08-30 17:00:22','hahhah'),(14,10,9,8,'dtr ko ah','ari na mapasa na','1788109615_Lab_Activity_2_Gabadal Pogi sabe mama.pdf','../uploads/1788109615_Lab_Activity_2_Gabadal Pogi sabe mama.pdf',120191,NULL,'Rejected',0,'2026-08-30 17:06:55','ayaw nako'),(15,10,21,NULL,'fyufuf','jhf','1788172666_BondaroukBrewster_2016.pdf','../uploads/1788172666_BondaroukBrewster_2016.pdf',508810,NULL,'Approved',0,'2026-08-31 10:37:46',''),(16,10,12,NULL,'Job Application','pa check nako maam','1792912629_Leave-Application-Sample-LA-2026-0147.pdf','../uploads/1792912629_Leave-Application-Sample-LA-2026-0147.pdf',75143,NULL,'Approved',0,'2026-10-25 07:17:09','okay.'),(17,11,9,8,'dtr','is this right po ','1792912880_morgandtr.docx','../uploads/1792912880_morgandtr.docx',38350,NULL,'Approved',0,'2026-10-25 07:21:20','che'),(18,10,15,7,'hjfjf','','1793696615_dodong-letter-gabadal - 1.docx','../uploads/1793696615_dodong-letter-gabadal - 1.docx',216892,NULL,'Approved',0,'2026-11-03 09:03:35','hffhgh'),(19,10,10,NULL,'DTR','ffjadksfdasfd','1793697471_dodong-letter-gabadal - 1.pdf','../uploads/1793697471_dodong-letter-gabadal - 1.pdf',129954,NULL,'Approved',0,'2026-11-03 09:17:51','yfyy'),(20,10,9,8,'dtr ko ah','','1793760125_1793696615_dodong-letter-gabadal - 1.docx','../uploads/1793760125_1793696615_dodong-letter-gabadal - 1.docx',216892,NULL,'Approved',0,'2026-11-04 02:42:05',''),(21,22,20,5,'certificate nako maam','','1794034078_326766126_1628065290960776_8305564437051601235_n.jpg','../uploads/1794034078_326766126_1628065290960776_8305564437051601235_n.jpg',105046,NULL,'Approved',0,'2026-11-07 06:47:58','hahhah'),(22,10,9,8,'dtr','','1794201935_HR-DMS_Chapters1-3_Finalversion.docx','../uploads/1794201935_HR-DMS_Chapters1-3_Finalversion.docx',725851,NULL,'Approved',0,'2026-11-09 05:25:35',''),(23,10,9,8,'DTR','dtr jko','1794203294_1794201935_HR-DMS_Chapters1-3_Finalversion.docx','../uploads/1794203294_1794201935_HR-DMS_Chapters1-3_Finalversion.docx',725851,NULL,'Approved',0,'2026-11-09 05:48:14',''),(24,11,15,7,'Diploma','','1794291865_326766126_1628065290960776_8305564437051601235_n.jpg','../uploads/1794291865_326766126_1628065290960776_8305564437051601235_n.jpg',105046,NULL,'Approved',0,'2026-11-10 06:24:25',''),(25,12,4,10,'sAMPL','','1794365321_326766126_1628065290960776_8305564437051601235_n.jpg','../uploads/1794365321_326766126_1628065290960776_8305564437051601235_n.jpg',105046,NULL,'Approved',0,'2026-11-11 02:48:41',''),(26,11,4,10,'DPRdfds','','1794372749_326766126_1628065290960776_8305564437051601235_n (1).jpg','../uploads/1794372749_326766126_1628065290960776_8305564437051601235_n (1).jpg',105046,NULL,'Approved',0,'2026-11-11 04:52:29',''),(27,12,1,12,'PDS ko','','1794449737_326766126_1628065290960776_8305564437051601235_n (1).jpg','../uploads/1794449737_326766126_1628065290960776_8305564437051601235_n (1).jpg',105046,NULL,'Approved',0,'2026-11-12 02:15:37',''),(28,28,2,15,'iprr','','1794537844_dodong-letter-gabadal - 1.pdf','../uploads/1794537844_dodong-letter-gabadal - 1.pdf',129954,NULL,'Approved',1,'2026-11-13 02:44:04',''),(30,31,12,NULL,'My Job application','pa check q b ma\'am','1795013183_c30f96fe-1420-4369-8e1f-cc06b0bc269d (1).jpg','../uploads/1795013183_c30f96fe-1420-4369-8e1f-cc06b0bc269d (1).jpg',32790,NULL,'Approved',0,'2026-11-18 14:46:23',''),(31,31,4,10,'DPCR','','1795610286_42.8386.pdf','../uploads/1795610286_42.8386.pdf',527461,NULL,'Approved',0,'2026-11-25 12:38:06','');
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `file_templates`
--

DROP TABLE IF EXISTS `file_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `file_templates` (
  `template_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_size` int(11) DEFAULT 0,
  `uploaded_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `file_templates`
--

LOCK TABLES `file_templates` WRITE;
/*!40000 ALTER TABLE `file_templates` DISABLE KEYS */;
INSERT INTO `file_templates` VALUES (1,'Temple for DPCR','Questionnaire-END-USER-HR oh yeah.docx','1794713047_Questionnaire-END-USER-HR oh yeah.docx',26543,14,'2026-11-15 03:24:07'),(2,'temple for Profile','VIOLATAP-10-10-2026.pdf','1795185289_VIOLATAP-10-10-2026.pdf',1751581,10,'2026-11-20 14:34:49');
/*!40000 ALTER TABLE `file_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hr_returned_files`
--

DROP TABLE IF EXISTS `hr_returned_files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hr_returned_files` (
  `return_id` int(11) NOT NULL AUTO_INCREMENT,
  `document_id` int(11) NOT NULL,
  `hr_user_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `file_size` int(11) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`return_id`),
  KEY `idx_document` (`document_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hr_returned_files`
--

LOCK TABLES `hr_returned_files` WRITE;
/*!40000 ALTER TABLE `hr_returned_files` DISABLE KEYS */;
INSERT INTO `hr_returned_files` VALUES (1,21,10,'morgandtr.docx','../uploads/hr_returns/1794119759_588b1ada.docx',38350,'hoy ja ang skto ay','2026-11-08 06:35:59'),(2,31,11,'Formal Studio Portrait.png','../uploads/hr_returns/1795610380_0805d44d.png',1608281,'','2026-11-25 12:39:40');
/*!40000 ALTER TABLE `hr_returned_files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_verifications`
--

DROP TABLE IF EXISTS `login_verifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_verifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `code_hash` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `attempts` int(11) NOT NULL DEFAULT 0,
  `last_sent_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_login_verifications_user` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_verifications`
--

LOCK TABLES `login_verifications` WRITE;
/*!40000 ALTER TABLE `login_verifications` DISABLE KEYS */;
INSERT INTO `login_verifications` VALUES (56,19,'$2y$10$awrPTUASkSoOgKRGTgq6ee2wjqVs6zDKrr1ycNTwtGYS9Lu1dfSPe','2026-11-15 04:49:51',0,'2026-11-15 04:39:51','2026-11-15 03:39:51'),(58,22,'$2y$10$jqfl0je4MIdk0XyYIwiCwepA8lrPlo83Cp1islDfaU9Hhtcp0HhG6','2026-11-18 14:49:24',0,'2026-11-18 14:39:24','2026-11-18 13:39:24');
/*!40000 ALTER TABLE `login_verifications` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=436 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
INSERT INTO `notifications` VALUES (1,6,'Your document \"service record\" has been Pending by HR.','general',0,0,'2026-07-06 05:23:20'),(2,6,'Your document \"service record\" has been Approved by HR.','general',0,0,'2026-07-06 05:24:04'),(3,6,'Your document \"service record\" has been Approved by HR.','general',0,0,'2026-07-06 05:26:02'),(4,6,'Your document \"service record\" has been Approved by HR.','general',0,0,'2026-07-06 05:27:47'),(5,6,'Your document \"ok\" has been Approved by HR.','general',0,0,'2026-07-06 05:27:52'),(6,6,'Your document \"ok\" has been Approved by HR.','general',0,0,'2026-07-13 09:46:19'),(7,6,'Your document \"ok\" has been Approved by HR.','general',0,0,'2026-07-13 09:48:51'),(8,6,'Your document \"ok\" has been Approved by HR.','general',0,0,'2026-07-13 09:48:53'),(9,6,'Your document \"ok\" has been Rejected by HR.','general',0,0,'2026-07-13 09:49:06'),(10,6,'Your document \"ok\" has been Rejected by HR.','general',0,0,'2026-07-13 09:50:37'),(11,6,'Your document \"ok\" has been Rejected by HR.','general',0,0,'2026-07-13 10:52:39'),(12,3,'Your document \"title\" has been Pending by HR.','general',0,0,'2026-07-13 22:32:03'),(13,6,'Your document \"ok\" has been Approved by HR.','general',0,0,'2026-07-13 22:32:23'),(14,6,'Your document \"ok\" has been Approved by HR.','general',0,0,'2026-07-13 22:32:25'),(15,11,'Your document \"sakto ni sa maam?\" has been Approved by HR.','general',1,0,'2026-07-19 09:23:03'),(16,11,'Your document \"sakto ni sa maam?\" has been Approved by HR.','general',1,0,'2026-07-19 10:18:11'),(17,3,'Your document \"title\" has been Rejected by HR.','general',0,0,'2026-07-19 10:19:20'),(18,3,'Your document \"title\" has been Approved by HR.','general',0,0,'2026-07-19 10:19:28'),(20,11,'Your document \"sakto ni sa maam?\" has been Approved by HR.','general',1,0,'2026-07-20 13:39:24'),(21,12,'Your document \'ELigibilty Certificate\' has been Returned by HR.','general',1,0,'2026-07-21 04:51:53'),(22,12,'Your document \'dpcr ah\' has been Pending by HR.','general',1,0,'2026-07-21 05:04:40'),(23,12,'Your document \'dga\' has been Approved by HR.','general',1,0,'2026-07-22 03:19:23'),(24,12,'Your document \'PDS\' has been Rejected by HR.','general',1,0,'2026-07-27 04:11:13'),(25,12,'Your document \'dga\' has been Approved by HR.','general',1,0,'2026-07-27 04:11:14'),(26,11,'Your document \'ghg\' has been Approved by HR.','general',1,0,'2026-07-27 06:41:23'),(27,11,'New deadline: submit your \"DPCR\" by August 7, 2026, 4:00 PM.','deadline',1,0,'2026-07-30 10:02:21'),(28,12,'New deadline: submit your \"DPCR\" by August 7, 2026, 4:00 PM.','deadline',1,0,'2026-07-30 10:02:21'),(31,18,'New deadline: submit your \"DPCR\" by August 7, 2026, 4:00 PM.','deadline',0,0,'2026-07-30 10:02:21'),(32,19,'New deadline: submit your \"DPCR\" by August 7, 2026, 4:00 PM.','deadline',0,0,'2026-07-30 10:02:21'),(34,11,'New deadline: submit your \"DPCR\" by August 7, 2026, 4:00 PM.','deadline',1,0,'2026-07-30 10:09:39'),(35,12,'New deadline: submit your \"DPCR\" by August 7, 2026, 4:00 PM.','deadline',1,0,'2026-07-30 10:09:39'),(38,18,'New deadline: submit your \"DPCR\" by August 7, 2026, 4:00 PM.','deadline',0,0,'2026-07-30 10:09:39'),(39,19,'New deadline: submit your \"DPCR\" by August 7, 2026, 4:00 PM.','deadline',0,0,'2026-07-30 10:09:39'),(41,11,'New deadline: submit your \"DTR Monthly\" by July 30, 2026, 6:44 PM.','deadline',1,1,'2026-07-30 10:41:58'),(42,12,'New deadline: submit your \"DTR Monthly\" by July 30, 2026, 6:44 PM.','deadline',1,1,'2026-07-30 10:41:58'),(45,18,'New deadline: submit your \"DTR Monthly\" by July 30, 2026, 6:44 PM.','deadline',0,1,'2026-07-30 10:41:58'),(46,19,'New deadline: submit your \"DTR Monthly\" by July 30, 2026, 6:44 PM.','deadline',0,1,'2026-07-30 10:41:58'),(49,11,'New deadline: submit your \"DTR Monthly\" by July 30, 2026, 6:44 PM.','deadline',1,1,'2026-07-30 11:16:16'),(50,12,'New deadline: submit your \"DTR Monthly\" by July 30, 2026, 6:44 PM.','deadline',1,1,'2026-07-30 11:16:16'),(53,18,'New deadline: submit your \"DTR Monthly\" by July 30, 2026, 6:44 PM.','deadline',0,1,'2026-07-30 11:16:16'),(54,19,'New deadline: submit your \"DTR Monthly\" by July 30, 2026, 6:44 PM.','deadline',0,1,'2026-07-30 11:16:16'),(57,11,'New deadline: submit your \"Eligibility Certificate\" by July 30, 2026, 7:18 PM.','deadline',1,1,'2026-07-30 11:17:46'),(58,12,'New deadline: submit your \"Eligibility Certificate\" by July 30, 2026, 7:18 PM.','deadline',1,1,'2026-07-30 11:17:46'),(61,18,'New deadline: submit your \"Eligibility Certificate\" by July 30, 2026, 7:18 PM.','deadline',0,1,'2026-07-30 11:17:46'),(62,19,'New deadline: submit your \"Eligibility Certificate\" by July 30, 2026, 7:18 PM.','deadline',0,1,'2026-07-30 11:17:46'),(65,11,'New deadline: submit your \"Diploma\" by August 6, 2026, 7:21 PM.','deadline',1,1,'2026-07-30 11:19:25'),(66,12,'New deadline: submit your \"Diploma\" by August 6, 2026, 7:21 PM.','deadline',1,1,'2026-07-30 11:19:25'),(69,18,'New deadline: submit your \"Diploma\" by August 6, 2026, 7:21 PM.','deadline',0,1,'2026-07-30 11:19:25'),(70,19,'New deadline: submit your \"Diploma\" by August 6, 2026, 7:21 PM.','deadline',0,1,'2026-07-30 11:19:25'),(73,11,'Reminder: you still haven\'t submitted \"Diploma\". Deadline is August 6, 2026, 7:21 PM.','deadline_reminder',1,0,'2026-07-30 11:20:02'),(74,12,'Reminder: you still haven\'t submitted \"Diploma\". Deadline is August 6, 2026, 7:21 PM.','deadline_reminder',1,0,'2026-07-30 11:20:02'),(77,18,'Reminder: you still haven\'t submitted \"Diploma\". Deadline is August 6, 2026, 7:21 PM.','deadline_reminder',0,0,'2026-07-30 11:20:02'),(78,19,'Reminder: you still haven\'t submitted \"Diploma\". Deadline is August 6, 2026, 7:21 PM.','deadline_reminder',0,0,'2026-07-30 11:20:02'),(81,11,'New deadline: submit your \"Diploma\" by August 6, 2026, 7:21 PM.','deadline',1,1,'2026-07-30 11:20:28'),(82,12,'New deadline: submit your \"Diploma\" by August 6, 2026, 7:21 PM.','deadline',1,1,'2026-07-30 11:20:28'),(85,18,'New deadline: submit your \"Diploma\" by August 6, 2026, 7:21 PM.','deadline',0,1,'2026-07-30 11:20:28'),(86,19,'New deadline: submit your \"Diploma\" by August 6, 2026, 7:21 PM.','deadline',0,1,'2026-07-30 11:20:28'),(89,11,'Reminder: you still haven\'t submitted \"Diploma\". Deadline is August 6, 2026, 7:21 PM.','deadline_reminder',1,0,'2026-07-30 11:44:28'),(90,12,'Reminder: you still haven\'t submitted \"Diploma\". Deadline is August 6, 2026, 7:21 PM.','deadline_reminder',1,0,'2026-07-30 11:44:28'),(93,18,'Reminder: you still haven\'t submitted \"Diploma\". Deadline is August 6, 2026, 7:21 PM.','deadline_reminder',0,0,'2026-07-30 11:44:28'),(94,19,'Reminder: you still haven\'t submitted \"Diploma\". Deadline is August 6, 2026, 7:21 PM.','deadline_reminder',0,0,'2026-07-30 11:44:28'),(97,11,'Your document \'ghg\' has been Approved by HR.','status_update',1,0,'2026-08-22 06:39:17'),(98,11,'Your document \'upcr nalko\' has been Approved by HR.','status_update',1,0,'2026-08-25 12:21:45'),(99,10,'Your document \'certificate nako maam\' has been Approved by HR.','status_update',1,0,'2026-08-30 17:00:39'),(100,12,'Your document \'dpcr ah\' has been Rejected by HR.','status_update',1,0,'2026-08-30 17:01:43'),(101,11,'New deadline: submit your \"DTR Monthly\" by August 31, 2026, 7:02 AM. Note: Lihog kog amat2 na pasa sa inyung dtr mga maam, sir thanks','deadline',1,1,'2026-08-30 17:03:35'),(102,12,'New deadline: submit your \"DTR Monthly\" by August 31, 2026, 7:02 AM. Note: Lihog kog amat2 na pasa sa inyung dtr mga maam, sir thanks','deadline',1,1,'2026-08-30 17:03:35'),(105,18,'New deadline: submit your \"DTR Monthly\" by August 31, 2026, 7:02 AM. Note: Lihog kog amat2 na pasa sa inyung dtr mga maam, sir thanks','deadline',0,1,'2026-08-30 17:03:35'),(106,19,'New deadline: submit your \"DTR Monthly\" by August 31, 2026, 7:02 AM. Note: Lihog kog amat2 na pasa sa inyung dtr mga maam, sir thanks','deadline',0,1,'2026-08-30 17:03:35'),(108,22,'New deadline: submit your \"DTR Monthly\" by August 31, 2026, 7:02 AM. Note: Lihog kog amat2 na pasa sa inyung dtr mga maam, sir thanks','deadline',1,1,'2026-08-30 17:03:35'),(109,10,'New Announcement: Announcement from hr','announcement',1,0,'2026-08-30 17:04:20'),(110,11,'New Announcement: Announcement from hr','announcement',1,0,'2026-08-30 17:04:20'),(111,12,'New Announcement: Announcement from hr','announcement',1,0,'2026-08-30 17:04:20'),(114,18,'New Announcement: Announcement from hr','announcement',0,0,'2026-08-30 17:04:20'),(115,19,'New Announcement: Announcement from hr','announcement',0,0,'2026-08-30 17:04:20'),(117,22,'New Announcement: Announcement from hr','announcement',1,0,'2026-08-30 17:04:20'),(118,11,'New deadline: submit your \"DPCR\" by August 31, 2026, 1:10 AM. Note: Update lng ko mga ma\\\'am, sir noh sa dpcr ta ','deadline',1,1,'2026-08-30 17:10:51'),(119,12,'New deadline: submit your \"DPCR\" by August 31, 2026, 1:10 AM. Note: Update lng ko mga ma\\\'am, sir noh sa dpcr ta ','deadline',1,1,'2026-08-30 17:10:51'),(122,18,'New deadline: submit your \"DPCR\" by August 31, 2026, 1:10 AM. Note: Update lng ko mga ma\\\'am, sir noh sa dpcr ta ','deadline',0,1,'2026-08-30 17:10:51'),(123,19,'New deadline: submit your \"DPCR\" by August 31, 2026, 1:10 AM. Note: Update lng ko mga ma\\\'am, sir noh sa dpcr ta ','deadline',0,1,'2026-08-30 17:10:51'),(125,22,'New deadline: submit your \"DPCR\" by August 31, 2026, 1:10 AM. Note: Update lng ko mga ma\\\'am, sir noh sa dpcr ta ','deadline',1,1,'2026-08-30 17:10:51'),(126,11,'New deadline: submit your \"DPCR\" by August 31, 2026, 1:10 AM. Note: Update lng ko mga ma\\\'am, sir noh sa dpcr ta ','deadline',1,1,'2026-08-30 17:11:51'),(127,12,'New deadline: submit your \"DPCR\" by August 31, 2026, 1:10 AM. Note: Update lng ko mga ma\\\'am, sir noh sa dpcr ta ','deadline',1,1,'2026-08-30 17:11:51'),(130,18,'New deadline: submit your \"DPCR\" by August 31, 2026, 1:10 AM. Note: Update lng ko mga ma\\\'am, sir noh sa dpcr ta ','deadline',0,1,'2026-08-30 17:11:51'),(131,19,'New deadline: submit your \"DPCR\" by August 31, 2026, 1:10 AM. Note: Update lng ko mga ma\\\'am, sir noh sa dpcr ta ','deadline',0,1,'2026-08-30 17:11:51'),(133,22,'New deadline: submit your \"DPCR\" by August 31, 2026, 1:10 AM. Note: Update lng ko mga ma\\\'am, sir noh sa dpcr ta ','deadline',1,1,'2026-08-30 17:11:51'),(134,10,'Your document \'fyufuf\' has been Approved by HR.','status_update',1,0,'2026-08-31 10:38:02'),(135,10,'Your document \'Job Application\' has been Approved by HR.','status_update',1,0,'2026-10-25 07:17:44'),(136,10,'Your document \'dtr ko ah\' has been Rejected by HR.','status_update',1,0,'2026-10-25 07:18:23'),(137,11,'Your document \'dtr\' has been Approved by HR.','status_update',1,0,'2026-10-25 07:22:02'),(138,10,'Your document \'hjfjf\' has been Approved by HR.','status_update',1,0,'2026-11-03 09:03:59'),(139,10,'Your document \'hjfjf\' has been Approved by HR.','status_update',1,0,'2026-11-03 09:04:07'),(140,10,'Your document \'hjfjf\' has been Approved by HR.','status_update',1,0,'2026-11-03 09:04:13'),(141,10,'Your document \'hjfjf\' has been Approved by HR.','status_update',1,0,'2026-11-03 09:04:21'),(142,10,'Your document \'hjfjf\' has been Approved by HR.','status_update',1,0,'2026-11-03 09:04:28'),(143,10,'Your document \'hjfjf\' has been Approved by HR.','status_update',1,0,'2026-11-03 09:04:34'),(144,10,'Your document \'DTR\' has been Approved by HR.','status_update',1,0,'2026-11-03 09:18:26'),(145,10,'Your document \'DTR\' has been Rejected by HR.','status_update',1,0,'2026-11-04 02:41:51'),(146,10,'Your document \'dtr ko ah\' has been Approved by HR.','status_update',1,0,'2026-11-04 02:42:27'),(147,10,'Your document \'dtr ko ah\' has been Approved by HR.','status_update',1,0,'2026-11-07 06:35:57'),(148,10,'Your document \'dtr ko ah\' has been Pending by HR.','status_update',1,0,'2026-11-07 06:36:24'),(149,22,'Your document \'certificate nako maam\' has been Approved by HR.','status_update',1,0,'2026-11-07 06:49:08'),(150,22,'HR sent you an updated file for \'certificate nako maam\'. Check My Documents.','hr_file',1,0,'2026-11-08 06:35:59'),(151,22,'Your document \'certificate nako maam\' has been Rejected by HR.','status_update',1,0,'2026-11-08 07:21:07'),(152,22,'Your document \'certificate nako maam\' has been Rejected by HR.','status_update',1,0,'2026-11-08 07:21:17'),(153,22,'Your document \'certificate nako maam\' has been Approved by HR.','status_update',1,0,'2026-11-08 07:22:00'),(154,10,'New Announcement: Meeting For the Capstone','announcement',1,0,'2026-11-08 07:34:53'),(155,11,'New Announcement: Meeting For the Capstone','announcement',1,0,'2026-11-08 07:34:53'),(156,12,'New Announcement: Meeting For the Capstone','announcement',1,0,'2026-11-08 07:34:53'),(158,18,'New Announcement: Meeting For the Capstone','announcement',0,0,'2026-11-08 07:34:53'),(159,19,'New Announcement: Meeting For the Capstone','announcement',0,0,'2026-11-08 07:34:53'),(161,22,'New Announcement: Meeting For the Capstone','announcement',1,0,'2026-11-08 07:34:53'),(163,24,'New Announcement: Meeting For the Capstone','announcement',0,0,'2026-11-08 07:34:53'),(164,11,'New deadline: submit your \"Faculty Profile\" by November 12, 2026, 4:45 AM.','deadline',1,1,'2026-11-08 07:45:15'),(165,12,'New deadline: submit your \"Faculty Profile\" by November 12, 2026, 4:45 AM.','deadline',1,1,'2026-11-08 07:45:16'),(167,18,'New deadline: submit your \"Faculty Profile\" by November 12, 2026, 4:45 AM.','deadline',0,1,'2026-11-08 07:45:16'),(168,19,'New deadline: submit your \"Faculty Profile\" by November 12, 2026, 4:45 AM.','deadline',0,1,'2026-11-08 07:45:16'),(170,22,'New deadline: submit your \"Faculty Profile\" by November 12, 2026, 4:45 AM.','deadline',1,1,'2026-11-08 07:45:16'),(172,24,'New deadline: submit your \"Faculty Profile\" by November 12, 2026, 4:45 AM.','deadline',0,1,'2026-11-08 07:45:16'),(173,10,'New Announcement: bsan ano','announcement',1,0,'2026-11-09 05:31:11'),(174,11,'New Announcement: bsan ano','announcement',1,0,'2026-11-09 05:31:11'),(175,12,'New Announcement: bsan ano','announcement',1,0,'2026-11-09 05:31:11'),(177,18,'New Announcement: bsan ano','announcement',0,0,'2026-11-09 05:31:11'),(178,19,'New Announcement: bsan ano','announcement',0,0,'2026-11-09 05:31:11'),(180,22,'New Announcement: bsan ano','announcement',1,0,'2026-11-09 05:31:11'),(182,24,'New Announcement: bsan ano','announcement',0,0,'2026-11-09 05:31:11'),(183,11,'New deadline: submit your \"PDS\" by November 18, 2026, 2:56 PM.','deadline',1,1,'2026-11-09 05:56:46'),(184,12,'New deadline: submit your \"PDS\" by November 18, 2026, 2:56 PM.','deadline',1,1,'2026-11-09 05:56:46'),(186,18,'New deadline: submit your \"PDS\" by November 18, 2026, 2:56 PM.','deadline',0,1,'2026-11-09 05:56:46'),(187,19,'New deadline: submit your \"PDS\" by November 18, 2026, 2:56 PM.','deadline',0,1,'2026-11-09 05:56:46'),(189,22,'New deadline: submit your \"PDS\" by November 18, 2026, 2:56 PM.','deadline',1,1,'2026-11-09 05:56:46'),(191,24,'New deadline: submit your \"PDS\" by November 18, 2026, 2:56 PM.','deadline',0,1,'2026-11-09 05:56:46'),(192,25,'New deadline: submit your \"PDS\" by November 18, 2026, 2:56 PM.','deadline',1,1,'2026-11-09 05:56:46'),(193,10,'New Announcement: Deadline of Submission of PDS','announcement',1,0,'2026-11-10 06:08:27'),(194,11,'New Announcement: Deadline of Submission of PDS','announcement',1,0,'2026-11-10 06:08:27'),(195,12,'New Announcement: Deadline of Submission of PDS','announcement',1,0,'2026-11-10 06:08:27'),(197,18,'New Announcement: Deadline of Submission of PDS','announcement',0,0,'2026-11-10 06:08:27'),(198,19,'New Announcement: Deadline of Submission of PDS','announcement',0,0,'2026-11-10 06:08:27'),(200,22,'New Announcement: Deadline of Submission of PDS','announcement',1,0,'2026-11-10 06:08:27'),(202,24,'New Announcement: Deadline of Submission of PDS','announcement',0,0,'2026-11-10 06:08:27'),(203,25,'New Announcement: Deadline of Submission of PDS','announcement',0,0,'2026-11-10 06:08:27'),(204,12,'Your document \'PDS\' has been Approved by HR.','status_update',1,0,'2026-11-10 08:40:31'),(205,11,'New deadline: submit your \"IPCR\" by November 20, 2026, 12:18 PM.','deadline',1,1,'2026-11-12 02:18:59'),(206,12,'New deadline: submit your \"IPCR\" by November 20, 2026, 12:18 PM.','deadline',1,1,'2026-11-12 02:18:59'),(208,18,'New deadline: submit your \"IPCR\" by November 20, 2026, 12:18 PM.','deadline',0,1,'2026-11-12 02:18:59'),(209,19,'New deadline: submit your \"IPCR\" by November 20, 2026, 12:18 PM.','deadline',0,1,'2026-11-12 02:18:59'),(211,22,'New deadline: submit your \"IPCR\" by November 20, 2026, 12:18 PM.','deadline',1,1,'2026-11-12 02:18:59'),(213,24,'New deadline: submit your \"IPCR\" by November 20, 2026, 12:18 PM.','deadline',0,1,'2026-11-12 02:18:59'),(214,25,'New deadline: submit your \"IPCR\" by November 20, 2026, 12:18 PM.','deadline',0,1,'2026-11-12 02:18:59'),(217,11,'New deadline: submit your \"IPCR\" by November 16, 2026, 1:00 PM.','deadline',1,1,'2026-11-13 02:37:34'),(218,12,'New deadline: submit your \"IPCR\" by November 16, 2026, 1:00 PM.','deadline',1,1,'2026-11-13 02:37:34'),(220,18,'New deadline: submit your \"IPCR\" by November 16, 2026, 1:00 PM.','deadline',0,1,'2026-11-13 02:37:34'),(221,19,'New deadline: submit your \"IPCR\" by November 16, 2026, 1:00 PM.','deadline',0,1,'2026-11-13 02:37:34'),(223,22,'New deadline: submit your \"IPCR\" by November 16, 2026, 1:00 PM.','deadline',1,1,'2026-11-13 02:37:34'),(225,24,'New deadline: submit your \"IPCR\" by November 16, 2026, 1:00 PM.','deadline',0,1,'2026-11-13 02:37:34'),(226,25,'New deadline: submit your \"IPCR\" by November 16, 2026, 1:00 PM.','deadline',0,1,'2026-11-13 02:37:34'),(229,28,'New deadline: submit your \"IPCR\" by November 16, 2026, 1:00 PM.','deadline',1,1,'2026-11-13 02:37:34'),(230,11,'New deadline: submit your \"IPCR\" by November 16, 2026, 1:00 PM.','deadline',1,1,'2026-11-13 02:40:43'),(231,12,'New deadline: submit your \"IPCR\" by November 16, 2026, 1:00 PM.','deadline',1,1,'2026-11-13 02:40:43'),(233,18,'New deadline: submit your \"IPCR\" by November 16, 2026, 1:00 PM.','deadline',0,1,'2026-11-13 02:40:44'),(234,19,'New deadline: submit your \"IPCR\" by November 16, 2026, 1:00 PM.','deadline',0,1,'2026-11-13 02:40:44'),(236,22,'New deadline: submit your \"IPCR\" by November 16, 2026, 1:00 PM.','deadline',1,1,'2026-11-13 02:40:44'),(238,24,'New deadline: submit your \"IPCR\" by November 16, 2026, 1:00 PM.','deadline',0,1,'2026-11-13 02:40:44'),(239,25,'New deadline: submit your \"IPCR\" by November 16, 2026, 1:00 PM.','deadline',0,1,'2026-11-13 02:40:44'),(242,28,'New deadline: submit your \"IPCR\" by November 16, 2026, 1:00 PM.','deadline',1,1,'2026-11-13 02:40:44'),(243,11,'New deadline: submit your \"IPCR\" by November 16, 2026, 1:00 PM.','deadline',1,1,'2026-11-13 02:44:17'),(244,12,'New deadline: submit your \"IPCR\" by November 16, 2026, 1:00 PM.','deadline',1,1,'2026-11-13 02:44:17'),(246,18,'New deadline: submit your \"IPCR\" by November 16, 2026, 1:00 PM.','deadline',0,1,'2026-11-13 02:44:17'),(247,19,'New deadline: submit your \"IPCR\" by November 16, 2026, 1:00 PM.','deadline',0,1,'2026-11-13 02:44:17'),(249,22,'New deadline: submit your \"IPCR\" by November 16, 2026, 1:00 PM.','deadline',1,1,'2026-11-13 02:44:17'),(251,24,'New deadline: submit your \"IPCR\" by November 16, 2026, 1:00 PM.','deadline',0,1,'2026-11-13 02:44:17'),(252,25,'New deadline: submit your \"IPCR\" by November 16, 2026, 1:00 PM.','deadline',0,1,'2026-11-13 02:44:17'),(255,28,'New deadline: submit your \"IPCR\" by November 16, 2026, 1:00 PM.','deadline',1,1,'2026-11-13 02:44:17'),(256,28,'Your document \'iprr\' has been Approved by HR.','status_update',1,0,'2026-11-13 02:47:13'),(257,28,'Your document \'iprr\' has been Rejected by HR.','status_update',0,0,'2026-11-13 02:47:49'),(258,11,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',1,0,'2026-11-15 03:14:16'),(259,12,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-15 03:14:16'),(261,18,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-15 03:14:16'),(262,19,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-15 03:14:16'),(264,22,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-15 03:14:16'),(266,24,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-15 03:14:16'),(267,25,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-15 03:14:16'),(270,29,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',1,0,'2026-11-15 03:14:16'),(271,11,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',1,0,'2026-11-15 03:14:45'),(272,12,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-15 03:14:45'),(274,18,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-15 03:14:45'),(275,19,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-15 03:14:45'),(277,22,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-15 03:14:45'),(279,24,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-15 03:14:45'),(280,25,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-15 03:14:45'),(283,29,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',1,0,'2026-11-15 03:14:45'),(284,11,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',1,0,'2026-11-15 03:15:08'),(285,12,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-15 03:15:08'),(287,18,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-15 03:15:08'),(288,19,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-15 03:15:08'),(290,22,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-15 03:15:08'),(292,24,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-15 03:15:08'),(293,25,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-15 03:15:08'),(296,29,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',1,0,'2026-11-15 03:15:08'),(297,11,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',1,0,'2026-11-15 03:15:15'),(298,12,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-15 03:15:15'),(300,18,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-15 03:15:15'),(301,19,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-15 03:15:15'),(303,22,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-15 03:15:15'),(305,24,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-15 03:15:15'),(306,25,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-15 03:15:15'),(309,29,'Reminder: the deadline for \"IPCR\" is tomorrow (November 16, 2026, 1:00 PM) and you have not submitted yet.','deadline_reminder',1,0,'2026-11-15 03:15:15'),(310,10,'New Announcement: Meeting','announcement',1,0,'2026-11-15 03:20:42'),(311,11,'New Announcement: Meeting','announcement',1,0,'2026-11-15 03:20:42'),(312,12,'New Announcement: Meeting','announcement',0,0,'2026-11-15 03:20:42'),(314,18,'New Announcement: Meeting','announcement',0,0,'2026-11-15 03:20:42'),(315,19,'New Announcement: Meeting','announcement',0,0,'2026-11-15 03:20:42'),(317,22,'New Announcement: Meeting','announcement',0,0,'2026-11-15 03:20:42'),(319,24,'New Announcement: Meeting','announcement',0,0,'2026-11-15 03:20:42'),(320,25,'New Announcement: Meeting','announcement',0,0,'2026-11-15 03:20:42'),(323,28,'New Announcement: Meeting','announcement',0,0,'2026-11-15 03:20:42'),(324,29,'New Announcement: Meeting','announcement',1,0,'2026-11-15 03:20:42'),(326,11,'New template available: \"Temple for DPCR\". Open the Template page to download it.','template',1,0,'2026-11-15 03:24:07'),(327,12,'New template available: \"Temple for DPCR\". Open the Template page to download it.','template',0,0,'2026-11-15 03:24:07'),(329,18,'New template available: \"Temple for DPCR\". Open the Template page to download it.','template',0,0,'2026-11-15 03:24:07'),(330,19,'New template available: \"Temple for DPCR\". Open the Template page to download it.','template',0,0,'2026-11-15 03:24:07'),(332,22,'New template available: \"Temple for DPCR\". Open the Template page to download it.','template',0,0,'2026-11-15 03:24:07'),(334,24,'New template available: \"Temple for DPCR\". Open the Template page to download it.','template',0,0,'2026-11-15 03:24:07'),(335,25,'New template available: \"Temple for DPCR\". Open the Template page to download it.','template',0,0,'2026-11-15 03:24:07'),(338,28,'New template available: \"Temple for DPCR\". Open the Template page to download it.','template',0,0,'2026-11-15 03:24:07'),(339,29,'New template available: \"Temple for DPCR\". Open the Template page to download it.','template',1,0,'2026-11-15 03:24:07'),(344,28,'Your document \'iprr\' has been Approved by HR.','status_update',0,0,'2026-11-15 03:45:54'),(345,11,'Your document \'DPRdfds\' has been Approved by HR.','status_update',1,0,'2026-11-15 03:46:37'),(346,11,'Your document \'DPRdfds\' has been Approved by HR.','status_update',1,0,'2026-11-15 03:48:19'),(347,14,'HR marked Michael  Atilano\'s document \'DPRdfds\' as Approved','status_update',1,0,'2026-11-15 03:48:19'),(348,10,'Your document \'DTR\' has been Approved by HR.','status_update',1,0,'2026-11-15 03:48:32'),(349,14,'HR marked Magnus Carlsen\'s document \'DTR\' as Approved','status_update',1,0,'2026-11-15 03:48:32'),(350,14,'New faculty account registered: Patrick Jane (12345678)','new_user',1,0,'2026-11-18 14:44:19'),(351,31,'Your document \'My Job application\' has been Approved by HR.','status_update',1,0,'2026-11-18 14:47:29'),(352,14,'HR marked Patrick Jane\'s document \'My Job application\' as Approved','status_update',1,0,'2026-11-18 14:47:29'),(353,31,'Your document \'My Job application\' has been Approved by HR.','status_update',1,0,'2026-11-18 14:47:46'),(354,14,'HR marked Patrick Jane\'s document \'My Job application\' as Approved','status_update',1,0,'2026-11-18 14:47:46'),(355,12,'Your document \'PDS ko\' has been Approved by HR.','status_update',0,0,'2026-11-18 14:48:59'),(356,14,'HR marked Gian Alexic Ecle\'s document \'PDS ko\' as Approved','status_update',1,0,'2026-11-18 14:48:59'),(357,12,'Your document \'sAMPL\' has been Approved by HR.','status_update',0,0,'2026-11-18 14:49:04'),(358,14,'HR marked Gian Alexic Ecle\'s document \'sAMPL\' as Approved','status_update',1,0,'2026-11-18 14:49:04'),(359,11,'Your document \'Diploma\' has been Approved by HR.','status_update',1,0,'2026-11-18 14:49:09'),(360,14,'HR marked Michael  Atilano\'s document \'Diploma\' as Approved','status_update',1,0,'2026-11-18 14:49:09'),(361,10,'Your document \'DTR\' has been Approved by HR.','status_update',1,0,'2026-11-18 14:49:14'),(362,14,'HR marked Magnus Carlsen\'s document \'DTR\' as Approved','status_update',1,0,'2026-11-18 14:49:14'),(363,10,'Your document \'dtr\' has been Approved by HR.','status_update',1,0,'2026-11-18 14:49:20'),(364,14,'HR marked Magnus Carlsen\'s document \'dtr\' as Approved','status_update',1,0,'2026-11-18 14:49:20'),(365,10,'Your document \'dtr ko ah\' has been Approved by HR.','status_update',1,0,'2026-11-18 14:49:25'),(366,14,'HR marked Magnus Carlsen\'s document \'dtr ko ah\' as Approved','status_update',1,0,'2026-11-18 14:49:25'),(367,11,'New template available: \"temple for Profile\". Open the Template page to download it.','template',1,0,'2026-11-20 14:34:49'),(368,12,'New template available: \"temple for Profile\". Open the Template page to download it.','template',0,0,'2026-11-20 14:34:49'),(370,18,'New template available: \"temple for Profile\". Open the Template page to download it.','template',0,0,'2026-11-20 14:34:49'),(371,19,'New template available: \"temple for Profile\". Open the Template page to download it.','template',0,0,'2026-11-20 14:34:49'),(373,22,'New template available: \"temple for Profile\". Open the Template page to download it.','template',0,0,'2026-11-20 14:34:49'),(374,24,'New template available: \"temple for Profile\". Open the Template page to download it.','template',0,0,'2026-11-20 14:34:49'),(375,25,'New template available: \"temple for Profile\". Open the Template page to download it.','template',0,0,'2026-11-20 14:34:49'),(378,28,'New template available: \"temple for Profile\". Open the Template page to download it.','template',0,0,'2026-11-20 14:34:49'),(379,29,'New template available: \"temple for Profile\". Open the Template page to download it.','template',1,0,'2026-11-20 14:34:49'),(381,31,'New template available: \"temple for Profile\". Open the Template page to download it.','template',1,0,'2026-11-20 14:34:49'),(382,10,'New Announcement: GENERAL PTA MEETING','announcement',1,0,'2026-11-20 14:40:47'),(383,11,'New Announcement: GENERAL PTA MEETING','announcement',1,0,'2026-11-20 14:40:47'),(384,12,'New Announcement: GENERAL PTA MEETING','announcement',0,0,'2026-11-20 14:40:47'),(386,18,'New Announcement: GENERAL PTA MEETING','announcement',0,0,'2026-11-20 14:40:47'),(387,19,'New Announcement: GENERAL PTA MEETING','announcement',0,0,'2026-11-20 14:40:47'),(389,22,'New Announcement: GENERAL PTA MEETING','announcement',0,0,'2026-11-20 14:40:47'),(390,24,'New Announcement: GENERAL PTA MEETING','announcement',0,0,'2026-11-20 14:40:47'),(391,25,'New Announcement: GENERAL PTA MEETING','announcement',0,0,'2026-11-20 14:40:47'),(394,28,'New Announcement: GENERAL PTA MEETING','announcement',0,0,'2026-11-20 14:40:47'),(395,29,'New Announcement: GENERAL PTA MEETING','announcement',0,0,'2026-11-20 14:40:47'),(397,31,'New Announcement: GENERAL PTA MEETING','announcement',1,0,'2026-11-20 14:40:47'),(398,31,'Your document \'My Job application\' has been Pending by HR.','status_update',1,0,'2026-11-21 02:12:46'),(399,14,'HR marked Patrick Jane\'s document \'My Job application\' as Pending','status_update',1,0,'2026-11-21 02:12:46'),(400,31,'Your document \'My Job application\' has been Approved by HR.','status_update',1,0,'2026-11-21 02:12:53'),(401,14,'HR marked Patrick Jane\'s document \'My Job application\' as Approved','status_update',1,0,'2026-11-21 02:12:53'),(402,12,'Your document \'dpcr ah\' has been Approved by HR.','status_update',0,0,'2026-11-21 02:24:30'),(403,14,'HR marked Gian Alexic Ecle\'s document \'dpcr ah\' as Approved','status_update',1,0,'2026-11-21 02:24:30'),(404,31,'HR sent you an updated file for \'DPCR\'. Check My Documents.','hr_file',1,0,'2026-11-25 12:39:40'),(405,10,'New Announcement: MEETING ','announcement',0,0,'2026-11-25 12:47:06'),(406,11,'New Announcement: MEETING ','announcement',1,0,'2026-11-25 12:47:06'),(407,12,'New Announcement: MEETING ','announcement',0,0,'2026-11-25 12:47:06'),(408,18,'New Announcement: MEETING ','announcement',0,0,'2026-11-25 12:47:06'),(409,19,'New Announcement: MEETING ','announcement',0,0,'2026-11-25 12:47:06'),(410,22,'New Announcement: MEETING ','announcement',0,0,'2026-11-25 12:47:06'),(411,24,'New Announcement: MEETING ','announcement',0,0,'2026-11-25 12:47:06'),(412,25,'New Announcement: MEETING ','announcement',0,0,'2026-11-25 12:47:06'),(413,28,'New Announcement: MEETING ','announcement',0,0,'2026-11-25 12:47:06'),(414,29,'New Announcement: MEETING ','announcement',0,0,'2026-11-25 12:47:06'),(415,31,'New Announcement: MEETING ','announcement',1,0,'2026-11-25 12:47:06'),(416,12,'New deadline: submit your \"Diploma\" by November 26, 2026, 8:50 PM.','deadline',0,1,'2026-11-25 12:50:54'),(417,18,'New deadline: submit your \"Diploma\" by November 26, 2026, 8:50 PM.','deadline',0,1,'2026-11-25 12:50:54'),(418,19,'New deadline: submit your \"Diploma\" by November 26, 2026, 8:50 PM.','deadline',0,1,'2026-11-25 12:50:54'),(419,22,'New deadline: submit your \"Diploma\" by November 26, 2026, 8:50 PM.','deadline',0,1,'2026-11-25 12:50:54'),(420,24,'New deadline: submit your \"Diploma\" by November 26, 2026, 8:50 PM.','deadline',0,1,'2026-11-25 12:50:54'),(421,25,'New deadline: submit your \"Diploma\" by November 26, 2026, 8:50 PM.','deadline',0,1,'2026-11-25 12:50:54'),(422,28,'New deadline: submit your \"Diploma\" by November 26, 2026, 8:50 PM.','deadline',0,1,'2026-11-25 12:50:54'),(423,29,'New deadline: submit your \"Diploma\" by November 26, 2026, 8:50 PM.','deadline',0,1,'2026-11-25 12:50:54'),(424,31,'New deadline: submit your \"Diploma\" by November 26, 2026, 8:50 PM.','deadline',1,1,'2026-11-25 12:50:54'),(425,12,'Reminder: the deadline for \"Diploma\" is tomorrow (November 26, 2026, 8:50 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-25 14:01:31'),(426,18,'Reminder: the deadline for \"Diploma\" is tomorrow (November 26, 2026, 8:50 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-25 14:01:31'),(427,19,'Reminder: the deadline for \"Diploma\" is tomorrow (November 26, 2026, 8:50 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-25 14:01:31'),(428,22,'Reminder: the deadline for \"Diploma\" is tomorrow (November 26, 2026, 8:50 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-25 14:01:31'),(429,24,'Reminder: the deadline for \"Diploma\" is tomorrow (November 26, 2026, 8:50 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-25 14:01:31'),(430,25,'Reminder: the deadline for \"Diploma\" is tomorrow (November 26, 2026, 8:50 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-25 14:01:31'),(431,28,'Reminder: the deadline for \"Diploma\" is tomorrow (November 26, 2026, 8:50 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-25 14:01:31'),(432,29,'Reminder: the deadline for \"Diploma\" is tomorrow (November 26, 2026, 8:50 PM) and you have not submitted yet.','deadline_reminder',0,0,'2026-11-25 14:01:31'),(433,31,'Reminder: the deadline for \"Diploma\" is tomorrow (November 26, 2026, 8:50 PM) and you have not submitted yet.','deadline_reminder',1,0,'2026-11-25 14:01:31'),(434,31,'Your document \'DPCR\' has been Approved by HR.','status_update',1,0,'2026-11-26 03:23:13'),(435,14,'HR marked John Carlo Gabadal\'s document \'DPCR\' as Approved','status_update',1,0,'2026-11-26 03:23:13');
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submission_deadlines`
--

LOCK TABLES `submission_deadlines` WRITE;
/*!40000 ALTER TABLE `submission_deadlines` DISABLE KEYS */;
INSERT INTO `submission_deadlines` VALUES (1,4,'2026-08-07','16:00:00','',10,'2026-07-30 10:02:21','Active',0,NULL),(2,4,'2026-08-07','16:00:00','',10,'2026-07-30 10:09:39','Active',0,NULL),(3,9,'2026-07-30','18:44:00','',10,'2026-07-30 10:41:58','Active',0,NULL),(4,9,'2026-07-30','18:44:00','',10,'2026-07-30 11:16:16','Active',0,NULL),(5,20,'2026-07-30','19:18:00','',10,'2026-07-30 11:17:46','Active',0,NULL),(6,15,'2026-08-06','19:21:00','',10,'2026-07-30 11:19:25','Active',1,'2026-07-30 19:20:26'),(7,15,'2026-08-06','19:21:00','',10,'2026-07-30 11:20:28','Active',1,'2026-07-30 19:44:47'),(8,9,'2026-08-31','07:02:00','Lihog kog amat2 na pasa sa inyung dtr mga maam, sir thanks',10,'2026-08-30 17:03:35','Active',0,NULL),(9,4,'2026-08-31','01:10:00','Update lng ko mga ma\'am, sir noh sa dpcr ta ',10,'2026-08-30 17:10:51','Active',0,NULL),(10,4,'2026-08-31','01:10:00','Update lng ko mga ma\'am, sir noh sa dpcr ta ',10,'2026-08-30 17:11:51','Active',0,NULL),(11,11,'2026-11-12','04:45:00','',10,'2026-11-08 07:45:15','Active',0,NULL),(12,1,'2026-11-18','14:56:00','',10,'2026-11-09 05:56:46','Active',0,NULL),(13,2,'2026-11-20','12:18:00','',10,'2026-11-12 02:18:59','Active',0,NULL),(14,2,'2026-11-16','13:00:00','',10,'2026-11-13 02:37:34','Active',0,'2026-11-15 11:14:45'),(15,2,'2026-11-16','13:00:00','',10,'2026-11-13 02:40:43','Active',0,'2026-11-15 11:15:15'),(16,2,'2026-11-16','13:00:00','',10,'2026-11-13 02:44:17','Active',0,'2026-11-15 11:15:46'),(17,15,'2026-11-26','20:50:00','',11,'2026-11-25 12:50:54','Active',0,'2026-11-25 22:01:51');
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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (10,'1111','Magnus','hr','Carlsen','hr@gmail.com','$2y$10$orMyZwCfai4cAbUCuHh/iuKtdayfsM33W93zA5UGATO0s6TIrh1IW','hr','Others',NULL,NULL,NULL,NULL,'Active','2026-07-13 07:53:52'),(11,'2024-1234-F','Michael ','Aguilar','Atilano','maykmayk1738@gmail.com','$2y$10$ffbMOmSWgSy3hNgR06/Bw.KXqteNUHz/4v1zMrARPysGD3Mpnt88S','hr','hr staff','','profile_11_1785410828.jpg','8620492aef3f4a651fdde58d3bead555df8183010fd03e7730527e90084802fb','2026-11-14 10:40:30','active','2026-07-19 09:10:38'),(12,'2023-1423','Gian Alexic','Esleyer','Ecle','eclegianalexis@gmail.com','$2y$10$/IWg1UMaRbLGL4Q5mYJh6uX3/s3gOSZZq193CrmtVCfWyqfFB26NC','faculty','HBM','','profile_12_1794575721.jpg',NULL,NULL,'Active','2026-07-19 09:11:17'),(14,'2021323','Admin','Isat U','R','admin@gmail.com','$2y$10$zGiN9SAHCM1/BIR5dyz09e.jnjPSz4F2Xd1XU3kj.sf1raTOk8NUG','admin','Admin','Administrator','profile_14_1794575059.png',NULL,NULL,'Active','2026-07-20 03:11:01'),(18,'344738','Judifer John','Gito','Legaspi','judifer@gmail.com','$2y$10$C5pHKp7XizJTLt9VgIXWOuMjE7pDAB.tJNCAeb.usTfFjeyNyYTAe','faculty','Computer Studies',NULL,NULL,NULL,NULL,'Active','2026-07-21 15:02:00'),(19,'83737','Hance ','Manuel','Tipolo','hance@gmail.com','$2y$10$JsF8L4RiflDfNs2YVWHJFee9b1wHI.J8GIOps4SWlUq15NUMYhcja','faculty','Computer Studies',NULL,NULL,NULL,NULL,'Active','2026-07-24 07:24:30'),(22,'2023-4111-z','John','Carlo','Gabadal','gabadaljohncarlo3@gmail.com','$2y$10$JjrhEdj3B5iZuvoW0y6tOOD9k6iZwNp9ZCUpjmin4kHPaEKkoOxdG','faculty','Computer Studies',NULL,NULL,'c35e295300afa2891cb0622e5bead13ed3ddc67ca5b4cc1ad446d458a7785c4b','2026-11-14 10:52:20','Active','2026-07-30 11:46:47'),(24,'2023-6360-M','Allen','J.','Elmaguin','allenelmaguin@gmail.com','$2y$10$HdEKUjTU9RA3WhZBM7ho7eolFR3fIbb7qDBurqflnfeoo7W5/b5fG','faculty','Computer Studies',NULL,NULL,NULL,NULL,'Active','2026-11-04 02:02:44'),(25,'2023-4111-L','John','Carlo','Gabadals','nishidayuji2001@gmail.com','$2y$10$NYZ7w5mq9Azs45kQz3WIZuUm8i3VrxpjfHfg6JhTWqWkC4JnzZlyG','faculty','Computer Studies',NULL,'profile_25_1794203893.jpg',NULL,NULL,'Active','2026-11-09 05:53:10'),(28,'2020-2020-M','John','Carlo','Gabadalsssss','eclejanelafaye@gmail.com','$2y$10$7fGVMyZlOBFeSUtRLVMbyONAmk9c2/0Yn8AK42k4w8s2nKabtNDLa','faculty','Computer Studies',NULL,NULL,NULL,NULL,'Active','2026-11-13 02:34:09'),(29,'2024-2995-M','Kriscel Joy','Tirasol','Gabadal','krisceljoydumalfintirasol@gmail.com','$2y$10$n94YuXFfyelksOo/adXdNu3aNCcj2CHWQe67iliKUwjQJnWxeEP/e','faculty','BindTech',NULL,'profile_29_1794572310.jpg',NULL,NULL,'Active','2026-11-13 12:12:15'),(31,'12345678','John Carlo','Jan','Gabadal','gabadaljohncarlo1@gmail.com','$2y$10$/VTULbhbgUH6Lc.vzGjE0ezcnwgtI3cI6uq5uRHDynddIDSjsdpna','faculty','HBM',NULL,'profile_31_1795013133.png',NULL,NULL,'Active','2026-11-18 14:44:19');
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

-- Dump completed on 2026-11-27  2:24:28
