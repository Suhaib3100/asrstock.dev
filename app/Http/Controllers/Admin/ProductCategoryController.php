<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\ProductType;
use App\Tools\Repositories\Crud;
use App\Traits\ApiStatusTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    protected $model;
    use ApiStatusTrait;
    public function __construct(ProductCategory $product_category)
    {
        $this->model = new Crud($product_category);
    }

    public function index(Request $request)
    {
        $data['pageTitle'] = 'Category List';
        $data['subNavCategoryIndexActiveClass'] = 'active';
        $data['showProducts'] = 'show';
        $data['productTypes'] = ProductType::all();

        $data['categories'] = ProductCategory::where(function ($q) use ($request) {
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
            return view('admin.product.partial.render-category-list')->with($data);
        }

        return view('admin.product.category', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:product_categories,name',
        ]);

        $data = [
            'name' => $request->name,
            'product_type_id' => $request->product_type_id,
            'slug' => Str::slug($request->name),
            'status' => $request->status ?? 1,
        ];

        $this->model->create($data); // create new

        return redirect()->back()->with('success', 'Created Successfully');
    }

    public function update(Request $request, $uuid)
    {
        $productCategory = $this->model->getRecordByUuid($uuid);

        $this->validate($request, [
            'name' => 'required|unique:product_categories,name,'. $productCategory->id,
            'status' => 'required'
        ]);

        $data = [
            'name' => $request->name,
            'product_type_id' => $request->product_type_id,
            'slug' =>  Str::slug($request->name),
            'status' => $request->status,
        ];

        $this->model->updateByUuid($data, $uuid); // update category

        return redirect()->back()->with('success', __('Updated Successfully'));
    }

    public function delete($uuid)
    {
        $this->model->deleteByUuid($uuid);
        return redirect()->back()->with('success', __('Deleted Successfully'));
    }

    public function changeStatus(Request $request)
    {
        if(env('APP_DEMO') == 'active'){
            $response['message'] = 'This is a demo version! You can get full access after purchasing the application.';
            return $this->notAllowedApiResponse($response);
        }
        $productCategory = ProductCategory::findOrFail($request->id);
        $productCategory->status = $request->status;
        $productCategory->save();

        $response['message'] = 'Success';
        return $this->successApiResponse($response);
    }

}
