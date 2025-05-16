<table class="row-border stripe table-style common-datatable responsive">
    <thead>
    <tr>
        <th >{{__('Sl.')}}</th>
        <th >{{__('Image')}}</th>
        <th >{{__('Title')}}</th>
        <th >{{__('Type')}}</th>
        <th >{{__('Category')}}</th>
        <th >{{__('Accessibility')}}</th>
        <th >{{__('Status')}}</th>
        <th >{{__('Is Featured')}}</th>
        <th class="none">{{__('Created By')}}</th>
        <th >{{__('Action')}}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr class="removable-item">
            <td>{{$loop->iteration}}</td>
            <td>

                <div class="admin-dashboard-blog-list-img w-30 h-30 rounded-circle overflow-hidden">
                    <a class="test-popup-link" href="{{ $product->thumbnail_image }}">
                        <img src="{{ $product->thumbnail_image }}" alt="img" class="w-100 h-100 object-fit-cover">
                    </a>
                </div>
            </td>
            <td>
                {{$product->title}}
                <div class="finance-table-inner-item my-2">
                    <span class="fw-bold mr-1">{{ __('Downloads') }}: </span>{{@$product->downloadProducts->count()}}
                </div>
            </td>
            <td>{{@$product->productType->name }}</td>
            <td>{{@$product->productCategory->name }}</td>
            <td>
                @if($product->accessibility == 1)
                    <span class="text-danger">{{ __('Paid') }}</span>
                @elseif($product->accessibility == 2)
                    <span class="text-primary">{{ __('Free') }}</span>
                @endif
            </td>
            <td>
                <div class="d-flex justify-content-center">
                    <div>
                        @if($product->status == PRODUCT_STATUS_PUBLISHED)
                            <span class="zBadge zBadge-published">{{ __('Published') }}</span>
                        @elseif($product->status == PRODUCT_STATUS_PENDING)
                            <span class="zBadge zBadge-pending">{{ __('Pending') }}</span>
                        @elseif($product->status == PRODUCT_STATUS_HOLD)
                            <span class="zBadge zBadge-hold">{{ __('Hold') }}</span>
                        @endif
                    </div>
                    <div>
                        <ul class="action-list">
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('admin/images/icons/ellipsis-v.svg') }}" alt="icon" class="ellipsis-icon-img">
                                </a>
                                <span id="hidden_id" class="d-none">{{$product->id}}</span>
                                <ul class="dropdown-menu">
                                    @if($product->status != PRODUCT_STATUS_PUBLISHED)
                                        <li><a class="product_status dropdown-item" data-status="{{PRODUCT_STATUS_PUBLISHED}}" >{{ __('Published') }}</a></li>
                                    @endif
                                    @if($product->status != PRODUCT_STATUS_PENDING)
                                        <li><a class="product_status dropdown-item" data-status="{{PRODUCT_STATUS_PENDING}}" >{{ __('Pending') }}</a></li>
                                    @endif
                                    @if($product->status != PRODUCT_STATUS_HOLD)
                                        <li><a class="product_status dropdown-item" data-status="{{ PRODUCT_STATUS_HOLD }}" >{{ __('Hold') }}</a></li>
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </td>
            <td>
                <div class="d-flex justify-content-center align-items-center">
                    <div>
                        @if($product->is_featured == PRODUCT_IS_FEATURED_YES)
                            <span class="text-success fw-bold">{{ __('Yes') }}</span>
                        @else
                            <span class="text-danger fw-bold">{{ __('No') }}</span>
                        @endif
                    </div>
                    <div>
                        <ul class="action-list">
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('admin/images/icons/ellipsis-v.svg') }}" alt="icon" class="ellipsis-icon-img">
                                </a>
                                <span id="hidden_id" class="d-none">{{$product->id}}</span>
                                <ul class="dropdown-menu">
                                    @if($product->is_featured != PRODUCT_IS_FEATURED_YES)
                                        <li><a class="is_featured dropdown-item" data-is_featured="{{ PRODUCT_IS_FEATURED_YES }}" >{{ __('Yes') }}</a></li>
                                    @endif
                                    @if($product->is_featured != PRODUCT_IS_FEATURED_NO)
                                        <li><a class="is_featured dropdown-item" data-is_featured="{{ PRODUCT_IS_FEATURED_NO }}" >{{ __('No') }}</a></li>
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </td>

            <td>
                @if($product->uploaded_by == 1)
                    {{ @$product->user->name }} (Admin)
                @else
                    {{ @$product->customer->name }} (Contributor)
                @endif
            </td>
            <td>
                <div class="action__buttons">
                    <a target="__blank" href="{{route('admin.product.show', [$product->uuid])}}" title="view" class="btn-action">
                        <svg width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.5 8C8.60457 8 9.5 7.10457 9.5 6C9.5 4.89543 8.60457 4 7.5 4C6.39543 4 5.5 4.89543 5.5 6C5.5 7.10457 6.39543 8 7.5 8Z" fill="#5D697A"></path><path d="M14.9698 5.83C14.3817 4.30882 13.3608 2.99331 12.0332 2.04604C10.7056 1.09878 9.12953 0.561286 7.49979 0.5C5.87005 0.561286 4.29398 1.09878 2.96639 2.04604C1.6388 2.99331 0.617868 4.30882 0.0297873 5.83C-0.00992909 5.93985 -0.00992909 6.06015 0.0297873 6.17C0.617868 7.69118 1.6388 9.00669 2.96639 9.95396C4.29398 10.9012 5.87005 11.4387 7.49979 11.5C9.12953 11.4387 10.7056 10.9012 12.0332 9.95396C13.3608 9.00669 14.3817 7.69118 14.9698 6.17C15.0095 6.06015 15.0095 5.93985 14.9698 5.83ZM7.49979 9.25C6.857 9.25 6.22864 9.05939 5.69418 8.70228C5.15972 8.34516 4.74316 7.83758 4.49718 7.24372C4.25119 6.64986 4.18683 5.99639 4.31224 5.36596C4.43764 4.73552 4.74717 4.15642 5.20169 3.7019C5.65621 3.24738 6.23531 2.93785 6.86574 2.81245C7.49618 2.68705 8.14965 2.75141 8.74351 2.99739C9.33737 3.24338 9.84495 3.65994 10.2021 4.1944C10.5592 4.72886 10.7498 5.35721 10.7498 6C10.7485 6.86155 10.4056 7.68743 9.79642 8.29664C9.18722 8.90584 8.36133 9.24868 7.49979 9.25Z" fill="#5D697A"></path></svg>
                    </a>

                    <a href="{{route('admin.product.edit', [$product->uuid])}}" title="Edit" class="btn-action">
                        <svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.8067 3.19354C12.0667 2.93354 12.0667 2.5002 11.8067 2.25354L10.2467 0.693535C10 0.433535 9.56667 0.433535 9.30667 0.693535L8.08 1.91354L10.58 4.41354M0 10.0002V12.5002H2.5L9.87333 5.1202L7.37333 2.6202L0 10.0002Z" fill="#5D697A"></path></svg>
                    </a>

                    <button class="btn-action ms-2 deleteItem" data-formid="delete_row_form_{{$product->uuid}}">
                        <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.76256 2.51256C6.09075 2.18437 6.53587 2 7 2C7.46413 2 7.90925 2.18437 8.23744 2.51256C8.4448 2.71993 8.59475 2.97397 8.67705 3.25H5.32295C5.40525 2.97397 5.5552 2.71993 5.76256 2.51256ZM3.78868 3.25C3.89405 2.57321 4.21153 1.94227 4.7019 1.4519C5.3114 0.84241 6.13805 0.5 7 0.5C7.86195 0.5 8.6886 0.84241 9.2981 1.4519C9.78847 1.94227 10.106 2.57321 10.2113 3.25H13C13.4142 3.25 13.75 3.58579 13.75 4C13.75 4.41422 13.4142 4.75 13 4.75H12V13C12 13.3978 11.842 13.7794 11.5607 14.0607C11.2794 14.342 10.8978 14.5 10.5 14.5H3.5C3.10217 14.5 2.72064 14.342 2.43934 14.0607C2.15804 13.7794 2 13.3978 2 13V4.75H1C0.585786 4.75 0.25 4.41422 0.25 4C0.25 3.58579 0.585786 3.25 1 3.25H3.78868ZM5 6.37646C5.34518 6.37646 5.625 6.65629 5.625 7.00146V11.003C5.625 11.3481 5.34518 11.628 5 11.628C4.65482 11.628 4.375 11.3481 4.375 11.003V7.00146C4.375 6.65629 4.65482 6.37646 5 6.37646ZM9.625 7.00146C9.625 6.65629 9.34518 6.37646 9 6.37646C8.65482 6.37646 8.375 6.65629 8.375 7.00146V11.003C8.375 11.3481 8.65482 11.628 9 11.628C9.34518 11.628 9.625 11.3481 9.625 11.003V7.00146Z" fill="#5D697A"></path></svg>
                    </button>
                    <form action="{{ route('admin.product.destroy', $product->uuid) }}" method="post" id="delete_row_form_{{ $product->uuid }}">
                        {{ method_field('DELETE') }}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
