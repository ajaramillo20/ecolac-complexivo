<?php

require_once 'models/Pedido.php';

class PedidoController
{
    public function realizar()
    {
        $this->ValidarSucursal();
        require_once 'views/pedido/registro.php';
    }

    public function gestion()
    {
        $ped = new Pedido();
        $pedidos = $ped->GetAllPedidos();
        require_once 'views/pedido/reporte.php';
    }

    public function pedidossucursal()
    {
        $ped = new Pedido();
        $estados = PedidosEstatus::GetAllEstatus();
        $ped->suc_id = $_SESSION['userconnect']->suc_id;

        $ped->usr_id = isset($_SESSION['VENARGS']->nombre) ? $_SESSION['VENARGS']->nombre : null;
        $ped->ped_fecha = isset($_SESSION['VENARGS']->fec) ? $_SESSION['VENARGS']->fec : null;
        $ped->pes_id = isset($_SESSION['VENARGS']->estado) ? $_SESSION['VENARGS']->estado : null;
        $paginaActual = (isset($_SESSION['VENARGS']) && is_numeric($_SESSION['VENARGS']->pag)) ? $_SESSION['VENARGS']->pag : 1;

        $pedidos = $ped->GetAllPedidosBySuc();
        $paginas = AppController::GetPaginationListArray($pedidos, 5);
        //$pedidos = AppController::CastQueryResultToArray($pedidos);

        $pedidos = array_slice(
            $pedidos,
            (($paginaActual - 1) * 5),
            5
        );
        require_once 'views/pedido/gestion.php';

        App::UnsetSessionVar('VENARGS');
    }

    public function setVentasAjaxParams()
    {
        $_SESSION['VENARGS']->estado = isset($_GET['est']) ? $_GET['est'] : null;
        $_SESSION['VENARGS']->fec = isset($_GET['fec']) ? $_GET['fec'] : null;
        $_SESSION['VENARGS']->nombre = isset($_GET['nom']) ? $_GET['nom'] : null;
        $_SESSION['VENARGS']->pag = isset($_GET['pag']) ? $_GET['pag'] : 1;
    }

    public function setEntregasAjaxParams()
    {
        $_SESSION['ENARGS']->estado = isset($_GET['est']) ? $_GET['est'] : null;
        $_SESSION['ENARGS']->fec = isset($_GET['fec']) ? $_GET['fec'] : null;
        $_SESSION['ENARGS']->nombre = isset($_GET['nom']) ? $_GET['nom'] : null;
        $_SESSION['ENARGS']->pag = isset($_GET['pag']) ? $_GET['pag'] : 1;
    }

    public function entregassucursal()
    {
        $estados = PedidosEstatus::GetAllEstatus();
        $ped = new Pedido();
        $ped->suc_id = $_SESSION['userconnect']->suc_id;
        $ped->usr_id = isset($_SESSION['ENARGS']->nombre) ? $_SESSION['ENARGS']->nombre : null;
        $ped->ped_fecha = isset($_SESSION['ENARGS']->fec) ? $_SESSION['ENARGS']->fec : null;
        $ped->pes_id = isset($_SESSION['ENARGS']->estado) ? $_SESSION['ENARGS']->estado : null;
        $paginaActual = (isset($_SESSION['ENARGS']) && is_numeric($_SESSION['ENARGS']->pag)) ? $_SESSION['ENARGS']->pag : 1;

        $pedidos = array();
        foreach ($ped->GetAllPedidosBySuc() as $ped) {
            if ($ped->pes_nombre == PedidosEstatus::Despachado || $ped->pes_nombre == PedidosEstatus::EnCamino || $ped->pes_nombre == PedidosEstatus::Entregado) {
                array_push($pedidos, $ped);
            }
        }

        $paginas = AppController::GetPaginationListArray($pedidos, 5);
        //$pedidos = AppController::CastQueryResultToArray($pedidos);

        $pedidos = array_slice(
            $pedidos,
            (($paginaActual - 1) * 5),
            5
        );

        require_once 'views/pedido/entregassucursal.php';
    }


    public function gestionentrega()
    {
        if (isset($_GET['id'])) {
            $ped = new Pedido();
            $ped->ped_id = $_GET['id'];
            $entity = $ped->GetPedidoById();
            require_once 'views/pedido/gestionentrega.php';
        }
    }

    public function gestionpedido()
    {
        if (isset($_GET['id'])) {
            $ped = new Pedido();
            $ped->ped_id = $_GET['id'];
            $entity = $ped->GetPedidoById();
            require_once 'views/pedido/gestionpedido.php';
        }
    }

