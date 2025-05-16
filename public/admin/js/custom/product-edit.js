(function ($) {
    'use strict'

    $(document).find('#product_type_id').trigger('change');

    $(document).on('change', '#product_type_id', function () {
        let product_type_id = $('#product_type_id').val()
        $.ajax({
            type: "GET",
            url: productTypeCategoryRoute,
            data: { "product_type_id": product_type_id, "_token": csrfToken, },
            datatype: "json",
            success: function (response) {
                var productCategories = response.productCategories
                var optionsHtml = productCategories.map(function (opt) {
                    return '<option value="' + opt.id + '">' + opt.name + '</option>';
                }).join('');
                var html = '<option value="">--Select Option--</option>'
                    + optionsHtml

                $('.appendProductCategories').html(html);
            }
        });
    });

    $('.accessibility').on('change', function () {
        var value = this.value
        accessibility(value)
    })

    function accessibility(value) {
        var accessibility = value
        if (accessibility == 1) {
            $('.UseThisPhotoDiv').addClass('d-none')
            $('.PriceDiv').removeClass('d-none')
            $('.price').attr("required", true)
            $('.use_this_photo').removeAttr("required")
        } else if (accessibility == 2) {
            $('.UseThisPhotoDiv').removeClass('d-none')
            $('.PriceDiv').addClass('d-none')
            $('.price').removeAttr("required")
            $('.use_this_photo').attr("required", true)
        }
    }
    accessibility(value)
})(jQuery)
