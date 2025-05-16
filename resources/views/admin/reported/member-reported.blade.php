@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{ __(@$pageTitle) }}</h2>
            <div class="">
                <div class="breadcrumb__content p-0">
                    <div class="breadcrumb__content__right">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb sf-breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __(@$pageTitle) }}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
            <div class="table-resposive zTable-responsive">
                <table class="table zTable zTable-last-item-right commonDataTable">
                    <thead>
                    <tr>
                        <th>
                            <div>{{ __('Sl') }}</div>
                        </th>
                        <th>
                            <div class="text-nowrap">{{ __('Report By') }}</div>
                        </th>
                        <th>
                            <div>{{ __('Reported') }}</div>
                        </th>
                        <th>
                            <div>{{ __('Reason') }}</div>
                        </th>
                        <th>
                            <div>{{ __('Date') }}</div>
                        </th>
                        <th>
                            <div>{{ __('action') }}</div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($memberReports as $memberReport)
                        <tr class="removable-item">
                            <td>{{$loop->iteration}}</td>
                            <td>{{ @$memberReport->reportedByCustomer->name }}</td>
                            <td>
                                @if($memberReport->reported_to_customer_id)
                                    {{ @$memberReport->reportedToCustomer->name }}
                                @else
                                    {{ @$memberReport->reportedToUser->name }}
                                @endif
                            </td>
                            <td>{{ $memberReport->reason }}</td>
                            <td>{{ date('d M, Y', strtotime($memberReport->created_at)) }}</td>
                            <td>
                                <button class="btn-action ms-2 deleteItem"
                                        data-formid="delete_row_form_{{$memberReport->id}}">
                                    <img src="{{asset('admin/images/icons/trash-2.svg')}}" alt="trash">
                                </button>
                                <form action="{{ route('admin.reported.member.delete', $memberReport->id) }}"
                                      method="post" id="delete_row_form_{{ $memberReport->id }}">
                                    {{ method_field('DELETE') }}
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Page content area end -->

@endsection

@push('script')
    <script src="{{ asset('admin/js/custom/reported.js') }}"></script>
@endpush
