(function ($) {
    "use strict";

    let timer;
    $('.searchResult-filter-wrap-content input').on('change', function () {
        clearTimeout(timer); // Clear any previous timeout to prevent multiple submissions

        // Check if the changed input belongs to asset type
        if ($(this).attr('name') === 'asset_type') {
            // Uncheck all category checkboxes
            $('input[name="category[]"]').prop('checked', false);
        }

        timer = setTimeout(function () {
            $('#filter-form').trigger('submit'); // Submit the form after the delay
        }, 300); // Delay of 500ms (adjust if needed)
    });

    $('#sortSelect').on('change', function () {
        timer = setTimeout(function () {
            $('#searchForm').trigger('submit');
        });
    });

})(jQuery);
