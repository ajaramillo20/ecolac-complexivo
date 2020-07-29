<?php
require_once 'models/usuario.php';
require_once 'models/Direccion.php';
class DireccionController
{
    public function registro()
    {
        if (isset($_GET['usr'])) {
            $usrid = $_GET['usr'];
            require_once 'views/direccion/registro.php';
        }
    }

    public function editar()
    {
        if (isset($_GET['dir'])) {
            $dir = new Direccion();
            $dir->dir_id = $_GET['dir'];
            $entity = $dir->GetDireccionById();
            require_once 'views/direccion/registro.php';
        }
    }

    public function eliminar()
    {
        if (isset($_GET['dir'])) {
            $dir = new Direccion();
            $dir->dir_id = $_GET['dir'];
            $result = $dir->Eliminardireccion();

            if ($result) {
                $_SESSION['direccionGestionMensaje'] = 'Registro eliminado!';
                App::Redirect('usuario/perfil');
            } else {
                $_SESSION['direccionGestionError'] = 'No se pudo eliminar!';
                App::Redirect('usuario/perfil');
            }
        }
    }

    public function agregar()
    {
        if (isset($_POST)) {
            $dir = new Direccion();
            $dir->usr_id = $_POST['usrid'];
            $dir->dir_direccion = $_POST['direccion'];
            $dir->ciu_id = $_POST['ciudad'];
            $dir->dir_latitud = $_POST['latitud'];
            $dir->dir_longitud = $_POST['longitud'];

            $result = $dir->GuardarDireccion();

            if (is_null($result)) {
                $_SESSION['direccionRegistroError'] = 'Error al guardar dirección';
                App::Redirect('usuario/perfil');
            } else {
                $_SESSION['direccionGestionMensaje'] = 'Dirección guardara correctamente';
                App::Redirect('usuario/perfil');
            }
        }
    }

    public function actualizar()
    {
        if (isset($_POST)) {
            $dir = new Direccion();
            $dir->dir_id = $_POST['dirid'];
            $dir->dir_direccion = $_POST['direccion'];
            $dir->ciu_id = $_POST['ciudad'];
            $dir->dir_latitud = $_POST['latitud'];
            $dir->dir_longitud = $_POST['longitud'];
            $result = $dir->ActualizarDireccion();
            if ($result) {
                $_SESSION['direccionGestionMensaje'] = 'Dirección actualizada!';
                App::Redirect('usuario/perfil');
            } else {
                $_SESSION['direccionRegistroError'] = 'Error al actualizar!';
                App::Redirect('direccion/registro');
            }
        }
    }
}
