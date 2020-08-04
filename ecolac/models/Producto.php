<?php

class Producto
{
    public $pro_id;
    public $pro_nombre;
    public $tip_id;
    public $cat_id;
    public $pre_id;
    public $suc_id;
    public $pro_valor;
    public $pro_cantStock;
    public $rec_id;
    public $Recurso;

    private $db;

    public function __construct()
    {
        $this->db = BaseConection::Connect();
    }

    public function GetProductoById()
    {
        $sql = "SELECT * from producto pro
                INNER JOIN recursos rec ON pro.rec_id = rec.rec_id
                INNER JOIN tipo tip ON pro.tip_id = tip.tip_id
                INNER JOIN categoria cat ON pro.cat_id = cat.cat_id
                inner join presentacion pre ON pro.pre_id = pre.pre_id
                inner join sucursal suc ON pro.suc_id = suc.suc_id
                inner join direccion dir ON suc.dir_id = dir.dir_id
                inner join ciudad ciu ON dir.ciu_id = ciu.ciu_id
                WHERE pro.pro_id = {$this->pro_id}";
        $result = $this->db->query($sql);

        if ($result) {
            return $result->fetch_object();
        }

        return null;
    }

    public function GetAllProductosBySucusal()
    {
        $sql = "SELECT * from producto pro
                INNER JOIN recursos rec ON pro.rec_id = rec.rec_id
                INNER JOIN tipo tip ON pro.tip_id = tip.tip_id
                INNER JOIN categoria cat ON pro.cat_id = cat.cat_id
                inner join presentacion pre ON pro.pre_id = pre.pre_id
                inner join sucursal suc ON pro.suc_id = suc.suc_id
                inner join direccion dir ON suc.dir_id = dir.dir_id
                inner join ciudad ciu ON dir.ciu_id = ciu.ciu_id
                WHERE suc.suc_id = {$this->suc_id}";
        $result = $this->db->query($sql);
        return $result;
    }

    public function GetAllProductos()
    {
        $sql = "SELECT * from producto pro
                INNER JOIN recursos rec ON pro.rec_id = rec.rec_id
                INNER JOIN tipo tip ON pro.tip_id = tip.tip_id
                INNER JOIN categoria cat ON pro.cat_id = cat.cat_id
                inner join presentacion pre ON pro.pre_id = pre.pre_id
                inner join sucursal suc ON pro.suc_id = suc.suc_id
                inner join direccion dir ON suc.dir_id = dir.dir_id
                inner join ciudad ciu ON dir.ciu_id = ciu.ciu_id";
        $result = $this->db->query($sql);
        return $result;
    }

    public function AgregarProducto()
    {
        try {

            if ($this->ProductoExist()) {
                throw new Exception('Ya se encuentra registrado');
            }

            $this->db->begin_transaction();
            $this->Recurso->rec_nombre = products_path . '/' . $this->Recurso->rec_nombre;
            $sqlRecurso = "INSERT INTO recursos (rec_nombre, rec_tipo) VALUES ('{$this->Recurso->rec_nombre}', '{$this->Recurso->rec_tipo}')";
            $resultRec = $this->db->query($sqlRecurso);
            $this->Recurso->rec_id = $this->db->insert_id;


            $sqlProducto = "INSERT INTO producto 
                            (pro_nombre, tip_id, cat_id, pro_valor, pro_cantStock, pre_id, suc_id, rec_id) 
                            VALUES ('{$this->pro_nombre}', {$this->tip_id}, {$this->cat_id}, {$this->pro_valor}, {$this->pro_cantStock}, {$this->pre_id}, {$this->suc_id}, {$this->Recurso->rec_id} )";
            $resultPro = $this->db->query($sqlProducto);

            if ($resultPro && $resultRec) {
                $this->db->commit();
                return $this;
            }

            throw new Exception("Error al guardar");
        } catch (\Throwable $th) {
            $this->db->rollback();
            return null;
        }
    }

    public function EliminarProducto()
    {
    }

    public function ActualizarProducto()
    {
        try {
            $this->db->begin_transaction();
            $sqlProducto = "UPDATE producto SET
                            pro_nombre = '{$this->pro_nombre}',
                            tip_id = {$this->tip_id},
                            cat_id = {$this->cat_id},
                            pro_valor = {$this->pro_valor},
                            pro_cantStock = {$this->pro_cantStock},
                            pre_id = {$this->pre_id},
                            suc_id = {$this->suc_id}
                            WHERE pro_id = {$this->pro_id}";


            if (!is_null($this->Recurso)) {
                $this->Recurso->rec_nombre = products_path . '/' . $this->Recurso->rec_nombre;
                $sqlRecurso = "UPDATE recursos SET
                rec_nombre = '{$this->Recurso->rec_nombre}',
                rec_tipo = '{$this->Recurso->rec_tipo}'
                WHERE rec_id = {$this->Recurso->rec_id}";
                $this->db->query($sqlRecurso);

                $resultPro = $this->db->query($sqlProducto);
                $resultRec = $this->db->query($sqlRecurso);
                if ($resultRec && $resultPro) {
                    $this->db->commit();
                    return $this;
                }
            } else {
                $resultPro = $this->db->query($sqlProducto);
                if ($resultPro) {
                    $this->db->commit();
                    return $this;
                }
            }

            throw new Exception("Error al actualizar");
        } catch (\Throwable $th) {
            $this->db->rollback();
            return null;
        }
    }


    public function ProductoExist()
    {
        $sql = "SELECT * FROM producto pro
                INNER JOIN recursos rec ON pro.rec_id = rec.rec_id
                WHERE rec.rec_nombre = '{$this->Recurso->rec_nombre}' OR (pro.pro_nombre = '{$this->pro_nombre}' AND pro.suc_id = {$this->suc_id}) ";
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            return true;
        }
        return false;
    }
}
