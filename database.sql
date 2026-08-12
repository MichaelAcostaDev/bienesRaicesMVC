/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

/* =========================================================
   DROP TABLES
   ========================================================= */

DROP TABLE IF EXISTS `propiedades`;
DROP TABLE IF EXISTS `vendedores`;
DROP TABLE IF EXISTS `usuarios`;

/* =========================================================
   TABLA: usuarios
   ========================================================= */

CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(60) DEFAULT NULL,
  `password` char(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

/* =========================================================
   TABLA: vendedores
   ========================================================= */

CREATE TABLE `vendedores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) DEFAULT NULL,
  `apellido` varchar(45) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

/* =========================================================
   TABLA: propiedades
   ========================================================= */

CREATE TABLE `propiedades` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(60) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `imagen` varchar(200) DEFAULT NULL,
  `descripcion` longtext,
  `habitaciones` int DEFAULT NULL,
  `wc` int DEFAULT NULL,
  `estacionamiento` int DEFAULT NULL,
  `vendedorId` int DEFAULT NULL,
  `creado` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `vendedorId_idx` (`vendedorId`),
  CONSTRAINT `vendedorId`
    FOREIGN KEY (`vendedorId`)
    REFERENCES `vendedores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

/* =========================================================
   DATOS: usuarios
   ========================================================= */

INSERT INTO `usuarios`
(`id`, `email`, `password`)
VALUES
(7, 'admin@admin.com', '$2y$12$WT.pLeTlmtSMVsF6jitlKOkde/1kgNJrm.7sa4PG9/xaYf91WiPVq');

/* =========================================================
   DATOS: vendedores
   ========================================================= */

INSERT INTO `vendedores`
(`id`, `nombre`, `apellido`, `telefono`)
VALUES
(1, 'Liz', 'Del Rosario', '0987654321'),
(3, 'Michael Alexander', 'Acosta Ortega', '1234567890');

/* =========================================================
   DATOS: propiedades
   ========================================================= */

INSERT INTO `propiedades`
(`id`, `titulo`, `precio`, `imagen`, `descripcion`, `habitaciones`, `wc`, `estacionamiento`, `vendedorId`, `creado`)
VALUES
(3, 'Casa Moderna - 1', 486085.00, 'anuncio1.jpg', 'Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. ', 1, 1, 3, 1, '2026-06-27'),
(4, 'Casa Familiar - 2', 330027.00, 'anuncio2.jpg', 'Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. ', 5, 3, 0, 1, '2026-06-27'),
(5, 'Villa de Lujo - 3', 154498.00, 'anuncio3.jpg', 'Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. ', 5, 3, 3, 1, '2026-06-27'),
(6, 'Departamento Central - 4', 273456.00, 'anuncio4.jpg', 'Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. ', 4, 2, 3, 1, '2026-06-27'),
(7, 'Casa en el Lago - 5', 245066.00, 'anuncio5.jpg', 'Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. ', 5, 3, 3, 1, '2026-06-27'),
(8, 'Residencia Amplia - 6', 481366.00, 'anuncio6.jpg', 'Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. Propiedad en excelente ubicación. ', 4, 3, 0, 1, '2026-06-27');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
