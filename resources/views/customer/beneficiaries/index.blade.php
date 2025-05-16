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
                            <!--  -->
                            <div class="d-flex gap-3">
                                <button type="button" class="zaiStock-btn-secondary w-100" data-bs-toggle="modal"
                                        data-bs-target="#beneficiaryAddModal">{{__('Add Beneficiary')}}</button>
                                <a href="{{route('customer.my_earning')}}"
                                   class="zaiStock-btn w-100 bd-c-primary-dark-text bg-primary-dark-text text-white text-center d-block">{{__('Back to Earning')}}</a>
                            </div>
                        </div>
                        <div class="bd-one bd-c-stroke bd-ra-10 bg-white zaiStock-shadow-one p-sm-25 p-15">
                            <div class="pb-20 d-flex align-items-center justify-content-between">
                                <p class="fs-20 fw-500 lh-30 text-primary-dark-text">{{__('Beneficiary List')}}</p>
                            </div>
                            <table
                                class="table zTable zTable-last-item-border zTable-last-item-right zTable-last-item-right"
                                id="beneficiaryTable">
                                <thead>
                                <tr>
                                    <td>
                                        <div>{{__('SL')}}</div>
                                    </td>
                                    <td>
                                        <div>{{__('Name')}}</div>
                                    </td>
                                    <td>
                                        <div>{{__('Gateway')}}</div>
                                    </td>
                                    <td>
                                        <div>{{__('Details')}}</div>
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

    <!-- Withdraw Modal -->
    <div class="modal fade" id="beneficiaryAddModal" tabindex="-1" aria-labelledby="beneficiaryAddModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 bd-ra-10">
                <div class="p-sm-25 p-15 beneficiaryAddModal-content">
                    <div class="pb-10 d-flex justify-content-between">
                        <h5>{{__('Add Beneficiary')}}</h5>
                        <button type="button"
                                class="w-30 h-30 bg-bg-color-2 border-0 rounded-circle d-flex justify-content-center align-items-center"
                                data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
                    </div>
                    <form action="{{route('customer.beneficiaries.store')}}" class="ajax" method="POST" data-handler="commonResponseForModal">
                        @csrf
                        <div class="row rg-25">
                            <div class="col-lg-12">
                                <label for="name" class="zForm-label">{{__('Name')}}
                                    <span class="text-primary">*</span></label>
                                <input type="text" value="" name="name" id="name" class="zForm-control"
                                       placeholder="{{__('Name')}}">
                            </div>
                            <div class="col-lg-12">
                                <label for="type" class="zForm-label">{{__('Gateway')}} <span class="text-primary">*</span></label>
                                <select name="type" id="type" class="sf-select-without-search">
                                    @foreach(getBeneficiary() as $optIndex => $optValue)
                                        <option value="{{$optIndex}}">{{$optValue}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <label for="details" class="zForm-label">{{__('Details')}} <span
                                        class="text-primary">*</span></label>
                                <textarea name="details" id="details" placeholder="{{__('Details')}}"
                                          class="zForm-control"></textarea>
                            </div>
                            <div class="col-lg-12">
                                <label for="status" class="zForm-label">{{__('Status')}} <span
                                        class="text-primary">*</span></label>
                                <select name="status" id="status" class="sf-select-without-search">
                                    <option value="{{ACTIVE}}">{{__('Active')}}</option>
                                    <option value="{{DISABLE}}">{{__('Deactivate')}}</option>
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="zaiStock-btn">{{__('Save')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Beneficiary Modal -->
    <div class="modal fade" id="beneficiaryEditModal" tabindex="-1" aria-labelledby="beneficiaryEditModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 bd-ra-10">

            </div>
        </div>
    </div>

    <input type="hidden" id="datatable-route" value="{{ route('customer.beneficiaries.index') }}">
@endsection
@push('script')
    <script src="{{ asset('assets/js/beneficiaries.js') }}"></script>
@endpush
