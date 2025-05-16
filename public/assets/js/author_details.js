(function ($) {
    "use strict";

    function loadTabContent(button) {
        var url = button.data('url'); // Get the URL from the data attribute
        var targetPane = $(button.data('bs-target')); // Get the target tab pane

        commonAjax('GET', url, function (response) {
            targetPane.find('.item-parent').html(response.data.html);
        }, function () {
            targetPane.find('.item-parent').html('');
        });
    }

    // Initial Load - Load the content for the first active tab
    var firstActiveTab = $('button[data-bs-toggle="tab"].active');
    if (firstActiveTab.length) {
        loadTabContent(firstActiveTab);
    }

    // On Tab Change Event
    $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function () {
        loadTabContent($(this));
    });

})(jQuery);
