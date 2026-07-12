<?php

// autor: Zhunaula Kevin

require_once "BaseDAO.php";
require_once "models/dto/cliente.php";

class ClienteDAO extends BaseDAO
{
    // Permitimos recibir una conexión externa opcional para las transacciones
    public function __construct(?PDO $conexionCompartida = null)
    {
        parent::__construct();
        
        if ($conexionCompartida !== null) {
            $this->setConexion($conexionCompartida);
        }
    }

    public function obtenerTodos(): array 
    {
        $lista = [];
        try {
            // El INNER JOIN mapea los datos cruzados mediante la FK
            $sql = "SELECT c.*, u.nombre, u.correo, u.telefono , u fecha_registro
                    FROM clientes c
                    INNER JOIN usuarios u ON c.id_usuario = u.id_usuario
                    WHERE c.estado = 1";    //1: activo, 0: inactivo
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            
            // Mapeamos los resultados directos al DTO unificado
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $cliente = new Cliente();
                $cliente->setIdCliente($row['id_cliente']);
                $cliente->setIdUsuario($row['id_usuario']);
                $cliente->setDireccion($row['direccion']);
                $cliente->setFechaNacimiento($row['fecha_nacimiento']);
                $cliente->setGenero($row['genero']);
                $cliente->setObservaciones($row['observaciones']);
                
                // Setear campos heredados de la consulta JOIN
                $lista[] = $cliente;
            }
        } catch (PDOException $e) {
            error_log("Error en ClienteDAO::obtenerTodos -> " . $e->getMessage());
        }
        return $lista;
    }

    // Agregamos el método para insertar utilizando la propiedad $this->conexion heredada
    public function insertar(Cliente $cliente): bool
    {
        try {
            $sql = "INSERT INTO clientes (id_usuario, direccion, fecha_nacimiento, genero, observaciones) 
                    VALUES (:id_usuario, :direccion, :fecha_nacimiento, :genero, :observaciones)";
            
            $stmt = $this->conexion->prepare($sql);
            
            return $stmt->execute([
                ':id_usuario'       => $cliente->getIdUsuario(),
                ':direccion'        => $cliente->getDireccion(),
                ':fecha_nacimiento' => $cliente->getFechaNacimiento(),
                ':genero'           => $cliente->getGenero(),
                ':observaciones'    => $cliente->getObservaciones()
            ]);
        } catch (PDOException $e) {
            error_log("Error en ClienteDAO::insertar -> " . $e->getMessage());
            return false;
        }
    }
}