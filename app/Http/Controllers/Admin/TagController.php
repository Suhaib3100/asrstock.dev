<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TagRequest;
use App\Models\Tag;
use App\Tools\Repositories\Crud;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{

    protected $model;

    public function __construct(Tag $tag)
    {
        $this->model = new Crud($tag);
    }

    public function index(Request $request)
    {
        $data['pageTitle'] = 'Tag List';
        $data['subNavTagActiveClass'] = 'active';
        $data['showProducts'] = 'show';
        $data['tags'] = Tag::where(function ($q) use ($request) {
            if ($request->search_string) {
                $q->where('name', 'like', "%{$request->search_string}%");
            }
            if ($request->search_status == 1) {
                $q->active();
            } elseif($request->search_status == 2) {
                $q->disable();
            }
        })->latest()->get();

        if ($request->ajax()) {
            return view('admin.product.partial.render-tag-list')->with($data);
        }

        return view('admin.product.tag', $data);
    }

    public function store(TagRequest $request)
    {
        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ];
        $this->model->create($data); // create new category
        return redirect()->back()->with('success', __('Created Successfully'));
    }

    public function update(TagRequest $request, $uuid)
    {
        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->status,
        ];
        $this->model->updateByUuid($data, $uuid); // update tag
        return redirect()->back()->with('success', __('Updated Successfully'));
    }

    public function delete($uuid)
    {
        $this->model->deleteByUuid($uuid); // delete record

        return redirect()->back()->with('success', __('Tag has been deleted'));
    }
}
