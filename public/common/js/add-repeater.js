(function ($) {
    "use strict";
    $(document).ready(function () {

        jQuery(document).ready(function () {
            KTFormRepeater.init();
        });
        let formRepeaterId = "#add_repeater";
        let KTFormRepeater = function () {
            let demo1 = function () {
                $(formRepeaterId).repeater({
                    initEmpty: false,
                    defaultValues: {
                        'text-input': 'foo'
                    },
                    show: function () {
                        $(this).find('img:not(.onlyForProductRules)').attr('src', '');
                        $(this).slideDown();
                    },
                    hide: function (deleteElement) {
                        $(this).slideUp(deleteElement);
                    }
                });
            }
            return {
                // public functions
                init: function () {
                    demo1();
                }
            };
        }();
    });
})(jQuery)
