@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb__content">
                        <div class="breadcrumb__content__left">
                            <div class="breadcrumb__title">
                                <h2>{{ __('Frontend Settings') }}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb sf-breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ __(@$pageTitle) }}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    @include('admin.setting.sidebar')
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="email-inbox__area bg-style">
                        <div class="item-top mb-30 d-flex flex-wrap justify-content-between">
                            <h2>{{ __(@$pageTitle) }}</h2>
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#sendTestMail" class="btn btn-success btn-sm"> <i class="fa fa-envelope"></i> {{ __('Send Test Mail') }} </a>
                        </div>
                        <form action="{{ route('admin.setting.general-settings-env.update')}}" method="post" class="form-horizontal">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                                    <div class="form-group text-black">
                                        <label>{{__('APP MAIL STATUS')}} <span class="text-danger">*</span></label>
                                        <select name="app_mail_status" class="form-select" required>
                                            <option value="1" {{getOption('app_mail_status') == 1 ? 'selected' : '' }} > Active </option>
                                            <option value="0" {{getOption('app_mail_status') != 1 ? 'selected' : '' }} > Disable </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                                    <div class="form-group text-black">
                                        <label>{{__('MAIL MAILER')}} </label>
                                        <input type="text" name="MAIL_MAILER" value="{{env('MAIL_MAILER')}}" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                                    <div class="form-group text-black">
                                        <label>{{__('MAIL HOST')}} </label>
                                        <input type="text" name="MAIL_HOST" value="{{env('MAIL_HOST')}}" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                                    <div class="form-group text-black">
                                        <label>{{__('MAIL PORT')}} </label>
                                        <input type="text" name="MAIL_PORT" value="{{env('MAIL_PORT')}}" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                                    <div class="form-group text-black">
                                        <label>{{__('MAIL USERNAME')}} </label>
                                        <input type="text" name="MAIL_USERNAME" value="{{env('MAIL_USERNAME')}}" class="form-control">
                                    </div>
                                </div>


                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                                    <div class="form-group text-black">
                                        <label>{{__('MAIL PASSWORD')}} </label>
                                        <input type="password" name="MAIL_PASSWORD" value="{{env('MAIL_PASSWORD')}}" class="form-control">
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                                    <div class="form-group text-black">
                                        <label>{{__('MAIL ENCRYPTION')}} <span class="text-danger">*</span></label>
                                        <select name="MAIL_ENCRYPTION" class="form-select">
                                            <option value="tls" {{env('MAIL_ENCRYPTION') == 'tls' ? 'selected' : '' }} > tls </option>
                                            <option value="ssl" {{env('MAIL_ENCRYPTION') == 'ssl' ? 'selected' : '' }} > ssl </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                                    <div class="form-group text-black">
                                        <label>{{__('MAIL FROM ADDRESS')}} </label>
                                        <input type="text" name="MAIL_FROM_ADDRESS" value="{{env('MAIL_FROM_ADDRESS')}}" class="form-control">
                                    </div>
                                </div>


                                <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                                    <div class="form-group text-black">
                                        <label>{{__('MAIL FROM NAME')}} </label>
                                        <input type="text" name="MAIL_FROM_NAME" value="{{env('MAIL_FROM_NAME')}}" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="input__group general-settings-btn">
                                        <button type="submit" class="btn btn-blue float-right">{{__('Save')}}</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->

    <div class="modal fade" id="sendTestMail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('Test Mail')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('admin.setting.send.test.mail')}}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3 text-black">
                            <label for="to" class="col-form-label">{{__('Recipient')}}:</label>
                            <input type="email" name="to" class="form-control" id="to" placeholder="{{__('Recipient Mail')}}" required>
                        </div>
                        <div class="mb-3 text-black">
                            <label for="to" class="col-form-label">{{__('Subject')}}:</label>
                            <input type="text" name="subject" class="form-control" id="to" placeholder="{{__('Subject')}}" value="Test Mail" required>
                        </div>
                        <div class="mb-3 text-black">
                            <label for="message" class="col-form-label">{{ __('Your Message') }}:</label>
                            <textarea name="message" class="form-control" id="message-text">{{ __('Hi, This is a test mail') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer button__list">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-blue mx-2">{{ __('Send') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

