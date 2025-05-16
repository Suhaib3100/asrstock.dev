<div class="modal-header">
    <h5 class="modal-title">{{ __('Comment Reply') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form action="{{ route('frontend.blogs.comment.reply') }}" method="post">
    @csrf
    <input type="hidden" value="{{ $blogComment->blog_id }}" name="blog_id">
    <input type="hidden" value="{{ $blogComment->id }}" name="parent_id">
    <div class="modal-body">
        <label for="name" class="mb-10">{{__('Reply') }}</label>
        <textarea class="zForm-control" required name="comment" placeholder="Add your thoughts..."></textarea>
        <div class="pt-18 text-end">
            <button type="submit" class="zaiStock-btn">{{ __('Send') }}</button>
        </div>
    </div>
</form>
