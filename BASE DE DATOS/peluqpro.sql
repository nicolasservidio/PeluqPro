-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2025 at 11:39 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `peluqpro`
--

-- --------------------------------------------------------

--
-- Table structure for table `cargo`
--

CREATE TABLE `cargo` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cargo`
--

INSERT INTO `cargo` (`id`, `descripcion`) VALUES
(1, 'ADMINISTRADOR'),
(2, 'GERENTE_GENERAL'),
(3, 'ENCARGADO_ADMINISTRACION'),
(4, 'ENCARGADO_FINANZAS'),
(5, 'ENCARGADO_COMPRAS'),
(6, 'ENCARGADO_RRHH'),
(7, 'STAFF_CONTADOR'),
(8, 'ENCARGADO_OPERACIONES'),
(9, 'OPERATIVO_ESTILISTA'),
(10, 'OPERATIVO_AUXILIAR'),
(11, 'ENCARGADO_RECEPCION'),
(12, 'OPERATIVO_RECEPCIONISTA'),
(13, 'ENCARGADO_VENTAS'),
(14, 'OPERATIVO_VENDEDOR'),
(15, 'OPERATIVO_CAJERO'),
(16, 'OPERATIVO_REPOSITOR'),
(17, 'ENCARGADO_MARKETING'),
(18, 'COMMUNITY_MANAGER'),
(19, 'STAFF_DIS_GRAFICO');

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE `clientes` (
  `idCliente` int(11) NOT NULL,
  `dniCliente` int(20) DEFAULT NULL,
  `nombreCliente` varchar(50) DEFAULT NULL,
  `apellidoCliente` varchar(50) DEFAULT NULL,
  `mailCliente` varchar(50) DEFAULT NULL,
  `telefonoCliente` int(15) DEFAULT NULL,
  `direccionCliente` varchar(50) DEFAULT NULL,
  `localidadCliente` varchar(50) DEFAULT NULL,
  `bajaCliente` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`idCliente`, `dniCliente`, `nombreCliente`, `apellidoCliente`, `mailCliente`, `telefonoCliente`, `direccionCliente`, `localidadCliente`, `bajaCliente`) VALUES
(1, 345656432, 'Horacio', 'García', 'horaciog@yahoo.com', 12345678, '2093 Rivadavia', 'Córdoba', 'N'),
(2, 7654321, 'Alberto', 'Suárez', 'albertos@yahoo.com', 2147483647, '1029 Cuyo', 'Córdoba', 'N'),
(3, 2147483647, 'Nicolás', 'Servidio', 'servidion@yahoo.com', 999999777, '1901 Sarmiento', 'Córdoba', 'N'),
(4, 3028388, 'Carolina', 'Pérez', 'perezc@yahoo.com', 93928999, '992 Salta', 'Villa Carlos Paz', 'N'),
(5, 4432323, 'Lucia', 'Gonzalez', 'luciag@yahoo.com', 993939282, '993 Zapiola', 'Ciudad Autónoma de Buenos Aires', 'N'),
(16, 393093029, 'Agustín', 'Di Stefano', 'etchebarnea@yahoo.com', 2147483647, '1124 Salvador', 'La Plata', 'N'),
(17, 326643336, 'Maria', 'Kepano', 'mariakep@yahoo.com', 2147483647, '2939 Av. Callao', 'Ciudad Autónoma de Buenos Aires', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(250) DEFAULT NULL,
  `usuario` varchar(250) DEFAULT NULL,
  `contrasena` varchar(250) DEFAULT NULL,
  `id_cargo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `usuario`, `contrasena`, `id_cargo`) VALUES
(1, 'ADMINISTRADOR', 'ADMIN', 'ADMIN', 1),
(2, 'Nicolas Servidio', 'nservidio', '1234', 5),
(3, 'Lourdes Miranda', 'lmiranda', '1234', 3),
(4, 'Juan Ignacio Alvarez', 'jalvarez', '1234', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`idCliente`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuarios_ibfk_1` (`id_cargo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
