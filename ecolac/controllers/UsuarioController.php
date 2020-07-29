<?php

require_once 'models/Usuario.php';
require_once 'models/Direccion.php';
require_once 'models/Ciudad.php';

class UsuarioController
{
    public function index()
    {
        echo "<h1>Controlador usuario, acción index</h1>";
    }

    public function gestion()
    {
        $usr = new Usuario();
        $usuarios = $usr->GetAllUsuarios();
        require_once 'views/usuario/gestion.php';
    }

    public function registrar()
    {
        require_once 'views/usuario/registro.php';
    }

    public function registroCompleto()
    {
        require_once 'views/usuario/registroCompleto.php';
    }

    public function perfil()
    {
        $usr = new Usuario();
        $usr->usr_id = $_SESSION['userconnect']->usr_id;
        $entity = $usr->GetUserById();
        require_once 'views/usuario/perfil.php';
        require_once 'views/direccion/gestion.php';
    }

    public function login()
    {
        require_once 'views/usuario/login.php';
    }

    public function logout()
    {
        App::UnsetSessionVar('carrito');
        App::UnsetSessionVar('userconnect');
        App::Redirect();
    }

    public function autenticacion()
    {
        if (isset($_POST)) {

            $correo = isset($_POST['correo']) ? $_POST['correo'] : '';
            $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : '';

            $usr = new Usuario();
            $result = $usr->IniciarSesion($correo, $contrasena);
            //var_dump($result);

            if ($result && !is_null($result)) {
                $_SESSION["userconnect"] = $result;
                App::Redirect();
            } else {
                $_SESSION['loginError'] = 'Usuario o contraseña incorrectos';
                App::Redirect('usuario/login');
            }
        }
    }

    public function editar()
    {
        if (isset($_GET['id'])) {
            $usr = new Usuario();
            $usr->usr_id = $_GET['id'];
            $entity = $usr->GetUserById();

            require_once 'views/usuario/registro.php';
            require_once 'views/direccion/gestion.php';
        } else {
            App::Redirect('usuario/gestion');
        }
    }

    //CRUD
    public function agregar()
    {
        if (isset($_POST)) {
            $usr = new Usuario();
            $usr->usr_nombre = $_POST['nombre'];
            $usr->usr_cedula = $_POST['cedula'];
            $usr->usr_contrasena = $_POST['contrasena'];
            $usr->usr_correo = $_POST['correo'];
            $usr->usr_telefono = $_POST['telefono'];
            $usr->usr_usuario = $_POST['usuario'];

            $dir = new Direccion();
            $dir->dir_direccion = $_POST['direccion'];
            $dir->dir_latitud = $_POST['latitud'];
            $dir->dir_longitud = $_POST['longitud'];
            $dir->ciu_id = $_POST['ciudad'];
            array_push($usr->Direccion, $dir);

            //$usr->Direccion = $dir;

            $usr = $usr->GuardarUsuario();

            if (is_null($usr)) {
                App::Redirect('usuario/registro');
            } else {
                App::Redirect('usuario/registroCompleto');
            }
        }
    }

    public function actualizar()
    {
        if (isset($_POST)) {
            $usr = new Usuario();
            $usr->usr_id = $_POST['usr_id'];
            $usr->usr_nombre = $_POST['nombre'];
            $usr->usr_cedula = $_POST['cedula'];
            $usr->usr_correo = $_POST['correo'];
            $usr->usr_telefono = $_POST['telefono'];
            $usr->usr_usuario = $_POST['usuario'];
            $usr->rol_id = $_POST['rol'];
            $usr->suc_id = App::IsNullOrEmptyString($_POST['sucursal']) ? 'null' : $_POST['sucursal'];

            $result = $usr->ActualizarUsuario();

            if (!is_null($result)) {
                App::Redirect('usuario/gestion');
            } else {
                App::Redirect('usuario/editar&id=' . $usr->usr_id);
            }
        }
    }

    public function actualizarperfil()
    {
        if (isset($_POST)) {
            //var_dump($_POST);
        }
    }

    public function eliminar()
    {
        if (isset($_GET['id'])) {
            $usr = new Usuario();
            $usr->usr_id = $_GET['id'];
            $result = $usr->EliminarUsuario();
            if ($result) {
                $_SESSION['usuarioGestionMensaje'] = 'Usuario eliminado correctamente';
            } else {
                $_SESSION['usuarioGestionError'] = 'Error al eliminar usuario';
            }
            App::Redirect('usuario/gestion');
            //App::Redirect('usuario/gestion');
        }
    }
}
