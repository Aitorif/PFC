<<<<<<< HEAD
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


-- Volcando estructura de base de datos para clinica_castineira
CREATE DATABASE IF NOT EXISTS `clinica_castineira` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;
USE `clinica_castineira`;

-- Volcando estructura para tabla clinica_castineira.citas
CREATE TABLE IF NOT EXISTS `citas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_trabajador` int(11) DEFAULT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  `dia` varchar(10) DEFAULT NULL,
  `hora` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_trabajador` (`id_trabajador`),
  KEY `id_paciente` (`id_paciente`),
  CONSTRAINT `id_paciente` FOREIGN KEY (`id_paciente`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `id_trabajador` FOREIGN KEY (`id_trabajador`) REFERENCES `trabajadores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla clinica_castineira.citas: ~4 rows (aproximadamente)
DELETE FROM `citas`;
INSERT INTO `citas` (`id`, `id_trabajador`, `id_paciente`, `dia`, `hora`) VALUES
	(20, 1, 2, '2023-12-01', '10:30'),
	(21, 2, 2, '2023-12-01', '11:00'),
	(24, 2, 1, '2023-12-05', '09:00'),
	(25, 1, 1, '2023-12-09', '09:00');

-- Volcando estructura para tabla clinica_castineira.citas_posibles
CREATE TABLE IF NOT EXISTS `citas_posibles` (
  `hora` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla clinica_castineira.citas_posibles: ~18 rows (aproximadamente)
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

-- Volcando estructura para procedimiento clinica_castineira.CrearDoc
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

-- Volcando estructura para procedimiento clinica_castineira.CrearNuevoDocumento
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

-- Volcando estructura para tabla clinica_castineira.documentos
CREATE TABLE IF NOT EXISTS `documentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `documento` longtext NOT NULL,
  `propietario` int(11) NOT NULL,
  `titulo` varchar(150) DEFAULT NULL,
  `ultima_modificacion` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_propietario` (`propietario`),
  CONSTRAINT `FK_propietario` FOREIGN KEY (`propietario`) REFERENCES `trabajadores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla clinica_castineira.documentos: ~11 rows (aproximadamente)
DELETE FROM `documentos`;
INSERT INTO `documentos` (`id`, `documento`, `propietario`, `titulo`, `ultima_modificacion`) VALUES
	(47, '<div><div>Logopeda: Dra. Carla RodrÃ­guez CastiÃ±eira<br></div><div>Paciente: Carla MarÃ­a PÃ©rez</div><div><b><i><br></i></b></div><div><i>I. InformaciÃ³n del Paciente:</i></div><div>- Nombre: Carla MarÃ­a PÃ©rez</div><div>- Edad: 28 aÃ±os</div><div>- GÃ©nero: Femenino</div><div>- Fecha de Nacimiento: 5 de julio de 1994</div><div>- DirecciÃ³n: Calle Flores #456, Ciudad</div><div><i><br></i></div><div><i>II. Historia LogopÃ©dica:</i></div><div>Carla ha sido remitida a logopedia debido a dificultades en la articulaciÃ³n y pronunciaciÃ³n de ciertos sonidos. Se observa que presenta problemas leves de vocalizaciÃ³n.</div><div><i><br></i></div><div><i>III. EvaluaciÃ³n del Habla:</i></div><div>Se realizaron pruebas de evaluaciÃ³n del habla, incluyendo la pronunciaciÃ³n de sonidos individuales y la expresiÃ³n verbal de frases y oraciones.</div><div><i><br></i></div><div><i>IV. DiagnÃ³stico LogopÃ©dico:</i></div><div>Carla ha sido diagnosticada con un trastorno leve en la articulaciÃ³n de ciertos sonidos, especÃ­ficamente /r/ y /l/. No se observan otros problemas significativos.</div><div><i><br></i></div><div><i>V. Plan de IntervenciÃ³n LogopÃ©dica:</i></div><div><ol><li>&nbsp;Sesiones semanales de terapia logopÃ©dica enfocadas en la correcciÃ³n de la pronunciaciÃ³n de /r/ y /l/.</li><li>&nbsp;Ejercicios de fortalecimiento y coordinaciÃ³n de los mÃºsculos relacionados con la articulaciÃ³n.</li><li>&nbsp;Tareas de prÃ¡ctica en el hogar para reforzar lo aprendido en las sesiones.</li></ol></div><div><i><br></i></div><div><i>VI. Progreso y Seguimiento:</i></div><div>Se programarÃ¡ una revisiÃ³n del progreso despuÃ©s de 10 sesiones de terapia. Se alienta a Carla a practicar regularmente en casa y a comunicar cualquier dificultad adicional.</div><div><i><br></i></div><div><i>VII. Observaciones Adicionales:</i></div><div>Carla ha mostrado una actitud positiva hacia la terapia y estÃ¡ comprometida con el proceso de mejora. Se espera un progreso significativo con la intervenciÃ³n logopÃ©dica adecuada.</div></div><div><br></div>', 1, 'Informe LogopÃ©dico para Carla - 2023-02-10', '2023-11-28'),
	(48, '<div>Logopeda: Dra. MarÃ­a GÃ³mez<br></div><div>Paciente: Carla PÃ©rez</div><div><b><br></b></div><div><b>**I. InformaciÃ³n del Paciente:**</b></div><div>- Nombre: Carla PÃ©rez</div><div>- Edad: 28 aÃ±os</div><div>- GÃ©nero: Femenino</div><div>- Fecha de Nacimiento: 5 de julio de 1994</div><div>- DirecciÃ³n: Calle Flores #456, Ciudad</div><div><b><br></b></div><div><b>**II. Historia LogopÃ©dica:**</b></div><div>Carla ha sido remitida a logopedia debido a dificultades en la articulaciÃ³n y pronunciaciÃ³n de ciertos sonidos. Se observa que presenta problemas leves de vocalizaciÃ³n.</div><div><b><br></b></div><div><b>**III. EvaluaciÃ³n del Habla:**</b></div><div>Se realizaron pruebas de evaluaciÃ³n del habla, incluyendo la pronunciaciÃ³n de sonidos individuales y la expresiÃ³n verbal de frases y oraciones.</div><div><b><br></b></div><div><b>**IV. DiagnÃ³stico LogopÃ©dico:**</b></div><div>Carla ha sido diagnosticada con un trastorno leve en la articulaciÃ³n de ciertos sonidos, especÃ­ficamente /r/ y /l/. No se observan otros problemas significativos.</div><div><b><br></b></div><div><b>**V. Plan de IntervenciÃ³n LogopÃ©dica:**</b></div><div>1. Sesiones semanales de terapia logopÃ©dica enfocadas en la correcciÃ³n de la pronunciaciÃ³n de /r/ y /l/.</div><div>2. Ejercicios de fortalecimiento y coordinaciÃ³n de los mÃºsculos relacionados con la articulaciÃ³n.</div><div>3. Tareas de prÃ¡ctica en el hogar para reforzar lo aprendido en las sesiones.</div><div><b><br></b></div><div><b>**VI. Progreso y Seguimiento:**</b></div><div>Se programarÃ¡ una revisiÃ³n del progreso despuÃ©s de 10 sesiones de terapia. Se alienta a Carla a practicar regularmente en casa y a comunicar cualquier dificultad adicional.</div><div><b><br></b></div><div><b>**VII. Observaciones Adicionales:**</b></div><div>Carla ha mostrado una actitud positiva hacia la terapia y estÃ¡ comprometida con el proceso de mejora. Se espera un progreso significativo con la intervenciÃ³n logopÃ©dica adecuada.</div><div><br></div>', 1, 'Informe LogopÃ©dico para Carla - 2023-05-10', '2023-11-28'),
	(50, '<div>asdsadfs</div>', 1, 'Prueba ajax', '2023-11-30'),
	(52, '<div>asdasdasd</div>', 1, 'asdasdasdasd', '2023-11-30'),
	(53, '<div>asdasdadasd</div>', 1, 'asdasdasdas', '2023-11-30'),
	(54, '<div>asdasdasdasd</div>', 1, 'adasdadasda', '2023-11-30'),
	(55, '<div>asdasdasd</div>', 1, 'asdadadasd', '2023-11-30'),
	(56, '<div>asdasdad</div>', 1, 'asdasdasdasdasd', '2023-11-30'),
	(57, '<div>asdasdasdasda</div>', 1, 'asdadasda', '2023-11-30'),
	(58, '<div>asdasdasd</div>', 1, 'asdasdasd', '2023-11-30'),
	(59, '<div>sadasdasd</div>', 1, 'Nueva prueba', '2023-12-02');

-- Volcando estructura para tabla clinica_castineira.documento_compartido
CREATE TABLE IF NOT EXISTS `documento_compartido` (
  `id_documento` int(11) NOT NULL,
  `id_trabajador` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_documento`,`id_trabajador`,`id_user`),
  KEY `FK_id_trab` (`id_trabajador`),
  KEY `FK_id_usr` (`id_user`),
  CONSTRAINT `FK_id_doc` FOREIGN KEY (`id_documento`) REFERENCES `documentos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_id_trab` FOREIGN KEY (`id_trabajador`) REFERENCES `trabajadores` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK_id_usr` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla clinica_castineira.documento_compartido: ~1 rows (aproximadamente)
DELETE FROM `documento_compartido`;
INSERT INTO `documento_compartido` (`id_documento`, `id_trabajador`, `id_user`) VALUES
	(50, 1, 1);

-- Volcando estructura para tabla clinica_castineira.facturas
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla clinica_castineira.facturas: ~2 rows (aproximadamente)
DELETE FROM `facturas`;
INSERT INTO `facturas` (`id`, `fecha`, `descripcion`, `id_user`, `cantidad`, `precioUnitario`, `precioTotal`) VALUES
	(000005, '2023-12-01', 'Consulta', 2, 1, 20, 20),
	(000006, '2023-12-01', 'Consulta', 1, 1, 30, 30);

-- Volcando estructura para tabla clinica_castineira.trabajadores
CREATE TABLE IF NOT EXISTS `trabajadores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `pass` varchar(12) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `dni` varchar(50) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `rol` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla clinica_castineira.trabajadores: ~2 rows (aproximadamente)
DELETE FROM `trabajadores`;
INSERT INTO `trabajadores` (`id`, `nombre`, `pass`, `apellidos`, `dni`, `telefono`, `email`, `rol`) VALUES
	(1, 'Aitor', 'aitor', 'Iglesias Franjo', '53796160B', '638184210', 'aitor@clinicacastineira.com', 'admin'),
	(2, 'Carla', 'abc123.', 'RodrÃ­gu CastiÃ±eira', 'RodrÃ­gu CastiÃ±eira', 'carla@clinicacastineira.com', 'carla@clinicacastineira.com', 'user');

