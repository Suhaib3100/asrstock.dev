(function ($) {
    'use strict'

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
                $('.appendProductCategories').html(html).promise().then(() => {
                    if(typeof product_category_id != 'undefined'){
                        $('.appendProductCategories').val(product_category_id).trigger('change');
                    }
                });
            }
        });
    });

    $(document).on('change', '#product_type_id', function (e) {
        setOption($(this)).then(() => {
            $(this).closest('form').find('#product_type_extension');
        });
    });

    $(document).on('click', '#add-variation', function (e) {
        let htmlPaid = `<div class="row child">
            <hr>
            <div class="input__group mb-25 col-md-4">
                <input type="text" name="variations[]" value="" placeholder="Variation" class="variations form-control">
            </div>
            <div class="input__group mb-25 col-md-3">
                <div class="input-group">
                    <input type="number" step="any" min="0.0" name="prices[]" value="" placeholder="Price" class="prices form-control price">
                    <span class="input-group-text"></span>
                </div>
            </div>
            <div class="input__group mb-25 col-md-4">
                <input type="file" name="main_files[]" value="" class="form-control main_files" required>
            </div>
            <div class="col-md-1">
                <button type="button" class="text-danger btn-sm removeVariation"><span class="fa fa-2x fa-trash-alt"></span></button>
            </div>
        </div>`;

        $(document).find('#variation-block').append(htmlPaid);

    });

    $(document).on('click', '.removeVariation', function (e) {
        $(this).closest('.child').remove();
    });

    $(document).on('change', '#accessibility', function (e) {
        if($(this).val() == 1){
            $('#variation-block').removeClass('d-none');
            $('#free-block').addClass('d-none');
            $('#attribution-required-block').addClass('d-none');
            $('#use-this-photo-div').addClass('d-none');
        }
        else{
            $('#variation-block').addClass('d-none');
            $('#free-block').removeClass('d-none');
            $('#attribution-required-block').removeClass('d-none');
            $('#use-this-photo-div').removeClass('d-none');
        }
    });

    if($(document).find('#product_type_id').val() != ''){
        $(document).find('#product_type_id').trigger('change');
    }

})(jQuery)

function setOption(elm){
    return new Promise(function(resolve) {
        let value = $('#product_type_id').find(":selected").data('product_type_category');
        let product_type_id = $('#product_type_id').find(":selected").data('product_type_id');
        let extensions = productTypeExtensions.filter(x => (x.product_type_category == value && x.product_type_id == product_type_id));
        let html = '';
        $.each(extensions, function(ind, extension){
            html += `<option value="${extension.name}">${extension.title}</option>`;
        });


        $(elm).closest('form').find('#product_type_extension').html(html);
        if(typeof product_type_extension == 'undefined'){
            $('#product_type_extension').val($('#product_type_extension option:eq(0)').val()).trigger('change');
        }
        else{
            $('#product_type_extension').val(product_type_extension).trigger('change');
        }

        resolve(true);
    });
}
$(".sf-select-label").select2({
    dropdownCssClass: "sf-select-dropdown",
    selectionCssClass: "sf-select-section",
});

