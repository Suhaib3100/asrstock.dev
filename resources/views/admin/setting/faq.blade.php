@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb__content">
                        <div class="breadcrumb__content__left">
                            <div class="breadcrumb__title">
                                <h2>{{ __('Frontend Settings') }}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb sf-breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ @$pageTitle }}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    @include('admin.setting.sidebar')
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="email-inbox__area  bg-style">
                        <div class="item-top mb-30"><h2>{{ @$pageTitle }}</h2></div>
                        <form action="{{route('admin.setting.faq.update')}}" method="post">
                            @csrf
                            <div id="add_repeater" class="mb-3">
                                <div data-repeater-list="faqs" class="">
                                    @if($faqs->count() > 0)
                                        @foreach($faqs as $faq)
                                            <div data-repeater-item="" class="form-group row">
                                                <input type="hidden" name="id" value="{{ @$faq['id'] }}"/>
                                                <div class="custom-form-group mb-3 col-lg-5">
                                                    <label for="question_{{ @$faq['id'] }}" class="text-lg-right text-black"> {{ __('Question') }} </label>
                                                    <div class="">
                                                        <input type="text" name="question" id="question_{{ @$faq['id'] }}" value="{{ $faq->question }}"
                                                               class="form-control" placeholder="Type question" required>
                                                    </div>
                                                </div>
                                                <div class="custom-form-group mb-3 col-lg-6">
                                                    <label for="answer_{{ @$faq['id'] }}" class="text-lg-right text-black"> {{ __('Answer') }} </label>
                                                    <div class="">
                                                        <textarea name="answer" id="answer_{{ @$faq['id'] }}" rows="5"
                                                                  class="form-control" required>{{ $faq->answer }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-1 mb-3">
                                                    <label class="text-lg-right text-black opacity-0">{{ __('Remove') }}</label>
                                                    <a href="javascript:;" data-repeater-delete=""
                                                       class="btn btn-icon-remove">
                                                       <img src="{{asset('admin/images/icons/trash-2.svg')}}" alt="trash" class="onlyForProductRules">
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div data-repeater-item="" class="form-group row ">
                                            <div class="custom-form-group mb-3 col-lg-5">
                                                <label for="question" class="text-lg-right text-black">{{ __('Question') }}</label>
                                                <input type="text" name="question" id="question" value="" class="form-control" placeholder="Type question" required>
                                            </div>
                                            <div class="custom-form-group mb-3 col-lg-6">
                                                <label for="answer" class="text-lg-right text-black">{{ __('Answer') }}</label>
                                                <textarea name="answer" id="answer" class="form-control" rows="5" required></textarea>
                                            </div>

                                            <div class="col-lg-1 mb-3 ">
                                                <label class="text-lg-right text-black opacity-0">{{ __('Remove') }}</label>
                                                <a href="javascript:;" data-repeater-delete=""
                                                   class="btn btn-icon-remove">
                                                   <img src="{{asset('admin/images/icons/trash-2.svg')}}" alt="trash" class="onlyForProductRules">
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-lg-2">
                                    <a id="add" href="javascript:;" data-repeater-create=""
                                       class="btn btn-blue">
                                        <i class="fas fa-plus"></i> {{ __('Add') }}
                                    </a>
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-md-2 text-end">
                                    <button type="submit" class="btn btn-blue">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection


@push('style')
    <link rel="stylesheet" href="{{asset('admin/css/custom/image-preview.css')}}">
@endpush

@push('script')
    <script src="{{asset('admin/js/custom/image-preview.js')}}"></script>
    <script src="{{ asset('common/js/jquery.repeater.min.js') }}"></script>
    <script src="{{ asset('common/js/add-repeater.js') }}"></script>
@endpush
