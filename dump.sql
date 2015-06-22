-- MySQL dump 10.13  Distrib 5.5.43, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: crman
-- ------------------------------------------------------
-- Server version	5.5.43-0ubuntu0.14.04.1

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
-- Table structure for table `agent_refund`
--

DROP TABLE IF EXISTS `agent_refund`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agent_refund` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `refund_id` int(11) NOT NULL,
  `agent_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agent_refund`
--

LOCK TABLES `agent_refund` WRITE;
/*!40000 ALTER TABLE `agent_refund` DISABLE KEYS */;
INSERT INTO `agent_refund` VALUES (1,70,7),(2,70,7),(3,74,2),(4,75,2),(5,76,2),(6,77,2),(7,78,2);
/*!40000 ALTER TABLE `agent_refund` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agents`
--

DROP TABLE IF EXISTS `agents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login_UNIQUE` (`login`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agents`
--

LOCK TABLES `agents` WRITE;
/*!40000 ALTER TABLE `agents` DISABLE KEYS */;
INSERT INTO `agents` VALUES (2,'admin','CRMbBVAC64Dd6','fg@mail.ru'),(3,'name','CRZwWDET7s0Z2','name@gmail.com');
/*!40000 ALTER TABLE `agents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `key_refund`
--

DROP TABLE IF EXISTS `key_refund`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `key_refund` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key_id` int(11) NOT NULL,
  `refund_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `key_refund`
--

LOCK TABLES `key_refund` WRITE;
/*!40000 ALTER TABLE `key_refund` DISABLE KEYS */;
INSERT INTO `key_refund` VALUES (1,3,70),(2,4,70),(3,5,70),(4,123,71),(5,2,71),(6,1,71),(7,5,71),(8,123,0),(9,2,0),(10,1,0),(11,5,0),(12,123,72),(13,2,72),(14,1,72),(15,5,72),(16,123,73),(17,2,73),(18,1,73),(19,5,73),(20,123,74),(21,2,74),(22,1,74),(23,5,74),(24,123,75),(25,2,75),(26,1,75),(27,5,75),(28,123,76),(29,2,76),(30,1,76),(31,5,76),(32,123,77),(33,2,77),(34,1,77),(35,5,77),(36,123,78),(37,2,78),(38,1,78),(39,5,78),(40,123,79),(41,2,79),(42,1,79),(43,5,79),(44,123,80),(45,2,80),(46,1,80),(47,5,80),(48,123,0),(49,2,0),(50,1,0),(51,5,0),(52,13,0),(53,15,0),(54,7,0),(55,20,0),(56,13,0),(57,15,0),(58,7,0),(59,20,0),(60,13,0),(61,15,0),(62,7,0),(63,20,0),(64,13,0),(65,15,0),(66,7,0),(67,20,0),(68,13,0),(69,15,0),(70,7,0),(71,20,0),(72,13,0),(73,15,0),(74,7,0),(75,20,0),(76,13,81),(77,15,81),(78,7,81),(79,20,81);
/*!40000 ALTER TABLE `key_refund` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `keys`
--

DROP TABLE IF EXISTS `keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `keys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `key_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `percent` decimal(6,2) DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `keys`
--

LOCK TABLES `keys` WRITE;
/*!40000 ALTER TABLE `keys` DISABLE KEYS */;
INSERT INTO `keys` VALUES (1,50,3,0,84.00),(2,50,4,0,84.00),(3,50,5,1,NULL),(4,3,9,0,0.00),(5,5,10,0,0.00),(6,79,123,0,50.00),(7,79,123,0,50.00),(8,79,1,0,50.00),(9,79,2,0,50.00),(10,32,13,0,0.00),(11,32,15,0,0.00),(12,32,7,0,0.00),(13,32,20,0,0.00);
/*!40000 ALTER TABLE `keys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` smallint(6) DEFAULT NULL,
  `email_us` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `key_num` smallint(6) DEFAULT NULL,
  `sum` decimal(10,2) NOT NULL,
  `refunded_sum` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_UNIQUE` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,3,'d@s.ua',6,10000.00,0.00),(2,2,'s@w.yu',4,2000.60,0.00),(3,4,'s@w.yu',7,1000.00,0.00),(4,5,'d@s.ua',120,5000.00,257.00),(5,50,'d@s.ua',3,1000.00,0.00),(6,211,'alex@gmail.com',4,0.00,0.00),(7,81,'alex@gmail.com',4,0.00,0.00),(8,126,'alex@gmail.com',4,0.00,0.00),(9,175,'alex@gmail.com',4,0.00,0.00),(10,828,'alex@gmail.com',4,0.00,0.00),(11,756,'alex@gmail.com',4,0.00,0.00),(12,555,'alex@gmail.com',4,0.00,0.00),(13,844,'alex@gmail.com',4,0.00,0.00),(14,813,'alex@gmail.com',4,0.00,0.00),(15,62,'alex@gmail.com',4,0.00,0.00),(16,947,'alex@gmail.com',4,0.00,0.00),(17,845,'alex@gmail.com',4,0.00,0.00),(18,340,'alex@gmail.com',4,0.00,0.00),(19,744,'alex@gmail.com',4,0.00,0.00),(20,609,'alex@gmail.com',4,0.00,0.00),(21,912,'alex@gmail.com',4,0.00,0.00),(22,399,'alex@gmail.com',4,0.00,0.00),(23,136,'alex@gmail.com',4,0.00,0.00),(24,189,'alex@gmail.com',1,0.00,0.00),(25,636,'alex@gmail.com',4,100.00,0.00),(26,123,'alex@gmail.com',4,100.00,0.00),(27,425,'alex@gmail.com',4,100.00,0.00),(28,987,'alex@gmail.com',4,100.00,0.00),(32,800,'alex@gmail.com',4,30.00,0.00);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` smallint(6) NOT NULL,
  `name` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `count` smallint(6) DEFAULT NULL,
  `sum` decimal(10,2) DEFAULT NULL,
  `refund_sum` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refund`
--

DROP TABLE IF EXISTS `refund`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refund` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` tinyint(4) NOT NULL,
  `email_us` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `data` datetime DEFAULT NULL,
  `key_num` smallint(6) DEFAULT NULL,
  `percent` decimal(6,2) DEFAULT NULL,
  `final_percent` decimal(6,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refund`
--

LOCK TABLES `refund` WRITE;
/*!40000 ALTER TABLE `refund` DISABLE KEYS */;
INSERT INTO `refund` VALUES (70,1,'d@s.ua','2015-06-16 19:31:57',3,8.00,7.00),(71,1,'test@test.com','2015-06-19 17:09:21',4,9.99,9.99),(72,1,'test@test.com','2015-06-19 17:15:04',4,9.99,9.99),(73,1,'test@test.com','2015-06-19 17:16:45',4,3.00,3.00),(74,1,'test@test.com','2015-06-19 17:17:45',4,9.99,9.99),(75,1,'test@test.com','2015-06-19 17:18:01',4,9.99,9.99),(76,1,'test@test.com','2015-06-19 17:19:38',4,20.00,20.00),(77,1,'test@test.com','2015-06-19 19:37:50',4,20.00,20.00),(78,1,'test@test.com','2015-06-19 19:38:34',4,20.00,20.00),(79,0,'test@test.com','2015-06-19 19:39:50',4,20.00,20.00),(80,0,'test@test.com','2015-06-19 19:40:20',4,20.00,20.00),(81,0,'ty@gmail.com','2015-06-22 20:55:24',4,30.00,30.00);
/*!40000 ALTER TABLE `refund` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refund_product`
--

DROP TABLE IF EXISTS `refund_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refund_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sum` decimal(10,2) NOT NULL,
  `id_refund` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refund_product`
--

LOCK TABLES `refund_product` WRITE;
/*!40000 ALTER TABLE `refund_product` DISABLE KEYS */;
INSERT INTO `refund_product` VALUES (1,'Phone',1.00,3),(2,'Dr Web',3.00,4),(3,'iOS',5.00,4);
/*!40000 ALTER TABLE `refund_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'1','2',1),(2,'Dasha','d@s.ua',2),(3,'Fred','s@w.yu',3),(4,'asdasd','asdasd@asd.asd',4),(5,'asdasasdasdd','asdaasdasdsd@asd.asd',5),(6,'js','sadasd@gmail.com',6),(7,'alex','alex@gmail.com',0),(8,'afsdasf','george12@net.com',8);
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

-- Dump completed on 2015-06-22 20:58:58
