<?php

require_once 'models/configuracion.php';
class ConfiguracionController
{

    public function gestion()
    {
        $conf = new Configuracion();

        $configuraciones = $conf->GetAllConfiguracion();
        $configuraciones = AppController::CastQueryResultToArray($configuraciones);
        require_once 'views/configuracion/gestion.php';
    }

    public function registrar()
    {
        require_once 'views/configuracion/registro.php';
    }

    public function editar()
    {
        $conf = new Configuracion();
        $conf->conf_id = $_GET['id'];

        $entidad = $conf->GetConfiguracionById();
        require_once 'views/configuracion/registro.php';
    }

    public function agregar()
    {
        try {
            $descripcion = $_POST['descripcion'];
            $valor = $_POST['valor'];

            $conf = new Configuracion();
            $conf->conf_descripcion = $descripcion;
            $conf->conf_valor = $valor;

            $result = $conf->AddConfiguracion();

            $_SESSION['configuracionGestionMensaje'] = 'Configuración agregada!';
            App::Redirect('configuracion/gestion');
        } catch (\Throwable $th) {
            $_SESSION['configuracionGestionMensaje'] = $th->getMessage();
            App::Redirect('configuracion/gestion');
        }
    }

    public function actualizar()
    {
        try {
            $descripcion = $_POST['descripcion'];
            $valor = $_POST['valor'];
            $id = $_POST['id'];

            $conf = new Configuracion();
            $conf->conf_descripcion = $descripcion;
            $conf->conf_valor = $valor;
            $conf->conf_id = $id;

            $result = $conf->UpdateConfiguracion();

            $_SESSION['configuracionGestionMensaje'] = 'Configuración actualizada!';
            App::Redirect('configuracion/gestion');
        } catch (\Throwable $th) {
            $_SESSION['configuracionGestionError'] = $th->getMessage();
            App::Redirect('configuracion/gestion');
        }
    }

    public function eliminar()
    {
        try {
            $id = $_GET['id'];

            $conf = new Configuracion();
            $conf->conf_id = $id;
                        
            $conf->DeleteConfiguracion();

            $_SESSION['configuracionGestionMensaje'] = 'Configuración Eliminada!';
            App::Redirect('configuracion/gestion');
        } catch (\Throwable $th) {
            $_SESSION['configuracionGestionError'] = $th->getMessage();
            App::Redirect('configuracion/gestion');
        }
    }
}
