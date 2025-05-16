(function ($) {
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
})(jQuery)
