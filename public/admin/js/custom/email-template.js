(function ($) {
    'use strict'
    $(".preview-template").on("click", function () {
        var subject = $("#subject").val();
        var template_body = $("#body").val();
        $("#mail_subject").html(subject);
        $("#body_content").html(template_body);
        $("#previewModal").modal("show");
    });

    $("#sender_type").on("change", function (){
        var sender_type = $(this).val();
        if (sender_type === 'from_csv')
        {
            $('#csv_mail_list').removeClass('d-none');
        } else {
            $('#csv_mail_list').addClass('d-none');
        }
    });

})(jQuery)
