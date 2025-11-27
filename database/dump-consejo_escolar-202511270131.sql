-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: consejo_escolar
-- ------------------------------------------------------
-- Server version	8.4.3

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
-- Table structure for table `avisos`
--

DROP TABLE IF EXISTS `avisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `avisos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenido` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` enum('borrador','publicado') COLLATE utf8mb4_unicode_ci DEFAULT 'borrador',
  `fecha_publicacion` datetime DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `autor_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `autor_id` (`autor_id`),
  KEY `idx_estado` (`estado`),
  KEY `idx_fecha_publicacion` (`fecha_publicacion`),
  CONSTRAINT `avisos_ibfk_1` FOREIGN KEY (`autor_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avisos`
--

LOCK TABLES `avisos` WRITE;
/*!40000 ALTER TABLE `avisos` DISABLE KEYS */;
INSERT INTO `avisos` VALUES (1,'Inicio del Ciclo Lectivo 2025','Informamos a toda la comunidad educativa que el ciclo lectivo 2025 comenzará el próximo 4 de marzo. Se solicita a los directivos de todas las instituciones estar atentos a las comunicaciones oficiales.','publicado','2025-11-27 01:22:52','2025-11-27 04:22:52','2025-11-27 04:22:52',1),(2,'Convocatoria a Reunión de Consejeros','Se convoca a reunión ordinaria de consejeros para el día 15 de febrero a las 10:00 hs en la sede del Consejo Escolar. Orden del día: planificación del ciclo lectivo y asignación de recursos.','publicado','2025-11-27 01:22:52','2025-11-27 04:22:52','2025-11-27 04:22:52',1),(3,'Trabajos de Mantenimiento en Escuelas','Durante el receso escolar se están llevando a cabo trabajos de mantenimiento en diversas instituciones educativas del distrito. Agradecemos la paciencia y colaboración de toda la comunidad.','publicado','2025-11-27 01:22:52','2025-11-27 04:22:52','2025-11-27 04:22:52',1);
/*!40000 ALTER TABLE `avisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consejeros`
--

DROP TABLE IF EXISTS `consejeros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `consejeros` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cargo` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `institucion` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_cargo` (`cargo`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consejeros`
--

LOCK TABLES `consejeros` WRITE;
/*!40000 ALTER TABLE `consejeros` DISABLE KEYS */;
INSERT INTO `consejeros` VALUES (1,'María González','Presidenta del Consejo','Distrito Escolar','mgonzalez@consejoescolar.edu.ar',NULL,'2025-11-27 04:22:52','2025-11-27 04:22:52'),(2,'Juan Pérez','Vocal - Sector Primaria','Escuelas Primarias','jperez@consejoescolar.edu.ar',NULL,'2025-11-27 04:22:52','2025-11-27 04:22:52'),(3,'Ana Martínez','Vocal - Sector Secundaria','Escuelas Secundarias','amartinez@consejoescolar.edu.ar',NULL,'2025-11-27 04:22:52','2025-11-27 04:22:52'),(4,'Carlos Rodríguez','Secretario del Consejo','Distrito Escolar','crodriguez@consejoescolar.edu.ar',NULL,'2025-11-27 04:22:52','2025-11-27 04:22:52');
/*!40000 ALTER TABLE `consejeros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oficinas`
--

DROP TABLE IF EXISTS `oficinas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oficinas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fecha_creacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fecha_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oficinas`
--

LOCK TABLES `oficinas` WRITE;
/*!40000 ALTER TABLE `oficinas` DISABLE KEYS */;
INSERT INTO `oficinas` VALUES (1,'Secretaría General','Encargada de la gestión administrativa general del Consejo Escolar. Maneja correspondencia, documentación oficial y coordina las actividades administrativas.','secretaria@consejoescolar.edu.ar','(0291) 456-7890','2025-11-27 04:22:52','2025-11-27 04:22:52'),(2,'Oficina de Infraestructura','Responsable del mantenimiento y mejoras de los edificios escolares. Coordina trabajos de reparación, construcción y mantenimiento preventivo.','infraestructura@consejoescolar.edu.ar','(0291) 456-7891','2025-11-27 04:22:52','2025-11-27 04:22:52'),(3,'Oficina de Recursos','Gestiona la distribución de recursos materiales y equipamiento escolar. Administra inventarios y coordina la adquisición de materiales.','recursos@consejoescolar.edu.ar','(0291) 456-7892','2025-11-27 04:22:52','2025-11-27 04:22:52'),(4,'Área Legal','Brinda asesoramiento legal al Consejo Escolar. Maneja asuntos jurídicos relacionados con la gestión educativa.','legal@consejoescolar.edu.ar','(0291) 456-7893','2025-11-27 04:22:52','2025-11-27 04:22:52');
/*!40000 ALTER TABLE `oficinas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rol` enum('admin','usuario') COLLATE utf8mb4_unicode_ci DEFAULT 'usuario',
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `idx_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,'Administrador','admin@consejoescolar.edu.ar','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','admin','2025-11-27 04:22:52');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'consejo_escolar'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-27  1:31:19
