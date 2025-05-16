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
                <li class="breadcrumb-item"><a href="{{ route('frontend.index') }}">{{__('Home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('frontend.blogs.list') }}">{{__('Blog List')}}</a></li>
                <li class="breadcrumb-item"><a>{{$blog->title}}</a></li>
            </ol>
        </div>
    </section>
    <section class="section-gap-alt">
        <div class="container">
            <div class="blog-details-contentTop">
                <div class="categoryDate">
                    <a href="#" class="catLink">{{ $blog->category->name }}</a>
                    <p class="date"><span class="text-primary">/</span> {{ \Carbon\Carbon::parse($blog->created_at)->format('d M Y') }} </p>
                </div>
                <h4 class="title">{{ $blog->title }}</h4>
                <div class="img"><img src="{{ $blog->image }}" alt="" /></div>
            </div>
            <div class="row justify-content-end rg-20">
                <div class="col-lg-2 col-md-1 col-sm-2">
                    <ul class="blog-shareSocial">
                        <li>
                            <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ (route('frontend.blogs.details', ['slug' => $blog->slug])) }}" class="item"><img src="{{ asset('assets/images/icon/blog-shareSocial-facebook.svg') }}" alt="" /></a>
                        </li>
                        <li>
                            <a target="_blank" href="https://www.linkedin.com/sharing/share-offsite/?url={{ (route('frontend.blogs.details', $blog->slug)) }}" class="item"><img src="{{ asset('assets/images/icon/blog-shareSocial-linkedin.svg') }}" alt="" /></a>
                        </li>
                        <li>
                            <a target="_blank" href="https://twitter.com/intent/tweet?url={{ (route('frontend.blogs.details', $blog->slug)) }}" class="item"><img src="{{ asset('assets/images/icon/blog-shareSocial-twitter.svg') }}" alt="" /></a>
                        </li>
                        <li>
                            <a target="_blank" href="https://pinterest.com/pin/create/button/?url={{ route('frontend.blogs.details', $blog->slug) }}" class="item"><img src="{{ asset('assets/images/icon/blog-shareSocial-pinterest.svg') }}" alt="" /></a>
                        </li>
                        <li>
                            <a target="_blank" href="https://www.instagram.com/?url={{ route('frontend.blogs.details', $blog->slug) }}" class="item"><img src="{{ asset('assets/images/icon/blog-shareSocial-instagram.svg') }}" alt="" /></a>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-8 col-md-11 col-sm-10">
                    <div class="blog-details-contentRight">
                            {!! $blog->details !!}
                    </div>
                    @if(getOption('comment_status') == ACTIVE)
                    <h4 class="fs-md-24 fs-18 fw-600 lh-34 text-primary-dark-text pb-18">{{ count($blogComments) }}
                        {{__('Comments')}}</h4>
                    <div class="blog-details-commentWrap">
                        <ul class="list">
                            @forelse($blogComments as $comment)
                                <li class="">
                                    <div class="item">
                                        <div class="left">
                                            <div class="img"><img src="{{ $comment->customer->image }}" alt=""/></div>
                                            <div class="content">
                                                <h4 class="fs-18 fw-400 lh-28 text-primary-dark-text">{{ $comment->name }}</h4>
                                                <p class="fs-14 fw-400 lh-24 text-para-text">{{ $comment->comment }}</p>
                                            </div>
                                        </div>
                                        <div class="right">
                                            <p class="fs-14 fw-400 lh-24 text-para-text pb-5">{{ $comment->created_at->diffInDays(now()) }}
                                                {{__('days ago')}}</p>
                                            @if(auth()->check())
                                                <div class="d-flex align-items-center g-3">
                                                    <a type="submit" onclick="getEditModal('{{ route('frontend.blogs.comment.reply.modal', $comment->id) }}', '#edit-modal')" class="text-primary">{{ __('Reply') }}</a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    @if($comment->blogCommentReplies->count() > 0)
                                        <ul class="nested-list">
                                            @foreach($comment->blogCommentReplies as $reply)
                                                <li class="item">
                                                    <div class="left">
                                                        <div class="img">
                                                            <img src="{{ $reply->customer->image }}" alt=""/>
                                                        </div>
                                                        <div class="content">
                                                            <h4 class="fs-18 fw-400 lh-28 text-primary-dark-text">{{ $reply->name }}</h4>
                                                            <p class="fs-14 fw-400 lh-24 text-para-text">{{ $reply->comment }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="right">
                                                        <p class="fs-14 fw-400 lh-24 text-para-text pb-5">
                                                            {{ $reply->created_at->diffInDays(now()) }} {{__('days ago')}}
                                                        </p>
                                                        @if(auth()->check())
                                                            <div class="d-flex align-items-center g-3">
                                                                <a type="submit" onclick="getEditModal('{{ route('frontend.blogs.comment.reply.modal', $comment->id) }}', '#edit-modal')" class="text-primary">{{ __('Reply') }}</a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @empty
                                <li class="">
                                    <div class="item">{{__('No Comment Yet!')}}</div>
                                </li>
                            @endforelse
                        </ul>
                        @if(auth()->check())
                            <form action="{{route('frontend.blogs.comment.store')}}" method="post">
                                @csrf
                                <input type="hidden" name="blog_id" value="{{$blog->id}}">
                                <div class="inputWrap">
                                    <div class="img"><img src="{{ auth()->user()->image }}" alt=""/></div>
                                    <textarea class="zForm-control" required name="comment" placeholder="Add your thoughts..."></textarea>
                                </div>
                                <div class="inputWrap">
                                    <button type="submit" class="zaiStock-btn-black">{{__('Send')}}</button>
                                </div>
                            </form>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!--  -->
    @if($relatedPost->isNotEmpty())
        <section class="section-gap-bottom">
            <div class="container">
                <div class="section-content-wrap">
                    <h4 class="title">{{__('You Might Also Like')}}</h4>
                </div>
                <div class="row rg-20">
                    @foreach($relatedPost as $data)
                        <div class="col-lg-4 col-md-6">
                            <div class="blog-item">
                                <div class="img"><img src="{{ $data->image }}" alt="" /></div>
                                <div class="content">
                                    <div class="categoryDate">
                                        <a href="{{ route('frontend.blogs.details',$data->slug) }}" class="catLink">{{ $data->category->name }}</a>
                                        <p class="date"><span class="text-primary">/</span>{{ \Carbon\Carbon::parse($data->created_at)->format('d M Y') }}</p>
                                    </div>
                                    <a href="{{ route('frontend.blogs.details',$data->slug) }}" class="title">{{ $data->title }}</a>
                                    <a href="{{ route('frontend.blogs.details',$data->slug) }}" class="link">{{__('Read More')}}</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <!-- Edit Modal section start -->
    <div class="modal fade" id="edit-modal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bd-c-stroke-color bd-ra-12 py-25 px-20">

            </div>
        </div>
    </div>
@endsection
