<?php

// autor: Zhunaula Kevin

require_once "BaseDAO.php";
require_once "models/dto/Usuarios/usuario.php";

class UsuarioDAO extends BaseDAO
{
    public function __construct(?PDO $conexionCompartida = null)
    {
        parent::__construct();
        if ($conexionCompartida !== null) {
            $this->setConexion($conexionCompartida);
        }
    }

    public function listar()
    {
        $sql = "SELECT * FROM usuarios";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertarCliente(Usuario $usuario): int 
    {
        $sql = "INSERT INTO usuarios (nombre, correo, contrasena, telefono, estado, fecha_registro, id_rol)
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conexion->prepare($sql);
        
        $stmt->execute([
            $usuario->getUsername(),
            $usuario->getCorreo(),
            $usuario->getPassword(),
            $usuario->getTelefono(),
            $usuario->getEstado(),
            $usuario->getFechaRegistro(),
            $usuario->getIdRol()
        ]);

        return $this->conexion->lastInsertId();
    }
}