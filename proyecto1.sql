-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 09-11-2021 a las 02:50:02
-- Versión del servidor: 10.4.20-MariaDB
-- Versión de PHP: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto1`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_buscar_maximo` (IN `p_id_enc` VARCHAR(30))  SELECT (nvl(max(id_det),0) + 1) as id_det FROM det_encuestas WHERE id_encuesta = p_id_enc$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_detalle` (IN `p_id_det` VARCHAR(30), IN `p_id_enc` VARCHAR(30))  BEGIN
DELETE FROM det_encuestas WHERE id_det = p_id_det and id_encuesta = p_id_enc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_delete_encuesta` (IN `p_id_enc` VARCHAR(30))  BEGIN
DELETE FROM encuestas WHERE id_enc = p_id_enc;
DELETE FROM det_encuestas WHERE id_encuesta = p_id_enc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insertar_det_encuesta` (IN `p_id_enc` VARCHAR(30), IN `p_nom_enc` VARCHAR(100), IN `p_id_det_enc` VARCHAR(30), IN `p_descripcion` VARCHAR(100), IN `p_tipo` VARCHAR(30))  INSERT INTO `det_encuestas`(`id_encuesta`, `nom_encuesta`, `id_det`, `descripcion`, `tipo`) VALUES (p_id_enc,p_nom_enc,p_id_det_enc,p_descripcion,p_tipo)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insertar_encuesta` (IN `p_nom_enc` VARCHAR(100), IN `p_tipo` VARCHAR(30))  BEGIN

INSERT INTO encuestas(nom_encuesta,tipo) VALUES (p_nom_enc,p_tipo);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insertar_resp` (IN `p_id_enc` VARCHAR(30), IN `p_id_det_enc` VARCHAR(30), IN `p_nombre` VARCHAR(100), IN `p_cedula` VARCHAR(50))  INSERT INTO respuestas(id_encuesta, id_det_encuesta, nombre, cedula) VALUES (p_id_enc, p_id_det_enc, p_nombre, p_cedula)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listar_detalle_sp` (IN `p_id_det` VARCHAR(30))  select 
*
from det_encuestas
where id_det = p_id_det$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listar_det_enc` ()  BEGIN
select 
det.*
from
((SELECT * 
FROM encuestas 
where id_enc <= 4
order by id_enc)
union all
(SELECT * 
FROM encuestas 
where id_enc > 4
ORDER BY rand() LIMIT 10))encab,
det_encuestas det
where encab.id_enc = det.id_encuesta
order by det.id_encuesta, det.id_det;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listar_det_encp` (IN `p_id_enc` VARCHAR(30))  BEGIN
SELECT * FROM det_encuestas WHERE id_encuesta = p_id_enc order by id_encuesta, id_det;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listar_encuestas` ()  select 
*
from encuestas$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listar_encuesta_sp` (IN `p_id_enc` VARCHAR(30))  select 
*
from encuestas
where id_enc = p_id_enc$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listar_respuestas` (IN `p_id_enc` VARCHAR(30))  BEGIN
SET @s = CONCAT("SELECT det.nom_encuesta
      ,det.descripcion
      ,(select 
               count(*)
         FROM  respuestas sq_rep
         WHERE sq_rep.id_encuesta = det.id_encuesta
         AND   sq_rep.id_det_encuesta = det.id_det)cantidad
      ,(select 
               count(*)
         FROM  respuestas sq_rep
         WHERE sq_rep.id_encuesta = det.id_encuesta)cantidad_total
FROM  det_encuestas det
WHERE det.id_encuesta = ", p_id_enc,
" group by det.nom_encuesta, det.descripcion
order by det.id_encuesta, det.id_det");
PREPARE stmt FROM @s;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_listar_res_enc` ()  BEGIN
SELECT distinct id_encuesta, nom_encuesta
FROM det_encuestas order by id_encuesta;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_modificar_detalle` (IN `p_id_det` VARCHAR(30), IN `p_nom_det` VARCHAR(100))  BEGIN
UPDATE 	det_encuestas 
SET 	descripcion = p_nom_det
WHERE 	id_det = p_id_det;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_modificar_encuesta` (IN `p_id_enc` VARCHAR(30), IN `p_nom_enc` VARCHAR(100), IN `p_tipo` VARCHAR(30))  BEGIN
UPDATE 	encuestas 
SET 	nom_encuesta = p_nom_enc,
    	tipo = p_tipo
