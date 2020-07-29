<div class="miTabla">
    <h3>Tipo de productos</h3>
    <div class="contenedor">
        <a class="btn" href="<?= base_url ?>tipo/registrar">Agregar</a>
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
                <?php while ($tip = $tipos->fetch_object()) : ?>
                    <tr>
                        <td data-label="id"><?= $tip->tip_id ?></td>
                        <td data-label="nombre"><?= $tip->tip_nombre ?></td>
                        <td data-label="editar"><a class="icon-eye btn-action" href="#"></a></td>
                        <td data-label="eliminar"><a class="icon-trash btn-action" href="#"></a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
<br />
<hr />
<br />
<?php require_once 'views/presentacion/gestion.php'; ?>