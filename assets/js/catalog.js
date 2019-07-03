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
    let hash = window.location.hash ;
    let clean_hash = hash.substring(1);
    if (hash) {
        let id_product = document.getElementById(clean_hash);
        console.log(id_product);
        let tab_pill = (id_product.closest('.tab-pane')).id;
        console.log(tab_pill);
        $('#'+tab_pill).tab('show');
        document.getElementById(clean_hash).scrollIntoView();
    }
});


