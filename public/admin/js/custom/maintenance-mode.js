(function ($) {
    "use strict"
    $('.maintenance_secret_key').on('keyup', function () {
        var secret_value = $('.maintenance_secret_key').val()
        var url = getUrl + "/"
        $('.maintenance_mode_url').val(url + secret_value);
    })

    var url = getUrl + "/" + maintenanceSecretKey
    $('.maintenance_mode_url').val(url);
    var maintenance_mode = maintenanceModeConst
    maintenanceMode(maintenance_mode)

    $('.maintenance_mode').on("change",function () {
        var maintenance_mode = this.value
        maintenanceMode(maintenance_mode)
    });

    function maintenanceMode(maintenance_mode) {
        if (maintenance_mode == 1) {
            $(".maintenance_secret_key").attr("required", "true");
        } else if (maintenance_mode == 2) {
            $(".maintenance_secret_key").removeAttr('required');
            $('.maintenance_secret_key').val('');
            $('.maintenance_mode_url').val(getUrl);
        }
    }
})(jQuery)

