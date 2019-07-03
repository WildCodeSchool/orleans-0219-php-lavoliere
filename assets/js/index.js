const $ = require('jquery');



var iconFeature = new ol.Feature({
    geometry: new ol.geom.Point(ol.proj.fromLonLat([1.839839999999981, 47.9898])),
    name: 'Ferme la volière'
});

var iconStyle = new ol.style.Style({
    image: new ol.style.Icon(/** @type {module:ol/style/Icon~Options} */ ({
        anchor: [0.5, 60],
        anchorXUnits: 'fraction',
        anchorYUnits: 'pixels',
        src: 'build/image_map_icon.png',
    }))
});

iconFeature.setStyle(iconStyle);

var vectorSource = new ol.source.Vector({
    features: [iconFeature]
});

var vectorLayer = new ol.layer.Vector({
    source: vectorSource
});

var rasterLayer = new ol.layer.Tile({
    source: new ol.source.TileJSON({
        url: 'https://api.tiles.mapbox.com/v3/mapbox.geography-class.json?secure',
        crossOrigin: ''
    })
});

var map = new ol.Map({
    target: 'map',
    layers: [
        new ol.layer.Tile({
            source: new ol.source.OSM()
        }), vectorLayer
    ],
    controls: ol.control.defaults().extend([
        new ol.control.FullScreen()
    ]),
    interactions: ol.interaction.defaults({mouseWheelZoom:false}).extend([
        new ol.interaction.DragRotateAndZoom()
    ]),
    view: new ol.View({
        center: ol.proj.fromLonLat([1.839839999999981, 47.9898]),
        zoom: 16.5
    })
});

