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

    const passToggle2 = document.querySelector('.password-visibility.pass-2');

    passToggle2.addEventListener('click', function(){
        const passText2 = document.querySelector('#pass-2');

        if(passText2.type == "password"){
            passText2.type = 'text';
            this.classList.add('show');
        }else{
            passText2.type = 'password';
            this.classList.remove('show');
        }
    });
})(jQuery)
