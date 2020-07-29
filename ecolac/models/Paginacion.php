<?php

class Paginacion
{
    private $db;

    public function __construct()
    {
        $this->db = BaseConection::Connect();
    }

    public function GetTotal($tableName)
    {
        $sql = "SELECT COUNT(*) AS Total FROM " . $tableName;
        $result = $this->db->query($sql);

        if ($result) {
            $total = $result->fetch_object();
            return $total->Total;
        }
        return 0;
    }
}
