<?php

require_once "BaseDAO.php";
require_once "models/dto/usuarios/rol.php";

class RolDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listar(): array
    {
        $sql = "SELECT * FROM roles ORDER BY nombre";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function buscarPorId(int $idRol): ?Rol
    {
        $sql = "SELECT * FROM roles WHERE id_rol = ?";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$idRol]);

        $rol = $stmt->fetch();

        if (!$rol) {
            return null;
        }

        return new Rol(
            $rol['id_rol'],
            $rol['nombre'],
            $rol['descripcion']
        );
    }
}