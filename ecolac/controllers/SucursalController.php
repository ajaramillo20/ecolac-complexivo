<?php

require_once 'models/Sucursal.php';
require_once 'models/Direccion.php';

class SucursalController
{
    public function gestion()
    {
        $suc = new Sucursal();
        $sucursales = $suc->GetAllSucursales();
        require_once 'views/sucursal/gestion.php';
    }

    public function registrar()
    {
        require_once 'views/sucursal/registro.php';
    }

    public function editar()
    {
        if (isset($_GET['id'])) {
            $suc = new Sucursal();
            $suc->suc_id = $_GET['id'];
            $entity =  $suc->GetSucursalById();
            require_once 'views/sucursal/registro.php';
        } else {
            App::Redirect("pantalla/gestion");
        }
    }

    //CRUD
    public function agregar()
    {
        if (isset($_POST)) {
            $suc = new Sucursal();
            $suc->suc_nombre = $_POST['nombre'];

            $dir = new Direccion();
            $dir->dir_direccion = $_POST['direccion'];
            $dir->ciu_id = $_POST['ciudad'];
            $dir->dir_latitud = $_POST['latitud'];
            $dir->dir_longitud = $_POST['longitud'];

            $suc->Direccion = $dir;

            $result = $suc->AgregarSucursal();

            if (!is_null($result)) {
                $_SESSION['sucursalGestionMensaje'] = 'Sucursal registrada!';
                App::Redirect('sucursal/gestion');
            } else {
                $_SESSION['sucursalRegistroError'] = 'Error al guardar';
                App::Redirect('sucursal/registrar');
            }
        }
    }

    public function actualizar()
    {
        if (isset($_POST)) {
            $suc = new Sucursal();
            $suc->Direccion = new Direccion();

            $suc->suc_id = $_POST['suc_id'];
            $suc->suc_nombre = $_POST['nombre'];

            $suc->Direccion->dir_direccion = $_POST['direccion'];
            $suc->Direccion->dir_id = $_POST['dir_id'];
            $suc->Direccion->dir_latitud = $_POST['latitud'];
            $suc->Direccion->dir_longitud = $_POST['longitud'];
            $suc->Direccion->ciu_id = 1;

            $updateResult =  $suc->ActualizarSucursal();

            if (!is_null($updateResult)) {
                $_SESSION['sucursalGestionMensaje'] = 'Registro actualizado correctamente';
                App::Redirect('sucursal/gestion');
            } else {
                $_SESSION['sucursalRegistroError'] = 'Error al actualizar este registro';
                App::Redirect('pantalla/editar&id=' . $suc->suc_id);
            }
        }
    }

    public function eliminar()
    {
        if (isset($_GET['id'])) {
            $suc = new Sucursal();
            $suc->suc_id = $_GET['id'];

            $result = $suc->EliminarSucursal();

            if ($result) {
                $_SESSION['sucursalGestionMensaje'] = 'Registro eliminado!';
                App::Redirect('sucursal/gestion');
            } else {
                $_SESSION['sucursalGestionError'] = 'Error al eliminar';
                App::Redirect('sucursal/gestion');
            }
        }
    }
}
