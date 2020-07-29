<?php

class Tipo
{
    public $tip_id;
    public $tip_nombre;
    private $db;

    public function __construct()
    {
        $this->db = BaseConection::Connect();
    }

    public function GetAllTipos()
    {
        $sql = "SELECT * FROM tipo";
        $tipos = $this->db->query($sql);
        return $tipos;
    }


    public function GuardarTipo()
    {
        try {
            if ($this->TipoExist($this->tip_nombre)) {
                throw new Exception('Ya existe este elemento');
            }

            $sql = "INSERT INTO tipo (tip_nombre) VALUES ('{$this->tip_nombre}')";
            $result = $this->db->query($sql);
            if ($result) {
                $this->tip_id = $this->db->insert_id;
                return $this;
            }
            throw new Exception('Error al guardar');
        } catch (Throwable $ex) {
            $_SESSION['registroTipoError'] = $ex->getMessage();
            return null;
        }
    }

    public function TipoExist($cat_nombre)
    {
        $sql = "SELECT * FROM tipo where tip_nombre = '{$cat_nombre}'";
        $result = $this->db->query($sql);

        if ($result && $result->num_rows == 1) {
            return true;
        }
        return false;
    }
}
