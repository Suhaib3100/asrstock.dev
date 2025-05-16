//Get Value
document.querySelectorAll('input[type=color]').forEach(function (picker) {
    //Target Point
    var targetLabel = document.querySelector('label[for="' + picker.id + '"]'),
        codeArea = document.createElement('span');

    codeArea.innerHTML = picker.value;
    targetLabel.appendChild(codeArea);

    //Now AddEventListener
    picker.addEventListener('change', function () {
        codeArea.innerHTML = picker.value;
        targetLabel.appendChild(codeArea);
    });
});

$(function () {
    var css = document.getElementById("textContent");
    var color1 = document.querySelector(".color1");
    var color2 = document.querySelector(".color2");
    var div = document.getElementById("gradient");
    setGradient()
    function setGradient() {
        var textContent = "radial-gradient(circle, " + color1.value + " 10%, " + color2.value + " 100%)"
        div.style.background = textContent;
        css.textContent = div.style.background + ";"
        $('.app_hero_bg_color').val(textContent);
    }
    color1.addEventListener("input", setGradient);
    color2.addEventListener("input", setGradient);
})

$(function () {
    var app_color_design_type = colorDesignType;
    appDesignType(app_color_design_type)
})

$("input[name='app_color_design_type']").on("click",function () {
    var app_design_type = $("input[name='app_color_design_type']:checked").val();
    appDesignType(app_design_type)
});

function appDesignType(app_color_design_type) {
    if (app_color_design_type == 1) {
        $('.customDiv').addClass('d-none')
    } else {
        $('.customDiv').removeClass('d-none')
    }
}
