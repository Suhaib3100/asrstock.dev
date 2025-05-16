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
                        <div class="bd-one bd-c-stroke bd-ra-10 bg-white zaiStock-shadow-one py-sm-25 py-15 pb-0">
                            <!--  -->
                            <ul class="following-list">
                                @forelse($followings as $following)
                                    @php
                                        if($following->followingCustomer){
                                            $relation = 'followingCustomer';
                                            $productColumn = 'contributor_products_count';
                                        }else{
                                            $relation = 'followingUser';
                                            $productColumn = 'user_products_count';
                                        }
                                    @endphp
                                    <li class="item d-flex justify-content-between align-items-center {{$loop->last ? 'border-bottom-0' : ''}}">
                                        <div class="left">
                                            <div class="img">
                                                <img src="{{$following->$relation->image}}" alt=""/>
                                            </div>
                                            <div class="content">
                                                <a href="#" class="name">{{$following->$relation->name}}</a>
                                                <p class="info">{{$following->$productColumn}} {{__('Resource')}}</p>
                                            </div>
                                        </div>
                                        <button
                                            onclick="followUnfollow('{{ route('customer.followings.follow_unfollow', ['following_customer_id' => $following->following_customer_id, 'following_user_id' => $following->following_user_id]) }}')"
                                            type="button" class="zaiStock-btn-unfollow">{{__('Unfollow')}}</button>
                                    </li>
                                @empty
                                    <li class="align-items-center border-0 d-flex item justify-content-between">
                                        {{__('No Following Found')}}
                                    </li>
                                @endforelse
                            </ul>

                            <!-- Pagination -->
                            {{ $followings->links('layouts.partial.customer-pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script src="{{ asset('assets/js/follow_unfollow.js') }}"></script>
@endpush
