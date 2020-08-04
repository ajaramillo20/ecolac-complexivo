<?php
require_once 'models/Direccion.php';
class Pedido
{
    public $ped_id;
    public $usr_id;
    public $dir_id;
    public $pes_id;
    public $usr_ven_id;
    public $usr_rep_id;
    public $ped_fecha;
    public $ped_costo;
    public $suc_id;
    //Relaciones
    public $Direccion;
    public $Productos = array();
    public $Estado;

    private $db;

    public function __construct()
    {
        $this->db = BaseConection::Connect();
    }

    public function GuardarPedido()
    {
        try {
            $this->db->begin_transaction();
            $estadoNuevo = PedidosEstatus::GetEstadoSelect(PedidosEstatus::Nuevo);

            $sql = "INSERT INTO pedido
                (usr_id, dir_id, pes_id, ped_fecha, ped_costo , suc_id) VALUES
                ({$this->usr_id}, {$this->dir_id}, ($estadoNuevo), CURDATE(), {$this->ped_costo}, {$this->suc_id})";
            $result = $this->db->query($sql);

            if ($result) {
                $this->ped_id = $this->db->insert_id;
                $result = $this->GuardarProductos();
                $this->db->commit();
                return $this;
            }
            return null;
        } catch (\Throwable $th) {
            $this->db->rollback();
            throw new Exception($th->getMessage());
        }
    }

    public function DespacharPedido()
    {
        if ($this->VerificarEstado(PedidosEstatus::Despachado)) {
            throw new Exception("Este pedido ya fue despechado!");
        }
        $pesid = PedidosEstatus::GetEstadoSelect(PedidosEstatus::Despachado);
        $sql = "UPDATE pedido SET pes_id = ({$pesid}),
                usr_ven_id = {$this->usr_ven_id}
                WHERE ped_id = {$this->ped_id}";
        $result = $this->db->query($sql);

        if ($result) {
            return $this;
        }
        throw new Exception("No se pudo actualizar el estado del pedido");
    }

