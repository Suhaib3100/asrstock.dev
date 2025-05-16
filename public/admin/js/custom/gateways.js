$(function () {
    "use strict";
    $('.gateway_currency').on('change', function () {
        $('.gateway_append_currency').text($(this).val())
    });
    $('.gateway_append_currency').text($('.gateway_currency').val());
})
