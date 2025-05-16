<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.header')
@php
  $productType = getProductType();
@endphp
<body
    class="{{ selectedLanguage()->rtl == 1 ? 'direction-rtl' : 'direction-ltr' }} {{ !(getOption('app_color_design_type', DEFAULT_COLOR) == DEFAULT_COLOR) }}">

<input type="hidden" id="lang_code" value="{{session('local')}}">
@if (getOption('app_preloader_status', 0) == ACTIVE)
    <div id="preloader">
        <div id="preloader_status">
            <img src="{{ getSettingImage('app_preloader') }}" alt="{{ getOption('app_name') }}"/>
        </div>
    </div>
@endif

@if (getOption('cookie_status'))
    <div class="cookie-consent-wrap shadow-lg">
        @include('cookie-consent::index')
    </div>
@endif

@include('layouts.nav')
@yield('content')
@include('layouts.footer')

@include('layouts.script')

</body>

</html>
