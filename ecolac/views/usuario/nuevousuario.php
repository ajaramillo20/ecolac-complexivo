<div class="contenedor div-form">
    <?php
    if (isset($_SESSION['registroError'])) {
        echo '<p class="error">' . $_SESSION['registroError'] . '</p>';
        App::UnsetSessionVar('registroError');
    }

    $roles = AppController::GetRoles();
    $sucursales = AppController::GetSucursales();
    $url_action = base_url . 'usuario/agregarusuario';
    $titulo = 'Registro de usuario';
    $ciudades = AppController::GetCidades();

    ?>

    <h1><?= $titulo ?></h1>
    <form action="<?= $url_action ?>" method="POST" class="form-registro">
        <h2>Ingrese sus datos</h2>
        <div class="contenedor-inputs">
            <input type="text" name="usr_id" placeholder="usr_id" hidden="true" class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->usr_id : '';  ?>" />
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" placeholder="Nombre" required="true" class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->usr_nombre : '';  ?>" />
            <label for="cedula">Cédula</label>
            <input type="text" name="cedula" placeholder="Cédula" required="true" class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->usr_cedula : ''; ?>" />
            <label for="correo">Correo</label>
            <input type="email" name="correo" placeholder="Correo" required="true" class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->usr_correo : ''; ?>" />
            <label for="telefono">Teléfono</label>
            <input type="text" name="telefono" placeholder="Telefono" required="true" class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->usr_telefono : ''; ?>" />
            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" placeholder="Usuario" required="true" class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->usr_usuario : ''; ?>" />
            <label for="contrasena" <?= isset($entity) && !is_null($entity) ? 'hidden="true"' : ''; ?>>Contraseña</label>
            <input type="password" name="contrasena" placeholder="Contraseña" <?= isset($entity) && !is_null($entity) ? 'hidden="true"' : 'required="true"'; ?> class="input-100" />

            <label for="rol">Rol</label>
            <select name="rol" class="input-100">
                <?php foreach ($roles as $rol) : ?>

                    <option value="<?= $rol->rol_id ?>" <?= isset($entity) && !is_null($entity) && $rol->rol_id == $entity->rol_id ? 'selected' : ''; ?>>
                        <?= $rol->rol_nombre ?>
                    </option>

                <?php endforeach; ?>
            </select>

            <label for="sucursal">Sucursal</label>
            <select name="sucursal" class="input-100">
                <option>

                </option>

                <?php while ($suc = $sucursales->fetch_object()) : ?>

                    <option value="<?= $suc->suc_id ?>" <?= isset($entity) && !is_null($entity) && $suc->suc_id == $entity->suc_id ? 'selected' : ''; ?>>
                        <?= $suc->suc_nombre ?>
                    </option>

                <?php endwhile; ?>

            </select>

            <input type="submit" value="Guardar" class="btn-enviar" />
        </div>
    </form>

    <div class="miTabla">
        <div class="contenedor">
            <a class="btnaccion icon-angle-circled-left" href="#" onclick="GoBack();">Regresar </a>
        </div>
    </div>