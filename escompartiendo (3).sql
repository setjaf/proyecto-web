create database escompartiendo;

use escompartiendo;
-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2018 at 09:41 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `escompartiendo`
--

-- --------------------------------------------------------

--
-- Table structure for table `archivo`
--

CREATE TABLE `archivo` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` char(100) NOT NULL,
  `descripcion` text,
  `fecha_carga` date NOT NULL,
  `url` char(150) NOT NULL,
  `status` bit(1) NOT NULL,
  `profesor` int(10) UNSIGNED NOT NULL,
  `unidad_aprendizaje` int(10) UNSIGNED NOT NULL,
  `nivel` enum('Básico','Medio','Avanzado') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `archivo`
--

INSERT INTO `archivo` (`id`, `nombre`, `descripcion`, `fecha_carga`, `url`, `status`, `profesor`, `unidad_aprendizaje`, `nivel`) VALUES
(1, 'Prueba 1', 'Hola mundo, prueba de subir un archivo', '2018-12-05', 'files/Prueba_1_1.html', b'1', 2, 1, 'Básico'),
(3, 'Archivo 1', 'Hola mundo, prueba de subir un archivo', '2018-12-05', 'files/Archivo_1_3.html', b'1', 2, 2, 'Medio'),
(4, 'Archivo 2', 'Hola mundo, prueba de subir un archivo', '2018-12-05', 'files/Archivo_2_4.html', b'1', 2, 2, 'Medio'),
(5, 'Archivo 3', 'Hola mundo, prueba de subir un archivo', '2018-12-05', 'files/Archivo_3_5.html', b'1', 2, 2, 'Medio');

-- --------------------------------------------------------

--
-- Table structure for table `comentario`
--

CREATE TABLE `comentario` (
  `fecha_comentario` date NOT NULL,
  `usuario` int(10) UNSIGNED NOT NULL,
  `archivo` int(10) UNSIGNED NOT NULL,
  `comentario` text,
  `calificacion` enum('Bueno','Regular','Malo') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comentario`
--

INSERT INTO `comentario` (`fecha_comentario`, `usuario`, `archivo`, `comentario`, `calificacion`) VALUES
('2018-12-06', 1, 1, 'Este es un comentario de prueba, el archivo parece bueno', 'Bueno'),
('2018-12-06', 1, 3, 'oohhhh', 'Regular'),
('2018-12-06', 1, 4, 'Otro Comentario', 'Regular'),
('2018-12-06', 1, 5, 'Fue malísimo', 'Malo');

-- --------------------------------------------------------

--
-- Table structure for table `grupo`
--

CREATE TABLE `grupo` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` char(150) NOT NULL,
  `profesor` int(10) UNSIGNED NOT NULL,
  `ua` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grupo`
--

