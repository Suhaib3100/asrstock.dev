<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{@$pageTitle}}</title>

    <!-- Favicon included -->
    <link rel="shortcut icon" href="{{ getSettingImage('app_fav_icon') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{asset('admin/sweetalert2/sweetalert2.css')}}">

    <!-- All CSS files included here -->
    <link rel="stylesheet" href="{{asset('admin/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/bootstrap.min.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="{{asset('admin/css/metisMenu.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/styles/main.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/extra.css')}}">
    <link rel="stylesheet" href="{{ asset('admin/css/toastr.min.css') }}">
    <!-- Summernote CSS  -->
    <link href="{{ asset('admin/css/summernote.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/css/summernote-lite.min.css') }}" rel="stylesheet">
    <!-- //Summernote CSS  -->

    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/plugins.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.responsive.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/css/summernote/summernote-lite.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('assets/scss/style.css')}}?v={{env('VERSION', 1)}}"/>
    @include('layouts.dynamic-color')
    @stack('style')
</head>
<body class="bg-sidebar-bg {{ selectedLanguage()->rtl == 1 ? 'direction-rtl' : 'direction-ltr' }}">

@if(getOption('app_preloader_status') == ACTIVE)

    <!-- Pre Loader Area start -->
    <div id="preloader">
        <div id="preloader_status"><img src="{{ getSettingImage('app_preloader') }}" alt="img" /></div>
    </div>
    <!-- Pre Loader Area End -->

@endif

@if (getOption('cookie_status'))
    <div class="cookie-consent-wrap shadow-lg">
        @include('cookie-consent::index')
    </div>
@endif

<div class="zMain-wrap">
    @include('admin.layouts.sidebar')
    <!-- Main Content -->
    <div class="zMainContent overflow-x-hidden">
        <!-- Header -->
        @include('admin.layouts.header')
        <!-- Content -->
        @yield('content')
    </div>
</div>

<input type="hidden" class="getCurrentSymbol" value="{{ getCurrencySymbol() }}">
<!-- All Javascript files included here -->
<script src="{{asset('admin/js/jquery-3.7.1.min.js')}}"></script>
<script src="{{asset('admin/js/popper.min.js')}}"></script>
<script src="{{asset('admin/js/bootstrap.min.js')}}"></script>
<script src="{{asset('admin/js/apexcharts.min.js')}}"></script>
<script src="{{asset('admin/sweetalert2/sweetalert2.all.js')}}"></script>
<script src="{{asset('admin/js/iconify.min.js')}}"></script>
<script src="{{ asset('admin/js/toastr.min.js') }}"></script>
<script src="{{asset('admin/js/custom.js')}}"></script>
<script src="{{asset('admin/js/metisMenu.min.js')}}"></script>
<script src="{{asset('admin/js/main.js')}}"></script>

<script src="{{ asset('admin/js/custom/common.js') }}"></script>

<!-- Summernote JS  -->
<script src="{{ asset('admin/js/summernote-lite.min.js') }}"></script>
<!-- //Summernote JS  -->

<script src="{{asset('assets/js/dataTables.js')}}"></script>
<script src="{{asset('assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/js/plugins.js')}}"></script>
<script src="{{asset('assets/js/main.js')}}"></script>
@stack('script')

<script>
    "use strict"

    @if(Session::has('success'))
    toastr.success("{{ session('success') }}");
    @endif
    @if(Session::has('error'))
    toastr.error("{{ session('error') }}");
    @endif
    @if(Session::has('info'))
    toastr.info("{{ session('info') }}");
    @endif
    @if(Session::has('warning'))
    toastr.warning("{{ session('warning') }}");
    @endif

    @if (@$errors->any())
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    </script>

</body>
</html>
