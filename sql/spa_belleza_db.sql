-- =========================================================================
-- BASE DE DATOS: CENTRO DE BELLEZA Y SPA
-- Motor: MariaDB / MySQL
-- Descripción: Modelo relacional normalizado (3FN) para gestión de
--              usuarios, roles, empleados, clientes, servicios,
--              productos, citas y ventas.
--
-- NOTA DE ACTUALIZACIÓN (Módulo Integrante 1 - Autenticación y Usuarios):
-- Se reestructuraron las tablas roles, usuarios, empleados y clientes
-- para eliminar la redundancia de datos personales. Toda la información
-- personal y de autenticación ahora se centraliza en "usuarios"; las
-- tablas "empleados" y "clientes" solo contienen los atributos propios
-- de cada rol y se relacionan 1:1 con "usuarios".
-- =========================================================================

CREATE DATABASE IF NOT EXISTS spa_belleza
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE spa_belleza;

-- =========================================================================
-- TABLA: roles
-- Propósito: Catálogo fijo de los roles del sistema. No tiene CRUD propio;
--            se puebla únicamente mediante los datos semilla de este script.
-- Relación:  Es referenciada por la tabla usuarios (1 rol -> N usuarios).
-- =========================================================================
CREATE TABLE roles (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(30) NOT NULL UNIQUE
) ENGINE=InnoDB;

-- =========================================================================
-- TABLA: usuarios
-- Propósito: Centraliza toda la información personal y de autenticación
--            del sistema (administradores, colaboradores y clientes),
--            evitando duplicidad de datos entre empleados y clientes.
-- Relación:  FK hacia roles. Es referenciada 1:1 por empleados y clientes.
-- =========================================================================
CREATE TABLE usuarios (
    id_usuario     INT AUTO_INCREMENT PRIMARY KEY,
    id_rol         INT NOT NULL,
    nombre         VARCHAR(80)  NOT NULL,
    apellido       VARCHAR(80)  NOT NULL,
    correo         VARCHAR(120) NOT NULL UNIQUE,
    celular        VARCHAR(20)  NOT NULL,
    username       VARCHAR(50)  NOT NULL UNIQUE,
    password       VARCHAR(255) NOT NULL,
    estado         BOOLEAN      NOT NULL DEFAULT TRUE,
    fecha_creacion TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_usuarios_rol
        FOREIGN KEY (id_rol) REFERENCES roles(id_rol)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE INDEX idx_usuarios_rol ON usuarios(id_rol);

-- =========================================================================
-- TABLA: empleados
-- Propósito: Contiene únicamente la información laboral del colaborador.
--            Los datos personales (nombre, correo, etc.) pertenecen a
--            la tabla usuarios y no se duplican aquí.
-- Relación:  FK 1:1 hacia usuarios. Es referenciada por citas
--            (colaborador asignado).
-- =========================================================================
CREATE TABLE empleados (
    id_empleado   INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario    INT NOT NULL UNIQUE,
    cargo         VARCHAR(80) NOT NULL,
    fecha_ingreso DATE NOT NULL,
    CONSTRAINT fk_empleados_usuario
        FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

-- =========================================================================
-- TABLA: clientes
-- Propósito: Representa a los clientes registrados en el sistema. Los
--            datos personales pertenecen a usuarios; esta tabla solo
--            marca la relación de rol "Cliente" para futuras
--            funcionalidades (citas, compras).
-- Relación:  FK 1:1 hacia usuarios. Es referenciada por citas y ventas.
-- =========================================================================
CREATE TABLE clientes (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT NOT NULL UNIQUE,
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
INSERT INTO roles (nombre) VALUES
    ('Administrador'),
    ('Colaborador'),
    ('Cliente');

-- =========================================================================
-- DATOS DE PRUEBA: Usuario Administrador
-- La contraseña ya está hasheada con password_hash() (BCRYPT), tal como
-- la generará el sistema en un registro real. Contraseña en texto plano: admin123
-- =========================================================================
INSERT INTO usuarios (id_rol, nombre, apellido, correo, celular, username, password, estado)
VALUES (
    1,
    'Carlos',
    'Mendoza',
    'admin@spabelleza.com',
    '0999999999',
    'admin',
    '$2y$10$XSC0ZW4GCnByfKb4j1xOUeAJjcjh2kxjvP2DofpH6MD1VrV0vUx5y',
    1
);

INSERT INTO empleados (id_usuario, cargo, fecha_ingreso)
VALUES (LAST_INSERT_ID(), 'Administrador General', '2026-01-15');


--Datos de pruba Categoria productos

INSERT INTO categorias_producto (nombre_categoria, descripcion, estado) VALUES
('Cabello', 'Shampoo, acondicionadores y tratamientos capilares',1),
('Facial', 'Productos para limpieza e hidratación facial',1),
('Corporal', 'Cremas, exfoliantes y aceites corporales',1),
('Masajes', 'Aceites y productos para terapias de masaje',1),
('Maquillaje', 'Productos cosméticos y belleza',1);
