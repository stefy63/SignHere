-- MySQL dump 10.13  Distrib 5.6.35, for Linux (x86_64)
--
-- Host: localhost    Database: sign_here
-- ------------------------------------------------------
-- Server version	5.6.35

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
-- Table structure for table `acl_brand`
--

DROP TABLE IF EXISTS `acl_brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_brand` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `acl_id` int(10) unsigned NOT NULL DEFAULT '1',
  `brand_id` int(10) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `acl_brand_acl_id_foreign` (`acl_id`),
  KEY `acl_brand_brand_id_foreign` (`brand_id`),
  CONSTRAINT `acl_brand_acl_id_foreign` FOREIGN KEY (`acl_id`) REFERENCES `acls` (`id`) ON DELETE CASCADE,
  CONSTRAINT `acl_brand_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_brand`
--

LOCK TABLES `acl_brand` WRITE;
/*!40000 ALTER TABLE `acl_brand` DISABLE KEYS */;
INSERT INTO `acl_brand` VALUES (1,1,1,NULL,NULL),(7,3,2,NULL,NULL),(8,4,3,NULL,NULL),(17,2,1,NULL,NULL),(19,5,13,NULL,NULL),(20,1,14,NULL,NULL),(21,6,14,NULL,NULL),(22,1,15,NULL,NULL),(23,7,15,NULL,NULL),(24,8,15,NULL,NULL),(25,9,15,NULL,NULL);
/*!40000 ALTER TABLE `acl_brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acl_client`
--

DROP TABLE IF EXISTS `acl_client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_client` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `acl_id` int(10) unsigned NOT NULL DEFAULT '1',
  `client_id` int(10) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `acl_client_acl_id_foreign` (`acl_id`),
  KEY `acl_client_client_id_foreign` (`client_id`),
  CONSTRAINT `acl_client_acl_id_foreign` FOREIGN KEY (`acl_id`) REFERENCES `acls` (`id`) ON DELETE CASCADE,
  CONSTRAINT `acl_client_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_client`
--

LOCK TABLES `acl_client` WRITE;
/*!40000 ALTER TABLE `acl_client` DISABLE KEYS */;
INSERT INTO `acl_client` VALUES (1,1,1,NULL,NULL),(2,1,2,NULL,NULL),(3,2,3,NULL,NULL),(5,9,4,NULL,NULL);
/*!40000 ALTER TABLE `acl_client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acl_device`
--

DROP TABLE IF EXISTS `acl_device`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_device` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `acl_id` int(10) unsigned NOT NULL DEFAULT '1',
  `device_id` int(10) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `acl_device_acl_id_foreign` (`acl_id`),
  KEY `acl_device_device_id_foreign` (`device_id`),
  CONSTRAINT `acl_device_acl_id_foreign` FOREIGN KEY (`acl_id`) REFERENCES `acls` (`id`) ON DELETE CASCADE,
  CONSTRAINT `acl_device_device_id_foreign` FOREIGN KEY (`device_id`) REFERENCES `devices` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_device`
--

LOCK TABLES `acl_device` WRITE;
/*!40000 ALTER TABLE `acl_device` DISABLE KEYS */;
/*!40000 ALTER TABLE `acl_device` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acl_location`
--

DROP TABLE IF EXISTS `acl_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_location` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `acl_id` int(10) unsigned NOT NULL DEFAULT '1',
  `location_id` int(10) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `acl_location_acl_id_foreign` (`acl_id`),
  KEY `acl_location_location_id_foreign` (`location_id`),
  CONSTRAINT `acl_location_acl_id_foreign` FOREIGN KEY (`acl_id`) REFERENCES `acls` (`id`) ON DELETE CASCADE,
  CONSTRAINT `acl_location_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_location`
--

LOCK TABLES `acl_location` WRITE;
/*!40000 ALTER TABLE `acl_location` DISABLE KEYS */;
INSERT INTO `acl_location` VALUES (1,1,1,NULL,NULL),(2,1,2,NULL,NULL),(3,1,3,NULL,NULL),(4,1,4,NULL,NULL),(5,1,5,NULL,NULL),(8,1,6,NULL,NULL),(9,1,7,NULL,NULL),(10,1,8,NULL,NULL),(11,1,9,NULL,NULL),(12,1,10,NULL,NULL),(13,1,11,NULL,NULL),(14,1,12,NULL,NULL),(15,1,13,NULL,NULL),(16,1,14,NULL,NULL),(17,1,15,NULL,NULL),(18,1,16,NULL,NULL),(19,1,17,NULL,NULL),(20,1,18,NULL,NULL),(21,1,19,NULL,NULL),(22,1,20,NULL,NULL),(23,1,21,NULL,NULL),(24,1,22,NULL,NULL),(25,1,23,NULL,NULL),(27,1,25,NULL,NULL),(28,1,26,NULL,NULL),(29,7,25,NULL,NULL),(30,7,26,NULL,NULL),(31,8,25,NULL,NULL),(32,9,26,NULL,NULL),(33,1,27,NULL,NULL),(34,5,28,NULL,NULL),(37,8,28,NULL,NULL),(38,9,28,NULL,NULL),(39,6,27,NULL,NULL);
/*!40000 ALTER TABLE `acl_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acl_profile`
--

DROP TABLE IF EXISTS `acl_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_profile` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `acl_id` int(10) unsigned NOT NULL DEFAULT '1',
  `profile_id` int(10) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `acl_profile_acl_id_foreign` (`acl_id`),
  KEY `acl_profile_profile_id_foreign` (`profile_id`),
  CONSTRAINT `acl_profile_acl_id_foreign` FOREIGN KEY (`acl_id`) REFERENCES `acls` (`id`) ON DELETE CASCADE,
  CONSTRAINT `acl_profile_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_profile`
--

LOCK TABLES `acl_profile` WRITE;
/*!40000 ALTER TABLE `acl_profile` DISABLE KEYS */;
INSERT INTO `acl_profile` VALUES (1,1,1,'2017-04-26 13:08:56',NULL),(2,1,2,NULL,NULL),(3,2,2,NULL,NULL),(4,1,3,NULL,NULL),(5,1,4,NULL,NULL),(6,1,5,NULL,NULL),(7,5,4,NULL,NULL),(8,5,5,NULL,NULL),(9,6,4,NULL,NULL),(10,7,4,NULL,NULL),(11,7,5,NULL,NULL),(12,8,4,NULL,NULL),(13,8,5,NULL,NULL),(14,9,4,NULL,NULL),(15,9,5,NULL,NULL),(16,6,5,NULL,NULL);
/*!40000 ALTER TABLE `acl_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acl_user`
--

DROP TABLE IF EXISTS `acl_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `acl_id` int(10) unsigned NOT NULL DEFAULT '1',
  `user_id` int(10) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `acl_user_acl_id_foreign` (`acl_id`),
  KEY `acl_user_user_id_foreign` (`user_id`),
  CONSTRAINT `acl_user_acl_id_foreign` FOREIGN KEY (`acl_id`) REFERENCES `acls` (`id`) ON DELETE CASCADE,
  CONSTRAINT `acl_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl_user`
--

LOCK TABLES `acl_user` WRITE;
/*!40000 ALTER TABLE `acl_user` DISABLE KEYS */;
INSERT INTO `acl_user` VALUES (1,1,1,NULL,NULL),(3,2,2,NULL,NULL),(8,3,7,NULL,NULL),(9,4,2,NULL,NULL),(10,1,9,NULL,NULL),(11,1,10,NULL,NULL),(12,2,10,NULL,NULL),(14,5,11,NULL,NULL),(15,5,12,NULL,NULL),(16,6,9,NULL,NULL),(17,6,11,NULL,NULL),(19,7,11,NULL,NULL),(20,8,10,NULL,NULL),(21,8,11,NULL,NULL),(22,1,16,NULL,NULL),(23,9,11,NULL,NULL),(24,9,16,NULL,NULL);
/*!40000 ALTER TABLE `acl_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acls`
--

DROP TABLE IF EXISTS `acls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acls` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `parent_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acls`
--

LOCK TABLES `acls` WRITE;
/*!40000 ALTER TABLE `acls` DISABLE KEYS */;
INSERT INTO `acls` VALUES (1,'root','root group of all acls',0,1,1,'2017-04-26 13:08:56','2017-04-27 09:49:23',NULL),(2,'Azienda 1',NULL,1,1,1,'2017-04-27 11:19:50','2017-04-27 11:19:50',NULL),(3,'Azienda 2',NULL,1,1,1,'2017-04-27 12:35:39','2017-04-27 12:35:39',NULL),(4,'Azienda 3',NULL,1,1,1,'2017-04-27 12:36:57','2017-04-27 12:36:57',NULL),(5,'Di Viesto - ROOT','Di Viesto SPA',1,1,1,'2017-05-24 11:51:53','2017-05-24 11:51:53',NULL),(6,'Di Viesto Piu Spa ROOT','Di Viesto Piu Spa',1,1,1,'2017-05-24 13:17:29','2017-05-24 13:17:29',NULL),(7,'Il Faro SPA',NULL,1,1,1,'2017-05-24 13:25:26','2017-05-24 13:25:26',NULL),(8,'Autozentrum',NULL,7,1,1,'2017-05-24 13:26:50','2017-05-24 13:26:50',NULL),(9,'Ducati',NULL,7,1,1,'2017-05-24 13:29:32','2017-05-24 13:29:32',NULL);
/*!40000 ALTER TABLE `acls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alc_module`
--

DROP TABLE IF EXISTS `alc_module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alc_module` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `acl_id` int(10) unsigned NOT NULL DEFAULT '1',
  `module_id` int(10) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `alc_module_acl_id_foreign` (`acl_id`),
  KEY `alc_module_module_id_foreign` (`module_id`),
  CONSTRAINT `alc_module_acl_id_foreign` FOREIGN KEY (`acl_id`) REFERENCES `acls` (`id`) ON DELETE CASCADE,
  CONSTRAINT `alc_module_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alc_module`
--

LOCK TABLES `alc_module` WRITE;
/*!40000 ALTER TABLE `alc_module` DISABLE KEYS */;
/*!40000 ALTER TABLE `alc_module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brands`
--

DROP TABLE IF EXISTS `brands`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brands` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vat` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `personal_vat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sector` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zip_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `region` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brands`
--

LOCK TABLES `brands` WRITE;
/*!40000 ALTER TABLE `brands` DISABLE KEYS */;
INSERT INTO `brands` VALUES (1,'Azienda 1','123456789','123456789',NULL,'via Michele rossi 12','Torino','10100','Torino',NULL,NULL,NULL,NULL,'AZIENDA1@AZIENDA1.IT',1,1,'2017-04-27 07:02:52','2017-05-23 08:29:37',NULL),(2,'Azienda 2','123456789','123456789',NULL,'via rulfi 16','Milano','10200','Milano',NULL,NULL,NULL,NULL,'azienda2@azienda2.it',2,1,'2017-04-27 07:03:30','2017-04-27 14:26:20',NULL),(3,'Azienda 3','123456789','123456789',NULL,'via napoleone 4','Roma',NULL,'Roma',NULL,NULL,NULL,NULL,'azienda3@azienda3.it',1,1,'2017-04-27 07:04:38','2017-04-27 11:28:23',NULL),(4,'Azienda 4','123456789','123456789',NULL,'via Sospello 12','torino',NULL,'torino',NULL,NULL,NULL,NULL,'azeinda4@azienda4.it',1,1,'2017-04-27 07:05:35','2017-04-27 07:05:35',NULL),(5,'Azienda 5','123456789','123456789',NULL,'Corso Europa 198','Genova',NULL,'Genova',NULL,NULL,NULL,NULL,'azienda5@azienda5.it',1,1,'2017-04-27 07:06:12','2017-04-27 07:06:12',NULL),(6,'YSL','1076291765','1076291765','commercio','5, avenue Marceau','Paris','75116','Paris','Pierrè Berge','22336256325','3986598752','01119711100','YSL@SaintLaurent.fr',1,1,'2017-05-03 10:12:30','2017-05-03 10:50:44',NULL),(7,'Azienda 4','10762917653','10762917653','tiger','via scarpe','TORINO','10148','TO TORINO',NULL,'011256789','3896598754','011198578642','scarpetiger@balenciaga.it',1,1,'2017-05-03 10:14:23','2017-05-03 10:14:23',NULL),(8,'j brand Azienda 6','1058976555','1058976555','commercio','via clothes shop','torino','15987','la','j brand','+44708765688','+44708765688','+4498751254','jbrand@aol.com',1,1,'2017-05-03 10:17:30','2017-05-03 10:17:30',NULL),(9,'j crew Accessori','6544545','6544545','commercio','4th avenue','New York','10018','NY','Andy','+1 3478169862','+1 3478169862','+1 3478169888','jcrew@gmail.com',1,1,'2017-05-03 10:23:48','2017-05-03 10:23:48',NULL),(10,'Isabella Oliver','5579465','56+8466','commercio','mothers of invention','London','4456','London','isabell','0344 85576565','0344 85576565','0344 85576565','isabellaoliver@yey.com',1,1,'2017-05-03 10:27:43','2017-05-03 10:27:43',NULL),(11,'Balenciaga Shoes','46666','49866','commercio','Avenue George V','Paris','55454','Paris','Cristobal','+ 331 4478978754','+ 331 4478978754','+ 331 4478974548','balenciagashoes@dhfsfhf.fr',1,1,'2017-05-03 10:33:01','2017-05-03 10:33:01',NULL),(12,'Givenchy','46969589','46969589','commercio','Avenue George V Paris','Paris','4658','Paris','Hubert','487946203421245','487946203421245','3545789','Hubert@DeGivenchy.fr',1,1,'2017-05-03 10:42:28','2017-05-03 10:42:28',NULL),(13,'Di Viesto SPA','12345678901','12345678901','Auto','Via Reiss Rmoli 130','Torino','10100','Torino','Admin','123456789',NULL,NULL,'pippo@pippi.com',1,1,'2017-05-24 11:47:57','2017-05-24 11:47:57',NULL),(14,'Di Viesto Piu SPA','12345678901','12345678901','Auto','Via Reiss Rmoli 130','torino','10137','to',NULL,NULL,NULL,NULL,'pippo@pippi.com',1,1,'2017-05-24 13:16:19','2017-05-24 13:16:19',NULL),(15,'Il Faro SPA','12345678901',NULL,'Moto - Auto','Corso Allamano 70','Grugliasco','10095','TO','Pippo',NULL,NULL,NULL,'pippo@pippi.com',1,1,'2017-05-24 13:22:21','2017-05-24 13:22:21',NULL);
/*!40000 ALTER TABLE `brands` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `vat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `personal_vat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `region` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `zip_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (1,'ste','Super Admin','stefano.sca@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,'2017-04-26 13:09:28','2017-04-26 13:09:37',NULL),(2,'andy','fancy','afancy@yahoo.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,'2017-04-26 13:48:38','2017-04-26 13:49:03',NULL),(3,'Roberto','Rovazzi','r.rovazzi@gmail.com',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,1,'2017-04-27 11:31:11','2017-04-27 11:31:11',NULL),(4,'Roberto','Tarantino','roberto.tarantino@3punto6.com','10762910015','10762910015','Via Papacino 8','Torino','TO','10121',NULL,'0110438834',NULL,11,1,'2017-05-24 12:36:56','2017-05-24 13:43:49',NULL);
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `device_user`
--

DROP TABLE IF EXISTS `device_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `device_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `device_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `device_user`
--

LOCK TABLES `device_user` WRITE;
/*!40000 ALTER TABLE `device_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `device_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `devices`
--

DROP TABLE IF EXISTS `devices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `devices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `serial` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `devices`
--

LOCK TABLES `devices` WRITE;
/*!40000 ALTER TABLE `devices` DISABLE KEYS */;
/*!40000 ALTER TABLE `devices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctypes`
--

DROP TABLE IF EXISTS `doctypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `template` text COLLATE utf8_unicode_ci,
  `questions` text COLLATE utf8_unicode_ci,
  `user_id` int(10) unsigned NOT NULL,
  `single_sign` tinyint(1) DEFAULT '1',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctypes`
--

LOCK TABLES `doctypes` WRITE;
/*!40000 ALTER TABLE `doctypes` DISABLE KEYS */;
INSERT INTO `doctypes` VALUES (1,'Modello 1',NULL,'2|150|200|O|Accetta le dichiarazioni fornite a pagina 2?\r\n2|150|268|M\r\n2|60|238|M\r\n5|50|120|M\r\n5|150|245|M\r\n5|150|262|M','2|13|180|23|180|Reddito annuale variabile o insicuro.',1,0,1,'2017-04-27 11:29:56','2017-05-23 12:11:42',NULL),(2,'test',NULL,'1|100|100|M','1|10|10|20|20|prova question',10,0,1,'2017-05-22 14:24:25','2017-05-22 14:24:25',NULL);
/*!40000 ALTER TABLE `doctypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date_doc` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `doctype_id` int(10) unsigned DEFAULT NULL,
  `dossier_id` int(10) unsigned NOT NULL,
  `signed` tinyint(1) NOT NULL DEFAULT '0',
  `readonly` tinyint(1) NOT NULL DEFAULT '0',
  `date_sign` timestamp NULL DEFAULT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_dossier_id_foreign` (`dossier_id`),
  CONSTRAINT `documents_dossier_id_foreign` FOREIGN KEY (`dossier_id`) REFERENCES `dossiers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents`
--

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
INSERT INTO `documents` VALUES (1,'2017-04-25 22:00:00','schermata1.png',NULL,NULL,'1/1/wdXSFOshFeY3DxeZuEmPrzDsZ1FLNkBqYz727pZo.png',0,1,1,0,NULL,1,1,'2017-04-26 13:10:04','2017-04-29 20:43:46',NULL),(2,'2017-04-25 22:00:00','xorg.conf.new',NULL,NULL,'1/1/TvFYDbf18MOwCVc1h34qbGbu3nbKerYUVUCY2ADG.txt',0,1,0,1,NULL,1,1,'2017-04-26 13:10:04','2017-04-29 20:43:57',NULL),(3,'2017-04-25 22:00:00','xorg.conf.new_old',NULL,NULL,'1/1/nQmO20tAfVUQOP1pl04Atlidl4Iizj4ogCpxhpBc.txt',NULL,1,0,0,NULL,1,1,'2017-04-26 13:10:04','2017-04-26 13:10:04',NULL),(4,'2017-04-25 22:00:00','prova','fdf','dfd','1/1/1iBJ3AsYytC8UNs6I8CK7OyIGOTif9qxTfLx3Bhu.pdf',0,1,0,0,NULL,1,1,'2017-04-26 13:11:34','2017-04-26 13:11:34',NULL),(5,'2017-05-21 22:00:00','Signature SDK - Asynchronous Capture.pdf',NULL,NULL,'2/2/qKOiyEmqQSce8M4lEsXnofofXjCUsoH3lwzEk28J.pdf',2,2,1,1,NULL,10,1,'2017-05-03 13:18:25','2017-05-22 14:25:27',NULL),(6,'2017-05-21 22:00:00','Proposta-Assicurazione-Vita-Intera-20123.pdf',NULL,NULL,'2/3/1wWP5j9Z8kKS2qaqvprGzNOvv2mtJzrDbYntXxKm.pdf',1,3,1,1,NULL,10,1,'2017-05-03 13:45:21','2017-05-22 14:04:27',NULL),(7,'2017-05-21 22:00:00','qKOiyEmqQSce8M4lEsXnofofXjCUsoH3lwzEk28J.pdf',NULL,NULL,'3/4/lEkKY4uNkzVghqceAU0Pkry0hLMXZQY7t5MHDmMl.pdf',2,4,0,0,NULL,10,1,'2017-05-22 14:37:42','2017-05-22 14:38:25',NULL),(8,'2024-05-16 22:00:00','Polizza',NULL,'Semestrale','4/5/8CnAbfFxCRkcY1j8QTK4ReYvwqx6FP2Kd5kD3Yri.pdf',1,5,1,1,NULL,11,1,'2017-05-24 12:47:08','2017-05-24 13:03:38','2017-05-24 13:03:38');
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dossiers`
--

DROP TABLE IF EXISTS `dossiers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dossiers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_dossier` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `client_id` int(10) unsigned NOT NULL,
  `note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dossiers_client_id_foreign` (`client_id`),
  CONSTRAINT `dossiers_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dossiers`
--

LOCK TABLES `dossiers` WRITE;
/*!40000 ALTER TABLE `dossiers` DISABLE KEYS */;
INSERT INTO `dossiers` VALUES (1,'prova','dfd','2017-04-25 22:00:00',1,NULL,'2017-04-26 13:09:51','2017-04-26 13:09:51',NULL),(2,'100','hfdh','2017-04-05 22:00:00',2,'hhdh','2017-04-26 13:50:49','2017-04-26 13:50:59',NULL),(3,'Fascicolo 1','Test Assicurazione','2017-04-30 22:00:00',2,NULL,'2017-05-03 13:44:32','2017-05-03 13:44:32',NULL),(4,'pippo','moto 6 mesi','2017-05-21 22:00:00',3,NULL,'2017-05-22 14:34:27','2017-05-22 14:34:27',NULL),(5,'Audi EB201FW','Semestrale','2017-05-23 22:00:00',4,'Pessimo cliente','2017-05-24 12:38:58','2017-05-24 12:39:25',NULL),(6,'Auto DG926TV','Annuale','2017-01-31 23:00:00',4,'Cliente antipatico','2017-05-24 12:40:25','2017-05-24 12:40:25',NULL);
/*!40000 ALTER TABLE `dossiers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `locations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sector` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zip_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `region` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `contact` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fax` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `brand_id` int(10) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `locations_brand_id_foreign` (`brand_id`),
  CONSTRAINT `locations_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations`
--

LOCK TABLES `locations` WRITE;
/*!40000 ALTER TABLE `locations` DISABLE KEYS */;
INSERT INTO `locations` VALUES (1,'Sede 1',NULL,'Corso Grosseto 221','Torino','10100','torino',NULL,NULL,NULL,NULL,'AZIENDA1@AZIENDA1.IT',1,1,1,'2017-04-27 07:07:06','2017-04-27 07:07:06',NULL),(2,'Sede 2',NULL,'via Michele rossi 12','Torino','10100','Torino',NULL,NULL,NULL,NULL,'AZIENDA1@AZIENDA1.IT',1,1,1,'2017-04-27 07:07:54','2017-04-27 07:07:54',NULL),(3,'Sede 2',NULL,'viale cornaggia 12','Milano','10200','Milano',NULL,NULL,NULL,NULL,'azienda2@azienda2.it',1,2,1,'2017-04-27 07:08:21','2017-04-27 07:08:21',NULL),(4,'Sede 1',NULL,'Corso Italia 12','Milano','10200','Milano',NULL,NULL,NULL,NULL,'azienda2@azienda2.it',1,2,1,'2017-04-27 07:09:42','2017-04-27 07:09:42',NULL),(5,'Sede 3',NULL,'via Michele rossi 12','Torino','10100','Torino',NULL,NULL,NULL,NULL,'AZIENDA1@AZIENDA1.IT',1,2,1,'2017-04-27 07:15:07','2017-04-27 07:15:07',NULL),(6,'YSL Beverly hills','commercio','rodeo drive','California','90210','LA','Saint Laurent','+13102718580','+13102718580','+13102718580','YSL@SaintLaurent.com',1,6,1,'2017-05-03 10:57:45','2017-05-03 10:57:45',NULL),(7,'YSL NY City','commercio','3 east 57th street','Ny','54456','NY','hiiioui','+1 44989886565','+1 44989886565','+1 44989886565','ysl@SaintLaurentny.com',1,6,1,'2017-05-03 11:00:39','2017-05-03 11:00:39',NULL),(8,'YSL Santa Clara','commercio','gjhjgjhith California','California','54545','Santa Clara','MOEJRI','+1 3569875412','+1 3569875412','+1 3569875412','ysl@santaclara.ysl',1,6,1,'2017-05-03 11:03:41','2017-05-03 11:03:41',NULL),(9,'Azienda 4 Shanghai','commercio','Nanjing Road','Shanghai','201100','Shanghai','Lucy','+86 455555','+86 455555','+86 455555','hfhfhj@fhfh.ol',1,7,1,'2017-05-03 11:19:27','2017-05-03 11:19:27',NULL),(10,'Azienda 4 Rome','commercio','via roma 90','Roma','4599','Roma','Bey','389659751','389659751','389659751','azienda4@rome.it',1,7,1,'2017-05-03 11:37:30','2017-05-03 11:37:30',NULL),(11,'Holly Azienda4','commercio','via lagrange 4','Roma','55699','Roma','ela','46656565656','46656565656','46656565656','holly@azienda4.it',1,7,1,'2017-05-03 11:39:29','2017-05-03 11:39:29',NULL),(12,'Jeans IT','commercio','via san pio','TORINO','10100','Torino','heidi','39686559865','39686559865','39686559865','jbrand@jeans.it',1,8,1,'2017-05-03 11:41:13','2017-05-03 11:41:13',NULL),(13,'J Brand UAE','commercio','dubai roaa','dubai','886565','dubai','Fatima','+971 56-5559658','+971 56-5559658,00','4665456','jbrand@uae.com',1,8,1,'2017-05-03 11:44:41','2017-05-03 11:44:41',NULL),(14,'J Brand Tokyo','commercio','ghhhjj road','Tokyo','46898','Tokyo','ju uojo','565235898','565235898','565235898','JBrand@tokyo.com',1,8,1,'2017-05-03 11:52:36','2017-05-03 11:52:36',NULL),(15,'J Crew Singapore','commercio','Singapore road, 78','singapore','12236688','Singapore','lola','0564864','+369739425','0564864','jcrew@singapore.com',1,9,1,'2017-05-03 11:54:40','2017-05-03 11:54:40',NULL),(16,'J CREW KL','commercio','petronas tower road','Kuala Lumpur','4659','KL','LIS CHIA','4556689456','4556689456','4556689456','JCREW@KL.COM',1,9,1,'2017-05-03 11:57:03','2017-05-03 11:57:03',NULL),(17,'JCREW HONG KONG','commercio','MONTE VERDE','Hong Kong','no cap','Hong Kong','jojo','+88989899','+88989899','+88989899','jcrew@hk.com',1,9,1,'2017-05-03 11:59:00','2017-05-03 11:59:00',NULL),(18,'Isabella Oliver USA','commercio','FGFGIJGIR ROAD','Durango','16466','Durango','leila','0265877','0265877','0265877','isabellaoliver@durango.com',1,10,1,'2017-05-03 12:01:34','2017-05-03 12:01:34',NULL),(19,'Isabella Oliver Algarve','commercio','Algarve road','Alagarve, Portugal','46898','Faro','Luisa','+455689892589','+455689892589','+455689892589','Faroalgarve@isabellaoliver.com',1,10,1,'2017-05-03 12:07:57','2017-05-03 12:07:57',NULL),(20,'Balenciaga Hanoi','commercio','vietnam road','hanoi','5556','Ha Noi','Lara manager','8689866898','8689866898','8689866898','balenciagaclothes@hanoi.org',1,11,1,'2017-05-03 12:15:04','2017-05-03 12:15:04',NULL),(21,'Balenciaga Bali','commercio','indonesia road','Bali','45+652','Bali','alexa','548465989415','548465989415','4856489415','balenciagabags@hanoi.org',1,11,1,'2017-05-03 12:18:53','2017-05-03 12:18:53',NULL),(22,'Givenchy Capri','commercio','Capri Road','Capri, NA','46565','Capri, Na','Andres','86589847541210','86589847541210','86589847541210','givenchycapri@givenchy.it',1,12,1,'2017-05-03 12:22:08','2017-05-03 12:22:08',NULL),(23,'Givenchy Moscow','commercio','Moscow Road','Moscow','4565689','Moscow','Lexa','465694525851','465694525851','005414525851','givenchymoscow@russia.com',1,12,1,'2017-05-03 12:25:45','2017-05-03 12:25:45',NULL),(24,'Usato',NULL,'Via Reiss Romoli 130','Torino','10148','TO','Antonio','0112253310',NULL,NULL,'ced@diviesto.it',11,13,1,'2017-05-24 12:34:11','2017-05-24 13:33:25','2017-05-24 13:33:25'),(25,'AutoZentrum','Auto','Corso Allamano 70','Grugliasco','10095','TO',NULL,NULL,NULL,NULL,'pippo@pippi.com',1,15,1,'2017-05-24 13:23:34','2017-05-24 13:23:34',NULL),(26,'Ducati Store','Moto','Corso Allamano 66','Grugliasco','10095','TO',NULL,NULL,NULL,NULL,'pippo@pippi.com',1,15,1,'2017-05-24 13:24:21','2017-05-24 13:24:21',NULL),(27,'Nuovo','Auto','Via Giordano Bruno 70','Torino',NULL,'TO',NULL,NULL,NULL,NULL,'pippo@pippi.eu',11,14,1,'2017-05-24 13:34:20','2017-05-24 13:41:38',NULL),(28,'Di Viesto spa',NULL,'Via Reiss Romoli 130','Torino',NULL,'TO',NULL,NULL,NULL,NULL,'pippo@pluto.it',11,13,1,'2017-05-24 13:38:29','2017-05-24 13:38:29',NULL);
/*!40000 ALTER TABLE `locations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `env` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `level` enum('DEBUG','INFO','NOTICE','WARNING','ERROR','CRITICAL','ALERT','EMERGENCY') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'INFO',
  `context` text COLLATE utf8_unicode_ci NOT NULL,
  `extra` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=218 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` VALUES (1,'local','Login for user: admin from client IP: 192.168.136.147','DEBUG','[]','[]','2017-04-27 07:00:44','2017-04-27 07:00:44',NULL),(2,'local','Logout for user: admin from client IP: 192.168.136.147','DEBUG','[]','[]','2017-04-27 08:19:46','2017-04-27 08:19:46',NULL),(3,'local','Login for user: admin from client IP: 192.168.136.147','DEBUG','[]','[]','2017-04-27 08:20:34','2017-04-27 08:20:34',NULL),(4,'local','Logout for user: admin from client IP: 192.168.136.147','DEBUG','[]','[]','2017-04-27 08:21:29','2017-04-27 08:21:29',NULL),(5,'local','Login for user: admin from client IP: 192.168.136.147','DEBUG','[]','[]','2017-04-27 08:23:14','2017-04-27 08:23:14',NULL),(6,'local','Logout for user: admin from client IP: 192.168.136.147','DEBUG','[]','[]','2017-04-27 08:27:04','2017-04-27 08:27:04',NULL),(7,'local','Login for user: admin from client IP: 192.168.136.147','DEBUG','[]','[]','2017-04-27 08:29:29','2017-04-27 08:29:29',NULL),(8,'local','Logout for user: admin from client IP: 192.168.136.147','DEBUG','[]','[]','2017-04-27 08:30:10','2017-04-27 08:30:10',NULL),(9,'local','Login for user: admaz1 from client IP: 192.168.136.147','DEBUG','[]','[]','2017-04-27 08:30:14','2017-04-27 08:30:14',NULL),(10,'local','Logout for user: admaz1 from client IP: 192.168.136.147','DEBUG','[]','[]','2017-04-27 08:35:00','2017-04-27 08:35:00',NULL),(11,'local','Login for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-27 09:15:50','2017-04-27 09:15:50',NULL),(12,'local','Logout for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-27 09:15:52','2017-04-27 09:15:52',NULL),(13,'local','Login for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-27 09:16:04','2017-04-27 09:16:04',NULL),(14,'local','Logout for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-27 09:19:19','2017-04-27 09:19:19',NULL),(15,'local','Login for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-27 09:19:25','2017-04-27 09:19:25',NULL),(16,'local','Logout for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-27 09:19:29','2017-04-27 09:19:29',NULL),(17,'local','Login for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-27 09:19:34','2017-04-27 09:19:34',NULL),(18,'local','Logout for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-27 09:19:55','2017-04-27 09:19:55',NULL),(19,'local','Login for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-27 09:19:57','2017-04-27 09:19:57',NULL),(20,'local','Logout for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-27 09:19:59','2017-04-27 09:19:59',NULL),(21,'local','Login for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-27 09:20:54','2017-04-27 09:20:54',NULL),(22,'local','Login for user: admin from client IP: 192.168.136.147','DEBUG','[]','[]','2017-04-27 09:48:01','2017-04-27 09:48:01',NULL),(23,'local','exception \'PDOException\' with message \'SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry \'admaz1\' for key \'users_username_unique\'\' in /srv/www/htdocs/sign_here/vendor/laravel/framework/src/Illuminate/Database/Connection.php:449\nStack trace:\n#0 /srv/www/htdocs/sign_here/vendor/laravel/framework/src/Illuminate/Database/Connection.php(449): PDOStatement->execute()\n#1 /srv/www/htdocs/sign_here/vendor/laravel/framework/src/Illuminate/Database/Connection.ph','ERROR','[]','[]','2017-04-27 10:02:32','2017-04-27 10:02:32',NULL),(24,'local','exception \'PDOException\' with message \'SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry \'admaz1\' for key \'users_username_unique\'\' in /srv/www/htdocs/sign_here/vendor/laravel/framework/src/Illuminate/Database/Connection.php:449\nStack trace:\n#0 /srv/www/htdocs/sign_here/vendor/laravel/framework/src/Illuminate/Database/Connection.php(449): PDOStatement->execute()\n#1 /srv/www/htdocs/sign_here/vendor/laravel/framework/src/Illuminate/Database/Connection.ph','ERROR','[]','[]','2017-04-27 10:04:49','2017-04-27 10:04:49',NULL),(25,'local','exception \'PDOException\' with message \'SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry \'admaz1\' for key \'users_username_unique\'\' in /srv/www/htdocs/sign_here/vendor/laravel/framework/src/Illuminate/Database/Connection.php:449\nStack trace:\n#0 /srv/www/htdocs/sign_here/vendor/laravel/framework/src/Illuminate/Database/Connection.php(449): PDOStatement->execute()\n#1 /srv/www/htdocs/sign_here/vendor/laravel/framework/src/Illuminate/Database/Connection.ph','ERROR','[]','[]','2017-04-27 10:16:29','2017-04-27 10:16:29',NULL),(26,'local','exception \'PDOException\' with message \'SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry \'admaz1\' for key \'users_username_unique\'\' in /srv/www/htdocs/sign_here/vendor/laravel/framework/src/Illuminate/Database/Connection.php:449\nStack trace:\n#0 /srv/www/htdocs/sign_here/vendor/laravel/framework/src/Illuminate/Database/Connection.php(449): PDOStatement->execute()\n#1 /srv/www/htdocs/sign_here/vendor/laravel/framework/src/Illuminate/Database/Connection.ph','ERROR','[]','[]','2017-04-27 10:16:43','2017-04-27 10:16:43',NULL),(27,'local','Login for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-27 10:24:08','2017-04-27 10:24:08',NULL),(28,'local','Login for user: admin from client IP: 192.168.136.147','DEBUG','[]','[]','2017-04-27 10:25:38','2017-04-27 10:25:38',NULL),(29,'local','Login for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-27 10:26:06','2017-04-27 10:26:06',NULL),(30,'local','Logout for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-27 10:27:49','2017-04-27 10:27:49',NULL),(31,'local','Login for user: admin from client IP: 192.168.136.147','DEBUG','[]','[]','2017-04-27 10:42:26','2017-04-27 10:42:26',NULL),(32,'local','Login for user: admaz1 from client IP: 192.168.136.189','DEBUG','[]','[]','2017-04-27 10:43:20','2017-04-27 10:43:20',NULL),(33,'local','Login for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-27 10:48:53','2017-04-27 10:48:53',NULL),(34,'local','Login for user: admin from client IP: 192.168.136.147','DEBUG','[]','[]','2017-04-27 10:49:02','2017-04-27 10:49:02',NULL),(35,'local','Login for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-27 10:50:17','2017-04-27 10:50:17',NULL),(36,'local','Logout for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-27 10:50:21','2017-04-27 10:50:21',NULL),(37,'local','Login for user: admin from client IP: 192.168.136.147','DEBUG','[]','[]','2017-04-27 10:57:27','2017-04-27 10:57:27',NULL),(38,'local','Login for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-27 14:01:38','2017-04-27 14:01:38',NULL),(39,'local','Login for user: admin from client IP: 192.168.136.147','DEBUG','[]','[]','2017-04-27 14:09:58','2017-04-27 14:09:58',NULL),(40,'local','Login for user: admaz2 from client IP: 192.168.136.189','DEBUG','[]','[]','2017-04-27 14:10:12','2017-04-27 14:10:12',NULL),(41,'local','Login for user: admin from client IP: 192.168.136.147','DEBUG','[]','[]','2017-04-27 14:25:06','2017-04-27 14:25:06',NULL),(42,'local','Logout for user: admaz2 from client IP: 192.168.136.189','DEBUG','[]','[]','2017-04-27 14:33:48','2017-04-27 14:33:48',NULL),(43,'local','Login for user: admaz2 from client IP: 192.168.136.189','DEBUG','[]','[]','2017-04-27 14:34:36','2017-04-27 14:34:36',NULL),(44,'local','Login for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-27 14:47:32','2017-04-27 14:47:32',NULL),(45,'local','Logout for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-27 14:48:18','2017-04-27 14:48:18',NULL),(46,'local','Login for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-27 14:48:38','2017-04-27 14:48:38',NULL),(47,'local','Logout for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-27 14:50:31','2017-04-27 14:50:31',NULL),(48,'local','Login for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-27 15:05:46','2017-04-27 15:05:46',NULL),(49,'local','Login for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-27 19:21:06','2017-04-27 19:21:06',NULL),(50,'local','Login for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-28 15:12:18','2017-04-28 15:12:18',NULL),(51,'local','Logout for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-28 15:12:43','2017-04-28 15:12:43',NULL),(52,'local','Login for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-29 17:19:20','2017-04-29 17:19:20',NULL),(53,'local','Logout for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-29 17:37:08','2017-04-29 17:37:08',NULL),(54,'local','Login for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-29 18:37:16','2017-04-29 18:37:16',NULL),(55,'local','Logout for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-29 19:12:20','2017-04-29 19:12:20',NULL),(56,'local','Login for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-29 19:12:27','2017-04-29 19:12:27',NULL),(57,'local','Logout for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-29 19:12:56','2017-04-29 19:12:56',NULL),(58,'local','Login for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-29 19:13:02','2017-04-29 19:13:02',NULL),(59,'local','Logout for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-29 19:15:50','2017-04-29 19:15:50',NULL),(60,'local','Login for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-04-29 19:15:55','2017-04-29 19:15:55',NULL),(61,'local','Login for user: admin from client IP: 192.168.136.198','DEBUG','[]','[]','2017-05-02 07:20:54','2017-05-02 07:20:54',NULL),(62,'local','Login for user: admin from client IP: 192.168.136.147','DEBUG','[]','[]','2017-05-02 08:02:33','2017-05-02 08:02:33',NULL),(63,'local','Login for user: admin from client IP: 192.168.136.195','DEBUG','[]','[]','2017-05-02 09:02:55','2017-05-02 09:02:55',NULL),(64,'local','Login for user: admin from client IP: 192.168.136.132','DEBUG','[]','[]','2017-05-02 11:08:37','2017-05-02 11:08:37',NULL),(65,'local','Login for user: admin from client IP: 192.168.136.147','DEBUG','[]','[]','2017-05-02 11:31:49','2017-05-02 11:31:49',NULL),(66,'local','Login for user: admin from client IP: 192.168.136.147','DEBUG','[]','[]','2017-05-02 11:32:24','2017-05-02 11:32:24',NULL),(67,'local','Login for user: admin from client IP: 192.168.136.132','DEBUG','[]','[]','2017-05-02 11:37:30','2017-05-02 11:37:30',NULL),(68,'local','Login for user: admin from client IP: 192.168.136.147','DEBUG','[]','[]','2017-05-02 11:48:22','2017-05-02 11:48:22',NULL),(69,'local','Login for user: admin from client IP: 192.168.136.147','DEBUG','[]','[]','2017-05-02 12:33:35','2017-05-02 12:33:35',NULL),(70,'local','Login for user: admin from client IP: 192.168.136.147','DEBUG','[]','[]','2017-05-03 05:35:50','2017-05-03 05:35:50',NULL),(71,'local','Login for user: admin from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-03 08:47:57','2017-05-03 08:47:57',NULL),(72,'local','Login for user: admaz1 from client IP: 192.168.136.147','DEBUG','[]','[]','2017-05-03 11:42:46','2017-05-03 11:42:46',NULL),(73,'local','exception \'PDOException\' with message \'SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry \'corrado.manara@3punto6.com\' for key \'users_email_unique\'\' in /srv/www/htdocs/sign_here/vendor/laravel/framework/src/Illuminate/Database/Connection.php:449\nStack trace:\n#0 /srv/www/htdocs/sign_here/vendor/laravel/framework/src/Illuminate/Database/Connection.php(449): PDOStatement->execute()\n#1 /srv/www/htdocs/sign_here/vendor/laravel/framework/src/Illuminate/Datab','ERROR','[]','[]','2017-05-03 11:46:41','2017-05-03 11:46:41',NULL),(74,'local','Login for user: corrado from client IP: 192.168.136.147','DEBUG','[]','[]','2017-05-03 11:58:28','2017-05-03 11:58:28',NULL),(75,'local','Login for user: corrado from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-03 12:14:38','2017-05-03 12:14:38',NULL),(76,'local','Login for user: corrado from client IP: 192.168.136.147','DEBUG','[]','[]','2017-05-03 12:14:54','2017-05-03 12:14:54',NULL),(77,'local','Login for user: corrado from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-03 12:17:16','2017-05-03 12:17:16',NULL),(78,'local','Login for user: corrado from client IP: 192.168.136.147','DEBUG','[]','[]','2017-05-03 12:17:35','2017-05-03 12:17:35',NULL),(79,'local','Logout for user: corrado from client IP: 192.168.136.147','DEBUG','[]','[]','2017-05-03 12:18:31','2017-05-03 12:18:31',NULL),(80,'local','Login for user: corrado from client IP: 192.168.136.147','DEBUG','[]','[]','2017-05-03 12:19:05','2017-05-03 12:19:05',NULL),(81,'local','Login for user: corrado from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-03 12:19:08','2017-05-03 12:19:08',NULL),(82,'local','Logout for user: corrado from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-03 12:20:11','2017-05-03 12:20:11',NULL),(83,'local','Login for user: corrado from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-03 12:21:21','2017-05-03 12:21:21',NULL),(84,'local','Login for user: corrado from client IP: 192.168.136.147','DEBUG','[]','[]','2017-05-03 12:22:09','2017-05-03 12:22:09',NULL),(85,'local','Login for user: corrado from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-03 12:23:45','2017-05-03 12:23:45',NULL),(86,'local','Login for user: corrado from client IP: 192.168.136.147','DEBUG','[]','[]','2017-05-03 12:23:54','2017-05-03 12:23:54',NULL),(87,'local','Logout for user: corrado from client IP: 192.168.136.147','DEBUG','[]','[]','2017-05-03 12:25:34','2017-05-03 12:25:34',NULL),(88,'local','Login for user: corrado from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-03 12:26:09','2017-05-03 12:26:09',NULL),(89,'local','Login for user: corrado from client IP: 192.168.136.147','DEBUG','[]','[]','2017-05-03 12:26:38','2017-05-03 12:26:38',NULL),(90,'local','Login for user: corrado from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-03 12:27:09','2017-05-03 12:27:09',NULL),(91,'local','Logout for user: corrado from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-03 12:31:28','2017-05-03 12:31:28',NULL),(92,'local','Login for user: corrado from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-03 12:31:31','2017-05-03 12:31:31',NULL),(93,'local','Login for user: corrado from client IP: 192.168.136.147','DEBUG','[]','[]','2017-05-03 12:31:44','2017-05-03 12:31:44',NULL),(94,'local','Login for user: corrado from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-03 12:32:44','2017-05-03 12:32:44',NULL),(95,'local','Login for user: corrado from client IP: 192.168.136.147','DEBUG','[]','[]','2017-05-03 12:33:07','2017-05-03 12:33:07',NULL),(96,'local','Login for user: admin from client IP: 192.168.136.132','DEBUG','[]','[]','2017-05-03 13:14:13','2017-05-03 13:14:13',NULL),(97,'local','Login for user: corrado from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-03 13:33:49','2017-05-03 13:33:49',NULL),(98,'local','Login for user: corrado from client IP: 192.168.136.147','DEBUG','[]','[]','2017-05-03 13:39:35','2017-05-03 13:39:35',NULL),(99,'local','Login for user: admin from client IP: 192.168.136.147','DEBUG','[]','[]','2017-05-04 07:23:08','2017-05-04 07:23:08',NULL),(100,'local','Login for user: admin from client IP: 192.168.136.133','DEBUG','[]','[]','2017-05-09 11:09:06','2017-05-09 11:09:06',NULL),(101,'local','Login for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-05-11 11:24:15','2017-05-11 11:24:15',NULL),(102,'local','Logout for user: admin from client IP: 192.168.54.101','DEBUG','[]','[]','2017-05-11 11:24:28','2017-05-11 11:24:28',NULL),(103,'local','Login for user: admin from client IP: 192.168.54.49','DEBUG','[]','[]','2017-05-13 09:03:08','2017-05-13 09:03:08',NULL),(104,'local','Login for user: admin from client IP: 192.168.136.133','DEBUG','[]','[]','2017-05-22 11:12:49','2017-05-22 11:12:49',NULL),(105,'local','exception \'ErrorException\' with message \'openssl_pkcs7_sign(): error getting private key\' in /srv/www/htdocs/sign_here/vendor/tecnickcom/tcpdf/tcpdf.php:7594\nStack trace:\n#0 [internal function]: Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(2, \'openssl_pkcs7_s...\', \'/srv/www/htdocs...\', 7594, Array)\n#1 /srv/www/htdocs/sign_here/vendor/tecnickcom/tcpdf/tcpdf.php(7594): openssl_pkcs7_sign(\'/tmp/__tcpdf_22...\', \'/tmp/__tcpdf_22...\', \'file:///srv/www...\', Arr','ERROR','[]','[]','2017-05-22 11:20:54','2017-05-22 11:20:54',NULL),(106,'local','exception \'ErrorException\' with message \'openssl_pkcs7_sign(): error getting private key\' in /srv/www/htdocs/sign_here/vendor/tecnickcom/tcpdf/tcpdf.php:7594\nStack trace:\n#0 [internal function]: Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(2, \'openssl_pkcs7_s...\', \'/srv/www/htdocs...\', 7594, Array)\n#1 /srv/www/htdocs/sign_here/vendor/tecnickcom/tcpdf/tcpdf.php(7594): openssl_pkcs7_sign(\'/tmp/__tcpdf_4a...\', \'/tmp/__tcpdf_4a...\', \'file:///srv/www...\', Arr','ERROR','[]','[]','2017-05-22 11:24:43','2017-05-22 11:24:43',NULL),(107,'local','exception \'ErrorException\' with message \'openssl_pkcs7_sign(): error getting private key\' in /srv/www/htdocs/sign_here/vendor/tecnickcom/tcpdf/tcpdf.php:7594\nStack trace:\n#0 [internal function]: Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(2, \'openssl_pkcs7_s...\', \'/srv/www/htdocs...\', 7594, Array)\n#1 /srv/www/htdocs/sign_here/vendor/tecnickcom/tcpdf/tcpdf.php(7594): openssl_pkcs7_sign(\'/tmp/__tcpdf_8a...\', \'/tmp/__tcpdf_8a...\', \'file:///srv/www...\', Arr','ERROR','[]','[]','2017-05-22 11:26:23','2017-05-22 11:26:23',NULL),(108,'local','Login for user: admin from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-22 12:02:27','2017-05-22 12:02:27',NULL),(109,'local','Login for user: admin from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-22 12:03:36','2017-05-22 12:03:36',NULL),(110,'local','Login for user: admin from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-22 12:12:13','2017-05-22 12:12:13',NULL),(111,'local','Login for user: admin from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-22 12:13:08','2017-05-22 12:13:08',NULL),(112,'local','Login for user: admin from client IP: 192.168.136.133','DEBUG','[]','[]','2017-05-22 12:18:58','2017-05-22 12:18:58',NULL),(113,'local','exception \'ErrorException\' with message \'Undefined variable: lastItem\' in /srv/www/htdocs/sign_here/app/Http/Controllers/SignController.php:243\nStack trace:\n#0 /srv/www/htdocs/sign_here/app/Http/Controllers/SignController.php(243): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Undefined varia...\', \'/srv/www/htdocs...\', 243, Array)\n#1 [internal function]: App\\Http\\Controllers\\SignController->store_signing(Object(Illuminate\\Http\\Request), \'6\')\n#2 /srv/w','ERROR','[]','[]','2017-05-22 13:24:29','2017-05-22 13:24:29',NULL),(114,'local','exception \'ErrorException\' with message \'fopen() expects parameter 1 to be a valid path, string given\' in /srv/www/htdocs/sign_here/vendor/tecnickcom/tcpdf/include/tcpdf_static.php:1854\nStack trace:\n#0 [internal function]: Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(2, \'fopen() expects...\', \'/srv/www/htdocs...\', 1854, Array)\n#1 /srv/www/htdocs/sign_here/vendor/tecnickcom/tcpdf/include/tcpdf_static.php(1854): fopen(\'%PDF-1.5\\r%\\xE2\\xE3\\xCF\\xD3\\r...\', \'wb','ERROR','[]','[]','2017-05-22 13:41:41','2017-05-22 13:41:41',NULL),(115,'local','exception \'Symfony\\Component\\Debug\\Exception\\FatalErrorException\' with message \'Class \'App\\Http\\Controllers\\Carbon\' not found\' in /srv/www/htdocs/sign_here/app/Http/Controllers/SignController.php:250\nStack trace:\n#0 {main}','ERROR','[]','[]','2017-05-22 13:49:47','2017-05-22 13:49:47',NULL),(116,'local','Login for user: admin from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-22 13:56:34','2017-05-22 13:56:34',NULL),(117,'local','Login for user: admin from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-22 13:57:14','2017-05-22 13:57:14',NULL),(118,'local','Login for user: admin from client IP: 192.168.136.133','DEBUG','[]','[]','2017-05-22 13:59:14','2017-05-22 13:59:14',NULL),(119,'local','Logout for user: admin from client IP: 192.168.136.133','DEBUG','[]','[]','2017-05-22 14:00:22','2017-05-22 14:00:22',NULL),(120,'local','Login for user: stefy from client IP: 192.168.136.133','DEBUG','[]','[]','2017-05-22 14:00:32','2017-05-22 14:00:32',NULL),(121,'local','exception \'ErrorException\' with message \'Trying to get property of non-object\' in /srv/www/htdocs/sign_here/app/Http/Controllers/SignController.php:179\nStack trace:\n#0 /srv/www/htdocs/sign_here/app/Http/Controllers/SignController.php(179): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Trying to get p...\', \'/srv/www/htdocs...\', 179, Array)\n#1 [internal function]: App\\Http\\Controllers\\SignController->store_signing(Object(Illuminate\\Http\\Request), \'6\')\n#','ERROR','[]','[]','2017-05-22 14:01:18','2017-05-22 14:01:18',NULL),(122,'local','exception \'ErrorException\' with message \'Trying to get property of non-object\' in /srv/www/htdocs/sign_here/app/Http/Controllers/SignController.php:179\nStack trace:\n#0 /srv/www/htdocs/sign_here/app/Http/Controllers/SignController.php(179): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Trying to get p...\', \'/srv/www/htdocs...\', 179, Array)\n#1 [internal function]: App\\Http\\Controllers\\SignController->store_signing(Object(Illuminate\\Http\\Request), \'6\')\n#','ERROR','[]','[]','2017-05-22 14:02:28','2017-05-22 14:02:28',NULL),(123,'local','exception \'ErrorException\' with message \'Undefined offset: 0\' in /srv/www/htdocs/sign_here/app/Http/Controllers/SignController.php:222\nStack trace:\n#0 /srv/www/htdocs/sign_here/app/Http/Controllers/SignController.php(222): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Undefined offse...\', \'/srv/www/htdocs...\', 222, Array)\n#1 [internal function]: App\\Http\\Controllers\\SignController->store_signing(Object(Illuminate\\Http\\Request), \'6\')\n#2 /srv/www/htdocs','ERROR','[]','[]','2017-05-22 14:03:33','2017-05-22 14:03:33',NULL),(124,'local','Login for user: admin from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-22 14:46:38','2017-05-22 14:46:38',NULL),(125,'local','Login for user: admin from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-23 06:58:34','2017-05-23 06:58:34',NULL),(127,'local','Login for user: admin from client IP: 192.168.136.103','DEBUG','[]','[]','2017-05-23 07:19:45','2017-05-23 07:19:45',NULL),(128,'local','Login for user: stefy from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-23 10:22:56','2017-05-23 10:22:56',NULL),(129,'local','Logout for user: admin from client IP: 192.168.136.103','DEBUG','[]','[]','2017-05-23 10:25:37','2017-05-23 10:25:37',NULL),(130,'local','Login for user: admin from client IP: 192.168.136.103','DEBUG','[]','[]','2017-05-23 10:25:55','2017-05-23 10:25:55',NULL),(131,'local','Login for user: admin from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-23 11:31:47','2017-05-23 11:31:47',NULL),(132,'local','Login for user: admin from client IP: 192.168.136.103','DEBUG','[]','[]','2017-05-23 12:19:12','2017-05-23 12:19:12',NULL),(133,'local','Login for user: stefy from client IP: 192.168.136.189','DEBUG','[]','[]','2017-05-23 12:19:15','2017-05-23 12:19:15',NULL),(134,'local','exception \'ErrorException\' with message \'Undefined index: id\' in /srv/www/htdocs/sign_here/app/Http/Controllers/AdminModuleController.php:124\nStack trace:\n#0 /srv/www/htdocs/sign_here/app/Http/Controllers/AdminModuleController.php(124): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Undefined index...\', \'/srv/www/htdocs...\', 124, Array)\n#1 [internal function]: App\\Http\\Controllers\\AdminModuleController->update(Object(Illuminate\\Http\\Request), Object(Ap','ERROR','[]','[]','2017-05-23 12:37:55','2017-05-23 12:37:55',NULL),(138,'local','Login for user: admin from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-23 13:48:39','2017-05-23 13:48:39',NULL),(139,'local','Login for user: admin from client IP: 192.168.136.103','DEBUG','[]','[]','2017-05-23 13:49:37','2017-05-23 13:49:37',NULL),(140,'local','Login for user: stefy from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-24 04:13:39','2017-05-24 04:13:39',NULL),(141,'local','exception \'ErrorException\' with message \'openssl_pkcs7_sign(): error getting cert\' in /srv/www/htdocs/sign_here/vendor/tecnickcom/tcpdf/tcpdf.php:7594\nStack trace:\n#0 [internal function]: Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(2, \'openssl_pkcs7_s...\', \'/srv/www/htdocs...\', 7594, Array)\n#1 /srv/www/htdocs/sign_here/vendor/tecnickcom/tcpdf/tcpdf.php(7594): openssl_pkcs7_sign(\'/tmp/__tcpdf_50...\', \'/tmp/__tcpdf_50...\', \'file:///srv/www...\', Array, Arr','ERROR','[]','[]','2017-05-24 04:22:53','2017-05-24 04:22:53',NULL),(142,'local','Login for user: admin from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-24 04:30:28','2017-05-24 04:30:28',NULL),(143,'local','Login for user: admin from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 11:43:33','2017-05-24 11:43:33',NULL),(144,'local','exception \'Symfony\\Component\\Debug\\Exception\\FatalErrorException\' with message \'Call to a member function brands() on null\' in /srv/www/htdocs/sign_here/app/Http/Controllers/AdminAclController.php:116\nStack trace:\n#0 {main}','ERROR','[]','[]','2017-05-24 11:46:17','2017-05-24 11:46:17',NULL),(145,'local','exception \'Symfony\\Component\\Debug\\Exception\\FatalErrorException\' with message \'Call to a member function brands() on null\' in /srv/www/htdocs/sign_here/app/Http/Controllers/AdminAclController.php:116\nStack trace:\n#0 {main}','ERROR','[]','[]','2017-05-24 11:48:02','2017-05-24 11:48:02',NULL),(146,'local','exception \'Symfony\\Component\\Debug\\Exception\\FatalErrorException\' with message \'Call to a member function brands() on null\' in /srv/www/htdocs/sign_here/app/Http/Controllers/AdminAclController.php:116\nStack trace:\n#0 {main}','ERROR','[]','[]','2017-05-24 11:48:30','2017-05-24 11:48:30',NULL),(147,'local','exception \'Symfony\\Component\\Debug\\Exception\\FatalErrorException\' with message \'Call to a member function brands() on null\' in /srv/www/htdocs/sign_here/app/Http/Controllers/AdminAclController.php:116\nStack trace:\n#0 {main}','ERROR','[]','[]','2017-05-24 11:49:08','2017-05-24 11:49:08',NULL),(148,'local','exception \'Symfony\\Component\\Debug\\Exception\\FatalErrorException\' with message \'Call to a member function brands() on null\' in /srv/www/htdocs/sign_here/app/Http/Controllers/AdminAclController.php:116\nStack trace:\n#0 {main}','ERROR','[]','[]','2017-05-24 11:50:34','2017-05-24 11:50:34',NULL),(149,'local','exception \'Symfony\\Component\\Debug\\Exception\\FatalErrorException\' with message \'Call to a member function brands() on null\' in /srv/www/htdocs/sign_here/app/Http/Controllers/AdminAclController.php:116\nStack trace:\n#0 {main}','ERROR','[]','[]','2017-05-24 11:51:53','2017-05-24 11:51:53',NULL),(150,'local','Logout for user: admin from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 11:54:57','2017-05-24 11:54:57',NULL),(151,'local','Login for user: diviestoadm from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 11:55:05','2017-05-24 11:55:05',NULL),(152,'local','Logout for user: diviestoadm from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 11:57:21','2017-05-24 11:57:21',NULL),(153,'local','Login for user: admin from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 11:57:30','2017-05-24 11:57:30',NULL),(154,'local','Logout for user: admin from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 11:57:42','2017-05-24 11:57:42',NULL),(155,'local','Login for user: admin from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 11:58:04','2017-05-24 11:58:04',NULL),(156,'local','Logout for user: admin from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 12:00:58','2017-05-24 12:00:58',NULL),(157,'local','Login for user: admin from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 12:01:05','2017-05-24 12:01:05',NULL),(158,'local','Logout for user: admin from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 12:02:27','2017-05-24 12:02:27',NULL),(159,'local','Login for user: diviestoadm from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 12:02:36','2017-05-24 12:02:36',NULL),(160,'local','Logout for user: diviestoadm from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 12:03:35','2017-05-24 12:03:35',NULL),(161,'local','Login for user: admin from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 12:09:15','2017-05-24 12:09:15',NULL),(162,'local','Logout for user: admin from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 12:09:59','2017-05-24 12:09:59',NULL),(163,'local','Login for user: admin from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 12:10:15','2017-05-24 12:10:15',NULL),(164,'local','Logout for user: admin from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 12:10:24','2017-05-24 12:10:24',NULL),(165,'local','Login for user: diviestoadm from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 12:10:31','2017-05-24 12:10:31',NULL),(166,'local','Login for user: diviestoadm from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-24 12:16:08','2017-05-24 12:16:08',NULL),(167,'local','Login for user: admin from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 12:22:18','2017-05-24 12:22:18',NULL),(168,'local','Logout for user: diviestoadm from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-24 12:24:06','2017-05-24 12:24:06',NULL),(169,'local','Login for user: manu from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-24 12:24:25','2017-05-24 12:24:25',NULL),(170,'local','Logout for user: manu from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-24 12:24:44','2017-05-24 12:24:44',NULL),(171,'local','Login for user: diviestoadm from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-24 12:24:56','2017-05-24 12:24:56',NULL),(172,'local','Logout for user: diviestoadm from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-24 12:26:56','2017-05-24 12:26:56',NULL),(173,'local','Login for user: diviestoadm from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-24 12:27:20','2017-05-24 12:27:20',NULL),(174,'local','Logout for user: admin from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 12:30:20','2017-05-24 12:30:20',NULL),(175,'local','Login for user: admin from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 12:30:26','2017-05-24 12:30:26',NULL),(176,'local','Logout for user: admin from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 12:46:29','2017-05-24 12:46:29',NULL),(177,'local','Login for user: diviestoadm from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 12:46:37','2017-05-24 12:46:37',NULL),(178,'local','Logout for user: diviestoadm from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 12:47:19','2017-05-24 12:47:19',NULL),(179,'local','Login for user: diviestoadm from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-24 12:47:26','2017-05-24 12:47:26',NULL),(180,'local','Login for user: admin from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 12:47:55','2017-05-24 12:47:55',NULL),(181,'local','exception \'PDOException\' with message \'SQLSTATE[22007]: Invalid datetime format: 1292 Incorrect datetime value: \'24-05-2017 33-50-14\' for column \'date_doc\' at row 1\' in /srv/www/htdocs/sign_here/vendor/laravel/framework/src/Illuminate/Database/Connection.php:474\nStack trace:\n#0 /srv/www/htdocs/sign_here/vendor/laravel/framework/src/Illuminate/Database/Connection.php(474): PDOStatement->execute()\n#1 /srv/www/htdocs/sign_here/vendor/laravel/framework/src/Illuminate/Databas','ERROR','[]','[]','2017-05-24 12:50:33','2017-05-24 12:50:33',NULL),(182,'local','Logout for user: diviestoadm from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-24 13:00:29','2017-05-24 13:00:29',NULL),(183,'local','Login for user: manu from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-24 13:00:40','2017-05-24 13:00:40',NULL),(184,'local','Logout for user: manu from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-24 13:02:29','2017-05-24 13:02:29',NULL),(185,'local','Login for user: diviestoadm from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-24 13:02:43','2017-05-24 13:02:43',NULL),(186,'local','Logout for user: admin from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 13:07:20','2017-05-24 13:07:20',NULL),(187,'local','Login for user: admin from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 13:07:29','2017-05-24 13:07:29',NULL),(188,'local','exception \'PDOException\' with message \'SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry \'corrado\' for key \'users_username_unique\'\' in /srv/www/htdocs/sign_here/vendor/laravel/framework/src/Illuminate/Database/Connection.php:449\nStack trace:\n#0 /srv/www/htdocs/sign_here/vendor/laravel/framework/src/Illuminate/Database/Connection.php(449): PDOStatement->execute()\n#1 /srv/www/htdocs/sign_here/vendor/laravel/framework/src/Illuminate/Database/Connection.p','ERROR','[]','[]','2017-05-24 13:10:18','2017-05-24 13:10:18',NULL),(189,'local','exception \'PDOException\' with message \'SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry \'corrado\' for key \'users_username_unique\'\' in /srv/www/htdocs/sign_here/vendor/laravel/framework/src/Illuminate/Database/Connection.php:449\nStack trace:\n#0 /srv/www/htdocs/sign_here/vendor/laravel/framework/src/Illuminate/Database/Connection.php(449): PDOStatement->execute()\n#1 /srv/www/htdocs/sign_here/vendor/laravel/framework/src/Illuminate/Database/Connection.p','ERROR','[]','[]','2017-05-24 13:10:35','2017-05-24 13:10:35',NULL),(190,'local','exception \'Symfony\\Component\\Debug\\Exception\\FatalErrorException\' with message \'Call to a member function brands() on null\' in /srv/www/htdocs/sign_here/app/Http/Controllers/AdminAclController.php:116\nStack trace:\n#0 {main}','ERROR','[]','[]','2017-05-24 13:13:05','2017-05-24 13:13:05',NULL),(191,'local','exception \'Symfony\\Component\\Debug\\Exception\\FatalErrorException\' with message \'Call to a member function brands() on null\' in /srv/www/htdocs/sign_here/app/Http/Controllers/AdminAclController.php:116\nStack trace:\n#0 {main}','ERROR','[]','[]','2017-05-24 13:16:45','2017-05-24 13:16:45',NULL),(192,'local','exception \'Symfony\\Component\\Debug\\Exception\\FatalErrorException\' with message \'Call to a member function brands() on null\' in /srv/www/htdocs/sign_here/app/Http/Controllers/AdminAclController.php:116\nStack trace:\n#0 {main}','ERROR','[]','[]','2017-05-24 13:17:30','2017-05-24 13:17:30',NULL),(193,'local','exception \'Symfony\\Component\\Debug\\Exception\\FatalErrorException\' with message \'Call to a member function brands() on null\' in /srv/www/htdocs/sign_here/app/Http/Controllers/AdminAclController.php:116\nStack trace:\n#0 {main}','ERROR','[]','[]','2017-05-24 13:24:43','2017-05-24 13:24:43',NULL),(194,'local','exception \'Symfony\\Component\\Debug\\Exception\\FatalErrorException\' with message \'Call to a member function brands() on null\' in /srv/www/htdocs/sign_here/app/Http/Controllers/AdminAclController.php:116\nStack trace:\n#0 {main}','ERROR','[]','[]','2017-05-24 13:25:27','2017-05-24 13:25:27',NULL),(195,'local','exception \'Symfony\\Component\\Debug\\Exception\\FatalErrorException\' with message \'Call to a member function brands() on null\' in /srv/www/htdocs/sign_here/app/Http/Controllers/AdminAclController.php:116\nStack trace:\n#0 {main}','ERROR','[]','[]','2017-05-24 13:26:05','2017-05-24 13:26:05',NULL),(196,'local','exception \'Symfony\\Component\\Debug\\Exception\\FatalErrorException\' with message \'Call to a member function brands() on null\' in /srv/www/htdocs/sign_here/app/Http/Controllers/AdminAclController.php:116\nStack trace:\n#0 {main}','ERROR','[]','[]','2017-05-24 13:26:51','2017-05-24 13:26:51',NULL),(197,'local','exception \'Symfony\\Component\\Debug\\Exception\\FatalErrorException\' with message \'Call to a member function brands() on null\' in /srv/www/htdocs/sign_here/app/Http/Controllers/AdminAclController.php:116\nStack trace:\n#0 {main}','ERROR','[]','[]','2017-05-24 13:26:59','2017-05-24 13:26:59',NULL),(198,'local','exception \'PDOException\' with message \'SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry \'pippo@pippi.com\' for key \'users_email_unique\'\' in /srv/www/htdocs/sign_here/vendor/laravel/framework/src/Illuminate/Database/Connection.php:449\nStack trace:\n#0 /srv/www/htdocs/sign_here/vendor/laravel/framework/src/Illuminate/Database/Connection.php(449): PDOStatement->execute()\n#1 /srv/www/htdocs/sign_here/vendor/laravel/framework/src/Illuminate/Database/Connect','ERROR','[]','[]','2017-05-24 13:28:20','2017-05-24 13:28:20',NULL),(199,'local','exception \'Symfony\\Component\\Debug\\Exception\\FatalErrorException\' with message \'Call to a member function brands() on null\' in /srv/www/htdocs/sign_here/app/Http/Controllers/AdminAclController.php:116\nStack trace:\n#0 {main}','ERROR','[]','[]','2017-05-24 13:29:09','2017-05-24 13:29:09',NULL),(200,'local','exception \'Symfony\\Component\\Debug\\Exception\\FatalErrorException\' with message \'Call to a member function brands() on null\' in /srv/www/htdocs/sign_here/app/Http/Controllers/AdminAclController.php:116\nStack trace:\n#0 {main}','ERROR','[]','[]','2017-05-24 13:29:33','2017-05-24 13:29:33',NULL),(201,'local','Logout for user: diviestoadm from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-24 13:31:44','2017-05-24 13:31:44',NULL),(202,'local','Login for user: diviestoadm from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-24 13:31:59','2017-05-24 13:31:59',NULL),(203,'local','Logout for user: admin from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 13:34:36','2017-05-24 13:34:36',NULL),(204,'local','Login for user: admin from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 13:34:44','2017-05-24 13:34:44',NULL),(205,'local','Logout for user: diviestoadm from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-24 13:36:39','2017-05-24 13:36:39',NULL),(206,'local','Login for user: diviestoadm from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-24 13:37:11','2017-05-24 13:37:11',NULL),(207,'local','Logout for user: admin from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 13:39:11','2017-05-24 13:39:11',NULL),(208,'local','Login for user: admin from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 13:39:17','2017-05-24 13:39:17',NULL),(209,'local','Logout for user: diviestoadm from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-24 13:42:10','2017-05-24 13:42:10',NULL),(210,'local','Login for user: diviestoadm from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-24 13:42:26','2017-05-24 13:42:26',NULL),(211,'local','Logout for user: admin from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 13:43:26','2017-05-24 13:43:26',NULL),(212,'local','Login for user: admin from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 13:43:32','2017-05-24 13:43:32',NULL),(213,'local','Logout for user: diviestoadm from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-24 13:44:06','2017-05-24 13:44:06',NULL),(214,'local','Login for user: diviestoadm from client IP: 192.168.100.19','DEBUG','[]','[]','2017-05-24 13:44:24','2017-05-24 13:44:24',NULL),(215,'local','Logout for user: admin from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 13:45:23','2017-05-24 13:45:23',NULL),(216,'local','Login for user: andreea from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 13:45:31','2017-05-24 13:45:31',NULL),(217,'local','Logout for user: andreea from client IP: 192.168.136.130','DEBUG','[]','[]','2017-05-24 13:45:54','2017-05-24 13:45:54',NULL);
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=301 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (278,'2014_03_10_130944_create_logs_table',1),(279,'2014_10_12_000000_create_users_table',1),(280,'2014_10_12_100000_create_password_resets_table',1),(281,'2017_03_18_130536_create_brands_table',1),(282,'2017_03_18_130549_create_locations_table',1),(283,'2017_03_18_130556_create_clients_table',1),(284,'2017_03_18_130557_create_dossier_table',1),(285,'2017_03_18_130559_create_documents_table',1),(286,'2017_03_18_130607_create_devices_table',1),(287,'2017_03_18_130616_create_modules_table',1),(288,'2017_03_18_130940_create_acls_table',1),(289,'2017_03_18_131018_create_module_user_table',1),(290,'2017_03_18_131039_create_acl_user_table',1),(291,'2017_03_18_131129_create_acl_brand_table',1),(292,'2017_03_18_131151_create_acl_location_table',1),(293,'2017_03_18_131257_create_acl_device_table',1),(294,'2017_03_18_163424_create_acl_client__table',1),(295,'2017_03_18_182427_create_doctypes_table',1),(296,'2017_04_02_165457_create_device_user',1),(297,'2017_04_06_081325_create_profiles_table',1),(298,'2017_04_08_111403_create_module_profile_table',1),(299,'2017_04_14_134637_create_acl_profile',1),(300,'2017_04_14_134837_create_acl_module',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module_profile`
--

DROP TABLE IF EXISTS `module_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module_profile` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `profile_id` int(10) unsigned NOT NULL DEFAULT '1',
  `module_id` int(10) unsigned NOT NULL DEFAULT '1',
  `permission` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `module_profile_module_id_foreign` (`module_id`),
  KEY `module_profile_profile_id_foreign` (`profile_id`),
  CONSTRAINT `module_profile_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE,
  CONSTRAINT `module_profile_profile_id_foreign` FOREIGN KEY (`profile_id`) REFERENCES `profiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module_profile`
--

LOCK TABLES `module_profile` WRITE;
/*!40000 ALTER TABLE `module_profile` DISABLE KEYS */;
INSERT INTO `module_profile` VALUES (1,1,1,'ALL','2017-04-26 13:08:56',NULL),(2,1,2,'ALL','2017-04-26 13:08:56',NULL),(3,1,3,'ALL','2017-04-26 13:08:56',NULL),(4,1,4,'ALL','2017-04-26 13:08:56',NULL),(5,1,5,'ALL','2017-04-26 13:08:56',NULL),(6,1,6,'ALL','2017-04-26 13:08:56',NULL),(7,1,7,'ALL','2017-04-26 13:08:56',NULL),(8,1,8,'ALL','2017-04-26 13:08:56',NULL),(9,1,9,'ALL','2017-04-26 13:08:56',NULL),(10,1,10,'ALL','2017-04-26 13:08:56',NULL),(11,2,1,'create,show,edit,destroy,getitem',NULL,NULL),(12,2,2,'index,create,show,edit,destroy',NULL,NULL),(13,2,3,'index,create,show,edit,destroy',NULL,NULL),(14,2,5,'index,create,show,edit,destroy',NULL,NULL),(15,2,6,'index,create,show,edit,destroy,update_file',NULL,NULL),(16,2,7,'index,create,show,edit,destroy',NULL,NULL),(17,2,9,'index,create,show,edit,destroy,permission,resetPwd',NULL,NULL),(18,3,1,'index,create,show,edit,destroy,getitem',NULL,NULL),(19,3,3,'index,create,show,edit,destroy',NULL,NULL),(20,3,5,'index,create,show,edit,destroy',NULL,NULL),(21,3,6,'index,create,show,edit,destroy,update_file',NULL,NULL),(22,3,7,'index,show,edit',NULL,NULL),(23,3,9,'index,create,show,edit,destroy,permission,resetPwd',NULL,NULL),(24,3,2,'index,create,show,edit,destroy',NULL,NULL),(25,1,11,'ALL',NULL,NULL),(26,4,11,'index,edit,create,show,destroy,signing',NULL,NULL),(27,5,3,'index,create,show,edit,destroy',NULL,NULL),(28,5,5,'index,create,show,edit,destroy',NULL,NULL),(29,5,6,'index,create,show,edit,destroy,update_file',NULL,NULL),(30,5,7,'index,create,show,edit',NULL,NULL),(33,5,11,'index,edit,create,show,destroy,signing',NULL,NULL),(34,4,3,'index,create,show,edit',NULL,NULL);
/*!40000 ALTER TABLE `module_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module_user`
--

DROP TABLE IF EXISTS `module_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '1',
  `module_id` int(10) unsigned NOT NULL DEFAULT '1',
  `permission` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `module_user_module_id_foreign` (`module_id`),
  KEY `module_user_user_id_foreign` (`user_id`),
  CONSTRAINT `module_user_module_id_foreign` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`) ON DELETE CASCADE,
  CONSTRAINT `module_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module_user`
--

LOCK TABLES `module_user` WRITE;
/*!40000 ALTER TABLE `module_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `module_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `functions` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'fa fa-th-large',
  `isadmin` tinyint(1) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `user_id` int(10) unsigned NOT NULL,
  `order` int(10) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modules`
--

LOCK TABLES `modules` WRITE;
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
INSERT INTO `modules` VALUES (1,'ACLs','admin_acls','index,create,show,edit,destroy,getitem','fa fa-th-large',1,1,1,7,'2017-04-26 13:08:56','2017-05-24 12:32:10',NULL),(2,'Brands','admin_brands','index,create,show,edit,destroy','fa fa-th-large',1,1,1,9,'2017-04-26 13:08:56','2017-05-24 12:32:10',NULL),(3,'Clients','admin_clients','index,create,show,edit,destroy','fa fa-th-large',1,1,1,1,'2017-04-26 13:08:56','2017-05-24 12:31:16',NULL),(4,'Devices','admin_devices','index,create,show,edit,destroy','fa fa-th-large',1,0,1,8,'2017-04-26 13:08:56','2017-05-24 12:32:10',NULL),(5,'Doc Type','admin_doctypes','index,create,show,edit,destroy','fa fa-th-large',1,1,1,10,'2017-04-26 13:08:56','2017-05-24 12:32:10',NULL),(6,'Documents','admin_documents','index,create,show,edit,destroy,update_file','fa fa-th-large',1,1,1,2,'2017-04-26 13:08:56','2017-05-24 12:32:13',NULL),(7,'Locations','admin_locations','index,create,show,edit,destroy','fa fa-th-large',1,1,1,4,'2017-04-26 13:08:56','2017-05-24 12:32:10',NULL),(8,'Modules','admin_modules','index,create,show,edit,destroy','fa fa-th-large',1,1,1,11,'2017-04-26 13:08:56','2017-05-23 08:36:44',NULL),(9,'Users','admin_users','index,create,show,edit,destroy,permission,resetPwd','fa fa-th-large',1,1,1,6,'2017-04-26 13:08:56','2017-05-24 12:32:10',NULL),(10,'Profiles','admin_profiles','index,create,show,edit,destroy','fa fa-th-large',1,1,1,3,'2017-04-26 13:08:56','2017-05-24 12:32:13',NULL),(11,'Sign','sign','index,edit,create,show,destroy,signing','fa fa-th-large',0,1,1,5,'2017-04-29 19:15:35','2017-05-24 12:32:10',NULL);
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profiles`
--

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` VALUES (1,'Super Admin',1,1,'2017-04-26 13:08:56',NULL,NULL),(2,'Adm_az1',1,1,'2017-04-27 08:15:39','2017-04-27 08:15:39',NULL),(3,'adm_az2',1,1,'2017-04-27 12:34:34','2017-04-27 12:34:34',NULL),(4,'Operatore',1,1,'2017-05-03 13:15:33','2017-05-03 13:15:33',NULL),(5,'Di Viesto - ROOT',1,1,'2017-05-24 11:45:45','2017-05-24 11:45:45',NULL);
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `surname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `user_id` int(10) unsigned NOT NULL,
  `profile_id` int(10) unsigned DEFAULT NULL,
  `acl_id` int(10) unsigned DEFAULT NULL,
  `session_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `api_token` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_api_token_unique` (`api_token`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','Admin','Superadmin','admin@localhost.com','$2y$10$TXzUEpcnsOCcOBPUd6iHeem5chItOmt97C3OPLuE5PZv.2xPQDMWO',1,1,1,1,'Four9bstvSZwvLmz0jC8ofEHzFoqOMdyQBDC5mlH','IWpmkHaCZ3fyG7I4Q5cNeeheGlt0gm2UVvPm8ZWD2utRWFmYbFuxtPAqiv0M','V6FLuXrtvWWgpiAYStKqjatlxJsZ52TYhz5z2ZfSdGRUFF0sn0hNlyZTf1h6','2017-04-26 13:08:56','2017-05-24 13:43:32',NULL),(2,'admaz1','Corrado','Manara','corrado.manara@3punto6.com','$2y$10$FWG1cMy6Rd3M5sb8fzJD2eceiB2TGU6RNC0alAFoc.0.8zvmlBBia',1,1,2,NULL,'5cXwTXoUqzA3SzL2miTFgwYBHCUXGXKe7xZOvNMR','fEnhR01iYk3ocsul1TnoMrJAPle9VAIgfhCx0aHbi9AT11sqNTT1JmSO3FqD','dpEiN9SC6y4imjglAvONmuARMU626Gf7E7kdMGufm0SDXRSraMgxzbCWaAGT','2017-04-27 08:19:14','2017-05-03 11:42:46',NULL),(7,'admaz2','Amministratore','Azienda 2','ad@azienda2.it','$2y$10$oYExntE2kln3WqrmdiKRZui4TtxASB6myEBoN00tZqJv9iUi8BbNm',1,1,3,NULL,'Htsuy2U2ZGIzm2B8FU5l6CEQ9ooAhgQVdLTjUssz','VGB9cS6m3SRTUbElFcwLivsd5OW2ouYWkbtVCTNSBlYy3A4OvV2VWgZC9FI8','194vhj1GwO3f2cdL8VHnbB2Q5HS7dI47nBRTriIk1miI9WBGdeHhMDvh6Ua2','2017-04-27 12:35:11','2017-04-27 14:34:36',NULL),(9,'corrado','corrado','manara','commerciale@3punto6.it','$2y$10$gOjp8ll9CxlDKX4Ac.Z.uOjKQE6dDwzyHLgSLuvUGa..TksLkzdGi',1,1,4,NULL,'9brfpo32AuHzPE3Fj5EWLb7onpodDneqMr1MTMCh','rtUgu8Rpzss8qMMib9rw889WivE8QtMYlYnuG2cipW44cuw2SPihqUdszEfL','vIhyqQFSZzMGHhY1OuoxEkd87cviOgFjxMw4R42jjlvkwbEAeDZwACDF6qI0','2017-05-03 11:48:36','2017-05-24 13:11:07',NULL),(10,'stefy','Stefano','Scarsella','stefano.scarsella@3punto6.com','$2y$10$PHPk1q0jV4XfvUer6IFdn.77SKNvhmzLp5MUmsw9DSYKIBqTi6ACe',1,1,4,NULL,'EunHiZoetPUTVA81yVIo8JFCaDuqbgDgCWnIY0WL','VbSmdokZP54TOv7wOptFpIQTSFSPkjnBr9PedIwZgJLSnYg7LANFu5NuEnWC',NULL,'2017-05-22 14:00:16','2017-05-24 13:25:51',NULL),(11,'diviestoadm','Cristina','Di Viesto','pippo@pippi.com','$2y$10$4SuIMo96ri2KWODkQwwYz.zGkBM8I5hZoqTAIh.7aQySh0P9BywbW',1,1,5,NULL,'jagZSB7lONjTxoIMeogydjcSXrDYpDJfHM9HX85w','ItEKIoEarU83KGRcjG2eIU103botsX0W86YFOjYNlbKoPALeHSHcrL9oeVgx','2HCXVvnkLIxRYNSLKeHaY85zcBcrO4Qx4T2mO35Bc2bZ2jZM1w60a9FSO2yK','2017-05-24 11:44:32','2017-05-24 13:44:24',NULL),(12,'manu','Emanuele','Mio','pippo@pluto.it','$2y$10$eVcQb96P5w2C0Kkk7U.7l.QogzA3oehrmO9bZvptFxhkBfNBA.I8i',1,11,4,NULL,'O7SkyZz2MFlDYroU4msJxta00dEzkrawq10d0pzf','97jIujwwnpclx9fdl59tQO4fywbU8cpsW0zQIjDTiv0p9dQkQVT93W5unDqr','T4x72SSkvJqUyliczrVslf7Ct7lQfW3cpBLj3XW0MANLooEnuagd4iwc3lMH','2017-05-24 12:21:12','2017-05-24 13:00:40',NULL),(16,'andreea','Andreea','Dinu','pippo@pippi.it','$2y$10$RylfcKSZ9gAJC0BhLQMgi.0Ed.0V.J1a/bB1DPBH2fMv4CmHQu3lW',1,1,4,NULL,'BWOPAvYVj4QxP3IdopTEn2s0igP26dorwcw1Jhcf','juoMLhkdXdxLDll21wgfgSUPBIsuBjjv6INClEdoDRao6l3WFDi6OV2hiwAx','jOS5bAgLxrNZl5cXQYNtEiEsE6O0txCJPSBeBlffNZo6QIacdfcTmYHAZcmR','2017-05-24 13:28:58','2017-05-24 13:45:31',NULL);
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

-- Dump completed on 2017-05-24 19:22:25
