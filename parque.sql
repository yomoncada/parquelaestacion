-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 27, 2017 at 07:42 PM
-- Server version: 5.7.10-log
-- PHP Version: 5.6.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parque`
--

-- --------------------------------------------------------

--
-- Table structure for table `actividades`
--

CREATE TABLE `actividades` (
  `id_act` int(4) NOT NULL,
  `accion` varchar(300) COLLATE utf8_spanish2_ci NOT NULL,
  `tipo` enum('Censo','Mantenimiento','Reforestación','') COLLATE utf8_spanish2_ci NOT NULL,
  `estado` enum('Activa','Inactiva') COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Dumping data for table `actividades`
--

INSERT INTO `actividades` (`id_act`, `accion`, `tipo`, `estado`) VALUES
(1, 'Limpiar bancos del pasillo principal', 'Mantenimiento', 'Activa'),
(2, 'Colocar bombillos en los postes del pasillo principal', 'Mantenimiento', 'Activa'),
(3, 'Visitar el habitat natural de la especie', 'Censo', 'Activa'),
(4, 'Explorar el perimetro donde se ubica el habitat de la especie', 'Censo', 'Activa'),
(5, 'Echar agua', 'Reforestación', 'Activa');

-- --------------------------------------------------------

--
-- Table structure for table `actividades_censo`
--

CREATE TABLE `actividades_censo` (
  `censo` int(4) NOT NULL,
  `actividad` int(4) NOT NULL,
  `encargado` varchar(80) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `actividades_mantenimiento`
--

CREATE TABLE `actividades_mantenimiento` (
  `mantenimiento` int(4) NOT NULL,
  `actividad` int(4) NOT NULL,
  `encargado` varchar(80) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `actividades_reforestacion`
--

CREATE TABLE `actividades_reforestacion` (
  `reforestacion` int(4) NOT NULL,
  `actividad` int(4) NOT NULL,
  `encargado` varchar(80) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id_are` int(4) NOT NULL,
  `codigo` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `area` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `ubicacion` varchar(320) COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Activa','Inactiva') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id_are`, `codigo`, `area`, `ubicacion`, `estado`) VALUES
(1, 'P3ST', 'Perimetro Este', 'A 50 km al este de la Entrada Principal.', 'Activa'),
(2, 'P0ST', 'Perimetro Oeste', 'A 10 km al oeste de la Entrada Principal.', 'Activa'),
(3, 'P3SV', 'Perimetro Sur', 'A 25 km al sur de la Entrada Principal.', 'Activa'),
(4, 'P3N0', 'Perimetro Norte', 'A 30 km al norte de la Entrada Principal.\r\n', 'Activa');

-- --------------------------------------------------------

--
-- Table structure for table `areas_censo`
--

