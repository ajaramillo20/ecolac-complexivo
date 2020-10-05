<div class="miTabla">
    <?php if (isset($_SESSION['carritoIndexMensaje'])) {
        App::ShowMessage($_SESSION['carritoIndexMensaje'], 'Confirmación');
        App::UnsetSessionVar('carritoIndexMensaje');
    }
    if (isset($_SESSION['carritoIndexError'])) {
        App::ShowMessage($_SESSION['carritoIndexError'], 'Error');
        App::UnsetSessionVar('carritoIndexError');
    }
    $datos = App::EstadisticasCarrito();
    ?>
    <h3><?= isset($datos['count']) ? "Productos en carrito ({$datos['count']})" : "Productos en carrito"; ?></h3>
    <?php if ($datos['count'] > 0) : ?>
        <div class="contenedor">
            <table>
                <thead>
                    <tr>
                        <!-- <th>Id</th> -->
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Sucursal</th>
                        <th>Precio</th>
                        <th>Unidades</th>
                        <th>Total</th>
                        <!-- <th>Sucursal</th> -->
                        <th class="thAction">Añadir / Quitar</th>
                        <!-- <th class="thAction">Quitar</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($carrito as $indice => $elemento) :
                        $pro = $elemento['producto'];
                    ?>
                        <tr>
                            <!-- <td data-label="Id"><?= $pro->pro_id ?></td> -->
                            <td data-label="imagen"><img src="<?= base_url . $pro->rec_nombre ?>" /></td>
                            <td data-label="Nombre"><?= $pro->pro_nombre ?></td>
                            <td data-label="Descripción"><?= $pro->tip_nombre . '-' . $pro->cat_nombre . '-' . $pro->pre_nombre ?></td>
                            <td data-label="Sucursal"><?= $pro->suc_nombre ?></td>
                            <td data-label="Precio"><?= $pro->pro_valor . ' $' ?></td>
                            <td data-label="Unidades"><?= $elemento['unidades'] ?></td>
                            <td data-label="Total"><?= ($elemento['unidades'] * $pro->pro_valor) ?></td>
                            <!-- <td data-label="Sucursal"><?= $pro->suc_nombre ?></td> -->
                            <td data-label="Añadir/Quitar"><a href="<?= base_url . 'carrito/agregar&id=' . $pro->pro_id ?>" class="icon-carrito-agregar"></a></a>
                                <a class="icon-carrito-quitar" href="<?= base_url ?>carrito/eliminar&id=<?= $pro->pro_id ?>"></td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a class="btn icon-money" href="<?= base_url . 'pedido/realizar' ?>"><?= 'Confirmar pedido por: ' . number_format($datos['total'], 2) . ' $' ?></a>
        </div>
    <?php else : ?>
        <h3>Nada por aquí...</h3>
    <?php endif; ?>
</div>