-- MySQL dump 10.13  Distrib 8.0.39, for Linux (x86_64)
--
-- Host: localhost    Database: jpr_website
-- ------------------------------------------------------
-- Server version	8.0.39-0ubuntu0.22.04.1

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
-- Table structure for table `activations`
--

DROP TABLE IF EXISTS `activations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `activations_email_unique` (`email`),
  UNIQUE KEY `activations_code_unique` (`code`),
  UNIQUE KEY `activations_uuid_unique` (`uuid`),
  KEY `activations_user_id_foreign` (`user_id`),
  CONSTRAINT `activations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activations`
--

LOCK TABLES `activations` WRITE;
/*!40000 ALTER TABLE `activations` DISABLE KEYS */;
/*!40000 ALTER TABLE `activations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `approvals`
--

DROP TABLE IF EXISTS `approvals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `approvals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `journal_id` bigint unsigned NOT NULL,
  `approval_status` enum('pending','in-progress','approved','declined') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `approval_comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `approvals_user_id_foreign` (`user_id`),
  KEY `approvals_journal_id_foreign` (`journal_id`),
  CONSTRAINT `approvals_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE,
  CONSTRAINT `approvals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `approvals`
--

LOCK TABLES `approvals` WRITE;
/*!40000 ALTER TABLE `approvals` DISABLE KEYS */;
/*!40000 ALTER TABLE `approvals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_uuid_unique` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Computer Science','computer-science','fa7c365f-cd98-45a5-8334-2cd11148c641',NULL,NULL,1,'2024-10-21 18:58:04','2024-10-21 18:58:04'),(2,'Mathematics','mathematics','b8c2a53d-38fd-40c6-a8f2-5a36f1874eea',NULL,NULL,1,'2024-10-21 18:58:04','2024-10-21 18:58:04'),(3,'Physics','physics','f1d52be3-cc05-4766-823d-642b60d7436a',NULL,NULL,1,'2024-10-21 18:58:04','2024-10-21 18:58:04'),(4,'Chemistry','chemistry','23c6500f-02c9-4a69-ae43-d585f623b9eb',NULL,NULL,1,'2024-10-21 18:58:04','2024-10-21 18:58:04'),(5,'Biology','biology','f626a200-8374-48df-b126-b4a264a5f74b',NULL,NULL,1,'2024-10-21 18:58:04','2024-10-21 18:58:04'),(6,'Medicine','medicine','81d95f83-f2cb-4f1c-9500-b71a916abd77',NULL,NULL,1,'2024-10-21 18:58:04','2024-10-21 18:58:04'),(7,'Engineering','engineering','3929c919-34de-43d5-ae98-cd975432e663',NULL,NULL,1,'2024-10-21 18:58:04','2024-10-21 18:58:04'),(8,'Agriculture','agriculture','782f92f5-8272-4ff3-8df6-9d23d56428f6',NULL,NULL,1,'2024-10-21 18:58:04','2024-10-21 18:58:04'),(9,'Economics','economics','24d3ff26-c0db-42e1-9b84-4bb7024eaaa4',NULL,NULL,1,'2024-10-21 18:58:04','2024-10-21 18:58:04'),(10,'Law','law','22a8e585-7c27-4e9a-a123-e68f2b62ec7d',NULL,NULL,1,'2024-10-21 18:58:04','2024-10-21 18:58:04'),(11,'Education','education','7ee8ecda-104c-44b6-8100-1bf954b7d307',NULL,NULL,1,'2024-10-21 18:58:04','2024-10-21 18:58:04'),(12,'Arts','arts','0ddda909-6567-4fa7-bed8-5929a219898a',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(13,'Social Sciences','social-sciences','f4aecaa8-7211-4eb6-9700-0bcb7107263c',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(14,'Humanities','humanities','77d1bd32-72fe-4068-9834-0eb9342f3f58',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(15,'Environmental Sciences','environmental-sciences','01cf6d0d-3359-4fac-81ec-7f20af4efef9',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(16,'Management','management','e43987b4-ca52-40ac-a05f-2997f96888f0',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(17,'Accounting','accounting','fe21c758-7dae-4b3d-b081-386d9c2827fd',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(18,'Finance','finance','eed6be24-c7d4-4020-967e-ab698d4cc039',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(19,'Marketing','marketing','3a1ff761-5fc4-4c31-a927-a538eed495c7',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(20,'Business Administration','business-administration','b93b80a3-778a-40de-86cc-490a8bc7924d',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(21,'Public Administration','public-administration','82e47459-78e6-483c-bc5e-d7de5e38f6b9',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(22,'Political Science','political-science','5c64debb-5a98-45ae-a376-d129d00acb59',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(23,'International Relations','international-relations','0a2a8f41-f736-4a2e-875e-9cbf2805d42f',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(24,'History','history','4ae1049e-d628-43f0-9035-9c4dedcd98ed',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(25,'Geography','geography','e63debf3-8bb4-4c7d-bd8e-82e4b7095abe',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(26,'Philosophy','philosophy','dd6aa90b-44ba-480b-94bc-7dc277372fcc',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(27,'Religion','religion','9e856e3c-92de-4b40-b6a1-dd27ec54450e',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(28,'Library and Information Science','library-and-information-science','9361f273-a916-4c3a-bfd5-143cda729235',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(29,'Mass Communication','mass-communication','1db38d43-94f1-4a61-a64f-927e81428101',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(30,'Psychology','psychology','597436df-a6e1-4300-a0a4-d70c0892f78f',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(31,'Sociology','sociology','f400493a-32b9-44a9-aae3-e54865650c24',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(32,'Anthropology','anthropology','4d9ed869-2b2d-4823-a5b0-30cd0d1e9b20',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(33,'Archaeology','archaeology','52c65627-0815-42ee-9d2d-b14853552d8c',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(34,'Linguistics','linguistics','aaa6f49e-d6eb-4992-aa1e-3e1cae3c244f',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(35,'Literature','literature','b3f03c98-d11e-4742-8105-a8138e19d156',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(36,'Performing Arts','performing-arts','cf60867d-43de-4e70-b21f-ec5df1bc05c3',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(37,'Visual Arts','visual-arts','6473fe31-1a1a-498b-9a2d-38b14a88198b',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(38,'Music','music','72cbbd16-d0ef-45ab-aad6-c01825dcbb01',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(39,'Film Studies','film-studies','49eaed76-712c-4ed2-b3b5-8b08d7be7501',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(40,'Dance','dance','128446a7-3bce-4029-b27b-8eb0463ad940',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(41,'Sports','sports','2ec22bbe-53b1-4699-99df-da2fb5a965b9',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(42,'Tourism','tourism','2162112a-2d52-4b30-b7d5-39e7fe43c1f8',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(43,'Hospitality','hospitality','2d724864-7cc7-4cab-b40f-e1c1b88c5b6a',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(44,'Culinary Arts','culinary-arts','89b8118e-ef73-4880-9400-247b4351dba4',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(45,'Fashion','fashion','17009855-9e3a-42ea-bb6e-037d16b7cf90',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(46,'Textile','textile','aaa9dd00-030c-4380-b996-3194db9f0d82',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(47,'Architecture','architecture','24a523a6-9d21-4c56-941d-19bec74e7011',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(48,'Urban Planning','urban-planning','f2a0a2b7-e37b-4748-89db-ec3d65d05367',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(49,'Genetic Engineering','genetic-engineering','cf44da3f-73cc-45fc-88d8-dd59077ade5b',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(50,'Industrial Engineering','industrial-engineering','05a00c4c-6904-49a2-87f7-0ebdd297540b',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(51,'Rural Planning','rural-planning','c42ef19c-34aa-42f0-ba23-b61904a0e6f2',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(52,'Transportation`','transportation','a801a5fb-3615-4cd0-aa15-fbb0a550be84',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(53,'Communication Engineering','communication-engineering','465bee9c-5eb7-47d5-9a45-e4401e8cec38',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(54,'Computer Engineering','computer-engineering','f2264451-c153-4346-8466-d19b12fc25bf',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(55,'Electrical Engineering','electrical-engineering','be1a88a4-7239-4dd5-9ca1-2ff835ee8136',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(56,'Mechanical Engineering','mechanical-engineering','ac45480c-34c4-46a7-b2aa-5a5e8a865240',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(57,'Civil Engineering','civil-engineering','f3f86a0b-777f-49ba-b80b-5731ebd307d1',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(58,'Chemical Engineering','chemical-engineering','adbe3c6a-c72f-4e91-8fa0-e581e0037c28',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(59,'Petroleum Engineering','petroleum-engineering','dd326d06-11dc-4fd2-ab1a-a787d165b9ab',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(60,'Mining Engineering','mining-engineering','8b9c0a9a-1672-4d4c-8129-796a631a1561',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(61,'Metallurgical Engineering','metallurgical-engineering','b1775512-5bde-401d-8e2b-6c2a01b88147',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(62,'Materials Engineering','materials-engineering','90ebcde6-c44e-4422-a6ff-e255f11497b7',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(63,'Biomedical Engineering','biomedical-engineering','380f79b9-71f3-4536-9c6b-b91c1143f67a',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(64,'Manufacturing Engineering','manufacturing-engineering','46def0b9-2077-42d8-b138-de945ffb8be6',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(65,'Textile Engineering','textile-engineering','f7c1cbdb-e3e6-45f9-ace9-3fa9c74f3b2c',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(66,'Aerospace Engineering','aerospace-engineering','e7ea8a04-bb6c-4b34-ad13-55e30ba48fd5',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(67,'Nuclear Engineering','nuclear-engineering','6ba7bcd1-5c4f-4e4d-99e8-aa98ddaac034',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(68,'Marine Engineering','marine-engineering','6a8fa1a9-61f0-4e34-b740-438a20eee329',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(69,'Ocean Engineering','ocean-engineering','a02cf127-7d19-4545-a089-19dd058f8f10',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(70,'Water Resources Engineering','water-resources-engineering','fd3ccd23-bfc7-403b-aaea-7fe279ea240b',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(71,'Geotechnical Engineering','geotechnical-engineering','aefdd583-1176-4df3-b98a-7fd15b037a43',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(72,'Structural Engineering','structural-engineering','36a9653f-8675-47f0-ad26-5f199195beb5',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(73,'Transportation` Engineering','transportation-engineering','c974efe2-adfd-4dbe-99e3-8135f4dc6ee0',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(74,'Surveying Engineering','surveying-engineering','451a195a-f28a-455f-a3f4-1c97833f7b77',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(75,'Urban Engineering','urban-engineering','4b7d03a5-a1f6-4d60-94d1-5f4ad9e5e602',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(76,'Regional Engineering','regional-engineering','ac404367-d2f6-4041-827e-0ad4b4b83d1b',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(77,'Rural Engineering','rural-engineering','0991822f-d18b-4f8b-8941-dac8a733dd96',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(78,'Environmental Engineering','environmental-engineering','cf1cb572-4530-4489-a13f-c5db8035ff47',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(79,'Agricultural Engineering','agricultural-engineering','2b209343-dfa8-46b8-83a6-c4fe2251efd5',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(80,'Food Engineering','food-engineering','3991c568-e13e-44f6-b246-1e6408821157',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(81,'Biological Engineering','biological-engineering','23d05890-04e9-4695-8b89-2968f158156c',NULL,NULL,1,'2024-10-21 18:58:05','2024-10-21 18:58:05');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `countries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `region_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `countries_region_id_foreign` (`region_id`),
  CONSTRAINT `countries_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `countries`
--

