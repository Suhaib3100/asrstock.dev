@extends('layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush

@section('content')
    <!-- Main content -->
    <section class="admin-section">
        <div class="container">
            <div class="row rg-20 justify-content-center">
                <div class="col-lg-10">
                    <div class="referral-content-wrap">
                        <div class="referral-content-linkCopy">
                            <h4 class="title">{{__('Referral')}}</h4>
                            <div class="copyToClipboard">
                                <div class="left">
                                    <div class="icon"><img src="{{asset('assets/images/icon/copy-clipboard.svg')}}" alt="" /></div>
                                    <p id="copyText" class="copyText">{{route('register')}}?referred_by={{auth()->user()->user_name}}</p>
                                </div>
                                <button class="copyTextBtn">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                        <path d="M7.5 12.5C7.5 10.143 7.5 8.9645 8.23223 8.23223C8.9645 7.5 10.143 7.5 12.5 7.5H13.3333C15.6903 7.5 16.8688 7.5 17.6011 8.23223C18.3333 8.9645 18.3333 10.143 18.3333 12.5V13.3333C18.3333 15.6903 18.3333 16.8688 17.6011 17.6011C16.8688 18.3333 15.6903 18.3333 13.3333 18.3333H12.5C10.143 18.3333 8.9645 18.3333 8.23223 17.6011C7.5 16.8688 7.5 15.6903 7.5 13.3333V12.5Z" stroke="#09A8F7" stroke-width="1.625" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M14.1679 7.49999C14.1659 5.03575 14.1286 3.75933 13.4113 2.88535C13.2728 2.71656 13.1181 2.56181 12.9493 2.42329C12.0273 1.66666 10.6576 1.66666 7.91797 1.66666C5.1784 1.66666 3.80862 1.66666 2.88666 2.42329C2.71788 2.5618 2.56312 2.71656 2.4246 2.88535C1.66797 3.80731 1.66797 5.17709 1.66797 7.91666C1.66797 10.6562 1.66797 12.026 2.4246 12.948C2.56311 13.1167 2.71788 13.2715 2.88666 13.41C3.76064 14.1273 5.03706 14.1646 7.5013 14.1666" stroke="#09A8F7" stroke-width="1.625" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="pb-16 d-flex flex-column flex-sm-row justify-content-center justify-content-sm-between align-items-center g-10 flex-wrap">
                            <h4 class="fs-md-24 fs-20 fw-600 lh-34 text-primary-dark-text">{{__('Affiliate Dashboard')}}</h4>
                            <a href="{{route('customer.my_earning')}}" class="zaiStock-btn">{{__('My Earnings')}}</a>
                        </div>
                        <div class="row pb-sm-30 pb-20 rg-20">
                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-6">
                                <div class="myEarnings-item zaiStock-shadow-one">
                                    <div class="icon"><img src="{{asset('assets/images/icon/myEarnings-icon-7.svg')}}" alt="" /></div>
                                    <div class="text-content">
                                        <h4 class="title">{{__('Number of Affiliate')}}</h4>
                                        <p class="amount">{{$totalNumberAffiliate}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-6">
                                <div class="myEarnings-item zaiStock-shadow-one">
                                    <div class="icon"><img src="{{asset('assets/images/icon/myEarnings-icon-8.svg')}}" alt="" /></div>
                                    <div class="text-content">
                                        <h4 class="title">{{__('Total Affiliate')}}</h4>
                                        <p class="amount">{{showPrice($totalAffiliate)}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-6 col-md-12 col-sm-6">
                                <div class="myEarnings-item zaiStock-shadow-one">
                                    <div class="icon"><img src="{{asset('assets/images/icon/myEarnings-icon-9.svg')}}" alt="" /></div>
                                    <div class="text-content">
                                        <h4 class="title">{{__('Commission Earnings')}}</h4>
                                        <p class="amount">{{showPrice($totalCommissionEarning)}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bd-one bd-c-stroke bd-ra-10 bg-white zaiStock-shadow-one p-sm-25 p-15">
                            <div class="pb-20 d-flex align-items-center justify-content-between">
                                <p class="fs-20 fw-500 lh-30 text-primary-dark-text">{{__('Earning History')}}</p>
                            </div>
                            <table class="table zTable zTable-last-item-border zTable-last-item-right" id="referralTable">
                                <thead>
                                <tr>
                                    <td><div>{{__('#SL')}}</div></td>
                                    <td><div>{{__('TxnID')}}</div></td>
                                    <td><div>{{__('Plan')}}</div></td>
                                    <td><div class="text-nowrap">{{__('Actual Amount')}}</div></td>
                                    <td><div class="text-nowrap">{{__('Earned Amount')}}</div></td>
                                    <td><div>{{__('Percentage')}}</div></td>
                                    <td><div>{{__('Date')}}</div></td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <input type="hidden" id="datatable-route" value="{{ route('customer.referral.index') }}">
@endsection
@push('script')
    <script src="{{ asset('assets/js/referral.js') }}"></script>
@endpush
