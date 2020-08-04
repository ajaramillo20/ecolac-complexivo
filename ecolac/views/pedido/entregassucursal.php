<?php if (isset($_SESSION['entregassucursalMensaje'])) {
    App::ShowMessage($_SESSION['entregassucursalMensaje'], 'Confirmación');
    App::UnsetSessionVar('entregassucursalMensaje');
}
if (isset($_SESSION['entregassucursalError'])) {
    App::ShowMessage($_SESSION['entregassucursalError'], 'Error');
    App::UnsetSessionVar('entregassucursalError');
}
?>
<div class="miTabla">
    <h2>Gestión entregas</h2>
    <div class="contenedor">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Sucursal</th>
                    <th>Dirección</th>
                    <th class="thAction">Detalles / Gestionar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $ped) : ?>

                    <tr>
                        <td data-label="ID"><?= $ped->ped_id ?></td>
                        <td data-label="Cliente"><?= $ped->usr_nombre ?></td>
                        <td data-label="FECHA"><?= StringFormat::DateFormat($ped->ped_fecha) ?></td>
                        <td data-label="ESTADO"><?= $ped->pes_nombre ?></td>
                        <td data-label="SUCURSAL"><?= $ped->suc_nombre ?></td>
                        <td data-label="Dirección de entrega"><?= $ped->dir_direccion ?></td>
                        <td data-label="Detalles"><a href="<?= base_url . 'pedido/detallepedido&id=' . $ped->ped_id ?>" class="icon-eye"></a>
                            <a href="<?= base_url . 'pedido/gestionentrega&id=' . $ped->ped_id ?>" class="icon-paper-plane"></a></td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>