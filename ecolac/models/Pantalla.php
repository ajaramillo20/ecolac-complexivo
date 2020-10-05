<?php

class Pantalla
{

    public $pnt_id;
    public $pnt_nombre;
    public $pnt_vinculo;
    public $pnt_menu;
    public $rol_id;
    private $db;

    public function __construct()
    {
        $this->db = BaseConection::Connect();
    }

    public function GetPantallasRol()
    {
        $sql = "SELECT * FROM pantallarol WHERE rol_id = {$this->rol_id}";
        $result = $this->db->query($sql);

        $pantallas = array();

        while ($item = $result->fetch_object()) {
            array_push($pantallas, $item);
        }

        return $pantallas;
    }



    public function PantallaExist()
    {
        $sql = "SELECT * FROM pantallarol WHERE
         pnt_vinculo = '{$this->pnt_vinculo}' AND rol_id = {$this->rol_id}";
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            return true;
        }
        return false;
    }

    //CRUD
    public function AgregarPantalla()
    {
        try {

            if ($this->PantallaExist()) {
                throw new Exception('Ya existe este elemento');
            }

            $sql = "INSERT INTO pantallarol (pnt_nombre, pnt_vinculo, rol_id, pnt_menu) VALUES ('{$this->pnt_nombre}', '{$this->pnt_vinculo}', {$this->rol_id}, {$this->pnt_menu})";
            $result = $this->db->query($sql);
            if ($result) {
                $this->pnt_id = $this->db->insert_id;
                return $this;
            }
            return null;
        } catch (Throwable $ex) {
            $_SESSION['registroPantallaError'] = $ex->getMessage();
            return null;
        }
    }

    public function ActualizarPantalla()
    {
        $sql = "UPDATE pantallarol
                SET pnt_nombre = '{$this->pnt_nombre}',
                pnt_vinculo = '{$this->pnt_vinculo}',
                pnt_menu = {$this->pnt_menu},
                rol_id = {$this->rol_id}
                WHERE pnt_id = {$this->pnt_id}";

        $result = $this->db->query($sql);
        if ($result) {
            return $this;
        }
        return null;
    }

    public function GetAllPantallas()
    {
        $sql = "SELECT pnt.pnt_id, pnt.pnt_nombre, pnt.pnt_vinculo, pnt.pnt_menu, rol.rol_nombre FROM pantallarol pnt
                INNER JOIN rol rol on pnt.rol_id = rol.rol_id
                WHERE  (" . (StringFormat::IsNullOrEmptyString($this->rol_id) ? 'null' : "{$this->rol_id}") . " IS NULL
                OR rol.rol_id =" . (StringFormat::IsNullOrEmptyString($this->rol_id) ? 'null' : "{$this->rol_id}") . ") " .
            "AND (" . (StringFormat::IsNullOrEmptyString($this->pnt_vinculo) ? "'null'" : "'{$this->pnt_vinculo}'") . " = 'null'
                OR pnt.pnt_nombre LIKE " . (StringFormat::IsNullOrEmptyString($this->pnt_vinculo) ? 'null' : "'%{$this->pnt_vinculo}%'") . ") 
                ORDER BY rol.rol_nombre, pnt.pnt_nombre";


        $pantallas = $this->db->query($sql);
        return $pantallas;
    }

    public function GetPantallaById()
    {
        $sql = "SELECT * FROM pantallarol where pnt_id = {$this->pnt_id}";
        $result =  $this->db->query($sql);
        if ($result) {
            return $result->fetch_object();
        }
        return null;
    }

    public function EliminarPantalla()
    {
        $sql = "DELETE FROM pantallarol WHERE pnt_id = {$this->pnt_id}";
        $result = $this->db->query($sql);
        if ($result) {
            return true;
        }
        return false;
    }
}
