@extends('layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush
@section('content')
    @if(getOption('google_adsense_enable'))
        <!-- Sponsored Images -->
        <section class="home-sponsor-section home-sponsor-overlayNone">
            <div class="container-fluid">
                <div class="m-auto p-0 position-relative text-center">
                    <ins class="adsbygoogle"
                         style="display:block;"
                         data-ad-client="{{getOption('google_adsense_client_id')}}"
                         data-ad-format="auto"
                         data-full-width-responsive="true"></ins>
                    <script>
                        (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                </div>
            </div>
        </section>
        <!-- Sponsored Images -->
    @endif

    <!-- Result -->
    <section class="section-gap-bottom pt-md-30 pt-20">
        <div class="container-fluid">
            <div class="searchResult-content">
                <div class="row rg-20">
                    <div class="col-xl-3 col-lg-4">
                        <div class="searchResult-filter-wrap">
                            <button class="searchResult-filter-wrap-btn" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#searchResult-filterWrap" aria-expanded="true"
                                    aria-controls="searchResult-filterWrap">
                                <p class="text">{{__('Filter')}}</p>
                                <div class="icon">
                                    <img src="{{asset('assets/images/icon/filter-horizontal-icon.svg')}}" alt=""/>
                                </div>
                            </button>
                            <div class="collapse show" id="searchResult-filterWrap">
                                <form id="filter-form" action="{{route('frontend.search-result')}}" method="GET">
                                    <input type="hidden" name="search_key" value="{{ request('search_key') }}">
                                    <input type="hidden" name="sort_by" value="{{ request('sort_by') }}">
                                    <div class="searchResult-filter-wrap-content">
                                        <div class="searchResult-filter-content">
                                            <!-- Assets Type -->
                                            <div class="item">
                                                <button
                                                    class="leftSidebar-btn {{request()->get('asset_type') ? '' : 'collapsed'}}"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#searchResult-item-one"
                                                    aria-expanded="{{request()->get('asset_type') ? 'true' : 'false'}}"
                                                    aria-controls="searchResult-item-one">
                                                    <div class="left">
                                                        <div class="iconImage"><img
                                                                src="{{asset('assets/images/icon/filterSearch-assetsType.svg')}}"
                                                                alt=""/></div>
                                                        <p class="text">{{__('Assets Type')}}</p>
                                                    </div>
                                                    <div class="icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="6"
                                                             viewBox="0 0 8 6" fill="none">
                                                            <path
                                                                d="M4.79261 5.26867C4.39625 5.85712 3.53019 5.85712 3.13382 5.26867L0.971639 2.05866C0.524231 1.39443 1.00018 0.499999 1.80103 0.499999L6.1254 0.5C6.92625 0.5 7.4022 1.39443 6.95479 2.05866L4.79261 5.26867Z"
                                                                fill="#1F2224"/>
                                                        </svg>
                                                    </div>
                                                </button>
                                                <div class="collapse {{request()->get('asset_type') ? 'show' : ''}}"
                                                     id="searchResult-item-one">
                                                    <div class="leftSidebar-content">
                                                        <div class="d-flex flex-wrap g-9">
                                                            <div class="filter-check-item">
                                                                <input type="radio" name="asset_type"
                                                                       value="all"
                                                                       id="asset-type-all" {{(request()->get('asset_type') == 'all') ? 'checked' : ''}}/>
                                                                <label for="asset-type-all">
                                                                    <div class="iconWrap">
                                                                        <img
                                                                            src="{{asset('assets/images/icon/filter-check.svg')}}"
                                                                            alt=""/>
                                                                    </div>
                                                                    <span>{{__('All')}}</span>
                                                                </label>
                                                            </div>
                                                            @foreach(getProductType() as $assetType)
                                                                <div class="filter-check-item">
                                                                    <input type="radio" name="asset_type"
                                                                           value="{{$assetType->uuid}}"
                                                                           id="asset-type-{{$assetType->id}}" {{(request()->get('asset_type') == $assetType->uuid) ? 'checked' : ''}}/>
                                                                    <label for="asset-type-{{$assetType->id}}">
                                                                        <div class="iconWrap">
                                                                            <img
                                                                                src="{{asset('assets/images/icon/filter-check.svg')}}"
                                                                                alt=""/>
                                                                        </div>
                                                                        <span>{{$assetType->name}}</span>
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- License -->
                                            <div class="item">
                                                <button
                                                    class="leftSidebar-btn {{request()->get('license') ? '' : 'collapsed'}}"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#searchResult-item-two"
                                                    aria-expanded="{{request()->get('license') ? 'false' : 'true'}}"
                                                    aria-controls="searchResult-item-two">
                                                    <div class="left">
                                                        <div class="iconImage">
                                                            <img
                                                                src="{{asset('assets/images/icon/filterSearch-license.svg')}}"
                                                                alt=""/>
                                                        </div>
                                                        <p class="text">{{__('License')}}</p>
                                                    </div>
                                                    <div class="icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="6"
                                                             viewBox="0 0 8 6" fill="none">
                                                            <path
                                                                d="M4.79261 5.26867C4.39625 5.85712 3.53019 5.85712 3.13382 5.26867L0.971639 2.05866C0.524231 1.39443 1.00018 0.499999 1.80103 0.499999L6.1254 0.5C6.92625 0.5 7.4022 1.39443 6.95479 2.05866L4.79261 5.26867Z"
                                                                fill="#1F2224"/>
                                                        </svg>
                                                    </div>
                                                </button>
                                                <div class="collapse {{request()->get('license') ? 'show' : ''}}"
                                                     id="searchResult-item-two">
                                                    <div class="leftSidebar-content">
                                                        <div class="d-flex flex-wrap g-9">
                                                            <div class="filter-check-item">
                                                                <input type="radio" name="license"
                                                                       {{(request()->get('license') == 'all')? 'checked' : ''}}
                                                                       value="all"
                                                                       id="all"/>
                                                                <label for="all">
                                                                    <div class="iconWrap"><img
                                                                            src="{{asset('assets/images/icon/filter-check.svg')}}"
                                                                            alt=""/></div>
                                                                    <span>{{__('All')}}</span>
                                                                </label>
                                                            </div>
                                                            <div class="filter-check-item">
                                                                <input type="radio" name="license"
                                                                       {{(request()->get('license') == PRODUCT_ACCESSIBILITY_FREE)? 'checked' : ''}}
                                                                       value="{{PRODUCT_ACCESSIBILITY_FREE}}"
                                                                       id="freeImage"/>
                                                                <label for="freeImage">
                                                                    <div class="iconWrap"><img
                                                                            src="{{asset('assets/images/icon/filter-check.svg')}}"
                                                                            alt=""/></div>
                                                                    <span>{{__('Free')}}</span>
                                                                </label>
                                                            </div>
                                                            <div class="filter-check-item">
                                                                <input type="radio" name="license"
                                                                       {{(request()->get('license') == PRODUCT_ACCESSIBILITY_PAID)? 'checked' : ''}}
                                                                       value="{{PRODUCT_ACCESSIBILITY_PAID}}"
                                                                       id="premiumImage"/>
                                                                <label for="premiumImage">
                                                                    <div class="iconWrap"><img
                                                                            src="{{asset('assets/images/icon/filter-check.svg')}}"
                                                                            alt=""/></div>
                                                                    <span>{{__('Premium')}}</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- File Types -->
                                            <div class="item">
                                                <button
                                                    class="leftSidebar-btn {{request()->get('file_type') ? '' : 'collapsed'}}"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#searchResult-item-four"
                                                    aria-expanded="{{request()->get('file_type') ? 'true' : 'false'}}"
                                                    aria-controls="searchResult-item-four">
                                                    <div class="left">
                                                        <div class="iconImage"><img
                                                                src="{{asset('assets/images/icon/filterSearch-orientation.svg')}}"
                                                                alt=""/></div>
                                                        <p class="text">{{__('File Types')}}</p>
                                                    </div>
                                                    <div class="icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="6"
                                                             viewBox="0 0 8 6" fill="none">
                                                            <path
                                                                d="M4.79261 5.26867C4.39625 5.85712 3.53019 5.85712 3.13382 5.26867L0.971639 2.05866C0.524231 1.39443 1.00018 0.499999 1.80103 0.499999L6.1254 0.5C6.92625 0.5 7.4022 1.39443 6.95479 2.05866L4.79261 5.26867Z"
                                                                fill="#1F2224"/>
                                                        </svg>
                                                    </div>
                                                </button>
                                                <div class="collapse {{request()->get('file_type') ? 'show' : ''}}"
                                                     id="searchResult-item-four">
                                                    <div class="leftSidebar-content">
                                                        <div class="d-flex flex-wrap g-9">
                                                            <div class="filter-check-item">
                                                                <input type="radio" value="all"
                                                                       name="file_type"
                                                                       id="file-type-all" {{request()->get('file_type') == 'all' ? 'checked' : ''}} />
                                                                <label for="file-type-all">
                                                                    <div class="iconWrap"><img
                                                                            src="{{asset('assets/images/icon/filter-check.svg')}}"
                                                                            alt=""/></div>
                                                                    <span>{{__('All')}}</span>
                                                                </label>
                                                            </div>
                                                            @foreach($fileTypes as $fileType)
                                                                <div class="filter-check-item">
                                                                    <input type="radio" value="{{$fileType->name}}"
                                                                           name="file_type"
                                                                           id="file-type-{{$fileType->id}}" {{request()->get('file_type') == $fileType->name ? 'checked' : ''}} />
                                                                    <label for="file-type-{{$fileType->id}}">
                                                                        <div class="iconWrap"><img
                                                                                src="{{asset('assets/images/icon/filter-check.svg')}}"
                                                                                alt=""/></div>
                                                                        <span>{{$fileType->title}}</span>
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Category -->
                                            @if(count($productCategories))
                                                <div class="item">
                                                    <button
                                                        class="leftSidebar-btn {{(request()->get('category') && !empty(request()->get('category') ?? [])) ? '' : 'collapsed'}}"
                                                        type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#searchResult-item-category"
                                                        aria-expanded="{{(request()->get('category') && !empty(request()->get('category') ?? [])) ? 'true' : 'false'}}"
                                                        aria-controls="searchResult-item-category">
                                                        <div class="left">
                                                            <div class="iconImage"><img
                                                                    src="{{asset('assets/images/icon/filterSearch-category.svg')}}"
                                                                    alt=""/></div>
                                                            <p class="text">{{__('Category')}}</p>
                                                        </div>
                                                        <div class="icon">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="6"
                                                                 viewBox="0 0 8 6" fill="none">
                                                                <path
                                                                    d="M4.79261 5.26867C4.39625 5.85712 3.53019 5.85712 3.13382 5.26867L0.971639 2.05866C0.524231 1.39443 1.00018 0.499999 1.80103 0.499999L6.1254 0.5C6.92625 0.5 7.4022 1.39443 6.95479 2.05866L4.79261 5.26867Z"
                                                                    fill="#1F2224"/>
                                                            </svg>
                                                        </div>
                                                    </button>
                                                    <div
                                                        class="collapse {{(request()->get('category') && !empty(request()->get('category') ?? [])) ? 'show' : ''}}"
                                                        id="searchResult-item-category">
                                                        <div class="leftSidebar-content">
                                                            <div class="d-flex flex-wrap g-9">
                                                                @foreach($productCategories as $category)
                                                                    <div class="filter-check-item">
                                                                        <input type="checkbox" name="category[]"
                                                                               id="category-{{$category->slug}}"
                                                                               value="{{$category->slug}}" {{in_array($category->slug, request()->get('category') ?? []) ? 'checked' : ''}}/>
                                                                        <label for="category-{{$category->slug}}">
                                                                            <div class="iconWrap">
                                                                                <img
                                                                                    src="{{asset('assets/images/icon/filter-check.svg')}}"
                                                                                    alt=""/></div>
                                                                            <span>{{$category->name}}</span>
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- editor choice -->
                                            <div class="item">
                                                <button
                                                    class="leftSidebar-btn {{request()->get('choice') ? '' : 'collapsed'}}"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#searchResult-editor-choice"
                                                    aria-expanded="{{request()->get('choice') ? 'true' : 'false'}}"
                                                    aria-controls="searchResult-editor-choice">
                                                    <div class="left">
                                                        <div class="iconImage"><img
                                                                src="{{asset('assets/images/icon/choice.svg')}}"
                                                                alt=""/></div>
                                                        <p class="text">{{__('Editor\'s Choice')}}</p>
                                                    </div>
                                                    <div class="icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="6"
                                                             viewBox="0 0 8 6" fill="none">
                                                            <path
                                                                d="M4.79261 5.26867C4.39625 5.85712 3.53019 5.85712 3.13382 5.26867L0.971639 2.05866C0.524231 1.39443 1.00018 0.499999 1.80103 0.499999L6.1254 0.5C6.92625 0.5 7.4022 1.39443 6.95479 2.05866L4.79261 5.26867Z"
                                                                fill="#1F2224"/>
                                                        </svg>
                                                    </div>
                                                </button>
                                                <div class="collapse {{request()->get('choice') ? 'show' : ''}}"
                                                     id="searchResult-editor-choice">
                                                    <div class="leftSidebar-content">
                                                        <div
                                                            class="align-items-center d-flex form-check form-switch justify-content-between p-0 zCheck zPrice-plan-switch">
                                                            <label
                                                                for="editor_choice">{{__('See our favorites')}}</label>
                                                            <input class="form-check-input" type="checkbox"
                                                                   name="choice"
                                                                   value="1" role="switch"
                                                                   {{request()->get('choice') ? 'checked' : ''}} id="editor_choice"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-lg-8">
                        <form id="searchForm" action="{{ route('frontend.search-result') }}" method="GET">
                            @if(request('search_key'))
                                <input type="hidden" name="search_key" value="{{ request('search_key') }}">
                            @endif
                            @if(request('asset_type'))
                                <input type="hidden" name="asset_type" value="{{ request('asset_type') }}">
                            @endif
                            @if(request('license'))
                                <input type="hidden" name="license" value="{{ request('license') }}">
                            @endif
                            @if(request('file_type'))
                                <input type="hidden" name="file_type" value="{{ request('file_type') }}">
                            @endif
                            @if(request('choice'))
                                <input type="hidden" name="choice" value="{{ request('choice') }}">
                            @endif
                            @foreach(request('category', []) as $category)
                                <input type="hidden" name="category[]" value="{{ $category }}">
                            @endforeach

                            <div class="searchResult-content-sort">
                                <h4 class="title">
                                    {{ __('Showing') }}
                                    <span>{{ $products->firstItem() }}</span>
                                    {{ __('to') }}
                                    <span>{{ $products->lastItem() }}</span>
                                    {{ __('of') }}
                                    <span>{{ $products->total() }}</span>
                                    {{ __('Items') }}
                                </h4>

                                <div class="sortDropdown-wrap">
                                    <h4 class="fs-14 fw-400 lh-24 text-primary-dark-text flex-shrink-0">{{ __('Sort By') }}
                                        :</h4>
                                    <select class="sf-select-without-search" name="sort_by" id="sortSelect">
                                        <option
                                            value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>{{ __('Newest First') }}</option>
                                        <option
                                            value="oldest" {{ request('sort_by') == 'oldest' ? 'selected' : '' }}>{{ __('Oldest First') }}</option>
                                        <option
                                            value="relevant" {{ request('sort_by') == 'relevant' ? 'selected' : '' }}>{{ __('Most Relevant') }}</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                        <div class="imageGridGallery-searchResult">
                            @foreach($products as $key => $product)
                                <div class="photo-item item-{{$key + 1}}">
                                    <a href="{{route('frontend.product-details', $product->slug)}}" class="imgWrap">
                                        <img src="{{$product->thumbnail_image}}" alt=""/>
                                    </a>
                                    @if($product->accessibility == PRODUCT_ACCESSIBILITY_PAID)
                                        <button class="imgActionBtn premiumBtn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                 viewBox="0 0 24 24"
                                                 fill="none">
                                                <path
                                                    d="M3.51819 10.3058C3.13013 9.23176 2.9361 8.69476 3.01884 8.35065C3.10933 7.97427 3.377 7.68084 3.71913 7.58296C4.03193 7.49346 4.51853 7.70973 5.49173 8.14227C6.35253 8.52486 6.78293 8.71615 7.18732 8.70551C7.63257 8.69379 8.06088 8.51524 8.4016 8.19931C8.71105 7.91237 8.91861 7.45513 9.33373 6.54064L10.2486 4.52525C11.0128 2.84175 11.3949 2 12 2C12.6051 2 12.9872 2.84175 13.7514 4.52525L14.6663 6.54064C15.0814 7.45513 15.289 7.91237 15.5984 8.19931C15.9391 8.51524 16.3674 8.69379 16.8127 8.70551C17.2171 8.71615 17.6475 8.52486 18.5083 8.14227C19.4815 7.70973 19.9681 7.49346 20.2809 7.58296C20.623 7.68084 20.8907 7.97427 20.9812 8.35065C21.0639 8.69476 20.8699 9.23176 20.4818 10.3057L18.8138 14.9222C18.1002 16.897 17.7435 17.8844 16.9968 18.4422C16.2502 19 15.2854 19 13.3558 19H10.6442C8.71459 19 7.74977 19 7.00315 18.4422C6.25654 17.8844 5.89977 16.897 5.18622 14.9222L3.51819 10.3058Z"
                                                    fill="#F1F2FF"
                                                    stroke="#F1F2FF"
                                                    stroke-width="1.5"
                                                />
                                                <path d="M12 14H12.009H12Z" fill="#F1F2FF"/>
                                                <path d="M12 14H12.009" stroke="#1F2224" stroke-width="2"
                                                      stroke-linecap="round"
                                                      stroke-linejoin="round"/>
                                                <path d="M7 22H17H7Z" fill="#F1F2FF"/>
                                                <path d="M7 22H17" stroke="#F1F2FF" stroke-width="1.5"
                                                      stroke-linecap="round"/>
                                            </svg>
                                        </button>
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
                                    @if($product->productType->product_type_category === PRODUCT_TYPE_AUDIO)
                                        <div class="audioVideo-wrap">
                                            <div class="imgActionBtn audioVideo">
                                                <img src="{{asset('assets/images/icon/photoItem-audio-icon.svg')}}" alt="" />
                                            </div>
                                        </div>
                                    @elseif($product->productType->product_type_category === PRODUCT_TYPE_VIDEO)
                                        <div class="audioVideo-wrap">
                                            <div class="imgActionBtn audioVideo">
                                                <img src="{{asset('assets/images/icon/photoItem-video-icon.svg')}}" alt="" />
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        {{ $products->links('layouts.partial.product-pagination') }}
                    </div>
                </div>
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
@endsection
@push('script')
    <script src="{{ asset('assets/js/search-items.js') }}"></script>
@endpush

