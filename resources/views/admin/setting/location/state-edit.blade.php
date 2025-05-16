@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{__('Frontend Settings')}}</h2>
            <div class="">
                <div class="breadcrumb__content p-0">
                    <div class="breadcrumb__content__right">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb sf-breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ @$pageTitle }}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="row rg-24">
            <div class="col-xl-3">
                @include('admin.setting.sidebar')
            </div>
            <div class="col-xl-9">
                <div class="d-flex justify-content-between align-items-center g-10 flex-wrap pb-24">
                    <h2 class="fs-18 fw-600 lh-20 text-primary-dark-text">Edit State</h2>
                    <a href="{{ route('admin.setting.location.state.index') }}" class="border-0 bg-para-text py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white d-inline-flex align-items-center g-10" >
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>
                <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                    <form action="{{route('admin.setting.location.state.update', [$state->id])}}" method="post" class="form-horizontal">
                        @csrf
                        @method('patch')
                        <div class="pb-24">
                        <div class="row rg-24">
                            <div class="col-md-6">
                                    <label class="zForm-label" for="name">Country name</label>
                                    <select class="form-select" name="country_id" required>
                                        <option value="">--Select Option--</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ $state->country_id == $country->id ? 'selected' : '' }}>{{ $country->country_name }} </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('country_id'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('country_id') }}</span>
                                    @endif
                            </div>
                            <div class="col-md-6">
                                    <label class="zForm-label" for="name">Name</label>
                                    <input class="zForm-control" type="text" name="name" id="name" placeholder="Type name" value="{{ $state->name }}" required>
                                    @if ($errors->has('name'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('name') }}</span>
                                    @endif
                            </div>

                        </div>
                        </div>


                        <div class="bd-c-stroke bd-t-one d-flex justify-content-between align-items-center pt-15">
                            <button type="submit" class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection
