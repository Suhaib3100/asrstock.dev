(function ($) {
    'use strict'

    $('.product_type_extension').select2({
        dropdownCssClass: "sf-select-dropdown",
        selectionCssClass: "sf-select-section"
    });

    var old_extensions = [];

    $(document).on('change', '.product_type_category', function (e) {
        setOption($(this)).then(() => {
            $(this).closest('form').find('.product_type_extension').val(old_extensions).trigger('change');
        });
    });

    $('.edit').on('click', function (e) {
        const selector = $('#editModal');
        old_extensions = $(this).data('item').product_type_extensions.map((item) => item.id);
        selector.find('input[name=uuid]').val($(this).data('item').uuid);
        selector.find('input[name=name]').val($(this).data('item').name);
        selector.find('select[name=product_type_category]').val($(this).data('item').product_type_category);
        selector.find('select[name=product_type_category]').trigger('change');
        selector.find('select[name=status]').val($(this).data('item').status)
        selector.find('#edit-icon').attr("src",$(this).data('item').icon)
        selector.modal('show')
        selector.find('.product_type_extension').select2({
            dropdownCssClass: "sf-select-dropdown",
            selectionCssClass: "sf-select-section"
        });

    });

    $(".status").on("change", function () {
        var id = $(this).closest('tr').find('#hidden_id').html();
        var status_value = $(this).closest('tr').find('.status option:selected').val();
        Swal.fire({
            title: "Are you sure to change status?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Change it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: productTypeStatusChangeRoute,
                    data: { "status": status_value, "id": id, "_token": csrfToken, },
                    datatype: "json",
                    success: function (data) {
                        toastr.success('', 'Status has been updated');
                        setTimeout(() => {
                            location.reload()
                        }, 1000);
                    },
                    error: function (error) {
                        toastr.error(error.responseJSON.message);
                        setTimeout(() => {
                            location.reload()
                        }, 1500);
                    },
                });
            } else if (result.dismiss === "cancel") {
            }
        });
    });
})(jQuery)

function setOption(elm){
    return new Promise(function(resolve) {
        let value = $(elm).val();
        let extensions = productTypeExtensions.filter(x => x.product_type_category == value);
        let html = '';
        $.each(extensions, function(ind, extension){
            html += `<option value="${extension.id}">${extension.name}</option>`;
        });

        $(elm).closest('form').find('.product_type_extension').html(html);
        $(elm).closest('form').find('.product_type_extension').val("");
        $(elm).closest('form').find('.product_type_extension').trigger("change");

        resolve(true);
    });
}
