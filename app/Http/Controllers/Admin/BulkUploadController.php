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
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use League\Csv\Reader;
use ZipArchive;

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
        $pageTitle = 'Bulk Upload Products';
        $productTypes = ProductType::with('categories')->get();
        return view('admin.product.bulk-upload', compact('pageTitle', 'productTypes'));
    }

    public function product_bulk_upload_file(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'zip_file' => 'required|file|mimes:zip|max:512000', // 500MB max
            'category_id' => 'required|exists:product_categories,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            $zipFile = $request->file('zip_file');
            $tempPath = storage_path('app/temp/' . uniqid());
            mkdir($tempPath, 0755, true);

            // Extract ZIP file
            $zip = new ZipArchive;
            if ($zip->open($zipFile->getPathname()) === TRUE) {
                $zip->extractTo($tempPath);
                $zip->close();
            } else {
                throw new \Exception('Failed to extract ZIP file');
            }

            // Find CSV file
            $csvFile = null;
            foreach (glob($tempPath . '/*.csv') as $file) {
                $csvFile = $file;
                break;
            }

            if (!$csvFile) {
                throw new \Exception('No CSV file found in the ZIP');
            }

            // Process CSV
            $csv = Reader::createFromPath($csvFile, 'r');
            $csv->setHeaderOffset(0);
            $records = $csv->getRecords();

            $processed = 0;
            $errors = [];
            $categoryId = $request->category_id;

            foreach ($records as $record) {
                try {
                    // Validate required fields
                    if (empty($record['filename']) || empty($record['title'])) {
                        throw new \Exception('Missing required fields');
                    }

                    // Check if file exists in ZIP
                    $filePath = $tempPath . '/' . $record['filename'];
                    if (!file_exists($filePath)) {
                        throw new \Exception('File not found in ZIP: ' . $record['filename']);
                    }

                    // Process tags
                    $tagIds = [];
                    if (!empty($record['tags'])) {
                        $tagNames = array_map('trim', explode(',', $record['tags']));
                        foreach ($tagNames as $tagName) {
                            $tag = Tag::firstOrCreate(['name' => $tagName]);
                            $tagIds[] = $tag->id;
                        }
                    }

                    // Create product
                    $product = new Product();
                    $product->title = $record['title'];
                    $product->category_id = $categoryId;
                    $product->price = $record['price'] ?? 0;
                    $product->accessibility = $record['accessibility'] ?? PRODUCT_ACCESSIBILITY_PAID;
                    $product->status = PRODUCT_STATUS_ACTIVE;
                    $product->save();

                    // Attach tags
                    if (!empty($tagIds)) {
                        $product->tags()->attach($tagIds);
                    }

                    // Move file to storage
                    $extension = pathinfo($record['filename'], PATHINFO_EXTENSION);
                    $newFilename = 'products/' . $product->id . '.' . $extension;
                    Storage::put($newFilename, file_get_contents($filePath));
                    $product->file = $newFilename;
                    $product->save();

                    $processed++;
                } catch (\Exception $e) {
                    $errors[] = "Row {$processed}: " . $e->getMessage();
                }
            }

            // Cleanup
            $this->rrmdir($tempPath);

            return response()->json([
                'success' => true,
                'message' => "Successfully processed {$processed} products" . 
                            (!empty($errors) ? ". Errors: " . implode(', ', $errors) : ''),
                'redirect' => route('admin.product.index')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing upload: ' . $e->getMessage()
            ]);
        }
    }

    public function product_bulk_upload_template()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="bulk_upload_template.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, [
                'filename',
                'title',
                'price',
                'accessibility',
                'tags'
            ]);

            // Add example row
            fputcsv($file, [
                'example.jpg',
                'Example Product',
                '0',
                'free',
                'tag1, tag2, tag3'
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . "/" . $object)) {
                        $this->rrmdir($dir . "/" . $object);
                    } else {
                        unlink($dir . "/" . $object);
                    }
                }
            }
            rmdir($dir);
        }
    }
}
