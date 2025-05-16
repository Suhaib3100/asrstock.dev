(function ($) {
    "use strict";

    // Initialize DataTable with custom search input
    $('#withdrawalHistoryTable').DataTable({
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
            {"data": 'DT_RowIndex', "name": 'DT_RowIndex'},
            {"data": "amount", "name": "amount"},
            {"data": "type", "name": "type"},
            {"data": "date", "name": "date"},
            {"data": "status", "name": "status"},
        ]
    });

})(jQuery);