WHERE 	id_enc = p_id_enc;

UPDATE 	det_encuestas 
SET 	nom_encuesta = p_nom_enc,
    	tipo = p_tipo
WHERE 	id_encuesta = p_id_enc;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_validar_resp_det` (IN `p_id_enc` VARCHAR(30), IN `p_id_det` VARCHAR(30))  select 
count(*) registros
from respuestas
where id_encuesta = p_id_enc
and   id_det_encuesta = p_id_det$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_validar_resp_enc` (IN `p_id_enc` VARCHAR(30))  select 
count(*)registros
from respuestas
where id_encuesta = p_id_enc$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `det_encuestas`
--

CREATE TABLE `det_encuestas` (
  `id` int(11) NOT NULL,
  `id_encuesta` int(11) NOT NULL,
  `nom_encuesta` varchar(300) NOT NULL,
  `id_det` int(11) NOT NULL,
  `descripcion` varchar(300) NOT NULL,
  `tipo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `det_encuestas`
--

INSERT INTO `det_encuestas` (`id`, `id_encuesta`, `nom_encuesta`, `id_det`, `descripcion`, `tipo`) VALUES
(1, 1, 'Genero', 1, 'Masculino', 'RB'),
(2, 1, 'Genero', 2, 'Femenino', 'RB'),
(3, 2, 'Rango de edad', 1, '20 a 30', 'RB'),
(4, 2, 'Rango de edad', 2, '31 a 40', 'RB'),
(5, 2, 'Rango de edad', 3, '41 a 50', 'RB'),
(6, 2, 'Rango de edad', 4, '51 o mas', 'RB'),
(7, 3, 'Rango salarial', 1, '500 a 1000', 'RB'),
(8, 3, 'Rango salarial', 2, '1001 a 1500', 'RB'),
(9, 3, 'Rango salarial', 3, '1501 a 2000', 'RB'),
(10, 3, 'Rango salarial', 4, '2001 o mas', 'RB'),
(11, 4, 'Provincia', 1, 'Panama', 'RB'),
(12, 4, 'Provincia', 2, 'Panama Oeste', 'RB'),
(13, 4, 'Provincia', 3, 'Darien', 'RB'),
(14, 4, 'Provincia', 4, 'Coclé', 'RB'),
(15, 4, 'Provincia', 5, 'Herrera', 'RB'),
(16, 4, 'Provincia', 6, 'Los Santos', 'RB'),
(17, 4, 'Provincia', 7, 'Colon', 'RB'),
(18, 4, 'Provincia', 8, 'Veraguas', 'RB'),
(19, 4, 'Provincia', 9, 'Chiriquí', 'RB'),
(20, 4, 'Provincia', 10, 'Bocas del Toro', 'RB'),
(21, 5, '¿Disfrutas aprendiendo de forma virtual?', 1, 'Si, absolutamente', 'RB'),
(22, 5, '¿Disfrutas aprendiendo de forma virtual?', 2, 'No, hay bastantes desafíos', 'RB'),
(23, 5, '¿Disfrutas aprendiendo de forma virtual?', 3, 'No, en absoluto', 'RB'),
(24, 6, '¿confía  en que la educación virtual favorece el progreso académico? ', 1, 'Si', 'RB'),
(25, 6, '¿confía  en que la educación virtual favorece el progreso académico? ', 2, 'No', 'RB'),
(26, 7, '¿Qué  opinas en general sobre la educación virtual?', 1, 'Excelente', 'RB'),
(27, 7, '¿Qué  opinas en general sobre la educación virtual?', 2, 'Regular', 'RB'),
(28, 7, '¿Qué  opinas en general sobre la educación virtual?', 3, 'No aprendo nada', 'RB'),
(29, 7, '¿Qué  opinas en general sobre la educación virtual?', 4, 'Malo', 'RB'),
(30, 8, '¿Tienes acceso a un dispositivo para aprender en línea?', 1, 'Si', 'RB'),
(31, 8, '¿Tienes acceso a un dispositivo para aprender en línea?', 2, 'No', 'RB'),
(32, 9, '¿Qué dispositivo utilizas para el aprendizaje a distancia?', 1, 'Tablet', 'CB'),
(33, 9, '¿Qué dispositivo utilizas para el aprendizaje a distancia?', 2, 'Celular', 'CB'),
(34, 9, '¿Qué dispositivo utilizas para el aprendizaje a distancia?', 3, 'Computadora', 'CB'),
(35, 10, '¿Cuánto tiempo dedicas cada día en promedio a la educación virtual?', 1, '1 a 3 Horas', 'RB'),
(36, 10, '¿Cuánto tiempo dedicas cada día en promedio a la educación virtual?', 2, '3 a 5 Horas', 'RB'),
(37, 10, '¿Cuánto tiempo dedicas cada día en promedio a la educación virtual?', 3, '5 a 7 Horas', 'RB'),
(38, 10, '¿Cuánto tiempo dedicas cada día en promedio a la educación virtual?', 4, '7 a 10 Horas', 'RB'),
(39, 10, '¿Cuánto tiempo dedicas cada día en promedio a la educación virtual?', 5, 'mas de 10 Horas', 'RB'),
(40, 11, '¿Qué tan efectivo ha sido el aprendizaje de manera virtual?', 1, 'Excelente', 'RB'),
(41, 11, '¿Qué tan efectivo ha sido el aprendizaje de manera virtual?', 2, 'Regular', 'RB'),
(42, 11, '¿Qué tan efectivo ha sido el aprendizaje de manera virtual?', 3, 'Malo', 'RB'),
(43, 12, '¿Qué tan útil ha sido la [ escuela o universidad] al ofrecer los recursos para aprender en casa?', 1, 'Para nada util', 'RB'),
(44, 12, '¿Qué tan útil ha sido la [ escuela o universidad] al ofrecer los recursos para aprender en casa?', 2, 'Ligeramente util', 'RB'),
(45, 12, '¿Qué tan útil ha sido la [ escuela o universidad] al ofrecer los recursos para aprender en casa?', 3, 'Moderadamente util', 'RB'),
(46, 12, '¿Qué tan útil ha sido la [ escuela o universidad] al ofrecer los recursos para aprender en casa?', 4, 'Muy util', 'RB'),
(47, 12, '¿Qué tan útil ha sido la [ escuela o universidad] al ofrecer los recursos para aprender en casa?', 5, 'Extremendamente util', 'RB'),
(48, 13, '¿Siente que la comunicación es fluida entre estudiantes y profesores?', 1, 'Si', 'RB'),
(49, 13, '¿Siente que la comunicación es fluida entre estudiantes y profesores?', 2, 'No', 'RB'),
(50, 14, '¿Tus profesores son efectivos al estudiar en línea? ', 1, 'Si', 'RB'),
(51, 14, '¿Tus profesores son efectivos al estudiar en línea? ', 2, 'No', 'RB'),
(52, 15, '¿El  ambiente en tu casa es pacifico mientras aprendes?', 1, 'Si', 'RB'),
(53, 15, '¿El  ambiente en tu casa es pacifico mientras aprendes?', 2, 'No', 'RB'),
(54, 16, '¿Tiene acceso a internet desde su hogar? ', 1, 'Si', 'RB'),
(55, 16, '¿Tiene acceso a internet desde su hogar? ', 2, 'No', 'RB'),
(56, 17, '¿Con que tipo de internet Cuentas?', 1, 'Internet Movil', 'CB'),
(57, 17, '¿Con que tipo de internet Cuentas?', 2, 'Internet Residencial', 'CB'),
(58, 17, '¿Con que tipo de internet Cuentas?', 3, 'Internet Satelital', 'CB'),
(59, 18, '¿Cuál  considera como el mecanismo mas efectivo para que los(as) estudiantes realicen las asignacion', 1, 'Plataforma educativas', 'RB'),
(60, 18, '¿Cuál  considera como el mecanismo mas efectivo para que los(as) estudiantes realicen las asignacion', 2, 'Guias Impresas', 'RB'),
(61, 19, '¿Considera  que la educación virtual  debe ser una opción para los estudiantes cuando acabe el estad', 1, 'Si', 'RB'),
(62, 19, '¿Considera  que la educación virtual  debe ser una opción para los estudiantes cuando acabe el estad', 2, 'No', 'RB'),
(63, 20, '¿La educación virtual debería tener el mismo costo que la educación presencial? ', 1, 'Si', 'RB'),
(64, 20, '¿La educación virtual debería tener el mismo costo que la educación presencial? ', 2, 'No', 'RB');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuestas`
--

CREATE TABLE `encuestas` (
  `id_enc` int(11) NOT NULL,
  `nom_encuesta` varchar(300) NOT NULL,
  `tipo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `encuestas`
--

INSERT INTO `encuestas` (`id_enc`, `nom_encuesta`, `tipo`) VALUES
(1, 'Genero', 'RB'),
(2, 'Rango de edad', 'RB'),
(3, 'Rango salarial', 'RB'),
(4, 'Provincia', 'RB'),
(5, '¿Disfrutas aprendiendo de forma virtual?', 'RB'),
(6, '¿confía  en que la educación virtual favorece el progreso académico? ', 'RB'),
(7, '¿Qué  opinas en general sobre la educación virtual?', 'RB'),
(8, '¿Tienes acceso a un dispositivo para aprender en línea?', 'RB'),
(9, '¿Qué dispositivo utilizas para el aprendizaje a distancia?', 'CB'),
(10, '¿Cuánto tiempo dedicas cada día en promedio a la educación virtual?', 'RB'),
(11, '¿Qué tan efectivo ha sido el aprendizaje de manera virtual?', 'RB'),
(12, '¿Qué tan útil ha sido la [ escuela o universidad] al ofrecer los recursos para aprender en casa?', 'RB'),
(13, '¿Siente que la comunicación es fluida entre estudiantes y profesores?', 'RB'),
(14, '¿Tus profesores son efectivos al estudiar en línea? ', 'RB'),
(15, '¿El  ambiente en tu casa es pacifico mientras aprendes?', 'RB'),
(16, '¿Tiene acceso a internet desde su hogar? ', 'RB'),
(17, '¿Con que tipo de internet Cuentas?', 'CB'),
(18, '¿Cuál  considera como el mecanismo mas efectivo para que los(as) estudiantes realicen las asignacion', 'RB'),
(19, '¿Considera  que la educación virtual  debe ser una opción para los estudiantes cuando acabe el estad', 'RB'),
(20, '¿La educación virtual debería tener el mismo costo que la educación presencial? ', 'RB');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `id` int(11) NOT NULL,
  `id_encuesta` int(11) NOT NULL,
  `id_det_encuesta` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `cedula` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `respuestas`
--

INSERT INTO `respuestas` (`id`, `id_encuesta`, `id_det_encuesta`, `nombre`, `cedula`) VALUES
(1, 1, 1, 'Luis Valdes', '4-720-230'),
(2, 2, 3, 'Luis Valdes', '4-720-230'),
(3, 3, 4, 'Luis Valdes', '4-720-230'),
(4, 4, 2, 'Luis Valdes', '4-720-230'),
(5, 5, 1, 'Luis Valdes', '4-720-230'),
(6, 6, 1, 'Luis Valdes', '4-720-230'),
(7, 7, 1, 'Luis Valdes', '4-720-230'),
(8, 8, 1, 'Luis Valdes', '4-720-230'),
(9, 9, 1, 'Luis Valdes', '4-720-230'),
(10, 9, 2, 'Luis Valdes', '4-720-230'),
(11, 9, 3, 'Luis Valdes', '4-720-230'),
(12, 10, 2, 'Luis Valdes', '4-720-230'),
(13, 11, 1, 'Luis Valdes', '4-720-230'),
(14, 12, 5, 'Luis Valdes', '4-720-230'),
(15, 13, 1, 'Luis Valdes', '4-720-230'),
(16, 14, 1, 'Luis Valdes', '4-720-230'),
(17, 15, 2, 'Luis Valdes', '4-720-230'),
(18, 16, 2, 'Luis Valdes', '4-720-230'),
(19, 17, 1, 'Luis Valdes', '4-720-230'),
(20, 17, 2, 'Luis Valdes', '4-720-230'),
(21, 18, 1, 'Luis Valdes', '4-720-230'),
(22, 19, 1, 'Luis Valdes', '4-720-230'),
(23, 20, 2, 'Luis Valdes', '4-720-230'),
(24, 1, 2, 'Marcos Mojica', '4-774-251'),
(25, 2, 4, 'Marcos Mojica', '4-774-251'),
(26, 3, 4, 'Marcos Mojica', '4-774-251'),
(27, 4, 10, 'Marcos Mojica', '4-774-251'),
(28, 7, 4, 'Marcos Mojica', '4-774-251'),
(29, 8, 2, 'Marcos Mojica', '4-774-251'),
(30, 9, 2, 'Marcos Mojica', '4-774-251'),
(31, 11, 3, 'Marcos Mojica', '4-774-251'),
(32, 12, 5, 'Marcos Mojica', '4-774-251'),
(33, 13, 2, 'Marcos Mojica', '4-774-251'),
(34, 15, 2, 'Marcos Mojica', '4-774-251'),
(35, 16, 2, 'Marcos Mojica', '4-774-251'),
(36, 18, 2, 'Marcos Mojica', '4-774-251'),
(37, 19, 2, 'Marcos Mojica', '4-774-251'),
(38, 1, 1, 'Oscar Ruiz', '8-4-7814'),
(39, 2, 2, 'Oscar Ruiz', '8-4-7814'),
(40, 3, 2, 'Oscar Ruiz', '8-4-7814'),
(41, 4, 2, 'Oscar Ruiz', '8-4-7814'),
(42, 5, 1, 'Oscar Ruiz', '8-4-7814'),
(43, 7, 1, 'Oscar Ruiz', '8-4-7814'),
(44, 8, 1, 'Oscar Ruiz', '8-4-7814'),
(45, 10, 1, 'Oscar Ruiz', '8-4-7814'),
(46, 11, 1, 'Oscar Ruiz', '8-4-7814'),
(47, 12, 1, 'Oscar Ruiz', '8-4-7814'),
(48, 15, 1, 'Oscar Ruiz', '8-4-7814'),
(49, 18, 1, 'Oscar Ruiz', '8-4-7814'),
(50, 19, 1, 'Oscar Ruiz', '8-4-7814'),
(51, 20, 1, 'Oscar Ruiz', '8-4-7814');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `det_encuestas`
--
ALTER TABLE `det_encuestas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  ADD PRIMARY KEY (`id_enc`);

--
-- Indices de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `det_encuestas`
--
ALTER TABLE `det_encuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `encuestas`
--
ALTER TABLE `encuestas`
  MODIFY `id_enc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
