<div class="contenedor div-form">
    <?php
    if (isset($_SESSION['presentacionRegistroError'])) {
        echo '<p class="error">' . $_SESSION['presentacionRegistroError'] . '</p>';
        App::UnsetSessionVar('presentacionRegistroError');
    }
    if (isset($entity) && !is_null($entity)) {
        $titulo = 'Editar presentación';
        $url_action = base_url . 'presentacion/actualizar';
    } else {
        $titulo = 'Registrar presentación';
        $url_action = base_url . 'presentacion/agregar';
    }
    ?>

    <form action="<?= $url_action ?>" method="POST" class="form-registro">
        <h2><?= $titulo ?></h2>
        <div class="contenedor-inputs">
            <input hidden="true" type="text" name="pre_id" placeholder="Presentación" class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->pre_id : '' ?>" />
            <label for="nombre">Presentación</label>
            <input type="text" name="nombre" placeholder="Presentación" required="true" class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->pre_nombre : '' ?>" />
            <input type="submit" value="Guardar" class="btn-enviar" />
        </div>
    </form>
</div>