var getCurrencySymbol = $('#getCurrencySymbol').val();
var allCurrency = JSON.parse($('#allCurrency').val());

(function ($) {
    "use strict";

    $(document).on('change', '.currency', function () {
        $(this).closest('li').find('.append_currency').text($(this).val())
    });

    // Bank
    $(document).on('click', '.addBankBtn', function (e) {
        $(document).find('.bankItemLists').append(addBank());
    });

    $(document).on('click', '.removedBankBtn', function () {
        $(this).closest('li').remove()
    });

    window.addBank = function () {
        return `<li class="d-flex justify-content-between align-items-center g-10">
                    <div class="d-flex flex-grow-1 gap-2 pt-3 left">
                        <div class="flex-grow-1">
                            <input type="text" class="form-control zForm-control" name="bank[name][]" placeholder="Name">
                        </div>
                        <div class="flex-grow-1">
                            <textarea name="bank[details][]" class="form-control zForm-control" placeholder="Details"></textarea>
                        </div>
                    </div>
                    <button type="button"
                        class="flex-shrink-0 bd-one bd-c-stroke rounded-circle w-25 h-25 d-flex justify-content-center align-items-center bg-transparent text-danger removedBankBtn">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </li>`;
    }

    $(document).on('change', '.gateway_currency', function () {
        $('.gateway_append_currency').text($(this).val());
    });

    $('.gateway_append_currency').text($('.gateway_currency').val());

})(jQuery);
