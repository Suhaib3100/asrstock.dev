(function ($) {
    "use strict"
    googleStatus(google_status)
    facebookStatus(facebook_status)

    $('#google_login_status').on('change', function () {
        var status = this.value
        googleStatus(status)
    })

    function googleStatus(status) {
        if (status == 1) {
            $('#google_client_id').attr('required', true)
            $('#google_client_secret').attr('required', true)
        } else {
            $('#google_client_id').removeAttr('required')
            $('#google_client_secret').removeAttr('required')
        }
    }

    $('#facebook_login_status').on('change', function () {
        var status = this.value
        facebookStatus(status)
    })

    function facebookStatus(status) {
        if (status == 1) {
            $('#facebook_client_id').attr('required', true)
            $('#facebook_client_secret').attr('required', true)
        } else {
            $('#facebook_client_id').removeAttr('required')
            $('#facebook_client_secret').removeAttr('required')
        }
    }
})(jQuery)
