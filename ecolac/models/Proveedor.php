<?php

class Proveedor
{

    public $prv_id;
    public $prv_nombre;
    public $prv_telefono;
    public $prv_correo;
    public $dir_id;
    public $ciu_id;
    public $direccion;

    private $db;

    public function __construct()
    {
        $this->db = BaseConection::Connect();
    }

    public function AgregarProveedor()
    {
        $this->db->begin_transaction();
        $sqlDir = "INSERT INTO direcion (dir_direccion, dir_latitud, dir_longitud, ciu_id,dir_predeterminado) 
                    VALUES ( '{$this->direccion->dir_direccion}', '{$this->direccion->dir_latitud}', '{$this->direccion->dir_longitud}',
                             {$this->direccion->ciud_id}, true)";

        $dirResult = $this->db->query($sqlDir);
        if ($dirResult) {
            $this->dir_id = $this->db->insert_id;
            $sqlPrv = "INSERT INTO proveedor (prv_nombre, prv_telefono, prv_correo, dir_id) VALUES
                        ('{$this->prv_nombre}', '{$this->prv_telefono}', '{$this->prv_correo}', {$this->dir_id} )";
            $prvResult = $this->db->query($sqlPrv);

            if ($prvResult) {
                $this->db->commit();
                return true;
            }
            $this->db->rollback();
            throw new Exception("Error al guardar proveedor");
        } else {
            $this->db->rollback();
            throw new Exception("Error al guardar la dirección");
        }
    }

    public function GetAllProveedores()
    {
        $sql = "SELECT * FROM proveedores prv
                INNER JOIN direccion dir ON prv.dir_id = dir.dir_id
                INNER JOIN ciudad ciu ON dir.ciu_id = ciu.ciu_id
                WHERE  (" . (StringFormat::IsNullOrEmptyString($this->ciu_id) ? 'null' : "{$this->ciu_id}") . " IS NULL
                OR ciu.ciu_id =" . (StringFormat::IsNullOrEmptyString($this->ciu_id) ? 'null' : "{$this->ciu_id}") . ") " .
                "AND (" . (StringFormat::IsNullOrEmptyString($this->prv_nombre) ? "'null'" : "'{$this->prv_nombre}'") . " = 'null'
                OR prv.prv_nombre LIKE " . (StringFormat::IsNullOrEmptyString($this->prv_nombre) ? 'null' : "'%{$this->prv_nombre}%'") . ") 
                ORDER BY ciu.ciu_nombre, prv.prv_nombre";

        $result = $this->db->query($sql);
        if ($result) {
            return $result;
        }
    }

    public function UpdateProveedor()
    {
        $this->db->begin_transaction();

        $updateDir = "UPDATE direccion SET
                      dir_direccion = '{$this->direccion->dir_id}',
                      dir_latitud = '{$this->direccion->dir_latitud}',
                      dir_latitud = '{$this->direccion->dir_longiud}'
                      ciu_id = {$this->direccion->ciu_id} 
                      WHERE dir_id = {$this->direccion->dir_id}";

        $dirResult = $this->db->query($updateDir);

        if ($updateDir) {
            $updatePrv = "UPDATE proveedor SET
                      prv_nombre = '{$this->prv_nombre}',
                      prv_telefono = '{$this->prv_telefono}',
                      prv_correo = '{$this->prv_correo}'
                      WHERE prv_id = {$this->prv_id}";
            $prvResult = $this->db->query($updatePrv);

            if ($prvResult) {
                $this->db->commit();
            }
        }
        $this->db->rollback();
        throw new Exception("Error al actualizar proveedor");
    }
}