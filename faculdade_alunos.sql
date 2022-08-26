-- MySQL dump 10.13  Distrib 8.0.29, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: faculdade
-- ------------------------------------------------------
-- Server version	8.0.30-0ubuntu0.20.04.2

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
-- Table structure for table `alunos`
--

DROP TABLE IF EXISTS `alunos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `alunos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) DEFAULT NULL,
  `sobrenome` varchar(150) DEFAULT NULL,
  `data_nascimento` date DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `rg` varchar(11) DEFAULT NULL,
  `cpf` varchar(11) DEFAULT NULL,
  `nome_mae` varchar(150) DEFAULT NULL,
  `nome_pai` varchar(150) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alunos`
--

LOCK TABLES `alunos` WRITE;
/*!40000 ALTER TABLE `alunos` DISABLE KEYS */;
INSERT INTO `alunos` VALUES (17,'Felipe','Almeida Ferraz','1992-08-06','almeidaferraz@gmail.com','14589000745','01337878006','Jurrasi Almeida Martins','Augusto Tomas Ferraz','2022-08-26 05:41:40','2022-08-26 05:50:44'),(18,'Eloísa','Ferreira Gomes','1992-09-08','eloisagomes@gmail.com','46878522222','69519320008','Aldaira Martins Ferrira','Rogerio Etzel Gomes','2022-08-26 05:43:10','2022-08-26 05:43:41'),(19,'Emilio','Feitosa Neto','1979-08-09','emilioneto@yahoo.com','11698822244','86642602064','Erminda Feitosa dos Santos','Aldair Conceição Neto','2022-08-26 05:45:26','2022-08-26 05:45:26'),(20,'Jurassi','Miguez Lima','1997-08-09','jurramiguez@outlook.com','45878222288','86954238082','Edivania Marcondes Miguez','Aldenor Ferreira Lima','2022-08-26 05:47:36','2022-08-26 05:50:25');
/*!40000 ALTER TABLE `alunos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-08-25 23:59:46
