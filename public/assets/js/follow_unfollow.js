(function ($) {
    "use strict";

    window.followUnfollow = function (url) {
        $.ajax({
            type: 'POST',
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                toastr.success(data.message);
                setTimeout(function (){
                    location.reload();
                }, 500);
            },
            error: function (error) {
                toastr.error(error.responseJSON.message)
            }
        })
    }

})(jQuery);
