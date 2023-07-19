-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-06-2023 a las 19:42:01
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `miconsigna`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `espacio`
--

CREATE TABLE `espacio` (
  `id` bigint(20) NOT NULL,
  `texto` varchar(700) NOT NULL,
  `estado` tinyint(1) DEFAULT 1,
  `fecha_ad` date NOT NULL,
  `precio_d` double NOT NULL,
  `id_lugar` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `espacio`
--

INSERT INTO `espacio` (`id`, `texto`, `estado`, `fecha_ad`, `precio_d`, `id_lugar`) VALUES
(1, 'Un espacio de 3mx3m, cabe perfectamente 2 o 3 motos', 1, '2023-04-14', 2.5, 1),
(2, 'Una habitación de 6x6 metros. Primera planta', 1, '2023-04-14', 2.2, 2),
(3, 'Un espacio de 2mx2m, para algunas maletas\r\n', 1, '2023-04-10', 3, 1),
(4, 'Una taquilla sin baldas de 1x1x2.', 1, '2023-04-15', 1.5, 3),
(5, 'Es un garaje pequeño, pero caben bastantes cosas bien apiladas', 1, '2023-05-10', 2, 6),
(6, 'Un armario pequeño para maletas de viaje', 1, '2023-05-14', 1, 6),
(7, 'Una cochera enorme. Disponemos de mantas de protección contra el polvo y suciedad.', 1, '2023-05-20', 1.5, 10),
(11, 'Un armario pequeño para maletas de viaje', 1, '2023-05-30', 1, 4),
(12, 'Hueco de 4x4 metros', 1, '2023-06-06', 2, 15),
(13, 'Espacio de 5x5m. Preguntar', 1, '2023-06-07', 1, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informe`
--

CREATE TABLE `informe` (
  `id` bigint(20) NOT NULL,
  `asunto` varchar(200) NOT NULL,
  `contenido` varchar(500) NOT NULL,
  `fecha` date NOT NULL,
  `leido` tinyint(1) NOT NULL,
  `id_emisor` bigint(20) NOT NULL,
  `id_denunciada` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `informe`
--

INSERT INTO `informe` (`id`, `asunto`, `contenido`, `fecha`, `leido`, `id_emisor`, `id_denunciada`) VALUES
(1, 'Ese tipo pinta raro', 'El tipo este ha subido como direccion un callejon sin nada en un poligono industrial', '2023-04-24', 0, 8, 2),
(2, 'Me da miedo la foto', 'Mucho cuidado con este usuario, creo que usa foto falsa. Por favor, mirad si es un bot.', '2023-04-26', 1, 11, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lugar`
--

CREATE TABLE `lugar` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `cp` bigint(20) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `texto` varchar(700) NOT NULL,
  `estado` tinyint(1) DEFAULT 0,
  `fecha_ad` date NOT NULL,
  `id_usuario` bigint(20) UNSIGNED NOT NULL,
  `foto` varchar(200) NOT NULL DEFAULT '../img_lugares/prede_lugar.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `lugar`
--

INSERT INTO `lugar` (`id`, `direccion`, `cp`, `ciudad`, `texto`, `estado`, `fecha_ad`, `id_usuario`, `foto`) VALUES
(1, 'Calle Albondiga 3', 19950, 'Granada', 'Cuento con una cochera de gran tamaño, de 30x20 metros, en la que dejar varias cosas', 1, '2023-05-06', 2, '../img_lugares/1.jpeg'),
(2, 'Calle Pinguino 12 ', 19000, 'Granada', 'Mi trastero puede alojar bicicletas, cajas, muchas cosas', 1, '2023-03-09', 1, '../img_lugares/prede_lugar.png'),
(3, 'Calle Muchoarte 3 ', 41000, 'Sevilla', 'Tenemos un garaje vacío de 3x7 metros', 1, '2023-04-05', 3, '../img_lugares/prede_lugar.png'),
(4, 'Calle el Balcón 11', 29000, 'Málaga', 'Tengo una habitación grande de 5x5m', 1, '2023-05-06', 4, '../img_lugares/prede_lugar.png'),
(5, 'Rúa do Concello 3', 27000, 'Lugo', 'Se trata de un trastero bastante amplio, donde se pueden guardar bicicletas, maletas, cajas de gran tamaño, etc. Contáctame para cualquier duda', 1, '2023-04-24', 12, '../img_lugares/prede_lugar.png'),
(6, 'Calle Arroz 5', 19950, 'Granada', 'Un armario enorme donde meter de todo', 1, '2023-04-30', 2, '../img_lugares/prede_lugar.png'),
(7, 'Calle Oyeunabrazo', 19200, 'Granada', 'Prueba', 0, '2023-05-10', 2, '../img_lugares/prede_lugar.png'),
(10, 'Calle la paloma', 41500, 'Sevilla', 'Prueba', 1, '2023-05-10', 3, '../img_lugares/10.png'),
(11, 'Calle el rechazo', 19200, 'Granada', 'sdfsd', 0, '2023-05-10', 5, '../img_lugares/prede_lugar.png'),
(12, 'Calle el desperfecto', 19200, 'Granada', 'dasfsdfsdfdsdsfsdf ', 0, '2023-04-24', 4, '../img_lugares/prede_lugar.png'),
(13, 'Calle Molino n40', 29780, 'Nerja', 'Es un garaje en el que cabe casi de todo. Puedes dejar tu kayak aquí', 0, '2023-05-20', 6, '../img_lugar/6.png'),
(15, 'Avenida Federico García Lorca', 4100, 'Níjar', 'Tengo un desván bastante grande, donde puedes dejar tu maleta', 1, '2023-06-06', 11, '../img_lugar/11.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje`
--

CREATE TABLE `mensaje` (
  `id` bigint(20) NOT NULL,
  `texto` varchar(700) NOT NULL,
  `asunto` varchar(200) NOT NULL,
  `fecha` date NOT NULL,
  `id_emisor` bigint(20) UNSIGNED NOT NULL,
  `id_receptor` bigint(20) UNSIGNED NOT NULL,
  `leido` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `mensaje`
--

INSERT INTO `mensaje` (`id`, `texto`, `asunto`, `fecha`, `id_emisor`, `id_receptor`, `leido`) VALUES
(1, 'Saludos al administrador', 'Esto es un mensaje de prueba para el administrador', '2023-05-17', 6, 0, 1),
(2, 'Mensaje del admin', 'Portate bien, pepito', '2023-05-17', 0, 6, 1),
(5, 'En breve estaremos por Nerja', 'Contesta pronto por favor', '2023-05-18', 6, 2, 1),
(6, '¿Tienes hueco para una bicicleta?', 'Sobre espacio', '2023-05-18', 6, 1, 0),
(7, 'Hola Antonio, bienvenido a la plataforma.', 'Mensaje de miconsigna', '2023-05-21', 0, 2, 1),
(8, '123', 'Pepito, ya está actualizado tu perfil', '2023-06-04', 0, 6, 1),
(9, 'Perfecto Pepe, aquí te esperamos. Hay tiempo todavía. Si no encuentras el sitio, avísame por aquí', 'RE: Contesta pronto por favor', '2023-06-06', 2, 6, 1),
(10, 'Antonio miarma, que en una semanita estaré de visita para ver la Alhambra. Mira a ver si tienes un hueco para la maleta de mi suegra, que viene con nosotros también.', 'Hola Antonio!', '2023-06-06', 3, 2, 0),
(11, 'El propietario Fernando García Quiroga ha confirmado tu reserva. <br> \n        El lugar espacio elegido se encuentra en Rúa do Concello 3 27000 Lugo. <br> \n        Fecha de inicio: 16-06-2023 <br> Fecha final: 18-06-2023 <br> Cuantía total: 2 €', 'Reserva confirmada', '2023-06-08', 0, 11, 1),
(12, 'El usuario Juan López Domínguez desea hacer una reserva. <br> \r\n        El espacio elegido se encuentra en Calle Albondiga 3 19950 Granada. <br> \r\n        Fecha de inicio: 2023-06-23 <br> Fecha final: 2023-06-25 <br> Cuantía total: 5 €', 'Solicitud de reserva', '2023-06-08', 0, 2, 1),
(13, 'El propietario Antonio González Pérez ha confirmado tu reserva. <br> \r\n        El espacio elegido se encuentra en Calle Albondiga 3 19950 Granada. <br> \r\n        Fecha de inicio: 23-06-2023 <br> Fecha final: 25-06-2023 <br> Cuantía total: 5 €', 'Reserva confirmada', '2023-06-08', 0, 3, 0),
(14, 'Pues eso', 'También viene mi sobrina', '2023-06-08', 3, 2, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pago`
--

CREATE TABLE `pago` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_reserva` bigint(20) UNSIGNED NOT NULL,
  `fecha` date NOT NULL,
  `cuantia` decimal(15,0) UNSIGNED NOT NULL,
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pago`
--

INSERT INTO `pago` (`id`, `id_reserva`, `fecha`, `cuantia`, `estado`) VALUES
(1, 3, '2023-05-16', '5', 1),
(2, 1, '2023-05-18', '3', 1),
(3, 2, '2023-05-18', '3', 1),
(4, 5, '2023-05-19', '2', 1),
(5, 5, '2023-05-23', '3', 1),
(6, 6, '2023-05-25', '3', 1),
(7, 8, '2023-05-30', '1', 1),
(8, 9, '2023-06-06', '2', 1),
(9, 10, '2023-06-06', '2', 1),
(10, 11, '2023-06-07', '2', 1),
(11, 12, '2023-06-08', '2', 1),
(12, 13, '2023-06-08', '2', 1),
(13, 22, '2023-06-08', '5', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reserva`
--

CREATE TABLE `reserva` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_espacio` bigint(20) UNSIGNED NOT NULL,
  `fecha_ini` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `id_usuario` bigint(20) UNSIGNED NOT NULL,
  `estado` int(1) NOT NULL DEFAULT 0,
  `id_pago` bigint(20) UNSIGNED NOT NULL,
  `comentado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `reserva`
--

INSERT INTO `reserva` (`id`, `id_espacio`, `fecha_ini`, `fecha_fin`, `id_usuario`, `estado`, `id_pago`, `comentado`) VALUES
(1, 3, '2023-05-20', '2023-05-21', 4, 1, 1, 1),
(2, 3, '2023-05-22', '2023-05-23', 9, 1, 2, 1),
(3, 1, '2023-05-16', '2023-05-18', 6, 1, 3, 1),
(4, 3, '2023-05-30', '2023-05-31', 6, 1, 4, 1),
(5, 1, '2023-05-23', '2023-05-24', 10, 1, 5, 1),
(6, 1, '2023-06-01', '2023-06-02', 6, 1, 6, 1),
(8, 11, '2023-05-30', '2023-05-30', 3, 1, 7, 1),
(9, 7, '2023-06-06', '2023-06-06', 11, 1, 8, 1),
(10, 12, '2023-06-07', '2023-06-07', 3, 1, 9, 0),
(11, 7, '2023-06-08', '2023-06-08', 12, 1, 10, 0),
(12, 13, '2023-06-09', '2023-06-11', 11, 1, 11, 0),
(13, 13, '2023-06-16', '2023-06-18', 11, 1, 12, 0),
(22, 1, '2023-06-23', '2023-06-25', 3, 1, 13, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` bigint(20) NOT NULL,
  `dni` varchar(20) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `fecha_nac` date NOT NULL,
  `pass` varchar(50) NOT NULL,
  `foto` varchar(200) NOT NULL DEFAULT '../img_usuarios/nophoto.png',
  `estado` tinyint(1) DEFAULT 0,
  `descripcion` varchar(300) DEFAULT NULL,
  `activado` tinyint(1) NOT NULL DEFAULT 0,
  `penalizacion` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `dni`, `nombre`, `apellidos`, `email`, `telefono`, `fecha_nac`, `pass`, `foto`, `estado`, `descripcion`, `activado`, `penalizacion`) VALUES
(0, 'admin', 'admin', 'admin', 'admin', '0', '0000-00-00', 'c3284d0f94606de1fd2af172aba15bf3 ', '', 1, '', 1, 0),
(1, '76234578F', 'José', 'García', 'joselinex@gmail.com', '123123123', '1978-07-06', 'd9b1d7db4cd6e70935368a1efb10e377 ', '../img_usuarios/1.png', 1, 'Si tienes alguna pregunta, no dudes en contactarme.', 1, 0),
(2, '71113323H', 'Antonio', 'González Pérez', 'antonillo@gmail.com', '958888999', '1993-05-12', 'd9b1d7db4cd6e70935368a1efb10e377 ', '../img_usuarios/Antonio.png', 1, 'Tengo unos cuantos espacios para guardar cosillas. Pregúntame lo que necesites.', 1, 2),
(3, '74178989L', 'Juan', 'López Domínguez', 'juanillo@gmail.com', '958646646', '1989-09-23', 'd9b1d7db4cd6e70935368a1efb10e377 ', '../img_usuarios/3.jpg\r\n', 1, 'Trato con muchos turistas y visitantes a Sevilla. Respondo rápido.', 1, 2),
(4, '76676778M', 'Manuel', 'Ordóñez Huertas', 'manolillo@gmail.com', '952456456', '1990-07-13', 'd9b1d7db4cd6e70935368a1efb10e377 ', '../img_usuarios/4.jpg\r\n', 1, '', 1, 0),
(6, '12121212k', 'Pepe', 'Palomares', 'pepito@gmail.com', '123123123', '1999-04-11', 'd9b1d7db4cd6e70935368a1efb10e377 ', '../img_usuarios/Pepe.png', 1, 'Aquí estoy yo. Este es mi perfil personal. Tengo un garaje grande en mi casa, con dos armarios con llave. Pregúntame lo que necesites.', 1, 0),
(7, '12121212g', 'Ramón', 'Ramírez', 'ramoncete@gmail.com', '123123123', '1989-12-12', 'd9b1d7db4cd6e70935368a1efb10e377 ', '../img_usuarios/nophoto.png', 0, '', 1, 1),
(8, '12671267a', 'Daniel', 'Ocaña', 'danielillo@gmail.com', '123123123', '1988-07-11', 'd9b1d7db4cd6e70935368a1efb10e377 ', '../img_usuarios/Daniel.png', 1, '', 1, 1),
(9, '33333333f', 'Juan', 'Juánez', 'juanjua@gmail.com', '123123123', '1999-11-11', 'd9b1d7db4cd6e70935368a1efb10e377 ', '../img_usuarios/nophoto.png', 0, '', 1, 2),
(10, '12909090q', 'Carlos', 'López García', 'carlitos@gmail.com', '123123123', '1998-11-11', 'd9b1d7db4cd6e70935368a1efb10e377 ', '../img_usuarios/nophoto.png', 1, 'Si no os respondo por aquí, contactadme por wassap', 0, 0),
(11, '45671212h', 'Carmen', 'González Ruiz', 'carmencilla@gmail.com', '234234234', '1988-04-21', 'd9b1d7db4cd6e70935368a1efb10e377 ', '../img_usuarios/Carmen.png', 1, 'Hola que tal, soy Carmen. Aquí compartiré mis espacios. Si necesitas algo, pregunta', 1, 0),
(12, '75192323G', 'Fernando', 'García Quiroga', 'fernandete@gmail.com', '678789981', '1972-04-03', 'd9b1d7db4cd6e70935368a1efb10e377 ', '../img_usuarios/Fernando.png', 1, 'Hola, soy un vecino de Lugo con un gran trastero', 1, 1),
(14, '12787812g', 'Luis', 'Perez', 'luisito@gmail.com', '123123123', '2000-11-12', 'd9b1d7db4cd6e70935368a1efb10e377', '../img_usuarios/nophoto.png', 1, '', 1, 0),
(15, '77114455d', 'Darío', 'Globetrotter', 'dario@gmail.com', '999444777', '1989-05-01', 'd9b1d7db4cd6e70935368a1efb10e377', '../img_usuarios/nophoto.png', 1, NULL, 1, 0),
(17, '79919455d', 'Wachornein', 'Mainnameist', 'wachornein@gmail.com', '999999999', '2000-10-10', 'd9b1d7db4cd6e70935368a1efb10e377', '../img_usuarios/nophoto.png', 1, NULL, 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `valoracion`
--

CREATE TABLE `valoracion` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `texto` varchar(300) NOT NULL,
  `fecha` date NOT NULL,
  `puntuacion` int(1) UNSIGNED NOT NULL,
  `id_usuario` bigint(20) UNSIGNED NOT NULL,
  `id_reserva` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `valoracion`
--

INSERT INTO `valoracion` (`id`, `texto`, `fecha`, `puntuacion`, `id_usuario`, `id_reserva`) VALUES
(1, 'Muy rápido todo. El propietario fue muy agradable, y me dió confianza. Genial', '2023-04-21', 5, 4, 1),
(2, 'El propietario tardó en presentarse, y no me dió muy buena impresión. Por si acaso, me llevé la cartera en el bolsillo.', '2023-04-22', 2, 9, 2),
(3, 'Todo bien, aunque tardó en contestar', '2023-04-18', 4, 6, 3),
(4, 'Rápido, pero mi maleta llegó manchada con lo que parece guiso de carne', '2023-04-13', 2, 7, 4),
(5, 'Esto es otro comentario de prueba para ver la paginación', '2023-05-24', 4, 10, 5),
(6, 'No me voy muy contento. La maleta se manchó de comida.', '2023-05-30', 2, 3, 8),
(7, 'Todo perfecto. El propietario me contestó rápido, y por un precio muy bueno hizo un hueco a mi maleta. Me solucionó la tarde!', '2023-06-02', 5, 6, 6),
(8, 'Respuesta rápida y buen servicio. Gracias', '2023-06-06', 5, 11, 9);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `espacio`
--
ALTER TABLE `espacio`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `informe`
--
ALTER TABLE `informe`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `lugar`
--
ALTER TABLE `lugar`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pago`
--
ALTER TABLE `pago`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `valoracion`
--
ALTER TABLE `valoracion`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `espacio`
--
ALTER TABLE `espacio`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `informe`
--
ALTER TABLE `informe`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `lugar`
--
ALTER TABLE `lugar`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `pago`
--
ALTER TABLE `pago`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `reserva`
--
ALTER TABLE `reserva`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `valoracion`
--
ALTER TABLE `valoracion`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
