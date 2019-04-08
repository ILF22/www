-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-04-2019 a las 17:57:26
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
-- Estructura de tabla para la tabla `imagen`
--

CREATE TABLE `imagen` (
  `idfoto` int(11) NOT NULL,
  `usuarioID` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  `descripcion` text COLLATE utf8mb4_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Volcado de datos para la tabla `imagen`
--

INSERT INTO `imagen` (`idfoto`, `usuarioID`, `nombre`, `descripcion`) VALUES
(1, 1, '5.jpeg', 'Londres'),
(2, 4, 'calderon.jpg', 'Calderon'),
(3, 3, 'barca.jpeg', 'Pantano');

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
(1, 'Irene', '$2y$10$R6A3yNvjcoAg.kL8vHE7gexs1zkH7WTTZNR8JbfcEhhahZHX6Qn.G', 'irene.leon95@gmail.com', 'Yes', NULL, 'No', 3),
(2, 'IreneBitcode', '$2y$10$J0yf3ofA1KZsgUDODBToFOE9yADiPA6kGmN94CN/WoMue5jGRnm8e', 'irene.leon@bitcode.com', 'Yes', NULL, 'No', 0),
(3, 'IreneClase', '$2y$10$Q.bRTg6WmQ9aszCHSd1N0ez.tOPT1c5xMxe/j/F88HmapcUaz57p6', 'irene.leonfernandez@colegio-losnaranjos.com', 'Yes', NULL, 'No', 0),
(4, 'JulioBitcode', '$2y$10$6yyPb7FYtZLeqsmFBTP0.O925NjLgm3PpR1tvNBIUsCleS3U2/5Fy', 'julio.mena@bitcode.com', 'Yes', NULL, 'No', 0),
(5, 'Aitor', '$2y$10$a3RJKLkSlH9njYZbpakGw.zFhfj5KRD5sSfwcxhgRF5wKPRf.WeWu', 'aitorsan2092@gmail.com', 'Yes', NULL, 'No', 13);

--
-- Índices para tablas volcadas
--

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
-- AUTO_INCREMENT de la tabla `imagen`
--
ALTER TABLE `imagen`
  MODIFY `idfoto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `usuarioID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
