<?php

class Presentacion
{
    public $pre_id;
    public $pre_nombre;
    private $db;

    public function __construct()
    {
        $this->db = BaseConection::Connect();
    }

    public function GetAllPresentaciones()
    {
        $sql = "SELECT * FROM presentacion";
        $presentaciones = $this->db->query($sql);
        return $presentaciones;
    }

    public function GetPresentacionById()
    {
        $sql = "SELECT * FROM presentacion WHERE pre_id= {$this->pre_id}";
        $result = $this->db->query($sql);
        if ($result) {
            return $result->fetch_object();
        } else {
            return null;
        }
    }

    //CRUD
    public function AgregarPresentacion()
    {
        if ($this->PresentacionExist()) {
            return null;
        }
        $sql = "INSERT INTO presentacion (pre_nombre) VALUES ('{$this->pre_nombre}')";
        $result = $this->db->query($sql);

        if ($result) {
            return $this;
        }
        return null;
    }

    public function ActualizarPresentacion()
    {
        if ($this->PresentacionUpdateExist()) {
            return null;
        }

        $sql = "UPDATE presentacion SET pre_nombre = '{$this->pre_nombre}' WHERE pre_id = '{$this->pre_id}'";
        $result = $this->db->query($sql);

        if ($result) {
            return $this;
        }
        return null;
    }

    public function EliminarPresentacion()
    {
        $sql = "DELETE FROM presentacion WHERE pre_id = {$this->pre_id}";
        $result = $this->db->query($sql);

        if ($result) {
            return true;
        }

        return false;
    }

    //// validaciones
    public function PresentacionExist()
    {
        $sql = "SELECT * FROM presentacion where pre_nombre= '{$this->pre_nombre}'";

        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            return true;
        }

        return false;
    }

    public function PresentacionUpdateExist()
    {
        $sql = "SELECT * FROM presentacion where pre_id <> {$this->pre_id} AND pre_nombre = '{$this->pre_nombre}'";
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            return true;
        }
        return false;
    }
}
