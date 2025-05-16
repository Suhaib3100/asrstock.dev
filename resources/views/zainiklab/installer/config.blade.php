@extends('zainiklab.installer.layout')

@section('title', 'Configuration')
@section('preloader')
    <!-- Pre Loader Area start -->
    <div id="preloader" class="d-none">
        <div id="status">
            <img src="{{ asset('frontend/assets/img/loader.svg') }}" alt="img"/>
            <span class="loading-text">Your install is processing. Please wait a few minutes.</span>
        </div>

    </div>
    <!-- Pre Loader Area End -->
@endsection
@section('content')
<div class="section-wrap-body">

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{$errors->first()}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="primary-form">
      <form action="{{ route('ZaiInstaller::final') }}" method="POST">
        @csrf
        <div class="single-section">
          <h4 class="section-title">{{__('Please enter your application details')}}</h4>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="AppName">{{__('App Name')}}</label>
                <input type="text" class="form-control" id="AppName" name="app_name" value="{{ $_ENV['APP_NAME'] }}" placeholder="{{__('ZaiInstaller')}}" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="AppURL">{{__('App URL')}}</label>
                <input type="text" class="form-control" id="AppURL" name="app_url" value="{{ $_ENV['APP_URL'] }}" placeholder="{{__('http://localhost:8000')}}" />
              </div>
            </div>
          </div>
        </div>
        <div class="single-section {{ $is_active == true ? '' : 'd-none'}}">
          <h4 class="section-title">{{__('Please enter your Item purchase code and customer email')}}</h4>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="email">{{__('Customer E-mail')}}</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', 'install@zainiklab.com') }}" placeholder="{{__('example@example.com')}}" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="purchase_code">{{__('Item purchase code')}}</label>
                <input type="text" class="form-control" id="purchase_code" name="purchase_code" value="{{ old('purchase_code', '1234567890') }}" placeholder="31200164-dd02-49ea-baef-3865c90acc123" />
              </div>
            </div>
          </div>
        </div>
        <div class="single-section">
            <h4 class="section-title">{{__('Please enter your database connection details')}}</h4>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="DatabaseHost">{{__('Database Host')}}</label>
                  <input type="text" class="form-control" id="DatabaseHost" name="db_host" value="{{ $_ENV['DB_HOST'] }}" placeholder="{{__('localhost')}}" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="DatabaseUser">{{__('Database User')}}</label>
                  <input type="text" class="form-control" id="DatabaseUser" name="db_user" value="{{ $_ENV['DB_USERNAME'] }}" placeholder="{{__('root')}}" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="DatabaseName">{{__('Database Name')}}</label>
                  <input type="text" class="form-control" id="DatabaseName" name="db_name" value="{{ $_ENV['DB_DATABASE'] }}" placeholder="{{__('Type your database name')}}" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="Password">Password</label>
                  <input type="password" class="form-control" id="Password" name="db_password" value="{{ $_ENV['DB_PASSWORD'] }}" placeholder="{{__('password')}}" />
                </div>
              </div>
            </div>
        </div>
        <div class="single-section">
            <h4 class="section-title">{{__('Please enter your SMTP details')}}</h4>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="MailHost">{{__('Mail Host')}}</label>
                  <input type="text" class="form-control" id="MailHost" name="mail_host" value="{{ $_ENV['MAIL_HOST'] }}" placeholder="{{__('Type Your mail host name')}}" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="MailPort">{{__('Port')}}</label>
                  <input type="text" class="form-control" id="MailPort" name="mail_port" value="{{ $_ENV['MAIL_PORT'] }}" placeholder="{{__('Type your mail port')}}" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="MailUsername">{{__('Username')}}</label>
                  <input type="text" class="form-control" id="MailUsername" name="mail_username" value="{{ $_ENV['MAIL_USERNAME'] }}" placeholder="{{__('Type your mail username')}}" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="MailPassword">{{__('Password')}}</label>
                  <input type="password" class="form-control" id="MailPassword" name="mail_password" value="{{ $_ENV['MAIL_PASSWORD'] }}" placeholder="{{__('password')}}" />
                </div>
              </div>
            </div>
        </div>
        <div class="single-section d-none">
          <h4 class="section-title">{{__('Please enter your Item purchase code')}}</h4>
          <div class="form-group">
            <label for="purchasecode">{{__('Item purchase code')}}</label>
            <input type="text" class="form-control" id="purchasecode" name="purchasecode" value="NHLE-L6MI-4GE4-ETEV" placeholder="{{__('NHLE-L6MI-4GE4-ETEV')}}" />
          </div>
        </div>
        <div class="row">
          <div class="col-6">
              <a href="{{ route('ZaiInstaller::pre-install') }}" class="primary-btn">{{__('Close')}}</a>
          </div>
          <div class="col-6">
              <button class="primary-btn next" id="submitNext" type="submit">{{__('Next')}}</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection

@push('script')
    <script>
        "use strict"

        $('#submitNext').on('click', function (){
            $('#preloader').removeClass('d-none');
            $('#preloader').addClass('d-block');
        })
    </script>
@endpush
