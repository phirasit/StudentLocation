-- MySQL dump 10.13  Distrib 5.7.18, for Linux (x86_64)
--
-- Host: localhost    Database: CUDStudentLocationDB
-- ------------------------------------------------------
-- Server version	5.7.18-0ubuntu0.16.04.1

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
-- Table structure for table `adapters`
--

DROP TABLE IF EXISTS `adapters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adapters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `adapter_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'not assigned',
  `login_user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pi',
  `ip_address` int(11) NOT NULL DEFAULT '0',
  `location_x` double NOT NULL DEFAULT '0',
  `location_y` double NOT NULL DEFAULT '0',
  `location_z` double NOT NULL DEFAULT '0',
  `inside_length` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `adapters_adapter_name_index` (`adapter_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adapters`
--

LOCK TABLES `adapters` WRITE;
/*!40000 ALTER TABLE `adapters` DISABLE KEYS */;
INSERT INTO `adapters` VALUES (1,'66:39:21:1A:E7:B9','Door3','pi',0,13,4.64,2,2,NULL,NULL),(2,'40:6A:2A:23:21:C4','Door5','pi',0,8.2,10.92,2.07,5,NULL,NULL),(3,'6A:E0:EA:A8:86:2B','Door5','pi',0,1,10.62,2.34,5,NULL,NULL),(4,'8E:DE:A6:EB:56:BB','Door5','pi',0,25,10.62,2.34,5,NULL,NULL),(5,'6C:5B:92:CB:C5:C1','Door3','pi',0,2,1,2.34,5,NULL,NULL),(6,'B8:27:EB:22:EF:69','Door5','pi',0,8.2,10.62,1,2,NULL,NULL),(7,'B8:27:EB:19:BC:DC','not assigned','pi',0,8.2,10.62,1,2,NULL,NULL);
/*!40000 ALTER TABLE `adapters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `devices`
--

DROP TABLE IF EXISTS `devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_mac_address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `location_x` double NOT NULL DEFAULT '0',
  `location_y` double NOT NULL DEFAULT '0',
  `location_z` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `devices_device_mac_address_unique` (`device_mac_address`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devices`
--

LOCK TABLES `devices` WRITE;
/*!40000 ALTER TABLE `devices` DISABLE KEYS */;
INSERT INTO `devices` VALUES (1,'13:67:14:FC:58:FC','',0,0,0,NULL,NULL),(2,'36:59:DC:FA:58:FC','',0,0,0,NULL,NULL),(3,'C9:35:0D:FA:58:FC','',0,0,0,NULL,NULL),(4,'FF:FF:B0:00:0C:32','',0,0,0,NULL,NULL),(5,'FF:FF:00:00:04:78','',0,0,0,NULL,NULL),(6,'FF:FF:00:00:1D:78','',0,0,0,NULL,NULL),(7,'FF:FF:10:00:0D:0D','',0,0,0,NULL,NULL),(8,'FF:FF:40:00:15:0D','',0,0,0,NULL,NULL),(9,'FF:FF:70:00:07:11','',0,0,0,NULL,NULL),(10,'FF:FF:90:00:0C:84','',0,0,0,NULL,NULL),(11,'FF:FF:E0:01:45:FF','',0,0,0,NULL,NULL),(12,'FF:FF:E0:01:53:40','',0,0,0,NULL,NULL),(13,'FF:FF:E0:01:5C:D3','',0,0,0,NULL,NULL),(14,'FF:FF:E0:01:37:36','',0,0,0,NULL,NULL),(15,'FF:FF:F0:00:37:25','',0,0,0,NULL,NULL);
/*!40000 ALTER TABLE `devices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `device_id` int(11) NOT NULL,
  `adapter_id` int(11) NOT NULL,
  `length` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `locations_device_id_index` (`device_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=243 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (235,'2014_10_12_000000_create_users_table',1),(236,'2014_10_12_100000_create_password_resets_table',1),(237,'2017_01_27_024717_create_students_table',1),(238,'2017_01_27_083949_create_user_student_table',1),(239,'2017_02_01_132514_create_adapters_table',1),(240,'2017_02_02_110211_create_waitings_table',1),(241,'2017_03_03_065521_create_devices_table',1),(242,'2017_03_03_082642_create_locations_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `std_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `std_room` int(11) NOT NULL DEFAULT '0',
  `std_no` int(11) NOT NULL DEFAULT '0',
  `device_mac_address` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `students_name_unique` (`name`),
  UNIQUE KEY `students_std_id_unique` (`std_id`),
  UNIQUE KEY `students_device_mac_address_unique` (`device_mac_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_student_relationships`
--

DROP TABLE IF EXISTS `user_student_relationships`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_student_relationships` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_student_relationships_user_id_index` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_student_relationships`
--

LOCK TABLES `user_student_relationships` WRITE;
/*!40000 ALTER TABLE `user_student_relationships` DISABLE KEYS */;
INSERT INTO `user_student_relationships` VALUES (1,1,11);
/*!40000 ALTER TABLE `user_student_relationships` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '2',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin@CUD.com',0,'$2y$10$QfhM4etOIt8geVI9myiQVOJ/9pewC/LxUrHmKWUjC8UF43T6pFd0W',NULL,NULL,NULL),(2,'Jerasak','j_jerasak@hotmail.com',2,'$2y$10$6MAiVRRhuy3eOfovIUphD.ep3tUd3OUNw577GdUN3Mzqt0nnjTi4O',NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `waitinglists`
--

DROP TABLE IF EXISTS `waitinglists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `waitinglists` (
  `id` int(11) NOT NULL,
  `area` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `waitinglists_id_index` (`id`),
  KEY `waitinglists_area_index` (`area`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `waitinglists`
--

LOCK TABLES `waitinglists` WRITE;
/*!40000 ALTER TABLE `waitinglists` DISABLE KEYS */;
INSERT INTO `waitinglists` VALUES (0,'Door3',NULL,NULL),(0,'Door5',NULL,NULL);
/*!40000 ALTER TABLE `waitinglists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `waitings`
--

DROP TABLE IF EXISTS `waitings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `waitings` (
  `id` int(11) NOT NULL,
  `area` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `waitings_id_index` (`id`),
  KEY `waitings_area_index` (`area`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `waitings`
--

LOCK TABLES `waitings` WRITE;
/*!40000 ALTER TABLE `waitings` DISABLE KEYS */;
INSERT INTO `waitings` VALUES (1,'Door1',NULL,NULL),(2,'Door2',NULL,NULL);
/*!40000 ALTER TABLE `waitings` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-07-14 19:22:50
