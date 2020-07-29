<section id="bienvenida">
    <h2>Productos</h2>
    <p>Listado de productos</p>
</section>

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