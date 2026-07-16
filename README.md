# Centro de Belleza y Spa - Sistema de Gestión

Proyecto universitario desarrollado en PHP 8 con arquitectura **MVC**, patrón **DAO**, **DTO** y **Front Controller**, sin frameworks (PHP puro + PDO + JavaScript Vanilla).

## 🚀 Módulo Integrante 1: Autenticación y Usuarios

- **Autenticación:** login, logout y registro público de clientes con `password_hash()` / `password_verify()` y `$_SESSION`.
- **Control de acceso por roles:** Administrador, Colaborador y Cliente, protegido mediante `controllers/SesionHelper.php`.
- **CRUD de Usuarios, Empleados y Clientes:** con búsqueda, edición y baja lógica (se desactiva la cuenta en `usuarios`).
- **Base de datos reestructurada:** toda la información personal vive en `usuarios`; `empleados` y `clientes` solo contienen sus atributos propios (sin duplicar datos).

## 🛠️ Tecnologías

- **Backend:** PHP 8.x + PDO
- **Base de Datos:** MariaDB / MySQL
- **Frontend:** HTML5, CSS3 y JavaScript Vanilla (ES6)

## 📋 Instalación

1. Clona el proyecto dentro de la carpeta de tu servidor local (ej. `htdocs` en XAMPP).
2. Importa la base de datos: en phpMyAdmin, ejecuta `sql/spa_belleza_db.sql` (crea la base de datos y las tablas automáticamente).
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
| `?controller=area-cliente&action=inicio`         | Área privada del Cliente autenticado      |

## 📁 Estructura relevante del módulo

```
config/Database.php                Conexión PDO
controllers/SesionHelper.php       Gestión de sesión y control de acceso por rol
controllers/auth/                  Login, logout, registro
controllers/admin/                 Dashboard, CRUD Usuarios/Empleados/Clientes
controllers/publico/               Sitio público (Inicio)
controllers/cliente/               Área privada del cliente
models/dao/usuarios/               Acceso a datos (PDO)
models/dto/usuarios/               Entidades (Rol, Usuario, Empleado, Cliente)
views/auth/, views/publico/, views/cliente/, views/admin/   Vistas correspondientes
assets/css/design-system/          Design System compartido (variables, components, client)
assets/css/                        admin.css, login.css, usuarios.css, empleados.css, clientes.css
```
