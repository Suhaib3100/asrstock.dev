@extends('layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush
@section('content')
    <!-- Ideal Photo -->
    <section class="section-gap section-large-wrap section-idealPhoto">
        <div class="container">
            <div class="section-content-wrap">
                <h4 class="title">{{__('The Ideal Photo for Every Need')}}</h4>
                <p class="info">{{__('Find the perfect photo to match your vision, no matter the project or purpose')}}</p>
            </div>
            <div class="row rg-20">
                @foreach($productCategory as $data)
                    <div class="col-xxl-3 col-lg-4 col-md-6">
                        <a href="{{route('frontend.search-result', ['asset_type' => $productType->uuid, 'category' => [$data->slug]])}}" class="zaiStock-linkBlock">
                            <div class="img"><img src="{{ $data->product->thumbnail_image }}" alt=""/></div>
                            <h4 class="title">{{ $data->name }}</h4>
                            <p class="info">{{$data->products_count}} {{__('Resource')}}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Premium Resources -->
    <section class="section-gap bg-primary-light section-large-wrap">
        <div class="container">
            <div class="pb-md-60 pb-30">
                <div class="row rg-20 align-items-lg-end">
                    <div class="col-xl-6 col-lg-8">
                        <div class="section-content-wrap pb-0">
                            <div class="icon mb-20"><img src="{{ asset('assets/images/icon/crown.svg') }}" alt=""/>
                            </div>
                            <h4 class="title">{{__('Premium Resources')}}</h4>
                            <h4 class="info">{{__('Find the perfect photo to match your vision, no matter the project or purpose')}}</h4>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-4">
                        <div class="d-flex justify-content-lg-end">
                            <a href="{{route('frontend.search-result', ['asset_type' => $productType->uuid])}}"
                               class="fs-14 fw-600 lh-20 text-primary hover-underline">{{__('Show More')}}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="imageGridGallery">
                @foreach($premiumResources as $key => $data)
                    <div class="photo-item item-{{$key + 1}}">
                        <a href="{{route('frontend.product-details', $data->slug)}}" class="imgWrap"><img src="{{ $data->thumbnail_image }}" alt=""/></a>
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
                                    <img src="{{asset('assets/images/icon/photoItem-audio-icon.svg')}}" alt="" />
                                </div>
                            </div>
                        @elseif($data->productType->product_type_category === PRODUCT_TYPE_VIDEO)
                            <div class="audioVideo-wrap">
                                <div class="imgActionBtn audioVideo">
                                    <img src="{{asset('assets/images/icon/photoItem-video-icon.svg')}}" alt="" />
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Free Resources -->
    <section class="section-gap section-large-wrap">
        <div class="container">
            <div class="pb-md-60 pb-30">
                <div class="row rg-20 align-items-lg-end">
                    <div class="col-xl-6 col-lg-8">
                        <div class="section-content-wrap pb-0">
                            <h4 class="title">{{__('Free Resources')}}</h4>
                            <p class="info">{{__('Find the perfect photo to match your vision, no matter the project or purpose')}}</p>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-4">
                        <div class="d-flex justify-content-lg-end">
                            <a href="{{route('frontend.search-result', ['asset_type' => $productType->uuid])}}" class="fs-14 fw-600 lh-20 text-primary hover-underline">{{__('Show
                                More')}}</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="imageGridGallery-two">
                @foreach($freeResources as $key => $data)
                    <div class="photo-item item-{{ $key + 1 }}">
                        <a href="{{route('frontend.product-details', $data->slug)}}" class="imgWrap"><img src="{{ $data->thumbnail_image }}" alt=""/></a>
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
                                    <img src="{{asset('assets/images/icon/photoItem-audio-icon.svg')}}" alt="" />
                                </div>
                            </div>
                        @elseif($data->productType->product_type_category === PRODUCT_TYPE_VIDEO)
                            <div class="audioVideo-wrap">
                                <div class="imgActionBtn audioVideo">
                                    <img src="{{asset('assets/images/icon/photoItem-video-icon.svg')}}" alt="" />
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Latest Articles -->
    @if(getOption('blog_section') == ACTIVE)
        <section class="section-gap-bottom">
            <div class="container">
                <div class="section-content-wrap text-center">
                    <h4 class="title">{{ getOption('blog_title') }}</h4>
                    <p class="info">{{ getOption('blog_subtitle') }}</p>
                </div>
                <div class="row rg-20">
                    @foreach($blogsData as $data)
                        <div class="col-lg-4 col-md-6">
                            <div class="blog-item">
                                <div class="img"><img src="{{ $data->image }}" alt=""/></div>
                                <div class="content">
                                    <div class="categoryDate">
                                        <a href="{{ route('frontend.blogs.details',$data->slug) }}"
                                           class="catLink">{{ $data->category->name }}</a>
                                        <p class="date">
                                            <span
                                                class="text-primary">/</span> {{ formatDate($data->created_at, 'd M Y') }}
                                        </p>
                                    </div>
                                    <a href="{{ route('frontend.blogs.details',$data->slug) }}"
                                       class="title">{{ $data->title }}</a>
                                    <a href="{{ route('frontend.blogs.details',$data->slug) }}"
                                       class="link">{{__('Read More')}}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Product Board Modal -->
    <div class="modal fade" id="createBoardsModal" tabindex="-1" aria-labelledby="createBoardsModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content border-0 bg-transparent">

            </div>
        </div>
    </div>
@endsection
