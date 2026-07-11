<?php
//Patron de diseño front controller

// index.php (Raíz del proyecto)
session_start();

// 1. Capturar el controlador y la acción de la URL (con valores por defecto)
$controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) . 'Controller' : 'AdminController';
$action = isset($_GET['action']) ? $_GET['action'] : 'dashboard';

// 2. Ruta física del controlador
$controllerPath = "controllers/Admin/" . $controllerName . ".php";

// 3. Verificar si el controlador existe y despachar
if (file_exists($controllerPath)) {
    require_once $controllerPath;
    $controller = new $controllerName();

    if (method_exists($controller, $action)) {
        $controller->$action(); // Ejecuta la acción (ej: login())
    } else {
        die("La acción no existe.");
    }
} else {
    die("El controlador no existe.");
}
