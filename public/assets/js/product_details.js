(function ($) {
    "use strict";

    $('input[name="buySingleLicense"]').on('change', function () {
        let price = $(this).attr("data-price");
        let variation = $(this).attr("variation-id");
        $("#form-variation-id").val(`${variation}`);
        $("#buySingleLicense").text(`${showPrice(price)}`);
    });

    $(document).on('keypress', '#productComment', function (event) {
        if (event.which === 13) { // 13 is the Enter key
            event.preventDefault(); // Prevent default form submission (if needed)
            $(this).closest('form').trigger('submit'); // Submit the form
        }
    });

    let $items = $(".donation-payItem .itemBlock");
    let $donationButton = $("#donate-button-price");

    let donationPrice = $donationButton.attr("data-donation-price");

    $items.first().addClass("active");

    $items.on("click", function () {
        let index = $(this).index();

        if (index === 0) {
            $items.removeClass("active");
            $(this).addClass("active");
        } else {
            $items
                .removeClass("active")
                .slice(0, index + 1)
                .addClass("active");
        }

        let activeCount = $(".donation-payItem .itemBlock.active").length;
        let newAmount = activeCount * parseInt(donationPrice);
        $(document).find('#donation-form-price').val(newAmount);
        $donationButton.text(`${showPrice(newAmount)}`);
    });

})(jQuery);
