# Centro de Belleza y Spa - Sistema de Gestión

Este es un proyecto universitario desarrollado en PHP utilizando la arquitectura **MVC** y Programación Orientada a Objetos (**POO**).

## 🚀 Características Breves
- **Autenticación Centralizada:** Login único con redirección dinámica según el rol del usuario.
- **Módulo de Usuarios:** Interfaz exclusiva de Administrador para gestionar Clientes y Empleados.
- **Navegación Dinámica:** Menú intermodular en la barra superior que se activa solo dentro de las secciones internas.
- **Diseño Limpio:** Interfaz moderna basada en tarjetas interactivas con efectos visuales.

## 🛠️ Tecnologías
- **Backend:** PHP 8.x
- **Base de Datos:** MariaDB / MySQL
- **Frontend:** HTML5, CSS3 y JavaScript moderno (ES6)

## 📋 Requisitos e Instalación

1. **Clonar el proyecto** dentro de la carpeta de tu servidor local (ej: `htdocs` en XAMPP).
2. **Importar la Base de Datos:**
   - Abre tu gestor (ej: phpMyAdmin).
   - Importa directamente el archivo ubicado en `sql/spa_belleza_db.sql` (el script ya incluye el comando para crear la base de datos automáticamente).
3. **Configurar Conexión:**
   - Ajusta las credenciales de tu servidor local en `config/Database.php`.

**Credenciales de prueba (Admin):**
- **Correo:** `admin@spabelleza.com`
- **Contraseña:** `admin123`