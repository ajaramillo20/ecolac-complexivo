<?php
if (isset($_SESSION['presentacionGestionMensaje'])) {
        echo '<p class="succes">' . $_SESSION['presentacionGestionMensaje'] . '</p>';
        App::UnsetSessionVar('presentacionGestionMensaje');
    }
    if (isset($_SESSION['presentacionGestionError'])) {
        echo '<p class="error">' . $_SESSION['presentacionGestionError'] . '</p>';
        App::UnsetSessionVar('presentacionGestionError');
    }
?>
<div class="miTabla">
    <h3>Presentación</h3>
    <div class="contenedor">
        <a class="btn" href="<?= base_url ?>presentacion/registrar">Agregar</a>
        <table>
            <thead>
                <tr>
                    <th class="thAction">Id</th>
                    <th>Nombre</th>
                    <th class="thAction">Editar</th>
                    <th class="thAction">Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php $presentaciones = AppController::GetPresentacion(); ?>
                <?php while ($pre = $presentaciones->fetch_object()) : ?>
                    <tr>
                        <td data-label="id"><?= $pre->pre_id ?></td>
                        <td data-label="nombre"><?= $pre->pre_nombre ?></td>
                        <td data-label="editar"><a class="icon-eye btn-action" href="<?= base_url . 'presentacion/editar&id=' . $pre->pre_id ?>"></a></td>
                        <td data-label="eliminar"><a class="icon-trash btn-action" href="<?= base_url . 'presentacion/eliminar&id=' . $pre->pre_id ?>"></a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>