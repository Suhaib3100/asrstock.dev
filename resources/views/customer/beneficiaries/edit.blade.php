<div class="p-sm-25 p-15 beneficiaryAddModal-content">
    <div class="pb-10 d-flex justify-content-between">
        <h5>{{__('Update Beneficiary')}}</h5>
        <button type="button"
                class="w-30 h-30 bg-bg-color-2 border-0 rounded-circle d-flex justify-content-center align-items-center"
                data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
    </div>
    <form action="{{route('customer.beneficiaries.store', $beneficiary->id)}}" class="ajax" method="POST"
          data-handler="commonResponseForModal">
        @csrf
        <div class="row rg-25">
            <div class="col-lg-12">
                <label for="name" class="zForm-label">{{__('Name')}}
                    <span class="text-primary">*</span></label>
                <input type="text" value="{{$beneficiary->name}}" name="name" id="name" class="zForm-control"
                       placeholder="{{__('Name')}}">
            </div>
            <div class="col-lg-12">
                <label for="type" class="zForm-label">{{__('Gateway')}} <span class="text-primary">*</span></label>
                <select name="type" id="type" class="sf-select-without-search">
                    @foreach(getBeneficiary() as $optIndex => $optValue)
                        <option {{ $beneficiary->type == $optIndex ? 'selected' : '' }} value="{{$optIndex}}">{{$optValue}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-12">
                <label for="details" class="zForm-label">{{__('Details')}} <span
                        class="text-primary">*</span></label>
                <textarea name="details" id="details" placeholder="{{__('Details')}}"
                          class="zForm-control">{{$beneficiary->details}}</textarea>
            </div>
            <div class="col-lg-12">
                <label for="status" class="zForm-label">{{__('Status')}} <span
                        class="text-primary">*</span></label>
                <select name="status" id="status" class="sf-select-without-search">
                    <option {{ $beneficiary->status == ACTIVE ? 'selected' : '' }} value="{{ACTIVE}}">{{__('Active')}}</option>
                    <option {{ $beneficiary->status == DISABLE ? 'selected' : '' }} value="{{DISABLE}}">{{__('Deactivate')}}</option>
                </select>
            </div>
            <div class="col-lg-12">
                <button type="submit" class="zaiStock-btn">{{__('Update')}}</button>
            </div>
        </div>
    </form>
</div>
