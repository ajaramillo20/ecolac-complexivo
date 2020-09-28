<div class="miTabla">
    <div class="contenedor-filtros">
        <label for="sucursales">Sucursal:</label>
        <select class="input-100" name="sucursales" id="sucursales">
            <option value="">
                Todos
            </option>
            <?php if (isset($sucursales)) : ?>
                <?php while ($suc = $sucursales->fetch_object()) : ?>

                    <option value="<?= $suc->suc_id ?>" <?= isset($_SESSION['succonnect']->suc_id) && $suc->suc_id == $_SESSION['succonnect']->suc_id ? 'selected' : ''; ?>>
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

                    <option value="<?= $tip->tip_id ?>" <?= isset($_SESSION['PROARGS']->tip_id) && $tip->tip_id == $_SESSION['PROARGS']->tip_id ? 'selected' : ''; ?>>
                        <?= $tip->tip_nombre ?>
                    </option>

                <?php endwhile; ?>
            <?php endif; ?>
        </select>

        <label for="buscar">Buscar producto</label>
        <input class="input-100" type="text" name="buscar" id="buscar" value="<?= isset($_SESSION['PROARGS']->pro_nombre) ? $_SESSION['PROARGS']->pro_nombre : "" ?>">
        <div class="contenedor">
            <a class="btnaccion input-48 icon-search" href="javascript:void(0);" onclick="onChange()">Buscar</a>
        </div>
    </div>
</div>

<section id="bienvenida">
    <h2>Productos</h2>
    <p>Listado de productos</p>
</section>

<section class="productos">
    <!-- <h3>Productos</h3> -->
    <div class="contenedor">
        <?php foreach ($productos as $pro) : ?>
            <article>

                <img alt="producto" src="<?= base_url . $pro->rec_nombre ?>" />
                <h4><?= $pro->pro_nombre ?></h4>
                <p><?= $pro->tip_nombre . ', ' . $pro->cat_nombre . ', ' . $pro->pre_nombre ?></p>
                <h4><?= $pro->pro_valor . ' $' ?></h4>
                <h4><a href="javascript:void(0);" onclick="addToCar('<?= base_url . 'carrito/agregarAjax&id=' . $pro->pro_id ?>', this )" id class="icon-carrito-agregar">Comprar</a></h4>
            </article>

        <?php endforeach; ?>
    </div>
</section>

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

        var baseurl = '<?= base_url . 'producto/selectsucursal' ?>' + params;
        $.ajax({
            type: "POST",
            url: baseurl,
            success: function(result) {
                window.location.reload();
            }
        });
    }

    function addToCar(url, o) {
        $.ajax({
            type: "POST",
            url: url,
            success: function(result) {
                var type = 'info';
                var msg = '';
                if (result == 'Correcto') {
                    msg = 'Agregado a carrito!'
                    type = 'success';
                } else {
                    msg = result;
                }
                $.notify(o, msg, type, {
                    elementPosition: 'bottom center'
                });
            }
        });
    }
</script>