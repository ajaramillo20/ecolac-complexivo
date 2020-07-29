<?php
class pedido
{
    public $ped_id;
    public $usr_id;
    public $dir_id;
    public $pes_id;
    public $usr_ven_id;
    public $usr_rep_id;
    public $ped_fecha;
    public $ped_costo;

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
                (usr_id, dir_id, pes_id, ped_fecha, ped_costo ) VALUES
                ({$this->usr_id}, {$this->dir_id}, ($estadoNuevo), CURDATE(), {$this->ped_costo})";
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
}
