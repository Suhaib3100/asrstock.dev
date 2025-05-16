@extends('layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush
@section('content')
    <!--  -->
    <section class="section-gap">
        <div class="container">
            <div class="row rg-20">
                <div class="col-md-12">
                    <div
                        class="align-items-center bg-body-tertiary checkout-wrap d-flex flex-column justify-content-center mt-10 p-30 rounded text-center">
                        @if($success == true)
                            <div class="d-flex justify-content-center pb-30">
                                <img src="{{ asset('assets/images/thank-you-bg.png')}}" alt=""/>
                            </div>
                            <h4 class="fs-20 fw-600 lh-24 text-1b1c17 pb-8">{{ __('Successful') }}</h4>
                            <p class="fs-12 fw-400 lh-17 pb-14 max-w-260 m-auto">{{ $message }}</p>
                        @else
                            <div class="d-flex justify-content-center pb-30">
                                <img src="{{ asset('assets/images/failed-bg.png')}}" alt=""/>
                            </div>
                            <h4 class="fs-20 fw-600 lh-24 text-1b1c17 pb-8">{{ __('Failed') }}</h4>
                            <p class="fs-12 fw-400 lh-17 pb-14 max-w-260 m-auto">{{ $message }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
