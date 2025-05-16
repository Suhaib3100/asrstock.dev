(function ($) {
    'use strict';

    let status = $('#status').val();

    let columns = [
        { "data": 'DT_RowIndex', "name": 'DT_RowIndex', searchable: false },
        { data: "thumbnail_image", name: "thumbnail_image" },
        { data: "title", name: "title" },
        { data: "productType", name: "productType" },
        { data: "productCategory", name: "productCategory" },
        { data: "accessibility", name: "accessibility" },
        { data: "status", name: "status" },
        { data: "created_by", name: "created_by" },
        { data: "action", name: "action", orderable: false, searchable: false }
    ];

    if (status == 0) {
        columns.splice(7, 0, { data: "is_featured", name: "is_featured" });
    }

    let productDataTable = $('#product-datatable').DataTable({
        pageLength: 10,
        ordering: false,
        serverSide: true,
        processing: true,
        searching: true,
        responsive: true,
        ajax: {
            url: $('#product-route').val(),
            data: function (data) {
                data.search_value = $('#search-key').val();
            }
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
        columns: columns,  // Pass the modified columns array here
    });


    $('#search-key').on('keyup', function () {
        productDataTable.draw();
    });

})(jQuery);
