<?php
require_once 'models/Paginacion.php';

class PaginacionController
{
    private $paginacion;

    public function __construct()
    {
        $this->paginacion = new Paginacion();
    }

    public function Paginar($tableName, $tamano = 20)
    {
        $rows = $this->paginacion->GetTotal($tableName);
        $paginas = ($rows / $tamano);

        return $paginas;
    }
}
