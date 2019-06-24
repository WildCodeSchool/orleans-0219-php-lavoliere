/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../scss/app.scss');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

// or you can include specific pieces
require('bootstrap/js/dist/tooltip');
require('bootstrap/js/dist/popover');

// Fontawesome
require('@fortawesome/fontawesome-free/css/all.min.css');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});


// jquery for change navbar color on scroll

function checkScroll() {
    var startY = $('.navbar').height(); //The point where the navbar changes in px

    if ($(window).scrollTop() > startY) {
        $('.navbar').addClass("bg-custom");
    } else {
        $('.navbar').removeClass("bg-custom");
    }
}

if ($('.navbar').length > 0) {
    $(window).on("scroll load resize", function () {
        checkScroll();
    });
}

$(document).ready(function () {
    $(".collapse").on('shown.bs.collapse', function () {
        window.location = "#collapseContact";
    });
    $(".contact-toggle").click(function () {
        $(".collapse").collapse('show');
    });
});