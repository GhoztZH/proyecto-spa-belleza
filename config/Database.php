<?php

class Database
{
    private string $host = "localhost";
    private string $dbname = "spa_belleza";
    private string $user = "root";
    private string $password = "";

    public function conectar(): PDO
    {
        return new PDO(
            "mysql:host={$this->host};dbname={$this->dbname};charset=utf8",
            $this->user,
            $this->password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }
}