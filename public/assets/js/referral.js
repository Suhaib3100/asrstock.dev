(function ($) {
    "use strict";

    $(document).on("click", ".copyTextBtn", function () {
        let text = $("#copyText").text();
        navigator.clipboard.writeText(text).then(() => {
           toastr.success('Copied successfully!');
        }).catch(err => {
            console.error("Error copying text: ", err);
        });
    });

    // Initialize DataTable with custom search input
    $('#referralTable').DataTable({
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
            {"data": "transaction_no", "name": "transaction_no"},
            {"data": "plan_name", "name": "plan_name"},
            {"data": "actual_amount", "name": "actual_amount"},
            {"data": "earned_amount", "name": "earned_amount"},
            {"data": "commission_percentage", "name": "commission_percentage"},
            {"data": "date", "name": "date"}
        ]
    });

})(jQuery);
