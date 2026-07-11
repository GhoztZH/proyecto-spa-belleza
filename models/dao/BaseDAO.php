<?php

require_once "config/Database.php";

//Clase base para el acceso a la base de datos
//Se debe hererad de esta clase en los DAOs creados 
abstract class BaseDAO
{
    protected PDO $conexion;

    public function __construct()
    {
        $db = new Database();
        $this->conexion = $db->conectar();
    }
}