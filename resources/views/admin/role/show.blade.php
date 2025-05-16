@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{__(@$pageTitle)}}</h2>
            <div class="">
                <div class="breadcrumb__content p-0">
                    <div class="breadcrumb__content__right">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb sf-breadcrumb">
                                <li class="breadcrumb-item"><a
                                            href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{__(@$pageTitle)}}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <h2 class="fs-18 fw-600 lh-22 text-primary-dark-text pb-25">{{__($role->name)}}</h2>
        <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
            <table class="table zTable zTable-last-item-right">
                <thead>
                <tr>
                    <th>
                        <div>{{ __('Sl') }}</div>
                    </th>
                    <th>
                        <div>{{__('Module')}}</div>
                    </th>
                    <th>
                        <div>{{__('Sub-module')}}</div>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($permissions->where('submodule_id', 0) as $permission)
                    <tr class="removable-item">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$permission->display_name}}</td>
                        <td>
                            {{implode(', ', $permissions->where('submodule_id', $permission->id)->pluck('display_name')->toArray())}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Page content area end -->
@endsection
