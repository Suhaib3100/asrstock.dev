var stateSelector;

$('.items-category').on('change', function () {
    stateSelector = $(this).find(":selected");
    var typeName = stateSelector.parent().attr('label');
    stateSelector.text(stateSelector.data('name') + ' (' + typeName + ')');
})
