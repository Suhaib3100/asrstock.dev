@extends('admin.layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="p-sm-30 p-15">
        <div class="d-flex align-items-center justify-content-between flex-wrap g-15 pb-26">
            <h2 class="fs-24 fw-600 lh-29 text-primary-dark-text">{{__('Edit Blog')}}</h2>
            <div class="">
                <div class="breadcrumb__content p-0">
                    <div class="breadcrumb__content__right">
                        <nav aria-label="breadcrumb">
                            <ul class="breadcrumb sf-breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{route('admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                <li class="breadcrumb-item"><a href="{{route('admin.blog.index')}}">{{__('Blog')}}</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{__('Edit Blog')}}</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
            <form action="{{route('admin.blog.update', [$blog->uuid])}}" method="post" class="form-horizontal"
                  enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                <div class="row rg-24 pb-24">
                    <div class="col-12">
                        <label class="zForm-label">{{__('Title')}} <span class="text-danger">*</span></label>
                        <input type="text" name="title" value="{{$blog->title}}" placeholder="{{__('Title')}}" class="zForm-control slugable" onkeyup="slugable()">
                        @if ($errors->has('title'))
                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('title') }}</span>
                        @endif
                    </div>

                    <div class="col-12">
                        <label class="zForm-label">{{__('Slug')}} <span class="text-danger">*</span></label>
                        <input type="text" name="slug" value="{{$blog->slug}}" placeholder="{{__('Slug')}}" class="zForm-control slug" onkeyup="getMyself()">
                        @if ($errors->has('slug'))
                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('slug') }}</span>
                        @endif
                    </div>

                    <div class="col-12">
                        <label class="zForm-label" for="blog_category_id"> {{ __('Blog category') }} </label>
                        <select class="form-select" name="blog_category_id" id="blog_category_id">
                            <option value="">--{{ __('Select Option') }}--</option>
                            @foreach($blogCategories as $blogCategory)
                                <option value="{{ $blogCategory->id }}"
                                        @if($blogCategory->id = $blog->blog_category_id) selected @endif>{{ $blogCategory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="zForm-label">Status</label>
                        <select class="form-select" name="status" id="status">
                            <option value="">--{{ __('Select Option') }}--</option>
                            <option value="1" @if($blog->status == 1) selected @endif>{{ __('Published') }}</option>
                            <option value="0" @if($blog->status != 1) selected @endif>{{ __('Unpublished') }}</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="zForm-label">{{__('Details')}} <span class="text-danger">*</span></label>
                        <textarea name="details" id="summernote" class="summernoteOne" >{{$blog->details}}</textarea>

                        @if ($errors->has('Details'))
                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('details') }}</span>
                        @endif

                    </div>
                    <div class="col-12">
                        <div class="col-md-3">
                            <div class="upload-img-box mb-25">
                                @if($blog->image)
                                    <img src="{{asset($blog->image)}}" alt="img">
                                @else
                                    <img src="{{ getDefaultImage() }}" alt="">
                                @endif
                                <input type="file" name="image" id="image" accept="image/*"
                                       onchange="previewFile(this)">
                                <div class="upload-img-box-icon">
                                    <i class="fa fa-camera"></i>
                                </div>
                            </div>
                            @if ($errors->has('image'))
                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('image') }}</span>
                            @endif
                            <p>{{ __('Accepted Image Files') }}: JPEG, JPG, PNG <br> {{ __('Recommend Size') }}: 870 x
                                500 (1MB)</p>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end align-items-center g-10">
                    <a href="{{route('admin.blog.index')}}" class="border-0 bg-para-text py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white d-inline-flex align-items-center g-5"> <i class="fa fa-arrow-left"></i> {{__('back')}} </a>
                    <button type="submit" class="border-0 bg-primary py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white">{{ __('Update') }}</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Page content area end -->
@endsection

@push('style')
    <link rel="stylesheet" href="{{asset('admin/css/custom/image-preview.css')}}">
@endpush

@push('script')
    <script src="{{asset('admin/js/custom/image-preview.js')}}"></script>
    <script src="{{asset('admin/js/custom/slug.js')}}"></script>
    <script src="{{ asset('admin/js/custom/summernote-editor.js') }}"></script>
@endpush
