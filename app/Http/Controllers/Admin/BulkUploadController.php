<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductType;
use App\Models\Tag;
use App\Services\ProductUploadService;
use App\Tools\Repositories\Crud;
use App\Traits\ApiStatusTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BulkUploadController extends Controller
{
    use ApiStatusTrait;
    public $model;
    public $productUploadService;
    
    public function __construct(Product $product)
    {
        $this->model = new Crud($product);
        $this->productUploadService = new ProductUploadService;
    }

    public function product_bulk_upload()
    {
        $data['pageTitle'] = 'Product Bulk Upload';
        $data['subNavProductBulkUploadActiveClass'] = 'active';
        $data['showProducts'] = 'show';
        $data['productTypes'] = ProductType::active()->get();
        $data['tags'] = Tag::all();
        return view('admin.product.bulk-upload', $data);
    }

    public function product_bulk_upload_store(Request $request)
    {
        DB::beginTransaction();
        try {
            $files = $request->file('files');
            $titles = $request->input('titles');
            $categories = $request->input('categories');
            $tags = $request->input('tags');
            $prices = $request->input('prices');
            $accessibility = $request->input('accessibility');
            
            foreach ($files as $index => $file) {
                $category = ProductCategory::find($categories[$index]);
                if (!$category) {
                    continue;
                }

                $item = [
                    'title' => $titles[$index],
                    'product_type_id' => $category->product_type_id,
                    'product_category_id' => $category->id,
                    'tags' => $tags[$index] ?? [],
                    'accessibility' => $accessibility[$index] ?? PRODUCT_ACCESSIBILITY_PAID,
                    'price' => $prices[$index] ?? 0,
                    'main_files' => [$file],
                    'file_types' => $file->getClientOriginalExtension(),
                    'status' => ACTIVE
                ];

                if ($item['accessibility'] == PRODUCT_ACCESSIBILITY_FREE) {
                    $item['use_this_photo'] = 1;
                }

                $this->productUploadService->store($item, 1);
            }

            DB::commit();
            return redirect()->route('admin.product.bulk-upload.index')->with('success', __('Products uploaded successfully'));
        } catch (Exception $e) {
            Log::error($e);
            DB::rollBack();
            return redirect()->route('admin.product.bulk-upload.index')->with('error', __('Something went wrong'));
        }
    }
}
