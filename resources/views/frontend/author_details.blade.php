@extends('layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush
@php
    $productType = getProductType();
@endphp
@section('content')
    <!-- Main content -->
    <section class="admin-section">
        <div class="container">
            <div class="authorProfile-wrap bd-one bd-c-stroke bd-ra-10 zaiStock-shadow-one">
                <!-- Banner -->
                <div class="authorBanner">
                    <img src="{{$author->cover_image}}" alt="{{$author->name}}"/>
                </div>
                <!-- Info -->
                <div class="authorInfo">
                    <div class="left">
                        <div class="img">
                            <img src="{{$author->image}}" alt="{{$author->name}}"/>
                        </div>
                        <h4 class="name">{{$author->name}}</h4>
                    </div>
                    <div class="right">
                        <div class="userDetailsInfo">
                            <p class="text text-primary">{{$author->totalProducts}} {{__('Resource')}}</p>
                            <button class="text" data-bs-toggle="modal"
                                    data-bs-target="#followerModal">{{count($author->followers)}}
                                {{__('Followers')}}
                            </button>
                            @if($type == 1)
                                <button class="text" data-bs-toggle="modal"
                                        data-bs-target="#followingModal">{{count($author->followings)}}
                                    {{__('Following')}}
                                </button>
                            @endif
                        </div>

                        <form class="ajax" data-handler="commonResponseWithPageLoad"
                              action="{{route('customer.followings.follow_unfollow')}}" method="POST">
                            @csrf
                            @if($type == 2)
                                <input type="hidden" name="following_user_id" value="{{$author->id}}">
                                @if ($followings->contains('following_user_id', $author->id))
                                    <button type="submit"
                                            class="zaiStock-btn-follow">{{__('Unfollow')}}</button>
                                @else
                                    <button type="submit"
                                            class="zaiStock-btn-unfollow">{{__('Follow')}}</button>
                                @endif
                            @else
                                <input type="hidden" name="following_customer_id"
                                       value="{{$author->id}}">
                                @if ($followings->contains('following_customer_id', $author->id))
                                    <button type="submit"
                                            class="zaiStock-btn-follow">{{__('Unfollow')}}</button>
                                @else
                                    <button type="submit"
                                            class="zaiStock-btn-unfollow">{{__('Follow')}}</button>
                                @endif
                            @endif
                        </form>
                    </div>
                </div>
                <!-- Tabs -->
                <div class="px-sm-25 px-10">
                    <ul class="nav nav-tabs zTab-reset zTab-three align-self-xl-end" id="myTab" role="tablist">
                        @foreach($productType as $data)
                            <li class="nav-item" role="presentation">
                                <button
                                        data-url="{{route('frontend.product_by_contributor', [$type, $author->id, $data->id])}}"
                                        class="nav-link {{$loop->first ? 'active' : ''}}"
                                        id="product-type{{$data->id}}-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#product-type{{$data->id}}-tab-pane" type="button" role="tab"
                                        aria-controls="product-type{{$data->id}}-tab-pane"
                                        aria-selected="{{$loop->first ? 'true' : 'false'}}">{{$data->name}}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="bd-t-one bd-c-stroke p-sm-25 p-15">
                    <div class="tab-content" id="myTabContent">
                        @foreach($productType as $data)
                            <div class="tab-pane fade {{$loop->first ? 'show active' : ''}}"
                                 id="product-type{{$data->id}}-tab-pane"
                                 role="tabpanel"
                                 aria-labelledby="product-type{{$data->id}}-tab" tabindex="0">
                                <div class="row rg-20 item-parent">

                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Followers Modal -->
    <div class="modal fade" id="followerModal" tabindex="-1" aria-labelledby="followerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 bd-ra-10">
                <div class="d-flex justify-content-between align-items-center g-10 p-sm-25 p-15">
                    <h4 class="fs-sm-24 fs-18 fw-400 lh-34 text-primary-dark-text">{{__('Followers')}}</h4>
                    <button type="button"
                            class="border-0 w-30 h-30 rounded-circle bg-bg-color-2 d-flex justify-content-center align-items-center"
                            data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
                </div>
                <div class="">
                    <ul class="following-list zList-border-none">
                        @foreach($author->followers ?? [] as $follower)
                            <li class="item d-flex justify-content-between align-items-center">
                                <div class="left">
                                    <div class="img">
                                        <img src="{{$follower->customer->image}}" alt=""/>
                                    </div>
                                    <div class="content">
                                        <span class="bg-transparent border-0 name">{{$follower->customer->name}}</span>
                                        @if($follower->customer->contributor_status == CONTRIBUTOR_STATUS_APPROVED)
                                            <p class="info">{{$follower->totalProducts}} {{__('Resource')}}</p>
                                        @endif
                                    </div>
                                </div>

                                <form class="ajax" data-handler="commonResponseWithPageLoad"
                                      action="{{route('customer.followings.follow_unfollow')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="following_customer_id"
                                           value="{{$follower->customer->id}}">
                                    @if ($followings->contains('following_customer_id', $follower->customer->id))
                                        <button type="submit"
                                                class="zaiStock-btn-follow">{{__('Unfollow')}}</button>
                                    @else
                                        <button type="submit"
                                                class="zaiStock-btn-unfollow">{{__('Follow')}}</button>
                                    @endif
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Following Modal -->
    <div class="modal fade" id="followingModal" tabindex="-1" aria-labelledby="followingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 bd-ra-10">
                <div class="d-flex justify-content-between align-items-center g-10 p-sm-25 p-15">
                    <h4 class="fs-sm-24 fs-18 fw-400 lh-34 text-primary-dark-text">{{__('Following')}}</h4>
                    <button type="button"
                            class="border-0 w-30 h-30 rounded-circle bg-bg-color-2 d-flex justify-content-center align-items-center"
                            data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
                </div>
                <div class="">
                    <ul class="following-list zList-border-none">
                        @foreach($author->followings ?? [] as $following)
                            @if($following->followingCustomer)
                                <li class="item d-flex justify-content-between align-items-center">
                                    <div class="left">
                                        <div class="img">
                                            <img src="{{$following->followingCustomer->image}}" alt=""/>
                                        </div>
                                        <div class="content">
                                            <span
                                                    class="bg-transparent border-0 name">{{$following->followingCustomer->name}}</span>
                                            <p class="info">{{$following->totalProducts}} {{__('Resource')}}</p>
                                        </div>
                                    </div>

                                    <form class="ajax" data-handler="commonResponseWithPageLoad"
                                          action="{{route('customer.followings.follow_unfollow')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="following_customer_id"
                                               value="{{$following->followingCustomer->id}}">
                                        @if ($followings->contains('following_customer_id', $following->followingCustomer->id))
                                            <button type="submit"
                                                    class="zaiStock-btn-follow">{{__('Unfollow')}}</button>
                                        @else
                                            <button type="submit"
                                                    class="zaiStock-btn-unfollow">{{__('Follow')}}</button>
                                        @endif
                                    </form>
                                </li>
                            @else
                                <li class="item d-flex justify-content-between align-items-center">
                                    <div class="left">
                                        <div class="img">
                                            <img src="{{$following->followingUser->image}}" alt=""/>
                                        </div>
                                        <div class="content">
                                            <span
                                                    class="bg-transparent border-0 name">{{$following->followingUser->name}}</span>
                                            <p class="info">{{$following->totalProducts}} {{__('Resource')}}</p>
                                        </div>
                                    </div>

                                    <form class="ajax" data-handler="commonResponseWithPageLoad"
                                          action="{{route('customer.followings.follow_unfollow')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="following_customer_id"
                                               value="{{$following->followingUser->id}}">
                                        @if ($followings->contains('following_customer_id', $following->followingUser->id))
                                            <button type="submit"
                                                    class="zaiStock-btn-follow">{{__('Unfollow')}}</button>
                                        @else
                                            <button type="submit"
                                                    class="zaiStock-btn-unfollow">{{__('Follow')}}</button>
                                        @endif
                                    </form>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Board Modal -->
    <div class="modal fade" id="createBoardsModal" tabindex="-1" aria-labelledby="createBoardsModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content border-0 bg-transparent">

            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('assets/js/author_details.js') }}"></script>
@endpush

