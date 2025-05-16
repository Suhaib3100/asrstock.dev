(function ($) {
    "use strict"
    $('.addmore').on('click', function (e) {
        e.preventDefault()
        let html = `
                    <tr>
                        <td>
                            <textarea type="text" name="key" class="key form-control"></textarea>
                        </td>
                        <td>
                            <input type="hidden" value="1" class="is_new">
                            <textarea type="text" name="value" class="val form-control"></textarea>
                        </td>
                        <td class="text-end col-1">
                            <button type="button" class="language-update btn btn-sm btn-blue">Update</button>
                        </td>
                    </tr>
                `;
        $('#append').prepend(html);
    })

    $(document).on('input', '.val', function () {
        $(this).closest('tr').find('button').attr('disabled', false);
    })
    $(document).on('click', '.language-update', function () {
        var keyStr = $(this).closest('tr').find('.key').val();
        var valStr = $(this).closest('tr').find('.val').val();
        var is_new = $(this).closest('tr').find('.is_new').val();
        var dom = $(this);
        $.ajax({
            type: "POST",
            url: $('#updateLanguageRoute').val(),
            data: { 'key': keyStr, 'val': valStr, 'is_new': is_new },
            datatype: "json",
            success: function (response) {
                toastr.options.positionClass = 'toast-bottom-right';
                if (response['status'] == 200) {
                    toastr.success(response['msg'])
                    dom.closest('tr').find('.is_new').val(0);
                    dom.closest('tr').find('.key').attr('readonly', true);
                    dom.attr('disabled', 'disabled');
                } else {
                    toastr.error(response['msg'])
                }
                if (response['type'] == 1) {
                    dom.closest('tr').remove();
                }
            },
            error: function (error) {
            },
        });
    })
});
