-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: ferre_update
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `adm_departamento`
--

DROP TABLE IF EXISTS `adm_departamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adm_departamento` (
  `id_departamento` tinyint(2) NOT NULL AUTO_INCREMENT COMMENT 'llave primaria incremental',
  `departamento_nombre` varchar(150) NOT NULL COMMENT 'nombreo o descripcion del departamento',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_departamento`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adm_departamento`
--

LOCK TABLES `adm_departamento` WRITE;
/*!40000 ALTER TABLE `adm_departamento` DISABLE KEYS */;
INSERT INTO `adm_departamento` VALUES (1,'Ahuachapán','2017-03-01 16:28:35'),(2,'Cabañas','2017-03-01 16:28:35'),(3,'Chalatenango','2017-03-01 16:28:35'),(4,'Cuscatlán','2017-03-01 16:28:36'),(5,'La Libertad','2017-03-01 16:28:36'),(6,'La Paz','2017-03-01 16:28:36'),(7,'La Unión','2017-03-01 16:28:36'),(8,'Morazán','2017-03-01 16:28:36'),(9,'San Miguel','2017-03-01 16:28:36'),(10,'San Salvador','2017-03-01 16:28:36'),(11,'San Vicente','2017-03-01 16:28:36'),(12,'Santa Ana','2017-03-01 16:28:36'),(13,'Sonsonate','2017-03-01 16:28:36'),(14,'Usulután','2017-03-01 16:28:36');
/*!40000 ALTER TABLE `adm_departamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adm_modulo`
--

DROP TABLE IF EXISTS `adm_modulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adm_modulo` (
  `id_modulo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_modulo` varchar(100) NOT NULL,
  `modulo_descripcion` varchar(180) NOT NULL COMMENT 'descripcion del modulo',
  `fa_menu` varchar(25) DEFAULT NULL,
  `mo_estado` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_modulo`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adm_modulo`
--

LOCK TABLES `adm_modulo` WRITE;
/*!40000 ALTER TABLE `adm_modulo` DISABLE KEYS */;
INSERT INTO `adm_modulo` VALUES (1,'Facturación','Modulo de facturación','fa-file-text-o',1,'2023-02-15 08:56:31'),(2,'Inventario','Modoulo de inventario','fa-barcode',1,'2023-02-15 08:56:31'),(3,'Reportes','Modulo de reportes',NULL,1,'2023-02-15 08:56:31'),(4,'Administración','Módulu de aministración','fa-gears',1,'2023-02-15 08:56:31'),(5,'Clientes','Módulo de cliente','fa-users',1,'2023-02-15 08:56:31'),(6,'Proveedores','Módulo de proveedores','fa-user',1,'2023-02-15 08:56:31'),(7,'Reportes','Módulo de reportes','fa-file-pdf-o',1,'2023-02-15 08:56:31');
/*!40000 ALTER TABLE `adm_modulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adm_modulo_opcion`
--

DROP TABLE IF EXISTS `adm_modulo_opcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adm_modulo_opcion` (
  `id_modulo_opcion` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_opcion` varchar(250) NOT NULL,
  `link` char(100) DEFAULT NULL,
  `opcion_nivel` tinyint(4) NOT NULL COMMENT 'nivel de la opcion, 1 opcion del menu raiz, 2 opcion del submenu raiz 1,  3 opcion del submenu 2, etc..',
  `opcion_estado` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'estado de la opcion 1=activo 0=inactiva',
  `id_modulo` int(11) NOT NULL COMMENT 'llave foranea para relacionar con la tabla adm_modulo, indice',
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `opcion_orden` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_modulo_opcion`),
  KEY `id_modulo` (`id_modulo`),
  CONSTRAINT `fk_moduloopcion_modulo` FOREIGN KEY (`id_modulo`) REFERENCES `adm_modulo` (`id_modulo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adm_modulo_opcion`
--

LOCK TABLES `adm_modulo_opcion` WRITE;
/*!40000 ALTER TABLE `adm_modulo_opcion` DISABLE KEYS */;
INSERT INTO `adm_modulo_opcion` VALUES (1,'Cotizaciones','/Administrar_Cotizaciones',1,1,1,'2023-02-15 09:08:34',1),(2,'Por cobrar','/Ventas/Bandeja_Facturas',1,1,1,'2023-02-15 09:08:34',2),(3,'Productos','/productos/Administrar_Productos',1,1,2,'2023-02-15 09:08:34',1),(4,'Entradas al inventario','/Inventario/Administrar_Entradas_Al_Inventario',1,1,2,'2023-02-15 09:08:34',2),(5,'Compras','/Compras/Administrar_Compras',1,1,6,'2023-02-15 09:08:34',2),(6,'Utilidad','',1,0,3,'2023-02-15 09:08:34',0),(7,'Ventas','',1,0,3,'2023-02-15 09:08:34',0),(8,'Usuarios','/Administrar_Usuarios',1,1,4,'2023-02-15 09:08:34',0),(9,'Backups','/Aministrar_Backups',1,0,4,'2023-02-15 09:08:34',0),(10,'Ventas','/Administrar_Ventas',1,0,1,'2023-02-15 09:08:34',6),(11,'Administrar clientes','/Administrar_Clientes',1,1,5,'2023-02-17 23:25:02',0),(12,'Administrar proveedores','/Administrar_Proveedores',1,1,6,'2023-02-17 23:25:02',1),(13,'Precios','/Precios/Administrar_Precios',1,1,2,'2023-02-17 23:25:02',4),(14,'Salidas al inventario','/Inventario_Salidas/Administrar_Salidas_Al_Inventario',1,1,2,'2023-02-15 09:08:34',3),(15,'Facturas','/Ventas/Administrar_Facturas',1,1,1,'2023-02-15 09:08:34',4),(16,'Pre factura','/Ventas/Nueva_Venta',1,1,1,'2023-02-15 09:08:34',3),(19,'Utilidad','/Reportes/Utilidad',1,1,7,'2023-02-15 09:08:34',1),(20,'Ventas','/Reportes/Ventas',1,1,7,'2023-02-15 09:08:34',2),(21,'Productos','/Reportes/Productos',1,1,7,'2023-02-15 09:08:34',3),(22,'Tipos de usuarios','/Tipos_Usuarios/Administrar_Tipos_Usuarios',1,1,4,'2023-02-15 09:08:34',4),(23,'Kardex','/Reportes/Kardex',1,1,7,'2023-02-15 09:08:34',4),(24,'Datos de la empresa','/Configuracion/Datos_Empresa',1,1,4,'2023-02-15 09:08:34',5),(25,'Precios','/Reportes/Precios',1,1,7,'2023-02-15 09:08:34',5);
/*!40000 ALTER TABLE `adm_modulo_opcion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adm_modulo_opcion_usuario`
--

DROP TABLE IF EXISTS `adm_modulo_opcion_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adm_modulo_opcion_usuario` (
  `id_usuario` int(10) unsigned NOT NULL,
  `id_modulo_opcion` int(11) NOT NULL,
  `tiene_permiso` tinyint(1) DEFAULT 0,
  `agregar` tinyint(1) DEFAULT 0,
  `actualizar` tinyint(1) DEFAULT 0,
  `eliminar` tinyint(1) DEFAULT 0,
  UNIQUE KEY `id_usuario_id_opcion_menu` (`id_usuario`,`id_modulo_opcion`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_modulo_opcion` (`id_modulo_opcion`),
  CONSTRAINT `fk_moduloopcionenusuario_moduloopcion` FOREIGN KEY (`id_modulo_opcion`) REFERENCES `adm_modulo_opcion` (`id_modulo_opcion`) ON UPDATE CASCADE,
  CONSTRAINT `fk_moduloopcionenusuario_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`codigousuario`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adm_modulo_opcion_usuario`
--

LOCK TABLES `adm_modulo_opcion_usuario` WRITE;
/*!40000 ALTER TABLE `adm_modulo_opcion_usuario` DISABLE KEYS */;
INSERT INTO `adm_modulo_opcion_usuario` VALUES (1,1,1,1,1,1),(1,2,1,1,1,1),(1,3,1,1,1,1),(1,4,1,1,1,1),(1,5,1,1,1,1),(1,6,1,1,1,1),(1,7,1,1,1,1),(1,8,1,1,1,1),(1,9,1,1,1,1),(1,10,1,1,1,1),(1,11,1,1,1,1),(1,12,1,1,1,1),(1,13,1,1,1,1),(1,14,1,1,1,1),(1,15,1,1,1,1),(1,16,1,1,1,1),(1,19,1,1,1,1),(1,20,1,1,1,1),(1,21,1,0,0,0),(1,22,1,1,1,1),(1,23,1,1,1,1),(1,24,1,1,1,1),(1,25,1,1,1,1),(2,1,0,0,0,0),(2,2,0,0,0,0),(2,3,0,0,0,0),(2,4,0,0,0,0),(2,5,0,0,0,0),(2,6,0,0,0,0),(2,7,0,0,0,0),(2,8,0,0,0,0),(2,9,0,0,0,0),(2,10,0,0,0,0),(20,1,0,0,0,0),(20,2,0,0,0,0),(20,3,0,0,0,0),(20,4,0,0,0,0),(20,5,0,0,0,0),(20,6,0,0,0,0),(20,7,0,0,0,0),(20,8,0,0,0,0),(20,9,0,0,0,0),(20,10,0,0,0,0),(28,1,0,0,0,0),(28,2,0,0,0,0),(28,3,0,0,0,0),(28,4,0,0,0,0),(28,5,0,0,0,0),(28,6,0,0,0,0),(28,7,0,0,0,0),(28,8,0,0,0,0),(28,9,0,0,0,0),(28,10,0,0,0,0),(32,1,0,0,0,0),(32,2,0,0,0,0),(32,3,0,0,0,0),(32,4,0,0,0,0),(32,5,0,0,0,0),(32,6,0,0,0,0),(32,7,0,0,0,0),(32,8,0,0,0,0),(32,9,0,0,0,0),(32,10,0,0,0,0),(34,1,0,0,0,0),(34,2,0,0,0,0),(34,3,0,0,0,0),(34,4,0,0,0,0),(34,5,0,0,0,0),(34,6,0,0,0,0),(34,7,0,0,0,0),(34,8,0,0,0,0),(34,9,0,0,0,0),(34,10,0,0,0,0),(36,1,0,0,0,0),(36,2,0,0,0,0),(36,3,0,0,0,0),(36,4,0,0,0,0),(36,5,0,0,0,0),(36,6,0,0,0,0),(36,7,0,0,0,0),(36,8,0,0,0,0),(36,9,0,0,0,0),(36,10,0,0,0,0),(37,1,0,0,0,0),(37,2,0,0,0,0),(37,3,0,0,0,0),(37,4,0,0,0,0),(37,5,0,0,0,0),(37,6,0,0,0,0),(37,7,0,0,0,0),(37,8,0,0,0,0),(37,9,0,0,0,0),(37,10,0,0,0,0),(38,1,0,0,0,0),(38,2,0,0,0,0),(38,3,0,0,0,0),(38,4,0,0,0,0),(38,5,0,0,0,0),(38,6,0,0,0,0),(38,7,0,0,0,0),(38,8,0,0,0,0),(38,9,0,0,0,0),(38,10,0,0,0,0),(39,1,0,0,0,0),(39,2,0,0,0,0),(39,3,0,0,0,0),(39,4,0,0,0,0),(39,5,0,0,0,0),(39,6,0,0,0,0),(39,7,0,0,0,0),(39,8,0,0,0,0),(39,9,0,0,0,0),(39,10,0,0,0,0),(40,1,0,0,0,0),(40,2,0,0,0,0),(40,3,0,0,0,0),(40,4,0,0,0,0),(40,5,0,0,0,0),(40,6,0,0,0,0),(40,7,0,0,0,0),(40,8,0,0,0,0),(40,9,0,0,0,0),(40,10,0,0,0,0),(41,1,0,0,0,0),(41,2,0,0,0,0),(41,3,0,0,0,0),(41,4,0,0,0,0),(41,5,0,0,0,0),(41,6,0,0,0,0),(41,7,0,0,0,0),(41,8,0,0,0,0),(41,9,0,0,0,0),(41,10,0,0,0,0),(41,11,0,0,0,0),(41,12,0,0,0,0),(41,13,0,0,0,0),(41,14,0,0,0,0),(41,15,0,0,0,0),(41,16,0,0,0,0),(41,19,0,0,0,0),(41,20,1,0,0,0),(41,21,0,0,0,0),(41,22,0,0,0,0),(42,1,0,0,0,0),(42,2,0,0,0,0),(42,3,0,0,0,0),(42,4,0,0,0,0),(42,5,0,0,0,0),(42,6,0,0,0,0),(42,7,0,0,0,0),(42,8,0,0,0,0),(42,9,0,0,0,0),(42,10,0,0,0,0),(42,11,0,0,0,0),(42,12,0,0,0,0),(42,13,0,0,0,0),(42,14,0,0,0,0),(42,15,0,0,0,0),(42,16,0,0,0,0),(42,19,0,0,0,0),(42,20,0,0,0,0),(42,21,0,0,0,0),(42,22,0,0,0,0),(43,1,1,1,0,0),(43,2,1,1,0,0),(43,3,0,0,0,0),(43,4,0,0,0,0),(43,5,0,0,0,0),(43,6,0,0,0,0),(43,7,0,0,0,0),(43,8,0,0,0,0),(43,9,0,0,0,0),(43,10,0,0,0,0),(43,11,0,0,0,0),(43,12,0,0,0,0),(43,13,0,0,0,0),(43,14,0,0,0,0),(43,15,0,0,0,0),(43,16,1,1,0,0),(43,19,0,0,0,0),(43,20,1,1,0,0),(43,21,0,0,0,0),(43,22,0,0,0,0),(43,23,0,0,0,0),(43,24,0,0,0,0),(43,25,0,0,0,0);
/*!40000 ALTER TABLE `adm_modulo_opcion_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adm_municipio`
--

DROP TABLE IF EXISTS `adm_municipio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adm_municipio` (
  `id_municipio` smallint(6) NOT NULL AUTO_INCREMENT COMMENT 'llave primaria',
  `municipio_nombre` varchar(150) NOT NULL COMMENT 'nombre o descripcion del municipio',
  `id_departamento` tinyint(2) NOT NULL COMMENT 'llave foranea para relacionar con la tabla adm_departamento, indice',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_municipio`),
  KEY `id_departamento` (`id_departamento`),
  CONSTRAINT `fk_municipio_departamento` FOREIGN KEY (`id_departamento`) REFERENCES `adm_departamento` (`id_departamento`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=263 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adm_municipio`
--

LOCK TABLES `adm_municipio` WRITE;
/*!40000 ALTER TABLE `adm_municipio` DISABLE KEYS */;
INSERT INTO `adm_municipio` VALUES (1,'Ahuachapán',1,'2017-03-01 17:15:28'),(2,'Jujutla',1,'2017-03-01 17:15:28'),(3,'Atiquizaya',1,'2017-03-01 17:15:28'),(4,'Concepción de Ataco',1,'2017-03-01 17:15:28'),(5,'El Refugio',1,'2017-03-01 17:15:28'),(6,'Guaymango',1,'2017-03-01 17:15:28'),(7,'Apaneca',1,'2017-03-01 17:15:28'),(8,'San Francisco Menéndez',1,'2017-03-01 17:15:28'),(9,'San Lorenzo',1,'2017-03-01 17:15:28'),(10,'San Pedro Puxtla',1,'2017-03-01 17:15:28'),(11,'Tacuba',1,'2017-03-01 17:15:28'),(12,'Turín',1,'2017-03-01 17:15:28'),(13,'Cinquera',2,'2017-03-01 17:15:28'),(14,'Villa Dolores',2,'2017-03-01 17:15:28'),(15,'Guacotecti',2,'2017-03-01 17:15:28'),(16,'Ilobasco',2,'2017-03-01 17:15:28'),(17,'Jutiapa',2,'2017-03-01 17:15:28'),(18,'San Isidro',2,'2017-03-01 17:15:28'),(19,'Sensuntepeque',2,'2017-03-01 17:15:28'),(20,'Ciudad de Tejutepeque',2,'2017-03-01 17:15:28'),(21,'Victoria',2,'2017-03-01 17:15:28'),(22,'Agua Caliente',3,'2017-03-01 17:15:28'),(23,'Arcatao',3,'2017-03-01 17:15:28'),(24,'Azacualpa',3,'2017-03-01 17:15:28'),(25,'Chalatenango',3,'2017-03-01 17:15:28'),(26,'Citalá',3,'2017-03-01 17:15:28'),(27,'Comalapa',3,'2017-03-01 17:15:28'),(28,'Concepción Quezaltepeque',3,'2017-03-01 17:15:28'),(29,'Dulce Nombre de María',3,'2017-03-01 17:15:28'),(30,'El Carrizal',3,'2017-03-01 17:15:28'),(31,'El Paraíso',3,'2017-03-01 17:15:28'),(32,'La Laguna',3,'2017-03-01 17:15:28'),(33,'La Palma',3,'2017-03-01 17:15:28'),(34,'La Reina',3,'2017-03-01 17:15:28'),(35,'Las Vueltas',3,'2017-03-01 17:15:28'),(36,'Nombre de Jesús',3,'2017-03-01 17:15:28'),(37,'Nueva Concepción',3,'2017-03-01 17:15:28'),(38,'Nueva Trinidad',3,'2017-03-01 17:15:28'),(39,'Ojos de Agua',3,'2017-03-01 17:15:28'),(40,'Potonico',3,'2017-03-01 17:15:28'),(41,'San Antonio de la Cruz',3,'2017-03-01 17:15:28'),(42,'San Antonio Los Ranchos',3,'2017-03-01 17:15:28'),(43,'San Fernando',3,'2017-03-01 17:15:28'),(44,'San Francisco Lempa',3,'2017-03-01 17:15:28'),(45,'San Francisco Morazán',3,'2017-03-01 17:15:28'),(46,'San Ignacio',3,'2017-03-01 17:15:28'),(47,'San Isidro Labrador',3,'2017-03-01 17:15:28'),(48,'San José Cancasque',3,'2017-03-01 17:15:28'),(49,'San José Las Flores',3,'2017-03-01 17:15:28'),(50,'San Luis del Carmen',3,'2017-03-01 17:15:28'),(51,'San Miguel de Mercedes',3,'2017-03-01 17:15:28'),(52,'San Rafael',3,'2017-03-01 17:15:28'),(53,'Santa Rita',3,'2017-03-01 17:15:28'),(54,'Tejutla',3,'2017-03-01 17:15:28'),(55,'Candelaria',4,'2017-03-01 17:15:28'),(56,'Cojutepeque',4,'2017-03-01 17:15:28'),(57,'El Carmen',4,'2017-03-01 17:15:28'),(58,'El Rosario',4,'2017-03-01 17:15:28'),(59,'Monte San Juan',4,'2017-03-01 17:15:28'),(60,'Oratorio de Concepción',4,'2017-03-01 17:15:28'),(61,'San Bartolomé Perulapía',4,'2017-03-01 17:15:28'),(62,'San Cristóbal',4,'2017-03-01 17:15:28'),(63,'San José Guayabal',4,'2017-03-01 17:15:28'),(64,'San Pedro Perulapán',4,'2017-03-01 17:15:28'),(65,'San Rafael Cedros',4,'2017-03-01 17:15:28'),(66,'San Ramón',4,'2017-03-01 17:15:28'),(67,'Santa Cruz Analquito',4,'2017-03-01 17:15:28'),(68,'Santa Cruz Michapa',4,'2017-03-01 17:15:28'),(69,'Suchitoto',4,'2017-03-01 17:15:28'),(70,'Tenancingo',4,'2017-03-01 17:15:28'),(71,'Antiguo Cuscatlán',5,'2017-03-01 17:15:28'),(72,'Chiltiupán',5,'2017-03-01 17:15:28'),(73,'Ciudad Arce',5,'2017-03-01 17:15:28'),(74,'Colón',5,'2017-03-01 17:15:28'),(75,'Comasagua',5,'2017-03-01 17:15:28'),(76,'Huizúcar',5,'2017-03-01 17:15:28'),(77,'Jayaque',5,'2017-03-01 17:15:28'),(78,'Jicalapa',5,'2017-03-01 17:15:28'),(79,'La Libertad',5,'2017-03-01 17:15:28'),(80,'Santa Tecla',5,'2017-03-01 17:15:28'),(81,'Nuevo Cuscatlán',5,'2017-03-01 17:15:28'),(82,'Opico',5,'2017-03-01 17:15:28'),(83,'Quezaltepeque',5,'2017-03-01 17:15:28'),(84,'Sacacoyo',5,'2017-03-01 17:15:28'),(85,'San José Villanueva',5,'2017-03-01 17:15:28'),(86,'San Matías',5,'2017-03-01 17:15:28'),(87,'San Pablo Tacachico',5,'2017-03-01 17:15:28'),(88,'Talnique',5,'2017-03-01 17:15:28'),(89,'Tamanique',5,'2017-03-01 17:15:28'),(90,'Teotepeque',5,'2017-03-01 17:15:28'),(91,'Tepecoyo',5,'2017-03-01 17:15:28'),(92,'Zaragoza',5,'2017-03-01 17:15:28'),(93,'Cuyultitán',6,'2017-03-01 17:15:28'),(94,'El Rosario',6,'2017-03-01 17:15:28'),(95,'Jerusalén',6,'2017-03-01 17:15:28'),(96,'Mercedes La Ceiba',6,'2017-03-01 17:15:28'),(97,'Olocuilta',6,'2017-03-01 17:15:28'),(98,'Paraíso de Osorio',6,'2017-03-01 17:15:28'),(99,'San Antonio Masahuat',6,'2017-03-01 17:15:28'),(100,'San Emigdio',6,'2017-03-01 17:15:28'),(101,'San Francisco Chinameca',6,'2017-03-01 17:15:28'),(102,'San Juan Nonualco',6,'2017-03-01 17:15:28'),(103,'San Juan Talpa',6,'2017-03-01 17:15:28'),(104,'San Juan Tepezontes',6,'2017-03-01 17:15:28'),(105,'San Luis La Herradura',6,'2017-03-01 17:15:28'),(106,'San Luis Talpa',6,'2017-03-01 17:15:28'),(107,'San Miguel Tepezontes',6,'2017-03-01 17:15:28'),(108,'San Pedro Masahuat',6,'2017-03-01 17:15:28'),(109,'San Pedro Nonualco',6,'2017-03-01 17:15:28'),(110,'San Rafael Obrajuelo',6,'2017-03-01 17:15:28'),(111,'Santa María Ostuma',6,'2017-03-01 17:15:28'),(112,'Santiago Nonualco',6,'2017-03-01 17:15:28'),(113,'Tapalhuaca',6,'2017-03-01 17:15:28'),(114,'Zacatecoluca',6,'2017-03-01 17:15:28'),(115,'Anamorós',7,'2017-03-01 17:15:28'),(116,'Bolívar',7,'2017-03-01 17:15:28'),(117,'Concepción de Oriente',7,'2017-03-01 17:15:28'),(118,'Conchagua',7,'2017-03-01 17:15:28'),(119,'El Carmen',7,'2017-03-01 17:15:28'),(120,'El Sauce',7,'2017-03-01 17:15:28'),(121,'Intipucá',7,'2017-03-01 17:15:28'),(122,'La Unión',7,'2017-03-01 17:15:28'),(123,'Lislique',7,'2017-03-01 17:15:28'),(124,'Meanguera del Golfo',7,'2017-03-01 17:15:28'),(125,'Nueva Esparta',7,'2017-03-01 17:15:28'),(126,'Pasaquina',7,'2017-03-01 17:15:28'),(127,'Polorós',7,'2017-03-01 17:15:28'),(128,'San Alejo',7,'2017-03-01 17:15:28'),(129,'San José',7,'2017-03-01 17:15:28'),(130,'Santa Rosa de Lima',7,'2017-03-01 17:15:28'),(131,'Yayantique',7,'2017-03-01 17:15:28'),(132,'Yucuayquín',7,'2017-03-01 17:15:28'),(133,'Arambala',8,'2017-03-01 17:15:28'),(134,'Cacaopera',8,'2017-03-01 17:15:28'),(135,'Chilanga',8,'2017-03-01 17:15:28'),(136,'Corinto',8,'2017-03-01 17:15:28'),(137,'Delicias de Concepción',8,'2017-03-01 17:15:28'),(138,'El Divisadero',8,'2017-03-01 17:15:28'),(139,'El Rosario',8,'2017-03-01 17:15:28'),(140,'Gualococti',8,'2017-03-01 17:15:28'),(141,'Guatajiagua',8,'2017-03-01 17:15:28'),(142,'Joateca',8,'2017-03-01 17:15:28'),(143,'Jocoaitique',8,'2017-03-01 17:15:28'),(144,'Jocoro',8,'2017-03-01 17:15:28'),(145,'Lolotiquillo',8,'2017-03-01 17:15:28'),(146,'Meanguera',8,'2017-03-01 17:15:28'),(147,'Osicala',8,'2017-03-01 17:15:28'),(148,'Perquín',8,'2017-03-01 17:15:28'),(149,'San Carlos',8,'2017-03-01 17:15:28'),(150,'San Fernando',8,'2017-03-01 17:15:28'),(151,'San Francisco Gotera',8,'2017-03-01 17:15:28'),(152,'San Isidro',8,'2017-03-01 17:15:28'),(153,'San Simón',8,'2017-03-01 17:15:28'),(154,'Sensembra',8,'2017-03-01 17:15:28'),(155,'Sociedad',8,'2017-03-01 17:15:28'),(156,'Torola',8,'2017-03-01 17:15:28'),(157,'Yamabal',8,'2017-03-01 17:15:28'),(158,'Yoloaiquín',8,'2017-03-01 17:15:28'),(159,'Carolina',9,'2017-03-01 17:15:28'),(160,'Chapeltique',9,'2017-03-01 17:15:28'),(161,'Chinameca',9,'2017-03-01 17:15:28'),(162,'Chirilagua',9,'2017-03-01 17:15:28'),(163,'Ciudad Barrios',9,'2017-03-01 17:15:28'),(164,'Comacarán',9,'2017-03-01 17:15:28'),(165,'El Tránsito',9,'2017-03-01 17:15:28'),(166,'Lolotique',9,'2017-03-01 17:15:28'),(167,'Moncagua',9,'2017-03-01 17:15:28'),(168,'Nueva Guadalupe',9,'2017-03-01 17:15:28'),(169,'Nuevo Edén de San Juan',9,'2017-03-01 17:15:28'),(170,'Quelepa',9,'2017-03-01 17:15:28'),(171,'San Antonio',9,'2017-03-01 17:15:28'),(172,'San Gerardo',9,'2017-03-01 17:15:28'),(173,'San Jorge',9,'2017-03-01 17:15:28'),(174,'San Luis de la Reina',9,'2017-03-01 17:15:28'),(175,'San Miguel',9,'2017-03-01 17:15:28'),(176,'San Rafael',9,'2017-03-01 17:15:28'),(177,'Sesori',9,'2017-03-01 17:15:28'),(178,'Uluazapa',9,'2017-03-01 17:15:28'),(179,'Aguilares',10,'2017-03-01 17:15:28'),(180,'Apopa',10,'2017-03-01 17:15:28'),(181,'Ayutuxtepeque',10,'2017-03-01 17:15:28'),(182,'Cuscatancingo',10,'2017-03-01 17:15:28'),(183,'Delgado',10,'2017-03-01 17:15:28'),(184,'El Paisnal',10,'2017-03-01 17:15:28'),(185,'Guazapa',10,'2017-03-01 17:15:28'),(186,'Ilopango',10,'2017-03-01 17:15:28'),(187,'Mejicanos',10,'2017-03-01 17:15:28'),(188,'Nejapa',10,'2017-03-01 17:15:28'),(189,'Panchimalco',10,'2017-03-01 17:15:28'),(190,'Rosario de Mora',10,'2017-03-01 17:15:28'),(191,'San Marcos',10,'2017-03-01 17:15:28'),(192,'San Martín',10,'2017-03-01 17:15:28'),(193,'San Salvador',10,'2017-03-01 17:15:28'),(194,'Santiago Texacuangos',10,'2017-03-01 17:15:28'),(195,'Santo Tomás',10,'2017-03-01 17:15:28'),(196,'Soyapango',10,'2017-03-01 17:15:28'),(197,'Tonacatepeque',10,'2017-03-01 17:15:28'),(198,'Apastepeque',11,'2017-03-01 17:15:28'),(199,'Guadalupe',11,'2017-03-01 17:15:28'),(200,'San Cayetano Istepeque',11,'2017-03-01 17:15:28'),(201,'San Esteban Catarina',11,'2017-03-01 17:15:28'),(202,'San Ildefonso',11,'2017-03-01 17:15:28'),(203,'San Lorenzo',11,'2017-03-01 17:15:28'),(204,'San Sebastián',11,'2017-03-01 17:15:28'),(205,'Santa Clara',11,'2017-03-01 17:15:28'),(206,'Santo Domingo',11,'2017-03-01 17:15:28'),(207,'San Vicente',11,'2017-03-01 17:15:28'),(208,'Tecoluca',11,'2017-03-01 17:15:28'),(209,'Tepetitán',11,'2017-03-01 17:15:28'),(210,'Verapaz',11,'2017-03-01 17:15:28'),(211,'Candelaria de la Frontera',12,'2017-03-01 17:15:28'),(212,'Chalchuapa',12,'2017-03-01 17:15:28'),(213,'Coatepeque',12,'2017-03-01 17:15:28'),(214,'El Congo',12,'2017-03-01 17:15:28'),(215,'El Porvenir',12,'2017-03-01 17:15:28'),(216,'Masahuat',12,'2017-03-01 17:15:28'),(217,'Metapán',12,'2017-03-01 17:15:28'),(218,'San Antonio Pajonal',12,'2017-03-01 17:15:28'),(219,'San Sebastián Salitrillo',12,'2017-03-01 17:15:28'),(220,'Santa Ana',12,'2017-03-01 17:15:28'),(221,'Santa Rosa Guachipilín',12,'2017-03-01 17:15:28'),(222,'Santiago de la Frontera',12,'2017-03-01 17:15:28'),(223,'Texistepeque',12,'2017-03-01 17:15:28'),(224,'Acajutla',13,'2017-03-01 17:15:28'),(225,'Armenia',13,'2017-03-01 17:15:28'),(226,'Caluco',13,'2017-03-01 17:15:28'),(227,'Cuisnahuat',13,'2017-03-01 17:15:28'),(228,'Izalco',13,'2017-03-01 17:15:28'),(229,'Juayúa',13,'2017-03-01 17:15:28'),(230,'Nahuizalco',13,'2017-03-01 17:15:28'),(231,'Nahulingo',13,'2017-03-01 17:15:28'),(232,'Salcoatitán',13,'2017-03-01 17:15:28'),(233,'San Antonio del Monte',13,'2017-03-01 17:15:28'),(234,'San Julián',13,'2017-03-01 17:15:28'),(235,'Santa Catarina Masahuat',13,'2017-03-01 17:15:28'),(236,'Santa Isabel Ishuatán',13,'2017-03-01 17:15:28'),(237,'Santo Domingo',13,'2017-03-01 17:15:28'),(238,'Sonsonate',13,'2017-03-01 17:15:28'),(239,'Sonzacate',13,'2017-03-01 17:15:28'),(240,'Alegría',14,'2017-03-01 17:15:28'),(241,'Berlín',14,'2017-03-01 17:15:28'),(242,'California',14,'2017-03-01 17:15:28'),(243,'Concepción Batres',14,'2017-03-01 17:15:28'),(244,'El Triunfo',14,'2017-03-01 17:15:28'),(245,'Ereguayquín',14,'2017-03-01 17:15:28'),(246,'Estanzuelas',14,'2017-03-01 17:15:28'),(247,'Jiquilisco',14,'2017-03-01 17:15:28'),(248,'Jucuapa',14,'2017-03-01 17:15:28'),(249,'Jucuarán',14,'2017-03-01 17:15:28'),(250,'Mercedes Umaña',14,'2017-03-01 17:15:28'),(251,'Nueva Granada',14,'2017-03-01 17:15:28'),(252,'Ozatlán',14,'2017-03-01 17:15:28'),(253,'Puerto El Triunfo',14,'2017-03-01 17:15:28'),(254,'San Agustín',14,'2017-03-01 17:15:28'),(255,'San Buenaventura',14,'2017-03-01 17:15:28'),(256,'San Dionisio',14,'2017-03-01 17:15:28'),(257,'San Francisco Javier',14,'2017-03-01 17:15:28'),(258,'Santa Elena',14,'2017-03-01 17:15:28'),(259,'Santa María',14,'2017-03-01 17:15:28'),(260,'Santiago de María',14,'2017-03-01 17:15:28'),(261,'Tecapán',14,'2017-03-01 17:15:28'),(262,'Usulután',14,'2017-03-01 17:15:28');
/*!40000 ALTER TABLE `adm_municipio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adm_tipos_usuario`
--

DROP TABLE IF EXISTS `adm_tipos_usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adm_tipos_usuario` (
  `id_tipo_usuario` smallint(6) NOT NULL AUTO_INCREMENT,
  `tipousu_nombre` varchar(25) NOT NULL,
  `tipousu_estado` tinyint(1) NOT NULL DEFAULT 1,
  `tipousu_fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `codigousuario` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_tipo_usuario`),
  KEY `codigousuario` (`codigousuario`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adm_tipos_usuario`
--

LOCK TABLES `adm_tipos_usuario` WRITE;
/*!40000 ALTER TABLE `adm_tipos_usuario` DISABLE KEYS */;
INSERT INTO `adm_tipos_usuario` VALUES (1,'Administrador',1,'2023-03-10 16:13:46',1),(2,'Cajero',1,'2023-03-10 16:13:46',1),(3,'Vendedor',1,'2023-03-10 16:13:46',1),(4,'Usuario común',1,'2023-03-10 21:07:52',1),(5,'Usuario solo reportes',1,'2023-03-10 21:24:54',1),(6,'Usuario solo facturas rep',1,'2023-03-10 21:25:28',1),(7,'Usuarios solo catalogador',1,'2023-03-10 21:31:07',1),(8,'Usuarios solo para invent',1,'2023-03-10 21:31:52',1),(9,'Usuario para catalogar Pr',1,'2023-03-11 00:19:24',1),(10,'User Alta inventraio',1,'2023-03-11 00:20:46',1),(11,'Usuario Reporte ventas',1,'2023-03-11 00:23:27',1),(12,'Usuarios Crear Usuarios',1,'2023-03-11 00:24:08',1);
/*!40000 ALTER TABLE `adm_tipos_usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `com_compras`
--

DROP TABLE IF EXISTS `com_compras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `com_compras` (
  `id_compra` int(11) NOT NULL AUTO_INCREMENT,
  `id_proveedor` int(11) NOT NULL,
  `com_codigo` varchar(15) NOT NULL COMMENT 'codiog del proveedor valor unico',
  `com_razon_social` varchar(250) NOT NULL COMMENT 'nombre de la razon social',
  `com_nombre_comercial` varchar(250) DEFAULT NULL,
  `com_nrc` varchar(8) NOT NULL COMMENT 'numero de registro del contribuyente',
  `com_nit` varchar(16) NOT NULL COMMENT 'numero de identificacion tributaria',
  `com_numero_documednto` varchar(15) DEFAULT NULL,
  `com_total` decimal(10,2) NOT NULL,
  `com_fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_compra`),
  KEY `id_proveedor` (`id_proveedor`),
  CONSTRAINT `fk_compras_proveedores` FOREIGN KEY (`id_proveedor`) REFERENCES `com_proveedor` (`id_proveedor`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `com_compras`
--

LOCK TABLES `com_compras` WRITE;
/*!40000 ALTER TABLE `com_compras` DISABLE KEYS */;
INSERT INTO `com_compras` VALUES (41,1,'','Caninos sa. de cv.','Canes para todos','E1589568','1121-251287-102-','569874',349.25,'2023-03-20 11:04:40'),(42,10,'','Compras SA de CV','Compras SA de CV','78797798','8798-455545-454-','1a-9878',63.00,'2023-05-18 17:38:46');
/*!40000 ALTER TABLE `com_compras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `com_compras_detalle`
--

DROP TABLE IF EXISTS `com_compras_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `com_compras_detalle` (
  `id_detalle_compra` int(11) NOT NULL AUTO_INCREMENT,
  `codigoproducto` int(10) unsigned NOT NULL,
  `det_cantidad` decimal(10,2) NOT NULL,
  `det_precio` decimal(10,2) NOT NULL,
  `det_sub_total` decimal(10,2) NOT NULL,
  `id_compra` int(11) NOT NULL,
  PRIMARY KEY (`id_detalle_compra`),
  KEY `codigoproducto` (`codigoproducto`),
  KEY `id_compra` (`id_compra`),
  CONSTRAINT `fk_comprasdetalle_compras` FOREIGN KEY (`id_compra`) REFERENCES `com_compras` (`id_compra`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_comprasdetalle_productos` FOREIGN KEY (`codigoproducto`) REFERENCES `productos` (`codigoproducto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `com_compras_detalle`
--

LOCK TABLES `com_compras_detalle` WRITE;
/*!40000 ALTER TABLE `com_compras_detalle` DISABLE KEYS */;
INSERT INTO `com_compras_detalle` VALUES (56,2068,15.00,12.00,180.00,41),(57,2065,6.00,6.25,37.50,41),(58,2066,6.00,6.00,36.00,41),(59,2070,18.00,2.25,40.50,41),(60,2069,7.00,6.75,47.25,41),(61,2065,2.00,4.00,8.00,41),(62,2073,12.00,5.25,63.00,42);
/*!40000 ALTER TABLE `com_compras_detalle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `com_proveedor`
--

DROP TABLE IF EXISTS `com_proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `com_proveedor` (
  `id_proveedor` int(11) NOT NULL AUTO_INCREMENT,
  `pro_codigo` varchar(15) NOT NULL COMMENT 'codiog del proveedor valor unico',
  `pro_razon_social` varchar(250) NOT NULL COMMENT 'nombre de la razon social',
  `pro_nombre_comercial` varchar(250) DEFAULT NULL,
  `pro_nrc` varchar(8) NOT NULL COMMENT 'numero de registro del contribuyente',
  `pro_nit` varchar(17) NOT NULL COMMENT 'numero de identificacion tributaria',
  `pro_dui` varchar(10) DEFAULT NULL,
  `pro_direccion` varchar(250) DEFAULT NULL,
  `pro_telefono` varchar(9) DEFAULT NULL,
  `pro_estado` tinyint(1) NOT NULL DEFAULT 1,
  `pro_fecha_alta` datetime NOT NULL DEFAULT current_timestamp(),
  `id_municipio` smallint(6) NOT NULL,
  PRIMARY KEY (`id_proveedor`),
  UNIQUE KEY `pro_codigo` (`pro_codigo`),
  UNIQUE KEY `pro_nrc` (`pro_nrc`),
  KEY `id_municipio` (`id_municipio`),
  CONSTRAINT `fk_proveedor_municipio` FOREIGN KEY (`id_municipio`) REFERENCES `adm_municipio` (`id_municipio`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `com_proveedor`
--

LOCK TABLES `com_proveedor` WRITE;
/*!40000 ALTER TABLE `com_proveedor` DISABLE KEYS */;
INSERT INTO `com_proveedor` VALUES (1,'002369','Caninos sa. de cv.','Canes para todos','E1589568','1121-251287-102-9','123456789','','',1,'2023-02-14 23:58:24',193),(4,'002370','Canmon sa','Para todos','E1590','1029','456489','avenida peralta',NULL,1,'2023-02-14 23:58:24',193),(5,'002371','Paladin sa','Tenemos de todo','E1591','215469','456489','avenida peralta',NULL,1,'2023-02-14 23:58:24',193),(6,'00236998','Marta sa de cv','Matinica','6487e','1236547898745697','464646548','','',1,'2023-02-18 11:46:30',193),(7,'6664566456','Marckfaldks','dsfdasfadsf','fade698','dfasfdsdfsdafdfd','878989785','','',1,'2023-02-18 23:40:10',193),(8,'454545454','fsdfsasdfsdafdsfasd','dsfadsfdsafasdfdsafads','dsfasdfa','fasdfdsfadsfdsfa','','','',1,'2023-02-18 23:40:38',193),(9,'000001','Canaa sa de cv','Canaa sa de cv','659259','5464-654545-656-4','46444646-4','Avenida norte','1111-1111',1,'2023-03-03 19:49:10',26),(10,'010707','Compras SA de CV','Compras SA de CV','78797798','8798-455545-454-5','54646545-6','Avenida norte, juan bertis','2222-5847',1,'2023-05-18 17:35:25',101);
/*!40000 ALTER TABLE `com_proveedor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cotizacion`
--

DROP TABLE IF EXISTS `cotizacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cotizacion` (
  `id_cotizacion` int(11) NOT NULL AUTO_INCREMENT,
  `numero_cotizacion` varchar(8) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `nombre_cliente` varchar(200) DEFAULT NULL,
  `terminos_condiciones` varchar(150) DEFAULT NULL,
  `codigousuario` int(10) unsigned NOT NULL,
  `codigocajero` int(10) unsigned DEFAULT NULL,
  `costo` decimal(10,2) NOT NULL,
  `estado` tinyint(3) unsigned NOT NULL DEFAULT 0 COMMENT '0 no facturada, 1 facturada',
  `fecha_procesamiento` datetime DEFAULT NULL,
  `fecha_ultima_modificacion` datetime DEFAULT NULL,
  `id_cliente` int(11) NOT NULL,
  PRIMARY KEY (`id_cotizacion`),
  KEY `codigousuario` (`codigousuario`),
  KEY `id_cliente` (`id_cliente`),
  CONSTRAINT `fk_cotizacion_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `fac_cliente` (`id_cliente`) ON UPDATE CASCADE,
  CONSTRAINT `fk_cotizacion_usuarios` FOREIGN KEY (`codigousuario`) REFERENCES `usuarios` (`codigousuario`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cotizacion`
--

LOCK TABLES `cotizacion` WRITE;
/*!40000 ALTER TABLE `cotizacion` DISABLE KEYS */;
INSERT INTO `cotizacion` VALUES (49,'2305-440','2023-05-18 23:44:00','Cliente X','Válido hasta 12 de junio 2023',1,NULL,32.80,1,'2023-05-18 17:45:58',NULL,1);
/*!40000 ALTER TABLE `cotizacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cotizacion_detalle`
--

DROP TABLE IF EXISTS `cotizacion_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cotizacion_detalle` (
  `id_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad` decimal(12,2) NOT NULL,
  `precio_venta` decimal(10,2) NOT NULL,
  `id_cotizacion` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `codigoproducto` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_detalle`),
  KEY `id_cotizacion` (`id_cotizacion`),
  KEY `codigoproducto` (`codigoproducto`),
  CONSTRAINT `fk_coitaciondetalle_productos` FOREIGN KEY (`codigoproducto`) REFERENCES `productos` (`codigoproducto`) ON UPDATE CASCADE,
  CONSTRAINT `fk_cotizaciondetalle_cotizacion` FOREIGN KEY (`id_cotizacion`) REFERENCES `cotizacion` (`id_cotizacion`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=138 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cotizacion_detalle`
--

LOCK TABLES `cotizacion_detalle` WRITE;
/*!40000 ALTER TABLE `cotizacion_detalle` DISABLE KEYS */;
INSERT INTO `cotizacion_detalle` VALUES (136,1.00,7.80,49,7.80,2073),(137,100.00,0.25,49,25.00,2065);
/*!40000 ALTER TABLE `cotizacion_detalle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fac_cliente`
--

DROP TABLE IF EXISTS `fac_cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fac_cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `cli_codigo` varchar(12) NOT NULL,
  `cli_nombre` varchar(125) NOT NULL,
  `cli_direccion` varchar(125) DEFAULT NULL,
  `cli_telefono` varchar(9) DEFAULT NULL,
  `cli_razon_social` varchar(125) NOT NULL,
  `cli_nombre_comercial` varchar(125) DEFAULT NULL,
  `cli_nrc` varchar(8) NOT NULL COMMENT 'numero de registro del contribuyente',
  `cli_nit` varchar(17) NOT NULL COMMENT 'numero de identificacion tributaria',
  `cli_dui` varchar(10) DEFAULT NULL,
  `cli_estado` tinyint(1) NOT NULL DEFAULT 1,
  `cli_fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `id_municipio` smallint(6) NOT NULL,
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `cli_codigo` (`cli_codigo`),
  KEY `id_municipio` (`id_municipio`),
  CONSTRAINT `fk_cliente_municipio` FOREIGN KEY (`id_municipio`) REFERENCES `adm_municipio` (`id_municipio`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fac_cliente`
--

LOCK TABLES `fac_cliente` WRITE;
/*!40000 ALTER TABLE `fac_cliente` DISABLE KEYS */;
INSERT INTO `fac_cliente` VALUES (1,'00001','Cliente X','Avenida Peralta','2365-978_','Cliente X','Cliente X','','','',1,'2023-02-18 00:03:59',193),(2,'4645646565','Juan Manuel Aguirre','Avenida peralta','2312-5665','Aguires SA de CV','Juan Manuel Aguirre','45897','8997-979979-798-9','66546654-6',1,'2023-02-18 00:07:26',14),(3,'11-11','Marta Cruz','Avenida sur','231256','',NULL,'','',NULL,1,'2023-02-18 00:07:26',193),(4,'11-12','Carlos Marlon del monte','San salvador','','Carlos Marlon del monte','Carlos Marlon del monte','64665456','6464-564654-454-6','46446544-5',1,'2023-02-23 07:32:38',16),(6,'11-13','María Luisa','Usulutan','98-874','',NULL,'','',NULL,1,'2023-02-23 07:32:38',193),(7,'11-14','Juana del Carmen','Santiago de María','69874-98','',NULL,'','',NULL,1,'2023-02-23 07:32:38',193),(8,'11-15','Eugenia Tobar','Tierra Blanca','2364-87','',NULL,'','',NULL,1,'2023-02-23 07:32:38',193),(9,'0101145','Juan Manuel García Cruz','Avenida peralta','223669','',NULL,'','',NULL,1,'2023-03-02 08:50:12',193),(10,'000002','Marvin Giancarlo Cruz','avenida peralta','2222-2222','MaCruz-Gi Sa de cv','Marvin Giancarlo Cruz','ab129','1125-215487-104-9','02689781-0',1,'2023-03-02 21:04:33',115),(11,'000003','Manuel Alcides Chavez','avenida las amopalas','4645-6644','Manuel Alcides Chavez','Manuel Alcides Chavez','2365974','4646-546545-646-5','54654645-6',1,'2023-03-02 21:44:21',16),(12,'000004','Marcelo Anacleto Eustaquio Aquino','Avenida sur y norte no. 26','4646-4654','Maea SA de CV','Marcelo Anacleto Eustaquio Aquino','cr25698','4546-564654-546-4','46546654-6',1,'2023-03-03 09:05:43',59),(13,'000009','Karmen Marina','','','Karmen Marina','Karmen Marina','','','',1,'2023-03-03 18:31:52',4),(14,'010707','Luis Gonzáles','7 avenida norte contiguo al almacén','8578-9784','Luis Gonzáles','Luis Gonzáles','787987','5555-555555-125-5','65654445-4',1,'2023-05-18 17:32:59',8);
/*!40000 ALTER TABLE `fac_cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fac_factura`
--

DROP TABLE IF EXISTS `fac_factura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fac_factura` (
  `id_factura` int(11) NOT NULL AUTO_INCREMENT,
  `fac_fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fac_nombre_cliente` varchar(200) DEFAULT NULL,
  `codigousuario` int(10) unsigned NOT NULL,
  `codigocajero` int(10) unsigned DEFAULT NULL,
  `fac_total` decimal(10,2) NOT NULL,
  `fac_estado` tinyint(1) NOT NULL DEFAULT 0,
  `id_cliente` int(11) NOT NULL,
  `fac_numero_factura` varchar(10) DEFAULT NULL,
  `id_cotizacion` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_factura`),
  KEY `id_cliente` (`id_cliente`),
  KEY `codigousuario` (`codigousuario`),
  CONSTRAINT `fk_factura_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `fac_cliente` (`id_cliente`) ON UPDATE CASCADE,
  CONSTRAINT `fk_factura_usuario` FOREIGN KEY (`codigousuario`) REFERENCES `usuarios` (`codigousuario`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=327753 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fac_factura`
--

LOCK TABLES `fac_factura` WRITE;
/*!40000 ALTER TABLE `fac_factura` DISABLE KEYS */;
INSERT INTO `fac_factura` VALUES (327746,'2023-05-18 17:42:14','Juan Manuel García Cruz',1,1,15.60,1,9,NULL,0),(327748,'2023-05-18 17:45:52','Cliente X',1,1,7.80,1,1,NULL,49),(327750,'2023-05-18 17:46:58','María Luisa',1,1,7.80,1,6,NULL,0),(327751,'2023-05-18 17:52:33','Juan Manuel García Cruz',1,1,10.30,1,9,NULL,0),(327752,'2023-05-18 18:04:02','María Luisa',43,43,20.05,1,6,NULL,0);
/*!40000 ALTER TABLE `fac_factura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fac_factura_detalle`
--

DROP TABLE IF EXISTS `fac_factura_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fac_factura_detalle` (
  `id_factura_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `facde_cantidad` decimal(12,2) NOT NULL,
  `facde_precio_venta` decimal(10,2) NOT NULL,
  `facde_subtotal` decimal(10,2) NOT NULL,
  `id_factura` int(10) NOT NULL,
  `codigoproducto` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_factura_detalle`),
  KEY `codigoproducto` (`codigoproducto`),
  KEY `id_factura` (`id_factura`),
  CONSTRAINT `fk_facturadetalle_factura` FOREIGN KEY (`id_factura`) REFERENCES `fac_factura` (`id_factura`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_facturadetalle_producto` FOREIGN KEY (`codigoproducto`) REFERENCES `productos` (`codigoproducto`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32988 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fac_factura_detalle`
--

LOCK TABLES `fac_factura_detalle` WRITE;
/*!40000 ALTER TABLE `fac_factura_detalle` DISABLE KEYS */;
INSERT INTO `fac_factura_detalle` VALUES (32979,2.00,7.80,15.60,327746,2073),(32981,1.00,7.80,7.80,327748,2073),(32983,1.00,7.80,7.80,327750,2073),(32984,1.00,7.80,7.80,327751,2073),(32985,1.00,2.50,2.50,327751,2065),(32986,1.00,7.80,7.80,327752,2073),(32987,1.00,12.25,12.25,327752,2067);
/*!40000 ALTER TABLE `fac_factura_detalle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ferro_adm_configuraciones`
--

DROP TABLE IF EXISTS `ferro_adm_configuraciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ferro_adm_configuraciones` (
  `id_configuracion` int(11) NOT NULL AUTO_INCREMENT,
  `conf_nombre_configuracion` longtext NOT NULL,
  `valor_configuracion` varchar(150) NOT NULL COMMENT 'valor asiganod a la configuraicon para ser utilizado, numeros o letras',
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_configuracion`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ferro_adm_configuraciones`
--

LOCK TABLES `ferro_adm_configuraciones` WRITE;
/*!40000 ALTER TABLE `ferro_adm_configuraciones` DISABLE KEYS */;
INSERT INTO `ferro_adm_configuraciones` VALUES (1,'Valor del numero de renglones que caben en la factura se ponen renglones menos para cuando haya salto de linea no rebase el tamaÃ±o del papel y baje los totales a otra pagina, en este caso la factura agarra 14 renglones pero se pone 12','12','2022-03-21 21:29:35'),(2,'Nombre de la empresa','Ferretería Hernández','2023-03-07 14:47:05'),(3,'Direción de la empresa','6a. Avenida Norte y 4a. Calle poniente, sobre el redondel Torogoz','2023-03-07 14:48:20'),(4,'Teléfono de la empresa','2222-2258','2023-03-07 14:49:17'),(5,'Moneda','Expresado en dólares de los Estados Unidos de Norte América','2023-03-07 14:51:01'),(6,'logo de la empresa','ferre.jpg','2023-03-07 14:51:22');
/*!40000 ALTER TABLE `ferro_adm_configuraciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inv_entradas`
--

DROP TABLE IF EXISTS `inv_entradas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inv_entradas` (
  `id_entrada` int(11) NOT NULL AUTO_INCREMENT,
  `en_numero_documento` varchar(15) NOT NULL COMMENT 'Numero del documento',
  `en_comentario` varchar(250) DEFAULT NULL COMMENT 'comentario',
  `en_fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `en_total` decimal(10,2) DEFAULT NULL,
  `codigousuario` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_entrada`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inv_entradas`
--

LOCK TABLES `inv_entradas` WRITE;
/*!40000 ALTER TABLE `inv_entradas` DISABLE KEYS */;
INSERT INTO `inv_entradas` VALUES (13,'256','entradas al inventario','2023-03-20 15:26:13',3.00,1),(14,'E-102','Entrada de inventario','2023-05-18 17:49:03',35.00,1);
/*!40000 ALTER TABLE `inv_entradas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inv_entradas_detalle`
--

DROP TABLE IF EXISTS `inv_entradas_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inv_entradas_detalle` (
  `id_entrada_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `codigoproducto` int(10) unsigned NOT NULL,
  `ende_cantidad` decimal(10,2) NOT NULL,
  `ende_precio` decimal(10,2) NOT NULL,
  `ende_sub_total` decimal(10,2) NOT NULL,
  `id_entrada` int(11) NOT NULL,
  PRIMARY KEY (`id_entrada_detalle`),
  KEY `codigoproducto` (`codigoproducto`),
  KEY `id_entrada` (`id_entrada`),
  CONSTRAINT `fk_entradadetalle_entradas` FOREIGN KEY (`id_entrada`) REFERENCES `inv_entradas` (`id_entrada`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_entradadetalle_productos` FOREIGN KEY (`codigoproducto`) REFERENCES `productos` (`codigoproducto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inv_entradas_detalle`
--

LOCK TABLES `inv_entradas_detalle` WRITE;
/*!40000 ALTER TABLE `inv_entradas_detalle` DISABLE KEYS */;
INSERT INTO `inv_entradas_detalle` VALUES (28,2065,1.00,3.00,3.00,13),(29,2067,3.00,1.25,3.75,14),(30,2073,5.00,6.25,31.25,14);
/*!40000 ALTER TABLE `inv_entradas_detalle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inv_kardex`
--

DROP TABLE IF EXISTS `inv_kardex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inv_kardex` (
  `id_kardex` int(11) NOT NULL AUTO_INCREMENT,
  `kar_fecha_creacion` datetime NOT NULL,
  `kar_tipo_transaccion` tinyint(1) NOT NULL COMMENT 'tipo operacion, 1=compra, 2=venta, 3= entradas, 4=salidas',
  `kar_numero_documento` varchar(15) DEFAULT NULL,
  `kar_cantidad` decimal(10,2) NOT NULL,
  `kar_saldo` decimal(10,2) NOT NULL,
  `id_venta` int(11) DEFAULT NULL,
  `id_compra` int(11) DEFAULT NULL,
  `id_entrada` int(11) DEFAULT NULL COMMENT 'Para relacionar con la tabla inv_entradas',
  `id_salida` int(11) DEFAULT NULL COMMENT 'Para relacionar con la tabla inv_salidas',
  `codigoproducto` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_kardex`),
  KEY `codigoproducto` (`codigoproducto`),
  CONSTRAINT `fk_kardex_producto` FOREIGN KEY (`codigoproducto`) REFERENCES `productos` (`codigoproducto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2304 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inv_kardex`
--

LOCK TABLES `inv_kardex` WRITE;
/*!40000 ALTER TABLE `inv_kardex` DISABLE KEYS */;
INSERT INTO `inv_kardex` VALUES (2286,'2023-03-20 11:04:40',1,'569874',15.00,15.00,NULL,41,NULL,NULL,2068),(2287,'2023-03-20 11:04:40',1,'569874',6.00,6.00,NULL,41,NULL,NULL,2065),(2288,'2023-03-20 11:04:40',1,'569874',6.00,6.00,NULL,41,NULL,NULL,2066),(2289,'2023-03-20 11:04:40',1,'569874',18.00,18.00,NULL,41,NULL,NULL,2070),(2290,'2023-03-20 11:04:40',1,'569874',7.00,7.00,NULL,41,NULL,NULL,2069),(2291,'2023-03-20 11:04:40',1,'569874',2.00,8.00,NULL,41,NULL,NULL,2065),(2292,'2023-03-20 15:26:13',3,'256',1.00,7.00,NULL,NULL,13,NULL,2065),(2293,'2023-05-18 17:38:46',1,'1a-9878',12.00,12.00,NULL,42,NULL,NULL,2073),(2294,'2023-05-18 17:42:34',2,'327746',2.00,10.00,327746,NULL,NULL,NULL,2073),(2295,'2023-05-18 17:45:58',2,'327748',1.00,9.00,327748,NULL,NULL,NULL,2073),(2296,'2023-05-18 17:47:07',2,'327750',1.00,8.00,327750,NULL,NULL,NULL,2073),(2297,'2023-05-18 17:49:03',3,'E-102',3.00,3.00,NULL,NULL,14,NULL,2067),(2298,'2023-05-18 17:49:03',3,'E-102',5.00,13.00,NULL,NULL,14,NULL,2073),(2299,'2023-05-18 17:51:00',4,'SI-1025',3.00,10.00,NULL,NULL,NULL,26,2073),(2300,'2023-05-18 17:52:37',2,'327751',1.00,9.00,327751,NULL,NULL,NULL,2073),(2301,'2023-05-18 17:52:37',2,'327751',1.00,6.00,327751,NULL,NULL,NULL,2065),(2302,'2023-05-18 18:04:06',2,'327752',1.00,8.00,327752,NULL,NULL,NULL,2073),(2303,'2023-05-18 18:04:06',2,'327752',1.00,2.00,327752,NULL,NULL,NULL,2067);
/*!40000 ALTER TABLE `inv_kardex` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inv_salidas`
--

DROP TABLE IF EXISTS `inv_salidas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inv_salidas` (
  `id_salida` int(11) NOT NULL AUTO_INCREMENT,
  `sa_numero_documento` varchar(15) NOT NULL COMMENT 'Numero del documento',
  `sa_comentario` varchar(250) DEFAULT NULL COMMENT 'comentario',
  `sa_fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `sa_total` decimal(10,2) DEFAULT NULL,
  `codigousuario` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_salida`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inv_salidas`
--

LOCK TABLES `inv_salidas` WRITE;
/*!40000 ALTER TABLE `inv_salidas` DISABLE KEYS */;
INSERT INTO `inv_salidas` VALUES (26,'SI-1025','Salida del inventario','2023-05-18 17:51:00',18.75,1);
/*!40000 ALTER TABLE `inv_salidas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inv_salidas_detalle`
--

DROP TABLE IF EXISTS `inv_salidas_detalle`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inv_salidas_detalle` (
  `id_salida_detalle` int(11) NOT NULL AUTO_INCREMENT,
  `codigoproducto` int(10) unsigned NOT NULL,
  `salde_cantidad` decimal(10,2) NOT NULL,
  `salde_precio` decimal(10,2) NOT NULL,
  `salde_sub_total` decimal(10,2) NOT NULL,
  `id_salida` int(11) NOT NULL,
  PRIMARY KEY (`id_salida_detalle`),
  KEY `codigoproducto` (`codigoproducto`),
  KEY `id_salida` (`id_salida`),
  CONSTRAINT `fk_salidadetalle_productos` FOREIGN KEY (`codigoproducto`) REFERENCES `productos` (`codigoproducto`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_salidadetalle_salidas` FOREIGN KEY (`id_salida`) REFERENCES `inv_salidas` (`id_salida`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inv_salidas_detalle`
--

LOCK TABLES `inv_salidas_detalle` WRITE;
/*!40000 ALTER TABLE `inv_salidas_detalle` DISABLE KEYS */;
INSERT INTO `inv_salidas_detalle` VALUES (34,2073,3.00,6.25,18.75,26);
/*!40000 ALTER TABLE `inv_salidas_detalle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opciones_menu`
--

DROP TABLE IF EXISTS `opciones_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opciones_menu` (
  `id_opcion` int(11) NOT NULL AUTO_INCREMENT,
  `opcion_nombre` varchar(150) NOT NULL,
  `opcion_estado` tinyint(1) DEFAULT 1,
  `fecha_alta` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_opcion`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opciones_menu`
--

LOCK TABLES `opciones_menu` WRITE;
/*!40000 ALTER TABLE `opciones_menu` DISABLE KEYS */;
INSERT INTO `opciones_menu` VALUES (1,'Facturación-Cobrar factrua',1,'2023-01-23 22:27:22'),(2,'Facturación-Nueva factura',1,'2023-01-23 22:27:22'),(3,'Inventario-Agregar producto',1,'2023-01-23 22:27:22'),(4,'Reportes-Utilidad',1,'2023-01-23 22:27:22'),(5,'Reportes-Ventas',1,'2023-01-23 22:27:22'),(6,'Reportes-Existencias por producto',1,'2023-01-23 22:27:22'),(7,'Administración-Usuarios',1,'2023-01-23 22:27:22'),(8,'Administración-Backups',1,'2023-01-23 22:27:22');
/*!40000 ALTER TABLE `opciones_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prod_precios`
--

DROP TABLE IF EXISTS `prod_precios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prod_precios` (
  `id_precio` int(11) NOT NULL AUTO_INCREMENT,
  `pre_precio` decimal(10,2) NOT NULL,
  `pre_fecha_creacion` datetime NOT NULL,
  `codigoproducto` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_precio`),
  KEY `codigoproducto` (`codigoproducto`),
  CONSTRAINT `fk_precios_producto` FOREIGN KEY (`codigoproducto`) REFERENCES `productos` (`codigoproducto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1883 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prod_precios`
--

LOCK TABLES `prod_precios` WRITE;
/*!40000 ALTER TABLE `prod_precios` DISABLE KEYS */;
INSERT INTO `prod_precios` VALUES (1880,7.80,'2023-05-18 17:40:55',2073),(1881,7.80,'2023-05-18 17:53:59',2065),(1882,12.25,'2023-05-18 18:02:44',2067);
/*!40000 ALTER TABLE `prod_precios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prod_tipo_unidad`
--

DROP TABLE IF EXISTS `prod_tipo_unidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prod_tipo_unidad` (
  `id_tipo_unidad` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_unidad_nombre` varchar(25) NOT NULL,
  `tipo_fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_tipo_unidad`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prod_tipo_unidad`
--

LOCK TABLES `prod_tipo_unidad` WRITE;
/*!40000 ALTER TABLE `prod_tipo_unidad` DISABLE KEYS */;
INSERT INTO `prod_tipo_unidad` VALUES (1,'Unidad','2023-02-20 10:06:48'),(2,'Libra','2023-02-20 10:06:48'),(3,'Quintal','2023-02-20 10:06:48'),(4,'Media Libra','2023-02-20 10:06:48'),(5,'Botella','2023-02-20 10:06:48'),(6,'Caja','2023-02-20 10:06:48'),(7,'Metro','2023-02-20 10:06:48'),(8,'Yarda','2023-02-20 10:06:48'),(9,'Pie','2023-02-20 10:06:48');
/*!40000 ALTER TABLE `prod_tipo_unidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prod_tipos`
--

DROP TABLE IF EXISTS `prod_tipos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prod_tipos` (
  `id_tipo_producto` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_nombre` varchar(25) NOT NULL,
  `tipo_fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_tipo_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prod_tipos`
--

LOCK TABLES `prod_tipos` WRITE;
/*!40000 ALTER TABLE `prod_tipos` DISABLE KEYS */;
INSERT INTO `prod_tipos` VALUES (1,'Agrícola','2023-02-20 09:35:27'),(2,'Automotríz','2023-02-20 09:35:27'),(3,'Carpintería','2023-02-20 09:35:27'),(4,'Construcción','2023-02-20 09:35:27'),(5,'Eléctrico','2023-02-20 09:35:27'),(6,'Electrónico','2023-02-20 09:35:27'),(7,'Farmacia','2023-02-20 09:37:27'),(8,'Fontanería','2023-02-20 09:37:27'),(9,'Herramientas','2023-02-20 09:37:27'),(10,'Librería','2023-02-20 09:37:27'),(11,'Pintura','2023-02-20 09:37:27'),(12,'Variedades','2023-02-20 09:37:27'),(13,'General','2023-02-20 09:37:27');
/*!40000 ALTER TABLE `prod_tipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productos` (
  `codigoproducto` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prod_codigo` varchar(25) COLLATE utf8_spanish_ci DEFAULT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `medida` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `id_tipo_producto` int(11) NOT NULL,
  `id_tipo_unidad` int(11) NOT NULL,
  `prod_fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`codigoproducto`),
  UNIQUE KEY `prod_codigo` (`prod_codigo`),
  KEY `id_tipo_producto` (`id_tipo_producto`),
  KEY `id_tipo_unidad` (`id_tipo_unidad`),
  CONSTRAINT `fk_productos_tipoproducto` FOREIGN KEY (`id_tipo_producto`) REFERENCES `prod_tipos` (`id_tipo_producto`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2074 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (2065,'2065','Teclado','Electronico','Unidad','Teclado con luces',6,1,'2023-02-20 13:10:35'),(2066,'abcdefg','Corta uñas','','','Corta uñas largo para quitar uñeros',2,5,'2023-02-20 15:14:01'),(2067,'abcdefgh','Cable cumputadora','','','Cable para computadora uno noventa',8,6,'2023-02-20 15:15:41'),(2068,'tab45877-ii','Teléfono ab','','','teléfono con 100 gibas de espacio interno',5,6,'2023-02-20 16:09:21'),(2069,'000002','Calculadora cientifica','','','Calculadora científica que se puede usar para muchos usos',6,1,'2023-03-06 18:00:07'),(2070,'000003','Calculadora de bolsillo','','','Se puede usar para todo uso',6,1,'2023-03-06 18:00:53'),(2071,'000004','VENTIDLADOR','','','VENTILADOR A MOTOR DE CALIDAD',5,1,'2023-03-15 09:50:24'),(2072,'000005','ARO DE LUZ','','','ARO DE LUZ LED',6,1,'2023-03-15 09:50:56'),(2073,'MO-12345','Mochila porta herramientas','','','Mochila con muchos depósitos para portar herramientas pesadas',13,1,'2023-05-18 17:36:52');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario_opciones`
--

DROP TABLE IF EXISTS `usuario_opciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario_opciones` (
  `id_usuario` int(10) unsigned NOT NULL,
  `id_opcion` int(11) NOT NULL,
  `tiene_permiso` tinyint(1) DEFAULT 0,
  UNIQUE KEY `id_usuario_id_opcion_menu` (`id_usuario`,`id_opcion`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_opcion` (`id_opcion`),
  CONSTRAINT `fk_usuarioopcion_opcionesmenu` FOREIGN KEY (`id_opcion`) REFERENCES `opciones_menu` (`id_opcion`) ON UPDATE CASCADE,
  CONSTRAINT `fk_usuariopcion_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`codigousuario`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario_opciones`
--

LOCK TABLES `usuario_opciones` WRITE;
/*!40000 ALTER TABLE `usuario_opciones` DISABLE KEYS */;
INSERT INTO `usuario_opciones` VALUES (1,1,1),(1,2,1),(1,3,1),(1,4,1),(1,5,1),(1,6,1),(1,7,1),(1,8,0),(2,1,0),(2,2,0),(2,3,0),(2,4,0),(2,5,0),(2,6,0),(2,7,0),(2,8,0);
/*!40000 ALTER TABLE `usuario_opciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `codigousuario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombreusuario` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `id_tipo_usuario` smallint(6) NOT NULL COMMENT '1= administrador, 2= cajero, 3= vendedor',
  `contrasena` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `departamento` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `municipio` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(9) COLLATE utf8_spanish_ci DEFAULT NULL,
  `estado` int(10) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`codigousuario`),
  KEY `id_tipo_usuario` (`id_tipo_usuario`),
  CONSTRAINT `fk_usuarios_tiposusuarios` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `adm_tipos_usuario` (`id_tipo_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'usuario1',1,'a47c973cdb475cec9ad0d26e0891c43f','María Luisa','UsulutÃƒÂ¡n','UsulutÃƒÂ¡n','Residencial Alejandria','78122825',1),(2,'administrador',1,'a47c973cdb475cec9ad0d26e0891c43f','Administrador del sistema','','','','0',1),(15,'usuario2',1,'a47c973cdb475cec9ad0d26e0891c43f','Carlos Natanael','UsulutÃƒÂ¡n','Jiquilisco','Canton Tierra Blanca','75791693',1),(16,'cajerouno',2,'a47c973cdb475cec9ad0d26e0891c43f','Cajero','UsulutÃƒÂ¡n','Jiquilisco','Tierra Blanca','22222222',1),(17,'vendedor',3,'a47c973cdb475cec9ad0d26e0891c43f','Vendedor','UsulutÃƒÂ¡n','Jiquilisco','Tierra Blanca','22222222',1),(18,'adanuno',1,'a47c973cdb475cec9ad0d26e0891c43f','Marcos Tulio','UsulutÃƒÂ¡n','Jiquilisco','Canton Tierra Blanca','72363336',1),(20,'macruzgi',1,'a47c973cdb475cec9ad0d26e0891c43f','Marvin Giancarlo Cruz','','','avenida peralta','5487-8979',1),(28,'cajerofsadfsads',2,'a47c973cdb475cec9ad0d26e0891c43f','María del Carmen Guzmán','','','','0',0),(32,'cajerofsadfsads3',2,'a47c973cdb475cec9ad0d26e0891c43f','Cajero','','','sdfasfasd','9879-7870',1),(34,'cajerofsadfsads33',2,'a47c973cdb475cec9ad0d26e0891c43f','fasfasd','','','sdfasfasd','0',1),(36,'cajerofsadfsads336',2,'a47c973cdb475cec9ad0d26e0891c43f','fasfasd','','','sdfasfasd','0',0),(37,'cajerofsadfsads33674',2,'a47c973cdb475cec9ad0d26e0891c43f','fasfasd','','','sdfasfasd','0',0),(38,'marcharl',2,'a47c973cdb475cec9ad0d26e0891c43f','fasfasd','','','sdfasfasd','0',1),(39,'mirialuisa',2,'a47c973cdb475cec9ad0d26e0891c43f','Maria Luisa Tobar','','','','0',1),(40,'marvin',2,'a47c973cdb475cec9ad0d26e0891c43f','Marvin','','','','0',1),(41,'marchel',2,'a47c973cdb475cec9ad0d26e0891c43f','Marcelina Torres','','','Avenida Norte No.26','2025-____',1),(42,'usuariotest',9,'a47c973cdb475cec9ad0d26e0891c43f','Usuario test','','','','',1),(43,'jaraniba',3,'a47c973cdb475cec9ad0d26e0891c43f','Juan Araniba','','','','',1);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-07-12 22:20:13
