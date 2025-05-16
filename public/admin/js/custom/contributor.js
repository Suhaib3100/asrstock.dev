(function ($) {
    'use strict'
    let contributorDatatable = $('#contributor-datatable').DataTable({
        pageLength: 10,
        ordering: false,
        serverSide: true,
        processing: true,
        searching: true,
        responsive: true,
        ajax: {
            url: $('#contributor-route').val(),
            data: function (d) {
                d.search_string = $('#search-key').val();
            },
        },
        language: {
            paginate: {
                previous: "<i class='fa-solid fa-angles-left'></i>",
                next: "<i class='fa-solid fa-angles-right'></i>",
            },
            searchPlaceholder: "Search customer",
            search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
        },
        dom: '<>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi adminTablePagi"p>>>><"clear">',
        columns: [
            {"data": 'DT_RowIndex', "name": 'DT_RowIndex', searchable: false},
            { data: "image", name: "image" },
            { data: "name", name: "name" },
            { data: "email", name: "email" },
            { data: "contact_number", name: "contact_number" },
            { data: "status", name: "status" },
            { data: "action", name: "action", orderable: false, searchable: false },
        ],
        stateSave: true,
        destroy: true,
    });
    $('#search-key').on('keyup',function (){
        contributorDatatable.draw();
    })
})(jQuery)
