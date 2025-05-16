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
                            <table class="table zTable zTable-last-item-border zTable-last-item-right" id="productTable">
                                <thead>
                                <tr>
                                    <td>
                                        <div>{{__('Thumbnail')}}</div>
                                    </td>
                                    <td>
                                        <div>{{__('Title')}}</div>
                                    </td>
                                    <td>
                                        <div>{{__('Sales')}}</div>
                                    </td>
                                    <td>
                                        <div>{{__('Downloads')}}</div>
                                    </td>
                                    <td>
                                        <div>{{__('Earnings')}}</div>
                                    </td>
                                    <td>
                                        <div>{{__('Status')}}</div>
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

    <input type="hidden" id="datatable-route" value="{{ route('customer.products.index') }}">
@endsection
@push('script')
    <script src="{{ asset('assets/js/products.js') }}"></script>
@endpush
