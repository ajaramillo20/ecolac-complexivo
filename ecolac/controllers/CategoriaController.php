<?php
require_once 'models/categoria.php';

class CategoriaController
{
    public function gestion()
    {
        $categoria = new Categoria();
        $categorias = $categoria->GetAllCategorias();
        require_once 'views/categoria/gestion.php';
    }

    public function agregar()
    {
        if (isset($_POST)) {
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : null;
            $tipo = isset($_POST['tipo']) ? $_POST['tipo'] : null;

            if (!is_null($nombre) && !is_null($tipo)) {
                $categoria = new Categoria();
                $categoria->cat_nombre = $nombre;
                $categoria->tip_id = $tipo;
                $entity = $categoria->AgregarCategoria();

                if (!is_null($entity)) {
                    App::Redirect('categoria/gestion');
                } else {
                    App::Redirect('categoria/registrar');
                }
            } else {
                $_SESSION['registroCategoriaError'] = 'Ingrese un nombre válido';
            }
        }
    }

    public function registrar()
    {
        require_once 'views/categoria/registro.php';
    }

    public function editar()
    {
        if (isset($_GET['id'])) {
            $editar = true;
            $categoria = new Categoria();
            $categoria->cat_id = $_GET['id'];
            $entity = $categoria->GetCategoriaById();

            require_once 'views/categoria/registro.php';
        } else {
            App::Redirect('categoria/gestion');
        }
    }

    public function actualizar()
    {
        if (isset($_POST)) {

            $cat = new Categoria();
            $cat->cat_id = $_POST['catid'];
            $cat->cat_nombre = $_POST['nombre'];
            $cat->tip_id = $_POST['tipo'];

            $result = $cat->ActualizarCategoria();

            if (!is_null($result)) {
                App::Redirect('categoria/gestion');
            } else {
                App::Redirect('categoria/editar&id=' . $cat->cat_id);
            }
        }
    }
    public function eliminar()
    {
        if (isset($_GET['id'])) {
            $idCategoria = $_GET['id'];

            $categoria = new Categoria();
            $categoria->cat_id = $idCategoria;
            $categoria->Eliminar();

            App::Redirect('categoria/gestion');
        } else {
            App::Redirect('categoria/gestion');
        }
    }
}