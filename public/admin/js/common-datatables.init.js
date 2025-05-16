$(document).ready(function () {
  $(".common-datatable").DataTable({
    language: {
        paginate: {
          previous: "<span class='iconify' data-icon='material-symbols:chevron-left-rounded'></span>",
          next: "<span class='iconify' data-icon='material-symbols:chevron-right-rounded'></span>",
        },
        searchPlaceholder: "Search",
        search: ""
    },
    dom: '<"row"<"col-sm-2 d-flex justify-content-start"f><"col-sm-8"><"col-sm-2 d-flex justify-content-end"l>>tr<"bottom"<"row"<"col-sm-6"i><"col-sm-6"p>>><"clear">',
    pageLength: 10,
    bLengthChange : true,
    responsive: true,
    ordering: false,
    autoWidth:false,
    searching: true,
    paging: true,
    info: true,

    drawCallback: function () {
      $(".dataTables_length select").addClass("form-select form-select-sm");
    },
  });

});
