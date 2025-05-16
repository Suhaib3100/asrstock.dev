<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogComment;
use App\Models\FileManager;
use App\Models\Tag;
use App\Tools\Repositories\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    protected $model;
    public function __construct(Blog $blog)
    {
        $this->model = new Crud($blog);
    }

    public function index()
    {
        $data['pageTitle'] = 'Manage Blog';
        $data['subNavBlogIndexActiveClass'] = 'active';
        $data['showAdminBlog'] = 'show';
        $data['blogs'] = $this->model->getOrderById('DESC', 25);
        return view('admin.blog.index', $data);
    }

    public function create()
    {
        $data['pageTitle'] = 'Create Blog';
        $data['subNavBlogCreateActiveClass'] = 'active';
        $data['showAdminBlog'] = 'show';
        $data['blogCategories'] = BlogCategory::all();
        $data['tags'] = Tag::all();
        return view('admin.blog.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'min:2', 'max:255'],
            'slug' => ['required', 'min:2', 'max:255'],
            'details' => ['required'],
            'image' => 'mimes:jpeg,png,jpg|file|max:1024'
        ]);

        if (Blog::where('slug', $request->slug)->count() > 0)
        {
            $slug = Str::slug($request->slug) . '-'. rand(100000, 999999);
        } else {
            $slug = Str::slug($request->slug);
        }

        $data = [
            'title' => $request->title,
            'slug' => $slug,
            'details' => $request->details,
            'blog_category_id' => $request->blog_category_id,
            'status' => $request->status ?? 1,
        ];

        $blog = $this->model->create($data); // create new blog

        /*File Manager Call upload*/
        if ($request->image) {
            $new_file = new FileManager();
            $upload = $new_file->upload('Blog', $request->image);

            if ($upload['status']) {
                $upload['file']->origin_id = $blog->id;
                $upload['file']->origin_type = "App\Models\Blog";
                $upload['file']->save();
            }
        }
        /*End*/

        return redirect()->route('admin.blog.index')->with('success', __('Created Successfully'));
    }

    public function edit($uuid)
    {
        $data['pageTitle'] = 'Edit Blog';
        $data['subNavBlogIndexActiveClass'] = 'active';
        $data['showAdminBlog'] = 'show';
        $data['blog'] = $this->model->getRecordByUuid($uuid);
        $data['blogCategories'] = BlogCategory::all();
        $data['tags'] = Tag::all();
        return view('admin.blog.edit', $data);
    }

    public function update(Request $request, $uuid)
    {
        $request->validate([
            'title' => ['required', 'min:2', 'max:255'],
            'slug' => ['required', 'min:2', 'max:255'],
            'details' => ['required'],
            'image' => 'mimes:jpeg,png,jpg|file|max:1024'
        ]);

        if (Blog::where('slug', $request->slug)->where('uuid', '!=', $uuid)->count() > 0)
        {
            $slug = Str::slug($request->slug) . '-'. rand(100000, 999999);
        } else {
            $slug = Str::slug($request->slug);
        }

        $data = [
            'title' => $request->title,
            'slug' => $slug,
            'details' => $request->details,
            'blog_category_id' => $request->blog_category_id,
            'status'=> $request->status ?? 1
        ];

        $blog = $this->model->updateByUuid($data, $uuid); // update category

        /*File Manager Call upload*/
        if ($request->image) {
            $new_file = FileManager::where('origin_type', 'App\Models\Blog')->where('origin_id',$blog->id)->first();

            if ($new_file) {
                $new_file->removeFile();
                $upload = $new_file->upload('Blog', $request->image, null, $new_file->id);
            } else {
                $new_file = new FileManager();
                $upload = $new_file->upload('Blog', $request->image);
            }

            if ($upload['status']) {
                $upload['file']->origin_id = $blog->id;
                $upload['file']->origin_type = "App\Models\Blog";
                $upload['file']->save();
            }
        }
        /*End*/

        return redirect()->route('admin.blog.index')->with('success', __('Updated Successfully'));
    }

    public function delete($uuid)
    {
        $blog = $this->model->getRecordByUuid($uuid);
        $file = FileManager::where('origin_type', 'App\Models\Blog')->where('origin_id', $blog->id)->first();
        if ($file){
            $file->removeFile();
            $file->delete();
        }
        $this->model->deleteByUuid($uuid);

        return redirect()->back()->with('success', __('Blog has been deleted'));
    }

    public function blogCommentList()
    {
        $data['title'] = ' Blog Comments';
        $data['navBlogParentActiveClass'] = 'active';
        $data['subNavBlogCommentListActiveClass'] = 'active';
        $data['showAdminBlog'] = 'show';

        $data['comments'] = BlogComment::all();
        return view('admin.blog.comment-list', $data);

    }

    public function changeBlogCommentStatus(Request $request)
    {
        $comment = BlogComment::findOrFail($request->id);
        $comment->status = $request->status;
        $comment->save();

        return response()->json([
            'data' => 'success',
        ]);
    }

    public function blogCommentDelete($id)
    {
        $comment = BlogComment::findOrFail($id);
        BlogComment::where('parent_id', $id)->delete();
        $comment->delete();

        return redirect()->back()->with('success', __('Blog has been deleted'));
    }
}
