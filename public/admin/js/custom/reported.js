
$(function () {
    'use strict'
    $('.edit').on('click', function (e) {
        e.preventDefault();
        const modal = $('.edit_modal');
        modal.find('input[name=name]').val($(this).data('item').name)
        modal.find('select[name=status]').val($(this).data('item').status)
        let route = $(this).data('updateurl');
        $('#updateEditModal').attr("action", route)
        modal.modal('show')
    })

    $('#mail_type').on('change', function () {
        var mail_type = this.value;
        if (mail_type == 1) {
            $('#mailDiv').addClass('d-none');
            $('#mail').removeAttr('required');
        } else if (mail_type == 2) {
            $('#mailDiv').removeClass('d-none');
            $('#mail').attr('required', true);
        }
    });
})(jQuery)
