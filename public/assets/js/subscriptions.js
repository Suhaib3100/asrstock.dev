(function ($) {
    "use strict";

    // Initialize DataTable with custom search input
    $('#billingHistoryTable').DataTable({
        pageLength: 10,
        ordering: false,
        serverSide: true,
        processing: true,
        responsive: true,
        searchable: true,
        ajax: {
            url: $('#datatable-route').val(),
        },
        language: {
            paginate: {
                previous: "<i class='fa-solid fa-angle-left'></i>",
                next: "<i class='fa-solid fa-angle-right'></i>",
            },
        },
        dom: '<>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tablePagi"p>>>><"clear">',
        columns: [
            {"data": "order_no", "name": "order_no", responsivePriority: 1},
            {"data": "plan", "name": "plan"},
            {"data": "amount", "name": "amount"},
            {"data": "start_date", "name": "start_date"},
            {"data": "end_date", "name": "end_date"},
            {"data": "gateway", "name": "gateway"},
            {"data": "status", "name": "status"},
        ]
    });

    window.cancelSubscription = function (url) {
        Swal.fire({
            title: 'Sure! You want to cancel?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Cancel It!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        toastr.success(data.message);
                        setTimeout(function () {
                            location.reload();
                        }, 500);
                    },
                    error: function (error) {
                        toastr.error(error.responseJSON.message)
                    }
                })
            }
        })
    }

})(jQuery);
