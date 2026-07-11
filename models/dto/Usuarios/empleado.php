<?php

class Empleado
{
    private ?int $idEmpleado;
    private string $nombres;
    private string $apellidos;
    private string $cedula;
    private string $telefono;
    private string $direccion;
    private string $cargo;
    private bool $estado;
    private int $idUsuario;

    public function __construct(
        ?int $idEmpleado = null,
        string $nombres = '',
        string $apellidos = '',
        string $cedula = '',
        string $telefono = '',
        string $direccion = '',
        string $cargo = '',
        bool $estado = true,
        int $idUsuario = 0
    ) {
        $this->idEmpleado = $idEmpleado;
        $this->nombres = $nombres;
        $this->apellidos = $apellidos;
        $this->cedula = $cedula;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
        $this->cargo = $cargo;
        $this->estado = $estado;
        $this->idUsuario = $idUsuario;
    }

    public function getIdEmpleado(): ?int
    {
        return $this->idEmpleado;
    }

    public function setIdEmpleado(?int $idEmpleado): void
    {
        $this->idEmpleado = $idEmpleado;
    }

    public function getNombres(): string
    {
        return $this->nombres;
    }

    public function setNombres(string $nombres): void
    {
        $this->nombres = $nombres;
    }

    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    public function getCedula(): string
    {
        return $this->cedula;
    }

    public function setCedula(string $cedula): void
    {
        $this->cedula = $cedula;
    }

    public function getTelefono(): string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): void
    {
        $this->telefono = $telefono;
    }

    public function getDireccion(): string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): void
    {
        $this->direccion = $direccion;
    }

    public function getCargo(): string
    {
        return $this->cargo;
    }

    public function setCargo(string $cargo): void
    {
        $this->cargo = $cargo;
    }

    public function getEstado(): bool
    {
        return $this->estado;
    }

    public function setEstado(bool $estado): void
    {
        $this->estado = $estado;
    }

    public function getIdUsuario(): int
    {
        return $this->idUsuario;
    }

    public function setIdUsuario(int $idUsuario): void
    {
        $this->idUsuario = $idUsuario;
    }
}