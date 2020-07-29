<?php

require_once 'models/Presentacion.php';

class PresentacionController
{
    //rutas
    public function registrar()
    {
        require_once 'views/presentacion/registro.php';
    }

    public function editar()
    {
        if (isset($_GET['id'])) {
            $pre = new Presentacion();
            $pre->pre_id = $_GET['id'];
            $entity = $pre->GetPresentacionById();

            require_once 'views/presentacion/registro.php';
        } else {
            App::Redirect('tipo/gestion');
        }
    }

    //CRUD
    public function agregar()
    {
        if (isset($_POST)) {
            $pre = new Presentacion();
            $pre->pre_nombre = $_POST['nombre'];

            if (!is_null($pre->AgregarPresentacion())) {
                $_SESSION['presentacionGestionMensaje'] = 'Prsentación agregada';
                App::Redirect('tipo/gestion');
            } else {
                $_SESSION['presentacionRegistroError'] = 'Error al agregar';
                App::Redirect('presentacion/registrar');
            }
        }
    }

    public function eliminar()
    {
        if ($_GET['id']) {
            $pre = new Presentacion();
            $pre->pre_id = $_GET['id'];
            $result = $pre->EliminarPresentacion();

            if ($result) {
                $_SESSION['presentacionGestionMensaje'] = 'Registro eliminado';
            } else {
                $_SESSION['presentacionGestionError'] = 'Error al eliminar!';
            }
            App::Redirect('tipo/gestion');
        }
    }

    public function actualizar()
    {
        if ($_POST) {
            $pre = new Presentacion();
            $pre->pre_id = $_POST['pre_id'];
            $pre->pre_nombre = $_POST['nombre'];
            $result = $pre->ActualizarPresentacion();

            if (!is_null($result)) {
                App::Redirect('tipo/gestion');
                $_SESSION['presentacionGestionMensaje'] = 'Registro actualizado';
            } else {
                $_SESSION['presentacionRegistroError'] = 'Error al actualizar';
                App::Redirect('presentacion/registrar');
            }
        }
    }
}
