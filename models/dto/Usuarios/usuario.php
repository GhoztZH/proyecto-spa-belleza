<?php

class Usuario
{
    private ?int $idUsuario;
    private string $username;
    private string $correo;
    private string $password;
    private bool $estado;
    private int $idRol;

    public function __construct(
        ?int $idUsuario = null,
        string $username = '',
        string $correo = '',
        string $password = '',
        bool $estado = true,
        int $idRol = 0
    ) {
        $this->idUsuario = $idUsuario;
        $this->username = $username;
        $this->correo = $correo;
        $this->password = $password;
        $this->estado = $estado;
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

    public function getIdRol(): int
    {
        return $this->idRol;
    }

    public function setIdRol(int $idRol): void
    {
        $this->idRol = $idRol;
    }
}