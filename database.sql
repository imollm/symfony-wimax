CREATE DATABASE  IF NOT EXISTS `wimax` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `wimax`;
-- MySQL dump 10.13  Distrib 8.0.17, for macos10.14 (x86_64)
--
-- Host: 127.0.0.1    Database: wimax
-- ------------------------------------------------------
-- Server version	5.7.19

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `antennas`
--

DROP TABLE IF EXISTS `antennas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `antennas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `wlan_mac` varchar(17) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lan_mac` varchar(17) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_17B46F64FECC1BF` (`lan_mac`),
  UNIQUE KEY `wlan_mac_UNIQUE` (`wlan_mac`),
  UNIQUE KEY `UNIQ_17B46F653EA3F4B` (`ip`),
  KEY `IDX_17B46F6A76ED395` (`user_id`),
  CONSTRAINT `FK_17B46F6A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `antennas`
--

LOCK TABLES `antennas` WRITE;
/*!40000 ALTER TABLE `antennas` DISABLE KEYS */;
INSERT INTO `antennas` VALUES (1,1,'80:2A:A8:EE:A5:F1','80:2A:A8:EF:A5:F1','192.168.1.4','40.0046154','3.835849','Rocket_M5','Rocket M5 Ronda Nord','2020-09-07 00:00:38','2020-09-07 00:00:38'),(2,1,'68:72:51:72:9F:B3','68:72:51:73:9F:B3','192.168.1.2','40.006475','3.835417','NanoStation_M2','NSM2 Tres Alquerias','2020-09-07 00:09:00','2020-09-07 00:09:00'),(3,1,'18:E8:29:78:8C:F5','18:E8:29:79:8C:F5','192.168.1.8','40.006475','3.835417','LiteAp_AC_120','LiteAp AC Port','2020-09-07 00:19:10','2020-09-07 00:19:10'),(4,1,'E0:63:DA:60:42:93','E0:63:DA:61:42:93','192.168.1.11','40.006475','3.835417','LiteAp_AC_120','LiteAp AC Calan Blanes','2020-09-07 00:24:08','2020-09-07 00:24:08'),(5,2,'68:72:51:5E:9F:61','68:72:51:5F:9F:61','192.168.1.6','40.006475','3.835417','NanoStation_Loco_M2','ST TresAlq36 ','2020-09-07 00:29:07','2020-09-07 00:29:07'),(6,2,'00:27:22:EE:75:2E','00:27:22:EF:75:2E','192.168.1.14','40.005588','3.836043','NanoStation','ST Santa Barbara','2020-09-07 00:35:08','2020-09-07 00:35:08'),(7,3,'80:2A:A8:00:3E:4B','80:2A:A8:01:3E:4B','192.168.1.7','40.019402','3.850958','PowerBeam_M5','ST Retxilleres Caseta','2020-09-07 00:38:28','2020-09-07 00:38:28'),(8,NULL,'80:2A:A8:00:07:4B','80:2A:A8:01:07:4B','192.168.1.5','40.023734','3.874383','PowerBeam_M5','ST Son Morell Pina','2020-09-07 00:41:43','2020-09-07 00:41:43'),(9,NULL,'B4:FB:E4:AE:31:6F','B4:FB:E4:AF:31:6F','192.168.1.3','40.023734','3.874383','LiteBeam_M5','ST Son Morell Toni','2020-09-07 00:43:50','2020-09-07 00:43:50'),(10,NULL,'74:83:C2:A0:73:D3','74:83:C2:A1:73:D3','192.168.1.9','40.002105','3.836390','LiteBeam_M5','ST Oriol','2020-09-07 00:46:30','2020-09-07 00:46:30'),(11,NULL,'74:83:C2:A0:8C:19','74:83:C2:A1:8C:19','192.168.1.12','40.005154','3.811717','LiteBeam_M5','ST Es Figueral','2020-09-07 00:49:46','2020-09-07 00:49:46');
/*!40000 ALTER TABLE `antennas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aps`
--

DROP TABLE IF EXISTS `aps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `antenna_id` int(11) NOT NULL,
  `ssid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `frequency` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bandwith` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_6D3A392535C246D5` (`password`),
  UNIQUE KEY `UNIQ_6D3A3925B6FC8A64` (`antenna_id`),
  CONSTRAINT `FK_6D3A3925B6FC8A64` FOREIGN KEY (`antenna_id`) REFERENCES `antennas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aps`
--

LOCK TABLES `aps` WRITE;
/*!40000 ALTER TABLE `aps` DISABLE KEYS */;
INSERT INTO `aps` VALUES (1,2,'AP_IMM_01','\'2<Y\\R?!6s4M','5825','20'),(2,1,'AP_IMM_02','K^[85yzb8)}c','2452','20'),(3,3,'AP_IMM_03','}6855\\4d8.5J','5630','20'),(4,4,'AP_IMM_04','[5?ob9@>V<K}','5740','20');
/*!40000 ALTER TABLE `aps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `antenna_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `amount` double NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_6D28840DB6FC8A64` (`antenna_id`),
  KEY `IDX_6D28840DA76ED395` (`user_id`),
  CONSTRAINT `FK_6D28840DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `FK_6D28840DB6FC8A64` FOREIGN KEY (`antenna_id`) REFERENCES `antennas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (6,1,3,2,2021,25,'2020-09-16 19:47:42','2020-09-16 19:47:42'),(31,1,1,9,2020,25,'2020-09-19 00:33:06','2020-09-19 00:33:06'),(32,1,1,10,2020,25,'2020-09-19 00:33:06','2020-09-19 00:33:06'),(33,1,1,11,2020,25,'2020-09-19 00:33:06','2020-09-19 00:33:06'),(34,1,1,12,2020,25,'2020-09-19 00:33:06','2020-09-19 00:33:06'),(35,1,1,1,2021,25,'2020-09-19 00:33:06','2020-09-19 00:33:06'),(36,1,1,2,2021,25,'2020-09-19 00:33:06','2020-09-19 00:33:06'),(37,1,1,1,2020,11,'2020-10-25 22:42:43','2020-10-25 22:42:43'),(38,7,3,1,2020,11,'2020-10-25 22:55:09','2020-10-25 22:55:09'),(39,1,1,2,2020,2,'2020-10-25 22:55:47','2020-10-25 22:55:47');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `routers`
