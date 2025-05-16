(function ($) {
    $('#mail_type').on('change', function () {
        var mail_type = this.value;
        if (mail_type == 1) {
            $('#mailDiv').addClass('d-none');
            $('#mail').removeAttr('required');
        } else if (mail_type == 2) {
            $('#mailDiv').removeClass('d-none');
            $('#mail').attr('required', true);
        }
    });
})(jQuery)
