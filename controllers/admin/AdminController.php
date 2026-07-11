<?php
// controllers/AdminController.php

class AdminController
{
    // Acción para mostrar el Dashboard principal 
    public function dashboard()
    {
        // En la pantalla principal el menú va oculto, por lo que no definimos $mostrarMenu
        // NOTA: Asegúrate de que tu vista principal se llame admin.php si la renombraste.
        require_once "views/admin/admin.php"; 
    }

    // Acción para mostrar el módulo de Usuarios (Clientes, Empleados, Roles)
    public function usuarios()
    {
        // Activamos el menú dinámico para esta vista interna
        $mostrarMenu = true;

        // Cargamos la vista del módulo de usuarios
        require_once "views/admin/usuarios.php";
        
        // Se eliminó la línea vacía que causaba el error de sintaxis
    }
}