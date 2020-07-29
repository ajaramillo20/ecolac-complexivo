<?php

class PedidosEstatus
{
    public const Nuevo = 'Nuevo';
    public const Despachado = 'Despachado';
    public const EnCamino = 'En camino';
    public const Entregado = 'Entregado';
    public const Cancelado = 'Cancelado';
    public const Rechazado = 'Rechazado';


    public static function GetEstadoSelect($estado)
    {
        return "SELECT pes_id FROM statuspedido WHERE pes_nombre = '{$estado}'";
    }
}