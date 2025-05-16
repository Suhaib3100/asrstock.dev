/*-------------------------------------------------------
All javascript and jquery plugins activation
-------------------------------------------------------*/
(function($){
    "use strict";

    // Preloader Start
    $(window).on('load', function () {
        $('#preloader_status').fadeOut();
        $('#preloader')
            .delay(350)
            .fadeOut('slow');
        $('body')
            .delay(350);
    });
    // Preloader End

    /*---------------------------
    sidebar toggle
    ---------------------------*/
    const sidebarToggler = $('.sidebar-toggler');
    const sidebarClose = $('.sidebar__close');
    const sidebarArea = $('.sidebar__area');
    sidebarToggler.on('click', () => {
        sidebarArea.addClass('active');
    });

    sidebarClose.on('click', ()=>{
        sidebarArea.removeClass('active');
    });

    var alterClass = function() {
        var ww = document.body.clientWidth;
        if (ww > 1199) {
            sidebarArea.removeClass('active');
        }
    };

    $(window).resize(function(){
        alterClass();
    });

    alterClass();

    /*---------------------------
    sidebar menu
    ---------------------------*/
    $('#sidebar-menu').metisMenu();

})(jQuery);
