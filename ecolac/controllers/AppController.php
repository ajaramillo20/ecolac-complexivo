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

    public static function GetEstados()
    {
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

    public static function GetPagination($name, $tamaño = 20)
    {
        require_once 'models/Paginacion.php';
        require_once 'models/class/PaginacionResult.php';

        $pag = new Paginacion();
        $total = $pag->GetTotal($name);

        $result = new PaginacionResult();
        $result->Rows = $total;
        $result->Paginas = ($total > 0) ? ceil(($total / $tamaño)) : 0;

        return $result;
    }

    public static function GetPaginationList($list, $tamano = 20)
    {
        require_once 'models/class/PaginacionResult.php';

        $result = new PaginacionResult();
        $result->Rows = $list->num_rows;
        $result->Paginas = ($result->Rows > 0) ? ceil(($result->Rows / $tamano)) : 0;

        return $result;
    }

    public static function GetPaginationListArray($list, $tamano = 20)
    {
        require_once 'models/class/PaginacionResult.php';

        $result = new PaginacionResult();
        $result->Rows = count($list);
        $result->Paginas = ($result->Rows > 0) ? ceil(($result->Rows / $tamano)) : 0;

        return $result;
    }

    public static function GetSucursales()
    {
        require_once 'models/Sucursal.php';
        $suc = new Sucursal();
        return $suc->GetAllSucursales();
    }

    public static function GetsucursalById($sucid)
    {
        require_once 'models/Sucursal.php';
        $suc = new Sucursal();
        $suc->suc_id = $sucid;
        return $suc->GetsucursalById();
    }

    public static function GetDirecciones($usrid)
    {
        require_once 'models/Direccion.php';
        $dir = new Direccion();
        $dir->usr_id = $usrid;
        return $dir->GetDireccionByUsuario();
    }

    public static function GetDireccionById($dirid)
    {
        require_once 'models/Direccion.php';
        $dir = new Direccion();
        $dir->dir_id = $dirid;
        return $dir->GetDireccionById();
    }

    public static function GetPedidosByUsuarioId($usrid)
    {
        require_once 'models/Pedido.php';
        $ped = new Pedido();
        $ped->usr_id = $usrid;
        return $ped->GetPedidosByUserId();
    }

    public static function GetDefaultUserDir($usrid)
    {
        $dir = new Direccion();
        $dir->usr_id = $usrid;
        return $dir->GetDireccionPredeterminada();
    }

    public static function CastQueryResultToArray($result)
    {
        $array = [];
        if ($result) {
            while ($r = $result->fetch_object()) {
                $array[] = $r;
            }
        }
        return $array;
    }
}
