<?php

class Direccion
{

    public $dir_id;
    public $dir_direccion;
    public $dir_latitud;
    public $dir_longitud;
    public $ciu_id;
    public $usr_id;
    public $Ciudad;
    private $db;

    public function __construct()
    {
        $this->db = BaseConection::Connect();
    }

    function getDir_id()
    {
        return $this->dir_id;
    }

    function setDir_id($dir_id): void
    {
        $this->dir_id = $dir_id;
    }

    public function GuardarDireccion()
    {
        $this->db->begin_transaction();

        $sql = "INSERT INTO direccion (dir_direccion, dir_latitud, dir_longitud, ciu_id)"
            . "VALUES ('{$this->dir_direccion}', '{$this->dir_latitud}', '{$this->dir_longitud}', '{$this->ciu_id}') ";
        $result = $this->db->query($sql);
        $this->dir_id = $this->db->insert_id;

        $sql = "INSERT INTO usuariodireccion (usr_id, dir_id) VALUES ({$this->usr_id}, {$this->dir_id})";
        $usrDirResult = $this->db->query($sql);

        if ($result && $usrDirResult) {
            $this->db->commit();
            return $this;
        }
        $this->db->rollback();
        return null;
    }

    public function GetDireccionById()
    {
        $sql = "SELECT * FROM direccion WHERE dir_id = {$this->dir_id}";
        $result = $this->db->query($sql);

        if ($result) {
            return $result->fetch_object('Direccion');
        }
        return null;
    }

    public function GetDireccionByUsuario()
    {

        $sql = "SELECT * FROM direccion dir
                INNER JOIN usuariodireccion usd on dir.dir_id = usd.dir_id
                WHERE usd.usr_id = {$this->usr_id}";
        $result = $this->db->query($sql);
        $direcciones = array();
        if ($result) {
            while ($r = $result->fetch_object('Direccion')) {
                array_push($direcciones, $r);
            }
        }
        return $direcciones;
    }

    public function EliminarDireccion()
    {
        $this->db->begin_transaction();

        $sql = "DELETE FROM usuariodireccion WHERE
                dir_id = {$this->dir_id}";
        $usrDirResult = $this->db->query($sql);

        $sql = "DELETE FROM direccion WHERE
                dir_id = {$this->dir_id}";
        $dirResult = $this->db->query($sql);

        if ($usrDirResult && $dirResult) {
            $this->db->commit();
            return true;
        }
        $this->db->rollback();
        return false;
    }

    public function ActualizarDireccion()
    {
        $sql = "UPDATE direccion SET
                dir_direccion = '{$this->dir_direccion}',
                ciu_id = {$this->ciu_id},
                dir_latitud = {$this->dir_latitud},
                dir_longitud = {$this->dir_longitud}
                WHERE dir_id = {$this->dir_id}";

        $result = $this->db->query($sql);

        if ($result) {
            return true;
        }
        return false;
    }
}
