function LoadMap(lat = "", long = "") {
    //Parametros iniciales
    var dir_lat = lat;
    var dir_long = long;
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
}

function LoadMapRoute(lat = "", long = "") {
    //Parametros iniciales
    var dir_lat = lat;
    var dir_long = long;
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

    L.Routing.control

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
}