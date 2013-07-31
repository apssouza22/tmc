CREATE DATABASE  IF NOT EXISTS `tmc` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `tmc`;
-- MySQL dump 10.13  Distrib 5.5.32, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: tmc
-- ------------------------------------------------------
-- Server version	5.5.32-0ubuntu0.12.04.1

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
-- Table structure for table `chamado`
--

DROP TABLE IF EXISTS `chamado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chamado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `tecnico` varchar(255) DEFAULT NULL,
  `descricao` text,
  `dataabertura` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `datafechamento` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `problema` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chamado`
--

LOCK TABLES `chamado` WRITE;
/*!40000 ALTER TABLE `chamado` DISABLE KEYS */;
INSERT INTO `chamado` VALUES (128,1,NULL,'Chamado aberto automaticamente por queda de equipamentos &lt;br&gt; IP: 192.168.1.102','2013-07-27 20:09:04',NULL,1,NULL),(129,2,NULL,'Chamado aberto automaticamente por queda de equipamentos &lt;br&gt; IP: 192.168.1.111','2013-07-27 20:09:07','2013-07-27 20:26:53',0,NULL),(130,2,NULL,'Chamado aberto automaticamente por queda de equipamentos &lt;br&gt; IP: 192.168.2.7','2013-07-27 20:09:17',NULL,2,'NULL'),(131,3,NULL,'Chamado aberto automaticamente por queda de equipamentos &lt;br&gt; IP:  192.168.2.3','2013-07-27 20:09:27','2013-07-27 20:12:04',0,NULL),(132,1,NULL,'Chamado aberto automaticamente por queda de equipamentos &lt;br&gt; IP:  192168.5.1','2013-07-27 20:09:27','2013-07-27 20:11:58',2,'jasdfl'),(133,1,NULL,'Chamado aberto automaticamente por queda de equipamentos &lt;br&gt; IP: 192168.5.1','2013-07-27 20:09:27','2013-07-27 20:33:57',0,NULL),(134,1,NULL,'Chamado aberto automaticamente por queda de equipamentos &lt;br&gt; IP:  192.168.25.222','2013-07-27 20:29:51','2013-07-27 20:31:42',2,NULL),(135,1,NULL,'verificaro sinal baixo do radio','2013-07-27 21:45:51',NULL,0,'tinha agua no conector'),(136,1,NULL,'Chamado aberto automaticamente por queda de equipamentos &lt;br&gt; IP:  192.168.50.237','2013-07-27 21:52:22','2013-07-27 21:53:41',2,NULL),(137,2,NULL,'Chamado aberto automaticamente por queda de equipamentos &lt;br&gt; IP:  192.168.50.237','2013-07-27 21:52:22','2013-07-27 21:53:41',2,NULL),(138,1,NULL,'Chamado aberto automaticamente por queda de equipamentos &lt;br&gt; IP:  192.168.50.237','2013-07-27 21:58:51','2013-07-27 21:59:41',2,NULL),(139,1,NULL,'Chamado aberto automaticamente por queda de equipamentos &lt;br&gt; IP:  192.168.50.237','2013-07-27 22:11:51','2013-07-27 22:12:41',2,NULL),(140,1,NULL,'Chamado aberto automaticamente por queda de equipamentos &lt;br&gt; IP:  192.168.50.237','2013-07-27 22:13:51','2013-07-27 22:14:41',2,NULL),(141,2,NULL,'Chamado aberto automaticamente por queda de equipamentos &lt;br&gt; IP:  192.168.50.237','2013-07-27 22:50:51',NULL,1,NULL),(142,1,NULL,'Chamado aberto automaticamente por queda de equipamentos &lt;br&gt; IP:  192.168.50.237','2013-07-27 22:51:51',NULL,1,NULL);
/*!40000 ALTER TABLE `chamado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cliente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `empresa` varchar(245) DEFAULT NULL,
  `nome_responsavel` varchar(245) DEFAULT NULL,
  `email` varchar(145) DEFAULT NULL,
  `telefone` varchar(45) DEFAULT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `bairro` varchar(145) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `estado` varchar(3) DEFAULT NULL,
  `datacadastro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) DEFAULT '1',
  `clientecol` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (1,'apssouza',NULL,'apssouza22@gmail.com','76184253','rua alvaro ferreira',NULL,NULL,NULL,NULL,'0000-00-00 00:00:00',1,NULL),(2,'apssystem','Mateus','apssouza22@gmail.com','76184253','endereco do escritorio','05874020','bairro ','cidade ','sp','0000-00-00 00:00:00',1,NULL),(3,'Ma Systemas inteligentes','Alexsandro souza','alex@souzasystemas.com','76184253 /28432471','Rua funchal,20','05874020','vila olimpia','são paulo','sp','2013-03-15 15:49:15',0,NULL);
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
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
INSERT INTO `cms_usuario` VALUES (5,'Cícero Lourenço','cicerolourenco@yahoo.com','011',''),(15,'Marcia','marcia@gmail.com','',NULL),(17,'Alexsandro','apssouza22@gmail.com','011',NULL);
/*!40000 ALTER TABLE `cms_usuario` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Table structure for table `equipamento`
--

DROP TABLE IF EXISTS `equipamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipamento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `ip` varchar(45) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_radio_Cliente_idx` (`cliente_id`),
  CONSTRAINT `fk_radio_Cliente` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipamento`
--

LOCK TABLES `equipamento` WRITE;
/*!40000 ALTER TABLE `equipamento` DISABLE KEYS */;
INSERT INTO `equipamento` VALUES (1,1,'192.168.1.102','repetidora morumbi',1),(2,1,'127.0.0.1','localhost',1),(3,2,'192.168.1.111 ','roteador de internet',1),(4,2,'192.168.2.7','ubuntu',1),(5,3,' 192.168.2.3','win7',1),(6,1,' 192168.5.1','sede teste',1),(8,1,' 192.168.50.237','teste no ale',1),(9,2,' 192.168.50.237','roteador lan-to-lan',1);
/*!40000 ALTER TABLE `equipamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `queda`
--

DROP TABLE IF EXISTS `queda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `queda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chamado_id` int(11) NOT NULL,
  `equip_id` int(11) NOT NULL,
  `datainicio` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `datafim` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_queda_radio1_idx` (`equip_id`),
  CONSTRAINT `fk_queda_radio1` FOREIGN KEY (`equip_id`) REFERENCES `equipamento` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `queda`
--

LOCK TABLES `queda` WRITE;
/*!40000 ALTER TABLE `queda` DISABLE KEYS */;
INSERT INTO `queda` VALUES (82,128,1,'2013-07-27 20:09:04',NULL,1),(83,129,3,'2013-07-27 20:09:07',NULL,1),(84,130,4,'2013-07-27 20:09:17',NULL,1),(85,131,5,'2013-07-27 20:09:27',NULL,1),(86,132,6,'2013-07-27 20:09:27',NULL,1),(88,134,8,'2013-07-27 20:29:51','2013-07-27 22:14:42',0),(89,136,8,'2013-07-27 21:52:22','2013-07-27 22:14:42',0),(90,137,9,'2013-07-27 21:52:23','2013-07-27 21:53:41',0),(91,138,8,'2013-07-27 21:58:51','2013-07-27 22:14:42',0),(92,139,8,'2013-07-27 22:11:51','2013-07-27 22:14:42',0),(93,140,8,'2013-07-27 22:13:51','2013-07-27 22:14:42',0),(94,141,9,'2013-07-27 22:50:51',NULL,1),(95,142,8,'2013-07-27 22:51:52',NULL,1);
/*!40000 ALTER TABLE `queda` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tecnico`
--

DROP TABLE IF EXISTS `tecnico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tecnico` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(245) DEFAULT NULL,
  `email` varchar(245) DEFAULT NULL,
  `celular` varchar(45) DEFAULT NULL,
  `rg` varchar(45) DEFAULT NULL,
  `datanascimento` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tecnico`
--

LOCK TABLES `tecnico` WRITE;
/*!40000 ALTER TABLE `tecnico` DISABLE KEYS */;
/*!40000 ALTER TABLE `tecnico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `datacadastro` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-07-30 21:38:22
