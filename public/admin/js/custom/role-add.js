let countSub = 0;
let formRepeaterId = "#repeater_role";
let KTFormRepeater = function () {
    let demo1 = function () {
        $(formRepeaterId).repeater({
            initEmpty: false,
            defaultValues: {
                'text-input': 'foo'
            },
            show: function () {
                $(this).slideDown();
                $(this).find('.sub-module-select').attr('id', 'select-kt-' + countSub)
                $(`#select-kt-${countSub++}`).select2({
                    placeholder: "Select permission",
                    dropdownCssClass: "sf-select-dropdown",
                    selectionCssClass: "sf-select-section",
                })
            },
            hide: function (deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });
    }
    return {
        init: function () {
            demo1();
        }
    };
}();

function onSelectSelect(that) {
    const value = $(that).find(':selected').data('id')
    $.ajax({
        type: 'GET',
        url: `${roleSubModuleUrl}/${value}`,
        success: res => {
            if (res.permissions.length > 0) {
                let idName = $(that).parent().parent().find('select')[1].id
                $(`#${idName}`).children().remove()
                res.permissions.forEach(each => {
                    $(`#${idName}`).append(new Option(each.display_name, each.name))
                })
            } else {
                let idName = $(that).parent().parent().find('select')[1].id;
                $(`#${idName}`).children().remove()
                toastr.warning('', `No sub-module data found against ${res.permission.display_name}`);
            }
        },
    })
}
