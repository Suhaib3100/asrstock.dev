(function ($) {
    'use strict'
     let customerDatatable = $('#customer-datatable').DataTable({
            pageLength: 10,
            ordering: false,
            serverSide: true,
            processing: true,
            searching: true,
            responsive: true,
            ajax: {
                url: $('#customer-route').val(),
                data: function (data){
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
                { data: "id", name: "id" },
                { data: "image", name: "image",searchable: false },
                { data: "name", name: "name" ,searchable: false},
                { data: "email", name: "email" },
                { data: "contact_number", name: "contact_number" },
                { data: "role", name: "role" },
                { data: "wallet_balance", name: "wallet_balance" },
                { data: "earning_balance", name: "earning_balance" },
                { data: "status", name: "status" ,searchable: false},
                { data: "action", name: "action", orderable: false, searchable: false },
            ],
            stateSave: true,
            destroy: true,
        });
        $('#search-key').on('keyup',function (){
            customerDatatable.draw();
        })
})(jQuery)
