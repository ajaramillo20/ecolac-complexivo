<br />
<hr />
<div class="miTabla">
    <h3>Direcciones registradas</h3>
    <?php
    if (isset($_SESSION['direccionGestionMensaje'])) {
        echo '<p class="succes">' . $_SESSION['direccionGestionMensaje'] . '</p>';
        App::UnsetSessionVar('direccionGestionMensaje');
    }
    if (isset($_SESSION['direccionGestionError'])) {
        echo '<p class="error">' . $_SESSION['direccionGestionError'] . '</p>';
        App::UnsetSessionVar('direccionGestionError');
    } ?>
    <div class="contenedor">
        <a class="btn" href="<?= base_url . 'direccion/registro&usr=' . $entity->usr_id ?>">Agregar</a>
        <table>
            <thead>
                <tr>
                    <th>Direccion</th>
                    <th>Latitud</th>
                    <th>Longitud</th>
                    <th class="thAction">Editar</th>
                    <th class="thAction">Eliminar</th>
                </tr>
            </thead>
            <tbody>

                <?php if (isset($entity) && !is_null($entity) &&  count($entity->Direccion) > 0) : ?>
                    <?php foreach ($entity->Direccion  as $dir) : ?>
                        <tr>
                            <!-- <td data-label="id"><?= $dir->dir_id ?></td> -->
                            <td data-label="Direccion"><?= $dir->dir_direccion ?></td>
                            <td data-label="Latitud"><?= $dir->dir_latitud ?></td>
                            <td data-label="Longitud"><?= $dir->dir_longitud ?></td>
                            <td data-label="editar"><a class="icon-eye btn-action" href="<?= base_url . 'direccion/editar&dir=' . $dir->dir_id ?>"></a></td>
                            <td data-label="eliminar"><a onclick="return ConfirmDelete();" class="icon-trash btn-action" href="<?= base_url ?>direccion/eliminar&dir=<?= $dir->dir_id ?>"></a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            <tbody>
        </table>
    </div>
</div>