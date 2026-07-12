<?
//Autor Zhunaula Kevin

class Cliente {
    // Campos propios de la tabla 'clientes'
    private ?int $id_cliente;
    private int $id_usuario;
    private string $direccion;
    private string $fecha_nacimiento;
    private string $genero;
    private string $observaciones;

    private $nombre;
    private $correo;
    private $telefono;

    // Campos heredados/relacionados de la tabla 'usuarios' para facilitar el uso en vistas
    public function __construct(
        $id_usuario = null,
        $direccion = '',
        $fecha_nacimiento = '',
        $genero = '',
        $observaciones = ''
    ) {
        $this->id_usuario = $id_usuario;
        $this->direccion = $direccion;
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->genero = $genero;
        $this->observaciones = $observaciones;
    }

    // --- GETTERS Y SETTERS PROPIOS ---
    public function getIdCliente() { return $this->id_cliente; }
    public function setIdCliente($id_cliente) { $this->id_cliente = $id_cliente; }

    public function getIdUsuario() { return $this->id_usuario; }
    public function setIdUsuario($id_usuario) { $this->id_usuario = $id_usuario; }

    public function getDireccion() { return $this->direccion; }
    public function setDireccion($direccion) { $this->direccion = $direccion; }

    public function getFechaNacimiento() { return $this->fecha_nacimiento; }
    public function setFechaNacimiento($fecha_nacimiento) { $this->fecha_nacimiento = $fecha_nacimiento; }

    public function getGenero() { return $this->genero; }
    public function setGenero($genero) { $this->genero = $genero; }

    public function getObservaciones() { return $this->observaciones; }
    public function setObservaciones($observaciones) { $this->observaciones = $observaciones; }

    // --- GETTERS Y SETTERS DE RELACIÓN (USUARIOS) ---
    public function getNombre() { return $this->nombre; }
    public function setNombre($nombre) { $this->nombre = $nombre; }

    public function getCorreo() { return $this->correo; }
    public function setCorreo($correo) { $this->correo = $correo; }

    public function getTelefono() { return $this->telefono; }
    public function setTelefono($telefono) { $this->telefono = $telefono; }
    
}