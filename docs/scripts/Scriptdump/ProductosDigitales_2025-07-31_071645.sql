/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.5.28-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: ProductosDigitales
-- ------------------------------------------------------
-- Server version	11.4.6-MariaDB

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
-- Table structure for table `bitacora`
--

DROP TABLE IF EXISTS `bitacora`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `bitacora` (
  `bitacoracod` int(11) NOT NULL AUTO_INCREMENT,
  `bitacorafch` datetime DEFAULT NULL,
  `bitprograma` varchar(255) DEFAULT NULL,
  `bitdescripcion` varchar(255) DEFAULT NULL,
  `bitobservacion` mediumtext DEFAULT NULL,
  `bitTipo` char(3) DEFAULT NULL,
  `bitusuario` bigint(18) DEFAULT NULL,
  PRIMARY KEY (`bitacoracod`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bitacora`
--

/*!40000 ALTER TABLE `bitacora` DISABLE KEYS */;
/*!40000 ALTER TABLE `bitacora` ENABLE KEYS */;

--
-- Table structure for table `carretilla`
--

DROP TABLE IF EXISTS `carretilla`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `carretilla` (
  `usercod` bigint(10) NOT NULL,
  `productId` int(11) NOT NULL,
  `crrctd` int(5) NOT NULL,
  `crrprc` decimal(12,2) NOT NULL,
  `crrfching` datetime NOT NULL,
  PRIMARY KEY (`usercod`,`productId`),
  KEY `productId_idx` (`productId`),
  CONSTRAINT `carretilla_prd_key` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `carretilla_user_key` FOREIGN KEY (`usercod`) REFERENCES `usuario` (`usercod`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carretilla`
--

/*!40000 ALTER TABLE `carretilla` DISABLE KEYS */;
INSERT INTO `carretilla` VALUES (7,1,2,200.00,'2025-07-30 03:50:20'),(7,2,1,300.00,'2025-07-30 03:50:37');
/*!40000 ALTER TABLE `carretilla` ENABLE KEYS */;

--
-- Table structure for table `carretillaanon`
--

DROP TABLE IF EXISTS `carretillaanon`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `carretillaanon` (
  `anoncod` varchar(128) NOT NULL,
  `productId` int(11) NOT NULL,
  `crrctd` int(5) NOT NULL,
  `crrprc` decimal(12,2) NOT NULL,
  `crrfching` datetime NOT NULL,
  PRIMARY KEY (`anoncod`,`productId`),
  KEY `productId_idx` (`productId`),
  CONSTRAINT `carretillaanon_prd_key` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carretillaanon`
--

/*!40000 ALTER TABLE `carretillaanon` DISABLE KEYS */;
/*!40000 ALTER TABLE `carretillaanon` ENABLE KEYS */;

--
-- Table structure for table `funciones`
--

DROP TABLE IF EXISTS `funciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `funciones` (
  `fncod` varchar(255) NOT NULL,
  `fndsc` varchar(255) DEFAULT NULL,
  `fnest` char(3) DEFAULT NULL,
  `fntyp` char(3) DEFAULT NULL,
  PRIMARY KEY (`fncod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `funciones`
--

/*!40000 ALTER TABLE `funciones` DISABLE KEYS */;
INSERT INTO `funciones` VALUES ('Controllers\\FuncionesRoles\\FuncionesRoles','Controllers\\FuncionesRoles\\FuncionesRoles','ACT','ADM'),('Controllers\\FuncionesRoles\\FuncionRol','Controllers\\FuncionesRoles\\FuncionRol','ACT','ADM'),('Controllers\\Funciones\\Funcion','Controllers\\Funciones\\Funcion','ACT',''),('Controllers\\Funciones\\Funciones','Controllers\\Funciones\\Funciones','ACT','ADM'),('Controllers\\MantenimientoProductos\\Producto','Controllers\\MantenimientoProductos\\Producto','ACT','ADM'),('Controllers\\MantenimientoProductos\\Productos','Controllers\\MantenimientoProductos\\Productos','ACT','ADM'),('Controllers\\MantenimientosProductos\\MantenimientosProductos','Controllers\\MantenimientosProductos\\MantenimientosProductos','ACT','CTR'),('Controllers\\Novedades\\Novedades','Controllers\\Novedades\\Novedades','ACT','CTR'),('Controllers\\RolesUsuarios\\RolesUsuarios','Controllers\\RolesUsuarios\\RolesUsuarios','ACT','CTR'),('Controllers\\RolesUsuarios\\RolUsuario','Controllers\\RolesUsuarios\\RolUsuario','ACT','CTR'),('Controllers\\Roles\\Roles','Controllers\\Roles\\Roles','ACT','ADM'),('Controllers\\Sales\\Sales','Controllers\\Sales\\Sales','ACT','CTR'),('Controllers\\Usuarios\\Usuarios','Controllers\\Usuarios\\Usuarios','ACT','ADM'),('Controller\\RolesUsuarios\\RolesUsuarios','Controller\\RolesUsuarios\\RolesUsuarios','ACT','ADM'),('Controller\\RolesUsuarios\\RolUsuario','Controller\\RolesUsuarios\\RolUsuario','ACT','ADM'),('Controlles\\MantenimientoProductos\\Productos','Controlles\\MantenimientoProductos\\Productos',NULL,NULL),('Menu_MantenimientoFunciones','Menu_MantenimientoFunciones','ACT','MNU'),('Menu_MantenimientoProductos','Menu_MantenimientoProductos','ACT','MNU'),('Menu_PaymentCheckout','Menu_PaymentCheckout','ACT','MNU');
/*!40000 ALTER TABLE `funciones` ENABLE KEYS */;

--
-- Table structure for table `funciones_roles`
--

DROP TABLE IF EXISTS `funciones_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `funciones_roles` (
  `rolescod` varchar(128) NOT NULL,
  `fncod` varchar(255) NOT NULL,
  `fnrolest` char(3) DEFAULT NULL,
  `fnexp` datetime DEFAULT NULL,
  PRIMARY KEY (`rolescod`,`fncod`),
  KEY `rol_funcion_key_idx` (`fncod`),
  CONSTRAINT `funcion_rol_key` FOREIGN KEY (`rolescod`) REFERENCES `roles` (`rolescod`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `rol_funcion_key` FOREIGN KEY (`fncod`) REFERENCES `funciones` (`fncod`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `funciones_roles`
--

/*!40000 ALTER TABLE `funciones_roles` DISABLE KEYS */;
INSERT INTO `funciones_roles` VALUES ('ADM','Controllers\\FuncionesRoles\\FuncionesRoles','ACT','2025-10-18 00:00:00'),('ADM','Controllers\\Funciones\\Funcion','ACT','2025-08-31 00:00:00'),('ADM','Controllers\\Funciones\\Funciones','ACT','2026-02-20 00:00:00'),('ADM','Controllers\\MantenimientoProductos\\Producto','ACT','2025-08-31 00:00:00'),('ADM','Controllers\\MantenimientoProductos\\Productos','ACT','2025-08-31 00:00:00'),('ADM','Controllers\\MantenimientosProductos\\MantenimientosProductos','ACT','2025-08-31 00:00:00'),('ADM','Controllers\\Novedades\\Novedades','ACT','2025-08-31 00:00:00'),('ADM','Controllers\\RolesUsuarios\\RolesUsuarios','ACT','2025-08-31 00:00:00'),('ADM','Controllers\\RolesUsuarios\\RolUsuario','ACT','2025-09-27 00:00:00'),('ADM','Controllers\\Roles\\Roles','ACT','2025-08-31 00:00:00'),('ADM','Controllers\\Sales\\Sales','ACT','2025-08-31 00:00:00'),('ADM','Controllers\\Usuarios\\Usuarios','ACT','2025-08-31 00:00:00'),('AUD','Controllers\\FuncionesRoles\\FuncionRol','ACT','2025-08-31 00:00:00');
/*!40000 ALTER TABLE `funciones_roles` ENABLE KEYS */;

--
-- Table structure for table `highlights`
--

DROP TABLE IF EXISTS `highlights`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `highlights` (
  `highlightId` int(11) NOT NULL AUTO_INCREMENT,
  `productId` int(11) NOT NULL,
  `highlightStart` datetime NOT NULL,
  `highlightEnd` datetime NOT NULL,
  PRIMARY KEY (`highlightId`),
  KEY `fk_highlights_products_idx` (`productId`),
  CONSTRAINT `fk_highlights_products` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `highlights`
--

/*!40000 ALTER TABLE `highlights` DISABLE KEYS */;
/*!40000 ALTER TABLE `highlights` ENABLE KEYS */;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `productId` int(11) NOT NULL AUTO_INCREMENT,
  `productName` varchar(255) NOT NULL,
  `productDescription` text NOT NULL,
  `productPrice` decimal(10,2) NOT NULL,
  `productImgUrl` varchar(255) NOT NULL,
  `productStatus` char(3) NOT NULL,
  `productStock` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`productId`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Mouse Gaming','Mouse ergonómico con luces RGB, sensor de alta precisión y botones programables, ideal para juegos de alto rendimiento.',200.00,'public/imagenes/Mouse_Gaming.jpg','ACT',100),(2,'Teclado Gaming','Teclado mecánico retroiluminado con switches de alta velocidad, diseñado para gamers exigentes y largas sesiones de juego.',300.00,'public/imagenes/Teclado_gaming.jpg','ACT',30),(3,'Monitor 120hz','Monitor de 24 pulgadas con tasa de refresco de 120Hz, resolución Full HD y tecnología anti-parpadeo para una experiencia visual fluida.',700.00,'public/imagenes/Monitor_120hz.jpg','ACT',40),(4,'Mouse Pad','Alfombrilla para mouse de gran tamaño con superficie antideslizante y bordes reforzados, perfecta para gaming o trabajo de precisión.',1000.00,'public/imagenes/Pad.jpg','ACT',100),(5,'Laptop OMEN','Laptop gamer HP OMEN con procesador Intel i7, 16GB de RAM, tarjeta gráfica NVIDIA y pantalla de 144Hz para máximo rendimiento.',1500.00,'public/imagenes/Laptod_Omen.jpg','ACT',40),(6,'Laptop ASUS','Laptop ASUS con diseño delgado, procesador Ryzen 7, SSD de 512GB y gráfica integrada, ideal para trabajo y entretenimiento.',2000.00,'public/imagenes/laptod_Asus.jpg','ACT',30),(7,'PlayStation 5','Consola PlayStation 5 con gráficos 4K, disco SSD ultrarrápido y mando DualSense para una nueva generación de videojuegos.',2500.00,'public/imagenes/PlayStation5.jpg','ACT',25),(8,'XBOX 360','Consola clásica XBOX 360 con gran catálogo de juegos, conectividad en línea y control ergonómico.',1500.00,'public/imagenes/Xbox360.jpg','ACT',15),(9,'XBOX SERIES X','XBOX Series X con soporte para juegos en 4K, almacenamiento SSD y compatibilidad con generaciones anteriores.',2000.00,'public/imagenes/Xbox-Series_X.jpg','ACT',20),(10,'PC Gamer','PC Gamer de alto rendimiento con procesador Intel i9, tarjeta gráfica RTX 3080, refrigeración líquida y diseño RGB.',2500.00,'public/imagenes/Pc_Gamer.jpg','ACT',10),(11,'Disco SSD 1TB','Unidad de estado sólido (SSD) de 1TB con interfaz NVMe, ideal para aumentar la velocidad de carga del sistema y programas.',350.00,'public/imagenes/SS_1TB.jpg','ACT',80),(12,'Memoria RAM 16GB','Módulo de memoria DDR4 de 16GB a 3200MHz, excelente para multitarea, gaming y productividad.',200.00,'public/imagenes/RAM_16GB.jpg','ACT',100),(13,'Fuente de Poder 650W','Fuente de poder certificada 80 PLUS Bronze de 650W, con cableado modular y protección contra sobrecargas.',250.00,'public/imagenes/Fuente_650W.jpg','ACT',50),(14,'Tarjeta Madre ASUS B550','Placa base ASUS B550 compatible con procesadores AMD Ryzen, con soporte para PCIe 4.0 y hasta 128GB de RAM.',450.00,'public/imagenes/Motherboard_Asus_B550.jpg','ACT',40),(15,'Gabinete Gamer RGB','Gabinete para PC con panel lateral de vidrio templado, ventiladores RGB incluidos y excelente flujo de aire.',300.00,'public/imagenes/Gabinete_RGB.jpg','ACT',35),(16,'Webcam Full HD','Cámara web con resolución 1080p, micrófono integrado y conexión USB para videollamadas claras y nítidas.',120.00,'public/imagenes/Webcam_HD.jpg','ACT',60),(17,'Router Wi-Fi 6','Router de última generación con tecnología Wi-Fi 6, mayor cobertura, velocidad y eficiencia para múltiples dispositivos.',400.00,'public/imagenes/Router_Wifi.jpg','ACT',25),(18,'Sistema de Refrigeración Líquida','Kit de refrigeración líquida todo en uno con radiador de 240mm y luces RGB, compatible con Intel y AMD.',500.00,'public/imagenes/refrigeracion_liquida.jpg','ACT',20),(19,'Hub USB 3.0 4 Puertos','Hub USB con 4 puertos 3.0 para expansión de periféricos, ideal para laptops o PCs con pocos puertos.',90.00,'public/imagenes/Hub_Usb_3.0.jpg','ACT',150),(20,'Monitor Curvo 27\"','Monitor curvo de 27 pulgadas con resolución 2K, tecnología VA, 144Hz y diseño sin bordes para mayor inmersión.',950.00,'public/imagenes/Monitor_Curvo.jpg','ACT',18);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `rolescod` varchar(128) NOT NULL,
  `rolesdsc` varchar(45) DEFAULT NULL,
  `rolesest` char(3) DEFAULT NULL,
  PRIMARY KEY (`rolescod`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES ('ADM','Admiistrador','ACT'),('AUD','Auditor','ACT'),('PBL','Publico','ACT');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

--
-- Table structure for table `roles_usuarios`
--

DROP TABLE IF EXISTS `roles_usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles_usuarios` (
  `usercod` bigint(10) NOT NULL,
  `rolescod` varchar(128) NOT NULL,
  `roleuserest` char(3) DEFAULT NULL,
  `roleuserfch` datetime DEFAULT NULL,
  `roleuserexp` datetime DEFAULT NULL,
  PRIMARY KEY (`usercod`,`rolescod`),
  KEY `rol_usuario_key_idx` (`rolescod`),
  CONSTRAINT `rol_usuario_key` FOREIGN KEY (`rolescod`) REFERENCES `roles` (`rolescod`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `usuario_rol_key` FOREIGN KEY (`usercod`) REFERENCES `usuario` (`usercod`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles_usuarios`
--

/*!40000 ALTER TABLE `roles_usuarios` DISABLE KEYS */;
INSERT INTO `roles_usuarios` VALUES (3,'ADM','ACT','2025-07-18 02:17:37','2035-07-18 02:17:37'),(4,'PBL','ACT','2025-07-20 00:00:00','2026-01-21 00:00:00'),(7,'PBL','ACT','2025-07-29 21:47:44','2035-07-29 21:47:44');
/*!40000 ALTER TABLE `roles_usuarios` ENABLE KEYS */;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sales` (
  `saleId` int(11) NOT NULL AUTO_INCREMENT,
  `productId` int(11) NOT NULL,
  `salePrice` decimal(10,2) NOT NULL,
  `saleStart` datetime NOT NULL,
  `saleEnd` datetime NOT NULL,
  PRIMARY KEY (`saleId`),
  KEY `fk_sales_products_idx` (`productId`),
  CONSTRAINT `fk_sales_products` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `usercod` bigint(10) NOT NULL AUTO_INCREMENT,
  `useremail` varchar(80) DEFAULT NULL,
  `username` varchar(80) DEFAULT NULL,
  `userpswd` varchar(128) DEFAULT NULL,
  `userfching` datetime DEFAULT NULL,
  `userpswdest` char(3) DEFAULT NULL,
  `userpswdexp` datetime DEFAULT NULL,
  `userest` char(3) DEFAULT NULL,
  `useractcod` varchar(128) DEFAULT NULL,
  `userpswdchg` varchar(128) DEFAULT NULL,
  `usertipo` char(3) DEFAULT NULL,
  PRIMARY KEY (`usercod`),
  UNIQUE KEY `useremail_UNIQUE` (`useremail`),
  KEY `usertipo` (`usertipo`,`useremail`,`usercod`,`userest`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (3,'luca@gmail.com','luca','$2y$10$aXYJ9v.9ROTEk3l/tx0rN.hYbLuy6vPp1nCit6chxOi.3AqRY.Xai','2025-07-18 08:17:37','ACT','2025-10-16 00:00:00','ACT','b985bf8e38731db3721c113cbc1cfcb7940b6cbb5ea6de2280fbca8f9a685966','2025-07-18 08:17:37','PBL'),(4,'lucabotteri@gmail.com','lucabotteri','$2y$10$MjD9Zhz8Vo4O6w3PuSs./O8L3wBBs71xIarVJTuLJG4zycFGmdG..','2025-07-18 08:18:19','ACT','2025-10-16 00:00:00','ACT','0db37458a46739947ebfcc39fccedf68aff3d35fa9fc3ca97a67f769c801a3c1','2025-07-18 08:18:19','PBL'),(7,'pruebausuario@gmail.com','pruebausuario','$2y$10$tVHbPYNVzZnckLmTnMXv.ODqMZyYDIHNiGwDD4EgV7UHrCJ5EPhy.','2025-07-30 03:47:44','ACT','2025-10-27 00:00:00','ACT','bc3ecc62e9295a7c4c33e86ca8812f8f9d7275f9ea7c3619734cc5f80ff798d3','2025-07-30 03:47:44','PBL');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;

--
-- Dumping routines for database 'ProductosDigitales'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-07-31  7:17:10
