<?php
// autor: Zhunaula Kevin

class AdminController
{
    // Acción para mostrar el Dashboard principal 
    public function dashboard()
    {
        require_once "views/admin/admin.php"; 
    }

    public function clientes()
    {
        // Activamos el menú dinámico para esta vista interna
        $mostrarMenu = true;

        $clientes = 

        // Cargamos la vista del módulo de usuarios
        require_once "views/admin/clientes.php";
    }

    // Acción para mostrar el módulo de Usuarios (Clientes, Empleados, Roles)
    public function empleados()
    {
        // Activamos el menú dinámico para esta vista interna
        $mostrarMenu = true;

        // Cargamos la vista del módulo de usuarios
        require_once "views/admin/empleados.php";
    }
    
}