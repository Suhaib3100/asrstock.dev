$(function () {
    "use strict";

    $(document).on('change', "#meta-type", function (event) {
        event.preventDefault();
        commonAjax("get", get_page_route, getPageHandler, getPageHandler, { 'type': $(this).val() });
    });

    $(document).find("#meta-type").trigger('change');

    function getPageHandler(response){
        if(response.success == true){
            let html = '';
            $.each(response.data, function(ind, val){
                if($(document).find("#meta-type").val() == 1){
                    html += '<option value="'+ind+'">'+val+'</option>';
                }
                else{
                    html += '<option value="'+val.id+'">'+val.name+'</option>';
                }
            });

            $('#page').html(html);
        }
    }
});