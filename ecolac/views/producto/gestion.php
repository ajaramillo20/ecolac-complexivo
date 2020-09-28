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
        <a class="btn icon-plus" href="<?= base_url ?>producto/registrar">Agregar nuevo producto</a>
        <section class="filters">

            <label for="sucursales">Tipo:</label>
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
            <label for="sucursales">Categoria:</label>
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
        </section>
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
                        <td data-label="Editar"><a class="icon-pencil-neg" href="<?= base_url ?>producto/editar&id=<?= $pro->pro_id ?>">Editar</a></td>
                        <td data-label="Eliminar"><a onclick="return ConfirmDelete('<?= base_url ?>producto/eliminar&id=<?= $pro->pro_id ?>');" class="icon-trash btn-action" href="#">Eliminar</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>