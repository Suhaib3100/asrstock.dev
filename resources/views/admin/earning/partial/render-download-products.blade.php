<table class="table zTable zTable-last-item-right commonDataTable">
    <thead>
        <tr>
            <th><div>{{__('Sl.')}}</div></th>
            <th><div>{{__('Image')}}</div></th>
            <th><div>{{__('Title')}}</div></th>
            <th><div class="text-nowrap">{{__('Product Type')}}</div></th>
            <th><div>{{__('Category')}}</div></th>
            <th><div class="text-nowrap">{{__('Earn Money')}}</div></th>
            <th><div class="text-nowrap">{{__('Created By')}}</div></th>
            <th><div>{{__('Date')}}</div></th>
        </tr>
    </thead>
    <tbody>
    @foreach($downloadProducts as $downloadProduct)
        <tr class="removable-item">
            <td>
                {{$loop->iteration}}
            </td>
            <td>
                <div class="admin-dashboard-blog-list-img w-30 h-30 rounded-circle overflow-hidden">
                    <a class="test-popup-link" href="{{ @$downloadProduct->product->thumbnail_image }}">
                        <img src="{{ @$downloadProduct->product->thumbnail_image }}" alt="img" class="w-100 h-100 object-fit-cover">
                    </a>
                </div>
            </td>
            <td>{{ @$downloadProduct->product->title }}</td>
            <td>{{ @$downloadProduct->product->productType->name }}</td>
            <td>{{ @$downloadProduct->product->productCategory->name }}</td>
            <td>{{ @$downloadProduct->earn_money }}</td>

            <td>
                @if(@$downloadProduct->product->uploaded_by == 1)
                    {{ @$downloadProduct->product->user->name }} (Admin)
                @else
                    {{ @$downloadProduct->product->customer->name }} (Contributor)
                @endif
            </td>
            <td>{{ date('d M, Y', strtotime($downloadProduct->created_at)) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
