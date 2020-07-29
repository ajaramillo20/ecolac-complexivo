<div class="contenedor div-form">
    <?php
    if (isset($_SESSION['sucursalRegistroError'])) {
        echo '<p class="error">' . $_SESSION['sucursalRegistroError'] . '</p>';
        App::UnsetSessionVar('sucursalRegistroError');
    }
    if (isset($_SESSION['sucursalRegistroMensaje'])) {
        echo '<p class="error">' . $_SESSION['sucursalRegistroMensaje'] . '</p>';
        App::UnsetSessionVar('sucursalRegistroMensaje');
    }
    ?>
    <?php if (isset($entity) && !is_null($entity)) : ?>
        <!-- <?php $url_action = base_url . 'sucursal/actualizar&id=' . $entity->usr_id ?>                -->
        <?php $url_action = base_url . 'sucursal/actualizar' ?>
        <h1>Editar usuario</h1>
    <?php else : ?>
        <?php $url_action = base_url . 'sucursal/agregar' ?>
        <h1>Registro de sucursal</h1>
    <?php endif; ?>

    <form action="<?= $url_action ?>" method="POST" class="form-registro">
        <h2>Ingrese los datos</h2>
        <div class="contenedor-inputs">
            <label for="nombre">Nombre sucursal</label>
            <input type="text" name="suc_id" placeholder="id" hidden="true" class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->suc_id : '';  ?>" />
            <input type="text" name="dir_id" placeholder="id" hidden="true" class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->dir_id : '';  ?>" />
            <input type="text" name="nombre" placeholder="Nombre" required="true" class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->suc_nombre : '';  ?>" />
            <label for="direccion">Dirección sucursal</label>
            <input type="text" name="direccion" placeholder="Dirección" required="true" class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->dir_direccion : ''; ?>" />
            <label for="ciudad">Ciudad</label>
            <select name="ciudad" class="input-100">
                <?php $ciudades = AppController::GetCidades(); ?>
                <?php while ($ciu = $ciudades->fetch_object()) : ?>
                    <option value="<?= $ciu->ciu_id ?>" <?= isset($entity) && !is_null($entity) && $ciu->ciu_id == $entity->ciu_id ? 'selected' : ''; ?>>
                        <?= $ciu->ciu_nombre ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <label for="latitud">Latitud</label>
            <input type="text" name="latitud" placeholder="Latitud" required="true" readonly="true" class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->dir_latitud : ''; ?>" />
            <label for="longitud">Longitud</label>
            <input type="text" name="longitud" placeholder="Longitud" required="true" readonly="true" class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->dir_longitud : ''; ?>" />
            <div id="myMap"></div>
            <input type="submit" value="Guardar" class="btn-enviar" />
        </div>
    </form>
</div>


<script>
    //Parametros iniciales
    var dir_lat = document.getElementsByName('latitud')[0].value;
    var dir_long = document.getElementsByName('longitud')[0].value;
    var tilesProvider = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
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