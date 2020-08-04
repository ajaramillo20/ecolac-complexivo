<?php

require_once 'models/Producto.php';

class CarritoController
{

    public function index()
    {
        $carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : array();
        require_once 'views/carrito/index.php';
    }

    public function agregar()
    {
        try {
            if (isset($_GET['id'])) {
                $pro_id = $_GET['id'];
                $pro = new Producto();
                $pro->pro_id = $_GET['id'];
                $producto = $pro->GetProductoById();
                $this->ValidarCarrito($producto);
                $counter = 0;
                if (isset($_SESSION['carrito'])) {
                    foreach ($_SESSION['carrito'] as $indice => $elemento) {
                        if ($elemento['pro_id'] == $producto->pro_id) {
                            $_SESSION['carrito'][$indice]['unidades']++;
                            $counter++;
                        }
                    }
                }

                if ($counter == 0) {
                    $_SESSION['carrito'][] = array(
                        'pro_id' => $producto->pro_id,
                        'pro_valor' => $producto->pro_valor,
                        'unidades' => 1,
                        'producto' => $producto
                    );
                }

                App::Redirect('carrito/index');
            }
        } catch (\Throwable $th) {
            $_SESSION['carritoIndexError'] = $th->getMessage();
            App::Redirect('carrito/index');
        }
    }

    private function ValidarCarrito($pro)
    {
        if (isset($_SESSION['succonnect'])) {

            if ($pro->suc_id != $_SESSION['succonnect']->suc_id) {
                throw new Exception("Este producto no es de la sucursal seleccionada");
            }
        } else {
            throw new Exception("Regitre una dirección o seleccione una sucursal");
        }
    }

    public function eliminar()
    {
        if (isset($_GET['id'])) {
            $pro_id = $_GET['id'];
            $pro = new Producto();
            $pro->pro_id = $_GET['id'];
            $producto = $pro->GetProductoById();

            $counter = 0;
            if (isset($_SESSION['carrito'])) {
                foreach ($_SESSION['carrito'] as $indice => $elemento) {
                    if ($elemento['pro_id'] == $producto->pro_id) {
                        if ($_SESSION['carrito'][$indice]['unidades'] > 1) {
                            $_SESSION['carrito'][$indice]['unidades']--;
                        } else {
                            unset($_SESSION['carrito'][$indice]);
                        }
                    }
                }
            }




            App::Redirect('carrito/index');
        }
    }

    public function limpiarcarrito()
    {
        App::UnsetSessionVar('carrito');
        App::Redirect('carrito/index');
    }
}
