$(function () {
    'use strict'
    $('.daterange-btn').daterangepicker({
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment()
    }, function (start, end) {
        $('.daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
            'MMMM D, YYYY'))
    });
    $('.ranges ul li').each(function (index) {
        $(this).on('click', function () {
            let key = $(this).data('range-key')
            $("#overlay").fadeIn(300);
            if (key == 'Custom Range') {
                return;
            }
            $('.pageTitle').html(key)

            $.ajax({
                url: earningDownloadProductsRoute,
                data: {
                    key: key
                },
                method: "GET",
                success: function (response) {
                    $('#appendList').html(response);
                    $('.test-popup-link').magnificPopup({
                        type: 'image'
                    });
                },
                complete: function () {
                    $("#overlay").fadeOut(300);
                }
            })
        })
    })
    $(document).on('click', '.applyBtn', function () {
        let start_date = $('input[name=daterangepicker_start]').val()
        let end_date = $('input[name=daterangepicker_end]').val()
        let key = 'Custom Range'
        $('.pageTitle').html(moment(start_date).format("DD MMM, Y") + ' - ' + moment(end_date).format("DD MMM, Y"))
        $("#overlay").fadeIn(300);
        $.ajax({
            url: currentUrl,
            data: {
                key: key,
                start_date: start_date,
                end_date: end_date
            },
            method: "GET",
            success: function (response) {
                $('#appendList').html(response);
                $('.test-popup-link').magnificPopup({
                    type: 'image'
                });
            },
            complete: function () {
                $("#overlay").fadeOut(300);
            }
        })
    })
})

function fetch_data(route, data) {
    $.ajax({
        url: route,
        data: data,
        success: function (data) {
            $('#appendList').html(data);
            $('.test-popup-link').magnificPopup({
                type: 'image'
            });
        }
    });
}

$(document).ready(function () {
    $('.test-popup-link').magnificPopup({
        type: 'image'
    });
});
