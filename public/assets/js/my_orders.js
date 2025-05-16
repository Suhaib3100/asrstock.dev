(function ($) {
    "use strict";

    // Initialize DataTable with custom search input
    $('#orderHistoryTable').DataTable({
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
            {"data": "amount", "name": "amount"},
            {"data": "gateway", "name": "gateway"},
            {"data": "type", "name": "type"},
            {"data": "date", "name": "date"},
            {"data": "status", "name": "status"},
            {"data": "invoice", "name": "invoice", searchable: false, responsivePriority: 2},
        ]
    });

})(jQuery);
