<section id="bienvenida">
    <h2>Productos</h2>
    <p>Listado de productos</p>
</section>

<?php if (isset($_SESSION['userconnect'])) : ?>

    <section class="filters">
        <label for="sucursales">Sucursal:</label>
        <select class="input-filter" name="sucursales" id="sucursales">

            <?php if (isset($sucursales)) : ?>
                <?php while ($suc = $sucursales->fetch_object()) : ?>

                    <option value="<?= $suc->suc_id ?>" <?= isset($_SESSION['succonnect']) && $suc->suc_id == $_SESSION['succonnect']->suc_id ? 'selected' : ''; ?>>
                        <?= $suc->ciu_nombre . ': ' . $suc->suc_nombre ?>
                    </option>

                <?php endwhile; ?>
            <?php endif; ?>

        </select>
    </section>

<?php endif; ?>

<section class="productos">
    <h3>Productos</h3>
    <div class="contenedor">
        <?php while ($pro = $productos->fetch_object()) : ?>
            <article>

                <img src="<?= base_url . $pro->rec_nombre ?>" />
                <h4><?= $pro->pro_nombre ?></h4>
                <p><?= $pro->tip_nombre . ', ' . $pro->cat_nombre . ', ' . $pro->pre_nombre ?></p>
                <h4><?= $pro->pro_valor . ' $' ?></h4>
                <h4><a href="<?= base_url . 'carrito/agregar&id=' . $pro->pro_id ?>" class="icon-carrito-agregar">Comprar</a></h4>
            </article>

        <?php endwhile; ?>
    </div>
</section>

<script type="text/javascript">
    /* PREPARE THE SCRIPT */
    $("#sucursales").change(function() {
        /* WHEN YOU CHANGE AND SELECT FROM THE SELECT FIELD */
        var filter = $(this).val();

        var dataString = "suc=" + filter; /* STORE THAT TO A DATA STRING */
        var baseurl = '<?= base_url . 'producto/selectsucursal&suc=' ?>' + filter;
        console.log(baseurl);
        console.log(filter);
        $.ajax({
            /* THEN THE AJAX CALL */
            type: "POST",
            /* TYPE OF METHOD TO USE TO PASS THE DATA */
            url: baseurl,
            /* PAGE WHERE WE WILL PASS THE DATA */
            /* THE DATA WE WILL BE PASSING */
            success: function(result) {
                window.location.reload();
            }
        });
    });
</script>