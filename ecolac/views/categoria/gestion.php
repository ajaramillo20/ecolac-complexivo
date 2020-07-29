<div class="miTabla">
    <h3>Gestion categorias</h3>
    <div class="contenedor">
        <a class="btn" href="<?= base_url ?>categoria/registrar">Agregar</a>
        <table>
            <thead>
                <tr>
                    <th class="thAction">Id</th>
                    <th>Tipo producto</th>
                    <th>Categoria</th>
                    <th class="thAction">Editar</th>
                    <th class="thAction">Eliminar</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($cat = $categorias->fetch_object()) : ?>
                <tr>
                    <td data-label="id"><?= $cat->cat_id ?></td>
                    <td data-label="Tipo"><?= $cat->tip_nombre ?></td>
                    <td data-label="Categoria"><?= $cat->cat_nombre ?></td>
                    <td data-label="editar"><a class="icon-eye btn-action" href="<?= base_url ?>categoria/editar&id=<?= $cat->cat_id ?>"></a></td>
                    <td data-label="eliminar"><a onclick="return ConfirmDelete();" class="icon-trash btn-action" href="<?= base_url ?>categoria/eliminar&id=<?= $cat->cat_id ?>"></a></td>
                </tr>
            <?php endwhile; ?>
            <tbody>
        </table>
    </div>
</div>