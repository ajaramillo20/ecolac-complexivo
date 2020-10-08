<?php

class Sucursal
{
    public $suc_id;
    public $suc_nombre;
    public $dir_id;
    public $Direccion;
    private $db;

    public function __construct()
    {
        $this->db = BaseConection::Connect();
    }

    public function GetAllSucursales()
    {
        $sql = "SELECT * FROM sucursal suc
                INNER JOIN direccion dir on suc.dir_id = dir.dir_id
                INNER JOIN ciudad ciu on dir.ciu_id = ciu.ciu_id
                ORDER BY ciu.ciu_nombre, suc.suc_nombre";
        $result = $this->db->query($sql);
        return $result;
    }

    public function GetSucursalById()
    {
        $sql = "SELECT * FROM sucursal suc
                INNER JOIN direccion dir on suc.dir_id = dir.dir_id
                INNER JOIN ciudad ciu on dir.ciu_id = ciu.ciu_id
                WHERE suc.suc_id = {$this->suc_id}";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->fetch_object();
        }
        return null;
    }

    //CRUD
    public function AgregarSucursal()
    {
        try {
            $this->db->begin_transaction();

            $sqlDir = "INSERT INTO direccion (dir_direccion, dir_latitud, dir_longitud, ciu_id)"
                . "VALUES ('{$this->Direccion->dir_direccion}', '{$this->Direccion->dir_latitud}', '{$this->Direccion->dir_longitud}',"
                . " '{$this->Direccion->ciu_id}') ";
            $resultDir = $this->db->query($sqlDir);
            $this->Direccion->dir_id = $this->db->insert_id;

            $sqlSuc = "INSERT INTO sucursal (suc_nombre, dir_id) values ('{$this->suc_nombre}', {$this->Direccion->dir_id})";
            $resultSuc = $this->db->query($sqlSuc);

            if ($resultDir && $resultSuc) {
                $this->db->commit();
                return $this;
            }
            throw new Exception("Error al guardar");
        } catch (\Throwable $th) {
            $this->db->rollback();
            return null;
        }
    }

    public function ActualizarSucursal()
    {
        try {
            $sqlSuc = "UPDATE sucursal SET suc_nombre = '{$this->suc_nombre}' WHERE suc_id = {$this->suc_id}";
            $sqlDir = "UPDATE direccion SET 
                    dir_direccion = '{$this->Direccion->dir_direccion}',
                    dir_latitud = '{$this->Direccion->dir_latitud}',
                    dir_longitud = '{$this->Direccion->dir_longitud}',
                    ciu_id = '{$this->Direccion->ciu_id}'
                    WHERE dir_id = {$this->Direccion->dir_id}";

            $this->db->begin_transaction();

            $resultSuc = $this->db->query($sqlSuc);
            $resultDir = $this->db->query($sqlDir);
            if ($resultDir && $resultSuc) {
                $this->db->commit();
                return $this;
            }
        } catch (Throwable $ex) {
            $this->db->rollback();
            return null;
        }
    }

    public function EliminarSucursal()
    {
        try {
            $suc = $this->GetSucursalById();

            $sqlSuc = "DELETE FROM sucursal WHERE suc_id = {$suc->suc_id}";
            $sqlDir = "DELETE FROM direccion WHERE dir_id = {$suc->dir_id}";

            $this->db->begin_transaction();

            $resultSuc = $this->db->query($sqlSuc);
            $resultDir =  $this->db->query($sqlDir);

            if ($resultSuc && $resultDir) {
                $this->db->commit();
                return true;
            }
        } catch (\Throwable $th) {
            $this->db->rollback();
            return false;
        }
    }
}
