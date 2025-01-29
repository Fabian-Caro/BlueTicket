-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: blueticketv3
-- ------------------------------------------------------
-- Server version	8.0.37

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
-- Table structure for table `artista`
--

DROP TABLE IF EXISTS `artista`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `artista` (
  `idArtista` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`idArtista`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `artista`
--

LOCK TABLES `artista` WRITE;
/*!40000 ALTER TABLE `artista` DISABLE KEYS */;
INSERT INTO `artista` VALUES (8,'Club Deportivo La Equidad'),(9,'Carnaval de Barranquilla SAS'),(10,'Mac Latam S.A.S'),(11,'Angel Blue'),(12,'Andrés Lopez'),(13,' BREAKFAST TBL SAS');
/*!40000 ALTER TABLE `artista` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `boleta`
--

DROP TABLE IF EXISTS `boleta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `boleta` (
  `idBoleta` int NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(45) NOT NULL,
  `idFactura` int NOT NULL,
  `idDetalle` int NOT NULL,
  PRIMARY KEY (`idBoleta`),
  KEY `fk_Factura_Boleta_Boleta1_idx` (`idDetalle`),
  KEY `fk_Boleta_Factura1_idx` (`idFactura`),
  CONSTRAINT `fk_Boleta_Factura1` FOREIGN KEY (`idFactura`) REFERENCES `factura` (`idFactura`),
  CONSTRAINT `fk_Factura_Boleta_Boleta1` FOREIGN KEY (`idDetalle`) REFERENCES `detalle_evento` (`idDetalle`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `boleta`
--

LOCK TABLES `boleta` WRITE;
/*!40000 ALTER TABLE `boleta` DISABLE KEYS */;
INSERT INTO `boleta` VALUES (4,'Fabian',4,9),(5,'Jo',4,9),(6,'Jo',5,19),(7,'Jo',5,22),(8,'',6,12);
/*!40000 ALTER TABLE `boleta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carro`
--

DROP TABLE IF EXISTS `carro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carro` (
  `idCarro` int NOT NULL AUTO_INCREMENT,
  `nombre_usuario` varchar(45) NOT NULL,
  `idCliente` int NOT NULL,
  `idDetalle` int NOT NULL,
  PRIMARY KEY (`idCarro`),
  KEY `fk_Cliente_has_Detalle_evento_Detalle_evento1_idx` (`idDetalle`),
  KEY `fk_Cliente_has_Detalle_evento_Cliente1_idx` (`idCliente`),
  CONSTRAINT `fk_Cliente_has_Detalle_evento_Cliente1` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idCliente`),
  CONSTRAINT `fk_Cliente_has_Detalle_evento_Detalle_evento1` FOREIGN KEY (`idDetalle`) REFERENCES `detalle_evento` (`idDetalle`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carro`
--

LOCK TABLES `carro` WRITE;
/*!40000 ALTER TABLE `carro` DISABLE KEYS */;
INSERT INTO `carro` VALUES (71,'Lucas',2,16),(72,'Pedro',2,16),(74,'Camilo',2,13),(75,'Juana',2,13),(76,'Ana',2,13);
/*!40000 ALTER TABLE `carro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `idCategoria` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`idCategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (5,'Concierto'),(6,'Teatro'),(7,'Deportes'),(8,'Festival'),(9,'Conferencia y congreso'),(10,'Comedia'),(11,'Exposición');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ciudad`
--

DROP TABLE IF EXISTS `ciudad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ciudad` (
  `idCiudad` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`idCiudad`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ciudad`
--

LOCK TABLES `ciudad` WRITE;
/*!40000 ALTER TABLE `ciudad` DISABLE KEYS */;
INSERT INTO `ciudad` VALUES (4,'Bogotá'),(5,'Medellín'),(6,'Cali'),(7,'Barranquilla'),(8,'Cartagena'),(9,'Cúcuta'),(10,'Bucaramanga'),(11,'Pereira'),(12,'Santa Marta'),(13,'Ibagué'),(14,'Manizales'),(15,'Villavicencio'),(16,'Montería'),(17,'Neiva'),(18,'Pasto');
/*!40000 ALTER TABLE `ciudad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cliente` (
  `idCliente` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `clave` varchar(45) NOT NULL,
  `estado` int DEFAULT '0',
  PRIMARY KEY (`idCliente`),
  UNIQUE KEY `correo_UNIQUE` (`correo`),
  CONSTRAINT `cliente_chk_1` CHECK ((`estado` in (0,1,2)))
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (1,'Fabian','Caro','fm@correo.com','81dc9bdb52d04dc20036dbd8313ed055',1),(2,'Jo','Donghee','jd@correo.com','81dc9bdb52d04dc20036dbd8313ed055',1);
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detalle_evento`
--

DROP TABLE IF EXISTS `detalle_evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detalle_evento` (
  `idDetalle` int NOT NULL AUTO_INCREMENT,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_final` time NOT NULL,
  `costo` double NOT NULL,
  `aforo` int NOT NULL,
  `idLugar` int NOT NULL,
  `idEvento` int NOT NULL,
  PRIMARY KEY (`idDetalle`),
  KEY `fk_Lugar_Evento_Lugar1_idx` (`idLugar`),
  KEY `fk_Lugar_Evento_Evento1_idx` (`idEvento`),
  CONSTRAINT `fk_Lugar_Evento_Evento1` FOREIGN KEY (`idEvento`) REFERENCES `evento` (`idEvento`),
  CONSTRAINT `fk_Lugar_Evento_Lugar1` FOREIGN KEY (`idLugar`) REFERENCES `lugar` (`idLugar`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detalle_evento`
--

LOCK TABLES `detalle_evento` WRITE;
/*!40000 ALTER TABLE `detalle_evento` DISABLE KEYS */;
INSERT INTO `detalle_evento` VALUES (9,'2025-02-02','14:00:00','16:30:00',80000,33000,7,8),(10,'2025-02-28','18:00:00','00:00:00',50000,10000,8,9),(11,'2025-03-01','18:00:00','00:00:00',50000,10000,8,9),(12,'2025-03-02','18:00:00','00:00:00',50000,10000,8,9),(13,'2025-06-12','11:00:00','17:00:00',35000,10000,9,10),(14,'2025-06-13','11:00:00','17:00:00',35000,10000,9,10),(15,'2025-06-14','11:00:00','17:00:00',35000,10000,9,10),(16,'2025-01-31','20:00:00','22:00:00',30000,1000,10,11),(17,'2025-01-31','20:00:00','23:00:00',86200,1500,11,12),(18,'2025-02-01','20:00:00','23:00:00',86200,1500,11,12),(19,'2025-02-02','17:00:00','20:00:00',86200,1500,11,12),(20,'2025-02-07','17:00:00','20:00:00',86200,1500,11,12),(21,'2025-02-14','17:00:00','00:00:00',557500,40000,12,13),(22,'2025-02-15','17:00:00','00:00:00',557500,40000,12,13);
/*!40000 ALTER TABLE `detalle_evento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evento`
--

DROP TABLE IF EXISTS `evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evento` (
  `idEvento` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `idProveedor` int NOT NULL,
  `idCategoria` int NOT NULL,
  `idArtista` int NOT NULL,
  `imagen` varchar(45) NOT NULL DEFAULT 'defaultImg.jpeg',
  PRIMARY KEY (`idEvento`),
  KEY `fk_Evento_Proveedor_idx` (`idProveedor`),
  KEY `fk_Evento_Categoria1_idx` (`idCategoria`),
  KEY `fk_Evento_Artista1_idx` (`idArtista`),
  CONSTRAINT `fk_Evento_Artista1` FOREIGN KEY (`idArtista`) REFERENCES `artista` (`idArtista`),
  CONSTRAINT `fk_Evento_Categoria1` FOREIGN KEY (`idCategoria`) REFERENCES `categoria` (`idCategoria`),
  CONSTRAINT `fk_Evento_Proveedor` FOREIGN KEY (`idProveedor`) REFERENCES `proveedor` (`idProveedor`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evento`
--

LOCK TABLES `evento` WRITE;
/*!40000 ALTER TABLE `evento` DISABLE KEYS */;
INSERT INTO `evento` VALUES (8,'EQUIDAD VS NACIONAL 2025-1',1,7,8,'1738122105.jpg'),(9,'BAILA LA CALLE 2025 ',1,8,9,'1738121358.jpg'),(10,'EXPOLICORES 2025 ',1,11,10,'1738121954.jpg'),(11,'Orquesta Filarmonica de Bogotá - Angel Blue',2,5,11,'1738122408.jpg'),(12,'LA PELOTA DE LETRAS ',2,10,12,'1738122636.jpg'),(13,'TOMORROWLAND PRESENTS CORE 2025',2,5,13,'1738123009.jpg');
/*!40000 ALTER TABLE `evento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `factura`
--

DROP TABLE IF EXISTS `factura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `factura` (
  `idFactura` int NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `valor_subtotal` double NOT NULL,
  `valor_total` double NOT NULL,
  `idCliente` int NOT NULL,
  PRIMARY KEY (`idFactura`),
  KEY `fk_Factura_Cliente1_idx` (`idCliente`),
  CONSTRAINT `fk_Factura_Cliente1` FOREIGN KEY (`idCliente`) REFERENCES `cliente` (`idCliente`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `factura`
--

LOCK TABLES `factura` WRITE;
/*!40000 ALTER TABLE `factura` DISABLE KEYS */;
INSERT INTO `factura` VALUES (4,'2025-01-28 23:02:59',160000,190400,1),(5,'2025-01-29 04:18:51',643700,766003,2),(6,'2025-01-28 23:24:55',50000,59500,1);
/*!40000 ALTER TABLE `factura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lugar`
--

DROP TABLE IF EXISTS `lugar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lugar` (
  `idLugar` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `direccion` varchar(45) NOT NULL,
  `capacidad_maxima` int DEFAULT NULL COMMENT 'Capacidad máxima del lugar',
  `idCiudad` int NOT NULL,
  PRIMARY KEY (`idLugar`),
  KEY `fk_Lugar_Ciudad1_idx` (`idCiudad`),
  CONSTRAINT `fk_Lugar_Ciudad1` FOREIGN KEY (`idCiudad`) REFERENCES `ciudad` (`idCiudad`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lugar`
--

LOCK TABLES `lugar` WRITE;
/*!40000 ALTER TABLE `lugar` DISABLE KEYS */;
INSERT INTO `lugar` VALUES (7,'Estadio Nemesio Camacho El Campín','Carrera 30 y Calle 57, Bogotá',60000,4),(8,'Vía de la Carrera 50 con Calle Murillo','Vía de la Carrera 50 con Calle Murillo',10000,7),(9,'Hacienda San Rafael','Cra. 57 #133, Suba, Bogotá',20000,4),(10,'Bogotá Teatro Mayor Julio Mario Santo Domingo','Cl. 170 #67-51, Bogotá',1000,4),(11,'Teatro Cafam','Av. 68 #9088, Bogotá',1500,4),(12,'Parque Norte','Cra. 53 #76-115, Medellín',50000,5);
/*!40000 ALTER TABLE `lugar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proveedor`
--

DROP TABLE IF EXISTS `proveedor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `proveedor` (
  `idProveedor` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `apellido` varchar(45) NOT NULL,
  `correo` varchar(45) NOT NULL,
  `clave` varchar(45) NOT NULL,
  `estado` int DEFAULT '0',
  PRIMARY KEY (`idProveedor`),
  UNIQUE KEY `correo_UNIQUE` (`correo`),
  CONSTRAINT `proveedor_chk_1` CHECK ((`estado` in (0,1,2)))
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proveedor`
--

LOCK TABLES `proveedor` WRITE;
/*!40000 ALTER TABLE `proveedor` DISABLE KEYS */;
INSERT INTO `proveedor` VALUES (1,'Fabian','Caro','fc@bt.es','81dc9bdb52d04dc20036dbd8313ed055',1),(2,'Jo','Donghee','jd@bt.com','81dc9bdb52d04dc20036dbd8313ed055',1);
/*!40000 ALTER TABLE `proveedor` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-28 23:28:02
