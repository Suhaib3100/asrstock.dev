(function ($) {
    "use strict";
    var use_type = $('#use_type').val();
    useType(use_type)

    $('#use_type').on('change', function (){
        var use_type = $(this).val()
        useType(use_type)
    })

    function useType(use_type)
    {
        if (use_type == 2) {
            $('#maximumUseLimitDiv').removeClass('d-none');
            $('#maximum_use_limit').attr('required', true);
        } else {
            $('#maximumUseLimitDiv').addClass('d-none');
            $('#maximum_use_limit').removeAttr('required');
        }
    }

    var discount_type = $('#discount_type').val()
    discountType(discount_type)

    $('#discount_type').on('change', function (){
        var discount_type = $(this).val()
        discountType(discount_type)
    })

    function discountType(discount_type)
    {
        if (discount_type == 1) {
            $('.discountValueText').text('Discount Percentage (%) (ex: 15, 25, 30, 40 ...)');
        } else if (discount_type == 2) {
            var getCurrentSymbol = $('.getCurrentSymbol').val();
            $('.discountValueText').text('Discount Amount ( ' + getCurrentSymbol + ' )');
        } else {
            $('.discountValueText').text('Discount Value');
        }
    }

})(jQuery)
