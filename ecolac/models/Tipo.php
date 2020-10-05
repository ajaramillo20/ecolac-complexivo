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

    public function GetTipoById()
    {
        $sql = "SELECT * FROM tipo WHERE tip_id = {$this->tip_id}";

        $result = $this->db->query($sql);

        if ($result) {
            return $result->fetch_object();
        }

        return null;
    }

    public function UpdateTipo()
    {
        if ($this->TipoUpdateExist()) {
            throw new Exception('Ya existe un producto con este nombre');
        }

        $sql = "UPDATE tipo set tip_nombre = '{$this->tip_nombre}'
                WHERE tip_id = {$this->tip_id}";

        $result = $this->db->query($sql);

        if ($result) {
            return true;
        }

        throw new Exception("No se pudo actualizar!");
    }

    public function TipoUpdateExist()
    {
        $sql = "SELECT * FROM tipo WHERE tip_id <> {$this->tip_id} AND tip_nombre = '{$this->tip_nombre}'";

        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            return true;
        }

        return false;
    }

    public function DeleteTipo()
    {
        $sql = "DELETE FROM tipo where tip_id = {$this->tip_id}";

        $result =  $this->db->query($sql);

        if ($result) {
            return true;
        }

        throw new Exception('No se pudo eliminar este registro');
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
