<?php
// CONTROLLER - Sirve las páginas públicas del sitio (visitantes sin
// autenticar). Expone el Inicio, mostrando servicios y productos
// destacados a partir de los módulos ya existentes (sin duplicar datos).
// Autor: Integrante 1

require_once "models/dao/Citas/ServicioDAO.php";
require_once "models/dao/producto/ProductoDAO.php";

class SitioController
{
    public function inicio()
    {
        $servicioDAO = new ServicioDAO();
        $productoDAO = new ProductoDAO();

        $serviciosDestacados = $servicioDAO->listarDestacados(3);

        // Reutiliza ProductoDAO::listar() (ya usado por el CRUD de Productos)
        // y se queda solo con los primeros para la vitrina de "destacados".
        $productosDestacados = array_slice($productoDAO->listar(), 0, 3);

        require_once "views/publico/inicio.php";
    }
}
