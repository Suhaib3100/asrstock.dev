(function ($) {
    "use strict";

    // Initialize DataTable with custom search input
    $('#productTable').DataTable({
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
            {"data": "sales", "name": "sales"},
            {"data": "downloads", "name": "sale_amount"},
            {"data": "earning", "name": "earning"},
            {"data": "status", "name": "status"},
            {"data": "action", "name": "action", searchable: false, responsivePriority: 2},
        ]
    });

    $(document).on('change', '#product_type_id', function () {
        var product_type_id = $(this).val();
        if (product_type_id) {
            // Replace the PRODUCT_TYPE_ID placeholder in the URL with the actual product_type_id
            var productTypeCategoryUrl = $(document).find('#fetch_product_type_category_route').val().replace('PRODUCT_TYPE_ID', product_type_id);
            commonAjax('GET', productTypeCategoryUrl, function (response) {
                // Empty the state and city dropdowns
                $('#product_category_id').empty().append('<option value="">Select Category</option>');
                $('#file_types').empty().append('<option value="">Select Product Type</option>');

                // Append states to the #product_category_id dropdown
                if (response.data && response.data.product_categories && response.data.product_categories.length) {
                    response.data.product_categories.forEach(function (category) {
                        $('#product_category_id').append('<option value="' + category.id + '">' + category.name + '</option>');
                    });
                }

                // Append states to the #file_types dropdown
                if (response.data && response.data.file_types && response.data.file_types.length) {
                    response.data.file_types.forEach(function (fileType) {
                        $('#file_types').append('<option value="' + fileType.name + '">' + fileType.title + '</option>');
                    });
                }

                $('#product_category_id').niceSelect('update');
                $('#file_types').niceSelect('update');

            }, function (response) {
                // Handle error if needed
            });
        } else {
            // If no country selected, clear the state and city dropdowns
            $('#product_category_id').empty().append('<option value="">Select Category</option>');
            $('#file_types').empty().append('<option value="">Select File Type</option>');
            $('#product_category_id').niceSelect('update');
            $('#file_types').niceSelect('update');
        }
    });

    // Function to get the next available index
    function getNextIndex() {
        return $('#variation-block li').length + 1;
    }

    // When the "add variation" button is clicked
    $('#addVariation').on("click",function () {
        // Clone the variation item HTML
        let newVariation = $('#variation-item-html').html();

        // Create a jQuery object to modify the cloned HTML
        let $newItem = $(newVariation);

        // Get the next available index based on existing variations
        let newIndex = getNextIndex();

        // Update the file input ID and the associated label "for" attribute dynamically
        let newInputId = 'mAttachment-' + newIndex;
        $newItem.find('input[type="file"]').attr('id', newInputId);
        $newItem.find('label[for="mAttachment-1"]').attr('for', newInputId);

        // Append the modified variation item to the variations list
        $('#variation-block').append($newItem);
    });

    // Delegate click event for removing variations
    $(document).on('click', '.remove-variation', function () {
        $(this).closest('li').remove();
    });

})(jQuery);
