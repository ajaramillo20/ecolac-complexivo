<?php

require_once 'models/Proveedor.php';

class ProveedorController
{
    public function gestion()
    {
        $prv =  new Proveedor();
        $proveedores = $prv->GetAllProveedores();

        require_once 'views/proveedores/gestion.php';
    }
}