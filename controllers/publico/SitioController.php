<?php
// CONTROLLER - Sirve las páginas públicas del sitio (visitantes sin
// autenticar). Por ahora solo expone el Inicio; el catálogo completo de
// servicios/productos lo desarrollará el integrante correspondiente.
// Autor: Integrante 1

class SitioController
{
    public function inicio()
    {
        require_once "views/publico/inicio.php";
    }
}