-- Volcando estructura para tabla clinica_castineira.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `pass` varchar(12) NOT NULL,
  `photo` varchar(50) NOT NULL DEFAULT 'userphoto.jpg',
  `direccion` varchar(300) NOT NULL,
  `dni` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla clinica_castineira.user: ~2 rows (aproximadamente)
DELETE FROM `user`;
INSERT INTO `user` (`id`, `nombre`, `apellidos`, `email`, `pass`, `photo`, `direccion`, `dni`) VALUES
	(1, 'Carla', 'RodrÃ­guez', 'carla@clinicacastineira.com', 'carla', 'userphoto', 'c/Angel del castillo, 29, 8C A Coru&Ntilde;a', '6352145A'),
	(2, 'Alexis', 'Iglesias Franjo', 'alexis@gmail.com', 'alexis', 'userphoto', 'c/Finisterre, 34, 2A A Coru&Ntilde;a', '59874563A');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
=======
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


-- Volcando estructura de base de datos para clinica_castineira
CREATE DATABASE IF NOT EXISTS `clinica_castineira` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;
USE `clinica_castineira`;

-- Volcando estructura para tabla clinica_castineira.citas
CREATE TABLE IF NOT EXISTS `citas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_trabajador` int(11) DEFAULT NULL,
  `id_paciente` int(11) DEFAULT NULL,
  `dia` varchar(10) DEFAULT NULL,
  `hora` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_trabajador` (`id_trabajador`),
  KEY `id_paciente` (`id_paciente`),
  CONSTRAINT `id_paciente` FOREIGN KEY (`id_paciente`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `id_trabajador` FOREIGN KEY (`id_trabajador`) REFERENCES `trabajadores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla clinica_castineira.citas: ~4 rows (aproximadamente)