INSERT INTO `grupo` (`id`, `nombre`, `profesor`, `ua`) VALUES
(1, 'Tec Web 2cv1', 2, 1),
(2, 'Tec Web 2cv3', 2, 1),
(3, 'Algoritmia 2cv3', 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `grupo_alumno`
--

CREATE TABLE `grupo_alumno` (
  `alumno` int(10) UNSIGNED NOT NULL,
  `grupo` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rol`
--

CREATE TABLE `rol` (
  `id` int(10) UNSIGNED NOT NULL,
  `descripcion` char(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rol`
--

INSERT INTO `rol` (`id`, `descripcion`) VALUES
(1, 'administrador'),
(2, 'profesor'),
(3, 'alumno');

-- --------------------------------------------------------

--
-- Table structure for table `tarea`
--

CREATE TABLE `tarea` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` text NOT NULL,
  `descripcion` text NOT NULL,
  `fecha_creacion` date NOT NULL,
  `fecha_termino` date NOT NULL,
  `path_archivo` char(150) DEFAULT NULL,
  `profesor` int(10) UNSIGNED NOT NULL,
  `archivo` int(10) UNSIGNED NOT NULL,
  `grupo` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tarea_enviada`
--

CREATE TABLE `tarea_enviada` (
  `fecha_subida` date NOT NULL,
  `path_archivo` char(150) DEFAULT NULL,
  `alumno` int(10) UNSIGNED NOT NULL,
  `tarea` int(10) UNSIGNED NOT NULL,
  `calificacion` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ua_profesor`
--

CREATE TABLE `ua_profesor` (
  `profesor` int(10) UNSIGNED NOT NULL,
  `ua` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ua_profesor`
--

INSERT INTO `ua_profesor` (`profesor`, `ua`) VALUES
(2, 1),
(2, 2),
(2, 4),
(5, 1),
(5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `unidad_aprendizaje`
--

CREATE TABLE `unidad_aprendizaje` (
  `id` int(10) UNSIGNED NOT NULL,
  `nombre` char(100) NOT NULL,
  `descripcion` char(150) NOT NULL,
  `nivel` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `unidad_aprendizaje`
--

INSERT INTO `unidad_aprendizaje` (`id`, `nombre`, `descripcion`, `nivel`) VALUES
(1, 'Tecnologías para la web', 'Esta es una prueba de ua', 2),
(2, 'Análisis y diseño orientado a objetos (ADOO)', 'Otra prueba de materia', 2),
(3, 'Matemáticas Avanzadas para la Ingeniería', 'Una materia de matemáticas', 2),
(4, 'Algoritmia y Programación Estructurada', 'Una materia de programación', 1),
(5, 'Matemáticas Discretas', 'Una materia de matemáticas', 1),
(6, 'Programación Orientada a Objetos', 'Esta es una ua', 2);

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id` int(10) UNSIGNED NOT NULL,
  `correo` char(100) NOT NULL,
  `contrasena` char(100) NOT NULL,
  `fecha_alta` date NOT NULL,
  `nombre` char(100) NOT NULL,
  `paterno` char(50) NOT NULL,
  `materno` char(50) DEFAULT NULL,
  `fecha_nacimiento` date NOT NULL,
  `boleta` char(10) DEFAULT NULL,
  `CURP` char(18) DEFAULT NULL,
  `status` bit(1) NOT NULL,
  `rol` int(10) UNSIGNED NOT NULL,
  `foto` char(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `correo`, `contrasena`, `fecha_alta`, `nombre`, `paterno`, `materno`, `fecha_nacimiento`, `boleta`, `CURP`, `status`, `rol`, `foto`) VALUES
(1, 'admin@gmail.com', '123', '2018-11-23', 'Admin', 'Usuario', 'Prueba', '1997-06-06', NULL, 'REOS970606HMCNRT00', b'1', 1, 'images/user_1.jpg'),
(2, 'profesor@gmail.com', '123', '2018-11-23', 'Profesor', 'Usuario', 'Prueba', '1997-06-06', NULL, 'REOS970606HMCNRT01', b'1', 2, 'images/user_2.jpg'),
(3, 'setjafet@gmail.com', '123', '2018-11-23', 'Alumno', 'Usuario', 'Prueba', '1997-06-06', '2016301390', 'REOS970606HMCNRT03', b'1', 3, 'images/user_3.jpg'),
(4, 'ejchavezg17@gmail.com', '123456', '2018-11-27', 'EDUARDO', 'CHAVEZ', 'GARCIA', '2018-11-05', '2013630447', 'CAGE940805HDFHRD04', b'1', 3, 'images/user_0.jpg'),
(5, 'gaby_dlib@hotmail.com', '12345', '2018-11-27', 'Gabriela de Jesús', 'López', 'Ruiz', '1986-12-12', NULL, 'LORG851212MCSPZB03', b'1', 2, 'images/user_0.jpg'),
(6, 'rayplaneta21@gmail.com', '123', '2018-12-03', 'Raymundo', 'Torres', 'Diaz', '2019-02-21', '2014090714', 'TODR980221HDFRZY00', b'1', 3, 'images/user_6.jpg'),
(7, 'wildones_2011a@hotmail.com', '1521', '2018-12-03', 'Aaron', 'Castro', 'Santamaria', '1998-07-01', '2014090124', 'CASA980701HPLSNR09', b'1', 3, 'images/user_7.jpg'),
(8, 'armndo.g@gmail.com', '123', '2018-12-04', 'Armando Omar', 'González', 'González', '1999-06-29', '2015090269', 'GOGA990629HDFNNR03', b'1', 3, 'images/user_8.jpg'),
(10, 'hawken9881@gmail.com', '123456', '2018-12-04', 'Ernesto', 'Galarga', 'Negrete', '1520-12-19', '2018631191', 'JOCA981019HFDLRL01', b'1', 3, 'images/user_10.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `archivo`
--
ALTER TABLE `archivo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `profesor` (`profesor`),
  ADD KEY `unidad_aprendizaje` (`unidad_aprendizaje`);

--
-- Indexes for table `comentario`
--
ALTER TABLE `comentario`
  ADD PRIMARY KEY (`usuario`,`archivo`),
  ADD KEY `archivo` (`archivo`);

--
-- Indexes for table `grupo`
--
ALTER TABLE `grupo`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD KEY `profesor` (`profesor`),
  ADD KEY `ua` (`ua`);

--
-- Indexes for table `grupo_alumno`
--
ALTER TABLE `grupo_alumno`
  ADD PRIMARY KEY (`alumno`,`grupo`),
  ADD KEY `grupo` (`grupo`);

--
-- Indexes for table `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tarea`
--
ALTER TABLE `tarea`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profesor` (`profesor`),
  ADD KEY `archivo` (`archivo`),
  ADD KEY `grupo` (`grupo`);

--
-- Indexes for table `tarea_enviada`
--
ALTER TABLE `tarea_enviada`
  ADD PRIMARY KEY (`alumno`,`tarea`),
  ADD KEY `tarea` (`tarea`);

--
-- Indexes for table `ua_profesor`
--
ALTER TABLE `ua_profesor`
  ADD PRIMARY KEY (`profesor`,`ua`),
  ADD KEY `ua` (`ua`);

--
-- Indexes for table `unidad_aprendizaje`
--
ALTER TABLE `unidad_aprendizaje`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD UNIQUE KEY `boleta` (`boleta`),
  ADD UNIQUE KEY `CURP` (`CURP`),
  ADD KEY `rol` (`rol`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `archivo`
--
ALTER TABLE `archivo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `grupo`
--
ALTER TABLE `grupo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tarea`
--
ALTER TABLE `tarea`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unidad_aprendizaje`
--
ALTER TABLE `unidad_aprendizaje`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `archivo`
--
ALTER TABLE `archivo`
  ADD CONSTRAINT `archivo_ibfk_1` FOREIGN KEY (`profesor`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `archivo_ibfk_2` FOREIGN KEY (`unidad_aprendizaje`) REFERENCES `unidad_aprendizaje` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `comentario_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comentario_ibfk_2` FOREIGN KEY (`archivo`) REFERENCES `archivo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `grupo`
--
ALTER TABLE `grupo`
  ADD CONSTRAINT `grupo_ibfk_1` FOREIGN KEY (`profesor`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `grupo_ibfk_2` FOREIGN KEY (`ua`) REFERENCES `unidad_aprendizaje` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `grupo_alumno`
--
ALTER TABLE `grupo_alumno`
  ADD CONSTRAINT `grupo_alumno_ibfk_1` FOREIGN KEY (`alumno`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `grupo_alumno_ibfk_2` FOREIGN KEY (`grupo`) REFERENCES `grupo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tarea`
--
ALTER TABLE `tarea`
  ADD CONSTRAINT `tarea_ibfk_1` FOREIGN KEY (`profesor`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tarea_ibfk_2` FOREIGN KEY (`archivo`) REFERENCES `archivo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tarea_ibfk_3` FOREIGN KEY (`grupo`) REFERENCES `grupo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tarea_enviada`
--
ALTER TABLE `tarea_enviada`
  ADD CONSTRAINT `tarea_enviada_ibfk_1` FOREIGN KEY (`alumno`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tarea_enviada_ibfk_2` FOREIGN KEY (`tarea`) REFERENCES `tarea` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ua_profesor`
--
ALTER TABLE `ua_profesor`
  ADD CONSTRAINT `ua_profesor_ibfk_1` FOREIGN KEY (`ua`) REFERENCES `unidad_aprendizaje` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ua_profesor_ibfk_2` FOREIGN KEY (`profesor`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`rol`) REFERENCES `rol` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
