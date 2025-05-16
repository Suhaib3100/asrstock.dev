(function ($) {
    'use strict'
    /*---------------------------
     password toggle
     ---------------------------*/
     const passToggle = document.querySelector('.password-visibility');

     passToggle.addEventListener('click', function(){
        const passText = document.querySelector('#pass');

        if(passText.type == "password"){
            passText.type = 'text';
            this.classList.add('show');
        }else{
            passText.type = 'password';
            this.classList.remove('show');
        }
    });
})(jQuery)
