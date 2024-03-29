<div class="contenedor div-form">
    <?php
    if (isset($_SESSION['registroError'])) {
        App::ShowMessage($_SESSION['registroError'], 'Error');
        App::UnsetSessionVar('registroError');
    } else if (isset($_SESSION['userconnect']) && !isset($entity)) {
        App::Redirect(base_url);
    }

    if (isset($entity) && !is_null($entity)) {
        $url_action = base_url . 'usuario/actualizar';
        $titulo = 'Editar usuario';
        $roles = AppController::GetRoles();
        $sucursales = AppController::GetSucursales();
    } else {
        $url_action = base_url . 'usuario/agregar';
        $titulo = 'Registro de usuario';
        $ciudades = AppController::GetCidades();
    }
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

            <?php if (isset($entity) && !is_null($entity)) : ?>

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
            <?php endif; ?>

            <?php if (!isset($entity)) : ?>
                <label for="direccion">Dirección</label>
                <input type="text" name="direccion" placeholder="Dirección" required="true" class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->dir_direccion : ''; ?>" />

                <label for="ciudad">Ciudad</label>
                <select name="ciudad" class="input-100">

                    <?php while ($ciu = $ciudades->fetch_object()) : ?>

                        <option value="<?= $ciu->ciu_id ?>" <?= isset($entity) && !is_null($entity) && $ciu->ciu_id == $entity->ciu_id ? 'selected' : ''; ?>>
                            <?= $ciu->ciu_nombre ?>
                        </option>

                    <?php endwhile; ?>
                </select>

                <input type="text" name="latitud" placeholder="Latitud" required="true" readonly="true" class="input-48" value="<?= isset($entity) && !is_null($entity) ? $entity->dir_latitud : ''; ?>" />
                <input type="text" name="longitud" placeholder="Longitud" required="true" readonly="true" class="input-48" value="<?= isset($entity) && !is_null($entity) ? $entity->dir_longitud : ''; ?>" />
                <label for="myMap">Seleccione su ubicación</label>
                <div id="myMap"></div>
            <?php endif; ?>
            <input type="submit" value="Guardar" class="btn-enviar" />
        </div>
    </form>

    <div class="miTabla">
        <div class="contenedor">
            <a class="btnaccion icon-angle-circled-left" href="#" onclick="GoBack();">Regresar </a>
        </div>
    </div>


    <script>
        //Parametros iniciales
        var dir_lat = document.getElementsByName('latitud')[0].value;
        var dir_long = document.getElementsByName('longitud')[0].value;
        var tilesProvider = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
        //var tilesProvider =  'https://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png';
        var lat = dir_lat === "" ? -1.736 : dir_lat;
        var long = dir_long === "" ? -78.322 : dir_long;
        var zoom = (lat === -1.736 && long === -78.322) ? 6 : 16;
        var currentLayer;

        console.log(lat, long);

        var myMap = L.map('myMap').setView([lat, long], zoom);

        if (dir_lat !== "" && dir_long !== "") {
            currentLayer = L.marker([lat, long]).addTo(myMap);
        }

        L.tileLayer(tilesProvider, {
            maxZoom: 18,
        }).addTo(myMap);

        myMap.doubleClickZoom.disable();

        myMap.on('dblclick', e => {
            if (currentLayer != undefined) {
                currentLayer.remove();
            }
            var coordenadas = myMap.mouseEventToLatLng(e.originalEvent)
            console.log(coordenadas)
            currentLayer = L.marker([coordenadas.lat, coordenadas.lng]).addTo(myMap)
            document.getElementsByName('latitud')[0].value = coordenadas.lat;
            document.getElementsByName('longitud')[0].value = coordenadas.lng;
        })
    </script>