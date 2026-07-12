<?
// autor: Zhunaula Kevin

require_once "models/dao/Usuarios/Cliente.DAO.php";
require_once "models/dao/Usuarios/UsuarioDAO.php";
require_once "models/dto/Usuarios/Cliente.php";

class ClienteController
{
    public function registrarCliente() 
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recibimos los datos del formulario
            //datos para la tabla usuarios
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            $contrasena = $_POST['contrasena'];
            $telefono = $_POST['telefono'];
            // Fecha se establece en la base de datos con CURRENT_TIMESTAMP, por lo que no es necesario recibirla del formulario
            //El estado se establece en 1 (activo) por defecto, por lo que tampoco es necesario recibirlo del formulario

            //datos para la tabla clientes
            $direccion = $_POST['direccion'];
            $fechaNacimiento = $_POST['fecha_nacimiento'];
            $genero = $_POST['genero'];
            $observaciones = $_POST['observaciones'];
            //El estado se obtiene de usuarios

            // Crear el objeto Usuario
            $usuario = new Usuario(
                $nombre,
                $correo,
                $contrasena,
                $telefono,
                3 // idRol para clientes
            );

            // Insertar el usuario y obtener el ID generado
            $idUsario = new UsuarioDAO()->insertarUserCliente($usuario);

            // Insertar el cliente
            if(!empty($idUsario)) {
                $cliente = new Cliente(
                    $idUsario,
                    $direccion,
                    $fechaNacimiento,
                    $genero,
                    1, // estado activo
                    $observaciones
                );
                $resultado = new ClienteDAO()->insertar($cliente);

                if ($resultado) {
                    echo "Cliente registrado exitosamente.";
                } else {
                    echo "Error al registrar el cliente.";
                }
            } else {
                echo "Error al registrar el usuario.";
            }
            
        }
    }
}
