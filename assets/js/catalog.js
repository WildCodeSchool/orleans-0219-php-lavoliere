const $ = require('jquery');

$(document).ready(function () {
    let hash = window.location.hash ;
    let clean_hash = hash.substring(1);
    if (hash) {
        let id_product = document.getElementById(clean_hash);
        let tab_pill = (id_product.closest('.tab-pane')).id;
        let hash_tab = '#'+tab_pill;
        let activeTab = $('[href="' + hash_tab + '"]');
        activeTab && activeTab.tab('show');
        document.getElementById(clean_hash).scrollIntoView();
    }
});


