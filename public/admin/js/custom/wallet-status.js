(function ($) {
    "use strict"
    $(".status").on("change",function () {
        var id = $(this).closest('tr').find('#hidden_id').html();
        var status = $(this).closest('tr').find('.status option:selected').val();
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
                    url: walletChangeStatusRoute,
                    data: { "id": id, "status": status, "_token": csrfToken, },
                    datatype: "json",
                    success: function (data) {
                        toastr.success('', data.msg);
                        setTimeout(function () {
                            location.reload()
                        }, 2000)
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
