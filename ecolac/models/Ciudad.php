<?php
require_once 'IO/IOModel.php';

class Ciudad extends IOModel
{
    public $ciu_id;
    public $ciu_nombre;
    private $db;

    public function __construct()
    {
        $this->db = BaseConection::Connect();
    }

    public function GetCiudades()
    {
        $sql = "SELECT * FROM ciudad";
        $ciudades = $this->db->query($sql);
        return $ciudades;
    }
}
