-- =========================================================================
-- BASE DE DATOS: CENTRO DE BELLEZA Y SPA
-- Motor: MariaDB / MySQL
-- Descripción: Modelo relacional normalizado (3FN) para gestión de
--              usuarios, roles, empleados, clientes, servicios,
--              productos, citas y ventas.
-- =========================================================================

CREATE DATABASE IF NOT EXISTS spa_belleza
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE spa_belleza;

-- =========================================================================
-- TABLA: roles
-- Propósito: Catálogo fijo de los roles del sistema (Administrador,
--            Colaborador Spa, Cliente). No tiene CRUD; se puebla por seed.
-- Relación:  Es referenciada por la tabla usuarios (1 rol -> N usuarios).
-- =========================================================================
CREATE TABLE roles (
    id_rol      INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol  VARCHAR(50)  NOT NULL UNIQUE,
    descripcion VARCHAR(150) NULL
) ENGINE=InnoDB;

-- =========================================================================
-- TABLA: usuarios
-- Propósito: Tabla única de autenticación para TODOS los tipos de usuario
--            (administradores, colaboradores spa y clientes).
-- Relación:  FK hacia roles. Es referenciada 1:1 por empleados y clientes.
-- =========================================================================
CREATE TABLE usuarios (
    id_usuario     INT AUTO_INCREMENT PRIMARY KEY,
    id_rol         INT NOT NULL,
    nombre         VARCHAR(100) NOT NULL,
    correo         VARCHAR(150) NOT NULL UNIQUE,
    contrasena     VARCHAR(255) NOT NULL,
    telefono       VARCHAR(15)  NULL,
    estado         TINYINT(1)   NOT NULL DEFAULT 1,
    fecha_registro DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_usuarios_rol
        FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE INDEX idx_usuarios_rol ON usuarios(id_rol);

-- =========================================================================
-- TABLA: empleados
-- Propósito: Datos propios del personal interno del spa (no de contacto,
--            eso vive en usuarios). CRUD gestionado por el Administrador.
-- Relación:  FK 1:1 hacia usuarios. Es referenciada por citas
--            (colaborador asignado).
-- =========================================================================
CREATE TABLE empleados (
    id_empleado         INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario          INT NOT NULL UNIQUE,
    cedula              VARCHAR(20)  NOT NULL UNIQUE,
    cargo               VARCHAR(100) NOT NULL,
    direccion           VARCHAR(200) NULL,
    fecha_contratacion  DATE NOT NULL,
    estado              TINYINT(1)   NOT NULL DEFAULT 1,
    CONSTRAINT fk_empleados_usuario
        FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

-- =========================================================================
-- TABLA: clientes
-- Propósito: Datos propios del cliente (no de contacto, eso vive en
--            usuarios). Permite registro, edición de perfil, citas y compras.
-- Relación:  FK 1:1 hacia usuarios. Es referenciada por citas y ventas.
-- =========================================================================
CREATE TABLE clientes (
    id_cliente        INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario        INT NOT NULL UNIQUE,
    direccion         VARCHAR(200) NULL,
    fecha_nacimiento  DATE NULL,
    genero            ENUM('Masculino','Femenino','Otro') NULL,
    estado            TINYINT(1)   NOT NULL DEFAULT 1,
    observaciones     VARCHAR(255) NULL,
    CONSTRAINT fk_clientes_usuario
        FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

-- =========================================================================
-- TABLA: categorias_servicio
-- Propósito: Clasificación de los servicios del spa (catálogo de apoyo).
-- Relación:  Es referenciada por servicios (1 categoría -> N servicios).
-- =========================================================================
CREATE TABLE categorias_servicio (
    id_categoria_servicio INT AUTO_INCREMENT PRIMARY KEY,
    nombre_categoria      VARCHAR(100) NOT NULL UNIQUE,
    descripcion           VARCHAR(200) NULL,
    estado                TINYINT(1)   NOT NULL DEFAULT 1
) ENGINE=InnoDB;

-- =========================================================================
-- TABLA: servicios
-- Propósito: Catálogo de servicios ofrecidos por el spa (mostrados en
--            tarjetas/cards). CRUD gestionado por el Administrador.
-- Relación:  FK hacia categorias_servicio. Es referenciada por citas.
-- =========================================================================
CREATE TABLE servicios (
    id_servicio            INT AUTO_INCREMENT PRIMARY KEY,
    id_categoria_servicio  INT NOT NULL,
    nombre                 VARCHAR(100) NOT NULL,
    descripcion            TEXT NULL,
    precio                 DECIMAL(10,2) NOT NULL,
    disponibilidad         TINYINT(1) NOT NULL DEFAULT 1,
    imagen                 VARCHAR(255) NULL,
    CONSTRAINT fk_servicios_categoria
        FOREIGN KEY (id_categoria_servicio) REFERENCES categorias_servicio(id_categoria_servicio)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE INDEX idx_servicios_categoria ON servicios(id_categoria_servicio);

-- =========================================================================
-- TABLA: categorias_producto
-- Propósito: Clasificación de los productos a la venta (catálogo de apoyo).
-- Relación:  Es referenciada por productos (1 categoría -> N productos).
-- =========================================================================
CREATE TABLE categorias_producto (
    id_categoria_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre_categoria      VARCHAR(100) NOT NULL UNIQUE,
    descripcion           VARCHAR(200) NULL,
    estado                TINYINT(1)   NOT NULL DEFAULT 1
) ENGINE=InnoDB;

-- =========================================================================
-- TABLA: productos
-- Propósito: Catálogo de productos que se venden en el spa. CRUD
--            gestionado por el Administrador.
-- Relación:  FK hacia categorias_producto. Es referenciada por detalle_venta.
-- =========================================================================
CREATE TABLE productos (
    id_producto            INT AUTO_INCREMENT PRIMARY KEY,
    id_categoria_producto  INT NOT NULL,
    nombre                 VARCHAR(100) NOT NULL,
    descripcion            TEXT NULL,
    precio                 DECIMAL(10,2) NOT NULL,
    stock                  INT NOT NULL DEFAULT 0,
    disponibilidad         TINYINT(1) NOT NULL DEFAULT 1,
    imagen                 VARCHAR(255) NULL,
    CONSTRAINT fk_productos_categoria
        FOREIGN KEY (id_categoria_producto) REFERENCES categorias_producto(id_categoria_producto)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE INDEX idx_productos_categoria ON productos(id_categoria_producto);

-- =========================================================================
-- TABLA: citas
-- Propósito: Agenda de citas. El cliente elige servicio, fecha y hora;
--            el Administrador asigna posteriormente al colaborador.
--            El colaborador solo actualiza estado y observación.
-- Relación:  FK hacia clientes, empleados (nullable) y servicios.
-- =========================================================================
CREATE TABLE citas (
    id_cita        INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente     INT NOT NULL,
    id_empleado    INT NULL,
    id_servicio    INT NOT NULL,
    fecha          DATE NOT NULL,
    hora           TIME NOT NULL,
    estado         ENUM('Pendiente','Atendida','Cancelada') NOT NULL DEFAULT 'Pendiente',
    observacion    VARCHAR(255) NULL,
    fecha_registro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_citas_cliente
        FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_citas_empleado
        FOREIGN KEY (id_empleado) REFERENCES empleados(id_empleado)
        ON UPDATE CASCADE ON DELETE SET NULL,
    CONSTRAINT fk_citas_servicio
        FOREIGN KEY (id_servicio) REFERENCES servicios(id_servicio)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE INDEX idx_citas_cliente  ON citas(id_cliente);
CREATE INDEX idx_citas_empleado ON citas(id_empleado);
CREATE INDEX idx_citas_servicio ON citas(id_servicio);
CREATE INDEX idx_citas_fecha    ON citas(fecha);

-- =========================================================================
-- TABLA: ventas
-- Propósito: Cabecera de una transacción de venta de productos realizada
--            por un cliente.
-- Relación:  FK hacia clientes. Es referenciada por detalle_venta.
-- =========================================================================
CREATE TABLE ventas (
    id_venta     INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente   INT NOT NULL,
    fecha_venta  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    total        DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    metodo_pago  VARCHAR(50) NOT NULL,
    estado       ENUM('Completada','Cancelada') NOT NULL DEFAULT 'Completada',
    observacion  VARCHAR(255) NULL,
    CONSTRAINT fk_ventas_cliente
        FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE INDEX idx_ventas_cliente ON ventas(id_cliente);

-- =========================================================================
-- TABLA: detalle_venta
-- Propósito: Líneas de detalle (productos, cantidad, precio) de cada venta.
-- Relación:  FK hacia ventas (cabecera) y productos (ítem vendido).
-- =========================================================================
CREATE TABLE detalle_venta (
    id_detalle_venta  INT AUTO_INCREMENT PRIMARY KEY,
    id_venta          INT NOT NULL,
    id_producto       INT NOT NULL,
    cantidad          INT NOT NULL,
    precio_unitario   DECIMAL(10,2) NOT NULL,
    subtotal          DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_detalle_venta_venta
        FOREIGN KEY (id_venta) REFERENCES ventas(id_venta)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_detalle_venta_producto
        FOREIGN KEY (id_producto) REFERENCES productos(id_producto)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE INDEX idx_detalle_venta_venta    ON detalle_venta(id_venta);
CREATE INDEX idx_detalle_venta_producto ON detalle_venta(id_producto);

-- =========================================================================
-- SEED: Roles del sistema (fijos, no editables desde CRUD)
-- =========================================================================
INSERT INTO roles (nombre_rol, descripcion) VALUES
    ('Administrador',   'Gestiona usuarios, empleados, clientes, servicios, productos, citas y ventas'),
    ('Colaborador Spa', 'Atiende las citas que le son asignadas y actualiza su estado'),
    ('Cliente',         'Agenda citas, compra productos y consulta su historial');

-- =========================================================================
-- FIN DEL SCRIPT
-- =========================================================================
