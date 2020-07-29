<div class="miTabla">
    <h3>Gestion de usuarios</h3>
    <?php
    if (isset($_SESSION['usuarioGestionMensaje'])) {
        echo '<p class="succes">' . $_SESSION['usuarioGestionMensaje'] . '</p>';
        App::UnsetSessionVar('usuarioGestionMensaje');
    }
    if (isset($_SESSION['usuarioGestionError'])) {
        echo '<p class="error">' . $_SESSION['usuarioGestionError'] . '</p>';
        App::UnsetSessionVar('usuarioGestionError');
    } ?>
    <div class="contenedor">
        <a class="btn" href="<?= base_url ?>usuario/registro">Agregar</a>
        <table>
            <thead>
                <tr>
                    <th class="thAction">Id</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th class="thAction">Editar</th>
                    <th class="thAction">Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($usr = $usuarios->fetch_object()) : ?>
                    <tr>
                        <td data-label="id"><?= $usr->usr_id ?></td>
                        <td data-label="Tipo"><?= $usr->usr_nombre ?></td>
                        <td data-label="Categoria"><?= $usr->usr_correo ?></td>
                        <td data-label="editar"><a class="icon-eye btn-action" href="<?= base_url . 'usuario/editar&id=' . $usr->usr_id ?>"></a></td>
                        <td data-label="eliminar"><a onclick="return ConfirmDelete();" class="icon-trash btn-action" href="<?= base_url ?>usuario/eliminar&id=<?= $usr->usr_id ?>"></a></td>
                    </tr>
                <?php endwhile; ?>
            <tbody>
        </table>
    </div>
</div>