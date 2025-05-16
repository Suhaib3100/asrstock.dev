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
                            <div class="pb-24 mb-24 bd-b-one bd-c-stroke d-flex align-items-center justify-content-between">
                                <p class="fs-20 fw-500 lh-30 text-primary-dark-text">{{$board->name}}</p>
                                <a href="{{route('customer.boards.index')}}" class="zaiStock-btn-black">{{__('Back to Board')}}</a>
                            </div>
                            <div class="row rg-20">
                                @forelse($board->boardProducts ?? [] as $boardProduct)
                                    <div class="col-lg-4 col-md-6">
                                        <a href="#" class="zaiStock-linkBlock">
                                            <div class="img"><img src="{{ $boardProduct->product->thumbnail_image }}" alt="" /></div>
                                            <div class="align-items-center d-flex justify-content-between variationFields ">
                                                <div class="d-flex flex-column">
                                                    <h4 class="title">{{ $boardProduct->product->title }}</h4>
                                                    <p class="info">{{formatDate($boardProduct->created_at, 'd M Y')}}</p>
                                                </div>
                                                <button class="right" onclick="deleteItem('{{ route('customer.boards.product_delete', $boardProduct->id) }}')">
                                                    <img src="{{asset('assets/images/icon/variationFields-delete.svg')}}" alt="" />
                                                </button>
                                            </div>
                                        </a>
                                    </div>
                                @empty
                                    <div class="col-lg-4 col-md-6">
                                    {{__('No Item Found')}}
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
