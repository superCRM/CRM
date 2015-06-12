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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agents`
--

LOCK TABLES `agents` WRITE;
/*!40000 ALTER TABLE `agents` DISABLE KEYS */;
INSERT INTO `agents` VALUES (2,'admin','CRMbBVAC64Dd6','fg@mail.ru');
/*!40000 ALTER TABLE `agents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_num` smallint(6) NOT NULL,
  `email_us` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `product` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prod_num` smallint(6) DEFAULT NULL,
  `prod_num_refunded` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_UNIQUE` (`order_num`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,3,'d@s.ua','Phone',6,6),(2,2,'s@w.yu','Ref',4,4),(3,4,'s@w.yu','Cat',7,7),(4,5,'d@s.ua','Log',120,65);
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
  `date` datetime DEFAULT NULL,
  `product` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_num` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refund`
--

LOCK TABLES `refund` WRITE;
/*!40000 ALTER TABLE `refund` DISABLE KEYS */;
INSERT INTO `refund` VALUES (14,0,'d@s.ua','2015-06-12 18:16:51','Phone',1),(15,0,'s@w.yu','2015-06-12 18:22:06','Ref',1),(16,0,'s@w.yu','2015-06-12 18:22:20','Ref',1),(17,0,'s@w.yu','2015-06-12 18:22:56','Ref',1),(18,0,'s@w.yu','2015-06-12 18:25:16','Ref',1),(19,0,'d@s.ua','2015-06-12 18:26:18','Phone',1),(20,0,'d@s.ua','2015-06-12 18:27:57','Phone',1),(21,0,'d@s.ua','2015-06-12 18:29:04','Phone',1),(22,0,'d@s.ua','2015-06-12 18:29:15','Phone',1),(23,0,'d@s.ua','2015-06-12 18:30:59','Phone',1),(24,0,'s@w.yu','2015-06-12 18:35:21','Cat',1),(25,0,'s@w.yu','2015-06-12 18:35:26','Cat',1),(26,0,'s@w.yu','2015-06-12 18:38:09','Cat',2),(27,0,'s@w.yu','2015-06-12 18:38:17','Cat',2),(28,0,'s@w.yu','2015-06-12 18:52:52','Cat',1),(29,0,'d@s.ua','2015-06-12 19:35:10','Log',1),(30,0,'d@s.ua','2015-06-12 19:35:17','Log',1),(31,0,'d@s.ua','2015-06-12 19:35:23','Log',1),(32,0,'d@s.ua','2015-06-12 19:37:27','Log',1),(33,0,'d@s.ua','2015-06-12 19:37:52','Log',1),(34,0,'d@s.ua','2015-06-12 19:45:07','Log',2),(35,0,'d@s.ua','2015-06-12 19:45:42','Log',2),(36,0,'d@s.ua','2015-06-12 19:45:48','Log',2),(37,0,'d@s.ua','2015-06-12 19:48:42','Log',1),(38,0,'d@s.ua','2015-06-12 19:55:22','Log',1),(39,0,'d@s.ua','2015-06-12 19:56:48','Log',1),(40,0,'d@s.ua','2015-06-12 19:58:37','Log',2),(41,0,'d@s.ua','2015-06-12 19:58:38','Log',2),(42,0,'d@s.ua','2015-06-12 19:58:43','Log',2),(43,0,'d@s.ua','2015-06-12 19:58:44','Log',2),(44,0,'d@s.ua','2015-06-12 19:58:54','Log',2),(45,0,'d@s.ua','2015-06-12 19:58:54','Log',2),(46,0,'d@s.ua','2015-06-12 19:59:12','Log',2),(47,0,'d@s.ua','2015-06-12 19:59:39','Log',3),(48,0,'d@s.ua','2015-06-12 19:59:43','Log',3),(49,0,'d@s.ua','2015-06-12 20:00:45','Log',3),(50,0,'d@s.ua','2015-06-12 20:01:39','Log',3),(51,0,'d@s.ua','2015-06-12 20:01:56','Log',3),(52,0,'d@s.ua','2015-06-12 20:02:27','Log',3),(53,0,'d@s.ua','2015-06-12 20:08:27','Log',3),(54,0,'d@s.ua','2015-06-12 20:09:03','Log',3),(55,0,'d@s.ua','2015-06-12 20:09:46','Log',3),(56,0,'d@s.ua','2015-06-12 20:10:03','Log',4),(57,0,'d@s.ua','2015-06-12 20:10:38','Log',6);
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'1','2'),(2,'Dasha','d@s.ua'),(3,'Fred','s@w.yu'),(4,'asdasd','asdasd@asd.asd'),(5,'asdasasdasdd','asdaasdasdsd@asd.asd'),(6,'js','sadasd@gmail.com'),(7,'alex','alex@gmail.com');
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

-- Dump completed on 2015-06-12 20:12:33
