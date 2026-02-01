-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: restaurant_system
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'samsi','$2y$10$dHGeHlt2nOiR.K6cWtQGdeHU5qIRdyUjwo9F6rf/x.gplmKWfW.uK');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Pizza','2026-01-24 07:59:12'),(2,'Burger','2026-01-24 07:59:12'),(3,'Drinks','2026-01-24 07:59:12'),(4,'Desserts','2026-01-24 07:59:12'),(5,'Nepali','2026-01-24 07:59:12'),(6,'Indian','2026-01-24 07:59:12');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_items`
--

DROP TABLE IF EXISTS `menu_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `description` text,
  `cuisine` varchar(100) DEFAULT NULL,
  `category_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_category` (`category_id`),
  CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_items`
--

LOCK TABLES `menu_items` WRITE;
/*!40000 ALTER TABLE `menu_items` DISABLE KEYS */;
INSERT INTO `menu_items` VALUES (8,'sukuti',240.00,'2026-01-24 08:05:48',NULL,NULL,5),(9,'chowmien',240.00,'2026-01-24 08:08:10',NULL,NULL,5),(10,'Nepali Khaja set',300.00,'2026-01-24 11:08:46',NULL,NULL,5),(16,'C.momo',160.00,'2026-01-30 07:59:25',NULL,NULL,5),(17,'Soft drinks(coke,pepsi,Dew)',70.00,'2026-01-30 08:01:08',NULL,NULL,3),(18,'Thukpa',200.00,'2026-01-30 08:01:33',NULL,NULL,5),(19,'Butter chicken Naan',300.00,'2026-01-30 08:01:51',NULL,NULL,6);
/*!40000 ALTER TABLE `menu_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `item_id` int NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `qty` int NOT NULL,
  `line_total` decimal(8,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,8,'sukuti',240.00,6,1440.00),(2,2,8,'sukuti',240.00,1,240.00),(3,3,8,'sukuti',240.00,1,240.00),(4,4,9,'chowmien',240.00,1,240.00),(5,5,9,'chowmien',240.00,1,240.00),(6,6,9,'chowmien',240.00,1,240.00),(7,7,10,'Nepali Khaja set',300.00,1,300.00),(8,8,14,'Margherita',600.00,1,600.00),(9,8,10,'Nepali Khaja set',300.00,1,300.00),(10,9,10,'Nepali Khaja set',300.00,1,300.00),(11,10,12,'Soft Drinks(coke,sprite,Dew)',70.00,1,70.00),(12,10,11,'Keema Noodles',210.00,1,210.00),(13,10,13,'Peach iced Tea',180.00,1,180.00),(14,11,12,'Soft Drinks(coke,sprite,Dew)',70.00,1,70.00),(15,11,11,'Keema Noodles',210.00,1,210.00),(16,12,9,'chowmien',240.00,1,240.00),(17,13,8,'sukuti',240.00,2,480.00),(18,14,9,'chowmien',240.00,1,240.00),(19,15,10,'Nepali Khaja set',300.00,2,600.00),(20,15,9,'chowmien',240.00,1,240.00),(21,16,8,'sukuti',240.00,1,240.00),(22,17,8,'sukuti',240.00,1,240.00),(23,18,16,'C.momo',160.00,1,160.00);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(100) NOT NULL,
  `table_number` int NOT NULL,
  `total` decimal(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('pending','served') NOT NULL DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'sam',2,1440.00,'2026-01-24 08:45:47','pending'),(2,'ram',3,240.00,'2026-01-24 08:53:59','served'),(3,'sam',3,240.00,'2026-01-24 08:54:19','served'),(4,'hari',3,240.00,'2026-01-24 08:56:26','pending'),(5,'aarnav',5,240.00,'2026-01-24 09:00:44','pending'),(6,'sup',4,240.00,'2026-01-24 09:01:03','served'),(7,'suori',2,300.00,'2026-01-25 04:21:55','pending'),(8,'aarnav',6,900.00,'2026-01-25 04:22:46','served'),(9,'nikita',4,300.00,'2026-01-25 07:01:09','served'),(10,'akshyata',5,460.00,'2026-01-25 07:04:35','pending'),(11,'<s>sam',8,280.00,'2026-01-26 08:22:47','served'),(12,'sam',2,240.00,'2026-01-26 08:25:02','served'),(13,'sam',4,480.00,'2026-01-27 13:30:08','pending'),(14,'dilasa',4,240.00,'2026-01-27 13:30:46','pending'),(15,'supadim',4,840.00,'2026-01-30 07:58:45','served'),(16,'hama',4,240.00,'2026-01-31 08:17:20','served'),(17,'raviteja',7,240.00,'2026-01-31 12:45:32','pending'),(18,'aarnav',8,160.00,'2026-02-01 07:55:34','pending');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-02-01 14:19:59
