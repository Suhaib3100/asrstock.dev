$(function () {
    'use strict'
    $(document).on('click', '.edit', function (e) {
        e.preventDefault();
        const modal = $('.edit_modal');
        modal.find('input[name=name]').val($(this).data('item').name)
        modal.find('select[name=product_type_id]').val($(this).data('item').product_type_id)
        modal.find('select[name=status]').val($(this).data('item').status)
        let route = $(this).data('updateurl');
        $('#updateEditModal').attr("action", route)
        modal.modal('show')
    })
})

$(document).on('change', ".status", function () {
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
                url: productCategoryStatusChangeRoute,
                data: {"status": status_value, "id": id, "_token": csrfToken,},
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

function fetch_data(route, data) {
    $.ajax({
        url: route,
        data: data,
        success: function (data) {
            $('#appendList').html(data);
        }
    });
}
