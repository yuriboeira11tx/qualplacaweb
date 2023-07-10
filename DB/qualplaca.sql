-- MariaDB dump 10.19  Distrib 10.4.28-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: qualplaca
-- ------------------------------------------------------
-- Server version	10.4.28-MariaDB

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
-- Table structure for table `avaliacao`
--

DROP TABLE IF EXISTS `avaliacao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `avaliacao` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_Id` int(11) NOT NULL,
  `placa_Id` int(11) NOT NULL,
  `valor` int(11) DEFAULT NULL,
  `comentario` varchar(500) DEFAULT NULL,
  `data` datetime NOT NULL,
  PRIMARY KEY (`Id`,`usuario_Id`,`placa_Id`),
  KEY `fk_usuario_has_placa_placa2_idx` (`placa_Id`),
  KEY `fk_usuario_has_placa_usuario2_idx` (`usuario_Id`),
  CONSTRAINT `fk_usuario_has_placa_placa2` FOREIGN KEY (`placa_Id`) REFERENCES `placa` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_has_placa_usuario2` FOREIGN KEY (`usuario_Id`) REFERENCES `usuario` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avaliacao`
--

LOCK TABLES `avaliacao` WRITE;
/*!40000 ALTER TABLE `avaliacao` DISABLE KEYS */;
/*!40000 ALTER TABLE `avaliacao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fabricante`
--

DROP TABLE IF EXISTS `fabricante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fabricante` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fabricante`
--

LOCK TABLES `fabricante` WRITE;
/*!40000 ALTER TABLE `fabricante` DISABLE KEYS */;
INSERT INTO `fabricante` VALUES (1,'Nvidia'),(2,'AMD'),(3,'Intel');
/*!40000 ALTER TABLE `fabricante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `favorito`
--

DROP TABLE IF EXISTS `favorito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `favorito` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_Id` int(11) NOT NULL,
  `placa_Id` int(11) NOT NULL,
  PRIMARY KEY (`Id`,`usuario_Id`,`placa_Id`),
  KEY `fk_usuario_has_placa_placa1_idx` (`placa_Id`),
  KEY `fk_usuario_has_placa_usuario1_idx` (`usuario_Id`),
  CONSTRAINT `fk_usuario_has_placa_placa1` FOREIGN KEY (`placa_Id`) REFERENCES `placa` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_has_placa_usuario1` FOREIGN KEY (`usuario_Id`) REFERENCES `usuario` (`Id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorito`
--

LOCK TABLES `favorito` WRITE;
/*!40000 ALTER TABLE `favorito` DISABLE KEYS */;
/*!40000 ALTER TABLE `favorito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marca`
--

DROP TABLE IF EXISTS `marca`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marca` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marca`
--

LOCK TABLES `marca` WRITE;
/*!40000 ALTER TABLE `marca` DISABLE KEYS */;
INSERT INTO `marca` VALUES (1,'ASUS'),(2,'Gigabyte'),(3,'MSI'),(4,'EVGA'),(5,'Zotac'),(6,'Palit'),(7,'Sapphire'),(8,'Galax'),(9,'Palit'),(10,'Outra');
/*!40000 ALTER TABLE `marca` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `placa`
--

DROP TABLE IF EXISTS `placa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `placa` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) DEFAULT NULL,
  `marca_Id` int(11) NOT NULL,
  `preco` varchar(45) DEFAULT NULL,
  `fabricante_Id` int(11) NOT NULL,
  `vram` varchar(45) DEFAULT NULL,
  `clock` varchar(45) DEFAULT NULL,
  `consumo` varchar(45) DEFAULT NULL,
  `imagem` longblob NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `fk_placa_marca1_idx` (`marca_Id`),
  KEY `fk_placa_fabricante1_idx` (`fabricante_Id`),
  CONSTRAINT `fk_placa_fabricante1` FOREIGN KEY (`fabricante_Id`) REFERENCES `fabricante` (`Id`),
  CONSTRAINT `fk_placa_marca1` FOREIGN KEY (`marca_Id`) REFERENCES `marca` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `placa`
--

LOCK TABLES `placa` WRITE;
/*!40000 ALTER TABLE `placa` DISABLE KEYS */;
/*!40000 ALTER TABLE `placa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `placa_utilidade`
--

DROP TABLE IF EXISTS `placa_utilidade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `placa_utilidade` (
  `placa_id` int(11) NOT NULL,
  `utilidade_id` int(11) NOT NULL,
  PRIMARY KEY (`placa_id`,`utilidade_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `placa_utilidade`
--

LOCK TABLES `placa_utilidade` WRITE;
/*!40000 ALTER TABLE `placa_utilidade` DISABLE KEYS */;
/*!40000 ALTER TABLE `placa_utilidade` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) DEFAULT NULL,
  `email` varchar(60) DEFAULT NULL,
  `senha` varchar(45) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'ADM','adm@adm.com','adm','0'),(2,'USER','user@user.com','user','1');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilidade`
--

DROP TABLE IF EXISTS `utilidade`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utilidade` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilidade`
--

LOCK TABLES `utilidade` WRITE;
/*!40000 ALTER TABLE `utilidade` DISABLE KEYS */;
INSERT INTO `utilidade` VALUES (1,'Streaming'),(2,'Computação de Alto Desempenho'),(3,'Mineração de Criptomoedas'),(4,'Edição de Vídeo e Design Gráfico'),(5,'Jogos');
/*!40000 ALTER TABLE `utilidade` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-07-10 13:46:03
