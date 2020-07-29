<div class="contenedor div-form">
    <?php
    if (isset($_SESSION['productoRegistroError'])) {
        echo '<p class="error">' . $_SESSION['productoRegistroError'] . '</p>';
        App::UnsetSessionVar('productoRegistroError');
    }
    if (isset($_SESSION['productoRegistroMensaje'])) {
        echo '<p class="error">' . $_SESSION['productoRegistroMensaje'] . '</p>';
        App::UnsetSessionVar('productoRegistroMensaje');
    }
    ?>
    <?php if (isset($entity) && !is_null($entity)) : ?>
        <?php $url_action = base_url . 'producto/actualizar' ?>
        <h1>Edición de Producto</h1>
    <?php else : ?>
        <?php $url_action = base_url . 'producto/agregar' ?>
        <h1>Registro de productos</h1>
    <?php endif; ?>

    <form action="<?= $url_action ?>" method="POST" enctype="multipart/form-data" id="frmRegistroProducto" class="form-registro">
        <h2>Ingrese los datos del producto</h2>
        <div class="contenedor-inputs">
            <input type="text" name="pro_id" placeholder="pro_id" hidden="true" class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->pro_id : '';  ?>" />
            <input type="text" name="rec_id" placeholder="rec_id" hidden="true" class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->rec_id : '';  ?>" />

            <label>Nombre producto</label>
            <input type="text" name="nombre" placeholder="Nombre" required="true" class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->pro_nombre : '';  ?>" />
            <label>Tipo de producto</label>
            <select id="cmbTipos" name="tipo" required="true" class="input-100">
                <?php $tipos = AppController::GetTipos(); ?>
                <?php while ($tip = $tipos->fetch_object()) : ?>
                    <option value="<?= $tip->tip_id ?>" <?= isset($entity) && !is_null($entity) && $tip->tip_id == $entity->tip_id ? 'selected' : ''; ?>>
                        <?= $tip->tip_nombre ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <label>Categoria</label>
            <select id="cmbCategorias" name="categoria" class="input-100">
                <?php $categorias = AppController::GetCategorias(); ?>
                <?php while ($cat = $categorias->fetch_object()) : ?>
                    <option cat="<?= $cat->tip_id ?>" value="<?= $cat->cat_id ?>" <?= isset($entity) && !is_null($entity) && $cat->cat_id == $entity->cat_id ? 'selected' : ''; ?>>
                        <?= $cat->cat_nombre ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <label for="presentacion">Presentacion</label>
            <select name="presentacion" class="input-100">
                <?php $presentaciones = AppController::GetPresentacion(); ?>
                <?php while ($pre = $presentaciones->fetch_object()) : ?>
                    <option value="<?= $pre->pre_id ?>" <?= isset($entity) && !is_null($entity) && $pre->pre_id == $entity->pre_id ? 'selected' : ''; ?>>
                        <?= $pre->pre_nombre ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <label for="sucursal">Sucursal</label>
            <select required="true" name="sucursal" class="input-100">
                <?php $sucursales = AppController::GetSucursales(); ?>
                <?php while ($suc = $sucursales->fetch_object()) : ?>
                    <option value="<?= $suc->suc_id ?>" <?= isset($entity) && !is_null($entity) && $suc->suc_id == $entity->suc_id ? 'selected' : ''; ?>>
                        <?= $suc->suc_nombre ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <label for="valor">Valor</label>
            <input type="number" step="0.01" name="valor" placeholder="Valor $" required="true" class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->pro_valor : ''; ?>" />
            <label for="stock">Stock</label>
            <input type="number" step="1" name="stock" placeholder="Stock" required="true" class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->pro_cantStock : ''; ?>" />
            <label>Imagen</label>
            <?php if (isset($entity) && !is_null($entity)) : ?>
                <img id="imgPro" src="<?= App::GetImagesPath() . $entity->rec_nombre ?>" />
            <?php endif; ?>
            <input type="file" name="imagen" <?= isset($entity) && !is_null($entity) ? '' : 'required="true"'; ?> class="input-100" />

            <input type="submit" value="Guardar" class="btn-enviar" />
        </div>
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        recargarCategorias();
    })

    $("#cmbTipos").change(function() {
        recargarCategorias();
    });

    function recargarCategorias() {
        if ($('#cmbTipos').data('options') === undefined) {
            /*Taking an array of all options-2 and kind of embedding it on the select1*/
            $('#cmbTipos').data('options', $('#cmbCategorias option').clone());
        }
        var id = $('#cmbTipos').val();
        var options = $('#cmbTipos').data('options').filter('[cat=' + id + ']');
        $('#cmbCategorias').html(options);
    }
</script>