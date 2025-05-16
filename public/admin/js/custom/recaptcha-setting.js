(function ($) {
    "use strict"
    googleStatus(google_recaptcha_status)
    $('#google_recaptcha_status').on('change', function () {
        var status = this.value
        googleStatus(status)
    })

    function googleStatus(status) {
        if (status == 1) {
            $('#google_recaptcha_site_key').attr('required', true)
            $('#google_recaptcha_secret_key').attr('required', true)
        } else {
            $('#google_recaptcha_site_key').removeAttr('required')
            $('#google_recaptcha_secret_key').removeAttr('required')
        }
    }
})(jQuery);
