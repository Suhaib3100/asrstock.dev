(function ($) {
    "use strict";

    // Initialize DataTable with custom search input
    $('#myDownloadTable').DataTable({
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
            {"data": "thumbnail", "name": "thumbnail", responsivePriority: 1},
            {"data": "title", "name": "title"},
            {"data": "author", "name": "author"},
            {"data": "type", "name": "type"},
            {"data": "download", "name": "download"},
        ]
    });

})(jQuery);