DELETE FROM `citas`;
INSERT INTO `citas` (`id`, `id_trabajador`, `id_paciente`, `dia`, `hora`) VALUES
	(20, 1, 2, '2023-12-01', '10:30'),
	(21, 2, 2, '2023-12-01', '11:00'),
	(24, 2, 1, '2023-12-05', '09:00'),
	(25, 1, 1, '2023-12-09', '09:00');

-- Volcando estructura para tabla clinica_castineira.citas_posibles
CREATE TABLE IF NOT EXISTS `citas_posibles` (
  `hora` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla clinica_castineira.citas_posibles: ~18 rows (aproximadamente)
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

-- Volcando estructura para procedimiento clinica_castineira.CrearDoc
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

-- Volcando estructura para procedimiento clinica_castineira.CrearNuevoDocumento
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

-- Volcando estructura para tabla clinica_castineira.documentos
CREATE TABLE IF NOT EXISTS `documentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `documento` longtext NOT NULL,
  `propietario` int(11) NOT NULL,
  `titulo` varchar(150) DEFAULT NULL,
  `ultima_modificacion` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_propietario` (`propietario`),
  CONSTRAINT `FK_propietario` FOREIGN KEY (`propietario`) REFERENCES `trabajadores` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla clinica_castineira.documentos: ~11 rows (aproximadamente)
DELETE FROM `documentos`;
INSERT INTO `documentos` (`id`, `documento`, `propietario`, `titulo`, `ultima_modificacion`) VALUES
	(47, '<div><div>Logopeda: Dra. Carla RodrÃ­guez CastiÃ±eira<br></div><div>Paciente: Carla MarÃ­a PÃ©rez</div><div><b><i><br></i></b></div><div><i>I. InformaciÃ³n del Paciente:</i></div><div>- Nombre: Carla MarÃ­a PÃ©rez</div><div>- Edad: 28 aÃ±os</div><div>- GÃ©nero: Femenino</div><div>- Fecha de Nacimiento: 5 de julio de 1994</div><div>- DirecciÃ³n: Calle Flores #456, Ciudad</div><div><i><br></i></div><div><i>II. Historia LogopÃ©dica:</i></div><div>Carla ha sido remitida a logopedia debido a dificultades en la articulaciÃ³n y pronunciaciÃ³n de ciertos sonidos. Se observa que presenta problemas leves de vocalizaciÃ³n.</div><div><i><br></i></div><div><i>III. EvaluaciÃ³n del Habla:</i></div><div>Se realizaron pruebas de evaluaciÃ³n del habla, incluyendo la pronunciaciÃ³n de sonidos individuales y la expresiÃ³n verbal de frases y oraciones.</div><div><i><br></i></div><div><i>IV. DiagnÃ³stico LogopÃ©dico:</i></div><div>Carla ha sido diagnosticada con un trastorno leve en la articulaciÃ³n de ciertos sonidos, especÃ­ficamente /r/ y /l/. No se observan otros problemas significativos.</div><div><i><br></i></div><div><i>V. Plan de IntervenciÃ³n LogopÃ©dica:</i></div><div><ol><li>&nbsp;Sesiones semanales de terapia logopÃ©dica enfocadas en la correcciÃ³n de la pronunciaciÃ³n de /r/ y /l/.</li><li>&nbsp;Ejercicios de fortalecimiento y coordinaciÃ³n de los mÃºsculos relacionados con la articulaciÃ³n.</li><li>&nbsp;Tareas de prÃ¡ctica en el hogar para reforzar lo aprendido en las sesiones.</li></ol></div><div><i><br></i></div><div><i>VI. Progreso y Seguimiento:</i></div><div>Se programarÃ¡ una revisiÃ³n del progreso despuÃ©s de 10 sesiones de terapia. Se alienta a Carla a practicar regularmente en casa y a comunicar cualquier dificultad adicional.</div><div><i><br></i></div><div><i>VII. Observaciones Adicionales:</i></div><div>Carla ha mostrado una actitud positiva hacia la terapia y estÃ¡ comprometida con el proceso de mejora. Se espera un progreso significativo con la intervenciÃ³n logopÃ©dica adecuada.</div></div><div><br></div>', 1, 'Informe LogopÃ©dico para Carla - 2023-02-10', '2023-11-28'),
	(48, '<div>Logopeda: Dra. MarÃ­a GÃ³mez<br></div><div>Paciente: Carla PÃ©rez</div><div><b><br></b></div><div><b>**I. InformaciÃ³n del Paciente:**</b></div><div>- Nombre: Carla PÃ©rez</div><div>- Edad: 28 aÃ±os</div><div>- GÃ©nero: Femenino</div><div>- Fecha de Nacimiento: 5 de julio de 1994</div><div>- DirecciÃ³n: Calle Flores #456, Ciudad</div><div><b><br></b></div><div><b>**II. Historia LogopÃ©dica:**</b></div><div>Carla ha sido remitida a logopedia debido a dificultades en la articulaciÃ³n y pronunciaciÃ³n de ciertos sonidos. Se observa que presenta problemas leves de vocalizaciÃ³n.</div><div><b><br></b></div><div><b>**III. EvaluaciÃ³n del Habla:**</b></div><div>Se realizaron pruebas de evaluaciÃ³n del habla, incluyendo la pronunciaciÃ³n de sonidos individuales y la expresiÃ³n verbal de frases y oraciones.</div><div><b><br></b></div><div><b>**IV. DiagnÃ³stico LogopÃ©dico:**</b></div><div>Carla ha sido diagnosticada con un trastorno leve en la articulaciÃ³n de ciertos sonidos, especÃ­ficamente /r/ y /l/. No se observan otros problemas significativos.</div><div><b><br></b></div><div><b>**V. Plan de IntervenciÃ³n LogopÃ©dica:**</b></div><div>1. Sesiones semanales de terapia logopÃ©dica enfocadas en la correcciÃ³n de la pronunciaciÃ³n de /r/ y /l/.</div><div>2. Ejercicios de fortalecimiento y coordinaciÃ³n de los mÃºsculos relacionados con la articulaciÃ³n.</div><div>3. Tareas de prÃ¡ctica en el hogar para reforzar lo aprendido en las sesiones.</div><div><b><br></b></div><div><b>**VI. Progreso y Seguimiento:**</b></div><div>Se programarÃ¡ una revisiÃ³n del progreso despuÃ©s de 10 sesiones de terapia. Se alienta a Carla a practicar regularmente en casa y a comunicar cualquier dificultad adicional.</div><div><b><br></b></div><div><b>**VII. Observaciones Adicionales:**</b></div><div>Carla ha mostrado una actitud positiva hacia la terapia y estÃ¡ comprometida con el proceso de mejora. Se espera un progreso significativo con la intervenciÃ³n logopÃ©dica adecuada.</div><div><br></div>', 1, 'Informe LogopÃ©dico para Carla - 2023-05-10', '2023-11-28'),
	(50, '<div>asdsadfs</div>', 1, 'Prueba ajax', '2023-11-30'),
	(52, '<div>asdasdasd</div>', 1, 'asdasdasdasd', '2023-11-30'),
	(53, '<div>asdasdadasd</div>', 1, 'asdasdasdas', '2023-11-30'),
	(54, '<div>asdasdasdasd</div>', 1, 'adasdadasda', '2023-11-30'),
	(55, '<div>asdasdasd</div>', 1, 'asdadadasd', '2023-11-30'),
	(56, '<div>asdasdad</div>', 1, 'asdasdasdasdasd', '2023-11-30'),
	(57, '<div>asdasdasdasda</div>', 1, 'asdadasda', '2023-11-30'),
	(58, '<div>asdasdasd</div>', 1, 'asdasdasd', '2023-11-30'),
	(59, '<div>sadasdasd</div>', 1, 'Nueva prueba', '2023-12-02');

-- Volcando estructura para tabla clinica_castineira.documento_compartido
CREATE TABLE IF NOT EXISTS `documento_compartido` (
  `id_documento` int(11) NOT NULL,
  `id_trabajador` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`id_documento`,`id_trabajador`,`id_user`),
  KEY `FK_id_trab` (`id_trabajador`),
  KEY `FK_id_usr` (`id_user`),
  CONSTRAINT `FK_id_doc` FOREIGN KEY (`id_documento`) REFERENCES `documentos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_id_trab` FOREIGN KEY (`id_trabajador`) REFERENCES `trabajadores` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK_id_usr` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla clinica_castineira.documento_compartido: ~1 rows (aproximadamente)
DELETE FROM `documento_compartido`;
INSERT INTO `documento_compartido` (`id_documento`, `id_trabajador`, `id_user`) VALUES
	(50, 1, 1);

-- Volcando estructura para tabla clinica_castineira.facturas
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla clinica_castineira.facturas: ~2 rows (aproximadamente)
DELETE FROM `facturas`;
INSERT INTO `facturas` (`id`, `fecha`, `descripcion`, `id_user`, `cantidad`, `precioUnitario`, `precioTotal`) VALUES
	(000005, '2023-12-01', 'Consulta', 2, 1, 20, 20),
	(000006, '2023-12-01', 'Consulta', 1, 1, 30, 30);

-- Volcando estructura para tabla clinica_castineira.trabajadores
CREATE TABLE IF NOT EXISTS `trabajadores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `pass` varchar(12) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `dni` varchar(50) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `rol` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla clinica_castineira.trabajadores: ~2 rows (aproximadamente)
DELETE FROM `trabajadores`;
INSERT INTO `trabajadores` (`id`, `nombre`, `pass`, `apellidos`, `dni`, `telefono`, `email`, `rol`) VALUES
	(1, 'Aitor', 'aitor', 'Iglesias Franjo', '53796160B', '638184210', 'aitor@clinicacastineira.com', 'admin'),
	(2, 'Carla', 'abc123.', 'RodrÃ­gu CastiÃ±eira', 'RodrÃ­gu CastiÃ±eira', 'carla@clinicacastineira.com', 'carla@clinicacastineira.com', 'user');

-- Volcando estructura para tabla clinica_castineira.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `pass` varchar(12) NOT NULL,
  `photo` varchar(50) NOT NULL DEFAULT 'userphoto.jpg',
  `direccion` varchar(300) NOT NULL,
  `dni` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- Volcando datos para la tabla clinica_castineira.user: ~2 rows (aproximadamente)
DELETE FROM `user`;
INSERT INTO `user` (`id`, `nombre`, `apellidos`, `email`, `pass`, `photo`, `direccion`, `dni`) VALUES
	(1, 'Carla', 'RodrÃ­guez', 'carla@clinicacastineira.com', 'carla', 'userphoto', 'c/Angel del castillo, 29, 8C A Coru&Ntilde;a', '6352145A'),
	(2, 'Alexis', 'Iglesias Franjo', 'alexis@gmail.com', 'alexis', 'userphoto', 'c/Finisterre, 34, 2A A Coru&Ntilde;a', '59874563A');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
>>>>>>> b7aea134f698fe0c7cd265d52d5db1b1e06eadcb
