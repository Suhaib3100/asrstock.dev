

$(document).on('submit', "form.ajax", function (event) {
    event.preventDefault();
    var enctype = $(this).prop("enctype");
    if (!enctype) {
        enctype = "application/x-www-form-urlencoded";
    }
    commonAjax($(this).prop('method'), $(this).prop('action'), window[$(this).data("handler")], window[$(this).data("handler")], new FormData($(this)[0]), $(this));
});

function commonAjax(type, url, successHandler, errorHandler, data, form) {
    var ajaxData = {
        type: type,
        url: url,
        dataType: 'json'
    }
    if (typeof (data) != 'undefined') {
        ajaxData.data = data;
    }
    if (type == 'POST' || type == 'post') {
        ajaxData.encType = 'enctype';
        ajaxData.contentType = false;
        ajaxData.processData = false;
    }
    $.ajax(ajaxData).done(resData => {
        successHandler(resData, form);
    }).fail(failData => {
        errorHandler(failData, form);
    });
}

function getShowMessage(response, form) {
    if (response['success'] == true) {
        toastr.success(response.message)
        location.reload()
    } else {
        commonHandler(response, form)
    }
}
window.alertAjaxMessage = function (type, message) {
    if (type === 'success') {
        toastr.success(message);
    } else if (type === 'error') {
        toastr.error(message);
    } else if (type === 'warning') {
        toastr.error(message);
    } else {
        return false;
    }
}

window.getValidationError = function (errors) {
    var output = 'There were issues with your submission. Please review the input fields.';
    $.each(errors, function (index, items) {
        if (index.indexOf('.') != -1) {
            var name = index.split('.');
            var getName = name.slice(0, -1).join('-');
            var i = name.slice(-1)[0]; // Get the last part of the split result
            if (!isNaN(i)) {
                var itemSelect = $(document).find('.' + getName + ':eq(' + i + ')');
            } else {
                var itemSelect = $(document).find('.' + getName + '_' + i);
            }

            var message = items[0];
            itemSelect.addClass('is-invalid');
            itemSelect.closest('div').append('<span class="text-danger p-2 fs-12 z-index-10 position-relative error-message">' + message + '</span>');

        } else {
            var itemSelect = $(document).find("[name='" + index + "']");
            if (!itemSelect.length) {
                itemSelect = $(document).find("[name^='" + index + "']");
            }
            itemSelect.addClass('is-invalid');
            itemSelect.closest('div').append('<span class="text-danger p-2 fs-12 z-index-10 position-relative error-message">' + items[0] + '</span>')
        }
    });
    return output;
}

window.settingCommonHandler = function (data) {
    var output = '';
    var type = 'error';
    $('.error-message').remove();
    $('.is-invalid').removeClass('is-invalid');
    $(document).find(':input[type=submit]').find('.spinner-border').addClass('d-none');
    $(document).find(':input[type=submit]').removeAttr('disabled');

    if (data['status'] == true) {
        output = output + data['message'];
        type = 'success';
        if ($('.modal.show').length) {
            $('.modal.show').modal('toggle')
        }
        if ($('.dataTable ').length) {
            $('.dataTable').DataTable().ajax.reload();
        }
        alertAjaxMessage(type, output);

        if ($(document).find('form.reset').length) {
            $(document).find('form.reset').first().trigger("reset");
            if ($('.summernoteOne')) {
                $('.summernoteOne').summernote('reset');
            }

            if($('.fileUploadInput')){
                $('.fileUploadInput').val('').trigger('change')
            }

            if ($('.upload-img-box').find('img')) {
                $('.upload-img-box').find('img').attr('src', '');
            }
            if ($('.select2-hidden-accessible')) {
                $('.select2-hidden-accessible').val(null).trigger('change');
            }
            if ($('.sf-select-without-search')) {
                $('.sf-select-without-search').niceSelect('update');
            }

            if ($('.sf-select-checkbox-search')) {
                $('.sf-select-checkbox-search').each(function () {
                    $(this).multiselect('deselectAll', false); // Deselect all options
                    $(this).multiselect('updateButtonText'); // Update the button text
                });
            }

            if ($('.sf-select-checkbox')) {
                $('.sf-select-checkbox').each(function () {
                    $(this).multiselect('deselectAll', false); // Deselect all options
                    $(this).multiselect('updateButtonText'); // Update the button text
                });
            }
        }
    } else {
        commonHandler(data)
    }
}

