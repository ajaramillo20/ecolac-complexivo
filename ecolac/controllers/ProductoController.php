<?php

require_once 'models/Producto.php';
require_once 'models/Recurso.php';

class ProductoController
{
    public function index()
    {
        $sucursales = AppController::GetSucursales();
        if (isset($_SESSION['succonnect']) && !is_null($_SESSION['succonnect'])) {
            $pro = new Producto();
            $pro->suc_id = $_SESSION['succonnect']->suc_id;
            $productos = $pro->GetAllProductosBySucusal();
            require_once 'views/producto/catalogo.php';
        } 
        else {
            $pro = new Producto();
            $productos = $pro->GetAllProductos();
            require_once 'views/producto/catalogo.php';
        }
    }

    public function selectsucursal()
    {
        if (isset($_GET['suc'])) {
            $suc = AppController::GetSucursalById($_GET['suc']);
            if (!is_null($suc)) {
                App::SetSucursalSession($suc);
            }
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