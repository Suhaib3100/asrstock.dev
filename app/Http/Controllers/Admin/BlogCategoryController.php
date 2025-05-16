<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Tools\Repositories\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    protected $model;
    public function __construct(BlogCategory $category)
    {
        $this->model = new Crud($category);
    }

    public function index()
    {

        $data['pageTitle'] = 'Manage Blog Category';
        $data['navBlogActiveClass'] = "active";
        $data['subNavBlogCategoryIndexActiveClass'] = "active";
        $data['showAdminBlog'] = 'show';
        $data['blogCategories'] = $this->model->getOrderById('DESC', 25);
        return view('admin.blog.category-index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $slug = Str::slug($request->name);

        if (BlogCategory::where('slug', $slug)->count() > 0)
        {
            $slug = Str::slug($request->name) . '-'. rand(100000, 999999);
        }

        $data = [
            'name' => $request->name,
            'slug' => $slug,
            'status' => $request->status ?? 1,
        ];

        $this->model->create($data); // create new blog

        return redirect()->back()->with('success', __('Created Successfully'));
    }

    public function update(Request $request, $uuid)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'status' => $request->status ?? 1,
        ];

        $this->model->updateByUuid($data, $uuid); // update category

        return redirect()->back()->with('success', __('Updated Successfully'));
    }

    public function delete($uuid)
    {
        $this->model->deleteByUuid($uuid); // delete record
        return redirect()->back()->with('error', __('Blog has been deleted'));
    }
}
