<div class="createBoardsModal-content">
    <div class="left"><img src="{{asset('assets/images/create-new-board.png')}}" alt=""/></div>
    <div class="right" id="createBoardSection">
        <h4 class="fs-md-24 fw-600 lh-34 text-primary-dark-text pb-20">{{__('Create New Board')}}</h4>
        <form class="ajax" action="{{ route('customer.boards.update', $board->id) }}" method="post"
              data-handler="commonResponseWithPageLoad">
            @csrf
            <div class="pb-15">
                <label for="boardName" class="zForm-label">{{__('Board Name')}}<span class="text-primary"> *</span></label>
                <input type="text" id="boardName" value="{{$board->name}}" class="zForm-control" name="name"
                       placeholder="Enter your board name"/>
            </div>
            <button type="submit" class="zaiStock-btn w-100">{{__('Create a new')}}</button>
        </form>
    </div>
</div>
