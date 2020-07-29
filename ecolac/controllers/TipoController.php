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
}
