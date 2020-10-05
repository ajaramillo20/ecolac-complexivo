<?php

require_once 'models/Pantalla.php';
class PantallaController
{

    public function gestion()
    {
        $pnt = new Pantalla();
        $roles = AppController::GetRoles();

        $pnt->rol_id = isset($_SESSION['PANARGS']->rol_id) ? $_SESSION['PANARGS']->rol_id : null;
        $pnt->pnt_vinculo = isset($_SESSION['PANARGS']->ruta) ? $_SESSION['PANARGS']->ruta : null;

        $paginaActual = (isset($_SESSION['PROGARGS']) && is_numeric($_SESSION['PROGARGS']->pag)) ? $_SESSION['PROGARGS']->pag : 1;

        $pantallas = $pnt->GetAllPantallas();
        $paginas = AppController::GetPaginationList($pantallas, 10);
        $pantallas = AppController::CastQueryResultToArray($pantallas);

        $pantallas = array_slice(
            $pantallas,
            (($paginaActual - 1) * 10),
            10
        );

        require_once 'views/pantalla/gestion.php';
        App::UnsetSessionVar('PANARGS');
    }

    public function setGestionAjaxArgs()
    {
        $_SESSION['PANARGS']->rol_id = isset($_GET['rol']) ? $_GET['rol'] : null;
        $_SESSION['PANARGS']->ruta = isset($_GET['ruta']) ? $_GET['ruta'] : null;
        $_SESSION['PANARGS']->pag = isset($_GET['ruta']) ? $_GET['ruta'] : null;
        $_SESSION['PROGARGS']->pag = isset($_GET['pag']) ? $_GET['pag'] : 1;
    }

    public function registrar()
    {
        require_once 'views/pantalla/registro.php';
    }


    //CRUD
    public function agregar()
    {
        if (isset($_POST)) {
            $pnt = new Pantalla();
            $pnt->pnt_nombre = $_POST['nombre'];
            $pnt->pnt_vinculo = $_POST['ruta'];
            $pnt->pnt_menu = $_POST['menu'];
            $pnt->rol_id = $_POST['rol'];
            $entity = $pnt->AgregarPantalla();

            if (!is_null($entity)) {
                App::Redirect('pantalla/gestion');
            } else {
                App::Redirect('pantalla/registrar');
            }
        }
    }

    public function editar()
    {
        if (isset($_GET['id'])) {
            $pnt = new Pantalla();
            $pnt->pnt_id = $_GET['id'];
            $entity = $pnt->GetPantallaById();
            require_once 'views/pantalla/registro.php';
        } else {
            App::Redirect('pantalla/gestion');
        }
    }

    public function actualizar()
    {
        if (isset($_POST)) {
            $pnt = new Pantalla();
            $pnt->pnt_id = $_POST['id'];
            $pnt->pnt_nombre = $_POST['nombre'];
            $pnt->pnt_vinculo = $_POST['ruta'];
            $pnt->pnt_menu = $_POST['menu'];
            $pnt->rol_id = $_POST['rol'];

            $result = $pnt->ActualizarPantalla();
            if (!is_null($result)) {
                $_SESSION['pantallaGestionMensaje'] = 'Actualizado correctamente!';
                App::Redirect('pantalla/gestion');
            } else {
                $_SESSION['registroPantallaError'] = 'Error al actualizar';
                App::Redirect('pantalla/editar&id=' . $pnt->pnt_id);
            }
        }
    }

    public function eliminar()
    {
        if (isset($_GET['id'])) {
            $pnt = new Pantalla();
            $pnt->pnt_id = $_GET['id'];
            $result = $pnt->EliminarPantalla();
            if ($result) {
                $_SESSION['pantallaGestionMensaje'] = "Registro eliminado correctamente!";
            } else {
                $_SESSION['pantallaGestionError'] = "No se pudo eliminar!";
            }
            App::Redirect('pantalla/gestion');
        }
    }
}
