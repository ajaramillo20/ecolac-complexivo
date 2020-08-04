<div class="miTabla">
    <?php if (isset($_SESSION['gestionPedidoMensaje'])) {
        App::ShowMessage($_SESSION['gestionPedidoMensaje'], 'Confirmación');
        App::UnsetSessionVar('gestionPedidoMensaje');
    }
    if (isset($_SESSION['gestionPedidoError'])) {
        App::ShowMessage($_SESSION['gestionPedidoError'], 'Error');
        App::UnsetSessionVar('gestionPedidoError');
    }
    if (!isset($entity) || is_null($entity)) {
        App::Redirect('pedido/gestion');
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
    <p class="informacion"><?= StringFormat::IsNullOrEmptyString($entity->rep_nombre) ? 'Repartidor: No asignado' : 'Repartidor: ' . $entity->ven_nombre ?></p>
    <br />
    <div class="contenedor">


        <?php if ($entity->pes_nombre != PedidosEstatus::Despachado) : ?>

            <a class="btnaccion icon-cancel" onclick="ConfirmDelete('<?= base_url . 'pedido/rechazar&id=' . $entity->ped_id ?>');">Rechazar</a>
            <a class="btnaccion icon-caja" href="<?= base_url . 'pedido/despachar&id=' . $entity->ped_id . '&ven=' . $_SESSION['userconnect']->usr_id ?>">Despachar</a>

        <?php else : ?>

            <a class="btnaccion icon-angle-circled-left" onclick="GoBack();">Regresar</a>

        <?php endif; ?>
    </div>
</div>