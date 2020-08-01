<div class="miTabla">
    <h2>Gestión pedidos</h2>
    <div class="contenedor">
    <a class="btn" href="<?= base_url ?>usuario/registro">Agregar</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>                    
                    <th>Fecha</th>
                    <th>Estado</th>
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
                        <td data-label="Dirección de entrega"><?= $ped->dir_direccion ?></td>                        
                        <td data-label="Detalles"><a href="<?= base_url . 'pedido/detallepedido&id=' . $ped->ped_id ?>" class="icon-eye"></a>
                        <a href="<?= base_url . 'pedido/gestionpedido&id=' . $ped->ped_id ?>" class="icon-caja"></a></td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>