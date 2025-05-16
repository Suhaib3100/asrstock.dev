"use strict"
function fetch_data(route, data) {
    $.ajax({
        url: route,
        data: data,
        success: function (data) {
            $('#appendList').html(data);
        }
    });
}
