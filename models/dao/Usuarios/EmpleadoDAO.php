<?php

require_once "BaseDAO.php";
require_once "models/Empleado.php";

class EmpleadoDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listar(): array
    {
        $sql = "SELECT * FROM empleados ORDER BY nombres";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function buscarPorId(int $idEmpleado): ?Empleado
    {
        $sql = "SELECT * FROM empleados WHERE id_empleado = ?";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([$idEmpleado]);

        $empleado = $stmt->fetch();

        if (!$empleado) {
            return null;
        }

        return new Empleado(
            $empleado['id_empleado'],
            $empleado['nombres'],
            $empleado['apellidos'],
            $empleado['cedula'],
            $empleado['telefono'],
            $empleado['direccion'],
            $empleado['cargo'],
            (bool)$empleado['estado'],
            $empleado['id_usuario']
        );
    }

    public function insertar(Empleado $empleado): bool
    {
        $sql = "INSERT INTO empleados
                (nombres, apellidos, cedula, telefono, direccion, cargo, estado, id_usuario)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            $empleado->getNombres(),
            $empleado->getApellidos(),
            $empleado->getCedula(),
            $empleado->getTelefono(),
            $empleado->getDireccion(),
            $empleado->getCargo(),
            $empleado->getEstado(),
            $empleado->getIdUsuario()
        ]);
    }

    public function actualizar(Empleado $empleado): bool
    {
        $sql = "UPDATE empleados SET
                    nombres = ?,
                    apellidos = ?,
                    cedula = ?,
                    telefono = ?,
                    direccion = ?,
                    cargo = ?,
                    estado = ?
                WHERE id_empleado = ?";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            $empleado->getNombres(),
            $empleado->getApellidos(),
            $empleado->getCedula(),
            $empleado->getTelefono(),
            $empleado->getDireccion(),
            $empleado->getCargo(),
            $empleado->getEstado(),
            $empleado->getIdEmpleado()
        ]);
    }

    public function eliminar(int $idEmpleado): bool
    {
        $sql = "DELETE FROM empleados WHERE id_empleado = ?";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([$idEmpleado]);
    }
}