<?php

require_once 'models/Pedido.php';

class PedidoController
{
    public function realizar()
    {
        require_once 'views/pedido/registro.php';
    }

    public function agregar()
    {
        try {
            if (isset($_POST)) {                
                $ped = new pedido();
                $ped->usr_id = $_SESSION['userconnect']->usr_id;
                $ped->dir_id = $_POST['direccion'];
                $ped->ped_costo = App::EstadisticasCarrito()['total'];
                $result = $ped->GuardarPedido();

                if (!is_null($result)) {
                    $_SESSION['pedidoMisPedidosMensaje'] = 'Su pedido se guardo correctamente!';
                    App::Redirect('pedido/mispedidos');
                } else {
                    $_SESSION['carritoIndexError'] = 'Intente realizar su pedido mas tarde!';
                    App::Redirect('carrito/index');
                }
            }
        } catch (\Throwable $th) {
            $_SESSION['carritoIndexError'] = $th->getMessage();
            App::Redirect('carrito/index');
        }
    }

    public function mispedidos()
    {
        require_once 'views/pedido/mispedidos.php';
    }
}
