<div class="contenedor div-form">
    <?php
    if (isset($_SESSION['registroPantallaError'])) {
        echo '<p class="error">' . $_SESSION['registroPantallaError'] . '</p>';
        App::UnsetSessionVar('registroPantallaError');
    }    
    if (isset($entity) && !is_null($entity)) {        
        $titulo = 'Editar pantalla';
        $url_action = base_url . 'pantalla/actualizar';
    } else {
        $titulo = 'Agregar pantalla';
        $url_action = base_url . 'pantalla/agregar';
    }
    ?>
    <h1><?= $titulo ?></h1>
    <form action="<?= $url_action ?>" method="POST" class="form-registro">
        <h2>Complete los campos</h2>
        <div class="contenedor-inputs">
        <input type="text" name="id" placeholder="" hidden="true" class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->pnt_id : '' ?>" />
            <label>Pantalla</label>
            <input type="text" name="nombre" placeholder="Nombre ruta" required="true" class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->pnt_nombre : '' ?>" />
            <label>Controlador</label>
            <input type="text" name="ruta" placeholder="ruta" required="true" class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->pnt_vinculo : '' ?>" />
            <label>Mostrar en menu</label>
            <select name="menu" class="input-100" required="true">
                <option value="1" <?= isset($entity) && !is_null($entity) && $entity->pnt_menu == '1' ? 'selected' : '' ?>>SI</option>
                <option value="0" <?= isset($entity) && !is_null($entity) && $entity->pnt_menu == '0' ? 'selected' : '' ?>>NO</option>
            </select>
            <label>Rol permitido</label>
            <select name="rol" class="input-100">
                <?php foreach (AppController::GetRoles() as $rol) : ?>
                    <option value="<?= $rol->rol_id ?>" <?=isset($entity) && !is_null($entity) && $entity->rol_id==$rol->rol_id ? 'selected':'' ?>>
                        <?= $rol->rol_nombre ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input type="submit" value="Guardar" class="btn-enviar" />
        </div>
    </form>
</div>