<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Meta;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Tag;
use App\Tools\Repositories\Crud;
use App\Traits\ApiStatusTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MetaManagementController extends Controller
{
    use ApiStatusTrait;

    protected $metaModel;

    public function __construct(Meta $meta)
    {
        $this->metaModel = new Crud($meta);
    }

    public function metaIndex()
    {
        $data['pageTitle'] = 'Meta Management';
        $data['navSettingsActiveClass'] = 'active';
        $data['subMetaIndexActiveClass'] = 'active';

        $data['metas'] = $this->metaModel->getOrderById('DESC', 25);
        return view('admin.setting.general.meta_manage.index', $data);
    }

    public function add()
    {
        $data['pageTitle'] = 'Add Meta';
        $data['navSettingsActiveClass'] = 'active';
        $data['subMetaIndexActiveClass'] = 'active';
        return view('admin.setting.general.meta_manage.add', $data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'page_type' => 'required',
            'page' => 'required|unique:metas,page,NULL,id,page_type,' . $request->page_type,
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keyword' => 'required',
        ]);

        if ($request->page_type == META_TYPE_PAGE) {
            $data['page_name'] = getPageName($request->page_type);
        } elseif ($request->page_type == META_TYPE_PRODUCT) {
            $data['page_name'] = Product::select('id', 'title as name')->findOrFail($request->page)->name;
        } elseif ($request->page_type == META_TYPE_PRODUCT_CATEGORY) {
            $data['page_name'] = ProductCategory::select('name')->findOrFail($request->page)->name;
        } elseif ($request->page_type == META_TYPE_PRODUCT_TAG) {
            $data['page_name'] = Tag::select('name')->findOrFail($request->page)->name;
        } elseif ($request->page_type == META_TYPE_BLOG_CATEGORY) {
            $data['page_name'] = BlogCategory::select('name')->findOrFail($request->page)->name;
        } elseif ($request->page_type == META_TYPE_BLOG) {
            $data['page_name'] = Blog::select('title as name')->findOrFail($request->page)->name;
        }

        try {
            $this->metaModel->create($data);
            $response['message'] = 'Success';
            return $this->success($response, __('Created Successfully'));
        } catch (Exception $e) {
            return $this->failed([],  $e);
        }
    }

    public function editMeta($uuid)
    {
        $data['pageTitle'] = 'Edit Meta';
        $data['navSettingsActiveClass'] = 'active';
        $data['subMetaIndexActiveClass'] = 'active';
        $data['meta'] = $this->metaModel->getRecordByUuid($uuid);
        return view('admin.setting.general.meta_manage.edit', $data);
    }

    public function updateMeta(Request $request, $uuid)
    {
        $data = $request->validate([
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_keyword' => 'required',
        ]);

        try {
            $this->metaModel->updateByUuid($data, $uuid);
            $response['message'] = 'Success';
            return $this->success($response, __('Updated Successfully'));
        } catch (Exception $e) {
            return $this->failed([],  $e);
        }
    }

    public function delete($uuid)
    {
        $this->metaModel->deleteByUuid($uuid); // delete record

        return redirect()->back()->with('success', __('Deleted Successfully'));
    }

    public function getPage(Request $request)
    {
        $data['items'] = [];
        if ($request->type == META_TYPE_PRODUCT_CATEGORY) {
            $data['items'] = ProductCategory::select('id', 'name')->get();
        } elseif ($request->type == META_TYPE_PRODUCT_TAG) {
            $data['items'] = Tag::select('id', 'name')->get();
        } elseif ($request->type == META_TYPE_PRODUCT) {
            $data['items'] = DB::table('products')->select('id', 'title as name')->get();
        } elseif ($request->type == META_TYPE_BLOG_CATEGORY) {
            $data['items'] = BlogCategory::select('id', 'name')->get();
        } elseif ($request->type == META_TYPE_BLOG) {
            $data['items'] = Blog::select('id', 'title as name')->get();
        } elseif ($request->type == META_TYPE_PAGE) {
            $data['items'] = getPageName();
        }

        return $this->success($data['items']);
    }
}