    public function entregar()
    {
        try {
            if (isset($_GET['id']) && isset($_GET['rep'])) {
                $ped = new Pedido();
                $ped->ped_id = $_GET['id'];
                $ped->usr_rep_id = $_GET['rep'];
                $ped->EntregarPedido();
                $_SESSION['entregassucursalMensaje'] = "Entrega #{$ped->ped_id} asignado correctamente :)";
                App::Redirect('pedido/entregassucursal');
            } else if (isset($_GET['id'])) {
                $ped = new Pedido();
                $ped->ped_id = $_GET['id'];
                $ped->ActualizarEstado(PedidosEstatus::Entregado);
                $_SESSION['entregassucursalMensaje'] = "Pedido #{$ped->ped_id} Entregado";
                App::Redirect('pedido/entregassucursal');
            }
        } catch (\Throwable $th) {
            $_SESSION['gestionEntregaError'] = $th->getMessage();
            App::Redirect('pedido/gestionentrega&id=' . $_GET['id']);
        }
    }

    public function despachar()
    {
        if (isset($_GET['id']) && isset($_GET['ven'])) {
            try {
                $ped = new Pedido();
                $ped->ped_id = $_GET['id'];
                $ped->usr_ven_id = $_GET['ven'];
                $ped->DespacharPedido();
                $_SESSION['pedidotoGestionMensaje'] = "Pedido #{$ped->ped_id} despachado correctamente :)";
                App::Redirect('pedido/pedidossucursal');
            } catch (\Throwable $th) {
                $_SESSION['gestionPedidoError'] = $th->getMessage();
                App::Redirect('pedido/gestionpedido&id=' . $_GET['id']);
            }
        }
    }

    public function ValidarSucursal()
    {
        if ($_SESSION['succonnect']) {
            $suc = AppController::GetsucursalById($_SESSION['carrito'][0]['producto']->suc_id);

            if ($suc->suc_id != $_SESSION['succonnect']->suc_id) {
                $_SESSION['succonnect'] = $suc;
            }
        } else {
            $_SESSION['succonnect'] = AppController::GetsucursalById($_SESSION['carrito'][0]['producto']->suc_id);
        }
    }

    public function agregar()
    {
        try {
            $this->ValidarSucursal();
            if (isset($_POST) && isset($_SESSION['succonnect'])) {

                APP::ValidarDireccionPedido($_POST['direccion']);
                $ped = new Pedido();
                $ped->usr_id = $_SESSION['userconnect']->usr_id;
                $ped->dir_id = $_POST['direccion'];
                $ped->ped_costo = App::EstadisticasCarrito()['total'];
                $ped->suc_id = $_SESSION['succonnect']->suc_id;
                $result = $ped->GuardarPedido();

                if (!is_null($result)) {
                    $_SESSION['pedidoMisPedidosMensaje'] = 'Su pedido se guardo correctamente!';
                    App::UnsetSessionVar('carrito');
                    App::Redirect('pedido/detallepedido&id=' . $ped->ped_id);
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
        require_once 'models/Direccion.php';

        $dir = new Direccion();
        $dir->usr_id = $_SESSION['userconnect']->usr_id;

        $estados = PedidosEstatus::GetAllEstatus();
        $direcciones = $dir->GetDireccionByUsuario();

        $ped = new Pedido();
        $ped->usr_id = $_SESSION['userconnect']->usr_id;
        $ped->ped_fecha = isset($_SESSION['PEDARGS']->ped_fecha) ? $_SESSION['PEDARGS']->ped_fecha : null;
        $ped->pes_id = isset($_SESSION['PEDARGS']->pes_id) ? $_SESSION['PEDARGS']->pes_id : null;
        $ped->dir_id = isset($_SESSION['PEDARGS']->dir_id) ? $_SESSION['PEDARGS']->dir_id : null;
        $ped->ped_id = isset($_SESSION['PEDARGS']->ped_id) ? $_SESSION['PEDARGS']->ped_id : null;

        $paginaActual = (isset($_SESSION['PEDARGS']) && is_numeric($_SESSION['PEDARGS']->pag)) ? $_SESSION['PEDARGS']->pag : 1;

        $pedidos = $ped->GetAllPedidos();
        $paginas = AppController::GetPaginationListArray($pedidos, 5);
        $pedidos = array_slice(
            $pedidos,
            (($paginaActual - 1) * 5),
            5
        );

        require_once 'views/pedido/mispedidos.php';
        App::UnsetSessionVar('PEDARGS');
    }

    public function setMisPedidosAjaxParams()
    {
        $_SESSION['PEDARGS']->ped_fecha = isset($_GET['fec']) ? $_GET['fec'] : null;
        $_SESSION['PEDARGS']->pes_id = isset($_GET['est']) ? $_GET['est'] : null;
        $_SESSION['PEDARGS']->dir_id = isset($_GET['dir']) ? $_GET['dir'] : null;
        $_SESSION['PEDARGS']->ped_id = isset($_GET['ped']) ? $_GET['ped'] : null;
        $_SESSION['PEDARGS']->pag = isset($_GET['pag']) ? $_GET['pag'] : 1;
    }

    public function detallepedido()
    {
        if (isset($_GET['id'])) {
            $ped = new Pedido();
            $ped->ped_id = $_GET['id'];
            $entity = $ped->GetPedidoById();
            require_once 'views/pedido/detallepedido.php';
        }
    }
}
