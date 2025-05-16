<table class="table zTable zTable-last-item-right commonDataTable">
    <thead>
        <tr>
            <th><div>{{__('Sl.')}}</div></th>
            <th><div>{{__('Image')}}</div></th>
            <th><div>{{__('Title')}}</div></th>
            <th><div>{{__('Sales')}}</div></th>
            <th><div class="text-nowrap">{{__('Paid Download')}}</div></th>
            <th><div class="text-nowrap">{{__('Free Download')}}</div></th>
            <th><div class="text-nowrap">{{__('Created By')}}</div></th>
            <th><div>{{__('Date')}}</div></th>
        </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr class="removable-item">
            <td>{{$loop->iteration}}</td>
            <td>
                <div class="admin-dashboard-blog-list-img w-30 h-30 rounded-circle overflow-hidden">
                    <a class="test-popup-link" href="{{ @$product->thumbnail_image }}">
                        <img src="{{ @$product->thumbnail_image }}" alt="img" class="w-100 h-100 object-fit-cover">
                    </a>
                </div>
            </td>
            <td>{{ $product->title }}</td>
            <td><b>{{ productSalesCount($product->id) }}</b>({{ getAmountPlace(productSalesAmount($product->id)) }})</td>
            <td><b>{{ downloadPaidCount($product->id) }}</b>({{ getAmountPlace(downloadPaidAmount($product->id)) }})</td>
            <td><b>{{ downloadFreeCount($product->id) }}</b></td>

            <td>
                @if($product->uploaded_by == PRODUCT_UPLOADED_BY_ADMIN)
                    {{ @$product->user->name }} (Admin)
                @else
                    {{ @$product->customer->name }} (Contributor)
                @endif
            </td>
            <td>{{ date('d M, Y', strtotime($product->created_at)) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
