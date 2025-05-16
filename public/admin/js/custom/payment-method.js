(function ($) {
    "use strict";
    $('.paypal_currency').on('keyup', function () {
        $('.paypal_append_currency').text($(this).val())
    })
    $('.paypal_append_currency').text($('.paypal_currency').val())

    $('.bank_currency').on('keyup', function () {
        $('.bank_append_currency').text($(this).val())
    })
    $('.bank_append_currency').text($('.bank_currency').val())

    $('.stripe_currency').on('keyup', function () {
        $('.stripe_append_currency').text($(this).val())
    })
    $('.stripe_append_currency').text($('.stripe_currency').val())

    $('.razorpay_currency').on('keyup', function () {
        $('.razorpay_append_currency').text($(this).val())
    })
    $('.razorpay_append_currency').text($('.razorpay_currency').val())

    $('.mollie_currency').on('keyup', function () {
        $('.mollie_append_currency').text($(this).val())
    })
    $('.mollie_append_currency').text($('.mollie_currency').val())

    $('.sslcommerz_currency').on('keyup', function () {
        $('.sslcommerz_append_currency').text($(this).val())
    })
    $('.sslcommerz_append_currency').text($('.sslcommerz_currency').val())

    $('.im_currency').on('keyup', function () {
        $('.im_append_currency').text($(this).val())
    })
    $('.im_append_currency').text($('.im_currency').val())
    $('.paystack_currency').on('keyup', function () {
        $('.paystack_append_currency').text($(this).val())
    })
    $('.paystack_append_currency').text($('.paystack_currency').val())
})(jQuery)
