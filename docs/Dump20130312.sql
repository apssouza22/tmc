CREATE DATABASE  IF NOT EXISTS `salvesocial` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `salvesocial`;
-- MySQL dump 10.13  Distrib 5.5.29, for debian-linux-gnu (i686)
--
-- Host: 64.207.176.53    Database: salvesocial
-- ------------------------------------------------------
-- Server version	5.1.54

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
-- Table structure for table `cms_usuario_modulo`
--

DROP TABLE IF EXISTS `cms_usuario_modulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_usuario_modulo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` int(10) unsigned NOT NULL,
  `id_modulo` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=154 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_usuario_modulo`
--

LOCK TABLES `cms_usuario_modulo` WRITE;
/*!40000 ALTER TABLE `cms_usuario_modulo` DISABLE KEYS */;
INSERT INTO `cms_usuario_modulo` VALUES (142,14,1),(141,14,2),(140,15,2),(139,0,1),(138,0,2),(137,14,1),(136,14,2),(143,14,2),(144,5,2),(145,5,1),(146,0,2),(147,0,1),(148,17,2),(149,17,1),(150,18,2),(151,18,1),(152,19,2),(153,19,1);
/*!40000 ALTER TABLE `cms_usuario_modulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_modulo`
--

DROP TABLE IF EXISTS `cms_modulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_modulo` (
  `id` int(10) unsigned NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `diretorio` varchar(255) DEFAULT NULL,
  `bool_ativo` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_modulo`
--

LOCK TABLES `cms_modulo` WRITE;
/*!40000 ALTER TABLE `cms_modulo` DISABLE KEYS */;
INSERT INTO `cms_modulo` VALUES (2,'notícias','noticias',1),(1,'usuários','usuarios',1);
/*!40000 ALTER TABLE `cms_modulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_usuario`
--

DROP TABLE IF EXISTS `cms_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_usuario` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `senha` varchar(60) DEFAULT NULL,
  `arquivo` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_usuario`
--

LOCK TABLES `cms_usuario` WRITE;
/*!40000 ALTER TABLE `cms_usuario` DISABLE KEYS */;
INSERT INTO `cms_usuario` VALUES (14,'Fabiana Rangel','fabiana@agenciasalve.com.br','011',''),(5,'Cícero Lourenço','cicerolourenco@yahoo.com','011',''),(15,'Marcia','marcia@gmail.com','',NULL),(17,'Alexsandro','apssouza22@gmail.com','011',NULL),(19,'salve','salve@agenciasalve.com.br','011',NULL);
/*!40000 ALTER TABLE `cms_usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-03-12 21:11:22
