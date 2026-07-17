<?php
// index.php (Raíz del proyecto) - Patrón de diseño Front Controller.
// Único punto de entrada HTTP de la aplicación: recibe la petición,
// resuelve qué Controller/acción debe atenderla y delega el control.

session_start();

// -------------------------------------------------------------------------
// MAPA DE RUTAS
// -------------------------------------------------------------------------
// Se utiliza un mapa explícito (allowlist) en lugar de construir la ruta del
// archivo directamente a partir de $_GET['controller']. Esto corrige dos
// problemas del enrutamiento original:
//   1. Seguridad: incluir un archivo cuyo nombre proviene directamente de la
//      entrada del usuario permite Local File Inclusion si no se valida.
//   2. La ruta física estaba fija en "controllers/Admin/", por lo que
//      cualquier controlador fuera de esa carpeta (auth, cliente, público)
//      nunca podía ser despachado.
//
// Cada integrante puede registrar aquí los controladores de su módulo
// siguiendo el mismo formato: 'clave' => ['clase' => ..., 'ruta' => ...].
$rutasControllers = [
    // Módulo de autenticación
    'auth'         => ['clase' => 'AuthController',        'ruta' => 'controllers/auth/AuthController.php'],

    // Panel administrativo
    'admin'        => ['clase' => 'AdminController',       'ruta' => 'controllers/admin/AdminController.php'],
    'usuario'      => ['clase' => 'UsuarioController',     'ruta' => 'controllers/admin/UsuarioController.php'],
    'empleado'     => ['clase' => 'EmpleadoController',    'ruta' => 'controllers/admin/EmpleadoController.php'],
    'cliente'      => ['clase' => 'ClienteController',     'ruta' => 'controllers/admin/ClienteController.php'],
    'citas'        => ['clase' => 'CitasController',       'ruta' => 'controllers/admin/CitasController.php'],
    'producto'     => ['clase' => 'ProductoController',    'ruta' => 'controllers/admin/ProductoController.php'],
    'venta'        => ['clase' => 'VentaController',       'ruta' => 'controllers/admin/VentaController.php'],

    // Sitio público (visitantes sin autenticar)
    'sitio'        => ['clase' => 'SitioController',       'ruta' => 'controllers/publico/SitioController.php'],

    // Área privada del cliente autenticado
    'area-cliente' => ['clase' => 'ClienteAreaController', 'ruta' => 'controllers/cliente/ClienteAreaController.php'],
    'clienteProd'  => ['clase' => 'ClienteProdController', 'ruta' => 'controllers/cliente/ClienteProdController.php'],
    'carrito'      => ['clase' => 'CarritoController',     'ruta' => 'controllers/cliente/CarritoController.php'],
];

// -------------------------------------------------------------------------
// RESOLUCIÓN DE LA PETICIÓN
// -------------------------------------------------------------------------
// Por defecto se muestra el Inicio público, no el panel administrativo,
// ya que la primera pantalla de un sitio real debe ser accesible a
// cualquier visitante sin necesidad de iniciar sesión.
$controllerKey = $_GET['controller'] ?? 'sitio';
$action = $_GET['action'] ?? 'inicio';

if (!isset($rutasControllers[$controllerKey])) {
    http_response_code(404);
    die("El controlador solicitado no existe.");
}

$definicion = $rutasControllers[$controllerKey];
$controllerPath = $definicion['ruta'];
$controllerName = $definicion['clase'];

if (!file_exists($controllerPath)) {
    http_response_code(500);
    die("El archivo del controlador no fue encontrado.");
}

require_once $controllerPath;
$controller = new $controllerName();

if (!method_exists($controller, $action)) {
    http_response_code(404);
    die("La acción solicitada no existe.");
}

$controller->$action();
