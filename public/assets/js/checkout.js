(function ($) {
    "use strict";

    $(document).on('change', 'input[name="payment-item"]', function () {
        const selectedGateway = $(this);
        const gatewayId = selectedGateway.data('gateway-id');  // Get the gateway id
        const gatewaySlug = selectedGateway.data('gateway-slug');  // Get the gateway id
        const conversionRate = parseFloat(selectedGateway.data('conversion'));
        const currency = selectedGateway.data('currency');
        const total = parseFloat($('#paymentData').data('total')); // Assuming $total is passed from the controller

        if(gatewaySlug == 'bank'){
            $('#bankBlock').removeClass('d-none');
        }else{
            $('#bankBlock').addClass('d-none');
        }

        // Set the hidden gateway_id field value
        $('#gateway_id').val(gatewayId);

        // Calculate the grand total
        const grandTotal = (total * conversionRate).toFixed(2);

        // Update the conversion rate and grand total in the DOM
        $('#conversion_rate').text(`${conversionRate} ${currency}`);
        $('#grand_total').text(`${grandTotal} ${currency}`);
    });

    // Trigger change event on page load to set the initial values
    $(document).ready(function () {
        $('input[name="payment-item"]:checked').trigger('change');
    });

})(jQuery);
