const $ = require('jquery');

$(document).ready(function () {
    $(".collapse-contact").on('shown.bs.collapse', function () {
        window.location = "#collapseContact";
    });
    $(".contact-toggle").click(function () {
        $(".collapse-contact").collapse('show');
    });
});

$(document).ready(function () {
    // Javascript to enable link to tab
    let hash = document.location.hash;
    if (hash) {
        $('.nav-pills a[href=\\'+hash+']').tab('show');
        document.getElementById("pills-tabContent").scrollIntoView();
    }
});


