(function ($) {
    'use strict'
    $(function () {
        $('.cancelledStatus').on('click', function (e) {
            e.preventDefault();
            const modal = $('.cancelled_status_modal');
            modal.find('input[name=uuid]').val($(this).data('uuid'))
            modal.find('input[name=status]').val($(this).data('status'))
            modal.modal('show')
        })
    })

    $(".status").on("click",function () {
        var uuid = $(this).data('uuid');
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
                    url: withdrawCompletedStatusRoute,
                    data: { "uuid": uuid, "_token": csrfToken, },
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
