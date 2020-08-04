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
    <hr>
    <br>
    <p class="informacion"><?= 'Fecha: ' . date("d-m-Y", strtotime($entity->ped_fecha)); ?></p>
    <p class="informacion"><?= 'Cliente: ' . $entity->usr_nombre ?></p>
    <p class="informacion"><?= 'Ciudad: ' . $entity->ciu_nombre ?></p>
    <p class="informacion"><?= 'Dirección: ' . $entity->dir_direccion ?></p>
    <p class="informacion"><?= 'Teléfono: ' . $entity->usr_telefono ?></p>
    <p class="informacion"><?= 'Correo: ' . $entity->usr_correo ?></p>
    <p class="informacion"><?= 'Estado: ' . $entity->pes_nombre ?></p>
    <p class="informacion"><?= StringFormat::IsNullOrEmptyString($entity->ven_nombre) ? 'Vendedor: No asignado' : 'Vendedor: ' . $entity->ven_nombre ?></p>
    <p class="informacion"><?= StringFormat::IsNullOrEmptyString($entity->rep_nombre) ? 'Repartidor: No asignado' : 'Repartidor: ' . $entity->rep_nombre ?></p>
    <p class="informacion"><?= StringFormat::IsNullOrEmptyString($entity->suc_nombre) ? 'Sucursal: -' : 'Sucursal: ' . $entity->suc_nombre ?></p>
    <br />
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
                        <td data-label="COSTO"><?= $pro->pro_valor . ' $' ?></td>
                        <td data-label="Unidades"><?= $pro->prp_cantidad ?></td>
                    </tr>

                <?php endforeach; ?>

                <tr>
                    <td data-label="" colspan="3">TOTAL</td>
                    <td data-label="TOTAL"><?= $entity->ped_costo . ' $' ?></td>
                </tr>
            </tbody>
        </table>
        <div class="mapdetalles">
            <h2>Ubicación entrega</h2>
            <div id="myMap"></div>
        </div>
    </div>
</div>

<?php if ($entity->pes_nombre != PedidosEstatus::EnCamino) : ?>

    <script>
        LoadMap(<?= $entity->dir_latitud ?>, <?= $entity->dir_longitud ?>);
    </script>

<?php else : ?>

    <script>
        LoadMapRoute(<?= $entity->dir_latitud ?>, <?= $entity->dir_longitud ?>, <?= $entity->dirsuc_latitud ?>, <?= $entity->dirsuc_longitud ?>)
    </script>

<?php endif; ?>