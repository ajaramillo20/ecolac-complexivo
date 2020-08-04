<div class="contenedor div-form">
    <?php
    if (isset($_SESSION['pedidoRegistroError'])) {
        echo '<p class="error">' . $_SESSION['PedidoRegistroError'] . '</p>';
        App::UnsetSessionVar('PedidoRegistroError');
    }
    ?>
    <?php if (isset($entity) && !is_null($entity)) : ?>
        <?php $url_action = base_url . 'pedido/actualizar' ?>
        <h1>Editar pedido</h1>
    <?php else : ?>
        <?php $url_action = base_url . 'pedido/agregar' ?>
        <h1>Confirmar pedido</h1>
    <?php endif; ?>

    <form action="<?= $url_action ?>" method="POST" class="form-registro">
        <h2>Confirme los datos para su pedido</h2>
        <div class="contenedor-inputs">
            <input type="text" name="pedidoid" hidden class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->dir_direccion : ''; ?>" />
            <label for="direccion">Dirección donde desea recibir el pedido</label>
            <?php $direcciones = AppController::GetDirecciones($_SESSION['userconnect']->usr_id); ?>
            <select name="direccion" class="input-100">
                <?php foreach ($direcciones as $dir) : ?>
                    <option value="<?= $dir->dir_id ?>" <?= isset($_SESSION['dirconnect']) && $dir->dir_id == $_SESSION['dirconnect']->dir_id ? 'selected' : ''; ?>>
                        <?= $dir->dir_direccion ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="observacion">Observaciones para su pedido</label>
            <input type="text" name="observacion" placeholder="Observaciones" class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->dir_direccion : ''; ?>" />

            <input type="submit" value="Guardar" class="btn-enviar" />
        </div>
    </form>
</div>