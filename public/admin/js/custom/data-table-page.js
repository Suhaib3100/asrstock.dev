 /*---------------------------
 DataTable page
 ---------------------------*/
 $('#customers-table').DataTable({
    "paging": false,
    "info": false,
    searching: false,

    language: {
        searchPlaceholder: "Type..."
    }
});

$('#project-list-table').DataTable({
    "info": false,
    language: {
        searchPlaceholder: "Type..."
    }
});

$('#filter-table').DataTable({
    "paging": false,
    "info": false,
    searching: false,
    language: {
        searchPlaceholder: "Type..."
    }
});
