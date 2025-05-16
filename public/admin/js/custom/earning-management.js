$(function () {
    $("#datepickerMonthYear").datepicker({
        format: "MM-yyyy",
        viewMode: "months-years",
        minViewMode: "months",
    });

    $(".datepickerMonthYear").on('change', function () {
        var month_year = $('#datepickerMonthYear').val();
        var admin_commission_percentage = $('.admin_commission_percentage').val();
        var contributor_commission_percentage = $('.contributor_commission_percentage').val();
        if (month_year == null || !month_year) {
            return
        }
        $('.monthly_year_level').html('(' + month_year + ')');
        $.ajax({
            type: "GET",
            url: earningInfoMonthYearRoute,
            data: { "month_year": month_year, "admin_commission_percentage": admin_commission_percentage, "contributor_commission_percentage": contributor_commission_percentage },
            datatype: "json",
            success: function (response) {
                $('.total_download').val(response.total_download)
                $('.total_income_from_plan').val(response.total_income_from_plan)
                $('.get_commission_per_download').val(response.get_commission_per_download)
                $('.admin_commission_percentage').val(response.admin_commission_percentage)
                $('.contributor_commission_percentage').val(response.contributor_commission_percentage)
            },
            error: function () {
                alert("Error!");
            },
        });
    });

    $('#search_string').on("change",function () {
        var search_string = $('#search_string').val()
        var route = currentUrl;
        var data = { 'search_string': search_string }
        fetch_data(route, data);
    })

    function fetch_data(route, data) {
        $.ajax({
            url: route,
            data: data,
            success: function (data) {
                $('#appendList').html(data);
            }
        });
    }

});
