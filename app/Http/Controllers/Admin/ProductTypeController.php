<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FileManager;
use App\Models\ProductType;
use App\Models\ProductTypeExtension;
use App\Traits\ApiStatusTrait;
use Exception;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    use ApiStatusTrait;
    public function index()
    {
        $data['pageTitle'] = 'Product Type List';
        $data['subNavProductTypeActiveClass'] = "active";
        $data['showProducts'] = 'show';
        $data['productTypes'] = ProductType::with('product_type_extensions')->get();
        $data['productTypeCategories'] = getProductTypeCategory();
        $data['productTypeExtensions'] = ProductTypeExtension::whereStatus(ACTIVE)->get();
        return view('admin.product.product-type', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required',
            'product_type_category' => 'required',
            'product_type_extension.0' => 'required',
            'product_type_extension.*' => 'required',
        ],[
            'product_type_extension.*.required' => __('This field is required')
        ]);

        try {
            $uuid = $request->get('uuid', '');
            if ($uuid != '') {
                $type = ProductType::where('uuid', $request->uuid)->firstOrFail();
            } else {
                $type = new ProductType();
            }
            $type->name = $request->name;
            $type->product_type_category = $request->product_type_category;
            $type->status = $request->status;
            $type->save();

            if ($request->hasFile('icon')) {
                /*File Manager Call upload*/
                $new_file = FileManager::where('origin_type', 'App\Models\ProductType')->where('origin_id', $type->id)->first();
                if ($new_file) {
                    $new_file->removeFile();
                    $new_file->delete();
                } else {
                    $new_file = new FileManager();
                }
                $upload = $new_file->upload('ProductType', $request->icon);
                if ($upload['status']) {
                    $upload['file']->origin_id = $type->id;
                    $upload['file']->origin_type = "App\Models\ProductType";
                    $upload['file']->save();
                }
            }

            $type->product_type_extensions()->sync($request->product_type_extension);
            $response['message'] = 'Success';
            return $this->success($response, ($uuid ? __('Updated Successfully') :__('Created Successfully')));
        } catch (Exception $e) {
            return $this->failed([],  $e);
        }
    }

    public function changeStatus(Request $request)
    {


        $productType = ProductType::findOrFail($request->id);
        $productType->status = $request->status;
        $productType->save();

        $response['message'] = 'Success';
        return $this->successApiResponse($response);
    }

    public function delete($uuid)
    {
        ProductType::where('uuid', $uuid)->firstOrFail()->delete();
        return redirect()->back()->with('success', __('Deleted Successfully'));
    }
}
