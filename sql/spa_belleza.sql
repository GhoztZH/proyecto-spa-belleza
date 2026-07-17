-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2026 at 12:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spa_belleza`
--
CREATE DATABASE IF NOT EXISTS `spa_belleza` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `spa_belleza`;


-- --------------------------------------------------------

--
-- Table: categorias_producto
-- Almacena las categorías a las que pertenecen los productos.
--

CREATE TABLE `categorias_producto` (
  `id_categoria_producto` int(11) NOT NULL,
  `nombre_categoria` varchar(100) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categorias_producto`
--

INSERT INTO `categorias_producto` (`id_categoria_producto`, `nombre_categoria`, `descripcion`, `estado`) VALUES
(1, 'Cabello', 'Shampoo, acondicionadores y tratamientos capilares', 1),
(2, 'Facial', 'Productos para limpieza e hidratación facial', 1),
(3, 'Corporal', 'Cremas, exfoliantes y aceites corporales', 1),
(4, 'Masajes', 'Aceites y productos para terapias de masaje', 1),
(5, 'Maquillaje', 'Productos cosméticos y belleza', 1);

-- --------------------------------------------------------

--
-- Table: categorias_servicio
-- Clasifica los servicios ofrecidos por el spa.
--

CREATE TABLE `categorias_servicio` (
  `id_categoria_servicio` int(11) NOT NULL,
  `nombre_categoria` varchar(100) NOT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categorias_servicio`
--

INSERT INTO `categorias_servicio` (`id_categoria_servicio`, `nombre_categoria`, `descripcion`, `estado`) VALUES
(1, 'Servicios', 'Servicios generales de spa y belleza', 1),
(2, 'Tratamientos', 'Tratamientos especializados de belleza', 1);

-- --------------------------------------------------------

--
-- Table: citas
-- Registra las citas agendadas por los clientes para un servicio.
--

CREATE TABLE `citas` (
  `id_cita` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_empleado` int(11) DEFAULT NULL,
  `id_servicio` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `estado` enum('Pendiente','Atendida','Cancelada') NOT NULL DEFAULT 'Pendiente',
  `observacion` varchar(255) DEFAULT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `citas`
--

INSERT INTO `citas` (`id_cita`, `id_cliente`, `id_empleado`, `id_servicio`, `fecha`, `hora`, `estado`, `observacion`, `fecha_registro`) VALUES
(1, 1, NULL, 1, '2026-07-24', '16:28:00', 'Pendiente', NULL, '2026-07-17 16:28:29');

-- --------------------------------------------------------

--
-- Table: clientes
-- Identifica a los usuarios que poseen el rol de cliente.
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `id_usuario`) VALUES
(1, 5);

-- --------------------------------------------------------

--
-- Table: compras
-- Almacena el encabezado de cada compra realizada por un cliente.
--

