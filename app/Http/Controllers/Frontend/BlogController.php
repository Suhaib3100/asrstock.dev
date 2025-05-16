<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Traits\ApiStatusTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    use ApiStatusTrait;

    public function list(Request $request)
    {
        $data['searchDisable'] = true;
        $data['pageTitle'] = 'Blogs';

        $categoryId = $request->query('category');
        $searchTerm = $request->query('search');

        $query = Blog::active()->latest();

        if ($categoryId) {
            $query->where('blog_category_id', $categoryId);
        }
        if ($searchTerm) {
            $query->where('title', 'LIKE', "%{$searchTerm}%");
        }
        $data['blogs'] = $query->paginate(3)->appends($request->query());

        $data['recentBlogs'] = Blog::with(['category'])->active()->orderBy('id', 'DESC')->take(3)->get();
        $data['blogCategories'] = BlogCategory::withCount('activeBlogs')->active()->get();

        return view('frontend.blog.list', $data);
    }

    public function blogEssential()
    {
        $response['recentBlogs'] = Blog::active()->latest()->take(3)->get();
        $response['blogCategories'] = BlogCategory::withCount('activeBlogs')->active()->get();
        return $this->success($response);
    }


    public function details($slug)
    {
        $data['searchDisable'] = true;
        $data['pageTitle'] = 'Blog Details';
        $data['blog'] = Blog::whereSlug($slug)->first();

        if ($data['blog']) {
            // Fetch active blog comments with only active replies
            $data['blogComments'] = BlogComment::with([
                'blogCommentReplies' => function ($query) {
                    $query->active(); // Ensure only active replies are fetched
                }
            ])->active()
                ->where('blog_id', $data['blog']->id)
                ->whereNull('parent_id')
                ->orderBy('id', 'DESC')
                ->get();

            // Fetch related blog posts
            $data['relatedPost'] = Blog::where('blog_category_id', $data['blog']->blog_category_id)
                ->where('id', '!=', $data['blog']->id)
                ->take(6)
                ->get();

            return view('frontend.blog.details', $data);
        }

        abort(404); // Handle case where blog is not found
    }

    public function blogCommentStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required|max:255',
            'blog_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'This field is required !');
        }

        if (auth()->user()->id) {
            $comment = new BlogComment();
            $comment->name = auth()->user()->name;
            $comment->email = auth()->user()->email;
            $comment->comment = $request->comment;
            $comment->status = 1;
            $comment->blog_id = $request->blog_id;
            $comment->customer_id = auth()->user()->id;
            $comment->save();

            return redirect()->back()->with('success', 'Your comment has been posted successfully!');
        }

        return redirect()->back()->with('error', 'You need to login first!');
    }

    public function blogCommentReplyModal($id)
    {

        $data['blogComment'] = BlogComment::findOrFail($id);
        return view('frontend.blog.reply-modal', $data);

    }

    public function blogCommentReplyStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required|max:255',
            'blog_id' => 'required',
            'parent_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', 'This field is required !');
        }

        if (auth()->user()->id && $request->comment) {
            $comment = new BlogComment();
            $comment->name = auth()->user()->name;
            $comment->email = auth()->user()->email;
            $comment->comment = $request->comment;
            $comment->status = 1;
            $comment->blog_id = $request->blog_id;
            $comment->customer_id = auth()->user()->id;
            $comment->parent_id = $request->parent_id;
            $comment->save();

            return redirect()->back()->with('success', 'Your reply has been posted successfully!');

        }

        return redirect()->back()->with('error', 'You need to login first!');
    }

}
