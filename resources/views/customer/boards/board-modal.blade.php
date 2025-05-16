<div class="createBoardsModal-content">
    <div class="left"><img src="{{asset('assets/images/create-new-board.png')}}" alt=""/></div>
    <div class="right" id="createBoardSection">
        <h4 class="fs-md-24 fw-600 lh-34 text-primary-dark-text pb-20">{{__('Create New Board')}}</h4>
        <form class="ajax" action="{{ route('customer.boards.store') }}" method="post"
              data-handler="commonResponseWithPageLoad">
            @csrf
            <div class="pb-15">
                <label for="boardName" class="zForm-label">{{__('Board Name')}}<span
                        class="text-primary"> *</span></label>
                <input type="text" id="boardName" class="zForm-control" name="name"
                       placeholder="Enter your board name"/>
            </div>
            <button type="submit" class="zaiStock-btn w-100">{{__('Create a new')}}</button>
        </form>
        @if($product_id)
            <div class="text-center pt-20">
                <a type="submit" id="chooseBoardBtn" class="w-100">{{__('Choose Board')}}</a>
            </div>
        @endif
    </div>
    <!-- Choose Board Form -->
    <div class="right" id="chooseBoardSection" style="display: none;">
        <h4 class="fs-md-24 fw-600 lh-34 text-primary-dark-text pb-20">{{__('Choose Board')}}</h4>
        <form class="ajax" action="{{ route('customer.boards.product.store') }}" method="post"
              data-handler="commonResponseWithPageLoad">
            @csrf
            <input type="hidden" value="{{$product_id}}" name="product_id">
            <div class="pb-15">
                <label for="selectBoard" class="zForm-label">{{__('Select Board Name')}} <span
                        class="text-primary"> *</span></label>
                <select name="board_id" id="selectBoard" class="zForm-control sf-select-without-search">
                    <option value="">{{__("Select Board")}}</option>
                    @foreach($getBoardName as $data)
                        <option value="{{$data->id}}">{{ $data->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="zaiStock-btn w-100">{{__('Save Product')}}</button>
        </form>
        <div class="text-center pt-20">
            <a type="submit" id="createBoardBtn" class="w-100">{{__('Create New Board')}}</a>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#createBoardBtn').on('click', function () {
            $('#createBoardSection').show();
            $('#chooseBoardSection').hide();
        });

        $('#chooseBoardBtn').on('click', function () {
            $('#createBoardSection').hide();
            $('#chooseBoardSection').show();
        });
    });
</script>
