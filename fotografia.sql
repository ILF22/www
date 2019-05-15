-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-05-2019 a las 17:50:55
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 5.6.40

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
(1, 5, 'HOLA', 1),
(6, 5, 'HOLA GUAPO', 1),
(7, 5, 'HOLA GUAPO', 1),
(8, 5, 'HOLA GUAPO', 1),
(9, 5, 'HOLA GUAPO', 1),
(10, 5, 'HOLA GUAPO', 1),
(11, 5, 'HOLA GUAPO', 1);

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
(2, 4, 'calderon.jpg', 'Calderon', 0),
(3, 3, 'barca.jpeg', 'Pantano', 0),
(4, 1, 'perri.jpg.jpg', 'perro', 1),
(5, 1, 'wood-3271749_640.jpg', 'mesa', 1),
(6, 5, 'wood-3271749_640.jpg', 'mesa2', 0);

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
(5, 5),
(5, 4),
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
  `visitas` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usuarioID`, `username`, `password`, `email`, `active`, `resetToken`, `resetComplete`, `visitas`) VALUES
(1, 'Irene', '$2y$10$R6A3yNvjcoAg.kL8vHE7gexs1zkH7WTTZNR8JbfcEhhahZHX6Qn.G', 'irene.leon95@gmail.com', 'Yes', NULL, 'No', 84),
(5, 'Aitor', '$2y$10$a3RJKLkSlH9njYZbpakGw.zFhfj5KRD5sSfwcxhgRF5wKPRf.WeWu', 'aitorsan2092@gmail.com', 'Yes', NULL, 'No', 14),
(14, 'IreneN', '$2y$10$1jojffb8rGJsqbrcqv1WeOsCvQQZZ6N0voB14oNoGcnZHbORPPbhS', 'irene.leonfernandez@colegio-losnaranjos.com', 'Yes', NULL, 'No', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
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
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `idcomentarios` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `imagen`
--
ALTER TABLE `imagen`
  MODIFY `idfoto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuarioID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
