<?php
// CONFIG - Encapsula los datos de conexión a MariaDB y expone un método
// para obtener una instancia PDO lista para usar en los DAO.

class Database
{
    private string $host = "localhost";
    private string $dbname = "spa_belleza";
    private string $user = "root";
    private string $password = "";

    public function conectar(): PDO
    {
        // utf8mb4 coincide con el charset/collation definidos en el script SQL,
        // evitando problemas con acentos y la letra 'ñ'.
        return new PDO(
            "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
            $this->user,
            $this->password,
            [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false
            ]
        );
    }
}