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
        $sql = "SELECT COUNT(*) AS TotalRows FROM " . $tableName;
        $result = $this->db->query($sql);

        if ($result) {
            $total = $result->fetch_object();
            return $total->TotalRows;
        }
        return 0;
    }

    public function GetTotalByQuery($sql)
    {
        $result = $this->db->query($sql);
        if ($result) {
            $total = $result->num_rows;
            return $total;
        }
        return 0;
    }
}