window.getEditModal = function (url, modalId, callbackFunc){
    $.ajax({
        type: 'GET',
        url: url,
        success: function (data) {
            $(document).find(modalId).find('.modal-content').html(data);

            if ($(document).find(modalId).find('.sf-select-edit-modal').length) {
                $(document).find(modalId).find('.sf-select-edit-modal').select2({
                    dropdownCssClass: "sf-select-dropdown",
                    selectionCssClass: "sf-select-section",
                    dropdownParent: $(modalId),
                });
            }

            if ($(document).find(modalId).find('.sf-select-without-search').length) {
                $(document).find(modalId).find('.sf-select-without-search').niceSelect();
            }

            if ($(document).find(modalId).find('.date-time-picker').length) {
                $(document).find(modalId).find('.date-time-picker').each(function () {
                    $(this).closest(".primary-form-group-wrap").addClass("calendarIcon"); // Add your custom class here
                });
            }

            if ($(document).find(modalId).find('.date-time-picker').length) {
                $(document).find(modalId).find('.date-time-picker').daterangepicker({
                    singleDatePicker: true,
                    timePicker: true,
                    locale: {
                        format: "Y-M-D h:mm",
                    },
                });
            }

            if ($(document).find(modalId).find('.sf-select-two').length) {
                $(document).find(modalId).find('.sf-select-two').select2({
                    dropdownCssClass: "sf-select-dropdown",
                    selectionCssClass: "sf-select-section",
                    minimumResultsForSearch: -1,
                });
            }

            if ($(document).find(modalId).find('.sf-select').length) {
                $(document).find(modalId).find('.sf-select').select2({
                    dropdownCssClass: "sf-select-dropdown",
                    selectionCssClass: "sf-select-section",
                });
            }

            if ($(document).find(modalId).find('.sf-select-checkbox-search').length) {
                $(document).find(modalId).find('.sf-select-checkbox-search').multiselect({
                    buttonClass: "form-select sf-select-checkbox-btn",
                    maxHeight: 322,
                    enableCaseInsensitiveFiltering: true,
                    templates: {
                        button: '<button type="button" class="multiselect dropdown-toggle" data-bs-toggle="dropdown"><span class="multiselect-selected-text"></span></button>',
                    },
                });
            }

            if ($(document).find(modalId).find('.sf-select-checkbox').length) {
                $(document).find(modalId).find('.sf-select-checkbox').multiselect({
                    buttonClass: "form-select sf-select-checkbox-btn",
                    enableFiltering: false,
                    maxHeight: 322,
                    templates: {
                        button: '<button type="button" class="multiselect dropdown-toggle" data-bs-toggle="dropdown"><span class="multiselect-selected-text"></span></button>',
                    },
                });
            }

            if ($(document).find(modalId).find('.summernoteOne').length) {
                $(document).find(modalId).find('.summernoteOne').summernote({
                    placeholder: "Write description...",
                    tabsize: 2,
                    minHeight: 183,
                    toolbar: [
                        ["fontsize", ["fontsize"]],
                        ["para", ["ul", "ol", "paragraph"]],
                        ["color", ["color"]],
                        ["font", ["bold", "italic", "underline"]],
                        ["para", ["ul", "ol", "paragraph"]],
                    ],
                });
            }

            if ($(document).find(modalId).find('.date-time-disable-previous').length) {
                $(document).find(modalId).find(".date-time-disable-previous").attr("min",
                    new Date().getFullYear() + "-" +
                    String(new Date().getMonth() + 1).padStart(2, '0') + "-" +
                    String(new Date().getDate()).padStart(2, '0') + "T" +
                    String(new Date().getHours()).padStart(2, '0') + ":" +
                    String(new Date().getMinutes()).padStart(2, '0')
                );
            }

            if ($(document).find(modalId).find('#youtube-player-video').length) {
                initYoutubePlayer();
            }

            if ($(document).find(modalId).find('#video-player').length) {
                initVideoPlayer();
            }

            if ($(document).find(modalId).find('#audio-player').length) {
                initAudioPlayer();
            }

            $(modalId).modal('toggle');

            // Execute callback after modal is fully loaded and toggled
            if (typeof callbackFunc !== 'undefined'  && typeof window[callbackFunc] === 'function') {
                window[callbackFunc]();
            }
        },
        error: function (error) {
            toastr.error(error.responseJSON.message)
        }
    })
}

