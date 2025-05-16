<div class="row rg-20">
    <input type="hidden" name="status" value="{{$product->status ?? PRODUCT_STATUS_PENDING}}">
    <div class="col-xl-6">
        <!-- Product Detail -->
        <div
            class="p-sm-20 p-10 bg-white bd-one bd-c-stroke bd-ra-10 zaiStock-shadow-one mb-20">
            <h4 class="inner-sub-title-one pb-20">{{__('Product Detail')}}</h4>
            <ul class="zList-pb-18">
                <li>
                    <div>
                        <label for="title" class="zForm-label">{{__('Product Title')}}
                            <span
                                class="text-primary">*</span></label>
                        <input value="{{$product->title ?? ''}}" type="text" id="title" name="title"
                               class="zForm-control"
                               placeholder="{{__('Enter title')}}"/>
                    </div>
                </li>
                <li>
                    <div>
                        <label for="product_type_id"
                               class="zForm-label">{{__('Product Type')}}
                            <span
                                class="text-primary">*</span></label>
                        <select class="sf-select-without-search" id="product_type_id"
                                name="product_type_id">
                            <option value="">{{__('Select Type')}}</option>
                            @foreach($productTypes as $type)
                                <option
                                    {{($product->product_type_id ?? null) == $type->id ? 'selected' : ''}} value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </li>
                <li>
                    <div>
                        <label for="product_category_id"
                               class="zForm-label">{{__('Product Category')}}<span
                                class="text-primary">*</span></label>
                        <select class="sf-select-without-search"
                                name="product_category_id"
                                id="product_category_id">
                            <option value="">{{__('Select Category')}}</option>
                            @foreach($product_categories ?? [] as $category)
                                <option
                                    {{$product->product_category_id == $category->id ? 'selected' : ''}} value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </li>
                <li>
                    <div>
                        <label for="file_types" class="zForm-label">{{__('File Types')}}
                            <span
                                class="text-primary">*</span></label>
                        <select class="sf-select-without-search" name="file_types"
                                id="file_types">
                            <option value="">{{__('Select File Type')}}</option>
                            @foreach($file_types ?? [] as $type)
                                <option
                                    {{$product->file_types == $type->name ? 'selected' : ''}} value="{{$type->name}}">{{$type->title}}</option>
                            @endforeach
                        </select>
                    </div>
                </li>
                <li>
                    <div>
                        <label for="tags" class="zForm-label">{{__('Tags')}}<span
                                class="text-primary">*</span></label>
                        <select class="sf-select" multiple id="tags" name="tags[]">
                            @foreach($tags as $tag)
                                <option
                                    {{ in_array($tag->id, ($productTags ?? [])) ? 'selected' : '' }} value="{{$tag->id}}">{{$tag->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </li>
                <li>
                    <div>
                        <label for="tax_id"
                               class="zForm-label">{{__('Product Tax')}}</label>
                        <select class="sf-select-without-search" name="tax_id" id="tax_id">
                            <option value="">{{__('Select Tax')}}</option>
                            @foreach($taxes as $tax)
                                <option
                                    {{($product->tax_id ?? null) == $tax->id ? 'selected' : ''}}  value="{{$tax->id}}">{{$tax->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </li>
            </ul>
        </div>
        <!-- Product Description -->
        <div
            class="p-sm-20 p-10 bg-white bd-one bd-c-stroke bd-ra-10 zaiStock-shadow-one">
            <h4 class="inner-sub-title-one pb-20">{{__('Product Description')}}</h4>
            <ul class="zlist-pb-18">
                <li>
                    <label for="description"
                           class="zForm-label">{{__('Description')}}</label>
                    <textarea name="description" class="summernoteOne"
                              placeholder="{{__('Write something here....')}}">{{$product->description ?? ''}}</textarea>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-xl-6">
        <!-- Product Image -->
        <div
            class="p-sm-20 p-10 bg-white bd-one bd-c-stroke bd-ra-10 zaiStock-shadow-one mb-20">
            <h4 class="inner-sub-title-one pb-20">{{__('Product Image')}}</h4>
            <div class="zImage-upload-details">
                <div class="zImage-inside">
                    <div class="d-flex pb-12">
                        <img src="{{asset('assets/images/icon/img-upload.svg')}}" alt=""/>
                    </div>
                    <p class="text">{{__('Drop your thumbnail image')}}
                        <span>{{__('here')}}</span></p>
                </div>
                <div class="upload-img-box">
                    @if(isset($product) && $product->thumbnail_image)
                        <img class="" src="{{ $product->thumbnail_image }}">
                    @else
                        <img src="" alt=""/>
                    @endif
                    <input type="file" name="thumbnail_image" id="thumbnail_image"
                           accept="image/*"
                           onchange="previewFile(this)"/>
                </div>
            </div>
        </div>
        <!-- License -->
        <div
            class="p-sm-20 p-10 bg-white bd-one bd-c-stroke bd-ra-10 zaiStock-shadow-one mb-20">
            <h4 class="inner-sub-title-one pb-20">{{__('License')}}</h4>
            <div class="d-flex align-items-center g-19 pb-sm-30 pb-20">
                <p class="fs-16 fw-400 lh-26 text-primary-dark-text">{{__('Accessibility')}}
                    <span
                        class="text-primary">*</span></p>
                <ul class="nav nav-tabs zTab-reset zTab-two" id="myTab" role="tablist">
                    <li class="nav-item zForm-wrap-radio" role="presentation">
                        <input type="radio" name="accessibility"
                               value="{{DOWNLOAD_ACCESSIBILITY_TYPE_FREE}}"
                               class="form-check-input"
                               id="freeLicenseLable" {{ ($product->accessibility ?? PRODUCT_ACCESSIBILITY_FREE) == PRODUCT_ACCESSIBILITY_FREE ? 'checked' : '' }}/>
                        <label class="nav-link {{ ($product->accessibility ?? PRODUCT_ACCESSIBILITY_FREE) == PRODUCT_ACCESSIBILITY_FREE ? 'active' : '' }}" for="freeLicenseLable"
                               id="free-tab"
                               data-bs-toggle="tab" data-bs-target="#free-tab-pane"
                               role="tab" aria-controls="free-tab-pane"
                               aria-selected="{{ ($product->accessibility ?? PRODUCT_ACCESSIBILITY_FREE) == PRODUCT_ACCESSIBILITY_FREE ? 'true' : 'false' }}">{{__('Free')}}</label>
                    </li>
                    <li class="nav-item zForm-wrap-radio" role="presentation">
                        <input type="radio" name="accessibility"
                               value="{{DOWNLOAD_ACCESSIBILITY_TYPE_PAID}}"
                               class="form-check-input"
                               id="paidLicenseLable" {{ ($product->accessibility ?? '') == DOWNLOAD_ACCESSIBILITY_TYPE_PAID ? 'checked' : '' }}/>
                        <label class="nav-link {{ ($product->accessibility ?? '') == DOWNLOAD_ACCESSIBILITY_TYPE_PAID ? 'active' : '' }}" for="paidLicenseLable" id="paid-tab"
                               data-bs-toggle="tab" data-bs-target="#paid-tab-pane"
                               role="tab" aria-controls="paid-tab-pane"
                               aria-selected="{{ ($product->accessibility ?? '') == DOWNLOAD_ACCESSIBILITY_TYPE_PAID ? 'true' : 'false' }}">{{__('Paid')}}</label>
                    </li>
                </ul>
            </div>
            <div class="tab-content" id="myTabContent">
                <!-- Free -->
                <div
                    class="tab-pane fade {{ ($product->accessibility ?? PRODUCT_ACCESSIBILITY_FREE) == PRODUCT_ACCESSIBILITY_FREE ? 'show active' : '' }}"
                    id="free-tab-pane"
                    role="tabpanel"
                    aria-labelledby="free-tab" tabindex="0">
                    <ul class="zList-pb-18 pb-md-40 pb-20">
                        <li>
                            <div>
                                <label for="use_this_photo" class="zForm-label">{{__('How can use this?')}}
                                    <span class="text-primary">*</span></label>
                                <select class="sf-select-without-search"
                                        id="use_this_photo"
                                        name="use_this_photo">
                                    <option
                                        value="">{{__('Select Use Option')}}</option>
                                    @foreach($useOptions as $useOption)
                                        <option
                                            {{ ($product->use_this_photo ?? null) == $useOption->id ? 'selected' : '' }} value="{{ $useOption->id }}">{{ $useOption->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </li>
                        <li>
                            <div>
                                <label class="zForm-label">{{__('File')}}
                                    <span class="text-primary">*</span>
                                    @if(isset($product))
                                        <a class="fs-12" href="{{ getFileUrl($product->variations->first()?->file) }}"
                                           target="_blank">{{__('View')}}</a>
                                    @endif
                                </label>
                                <div class="file-upload-one">
                                    <label for="main_file">
                                        <p class="fileName fs-14 fw-400 lh-24 text-para-text">{{__('Choose File to upload')}}</p>
                                        <p class="fs-14 fw-600 lh-24 text-white">{{__('Browse File')}}</p>
                                    </label>
                                    <input type="file" name="main_file" id="main_file"
                                           class="fileUploadInput invisible position-absolute top-0 w-100 h-100"/>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="zCheck form-switch d-flex align-items-center g-10">
                        <input class="form-check-input mt-0" name="attribution_required"
                               value="1"
                               {{ ($product->attribution_required ?? null) == ACTIVE ? 'checked' : '' }} type="checkbox"
                               role="switch"
                               id="attributionRequired"/>
                        <label for="attributionRequired">{{__('Attribution required')}}</label>
                    </div>
                </div>
                <!-- Paid -->
                <div
                    class="tab-pane fade {{ ($product->accessibility ?? '') == DOWNLOAD_ACCESSIBILITY_TYPE_PAID ? 'show active' : '' }}"
                    id="paid-tab-pane" role="tabpanel"
                    aria-labelledby="paid-tab" tabindex="0">
                    <ul class="zList-pb-10" id="variation-block">
                        @foreach($product->variations ?? [[]] as $variation)
                            <input type="hidden" name="variation_id[]" value="{{ $variation->id ?? '' }}">
                            <li class="variation-item">
                                <div class="licensePaid-item zaiStock-shadow-one">
                                    <div class="variationFields">
                                        <div class="left">
                                            <div>
                                                <input type="text" name="variations[]"
                                                       value="{{ $variation->variation ?? '' }}"
                                                       placeholder="{{__('Variation')}}"
                                                       class="variations zForm-control"/>
                                            </div>
                                            <div>
                                                <input type="text" name="prices[]" value="{{ $variation->price ?? '' }}"
                                                       placeholder="{{__('Price')}}"
                                                       class="prices zForm-control"/>
                                            </div>
                                        </div>
                                        @if($loop->first)
                                            <button id="addVariation" type="button"
                                                    class="right add">
                                                <img
                                                    src="{{asset('assets/images/icon/variationFields-add.svg')}}"
                                                    alt=""/>
                                            </button>
                                        @else
                                            <button type="button" class="right remove-variation">
                                                <img
                                                    src="{{asset('assets/images/icon/variationFields-delete.svg')}}"
                                                    alt=""/>
                                            </button>
                                        @endif
                                    </div>
                                    <div>
                                        <label class="zForm-label">{{__('Upload File')}}
                                            <span class="text-primary">*</span>
                                            @if(isset($product) && $variation->file)
                                                <a class="fs-12" href=" {{ getFileUrl($variation->file) }}"
                                                   target="_blank">{{__('View')}}</a>
                                            @endif
                                        </label>
                                        <div class="file-upload-one">
                                            <label for="mAttachment-1">
                                                <p class="fileName fs-14 fw-400 lh-24 text-para-text bd-c-stroke-2">
                                                    {{__('Choose Image to upload')}}</p>
                                                <p class="fs-14 fw-600 lh-24 text-white">{{__('Browse File')}}</p>
                                            </label>
                                            <input type="file" name="main_files[]"
                                                   id="mAttachment-1"
                                                   class="main_files fileUploadInput invisible position-absolute top-0 w-100 h-100"/>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <!-- Button -->
        <button class="zaiStock-btn">{{__('Upload Product')}}</button>
    </div>
</div>
