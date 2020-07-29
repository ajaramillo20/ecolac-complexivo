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
        if (isset($_GET['id'])) {
            $pro_id = $_GET['id'];
            $pro = new Producto();
            $pro->pro_id = $_GET['id'];
            $producto = $pro->GetProductoById();


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
    }
}
