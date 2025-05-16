(function ($) {
    "use strict"

    $('.test-popup-link').magnificPopup({
        type: 'image'
    });

    $(document).on("click", ".status-change", function () {
        var id = $(this).closest('tr').find('#hidden_id').html();
        var payment_status = $(this).attr('data-status');
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
                    url: paymentStatusChangeRoute,
                    data: {"id": id, "payment_status": payment_status, "_token": csrfToken,},
                    datatype: "json",
                    success: function (data) {
                        toastr.success('', 'Status has been updated');
                        location.reload()
                    },
                    error: function () {
                        alert("Error!");
                    },
                });
            } else if (result.dismiss === "cancel") {
            }
        });
    });


    $("#bank-pending-datatable").DataTable({
        language: {
            paginate: {
                previous: "<span class='iconify' data-icon='material-symbols:chevron-left-rounded'></span>",
                next: "<span class='iconify' data-icon='material-symbols:chevron-right-rounded'></span>",
            },
            searchPlaceholder: "Search",
            search: ""
        },
        dom: '<"row"<"col-sm-2 d-flex justify-content-start"f><"col-sm-8"><"col-sm-2 d-flex justify-content-end"l>>tr<"bottom"<"row"<"col-sm-6"i><"col-sm-6"p>>><"clear">',
        pageLength: 10,
        bLengthChange: true,
        responsive: true,
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: 11 },
            { responsivePriority: 3, targets: 12 }
        ],
        ordering: false,
        autoWidth: false,
        searching: true,
        paging: true,
        info: true,

        drawCallback: function () {
            $(".dataTables_length select").addClass("form-select form-select-sm");
        },
    });

})(jQuery)
