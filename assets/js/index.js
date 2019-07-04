let iconFeature = new ol.Feature({
    geometry: new ol.geom.Point(ol.proj.fromLonLat([1.839839999999981, 47.9898])),
    name: 'Ferme la volière'
});

let iconStyle = new ol.style.Style({
    image: new ol.style.Icon(/** @type {module:ol/style/Icon~Options} */ ({
        anchor: [0.5, 60],
        anchorXUnits: 'fraction',
        anchorYUnits: 'pixels',
        src: 'build/image_map_icon.png',
    }))
});

iconFeature.setStyle(iconStyle);

let vectorSource = new ol.source.Vector({
    features: [iconFeature]
});

let vectorLayer = new ol.layer.Vector({
    source: vectorSource
});

let rasterLayer = new ol.layer.Tile({
    source: new ol.source.TileJSON({
        url: 'https://api.tiles.mapbox.com/v3/mapbox.va-quake-aug.json?secure',
        crossOrigin: 'anonymous',
        // this layer has transparency, so do not fade tiles:
        transition: 0
    })
});

let view = new ol.View({
    center: ol.proj.fromLonLat([1.839839999999981, 47.9898]),
    zoom: 16.5
});

let map = new ol.Map({
    target: 'map',
    controls: ol.control.defaults().extend([
        new ol.control.FullScreen()
    ]),
    layers: [
        new ol.layer.Tile({
            source: new ol.source.OSM()
        }), vectorLayer
    ],
    view: view
});