@extends('layouts.app')
@push('title')
    {{ $pageTitle }}
@endpush
@section('content')
    <!-- Breadcrumb -->
    <section class="breadcrumb-section">
        <div class="breadcrumb-content bg-inner-bg">
            <h4 class="title">{{$pageTitle}}</h4>
            <ol class="breadcrumb sf-breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('frontend.index')}}">{{__('Home')}}</a></li>
                <li class="breadcrumb-item"><a>{{$pageTitle}}</a></li>
            </ol>
        </div>
    </section>
    <section class="section-gap blog-listWrap">
        <div class="container">
            <div class="blog-listTop">
                <div class="row rg-20">
                    @foreach($recentBlogs as $data)
                        <div class="col-lg-4 col-md-6">
                            <div class="blog-item">
                                <div class="img"><img src="{{ $data->image }}" alt="" /></div>
                                <div class="content">
                                    <div class="categoryDate">
                                        <a href="{{ route('frontend.blogs.details',$data->slug) }}" class="catLink">{{ $data->category->name }}</a>
                                        <p class="date"><span class="text-primary">/</span> {{ \Carbon\Carbon::parse($data->created_at)->format('d M Y') }}</p>
                                    </div>
                                    <a href="{{ route('frontend.blogs.details',$data->slug) }}" class="title">{{ $data->title }}</a>
                                    <a href="{{ route('frontend.blogs.details',$data->slug) }}" class="link">{{__('Read More')}}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="d-flex flex-column-reverse flex-xl-row justify-content-center justify-content-xl-between align-items-center align-items-xl-start flex-wrap g-10">
                <ul class="nav nav-tabs zTab-reset zTab-three align-self-xl-end" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a href="{{ route('frontend.blogs.list') }}" class="nav-link {{ request('category') ? '' : 'active' }}">{{__('All')}}</a>
                    </li>
                    @foreach($blogCategories as $category)
                        <li class="nav-item" role="presentation">
                            <a href="{{ route('frontend.blogs.list', ['category' => $category->id]) }}" class="nav-link {{ request('category') == $category->id ? 'active' : '' }}">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="searchOne blog-listSearch">
                    <form method="GET" action="{{ route('frontend.blogs.list') }}">
                        <div class="d-flex g-5">
                            <input type="text" name="search" class="zForm-control" placeholder="Search blogs" value="{{ request('search') }}" />
                            <button type="submit"><img src="{{ asset('assets/images/icon/search_light.svg') }}" alt="Search" /></button>
                        </div>
                        @if(request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                    </form>
                </div>
            </div>
            <div class="tab-content blog-listTabContent" id="myTabContent">
                <div class="tab-pane fade show active" id="all-tab-pane" role="tabpanel" aria-labelledby="all-tab" tabindex="0">
                    <div class="row rg-20">
                        @foreach($blogs as $data)
                            <div class="col-lg-4 col-md-6">
                                <div class="blog-item">
                                    <div class="img"><img src="{{ $data->image }}" alt="" /></div>
                                    <div class="content">
                                        <div class="categoryDate">
                                            <a href="{{ route('frontend.blogs.details', $data->slug) }}" class="catLink">{{ $data->category->name }}</a>
                                            <p class="date"><span class="text-primary">/</span> {{ \Carbon\Carbon::parse($data->created_at)->format('d M Y') }}</p>
                                        </div>
                                        <a href="{{ route('frontend.blogs.details',$data->slug) }}" class="title">{{ $data->title }}</a>
                                        <a href="{{ route('frontend.blogs.details', $data->slug) }}" class="link">{{ __('Read More') }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @foreach($blogCategories as $category)
                    <div class="tab-pane fade" id="category-{{ $category->id }}-tab-pane" role="tabpanel" aria-labelledby="category-{{ $category->id }}-tab" tabindex="0">
                        <div class="row rg-20">
                            @foreach($category->activeBlogs as $data)
                                <div class="col-lg-4 col-md-6">
                                    <div class="blog-item">
                                        <div class="img"><img src="{{ $data->image }}" alt="" /></div>
                                        <div class="content">
                                            <div class="categoryDate">
                                                <a href="{{ route('frontend.blogs.details', $data->slug) }}" class="catLink">{{ $data->category->name }}</a>
                                                <p class="date"><span class="text-primary">/</span> {{ \Carbon\Carbon::parse($data->created_at)->format('d M Y') }}</p>
                                            </div>
                                            <a href="{{ route('frontend.blogs.details',$data->slug) }}" class="title">{{ $data->title }}</a>
                                            <a href="{{ route('frontend.blogs.details', $data->slug) }}" class="link">{{ __('Read More') }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                {{ $blogs->links() }}
            </div>
        </div>
    </section>

@endsection
