# Centro de Belleza y Spa - Sistema de Gestión

Proyecto universitario desarrollado en PHP 8 con arquitectura **MVC**, patrón **DAO**, **DTO** y **Front Controller**, sin frameworks (PHP puro + PDO + JavaScript Vanilla).

Sistema integrado por el equipo (Grupo 4): Autenticación y Usuarios, Empleados, Clientes, Servicios y Citas, Productos y Compras, y reporte de Ventas.

## 🚀 Módulos del sistema

- **Autenticación:** login, logout y registro público de clientes con `password_hash()` / `password_verify()` y `$_SESSION`. Control de acceso por roles (Administrador, Colaborador, Cliente) mediante `controllers/SesionHelper.php`.
- **Usuarios / Empleados / Clientes:** CRUD completo con búsqueda, edición y baja lógica. Toda la información personal vive en `usuarios`; `empleados` y `clientes` solo contienen sus atributos propios (sin duplicar datos).
- **Citas:** el cliente reserva servicios/tratamientos desde su cuenta; el Administrador gestiona la agenda, asigna colaborador y actualiza el estado.
- **Productos:** catálogo administrado por el Administrador (CRUD) y catálogo público de cliente con carrito de compras.
- **Compras:** el cliente compra productos desde el carrito (`compras` / `detalle_compra`); el historial queda disponible en "Mis compras".
- **Ventas:** reporte administrativo de solo lectura sobre las compras realizadas por los clientes.

## 🛠️ Tecnologías

- **Backend:** PHP 8.x + PDO
- **Base de Datos:** MariaDB / MySQL
- **Frontend:** HTML5, CSS3 y JavaScript Vanilla (ES6)

## 📋 Instalación

1. Clona el proyecto dentro de la carpeta de tu servidor local (ej. `htdocs` en XAMPP).
2. Importa la base de datos: en phpMyAdmin, ejecuta `sql/spa_belleza_db.sql` (crea la base de datos, todas las tablas y datos de ejemplo automáticamente).
3. Ajusta las credenciales de conexión en `config/Database.php` si es necesario (por defecto: `root` sin contraseña).
4. Abre el proyecto en el navegador desde la carpeta raíz (`index.php`).

**Credenciales de prueba (Administrador):**
- Usuario: `admin`
- Correo: `admin@spabelleza.com`
- Contraseña: `admin123`

## 🗺️ Mapa de rutas principales

| Ruta                                            | Descripción                              |
|--------------------------------------------------|-------------------------------------------|
| `?controller=sitio&action=inicio`                | Página de inicio (pública)                |
| `?controller=auth&action=login`                  | Iniciar sesión                            |
| `?controller=auth&action=registro`               | Registro de clientes                      |
| `?controller=auth&action=logout`                 | Cerrar sesión                             |
| `?controller=admin&action=dashboard`             | Panel administrativo (Admin/Colaborador)  |
| `?controller=usuario&action=listar`              | CRUD de Usuarios (Administrador)          |
| `?controller=empleado&action=listar`             | CRUD de Empleados (Administrador)         |
| `?controller=cliente&action=listar`              | CRUD de Clientes (Administrador)          |
| `?controller=producto&action=listar`             | CRUD de Productos (Administrador)         |
| `?controller=venta&action=index`                 | Reporte de Ventas (Administrador)         |
| `?controller=citas&action=index`                 | Gestión de Citas (Administrador)          |
| `?controller=area-cliente&action=inicio`         | Área privada del Cliente autenticado      |
| `?controller=area-cliente&action=compras`        | Historial de compras del Cliente          |
| `?controller=clienteProd&action=catalogo`        | Catálogo público de productos             |
| `?controller=carrito&action=*`                   | Carrito de compras (AJAX, Cliente)        |
| `?controller=citas&action=crear`                 | Reservar cita (Cliente)                   |
| `?controller=citas&action=miAgenda`              | Agenda de citas del Cliente                |

## 📁 Estructura relevante

```
config/Database.php                Conexión PDO
controllers/SesionHelper.php       Gestión de sesión y control de acceso por rol
controllers/auth/                  Login, logout, registro
controllers/admin/                 Dashboard, CRUD Usuarios/Empleados/Clientes/Productos, Ventas, Citas
controllers/publico/               Sitio público (Inicio)
controllers/cliente/               Área privada del cliente, catálogo y carrito
models/dao/, models/dto/           Acceso a datos y entidades de cada módulo
views/auth/, views/publico/, views/cliente/, views/admin/   Vistas correspondientes
assets/css/design-system/          Design System compartido (variables, components, client)
assets/css/                        CSS específicos por vista (login, usuarios, empleados, clientes, productos, ventas, citas, catalogo, etc.)
```

## 📝 Notas de integración

- Las tablas `ventas` y `detalle_venta` del script SQL quedaron sin uso: el flujo de compras y el reporte de ventas se implementaron sobre `compras` / `detalle_compra`. Se dejaron documentadas en el propio script por si se necesitan más adelante.
- El módulo de **Servicios** (CRUD administrativo) aún no tiene una vista propia; los servicios se administran únicamente desde el script SQL. El enlace "Servicios" del panel queda inactivo hasta que se implemente.

