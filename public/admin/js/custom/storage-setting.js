(function ($) {
    "use strict";

    $(document).on('change', '#storage_driver', function(){
        let val = $(this).val();
        $(document).find('.storage-driver').addClass('d-none');
        $(document).find('#'+val).removeClass('d-none');
    });

    $('#storage_driver').trigger('change');
})(jQuery)

