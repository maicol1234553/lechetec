-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-06-2026 a las 03:55:24
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `lechetec`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `analisis_fq`
--

CREATE TABLE `analisis_fq` (
  `ID_AFQ` int(11) NOT NULL,
  `ID_MUE` int(11) DEFAULT NULL,
  `ACI_AFQ` float DEFAULT NULL,
  `DEN_AFQ` float DEFAULT NULL,
  `GRA_AFQ` float DEFAULT NULL,
  `PH_AFQ` float DEFAULT NULL,
  `ALC_AFQ` float DEFAULT NULL,
  `PRO_AFQ` float DEFAULT NULL,
  `FOS_AFQ` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `analisis_fq`
--

INSERT INTO `analisis_fq` (`ID_AFQ`, `ID_MUE`, `ACI_AFQ`, `DEN_AFQ`, `GRA_AFQ`, `PH_AFQ`, `ALC_AFQ`, `PRO_AFQ`, `FOS_AFQ`) VALUES
(1, 1, 0, 0, 0, 0, 0, 0, 0),
(2, 2, 0, 0, 0, 0, 0, 0, 0),
(3, 3, 0.01, -0.01, 0.01, 0.02, 0.01, 0.01, 0),
(4, 4, 0.01, -0.01, 0.01, 0.02, 0.01, 0.01, 0),
(5, 5, 0.01, -0.01, 0.01, 0.02, 0.01, 0.01, 0),
(6, 6, 0.01, -0.01, 0.01, 0.02, 0.01, 0.01, 0),
(7, 7, 0.01, -0.01, 0.01, 0.02, 0.01, 0.01, 0),
(8, 8, 1.95, 1.002, 0.06, 0.04, 0.03, 0.05, 0),
(9, 9, 0.01, 1.001, 0.02, 0.01, 0.02, 0.02, 0),
(10, 10, 15, 1.008, 0.02, 0.02, 0.02, 0.03, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `analisis_micro`
--

CREATE TABLE `analisis_micro` (
  `ID_MIC` int(11) NOT NULL,
  `ID_MUE` int(11) DEFAULT NULL,
  `UFC_MIC` int(11) DEFAULT NULL,
  `COL_MIC` int(11) DEFAULT NULL,
  `MES_MIC` int(11) DEFAULT NULL,
  `SAL_MIC` int(11) DEFAULT NULL,
  `OBS_MIC` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `analisis_micro`
--

INSERT INTO `analisis_micro` (`ID_MIC`, `ID_MUE`, `UFC_MIC`, `COL_MIC`, `MES_MIC`, `SAL_MIC`, `OBS_MIC`) VALUES
(1, 1, 0, 0, 0, 0, ''),
(2, 2, 0, 0, 0, 0, ''),
(3, 3, 0, 0, 1, 0, 'sgG'),
(4, 4, 0, 1, 0, 0, 'hola'),
(5, 5, 0, 0, 1, 0, 'gg'),
(6, 6, 0, 0, 0, 1, 'hhhh'),
(7, 7, 0, 0, 0, 0, 'kkk'),
(8, 8, 0, 1, 1, 1, 'buena '),
(9, 9, 0, 1, 1, 1, 'estado buena '),
(10, 10, 0, 1, 1, 1, 'leche en buen estado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `muestra`
--

CREATE TABLE `muestra` (
  `ID_MUE` int(11) NOT NULL,
  `FEC_MUE` date DEFAULT NULL,
  `HOR_MUE` time DEFAULT NULL,
  `ORI_MUE` varchar(100) DEFAULT NULL,
  `RES_MUE` varchar(100) DEFAULT NULL,
  `usuario` varchar(100) DEFAULT NULL,
  `numero_control` varchar(50) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `muestra`
--

INSERT INTO `muestra` (`ID_MUE`, `FEC_MUE`, `HOR_MUE`, `ORI_MUE`, `RES_MUE`, `usuario`, `numero_control`, `id_usuario`) VALUES
(1, '2026-04-19', '15:17:16', '', '', NULL, NULL, NULL),
(2, '2026-04-19', '15:18:20', '', '', NULL, NULL, NULL),
(3, '2026-04-19', '15:37:04', '5', '56', NULL, NULL, NULL),
(4, '2026-05-05', '01:59:29', '5', '56', NULL, NULL, NULL),
(5, '2026-05-05', '02:08:05', '5', '56', NULL, NULL, 1),
(6, '2026-05-05', '02:11:15', '5', '56', NULL, NULL, 2),
(7, '2026-05-14', '19:12:37', '5', '56', NULL, NULL, 1),
(8, '2026-05-22', '13:04:10', 'Instituto Tecnológico de Roque', 'Maicol fernando Roncancio ', NULL, NULL, 1),
(9, '2026-05-22', '14:51:07', 'Instituto Tecnológico de Roque', 'camila', NULL, NULL, 8),
(10, '2026-05-28', '09:24:42', 'Instituto Tecnológico de Roque', 'Maicol fernando Roncancio ', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` enum('admin','usuario') NOT NULL,
  `numero_control` varchar(50) DEFAULT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `correo` varchar(100) NOT NULL,
  `frase_secreta` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `password`, `rol`, `numero_control`, `estado`, `correo`, `frase_secreta`) VALUES
(1, 'maicol', '$2y$10$YV38Bl/GlpzDGfrmJUS6DuiButpyCG3HN9vUsCPNYkNmSvo3/cU..', 'admin', '12345', 'activo', '', 'hola'),
(2, 'maicol1', '$2y$10$S8qfw5JomlmEVGEDPdEX0.h2H.GbvNGC9cOu3Dx16xv79gSFunpdC', 'usuario', '123456', 'activo', '', 'hola'),
(3, 'esteban ', '$2y$10$MPp7rHukzb2He3gQyWm9uO4GWHuRRWyxTMYZvYBhMjA2xwIiXtKH.', 'usuario', '132', 'activo', '', NULL),
(4, 'fer', '$2y$10$TV/FfGQouWVsxGjvz3g/EuRGmvKNUVXr9bDUW85HuuYqmU0vzTBf6', 'usuario', '11', 'activo', '', NULL),
(7, 'anibal ', '$2y$10$bG37RXpkoZgxngpGmNRmOez9MCO6pX0FmVJzQoUkIiheb4URvlgQG', 'usuario', '823918', 'activo', '', NULL),
(8, 'camila', '$2y$10$BI1sXUHb91JE1OY.fBwlx.I1ORw9v7InoR815SVicx22avypFf0/m', 'usuario', '0000', 'activo', '', NULL),
(9, 'padro', '$2y$10$YrfidncWtKtuFfg1uwZe8.g.tKF/5rliTrzFj.en/W4QJMvyYK1nC', 'usuario', '444', 'activo', '', NULL),
(10, 'fernadno', '$2y$10$2A3dMoii9.rdkD49zuUR2.nmvD6OZKEP48Rk7xdwxJjQmCmZKEIu.', 'usuario', '11', 'activo', '', 'hola');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `analisis_fq`
--
ALTER TABLE `analisis_fq`
  ADD PRIMARY KEY (`ID_AFQ`),
  ADD KEY `ID_MUE` (`ID_MUE`);

--
-- Indices de la tabla `analisis_micro`
--
ALTER TABLE `analisis_micro`
  ADD PRIMARY KEY (`ID_MIC`),
  ADD KEY `ID_MUE` (`ID_MUE`);

--
-- Indices de la tabla `muestra`
--
ALTER TABLE `muestra`
  ADD PRIMARY KEY (`ID_MUE`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `analisis_fq`
--
ALTER TABLE `analisis_fq`
  MODIFY `ID_AFQ` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `analisis_micro`
--
ALTER TABLE `analisis_micro`
  MODIFY `ID_MIC` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `muestra`
--
ALTER TABLE `muestra`
  MODIFY `ID_MUE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `analisis_fq`
--
ALTER TABLE `analisis_fq`
  ADD CONSTRAINT `analisis_fq_ibfk_1` FOREIGN KEY (`ID_MUE`) REFERENCES `muestra` (`ID_MUE`);

--
-- Filtros para la tabla `analisis_micro`
--
ALTER TABLE `analisis_micro`
  ADD CONSTRAINT `analisis_micro_ibfk_1` FOREIGN KEY (`ID_MUE`) REFERENCES `muestra` (`ID_MUE`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
