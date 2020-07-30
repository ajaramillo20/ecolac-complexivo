<div class="miTabla">
    <?php if (isset($_SESSION['pedidoMisPedidosMensaje'])) {
        echo '<p class="succes">' . $_SESSION['pedidoMisPedidosMensaje'] . '</p>';
        App::UnsetSessionVar('pedidoMisPedidosMensaje');
    }
    if (isset($_SESSION['pedidoMisPedidosError'])) {
        echo '<p class="error">' . $_SESSION['pedidoMisPedidosError'] . '</p>';
        App::UnsetSessionVar('pedidoMisPedidosError');
    }
    if (!isset($entity) || is_null($entity)) {
        App::Redirect('pedido/mispedidos');
    }
    ?>
    <h2><?= 'Detalle del pedido # ' . $entity->ped_id ?></h2>
    <p class="informacion"><?= 'Fecha: ' . date("d-m-Y", strtotime($entity->ped_fecha)); ?></p>
    <p class="informacion"><?= 'Cliente: ' . $entity->Direccion->usr_nombre ?></p>
    <p class="informacion"><?= 'Dirección: ' . $entity->Direccion->dir_direccion ?></p>
    <p class="informacion"><?= 'Estado: ' . $entity->Estado->pes_nombre ?></p>
    <p class="informacion">Vendedor responsable:</p>
    <p class="informacion">Repartidor asignado:</p>

    <div class="contenedor">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Valor</th>
                    <th>Unidades</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($entity->Productos as $pro) : ?>

                    <tr>
                        <td data-label="ID"><?= $pro->pro_id ?></td>
                        <td data-label="Nombre"><?= $pro->pro_nombre ?></td>
                        <td data-label="COSTO"><?= $pro->pro_valor ?></td>
                        <td data-label="Unidades"><?= $pro->prp_cantidad ?></td>
                    </tr>

                <?php endforeach; ?>

                <tr>
                    <td data-label="" colspan="3">TOTAL</td>
                    <td data-label="TOTAL"><?= $entity->ped_costo ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>