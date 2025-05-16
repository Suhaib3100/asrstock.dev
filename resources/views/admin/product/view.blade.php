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
                            <li class="breadcrumb-item"><a
                                    href="{{route('admin.product.index')}}">{{__('Products')}}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{__(@$pageTitle)}}</li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="">
        <ul class="bg-white bd-one bd-c-stroke bd-ra-10">
            <li class="px-sm-30 py-15 p-15 bd-b-one bd-c-stroke d-flex align-items-center g-10 g-10 flex-wrap">
                <svg xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img"
                    class="iconify iconify--bi" width="24" height="24" preserveAspectRatio="xMidYMid meet"
                    viewBox="0 0 16 16">
                    <g fill="currentColor">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z">
                        </path>
                        <path
                            d="m8.93 6.588l-2.29.287l-.082.38l.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319c.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246c-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0a1 1 0 0 1 2 0z">
                        </path>
                    </g>
                </svg>
                <h4 class="fs-16 fw-400 lh-26 text-primary-dark-text">Details</h4>
            </li>
            <li class="px-sm-30 py-15 p-15 bd-b-one bd-c-stroke d-flex justify-content-between align-items-center g-10 flex-wrap">
                <h4 class="fs-16 fw-400 lh-26 text-primary-dark-text">{{ __("Title") }}</h4>
                <p class="fs-16 fw-400 lh-26 text-para-text">{{ $product->title }}</p>
            </li>
            <li class="px-sm-30 py-15 p-15 bd-b-one bd-c-stroke d-flex justify-content-between align-items-center g-10 flex-wrap">
                <h4 class="fs-16 fw-400 lh-26 text-primary-dark-text">{{ __("Category") }}</h4>
                <div class="fs-16 fw-400 lh-26 text-para-text">{{ $product->productCategory?->name }}</div>
            </li>
            <li class="px-sm-30 py-15 p-15 bd-b-one bd-c-stroke d-flex justify-content-between align-items-center g-10 flex-wrap">
                <h4 class="fs-16 fw-400 lh-26 text-primary-dark-text">{{ __("Product Type") }}</h4>
                <div class="fs-16 fw-400 lh-26 text-para-text">{{ $product->productType?->name }}</div>
            </li>
            <li class="px-sm-30 py-15 p-15 bd-b-one bd-c-stroke d-flex justify-content-between align-items-center g-10 flex-wrap">
                <h4 class="fs-16 fw-400 lh-26 text-primary-dark-text">{{ __("File type") }}</h4>
                <div class="fs-16 fw-400 lh-26 text-para-text">{{ $product->file_types }}</div>
            </li>
            <li class="px-sm-30 py-15 p-15 bd-b-one bd-c-stroke d-flex justify-content-between align-items-center g-10 flex-wrap">
                <h4 class="fs-16 fw-400 lh-26 text-primary-dark-text">{{ __("Description") }}</h4>
                <div class="fs-16 fw-400 lh-26 text-para-text">{!! nl2br($product->description) !!}</div>
            </li>
            <li class="px-sm-30 py-15 p-15 bd-b-one bd-c-stroke d-flex justify-content-between align-items-center g-10 flex-wrap">
                <h4 class="fs-16 fw-400 lh-26 text-primary-dark-text">{{ __("Accessibility") }}</h4>
                <div class="fs-16 fw-400 lh-26 text-para-text">{{ $product->accessibility == DOWNLOAD_ACCESSIBILITY_TYPE_PAID ? __("Paid") :
                    __("Free")}}</div>
            </li>
            @if($product->accessibility == DOWNLOAD_ACCESSIBILITY_TYPE_FREE)
            <li class="px-sm-30 py-15 p-15 bd-b-one bd-c-stroke d-flex justify-content-between align-items-center g-10 flex-wrap">
                <h4 class="fs-16 fw-400 lh-26 text-primary-dark-text">{{ __("Main File") }}</h4>
                <div class="fs-16 fw-400 lh-26 text-para-text"><a class="text-link" href="{{ getFileFromManager($product->variations->first()->file) }}">{{__('Download')}}</a>
                </div>
            </li>
            @endif
            <li class="px-sm-30 py-15 p-15 bd-b-one bd-c-stroke d-flex justify-content-between align-items-center g-10 flex-wrap">
                <h4 class="fs-16 fw-400 lh-26 text-primary-dark-text">{{ __("Attribution Required") }}</h4>
                <div class="fs-16 fw-400 lh-26 text-para-text">{{ $product->attribution_required == 1 ? __("Yes") : __("No")}}</div>
            </li>
            <li class="px-sm-30 py-15 p-15 bd-b-one bd-c-stroke d-flex justify-content-between align-items-center g-10 flex-wrap">
                <h4 class="fs-16 fw-400 lh-26 text-primary-dark-text">{{ __("Tax") }}</h4>
                <div class="fs-16 fw-400 lh-26 text-para-text">{{ $product->tax?->percentage ?? 0 }}%</div>
            </li>
            <li class="px-sm-30 py-15 p-15 bd-b-one bd-c-stroke d-flex justify-content-between align-items-center g-10 flex-wrap">
                <h4 class="fs-16 fw-400 lh-26 text-primary-dark-text">{{ __("Uploaded By") }}</h4>
                <div class="fs-16 fw-400 lh-26 text-para-text">{{ $product->user ? $product->user->name : $product->customer->name }}</div>
            </li>
            <li class="px-sm-30 py-15 p-15 d-flex justify-content-between align-items-center g-10 flex-wrap">
                <h4 class="fs-16 fw-400 lh-26 text-primary-dark-text">{{ __("Status") }}</h4>
                <div class="d-flex align-items-center g-10">
                    @if($product->status == PRODUCT_STATUS_PUBLISHED)
                        <div class="zBadge zBadge-published">{{ __('Published') }}</div>
                    @elseif($product->status == PRODUCT_STATUS_PENDING)
                            <div class="zBadge zBadge-pending">{{ __('Pending') }}</div>
                    @elseif($product->status == PRODUCT_STATUS_HOLD)
                            <div class="zBadge zBadge-hold">{{ __('Hold') }}</div>
                    @endif
                </div>
            </li>
        </ul>
    </div>
    @if($product->accessibility == DOWNLOAD_ACCESSIBILITY_TYPE_PAID)
        <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15 mt-24">
            <table class="table zTable zTable-last-item-right">
                <thead>
                    <th><div>{{ __("Variation") }}</div></th>
                    <th><div>{{ __("Price") }}</div></th>
                    <th><div>{{ __("Main File") }}</div></th>
                </thead>
                <tbody>
                    @foreach ($product->variations as $variation)
                    <tr>
                        <td>{{ $variation->variation }}</td>
                        <td>{{ $variation->price }}</td>
                        <td class="text-end"><a class="text-primary" href="{{ getFileFromManager($variation->file) }}">Download</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
<!-- Page content area end -->
@endsection
