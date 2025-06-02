-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-09-2024 a las 18:47:29
-- Versión del servidor: 10.4.27-MariaDB
-- Versión de PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
drop database if exists texfashion;
create database texfashion;
use texfashion; 

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarFactura` (IN `p_idFactura` INT)   BEGIN
    -- Seleccionar información detallada de la factura con el id proporcionado
    SELECT *
    FROM facturas
    WHERE idFacturas = p_idFactura;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `Descripcion` (IN `p_Descripcion` VARCHAR(255))   BEGIN 
    SELECT *  FROM productos_terminados WHERE Descripcion = p_Descripcion;
END$$

--
-- Funciones
--
CREATE DEFINER=`root`@`localhost` FUNCTION `Total_ventas_por_mes` (`anio` INT, `mes` INT) RETURNS DECIMAL(12,2) DETERMINISTIC BEGIN
    DECLARE total DECIMAL(12,2) DEFAULT 0;

    SELECT SUM(Precio_Total) INTO total
    FROM facturas
    WHERE YEAR(Fecha_de_Emision) = anio
    AND MONTH(Fecha_de_Emision) = mes;

    RETURN total;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `acceder`
--

CREATE TABLE `acceder` (
  `ID_ACCESO` varchar(250) NOT NULL,
  `Documento` varchar(255) NOT NULL,
  `Usuario` varchar(255) NOT NULL,
  `Contraseña` varbinary(255) NOT NULL,
  `fecha_inicio` datetime DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `acceder`
--

INSERT INTO `acceder` (`ID_ACCESO`, `Documento`, `Usuario`, `Contraseña`, `fecha_inicio`, `ip_address`) VALUES
('1', '1234567899', 'JefeYer1_actualizado', 0xadb032b53b3f2a8c87773afca77bdcfd, '2024-08-22 07:12:10', '192.168.1.10'),
('2', '4567895123', 'Luna4', 0x0599197705eb25b6646b5e2a3b1ac3b8, '2024-08-22 07:12:10', '10.0.0.25'),
('3', '3456789021', 'MaríaEstela_562', 0x49f7be1b726b0a061bc496fe28982c3d1443ff086b51b478dd0061a54a3bcb79, '2024-08-22 07:12:10', '172.16.5.44'),
('4', '5678901234', 'DianaPA5687', 0xbb134756df78eecbcc5b4438c96eb8f9, '2024-08-22 07:12:10', '198.51.100.7'),
('5', '4567890123', 'Rubiela45._', 0x5c9784ad53cec4f0219b7d26c990d223, '2024-08-22 07:12:10', '203.0.113.55'),
('6', '6789012345', 'Hilda6H', 0xd3df85c49c966d59bcdfd15f23afb985, '2024-08-22 07:12:10', '192.168.10.75'),
('7', '7890123456', 'AnaLucia657', 0xbe01e0f0742066c546be7851e4ce9671, '2024-08-22 07:12:10', '10.1.2.33');

--
-- Disparadores `acceder`
--
DELIMITER $$
CREATE TRIGGER `after_delete_acceder` AFTER DELETE ON `acceder` FOR EACH ROW BEGIN
    INSERT INTO log_accesos (`Documento`, accion, detalles)
    VALUES (OLD.`Documento`, 'DELETE', CONCAT('Acceso eliminado. Usuario: ', OLD.Usuario));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_insert_acceder` AFTER INSERT ON `acceder` FOR EACH ROW BEGIN
    INSERT INTO log_accesos (`Documento`, accion, detalles)
    VALUES (NEW.`Documento`, 'INSERT', CONCAT('Nuevo acceso registrado. Usuario: ', NEW.Usuario, ', Fecha de inicio: ', NEW.fecha_inicio));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_acceder` AFTER UPDATE ON `acceder` FOR EACH ROW BEGIN
    INSERT INTO log_accesos (`Documento`, accion, detalles)
    VALUES (NEW.`Documento`, 'UPDATE', CONCAT('Acceso actualizado. Usuario: ', NEW.Usuario, ', Nueva contraseña: ', NEW.Contraseña));
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_actualizarContraseña` BEFORE UPDATE ON `acceder` FOR EACH ROW BEGIN
    IF NEW.Contraseña <> OLD.Contraseña THEN
        SET NEW.Contraseña = AES_ENCRYPT(NEW.Contraseña, 'clave2024');
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_delete_password` BEFORE DELETE ON `acceder` FOR EACH ROW BEGIN
    -- Aquí puedes agregar lógica adicional si es necesario
    -- Por ejemplo, registrar la eliminación en otro lugar
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `cifrar_contraseña` BEFORE INSERT ON `acceder` FOR EACH ROW BEGIN
    SET NEW.Contraseña = AES_ENCRYPT(NEW.Contraseña, 'clave2024');
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `idCategoria` int(11) NOT NULL,
  `Categoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idCategoria`, `Categoria`) VALUES
(1, 'Algodón'),
(2, 'Lana'),
(3, 'Seda'),
(4, 'Lino'),
(5, 'Poliéster'),
(6, 'Nylon'),
(7, 'Acrílico'),
(8, 'Rayón'),
(9, 'Algodón/Poliéster'),
(10, 'Lana/Acrílico'),
(11, 'Plástico'),
(12, 'Cuero'),
(13, 'Tejido Plano'),
(14, 'Tejido de Punto'),
(15, 'Tela para Ropa de Trabajo'),
(16, 'Tela para Moda'),
(17, 'Tela para Decoración');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_facturas`
--

