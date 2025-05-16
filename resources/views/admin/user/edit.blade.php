@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{__($pageTitle)}}</h2>
            <div class="">
                <div class="breadcrumb__content p-0">
                    <div class="breadcrumb__content__right">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb sf-breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                <li class="breadcrumb-item"><a
                                        href="{{route('admin.user.index')}}">{{__('Admin Management')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{$pageTitle}}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
            <form action="{{route('admin.user.update', [$user->id])}}" method="post" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                <div class="row rg-24 pb-24">
                    <div class="col-md-6 col-xl-4">
                        <label for="name" class="zForm-label"> {{__('Name')}} </label>
                        <input type="text" name="name" id="name" value="{{$user->name}}" class="zForm-control flat-input" placeholder=" {{__('app.name')}} ">
                        @if ($errors->has('name'))
                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('name') }}</span>
                        @endif
                    </div>

                    <div class="col-md-6 col-xl-4">
                        <label for="email" class="zForm-label"> {{__('Email')}} </label>
                        <input type="email" name="email" id="email" value="{{$user->email}}" class="zForm-control flat-input" placeholder=" {{__('app.email')}} ">
                        @if ($errors->has('email'))
                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <div class="col-md-6 col-xl-4">
                        <label for="phone_number" class="zForm-label"> {{__('Contact Number')}} </label>
                        <input type="text" name="contact_number" value="{{$user->contact_number}}" class="zForm-control flat-input" placeholder=" {{__('Contact Number')}} ">
                        @if ($errors->has('contact_number'))
                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('contact_number') }}</span>
                        @endif
                    </div>

                    <div class="col-md-6 col-xl-4">
                        <label for="address" class="zForm-label"> {{__('Address')}} </label>
                        <textarea name="address" id="address" class="zForm-control" placeholder="Address">{{$user->address}}</textarea>
                        @if ($errors->has('address'))
                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('address') }}</span>
                        @endif
                    </div>

                    <div class="col-md-6 col-xl-4">
                        <label for="role_name" class="zForm-label"> {{__('Select Role')}} </label>
                        <select name="role_name" id="role_name" class="form-select">
                            <option value="">{{__('Select Role')}}</option>
                            @foreach($roles as $role)
                                <option value="{{$role->name}}" @if(count($user->getRoleNames()) > 0)
                                    {{$user->getRoleNames()[0] == $role->name ? 'selected' : '' }}
                                    @endif >{{$role->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('role_name'))
                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('role_name') }}</span>
                        @endif
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <label for="password" class="zForm-label"> {{__('Password')}} </label>
                        <input type="text" name="password" class="zForm-control flat-input" placeholder=" {{__('Password')}} ">
                        @if ($errors->has('password'))
                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('password') }}</span>
                        @endif
                    </div>
                </div>
                <div class="bd-c-stroke bd-t-one d-flex justify-content-end align-items-center pt-15">
                    <button type="submit"
                            class="border-0 bd-ra-12 bg-primary py-13 px-25 fs-16 fw-600 lh-19 text-white">{{ __('Update') }}</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Page content area end -->
@endsection

