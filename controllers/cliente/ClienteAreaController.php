<?php
// CONTROLLER - Área privada del Cliente autenticado. Expone el Inicio del
// cliente y el historial de compras (CompraDAO), reutilizando las vistas
// ya construidas en views/cliente/producto-compra/.
// Autor: Integrante 1

require_once "controllers/SesionHelper.php";
require_once "models/dao/compra/CompraDAO.php";

class ClienteAreaController
{
    private CompraDAO $compraDAO;

    public function __construct()
    {
        SesionHelper::requerirRol(['Cliente']);
        $this->compraDAO = new CompraDAO();
    }

    public function inicio()
    {
        $usuario = SesionHelper::usuarioActual();
        require_once "views/cliente/inicio.php";
    }

    // Historial de compras del cliente autenticado.
    public function compras()
    {
        $usuario = SesionHelper::usuarioActual();
        $compras = $this->compraDAO->listarPorUsuario($usuario['id_usuario']);
        require_once "views/cliente/producto-compra/compras.php";
    }

    // Detalle de una compra puntual del cliente autenticado.
    public function detalleCompra()
    {
        $idCompra = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$idCompra) {
            header("Location: index.php?controller=area-cliente&action=compras");
            exit;
        }

        $compra = $this->compraDAO->buscarPorId($idCompra);
        $usuario = SesionHelper::usuarioActual();

        // Evita que un cliente vea el detalle de una compra ajena.
        if (!$compra || (int)$compra['id_usuario'] !== (int)$usuario['id_usuario']) {
            header("Location: index.php?controller=area-cliente&action=compras");
            exit;
        }

        $detalle = $this->compraDAO->detalleCompra($idCompra);
        require_once "views/cliente/producto-compra/detalleCompra.php";
    }
}
