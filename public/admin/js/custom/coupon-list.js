(function ($) {
    'use strict'
    $(".status").on("change",function () {
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
                    url: couponStatusChnageRoute,
                    data: { "status": status_value, "id": id, "_token": csrfToken, },
                    datatype: "json",
                    success: function (data) {
                        toastr.success('', 'Status has been updated');
                    },
                    error: function () {
                        alert("Error!");
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
})(jQuery)