CREATE TABLE `areas_censo` (
  `censo` int(4) NOT NULL,
  `id_are` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `areas_mantenimiento`
--

CREATE TABLE `areas_mantenimiento` (
  `mantenimiento` int(4) NOT NULL,
  `id_are` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `areas_reforestacion`
--

CREATE TABLE `areas_reforestacion` (
  `reforestacion` int(4) NOT NULL,
  `id_are` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `beneficiarios`
--

CREATE TABLE `beneficiarios` (
  `id_ben` int(4) NOT NULL,
  `cedula` varchar(10) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `telefono` varchar(30) NOT NULL,
  `direccion` varchar(80) NOT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `beneficiarios`
--

INSERT INTO `beneficiarios` (`id_ben`, `cedula`, `nombre`, `telefono`, `direccion`, `estado`) VALUES
(1, 'V-27402258', 'Yonathan Moncada', '(0424) 359-1604', 'La Victoria, Estado Aragua', 'Activo'),
(2, 'V-27402257', 'Petronila Sinforosa', '(0424) 344-1233', 'La Victoria, Estado Aragua', 'Activo'),
(3, 'V-8589947', 'Esmeralda Navarro', '(0412) 463-3621', 'La Victoria, Estado Aragua', 'Activo'),
(4, 'V-8071662', 'Luciano Moncada', '(0416) 239-0187', 'La Victoria, Estado Aragua', 'Activo');

-- --------------------------------------------------------

--
-- Table structure for table `beneficiarios_servicio`
--

CREATE TABLE `beneficiarios_servicio` (
  `servicio` int(4) NOT NULL,
  `beneficiario` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bitacoras`
--

CREATE TABLE `bitacoras` (
  `id_bit` int(4) NOT NULL,
  `tipo` varchar(30) NOT NULL,
  `movimiento` varchar(300) NOT NULL,
  `usuario` int(4) NOT NULL,
  `tiempo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `bitacoras`
--

INSERT INTO `bitacoras` (`id_bit`, `tipo`, `movimiento`, `usuario`, `tiempo`) VALUES
(1, 'Nivel', 'Se ha actualizado el nivel .', 1, '2017-12-18 16:37:17'),
(2, 'Nivel', 'Se ha actualizado el nivel .', 1, '2017-12-18 16:38:48'),
(3, 'Nivel', 'Se ha actualizado el nivel .', 1, '2017-12-18 16:38:50'),
(4, 'Nivel', 'Se ha actualizado el nivel .', 1, '2017-12-18 16:38:59'),
(5, 'Usuario', 'Ha ingresado al sistema.', 1, '2017-12-18 16:39:07'),
(6, 'Nivel', 'Se ha actualizado el nivel .', 1, '2017-12-18 16:39:18'),
(7, 'Usuario', 'Ha ingresado al sistema.', 1, '2017-12-18 16:40:09'),
(8, 'Nivel', 'Se ha actualizado el nivel .', 1, '2017-12-18 16:40:16'),
(9, 'Usuario', 'Ha ingresado al sistema.', 1, '2017-12-18 16:40:25'),
(10, 'Usuario', 'Ha ingresado al sistema.', 1, '2017-12-18 16:48:12'),
(11, 'Usuario', 'Ha ingresado al sistema.', 1, '2017-12-18 22:06:38'),
(12, 'Area', 'Se ha desactivado el area Perimetro Norte.', 1, '2017-12-18 22:38:51'),
(13, 'Area', 'Se ha activado el area Perimetro Norte.', 1, '2017-12-18 22:38:54'),
(14, 'Area', 'Se ha desactivado el area Perimetro Este.', 1, '2017-12-18 23:13:17'),
(15, 'Area', 'Se ha activado el area Perimetro Este.', 1, '2017-12-18 23:13:20'),
(16, 'Area', 'Se ha desactivado el area Perimetro Sur.', 1, '2017-12-18 23:24:56'),
(17, 'Area', 'Se ha activado el area Perimetro Sur.', 1, '2017-12-18 23:24:59'),
(18, 'Area', 'Se ha desactivado el area Perimetro Norte.', 1, '2017-12-19 00:14:25'),
(19, 'Area', 'Se ha activado el area Perimetro Norte.', 1, '2017-12-19 00:15:29'),
(20, 'Area', 'Se ha desactivado el area Perimetro Norte.', 1, '2017-12-19 00:15:32'),
(21, 'Area', 'Se ha activado el area Perimetro Norte.', 1, '2017-12-19 00:21:09'),
(22, 'Area', 'Se ha desactivado el area Perimetro Norte.', 1, '2017-12-19 00:46:19'),
(23, 'Area', 'Se ha activado el area Perimetro Norte.', 1, '2017-12-19 00:46:22'),
(24, 'Beneficiario', 'Se ha desactivate al beneficiario Yonathan Moncada.', 1, '2017-12-19 00:47:21'),
(25, 'Beneficiario', 'Se ha activado al beneficiario Yonathan Moncada.', 1, '2017-12-19 00:47:24'),
(26, 'Beneficiario', 'Se ha desactivate al beneficiario Yonathan Moncada.', 1, '2017-12-19 00:50:37'),
(27, 'Beneficiario', 'Se ha activado al beneficiario Yonathan Moncada.', 1, '2017-12-19 00:50:40'),
(28, 'Area', 'Se ha desactivado el area Perimetro Este.', 1, '2017-12-19 00:50:58'),
(29, 'Area', 'Se ha activado el area Perimetro Este.', 1, '2017-12-19 00:51:02'),
(30, 'Cabaña', 'Se ha desactivado la cabaña número 1.', 1, '2017-12-19 01:11:34'),
(31, 'Cabaña', 'Se ha desactivado la cabaña número 1.', 1, '2017-12-19 01:11:36'),
(32, 'Cabaña', 'Se ha desactivado la cabaña número 1.', 1, '2017-12-19 01:11:39'),
(33, 'Cabaña', 'Se ha desactivado la cabaña número 1.', 1, '2017-12-19 01:12:08'),
(34, 'Cabaña', 'Se ha activado la cabaña número 1.', 1, '2017-12-19 01:12:29'),
(35, 'Cancha', 'Se ha desactivado la cancha número 1.', 1, '2017-12-19 01:12:35'),
(36, 'Cancha', 'Se ha activado la cancha número 2.', 1, '2017-12-19 01:12:38'),
(37, 'Cancha', 'Se ha activado la cancha número 2.', 1, '2017-12-19 01:12:40'),
(38, 'Cancha', 'Se ha activado la cancha número 1.', 1, '2017-12-19 01:12:54'),
(39, 'Edificio', 'Se ha desactivado al edificio Cazona.', 1, '2017-12-19 01:23:54'),
(40, 'Edificio', 'Se ha desactivado al edificio Cazona.', 1, '2017-12-19 01:23:58'),
(41, 'Edificio', 'Se ha desactivado al edificio Recibo.', 1, '2017-12-19 01:24:47'),
(42, 'Edificio', 'Se ha activado al edificio Cazona.', 1, '2017-12-19 01:24:50'),
(43, 'Edificio', 'Se ha activado al edificio Recibo.', 1, '2017-12-19 01:24:51'),
(44, 'Cargo', 'Se ha desactivado el cargo Recepcionista.', 1, '2017-12-19 01:32:07'),
(45, 'Cargo', 'Se ha activado el cargo Recepcionista.', 1, '2017-12-19 01:32:38'),
(46, 'Categoría', 'Se ha activado la categoría Mantenimiento2323.', 1, '2017-12-19 01:40:30'),
(47, 'Categoría', 'Se ha desactivado la categoría Mantenimiento2323.', 1, '2017-12-19 01:41:04'),
(48, 'Censo', 'Se ha actualizado el estado del censo 2.', 1, '2017-12-19 01:49:46'),
(49, 'Donante', 'Se ha desactivado al donante La Mansión de Michelle C.A.', 1, '2017-12-19 02:04:47'),
(50, 'Donante', 'Se ha activado al donante asdasd.', 1, '2017-12-19 02:04:51'),
(51, 'Donante', 'Se ha activado al donante La Mansión de Michelle C.A.', 1, '2017-12-19 02:04:52'),
(52, 'Donante', 'Se ha activado al donante Connecting People C.A.', 1, '2017-12-19 02:04:54'),
(53, 'Donante', 'Se ha desactivado al donante asdasd.', 1, '2017-12-19 02:05:11'),
(54, 'Donante', 'Se ha activado al donante asdasd.', 1, '2017-12-19 02:05:21'),
(55, 'Donante', 'Se ha desactivado al donante asdasd.', 1, '2017-12-19 02:05:27'),
(56, 'Empleado', 'Se ha desactivado el empleado Dubrazka Landaeta.', 1, '2017-12-19 02:12:00'),
(57, 'Empleado', 'Se ha activado el empleado Dubrazka Landaeta.', 1, '2017-12-19 02:12:02'),
(58, 'Usuario', 'Ha ingresado al sistema.', 1, '2017-12-19 12:12:12'),
(59, 'Especie', 'Se ha desactivado el especie Uvero.', 1, '2017-12-19 12:15:04'),
(60, 'Especie', 'Se ha activado el especie Uvero.', 1, '2017-12-19 12:15:08'),
(61, 'Especie', 'Se ha desactivado el especie Uvero.', 1, '2017-12-19 12:15:11'),
(62, 'Especie', 'Se ha activado el especie Uvero.', 1, '2017-12-19 12:15:14'),
(63, 'Especie', 'Se ha desactivado el especie Uvero.', 1, '2017-12-19 12:17:18'),
(64, 'Especie', 'Se ha activado el especie Uvero.', 1, '2017-12-19 12:17:24'),
(65, 'Implemento', 'Se ha desactivado el implemento Botas.', 1, '2017-12-19 12:32:28'),
(66, 'Implemento', 'Se ha desactivado el implemento Botas.', 1, '2017-12-19 12:32:44'),
(67, 'Implemento', 'Se ha desactivado el implemento Botas.', 1, '2017-12-19 12:33:04'),
(68, 'Implemento', 'Se ha desactivado el implemento Botas.', 1, '2017-12-19 12:33:19'),
(69, 'Implemento', 'Se ha activado el implemento Botas.', 1, '2017-12-19 12:33:27'),
(70, 'Implemento', 'Se ha desactivado el implemento Pala.', 1, '2017-12-19 12:33:30'),
(71, 'Implemento', 'Se ha activado el implemento Pala.', 1, '2017-12-19 12:33:32'),
(72, 'Nivel', 'Se ha desactivado el nivel Moderador.', 1, '2017-12-19 12:46:06'),
(73, 'Nivel', 'Se ha activado el nivel Moderador.', 1, '2017-12-19 12:46:09'),
(74, 'Nivel', 'Se ha desactivado el nivel Administrador.', 1, '2017-12-19 12:46:48'),
(75, 'Nivel', 'Se ha activado el nivel Administrador.', 1, '2017-12-19 12:46:50'),
(76, 'Usuario', 'Se ha desactivado la usuario <a href="http://localhost/parque/index.php/perfil/view/dubrazki">dubrazki</a>', 1, '2017-12-19 13:09:48'),
(77, 'Usuario', 'Se ha desactivado la usuario <a href="http://localhost/parque/index.php/perfil/view/alejandrop">alejandrop</a>', 1, '2017-12-19 13:10:12'),
(78, 'Usuario', 'Se ha activado la usuario <a href="http://localhost/parque/index.php/perfil/view/alejandrop">alejandrop</a>', 1, '2017-12-19 13:10:14'),
(79, 'Usuario', 'Se ha activado la usuario <a href="http://localhost/parque/index.php/perfil/view/dubrazki">dubrazki</a>', 1, '2017-12-19 13:10:16'),
(80, 'Usuario', 'Se ha desactivado la usuario <a href="http://localhost/parque/index.php/perfil/view/alejandrop">alejandrop</a>', 1, '2017-12-19 13:10:23'),
(81, 'Usuario', 'Se ha desactivado la usuario <a href="http://localhost/parque/index.php/perfil/view/dubrazki">dubrazki</a>', 1, '2017-12-19 13:10:25'),
(82, 'Empleado', 'Se ha desactivado el empleado Yonathan Moncada.', 1, '2017-12-19 13:18:56'),
(83, 'Empleado', 'Se ha activado el empleado Yonathan Moncada.', 1, '2017-12-19 13:18:59'),
(84, 'Area', 'Se ha desactivado el area Perimetro Norte.', 1, '2017-12-19 13:19:53'),
(85, 'Usuario', 'Ha ingresado al sistema.', 1, '2017-12-19 13:23:02'),
(86, 'Especie', 'Se ha desactivado el especie Uvero.', 1, '2017-12-19 13:26:26'),
(87, 'Especie', 'Se ha activado el especie Uvero.', 1, '2017-12-19 13:26:28'),
(88, 'Actividad', 'Se ha desactivado la actividad Explorar el perimetro donde se ubica el habitat de la especie.', 1, '2017-12-19 13:34:17'),
(89, 'Actividad', 'Se ha activado la actividad Explorar el perimetro donde se ubica el habitat de la especie.', 1, '2017-12-19 13:34:20'),
(90, 'Empleado', 'Se ha desactivado el empleado Yonathan Moncada.', 1, '2017-12-19 13:35:05'),
(91, 'Empleado', 'Se ha activado el empleado Yonathan Moncada.', 1, '2017-12-19 13:35:07'),
(92, 'Usuario', 'Ha ingresado al sistema.', 1, '2017-12-19 13:46:53'),
(93, 'Empleado', 'Se ha desactivado el empleado Yonathan Moncada.', 1, '2017-12-19 13:51:02'),
(94, 'Empleado', 'Se ha activado el empleado Yonathan Moncada.', 1, '2017-12-19 13:51:05'),
(95, 'Area', 'Se ha activado el area Perimetro Norte.', 1, '2017-12-19 13:51:16'),
(96, 'Especie', 'Se ha desactivado el especie Uvero.', 1, '2017-12-19 13:51:22'),
(97, 'Especie', 'Se ha activado el especie Uvero.', 1, '2017-12-19 13:52:02'),
(98, 'Implemento', 'Se ha desactivado el implemento Pala.', 1, '2017-12-19 13:52:08'),
(99, 'Implemento', 'Se ha activado el implemento Pala.', 1, '2017-12-19 13:52:13'),
(100, 'mantenimiento', 'Se ha registrado un mantenimiento.', 1, '2017-12-19 14:05:44'),
(101, 'Nivel', 'Se ha desactivado el nivel Administrador.', 1, '2017-12-19 15:44:31'),
(102, 'Nivel', 'Se ha activado el nivel Administrador.', 1, '2017-12-19 15:44:34'),
(103, 'Usuario', 'Ha ingresado al sistema.', 1, '2017-12-20 00:43:32'),
(104, 'Usuario', 'Ha salido del sistema.', 1, '2017-12-20 00:45:10'),
(105, 'Usuario', 'Ha ingresado al sistema.', 1, '2017-12-20 15:24:15'),
(106, 'Censo', 'Se ha registrado un censo.', 1, '2017-12-20 15:26:25'),
(107, 'Censo', 'Se ha actualizado el estado del censo 1.', 1, '2017-12-20 15:26:35'),
(108, 'Usuario', 'Ha ingresado al sistema.', 1, '2017-12-20 21:55:30'),
(109, 'Usuario', 'Ha ingresado al sistema.', 1, '2017-12-21 12:14:50'),
(110, 'Usuario', 'Ha ingresado al sistema.', 1, '2017-12-21 14:59:08'),
(111, 'Usuario', 'Ha ingresado al sistema.', 1, '2017-12-21 15:27:22'),
(112, 'Censo', 'Se ha finalizado el censo número 1.', 1, '2017-12-21 16:39:41'),
(113, 'Usuario', 'Ha ingresado al sistema.', 1, '2017-12-21 19:32:56'),
(114, 'Censo', 'Se ha registrado el censo número 2.', 1, '2017-12-21 19:33:48'),
(115, 'Censo', 'Se ha actualizado el estado del censo número 2.', 1, '2017-12-21 19:34:14'),
(116, 'Censo', 'Se ha finalizado el censo número 2.', 1, '2017-12-21 21:15:41'),
(117, 'Usuario', 'Ha ingresado al sistema.', 1, '2017-12-21 22:26:13'),
(118, 'Censo', 'Se ha registrado el censo número 3.', 1, '2017-12-21 22:48:14'),
(119, 'Censo', 'Se ha actualizado el estado del censo número 3.', 1, '2017-12-21 22:48:50'),
(120, 'Usuario', 'Ha ingresado al sistema.', 1, '2017-12-22 13:04:48'),
(121, 'Especie', 'Se ha desactivado el especie Uvero.', 1, '2017-12-22 13:39:37'),
(122, 'Especie', 'Se ha activado el especie Uvero.', 1, '2017-12-22 13:39:40'),
(123, 'Especie', 'Se ha desactivado el especie Uvero.', 1, '2017-12-22 13:39:44'),
(124, 'Especie', 'Se ha activado el especie Uvero.', 1, '2017-12-22 13:39:47'),
(125, 'Censo', 'Se ha registrado el censo número 4.', 1, '2017-12-22 13:41:12'),
(126, 'Censo', 'Se ha actualizado el estado del censo número 4.', 1, '2017-12-22 13:41:31'),
(127, 'Censo', 'Se ha finalizado el censo número 4.', 1, '2017-12-22 13:48:40'),
(128, 'Nivel', 'Se ha desactivado el nivel Invitado.', 1, '2017-12-22 13:51:17'),
(129, 'Nivel', 'Se ha activado el nivel Invitado.', 1, '2017-12-22 13:51:19'),
(130, 'Usuario', 'Ha ingresado al sistema.', 1, '2017-12-22 21:01:10'),
(131, 'Censo', 'Se ha registrado el censo número 5.', 1, '2017-12-22 21:01:48'),
(132, 'Censo', 'Se ha actualizado el estado del censo número 5.', 1, '2017-12-22 21:02:16'),
(133, 'Implemento', 'Se ha actualizado el implemento Pala.', 1, '2017-12-22 21:04:15'),
(134, 'Censo', 'Se ha registrado el censo número 6.', 1, '2017-12-22 21:05:55'),
(135, 'Usuario', 'Ha ingresado al sistema.', 1, '2017-12-25 22:15:54'),
(136, 'Usuario', 'Ha ingresado al sistema.', 1, '2017-12-27 17:16:50'),
(137, 'mantenimiento', 'Se ha registrado un mantenimiento.', 1, '2017-12-27 17:29:28'),
(138, 'mantenimiento', 'Se ha actualizado el estado del mantenimiento 1.', 1, '2017-12-27 17:30:53'),
(139, 'mantenimiento', 'Se ha registrado un mantenimiento.', 1, '2017-12-27 17:50:50'),
(140, 'mantenimiento', 'Se ha actualizado el estado del mantenimiento 1.', 1, '2017-12-27 17:50:56'),
(141, 'mantenimiento', 'Se ha finalizado el mantenimiento número 1.', 1, '2017-12-27 17:52:17'),
(142, 'mantenimiento', 'Se ha finalizado el mantenimiento número 1.', 1, '2017-12-27 17:53:30'),
(143, 'mantenimiento', 'Se ha finalizado el mantenimiento número 1.', 1, '2017-12-27 17:54:12'),
(144, 'mantenimiento', 'Se ha finalizado el mantenimiento número 1.', 1, '2017-12-27 17:56:07'),
(145, 'mantenimiento', 'Se ha finalizado el mantenimiento número 1.', 1, '2017-12-27 18:02:52'),
(146, 'mantenimiento', 'Se ha finalizado el mantenimiento número 1.', 1, '2017-12-27 18:04:31'),
(147, 'mantenimiento', 'Se ha finalizado el mantenimiento número 1.', 1, '2017-12-27 18:05:55'),
(148, 'Usuario', 'Ha salido del sistema.', 1, '2017-12-27 18:06:43'),
(149, 'Usuario', 'Ha ingresado al sistema.', 1, '2017-12-27 18:07:04'),
(150, 'mantenimiento', 'Se ha registrado un mantenimiento.', 1, '2017-12-27 18:07:56'),
(151, 'mantenimiento', 'Se ha actualizado el estado del mantenimiento 2.', 1, '2017-12-27 18:08:06'),
(152, 'mantenimiento', 'Se ha finalizado el mantenimiento número 2.', 1, '2017-12-27 18:08:54'),
(153, 'Actividad', 'Se ha registrado la actividad Echar agua.', 1, '2017-12-27 18:22:38'),
(154, 'Usuario', 'Ha ingresado al sistema.', 1, '2017-12-27 18:25:13'),
(155, 'reforestacion', 'Se ha registrado el reforestacion número 1.', 1, '2017-12-27 18:25:43'),
(156, 'reforestacion', 'Se ha actualizado el estado del reforestacion número 1.', 1, '2017-12-27 18:25:55'),
(157, 'reforestacion', 'Se ha registrado el reforestacion número 1.', 1, '2017-12-27 18:31:32'),
(158, 'reforestacion', 'Se ha actualizado el estado del reforestacion número 1.', 1, '2017-12-27 18:33:23'),
(159, 'reforestacion', 'Se ha finalizado el reforestacion número 1.', 1, '2017-12-27 18:35:45'),
(160, 'Usuario', 'Ha ingresado al sistema.', 1, '2017-12-27 18:37:06'),
(161, 'servicio', 'Se ha registrado un servicio.', 1, '2017-12-27 18:45:42'),
(162, 'servicio', 'Se ha actualizado el estado del servicio 1.', 1, '2017-12-27 18:45:48'),
(163, 'Usuario', 'Ha ingresado al sistema.', 1, '2017-12-27 19:15:44'),
(164, 'Usuario', 'Ha ingresado al sistema.', 1, '2017-12-27 19:18:40'),
(165, 'servicio', 'Se ha actualizado el estado del servicio 1.', 1, '2017-12-27 19:19:59'),
(166, 'servicio', 'Se ha actualizado el estado del servicio 1.', 1, '2017-12-27 19:27:28'),
(167, 'servicio', 'Se ha registrado un servicio.', 1, '2017-12-27 19:29:11'),
(168, 'servicio', 'Se ha actualizado el estado del servicio 1.', 1, '2017-12-27 19:38:56'),
(169, 'Usuario', 'Ha salido del sistema.', 1, '2017-12-27 19:42:43');

-- --------------------------------------------------------

--
-- Table structure for table `cabanas`
--

CREATE TABLE `cabanas` (
  `id_cab` int(4) NOT NULL,
  `numero` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `area` int(4) NOT NULL,
  `capacidad` int(4) NOT NULL,
  `disponibilidad` enum('Desocupada','Ocupada') COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Activa','Inactiva') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `cabanas`
--

INSERT INTO `cabanas` (`id_cab`, `numero`, `area`, `capacidad`, `disponibilidad`, `estado`) VALUES
(1, '1', 1, 50, 'Ocupada', 'Activa'),
(2, '2', 2, 20, 'Ocupada', 'Activa'),
(3, '3', 1, 20, 'Desocupada', 'Activa'),
(4, '4', 1, 25, 'Desocupada', 'Activa'),
(5, '5', 2, 20, 'Desocupada', 'Activa'),
(6, '6', 3, 25, 'Desocupada', 'Activa'),
(7, '7', 3, 50, 'Desocupada', 'Activa'),
(8, '9', 4, 25, 'Desocupada', 'Activa'),
(9, '10', 1, 25, 'Desocupada', 'Activa'),
(10, '8', 1, 50, 'Desocupada', 'Activa');

-- --------------------------------------------------------

--
-- Table structure for table `cabanas_servicio`
--

CREATE TABLE `cabanas_servicio` (
  `servicio` int(4) NOT NULL,
  `cabana` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `canchas`
--

CREATE TABLE `canchas` (
  `id_can` int(4) NOT NULL,
  `numero` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `area` int(4) NOT NULL,
  `capacidad` int(4) NOT NULL,
  `disponibilidad` enum('Desocupada','Ocupada') COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Activa','Inactiva') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `canchas`
--

INSERT INTO `canchas` (`id_can`, `numero`, `nombre`, `area`, `capacidad`, `disponibilidad`, `estado`) VALUES
(1, '1', 'Cancha de Fútbol', 1, 25, 'Ocupada', 'Activa'),
(2, '2', 'Cancha de Volleyball', 2, 25, 'Ocupada', 'Activa'),
(3, '3', 'Cancha de Tennis', 2, 25, 'Ocupada', 'Activa'),
(4, '4', 'Cancha de Basketball', 1, 20, 'Desocupada', 'Activa');

-- --------------------------------------------------------

--
-- Table structure for table `canchas_servicio`
--

CREATE TABLE `canchas_servicio` (
  `servicio` int(4) NOT NULL,
  `cancha` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cargos`
--

CREATE TABLE `cargos` (
  `id_car` int(4) NOT NULL,
  `cargo` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `cargos`
--

INSERT INTO `cargos` (`id_car`, `cargo`, `descripcion`, `estado`) VALUES
(4, 'Supervisor', 'Persona que supervisa', 'Activo'),
(5, 'Inspector', 'Persona que inspecciona', 'Activo'),
(6, 'Seguridad', 'Persona que asegura', 'Activo'),
(7, 'Recepcionista', 'Persona que recibe las personas', 'Activo'),
(8, 'Obrero', 'Persona que hace labores de construcción', 'Activo'),
(9, 'Mantenimiento', 'Persona que se encarga del aseo', 'Activo');

-- --------------------------------------------------------

--
-- Table structure for table `categorias`
--

CREATE TABLE `categorias` (
  `id_cat` int(4) NOT NULL,
  `categoria` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `descripcion` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Activa','Inactiva') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `categorias`
--

INSERT INTO `categorias` (`id_cat`, `categoria`, `descripcion`, `estado`) VALUES
(1, 'Mantenimiento', 'Implementos para garantizar la seguridad del personal obrero', 'Activa'),
(2, 'Decoración', 'Implementos de decoración para fiestas, actividades y eventos', 'Activa'),
(3, 'Seguridad', 'Beticas pa\' seguridad', 'Activa'),
(4, 'Mantenimiento2323', 'asdasd', 'Inactiva');

-- --------------------------------------------------------

--
-- Table structure for table `censos`
--

CREATE TABLE `censos` (
  `id_cen` int(4) NOT NULL,
  `fecha_act` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario` int(4) NOT NULL,
  `fecha_asig` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `hora_asig` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Pendiente','En progreso','','Finalizado') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('52dlnjo39de4v816m5c422nkcj5pvu97', '::1', 1514403763, 0x5f5f63695f6c6173745f726567656e65726174657c693a313531343430333736333b746f6b656e7c733a34303a2239663735633363643461363935663837343938363437363864326461623466386334386138323765223b);

-- --------------------------------------------------------

--
-- Table structure for table `donaciones`
--

CREATE TABLE `donaciones` (
  `id_dnc` int(4) NOT NULL,
  `fecha_act` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario` int(4) NOT NULL,
  `observacion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Procesada') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `donantes`
--

CREATE TABLE `donantes` (
  `id_don` int(4) NOT NULL,
  `rif` varchar(12) COLLATE utf8_spanish_ci NOT NULL,
  `razon_social` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `donantes`
--

INSERT INTO `donantes` (`id_don`, `rif`, `razon_social`, `telefono`, `direccion`, `estado`) VALUES
(1, 'J-27402258-9', 'Connecting People C.A', '(0244) 323-4011', 'La Victoria, Estado Aragua', 'Activo'),
(2, 'J-27402258-7', 'La Mansión de Michelle C.A', '(0244) 322-8569', 'La Victoria, Estado Aragua', 'Activo'),
(3, 'J-27402258-8', 'Trend Effect C.A', '(0244) 323-4011', 'La Victoria, Estado Aragua', 'Activo'),
(4, 'J-27402253-4', 'Skype C.A', '(0244) 323-4011', 'La Victoria, Estado Aragua', 'Activo'),
(5, 'J-27402225-8', 'asdasd', '(1231) 231-2312', 'asdasdasd', 'Inactivo');

-- --------------------------------------------------------

--
-- Table structure for table `donantes_donacion`
--

CREATE TABLE `donantes_donacion` (
  `donacion` int(4) NOT NULL,
  `donante` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `edificios`
--

CREATE TABLE `edificios` (
  `id_edi` int(4) NOT NULL,
  `numero` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `area` int(4) NOT NULL,
  `descripcion` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `edificios`
--

INSERT INTO `edificios` (`id_edi`, `numero`, `nombre`, `area`, `descripcion`, `estado`) VALUES
(1, '1', 'Cazona', 3, '', 'Activo'),
(2, '2', 'Recibo', 2, '', 'Activo'),
(3, '3', 'Pasarela', 1, 'Tacata', 'Activo');

-- --------------------------------------------------------

--
-- Table structure for table `edificios_mantenimiento`
--

CREATE TABLE `edificios_mantenimiento` (
  `mantenimiento` int(4) NOT NULL,
  `edificio` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `empleados`
--

CREATE TABLE `empleados` (
  `id_emp` int(4) NOT NULL,
  `cedula` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `cargo` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `turno` enum('Diurno','Nocturno') COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(60) COLLATE utf8_spanish_ci NOT NULL,
  `disponibilidad` enum('Desocupado','Ocupado') COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `empleados`
--

INSERT INTO `empleados` (`id_emp`, `cedula`, `nombre`, `cargo`, `turno`, `telefono`, `email`, `direccion`, `disponibilidad`, `estado`) VALUES
(1, 'V-27402258', 'Yonathan Moncada', '4', 'Diurno', '(0424) 359-1604', 'yomoncadabooking@gmail.com', 'La Victoria, Estado Aragua', 'Desocupado', 'Activo'),
(2, 'V-27402253', 'Esmeralda Navarro', '6', 'Diurno', '(0424) 355-2311', 'esmeraldanavarro@gmail.com', 'La Victoria, Estado Aragua', 'Desocupado', 'Activo'),
(3, 'V-27402264', 'Luciano Moncada', '5', 'Diurno', '(0424) 233-4566', 'lucianomoncada@gmail.com', 'La Victoria, Estado Aragua', 'Desocupado', 'Activo'),
(4, 'V-24388345', 'Dubrazka Landaeta', '7', 'Diurno', '(0426) 256-3320', 'dubrazkalandaeta@gmail.com', 'El Consejo, Estado Aragua', 'Desocupado', 'Activo');

-- --------------------------------------------------------

--
-- Table structure for table `empleados_censo`
--

CREATE TABLE `empleados_censo` (
  `censo` int(4) NOT NULL,
  `empleado` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `empleados_mantenimiento`
--

CREATE TABLE `empleados_mantenimiento` (
  `mantenimiento` int(4) NOT NULL,
  `empleado` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `empleados_reforestacion`
--

CREATE TABLE `empleados_reforestacion` (
  `reforestacion` int(4) NOT NULL,
  `empleado` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `empleados_servicio`
--

CREATE TABLE `empleados_servicio` (
  `servicio` int(4) NOT NULL,
  `empleado` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `especies`
--

CREATE TABLE `especies` (
  `id_esp` int(4) NOT NULL,
  `codigo` varchar(4) COLLATE utf8_spanish_ci NOT NULL,
  `nom_cmn` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `nom_cntfc` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `flia` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` enum('Flora','Fauna') COLLATE utf8_spanish_ci NOT NULL,
  `poblacion` int(3) NOT NULL,
  `riesgo` int(3) NOT NULL,
  `extincion` int(3) NOT NULL,
  `estado` enum('Activa','Inactiva') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `especies`
--

INSERT INTO `especies` (`id_esp`, `codigo`, `nom_cmn`, `nom_cntfc`, `flia`, `tipo`, `poblacion`, `riesgo`, `extincion`, `estado`) VALUES
(1, 'AA03', 'Apamate', 'Tebebuia Rosea', 'Bignoniaceae', 'Flora', 50, 10, 3, 'Activa'),
(2, 'AA04', 'Cachicamo', 'Dasypus N. Novencintus', 'Dasipódidos', 'Fauna', 1, 2, 0, 'Activa'),
(3, 'AA05', 'Ardilla', 'Sciurus Aestuans', 'Sciuridae', 'Fauna', 10, 5, 0, 'Activa'),
(4, 'AA06', 'Perico', 'Melopsittacus Undulatus', 'Psittacidae', 'Fauna', 25, 5, 0, 'Activa'),
(5, 'AA07', 'Oso Perezoso', 'Bodypus Variegatus', 'Bradypodidae', 'Fauna', 1, 10, 0, 'Activa'),
(6, 'AA08', 'Murciélago', 'Pipistrellus', 'Verspertilionidae', 'Fauna', 1, 5, 0, 'Activa'),
(7, 'AA10', 'Bambú', 'Bambusa Arundinacea', 'Poaceae', 'Flora', 10, 5, 0, 'Activa'),
(8, 'AB01', 'Guayaba', 'Psidium Guajava', 'Myrtaceae', 'Flora', 5, 10, 0, 'Activa'),
(9, 'AB02', 'Mango', 'Mangifera Indica', 'Sapindaceae', 'Flora', 3, 5, 0, 'Activa'),
(10, 'AB03', 'Uvero', 'Coccoloba caracasana', 'Polygonaceae', 'Flora', 5, 5, 0, 'Activa');

-- --------------------------------------------------------

--
-- Table structure for table `especies_censo`
--

CREATE TABLE `especies_censo` (
  `censo` int(4) NOT NULL,
  `especie` int(4) NOT NULL,
  `poblacion` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `especies_reforestacion`
--

CREATE TABLE `especies_reforestacion` (
  `reforestacion` int(4) NOT NULL,
  `especie` int(4) NOT NULL,
  `poblacion` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fondos_donacion`
--

CREATE TABLE `fondos_donacion` (
  `donacion` int(4) NOT NULL,
  `cantidad` int(4) NOT NULL,
  `divisa` varchar(30) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `implementos`
--

CREATE TABLE `implementos` (
  `id_imp` int(4) NOT NULL,
  `codigo` varchar(11) COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `categoria` int(4) NOT NULL,
  `stock` int(4) NOT NULL,
  `stock_min` int(4) NOT NULL,
  `stock_max` int(4) NOT NULL,
  `unidad` enum('Kilogramos','Gramos','Litros','Mililitros','Unidades') COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `implementos`
--

INSERT INTO `implementos` (`id_imp`, `codigo`, `nombre`, `categoria`, `stock`, `stock_min`, `stock_max`, `unidad`, `estado`) VALUES
(1, 'CC20', 'Pala', 1, 100, 0, 100, 'Unidades', 'Activo'),
(4, 'CC21', 'Martillo', 2, 50, 1, 50, 'Unidades', 'Activo'),
(5, 'CC22', 'Botas', 3, 100, 1, 100, 'Unidades', 'Activo');

-- --------------------------------------------------------

--
-- Table structure for table `implementos_censo`
--

CREATE TABLE `implementos_censo` (
  `censo` int(4) NOT NULL,
  `implemento` int(4) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `unidad` varchar(30) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `implementos_donacion`
--

CREATE TABLE `implementos_donacion` (
  `donacion` int(4) NOT NULL,
  `implemento` int(4) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `unidad` varchar(30) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `implementos_mantenimiento`
--

CREATE TABLE `implementos_mantenimiento` (
  `mantenimiento` int(4) NOT NULL,
  `implemento` int(4) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `unidad` varchar(30) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `implementos_reforestacion`
--

CREATE TABLE `implementos_reforestacion` (
  `reforestacion` int(4) NOT NULL,
  `implemento` int(4) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `unidad` varchar(30) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `implementos_servicio`
--

CREATE TABLE `implementos_servicio` (
  `servicio` int(4) NOT NULL,
  `implemento` int(4) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `unidad` varchar(30) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invitados_servicio`
--

CREATE TABLE `invitados_servicio` (
  `servicio` int(4) NOT NULL,
  `cedula` varchar(10) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(80) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mantenimientos`
--

CREATE TABLE `mantenimientos` (
  `id_man` int(4) NOT NULL,
  `fecha_act` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario` int(4) NOT NULL,
  `fecha_asig` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `hora_asig` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Pendiente','En progreso','','Finalizado') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `niveles`
--

CREATE TABLE `niveles` (
  `id_niv` int(4) NOT NULL,
  `nivel` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `esp_access` int(1) NOT NULL,
  `are_access` int(1) NOT NULL,
  `cab_access` int(1) NOT NULL,
  `can_access` int(1) NOT NULL,
  `edi_access` int(1) NOT NULL,
  `cat_access` int(1) NOT NULL,
  `imp_access` int(1) NOT NULL,
  `ben_access` int(1) NOT NULL,
  `car_access` int(1) NOT NULL,
  `don_access` int(1) NOT NULL,
  `emp_access` int(1) NOT NULL,
  `cen_access` int(1) NOT NULL,
  `dnc_access` int(1) NOT NULL,
  `man_access` int(1) NOT NULL,
  `ref_access` int(1) NOT NULL,
  `ser_access` int(1) NOT NULL,
  `bd_access` int(1) NOT NULL,
  `bit_access` int(1) NOT NULL,
  `usu_access` int(1) NOT NULL,
  `niv_access` int(1) NOT NULL,
  `descripcion` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `niveles`
--

INSERT INTO `niveles` (`id_niv`, `nivel`, `esp_access`, `are_access`, `cab_access`, `can_access`, `edi_access`, `cat_access`, `imp_access`, `ben_access`, `car_access`, `don_access`, `emp_access`, `cen_access`, `dnc_access`, `man_access`, `ref_access`, `ser_access`, `bd_access`, `bit_access`, `usu_access`, `niv_access`, `descripcion`, `estado`) VALUES
(1, 'Administrador', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '', 'Activo'),
(2, 'Moderador', 1, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '', 'Activo'),
(3, 'Invitado', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 'Activo');

-- --------------------------------------------------------

--
-- Table structure for table `reforestaciones`
--

CREATE TABLE `reforestaciones` (
  `id_ref` int(4) NOT NULL,
  `fecha_act` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario` int(4) NOT NULL,
  `fecha_asig` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `hora_asig` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Pendiente','En progreso','','Finalizado') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `servicios`
--

CREATE TABLE `servicios` (
  `id_ser` int(4) NOT NULL,
  `fecha_act` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario` int(4) NOT NULL,
  `fecha_asig` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `hora_asig` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Pendiente','En progreso','','Finalizado') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usu` int(4) NOT NULL,
  `nombre` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `biografia` varchar(120) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `genero` enum('Femenino','Masculino') COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `usuario` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `contrasena` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `nivel` int(1) NOT NULL,
  `email` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `pregunta` enum('¿Cuál fue el nombre de tu primera mascota?','¿Cuál es la profesión de tu abuelo?','¿Cómo se llama tu mejor amigo de la infancia?','¿Cuál fue tu clase favorita en el colegio?') COLLATE utf8_spanish_ci NOT NULL,
  `respuesta` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `avatar` varchar(80) COLLATE utf8_spanish_ci NOT NULL,
  `estado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id_usu`, `nombre`, `biografia`, `telefono`, `genero`, `direccion`, `usuario`, `contrasena`, `nivel`, `email`, `pregunta`, `respuesta`, `avatar`, `estado`) VALUES
(1, 'Yonathan Moncada', 'Diseñador Gráfico, Productor Audiovisual, Desarollador Web. \r\n20 años. \r\nVenezolano', '(0424) 359-1604', 'Masculino', 'La Victoria, Estado Aragua', 'yomoncada', '88ea39439e74fa27c09a4fc0bc8ebe6d00978392', 1, 'yomoncadabooking@gmail.com', '¿Cuál fue el nombre de tu primera mascota?', 'Firulais', 'perfil-yomoncada-.png', 'Activo'),
(2, 'Luís Hernández', '', '(0414) 945-2962', 'Masculino', 'La Victoria, Estado Aragua', 'luchohnz', 'c8f9b98678a420b6e5249417dd3a5efb5863198f', 2, 'luchohnz@gmail.com', '¿Cuál es la profesión de tu abuelo?', 'Agricultor', 'perfil-luchohnz-4.png', 'Activo'),
(3, 'Marco Salazar', '', '(0424) 306-6682', 'Masculino', 'La Victoria, Estado Aragua', 'marcoslzr', 'c8f9b98678a420b6e5249417dd3a5efb5863198f', 1, 'marcoslzr@gmail.com', '¿Cuál fue el nombre de tu primera mascota?', 'Doggie', '', 'Activo'),
(4, 'Alejandro Goncalves', '', '', 'Masculino', '', 'alejandrop', '88ea39439e74fa27c09a4fc0bc8ebe6d00978392', 2, 'alejandrop@gmail.com', '¿Cuál fue el nombre de tu primera mascota?', 'Golden', '', 'Inactivo'),
(5, 'Dubrazka Landaeta', '', '', 'Masculino', '', 'dubrazki', '88ea39439e74fa27c09a4fc0bc8ebe6d00978392', 3, 'dubrazkiz@gmail.com', '¿Cuál fue el nombre de tu primera mascota?', 'mía', '', 'Inactivo');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id_act`);

--
-- Indexes for table `actividades_censo`
--
ALTER TABLE `actividades_censo`
  ADD KEY `censo` (`censo`,`actividad`,`encargado`),
  ADD KEY `censo_2` (`censo`,`actividad`,`encargado`);

--
-- Indexes for table `actividades_mantenimiento`
--
ALTER TABLE `actividades_mantenimiento`
  ADD KEY `censo` (`mantenimiento`,`actividad`,`encargado`),
  ADD KEY `censo_2` (`mantenimiento`,`actividad`,`encargado`);

--
-- Indexes for table `actividades_reforestacion`
--
ALTER TABLE `actividades_reforestacion`
  ADD KEY `censo` (`reforestacion`,`actividad`,`encargado`),
  ADD KEY `censo_2` (`reforestacion`,`actividad`,`encargado`);

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id_are`);

--
-- Indexes for table `areas_censo`
--
ALTER TABLE `areas_censo`
  ADD KEY `mantenimiento` (`censo`,`id_are`),
  ADD KEY `area` (`id_are`);

--
-- Indexes for table `areas_mantenimiento`
--
ALTER TABLE `areas_mantenimiento`
  ADD KEY `mantenimiento` (`mantenimiento`,`id_are`),
  ADD KEY `area` (`id_are`);

--
-- Indexes for table `areas_reforestacion`
--
ALTER TABLE `areas_reforestacion`
  ADD KEY `mantenimiento` (`reforestacion`,`id_are`),
  ADD KEY `area` (`id_are`);

--
-- Indexes for table `beneficiarios`
--
ALTER TABLE `beneficiarios`
  ADD PRIMARY KEY (`id_ben`);

--
-- Indexes for table `beneficiarios_servicio`
--
ALTER TABLE `beneficiarios_servicio`
  ADD KEY `mantenimiento` (`servicio`,`beneficiario`),
  ADD KEY `area` (`beneficiario`);

--
-- Indexes for table `bitacoras`
--
ALTER TABLE `bitacoras`
  ADD PRIMARY KEY (`id_bit`),
  ADD KEY `usuario` (`usuario`);

--
-- Indexes for table `cabanas`
--
ALTER TABLE `cabanas`
  ADD PRIMARY KEY (`id_cab`),
  ADD KEY `area` (`area`);

--
-- Indexes for table `cabanas_servicio`
--
ALTER TABLE `cabanas_servicio`
  ADD KEY `mantenimiento` (`servicio`,`cabana`),
  ADD KEY `area` (`cabana`);

--
-- Indexes for table `canchas`
--
ALTER TABLE `canchas`
  ADD PRIMARY KEY (`id_can`),
  ADD KEY `area` (`area`);

--
-- Indexes for table `canchas_servicio`
--
ALTER TABLE `canchas_servicio`
  ADD KEY `mantenimiento` (`servicio`,`cancha`),
  ADD KEY `area` (`cancha`);

--
-- Indexes for table `cargos`
--
ALTER TABLE `cargos`
  ADD PRIMARY KEY (`id_car`);

--
-- Indexes for table `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_cat`);

--
-- Indexes for table `censos`
--
ALTER TABLE `censos`
  ADD PRIMARY KEY (`id_cen`),
  ADD KEY `usuario` (`usuario`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `donaciones`
--
ALTER TABLE `donaciones`
  ADD PRIMARY KEY (`id_dnc`),
  ADD KEY `usuario` (`usuario`);

--
-- Indexes for table `donantes`
--
ALTER TABLE `donantes`
  ADD PRIMARY KEY (`id_don`);

--
-- Indexes for table `donantes_donacion`
--
ALTER TABLE `donantes_donacion`
  ADD KEY `mantenimiento` (`donacion`,`donante`),
  ADD KEY `area` (`donante`);

--
-- Indexes for table `edificios`
--
ALTER TABLE `edificios`
  ADD PRIMARY KEY (`id_edi`),
  ADD KEY `area` (`area`);

--
-- Indexes for table `edificios_mantenimiento`
--
ALTER TABLE `edificios_mantenimiento`
  ADD KEY `mantenimiento` (`mantenimiento`,`edificio`),
  ADD KEY `area` (`edificio`);

--
-- Indexes for table `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_emp`);

--
-- Indexes for table `empleados_censo`
--
ALTER TABLE `empleados_censo`
  ADD KEY `mantenimiento` (`censo`,`empleado`),
  ADD KEY `area` (`empleado`);

--
-- Indexes for table `empleados_mantenimiento`
--
ALTER TABLE `empleados_mantenimiento`
  ADD KEY `mantenimiento` (`mantenimiento`,`empleado`),
  ADD KEY `area` (`empleado`);

--
-- Indexes for table `empleados_reforestacion`
--
ALTER TABLE `empleados_reforestacion`
  ADD KEY `mantenimiento` (`reforestacion`,`empleado`),
  ADD KEY `area` (`empleado`);

--
-- Indexes for table `empleados_servicio`
--
ALTER TABLE `empleados_servicio`
  ADD KEY `mantenimiento` (`servicio`,`empleado`),
  ADD KEY `area` (`empleado`);

--
-- Indexes for table `especies`
--
ALTER TABLE `especies`
  ADD PRIMARY KEY (`id_esp`);

--
-- Indexes for table `especies_censo`
--
ALTER TABLE `especies_censo`
  ADD KEY `mantenimiento` (`censo`,`especie`),
  ADD KEY `empleado` (`especie`);

--
-- Indexes for table `especies_reforestacion`
--
ALTER TABLE `especies_reforestacion`
  ADD KEY `mantenimiento` (`reforestacion`,`especie`),
  ADD KEY `empleado` (`especie`);

--
-- Indexes for table `fondos_donacion`
--
ALTER TABLE `fondos_donacion`
  ADD KEY `donacion` (`donacion`);

--
-- Indexes for table `implementos`
--
ALTER TABLE `implementos`
  ADD PRIMARY KEY (`id_imp`),
  ADD UNIQUE KEY `categoria` (`categoria`),
  ADD UNIQUE KEY `categoria_2` (`categoria`);

--
-- Indexes for table `implementos_censo`
--
ALTER TABLE `implementos_censo`
  ADD KEY `mantenimiento` (`censo`,`implemento`),
  ADD KEY `implemento` (`implemento`);

--
-- Indexes for table `implementos_donacion`
--
ALTER TABLE `implementos_donacion`
  ADD KEY `mantenimiento` (`donacion`,`implemento`),
  ADD KEY `implemento` (`implemento`);

--
-- Indexes for table `implementos_mantenimiento`
--
ALTER TABLE `implementos_mantenimiento`
  ADD KEY `mantenimiento` (`mantenimiento`,`implemento`),
  ADD KEY `implemento` (`implemento`);

--
-- Indexes for table `implementos_reforestacion`
--
ALTER TABLE `implementos_reforestacion`
  ADD KEY `mantenimiento` (`reforestacion`,`implemento`),
  ADD KEY `implemento` (`implemento`);

--
-- Indexes for table `implementos_servicio`
--
ALTER TABLE `implementos_servicio`
  ADD KEY `mantenimiento` (`servicio`,`implemento`),
  ADD KEY `implemento` (`implemento`);

--
-- Indexes for table `mantenimientos`
--
ALTER TABLE `mantenimientos`
  ADD PRIMARY KEY (`id_man`),
  ADD KEY `usuario` (`usuario`);

--
-- Indexes for table `niveles`
--
ALTER TABLE `niveles`
  ADD PRIMARY KEY (`id_niv`);

--
-- Indexes for table `reforestaciones`
--
ALTER TABLE `reforestaciones`
  ADD PRIMARY KEY (`id_ref`),
  ADD KEY `usuario` (`usuario`);

--
-- Indexes for table `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id_ser`),
  ADD KEY `usuario` (`usuario`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usu`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actividades`
--
ALTER TABLE `actividades`
  MODIFY `id_act` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id_are` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `beneficiarios`
--
ALTER TABLE `beneficiarios`
  MODIFY `id_ben` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `bitacoras`
--
ALTER TABLE `bitacoras`
  MODIFY `id_bit` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=170;
--
-- AUTO_INCREMENT for table `cabanas`
--
ALTER TABLE `cabanas`
  MODIFY `id_cab` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `canchas`
--
ALTER TABLE `canchas`
  MODIFY `id_can` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `cargos`
--
ALTER TABLE `cargos`
  MODIFY `id_car` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_cat` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `censos`
--
ALTER TABLE `censos`
  MODIFY `id_cen` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `donaciones`
--
ALTER TABLE `donaciones`
  MODIFY `id_dnc` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `donantes`
--
ALTER TABLE `donantes`
  MODIFY `id_don` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `edificios`
--
ALTER TABLE `edificios`
  MODIFY `id_edi` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_emp` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `especies`
--
ALTER TABLE `especies`
  MODIFY `id_esp` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `implementos`
--
ALTER TABLE `implementos`
  MODIFY `id_imp` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `mantenimientos`
--
ALTER TABLE `mantenimientos`
  MODIFY `id_man` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `niveles`
--
ALTER TABLE `niveles`
  MODIFY `id_niv` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `reforestaciones`
--
ALTER TABLE `reforestaciones`
  MODIFY `id_ref` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_ser` int(4) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usu` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `cabanas`
--
ALTER TABLE `cabanas`
  ADD CONSTRAINT `cabanas_ibfk_1` FOREIGN KEY (`area`) REFERENCES `areas` (`id_are`);

--
-- Constraints for table `canchas`
--
ALTER TABLE `canchas`
  ADD CONSTRAINT `canchas_ibfk_1` FOREIGN KEY (`area`) REFERENCES `areas` (`id_are`);

--
-- Constraints for table `edificios`
--
ALTER TABLE `edificios`
  ADD CONSTRAINT `edificios_ibfk_1` FOREIGN KEY (`area`) REFERENCES `areas` (`id_are`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
