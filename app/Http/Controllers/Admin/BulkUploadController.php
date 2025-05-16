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
use Illuminate\Support\Str;

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
        $request->validate([
            'files.*' => 'required|file|max:102400', // 100MB max
            'titles.*' => 'required|string|max:255',
            'categories.*' => 'required|exists:product_categories,id',
            'prices.*' => 'required|numeric|min:0',
            'accessibility.*' => 'required|in:1,2', // 1=free, 2=paid
            'tags.*' => 'nullable|array',
            'tags.*.*' => 'exists:tags,id'
        ]);

        DB::beginTransaction();
        try {
            $files = $request->file('files');
            $titles = $request->input('titles');
            $categories = $request->input('categories');
            $tags = $request->input('tags');
            $prices = $request->input('prices');
            $accessibility = $request->input('accessibility');
            
            $successCount = 0;
            $failedCount = 0;
            $failedItems = [];

            foreach ($files as $index => $file) {
                try {
                    $category = ProductCategory::find($categories[$index]);
                    if (!$category) {
                        $failedCount++;
                        $failedItems[] = [
                            'title' => $titles[$index],
                            'reason' => 'Invalid category'
                        ];
                        continue;
                    }

                    // Check if title is unique
                    if (Product::where('title', $titles[$index])->exists()) {
                        $titles[$index] = $titles[$index] . '-' . Str::random(6);
                    }

                    // Validate file type against category requirements
                    $fileExtension = strtolower($file->getClientOriginalExtension());
                    $productType = ProductType::find($category->product_type_id);
                    
                    if ($productType && !$productType->product_type_extensions->where('name', $fileExtension)->count()) {
                        $failedCount++;
                        $failedItems[] = [
                            'title' => $titles[$index],
                            'reason' => 'File type not allowed for this category'
                        ];
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
                        'file_types' => $fileExtension,
                        'status' => ACTIVE
                    ];

                    if ($item['accessibility'] == PRODUCT_ACCESSIBILITY_FREE) {
                        $item['use_this_photo'] = 1;
                    }

                    $result = $this->productUploadService->store($item, 1);
                    if ($result['status']) {
                        $successCount++;
                    } else {
                        $failedCount++;
                        $failedItems[] = [
                            'title' => $titles[$index],
                            'reason' => $result['message'] ?? 'Upload failed'
                        ];
                    }
                } catch (Exception $e) {
                    Log::error('Bulk upload error for file ' . $file->getClientOriginalName() . ': ' . $e->getMessage());
                    $failedCount++;
                    $failedItems[] = [
                        'title' => $titles[$index] ?? 'Unknown',
                        'reason' => 'System error: ' . $e->getMessage()
                    ];
                }
            }

            DB::commit();

            $message = "Successfully uploaded {$successCount} products.";
            if ($failedCount > 0) {
                $message .= " Failed to upload {$failedCount} products:";
                foreach ($failedItems as $item) {
                    $message .= "\n- {$item['title']}: {$item['reason']}";
                }
            }

            return redirect()->route('admin.product.bulk-upload.index')
                ->with('success', $message)
                ->with('failed_items', $failedItems);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Bulk upload error: ' . $e->getMessage());
            return redirect()->route('admin.product.bulk-upload.index')
                ->with('error', 'An error occurred during bulk upload: ' . $e->getMessage());
        }
    }
}
