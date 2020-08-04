<div class="miTabla">
    <?php if (isset($_SESSION['gestionEntregaMensaje'])) {
        App::ShowMessage($_SESSION['gestionEntregaMensaje'], 'Confirmación');
        App::UnsetSessionVar('gestionEntregaMensaje');
    }
    if (isset($_SESSION['gestionEntregaError'])) {
        App::ShowMessage($_SESSION['gestionEntregaError'], 'Error');
        App::UnsetSessionVar('gestionEntregaError');
    }
    if (!isset($entity) || is_null($entity)) {
        App::Redirect('pedido/entregassucursal');
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
    <br />
    <div class="contenedor">
        <a class="btnaccion icon-angle-circled-left" onclick="GoBack();">Regresar</a>

        <?php if ($entity->pes_nombre == PedidosEstatus::Despachado) : ?>

            <a class="btnaccion icon-user-plus" href="<?= base_url . 'pedido/entregar&id=' . $entity->ped_id . '&rep=' . $_SESSION['userconnect']->usr_id ?>">Asignarme entrega</a>

        <?php elseif ($entity->pes_nombre == PedidosEstatus::EnCamino) : ?>

            <a class="btnaccion icon-angle-circled-down" href="<?= base_url . 'pedido/entregar&id=' . $entity->ped_id ?>">Entregado</a>

        <?php endif; ?>
    </div>
</div>