-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2025 at 12:22 PM
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
(2, 7654321, 'Alberto', 'Perez', 'albertop@hotmail.com', 2147483611, '1029 Cuyo', 'Córdoba', 'N'),
(3, 2147483647, 'Nicolás', 'Servidio', 'servidion@yahoo.com', 999999777, '1901 Sarmiento', 'Córdoba', 'N'),
(4, 3028388, 'Carolina', 'Pérez', 'perezc@yahoo.com', 93928999, '992 Salta', 'Villa Carlos Paz', 'N'),
(5, 4432323, 'Lucia', 'Gonzalez', 'luciag@yahoo.com', 993939282, '993 Zapiola', 'Ciudad Autónoma de Buenos Aires', 'N'),
(16, 393093029, 'Agustín', 'Di Stefano', 'etchebarnea@yahoo.com', 2147483647, '1124 Salvador', 'La Plata', 'N'),
(17, 326643336, 'Maria', 'Kepano', 'mariakep@yahoo.com', 2147483647, '2939 Av. Callao', 'Ciudad Autónoma de Buenos Aires', 'N'),
(18, 838293929, 'Maria', 'Hernandez', 'mariah@yahoo.com', 2147483647, '38 Nicaragua', 'Rosario', 'N'),
(19, 939309290, 'Horacio', 'Gutierrez', 'gutierrezh@gmail.com', 2147483647, '1239 Belgrano', 'Ciudad Autónoma de Buenos Aires', 'N'),
(20, 2147483647, 'kdldñk', 'fodfjf jkdl', 'jeklsje@fklfkjdl.com', 389833290, 'kdlskñ dklñ', 'kdlskdl', 'S');

-- --------------------------------------------------------

--
-- Table structure for table `empleados`
--

