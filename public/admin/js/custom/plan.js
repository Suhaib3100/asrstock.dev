"use strict"
    var download_limit_type = $('#download_limit_type').val();
    downloadLimitType(download_limit_type)
    $('#download_limit_type').on('change', function () {
        downloadLimitType($(this).val())
    })

    function downloadLimitType(type) {
        if (type == 1) {
            $('.durationLimitDiv').addClass('d-none')
            $('.download_limit').removeAttr('required');
        } else if (type == 2) {
            $('.durationLimitDiv').removeClass('d-none')
            $('.download_limit').attr('required', true);
        }
    }

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
                    url: planStatusChange,
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

    function fetch_data(route, data) {
        $.ajax({
            url: route,
            data: data,
            success: function (data) {
                $('#appendList').html(data);
            }
        });
    }

