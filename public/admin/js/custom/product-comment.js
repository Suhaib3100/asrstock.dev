(function ($) {
    "use status"
    $(".status").on("click",function () {
        var id = $(this).closest('tr').find('#hidden_id').html();
        var status = $(this).data('status');
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
                    url: productCommentStatusChangeRoute,
                    data: { "status": status, "id": id, "_token": csrfToken, },
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