window.commonResponseForModal = function (response) {
    $('.error-message').remove();
    $('.is-invalid').removeClass('is-invalid');
    $(document).find(':input[type=submit]').find('.spinner-border').addClass('d-none');
    $(document).find(':input[type=submit]').removeAttr('disabled');
    if (response['status'] === true) {
        toastr.success(response['message'])

        if ($('.modal.show').length) {
            $('.modal.show').modal('toggle');
        }

        if ($('.dataTable').length) {
            $('.dataTable').DataTable().ajax.reload();
        }
        else {
            setTimeout(() => {
                location.reload()
            }, 1000);
        }

        if ($(document).find('form.reset').length) {
            $(document).find('form.reset').first().trigger("reset");
            if ($('.summernoteOne')) {
                $('.summernoteOne').summernote('reset');
            }

            if($('.fileUploadInput')){
                $('.fileUploadInput').val('').trigger('change')
            }

            if ($('.upload-img-box').find('img')) {
                $('.upload-img-box').find('img').attr('src', '');
            }
            if ($('.select2-hidden-accessible')) {
                $('.select2-hidden-accessible').val(null).trigger('change');
            }
            if ($('.sf-select-without-search')) {
                $('.sf-select-without-search').niceSelect('update');
            }

            if ($('.sf-select-checkbox-search')) {
                $('.sf-select-checkbox-search').multiselect("clearSelection");
                $('.sf-select-checkbox-search').multiselect("refresh");
            }
            if ($('.sf-select-checkbox')) {
                $('.sf-select-checkbox').multiselect("clearSelection");
                $('.sf-select-checkbox').multiselect("refresh");
            }
        }

    } else {
        commonHandler(response)
    }
}

window.commonResponseWithPageLoad = function (response) {
    $('.error-message').remove();
    $('.is-invalid').removeClass('is-invalid');
    if (response['status'] === true) {
        toastr.success(response['message'])

        setTimeout(() => {
            location.reload()
        }, 1000);


    } else {
        commonHandler(response)
    }
}

window.commonResponse = function (response) {
    $('.error-message').remove();
    $('.is-invalid').removeClass('is-invalid');
    $(document).find(':input[type=submit]').find('.spinner-border').addClass('d-none');
    $(document).find(':input[type=submit]').removeAttr('disabled');
    if (response['status'] === true) {
        toastr.success(response['message']);
        $("#files-names").html(" ");
        if ($('#serviceImage ').length) {
            $("#serviceImage").src('');
        }
        if ($('.dataTable ').length) {
            $('.dataTable').DataTable().ajax.reload();
        }
        if ($('.modal.show').length) {
            $('.modal.show').modal('toggle');
        }

        if ($(document).find('form.reset').length) {
            $(document).find('form.reset').first().trigger("reset");
            if ($('.summernoteOne')) {
                $('.summernoteOne').summernote('reset');
            }

            if($('.fileUploadInput')){
                $('.fileUploadInput').val('').trigger('change')
            }

            if ($('.upload-img-box').find('img')) {
                $('.upload-img-box').find('img').attr('src', '');
            }
            if ($('.select2-hidden-accessible')) {
                $('.select2-hidden-accessible').val(null).trigger('change');
            }
            if ($('.sf-select-without-search')) {
                $('.sf-select-without-search').niceSelect('update');
            }

            if ($('.sf-select-checkbox-search')) {
                $('.sf-select-checkbox-search').multiselect("clearSelection");
                $('.sf-select-checkbox-search').multiselect("refresh");
            }
            if ($('.sf-select-checkbox')) {
                $('.sf-select-checkbox').multiselect("clearSelection");
                $('.sf-select-checkbox').multiselect("refresh");
            }
        }


    } else {
        commonHandler(response)
    }
}

window.getShowMessage = function (response) {
    $(document).find(':input[type=submit]').find('.spinner-border').addClass('d-none');
    $(document).find(':input[type=submit]').removeAttr('disabled');
    $('.error-message').remove();
    $('.is-invalid').removeClass('is-invalid');
    if (response['status'] === true) {
        toastr.success(response['message']);
    } else {
        commonHandler(response)
    }
}

