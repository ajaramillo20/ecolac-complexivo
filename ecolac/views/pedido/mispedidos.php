<div class="miTabla">
    <h3>Mis pedidos</h3>
    <?php if (isset($_SESSION['pedidoMisPedidosMensaje'])) {
        echo '<p class="succes">' . $_SESSION['pedidoMisPedidosMensaje'] . '</p>';
        App::UnsetSessionVar('pedidoMisPedidosMensaje');
    }
    if (isset($_SESSION['pedidoMisPedidosError'])) {
        echo '<p class="error">' . $_SESSION['pedidoMisPedidosError'] . '</p>';
        App::UnsetSessionVar('pedidoMisPedidosError');
    }
    $pedidos = AppController::GetPedidosByUsuarioId($_SESSION['userconnect']->usr_id);
    ?>
    <div class="contenedor">
        <table>
            <thead>
                <tr>                    
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Costo</th>
                    <th>Estado</th>
                    <th>Direccion de entrega</th>
                    <th>Ciudad</th>                    
                    <th class="thAction">Detalles</th>                    
                </tr>
            </thead>
            <tbody>
                <?php while ($ped  = $pedidos->fetch_object()) : ?>
                    <tr>
                        <td data-label="ID"><?= $ped->ped_id ?></td>
                        <td data-label="FECHA"><?= $ped->ped_fecha ?></td>
                        <td data-label="COSTO"><?= $ped->ped_costo ?></td>
                        <td data-label="ESTADO"><?= $ped->pes_nombre ?></td>
                        <td data-label="Dirección de entrega"><?= $ped->dir_direccion ?></td>
                        <td data-label="Ciudad"><?= $ped->ciu_nombre ?></td>
                        <!-- <td data-label="Sucursal"><?= $pro->suc_nombre ?></td> -->
                        <td data-label="Detalles"><a href="<?= base_url . 'pedido/detalles&id=' . $ped->ped_id ?>" class="icon-eye"></a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>