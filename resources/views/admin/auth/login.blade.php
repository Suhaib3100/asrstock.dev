<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ getOption('app_name') }} - {{ __('Login') }}</title>

    <!-- Favicon included -->
    <link rel="shortcut icon" href="{{ getSettingImage('app_fav_icon') }}" type="image/x-icon">

    <!-- Apple touch icon included -->
    <link rel="apple-touch-icon" href="{{ getSettingImage('app_fav_icon') }}">

    <!-- All CSS files included here -->
    <link rel="stylesheet" href="{{ asset('admin/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/styles/main.css') }}">

</head>
<body>


<div class="main-content__area bg-img">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-8 col-md-10">
                <div class="authentication__item">
                    <div class="authentication__item__logo">
                        <a href="#">
                            <img src="{{ getSettingImage('app_logo') }}" alt="icon">
                        </a>
                    </div>
                    <div class="authentication__item__title mb-30">
                        <h2>Sign In</h2>
                    </div>
                    @if (session('error'))
                        <div class="alert alert-danger">
                            <p class="msg"> {{ session('error') }}</p>
                        </div>
                    @endif
                    <div class="authentication__item__content">
                        <form action="{{ route('admin.login') }}" method="post">
                            @csrf
                            <div class="input__group mb-25">
                                <label>{{ __('Email Address') }}</label>
                                <div class="input-overlay">
                                    <input type="text" name="email" id="email" placeholder="Enter email address">
                                    <div class="overlay">
                                        <img src="{{ asset('admin') }}/images/icons/mail.svg" alt="icon">
                                    </div>
                                </div>
                            </div>
                            <div class="input__group mb-20">
                                <label>{{ __('Password') }}</label>
                                <div class="input-overlay">
                                    <input type="password" name="password" id="pass" placeholder="Enter password">
                                    <div class="overlay">
                                        <img src="{{ asset('admin') }}/images/icons/lock.svg" alt="icon">
                                    </div>
                                    <div class="password-visibility">
                                        <img src="{{ asset('admin') }}/images/icons/eye.svg" alt="icon">
                                    </div>
                                </div>
                            </div>
                            <div class="input__group mb-27">
                                <button type="submit" class="btn btn-blue">{{ __('Sign In') }}</button>
                            </div>

                        </form>
                        @if(env('DEMO_SITE', false))
                        <div class="bg-light login-info-table mt-3 text-center">
                            <span id="adminCredentialShow" class="login-info"><b>Admin:</b> admin@gmail.com | 123456</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- All Javascript files included here -->
<script src="{{ asset('admin/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('admin') }}/js/popper.min.js"></script>
<script src="{{ asset('admin') }}/js/bootstrap.min.js"></script>
<script src="{{ asset('admin') }}/js/custom/password-show.js"></script>
<script>
    'use strict'
    $(document).ready(function(){
        $('.alert-danger').fadeIn().delay(3000).fadeOut();
    });

    $('#adminCredentialShow').on('click', function (){
        $('#email').val('admin@gmail.com');
        $('#pass').val('123456');
    });
</script>
</body>
</html>
