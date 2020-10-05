<?php

class Configuracion
{
    public $conf_id;
    public $conf_descripcion;
    public $conf_valor;

    public $db;
    public function __construct()
    {
        $this->db = BaseConection::Connect();
    }

    public function GetAllConfiguracion()
    {
        $sql = "SELECT * FROM configuracion";

        $result = $this->db->query($sql);
        return $result;
    }

    public function AddConfiguracion()
    {
        $sql = "INSERT INTO configuracion (conf_descripcion, conf_valor) VALUES ('{$this->conf_descripcion}','{$this->conf_valor}')";

        $result = $this->db->query($sql);
        if ($result) {
            return true;
        }

        throw new Exception("No se pudo guardar la configuración");
    }

    public function UpdateConfiguracion()
    {
        $sql = "UPDATE configuracion SET conf_descripcion = '{$this->conf_descripcion}', conf_valor = '{$this->conf_valor}'
                WHERE conf_id = {$this->conf_id}";

        $result = $this->db->query($sql);
        if ($result) {
            return true;
        }

        throw new Exception("No se pudo actualizar el registro");
    }

    public function DeleteConfiguracion()
    {
        $sql = "DELETE FROM configuracion where conf_id = {$this->conf_id}";

        $result = $this->db->query($sql);

        if ($result) {
            return true;
        }

        throw new Exception("No se puedo eliminar el registro");
    }

    public function GetConfiguracionById()
    {

        $sql = "SELECT * FROM configuracion
                WHERE conf_id = {$this->conf_id}";

        $result = $this->db->query($sql);
        if ($result) {
            return $result->fetch_object();
        }
        return null;
    }
}
