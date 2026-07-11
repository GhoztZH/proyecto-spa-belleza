<?php

require_once "BaseDAO.php";
require_once "models/dto/usuario.php";

class UsuarioDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listar()
    {
        $sql = "SELECT * FROM usuarios";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}