    public function VerificarEstado($estado)
    {
        $sql = "SELECT pes.pes_nombre FROM pedido ped
                INNER JOIN statuspedido pes on ped.pes_id = pes.pes_id
                WHERE ped.ped_id = {$this->ped_id}";
        $result = $this->db->query($sql);

        if ($result) {
            $e = $result->fetch_object();
            if ($e->pes_nombre == $estado) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    public function GuardarProductos()
    {
        $carrito = isset($_SESSION['carrito']) ? $_SESSION['carrito'] : array();
        foreach ($carrito as $indice => $elemento) {
            $pro = $elemento['producto'];
            $unidades = $elemento['unidades'];
            $sqlStock = "SELECT pro_cantStock FROM producto WHERE pro_id = {$pro->pro_id}";
            if ($resultStock =  $this->db->query($sqlStock)) {
                $stock = (int)$resultStock->fetch_object()->pro_cantStock;
                if ($stock > 0 && $stock >= $unidades) {

                    $sqlProPed = "INSERT INTO productopedido
                                  (pro_id, prp_cantidad, ped_id) VALUES ({$pro->pro_id}, {$unidades}, {$this->ped_id})";

                    $resultProPed = $this->db->query($sqlProPed);

                    $stock = ($stock - $unidades);
                    $sqlUpdateStock = "UPDATE producto SET pro_cantStock = {$stock} WHERE pro_id = {$pro->pro_id}";
                    $resultUpdateStock = $this->db->query($sqlUpdateStock);

                    if (!$resultProPed || !$resultUpdateStock) {
                        throw new Exception("El producto error al actualizar stock, intente mas tarde");
                    }
                } else {
                    throw new Exception("El producto {$pro->pro_nombre} no se encuentra en stock, unidades disponibles {$stock}");
                }
            }
        }
    }

    public function GetPedidoById()
    {
        //PEDIDO
        $sql = "SELECT ped.ped_id, ped.ped_fecha, ped.ped_costo, pes.pes_nombre, usr.usr_id, usr.usr_nombre,
        usr.usr_telefono, usr.usr_cedula, usr.usr_correo, dir.dir_id, dir.dir_direccion, dir.dir_latitud, dir.dir_longitud,
        ven.usr_id as ven_id, ven.usr_nombre as ven_nombre, rep.usr_id as rep_id, rep.usr_nombre as rep_nombre,
        ciu.ciu_id, ciu.ciu_nombre, suc.suc_id, suc.suc_nombre, dirsuc.dir_id as dirsuc_id, dirsuc.dir_direccion as dirsuc_direccion,
        dirsuc.dir_latitud as dirsuc_latitud, dirsuc.dir_longitud as dirsuc_longitud
        FROM pedido ped
        INNER JOIN statuspedido pes ON ped.pes_id = pes.pes_id
        INNER JOIN direccion dir on ped.dir_id = dir.dir_id
        INNER JOIN ciudad ciu on dir.ciu_id = ciu.ciu_id
        INNER JOIN usuario usr on ped.usr_id = usr.usr_id
        LEFT JOIN usuario ven on ped.usr_ven_id = ven.usr_id
        LEFT JOIN usuario rep on ped.usr_rep_id = rep.usr_id
        LEFT JOIN sucursal suc on ped.suc_id = suc.suc_id
        LEFT JOIN direccion dirsuc on suc.dir_id = dirsuc.dir_id
        WHERE ped.ped_id = {$this->ped_id}";

        $result = $this->db->query($sql);

        //PRODUCTOS
        $sqlProductos = "SELECT pro.pro_id, pro.pro_nombre, pro.pro_valor, prp.prp_cantidad FROM producto pro
                         INNER JOIN productopedido prp on prp.pro_id = pro.pro_id
                         INNER JOIN pedido ped on prp.ped_id = ped.ped_id
                        WHERE ped.ped_id = {$this->ped_id}";

        $resultPro = $this->db->query($sqlProductos);

        if ($result && $resultPro) {
            $pedidoEntity = $result->fetch_object();
            $pedidoEntity->Productos = array();

            while ($pro = $resultPro->fetch_object()) {
                array_push($pedidoEntity->Productos, $pro);
            }
            return $pedidoEntity;
        }
        return null;
    }

    public function GetPedidosByUserId()
    {
        $sql = "SELECT * FROM pedido ped
                INNER JOIN statuspedido pes ON ped.pes_id = pes.pes_id
                INNER JOIN direccion dir on ped.dir_id = dir.dir_id
                INNER JOIN ciudad ciu on dir.ciu_id = ciu.ciu_id
                WHERE ped.usr_id = {$this->usr_id}";

        $result = $this->db->query($sql);

        if ($result) {
            return $result;
        }
        return null;
    }

    public function GetAllPedidos()
    {
        $sql = "SELECT ped.ped_id, ped.ped_fecha, usr.usr_nombre, pes.pes_nombre,
                dir.dir_direccion, ven.usr_nombre AS ven_nombre,
                rep.usr_nombre as rep_nombre, suc.suc_id, suc.suc_nombre FROM pedido ped
                INNER JOIN usuario usr ON ped.usr_id = usr.usr_id
                INNER JOIN direccion dir ON ped.dir_id = dir.dir_id
                INNER JOIN statuspedido pes ON ped.pes_id = pes.pes_id
                INNER JOIN sucursal suc ON ped.suc_id = suc.suc_id
                LEFT JOIN usuario ven ON ped.usr_ven_id = ven.usr_id                
                LEFT JOIN usuario rep ON ped.usr_ven_id = rep.usr_id";

        $result = $this->db->query($sql);

        if ($result) {
            $pedidosResult = array();
            while ($ped = $result->fetch_object()) {
                array_push($pedidosResult, $ped);
            }
            return $pedidosResult;
        }

        return null;
    }

    public function GetAllPedidosBySuc()
    {
        $sql = "SELECT ped.ped_id, ped.ped_fecha, usr.usr_nombre, pes.pes_nombre,
                dir.dir_direccion, ven.usr_nombre AS ven_nombre,
                rep.usr_nombre as rep_nombre, suc.suc_id, suc.suc_nombre FROM pedido ped
                INNER JOIN usuario usr ON ped.usr_id = usr.usr_id
                INNER JOIN direccion dir ON ped.dir_id = dir.dir_id
                INNER JOIN statuspedido pes ON ped.pes_id = pes.pes_id
                INNER JOIN sucursal suc ON ped.suc_id = suc.suc_id
                LEFT JOIN usuario ven ON ped.usr_ven_id = ven.usr_id                
                LEFT JOIN usuario rep ON ped.usr_ven_id = rep.usr_id
                WHERE suc.suc_id = {$this->suc_id}";

        $result = $this->db->query($sql);

        if ($result) {
            $pedidosResult = array();
            while ($ped = $result->fetch_object()) {
                array_push($pedidosResult, $ped);
            }
            return $pedidosResult;
        }

        return null;
    }
}
