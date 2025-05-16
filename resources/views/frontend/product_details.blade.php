@extends('layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush
@section('content')
    <!-- Product download wrap -->
    <section class="pt-20">
        <div class="container">
            <div class="row rg-20">
                <div class="col-lg-8">
                    <div class="productDownload-detailsWrap">
                        <div class="photoDetails-imgBlock">
                            <div class="photo-item-block">
                                @if($product->productType->product_type_category === PRODUCT_TYPE_VIDEO)
                                    <div id="zaiStockVideoContainer" class="videoContainer">
                                        <video id="zaiStockVideo" poster="{{$product->thumbnail_image}}">
                                            <source
                                                src="{{$product->play_link}}"
                                                type="video/mp4"/>
                                        </video>

                                        <div class="control">
                                            <div class="topControl">
                                                <div class="left">
                                                    <a class="play video-play">
                                                        <img src="{{asset('assets/images/icon/video-play.svg')}}"
                                                             alt=""/>
                                                    </a>
                                                    <div class="time">
                                                        <span class="ctime">0:00</span>
                                                        <span class="stime"> / </span>
                                                        <span class="ttime">0:00</span>
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <div class="volume">
                                                        <a class="toggle-sound"><img
                                                                src="{{asset('assets/images/icon/video-sound-on.svg')}}"
                                                                alt=""/></a>
                                                        <div class="volume-slider">
                                                            <div class="drag-line">
                                                                <div class="line"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <a id="airplay" class="video-airplay">
                                                        <img src="{{asset('assets/images/icon/video-sound-on.svg')}}"
                                                             alt=""/>
                                                    </a>

                                                    <a class="fullscreen">
                                                        <img src="{{asset('assets/images/icon/video-full-screen.svg')}}"
                                                             alt=""/>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="progress">
                                                <div class="progress-bar"></div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($product->productType->product_type_category === PRODUCT_TYPE_AUDIO)
                                    <div class="audio-thumb-img imgWrap">
                                        <img src="{{$product->thumbnail_image}}" alt="{{$product->title}}"/>
                                    </div>
                                    <div id="zaiStockAudioContainer" class="audioContainer">
                                        <audio id="zaiStockAudio" src="{{$product->play_link}}"></audio>
                                        <div class="audio-controls">
                                            <div class="topControl">
                                                <div class="left">
                                                    <div class="audio-play">
                                                        <img src="{{asset('assets/images/icon/video-play.svg')}}"
                                                             alt="Play"/>
                                                    </div>
                                                    <div class="time">
                                                        <div class="audio-ctime">00:00</div>
                                                        <span>/</span>
                                                        <div class="audio-ttime">00:00</div>
                                                    </div>
                                                </div>
                                                <div class="right">
                                                    <div class="audio-volume">
                                                        <div class="audio-toggle-sound">
                                                            <img
                                                                src="{{asset('assets/images/icon/video-sound-on.svg')}}"
                                                                alt="Volume"/>
                                                        </div>
                                                        <div class="audio-volume-slider">
                                                            <div class="audio-line"></div>
                                                        </div>
                                                    </div>
                                                    <button id="audio-airplay">
                                                        <img src="{{asset('assets/images/icon/video-sound-on.svg')}}"
                                                             alt="Airplay"/>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="audio-progress">
                                                <div class="audio-progress-bar"></div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="imgWrap">
                                        <img src="{{$product->thumbnail_image}}" alt="{{$product->title}}"/>
                                    </div>
                                @endif
                                <div class="favoriteBoard">
                                    <form class="ajax" action="{{ route('frontend.favourite.product.store') }}"
                                          method="post"
                                          data-handler="commonResponseWithPageLoad">
                                        @csrf
                                        <input type="hidden" value="{{$product->id}}" name="product_id">
                                        @if ($favouriteCheck->contains('product_id', $product->id))
                                            <button type="submit" class="imgActionBtn favoriteBtn active">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M19.4626 3.99415C16.7809 2.34923 14.4404 3.01211 13.0344 4.06801C12.4578 4.50096 12.1696 4.71743 12 4.71743C11.8304 4.71743 11.5422 4.50096 10.9656 4.06801C9.55962 3.01211 7.21909 2.34923 4.53744 3.99415C1.01807 6.15294 0.22172 13.2749 8.33953 19.2834C9.88572 20.4278 10.6588 21 12 21C13.3412 21 14.1143 20.4278 15.6605 19.2834C23.7783 13.2749 22.9819 6.15294 19.4626 3.99415Z"
                                                        fill="#F1F2FF" stroke="#F1F2FF" stroke-width="2.5"
                                                        stroke-linecap="round"/>
                                                </svg>
                                            </button>
                                        @else
                                            <button type="submit" class="imgActionBtn favoriteBtn">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none">
                                                    <path
                                                        d="M19.4626 3.99415C16.7809 2.34923 14.4404 3.01211 13.0344 4.06801C12.4578 4.50096 12.1696 4.71743 12 4.71743C11.8304 4.71743 11.5422 4.50096 10.9656 4.06801C9.55962 3.01211 7.21909 2.34923 4.53744 3.99415C1.01807 6.15294 0.22172 13.2749 8.33953 19.2834C9.88572 20.4278 10.6588 21 12 21C13.3412 21 14.1143 20.4278 15.6605 19.2834C23.7783 13.2749 22.9819 6.15294 19.4626 3.99415Z"
                                                        fill="#F1F2FF" stroke="#F1F2FF" stroke-width="2.5"
                                                        stroke-linecap="round"/>
                                                </svg>
                                            </button>
                                        @endif
                                    </form>
                                    <button class="imgActionBtn boardBtn @if ($boardCheck->contains('product_id', $product->id)) active @endif"
                                            onclick="getEditModal('{{ route('frontend.board.modal',$product->id) }}', '#createBoardsModal')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M4 17.9808V9.70753C4 6.07416 4 4.25748 5.17157 3.12874C6.34315 2 8.22876 2 12 2C15.7712 2 17.6569 2 18.8284 3.12874C20 4.25748 20 6.07416 20 9.70753V17.9808C20 20.2867 20 21.4396 19.2272 21.8523C17.7305 22.6514 14.9232 19.9852 13.59 19.1824C12.8168 18.7168 12.4302 18.484 12 18.484C11.5698 18.484 11.1832 18.7168 10.41 19.1824C9.0768 19.9852 6.26947 22.6514 4.77285 21.8523C4 21.4396 4 20.2867 4 17.9808Z"
                                                fill="#F1F2FF" stroke="#F1F2FF" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <h4 class="title">{{$product->title}}</h4>
                            <p class="info">
                                {!! nl2br($product->description) !!}
                            </p>
                        </div>
                        <div class="item">
                            <h4 class="fs-md-24 fs-18 fw-600 lh-34 text-primary-dark-text pb-21">{{__('Tags')}}</h4>
                            <ul class="d-flex flex-wrap g-9">
                                @foreach($product->productTags as $productTag)
                                    <li>
                                        <a href="{{route('frontend.search-result', ['search_key' => $productTag->tag->name])}}" class="py-3 px-13 d-inline-flex rounded-pill bg-bg-color-2 fs-14 fw-400 lh-24 text-primary-dark-text">{{$productTag->tag->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="item">
                            <!-- Comments -->
                            <h4 class="fs-md-24 fs-18 fw-600 lh-34 text-primary-dark-text pb-18">{{$product->comments->where('status', 1)->count()}} {{__('Comments')}}</h4>
                            <div class="blog-details-commentWrap">
                                <ul class="list">
                                    @forelse($product->comments->where('status', 1) as $comment)
                                        <li class="item">
                                            <div class="left">
                                                <div class="img">
                                                    <img src="{{$comment->customer->image}}"
                                                         alt="{{$comment->customer->name}}"/>
                                                </div>
                                                <div class="content">
                                                    <h4 class="fs-18 fw-400 lh-28 text-primary-dark-text">{{$comment->customer->name}}</h4>
                                                    <p class="fs-14 fw-400 lh-24 text-para-text">{!! nl2br($comment->comment) !!}</p>
                                                </div>
                                            </div>
                                            <div class="right">
                                                <p class="fs-14 fw-400 lh-24 text-para-text pb-5">{{$comment->created_at->diffForHumans()}}</p>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="item">
                                            {{__('No Comment Found')}}
                                        </li>
                                    @endforelse
                                </ul>
                                @auth
                                    <form action="{{route('customer.products.comment', $product->id)}}" class="ajax"
                                          method="POST" data-handler="commonResponseForModal">
                                        @csrf
                                        <div class="inputWrap">
                                            <div class="img">
                                                <img src="{{auth()->user()->image}}" alt=""/>
                                            </div>
                                            <div class="w-100">
                                                <input name="comment" id="productComment" class="zForm-control"
                                                       placeholder="{{__('Add your thoughts...')}}">
                                            </div>
                                        </div>
                                    </form>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="productDownload-sidebar">
                        <div class="productDownload-sidebar-itemWrap">
                            <!-- Count-wrap -->
                            <div class="item productDownload-countWrap">
                                <div class="productCount-item">
                                    <div class="icon">
                                        <div class="img">
                                            <img src="{{asset('assets/images/icon/productCount-view.svg')}}" alt=""/>
                                        </div>
                                        <p class="fs-18 fw-400 lh-28 text-primary-dark-text">{{$product->total_watch}}</p>
                                    </div>
                                    <p class="fs-14 fw-400 lh-24 text-para-text">{{__('Views')}}</p>
                                </div>
                                <div class="productCount-item">
                                    <div class="icon">
                                        <div class="img">
                                            <img src="{{asset('assets/images/icon/productCount-likes.svg')}}" alt=""/>
                                        </div>
                                        <p class="fs-18 fw-400 lh-28 text-primary-dark-text">{{$product->favourite_products_count}}</p>
                                    </div>
                                    <p class="fs-14 fw-400 lh-24 text-para-text">{{__('Likes')}}</p>
                                </div>
                                <div class="productCount-item">
                                    <div class="icon">
                                        <div class="img">
                                            <img src="{{asset('assets/images/icon/productCount-download.svg')}}"
                                                 alt=""/>
                                        </div>
                                        <p class="fs-18 fw-400 lh-28 text-primary-dark-text">{{$product->download_products_count}}</p>
                                    </div>
                                    <p class="fs-14 fw-400 lh-24 text-para-text">{{__('Downloads')}}</p>
                                </div>
                            </div>
                            <!-- Download -->
                            <div class="item productDownload-downloadWrap">
                                @if($product->accessibility == PRODUCT_ACCESSIBILITY_PAID)
                                    <div class="icon">
                                        <img src="{{asset('assets/images/icon/crown.svg')}}" alt=""/>
                                    </div>
                                    <p class="text">{{__('Unlock this file and save on your Premium subscription.')}}</p>
                                    <div class="dropdown photoDownload-dropdown">
                                        <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                            {{__('Download')}}</button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <ul class="list pb-0">
                                                @foreach($product->variations as $variation)
                                                    <li>
                                                        <a href="{{route('customer.product_download', $variation->id)}}"
                                                           class="textContent">
                                                            <span>{{$variation->variation}}</span>
                                                            <span>{{showPrice($variation->price)}}</span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @else
                                    <div class="dropdown photoDownload-dropdown">
                                        <p class="fs-16 fw-400 lh-26 pb-20 text-para-text">{{__('This product is available for free. Click the download button below to get instant access.')}}</p>
                                        <a class="d-block text-center zaiStock-btn"
                                           href="{{route('customer.product_download', $product->variations->first()->id)}}">
                                            {{__('Download')}}</a>
                                    </div>
                                @endif
                            </div>
                            <!-- Share -->
                            <div class="item productDownload-share">
                                <h4 class="title">{{__('Share')}} :</h4>
                                <ul class="list">
                                    <li>
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                           target="_blank">
                                            <img src="{{ asset('assets/images/icon/blog-shareSocial-facebook.svg') }}"
                                                 alt="Share on Facebook"/>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                                           target="_blank">
                                            <img src="{{ asset('assets/images/icon/blog-shareSocial-linkedin.svg') }}"
                                                 alt="Share on LinkedIn"/>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://x.com/intent/tweet?url={{ urlencode(url()->current()) }}"
                                           target="_blank">
                                            <img src="{{ asset('assets/images/icon/blog-shareSocial-twitter.svg') }}"
                                                 alt="Share on X"/>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://pinterest.com/pin/create/button/?url={{ urlencode(url()->current()) }}"
                                           target="_blank">
                                            <img src="{{ asset('assets/images/icon/blog-shareSocial-pinterest.svg') }}"
                                                 alt="Share on Pinterest"/>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            @if($product->accessibility == PRODUCT_ACCESSIBILITY_PAID)
                                <div class="item productDownload-license">
                                    <h4 class="title">{{__('Buy Single License')}} :</h4>
                                    <ul class="list">
                                        @foreach($product->variations as $variation)
                                            <li>
                                                <div class="zForm-wrap-radio">
                                                    <input type="radio"
                                                           {{$loop->first ? 'checked' : ''}} name="buySingleLicense"
                                                           class="form-check-input"
                                                           id="variation-{{$variation->id}}"
                                                           data-variation-id="{{$variation->id}}"
                                                           data-price="{{$variation->price}}"/>
                                                    <label for="variation-{{$variation->id}}">
                                                        <span>{{$variation->variation}}</span>
                                                        <span class="">{{showPrice($variation->price)}}</span>
                                                    </label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <form action="{{route('customer.checkout.page')}}" method="GET">
                                        <input type="hidden" name="type" value="product">
                                        <input type="hidden" name="slug" value="{{$product->slug}}">
                                        <input type="hidden" id="form-variation-id" name="variation"
                                               value="{{$product->variations->first()->id}}">
                                        <button type="submit"
                                                class="zaiStock-btn w-100 d-flex justify-content-center g-5 bg-primary-dark-text bd-c-primary-dark-text">{{__('Buy
                                    Now ')}} <span
                                                id="buySingleLicense">{{showPrice($product->variations->first()->price)}}</span>
                                        </button>
                                    </form>
                                </div>
                            @endif
                            @if($product->content_type == 'image')
                                <div class="item productDownload-color">
                                    <div class="d-flex align-items-center g-11 pb-17">
                                        <div class="d-flex">
                                            <img src="{{asset('assets/images/icon/color-brush.svg')}}" alt=""/>
                                        </div>
                                        <h4 class="title">{{__('Color')}}</h4>
                                    </div>
                                    <ul class="d-flex g-9 flex-wrap">
                                        @foreach($product->colors as $color)
                                            <li>
                                                <a href="{{route('frontend.search-result', ['color' => $color->color_code])}}">
                                                    <div class="w-26 h-26 bd-ra-4"
                                                         style="background-color: #{{$color->color_code}}"></div>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="item productDownload-productDetails">
                                <h4 class="title">{{__('Details')}}:</h4>
                                <ul class="zList-pb-11">
                                    <li>
                                        <div class="row">
                                            <div class="col-5">
                                                <p class="fs-14 fw-400 lh-24 text-primary-dark-text">{{getProductTypeCategory($product->product_type_id)}}</p>
                                            </div>
                                            <div class="col-7">
                                                <p class="fs-14 fw-400 lh-24 text-primary-dark-text text-end">
                                                    #{{$product->id}}</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="col-5">
                                                <p class="fs-14 fw-400 lh-24 text-primary-dark-text">{{__('Published On')}}</p>
                                            </div>
                                            <div class="col-7">
                                                <p class="fs-14 fw-400 lh-24 text-primary-dark-text text-end">{{formatDate($product->created_at)}}</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="col-5">
                                                <p class="fs-14 fw-400 lh-24 text-primary-dark-text">{{__('Product Type')}}</p>
                                            </div>
                                            <div class="col-7">
                                                <p class="fs-14 fw-400 lh-24 text-primary-dark-text text-end">{{$product->file_types}}</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="row">
                                            <div class="col-5">
                                                <p class="fs-14 fw-400 lh-24 text-primary-dark-text">{{__('Category')}}</p>
                                            </div>
                                            <div class="col-7">
                                                <p class="fs-14 fw-400 lh-24 text-primary-dark-text text-end">{{$product->productCategory->name}}</p>
                                            </div>
                                        </div>
                                    </li>

                                    @if($product->accessibility == PRODUCT_ACCESSIBILITY_FREE)
                                        @if($product->use_this_photo)
                                            <li>
                                                <div class="row">
                                                    <div class="col-5">
                                                        <p class="fs-14 fw-400 lh-24 text-primary-dark-text">{{__('License')}}</p>
                                                    </div>
                                                    <div class="col-7">
                                                        <p class="fs-14 fw-400 lh-24 text-primary-dark-text text-end">{{getProductUseOption($product->use_this_photo)}}</p>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                        @if($product->attribution_required)
                                            <li>
                                                <div class="row">
                                                    <div class="col-5">
                                                        <p class="fs-14 fw-400 lh-24 text-primary-dark-text">{{__('Attribution')}}</p>
                                                    </div>
                                                    <div class="col-7">
                                                        <p class="fs-14 fw-400 lh-24 text-primary-dark-text text-end">{{__('Required')}}</p>
                                                    </div>
                                                </div>
                                            </li>
                                        @endif
                                    @endif
                                </ul>
                            </div>
                            <div class="item productDownload-author">
                                <div class="left">
                                    <div class="img">
                                        <img
                                            src="{{ $product->user ? $product->user->image : $product->customer->image }}"
                                            alt=""/>
                                    </div>
                                    <div class="content">
                                        <a href="{{route('frontend.author.profile', ['type' => ($product->user ? 2 : 1), 'user_name' => ($product->user ? $product->user->slug : $product->customer->user_name) ])}}"
                                           class="name">
                                            {{ $product->user ? $product->user->name : $product->customer->name }}
                                        </a>
                                        <p class="info">{{ $product->user ? $product->user->totalProducts : $product->customer->totalProducts }} {{__('Resource')}}</p>
                                    </div>
                                </div>
                                <form class="ajax" data-handler="commonResponseWithPageLoad"
                                      action="{{route('customer.followings.follow_unfollow')}}" method="POST">
                                    @csrf
                                    @if($product->user)
                                        <input type="hidden" name="following_user_id" value="{{$product->user_id}}">
                                        @if ($following->contains('following_user_id', $product->user_id))
                                            <button type="submit"
                                                    class="zaiStock-btn-follow">{{__('Unfollow')}}</button>
                                        @else
                                            <button type="submit"
                                                    class="zaiStock-btn-unfollow">{{__('Follow')}}</button>
                                        @endif
                                    @else
                                        <input type="hidden" name="following_customer_id"
                                               value="{{$product->customer_id}}">
                                        @if ($following->contains('following_customer_id', $product->customer_id))
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
                        <div class="pt-9 pb-30">
                            <button data-bs-toggle="modal" data-bs-target="#reportPhotoModal"
                                    class="bg-transparent border-0 d-inline-flex align-items-center g-8">
                                <div class="d-flex">
                                    <img src="{{asset('assets/images/icon/report-icon.svg')}}" alt=""/>
                                </div>
                                <p class="fs-16 fw-400 lh-26 text-red">{{__('Report Item')}}</p>
                            </button>
                        </div>
                        @if(isAddonInstalled('PIXELDONATION'))
                            @if(getOption('donation_status', false))
                                <div class="productDownload-sidebar-itemWrap">
                                    <div class="item productDownload-donation">
                                        <h4 class="title">{{__('Donation')}}</h4>
                                        <div class="donation-payItem">
                                            <div class="itemBlock active">
                                                <div class="icon">
                                                    <img src="{{asset('assets/images/icon/donation-cake.svg')}}"
                                                         alt=""/>
                                                </div>
                                                <button class="donation-payBtn">1</button>
                                            </div>
                                            <div class="itemBlock">
                                                <div class="icon">
                                                    <img src="{{asset('assets/images/icon/donation-cake.svg')}}"
                                                         alt=""/>
                                                </div>
                                                <button class="donation-payBtn">2</button>
                                            </div>
                                            <div class="itemBlock">
                                                <div class="icon">
                                                    <img src="{{asset('assets/images/icon/donation-cake.svg')}}"
                                                         alt=""/>
                                                </div>
                                                <button class="donation-payBtn">3</button>
                                            </div>
                                            <div class="itemBlock">
                                                <div class="icon">
                                                    <img src="{{asset('assets/images/icon/donation-cake.svg')}}"
                                                         alt=""/>
                                                </div>
                                                <button class="donation-payBtn">4</button>
                                            </div>
                                            <div class="itemBlock">
                                                <div class="icon">
                                                    <img src="{{asset('assets/images/icon/donation-cake.svg')}}"
                                                         alt=""/>
                                                </div>
                                                <button class="donation-payBtn">5</button>
                                            </div>
                                        </div>
                                        <form action="{{route('customer.checkout.page')}}" method="GET">
                                            <input type="hidden" name="type" value="donation">
                                            <input type="hidden" name="slug" value="{{$product->slug}}">
                                            <input type="hidden" name="amount" id="donation-form-price"
                                                   value="{{$donatePrice}}">
                                            <button type="submit" id="donation-payItemBtn"
                                                    class="zaiStock-btn w-100 bg-primary-dark-text bd-c-primary-dark-text">{{__('Donate')}}
                                                <span id="donate-button-price"
                                                      data-donation-price="{{$donatePrice}}">{{showPrice($donatePrice)}}</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--  -->
    <section class="section-gap">
        <div class="container">
            <div class="section-content-wrap text-center">
                <h4 class="title">{{__('You Might Also Like')}}</h4>
            </div>
            <div class="imageGridGallery-three">
                @foreach($relatedProducts as $key => $data)
                    <div class="photo-item item-{{$key + 1}}">
                        <a href="{{route('frontend.product-details', $data->slug)}}" class="imgWrap"><img
                                src="{{ $data->thumbnail_image }}" alt=""/></a>
                        @if($data->accessibility == PRODUCT_ACCESSIBILITY_PAID)
                            <button class="imgActionBtn premiumBtn">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none">
                                    <path
                                        d="M3.51819 10.3058C3.13013 9.23176 2.9361 8.69476 3.01884 8.35065C3.10933 7.97427 3.377 7.68084 3.71913 7.58296C4.03193 7.49346 4.51853 7.70973 5.49173 8.14227C6.35253 8.52486 6.78293 8.71615 7.18732 8.70551C7.63257 8.69379 8.06088 8.51524 8.4016 8.19931C8.71105 7.91237 8.91861 7.45513 9.33373 6.54064L10.2486 4.52525C11.0128 2.84175 11.3949 2 12 2C12.6051 2 12.9872 2.84175 13.7514 4.52525L14.6663 6.54064C15.0814 7.45513 15.289 7.91237 15.5984 8.19931C15.9391 8.51524 16.3674 8.69379 16.8127 8.70551C17.2171 8.71615 17.6475 8.52486 18.5083 8.14227C19.4815 7.70973 19.9681 7.49346 20.2809 7.58296C20.623 7.68084 20.8907 7.97427 20.9812 8.35065C21.0639 8.69476 20.8699 9.23176 20.4818 10.3057L18.8138 14.9222C18.1002 16.897 17.7435 17.8844 16.9968 18.4422C16.2502 19 15.2854 19 13.3558 19H10.6442C8.71459 19 7.74977 19 7.00315 18.4422C6.25654 17.8844 5.89977 16.897 5.18622 14.9222L3.51819 10.3058Z"
                                        fill="#F1F2FF"
                                        stroke="#F1F2FF"
                                        stroke-width="1.5"
                                    />
                                    <path d="M12 14H12.009H12Z" fill="#F1F2FF"/>
                                    <path d="M12 14H12.009" stroke="#1F2224" stroke-width="2" stroke-linecap="round"
                                          stroke-linejoin="round"/>
                                    <path d="M7 22H17H7Z" fill="#F1F2FF"/>
                                    <path d="M7 22H17" stroke="#F1F2FF" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                            </button>
                        @endif
                        <div class="favoriteBoard">
                            <form class="ajax" action="{{ route('frontend.favourite.product.store') }}" method="post"
                                  data-handler="commonResponseWithPageLoad">
                                @csrf
                                <input type="hidden" value="{{$data->id}}" name="product_id">
                                @if ($favouriteCheck->contains('product_id', $data->id))
                                    <button type="submit" class="imgActionBtn favoriteBtn active">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M19.4626 3.99415C16.7809 2.34923 14.4404 3.01211 13.0344 4.06801C12.4578 4.50096 12.1696 4.71743 12 4.71743C11.8304 4.71743 11.5422 4.50096 10.9656 4.06801C9.55962 3.01211 7.21909 2.34923 4.53744 3.99415C1.01807 6.15294 0.22172 13.2749 8.33953 19.2834C9.88572 20.4278 10.6588 21 12 21C13.3412 21 14.1143 20.4278 15.6605 19.2834C23.7783 13.2749 22.9819 6.15294 19.4626 3.99415Z"
                                                fill="#F1F2FF" stroke="#F1F2FF" stroke-width="2.5"
                                                stroke-linecap="round"/>
                                        </svg>
                                    </button>
                                @else
                                    <button type="submit" class="imgActionBtn favoriteBtn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M19.4626 3.99415C16.7809 2.34923 14.4404 3.01211 13.0344 4.06801C12.4578 4.50096 12.1696 4.71743 12 4.71743C11.8304 4.71743 11.5422 4.50096 10.9656 4.06801C9.55962 3.01211 7.21909 2.34923 4.53744 3.99415C1.01807 6.15294 0.22172 13.2749 8.33953 19.2834C9.88572 20.4278 10.6588 21 12 21C13.3412 21 14.1143 20.4278 15.6605 19.2834C23.7783 13.2749 22.9819 6.15294 19.4626 3.99415Z"
                                                fill="#F1F2FF" stroke="#F1F2FF" stroke-width="2.5"
                                                stroke-linecap="round"/>
                                        </svg>
                                    </button>
                                @endif
                            </form>
                            <button class="imgActionBtn boardBtn @if ($boardCheck->contains('product_id', $data->id)) active @endif"
                                    onclick="getEditModal('{{ route('frontend.board.modal',$data->id) }}', '#createBoardsModal')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none">
                                    <path
                                        d="M4 17.9808V9.70753C4 6.07416 4 4.25748 5.17157 3.12874C6.34315 2 8.22876 2 12 2C15.7712 2 17.6569 2 18.8284 3.12874C20 4.25748 20 6.07416 20 9.70753V17.9808C20 20.2867 20 21.4396 19.2272 21.8523C17.7305 22.6514 14.9232 19.9852 13.59 19.1824C12.8168 18.7168 12.4302 18.484 12 18.484C11.5698 18.484 11.1832 18.7168 10.41 19.1824C9.0768 19.9852 6.26947 22.6514 4.77285 21.8523C4 21.4396 4 20.2867 4 17.9808Z"
                                        fill="#F1F2FF" stroke="#F1F2FF" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                        @if($data->productType->product_type_category === PRODUCT_TYPE_AUDIO)
                            <div class="audioVideo-wrap">
                                <div class="imgActionBtn audioVideo">
                                    <img src="{{asset('assets/images/icon/photoItem-audio-icon.svg')}}" alt=""/>
                                </div>
                            </div>
                        @elseif($data->productType->product_type_category === PRODUCT_TYPE_VIDEO)
                            <div class="audioVideo-wrap">
                                <div class="imgActionBtn audioVideo">
                                    <img src="{{asset('assets/images/icon/photoItem-video-icon.svg')}}" alt=""/>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Product Board Modal -->
    <div class="modal fade" id="createBoardsModal" tabindex="-1" aria-labelledby="createBoardsModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content border-0 bg-transparent">

            </div>
        </div>
    </div>

    <div class="modal fade" id="reportPhotoModal" tabindex="-1" aria-labelledby="reportPhotoModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 bd-ra-10">
                <div class="p-sm-25 p-15 reportPhotoModal-content">
                    <div class="pb-10 d-flex justify-content-between">
                        <h5>{{__('Report This Item')}}</h5>
                        <button type="button"
                                class="w-30 h-30 bg-bg-color-2 border-0 rounded-circle d-flex justify-content-center align-items-center"
                                data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
                    </div>
                    <form action="{{route('customer.products.report', $product->id)}}" class="ajax" method="POST"
                          data-handler="commonResponseForModal">
                        @csrf
                        <div class="row rg-25">
                            <div class="col-lg-12">
                                <label for="reason" class="zForm-label">{{__('Reason to report this item')}} <span
                                        class="text-primary">*</span></label>
                                <select name="reason" id="reason" class="sf-select-without-search">
                                    <option value="">{{__('Select Reason')}}</option>
                                    @foreach($reportedCategories as $category)
                                        <option value="{{$category->name}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-12">
                                <button type="submit" class="zaiStock-btn">{{__('Report')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('assets/js/product_details.js') }}"></script>
    <script>
        $(document).on("DOMContentLoaded", function () {
            const videoElement = $("#zaiStockVideo");

            if (videoElement.length) {
                const videoContainer = $("#zaiStockVideoContainer");
                const playButton = $(".play");
                const progressBar = $(".progress-bar");
                const progressContainer = $(".progress");
                const fullscreenButton = $(".fullscreen img");
                const volumeToggleButton = $(".toggle-sound");
                const volumeSlider = $(".volume-slider");
                const volumeLine = $(".volume-slider .line");
                const airplayButton = $("#airplay");
                let controlVisibilityTimer;
                let savedVolumeLevel;

                setVideoVolume(0.8);

                $(document).on("keyup", function (event) {
                    if (event.keyCode === 32) {
                        const isFullscreen = document.fullscreenElement;
                        const isHovered =
                            videoElement.data("isHovered") === true;

                        if (isFullscreen || isHovered) {
                            togglePlayPause();
                            displayControlsForDuration(3000);
                        }
                    }
                });

                $(document).on(
                    "click",
                    "#zaiStockVideo, .play img",
                    togglePlayPause
                );

                function togglePlayPause() {
                    if (videoElement[0].paused) {
                        videoElement[0].play();
                        playButton
                            .find("img")
                            .attr(
                                "src",
                                "assets/images/icon/video-pause.svg"
                            );
                    } else {
                        videoElement[0].pause();
                        playButton
                            .find("img")
                            .attr(
                                "src",
                                "assets/images/icon/video-play.svg"
                            );
                    }
                }

                videoContainer
                    .on("mouseenter", showControls)
                    .on("mouseleave", hideControls)
                    .on("mousemove", function () {
                        displayControlsForDuration(3000);
                    });

                function displayControlsForDuration(milliseconds) {
                    clearTimeout(controlVisibilityTimer);
                    showControls();
                    videoContainer.css("cursor", "auto");
                    controlVisibilityTimer = setTimeout(function () {
                        hideControls();
                        videoContainer.css("cursor", "none");
                    }, milliseconds);
                }

                function showControls() {
                    $(".control").css("display", "flex");
                }

                function hideControls() {
                    $(".control").css("display", "none");
                }

                fullscreenButton.on("click", toggleFullscreen);

                function toggleFullscreen() {
                    const isFullscreen = document.fullscreenElement;
                    if (isFullscreen) {
                        fullscreenButton.attr(
                            "src",
                            "assets/images/icon/video-full-screen.svg"
                        );
                        document.exitFullscreen();
                    } else {
                        fullscreenButton.attr(
                            "src",
                            "assets/images/icon/video-full-screen-exit.svg"
                        );
                        videoContainer[0].requestFullscreen();
                    }
                }

                setInterval(function () {
                    $(".ctime").text(
                        formatTime(
                            Math.round(videoElement[0].currentTime)
                        )
                    );
                    $(".ttime").text(
                        formatTime(
                            videoElement[0].duration -
                            Math.round(videoElement[0].currentTime)
                        )
                    );
                }, 500);

                function formatTime(seconds) {
                    if (isNaN(seconds) || seconds < 0) return "00:00";

                    let minutes = Math.floor(seconds / 60);
                    let secs = Math.floor(seconds % 60);

                    return (
                        String(minutes).padStart(2, "0") +
                        ":" +
                        String(secs).padStart(2, "0")
                    );
                }

                videoElement.on("timeupdate", updateProgressBar);
                progressContainer.on("mousedown", handleProgressScrub);

                function updateProgressBar() {
                    let percentComplete =
                        videoElement[0].currentTime /
                        videoElement[0].duration;
                    progressBar.css(
                        "width",
                        percentComplete * 100 + "%"
                    );
                }

                function handleProgressScrub(event) {
                    let x =
                        event.pageX - progressContainer.offset().left;
                    let percentComplete = x / progressContainer.width();
                    progressBar.css(
                        "width",
                        percentComplete * 100 + "%"
                    );
                    videoElement[0].currentTime =
                        percentComplete * videoElement[0].duration;
                }

                volumeToggleButton.on("click", function () {
                    if (videoElement[0].muted) {
                        videoElement[0].muted = false;
                        setVideoVolume(savedVolumeLevel);
                    } else {
                        videoElement[0].muted = true;
                        savedVolumeLevel = videoElement[0].volume;
                        setVideoVolume(0);
                    }
                });

                volumeSlider.on("mousedown", function (event) {
                    $(document).on("mousemove", updateVolume);
                    $(document).on("mouseup", function () {
                        $(document).off("mousemove", updateVolume);
                    });
                    updateVolume(event);
                });

                function updateVolume(event) {
                    let sliderBounds =
                        volumeSlider[0].getBoundingClientRect();
                    let mouseYRelativeToSlider =
                        sliderBounds.bottom - event.clientY;
                    let volume =
                        Math.min(
                            Math.max(mouseYRelativeToSlider, 0),
                            sliderBounds.height
                        ) / sliderBounds.height;
                    if (isFinite(volume)) {
                        videoElement[0].volume = volume;
                        volumeLine.css("height", volume * 100 + "%");
                        setVolumeIcon(volume);
                    }
                }

                function setVolumeIcon(volume) {
                    let volumeClass =
                        volume >= 0.8
                            ? "video-volume-high"
                            : volume >= 0.4
                                ? "video-volume-medium"
                                : volume > 0
                                    ? "video-volume-low"
                                    : "video-volume-muted";
                    volumeToggleButton.attr(
                        "class",
                        `toggle-sound ${volumeClass}`
                    );
                    let volumeIcon =
                        volume > 0
                            ? "video-sound-on.svg"
                            : "video-sound-off.svg";
                    volumeToggleButton.html(
                        `<img src="assets/images/icon/${volumeIcon}" alt="Volume" />`
                    );
                }

                function setVideoVolume(volume) {
                    if (isFinite(volume)) {
                        videoElement[0].volume = volume;
                        volumeLine.css("height", volume * 100 + "%");
                        setVolumeIcon(volume);
                    }
                }

                if (window.WebKitPlaybackTargetAvailabilityEvent) {
                    airplayButton.on("click", function () {
                        videoElement[0].webkitShowPlaybackTargetPicker();
                    });
                } else {
                    airplayButton.hide();
                }
            }

            const audioElement = $("#zaiStockAudio");
            if (audioElement.length) {
                const audioContainer = $("#zaiStockAudioContainer");
                const playButton = $(".audio-play");
                const progressBar = $(".audio-progress-bar");
                const progressContainer = $(".audio-progress");
                const volumeToggleButton = $(".audio-toggle-sound");
                const volumeSlider = $(".audio-volume-slider");
                const volumeLine = $(
                    ".audio-volume-slider .audio-line"
                );
                const airplayButton = $("#audio-airplay");
                let controlVisibilityTimer;
                let savedVolumeLevel;

                setAudioVolume(0.8);

                $(audioElement)
                    .on("mouseenter", function () {
                        $(this).data("isHovered", true);
                    })
                    .on("mouseleave", function () {
                        $(this).data("isHovered", false);
                    });

                $(document).on("keyup", function (event) {
                    if (
                        event.keyCode === 32 &&
                        $(audioElement).data("isHovered")
                    ) {
                        togglePlayPause();
                        displayControlsForDuration(3000);
                    }
                });

                $(document).on(
                    "click",
                    "#zaiStockAudio, .audio-thumb-img img, .audio-play img",
                    togglePlayPause
                );

                function togglePlayPause() {
                    if (audioElement[0].paused) {
                        audioElement[0].play();
                        playButton
                            .find("img")
                            .attr(
                                "src",
                                "assets/images/icon/video-pause.svg"
                            );
                    } else {
                        audioElement[0].pause();
                        playButton
                            .find("img")
                            .attr(
                                "src",
                                "assets/images/icon/video-play.svg"
                            );
                    }
                }

                audioContainer
                    .on("mouseenter", showControls)
                    .on("mouseleave", hideControls)
                    .on("mousemove", function () {
                        displayControlsForDuration(3000);
                    });

                function displayControlsForDuration(milliseconds) {
                    clearTimeout(controlVisibilityTimer);
                    showControls();
                    audioContainer.css("cursor", "auto");
                    controlVisibilityTimer = setTimeout(function () {
                        hideControls();
                        audioContainer.css("cursor", "none");
                    }, milliseconds);
                }

                function showControls() {
                    $(".audio-controls").css("display", "flex");
                }

                function hideControls() {
                    $(".audio-controls").css("display", "flex");
                }

                setInterval(function () {
                    $(".audio-ctime").text(
                        formatTime(
                            Math.round(audioElement[0].currentTime)
                        )
                    );
                    $(".audio-ttime").text(
                        formatTime(
                            audioElement[0].duration -
                            Math.round(audioElement[0].currentTime)
                        )
                    );
                }, 500);

                function formatTime(seconds) {
                    let minutes = Math.floor(seconds / 60);
                    let formattedMinutes =
                        minutes >= 10 ? minutes : "0" + minutes;
                    seconds = Math.floor(seconds % 60);
                    let formattedSeconds =
                        seconds >= 10 ? seconds : "0" + seconds;
                    return `${formattedMinutes}:${formattedSeconds}`;
                }

                $(audioElement).on("timeupdate", updateProgressBar);
                $(document).on(
                    "mousedown",
                    ".audio-progress",
                    handleProgressScrub
                );

                function updateProgressBar() {
                    const percentComplete =
                        audioElement[0].currentTime /
                        audioElement[0].duration;
                    updateProgressBarWidth(percentComplete);
                }

                function handleProgressScrub(event) {
                    const x =
                        event.pageX - progressContainer.offset().left;
                    const percentComplete =
                        x / progressContainer.width();
                    updateProgressBarWidth(percentComplete);
                    updateAudioTime(percentComplete);
                }

                function updateProgressBarWidth(percentComplete) {
                    progressBar.css(
                        "width",
                        percentComplete * 100 + "%"
                    );
                }

                function updateAudioTime(percentComplete) {
                    audioElement[0].currentTime =
                        percentComplete * audioElement[0].duration;
                }

                $(document).on(
                    "click",
                    ".audio-toggle-sound",
                    function () {
                        if (audioElement[0].muted) {
                            audioElement[0].muted = false;
                            setAudioVolume(savedVolumeLevel);
                        } else {
                            audioElement[0].muted = true;
                            savedVolumeLevel = audioElement[0].volume;
                            setAudioVolume(0);
                        }
                    }
                );

                $(document).on(
                    "mousedown",
                    ".audio-volume-slider",
                    function (event) {
                        $(document)
                            .on("mousemove", updateVolume)
                            .on("mouseup", function () {
                                $(document).off(
                                    "mousemove",
                                    updateVolume
                                );
                            });
                        updateVolume(event);
                    }
                );

                function updateVolume(event) {
                    const sliderBounds =
                        volumeSlider[0].getBoundingClientRect();
                    const mouseYRelativeToSlider =
                        sliderBounds.bottom - event.clientY;
                    const sliderPosition = Math.min(
                        Math.max(mouseYRelativeToSlider, 0),
                        sliderBounds.height
                    );
                    const volume = sliderPosition / sliderBounds.height;

                    if (isFinite(volume)) {
                        audioElement[0].volume = volume;
                        volumeLine.css("height", `${volume * 100}%`);
                        setVolumeIcon(volume);
                    }
                }

                function setVolumeIcon(volume) {
                    let iconHtml;
                    if (volume >= 0.8) {
                        volumeToggleButton.attr(
                            "class",
                            "audio-toggle-sound audio-volume-high"
                        );
                        iconHtml =
                            '<img src="assets/images/icon/video-sound-on.svg" alt="Volume Up" />';
                    } else if (volume >= 0.4) {
                        volumeToggleButton.attr(
                            "class",
                            "audio-toggle-sound audio-volume-medium"
                        );
                        iconHtml =
                            '<img src="assets/images/icon/video-sound-on.svg" alt="Volume Up" />';
                    } else if (volume > 0) {
                        volumeToggleButton.attr(
                            "class",
                            "audio-toggle-sound audio-volume-low"
                        );
                        iconHtml =
                            '<img src="assets/images/icon/video-sound-on.svg" alt="Volume Up" />';
                    } else {
                        volumeToggleButton.attr(
                            "class",
                            "audio-toggle-sound audio-volume-muted"
                        );
                        iconHtml =
                            '<img src="assets/images/icon/video-sound-off.svg" alt="Volume Up" />';
                    }
                    volumeToggleButton.html(iconHtml);
                }

                function setAudioVolume(volume) {
                    if (isFinite(volume)) {
                        audioElement[0].volume = volume;
                        volumeLine.css("height", `${volume * 100}%`);
                        setVolumeIcon(volume);
                    }
                }

                if (window.WebKitPlaybackTargetAvailabilityEvent) {
                    airplayButton.on("click", function () {
                        audioElement[0].webkitShowPlaybackTargetPicker();
                    });
                } else {
                    airplayButton.hide();
                }
            }
        });
    </script>
@endpush
