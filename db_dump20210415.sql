-- MySQL dump 10.13  Distrib 8.0.23, for Linux (x86_64)
--
-- Host: localhost    Database: met
-- ------------------------------------------------------
-- Server version	8.0.23-0ubuntu0.20.04.1

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
-- Table structure for table `avatar`
--

DROP TABLE IF EXISTS `avatar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `avatar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avatar`
--

LOCK TABLES `avatar` WRITE;
/*!40000 ALTER TABLE `avatar` DISABLE KEYS */;
/*!40000 ALTER TABLE `avatar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `badge`
--

DROP TABLE IF EXISTS `badge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `badge` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `badge`
--

LOCK TABLES `badge` WRITE;
/*!40000 ALTER TABLE `badge` DISABLE KEYS */;
/*!40000 ALTER TABLE `badge` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `department` (
  `id` int NOT NULL AUTO_INCREMENT,
  `dept_nb` int DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text,
  `map_coords` varchar(100) DEFAULT NULL,
  `initial_error_margin` int DEFAULT NULL,
  `instructions` varchar(255) DEFAULT NULL,
  `point_unit` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (1,1,'Aile Américaine','Aujourd\'hui, la collection en constante évolution de l\'aile américaine comprend quelque 20 000 œuvres d\'artistes afro-américains, euro-américains, amérindiens et latino-américains, allant de la période coloniale à la période moderne.','1219,156,1219,233,1233,234,1234,374,1398,387,1396,154',50,'instructions',50),(2,3,'Arts anciens du Proche-Orient','La collection d\'art ancien du Proche-Orient du Musée comprend plus de 7000 œuvres datant du huitième millénaire avant notre ère.','510,625,1050,625,1053,728,547,730,543,744,511,744',50,'instructions',50),(3,4,'Armes et Armures','Les principaux objectifs du Département des armes et des armures sont de collecter, de préserver, de rechercher, de publier et d\'exposer des exemples distingués représentant l\'art de l\'armurier, du forgeron et du fabricant d\'armes à feu.  ','1233,382,1085,383,1083,234,1231,236',50,'instructions',50),(4,5,'Arts d\'Afrique, d\'Océanie et des Amériques','La collection d\'art océanique du Met comprend plus de 2800 œuvres qui présentent la riche histoire de l\'expression créative et de l\'innovation emblématique des îles du Pacifique.','325,620,502,625,508,747,547,745,544,773,323,772',50,'instructions',50),(5,6,'Art Asiatique','Le Département d\'art asiatique remplit un rôle unique au Met en représentant les réalisations artistiques de six grandes traditions culturelles qui englobent 5000 ans d\'histoire.','1055,625,1052,726,1216,729,1216,774,1451,774,1443,615,1321,613,1317,393,1263,392,1255,603',50,'instructions',50),(6,10,'Art Egyptien','La collection d\'art égyptien antique du Met se compose d\'environ 26 000 objets d\'importance artistique, historique et culturelle, datant du paléolithique à la période romaine (environ 300 000 av.J.-C. - IVe siècle).','359,150,357,375,396,374,398,244,546,243,544,151',50,'instructions',50),(7,11,'Peintures Européennes','La célèbre collection de peintures européennes du Met comprend plus de 2 500 œuvres d\'art du XIIIe au début du XXe siècle.','653,233,1070,234,1069,491,653,500',50,'instructions',50),(8,12,'Sculpture Européenne et Art Décoratif','Les 50 000 objets de la collection complète de sculptures et d\'arts décoratifs européens du Musée reflètent le développement d\'un certain nombre de formes d\'art dans les pays d\'Europe occidentale du début du XVe au début du XXe siècle.','1075,396,1073,496,1256,500,1251,392',50,'instructions',50),(9,13,'Art Grec et Romain','La collection d\'art grec et romain du musée comprend plus de 30000 œuvres allant de la période néolithique (environ 4500 avant JC) à l\'époque de la conversion de l\'empereur romain Constantin au christianisme en 312 après JC.','341,382,532,382,531,594,342,597',50,'instructions',50),(10,14,'Art Islamique','La collection d\'art islamique du Met est l\'une des plus complètes au monde et date du VIIe au XXIe siècle. Ses plus de 15 000 objets reflètent la grande diversité et l\'éventail des traditions culturelles de l\'Espagne à l\'Indonésie.','407,248,406,375,544,374,545,363,498,362,498,332,543,333,547,251',50,'instructions',50),(11,17,'Art Médiéval','La collection d\'art médiéval et byzantin du Musée est parmi les plus complètes au monde, englobant l\'art de la Méditerranée et de l\'Europe de la chute de Rome au début de la Renaissance.','551,229,646,230,647,458,553,458',50,'instructions',50),(12,19,'Photographies','Établi en tant que département de conservation indépendant en 1992, le département des photographies du Met abrite une collection d\'environ 75 000 œuvres couvrant l\'histoire de la photographie depuis son invention dans les années 1830 jusqu\'à nos jours.','532,464,645,467,646,500,980,498,977,619,541,622,535,594\"',50,'instructions',50),(13,21,'Art Moderne','Ca ne peut pas attendre?','501,336,503,358,552,359,551,338',50,'instructions',50);
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `avatar_id` int DEFAULT NULL,
  `count_game` int DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Gisele',NULL,1,NULL,NULL,NULL),(2,'Truffe',NULL,1,NULL,NULL,NULL),(3,'Gogogh',NULL,2,NULL,NULL,NULL),(4,'Mbappe',NULL,3,NULL,NULL,NULL),(5,'Merlin l\'enchanteur',NULL,3,NULL,NULL,NULL),(6,'Indiana Jones',NULL,5,NULL,NULL,NULL),(7,'Lara Croft',NULL,5,NULL,NULL,NULL),(8,'Rintintin',NULL,2,NULL,NULL,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_badge`
--

DROP TABLE IF EXISTS `user_badge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_badge` (
  `user_id` int DEFAULT NULL,
  `badge_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_badge`
--

LOCK TABLES `user_badge` WRITE;
/*!40000 ALTER TABLE `user_badge` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_badge` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_department`
--

DROP TABLE IF EXISTS `user_department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_department` (
  `user_id` int DEFAULT NULL,
  `department_id` int DEFAULT NULL,
  `best_score` int DEFAULT NULL,
  KEY `fk_userdepartment_user` (`user_id`),
  CONSTRAINT `fk_userdepartment_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_department`
--

LOCK TABLES `user_department` WRITE;
/*!40000 ALTER TABLE `user_department` DISABLE KEYS */;
INSERT INTO `user_department` VALUES (1,1,50),(2,1,250),(3,1,550),(4,1,15000),(5,1,475),(6,1,1350),(7,1,2350),(1,2,100),(2,3,780),(3,4,999),(4,5,1050),(5,6,3560),(6,7,750),(7,8,2560),(1,8,860),(2,8,4500),(3,8,800),(4,8,780),(4,7,6000);
/*!40000 ALTER TABLE `user_department` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-04-15  0:34:20
