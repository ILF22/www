-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-06-2019 a las 16:13:57
-- Versión del servidor: 10.1.32-MariaDB
-- Versión de PHP: 7.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `fotografia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `idcomentarios` int(11) NOT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `comentario` varchar(256) DEFAULT NULL,
  `idfoto` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`idcomentarios`, `idUsuario`, `comentario`, `idfoto`) VALUES
(9, 5, 'Adios', 1),
(10, 5, 'Adios', 1),
(11, 5, 'Adios', 1),
(12, 5, 'Adios', 1),
(13, 5, 'Adios', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentariosv`
--

CREATE TABLE `comentariosv` (
  `idcomentarios` int(11) NOT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `comentario` varchar(256) DEFAULT NULL,
  `idvideo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen`
--

CREATE TABLE `imagen` (
  `idfoto` int(11) NOT NULL,
  `usuarioID` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `descripcion` text COLLATE utf8mb4_bin NOT NULL,
  `likes` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `imagen`
--

INSERT INTO `imagen` (`idfoto`, `usuarioID`, `nombre`, `descripcion`, `likes`) VALUES
(1, 1, '5.jpeg', 'Londres', 1),
(4, 1, 'perri.jpg.jpg', 'perro', 1),
(5, 1, 'wood-3271749_640.jpg', 'mesa', 1),
(6, 5, 'wood-3271749_640.jpg', 'mesa2', 2),
(8, 1, 'bbb.jpg', 'irene', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likes`
--

CREATE TABLE `likes` (
  `idlikes_usuarios` int(11) NOT NULL,
  `idlikes_imagenes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `likes`
--

INSERT INTO `likes` (`idlikes_usuarios`, `idlikes_imagenes`) VALUES
(5, 4),
(5, 5),
(5, 1),
(5, 8),
(1, 6),
(19, 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `likesv`
--

CREATE TABLE `likesv` (
  `idlikes_usuarios` int(11) NOT NULL,
  `idlikes_video` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `likesv`
--

INSERT INTO `likesv` (`idlikes_usuarios`, `idlikes_video`) VALUES
(5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usuarioID` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `active` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `resetToken` varchar(255) COLLATE utf8mb4_bin DEFAULT NULL,
  `resetComplete` varchar(3) COLLATE utf8mb4_bin DEFAULT 'No',
  `visitas` int(11) DEFAULT '0',
  `descripcion` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `imagen` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `ultVisitas` longtext CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuarioID`, `username`, `password`, `email`, `active`, `resetToken`, `resetComplete`, `visitas`, `descripcion`, `imagen`, `ultVisitas`) VALUES
(1, 'Irene', '$2y$10$R6A3yNvjcoAg.kL8vHE7gexs1zkH7WTTZNR8JbfcEhhahZHX6Qn.G', 'irene.leon95@gmail.com', 'Yes', '0592385958c3e38b3d5fec6ba3a68954c952864ce99069e7776be28cd844ce45', 'No', 126, 'Hola me llamo Irene', '082213cb0f9eabb7e6715f59ef7d322a-icono-de-perfil-de-instagram-by-vexels.png', 'a:2:{i:0;s:1:\"5\";i:2;s:1:\"1\";}'),
(5, 'Aitor', '$2y$10$a3RJKLkSlH9njYZbpakGw.zFhfj5KRD5sSfwcxhgRF5wKPRf.WeWu', 'aitorsan2092@gmail.com', 'Yes', NULL, 'No', 85, 'Hola me llamo Aitor', 'usuario.jpg', 'a:2:{i:0;s:1:\"1\";i:2;s:1:\"5\";}'),
(14, 'IreneN', '$2y$10$1jojffb8rGJsqbrcqv1WeOsCvQQZZ6N0voB14oNoGcnZHbORPPbhS', 'irene.leonfernandez@colegio-losnaranjos.com', 'Yes', NULL, 'No', NULL, '', '', ''),
(19, 'Prueba123', '$2y$10$VstFf6HFZHC2edIvQ7V3tub4vmyGl7vi.vtxxj/1utWEzlw6QjMja', '2_web9_18@iesjovellanos.org', 'Yes', NULL, 'No', NULL, '', '', 'a:2:{i:0;s:1:\"5\";i:1;s:1:\"1\";}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `video`
--

CREATE TABLE `video` (
  `idvideo` int(11) NOT NULL,
  `usuarioID` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_bin NOT NULL,
  `descripcion` text COLLATE utf8_bin NOT NULL,
  `likes` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`idcomentarios`);

--
-- Indices de la tabla `comentariosv`
--
ALTER TABLE `comentariosv`
  ADD PRIMARY KEY (`idcomentarios`);

--
-- Indices de la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD PRIMARY KEY (`idfoto`),
  ADD KEY `usuarioID` (`usuarioID`) USING BTREE;

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`usuarioID`);

--
-- Indices de la tabla `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`idvideo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `idcomentarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `comentariosv`
--
ALTER TABLE `comentariosv`
  MODIFY `idcomentarios` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imagen`
--
ALTER TABLE `imagen`
  MODIFY `idfoto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuarioID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `video`
--
ALTER TABLE `video`
  MODIFY `idvideo` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
