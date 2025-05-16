(function ($) {
    "use strict";

    let walletDatatable = $('#wallet-datatable').DataTable({
        pageLength: 10,
        ordering: false,
        serverSide: true,
        processing: true,
        searching: true,
        responsive: true,
        ajax: {
            url: $('#wallet-route').val(),
            data: function (d) {
                d.search_string = $('#search-key').val();
            },
        },
        language: {
            paginate: {
                previous: "<i class='fa-solid fa-angles-left'></i>",
                next: "<i class='fa-solid fa-angles-right'></i>",
            },
            searchPlaceholder: "Search event",
            search: "<span class='searchIcon' id='search-key'><i class='fa-solid fa-magnifying-glass'></i></span>",
        },
        dom: '<>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi adminTablePagi"p>>>><"clear">',
        columns: [
            { "data": 'DT_RowIndex', "name": 'DT_RowIndex', searchable: false },
            { data: 'payment_id', name: 'payment_id' },
            { data: 'customer_email', name: 'customer_email' },
            { data: 'gateway_name', name: 'gateway_name' },
            { data: 'conversion_rate', name: 'conversion_rate' },
            { data: 'amount', name: 'amount' },
            { data: 'grand_total', name: 'grand_total' },
            { data: 'status', name: 'status' }
        ]
    });

    $('#search-key').on('keyup', function () {
        walletDatatable.draw();
    });

})(jQuery)
