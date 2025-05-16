(function ($) {
    'use strict'

   let orderDatatable = $('#order-datatable').DataTable({
        pageLength: 10,
        ordering: false,
        serverSide: true,
        processing: true,
        searching: true,
        responsive: true,
        ajax: {
            url: $('#order-route').val(),
            data:function (data) {
               data.search_string = $('#search-key').val();
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
            { "data": 'DT_RowIndex', "name": 'DT_RowIndex', searchable: false },
            { "data": 'order_number', "name": 'order_number' },
            { "data": 'customer_email', "name": 'order.customer_email' ,searchable: false},
            { "data": 'type', "name": 'type' },
            { "data": 'item', "name": 'item',searchable: false },
            { "data": 'subtotal', "name": 'subtotal', className: 'text-end' },
            { "data": 'discount', "name": 'discount', className: 'text-end' },
            { "data": 'tax_amount', "name": 'tax_amount', className: 'text-end' },
            { "data": 'referral', "name": 'referral', className: 'text-end',searchable: false },
            { "data": 'total', "name": 'total', className: 'text-end' },
            { "data": 'gateway', "name": 'gateway',searchable: false },
            { "data": 'payment_status', "name": 'payment_status',searchable: false },
        ],
    });
    $('#search-key').on('keyup',function (){
        orderDatatable.draw();
    })

})(jQuery)
