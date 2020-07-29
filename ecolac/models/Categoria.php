<?php

class Categoria
{
    public $cat_id;
    public $cat_nombre;
    public $tip_id;
    private $db;

    public function __construct()
    {
        $this->db = BaseConection::Connect();
    }

    public function AgregarCategoria()
    {
        try {
            if ($this->CategoriaExist($this->cat_nombre, $this->tip_id)) {
                throw new Exception('Ya existe este elemento');
            }

            $sql = "INSERT INTO categoria (cat_nombre,tip_id) VALUES ('{$this->cat_nombre}', {$this->tip_id})";
            $result = $this->db->query($sql);
            if ($result) {
                $this->cat_id = $this->db->insert_id;
                return $this;
            }
            throw new Exception('Error al guardar');
        } catch (Throwable $ex) {
            $_SESSION['registroCategoriaError'] = $ex->getMessage();
            return null;
        }
    }


    public function ActualizarCategoria()
    {
        if (!$this->CategoriaExistUpdate()) {
            $sql = "UPDATE categoria SET
                    tip_id = {$this->tip_id},
                    cat_nombre = '{$this->cat_nombre}'
                    WHERE cat_id = {$this->cat_id}";

            $result = $this->db->query($sql);

            if ($result) {
                return $this;
            }
        }
        return null;
    }

    public function CategoriaExistUpdate()
    {
        $sql = "SELECT * FROM categoria where cat_id <> {$this->cat_id} AND (cat_nombre = '{$this->cat_nombre}' AND tip_id= {$this->tip_id} )";
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            return true;
        }
        return false;
    }

    public function CategoriaExist($cat_nombre, $tip_id)
    {
        $sql = "SELECT * FROM categoria where cat_nombre = '{$cat_nombre}' AND tip_id = {$tip_id}";
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            return true;
        }
        return false;
    }

    public function GetAllCategorias()
    {
        $sql = "SELECT cat_id, cat_nombre, tip.tip_id, tip.tip_nombre FROM categoria cat
                INNER JOIN tipo tip on cat.tip_id = tip.tip_id ORDER BY tip.tip_nombre";
        $categorias = $this->db->query($sql);
        return $categorias;
    }

    public function GetCategoriaById()
    {
        $sql = "SELECT cat_id, cat_nombre, tip.tip_id, tip.tip_nombre FROM categoria cat
                INNER JOIN tipo tip on cat.tip_id = tip.tip_id WHERE cat.cat_id = {$this->cat_id}";
        $entity = $this->db->query($sql);
        if ($entity) {
            return $entity->fetch_object();
        } else {
            return null;
        }
    }

    public function Eliminar()
    {
        $sql = "DELETE FROM categoria WHERE cat_id = {$this->cat_id}";
        return $this->db->query($sql);
    }
}