CREATE TABLE `empleados` (
  `id` int(11) NOT NULL COMMENT 'Número de legajo del empleado',
  `nombreEmpleado` varchar(50) DEFAULT NULL,
  `apellidoEmpleado` varchar(50) DEFAULT NULL,
  `cuilEmpleado` varchar(20) NOT NULL,
  `fechaNacimiento` date DEFAULT NULL,
  `estadoCivil` varchar(20) DEFAULT NULL COMMENT 'Estado civil del empleado',
  `fechaIngreso` date DEFAULT NULL COMMENT 'Fecha de ingreso a la empresa',
  `idTipoContrato` int(11) DEFAULT NULL COMMENT 'Tipo de contrato',
  `idCargo` int(11) DEFAULT NULL COMMENT 'Cargo o puesto del empleado',
  `idEstadoContrato` int(11) DEFAULT NULL COMMENT 'Estado del contrato',
  `obrasocial` varchar(50) DEFAULT NULL COMMENT 'Obra social del empleado',
  `banco` varchar(50) DEFAULT NULL COMMENT 'Banco en donde se deposita salario',
  `cbu` varchar(50) DEFAULT NULL COMMENT 'CBU de la cuenta de depósito',
  `mailEmpleado` varchar(50) DEFAULT NULL,
  `telEmpleado` int(15) DEFAULT NULL,
  `direccionEmpleado` varchar(50) DEFAULT NULL,
  `localidadEmpleado` varchar(50) DEFAULT NULL,
  `bajaEmpleado` char(1) DEFAULT NULL COMMENT 'Para la baja lógica de los empleados, al igual que en clientes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `empleados`
--

INSERT INTO `empleados` (`id`, `nombreEmpleado`, `apellidoEmpleado`, `cuilEmpleado`, `fechaNacimiento`, `estadoCivil`, `fechaIngreso`, `idTipoContrato`, `idCargo`, `idEstadoContrato`, `obrasocial`, `banco`, `cbu`, `mailEmpleado`, `telEmpleado`, `direccionEmpleado`, `localidadEmpleado`, `bajaEmpleado`) VALUES
(1, 'Mariano', 'Zaballa', '882829020', '1982-02-12', 'Casado', '2002-02-12', 1, 9, 1, 'Ninguna', 'Ninguno', 'Ninguno', 'zaballam@gmail.com', 2147483647, '392 Zapiola', 'Córdoba', 'N'),
(2, 'Juan', 'Perez', '20123456789', '1990-12-04', 'Soltero', '2021-02-01', 2, 5, 1, 'OSDE', 'Santander', '1234567890123456789012', 'juan.perez@email.com', 1122334455, 'Av. Corrientes 1234', 'Córdoba', 'N'),
(3, 'María', 'María', '27234567890', '1988-02-25', 'Casada', '2019-03-15', 2, 18, 4, 'Swiss Medical', 'BBVA', '2345678901234567890123', 'maria.gomez@email.com', 1133445566, 'Av. Rivadavia 4567', 'Córdoba', 'N'),
(4, 'Carlos', 'Rodríguez', '23111223344', '1985-08-10', 'Divorciado', '2015-01-06', 1, 8, 3, 'Medife', 'Galicia', '3456789012345678901234', 'carlos.rodriguez@email.com', 1144556677, 'San Martín 789', 'Córdoba', 'N'),
(5, 'Laura', 'Fernández', '30123456789', '1995-01-30', 'Soltera', '2023-09-10', 3, 4, 9, 'OSDE', 'Santander', '4567890123456789012345', 'laura.fernandez@email.com', 1155667788, 'Mitre 2345', 'Córdoba', 'N'),
(6, 'Pedro', 'González', '32112345678', '1982-12-12', 'Casado', '2013-05-26', 1, 3, 1, 'Swiss Medical', 'Brubank', '5678901234567890123456', 'pedro.gonzalez@email.com', 1166778899, 'Belgrano 5678', 'Villa Carlos Paz', 'N'),
(7, 'Sofía', 'Martínez', '33112233445', '1993-07-22', 'Soltera', '2021-01-12', 2, 10, 6, 'Medife', 'Galicia', '6789012345678901234567', 'sofia.martinez@email.com', 1177889900, 'Sarmiento 890', 'Córdoba', 'N'),
(8, 'Mateo', 'Bianchi', '34123456789', '1992-12-04', 'Viudo', '2020-10-02', 1, 6, 10, 'OSDE', 'Santander', '7890123456789012345678', 'matteo.bianchi@email.com', 1199887766, 'Av. Alem 567', 'Córdoba', 'N'),
(9, 'Romina', 'Romano', '35112233445', '1987-06-22', 'Soltera', '2015-08-06', 2, 15, 7, 'Swiss Medical', 'BBVA', '8901234567890123456789', 'romano@yahoo.com', 1177665544, 'Calle San José 234', 'Córdoba', 'N'),
(10, 'Luciano', 'Moretti', '36113344556', '1989-10-12', 'Soltero', '2022-05-18', 3, 1, 2, 'Medife', 'Ualá', '9012345678901234567890', 'sofia.moretti@email.com', 1188223355, 'Avenida Italia 876', 'Córdoba', 'N'),
(11, 'Luca', 'Ferrari', '37114455667', '1989-03-19', 'Divorciado', '2016-02-11', 1, 1, 1, 'Ninguna', 'Dukascopy', '1234567890123456789012', 'ferrari@hotmail.com', 1155332299, 'Calle Colón 345', 'Villa Carlos Paz', 'N'),
(12, 'Alessia', 'De Luca', '38115566778', '1994-07-07', 'Soltera', '2020-04-15', 2, 9, 5, 'Ninguna', 'BBVA', '2345678901234567890123', 'alessia.deluca@email.com', 1166448877, 'Av. San Lorenzo 543', 'Córdoba', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `estadocontrato`
--

CREATE TABLE `estadocontrato` (
  `id` int(11) NOT NULL,
  `estado` varchar(25) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `estadocontrato`
--

INSERT INTO `estadocontrato` (`id`, `estado`, `descripcion`) VALUES
(1, 'Activo', 'El empleado se encuentra en funciones y con contrato vigente.'),
(2, 'Suspendido', 'El contrato está temporalmente inactivo por razones legales o administrativas (ejemplo: suspensión disciplinaria o por fuerza mayor).'),
(3, 'Licencia', 'El empleado tiene un permiso temporal por razones justificadas (ejemplo: licencia médica, maternidad, vacaciones).'),
(4, 'Baja voluntaria', 'El empleado ha renunciado a su puesto de trabajo.'),
(5, 'Despido con causa', 'El contrato ha sido rescindido por incumplimiento grave del empleado'),
(6, 'Despido sin causa', 'El contrato ha sido terminado por decisión del empleador sin justificación específica.'),
(7, 'Jubilado', 'El empleado ha cesado sus funciones por retiro previsional.'),
(8, 'Fallecido', 'El contrato se extingue por fallecimiento del empleado.'),
(9, 'Vencido', 'El vínculo laboral ha concluido por vencimiento del plazo acordado en contratos temporales.'),
(10, 'Reubicado', 'El empleado ha sido trasladado a otro puesto dentro de la empresa.');

-- --------------------------------------------------------

--
-- Table structure for table `tipodecontrato`
--

CREATE TABLE `tipodecontrato` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tipodecontrato`
--

INSERT INTO `tipodecontrato` (`id`, `descripcion`) VALUES
(1, 'Permanente'),
(2, 'Temporal'),
(3, 'Pasantía');

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
-- Indexes for table `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idTipoContrato` (`idTipoContrato`),
  ADD KEY `idCargo` (`idCargo`),
  ADD KEY `idEstadoContrato` (`idEstadoContrato`);

--
-- Indexes for table `estadocontrato`
--
ALTER TABLE `estadocontrato`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipodecontrato`
--
ALTER TABLE `tipodecontrato`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `idCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Número de legajo del empleado', AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `estadocontrato`
--
ALTER TABLE `estadocontrato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tipodecontrato`
--
ALTER TABLE `tipodecontrato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `empleados_ibfk_1` FOREIGN KEY (`idTipoContrato`) REFERENCES `tipodecontrato` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `empleados_ibfk_2` FOREIGN KEY (`idCargo`) REFERENCES `cargo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `empleados_ibfk_3` FOREIGN KEY (`idEstadoContrato`) REFERENCES `estadocontrato` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`id_cargo`) REFERENCES `cargo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
