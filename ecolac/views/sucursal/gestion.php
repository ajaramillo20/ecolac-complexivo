<div class="miTabla">
    <h3>Gestion Sucursales</h3>
    <?php if (isset($_SESSION['sucursalGestionMensaje'])) {
        echo '<p class="succes">' . $_SESSION['sucursalGestionMensaje'] . '</p>';
        App::UnsetSessionVar('sucursalGestionMensaje');
    }
    if (isset($_SESSION['sucursalGestionError'])) {
        echo '<p class="error">' . $_SESSION['sucursalGestionError'] . '</p>';
        App::UnsetSessionVar('sucursalGestionError');
    }
    ?>
    <div class="contenedor">
        <a class="btn" href="<?= base_url ?>sucursal/registrar">Agregar</a>
        <table>
            <thead>
                <tr>
                    <th class="thAction">Id</th>
                    <th>Nombre</th>
                    <th>Ciudad</th>
                    <th>Dirección</th>
                    <th class="thAction">Editar</th>
                    <th class="thAction">Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($suc = $sucursales->fetch_object()) : ?>
                    <tr>
                        <td data-label="Sucursal id"><?= $suc->suc_id ?></td>
                        <td data-label="Nombre"><?= $suc->suc_nombre ?></td>
                        <td data-label="Ciudad"><?= $suc->ciu_nombre ?></td>
                        <td data-label="Dirección"><?= $suc->dir_direccion ?></td>
                        <td data-label="Editar"><a class="icon-pencil-neg" href="<?= base_url ?>sucursal/editar&id=<?= $suc->suc_id ?>"></a></td>
                        <td data-label="Eliminar"><a onclick="return ConfirmDelete('<?= base_url ?>sucursal/eliminar&id=<?= $suc->suc_id ?>');" class="icon-trash btn-action" href="#"></a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>