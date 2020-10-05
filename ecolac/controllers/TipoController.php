<?php

require_once 'models/Tipo.php';

class TipoController
{
    public function gestion()
    {
        $tipo = new Tipo();
        $tipos = $tipo->GetAllTipos();
        require_once 'views/tipo/gestion.php';
    }

    public function registrar()
    {
        require_once 'views/tipo/registro.php';
    }

    public function agregar()
    {
        App::UnsetSessionVar('registroTipoError');
        if (isset($_POST)) {
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;

            if (!is_null($nombre)) {
                $tipo = new Tipo();
                $tipo->tip_nombre = $nombre;
                $entity = $tipo->GuardarTipo();

                if (!is_null($entity)) {
                    App::Redirect('tipo/gestion');
                } else {
                    App::Redirect('tipo/registrar');
                }
            } else {
                $_SESSION['registroTipoError'] = 'Ingrese un nombre válido';
            }
        }
    }

    public function actualizar()
    {
        try {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];

            $tip = new Tipo();
            $tip->tip_id = $id;
            $tip->tip_nombre = $nombre;

            $tip->UpdateTipo();
            $_SESSION['tipoGestionMensaje'] = 'Registro actualizado!';
            App::Redirect('tipo/gestion');
        } catch (\Throwable $th) {
            $_SESSION['tipoGestionError'] = $th->getMessage();
            App::Redirect('tipo/gestion');
        }
    }

    public function eliminar()
    {
        try {
            $id = $_GET['id'];
            $tip = new Tipo();
            $tip->tip_id = $id;
            $tip->DeleteTipo();

            $_SESSION['tipoGestionMensaje'] = 'Registro eliminado!';
            App::Redirect('tipo/gestion');
        } catch (\Throwable $th) {
            $_SESSION['tipoGestionError'] = $th->getMessage();
            App::Redirect('tipo/gestion');
        }
    }

    public function editar()
    {
        $id = $_GET['id'];

        $tip = new Tipo();
        $tip->tip_id = $id;

        $entity = $tip->GetTipoById();

        require_once 'views/tipo/registro.php';
    }
}