LOCK TABLES `countries` WRITE;
/*!40000 ALTER TABLE `countries` DISABLE KEYS */;
/*!40000 ALTER TABLE `countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dislike_journals`
--

DROP TABLE IF EXISTS `dislike_journals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `dislike_journals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `journal_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `dislike_journals_user_id_journal_id_unique` (`user_id`,`journal_id`),
  KEY `dislike_journals_journal_id_foreign` (`journal_id`),
  CONSTRAINT `dislike_journals_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE,
  CONSTRAINT `dislike_journals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dislike_journals`
--

LOCK TABLES `dislike_journals` WRITE;
/*!40000 ALTER TABLE `dislike_journals` DISABLE KEYS */;
/*!40000 ALTER TABLE `dislike_journals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal_comments`
--

DROP TABLE IF EXISTS `journal_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `journal_comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `journal_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `journal_comments_journal_id_foreign` (`journal_id`),
  KEY `journal_comments_user_id_foreign` (`user_id`),
  CONSTRAINT `journal_comments_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE,
  CONSTRAINT `journal_comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_comments`
--

LOCK TABLES `journal_comments` WRITE;
/*!40000 ALTER TABLE `journal_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `journal_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal_likes`
--

DROP TABLE IF EXISTS `journal_likes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `journal_likes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `journal_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `journal_likes_user_id_journal_id_unique` (`user_id`,`journal_id`),
  KEY `journal_likes_journal_id_foreign` (`journal_id`),
  CONSTRAINT `journal_likes_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE,
  CONSTRAINT `journal_likes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_likes`
--

LOCK TABLES `journal_likes` WRITE;
/*!40000 ALTER TABLE `journal_likes` DISABLE KEYS */;
/*!40000 ALTER TABLE `journal_likes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journals`
--

DROP TABLE IF EXISTS `journals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `journals` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `cover_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `journal_format` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `journal_language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `journal_url` longtext COLLATE utf8mb4_unicode_ci,
  `approval_status` enum('pending','in-progress','approved','declined') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_keywords` json DEFAULT NULL,
  `meta_description` longtext COLLATE utf8mb4_unicode_ci,
  `abstract` longtext COLLATE utf8mb4_unicode_ci,
  `institution` longtext COLLATE utf8mb4_unicode_ci,
  `license` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `approval_level` int NOT NULL DEFAULT '0',
  `user_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned DEFAULT NULL,
  `sub_category_id` bigint unsigned DEFAULT NULL,
  `sub_sub_category_id` bigint unsigned DEFAULT NULL,
  `created_by` json DEFAULT NULL,
  `updated_by` json DEFAULT NULL,
  `approved_by` json DEFAULT NULL,
  `approval_comments` json DEFAULT NULL,
  `reveiwers` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `journals_uuid_unique` (`uuid`),
  KEY `journals_user_id_foreign` (`user_id`),
  KEY `journals_category_id_foreign` (`category_id`),
  KEY `journals_sub_category_id_foreign` (`sub_category_id`),
  KEY `journals_sub_sub_category_id_foreign` (`sub_sub_category_id`),
  CONSTRAINT `journals_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `journals_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `journals_sub_sub_category_id_foreign` FOREIGN KEY (`sub_sub_category_id`) REFERENCES `sub_sub_categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `journals_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journals`
--

LOCK TABLES `journals` WRITE;
/*!40000 ALTER TABLE `journals` DISABLE KEYS */;
INSERT INTO `journals` VALUES (1,'Rerum est voluptatem provident doloremque omnis nulla.','Okey Wolff','et-pariatur-exercitationem-repellendus-illo','Exercitationem tempora facere cumque quaerat at sit dolores. Ut accusantium incidunt in at et. Ut ea aperiam sapiente.','https://via.placeholder.com/150',1,'4d0ce58d-7c7e-3a4f-aebe-8547e080ec6c','pdf','en','https://example.com/journal.pdf','pending','Illo inventore cumque quos molestiae est.','[\"distinctio\", \"at\", \"nostrum\"]','Ut dicta minima facere blanditiis. Odit maxime aut ullam aliquid consequatur ipsam. Vel aut tenetur doloribus ad dolore. Minima quia enim similique velit eaque repudiandae.','Non totam ipsum qui rerum. Nihil est est voluptatem eos. Dolore architecto maxime aut qui eligendi assumenda dolores.','Mann-Morar','CC BY 4.0','Nigeria',0,4,3,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(2,'Rem est reprehenderit iste doloribus.','Camden Waters','delectus-explicabo-nihil-sit-numquam-laborum-nobis-maxime','Soluta est ea non temporibus provident. Ipsam sit et rerum tempora. Ut laborum cum ut magni similique.','https://via.placeholder.com/150',1,'b586cefd-89fb-354e-8b65-f67b2a2c8536','pdf','en','https://example.com/journal.pdf','pending','Qui voluptates consequuntur non cum illum voluptates.','[\"rerum\", \"enim\", \"temporibus\"]','Illo aliquam ut beatae expedita porro. Enim id ex vero. Rem sit voluptatem quas ut. Quidem ab qui molestias sequi.','Qui cumque earum eveniet. Quasi error et quia sunt. Nisi rerum at molestiae incidunt excepturi itaque consequuntur. Dolor dolor natus dolor atque molestias velit qui.','Dicki PLC','CC BY 4.0','Nigeria',0,4,7,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(3,'Magni earum in maxime et sed.','Braden Hackett','velit-aut-harum-animi-asperiores-facere-minus','Corporis totam ullam saepe qui eaque est adipisci. Illum consequatur incidunt cumque laborum repudiandae.','https://via.placeholder.com/150',1,'a0dca7c1-336b-3385-a53c-397dd0a29a17','pdf','en','https://example.com/journal.pdf','pending','Est rerum voluptatem non sit aut.','[\"ab\", \"quas\", \"explicabo\"]','Adipisci debitis maxime vel dolores. Quibusdam dicta et amet. Rerum quisquam necessitatibus vitae et recusandae consequatur itaque illo.','Aliquid veritatis molestiae non quos officia est. Accusantium ducimus debitis incidunt labore molestiae tempora. Enim quia facilis et quae voluptas accusantium.','Schoen and Sons','CC BY 4.0','Nigeria',0,4,6,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(4,'In dignissimos est repellat nihil eaque non.','Dr. Laurence Koelpin','reprehenderit-molestias-odit-officiis-aut-sunt-error-earum','Doloribus saepe voluptas sed nisi minima aut. Earum sed laboriosam blanditiis.','https://via.placeholder.com/150',1,'2a1773ec-e8a5-373d-872a-633c4448739b','pdf','en','https://example.com/journal.pdf','pending','Praesentium recusandae quasi soluta.','[\"occaecati\", \"molestiae\", \"incidunt\"]','Quis aut odio molestiae eveniet laborum autem repudiandae. Quas deserunt ea eius corrupti sit animi iure. Aliquam dolor minus sit doloribus. Nesciunt minima voluptatum libero.','Veritatis dolorem et a. Excepturi eaque est assumenda eum ab explicabo corrupti. Qui voluptas possimus eius perferendis.','Prohaska Inc','CC BY 4.0','Nigeria',0,4,4,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(5,'Sequi voluptatem dolor voluptatibus tempora voluptas iusto error laborum.','Rachelle Hermiston','quia-accusamus-quos-architecto-magnam-sint-error','Laudantium eum voluptatem sunt quis. Ullam est reiciendis quae cupiditate. Ducimus quis quisquam rem repudiandae officia.','https://via.placeholder.com/150',1,'ea17a7db-9e6b-3982-b2a1-a35fb3116332','pdf','en','https://example.com/journal.pdf','pending','Eum voluptatum et ullam recusandae ducimus.','[\"dolorem\", \"explicabo\", \"est\"]','Perspiciatis pariatur ab sunt recusandae nostrum asperiores vel. Doloribus explicabo eum deserunt quae. Nihil ea nostrum eius ut et sit. Alias aut tenetur aut et.','Est ratione cupiditate dignissimos labore laudantium quas laudantium. Enim quas qui maiores et sit. Enim harum eveniet vero autem deleniti et repellat.','Bogan Group','CC BY 4.0','Nigeria',0,4,3,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(6,'Dolor voluptas ea tempora ex.','Aubree Lehner','suscipit-cum-sit-est-illo-pariatur','Dolores dolor et nihil ducimus. Et aut non culpa nihil repudiandae. Officiis esse natus ut sapiente magnam eos. Sed et unde sit molestias exercitationem nesciunt dolores nam. Dolores tempora voluptas tempore quo corrupti occaecati.','https://via.placeholder.com/150',1,'e178becb-4e25-369c-bea6-3b8cc130fc23','pdf','en','https://example.com/journal.pdf','pending','Beatae rerum nihil at sit.','[\"nam\", \"ipsa\", \"accusamus\"]','In tenetur molestiae natus nihil omnis maiores qui ipsam. Blanditiis sed vel dolor similique quo corporis. Deserunt veniam sit nobis. Expedita error ut omnis dolor minus.','Neque aut excepturi culpa porro autem quos. Minima sit sit minus at. Cum aut id similique in provident. Ut quos sint nisi ut ex.','Witting and Sons','CC BY 4.0','Nigeria',0,4,8,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(7,'A consectetur iste dolor quo dolor laudantium sed.','Eloise Ebert','et-voluptas-eum-ut-aspernatur-beatae','Sit voluptas officia vitae architecto est laborum maiores. Cum beatae impedit ullam vel. Quis qui blanditiis rerum officia sint accusamus harum.','https://via.placeholder.com/150',1,'5164d361-f632-33b3-a63a-9d7f1b46d2d7','pdf','en','https://example.com/journal.pdf','pending','Aut consequatur excepturi aliquam natus optio pariatur reiciendis.','[\"unde\", \"qui\", \"voluptas\"]','Rerum et excepturi totam. Quae commodi autem enim et dicta quo ut.','Ratione aut velit nemo ut facilis nobis inventore. Cupiditate ipsam doloremque vel a eum in et. Eum atque at consequatur. Eum magnam aut minima possimus.','Legros, Kuphal and Beier','CC BY 4.0','Nigeria',0,4,1,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(8,'Repellendus qui est rerum hic debitis consequuntur aut.','Mr. Gordon D\'Amore MD','ut-sit-magnam-est','Dolorem magnam provident tempora ipsa at voluptatum. Iusto voluptates dolorem temporibus debitis necessitatibus. Sit est et voluptas non reprehenderit unde quos. Nihil impedit est ratione odit laudantium est.','https://via.placeholder.com/150',1,'d5257ef4-c481-3820-937a-544e0230535a','pdf','en','https://example.com/journal.pdf','pending','Dolor debitis et veniam qui cupiditate illo.','[\"voluptatem\", \"velit\", \"sint\"]','Qui autem aut dolorem expedita qui vitae qui. Dolorem vel quo provident autem maiores. Soluta ea doloribus eum officiis iste.','Ipsam molestiae vel repellat sint voluptatem et. Illo alias voluptates culpa deserunt esse rem. Ut ipsum eum eum provident aut modi maxime.','Heaney, Von and Breitenberg','CC BY 4.0','Nigeria',0,4,2,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(9,'Id rerum omnis omnis est reprehenderit error est.','Helena Schumm','voluptas-debitis-delectus-molestias-et','Quis corrupti qui eum neque. Assumenda tenetur eum nulla ab non. Ad aspernatur rerum ex fuga eos.','https://via.placeholder.com/150',1,'d6f1692a-9621-3e31-b613-d4f682b03dda','pdf','en','https://example.com/journal.pdf','pending','Magnam et praesentium rerum dolorem.','[\"tenetur\", \"rerum\", \"quisquam\"]','Iure dolor nihil quia rerum non nisi. Ut blanditiis eligendi voluptatem dolor et et. Illum non eum quia eos nam.','Minus voluptatem nam commodi earum quas rerum. Eos neque quisquam quo assumenda. Architecto esse rem atque.','Stehr, Williamson and Barrows','CC BY 4.0','Nigeria',0,4,8,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(10,'Natus nulla in quis dolorum ipsum.','Carmen Lockman','numquam-similique-blanditiis-tempora-voluptas-quidem-odio','Sunt odit quo quasi dolores. Ad exercitationem officia ut quam magni officia et aut.','https://via.placeholder.com/150',1,'c89651a9-1193-39d8-9abf-12314153879e','pdf','en','https://example.com/journal.pdf','pending','Sunt repellendus incidunt in suscipit.','[\"ut\", \"odio\", \"nam\"]','At id vero pariatur laudantium quae. Eos quis voluptatibus dolor repellat quam quo. Aspernatur ad laudantium illo nihil aut sit impedit molestiae. Repudiandae laborum officia dolor ea aperiam autem sapiente.','Quod itaque aspernatur omnis sapiente nihil temporibus. Labore distinctio eum dolore explicabo quod architecto. Magni et quibusdam eaque id quasi. Sed cum molestias odit vel repudiandae enim.','Schowalter-Grady','CC BY 4.0','Nigeria',0,4,3,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(11,'Natus consequuntur sit voluptatem architecto.','Skylar Jenkins','occaecati-voluptatum-omnis-a-possimus-voluptatem-optio-vel','Amet expedita qui reiciendis minus. Explicabo fuga est enim temporibus. Omnis eum ipsam quasi. Nemo architecto voluptas laboriosam est maxime ut sint.','https://via.placeholder.com/150',1,'69d714d9-58be-37b3-bb70-b8fcf815010b','pdf','en','https://example.com/journal.pdf','pending','Accusamus dolorum et sed aut.','[\"ut\", \"saepe\", \"aut\"]','Porro assumenda inventore ad delectus illum in aut. Dolore porro quibusdam et et voluptatum possimus enim. Quos quia pariatur expedita doloribus itaque sed perferendis.','Sequi ea alias sit maiores quasi. Beatae minus sint rerum cum. Enim quia tempore necessitatibus est sunt aspernatur.','Windler and Sons','CC BY 4.0','Nigeria',0,4,2,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(12,'Quidem culpa natus doloribus adipisci libero sint at.','Greyson Bartell','quidem-quaerat-minima-at-consequatur-nemo-voluptate-tempore','Eos reiciendis id aliquam ut cupiditate explicabo voluptatibus. Totam recusandae quia soluta fugiat totam enim tempora. Repellat repellendus quis veniam harum est eum ut in. Sed saepe consequatur ipsam ipsa ex.','https://via.placeholder.com/150',1,'6b3d0a46-8d7e-30eb-8f6c-c39bc4fe88eb','pdf','en','https://example.com/journal.pdf','pending','Tempora aspernatur aut nemo nobis.','[\"illo\", \"dolorem\", \"debitis\"]','Quo eveniet veniam corrupti est rerum nobis. Officia vitae rem reiciendis sint illum ad dicta voluptas. Quis quos exercitationem aliquam reiciendis ex qui. Autem nemo id est sint.','Qui recusandae illum cupiditate voluptatem fuga magnam autem. Quia sunt iste eveniet dolorem asperiores. Dolorem molestiae asperiores sed unde. Velit qui doloribus enim nemo facere. Quo accusantium sint ea repudiandae aspernatur eos magni.','Tremblay, Larson and Beer','CC BY 4.0','Nigeria',0,4,6,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(13,'Cumque voluptas sed necessitatibus.','Prof. Imelda Rowe Sr.','ea-sit-consequatur-praesentium-qui-nisi-incidunt-rerum-dignissimos','Ea voluptatem ut non error. A veniam veritatis sit temporibus voluptatem vel eaque. Natus soluta quisquam mollitia dignissimos quasi nobis aliquam quam.','https://via.placeholder.com/150',1,'0b897da1-4c24-3f3f-8e9f-2f589771fe25','pdf','en','https://example.com/journal.pdf','pending','Totam eius unde dicta quam sequi est placeat.','[\"dolor\", \"est\", \"magnam\"]','Quis omnis deleniti nihil voluptas. Nihil vitae quo aut quo provident libero iure. Iusto eaque molestias quia quaerat quasi distinctio aut. Recusandae qui tempore blanditiis nisi dicta est ratione. Et voluptatem consectetur nisi et aperiam est.','Reiciendis quae ducimus ut alias. Consequatur quis sed officia qui distinctio. Consequatur recusandae iste repellat nihil eum. Voluptate magnam est quia omnis ut totam aut placeat.','Schimmel-Dicki','CC BY 4.0','Nigeria',0,4,5,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(14,'Aut minus sit qui.','Arlo Bradtke Sr.','ut-eum-a-reprehenderit-facilis-et-eius','Quasi distinctio aperiam quasi doloremque et numquam minima. Cupiditate doloremque sint exercitationem.','https://via.placeholder.com/150',1,'a350e4dd-2907-3fa8-9fa7-cdca619247a4','pdf','en','https://example.com/journal.pdf','pending','Aperiam sequi eum fugit similique cupiditate nesciunt totam.','[\"voluptas\", \"reprehenderit\", \"fugiat\"]','Autem aspernatur nobis sit aut possimus. Est optio sit dolore pariatur iure ut. Illo pariatur reiciendis magni dolorem cupiditate alias voluptatem quasi. Corrupti officiis optio dolore consequatur.','Provident similique placeat est quidem et earum veniam at. Et libero nesciunt enim saepe sed. Maxime itaque beatae omnis deserunt dolor labore dolorum. Consequatur modi vel maiores voluptas deleniti. Et explicabo corporis et aliquam dolores.','Rutherford Ltd','CC BY 4.0','Nigeria',0,4,3,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(15,'Enim sapiente optio magnam placeat sit veniam adipisci.','Brice Wehner','voluptate-dolorem-repudiandae-et-illum-nam-omnis-perferendis','Nemo aut rerum non nam pariatur repellat. Dolore voluptatibus occaecati nam aperiam enim eius explicabo. Ipsa saepe et nesciunt asperiores porro voluptatibus.','https://via.placeholder.com/150',1,'22c2b3a1-a290-3d93-8633-a24fa545a255','pdf','en','https://example.com/journal.pdf','pending','Aut ipsum et eius est sed.','[\"saepe\", \"et\", \"asperiores\"]','Dignissimos iusto omnis dolorum molestias et aut quae. Cumque labore aut qui laboriosam. Iusto voluptas tempora ipsa sed laudantium quis. Veritatis eligendi incidunt rem minima aut commodi.','Et quibusdam nostrum saepe ducimus sint est iste. Aliquid voluptatem provident minima corporis quia a laborum rerum. Eaque blanditiis rerum ratione ad. In tempora et iste nihil neque veniam quo.','Waters Group','CC BY 4.0','Nigeria',0,4,10,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(16,'Quia ut dolore magni itaque qui eum.','Cristian Stroman','voluptatem-earum-amet-sit-nulla','Nisi ut velit quia quo. Autem deserunt saepe nihil quas quibusdam voluptate.','https://via.placeholder.com/150',1,'b1e0a6db-403b-3bf3-a005-41b1a58659c0','pdf','en','https://example.com/journal.pdf','pending','Vitae distinctio consequatur deleniti voluptate.','[\"dolor\", \"corrupti\", \"alias\"]','Magni provident esse et et eos quod suscipit. Et culpa dolor omnis quae quisquam. Molestias sunt alias sint dolor modi ut.','Labore aut quia consequatur. Ratione aut id dolorum.','Hand-Pollich','CC BY 4.0','Nigeria',0,4,6,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(17,'Quia minima aut libero qui amet in.','Zella Kovacek','inventore-quidem-explicabo-veritatis','Saepe quisquam esse rerum quis quis sit quibusdam eum. Vitae ut unde quaerat consequatur. Quis et nemo consequatur neque magni maiores reiciendis. Et fugiat itaque temporibus deserunt illum.','https://via.placeholder.com/150',1,'7dbed8fb-d70b-3829-9b70-145d2986c40c','pdf','en','https://example.com/journal.pdf','pending','Fuga voluptas qui quaerat quia animi et at aut.','[\"omnis\", \"eveniet\", \"nam\"]','Magnam harum nam facere facere laudantium dolorum iste id. In consequuntur in a blanditiis. Esse quae et eum et est et consequuntur. Odit rerum totam et iusto quis eos est quibusdam.','Vel vel qui placeat ad quidem dignissimos iste. Quos reprehenderit ducimus nostrum sed magni porro quia. Et amet aspernatur optio tempora.','Waelchi, Nolan and Auer','CC BY 4.0','Nigeria',0,4,3,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(18,'Sed non saepe quod aut libero.','Julianne Pollich V','voluptatem-omnis-pariatur-rem-voluptates-aut-consequatur','Odit quia iste doloribus ut ex perferendis enim. Laboriosam magni et consequatur sed fuga fugit. Nemo adipisci eligendi adipisci consectetur. Aut ut molestiae dolorem voluptatem omnis ullam.','https://via.placeholder.com/150',1,'4057ea83-bd39-3e0a-9a19-808c047b75cd','pdf','en','https://example.com/journal.pdf','pending','Voluptatem et voluptatem omnis eveniet dolor magni.','[\"a\", \"ad\", \"quia\"]','Perferendis mollitia ipsa sunt quos asperiores sed officiis repudiandae. Expedita nostrum mollitia alias qui modi eos dolores animi. Provident enim dolores explicabo.','Qui eos voluptas repellat corrupti. Distinctio eveniet consequatur aut suscipit. Est maxime laudantium occaecati labore laboriosam voluptas itaque. Accusamus ut asperiores doloribus sed enim.','Dietrich-Crist','CC BY 4.0','Nigeria',0,4,8,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(19,'Consequuntur hic voluptatem voluptatem similique consequuntur ratione.','Danielle Bernhard','neque-rerum-corporis-eum-praesentium-et-nihil-blanditiis-voluptatem','Iste sed voluptates facilis praesentium tempore ratione molestias quia. Recusandae laborum distinctio veritatis omnis nulla molestiae voluptatem. Molestiae officiis repudiandae voluptatem architecto est. Maiores animi officiis nisi a et perferendis impedit.','https://via.placeholder.com/150',1,'f2ed69e2-202f-3e78-b702-2fe50fc9f066','pdf','en','https://example.com/journal.pdf','pending','Minus eveniet aut autem repellendus.','[\"labore\", \"repellendus\", \"officiis\"]','Tenetur explicabo maxime accusantium at enim non eaque. Quia dolores omnis et provident voluptates rerum non harum. Ut eligendi esse rerum repellendus dolorem ullam aspernatur. Qui consequuntur ullam nesciunt optio asperiores repellat dolor.','Molestiae quis omnis doloribus totam deleniti aperiam. Id et et optio. Odit reprehenderit doloremque consequuntur suscipit iste.','Vandervort PLC','CC BY 4.0','Nigeria',0,4,2,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(20,'Quasi quia magnam labore sed quae.','Destinee Rice','vero-aperiam-ullam-distinctio-quis-asperiores','Sunt officia voluptatem veritatis ea architecto blanditiis quia numquam. Nobis nobis quis sunt quia. Unde fuga tempore delectus repellendus. Quod nulla id eligendi necessitatibus reprehenderit doloribus.','https://via.placeholder.com/150',1,'ca29ffc6-bc9b-38ff-9b7b-b7e3c5dab269','pdf','en','https://example.com/journal.pdf','pending','Vel rerum doloremque a tempora debitis.','[\"modi\", \"doloribus\", \"et\"]','Blanditiis tempora ut culpa. Nobis laboriosam recusandae quidem qui autem enim nihil. Delectus quia quisquam aut et. Qui dolorem iure aperiam officia impedit.','Rerum quam soluta nobis iusto. Et eum et repellendus non saepe. Quaerat voluptatem atque itaque rerum possimus magni nam.','Ruecker, Beier and Walter','CC BY 4.0','Nigeria',0,4,3,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(21,'Nihil veniam quo impedit incidunt.','Carmel Mraz','neque-aut-culpa-aut-asperiores','Quibusdam vero unde laborum ea ab error eos. Qui similique suscipit placeat quia qui ullam. Voluptatum nulla ullam sapiente illo praesentium corporis non. Id delectus unde laudantium.','https://via.placeholder.com/150',1,'8b4327f4-1afd-30c8-ae78-8637820354a2','pdf','en','https://example.com/journal.pdf','pending','Error sit excepturi error repellendus nesciunt itaque totam.','[\"maxime\", \"dolor\", \"expedita\"]','Explicabo et dolorem aut sit maiores quo fugit in. Voluptates similique ducimus tenetur maiores deleniti qui voluptatibus. Amet dolores vel rerum ut.','Amet rerum rerum minima incidunt eum rem et. Debitis aliquam maxime quia ad aut dignissimos omnis. Iusto et illum tenetur nostrum quia sed facilis. Eum aliquam error recusandae nulla.','Beahan Inc','CC BY 4.0','Nigeria',0,4,1,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(22,'Dignissimos quia accusamus eos et.','Kamren Lind','dolore-ut-quos-velit-incidunt-iure','Repudiandae voluptas iusto esse qui sit earum dicta. Occaecati pariatur ut rerum amet.','https://via.placeholder.com/150',1,'fe5b3cf1-97a4-3d37-9c44-b3ffbc9f03ce','pdf','en','https://example.com/journal.pdf','pending','Corrupti deleniti totam totam.','[\"recusandae\", \"cumque\", \"veritatis\"]','Sapiente eum voluptas cum consequuntur temporibus. Maiores alias recusandae sed molestiae quas aliquam reprehenderit. Explicabo numquam quo accusamus facere voluptatem occaecati eveniet. Et harum sequi modi ut.','Et quos voluptates similique nulla nulla libero laudantium. Nostrum a qui veniam ipsam nihil et iusto. Laborum non provident id odio molestiae. Non quos corporis odio recusandae quis libero.','Kuvalis Ltd','CC BY 4.0','Nigeria',0,4,8,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(23,'Quae facere sed eum exercitationem eaque consequatur.','Kiana Armstrong','omnis-ex-reiciendis-minus-a','Doloremque ipsum quidem rerum aspernatur consequatur. Aut mollitia iure incidunt commodi id harum.','https://via.placeholder.com/150',1,'f6087957-911e-3f61-86d3-da414c9d7c7a','pdf','en','https://example.com/journal.pdf','pending','Vel neque dolores voluptatem et sit qui.','[\"itaque\", \"quia\", \"magnam\"]','Hic id excepturi assumenda occaecati placeat. Numquam neque qui explicabo delectus itaque et est exercitationem.','Quas aut aut placeat culpa iste. Aut et illum aliquid ut distinctio qui dolorem. Quas aliquid error sapiente qui id hic asperiores.','Daugherty-McCullough','CC BY 4.0','Nigeria',0,4,3,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(24,'Officia asperiores aut esse necessitatibus voluptas quas.','Rocio Weimann','velit-atque-laboriosam-ipsum-aut-quis-laboriosam-eligendi','Provident tempora voluptas atque est delectus neque molestiae. Ut qui dolor harum. Iure consequatur dolor omnis ipsum aperiam quia omnis.','https://via.placeholder.com/150',1,'83543106-cf1e-355e-9462-4cecd37fe484','pdf','en','https://example.com/journal.pdf','pending','Quia ut quia at dolorum impedit hic aliquam.','[\"dignissimos\", \"ab\", \"deserunt\"]','Quae sed dignissimos ut nisi libero neque. Animi maiores rerum eveniet doloremque. Sit vitae possimus sapiente quam distinctio alias. Ratione et reprehenderit amet et quia dolore.','In fugiat necessitatibus reprehenderit blanditiis. Veritatis voluptatum omnis asperiores sint aut voluptatem. At ea est laborum nostrum est sed. Aut quos delectus praesentium consequatur fugit.','Harris-Fritsch','CC BY 4.0','Nigeria',0,4,9,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(25,'Ut ut quo voluptatem earum libero id.','Myrtie Buckridge','illum-alias-praesentium-vitae-ut-et','Ratione qui et earum omnis ut. Voluptatem illum vero qui ullam. Aut aliquid sed consectetur.','https://via.placeholder.com/150',1,'3a033a25-2653-36a8-bcb8-45d79cbea13a','pdf','en','https://example.com/journal.pdf','pending','Error rem vel et numquam rerum deleniti dolorem.','[\"quibusdam\", \"harum\", \"blanditiis\"]','Ea magnam quia ipsum quia officiis fugit quam. Consequatur laboriosam et praesentium excepturi. Hic eligendi esse ut est omnis.','Eveniet facilis ratione quia dolores est vel. Adipisci eum quibusdam repellendus natus odit. Maxime beatae laboriosam dicta veritatis. Odio fugit voluptatem omnis iste consequatur ex debitis consequatur.','Jast Inc','CC BY 4.0','Nigeria',0,4,6,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(26,'Ipsum aut odio quia tempora voluptatem illum ducimus.','Johnny Cremin','nihil-et-nesciunt-hic','Ut placeat modi quam temporibus sed dolores. Aliquid soluta dolore quisquam facere delectus qui. Dolorem magni ullam qui qui.','https://via.placeholder.com/150',1,'617e450d-319f-3777-b4fe-e6d19cb3dd15','pdf','en','https://example.com/journal.pdf','pending','Autem aut in dolores ratione voluptas.','[\"atque\", \"est\", \"tempore\"]','Quas eos deserunt deserunt doloremque qui saepe. Repellat perspiciatis nobis harum ex dolores. Dicta dolores et dolor ut magnam voluptas dolores.','Et quibusdam libero ut nemo esse vel nisi. Aut est explicabo nulla libero quas dignissimos expedita voluptatem. Sit aut nostrum quasi maiores est. Esse voluptatem qui nihil voluptatum aut.','Bartell-Schumm','CC BY 4.0','Nigeria',0,4,5,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(27,'Sapiente sapiente nihil odit nobis.','Marilou Howell','quam-deserunt-dignissimos-id-nam','In quos ut eum et. Animi et quae natus et et molestiae et delectus. Vel autem voluptatem fugiat qui et. Voluptate quibusdam est doloribus suscipit sequi.','https://via.placeholder.com/150',1,'c00af80d-8820-3189-bfc4-25d9d3261367','pdf','en','https://example.com/journal.pdf','pending','Rerum cupiditate rem incidunt harum architecto dolores sit.','[\"non\", \"quis\", \"suscipit\"]','Commodi qui accusantium fuga vitae quidem tempora. Enim maiores eius velit enim. Distinctio quasi in fugiat amet dolor veniam et quam. Ut enim fugiat deleniti ipsum nihil odit.','Perferendis soluta praesentium beatae est ullam. Ducimus repellat enim saepe architecto quis debitis voluptatum. Ut officia reprehenderit corrupti ut culpa reprehenderit sint nostrum. Repellat asperiores sit quo nemo sit.','Hirthe Inc','CC BY 4.0','Nigeria',0,4,3,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(28,'Qui et et exercitationem quod aliquam iste reiciendis.','Ms. Ramona Metz III','officiis-inventore-repudiandae-aut','Aspernatur itaque neque minus nisi consectetur. Dolorum iste velit nihil impedit molestiae alias. Corporis quaerat inventore quidem. Dolorem repellat iste ut aliquam.','https://via.placeholder.com/150',1,'f8ad3935-ea8c-3e4a-8ba2-7c5f9a788a8d','pdf','en','https://example.com/journal.pdf','pending','Assumenda corporis iusto rerum tempore recusandae aliquid laborum quis.','[\"eos\", \"quis\", \"vero\"]','Deleniti qui iure sint consequatur explicabo enim nihil. Voluptatem odio et et aut non. Voluptatem incidunt et consequatur dicta. Consequatur sit omnis velit enim facere.','Laudantium molestiae voluptate placeat illo. Quidem commodi eveniet nulla cupiditate natus.','Lakin-Heidenreich','CC BY 4.0','Nigeria',0,4,10,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(29,'Nemo laborum totam qui non consequatur sunt.','Prof. Emelia Balistreri I','in-molestias-in-numquam-recusandae-corrupti','Ex asperiores incidunt sit ex nesciunt nam qui. Sint provident rem accusantium et ea. Blanditiis alias consectetur consectetur sequi sapiente repellat.','https://via.placeholder.com/150',1,'a71a5d5c-8a9c-3fdc-9319-adaf3170d22c','pdf','en','https://example.com/journal.pdf','pending','Nesciunt asperiores non quasi aperiam labore quis ratione.','[\"rerum\", \"iste\", \"voluptas\"]','Voluptatem et libero quaerat et voluptas dolore. Magni omnis voluptatem consequuntur provident nihil. Voluptas nam magni nulla aliquid sint qui sequi. Animi nobis quos dolorem soluta non quis molestiae qui. Earum neque beatae ad quisquam quis nihil tenetur et.','Deserunt facilis eius iusto asperiores. Eveniet consequatur reprehenderit repudiandae totam quos ratione.','Mann Inc','CC BY 4.0','Nigeria',0,4,6,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(30,'Quia expedita similique fugiat velit aut laboriosam.','Prof. Vita Jones','dignissimos-expedita-ipsum-quo-rerum-voluptatum','Laudantium error laborum dolor dolorem ipsa id. Ex qui qui veniam quaerat accusamus laudantium voluptatem. Nobis quidem explicabo et est necessitatibus. Vitae soluta qui labore et sed maiores sapiente.','https://via.placeholder.com/150',1,'0fa502f5-c25c-3010-b549-4bf24ec327ce','pdf','en','https://example.com/journal.pdf','pending','Saepe ullam dolorem est voluptatum iusto.','[\"sequi\", \"nisi\", \"quia\"]','Nostrum quo ratione rerum rerum omnis ut. Veritatis aut dolorum sit ad consequatur. Cupiditate qui nulla dolor perspiciatis.','Sint consequuntur exercitationem aperiam ratione omnis enim. Eveniet eos eum porro animi sed nulla. Impedit magnam esse consequatur doloribus laborum nulla. Sit maiores dolores ducimus.','Block Group','CC BY 4.0','Nigeria',0,4,7,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(31,'Autem aut ipsum ea molestiae qui.','Mr. Emmitt Senger PhD','ipsa-aut-et-ut-sed-qui-est-tempora','Amet enim ipsa aut voluptatem et provident. Illo minima est commodi expedita. Dicta ut esse nobis officia qui. Quibusdam eligendi quasi enim quia quia aut ut.','https://via.placeholder.com/150',1,'926f710a-d6a9-3dae-9719-e2969a2cf1c5','pdf','en','https://example.com/journal.pdf','pending','Sit laudantium error modi hic asperiores necessitatibus nobis.','[\"ea\", \"id\", \"saepe\"]','Repellat dolores hic nisi et corporis. Dolorem atque aspernatur ratione dolorem temporibus qui. Reprehenderit perspiciatis distinctio unde molestiae quam repellat. Officiis veritatis est ipsum.','Et id perspiciatis animi nostrum dolores ea. Ea omnis distinctio totam occaecati aliquid.','Fadel-Rau','CC BY 4.0','Nigeria',0,4,1,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(32,'Hic quia explicabo sint voluptatem.','Teresa Gerhold','in-non-accusantium-adipisci-alias-cum','Expedita sapiente repellendus fugit ut. Maiores similique voluptatem voluptatibus. Velit consequatur optio voluptatibus aliquid placeat. Sunt asperiores quam architecto voluptatem eos id perferendis.','https://via.placeholder.com/150',1,'88d9ff23-a3d9-385b-ac70-3755245c6905','pdf','en','https://example.com/journal.pdf','pending','Totam explicabo at ullam similique reiciendis sunt delectus.','[\"voluptates\", \"quia\", \"nihil\"]','Quod soluta velit pariatur. Est rem perspiciatis laborum fugit. Eveniet reiciendis voluptatibus quam illo cum cupiditate.','Odit inventore omnis aut sit ea labore. Itaque aut molestiae sit fugiat est odio impedit. Sit enim eos rerum facilis cum libero qui.','Williamson Ltd','CC BY 4.0','Nigeria',0,4,9,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(33,'Voluptatem at eum est.','Novella Schroeder','voluptatem-dolores-iste-reiciendis-iusto-quia-nemo-ratione','Quia consectetur eligendi quia enim. Illum nesciunt deleniti temporibus doloribus ut magni. Minus id ab sit incidunt et.','https://via.placeholder.com/150',1,'7ad3dc2c-030e-36db-9643-a4387d76ca03','pdf','en','https://example.com/journal.pdf','pending','In molestias veritatis consequatur fugit eos.','[\"dolorum\", \"ullam\", \"accusamus\"]','Maiores dolorem inventore voluptas. Et aperiam sit cupiditate id inventore expedita nihil. Beatae omnis error error voluptatum et unde. Facere a aut harum tempore fugiat.','Dolorum recusandae earum molestiae voluptas consequuntur. Veritatis dolore itaque fuga enim magnam qui modi tempora. Occaecati et provident aut quo eaque. Qui ullam accusantium ipsa sed molestiae.','Wunsch-Farrell','CC BY 4.0','Nigeria',0,4,6,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(34,'Quia doloribus nesciunt optio tempora eos rerum exercitationem.','Prof. Caitlyn VonRueden Sr.','iure-asperiores-praesentium-voluptatem-fugiat-qui','Reiciendis tempora possimus rerum quidem corrupti hic nulla. Quidem numquam dolor consequuntur fugiat dolor tempore. Modi labore aperiam laborum debitis. Similique tempore deleniti omnis voluptatum.','https://via.placeholder.com/150',1,'87337c47-56ed-3bd1-b89a-16ba1ac92df5','pdf','en','https://example.com/journal.pdf','pending','Ut sint eos ut est numquam incidunt.','[\"consequatur\", \"ut\", \"saepe\"]','Assumenda fugiat suscipit excepturi repudiandae vel ipsa voluptas. Perspiciatis et dolores ut nulla expedita ratione. Eius sunt quo aut et a.','Et cumque dolorum quo non consequatur. Voluptas minima omnis reiciendis. Non cum voluptates et enim.','Denesik-Gerlach','CC BY 4.0','Nigeria',0,4,6,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(35,'Nam similique natus beatae eveniet odio.','Miss Jessica Renner III','sunt-vitae-voluptatem-omnis-voluptatem-inventore-aut','Ut cumque magni alias quam ducimus eum dolorem. Unde quod nesciunt laborum molestias sint sunt quidem. Ullam ratione necessitatibus dignissimos incidunt omnis.','https://via.placeholder.com/150',1,'2c263c42-36dc-3040-82bc-854fb67101e2','pdf','en','https://example.com/journal.pdf','pending','Modi et ut quis perspiciatis hic dicta tenetur.','[\"et\", \"dolor\", \"doloribus\"]','Et quia corrupti id qui. Vel eligendi aut fugiat sint. Dolorem voluptas enim veniam impedit minima aliquid aliquid.','Illum inventore ducimus voluptatem nobis sit. Qui autem atque fuga. Cum et officia voluptas et. Molestiae maxime voluptatibus quis voluptatem molestiae.','Trantow and Sons','CC BY 4.0','Nigeria',0,4,10,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(36,'Odio illo magni suscipit rerum.','Emmanuel Weber','quam-debitis-facere-enim-sit-nihil-veritatis-qui','Earum nemo animi et neque. Assumenda est sit ipsam provident. Et quibusdam accusamus quia reprehenderit sunt repellendus.','https://via.placeholder.com/150',1,'b3d56928-ed02-38fa-98dd-d115dc4133db','pdf','en','https://example.com/journal.pdf','pending','Odio minima aliquam sint laboriosam voluptatibus et perferendis.','[\"omnis\", \"omnis\", \"earum\"]','Suscipit rerum quo eos sint. Ipsum corporis tempore reprehenderit voluptatem eum quasi tempore. Tempore quo nihil molestiae architecto aut quae impedit. Impedit minus consequuntur fuga consectetur illum.','Rerum praesentium aut non vel. Possimus ea deleniti vero dolorem et cupiditate. Earum est officiis sed atque eum. Quia laudantium amet labore impedit ratione.','Cormier-Ruecker','CC BY 4.0','Nigeria',0,4,4,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(37,'Et autem occaecati tempora corporis eius dolores.','Margarett Schmeler','quasi-debitis-porro-dolores','Aut culpa doloremque ut ea. Quis rerum rerum aperiam voluptatem harum nulla. Maxime fugit nisi et et. Maxime sunt consequatur magnam eius error sunt quia. Sint aspernatur eos voluptatem natus deserunt ipsa.','https://via.placeholder.com/150',1,'9ff825ca-0e1c-3bd1-b23b-5794beb39680','pdf','en','https://example.com/journal.pdf','pending','Aliquam sit temporibus repellat fugit minima rem aperiam.','[\"sed\", \"beatae\", \"eos\"]','Culpa repellat tempora magnam consequatur maxime ad dolor. Facilis ut labore est amet.','Omnis reiciendis ipsa non sit error. Culpa nisi est ab assumenda minus totam rerum magnam. Sed non sunt perspiciatis velit inventore non. Sint voluptates porro rem laborum enim.','Hickle Inc','CC BY 4.0','Nigeria',0,4,10,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(38,'Ut et eaque possimus quidem repudiandae aut eligendi.','Maria Jerde','ea-qui-doloremque-libero-sit-soluta','Ex et nesciunt sed qui illum. Ut voluptas labore distinctio. Aut quia dolorem deleniti occaecati ut.','https://via.placeholder.com/150',1,'e3dfe2cb-19fd-384f-9758-923a625e5ac1','pdf','en','https://example.com/journal.pdf','pending','Qui qui ad hic dolorum.','[\"et\", \"fugiat\", \"nostrum\"]','Impedit vel earum inventore et ad. Et perferendis voluptatem et accusamus rerum mollitia. Ducimus repellat consequatur consequuntur rem numquam a est. Autem minima ea quidem illo hic iste.','Ullam in repellendus dolorum itaque officiis nihil rerum. Eum corrupti laborum consequatur dolorem omnis qui blanditiis. Laboriosam aut nam dolorem qui est est.','Lindgren Group','CC BY 4.0','Nigeria',0,4,7,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08'),(39,'Aut officiis dolorum consequatur architecto placeat architecto consectetur.','Ryder Lind','consectetur-dolore-repellendus-sit-deserunt-aliquid-exercitationem','Consectetur ut ex dolorem dolore autem vero omnis. Dolorem rem earum adipisci fugiat consequuntur sapiente.','https://via.placeholder.com/150',1,'d5df3ca6-a819-3620-8037-71739c98d7a3','pdf','en','https://example.com/journal.pdf','pending','Similique ut odio quisquam fuga.','[\"magnam\", \"necessitatibus\", \"aut\"]','Architecto dolores doloremque quis tenetur quis nulla sit. Fugiat voluptate non ut non rerum sint. Cupiditate ut delectus est velit. Non enim qui qui sed laudantium consequatur provident aut.','Sint sunt ea deleniti. Quasi asperiores et esse aut minus. A consequatur dolor ipsa accusamus. Tempore dolore nulla eveniet esse.','Turner Ltd','CC BY 4.0','Nigeria',0,4,2,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(40,'Voluptas natus molestiae illum.','Einar Hegmann','perferendis-tempora-voluptatibus-consequatur-soluta-rerum-explicabo-repudiandae','Quo consequuntur distinctio voluptatibus inventore. Nostrum exercitationem rerum vel facere natus alias voluptates. Quia iusto hic tenetur laboriosam repellendus aliquam numquam inventore. Blanditiis eum nemo ipsam ut ratione voluptates soluta.','https://via.placeholder.com/150',1,'8dcadfc5-f17b-3dc0-a6ce-b56a7dfb5d29','pdf','en','https://example.com/journal.pdf','pending','Rem mollitia architecto consequatur repudiandae eum autem.','[\"odio\", \"repellendus\", \"maxime\"]','Inventore assumenda ea ut cum et. Est reprehenderit vero alias eaque placeat eos velit. Unde veniam optio beatae exercitationem perferendis.','Dolores quia velit rerum ut. Quod molestiae tempore qui consequatur. Eum aut vel aut qui sint natus.','Streich and Sons','CC BY 4.0','Nigeria',0,4,5,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(41,'Esse pariatur unde exercitationem deleniti quia.','Domingo Trantow','repellat-tenetur-iure-quia-facere-eos-necessitatibus-nemo-laboriosam','Dolorum sunt natus ut. Omnis architecto odio error quasi excepturi. Dolorum id veritatis quo earum. Repellendus nostrum eos est dicta alias ipsum nihil.','https://via.placeholder.com/150',1,'73830494-b688-30aa-a241-93379bb6a306','pdf','en','https://example.com/journal.pdf','pending','Ab iure sapiente necessitatibus in expedita et.','[\"velit\", \"sit\", \"et\"]','Sed vel architecto cumque. In et perspiciatis explicabo modi laborum enim. Adipisci consequatur natus error et voluptatem dolorum facere pariatur. Nam porro iure delectus id.','Et iure quisquam nihil vel omnis dolores laborum. Laboriosam laborum et dicta provident ut ut qui. Facere alias consectetur in omnis vero aspernatur dolor.','Kreiger Ltd','CC BY 4.0','Nigeria',0,4,6,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(42,'Corrupti optio et error qui.','Noe Larson','consequatur-perferendis-velit-ut-et-cumque-nostrum-blanditiis','Ratione deserunt aut suscipit quae. Enim sit molestiae non numquam ut sed. Neque architecto quo suscipit et ea eaque est. Eum voluptatem quia minus excepturi.','https://via.placeholder.com/150',1,'3d8cad86-af60-34cf-9f39-d6939a2c2813','pdf','en','https://example.com/journal.pdf','pending','Quibusdam eos aut deleniti.','[\"aut\", \"minima\", \"et\"]','Ut aperiam dolor dolor omnis. Autem voluptate qui et ullam a quibusdam. Aperiam odit vel voluptatum et et praesentium.','Repellat omnis cupiditate odit eum. Nulla rerum ut consequuntur vitae. Hic enim excepturi et totam consequatur. Qui temporibus nihil facilis quos.','Hahn Inc','CC BY 4.0','Nigeria',0,4,9,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(43,'Ad rerum necessitatibus amet aut rerum.','Bartholome Lebsack','assumenda-similique-ut-quidem-qui','Ad et molestias quis rerum rerum est veniam. Rerum quidem fugiat ut. Repudiandae qui optio quia non aut voluptatem odit. Quam ea exercitationem suscipit aut aut sit vel.','https://via.placeholder.com/150',1,'9f4f46aa-dd5e-31fd-b94a-1be7413ba896','pdf','en','https://example.com/journal.pdf','pending','Quidem quisquam nulla nam qui nostrum temporibus mollitia quisquam.','[\"ea\", \"ut\", \"illum\"]','Eligendi sed veritatis cupiditate in. Provident corporis similique nulla esse excepturi. Voluptas cum quia qui minima voluptates fugit ea. Dicta quaerat excepturi iste ut unde consequatur.','Quo neque iure voluptatem illo qui voluptas. Sint est necessitatibus vitae at atque. Corrupti possimus vel rerum quis architecto beatae quae. Quae accusantium dolores autem in.','Bednar LLC','CC BY 4.0','Nigeria',0,4,6,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(44,'Repellendus delectus et provident dolor perspiciatis est qui.','Mr. Brannon Hodkiewicz','et-blanditiis-ut-ratione-qui-quia','Quo et modi qui suscipit nulla. Quis ea dolorem odit modi odio ea vel.','https://via.placeholder.com/150',1,'e0100306-84c1-3b47-9b9f-b738e8c3da2d','pdf','en','https://example.com/journal.pdf','pending','Nihil sequi saepe repellendus aut quod.','[\"laboriosam\", \"illo\", \"reprehenderit\"]','Quia recusandae omnis qui et aut. Sint quo necessitatibus voluptates hic. Consectetur quisquam officiis excepturi enim ut ea. Dolor assumenda id molestias atque. Nihil ipsum expedita excepturi.','Accusamus hic quos qui nobis libero ut dolorem. Dicta qui repellat minima enim officiis officia. Dolor cupiditate delectus harum dolor explicabo.','Tremblay PLC','CC BY 4.0','Nigeria',0,4,5,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(45,'Dignissimos accusantium eius rerum fugiat qui.','Kamren Renner','ut-quaerat-fuga-quis-sed-neque-odit-omnis','Aspernatur sit quo similique ut. In nemo sapiente quasi non. Aperiam a reiciendis itaque in voluptas quibusdam.','https://via.placeholder.com/150',1,'25796640-d2da-3d87-b8ed-2c55d34ab58d','pdf','en','https://example.com/journal.pdf','pending','Accusamus qui non sit explicabo qui.','[\"dolor\", \"voluptatem\", \"dolores\"]','Nam officiis voluptas ut maxime non cumque sunt. Et aliquam voluptatem doloremque voluptatum. Porro qui impedit totam a omnis consequuntur.','Illo modi dolorem error aliquid veritatis aut. Ea dolor incidunt alias sed ut tempore. Dolorem ab qui error.','Beer, Kerluke and King','CC BY 4.0','Nigeria',0,4,6,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(46,'Rem ipsa voluptatem et et.','Ara Bins','nihil-dolorem-facere-omnis-deleniti-cum-vitae','Quos magni aut explicabo ut neque. Sit quas ipsa eos. Eos tempora nam et ut itaque quis. Doloremque sit voluptatem ratione excepturi omnis reiciendis. Nostrum et ipsum odit enim sed.','https://via.placeholder.com/150',1,'2af61da8-529c-34ca-b245-0a39eecbc091','pdf','en','https://example.com/journal.pdf','pending','Rerum in aut eum nihil.','[\"temporibus\", \"dolorem\", \"est\"]','Vitae minus sint sequi est ut doloribus tenetur. Inventore omnis sed aut in. Asperiores odio perferendis laudantium odio et accusantium.','Error distinctio doloribus culpa voluptas. Et nesciunt accusamus sed. Et corrupti fugit qui molestias voluptas.','O\'Reilly-Feeney','CC BY 4.0','Nigeria',0,4,9,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(47,'Omnis consequatur in voluptatibus eaque.','Turner Fritsch','molestiae-occaecati-voluptatem-facere','Occaecati est magnam molestiae molestiae a. Inventore est rerum vitae. Sed deserunt amet quo dolorum rerum optio. Et officiis fugiat vel dicta et soluta.','https://via.placeholder.com/150',1,'5f222344-dcde-35f5-86ae-f2011e6d557a','pdf','en','https://example.com/journal.pdf','pending','Non quaerat est deserunt repellat.','[\"ut\", \"est\", \"magnam\"]','Dolores fugiat amet corporis. Asperiores quas nihil eum sed ut accusamus aliquid. Dolores eum qui modi natus amet minus rerum.','Molestiae eos ut veritatis eum. Excepturi praesentium debitis nihil ut facilis facere. Nam blanditiis quod et cupiditate inventore. Aliquid accusamus eligendi eos minima eveniet accusamus tempora.','Schaden and Sons','CC BY 4.0','Nigeria',0,4,6,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(48,'Omnis commodi praesentium laboriosam.','Nils Rempel DVM','dolorum-quia-quam-provident-natus-eos-ex-sed-consectetur','Suscipit illo voluptates magnam facere. Debitis ut saepe blanditiis id. Laborum sit vel quia repudiandae qui. Sint ut eos hic ut qui eum.','https://via.placeholder.com/150',1,'1a24800a-dcf7-397b-9f27-9d877b7f0503','pdf','en','https://example.com/journal.pdf','pending','Ipsam voluptatum est nesciunt incidunt id aut sed.','[\"expedita\", \"culpa\", \"nulla\"]','Explicabo possimus commodi facere aliquam sunt. Sed aut exercitationem vel dolores ut dolorem. Facilis ullam molestiae reiciendis autem ut ullam impedit.','Accusamus quisquam facere temporibus est doloremque debitis quaerat. Quam ex quia ex recusandae itaque quia provident expedita. Voluptatem sed molestiae officia quae quam molestiae ut cumque. Deleniti vel numquam nam inventore. Vero magnam et quia.','Kulas-Mayert','CC BY 4.0','Nigeria',0,4,4,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(49,'Rerum veniam ipsam doloribus et.','Dominic Heidenreich','corporis-dignissimos-sint-est-quia-asperiores-excepturi','Maxime veritatis autem veniam voluptatem quaerat adipisci. Dolorem ut nostrum aliquid ex cumque cupiditate aperiam. Sunt voluptas quidem nostrum eos beatae eligendi.','https://via.placeholder.com/150',1,'631365b7-5b0e-3aeb-86de-8e66649d9400','pdf','en','https://example.com/journal.pdf','pending','Distinctio quae non aliquid.','[\"et\", \"est\", \"tempore\"]','Exercitationem non quidem dolores repudiandae est assumenda modi est. Inventore inventore et nam molestiae adipisci. Quidem nostrum rerum error blanditiis.','Dolorum provident vel quos quibusdam exercitationem molestiae ea. Quidem magni ut minus qui qui voluptates. Tenetur natus voluptas placeat molestiae odit est. Soluta molestiae aliquid et odit quidem eveniet.','Zboncak, Rath and Nader','CC BY 4.0','Nigeria',0,4,4,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(50,'Enim autem ullam nostrum repellat nobis omnis ipsa.','Jeramie Klein','necessitatibus-iure-officiis-nihil-nisi','Nobis consequatur rerum sunt qui quidem itaque est. Earum totam qui consequatur eum quas. Enim laborum sunt aliquid excepturi. Dolores sed commodi voluptatem est perferendis magnam enim quam.','https://via.placeholder.com/150',1,'798f9470-619f-3b4c-b979-91bc46ee68d1','pdf','en','https://example.com/journal.pdf','pending','Doloremque nisi voluptatem sit deserunt.','[\"quia\", \"error\", \"quis\"]','Porro possimus molestias sint adipisci sapiente dolores est. Error eum praesentium aliquid. Eius nam asperiores rem et est assumenda explicabo.','Enim quo consequatur voluptatem fugiat. Illo voluptatem occaecati numquam error aperiam mollitia sed. Deleniti voluptates harum ut provident.','Marquardt LLC','CC BY 4.0','Nigeria',0,4,5,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(51,'Velit deserunt aut nihil omnis.','Prof. Joel McClure DVM','ut-eum-ex-necessitatibus-et-qui','Consequatur officia asperiores molestiae nisi amet dolores labore quis. Et quas dolor aut eveniet porro nihil voluptatem. Amet iste quo minus quibusdam error porro eaque. Quos dolores aut aut id.','https://via.placeholder.com/150',1,'1f799483-c5ce-37fc-b070-275d2cd4c6eb','pdf','en','https://example.com/journal.pdf','pending','Omnis rerum sed qui et.','[\"adipisci\", \"ad\", \"consequatur\"]','Voluptatem sint est nostrum dolorem commodi. Ullam eligendi et dolor illum quia ut. Ab dolorem facilis earum placeat veritatis et.','Omnis voluptatem nam non sequi. Repellat ea quo in saepe amet quo. In ipsa repellendus unde enim.','Mitchell LLC','CC BY 4.0','Nigeria',0,4,1,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(52,'Placeat odio voluptatem officiis vel minus.','Elwin Cummerata','est-tempore-aperiam-distinctio','Dolorum aspernatur eos minima sed est eum eum. Rerum sit voluptas libero quis quas assumenda doloremque. Dicta voluptas voluptate rem non omnis itaque est. Autem molestiae et ut soluta quia quibusdam.','https://via.placeholder.com/150',1,'c4d67050-8363-352f-b030-8403c5db0acb','pdf','en','https://example.com/journal.pdf','pending','Neque et dolor veniam aperiam perferendis enim repellendus.','[\"amet\", \"dolor\", \"itaque\"]','Et nostrum ab ab nam. Qui ut ad eum et consequatur sed labore. Ut veritatis dicta dolore omnis perspiciatis. Qui et maiores beatae sunt.','Accusamus odit beatae accusantium assumenda. Voluptas qui quaerat est. Voluptas ut quo nemo recusandae nobis. Provident labore accusantium aut quo odio explicabo nihil tempore. Rem non laborum est blanditiis quidem sapiente.','Kreiger LLC','CC BY 4.0','Nigeria',0,4,3,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(53,'Culpa expedita accusamus beatae culpa et sed deleniti reprehenderit.','Richard Wunsch','consequatur-ex-labore-et-numquam-qui-iure','Et et aut nobis consequuntur. Architecto impedit ut doloribus veritatis. Voluptas provident cupiditate ea quis voluptate.','https://via.placeholder.com/150',1,'34640e19-69da-3f7b-a413-a85616de309c','pdf','en','https://example.com/journal.pdf','pending','Dolorem tempore et error earum odio eligendi.','[\"omnis\", \"minus\", \"sapiente\"]','Possimus incidunt voluptas est atque qui voluptatum. Qui occaecati fuga id recusandae tempora. Sequi et rerum dolor nemo ut quos.','Sit nulla sequi reiciendis. Et et velit quia voluptatibus vel. Earum blanditiis omnis sint nostrum quae et culpa commodi.','Lang, Kuhic and Spencer','CC BY 4.0','Nigeria',0,4,4,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(54,'Quia laborum accusantium eos similique enim.','Miss Lyla Stehr Jr.','error-omnis-facilis-aut-reiciendis-nulla-iste-laborum','Et odit ex esse rerum. Consequatur similique architecto dolorum animi. Eum consequatur laborum dolorem iure incidunt rerum.','https://via.placeholder.com/150',1,'72517fa0-7c84-3cd4-8614-4679527ba0c8','pdf','en','https://example.com/journal.pdf','pending','Id in dicta sit iusto porro dolores sint.','[\"hic\", \"non\", \"sed\"]','Autem dolores aspernatur quam autem. Accusantium sit esse voluptate ex aut et. Distinctio aut ab praesentium suscipit.','Eos sunt qui unde sunt. Id blanditiis illo corrupti. Dolore incidunt occaecati sit.','Leffler, Paucek and Larson','CC BY 4.0','Nigeria',0,4,1,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(55,'Ut molestiae omnis maiores quo.','Alvis Dooley','deleniti-quidem-ratione-eum-maiores-eveniet-earum-accusamus','Eum provident hic veritatis ducimus dolorem molestiae. Amet eveniet qui veritatis quasi quo iste explicabo. Voluptatum optio consectetur qui molestias accusantium.','https://via.placeholder.com/150',1,'97999d48-74e3-3152-83a4-de7dfdea26e1','pdf','en','https://example.com/journal.pdf','pending','Neque ad velit voluptatem magni.','[\"alias\", \"dolorum\", \"explicabo\"]','Qui autem voluptas amet. Est autem error doloribus animi.','Mollitia minus omnis non similique ducimus quam. Sit quia repellat accusantium quam voluptatem quia nulla. Provident porro officia eos aut harum. Commodi placeat debitis optio qui. Sunt eum cupiditate quibusdam eum ut vel possimus.','Pacocha-Ledner','CC BY 4.0','Nigeria',0,4,8,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(56,'Aut facere est nemo nobis.','Miss Patricia Stoltenberg','autem-ipsum-rerum-dolor-dolorem-blanditiis-quo-dolore-amet','Adipisci itaque quas voluptatem ratione autem at. Animi neque at facere eos voluptates praesentium. Molestias et aut sunt et iure doloribus temporibus. Enim id porro consequatur voluptatibus ipsum.','https://via.placeholder.com/150',1,'947b5d4b-39f7-3942-9147-2827234ad691','pdf','en','https://example.com/journal.pdf','pending','Sequi autem asperiores recusandae et enim dolore voluptatem.','[\"et\", \"veniam\", \"odio\"]','Veritatis omnis suscipit dignissimos et minus impedit aut rerum. Omnis molestiae aut at. Rem quam corrupti maxime aut. Mollitia in dolorum culpa delectus rerum est.','Sed veritatis officia quia quidem placeat debitis. Voluptas est sequi ut. Sit ea voluptas consectetur qui nobis. Eos dicta voluptatem expedita aut laudantium est. Dolorem aut voluptates incidunt cumque ut nisi iure.','Auer Inc','CC BY 4.0','Nigeria',0,4,10,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(57,'Inventore reprehenderit consequatur aut necessitatibus perspiciatis voluptas ad omnis.','Prof. Nigel Vandervort MD','praesentium-beatae-ea-et-cum','Vitae dolor minus magnam deleniti. Veritatis earum eligendi dicta sint assumenda. Aperiam ea reprehenderit qui qui voluptatem voluptatum repellendus. Quam velit consectetur rem dolores molestiae laudantium.','https://via.placeholder.com/150',1,'739056d4-e3a6-36dd-bc19-35b9e077514c','pdf','en','https://example.com/journal.pdf','pending','Repudiandae nesciunt in et reprehenderit.','[\"qui\", \"quia\", \"sit\"]','Voluptatem debitis explicabo voluptas. Amet sed at adipisci dolorem excepturi. Neque alias autem et a et consequatur.','Voluptatibus inventore eius rerum ut sapiente illum. Deserunt ut sed quis eaque. Voluptas voluptatum sunt vel sunt.','Bins, Schowalter and Rau','CC BY 4.0','Nigeria',0,4,1,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(58,'Quos ratione corporis quia quia quia.','Cielo Schoen','eos-neque-et-laborum-incidunt-doloremque-aliquid-occaecati','Dignissimos qui odio accusamus alias necessitatibus. Beatae deleniti deleniti facere vel placeat et. Ea libero qui rerum et voluptatem distinctio. Et optio sunt quia facere eius. Eaque et ratione aut odit nihil.','https://via.placeholder.com/150',1,'e5519826-30f7-31d8-8dac-ceda7da39582','pdf','en','https://example.com/journal.pdf','pending','Esse laudantium animi ratione ipsam molestiae.','[\"saepe\", \"dignissimos\", \"vero\"]','Atque neque nemo voluptates nemo enim a. Iusto quos totam est nobis voluptatibus. Et similique voluptatibus nam perspiciatis mollitia ut reiciendis.','Sint ratione rerum inventore suscipit rerum. Magnam numquam et ut explicabo. Qui unde doloremque fuga dolor ea eum consequatur. Est ad voluptas facilis omnis accusamus.','Fritsch-Gleichner','CC BY 4.0','Nigeria',0,4,4,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(59,'Blanditiis sed occaecati culpa aperiam voluptate molestiae vel.','Carlos Jacobi','adipisci-sunt-adipisci-voluptas-nam-qui-blanditiis-et','Sint ut porro magni nihil totam at officia. Recusandae minima soluta voluptatem qui accusantium.','https://via.placeholder.com/150',1,'f2663c7c-65c4-341c-82da-0e3d4131d681','pdf','en','https://example.com/journal.pdf','pending','Aliquid aut qui perferendis qui.','[\"totam\", \"dignissimos\", \"ex\"]','Rem ut sit aut dolor harum non. Est at iste ab rerum aspernatur aliquam atque. Voluptatum sequi et laudantium et iusto consectetur voluptatem.','Officia ut eius quis. Illo consequuntur consequatur mollitia. Reiciendis error quae praesentium alias veritatis reprehenderit impedit.','Boyer-Davis','CC BY 4.0','Nigeria',0,4,8,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(60,'Amet fugit molestiae quos quis architecto ea excepturi.','Violet Ward Jr.','et-nihil-cum-distinctio-illo-consequatur-nihil-est','Nam aut minus aut vel enim provident voluptatem occaecati. Aliquam exercitationem harum adipisci accusamus aut facilis. Autem ad dolore atque inventore.','https://via.placeholder.com/150',1,'a1579e37-c47d-33ab-a706-b1ce5d9552b3','pdf','en','https://example.com/journal.pdf','pending','Officia error minus qui dicta aut.','[\"similique\", \"assumenda\", \"veniam\"]','Est dolorem autem placeat. Occaecati iure tempore fugiat laborum a. Molestias perferendis ipsa aliquid sapiente.','Voluptatem ipsum facilis autem at a. Et perspiciatis dolore dolorem libero ut voluptate fuga ab. Tenetur omnis aut harum maiores aut itaque. Harum hic et asperiores velit et.','Gibson-Powlowski','CC BY 4.0','Nigeria',0,4,6,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(61,'Beatae ea corporis laborum voluptas nam fuga earum.','Dr. Lacy Lemke','aut-nisi-fugiat-libero-qui-ratione','Earum tempore ducimus atque iure quaerat repellat. Aperiam aut dolorem repellat voluptatem fugit. Error dolor pariatur nam est quo vitae.','https://via.placeholder.com/150',1,'675085f9-06db-3494-9c82-4e11436b037b','pdf','en','https://example.com/journal.pdf','pending','Quaerat sunt qui ullam non facere ratione.','[\"repudiandae\", \"inventore\", \"quas\"]','Repellat alias laudantium eos et veritatis quam. Exercitationem cum perspiciatis accusamus sunt animi repellat perspiciatis. Quam repellendus qui ut quas aut odio cumque. Numquam atque at quis consectetur fuga quia.','Velit distinctio perferendis velit nihil. Nisi nihil aut voluptatum labore nihil autem quaerat. Maiores ipsam doloremque blanditiis ea architecto quae.','Pagac, Mosciski and Bahringer','CC BY 4.0','Nigeria',0,4,4,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(62,'Voluptates esse ipsum est odio fugiat et velit reprehenderit.','Citlalli Batz','error-esse-aut-vero','Ut magnam quis et sint molestias. Totam velit praesentium nihil rerum voluptate quo. Quibusdam quia incidunt cumque iusto delectus. Laboriosam officiis dolore maiores aliquam laudantium distinctio blanditiis. Blanditiis quod voluptatibus quam quos ratione voluptatum expedita.','https://via.placeholder.com/150',1,'76870b09-21b9-3477-983e-1d133adbfce7','pdf','en','https://example.com/journal.pdf','pending','Neque sequi tenetur qui deserunt odio.','[\"quos\", \"omnis\", \"corporis\"]','Deserunt incidunt repellat aut nam doloribus. Quam dignissimos explicabo deserunt quos.','Et laboriosam et eos itaque temporibus. Excepturi cum esse magnam molestiae quia. Harum fugiat et consequatur cum nisi inventore eveniet. Veritatis aut architecto voluptatem fuga odio facere.','Torphy Group','CC BY 4.0','Nigeria',0,4,7,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(63,'Magnam alias pariatur voluptatum libero.','Travon Abbott DVM','quia-quae-tempore-quia-omnis-qui','Tempore odit et illum. Non necessitatibus id quis doloribus ea suscipit enim. Iste vel et provident dolorem non et. Quam quae dicta vero inventore.','https://via.placeholder.com/150',1,'5df3aee2-1651-3d13-9e3b-63e88d9d5252','pdf','en','https://example.com/journal.pdf','pending','Dolor rerum autem porro quod vitae nostrum.','[\"beatae\", \"doloremque\", \"optio\"]','Qui placeat dolores sit dignissimos omnis et eum. Neque ad numquam doloremque. Quia aut ipsam magnam in quae enim ea. Consequatur saepe ut odit assumenda adipisci fuga rerum a.','Ea ipsum id consequatur sed. Rem aliquam sed temporibus iste neque ullam. Ea esse enim possimus totam nisi cupiditate autem. Est qui ad est tempora quia maxime.','Reinger, Pouros and Schimmel','CC BY 4.0','Nigeria',0,4,5,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(64,'Omnis quos molestiae vel ipsum qui.','Prof. Laurel Gleichner','quaerat-sit-neque-sed-deserunt-aut-dolores','Ipsam atque veritatis aperiam nam reprehenderit sequi a odit. Illo blanditiis voluptatum eos sapiente corporis et. Officia sit dignissimos explicabo fuga voluptatem reiciendis est. Exercitationem aut voluptatem incidunt architecto saepe enim.','https://via.placeholder.com/150',1,'0ebf428e-bc28-3ad3-a2fc-713360b48a2d','pdf','en','https://example.com/journal.pdf','pending','Ut nesciunt architecto aut et sint omnis.','[\"quam\", \"sunt\", \"et\"]','Debitis in quo magni occaecati fuga. Sed aut voluptatem ad. Aut dolor molestiae ut dolorum non deleniti iusto. Et a unde consequuntur sit saepe et.','Quidem qui asperiores commodi hic perspiciatis. Culpa et impedit omnis animi eligendi ad et. Blanditiis ipsum odit excepturi et et. Eum soluta enim temporibus veniam.','Rutherford Inc','CC BY 4.0','Nigeria',0,4,3,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(65,'Earum dolorem est possimus.','Carolina Pacocha','est-aliquam-animi-non-eligendi','Est non in aut hic voluptas. Nostrum non ad ut dolorem minima harum sint blanditiis. Iusto qui impedit repudiandae harum quaerat cupiditate autem.','https://via.placeholder.com/150',1,'78f19073-fbe8-32f9-aa8a-709da2e110a2','pdf','en','https://example.com/journal.pdf','pending','Sequi autem ut incidunt architecto.','[\"veritatis\", \"at\", \"nisi\"]','Aliquid voluptatem quasi voluptate maxime. Eius voluptate qui ut sint non qui est voluptatem. Minima et asperiores aut sunt et et. Sint libero libero nihil ut nam delectus quo.','Quia non quia occaecati consequatur quis eum delectus. Repudiandae repellat perferendis voluptatem magnam dolorum porro fugiat. Enim ut numquam non quaerat nisi.','Halvorson LLC','CC BY 4.0','Nigeria',0,4,2,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(66,'Nulla sit asperiores quidem blanditiis omnis.','Aimee Hodkiewicz','id-rem-eaque-adipisci-ut-nihil-sint-fugit','Eum nostrum quo earum cum. Aut blanditiis quo beatae voluptate repudiandae laboriosam et. Atque maxime illo neque dolor ut provident vero.','https://via.placeholder.com/150',1,'123feae9-e33f-36a6-b523-7b09f70b94a9','pdf','en','https://example.com/journal.pdf','pending','Deserunt sed sunt placeat esse quia ea.','[\"autem\", \"optio\", \"ut\"]','Impedit minima quia fugit. Magnam nulla totam omnis enim iure illum esse. Illo esse aut voluptate voluptas rerum dolores quia. Ut eaque asperiores officiis reiciendis maxime eaque corporis amet.','Autem velit officiis iure architecto voluptas. Sed vel explicabo voluptatem quos vero. Explicabo pariatur sed soluta ducimus dolor itaque sit sunt. Animi reprehenderit ut recusandae ut.','Klocko LLC','CC BY 4.0','Nigeria',0,4,10,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(67,'Pariatur et ut tempore hic explicabo et delectus.','Jessie Dooley V','laborum-illum-est-sequi-quos','Libero aperiam ducimus deleniti libero debitis in quibusdam. Dolor distinctio dolorem ut illo. Est est quis accusamus illum accusamus ut cum ipsam. Dolor architecto quibusdam atque.','https://via.placeholder.com/150',1,'d958d641-8dc8-3166-8b6d-5ddc6fe39af4','pdf','en','https://example.com/journal.pdf','pending','Qui omnis dolor expedita ut est quis.','[\"ea\", \"nulla\", \"sequi\"]','Consequatur non sed rerum enim ipsam. Et voluptatum culpa sunt placeat vero veritatis natus placeat. Laboriosam repudiandae reiciendis iure aspernatur.','Enim ut odio consequatur dolor adipisci. Minima ipsa optio omnis pariatur. Tenetur dignissimos eius voluptate perspiciatis.','Little-Rolfson','CC BY 4.0','Nigeria',0,4,1,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(68,'Iste ratione saepe temporibus doloremque recusandae explicabo modi natus.','Mr. Elton Schneider','commodi-vel-et-voluptas','Velit iste velit inventore vel et adipisci et. Eos libero velit perspiciatis eum aut maiores. Vel corrupti dicta quo velit. Et molestiae natus reiciendis in et consequatur.','https://via.placeholder.com/150',1,'70fc25f5-1148-328a-95b6-7145910d55be','pdf','en','https://example.com/journal.pdf','pending','Itaque aut explicabo quia molestias praesentium culpa.','[\"quidem\", \"consectetur\", \"eos\"]','Impedit culpa est quaerat consequuntur doloribus dolor qui quis. Eum sint ex rem reprehenderit est soluta distinctio. Qui voluptatem dolores alias nam.','Harum veniam aut modi quibusdam voluptatem. Ut consequatur hic natus reiciendis eos eum. Modi modi soluta eum voluptas sit.','Bartell and Sons','CC BY 4.0','Nigeria',0,4,7,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(69,'Tempore rerum vel hic.','Lynn Bradtke','consequuntur-eaque-recusandae-possimus-impedit-ut-molestias-nihil-nemo','Dicta dolorem ipsum enim unde atque ex. Voluptas dicta ut ipsa. Libero asperiores odit asperiores in. Dolor deleniti illum doloribus fugit.','https://via.placeholder.com/150',1,'8af08a1f-22b7-3afa-bf04-7546787c7bb2','pdf','en','https://example.com/journal.pdf','pending','Nobis quis non et velit qui doloribus at nam.','[\"deleniti\", \"itaque\", \"ex\"]','Et corrupti neque qui nulla ut. Ea animi id unde illum voluptas optio aliquam. Explicabo doloremque dolore et et. Est aut corrupti dolores beatae.','Et repellendus minus voluptates repellendus tempora ad aut magnam. Modi numquam tempora totam minus quia. Quo placeat quas ea. Architecto aut occaecati tempora nemo dolorem.','Spinka LLC','CC BY 4.0','Nigeria',0,4,1,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(70,'Non et magni quia eaque.','Dr. Reginald Mills III','eum-ut-quis-aut-voluptatem-necessitatibus-vel-sit-qui','Eum omnis sed explicabo. In cumque sapiente quibusdam corrupti voluptate. Quia repellat ut voluptas et.','https://via.placeholder.com/150',1,'604f30ab-0b2f-39e6-b3e4-949a8b3c2a1a','pdf','en','https://example.com/journal.pdf','pending','Laudantium laboriosam molestiae debitis natus inventore odio.','[\"vitae\", \"reprehenderit\", \"aut\"]','Nostrum et error id eos numquam reprehenderit ullam quo. Ut aut totam autem qui quidem incidunt laborum. Tempore fugit qui distinctio velit provident quam. Eius voluptas ut accusamus dolor quaerat omnis dolor ipsa.','Impedit molestiae quia ex suscipit nihil et. Illum voluptatem aliquam qui eum labore quia aliquam veniam. Voluptate assumenda fugiat beatae quis architecto occaecati.','Rice and Sons','CC BY 4.0','Nigeria',0,4,9,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(71,'Et molestiae impedit iure autem sint aspernatur veritatis.','Hazel Larkin','laudantium-at-ut-sit','Numquam corrupti est quibusdam consectetur ut ipsa. Sed soluta sit tenetur debitis iure doloremque quidem. Voluptates autem porro voluptates cumque non. Et et minima et deserunt eos. Provident dicta quia asperiores eos non.','https://via.placeholder.com/150',1,'0875cd91-2f7d-3885-b736-a645f299d6c6','pdf','en','https://example.com/journal.pdf','pending','Maiores sunt neque possimus sint sed incidunt assumenda non.','[\"magnam\", \"fuga\", \"expedita\"]','Saepe aspernatur aperiam amet eum minus illum magnam. Est velit ratione facilis sequi in aliquam. Nostrum et commodi at ex ut. Quia a quis ducimus eveniet.','Perspiciatis temporibus illo itaque. Distinctio voluptas consectetur ipsa molestiae et illum deserunt. Molestiae rerum quia dolore odio. Consequuntur rerum delectus omnis nihil ab eveniet.','Swift PLC','CC BY 4.0','Nigeria',0,4,3,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(72,'Voluptates consequuntur expedita sint et.','Mary Howe','perspiciatis-et-consequuntur-doloribus-eligendi-numquam-eaque-molestiae-impedit','Qui porro sapiente nisi ut aut sit qui. Culpa omnis pariatur mollitia asperiores consequatur natus. Earum enim tenetur molestiae. Vel iste ut ullam fugit est vero.','https://via.placeholder.com/150',1,'345c54f9-302c-3aa6-b926-a9aa50adac13','pdf','en','https://example.com/journal.pdf','pending','Nemo dolor quas rem possimus.','[\"temporibus\", \"quam\", \"accusamus\"]','Cumque porro soluta rerum. Qui maiores molestias facere aut unde cum aut nisi. Molestias cumque hic minus veniam magnam. Dolor reprehenderit enim saepe quasi.','Magnam sit consequuntur nesciunt vitae tempore. Quasi cupiditate sunt accusantium dolorem minus sequi velit nihil. Dolorum repellat qui eos laborum adipisci nam consequatur. Laudantium est eveniet rerum aut. Hic rerum minus rerum ut dolores et impedit.','Hahn, Tillman and Grimes','CC BY 4.0','Nigeria',0,4,9,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(73,'Sequi perspiciatis vitae omnis ea occaecati optio quia commodi.','Lavina Koelpin','hic-assumenda-maiores-voluptatem-vero-ullam-vel','Dignissimos totam facere dolor doloremque eaque modi. Rerum tempora et est. Sed ab eligendi et sunt illum. Occaecati in aut sequi unde quam reprehenderit voluptatem eius. Voluptas repellendus qui non non.','https://via.placeholder.com/150',1,'9fb96a6c-5ac9-340c-b212-f598819cc1eb','pdf','en','https://example.com/journal.pdf','pending','Ut soluta repellat est nihil porro occaecati commodi.','[\"laborum\", \"delectus\", \"facilis\"]','Est ut aut voluptate quo. Reiciendis dignissimos ut quidem et nostrum temporibus ut. Quo voluptas voluptatem aut provident qui voluptas.','Quam quaerat eos consequuntur ratione. Aut aut labore non cumque. Neque nobis ut adipisci omnis et quae fugiat.','Jakubowski Inc','CC BY 4.0','Nigeria',0,4,10,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(74,'Tempora necessitatibus quia sint pariatur consequatur consequatur maiores.','Fritz VonRueden','harum-excepturi-cumque-molestiae-sed','Architecto qui est ex laboriosam vero quod provident. Itaque et consequatur qui sit voluptas. Sunt tempore impedit ex fugiat.','https://via.placeholder.com/150',1,'65b8cd7e-866c-35ef-b4ca-c9ba451f8537','pdf','en','https://example.com/journal.pdf','pending','Placeat voluptas dolor ducimus eum qui praesentium beatae.','[\"tempora\", \"at\", \"enim\"]','Corrupti necessitatibus voluptatum similique veritatis est mollitia. Facere id esse quia quis. Nisi quibusdam eum sint cupiditate nisi cupiditate vero. Reiciendis non rerum voluptas doloremque dolor quas voluptas.','Ratione earum vel vel molestiae facere et. Harum doloribus occaecati deserunt hic ea eveniet dolor. Rerum impedit dolor minima vitae iusto dolore. Quasi itaque eaque repellendus ex magni aspernatur.','Bednar-Smitham','CC BY 4.0','Nigeria',0,4,2,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(75,'Deserunt deserunt placeat temporibus ut cupiditate.','Fanny Blick','repudiandae-sit-nostrum-in-itaque','Ut beatae porro tempore labore. At consectetur ab iusto magni earum velit. Ex dicta quis illo ea molestiae sed. Sit voluptatum deleniti voluptatum nobis sit repellendus quas.','https://via.placeholder.com/150',1,'3449d547-4b7f-3c9b-94dd-0812ba705fd6','pdf','en','https://example.com/journal.pdf','pending','Inventore quam quasi repellendus magni necessitatibus omnis suscipit.','[\"qui\", \"eveniet\", \"aut\"]','Et dolores optio eligendi illo. Non exercitationem possimus magnam reiciendis laudantium ad.','Officiis magnam magnam voluptatem fuga qui. Nihil tempore esse deserunt harum. Rerum possimus qui qui rerum itaque eligendi aut et. Id omnis sunt eum cupiditate sit ratione excepturi aut.','Leuschke, Thompson and Robel','CC BY 4.0','Nigeria',0,4,7,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(76,'Incidunt exercitationem animi et rerum saepe possimus natus ipsa.','Sallie Hartmann','pariatur-quibusdam-ut-dolorum-quod','Adipisci nobis occaecati rem. Sequi modi unde corrupti dolores cupiditate velit sit. Ipsum quod quia iste at.','https://via.placeholder.com/150',1,'7118a8f5-aa17-32ec-81e7-ac327dc03595','pdf','en','https://example.com/journal.pdf','pending','Exercitationem repudiandae est impedit aut error.','[\"repudiandae\", \"quas\", \"libero\"]','Culpa deleniti id dolor sint omnis accusamus possimus. Sint doloremque voluptatum suscipit tempore. Quasi vero nam nesciunt quos nesciunt voluptatum reprehenderit. Dolor id rem quas corporis iusto sint modi.','Quis quisquam cupiditate molestiae et iure veritatis. Et facere sed officia itaque ea ad. Dolores fugiat ratione rerum molestiae.','Ryan, Pfannerstill and Upton','CC BY 4.0','Nigeria',0,4,4,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(77,'Impedit et accusantium cum ipsam rerum sequi.','Carissa McKenzie','qui-aperiam-laudantium-quia-sit','Quia earum soluta aut ab. Fuga officiis expedita magnam molestiae. Eum quasi et sit ea optio doloribus recusandae.','https://via.placeholder.com/150',1,'51354d37-b810-33bb-98e5-277745daa1c6','pdf','en','https://example.com/journal.pdf','pending','Veritatis ut cum rerum nulla iste.','[\"nisi\", \"eligendi\", \"aut\"]','Saepe iure et sint voluptas. Non fugit quibusdam amet non eligendi asperiores officiis. Nihil qui eligendi sed iste. Hic ex commodi nostrum voluptatem nostrum. Id facere pariatur atque corrupti molestiae sed et.','Pariatur rerum facilis alias beatae ut deserunt et velit. Esse occaecati est sint dignissimos qui quis voluptas. Cumque qui dolores corrupti atque nisi.','Schimmel-Gleichner','CC BY 4.0','Nigeria',0,4,5,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(78,'Laudantium porro voluptas fugit voluptatem.','Alycia Rath','ex-dolores-consequuntur-aut-ex-et-qui','Eum provident quibusdam et vero facilis. Est consequatur et et nulla placeat. Cum libero aut necessitatibus quos aliquam voluptas earum temporibus.','https://via.placeholder.com/150',1,'a6151f19-d874-34ae-8b87-7ab4ab5b051a','pdf','en','https://example.com/journal.pdf','pending','Dolor eaque non omnis ea maxime atque ducimus nesciunt.','[\"occaecati\", \"ad\", \"tempora\"]','Pariatur ratione enim enim doloremque magnam. Omnis ipsa quia at voluptatem rerum quisquam. Repellat similique dolores qui ex.','Natus rerum et modi voluptatem dolorum velit. Voluptas nam qui impedit. Delectus debitis architecto qui vel quos.','Nolan, Conn and Will','CC BY 4.0','Nigeria',0,4,2,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(79,'Ut beatae nam in optio repudiandae earum.','Wyatt Dickinson','ut-tempora-saepe-recusandae-corrupti-quo','Deleniti illum eum repudiandae laboriosam deserunt maxime ratione. Vel beatae magnam fugit et possimus. Et consequatur quia ut. Dolorum voluptatem maiores est rem dicta voluptatum sequi eius. Porro quae sunt quas.','https://via.placeholder.com/150',1,'85e94572-caa3-38f0-a966-357119dea1f2','pdf','en','https://example.com/journal.pdf','pending','Ullam molestias voluptatum sunt odit et ab eveniet rerum.','[\"laudantium\", \"dolorum\", \"cumque\"]','Quia beatae beatae provident modi magnam enim. Saepe laboriosam cum ea voluptas sit voluptatem. Aut in non qui tempore.','Est nulla et temporibus accusantium occaecati rem quo. Amet voluptas est aspernatur excepturi reprehenderit fuga. Nostrum aut possimus dolore et omnis.','Larkin-Vandervort','CC BY 4.0','Nigeria',0,4,9,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(80,'A nihil quae esse.','Prof. Yasmine Goldner','cupiditate-dolores-et-atque-corrupti-omnis-quia','Officiis nostrum modi tempora magnam sequi quo. Voluptatum laborum saepe voluptas. Sed enim quia sunt est.','https://via.placeholder.com/150',1,'305695c4-146c-3894-be09-3fdda15bb65d','pdf','en','https://example.com/journal.pdf','pending','Nam ullam quia in quia dolor odit voluptas.','[\"occaecati\", \"illum\", \"voluptas\"]','Inventore natus et voluptatibus ea iusto tenetur. Dolor cupiditate facere est nihil commodi modi at. Adipisci voluptatem reiciendis asperiores quibusdam impedit modi.','Veniam rerum et minima sit autem. Adipisci quia voluptatem ad in qui. Et rerum fuga ex perspiciatis sint at. Tempora accusantium excepturi placeat est aut maiores sunt.','Bruen and Sons','CC BY 4.0','Nigeria',0,4,5,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(81,'Illum provident dolorem aut.','Victoria Konopelski','et-nam-dicta-quisquam-aut-repellendus-voluptatem','Quia atque voluptas animi similique aliquid. Id tempore officia et. Ex provident et officia quasi tenetur. Eligendi nesciunt suscipit enim nulla voluptate fugiat. Itaque omnis dolorem dicta magnam vitae nulla.','https://via.placeholder.com/150',1,'22cfedc6-e03b-30e0-a6d1-2308794b5eab','pdf','en','https://example.com/journal.pdf','pending','Aliquid quia expedita vel voluptatum voluptatem odio totam.','[\"neque\", \"labore\", \"molestiae\"]','Velit quo numquam pariatur aperiam est. Mollitia a vel a sed omnis. Velit quidem incidunt quis ab.','Harum quae ducimus iure aliquid in. Fuga magnam voluptas libero voluptatem amet ab nulla aut. Et accusamus suscipit maiores repellendus. Sunt quidem blanditiis eos unde.','Lockman-Pfeffer','CC BY 4.0','Nigeria',0,4,9,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(82,'Non delectus sint beatae quia.','Dr. Alda Hammes I','eius-dolor-perspiciatis-qui-veniam-eveniet-quam-aspernatur','Blanditiis facilis nihil ipsa consequatur quia aliquid repellat ipsum. Quisquam saepe commodi vel optio enim. Sunt temporibus nulla repellendus harum quo odio.','https://via.placeholder.com/150',1,'9d2c0229-90c4-3881-996d-29712a5e5f59','pdf','en','https://example.com/journal.pdf','pending','Sequi autem nemo voluptatem non totam.','[\"deleniti\", \"eveniet\", \"omnis\"]','Quae sapiente commodi saepe. Laborum dolorem accusamus dolorem blanditiis praesentium. Ea nobis cum dolores dolorum et.','Ut sed libero unde. Aut aliquid iusto amet expedita molestiae at eum. Quas voluptas omnis recusandae perferendis similique illum eius. A vitae blanditiis pariatur sit temporibus.','Kohler PLC','CC BY 4.0','Nigeria',0,4,7,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(83,'Nam quia beatae eos porro.','Mr. Eliseo Gulgowski','vel-soluta-laudantium-quia-modi-deserunt-similique','Iure nobis velit cupiditate ut. Et ut similique dolorem. Sit est ipsum et autem molestias. Dolore ut officiis iure molestiae magni quis aut quia.','https://via.placeholder.com/150',1,'21e4f9cf-0e36-3f69-813b-552b1245fb35','pdf','en','https://example.com/journal.pdf','pending','Sed cum laborum non consequatur voluptatem quia occaecati.','[\"corrupti\", \"nemo\", \"non\"]','Perspiciatis error sit reiciendis sit. Labore et sunt delectus blanditiis neque quod velit. Vitae quia at nisi tempora sed non. Aut incidunt non eius non incidunt veritatis.','Rerum consequatur qui vitae nihil laborum. Enim repudiandae aut quisquam rerum occaecati. Consequatur quidem earum optio dolorem.','Fadel Inc','CC BY 4.0','Nigeria',0,4,6,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(84,'Enim non distinctio est nam.','Ova Kub','dolor-officia-dolorum-earum-qui-atque-placeat','Hic voluptatum et libero unde et mollitia. Esse autem consequatur et ut quibusdam est porro. Adipisci enim quia in eligendi autem.','https://via.placeholder.com/150',1,'5bdcae02-71f1-31b0-af63-b31771090ad7','pdf','en','https://example.com/journal.pdf','pending','Laboriosam inventore veniam nesciunt laboriosam id corporis.','[\"voluptas\", \"aut\", \"cum\"]','Quia earum quos voluptas esse ullam nisi. Est qui possimus omnis omnis doloribus nobis accusamus et. Ab enim neque possimus aspernatur ex.','Et dolores ea rerum eum asperiores. Molestiae soluta molestiae quae quas. Cum quas a consectetur autem aut quo quia minus. Cum repellat laborum expedita sequi beatae tempora sequi quis.','Quitzon, Torp and Wiza','CC BY 4.0','Nigeria',0,4,1,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(85,'Et voluptatum quia est tempora aut quaerat.','Jerad Bruen','et-fuga-sit-consequatur-voluptatem-quidem','Voluptatem culpa ullam iste maiores consequatur sed explicabo. Voluptas quaerat aut ab aut. Nesciunt officiis et numquam dolore et molestias. Laborum vel aut at ad facilis veritatis recusandae.','https://via.placeholder.com/150',1,'bce893be-1d95-34b4-ad73-949774630100','pdf','en','https://example.com/journal.pdf','pending','Vero et ducimus suscipit et maxime id.','[\"harum\", \"corrupti\", \"fugit\"]','Inventore doloribus perferendis vero neque at deserunt nesciunt rem. Nobis libero impedit laboriosam praesentium at et. Est nisi laboriosam dolor voluptas quae assumenda odit.','Voluptatem sunt velit non id qui dolorum dolore corrupti. Consectetur quod quos est itaque tempora.','Hane, Terry and Swift','CC BY 4.0','Nigeria',0,4,6,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(86,'Assumenda laborum ea pariatur rerum.','Joany Conroy','quasi-earum-magnam-labore-sint-aspernatur','Esse minus omnis optio aut autem. Qui ut dolorem sed ea qui quas. Labore vitae non numquam ea.','https://via.placeholder.com/150',1,'53b4c07b-ec90-326e-9c2d-8b7c2bf454e5','pdf','en','https://example.com/journal.pdf','pending','Et eaque ipsum molestiae ut asperiores.','[\"possimus\", \"assumenda\", \"non\"]','Officiis iste quam nemo molestiae necessitatibus doloremque rerum laboriosam. Voluptas autem libero molestias officiis et. Consequatur non rerum vitae maxime molestiae quasi qui.','Distinctio eum quis ratione eveniet natus doloribus voluptas saepe. Id inventore officia qui suscipit eum reprehenderit totam. Numquam vero et amet consectetur. Vero voluptatem optio ipsam asperiores et.','Kiehn, Friesen and Muller','CC BY 4.0','Nigeria',0,4,2,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(87,'Voluptatem sunt asperiores cum.','Ansley Bogisich','neque-eius-architecto-sequi-facilis-eius-vitae','Et quis libero inventore. Libero est et consequuntur placeat laudantium. Id qui ullam dolores voluptas aut.','https://via.placeholder.com/150',1,'6d3ee724-1277-301d-bda7-87d104408932','pdf','en','https://example.com/journal.pdf','pending','Id sunt suscipit consequatur labore doloremque eos nostrum.','[\"aut\", \"nesciunt\", \"illum\"]','Illum consequatur quo ratione corporis. Voluptatem molestias rem beatae quis perferendis autem aperiam. Sint et aut sed et.','Nesciunt nam fugiat fugit repellat. Ea eum illum in odio molestiae quisquam. Sint quae harum tenetur id. Quae ut dolor et ipsa est quod.','Keebler, Willms and Veum','CC BY 4.0','Nigeria',0,4,7,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(88,'Eius et sed qui.','Miss Shayna Gerlach','et-aut-consequuntur-suscipit-beatae','Est iste dolores cupiditate qui porro. Nulla asperiores expedita distinctio reiciendis quae quaerat et. Maxime consectetur voluptatem autem id harum. Consequatur consequatur accusamus rerum hic.','https://via.placeholder.com/150',1,'9e6318d0-5c4d-3641-bb25-c58d14c1b41f','pdf','en','https://example.com/journal.pdf','pending','Excepturi ab esse accusamus repellat omnis tempora vitae molestiae.','[\"dignissimos\", \"aut\", \"asperiores\"]','Repellendus dolore deleniti nam aut similique doloremque quia. Et est architecto dignissimos dolorem et aut repudiandae. Voluptatum explicabo repellendus voluptas natus illo dolore perferendis.','Voluptatem alias assumenda quia quam veritatis. Est quis provident eos error. Illo sit suscipit rerum nihil suscipit facilis est. Est non perferendis beatae inventore cumque modi voluptas voluptas.','Yost LLC','CC BY 4.0','Nigeria',0,4,5,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(89,'Sint accusantium neque culpa aut minus mollitia.','Mr. Arnold Volkman PhD','laborum-fugiat-consectetur-ea-ullam-suscipit-nihil-earum','Quis voluptas ab exercitationem quia mollitia veniam. Delectus blanditiis veritatis optio neque autem ipsa dolor. Non dolores consequatur ad ut.','https://via.placeholder.com/150',1,'6ef1a1bd-4c93-34f2-8e0a-064f1b6bc584','pdf','en','https://example.com/journal.pdf','pending','Dicta eos ratione qui aut.','[\"est\", \"aperiam\", \"quo\"]','Vel quod magnam soluta mollitia aperiam non sequi. Illum atque veniam debitis omnis recusandae possimus asperiores. Quo earum et nulla qui dolorem. Numquam atque repudiandae nulla aliquam est.','Error dignissimos dolorum dolores cupiditate voluptatem quod quos. Corporis delectus perspiciatis aliquid suscipit nesciunt maxime. Voluptate ipsam sed quis. Voluptates temporibus voluptas nobis aut maiores aliquam animi.','Hudson Inc','CC BY 4.0','Nigeria',0,4,2,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(90,'Dolore perspiciatis et rerum beatae est sunt dolores.','Korbin Hahn DDS','sit-quod-dolores-reiciendis-hic-impedit-porro','Totam expedita quia iusto sunt. Et ea voluptatem natus in fugiat eos. Sit quasi cupiditate harum architecto excepturi pariatur. Ipsam quis animi ea consectetur.','https://via.placeholder.com/150',1,'b64aa331-a8ca-3a10-88c0-715d56b545b0','pdf','en','https://example.com/journal.pdf','pending','Suscipit qui quas quia at dolores corporis accusamus.','[\"non\", \"rerum\", \"odit\"]','Nihil debitis sit aut quis. Qui ut error voluptas quia voluptates. Quo sunt et ratione aspernatur rem ex.','Suscipit tenetur deserunt repellat autem adipisci. Tempore illo totam quo sint vero cumque illum. Molestiae fugiat architecto est debitis id harum. Deleniti accusamus quae unde vero est omnis.','Halvorson and Sons','CC BY 4.0','Nigeria',0,4,6,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(91,'Aspernatur et rerum repellendus occaecati sed.','Dr. Alanna Harris I','dignissimos-optio-nulla-sit-quis-voluptate-libero-officia','Eum nesciunt est consequatur qui. Corporis rerum asperiores iste harum et sapiente quaerat.','https://via.placeholder.com/150',1,'562c2cd1-770f-35d7-ad90-221afc722fea','pdf','en','https://example.com/journal.pdf','pending','Facilis voluptatem quod esse pariatur consequatur qui aut.','[\"assumenda\", \"et\", \"fugiat\"]','Minima architecto numquam nisi consectetur vel et et. Quo modi incidunt dolorum optio maiores. Fugiat id voluptatem voluptate ad.','Reiciendis consequatur nisi et fuga earum in. Eum minima ipsam dolorum repellendus voluptas. Qui est dolor commodi maxime dolores.','Steuber, Steuber and Fisher','CC BY 4.0','Nigeria',0,4,5,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(92,'Officiis inventore minima est adipisci commodi veritatis sapiente.','Margot Nikolaus','harum-numquam-sunt-autem-dolores-sed-ratione','Aperiam consectetur quis dolores incidunt numquam provident sint. Veniam fuga officiis voluptatibus earum. Et nobis perspiciatis quod.','https://via.placeholder.com/150',1,'122d797d-fce7-3bab-bf49-aba619c694a1','pdf','en','https://example.com/journal.pdf','pending','Saepe praesentium perspiciatis qui voluptatum.','[\"architecto\", \"fugit\", \"ex\"]','Velit similique unde voluptates quibusdam. Qui rerum quia magni modi veritatis. Debitis ullam assumenda dignissimos totam.','Nesciunt voluptas aspernatur alias pariatur nihil blanditiis impedit. Repudiandae voluptates est nihil delectus aut aspernatur. Reiciendis corrupti ea qui unde odit. Nisi molestias nemo beatae. Sint doloribus optio qui et et labore labore.','Pacocha, Tremblay and Satterfield','CC BY 4.0','Nigeria',0,4,7,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(93,'Nesciunt molestiae nesciunt mollitia inventore voluptatem possimus eos a.','Vince Rau III','laudantium-dolorem-impedit-reprehenderit-impedit-qui-unde','Necessitatibus facilis rerum repellendus debitis unde dignissimos autem. In et et architecto earum soluta aliquid officia. Pariatur reiciendis officiis voluptatem similique. Deleniti aut delectus ea eos magnam dicta nobis.','https://via.placeholder.com/150',1,'72644e8e-ddb4-3019-9066-6ab8762b4c4c','pdf','en','https://example.com/journal.pdf','pending','Quaerat dolore aliquid vero quaerat ea.','[\"mollitia\", \"architecto\", \"quo\"]','Vero sunt aut hic asperiores ipsum aut. Vero saepe eos doloremque. Perferendis quo velit adipisci non voluptatibus.','Iusto dicta et cupiditate expedita blanditiis. Quo laudantium est ipsam itaque eius dolores. Saepe est exercitationem unde omnis ut laboriosam et.','Schuster-Hartmann','CC BY 4.0','Nigeria',0,4,5,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(94,'Quis eos dicta autem dolore.','Ms. Linnea Walsh','et-porro-velit-tempora-rerum','Eos ad doloribus aut delectus cupiditate. Doloremque consequatur error deserunt aut hic quod. Repellat sed illum earum corrupti necessitatibus. Voluptatem quas saepe modi qui.','https://via.placeholder.com/150',1,'fa4817cf-8485-3bcd-ba79-e5cf2bb32429','pdf','en','https://example.com/journal.pdf','pending','Unde quidem neque qui.','[\"voluptatem\", \"illo\", \"fugiat\"]','Expedita illum maiores et corrupti et iure. Iure natus aut aliquid minima nihil consequatur. Rerum mollitia amet inventore explicabo perferendis quaerat.','Incidunt ut voluptas dignissimos rerum animi nostrum molestias repudiandae. Officia quaerat tenetur repellat sunt qui iusto.','Lind PLC','CC BY 4.0','Nigeria',0,4,2,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(95,'Eos et corporis omnis molestiae eligendi ut.','Harrison Herzog','delectus-qui-laudantium-sunt-earum-in-aut-omnis','Aliquam omnis perferendis iure culpa sed sit quidem. Illo ab temporibus voluptatum tempore quia rem. Non fuga alias blanditiis velit voluptas. Dolores voluptates neque non et.','https://via.placeholder.com/150',1,'082f4084-9817-3858-bddd-3c079041f9f3','pdf','en','https://example.com/journal.pdf','pending','Aliquid ipsam enim consequatur consequatur cumque.','[\"temporibus\", \"fuga\", \"sit\"]','Enim nihil sunt qui modi explicabo. Quaerat totam sit velit qui. Neque quidem harum velit ea iusto voluptas ea. Repellat in reiciendis vel et consequatur harum.','Omnis minus et eos tenetur dolorem. Et vel harum autem ea. Quod vel autem rerum ea dolores velit qui deserunt. Laboriosam alias dolorem architecto harum reprehenderit eos minus aliquam.','Crona Inc','CC BY 4.0','Nigeria',0,4,1,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(96,'Ea corrupti corporis eos vero.','Myrna Swaniawski Sr.','dolorum-expedita-ad-aperiam','Id qui perferendis quo nemo vel nulla totam. Facere voluptatem magnam assumenda molestiae corrupti ratione error. Beatae id eos reiciendis ullam occaecati rerum. Eum labore et consequuntur ipsam fugit a optio.','https://via.placeholder.com/150',1,'54244a29-ea3a-39e7-98db-9b4113fb0c53','pdf','en','https://example.com/journal.pdf','pending','Suscipit quo dolorum temporibus omnis nisi dolor unde similique.','[\"repellendus\", \"possimus\", \"at\"]','Ea a quos magni ad praesentium natus. Quia nulla aut nulla voluptatem qui dolorem nostrum neque. Reprehenderit provident id explicabo ut magni earum commodi. Laborum voluptatem tempora sunt unde error quo aut. Optio molestias quis exercitationem debitis accusamus blanditiis.','Ducimus laboriosam non sint veniam nesciunt tempora. Accusamus velit et nihil voluptatem aut repudiandae. Sit ratione maxime deserunt assumenda eum illum quod.','Friesen, Shields and King','CC BY 4.0','Nigeria',0,4,5,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(97,'Iusto tempora rem et rerum aut labore.','Alayna Schneider','eligendi-suscipit-ipsum-quos-sed-est-dolore-asperiores','Aut rerum blanditiis alias ab ex id. Nostrum ut et neque sequi quas nesciunt. Omnis ipsa et dolor ab sit sit.','https://via.placeholder.com/150',1,'658e8d04-7d1c-3a34-b09e-5e1c03626090','pdf','en','https://example.com/journal.pdf','pending','Tenetur rerum omnis cum est.','[\"molestiae\", \"aperiam\", \"laboriosam\"]','Eius architecto doloribus non quibusdam dolores earum non dolorem. Nobis aliquid et et aliquid facere. Aut et veniam atque eos facere architecto.','Est vel laudantium repudiandae adipisci iure voluptas. Rem dolore incidunt magni temporibus aspernatur. Facilis ullam quam dolorum alias.','Kunze Ltd','CC BY 4.0','Nigeria',0,4,4,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(98,'Et blanditiis ut blanditiis dolor occaecati accusamus id.','Reymundo Braun','pariatur-dolorem-quisquam-aut-ut','Voluptas deserunt et omnis et in recusandae voluptatum fuga. Itaque distinctio accusamus suscipit eos veritatis non. Iure non maxime qui.','https://via.placeholder.com/150',1,'4e11f475-ae2d-327b-a88f-ecd4bdbb6e1e','pdf','en','https://example.com/journal.pdf','pending','Nihil voluptas saepe et temporibus aliquid quidem reiciendis.','[\"recusandae\", \"blanditiis\", \"distinctio\"]','Consequatur minus velit est amet corrupti iusto. Necessitatibus aut nobis labore ipsa quas. Animi sit voluptas provident numquam iste. Qui sunt tenetur qui aperiam.','Commodi rerum repellat illum id nesciunt ducimus id. Tempore et soluta consectetur est placeat molestiae qui. Velit aut assumenda in id ea.','Cormier Ltd','CC BY 4.0','Nigeria',0,4,3,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(99,'Quaerat vel voluptatum iure dolorem ab.','Giles Goyette II','ipsam-in-in-sapiente-eius-non-adipisci','Ad architecto repellendus ut incidunt facere non quo. Sed velit consequatur ut in. Expedita magnam sequi ut officiis. Pariatur delectus sit iste nemo qui omnis.','https://via.placeholder.com/150',1,'f9eabdc4-7771-3230-ad67-91f68d152b62','pdf','en','https://example.com/journal.pdf','pending','Modi quisquam ducimus et.','[\"veniam\", \"ea\", \"aut\"]','Perferendis voluptas laboriosam qui velit harum sed. Temporibus explicabo quia et ut eius quo exercitationem nihil. Quas similique quia cupiditate veniam distinctio. Temporibus magni repudiandae animi quo praesentium qui.','Maxime eaque eum optio magnam quibusdam. Qui consectetur suscipit autem consequatur. Qui et neque ullam quos id. Facere molestiae veniam saepe omnis aut quia fugiat.','Huel Group','CC BY 4.0','Nigeria',0,4,1,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09'),(100,'Quia consequatur architecto saepe non eum dolor.','Destini Mohr','quasi-rerum-voluptatem-deserunt-et-ipsum-numquam-expedita','Fuga numquam nulla corporis illum quisquam excepturi. Repudiandae rerum quaerat voluptatem. Provident numquam sed sit recusandae ipsa voluptatum dolorem. Enim repudiandae velit dolor ut quasi laborum nostrum architecto. Explicabo vel unde consequatur officiis voluptatum reprehenderit.','https://via.placeholder.com/150',1,'b176f87a-2a58-3fdd-bb19-ce7d3c2c0b63','pdf','en','https://example.com/journal.pdf','pending','Necessitatibus qui est maxime repellendus ex.','[\"provident\", \"provident\", \"enim\"]','Consequatur dolores nihil expedita officiis minima rerum. Enim aut pariatur quia at praesentium voluptatem. Qui doloremque delectus necessitatibus aut ad.','Pariatur commodi quisquam libero ut. Reiciendis velit perferendis at labore impedit incidunt veritatis. Eos autem vel nihil velit vel numquam dolorum.','Pouros Group','CC BY 4.0','Nigeria',0,4,2,NULL,NULL,'{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"id\": 4, \"name\": \"Admin\"}','{\"comments\": \"This is a test comment\"}',NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09');
/*!40000 ALTER TABLE `journals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2024_09_12_225334_create_permission_tables',1),(5,'2024_09_22_084109_create_categories_table',1),(6,'2024_09_22_084123_create_sub_categories_table',1),(7,'2024_09_22_084139_create_sub_sub_categories_table',1),(8,'2024_09_23_121159_create_journals_table',1),(9,'2024_09_28_032445_create_activations_table',1),(10,'2024_10_01_141808_create_journal_comments_table',1),(11,'2024_10_02_184437_create_regions_table',1),(12,'2024_10_02_185052_create_countries_table',1),(13,'2024_10_07_145829_create_user_interests_table',1),(14,'2024_10_07_160320_create_journal_likes_table',1),(15,'2024_10_07_160424_create_dislike_journals_table',1),(16,'2024_10_07_193026_create_my_journal_collections_table',1),(17,'2024_10_11_031106_create_pulse_tables',1),(18,'2024_10_20_092516_add_institution_to_users_table',1),(19,'2024_10_20_112219_create_reviewers_table',1),(20,'2024_10_20_122544_create_approvals_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(2,'App\\Models\\User',2),(3,'App\\Models\\User',3),(5,'App\\Models\\User',4),(6,'App\\Models\\User',5),(6,'App\\Models\\User',6),(6,'App\\Models\\User',7),(6,'App\\Models\\User',8);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `my_journal_collections`
--

DROP TABLE IF EXISTS `my_journal_collections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `my_journal_collections` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `journal_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `my_journal_collections_user_id_foreign` (`user_id`),
  KEY `my_journal_collections_journal_id_foreign` (`journal_id`),
  CONSTRAINT `my_journal_collections_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE,
  CONSTRAINT `my_journal_collections_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `my_journal_collections`
--

LOCK TABLES `my_journal_collections` WRITE;
/*!40000 ALTER TABLE `my_journal_collections` DISABLE KEYS */;
/*!40000 ALTER TABLE `my_journal_collections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'create-users','web',1,'d588df3e-305f-454c-bcb8-0706c76cd16f','2024-10-21 18:58:04','2024-10-21 18:58:04'),(2,'edit-users','web',1,'7a86aae5-4dbb-4ec1-b663-065b97e8e64e','2024-10-21 18:58:04','2024-10-21 18:58:04'),(3,'delete-users','web',1,'334b80b9-d62b-49a9-8a73-8239969ddef2','2024-10-21 18:58:04','2024-10-21 18:58:04'),(4,'create-publications','web',1,'770ea12e-ffc6-4870-b67a-618df61bf111','2024-10-21 18:58:04','2024-10-21 18:58:04'),(5,'edit-publications','web',1,'67988355-7d55-4f9d-8134-6bfc0433b1df','2024-10-21 18:58:04','2024-10-21 18:58:04'),(6,'delete-publications','web',1,'463649c6-6249-46b2-abb4-bf97352aaf65','2024-10-21 18:58:04','2024-10-21 18:58:04'),(7,'create-posts','web',1,'0c98d0b9-0f3f-4a69-a1ff-f9628a6f3aa5','2024-10-21 18:58:04','2024-10-21 18:58:04'),(8,'edit-posts','web',1,'5d4302f1-49ed-4617-8a63-e29ca5e8ab60','2024-10-21 18:58:04','2024-10-21 18:58:04'),(9,'delete-posts','web',1,'1461bc1d-8174-4925-83eb-75b54ac77f61','2024-10-21 18:58:04','2024-10-21 18:58:04'),(10,'can-invite','web',1,'5084d114-7764-4031-b497-dbc12d71f5b1','2024-10-21 18:58:04','2024-10-21 18:58:04');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pulse_aggregates`
--

DROP TABLE IF EXISTS `pulse_aggregates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pulse_aggregates` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `bucket` int unsigned NOT NULL,
  `period` mediumint unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `key_hash` binary(16) GENERATED ALWAYS AS (unhex(md5(`key`))) VIRTUAL,
  `aggregate` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` decimal(20,2) NOT NULL,
  `count` int unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pulse_aggregates_bucket_period_type_aggregate_key_hash_unique` (`bucket`,`period`,`type`,`aggregate`,`key_hash`),
  KEY `pulse_aggregates_period_bucket_index` (`period`,`bucket`),
  KEY `pulse_aggregates_type_index` (`type`),
  KEY `pulse_aggregates_period_type_aggregate_bucket_index` (`period`,`type`,`aggregate`,`bucket`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pulse_aggregates`
--

LOCK TABLES `pulse_aggregates` WRITE;
/*!40000 ALTER TABLE `pulse_aggregates` DISABLE KEYS */;
INSERT INTO `pulse_aggregates` (`id`, `bucket`, `period`, `type`, `key`, `aggregate`, `value`, `count`) VALUES (1,1729540680,60,'cache_miss','spatie.permission.cache','count',16.00,NULL),(2,1729540440,360,'cache_miss','spatie.permission.cache','count',16.00,NULL),(3,1729539360,1440,'cache_miss','spatie.permission.cache','count',16.00,NULL),(4,1729536480,10080,'cache_miss','spatie.permission.cache','count',16.00,NULL);
/*!40000 ALTER TABLE `pulse_aggregates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pulse_entries`
--

DROP TABLE IF EXISTS `pulse_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pulse_entries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` int unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `key_hash` binary(16) GENERATED ALWAYS AS (unhex(md5(`key`))) VIRTUAL,
  `value` bigint DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pulse_entries_timestamp_index` (`timestamp`),
  KEY `pulse_entries_type_index` (`type`),
  KEY `pulse_entries_key_hash_index` (`key_hash`),
  KEY `pulse_entries_timestamp_type_key_hash_value_index` (`timestamp`,`type`,`key_hash`,`value`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pulse_entries`
--

LOCK TABLES `pulse_entries` WRITE;
/*!40000 ALTER TABLE `pulse_entries` DISABLE KEYS */;
INSERT INTO `pulse_entries` (`id`, `timestamp`, `type`, `key`, `value`) VALUES (1,1729540684,'cache_miss','spatie.permission.cache',NULL),(2,1729540684,'cache_miss','spatie.permission.cache',NULL),(3,1729540684,'cache_miss','spatie.permission.cache',NULL),(4,1729540684,'cache_miss','spatie.permission.cache',NULL),(5,1729540684,'cache_miss','spatie.permission.cache',NULL),(6,1729540684,'cache_miss','spatie.permission.cache',NULL),(7,1729540684,'cache_miss','spatie.permission.cache',NULL),(8,1729540684,'cache_miss','spatie.permission.cache',NULL),(9,1729540684,'cache_miss','spatie.permission.cache',NULL),(10,1729540684,'cache_miss','spatie.permission.cache',NULL),(11,1729540684,'cache_miss','spatie.permission.cache',NULL),(12,1729540684,'cache_miss','spatie.permission.cache',NULL),(13,1729540684,'cache_miss','spatie.permission.cache',NULL),(14,1729540684,'cache_miss','spatie.permission.cache',NULL),(15,1729540684,'cache_miss','spatie.permission.cache',NULL),(16,1729540684,'cache_miss','spatie.permission.cache',NULL);
/*!40000 ALTER TABLE `pulse_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pulse_values`
--

DROP TABLE IF EXISTS `pulse_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pulse_values` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `timestamp` int unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `key_hash` binary(16) GENERATED ALWAYS AS (unhex(md5(`key`))) VIRTUAL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pulse_values_type_key_hash_unique` (`type`,`key_hash`),
  KEY `pulse_values_timestamp_index` (`timestamp`),
  KEY `pulse_values_type_index` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pulse_values`
--

LOCK TABLES `pulse_values` WRITE;
/*!40000 ALTER TABLE `pulse_values` DISABLE KEYS */;
/*!40000 ALTER TABLE `pulse_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `regions`
--

DROP TABLE IF EXISTS `regions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `regions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `regions`
--

LOCK TABLES `regions` WRITE;
/*!40000 ALTER TABLE `regions` DISABLE KEYS */;
INSERT INTO `regions` VALUES (1,'Central Africa','2024-10-21 18:58:08','2024-10-21 18:58:08'),(2,'Eastern Africa','2024-10-21 18:58:08','2024-10-21 18:58:08'),(3,'Northern Africa','2024-10-21 18:58:08','2024-10-21 18:58:08'),(4,'Southern Africa','2024-10-21 18:58:08','2024-10-21 18:58:08'),(5,'Western Africa','2024-10-21 18:58:08','2024-10-21 18:58:08');
/*!40000 ALTER TABLE `regions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviewers`
--

DROP TABLE IF EXISTS `reviewers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviewers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `journal_id` bigint unsigned NOT NULL,
  `review` longtext COLLATE utf8mb4_unicode_ci,
  `comment` longtext COLLATE utf8mb4_unicode_ci,
  `rating` int DEFAULT NULL,
  `is_accepted` tinyint(1) NOT NULL DEFAULT '0',
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reviewers_user_id_foreign` (`user_id`),
  KEY `reviewers_journal_id_foreign` (`journal_id`),
  CONSTRAINT `reviewers_journal_id_foreign` FOREIGN KEY (`journal_id`) REFERENCES `journals` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviewers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviewers`
--

LOCK TABLES `reviewers` WRITE;
/*!40000 ALTER TABLE `reviewers` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviewers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(4,2),(5,2),(6,2),(4,3),(5,3),(6,3),(7,4),(8,4),(9,4),(7,5),(8,5),(9,5),(7,6),(8,6),(9,6);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin','web',1,'43e7624f-e195-410a-bbc6-6407eb25f0db','2024-10-21 18:58:04','2024-10-21 18:58:04'),(2,'Editor','web',1,'08a77889-ffd1-4256-ad9d-20596133f949','2024-10-21 18:58:04','2024-10-21 18:58:04'),(3,'Author','web',1,'b8bf9606-bc92-4b46-b652-6f9241e2c379','2024-10-21 18:58:04','2024-10-21 18:58:04'),(4,'Contributor','web',1,'43761fad-ce4b-40f0-baf6-5a5b2f5c50e3','2024-10-21 18:58:04','2024-10-21 18:58:04'),(5,'Publisher','web',1,'72bf4f2f-a729-4547-9b14-e4023a935ed0','2024-10-21 18:58:04','2024-10-21 18:58:04'),(6,'Reviewer','web',1,'469f99e9-2eef-4d51-8c13-1439a3cb01aa','2024-10-21 18:58:04','2024-10-21 18:58:04'),(7,'Chief Editor','web',1,'b490edf8-9827-4ec6-a000-ef6eb4b598df','2024-10-21 18:58:04','2024-10-21 18:58:04'),(8,'Managing Editor','web',1,'a2514168-a3c5-4b89-90d8-012f6b2da642','2024-10-21 18:58:04','2024-10-21 18:58:04'),(9,'Associate Editor','web',1,'4be66f73-b240-4916-8fc4-96aff8883ed0','2024-10-21 18:58:04','2024-10-21 18:58:04'),(10,'Peer Reviewer','web',1,'9395813a-b892-40ca-8beb-278add6d20e7','2024-10-21 18:58:04','2024-10-21 18:58:04');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_categories`
--

DROP TABLE IF EXISTS `sub_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sub_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `category_id` bigint unsigned NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sub_categories_slug_unique` (`slug`),
  UNIQUE KEY `sub_categories_uuid_unique` (`uuid`),
  KEY `sub_categories_category_id_foreign` (`category_id`),
  CONSTRAINT `sub_categories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_categories`
--

LOCK TABLES `sub_categories` WRITE;
/*!40000 ALTER TABLE `sub_categories` DISABLE KEYS */;
INSERT INTO `sub_categories` VALUES (1,'Computer Science','computer-science','9cc03f6d-30ff-485a-9e4a-e345a7e814e9','Pariatur et fuga labore magni optio excepturi.',NULL,1,1,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(2,'Mathematics','mathematics','cc647d4f-6f78-4982-aecc-9f1ef44b31b2','Minima odit nesciunt voluptatem rem sint dolore.',NULL,1,2,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(3,'Physics','physics','ae520980-8a25-445c-8ea4-5e28e9335afe','Hic voluptates neque atque vel.',NULL,1,3,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(4,'Chemistry','chemistry','203d8694-c13c-408d-84df-6728a922836b','Unde quo iusto cumque architecto.',NULL,1,4,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(5,'Biology','biology','33551650-42a0-47fb-840f-d27819de41c8','Optio sed ratione ex rerum animi sint cum et.',NULL,1,5,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(6,'Medicine','medicine','8a713b3e-a60a-4a8e-b0c0-da55829c6d0a','Repellat et laudantium eaque error aut.',NULL,1,6,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(7,'Engineering','engineering','9c6fbad4-f7c9-4689-bb62-2b2df0b8a115','Et neque qui est odio.',NULL,1,7,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(8,'Agriculture','agriculture','63ddc9cf-615c-47a9-844b-c99468f6122d','Aspernatur quisquam est ipsa.',NULL,1,8,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(9,'Economics','economics','5e09805e-4ecb-403e-9f4c-1f1396a71cd1','Dicta dolor praesentium autem dolores.',NULL,1,9,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(10,'Law','law','bcad0421-ec31-4572-96ee-972a6d01dbcb','In maxime voluptatem porro et.',NULL,1,10,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(11,'Education','education','26f349d0-e8dc-4e34-9a41-c5f4eacb7129','Aliquam rerum maiores qui dolores.',NULL,1,11,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(12,'Arts','arts','b8d780a1-45a3-45b1-a556-928c14e26567','Et beatae nam quod suscipit consectetur debitis velit ex.',NULL,1,12,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(13,'Social Sciences','social-sciences','b7b50c3c-36bb-416c-a34d-4c08120f2753','Est qui velit error nam.',NULL,1,13,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(14,'Humanities','humanities','33086a9d-9c69-45cf-80ea-f11b1b91d50b','Sint corporis molestiae explicabo.',NULL,1,14,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(15,'Environmental Sciences','environmental-sciences','26cad77e-fd36-47c7-ae14-c1f42b04cf2c','Aut rerum atque neque optio voluptas similique.',NULL,1,15,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(16,'Management','management','ee557fba-f4a3-48b5-8dd3-a914b4561dab','Vitae beatae alias nemo nobis eos nihil.',NULL,1,16,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(17,'Accounting','accounting','5c06a88e-8c79-43ec-a7e1-4c4a20efbc4d','Iusto autem occaecati impedit repellendus.',NULL,1,17,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(18,'Finance','finance','4192a0ac-a726-424a-ab16-fde8f6f7d468','Pariatur sint error occaecati aliquam.',NULL,1,18,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(19,'Marketing','marketing','b070b5b4-cffe-43b2-aeab-d510776b79f8','A sint magni officia quam.',NULL,1,19,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(20,'Business Administration','business-administration','3f79f1ba-9b21-4223-a879-4135a5e1902f','Quibusdam necessitatibus possimus ut accusamus laborum eius.',NULL,1,20,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(21,'Public Administration','public-administration','1b233498-79f3-47ec-9532-f1264920b8bb','Nihil ullam ut sint molestiae enim illo molestias labore.',NULL,1,21,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(22,'Political Science','political-science','d92cf43a-467a-44c8-8be6-bfe28d4bc5f4','Excepturi consequatur numquam qui quia corporis velit qui vitae.',NULL,1,22,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(23,'International Relations','international-relations','2860d52a-3fb3-4d6b-bdf1-759af4ca315a','Natus molestiae voluptatem consequatur.',NULL,1,23,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(24,'History','history','bb62c0f6-ef8a-494e-a6c4-28effaf0e207','A architecto id voluptas ut culpa cupiditate.',NULL,1,24,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(25,'Geography','geography','e7adc4a0-a4c9-433a-93c7-5f6e09a7c14c','Fugit rerum nostrum autem dolorum laudantium aut.',NULL,1,25,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(26,'Philosophy','philosophy','30d8c932-b17a-4458-9d99-7c580d18b20e','Et aut nisi repudiandae optio et autem.',NULL,1,26,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(27,'Religion','religion','c0bae129-bd3d-45f7-bd78-07d047745ff5','Sed quis amet ut ut.',NULL,1,27,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(28,'Library and Information Science','library-and-information-science','e237bcc4-887a-49eb-a270-9cd9b0bdaaf6','Tempora asperiores aut corporis suscipit inventore modi est.',NULL,1,28,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(29,'Mass Communication','mass-communication','1e43202b-7955-4d89-ad20-b663ced1f6ca','Nesciunt modi et sapiente omnis voluptates voluptas.',NULL,1,29,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(30,'Psychology','psychology','4c56da44-a59b-4f15-83c3-3c5f9ba7e7c5','Vel vitae id distinctio eveniet blanditiis.',NULL,1,30,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(31,'Sociology','sociology','dfcf7a95-827a-4090-b1d2-b5e752d156ff','Ut cupiditate et ratione dolore dolor.',NULL,1,31,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(32,'Anthropology','anthropology','1abc5a0a-0300-4b6e-b01b-00e8d575c585','Voluptatem nemo hic molestias et ab.',NULL,1,32,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(33,'Archaeology','archaeology','a957088e-fcab-4904-8684-6f7009242dff','Ullam tempora maxime numquam consequuntur animi eius voluptatem.',NULL,1,33,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(34,'Linguistics','linguistics','16fe8244-4c81-405e-87bd-e2aabdc5ae44','Earum aperiam quod quas a corrupti.',NULL,1,34,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(35,'Literature','literature','5edf1f4d-2e6c-48f9-9a2b-06da4336f266','Maxime veritatis qui esse vel voluptatibus.',NULL,1,35,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(36,'Performing Arts','performing-arts','33e90b28-1336-4ea5-a405-1f185cd0f5a1','Id qui dolor repellat nam eos expedita.',NULL,1,36,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(37,'Visual Arts','visual-arts','63530143-1d4d-430d-99af-6ce1af108a2d','Rerum sunt itaque neque doloremque nesciunt id.',NULL,1,37,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(38,'Music','music','645d8169-53e7-4c40-8f43-f6a60b21cb47','Id illum quis rerum aut temporibus porro quia molestias.',NULL,1,38,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(39,'Film Studies','film-studies','9cbd5a46-c6c6-4fdb-bd97-8d5b65f20402','Eligendi beatae velit ex at.',NULL,1,39,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(40,'Dance','dance','03506d79-f67a-41b8-93e0-15d32b946717','Repellat nulla qui soluta et magnam nesciunt ipsa et.',NULL,1,40,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(41,'Sports','sports','257c44ec-00ff-495d-9273-1e9ba8e0ca2a','Totam labore quos magni reprehenderit.',NULL,1,41,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(42,'Tourism','tourism','088f0fc5-10fd-4791-861a-388ecc218dc6','Quas possimus ut vel aliquid sint aut.',NULL,1,42,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(43,'Hospitality','hospitality','0d0483e7-5fab-4475-bdcd-ee528090d599','Maxime voluptas autem repellendus veniam.',NULL,1,43,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(44,'Culinary Arts','culinary-arts','37733323-c352-4bc9-a21a-c30c8a1d8426','Qui libero quia omnis.',NULL,1,44,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(45,'Fashion','fashion','5efb6111-0c8d-440d-8ca3-64cda1086650','Earum animi beatae doloremque corporis at amet quas.',NULL,1,45,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(46,'Textile','textile','2807e0af-0ec9-461e-9f94-6c0f0fe24254','Iusto molestiae quas itaque.',NULL,1,46,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(47,'Architecture','architecture','a5a9825b-c7fb-49ab-81a1-bb47466bca96','Nostrum neque est enim ea non molestias.',NULL,1,47,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(48,'Urban Planning','urban-planning','a3843427-1f45-41d5-8764-ff5ed05fc0e8','Consequatur et nulla pariatur sed enim ex minus maxime.',NULL,1,48,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(49,'Genetic Engineering','genetic-engineering','052bf970-58b8-41a9-a435-d09c5ce7ead0','Similique qui aut aut ratione repudiandae consectetur tempore iste.',NULL,1,49,NULL,NULL,NULL,'2024-10-21 18:58:05','2024-10-21 18:58:05'),(50,'Industrial Engineering','industrial-engineering','7774f4e7-a3b5-4a65-9934-48115c42a5c9','Sed autem ut vel hic delectus corrupti.',NULL,1,50,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(51,'Rural Planning','rural-planning','46185ca7-7b35-4abf-9027-2abf5b85888c','Voluptate enim rerum aliquid.',NULL,1,51,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(52,'Transportation`','transportation','2519d1b0-732d-4246-9b3e-40c6dc66ba7a','Saepe aut voluptatibus porro molestias fugiat.',NULL,1,52,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(53,'Communication Engineering','communication-engineering','d46a7fdd-4198-497d-8d5b-55e672c33f61','Ut quam odit adipisci provident voluptatem.',NULL,1,53,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(54,'Computer Engineering','computer-engineering','3d6e782c-7ab4-4e70-8709-62a1ced61753','Vel consectetur et non doloremque voluptas voluptatem.',NULL,1,54,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(55,'Electrical Engineering','electrical-engineering','5c996e03-08c0-4935-9596-a15d02682187','Sed velit quia distinctio magnam.',NULL,1,55,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(56,'Mechanical Engineering','mechanical-engineering','e54a74d8-b386-4830-ad21-0e45e5537e3a','Sequi quae nam deserunt velit enim accusantium.',NULL,1,56,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(57,'Civil Engineering','civil-engineering','1d751b47-1b67-4191-b770-bb49db2d357c','Esse deserunt ut quos quaerat sed ut.',NULL,1,57,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(58,'Chemical Engineering','chemical-engineering','4bc6cc2c-cc16-4c5e-9c9c-385df7f8983d','Qui aliquam deserunt ipsa dolorum ullam cum ut alias.',NULL,1,58,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(59,'Petroleum Engineering','petroleum-engineering','9fc4fddf-560a-4fb8-a451-6c3cd1656260','Nihil nobis sint odit ut voluptate perferendis blanditiis.',NULL,1,59,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(60,'Mining Engineering','mining-engineering','9388a6d1-caf9-42a8-9553-93f7fe0ba5ce','Sint soluta tempore pariatur molestiae quis consequatur sed.',NULL,1,60,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(61,'Metallurgical Engineering','metallurgical-engineering','1c3f59f4-8715-43dc-b057-e6c0b11e97c5','Est fugiat et autem qui molestiae ut.',NULL,1,61,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(62,'Materials Engineering','materials-engineering','366ea6e5-64c1-494e-b7c4-4f4eb2d2eeb9','Fugiat ab voluptatibus rerum eaque voluptate non ex.',NULL,1,62,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(63,'Biomedical Engineering','biomedical-engineering','dd3bab64-971c-4ed5-afbf-a7b5f424c76f','Sed autem tempora in qui asperiores.',NULL,1,63,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(64,'Manufacturing Engineering','manufacturing-engineering','7440d3f9-d8ac-4dae-920c-1b00ed931a99','Hic nesciunt hic veritatis esse ut nulla.',NULL,1,64,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(65,'Textile Engineering','textile-engineering','5962bbc9-16b1-406f-9233-a3a3c82eb576','Non pariatur magnam ipsa porro.',NULL,1,65,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(66,'Aerospace Engineering','aerospace-engineering','c4119bc4-621f-4eab-b9e0-dc490819b321','Temporibus dolorem et ut quos ut suscipit ipsum.',NULL,1,66,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(67,'Nuclear Engineering','nuclear-engineering','1814584b-7834-407f-b216-6e116d805e95','Animi a amet nam asperiores.',NULL,1,67,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(68,'Marine Engineering','marine-engineering','c014a1e4-283e-4fbb-9fda-8a5a8e782882','Distinctio iusto neque cumque fuga.',NULL,1,68,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(69,'Ocean Engineering','ocean-engineering','e0fc1fb3-496c-4f7c-9f15-a3becac7a40a','Autem consectetur non maxime non in ab maxime.',NULL,1,69,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(70,'Water Resources Engineering','water-resources-engineering','90df3034-27a3-4ef3-92ef-7fa8e7bb60ce','Eaque voluptatem fugit natus velit ea et.',NULL,1,70,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(71,'Geotechnical Engineering','geotechnical-engineering','1367fba5-def1-4591-9156-abee7d945704','Earum voluptas impedit quis error.',NULL,1,71,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(72,'Structural Engineering','structural-engineering','9219e603-06e1-4604-9939-ba7cca56645b','Ut eum numquam ad esse possimus dolorem ducimus.',NULL,1,72,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(73,'Transportation` Engineering','transportation-engineering','c12710a6-0375-4728-a89d-4b3fcc6a1f69','Ea veniam fugit molestiae quidem tempore repellat.',NULL,1,73,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(74,'Surveying Engineering','surveying-engineering','f8486cb8-dfba-49c4-92f6-6b97f45cd9ab','Quam a rem qui aut.',NULL,1,74,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(75,'Urban Engineering','urban-engineering','a13008e0-3aba-4bef-8199-9e17f3bf4cbf','Eius tenetur natus vitae distinctio.',NULL,1,75,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(76,'Regional Engineering','regional-engineering','20f3aeaa-b48c-44da-b409-bf2964644634','Optio quaerat repudiandae beatae.',NULL,1,76,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(77,'Rural Engineering','rural-engineering','2f154e0b-8bf2-4251-ab02-16f670dc2551','Ipsum maxime deserunt voluptate aut est iusto.',NULL,1,77,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(78,'Environmental Engineering','environmental-engineering','fd3e0cea-82bc-456c-95d6-f064fd29479d','Autem qui magni quibusdam dolore et.',NULL,1,78,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(79,'Agricultural Engineering','agricultural-engineering','150103ef-1b90-4800-9c3b-2920f6fe71dc','Facilis quidem vero qui ab nihil.',NULL,1,79,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(80,'Food Engineering','food-engineering','ded6e4c6-5c16-4ba7-afe6-890d97f6fd4c','Voluptatem est vitae tempora odio.',NULL,1,80,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(81,'Biological Engineering','biological-engineering','e1112ec2-f73c-4273-b43f-557f9800a1f5','Cumque quasi maiores maxime maiores sed dolorem.',NULL,1,81,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06');
/*!40000 ALTER TABLE `sub_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_sub_categories`
--

DROP TABLE IF EXISTS `sub_sub_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sub_sub_categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sub_category_id` bigint unsigned NOT NULL,
  `created_by` bigint unsigned DEFAULT NULL,
  `updated_by` bigint unsigned DEFAULT NULL,
  `deleted_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sub_sub_categories_slug_unique` (`slug`),
  UNIQUE KEY `sub_sub_categories_uuid_unique` (`uuid`),
  KEY `sub_sub_categories_sub_category_id_foreign` (`sub_category_id`),
  CONSTRAINT `sub_sub_categories_sub_category_id_foreign` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_sub_categories`
--

LOCK TABLES `sub_sub_categories` WRITE;
/*!40000 ALTER TABLE `sub_sub_categories` DISABLE KEYS */;
INSERT INTO `sub_sub_categories` VALUES (1,'Computer Science','computer-science','74d3bea5-d2ca-4b32-bb5e-ce6dc7c2deed','Enim aut nemo sunt.',NULL,1,1,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(2,'Mathematics','mathematics','69068a42-afa6-43ec-b0ff-666e9c29b12c','Quos sint et sapiente perferendis nobis quia odio.',NULL,1,2,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(3,'Physics','physics','2dfa7ba6-308c-4c68-88e3-9df720b82071','Sit rerum tenetur est ea et facere.',NULL,1,3,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(4,'Chemistry','chemistry','7f46bafc-6602-49f5-9eb8-8e8e9144b384','Consequatur qui exercitationem unde.',NULL,1,4,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(5,'Biology','biology','7b834da0-2a0d-4cf5-808d-2140d57915b4','Velit veritatis qui voluptas maxime dolorem et.',NULL,1,5,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(6,'Medicine','medicine','76d6cedd-fb76-4790-9dcf-91c33ca28572','Eum et vero est explicabo nisi distinctio atque consequatur.',NULL,1,6,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(7,'Engineering','engineering','9dd87891-ced4-4e00-97e6-9226fe63789c','Neque veritatis nulla nesciunt voluptas aut praesentium eligendi.',NULL,1,7,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(8,'Agriculture','agriculture','dbf8b202-5d3c-406b-8005-53dfb92a2409','Et sunt eligendi rerum atque sunt velit dolorem placeat.',NULL,1,8,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(9,'Economics','economics','682fa699-ecea-4030-9dec-e2eb72ac7361','Tempore qui qui minus consequuntur.',NULL,1,9,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(10,'Law','law','0ed0944a-9ccb-4615-a3c1-e0fd9fb793b4','Eveniet id quos voluptatem voluptatem.',NULL,1,10,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(11,'Education','education','2e63c28e-1a76-45a3-8bc4-c27b92be8709','Nostrum rerum repellendus cum saepe est voluptates dolorem.',NULL,1,11,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(12,'Arts','arts','c58d35fd-5b64-4758-b5df-aca8f223ba4e','Culpa nemo ut eius eius laboriosam quia.',NULL,1,12,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(13,'Social Sciences','social-sciences','f8b2ead7-b435-40d8-8997-2a27dbe074e7','Quia accusantium cupiditate ut eum.',NULL,1,13,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(14,'Humanities','humanities','c34506e1-fd0f-43a8-a545-b2daf4c21ad1','Unde est enim eligendi sit nihil aperiam consequuntur.',NULL,1,14,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(15,'Environmental Sciences','environmental-sciences','d51e9237-4316-4f57-9854-98cbb496db9b','Officia praesentium quis excepturi exercitationem odit porro.',NULL,1,15,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(16,'Management','management','6eb18181-c2f3-41a5-99a6-1adf377aec4b','Quae ut tempora ea voluptas ut.',NULL,1,16,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(17,'Accounting','accounting','e5014996-23e1-444d-adce-978105f28451','Odit ducimus praesentium veniam tenetur perspiciatis sed nulla.',NULL,1,17,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(18,'Finance','finance','ca018e77-faeb-42af-aa41-b8b0824211ba','Qui est itaque labore.',NULL,1,18,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(19,'Marketing','marketing','fdd270cd-cd8f-4696-819e-3c53b686e98d','Omnis id ex quidem corporis id totam.',NULL,1,19,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(20,'Business Administration','business-administration','7de925d7-2876-403d-b8ed-237fb368f983','Fugit fuga molestiae repudiandae.',NULL,1,20,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(21,'Public Administration','public-administration','cd5eec01-e251-47fd-8a4e-66de40336cd8','Occaecati quasi voluptatem sint vel nostrum maxime fugiat.',NULL,1,21,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(22,'Political Science','political-science','81f4deb2-bd81-4aed-b83a-d056cdb5afde','Eos libero error accusamus et laboriosam et vel.',NULL,1,22,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(23,'International Relations','international-relations','1ec882af-178b-4d3d-9df6-30dcbcab691d','Pariatur reiciendis odio totam omnis exercitationem et.',NULL,1,23,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(24,'History','history','e2ed3c82-3de4-441b-b7a4-f0554518a7c0','Officiis eos nemo dignissimos velit nihil.',NULL,1,24,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(25,'Geography','geography','b4421bbf-873d-46e4-9583-a562d11970b4','Blanditiis blanditiis sunt cumque accusamus sunt ipsam eius.',NULL,1,25,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(26,'Philosophy','philosophy','f1360644-cae2-4ce6-927d-5ef86c0ee1ef','Dolorum qui sunt voluptates voluptate tempore dolorem quia.',NULL,1,26,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(27,'Religion','religion','03a0beba-6365-4b23-81c4-b38dea60ceed','Architecto reprehenderit quasi fugit aut.',NULL,1,27,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(28,'Library and Information Science','library-and-information-science','547576ed-cd97-420e-ba4c-0b4131717627','Quia rerum eum et iste qui ea doloremque recusandae.',NULL,1,28,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(29,'Mass Communication','mass-communication','c607896a-9ca3-4920-964e-7da9ef64defa','Quos aut autem harum omnis architecto sunt nisi.',NULL,1,29,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(30,'Psychology','psychology','09120cb1-8d2a-4e92-bddc-209389e0470a','Deleniti ut est et nostrum sunt.',NULL,1,30,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(31,'Sociology','sociology','c2dbad86-5994-4848-96a2-c1075e878da3','Fugit rerum quam facilis et fugiat.',NULL,1,31,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(32,'Anthropology','anthropology','b17a0199-7563-4735-a4ce-1b683189d38b','Quibusdam eius voluptatem ipsum eius.',NULL,1,32,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(33,'Archaeology','archaeology','04d0b8c4-5b85-4d11-bcac-b5b1b0d52af6','Placeat quod et adipisci enim provident dolores sed.',NULL,1,33,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(34,'Linguistics','linguistics','ab706b07-13e8-4b18-9b12-8e07e6cae2c4','Aut non harum adipisci quo voluptatum.',NULL,1,34,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(35,'Literature','literature','b9d6f00b-e0f9-41fc-a37c-980b7f437191','Eum expedita qui culpa ut.',NULL,1,35,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(36,'Performing Arts','performing-arts','d0dae49c-07af-4de7-a714-292e8af84e53','Praesentium vero esse autem impedit.',NULL,1,36,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(37,'Visual Arts','visual-arts','48cbd323-b483-44e4-97cd-bd0cfa57c1c9','Aut natus laborum ducimus nesciunt dolorem.',NULL,1,37,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(38,'Music','music','e46ff6ea-1ac2-4bd5-9789-32b533c83585','Amet repudiandae nulla est tenetur ipsa vel.',NULL,1,38,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(39,'Film Studies','film-studies','893712e6-5a4c-47c1-b7c5-a908ac4c772a','Ab distinctio expedita consequatur magni velit consequatur.',NULL,1,39,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(40,'Dance','dance','d6727be7-c08a-42c2-bf3c-eb3793903c40','Quaerat qui quam aut consectetur.',NULL,1,40,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(41,'Sports','sports','9756c28f-ce7d-4407-afeb-4acf767a82a7','Voluptate aspernatur laborum voluptatum recusandae.',NULL,1,41,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(42,'Tourism','tourism','cc60031d-95fd-41c5-adb4-36b070c8505f','Cumque quibusdam blanditiis aut aperiam.',NULL,1,42,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(43,'Hospitality','hospitality','101073dd-ee42-44c7-84fc-e5b736ef8c88','Rerum enim placeat modi velit.',NULL,1,43,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(44,'Culinary Arts','culinary-arts','30b28e7c-ebcd-4cf2-8d22-410fccd9a4b0','Fuga necessitatibus voluptatibus blanditiis dolorem.',NULL,1,44,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(45,'Fashion','fashion','3349a962-c126-4d07-be7f-754bb19f7cab','Exercitationem omnis recusandae quia quasi neque.',NULL,1,45,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(46,'Textile','textile','a56c9175-834a-4a04-ba70-39241374f50e','Vero est impedit quo harum rerum earum.',NULL,1,46,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(47,'Architecture','architecture','9bf7a07c-4216-482e-95d9-a9f6be65b917','Consequatur blanditiis fugit laboriosam non.',NULL,1,47,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(48,'Urban Planning','urban-planning','fe94a1f7-51c8-4792-bdb1-257d85e13d27','Aut et sunt et fuga.',NULL,1,48,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(49,'Genetic Engineering','genetic-engineering','17c4db8e-b46a-4af5-a9f0-0b8b7a9d61d9','Tempora deserunt ut sint error voluptate consequuntur.',NULL,1,49,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(50,'Industrial Engineering','industrial-engineering','cf4b4512-ade3-4f83-b146-2c09c3296f26','Dolores dolore totam sunt.',NULL,1,50,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(51,'Rural Planning','rural-planning','aeda6838-7f59-40ab-9442-eac0a14a7afc','Reiciendis quis eum nihil.',NULL,1,51,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(52,'Transportation`','transportation','21ffd25e-aaca-4355-900d-e3a3f44a874a','A tenetur consectetur ipsa doloremque perspiciatis repudiandae.',NULL,1,52,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(53,'Communication Engineering','communication-engineering','e0ff8643-3b38-41d6-af4f-08aed243060f','Cupiditate nulla nihil autem blanditiis suscipit.',NULL,1,53,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(54,'Computer Engineering','computer-engineering','c6eb534c-6d58-4b68-9584-968d6d9f7274','Vel ullam aut similique et.',NULL,1,54,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(55,'Electrical Engineering','electrical-engineering','1135c634-27ab-4819-bf19-cf2faabec365','Repellendus reiciendis est ex fuga rerum.',NULL,1,55,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(56,'Mechanical Engineering','mechanical-engineering','47ee7db4-26f6-450a-b138-f0c87c68cbbe','Voluptas dicta qui autem dicta doloribus aut voluptatem.',NULL,1,56,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(57,'Civil Engineering','civil-engineering','705fce63-75e2-4d93-af24-bd1ef448da2f','Rem aut ut explicabo odit doloribus.',NULL,1,57,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(58,'Chemical Engineering','chemical-engineering','7491e699-feb8-49ab-a3a8-65b42e1da177','Sed nesciunt maxime assumenda aut iusto.',NULL,1,58,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(59,'Petroleum Engineering','petroleum-engineering','21d4be11-c616-4519-a093-b3dd1dec3d9b','Nobis sunt ea velit odit mollitia nulla soluta.',NULL,1,59,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(60,'Mining Engineering','mining-engineering','0b125074-4a3c-4345-a500-897312754dc3','Iure temporibus enim itaque ut et occaecati est.',NULL,1,60,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(61,'Metallurgical Engineering','metallurgical-engineering','3443976a-1f80-44f7-9bc5-9b33b597a882','At adipisci rerum dignissimos neque ut.',NULL,1,61,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(62,'Materials Engineering','materials-engineering','0f4f4258-0150-4016-9dcf-058db089ed0c','Quasi voluptate suscipit qui dolor.',NULL,1,62,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(63,'Biomedical Engineering','biomedical-engineering','bd306e61-dcf9-463c-a062-7eeeb83bf644','Rerum dolor nostrum ab hic.',NULL,1,63,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(64,'Manufacturing Engineering','manufacturing-engineering','c1bec415-f3d2-444d-8329-ae87b0382d0d','Quia ipsum fugiat quod rerum.',NULL,1,64,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(65,'Textile Engineering','textile-engineering','e6aa5368-b906-4d77-9a05-599e1faf7f7c','Incidunt voluptatem recusandae impedit nihil.',NULL,1,65,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(66,'Aerospace Engineering','aerospace-engineering','0246bae6-f2bc-49a3-ad03-e9915352b3f6','Voluptates maiores tempore quis reiciendis eius velit quia eveniet.',NULL,1,66,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(67,'Nuclear Engineering','nuclear-engineering','d5ed3a6b-3037-4819-b3b2-4c161b5e8f48','Quasi quos enim eum quo voluptas dolorem laborum.',NULL,1,67,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(68,'Marine Engineering','marine-engineering','90be5568-6d11-4ddf-b304-51637662f6dd','Vero fugiat quidem eius unde sit.',NULL,1,68,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(69,'Ocean Engineering','ocean-engineering','668fbf86-c87f-421b-b773-da4569a304d5','Odio quia et minus ex ratione.',NULL,1,69,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(70,'Water Resources Engineering','water-resources-engineering','024067c3-f399-42ab-84ec-2ad014bc3d83','Voluptates saepe neque ea.',NULL,1,70,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(71,'Geotechnical Engineering','geotechnical-engineering','451ba0db-634d-4e26-949a-fa51f613339b','Vel similique ut tempore sunt rerum.',NULL,1,71,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(72,'Structural Engineering','structural-engineering','e68a6754-aac0-40dc-b0bf-386cd8e86048','Odio voluptates modi earum voluptas.',NULL,1,72,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(73,'Transportation` Engineering','transportation-engineering','b7507239-2f43-4087-86ee-422ab057e36b','Facilis hic vitae rerum dolorem voluptates.',NULL,1,73,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(74,'Surveying Engineering','surveying-engineering','e08771a9-46a6-4275-9ec2-9ac9017ea41c','Iusto illo repudiandae eum delectus rerum molestias quia.',NULL,1,74,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(75,'Urban Engineering','urban-engineering','d9128713-5b76-4ed2-a931-7027a9d7260f','Laborum quia in maiores nihil praesentium ut.',NULL,1,75,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(76,'Regional Engineering','regional-engineering','439631db-cf03-4f00-bc54-32155c9e3dd3','Labore similique quas dolorum totam veritatis.',NULL,1,76,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(77,'Rural Engineering','rural-engineering','f0d515a2-66ae-4c9f-94e8-77040ba623a6','Maiores expedita nam vel qui nisi reiciendis recusandae rerum.',NULL,1,77,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(78,'Environmental Engineering','environmental-engineering','5b63c26d-dca8-4aae-8269-47ac23fa97df','Ratione dolor odit ipsa autem optio beatae.',NULL,1,78,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(79,'Agricultural Engineering','agricultural-engineering','6558ff2b-5f76-4791-8541-bd14d2983f42','Neque nam voluptates modi dignissimos vitae totam rerum.',NULL,1,79,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(80,'Food Engineering','food-engineering','0fe0bfbf-620a-4ad8-89d4-a0de6eed667e','Doloribus laboriosam amet consequuntur cupiditate cum debitis eligendi.',NULL,1,80,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06'),(81,'Biological Engineering','biological-engineering','f0952775-00d1-4a54-aae9-a5d72d2c081b','Saepe sunt vitae ut incidunt quasi labore quia et.',NULL,1,81,NULL,NULL,NULL,'2024-10-21 18:58:06','2024-10-21 18:58:06');
/*!40000 ALTER TABLE `sub_sub_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_interests`
--

DROP TABLE IF EXISTS `user_interests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_interests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `interests` json NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_interests_user_id_foreign` (`user_id`),
  CONSTRAINT `user_interests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_interests`
--

LOCK TABLES `user_interests` WRITE;
/*!40000 ALTER TABLE `user_interests` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_interests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `is_first_login` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `institution` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_uuid_unique` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin User','admin','admin@example.com','Nigeria','2024-10-21 18:58:07','$2y$12$O.0l.y9GGuJZe/vrgqEP5eaKyvHFRAfuMYiemOwzwCuxAqEOMOnQS','13ab67f0-f314-48f7-93cc-018f2786f077','https://via.placeholder.com/150',NULL,1,1,NULL,'2024-10-21 18:58:07','2024-10-21 18:58:07',NULL),(2,'Editor User','editor','editor@example.com','Nigeria','2024-10-21 18:58:07','$2y$12$/Ozm.7hDxWrhJVTTei60OOjak1b9ZXQZFZHeMyvTKUkFm.sq31saa','d2242327-82fc-48cc-8673-73ece5b9bec9','https://via.placeholder.com/150',NULL,1,1,NULL,'2024-10-21 18:58:07','2024-10-21 18:58:07',NULL),(3,'Author User','author','author@example.com','Nigeria','2024-10-21 18:58:07','$2y$12$Lxfhlzrop2G7bhONrc3SYOEqbRYnR4KVnn5BjgKttCIqgNvuR5B/K','c14bb524-819d-419e-bfc8-7ebf900a3e3d','https://via.placeholder.com/150',NULL,1,1,NULL,'2024-10-21 18:58:07','2024-10-21 18:58:07',NULL),(4,'Publisher User','publisher','publisher@example.com','Nigeria','2024-10-21 18:58:08','$2y$12$yiN7SiYw.WFUm.dPO9WkvecoA5h7OAM.wYPoqZXJL8YognNTvR/pW','9956b8a8-efde-45fa-b5d8-287829cec436','https://via.placeholder.com/150',NULL,1,1,NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08',NULL),(5,'Reviewer User','reviewer','reviewer@example.com','Nigeria','2024-10-21 18:58:08','$2y$12$2DRqrZHT7Puqetdcz4cyXOUm.Rk/hkPnyKGuzxL.L/Zc5auELhPWK','8b6237ed-5564-4792-bfb1-1c0057bf8653','https://via.placeholder.com/150',NULL,1,1,NULL,'2024-10-21 18:58:08','2024-10-21 18:58:08',NULL),(6,'Afe Reviewer','afereviewer','afe@example.com','Nigeria','2024-10-21 18:58:09','$2y$12$F.Jq8y14E1Gxfi0TEoGcRuAUC3ZZRR5G/Oh6uP/HJQjdBVdZWgPZO','f1764917-a30e-4628-b8b1-3ccafbfa4353','https://via.placeholder.com/150',NULL,1,1,NULL,'2024-10-21 18:58:09','2024-10-21 18:58:09',NULL),(7,'Nani Reviewer','nani','nani@example.com','Nigeria','2024-10-21 18:58:10','$2y$12$1MJQgt1Q34YC/LjuPdoSHODNJ8ebrN2ZLeuMhVO2UdLg.PO/ZfMtG','13e0822e-6e83-4762-9907-96b5a3021109','https://via.placeholder.com/150',NULL,1,1,NULL,'2024-10-21 18:58:10','2024-10-21 18:58:10',NULL),(8,'John Reviewer','john','john@example.com','Nigeria','2024-10-21 18:58:10','$2y$12$ECQg1jYmxH9kqVX7PNBGL.Xw8g8G0TtjqLPtnmN3sIjcr7i6r1ZAe','f86ba423-3745-4bf0-941e-b1437d8783cd','https://via.placeholder.com/150',NULL,1,1,NULL,'2024-10-21 18:58:10','2024-10-21 18:58:10',NULL);
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

-- Dump completed on 2024-10-21 21:06:08