--

DROP TABLE IF EXISTS `routers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `routers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `station_id` int(11) DEFAULT NULL,
  `ssid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_45D2F225D374C9DC` (`serial`),
  UNIQUE KEY `UNIQ_45D2F22521BDB235` (`station_id`),
  CONSTRAINT `FK_45D2F22521BDB235` FOREIGN KEY (`station_id`) REFERENCES `stations` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `routers`
--

LOCK TABLES `routers` WRITE;
/*!40000 ALTER TABLE `routers` DISABLE KEYS */;
/*!40000 ALTER TABLE `routers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stations`
--

DROP TABLE IF EXISTS `stations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `stations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `antenna_id` int(11) NOT NULL,
  `ap_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_9F39F8B1B6FC8A64` (`antenna_id`),
  KEY `IDX_9F39F8B1904F155E` (`ap_id`),
  CONSTRAINT `FK_9F39F8B1904F155E` FOREIGN KEY (`ap_id`) REFERENCES `aps` (`id`),
  CONSTRAINT `FK_9F39F8B1B6FC8A64` FOREIGN KEY (`antenna_id`) REFERENCES `antennas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stations`
--

LOCK TABLES `stations` WRITE;
/*!40000 ALTER TABLE `stations` DISABLE KEYS */;
INSERT INTO `stations` VALUES (1,5,1),(2,6,2),(3,7,2),(4,8,2),(5,9,2),(6,10,3),(7,11,4);
/*!40000 ALTER TABLE `stations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649444F97DD` (`phone`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Ivan','Moll','ROLE_USER','+34646685237','Calle Santa Barbara','ivan@ivan.com','$2y$04$EwsRuPol.fOH8Fxi5mF0f.GZ21dc6eCOhJSy8jMHm1XZr1KQNngm6','2020-09-15 20:32:20','2020-09-15 20:32:20',NULL),(2,'Marc','Moll','ROLE_ADMIN','685510212','C/ Tres Alquerias, 36 - 2º','marc@marc.com','$2y$04$EwsRuPol.fOH8Fxi5mF0f.GZ21dc6eCOhJSy8jMHm1XZr1KQNngm6','2020-09-13 01:14:32','2020-09-13 01:14:32',NULL),(3,'Caro','Moll','ROLE_USER','+34555555555','asdfasdfasdf','caro@caro.es','$2y$04$fVO3JHc0fY7yUzdJW07xfu1S7KQqwGD/NVEvvOJz1LysbiBLz7Zh2','2020-09-13 01:55:49','2020-09-13 01:55:49',NULL);
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

-- Dump completed on 2020-10-26 20:29:37
