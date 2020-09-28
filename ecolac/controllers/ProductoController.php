<?php

require_once 'models/Producto.php';
require_once 'models/Recurso.php';
class ProductoController
{
    public function index()
    {
        $sucursales = AppController::GetSucursales();
        $tipos = AppController::GetTipos();
        $pro = new Producto();

        $pro->suc_id = isset($_SESSION['succonnect']->suc_id) ? $_SESSION['succonnect']->suc_id : null;
        $pro->tip_id = isset($_SESSION['PROARGS']->tip_id) ? $_SESSION['PROARGS']->tip_id : null;
        $pro->pro_nombre = isset($_SESSION['PROARGS']->pro_nombre) ? $_SESSION['PROARGS']->pro_nombre : null;
        $paginaActual = (isset($_SESSION['PROARGS']) && is_numeric($_SESSION['PROARGS']->pag)) ? $_SESSION['PROARGS']->pag : 1;

        $productos = $pro->GetAllProductos();
        $paginas = AppController::GetPaginationList($productos, 10);
        $productos = AppController::CastQueryResultToArray($productos);

        $productos = array_slice(
            $productos,
            (($paginaActual - 1) * 10),
            10
        );

        require_once 'views/producto/catalogo.php';
        APP::UnsetSessionVar('PROARGS');
    }

    public function selectsucursal()
    {
        $_SESSION['PROARGS']->suc_id = isset($_GET['suc']) ? $_GET['suc'] : null;
        $_SESSION['PROARGS']->tip_id = isset($_GET['cat']) ? $_GET['cat'] : null;
        $_SESSION['PROARGS']->pro_nombre = isset($_GET['pro']) ? $_GET['pro'] : null;
        $_SESSION['PROARGS']->pag = isset($_GET['pag']) ? $_GET['pag'] : 1;
        if (isset($_GET['suc'])) {
            $suc = AppController::GetSucursalById($_GET['suc']);
            if (!is_null($suc)) {
                App::SetSucursalSession($suc);
            }
        } else {
            App::UnsetSessionVar('succonnect');
        }
    }

    public function gestion()
    {
        $pro = new Producto();
        $productos = $pro->GetAllProductos();
        require_once 'views/producto/gestion.php';
    }

    public function registrar()
    {
        require_once 'views/producto/registro.php';
    }

    public function editar()
    {
        if (isset($_GET['id'])) {
            $pro = new Producto();
            $pro->pro_id = $_GET['id'];
            $entity = $pro->GetProductoById();
            require_once 'views/producto/registro.php';
        }
    }

    public function actualizar()
    {
        if (isset($_POST)) {
            $pro = new Producto();
            $pro->pro_id = $_POST['pro_id'];
            $pro->pro_nombre = $_POST['nombre'];
            $pro->tip_id = $_POST['tipo'];
            $pro->cat_id = $_POST['categoria'];
            $pro->pre_id = $_POST['presentacion'];
            $pro->suc_id = $_POST['sucursal'];
            $pro->pro_valor = $_POST['valor'];
            $pro->pro_cantStock = $_POST['stock'];

            $archivo = $_FILES['imagen'];

            if ($archivo['size'] == 0) {
                $pro->Recurso = null;
            } else {
                if (App::UploadImage($archivo)) {
                    $pro->Recurso = new Recurso();
                    $pro->Recurso->rec_id = $_POST['rec_id'];
                    $pro->Recurso->rec_nombre = $archivo['name'];
                    $pro->Recurso->rec_tipo = $archivo['type'];
                }
            }
            $result = $pro->ActualizarProducto();
            if (!is_null($result)) {
                $_SESSION['productoGestionMensaje'] = 'Producto actualizado correctamente!';
                App::Redirect('producto/gestion');
            } else {
                $_SESSION['productoRegistroError'] = 'Error al actualizar';
                App::Redirect('producto/registrar');
            }
        }
    }

    public function eliminar()
    {
        if (isset($_GET['id'])) {
            $pro = new Producto();
            $pro->pro_id = $_GET['id'];

            $pro->EliminarProducto();
        }
    }

    public function agregar()
    {
        if (isset($_POST)) {

            $pro = new Producto();
            $pro->Recurso =  new Recurso();

            $pro->pro_nombre = $_POST['nombre'];
            $pro->tip_id = $_POST['tipo'];
            $pro->cat_id = $_POST['categoria'];
            $pro->pre_id = $_POST['presentacion'];
            $pro->suc_id = $_POST['sucursal'];
            $pro->pro_valor = $_POST['valor'];
            $pro->pro_cantStock = $_POST['stock'];

            $archivo = $_FILES['imagen'];

            // var_dump($_POST);
            // var_dump($_FILES);
            // var_dump($pro);
            // die();
            if (App::UploadImage($archivo, products_path)) {
                $pro->Recurso->rec_nombre = $archivo['name'];
                $pro->Recurso->rec_tipo = $archivo['type'];
                $result = $pro->AgregarProducto();
                if (!is_null($result)) {
                    $_SESSION['productoGestionMensaje'] = 'Producto agregado correctamente!';
                    App::Redirect('producto/gestion');
                } else {
                    $_SESSION['productoRegistroError'] = 'Error al agregar';
                    App::Redirect('producto/registrar');
                }
            }
        }
    }
}
