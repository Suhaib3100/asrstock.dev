@extends('layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush

@section('content')
    <!-- Main content -->
    <section class="admin-section">
        <div class="container">
            <div class="row rg-20">
                <div class="col-xl-3 col-lg-4 col-md-4">
                    @include('customer.layouts.sidebar')
                </div>
                <!--  -->
                <div class="col-xl-9 col-lg-8 col-md-8">
                    <div class="admin-section-right">
                        <div class="bd-one bd-c-stroke bd-ra-10 bg-white zaiStock-shadow-one p-sm-25 p-15">
                            <table class="table zTable zTable-last-item-border zTable-last-item-right"
                                   id="favoriteTable">
                                <thead>
                                <tr>
                                    <td>
                                        <div>{{__('Product')}}</div>
                                    </td>
                                    <td>
                                        <div>{{__('Title')}}</div>
                                    </td>
                                    <td>
                                        <div>{{__('Author')}}</div>
                                    </td>
                                    <td>
                                        <div>{{__('Type')}}</div>
                                    </td>
                                    <td>
                                        <div>{{__('Action')}}</div>
                                    </td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script src="{{ asset('assets/js/favourites.js') }}"></script>
@endpush
