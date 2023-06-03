-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2023 at 08:34 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gym`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`` PROCEDURE `filtrar_ejercicios_por_equipo` (IN `equipoId` INT)   SELECT e.nombre as Nombre, g.nombre as Musculo, q.nombre as Equipo
FROM ejercicio as e
INNER JOIN grupo_muscular as g ON g.id_musculo=e.fk_musculo
INNER JOIN equipo AS q ON q.id_equipo=e.fk_equipo WHERE 
q.id_equipo=equipoId$$

CREATE DEFINER=`` PROCEDURE `filtrar_ejercicios_por_grupo` (IN `grupoMuscularId` INT)   BEGIN
    SELECT e.nombre as Nombre, g.nombre as Musculo, q.nombre as Equipo FROM ejercicio as e INNER JOIN 
    grupo_muscular as g ON g.id_musculo=e.fk_musculo INNER JOIN equipo AS
    q ON q.id_equipo=e.fk_equipo 
    WHERE e.fk_musculo = grupoMuscularId;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ejercicio`
--

CREATE TABLE `ejercicio` (
  `id_ejercicio` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `fk_musculo` int(11) DEFAULT NULL,
  `fk_equipo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ejercicio`
--

INSERT INTO `ejercicio` (`id_ejercicio`, `nombre`, `fk_musculo`, `fk_equipo`) VALUES
(1, 'Curl femoral', 4, 5),
(2, 'Press Banca', 3, 2);

-- --------------------------------------------------------

--
-- Stand-in structure for view `ejerciciospagina`
-- (See below for the actual view)
--
CREATE TABLE `ejerciciospagina` (
`Nombre` varchar(50)
,`Musculo` varchar(50)
,`Equipo` varchar(50)
);

-- --------------------------------------------------------

--
-- Table structure for table `entrenamiento`
--

CREATE TABLE `entrenamiento` (
  `id_entrenamiento` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `fk_usuario` varchar(20) DEFAULT NULL,
  `fk_rutina` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `entrenamiento`
--

INSERT INTO `entrenamiento` (`id_entrenamiento`, `fecha`, `fk_usuario`, `fk_rutina`) VALUES
(1, '2023-06-07', 'PachitoRTX', 6);

--
-- Triggers `entrenamiento`
--
DELIMITER $$
CREATE TRIGGER `actualizar_contador_delete` AFTER DELETE ON `entrenamiento` FOR EACH ROW BEGIN
    DECLARE contador INT;

    IF OLD.fk_rutina IS NOT NULL THEN
 SET contador = (
            SELECT COUNT(*) FROM entrenamiento WHERE fk_rutina = OLD.fk_rutina
        );
UPDATE rutina SET contador_entrenamientos = contador WHERE id_rutina = OLD.fk_rutina;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `actualizar_contador_insert` AFTER INSERT ON `entrenamiento` FOR EACH ROW BEGIN
    DECLARE contador INT; IF NEW.fk_rutina IS NOT NULL THEN
SET contador = (
            SELECT COUNT(*) FROM entrenamiento WHERE fk_rutina = NEW.fk_rutina
        );UPDATE rutina SET contador_entrenamientos = contador WHERE id_rutina = NEW.fk_rutina;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `actualizar_contador_update` AFTER UPDATE ON `entrenamiento` FOR EACH ROW BEGIN
    DECLARE contador INT;

    IF NEW.fk_rutina IS NOT NULL THEN
SET contador = (
            SELECT COUNT(*) FROM entrenamiento WHERE fk_rutina = NEW.fk_rutina
        );UPDATE rutina SET contador_entrenamientos = contador WHERE id_rutina = NEW.fk_rutina;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `entrenamiento_rutina`
-- (See below for the actual view)
--
CREATE TABLE `entrenamiento_rutina` (
`fecha` date
,`nombre` varchar(50)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `entrenamiento_rutina2`
-- (See below for the actual view)
--
CREATE TABLE `entrenamiento_rutina2` (
`fecha` date
,`nombre` varchar(50)
);

-- --------------------------------------------------------

--
-- Table structure for table `equipo`
--

CREATE TABLE `equipo` (
  `id_equipo` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `equipo`
--

INSERT INTO `equipo` (`id_equipo`, `nombre`) VALUES
(1, 'Mancuerna'),
(2, 'Barra'),
(3, 'Polea'),
(4, 'Barra paralela'),
(5, 'Maquina');

-- --------------------------------------------------------

--
-- Table structure for table `grupo_muscular`
--

CREATE TABLE `grupo_muscular` (
  `id_musculo` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `grupo_muscular`
--

INSERT INTO `grupo_muscular` (`id_musculo`, `nombre`) VALUES
(1, 'Bicep'),
(3, 'Pecho'),
(4, 'Espalda'),
(5, 'Tricep'),
(6, 'Abdominales'),
(8, 'Hombro'),
(9, 'Cuadricep'),
(10, 'Femoral'),
(11, 'Pantorrilla');

-- --------------------------------------------------------

--
-- Table structure for table `realiza`
--

CREATE TABLE `realiza` (
  `id_ejercicio_rutina` int(11) NOT NULL,
  `repeticiones` smallint(6) DEFAULT NULL,
  `series` smallint(6) DEFAULT NULL,
  `fk_rutina` int(11) DEFAULT NULL,
  `fk_ejercicio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rutina`
--

CREATE TABLE `rutina` (
  `id_rutina` int(11) NOT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `contador_entrenamientos` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rutina`
--

INSERT INTO `rutina` (`id_rutina`, `nombre`, `contador_entrenamientos`) VALUES
(6, 'Killer Pecho', 1),
(7, 'Killer Bicep', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id` int(11) NOT NULL,
  `tipo` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id`, `tipo`) VALUES
(1, 'USUARIO'),
(2, 'ADMINISTRADOR');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(150) NOT NULL,
  `sexo` varchar(1) DEFAULT NULL,
  `estatura` smallint(6) DEFAULT NULL,
  `peso` smallint(6) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `tipo_usuario` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `email`, `password`, `sexo`, `estatura`, `peso`, `fecha_nacimiento`, `tipo_usuario`) VALUES
('brunaco', 'brunaco@gmail.com', '$2y$10$Fp9hb.BjX0wHABj.lUw9ZeP0K3h8aaBe5sI9crCrHMZkuDebQI13m', 'H', 180, 70, '2019-01-15', 1),
('Jorgito1', 'jorgito1@gmail.com', '$2y$10$Qj0RRnkGbSSD51c3/skvLexLzBiQD87AVxaKQRDwr1zJmn2NZNyTy', 'H', 78, 190, '2023-05-11', 1),
('PachitoRTX', 'oscarmadriz24@gmail.com', '$2y$10$I5qr4/BLP3RCNbmkyzLDX.nzBglq5rhORl5YagEGoHbUyFUn0gYIy', 'H', 173, 75, '2005-03-23', 2),
('PachitoRTX23', 'oscarmadriz408@gmail.com', '$2y$10$RDRCDt2SJhezAO5zH/sz/.wi7LifWdS5lb8MqwMdHqMaaq8NSs5sC', 'M', 43, 234, '2023-05-10', 1),
('PachitoRTX40', 'oscarmadriz408@gmail.com', '$2y$10$Q6B2cBtFJAR4Z8vaSi008u91C5T0LFDwQR9ckccON5VJ.1hGImbai', 'M', 40, 1231, '2023-05-18', 1),
('PachitoRTX45', 'oscarmadriz408@gmail.com', '$2y$10$uvSPYQss9jDwZlsaguSWzu/Mpg1kGA6J391keIoaf448yziUeFgEO', 'H', 432, 234, '2023-05-17', 1),
('TUMADRE', 'tumadre@gmail.com', '$2y$10$4GlPJSTvbzj/IAbmckId/.8nX4bAvSBxOR2UaOtOWOSuCrbRxwxKS', 'H', 89, 189, '2023-05-18', 1);

-- --------------------------------------------------------

--
-- Structure for view `ejerciciospagina`
--
DROP TABLE IF EXISTS `ejerciciospagina`;

CREATE ALGORITHM=UNDEFINED DEFINER=`` SQL SECURITY DEFINER VIEW `ejerciciospagina`  AS SELECT `e`.`nombre` AS `Nombre`, `m`.`nombre` AS `Musculo`, `q`.`nombre` AS `Equipo` FROM ((`ejercicio` `e` join `grupo_muscular` `m` on(`m`.`id_musculo` = `e`.`fk_musculo`)) join `equipo` `q` on(`q`.`id_equipo` = `e`.`fk_equipo`))  ;

-- --------------------------------------------------------

--
-- Structure for view `entrenamiento_rutina`
--
DROP TABLE IF EXISTS `entrenamiento_rutina`;

CREATE ALGORITHM=UNDEFINED DEFINER=`` SQL SECURITY DEFINER VIEW `entrenamiento_rutina`  AS SELECT `e`.`fecha` AS `fecha`, `r`.`nombre` AS `nombre` FROM (`entrenamiento` `e` join `rutina` `r` on(`r`.`id_rutina` = `e`.`fk_rutina`)) ORDER BY `e`.`fecha` DESC LIMIT 0, 55  ;

-- --------------------------------------------------------

--
-- Structure for view `entrenamiento_rutina2`
--
DROP TABLE IF EXISTS `entrenamiento_rutina2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`` SQL SECURITY DEFINER VIEW `entrenamiento_rutina2`  AS SELECT `e`.`fecha` AS `fecha`, `r`.`nombre` AS `nombre` FROM (`entrenamiento` `e` join `rutina` `r` on(`r`.`id_rutina` = `e`.`fk_rutina`)) ORDER BY `e`.`fecha` AS `DESCdesc` ASC  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ejercicio`
--
ALTER TABLE `ejercicio`
  ADD PRIMARY KEY (`id_ejercicio`),
  ADD KEY `ejercicio_ibfk_1` (`fk_musculo`),
  ADD KEY `ejercicio_ibfk_2` (`fk_equipo`);

--
-- Indexes for table `entrenamiento`
--
ALTER TABLE `entrenamiento`
  ADD PRIMARY KEY (`id_entrenamiento`),
  ADD KEY `entrenamiento_ibfk_1` (`fk_usuario`),
  ADD KEY `entrenamiento_ibfk_2` (`fk_rutina`);

--
-- Indexes for table `equipo`
--
ALTER TABLE `equipo`
  ADD PRIMARY KEY (`id_equipo`);

--
-- Indexes for table `grupo_muscular`
--
ALTER TABLE `grupo_muscular`
  ADD PRIMARY KEY (`id_musculo`);

--
-- Indexes for table `realiza`
--
ALTER TABLE `realiza`
  ADD PRIMARY KEY (`id_ejercicio_rutina`),
  ADD KEY `realiza_ibfk_1` (`fk_ejercicio`),
  ADD KEY `realiza_ibfk_2` (`fk_rutina`);

--
-- Indexes for table `rutina`
--
ALTER TABLE `rutina`
  ADD PRIMARY KEY (`id_rutina`);

--
-- Indexes for table `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `tipo_usuario` (`tipo_usuario`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ejercicio`
--
ALTER TABLE `ejercicio`
  MODIFY `id_ejercicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `entrenamiento`
--
ALTER TABLE `entrenamiento`
  MODIFY `id_entrenamiento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `equipo`
--
ALTER TABLE `equipo`
  MODIFY `id_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `grupo_muscular`
--
ALTER TABLE `grupo_muscular`
  MODIFY `id_musculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `realiza`
--
ALTER TABLE `realiza`
  MODIFY `id_ejercicio_rutina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `rutina`
--
ALTER TABLE `rutina`
  MODIFY `id_rutina` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ejercicio`
--
ALTER TABLE `ejercicio`
  ADD CONSTRAINT `ejercicio_ibfk_1` FOREIGN KEY (`fk_musculo`) REFERENCES `grupo_muscular` (`id_musculo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ejercicio_ibfk_2` FOREIGN KEY (`fk_equipo`) REFERENCES `equipo` (`id_equipo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `entrenamiento`
--
ALTER TABLE `entrenamiento`
  ADD CONSTRAINT `entrenamiento_ibfk_1` FOREIGN KEY (`fk_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `entrenamiento_ibfk_2` FOREIGN KEY (`fk_rutina`) REFERENCES `rutina` (`id_rutina`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `realiza`
--
ALTER TABLE `realiza`
  ADD CONSTRAINT `realiza_ibfk_1` FOREIGN KEY (`fk_ejercicio`) REFERENCES `ejercicio` (`id_ejercicio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `realiza_ibfk_2` FOREIGN KEY (`fk_rutina`) REFERENCES `rutina` (`id_rutina`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`tipo_usuario`) REFERENCES `tipo_usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
