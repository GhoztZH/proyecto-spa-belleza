<?php
// Autor: Marvin Castro
require_once "models/dao/producto/ProductoDAO.php";
class ClienteProdController
{
    private ProductoDAO $productoDAO;
    public function __construct()
    {
        $this->productoDAO = new ProductoDAO();
    }
    // Mostrar catálogo de productos
    public function catalogo()
    {
        $productos = $this->productoDAO->listar();
        $categorias = $this->productoDAO->listarCategorias();

        require_once "views/cliente/producto-compra/catalogoProd.php";
    }

    public function index()
    {
        $this->catalogo();
    }

    // Mostrar detalle del producto
    public function detalle()
    {
        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);
        if (!$id) {
            header("Location:index.php?controller=clienteProd&action=catalogo");
            exit;
        }
        $producto = $this->productoDAO->buscarPorId($id);
        if (!$producto) {
            header("Location:index.php?controller=clienteProd&action=catalogo");
            exit;
        }
        require_once "views/cliente/producto-compra/detalleProducto.php";
    }

    // Búsqueda AJAX
    public function buscarAjax()
    {
        $texto = trim($_GET["texto"] ?? "");
        $categoria = (int)($_GET["categoria"] ?? 0);
        $productos = $this->productoDAO->buscarCliente($texto, $categoria);
        header("Content-Type: application/json");
        echo json_encode($productos);
        exit;
    }
}