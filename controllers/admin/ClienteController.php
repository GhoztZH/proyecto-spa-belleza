<?php
// autor: Zhunaula Kevin

require_once "models/dao/usuarios/Cliente.DAO.php";
require_once "models/dao/usuarios/UsuarioDAO.php";
require_once "models/dto/usuarios/cliente.php";
require_once "models/dto/usuarios/usuario.php";

class ClienteController
{
    public function registrarCliente()
    {
        $clienteDAO = new ClienteDAO();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recibimos los datos del formulario
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            $contrasena = $_POST['contrasena'];
            $telefono = $_POST['telefono'];
            $direccion = $_POST['direccion'];
            $fechaNacimiento = $_POST['fecha_nacimiento'];
            $genero = $_POST['genero'];
            $observaciones = $_POST['observaciones'];

            // Crear el objeto Usuario
            $usuario = new Usuario(null, $nombre, $correo, $contrasena, $telefono, true, "", 3); // Rol 3: Cliente

            // Insertar el usuario y obtener el ID generado
            $idUsuario = (new UsuarioDAO())->insertarUserCliente($usuario);

            // Insertar el cliente
            if (!empty($idUsuario)) {
                $cliente = new Cliente(
                    $idUsuario,
                    $direccion,
                    $fechaNacimiento,
                    $genero,
                    $observaciones
                );
                $resultado = $clienteDAO->insertar($cliente);

                if ($resultado) {
                    // Redirección limpia indicando éxito 
                    header("Location: index.php?controller=cliente&action=registrarCliente&status=success");
                    exit; // Detiene la ejecución aquí para que el navegador cambie de URL
                } else {
                    header("Location: index.php?controller=cliente&action=registrarCliente&status=error");
                    exit;
                }
            } else {
                header("Location: index.php?controller=cliente&action=registrarCliente&status=error_user");
                exit;
            }
        }

        // Si entra por GET (carga normal de la página o después de la redirección)
        $clientes = $clienteDAO->obtenerTodos();
        require_once "views/admin/clientes_crud.php";
    }
}
