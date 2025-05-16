(function ($) {
    "use strict";

    window.changeSettingStatus = function($selector, $key) {
        let value = $($selector).is(':checked') ? 1 : 0;
        let data = new FormData();
        data.append('value', value);
        data.append('key', $key);
        data.append("_token", $('meta[name="csrf-token"]').attr('content'));

        commonAjax('POST', $('#statusChangeRoute').val(), statusChangeResponse, statusChangeResponse, data);
    }

    $(document).on('click', '#sendTestMailBtn', function(){
        $('.main-modal').modal('hide');
        $(document).find('#sendTestMail').modal('show');
    });

    $(document).on('click', '#sendTestSMSBtn', function(){
        $('.main-modal').modal('hide');
        $(document).find('#sendTestSMS').modal('show');
    });


    window.statusChangeResponse = function(response){
        $('.error-message').remove();
        $('.is-invalid').removeClass('is-invalid');
        if (response['status'] === true) {
            toastr.success(response['message']);
        } else {
            toastr.error(response['message']);
            location.reload();
        }
    }


    window.configureModal = function(selector){
        $.ajax({
            type: 'GET',
            url: $('#configureUrl').val()+'?key='+selector,
            success: function (data) {
                $(document).find('#configureModal').find('.modal-content').html(data);
                $('#configureModal').modal('toggle');
                if ($(document).find('#configureModal').find('.sf-select-edit-modal').length) {
                    $(document).find('#configureModal').find('.sf-select-edit-modal').select2({
                        dropdownCssClass: "sf-select-dropdown",
                        selectionCssClass: "sf-select-section",
                        dropdownParent: $('#configureModal'),
                    });
                }
            },
            error: function (error) {
                toastr.error(error.responseJSON.message)
            }
        });
    }

    window.helpModal = function(selector){
        $.ajax({
            type: 'GET',
            url: $('#helpUrl').val()+'?key='+selector,
            success: function (data) {
                $(document).find('#helpModal').find('.modal-content').html(data);
                $('#helpModal').modal('toggle');
            },
            error: function (error) {
                toastr.error(error.responseJSON.message)
            }
        });
    }


})(jQuery)

