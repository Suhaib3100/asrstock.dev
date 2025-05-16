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
                        <div class="mb-30">
                            <div class="row rg-20 align-items-center">
                                <div class="col-lg-6">
                                    <div class="fundsAvailable h-100">
                                        <h4 class="title">{{showPrice($wallet_balance)}}</h4>
                                        <p class="info">{{__('Funds available in your account')}}</p>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <form action="{{route('customer.checkout.page')}}"
                                          method="GET">
                                        <input type="hidden" name="type" value="wallet">
                                        <div class="pb-15">
                                            <label for="addWalletMoney"
                                                   class="zForm-label">{{__('Add Wallet Money Range')}}({{$min_wallet_amount.'-'.$max_wallet_amount}})</label>
                                            <input type="number" name="amount" id="addWalletMoney" class="zForm-control"
                                                   placeholder="{{__('Enter amount')}}"/>
                                            @error('amount')
                                            <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <button type="submit"
                                                class="w-100 zaiStock-btn bd-c-primary-dark-text bg-primary-dark-text">{{__('Add Funds')}}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="bd-one bd-c-stroke bd-ra-10 bg-white zaiStock-shadow-one p-sm-25 p-15">
                            <div class="pb-20 d-flex align-items-center justify-content-between">
                                <p class="fs-20 fw-500 lh-30 text-primary-dark-text">{{__('Deposit History')}}</p>
                                <a class="py-10 zaiStock-btn-secondary" href="{{route('customer.my_earning')}}" >{{__('Go to Earning')}}</a>
                            </div>
                            <table class="table zTable zTable-last-item-border zTable-last-item-right zTable-last-item-right"
                                   id="depositHistoryTable">
                                <thead>
                                <tr>
                                    <td>
                                        <div>{{__('SL')}}</div>
                                    </td>
                                    <td>
                                        <div>{{__('Amount')}}</div>
                                    </td>
                                    <td>
                                        <div>{{__('Method')}}</div>
                                    </td>
                                    <td>
                                        <div>{{__('Date')}}</div>
                                    </td>
                                    <td>
                                        <div>{{__('Status')}}</div>
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

    <input type="hidden" id="datatable-route" value="{{ route('customer.wallets.history-deposit-wallet') }}">
@endsection
@push('script')
    <script src="{{ asset('assets/js/wallets.js') }}"></script>
@endpush
