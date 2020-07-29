<?php

class AppController
{
    public static function GetCidades()
    {
        require_once 'models/ciudad.php';
        $ciudad = new Ciudad();
        return $ciudad->GetCiudades();
    }

    public static function GetMenuByRol($rol_id)
    {
        require_once 'models/Pantalla.php';
        $pantalla = new Pantalla();
        $pantalla->rol_id = $rol_id;
        return $pantalla->GetPantallasRol();
    }

    public static function GetTipos()
    {
        require_once 'models/Tipo.php';
        $tipo = new Tipo();
        return $tipo->GetAllTipos();
    }

    public static function GetCategorias()
    {
        require_once 'models/Categoria.php';
        $cat = new Categoria();
        return $cat->GetAllCategorias();
    }

    public static function GetRoles()
    {
        require_once 'models/Rol.php';
        $rol = new Rol();
        return $rol->GetRoles();
    }

    public static function GetPresentacion()
    {
        require_once 'models/Presentacion.php';
        $pre = new Presentacion();
        return $pre->GetAllPresentaciones();
    }

    public static function GetPagination($name)
    {
        require_once 'models/Paginacion.php';
        $pag = new Paginacion();
        $total = $pag->GetTotal($name);
    }

    public static function GetSucursales()
    {
        require_once 'models/Sucursal.php';
        $suc = new Sucursal();
        return $suc->GetAllSucursales();
    }

    public static function GetDirecciones($usrid)
    {
        require_once 'models/Direccion.php';
        $dir = new Direccion();
        $dir->usr_id = $usrid;
        return $dir->GetDireccionByUsuario();
    }

    public static function GetPedidosByUsuarioId($usrid)
    {
        require_once 'models/Pedido.php';
        $ped = new Pedido();
        $ped->usr_id = $usrid;
        return $ped->GetPedidosByUserId();
    }
}
