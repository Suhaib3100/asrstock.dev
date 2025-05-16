@extends('layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush
@section('content')
    <!-- Breadcrumb -->
    <section class="breadcrumb-section">
        <div class="breadcrumb-content bg-inner-bg">
            <h4 class="title">{{$pageTitle}}</h4>
            <ol class="breadcrumb sf-breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('frontend.index')}}">{{__('Home')}}</a></li>
                <li class="breadcrumb-item"><a>{{$pageTitle}}</a></li>
            </ol>
        </div>
    </section>
    <section class="section-gap-alt">
        <div class="container">
            <div class="max-w-864 m-auto">
                {!! $policy->description !!}
            </div>
        </div>
    </section>
@endsection
