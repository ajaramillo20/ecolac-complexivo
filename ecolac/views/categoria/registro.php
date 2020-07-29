<div class="contenedor div-form">
    <?php
    if (isset($_SESSION['registroCategoriaError'])) {
        echo '<p class="error">' . $_SESSION['registroCategoriaError'] . '</p>';
        App::UnsetSessionVar('registroCategoriaError');
    }
    ?>
    <?php if (isset($editar) && $editar && !is_null($entity)) : ?>
        <?php $url_action = base_url . 'categoria/actualizar' ?>
        <h1>Editar categoria</h1>
    <?php else : ?>
        <?php $url_action = base_url . 'categoria/agregar'; ?>
        <h1>Registro de categoria</h1>
    <?php endif; ?>
    <form action="<?= $url_action ?>" method="POST" class="form-registro">
        <h2>Datos categoria</h2>
        <div class="contenedor-inputs">
            <label>Tipo producto</label>
            <select name="tipo" required="true" class="input-100">
                <option value="">Seleccione un tipo de producto</option>
                <?php $tipos = AppController::GetTipos() ?>
                <?php while ($tip = $tipos->fetch_object()) : ?>
                    <option value="<?= $tip->tip_id ?>" <?= isset($entity) && !is_null($entity) && $tip->tip_id == $entity->tip_id ? 'selected' : ''; ?>>
                        <?= $tip->tip_nombre ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <label>Nombre categoria</label>
            <input type="text" name="nombre" placeholder="Nombre" required="true" class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->cat_nombre : '' ?>" />
            <input type="text" hidden name="catid" class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->cat_id : '' ?>" />
            <input type="submit" value="Guardar" class="btn-enviar" />
        </div>
    </form>
</div>