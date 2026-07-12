<?php

require_once "config/Database.php";

// Clase base para el acceso a la base de datos
// Se debe heredar de esta clase en los DAOs creados 
abstract class BaseDAO
{
    protected PDO $conexion;

    public function __construct()
    {
        $db = new Database();
        $this->conexion = $db->conectar();
    }

    // --- MÉTODOS PARA MANEJO DE TRANSACCIONES ---

    public function iniciarTransaccion(): void
    {
        if (!$this->conexion->inTransaction()) {
            $this->conexion->beginTransaction();
        }
    }

    public function confirmarTransaccion(): void
    {
        if ($this->conexion->inTransaction()) {
            $this->conexion->commit();
        }
    }

    public function cancelarTransaccion(): void
    {
        if ($this->conexion->inTransaction()) {
            $this->conexion->rollBack();
        }
    }

    // --- MÉTODOS PARA COMPARTIR LA CONEXIÓN ENTRE DAOs ---

    public function getConexion(): PDO
    {
        return $this->conexion;
    }

    public function setConexion(PDO $conexion): void
    {
        $this->conexion = $conexion;
    }
}