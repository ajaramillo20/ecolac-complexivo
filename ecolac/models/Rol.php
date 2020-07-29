<?php

class Rol
{
    public $rol_nombre;
    public $rol_id;
    private $db;

    public function __construct()
    {
        $this->db = BaseConection::Connect();
    }

    public function GetRoles()
    {
        $sql = "SELECT * FROM rol";
        $result = $this->db->query($sql);

        $roles = array();

        while ($r = $result->fetch_object()) {
            array_push($roles, $r);
        }

        return $roles;
    }
}