CREATE TABLE `compras` (
  `id_compra` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `estado` enum('Pagada','Cancelada') NOT NULL DEFAULT 'Pagada'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `compras`
--

INSERT INTO `compras` (`id_compra`, `id_usuario`, `fecha`, `total`, `estado`) VALUES
(1, 5, '2026-07-17 17:48:34', 18.50, 'Pagada');

-- --------------------------------------------------------

--
-- Table: detalle_compra
-- Guarda los productos incluidos en cada compra y sus cantidades.
--

CREATE TABLE `detalle_compra` (
  `id_detalle` int(11) NOT NULL,
  `id_compra` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detalle_compra`
--

INSERT INTO `detalle_compra` (`id_detalle`, `id_compra`, `id_producto`, `cantidad`, `precio_unitario`, `subtotal`) VALUES
(1, 1, 5, 1, 11.00, 11.00),
(2, 1, 6, 1, 7.50, 7.50);

-- --------------------------------------------------------

--
-- Table: empleados
-- Identifica a los usuarios que trabajan como empleados del spa.
--

CREATE TABLE `empleados` (
  `id_empleado` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `cargo` varchar(80) NOT NULL,
  `fecha_ingreso` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `empleados`
--

INSERT INTO `empleados` (`id_empleado`, `id_usuario`, `cargo`, `fecha_ingreso`) VALUES
(1, 1, 'Administrador General', '2026-01-15'),
(2, 2, 'Cosmetóloga', '2026-02-01'),
(3, 3, 'Estilista', '2026-02-15'),
(4, 4, 'Masajista Terapéutico', '2026-03-01');

-- --------------------------------------------------------

--
-- Table: productos
-- Contiene el catálogo de productos disponibles para la venta.
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `id_categoria_producto` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `disponibilidad` tinyint(1) NOT NULL DEFAULT 1,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id_producto`, `id_categoria_producto`, `nombre`, `descripcion`, `precio`, `stock`, `disponibilidad`, `imagen`) VALUES
(1, 1, 'Shampoo Nutritivo 400ml', 'Shampoo con keratina para cabello dañado', 8.50, 40, 1, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRC5DcOtqMvp0h0ZrPq4My3SgOsnl3iGVAqH0BZMO2qo1vGxF7u5xUpuQhT&s=10'),
(2, 1, 'Acondicionador Reparador 400ml', 'Acondicionador hidratante para cabello seco', 8.50, 35, 1, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRaZZtlppnzsK-AnbfrfsBUhTDD_PY2OFhl5CjxvEGLGld_AhK_w2wkFciS&s=10'),
(3, 2, 'Crema Facial Hidratante', 'Crema facial con ácido hialurónico', 14.00, 25, 1, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRcRP57e2mEtKAl9kARz7fzClWf61MwkU7CjjMlFixcoCzdLKHT5oL4fw0&s=10'),
(4, 2, 'Limpiador Facial Espuma', 'Gel limpiador para todo tipo de piel', 9.90, 30, 1, 'https://dermashop.ec/web/image/product.template/351/image_1024?unique=5a5e280'),
(5, 3, 'Aceite Corporal Relajante', 'Aceite corporal para masajes', 11.00, 19, 1, 'https://www.gloriasaltos.com/wp-content/uploads/2025/01/136969.jpg'),
(6, 4, 'Aceite Esencial de Lavanda', 'Aceite esencial para aromaterapia', 7.50, 29, 1, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRbJ9UN5-W-IHHXiCHFE8LPNVb-lgxvmzYHYoFM75p6jHuXIA8U-d5bE9iz&s=10'),
(7, 5, 'Labial Mate Larga Duración', 'Labial mate en tono rosa nude', 6.00, 50, 1, 'https://cloudinary.images-iherb.com/image/upload/f_auto,q_auto:eco/images/wnw/wnw59252/y/54.jpg');

-- --------------------------------------------------------

--
-- Table: roles
-- Define los roles del sistema para controlar los permisos de acceso.
--

CREATE TABLE `roles` (
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id_rol`, `nombre`) VALUES
(1, 'Administrador'),
(3, 'Cliente'),
(2, 'Colaborador');

-- --------------------------------------------------------

--
-- Table: servicios
-- Almacena los servicios que ofrece el spa junto con su costo y duración.
--

CREATE TABLE `servicios` (
  `id_servicio` int(11) NOT NULL,
  `id_categoria_servicio` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `disponibilidad` tinyint(1) NOT NULL DEFAULT 1,
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `servicios`
--

INSERT INTO `servicios` (`id_servicio`, `id_categoria_servicio`, `nombre`, `descripcion`, `precio`, `disponibilidad`, `imagen`) VALUES
(1, 1, 'Manicure clásico', 'Cuidado y esmaltado de uñas de manos', 12.00, 1, 'assets/img/servicios/servicio_124376e84e0b80c4.jpg'),
(2, 1, 'Pedicure spa', 'Cuidado completo de pies con exfoliación', 15.00, 1, 'assets/img/servicios/servicio_02a486c7b90a8012.jpg'),
(3, 1, 'Corte de cabello', 'Corte y peinado profesional', 10.00, 0, 'assets/img/servicios/servicio_be59ef365bca6179.jpg'),
(4, 1, 'Masaje relajante', 'Masaje corporal de 50 minutos', 35.00, 1, 'assets/img/servicios/servicio_ce5f2a7567da7d75.jpg'),
(5, 2, 'Tratamiento facial hidratante', 'Limpieza profunda e hidratación facial', 25.00, 1, 'assets/img/servicios/servicio_8ce0c215dbf9630e.jpg'),
(6, 2, 'Tratamiento capilar reparador', 'Restauración capilar con keratina', 30.00, 1, 'assets/img/servicios/servicio_72f4c5a64d7ab0e2.jpg'),
(7, 2, 'Depilación con laser', 'Depilación corporal con cera tibia', 18.00, 0, 'assets/img/servicios/servicio_a2c1e26e6216f4b0.jpg');

-- --------------------------------------------------------

--
-- Table: usuarios
-- Guarda la información de acceso y datos personales de los usuarios del sistema.
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `id_rol` int(11) NOT NULL,
  `nombre` varchar(80) NOT NULL,
  `apellido` varchar(80) NOT NULL,
  `correo` varchar(120) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT 1,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `id_rol`, `nombre`, `apellido`, `correo`, `celular`, `username`, `password`, `estado`, `fecha_creacion`) VALUES
(1, 1, 'Carlos', 'Mendoza', 'admin@spabelleza.com', '0999999999', 'admin', '$2y$10$XSC0ZW4GCnByfKb4j1xOUeAJjcjh2kxjvP2DofpH6MD1VrV0vUx5y', 1, '2026-07-17 19:34:18'),
(2, 2, 'Valeria', 'Rojas', 'valeria.rojas@deluxspa.com', '0987111222', 'vrojas', '$2y$10$mgUZBQqTkXSqKMV1lExpbOdGjrwfPzOsAnXdkLWxu/0PUNjKEka5a', 1, '2026-07-17 19:34:18'),
(3, 2, 'Daniela', 'Paredes', 'daniela.paredes@deluxspa.com', '0987333444', 'dparedes', '$2y$10$mgUZBQqTkXSqKMV1lExpbOdGjrwfPzOsAnXdkLWxu/0PUNjKEka5a', 1, '2026-07-17 19:34:18'),
(4, 2, 'Jose', 'Salazar', 'andres.jose@gmail.com', '0987555666', 'asalazar', '$2y$10$mgUZBQqTkXSqKMV1lExpbOdGjrwfPzOsAnXdkLWxu/0PUNjKEka5a', 0, '2026-07-17 19:34:18'),
(5, 3, 'leodan', 'zhunaula', 'leodanzh@gmail.com', '0991231223', 'kevinzh', '$2y$10$hlVc//ZF5cGYeMlgDrYpY.h.szXvJ1N2YNnpSpdhybWRNPaUUMOaq', 1, '2026-07-17 21:24:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorias_producto`
--
ALTER TABLE `categorias_producto`
  ADD PRIMARY KEY (`id_categoria_producto`),
  ADD UNIQUE KEY `nombre_categoria` (`nombre_categoria`);

--
-- Indexes for table `categorias_servicio`
--
ALTER TABLE `categorias_servicio`
  ADD PRIMARY KEY (`id_categoria_servicio`),
  ADD UNIQUE KEY `nombre_categoria` (`nombre_categoria`);

--
-- Indexes for table `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id_cita`),
  ADD KEY `idx_citas_cliente` (`id_cliente`),
  ADD KEY `idx_citas_empleado` (`id_empleado`),
  ADD KEY `idx_citas_servicio` (`id_servicio`),
  ADD KEY `idx_citas_fecha` (`fecha`);

--
-- Indexes for table `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id_compra`),
  ADD KEY `idx_compras_usuario` (`id_usuario`);

--
-- Indexes for table `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `idx_detalle_compra_compra` (`id_compra`),
  ADD KEY `idx_detalle_compra_producto` (`id_producto`);

--
-- Indexes for table `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`id_empleado`),
  ADD UNIQUE KEY `id_usuario` (`id_usuario`);

--
-- Indexes for table `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `idx_productos_categoria` (`id_categoria_producto`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_rol`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indexes for table `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id_servicio`),
  ADD KEY `idx_servicios_categoria` (`id_categoria_servicio`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `idx_usuarios_rol` (`id_rol`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorias_producto`
--
ALTER TABLE `categorias_producto`
  MODIFY `id_categoria_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categorias_servicio`
--
ALTER TABLE `categorias_servicio`
  MODIFY `id_categoria_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `citas`
--
ALTER TABLE `citas`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `compras`
--
ALTER TABLE `compras`
  MODIFY `id_compra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `detalle_compra`
--
ALTER TABLE `detalle_compra`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `empleados`
--
ALTER TABLE `empleados`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id_rol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `fk_citas_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_citas_empleado` FOREIGN KEY (`id_empleado`) REFERENCES `empleados` (`id_empleado`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_citas_servicio` FOREIGN KEY (`id_servicio`) REFERENCES `servicios` (`id_servicio`) ON UPDATE CASCADE;

--
-- Constraints for table `clientes`
--
ALTER TABLE `clientes`
  ADD CONSTRAINT `fk_clientes_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `fk_compras_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON UPDATE CASCADE;

--
-- Constraints for table `detalle_compra`
--
ALTER TABLE `detalle_compra`
  ADD CONSTRAINT `fk_detalle_compra_compra` FOREIGN KEY (`id_compra`) REFERENCES `compras` (`id_compra`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detalle_compra_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`) ON UPDATE CASCADE;

--
-- Constraints for table `empleados`
--
ALTER TABLE `empleados`
  ADD CONSTRAINT `fk_empleados_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_categoria` FOREIGN KEY (`id_categoria_producto`) REFERENCES `categorias_producto` (`id_categoria_producto`) ON UPDATE CASCADE;

--
-- Constraints for table `servicios`
--
ALTER TABLE `servicios`
  ADD CONSTRAINT `fk_servicios_categoria` FOREIGN KEY (`id_categoria_servicio`) REFERENCES `categorias_servicio` (`id_categoria_servicio`) ON UPDATE CASCADE;

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `fk_usuarios_rol` FOREIGN KEY (`id_rol`) REFERENCES `roles` (`id_rol`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
