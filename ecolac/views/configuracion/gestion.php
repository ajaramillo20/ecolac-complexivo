<div class="miTabla">
    <h3>Mis pedidos</h3>
    <?php if (isset($_SESSION['configuracionGestionMensaje'])) {
        App::ShowMessage($_SESSION['configuracionGestionMensaje'], 'Confirmación');
        App::UnsetSessionVar('configuracionGestionMensaje');
    }
    if (isset($_SESSION['configuracionGestionError'])) {
        App::ShowMessage($_SESSION['configuracionGestionError'], 'Error');
        App::UnsetSessionVar('configuracionGestionError');
    }
    ?>

    <div class="contenedor">
        <a class="btn" href="<?= base_url ?>configuracion/registrar">Agregar</a>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descripción</th>
                    <th>Valor</th>
                    <th class="thAction">Editar</th>
                    <th class="thAction">Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($configuraciones as $conf) : ?>
                    <tr>
                        <td data-label="ID"><?= $conf->conf_id ?></td>
                        <td data-label="ID"><?= $conf->conf_descripcion ?></td>
                        <td data-label="COSTO"><?= $conf->conf_valor ?></td>
                        <td data-label="Editar"><a href="<?= base_url . 'configuracion/editar&id=' . $conf->conf_id ?>" class="icon-eye"></a></td>
                        <td data-label="Eliminar"><a href="#" onclick="return ConfirmDelete('<?= base_url ?>configuracion/eliminar&id=<?= $conf->conf_id ?>');" class="icon-eye"></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>