window.commonResponseRedirect = function (response) {
    $('.error-message').remove();
    $('.is-invalid').removeClass('is-invalid');
    $(document).find(':input[type=submit]').find('.spinner-border').addClass('d-none');
    $(document).find(':input[type=submit]').removeAttr('disabled');
    if (response['status'] == true) {
        toastr.success(response['message']);

        if ($('form').find(`[data-redirect-url]`)) {
            setTimeout(function () {
                location.href = $(document).find(`[data-redirect-url]`).data('redirect-url');
            }, 700);
        }else{
            if ($(document).find('form.reset').length) {
                $(document).find('form.reset').first().trigger("reset");
                if ($('.summernoteOne')) {
                    $('.summernoteOne').summernote('reset');
                }

                if($('.fileUploadInput')){
                    $('.fileUploadInput').val('').trigger('change')
                }

                if ($('.upload-img-box').find('img')) {
                    $('.upload-img-box').find('img').attr('src', '');
                }
                if ($('.select2-hidden-accessible')) {
                    $('.select2-hidden-accessible').val(null).trigger('change');
                }
                if ($('.sf-select-without-search')) {
                    $('.sf-select-without-search').niceSelect('update');
                }

                if ($('.sf-select-checkbox-search')) {
                    $('.sf-select-checkbox-search').multiselect("clearSelection");
                    $('.sf-select-checkbox-search').multiselect("refresh");
                }
                if ($('.sf-select-checkbox')) {
                    $('.sf-select-checkbox').multiselect("clearSelection");
                    $('.sf-select-checkbox').multiselect("refresh");
                }
            }
        }

    } else {
        commonHandler(response)
    }
}

window.gatewayCurrencyPrice = function ($price, $currency = '$') {
    if (currencyPlacement == 'after')
        return $price + ' ' + $currency;
    else {
        return $currency + ' ' + $price;
    }
}

window.deleteItem = function (url, id, redirect_url = null) {
    Swal.fire({
        title: 'Sure! You want to delete?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Delete It!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: 'POST',
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    Swal.fire({
                        title: 'Deleted',
                        html: ' <span style="color:red">Item has been deleted</span> ',
                        timer: 2000,
                        icon: 'success'
                    })
                    toastr.success(data.message);
                    $('#' + id).DataTable().ajax.reload();
                    if (redirect_url) {
                        window.location.href = redirect_url;
                    }else{
                        setTimeout(function() {
                            location.reload();
                        }, 600)
                    }
                },
                error: function (error) {
                    toastr.error(error.responseJSON.message)
                }
            })
        }
    })
}

window.commonHandler = function (data) {
    $(document).find(':input[type=submit]').find('.spinner-border').addClass('d-none');
    $(document).find(':input[type=submit]').removeAttr('disabled');
    var output = '';
    var type = 'error';
    $('.error-message').remove();
    $('.is-invalid').removeClass('is-invalid');
    if (data['status'] == false) {
        output = output + data['message'];
    } else if (data['status'] === 422) {
        var errors = data['responseJSON']['errors'];
        output = getValidationError(errors);
    } else if (data['status'] === 500) {
        output = data['responseJSON']['message'];
    } else if (typeof data['responseJSON']['error'] !== 'undefined') {
        output = data['responseJSON']['error'];
    } else {
        output = data['responseJSON']['message'];
    }
    alertAjaxMessage(type, output);
}

function alertAjaxMessage(type, message) {
    if (type === 'success') {
        toastr.success(message);
    } else if (type === 'error') {
        toastr.error(message);
    } else if (type === 'warning') {
        toastr.error(message);
    } else {
        return false;
    }
}

function getValidationError(errors, form) {
    var output = 'Validation Errors';
    $.each(errors, function (index, items) {
        if (index.indexOf('.') != -1) {
            var name = index.split('.');
            var getName = name.slice(0, -1).join('-');
            var i = name.slice(-1);
            var itemSelect = form.find('.' + getName + ':eq(' + i + ')')
            itemSelect.addClass('is-invalid');
            itemSelect.closest('.input__group').append('<span class="text-danger p-2 error-message">' + items[0] + '</span>')
        } else {
            var itemSelect = form.find("[name='" + index + "']");
            itemSelect.addClass('is-invalid');
            itemSelect.closest('.input__group').append('<span class="text-danger p-2 error-message">' + items[0] + '</span>')
        }
    });
    return output;
}
