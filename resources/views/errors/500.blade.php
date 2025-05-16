<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ getOption('app_name') }}</title>
    <link rel="shortcut icon" href="{{ getSettingImage('app_fav_icon') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ getSettingImage('app_fav_icon') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/styles/main.css') }}">
</head>

<body>
<div class="error__item__area">
    <div class="error__item__top">
        <div class="error__item__img">
            <img src="{{ asset('admin/images/error/500.png') }}" alt="img">
        </div>
    </div>
    <div class="error__item__content">
        <h2>{{ __('Ooops... 500!') }}</h2>
        <p>{{ $exception->getMessage() ?: __('Something Went Wrong') }}</p>
        <div class="error-button">
            <a href="{{ route('admin.dashboard') }}" class="btn-submit">{{ __('Home') }}</a>
        </div>
    </div>
</div>

<script src="{{ asset('admin/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('admin/js/popper.min.js') }}"></script>
<script src="{{ asset('admin/js/bootstrap.min.js') }}"></script>
</body>

</html>
