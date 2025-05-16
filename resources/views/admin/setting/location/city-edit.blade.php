@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{ __('Frontend Settings') }}</h2>
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
                <div class="d-flex flex-wrap justify-content-between align-items-center g-10 pb-24">
                    <h2 class="fs-18 fw-600 lh-20 text-primary-dark-text">Edit City</h2>
                    <a href="{{ route('admin.setting.location.city.index') }}" class="border-0 bg-para-text py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white d-inline-flex align-items-center g-10" >
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>
                <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
                    <form action="{{route('admin.setting.location.city.update', [$city->id])}}" method="post" class="form-horizontal">
                        @csrf
                        @method('patch')
                        <div class="row rg-24 pb-24">
                            <div class="col-md-6">
                                    <label class="zForm-label" for="name">State name</label>
                                    <select class="form-select" name="state_id" required>
                                        <option value="">--Select Option--</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state->id }}" {{ $city->state_id == $state->id ? 'selected' : '' }}>{{ $state->name }} </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('state_id'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('state_id') }}</span>
                                    @endif
                            </div>
                            <div class="col-md-6">
                                    <label class="zForm-label" for="name">Name</label>
                                    <input class="zForm-control" type="text" name="name" id="name" placeholder="Type name" value="{{ $city->name }}" required>
                                    @if ($errors->has('name'))
                                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('name') }}</span>
                                    @endif
                            </div>

                        </div>

                        <div class="bd-c-stroke bd-t-one d-flex justify-content-end align-items-center pt-15">
                            <button type="submit" class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection
