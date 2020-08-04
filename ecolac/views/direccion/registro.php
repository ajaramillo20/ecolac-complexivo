<div class="contenedor div-form">
    <?php
    if (isset($_SESSION['direccionRegistroError'])) {
        echo '<p class="error">' . $_SESSION['direccionRegistroError'] . '</p>';
        App::UnsetSessionVar('direccionRegistroError');
    }
    if (isset($entity) && !is_null($entity)) {
        $titulo = 'Editar dirección';
        $url_action = base_url . 'direccion/actualizar';
    } else if (isset($usrid)) {
        $titulo = "Nueva dirección";
        $url_action = base_url . 'direccion/agregar';
    }
    ?>
    <h1><?= $titulo ?></h1>
    <form action="<?= $url_action ?>" method="POST" class="form-registro">
        <h2>Complete los campos</h2>
        <div class="contenedor-inputs">
            <input type="text" name="usrid" placeholder="" hidden="true" class="input-100" value="<?= isset($usrid)  ? $usrid : '' ?>" />
            <input type="text" name="dirid" placeholder="" hidden="true" class="input-100" value="<?= isset($entity) && !is_null($entity) ? $entity->dir_id : '' ?>" />

            <label for="direccion">Dirección</label>
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
            <input type="text" name="latitud" placeholder="Latitud" required="true" readonly="true" class="input-48" value="<?= isset($entity) && !is_null($entity) ? $entity->dir_latitud : ''; ?>" />

            <input type="text" name="longitud" placeholder="Longitud" required="true" readonly="true" class="input-48" value="<?= isset($entity) && !is_null($entity) ? $entity->dir_longitud : ''; ?>" />
            <div id="myMap"></div>
            <label for="predeterminado">Direccion predeterminada</label>
            <select name="predeterminado" class="input-100" required="true">
                <option value="1" <?= isset($entity) && !is_null($entity) && $entity->dir_predeterminado == '1' ? 'selected' : '' ?>>SI</option>
                <option value="0" <?= isset($entity) && !is_null($entity) && $entity->dir_predeterminado == '0' ? 'selected' : '' ?>>NO</option>
            </select>
            <input type="submit" value="Guardar" class="btn-enviar" />
        </div>
    </form>
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