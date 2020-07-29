<div class="miTabla">
    <h3>Gestion de productos</h3>
    <?php if (isset($_SESSION['productoGestionMensaje'])) {
        echo '<p class="succes">' . $_SESSION['productoGestionMensaje'] . '</p>';
        App::UnsetSessionVar('productoGestionMensaje');
    }
    if (isset($_SESSION['productoGestionError'])) {
        echo '<p class="error">' . $_SESSION['productoGestionError'] . '</p>';
        App::UnsetSessionVar('productoGestionError');
    }
    ?>
    <div class="contenedor">
        <a class="btn" href="<?= base_url ?>producto/registrar">Agregar</a>
        <table>
            <thead>
                <tr>
                    <th class="thAction">Id</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Categoria</th>
                    <th>Presentacion</th>
                    <th>Valor</th>
                    <th>Stock</th>
                    <th>Ciudad</th>
                    <th>sucursal</th>
                    <th class="thAction">Editar</th>
                    <th class="thAction">Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($pro = $productos->fetch_object()) : ?>
                    <tr>
                        <td data-label="Producto id"><?= $pro->pro_id ?></td>
                        <td data-label="Nombre"><?= $pro->pro_nombre ?></td>
                        <td data-label="Tipo"><?= $pro->tip_nombre ?></td>
                        <td data-label="Categoria"><?= $pro->cat_nombre ?></td>
                        <td data-label="Presentación"><?= $pro->pre_nombre ?></td>
                        <td data-label="Valor"><?= $pro->pro_valor ?></td>
                        <td data-label="Stock"><?= $pro->pro_cantStock ?></td>
                        <td data-label="Ciudad"><?= $pro->ciu_nombre ?></td>
                        <td data-label="Sucursal"><?= $pro->suc_nombre ?></td>
                        <td data-label="Editar"><a class="icon-pencil-neg" href="<?= base_url ?>producto/editar&id=<?= $pro->pro_id ?>"></a></td>
                        <td data-label="Eliminar"><a onclick="return ConfirmDelete();" class="icon-trash btn-action" href="<?= base_url ?>producto/eliminar&id=<?= $pro->pro_id ?>"></a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>