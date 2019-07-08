const $ = require('jquery');
console.log('test');
$('#carousel-de-dingue').on('slide.bs.carousel', function (e) {
    /*
        CC 2.0 License Iatek LLC 2018 - Attribution required
    */
    var $e = $(e.relatedTarget);
    var idx = $e.index();
    var itemsPerSlide = 5;
    var totalItems = $('.carousel-item-partner').length;

    if (idx >= totalItems - (itemsPerSlide - 1)) {
        var it = itemsPerSlide - (totalItems - idx);
        for (var i = 0; i < it; i++) {
            // append slides to end
            if (e.direction == "left") {
                $('.carousel-item-partner').eq(i).appendTo('.carousel-inner-partner');
            } else {
                $('.carousel-item-partner').eq(0).appendTo('.carousel-inner-partner');
            }
        }
    }
});
