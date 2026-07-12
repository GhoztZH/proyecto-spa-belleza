<?php

class Usuario
{
    private ?int $idUsuario;
    private string $username;
    private string $correo;
    private string $password;
    private string $telefono;
    private bool $estado;
    private string $fechaRegistro;
    private int $idRol;

    public function __construct(
        ?int $idUsuario = null,
        string $username = '',
        string $correo = '',
        string $password = '',
        string $telefono = '',
        bool $estado = true,
        string $fechaRegistro = '',
        int $idRol = 0
    ) {
        $this->idUsuario = $idUsuario;
        $this->username = $username;
        $this->correo = $correo;
        $this->password = $password;
        $this->telefono = $telefono;
        $this->estado = $estado;
        $this->$fechaRegistro = '';
        $this->idRol = $idRol;
    }

    public function getIdUsuario(): ?int
    {
        return $this->idUsuario;
    }

    public function setIdUsuario(?int $idUsuario): void
    {
        $this->idUsuario = $idUsuario;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getCorreo(): string
    {
        return $this->correo;
    }

    public function setCorreo(string $correo): void
    {
        $this->correo = $correo;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getTelefono(): string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): void
    {
        $this->telefono = $telefono;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getEstado(): bool
    {
        return $this->estado;
    }

    public function setEstado(bool $estado): void
    {
        $this->estado = $estado;
    }

    public function getFechaRegistro(): string
    {
        return $this->fechaRegistro;
    }

    public function setFechaRegistro(string $fechaRegistro): void
    {
        $this->fechaRegistro = $fechaRegistro;
    }

    public function getIdRol(): int
    {
        return $this->idRol;
    }

    public function setIdRol(int $idRol): void
    {
        $this->idRol = $idRol;
    }
}
