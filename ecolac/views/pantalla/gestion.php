<div class="miTabla">
    <h3>Gestion transacciones de usuario</h3>
    <?php if (isset($_SESSION['pantallaGestionMensaje'])) {
        //echo '<p class="succes">' . $_SESSION['pantallaGestionMensaje'] . '</p>';
        App::UnsetSessionVar('pantallaGestionMensaje');
    }
    if (isset($_SESSION['pantallaGestionError'])) {
        //echo '<p class="error">' . $_SESSION['pantallaGestionError'] . '</p>';
        App::UnsetSessionVar('pantallaGestionError');
    }
    ?>
    <div class="contenedor">
        <a class="btn icon-plus" href="<?= base_url ?>pantalla/registrar">Agregar transacción a rol</a>
        <table>
            <thead>
                <tr>
                    <th class="thAction">Id</th>
                    <th>Pantalla</th>
                    <th>Ruta</th>
                    <th>Rol</th>
                    <th>Mostrar en menu</th>
                    <th class="thAction">Editar</th>
                    <th class="thAction">Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($pnt = $pantallas->fetch_object()) : ?>
                    <tr>
                        <td data-label="Pantalla id"><?= $pnt->pnt_id ?></td>
                        <td data-label="Nombre"><?= $pnt->pnt_nombre ?></td>
                        <td data-label="Ruta"><?= $pnt->pnt_vinculo ?></td>
                        <td data-label="Rol"><?= $pnt->rol_nombre ?></td>
                        <td data-label="Mostrar en menu"><?= $pnt->pnt_menu ?></td>
                        <td data-label="Editar"><a class="icon-pencil-neg" href="<?= base_url ?>pantalla/editar&id=<?= $pnt->pnt_id ?>">Editar</a></td>
                        <td data-label="Eliminar"><a onclick="return ConfirmDelete('<?= base_url ?>pantalla/eliminar&id=<?= $pnt->pnt_id ?>');" class="icon-trash btn-action" href="#">Eliminar</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>