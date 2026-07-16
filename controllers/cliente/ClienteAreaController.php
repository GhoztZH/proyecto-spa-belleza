<?php
// CONTROLLER - Área privada del Cliente autenticado. Deja preparada la
// infraestructura de acceso (protección de ruta + datos de sesión) para
// que otros integrantes agreguen aquí las funcionalidades de Citas y
// Compras, sin necesidad de tocar la autenticación.
// Autor: Integrante 1

require_once "controllers/SesionHelper.php";

class ClienteAreaController
{
    public function __construct()
    {
        SesionHelper::requerirRol(['Cliente']);
    }

    public function inicio()
    {
        $usuario = SesionHelper::usuarioActual();
        require_once "views/cliente/inicio.php";
    }
}
