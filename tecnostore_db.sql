-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-11-2026 a las 04:07:05
-- Versión del servidor: 10.11.16-MariaDB
-- Versión de PHP: 8.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tecnostore_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `categoria` varchar(60) NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `estado` enum('Disponible','Agotado') NOT NULL DEFAULT 'Disponible',
  `fecha_creacion` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `categoria`, `precio`, `imagen`, `estado`, `fecha_creacion`) VALUES
(1, 'Audífonos Bluetooth', 'Audífonos inalámbricos con estuche de carga.', 'Audio', 85000.00, NULL, 'Disponible', '2026-11-22 15:14:04'),
(2, 'Teclado inalámbrico', 'Teclado compacto para estudiar y trabajar.', 'Accesorios', 120000.00, NULL, 'Disponible', '2026-11-22 15:14:04'),
(3, 'Mouse ergonómico', 'Mouse cómodo y preciso para uso diario.', 'Accesorios', 65000.00, NULL, 'Disponible', '2026-11-22 15:14:04'),
(5, 'PARLANTE INALAMBRICO', '5 GG', 'Audio', 950000.00, NULL, 'Disponible', '2026-11-23 00:27:04'),
(6, 'COMPUTADOR PORTATIL', '16 GM RAM\r\nINTEL CORE 3\r\n1 T', 'Computadores', 3000000.00, NULL, 'Disponible', '2026-11-23 00:36:16');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
