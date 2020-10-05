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

    <div class="contenedor-filtros">
        <label for="sucursales">Sucursal:</label>
        <select class="input-100" name="sucursales" id="sucursales">
            <option value="">
                Todos
            </option>
            <?php if (isset($sucursales)) : ?>
                <?php while ($suc = $sucursales->fetch_object()) : ?>

                    <option value="<?= $suc->suc_id ?>" <?= isset($_SESSION['PROGARGS']->suc_id) && $suc->suc_id == $_SESSION['PROGARGS']->suc_id ? 'selected' : ''; ?>>
                        <?= $suc->ciu_nombre . ': ' . $suc->suc_nombre ?>
                    </option>

                <?php endwhile; ?>
            <?php endif; ?>

        </select>

        <label for="categorias">Categorias:</label>
        <select class="input-100" name="categorias" id="categorias">
            <option value="">
                Todos
            </option>
            <?php if (isset($tipos)) : ?>
                <?php while ($tip = $tipos->fetch_object()) : ?>

                    <option value="<?= $tip->tip_id ?>" <?= isset($_SESSION['PROGARGS']->tip_id) && $tip->tip_id == $_SESSION['PROGARGS']->tip_id ? 'selected' : ''; ?>>
                        <?= $tip->tip_nombre ?>
                    </option>

                <?php endwhile; ?>
            <?php endif; ?>
        </select>

        <label for="buscar">Buscar producto</label>
        <input class="input-100" type="text" name="buscar" id="buscar" value="<?= isset($_SESSION['PROGARGS']->pro_nombre) ? $_SESSION['PROGARGS']->pro_nombre : "" ?>">
        <div class="contenedor">
            <a class="btnaccion input-48 icon-search" href="javascript:void(0);" onclick="onChange()">Buscar</a>
            <a class="btnaccion input-48 icon-cancel" href="javascript:void(0);" onclick="cleanFilters()">Limpiar filtros</a>
        </div>
    </div>

    <div class="contenedor">
        <a class="btn icon-plus" href="<?= base_url ?>producto/registrar">Agregar nuevo producto</a>
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
                <?php foreach ($productos as $pro) : ?>
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
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="miTabla">
    <p> <?= $paginaActual . ' de ' . $paginas->Paginas ?></p>
    <div class="contenedor">
        <?php if ($paginaActual > 1) : ?>
            <a class="btnaccion icon-angle-circled-left" href="javascript:void(0);" onclick="onChange(<?= $paginaActual - 1 ?>);"></a>
        <?php endif; ?>
        <?php if ($paginaActual < $paginas->Paginas) : ?>
            <a class="btnaccion icon-angle-circled-right" href="javascript:void(0);" onclick="onChange(<?= $paginaActual + 1 ?>);"></a>
        <?php endif; ?>
    </div>
</div>

<script type="text/javascript">
    /* PREPARE THE SCRIPT */
    $("#sucursales").change(onChange);
    $("#categorias").change(onChange);
    $("#buscar").keydown(function(e) {
        if (e.keyCode == 13) {
            onChange();
        }
    });

    function cleanFilters() {
        document.getElementById('sucursales').value = '';
        document.getElementById('categorias').value = '';
        document.getElementById('buscar').value = '';
        onChange();
    }

    function onChange(pag = '1') {
        let suc = $('#sucursales').val();
        let cat = $('#categorias').val();
        let pro = $('#buscar').val();
        console.log(suc + cat + pro);
        let params = "&pag=" + pag;
        console.log("pag:" + pag);
        if (suc) {
            params += "&suc=" + suc;
        }

        if (cat) {
            params += "&cat=" + cat;
        }

        if (pro) {
            params += "&pro=" + pro;
        }

        var baseurl = '<?= base_url . 'producto/selectProAjaxArgs' ?>' + params;
        $.ajax({
            type: "POST",
            url: baseurl,
            success: function(result) {
                window.location.reload();
            }
        });
    }
</script>