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
    interactions: ol.interaction.defaults().extend([
        new ol.interaction.DragRotateAndZoom()
    ]),
    view: new ol.View({
        center: ol.proj.fromLonLat([1.839839999999981, 47.9898]),
        zoom: 16.5
    })
});

$(document).ready(function () {
    $(".collapse").on('shown.bs.collapse', function () {
        window.location = "#collapseContact";
    });
    $(".contact-toggle").click(function () {
        $(".collapse").collapse('show');
    });
});

