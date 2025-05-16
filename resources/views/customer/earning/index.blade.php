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
                            <div class="row pb-sm-30 pb-20 rg-20">
                                <div class="col-xl-4 col-lg-6 col-md-12 col-sm-6">
                                    <div class="myEarnings-item zaiStock-shadow-one">
                                        <div class="icon">
                                            <img src="{{asset('assets/images/icon/myEarnings-icon-1.svg')}}" alt=""/>
                                        </div>
                                        <div class="text-content">
                                            <h4 class="title">{{__('Total Earnings')}}</h4>
                                            <p class="amount">{{showPrice($totalEarningBalance)}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 col-sm-6">
                                    <div class="myEarnings-item zaiStock-shadow-one">
                                        <div class="icon">
                                            <img src="{{asset('assets/images/icon/myEarnings-icon-2.svg')}}" alt=""/>
                                        </div>
                                        <div class="text-content">
                                            <h4 class="title">{{__('Available Balance')}}</h4>
                                            <p class="amount">{{showPrice($totalAvailableBalance)}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 col-sm-6">
                                    <div class="myEarnings-item zaiStock-shadow-one">
                                        <div class="icon">
                                            <img src="{{asset('assets/images/icon/myEarnings-icon-3.svg')}}" alt=""/>
                                        </div>
                                        <div class="text-content">
                                            <h4 class="title">{{__('Wallet Balance')}}</h4>
                                            <p class="amount">{{showPrice($totalWalletBalance)}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 col-sm-6">
                                    <div class="myEarnings-item zaiStock-shadow-one">
                                        <div class="icon">
                                            <img src="{{asset('assets/images/icon/myEarnings-icon-4.svg')}}" alt=""/>
                                        </div>
                                        <div class="text-content">
                                            <h4 class="title">{{__('Total Download')}}</h4>
                                            <p class="amount">{{$totalDownload}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 col-sm-6">
                                    <div class="myEarnings-item zaiStock-shadow-one">
                                        <div class="icon">
                                            <img src="{{asset('assets/images/icon/myEarnings-icon-5.svg')}}" alt=""/>
                                        </div>
                                        <div class="text-content">
                                            <h4 class="title">{{__('Withdraw Completed')}}</h4>
                                            <p class="amount">{{showPrice($totalWithdrawCompletedAmount)}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 col-sm-6">
                                    <div class="myEarnings-item zaiStock-shadow-one">
                                        <div class="icon">
                                            <img src="{{asset('assets/images/icon/myEarnings-icon-6.svg')}}" alt=""/>
                                        </div>
                                        <div class="text-content">
                                            <h4 class="title">{{__('Withdraw Pending')}}</h4>
                                            <p class="amount">{{showPrice($totalWithdrawPendingAmount)}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--  -->
                            <div class="row rg-20">
                                <div class="col-xl-4 col-sm-6">
                                    <a href="{{route('customer.beneficiaries.index')}}" type="button"
                                       class="zaiStock-btn text-center w-100"
                                       type="button">{{__('Withdraw Beneficiary')}}</a>
                                </div>
                                <div class="col-xl-4 col-sm-6">
                                    <button type="button" class="zaiStock-btn-secondary w-100" data-bs-toggle="modal"
                                            data-bs-target="#myEarningsWithdrawModal">{{__('Withdraw Now')}}
                                    </button>
                                </div>
                                <div class="col-xl-4 col-sm-6">
                                    <a href="{{route('customer.wallets.index')}}"
                                       class="zaiStock-btn w-100 bd-c-primary-dark-text bg-primary-dark-text text-white text-center d-block">{{__('Deposit History')}}</a>
                                </div>
                            </div>
                        </div>
                        <div class="bd-one bd-c-stroke bd-ra-10 bg-white zaiStock-shadow-one p-sm-25 p-15">
                            <div class="pb-20 d-flex align-items-center justify-content-between">
                                <p class="fs-20 fw-500 lh-30 text-primary-dark-text">{{__('Withdrawal History')}}</p>
                            </div>
                            <table
                                class="table zTable zTable-last-item-border zTable-last-item-right zTable-last-item-right"
                                id="withdrawalHistoryTable">
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

    <!-- Withdraw Modal -->
    <div class="modal fade" id="myEarningsWithdrawModal" tabindex="-1" aria-labelledby="myEarningsWithdrawModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 bd-ra-10">
                <div class="p-sm-25 p-15 myEarningsWithdrawModal-content">
                    <form action="{{route('customer.withdraw')}}" class="ajax" method="POST" data-handler="commonResponseWithPageLoad">
                        @csrf
                        <div class="pb-10 d-flex justify-content-end">
                            <button type="button"
                                    class="w-30 h-30 bg-bg-color-2 border-0 rounded-circle d-flex justify-content-center align-items-center"
                                    data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i>
                            </button>
                        </div>
                        <div class="pb-20 titleWrap">
                            <h4 class="amount">{{showPrice($totalAvailableBalance)}}</h4>
                            <p class="info">{{__('Available Balance')}}</p>
                        </div>
                        <div class="d-flex flex-column rg-18 pb-md-40 pb-20">
                            <div class="">
                                <label for="widthDrawAmount" class="zForm-label">{{__('Amount')}}<span
                                        class="text-primary">*</span></label>
                                <input type="number" step="any" name="amount" id="widthDrawAmount" class="zForm-control"
                                       placeholder="{{__('Type amount')}}"/>
                            </div>
                            <div class="">
                                <label for="beneficiary_id" class="zForm-label">{{('Beneficiary')}}<span
                                        class="text-primary">*</span></label>
                                <select class="sf-select-without-search" name="beneficiary_id" id="beneficiary_id">
                                    <option value="">{{__('Select Beneficiary')}}</option>
                                    @foreach($beneficiaries as $beneficiary)
                                        <option
                                            value="{{$beneficiary->id}}">{{$beneficiary->name.'('.getBeneficiary($beneficiary->type).')'}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="">
                                <label for="note" class="zForm-label">{{__('Note')}}</label>
                                <textarea name="note" class="zForm-control" id="note"></textarea>
                            </div>
                        </div>
                        <button type="submit"
                                class="zaiStock-btn w-100 d-block text-center">{{__('Make Withdraw')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="datatable-route" value="{{ route('customer.my_earning') }}">
@endsection
@push('script')
    <script src="{{ asset('assets/js/my_earning.js') }}"></script>
@endpush
