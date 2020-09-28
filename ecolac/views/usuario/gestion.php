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
        <a class="btn icon-user-plus" href="<?= base_url ?>usuario/registro">Agregar nuevo usuario</a>

        <section class="filters">
            <label for="sucursales">Rol:</label>
            <select class="input-filter" name="sucursales" id="sucursales">
                <option value="">
                    Todos
                </option>
                <?php if (isset($sucursales)) : ?>
                    <?php while ($suc = $sucursales->fetch_object()) : ?>

                        <option value="<?= $suc->suc_id ?>" <?= isset($_SESSION['succonnect']) && $suc->suc_id == $_SESSION['succonnect']->suc_id ? 'selected' : ''; ?>>
                            <?= $suc->ciu_nombre . ': ' . $suc->suc_nombre ?>
                        </option>

                    <?php endwhile; ?>
                <?php endif; ?>
            </select>
            <label for="sucursales">Nombre:</label>
            <input type="text">
        </section>


        <table>
            <thead>
                <tr>
                    <th class="thAction">Id</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th class="thAction">Editar</th>
                    <th class="thAction">Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($usr = $usuarios->fetch_object()) : ?>
                    <tr>
                        <td data-label="id"><?= $usr->usr_id ?></td>
                        <td data-label="Nombre"><?= $usr->usr_nombre ?></td>
                        <td data-label="Correo"><?= $usr->usr_correo ?></td>
                        <td data-label="Rol"><?= $usr->rol_nombre ?></td>
                        <td data-label="editar"><a class="icon-eye btn-action" href="<?= base_url . 'usuario/editar&id=' . $usr->usr_id ?>">Editar</a></td>
                        <td data-label="eliminar"><a onclick="return ConfirmDelete('<?= base_url ?>usuario/eliminar&id=<?= $usr->usr_id ?>');" class="icon-trash btn-action" href="#">Eliminar</a></td>
                    </tr>
                <?php endwhile; ?>
            <tbody>
        </table>
    </div>
</div>