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

    public function insertarUserCliente(Usuario $usuario): ?int
    {
        try {
            // CORREGIDO: comas agregadas en VALUES e id_rol corregido
            $sql = "INSERT INTO usuarios (id_rol, nombre, correo, contrasena, telefono, estado, fecha_registro)
                    VALUES (:id_rol, :nombre, :correo, :contrasena, :telefono, :estado, :fecha_registro)";

            $stmt = $this->conexion->prepare($sql);

            $exito = $stmt->execute([
                'id_rol'          => $usuario->getIdRol(),
                ':nombre'         => $usuario->getUsername(),
                ':correo'         => $usuario->getCorreo(),
                ':contrasena'     => $usuario->getPassword(),
                ':telefono'       => $usuario->getTelefono(),
                ':estado'         => $usuario->getEstado() ? 1 : 0, // Convertimos el bool a 1 o 0 para TinyInt
                ':fecha_registro' => $usuario->getFechaRegistro()
            ]);

            // SI EL INSERT FUNCIONÓ: Devolvemos el ID casteado a entero
            if ($exito) {
                return (int)$this->conexion->lastInsertId();
            }

            return null;
        } catch (PDOException $e) {
            error_log("Error en UsuarioDAO::insertarUserCliente -> " . $e->getMessage());
            return null;
        }
    }

    //Colocar aqui el insert para empleados

    public function insertarUserEmpleado() {}
}
