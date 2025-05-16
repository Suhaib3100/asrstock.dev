<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <title> @stack('title' ?? '') | {{ getOption('app_name') }}</title>

    <!-- Open Graph meta tags for social sharing -->
    <meta property="og:type" content="{{ getOption('app_name') }}">
    <meta property="og:title" content="{{ $metaData['meta_title'] ?? getOption('app_name') }}">
    <meta property="og:description" content="{{ $metaData['meta_description'] ?? getOption('app_name') }}">
    <meta property="og:image" content="{{ $metaData['og_image'] ?? getSettingImage('app_logo') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{getOption('app_name') }}">

    <meta name="currencyPlacement" content="{{ config('app.currencyPlacement') }}">
    <meta name="currencySymbol" content="{{ config('app.currencySymbol') }}">

    <!-- Twitter Card meta tags for Twitter sharing -->
    <meta name="twitter:card" content="{{ getOption('app_name') }}">
    <meta name="twitter:title" content="{{ $metaData['meta_title'] ?? getOption('app_name') }}">
    <meta name="twitter:description" content="{{ $metaData['meta_description'] ?? getOption('app_name') }}">
    <meta name="twitter:image" content="{{ $metaData['og_image'] ?? getSettingImage('app_logo') }}">

    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <!-- Place favicon.ico in the root directory -->
    <link rel="icon" href="{{ getSettingImage('app_fav_icon') }}" type="image/png" sizes="16x16">
    <link rel="shortcut icon" href="{{ getSettingImage('app_fav_icon') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ getSettingImage('app_fav_icon') }}">

    <!-- css file  -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/plugins.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.responsive.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/summernote/summernote-lite.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/scss/style.css')}}?v={{env('VERSION', 1)}}"/>
    @include('layouts.dynamic-color')
    @stack('style')
    @if(getOption('google_analytics_status', 0))
        <!-- Google tag (gtag.js) -->
        <script async
                src="https://www.googletagmanager.com/gtag/js?id={{ getOption('google_analytics_tracking_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());
            gtag('config', "{{ getOption('google_analytics_tracking_id') }}");
        </script>
    @endif

    @if(getOption('google_adsense_enable'))
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client={{ getOption('google_adsense_client_id') }}" crossorigin="anonymous"></script>
    @endif
</head>