CREATE TABLE `detalle_facturas` (
  `idDetalle` int(11) NOT NULL,
  `idFacturas` int(11) DEFAULT NULL,
  `Talla` varchar(50) DEFAULT NULL,
  `Informacion_Producto` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_facturas`
--

INSERT INTO `detalle_facturas` (`idDetalle`, `idFacturas`, `Talla`, `Informacion_Producto`) VALUES
(1, 1, 'M', 'Tapabocas con tela seda estampada de PeppaPig'),
(2, 2, 'S', 'Cofias material sinteticos azul'),
(3, 3, 'L', 'Tela Algodon perchado'),
(4, 4, 'M', 'Tela de cortina azul oscuro'),
(5, 5, 'L', 'Tela de cortina azul clarito');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento`
--

CREATE TABLE `documento` (
  `IdDocumento` int(11) NOT NULL,
  `TipoDocumento` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `documento`
--

INSERT INTO `documento` (`IdDocumento`, `TipoDocumento`) VALUES
(1, 'Cedula ciudadania'),
(2, 'cedula extranjera'),
(3, 'RUT');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados`
--

CREATE TABLE `estados` (
  `idEstados` int(11) NOT NULL,
  `Estados` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estados`
--

INSERT INTO `estados` (`idEstados`, `Estados`) VALUES
(1, 'Disponible'),
(2, 'No_Disponible'),
(3, 'Habilitada'),
(4, 'No_Habilitada'),
(5, 'Pagado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `idFacturas` int(11) NOT NULL,
  `Cantidad` int(11) DEFAULT NULL,
  `Informacion_del_Producto` int(11) DEFAULT NULL,
  `Fecha_de_Emision` date DEFAULT NULL,
  `Precio_Total` decimal(10,2) DEFAULT NULL,
  `Numero_Factura` varchar(255) DEFAULT NULL,
  `idCliente` varchar(250) DEFAULT NULL,
  `Direccion_Facturacion` varchar(255) DEFAULT NULL,
  `Estado_Factura` int(11) DEFAULT NULL,
  `Fecha_Pago` date DEFAULT NULL,
  `Referencia_Pago` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`idFacturas`, `Cantidad`, `Informacion_del_Producto`, `Fecha_de_Emision`, `Precio_Total`, `Numero_Factura`, `idCliente`, `Direccion_Facturacion`, `Estado_Factura`, `Fecha_Pago`, `Referencia_Pago`) VALUES
(1, 500, 1, '2024-08-01', '500000.00', 'F-1001', '0123456789', '95 Sur53 Cra.5a Este', 5, '2024-08-15', 'R-12345'),
(2, 300, 2, '2024-08-05', '450000.00', 'F-1002', '0123456789', 'Carrera 78 #14-25, Medellín', 5, NULL, NULL),
(3, 150, 3, '2024-08-10', '300000.00', 'F-1003', '0123456789', 'Avenida 3 #45-12, Cali', 5, '2024-08-20', 'R-12346'),
(4, 100, 4, '2024-08-12', '250000.00', 'F-1004', '0123456789', 'Calle 10 #20-30, Cartagena', 5, NULL, NULL),
(5, 200, 5, '2024-08-15', '600000.00', 'F-1005', '0123456789', 'Carrera 12 #34-56, Bucaramanga', 5, '2024-09-01', 'R-12347');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `log_accesos`
--

CREATE TABLE `log_accesos` (
  `id` varchar(250) NOT NULL,
  `Documento` varchar(255) DEFAULT NULL,
  `Accion` varchar(100) NOT NULL,
  `Detalles` text NOT NULL,
  `Usuario` varchar(255) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `log_accesos`
--

INSERT INTO `log_accesos` (`id`, `Documento`, `Accion`, `Detalles`, `Usuario`, `fecha`) VALUES
('', '1234567899', 'UPDATE', 'Acceso actualizado. Usuario: JefeYer1_actualizado, Nueva contraseña: ??2?;?*??w:??{??', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materia_prima`
--

CREATE TABLE `materia_prima` (
  `idProducto` int(11) NOT NULL,
  `Nombre` varchar(255) DEFAULT NULL,
  `Descripcion` text DEFAULT NULL,
  `Fecha_Ingreso` date DEFAULT NULL,
  `Precio_Unidad` decimal(10,2) DEFAULT NULL,
  `Cantidad_Stock` int(11) DEFAULT NULL,
  `id_Proveedor` varchar(250) DEFAULT NULL,
  `Categoria` int(11) DEFAULT NULL,
  `Unidad_Medida` int(11) DEFAULT NULL,
  `Fecha_Actualizacion` date DEFAULT NULL,
  `Estado` int(11) DEFAULT NULL,
  `status` varchar(5) NOT NULL DEFAULT 'IN'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materia_prima`
--

INSERT INTO `materia_prima` (`idProducto`, `Nombre`, `Descripcion`, `Fecha_Ingreso`, `Precio_Unidad`, `Cantidad_Stock`, `id_Proveedor`, `Categoria`, `Unidad_Medida`, `Fecha_Actualizacion`, `Estado`, `status`) VALUES
(1, 'Telas de algodón', 'Tela simple de algodón, son una pizca de amor', '2024-09-10', '400000.00', 56666, '3216549870', 1, 14, '2024-07-30', 1, 'OUT'),
(2, 'Mezclilla', 'Tela de mezclilla color azul', '2024-07-22', '7000.00', 800, '7891234561', 7, 9, '2024-07-31', 1, 'IN'),
(3, 'Cuero Sintentico', 'Material sintetico color negro', '2024-07-25', '12000.00', 500, '4567890132', 8, 10, '2024-08-01', 1, 'IN'),
(4, 'Seda', 'Tela de seda color rojo', '2024-07-27', '15000.00', 300, '4567890123', 7, 10, '2024-08-03', 1, 'IN'),
(5, 'Cuero Natural', 'Cuero natural color marron', '2024-07-30', '18000.00', 400, '3216549870', 8, 10, '2024-08-05', 1, 'IN'),
(6, 'Pruebas', 'Prueba en desarrollos', '2024-09-22', '3000.00', 4, '3216549870', 7, 13, NULL, 5, 'IN');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orden`
--

CREATE TABLE `orden` (
  `idOrden` int(11) NOT NULL,
  `idCliente` varchar(250) DEFAULT NULL,
  `Fecha_Orden` date DEFAULT NULL,
  `Total_Total` decimal(10,2) DEFAULT NULL,
  `Cantidad_Producto` int(11) DEFAULT NULL,
  `Fecha_Entrega` date DEFAULT NULL,
  `idProductosTerminados` int(11) DEFAULT NULL,
  `idMateriaPrima` int(11) DEFAULT NULL,
  `Estado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `orden`
--

INSERT INTO `orden` (`idOrden`, `idCliente`, `Fecha_Orden`, `Total_Total`, `Cantidad_Producto`, `Fecha_Entrega`, `idProductosTerminados`, `idMateriaPrima`, `Estado`) VALUES
(4, '1234567809', '2024-08-12', '250000.00', 100, '2024-08-30', 4, 2, 4),
(5, '2345678910', '2024-08-15', '3000000.00', 200, '2024-09-01', 5, 3, 3),
(18, '4567891231', '2024-08-01', '100000.00', 400, '2024-09-25', 1, 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `produccion`
--

CREATE TABLE `produccion` (
  `ID_Produccion` int(11) NOT NULL,
  `ID_Producto` int(11) DEFAULT NULL,
  `ID_MateriaPrima` int(11) DEFAULT NULL,
  `Cantidad_Usada` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `produccion`
--

INSERT INTO `produccion` (`ID_Produccion`, `ID_Producto`, `ID_MateriaPrima`, `Cantidad_Usada`) VALUES
(1, 1, 1, 50),
(2, 2, 2, 30),
(3, 3, 3, 70),
(4, 4, 4, 20),
(5, 5, 5, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_terminados`
--

CREATE TABLE `productos_terminados` (
  `idProductos` int(11) NOT NULL,
  `Nombre_Producto` varchar(255) DEFAULT NULL,
  `Cantidad_Disponible` int(11) DEFAULT NULL,
  `Descripcion` text DEFAULT NULL,
  `Fecha_Entrada` date DEFAULT NULL,
  `Fecha_Salida` date DEFAULT NULL,
  `idmateria_prima` int(11) DEFAULT NULL,
  `idEstado` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos_terminados`
--

INSERT INTO `productos_terminados` (`idProductos`, `Nombre_Producto`, `Cantidad_Disponible`, `Descripcion`, `Fecha_Entrada`, `Fecha_Salida`, `idmateria_prima`, `idEstado`) VALUES
(1, 'Tapabocas', 500, 'Tapabocas con tela seda estampada de PeppaPig', '2024-08-15', '2024-08-15', 1, 1),
(2, 'Cofias', 300, 'Cofias material sinteticos azul', '2024-08-20', '2024-08-20', 2, 1),
(3, 'ChaquetaProm', 150, 'Tela Algodon perchado', '2024-08-10', '2024-08-25', 3, 2),
(4, 'Uniforme Vigilante', 50, 'Tela de cortina azul oscuro', '2024-08-12', '2024-08-30', 4, 1),
(5, 'Uniforme enfermeria', 55, 'Tela de cortina azul clarito', '2024-08-15', '2024-09-01', 5, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idRol` int(11) NOT NULL,
  `Rol` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idRol`, `Rol`) VALUES
(1, 'Confeccionista'),
(2, 'Administrador'),
(3, 'Jefe de bodega'),
(4, 'Cliente'),
(5, 'Proveedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `unidadmedida`
--

CREATE TABLE `unidadmedida` (
  `MedidaID` int(11) NOT NULL,
  `Uni_Med` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `unidadmedida`
--

INSERT INTO `unidadmedida` (`MedidaID`, `Uni_Med`) VALUES
(1, 'Metros'),
(2, 'Centímetros'),
(3, 'Pulgadas'),
(4, 'Yardas'),
(5, 'Gramos'),
(6, 'Kilogramos'),
(7, 'Onzas'),
(8, 'Libras'),
(9, 'Hilos por pulgada'),
(10, 'Densidad'),
(11, 'Anchos de tela'),
(12, 'Número de rosca'),
(13, 'Denier'),
(14, 'Tex'),
(15, 'Sacos'),
(16, 'Bobinas'),
(17, 'Rollos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `Documento` varchar(255) NOT NULL,
  `Nombre_Usuario` varchar(255) DEFAULT NULL,
  `Apellidos` varchar(255) DEFAULT NULL,
  `Fecha_Nacimiento` date DEFAULT NULL,
  `Direccion_Usuario` varchar(255) DEFAULT NULL,
  `Telefono` varchar(50) DEFAULT NULL,
  `Rol` int(11) DEFAULT NULL,
  `TipoDoc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`Documento`, `Nombre_Usuario`, `Apellidos`, `Fecha_Nacimiento`, `Direccion_Usuario`, `Telefono`, `Rol`, `TipoDoc`) VALUES
('0123456789', 'Antonio', 'Jimenez Ortega', '1980-05-22', 'Carrera 2 # 12-38, Bogotá D.C., Colombia.', '3267890123', 4, 1),
('1234567809', 'Sofia', 'Moreno Alvarez', '1993-08-04', 'Calle 130 # 90-10, Bogotá D.C., Colombia.', '3278901234', 4, 1),
('1234567899', 'Yeary', 'Vargas Calderon', '1985-06-15', 'Calle 45 #23-56, Bogotá.', '3123456789', 2, 1),
('2345678901', 'Ana', 'Martinez Lopez', '1985-04-12', 'Carrera 7 # 27-20, Bogotá D.C., Colombia.', '3189012345', 4, 1),
('2345678910', 'Carlos', 'Vazquez Fernandez', '1986-03-09', 'Carrera 7 # 115-20, Bogotá D.C., Colombia.', '3289012345', 4, 1),
('3216549870', 'Fatisyet', 'Null', '1990-02-14', 'Transversal 5 #15-20, Barranquilla.', '3115391787', 5, 3),
('3456789012', 'Luis', 'Garcia Fernandez', '1990-07-24', 'Avenida el Poblado # 1A-45, Medellín, Antioqua.', '3201234567', 4, 1),
('3456789021', 'Maria Estela', 'Calderon', '1975-03-05', 'Carrera 78 #14-25, Medellín.', '3145678901', 1, 1),
('4567890123', 'Rubiela', 'Forero', '1985-12-25', 'Carrera 12 #34-56, Bucaramanga.', '3167890123', 5, 1),
('4567890132', 'Grupo STone', 'Null', '1992-11-30', 'Calle 10 #20-30, Cartagena.', '3209062693', 5, 3),
('4567891231', 'Maria', 'Romero', '1983-01-17', 'Calle 5 # 6-23, Cali, Valle del Cauca, Colombia.', '3223456789', 4, 1),
('4567895123', 'Luna', 'Camacho Vargas', '1990-08-22', 'Carrera 78 #14-25, Medellín', '313 456 7890', 1, 1),
('5678901234', 'Diana Paola', 'Rodriguez Sanchez', '1982-10-05', 'Carrera 10 #10-10, Cali.', '3178901234', 1, 1),
('6543219870', 'Textilia', 'NULL', '1978-01-19', 'Carrera 12 #34-56, Bucaramanga.', '3234567890', 4, 1),
('6789012345', 'Hilda', 'Hernandez Morales', '1978-12-01', 'Diagonal 6 #20-25, Cartagena.', '3189012345', 2, 1),
('6789012354', 'Laura', 'NULL', '1995-06-11', 'Calle 22 #45-78, Barranquilla.', '31343336923', 4, 1),
('7890123456', 'Ana Luncia', 'NULL', '1992-07-04', 'Calle 26 # 13-19, Bogotá D.C., Colombia.', '3245678901', 4, 1),
('7891234561', 'Megacaps', 'Null', '1988-09-30', 'Avenida del Libertador 789, Bucaramanga.', '3256789012', 5, 3),
('8901234567', 'Pumotex', 'NULL', '1992-12-15', 'Carrera 13 # 82-22, Bogotá D.C., Colombia.', '3014387768', 5, 3),
('9012345678', 'David', 'NULL', '1992-12-15', 'Carrera 13 # 82-22, Bogotá D.C., Colombia.', '3256789012', 4, 1),
('9876543210', 'Elena', 'NULL', '1975-11-30', 'Avenida Siempre Viva 456, Medellín.', '3256789012', 3, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `acceder`
--
ALTER TABLE `acceder`
  ADD PRIMARY KEY (`ID_ACCESO`),
  ADD KEY `fk_usuario_Acceder` (`Documento`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `detalle_facturas`
--
ALTER TABLE `detalle_facturas`
  ADD PRIMARY KEY (`idDetalle`),
  ADD KEY `idFacturas` (`idFacturas`);

--
-- Indices de la tabla `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`IdDocumento`);

--
-- Indices de la tabla `estados`
--
ALTER TABLE `estados`
  ADD PRIMARY KEY (`idEstados`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`idFacturas`),
  ADD KEY `FK_AD_LK` (`Estado_Factura`),
  ADD KEY `FK_FACTURAS_DF` (`Informacion_del_Producto`),
  ADD KEY `FK_USU_CLI` (`idCliente`);

--
-- Indices de la tabla `log_accesos`
--
ALTER TABLE `log_accesos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `materia_prima`
--
ALTER TABLE `materia_prima`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `FK_MP_EST` (`Estado`),
  ADD KEY `fk_provedor_mp` (`id_Proveedor`),
  ADD KEY `fk_cat_est` (`Categoria`),
  ADD KEY `fk_um_est` (`Unidad_Medida`);

--
-- Indices de la tabla `orden`
--
ALTER TABLE `orden`
  ADD PRIMARY KEY (`idOrden`),
  ADD KEY `idProductosTerminados` (`idProductosTerminados`),
  ADD KEY `idMateriaPrima` (`idMateriaPrima`),
  ADD KEY `FK_ORDEN_CLIENTE` (`idCliente`),
  ADD KEY `FK_ORD_ESTA` (`Estado`);

--
-- Indices de la tabla `produccion`
--
ALTER TABLE `produccion`
  ADD PRIMARY KEY (`ID_Produccion`),
  ADD KEY `ID_Producto` (`ID_Producto`),
  ADD KEY `ID_MateriaPrima` (`ID_MateriaPrima`);

--
-- Indices de la tabla `productos_terminados`
--
ALTER TABLE `productos_terminados`
  ADD PRIMARY KEY (`idProductos`),
  ADD KEY `idEstado` (`idEstado`),
  ADD KEY `FK_PT_MP` (`idmateria_prima`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idRol`);

--
-- Indices de la tabla `unidadmedida`
--
ALTER TABLE `unidadmedida`
  ADD PRIMARY KEY (`MedidaID`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Documento`),
  ADD KEY `Rol` (`Rol`),
  ADD KEY `FK_USU_DOC` (`TipoDoc`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de la tabla `detalle_facturas`
--
ALTER TABLE `detalle_facturas`
  MODIFY `idDetalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `documento`
--
ALTER TABLE `documento`
  MODIFY `IdDocumento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `estados`
--
ALTER TABLE `estados`
  MODIFY `idEstados` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `idFacturas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `materia_prima`
--
ALTER TABLE `materia_prima`
  MODIFY `idProducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `orden`
--
ALTER TABLE `orden`
  MODIFY `idOrden` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `produccion`
--
ALTER TABLE `produccion`
  MODIFY `ID_Produccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `productos_terminados`
--
ALTER TABLE `productos_terminados`
  MODIFY `idProductos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `unidadmedida`
--
ALTER TABLE `unidadmedida`
  MODIFY `MedidaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `acceder`
--
ALTER TABLE `acceder`
  ADD CONSTRAINT `fk_usuario_Acceder` FOREIGN KEY (`Documento`) REFERENCES `usuario` (`Documento`);

--
-- Filtros para la tabla `detalle_facturas`
--
ALTER TABLE `detalle_facturas`
  ADD CONSTRAINT `detalle_facturas_ibfk_1` FOREIGN KEY (`idFacturas`) REFERENCES `facturas` (`idFacturas`);

--
-- Filtros para la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD CONSTRAINT `FK_FACTURAS_ESTADOS` FOREIGN KEY (`Estado_Factura`) REFERENCES `estados` (`idEstados`),
  ADD CONSTRAINT `FK_USU_CLI` FOREIGN KEY (`idCliente`) REFERENCES `usuario` (`Documento`),
  ADD CONSTRAINT `fk_info_prod` FOREIGN KEY (`Informacion_del_Producto`) REFERENCES `productos_terminados` (`idProductos`);

--
-- Filtros para la tabla `materia_prima`
--
ALTER TABLE `materia_prima`
  ADD CONSTRAINT `FK_CATEGORIA` FOREIGN KEY (`Categoria`) REFERENCES `categorias` (`idCategoria`),
  ADD CONSTRAINT `FK_MP_EST` FOREIGN KEY (`Estado`) REFERENCES `estados` (`idEstados`),
  ADD CONSTRAINT `FK_UNIDADMEDIDA` FOREIGN KEY (`Unidad_Medida`) REFERENCES `unidadmedida` (`MedidaID`),
  ADD CONSTRAINT `fk_provedor_mp` FOREIGN KEY (`id_Proveedor`) REFERENCES `usuario` (`Documento`);

--
-- Filtros para la tabla `orden`
--
ALTER TABLE `orden`
  ADD CONSTRAINT `FK_MP_ORDEN` FOREIGN KEY (`idMateriaPrima`) REFERENCES `materia_prima` (`idProducto`),
  ADD CONSTRAINT `FK_ORDEN_CLIENTE` FOREIGN KEY (`idCliente`) REFERENCES `usuario` (`Documento`),
  ADD CONSTRAINT `FK_ORDEN_PT` FOREIGN KEY (`idProductosTerminados`) REFERENCES `productos_terminados` (`idProductos`),
  ADD CONSTRAINT `FK_ORD_ESTA` FOREIGN KEY (`Estado`) REFERENCES `estados` (`idEstados`);

--
-- Filtros para la tabla `produccion`
--
ALTER TABLE `produccion`
  ADD CONSTRAINT `FK_PRODUCTO_PT` FOREIGN KEY (`ID_Producto`) REFERENCES `productos_terminados` (`idProductos`),
  ADD CONSTRAINT `FK_PRODUCTO_mp` FOREIGN KEY (`ID_MateriaPrima`) REFERENCES `materia_prima` (`idProducto`);

--
-- Filtros para la tabla `productos_terminados`
--
ALTER TABLE `productos_terminados`
  ADD CONSTRAINT `FK_ORDEN_EST` FOREIGN KEY (`idEstado`) REFERENCES `estados` (`idEstados`),
  ADD CONSTRAINT `FK_PT_MP` FOREIGN KEY (`idmateria_prima`) REFERENCES `materia_prima` (`idProducto`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `FK_USU_DOC` FOREIGN KEY (`TipoDoc`) REFERENCES `documento` (`IdDocumento`),
  ADD CONSTRAINT `FK_USU_ROL` FOREIGN KEY (`Rol`) REFERENCES `rol` (`idRol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
