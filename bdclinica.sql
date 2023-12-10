-- --------------------------------------------------------
-- Host:                         localhost
-- Versión del servidor:         11.1.0-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para clinica
CREATE DATABASE IF NOT EXISTS `clinica` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;
USE `clinica`;


-- Volcando estructura para tabla clinica.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `apellidos` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pass` varchar(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `photo` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'userphoto.png',
  `direccion` varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `dni` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `rol` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'user',
  `trabajador` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0',
  `telefono` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla clinica.user: ~5 rows (aproximadamente)
DELETE FROM `user`;
INSERT INTO `user` (`id`, `nombre`, `apellidos`, `email`, `pass`, `photo`, `direccion`, `dni`, `rol`, `trabajador`, `telefono`) VALUES
	(3, 'Aitor', 'Iglesias Franjo', 'aitor@clinicacastineira.com', 'aitor', '3foto.png', 'c/Ángel del Castillo, 29', '638184210', 'admin', 'true', NULL),
	(8, 'Juan', 'Gomez Perez', 'juan@gmail.com', 'contraseña1', 'foto1.png', 'Calle 123, Ciudad A', '123456789A', 'user', 'false', '123-456-789'),
	(9, 'Maria', 'Lopez Garcia', 'maria@yahoo.com', 'contraseña2', 'foto2.png', 'Avenida XYZ, Ciudad B', '987654321B', 'user', 'false', '987-654-321'),
	(10, 'Pedro', 'Martinez Rodriguez', 'pedro@hotmail.com', 'contraseña3', 'foto3.png', 'Calle Principal, Ciudad C', '111111111C', 'admin', 'true', '111-222-333'),
	(11, 'Laura', 'Sánchez Fernández', 'laura@gmail.com', 'contraseña4', 'foto4.png', 'Carrera 456, Ciudad D', '222222222D', 'admin', 'true', '444-555-666');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;


-- Volcando estructura para tabla clinica.citas
CREATE TABLE IF NOT EXISTS `citas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_trabajador` int(11) DEFAULT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  `dia` varchar(10) DEFAULT NULL,
  `hora` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_trabajador` (`id_trabajador`),
  KEY `id_paciente` (`id_paciente`),
  CONSTRAINT `FK_citas_user` FOREIGN KEY (`id_trabajador`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_citas_user_2` FOREIGN KEY (`id_paciente`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla clinica.citas: ~4 rows (aproximadamente)
DELETE FROM `citas`;
INSERT INTO `citas` (`id`, `id_trabajador`, `id_paciente`, `dia`, `hora`) VALUES
	(46, 3, 8, '2023-12-20', '10:00'),
	(47, 3, 8, '2023-12-22', '14:30'),
	(48, 10, 9, '2023-12-21', '11:30'),
	(49, 11, 9, '2023-12-23', '16:00');

-- Volcando estructura para tabla clinica.citas_posibles
CREATE TABLE IF NOT EXISTS `citas_posibles` (
  `hora` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla clinica.citas_posibles: ~18 rows (aproximadamente)
DELETE FROM `citas_posibles`;
INSERT INTO `citas_posibles` (`hora`) VALUES
	('09:00'),
	('09:30'),
	('10:00'),
	('10:30'),
	('11:00'),
	('11:30'),
	('12:00'),
	('12:30'),
	('13:00'),
	('13:30'),
	('14:00'),
	('14:30'),
	('15:00'),
	('15:30'),
	('16:00'),
	('16:30'),
	('17:00'),
	('17:30');

-- Volcando estructura para procedimiento clinica.CrearDoc
DELIMITER //
CREATE PROCEDURE `CrearDoc`(
    IN titulo_Doc VARCHAR(255),
    IN documento_nuevo LONGTEXT,
    IN propietario_doc INT
)
BEGIN
    DECLARE nuevo_id INT;

    -- Insertar un nuevo documento
    INSERT INTO documentos (titulo, documento, propietario)
    VALUES (titulo_Doc, documento_nuevo, propietario_doc);

    -- Obtener el ID del documento recién insertado
    SET nuevo_id = (SELECT id FROM documentos WHERE propietario = propietario_doc AND documento = documento_nuevo);

    -- Devolver el nuevo ID
    SELECT nuevo_id;
END//
DELIMITER ;

-- Volcando estructura para procedimiento clinica.CrearNuevoDocumento
DELIMITER //
CREATE PROCEDURE `CrearNuevoDocumento`(
	IN `titulo_Doc` VARCHAR(255),
	IN `documento_nuevo` LONGTEXT,
	IN `propietario_doc` INT,
	IN `ult_mod` DATE
)
BEGIN
    -- Insertar un nuevo documento
    INSERT INTO documentos (titulo, documento, propietario, ultima_modificacion)
    VALUES (titulo_Doc, documento_nuevo, propietario_doc, ult_mod);

    -- Obtener el ID del documento recién insertado
    SELECT id FROM documentos WHERE propietario = propietario_doc AND documento = documento_nuevo;

END//
DELIMITER ;

-- Volcando estructura para tabla clinica.documentos
CREATE TABLE IF NOT EXISTS `documentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `documento` longtext NOT NULL,
  `propietario` int(11) NOT NULL,
  `titulo` varchar(150) DEFAULT NULL,
  `ultima_modificacion` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_propietario` (`propietario`),
  CONSTRAINT `FK_documentos_user` FOREIGN KEY (`propietario`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla clinica.documentos: ~5 rows (aproximadamente)
DELETE FROM `documentos`;
INSERT INTO `documentos` (`id`, `documento`, `propietario`, `titulo`, `ultima_modificacion`) VALUES
	(62, 'Contenido del documento para Usuario 3', 3, 'Documento Usuario 3', '2023-12-15'),
	(63, 'Contenido del documento para Usuario 8', 8, 'Documento Usuario 8', '2023-12-16'),
	(64, 'Contenido del documento para Usuario 9', 9, 'Documento Usuario 9', '2023-12-17'),
	(65, 'Contenido del documento para Usuario 10', 10, 'Documento Usuario 10', '2023-12-18'),
	(66, 'Contenido del documento para Usuario 11', 11, 'Documento Usuario 11', '2023-12-19');

-- Volcando estructura para tabla clinica.documento_compartido
CREATE TABLE IF NOT EXISTS `documento_compartido` (
  `id_documento` int(11) NOT NULL,
  `id_trabajador` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_documento`,`id_trabajador`,`id_user`),
  KEY `FK_id_trab` (`id_trabajador`),
  KEY `FK_id_usr` (`id_user`),
  CONSTRAINT `FK_documento_compartido_user` FOREIGN KEY (`id_trabajador`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK_id_doc` FOREIGN KEY (`id_documento`) REFERENCES `documentos` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK_id_usr` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla clinica.documento_compartido: ~5 rows (aproximadamente)
DELETE FROM `documento_compartido`;
INSERT INTO `documento_compartido` (`id_documento`, `id_trabajador`, `id_user`) VALUES
	(62, 3, 8),
	(64, 3, 10),
	(63, 10, 9),
	(65, 11, 11),
	(66, 11, 8);

-- Volcando estructura para tabla clinica.facturas
CREATE TABLE IF NOT EXISTS `facturas` (
  `id` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `fecha` varchar(10) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `id_user` int(11) NOT NULL DEFAULT 0,
  `cantidad` int(11) NOT NULL DEFAULT 0,
  `precioUnitario` int(11) NOT NULL DEFAULT 0,
  `precioTotal` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `FK1id_user` (`id_user`),
  CONSTRAINT `FK1id_user` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Volcando datos para la tabla clinica.facturas: ~15 rows (aproximadamente)
DELETE FROM `facturas`;
INSERT INTO `facturas` (`id`, `fecha`, `descripcion`, `id_user`, `cantidad`, `precioUnitario`, `precioTotal`) VALUES
	(000007, '2023-12-15', 'Consulta médica', 3, 1, 50, 50),
	(000008, '2023-12-16', 'Análisis clínicos', 3, 2, 30, 60),
	(000009, '2023-12-17', 'Tratamiento especializado', 3, 1, 80, 80),
	(000010, '2023-12-16', 'Consulta medica', 8, 1, 50, 50),
	(000011, '2023-12-17', 'Radiografía', 8, 1, 40, 40),
	(000012, '2023-12-18', 'Medicamentos', 8, 3, 10, 30),
	(000013, '2023-12-17', 'Consulta medica', 9, 1, 50, 50),
	(000014, '2023-12-18', 'Estudios de laboratorio', 9, 2, 25, 50),
	(000015, '2023-12-19', 'Terapia ocupacional', 9, 1, 70, 70),
	(000016, '2023-12-18', 'Consulta médica', 10, 1, 50, 50),
	(000017, '2023-12-19', 'Ecografía', 10, 1, 60, 60),
	(000018, '2023-12-20', 'Tratamiento fisioterapéutico', 10, 2, 40, 80),
	(000019, '2023-12-19', 'Consulta médica', 11, 1, 50, 50),
	(000020, '2023-12-20', 'Rehabilitación neurológica', 11, 3, 30, 90),
	(000021, '2023-12-21', 'Control de medicamentos', 11, 1, 20, 20);
