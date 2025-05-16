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
use ZipArchive;

class BulkUploadController extends Controller
{
    use ApiStatusTrait;

    // Product Status Constants
    const PRODUCT_STATUS_ACTIVE = 1;
    const PRODUCT_STATUS_INACTIVE = 0;
    const PRODUCT_STATUS_PENDING = 2;

    // Product Accessibility Constants
    const PRODUCT_ACCESSIBILITY_FREE = 'free';
    const PRODUCT_ACCESSIBILITY_PAID = 'paid';

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

            // Process CSV using native PHP functions
            $handle = fopen($csvFile, 'r');
            if ($handle === false) {
                throw new \Exception('Could not open CSV file');
            }

            // Read headers
            $headers = fgetcsv($handle);
            if ($headers === false) {
                throw new \Exception('Invalid CSV format');
            }

            // Validate required headers
            $requiredHeaders = ['filename', 'title'];
            $missingHeaders = array_diff($requiredHeaders, $headers);
            if (!empty($missingHeaders)) {
                throw new \Exception('Missing required headers: ' . implode(', ', $missingHeaders));
            }

            $processed = 0;
            $errors = [];
            $categoryId = $request->category_id;

            // Process each row
            while (($record = fgetcsv($handle)) !== false) {
                try {
                    $data = array_combine($headers, $record);
                    
                    // Validate required fields
                    if (empty($data['filename']) || empty($data['title'])) {
                        throw new \Exception('Missing required fields');
                    }

                    // Clean filename - remove any commas and trim
                    $data['filename'] = trim(str_replace(',', '', $data['filename']));

                    // Check if file exists in ZIP
                    $filePath = $tempPath . '/' . $data['filename'];
                    if (!file_exists($filePath)) {
                        throw new \Exception('File not found in ZIP: ' . $data['filename']);
                    }

                    // Process tags
                    $tagIds = [];
                    if (!empty($data['tags'])) {
                        $tagNames = array_map('trim', explode(',', $data['tags']));
                        foreach ($tagNames as $tagName) {
                            $tagName = trim($tagName);
                            if (!empty($tagName)) {
                                $tag = Tag::firstOrCreate(
                                    ['name' => $tagName],
                                    [
                                        'slug' => Str::slug($tagName),
                                        'uuid' => Str::uuid()
                                    ]
                                );
                                $tagIds[] = $tag->id;
                            }
                        }
                    }

                    // Create product
                    $product = new Product();
                    $product->title = $data['title'];
                    $product->slug = Str::slug($data['title']);
                    $product->category_id = $categoryId;
                    $product->price = $data['price'] ?? 0;
                    $product->accessibility = $data['accessibility'] ?? PRODUCT_ACCESSIBILITY_PAID;
                    $product->status = PRODUCT_STATUS_ACTIVE;
                    $product->save();

                    // Attach tags
                    if (!empty($tagIds)) {
                        $product->tags()->attach($tagIds);
                    }

                    // Move file to storage
                    $extension = pathinfo($data['filename'], PATHINFO_EXTENSION);
                    $newFilename = 'products/' . $product->id . '.' . $extension;
                    Storage::put($newFilename, file_get_contents($filePath));
                    $product->file = $newFilename;
                    $product->save();

                    $processed++;
                } catch (\Exception $e) {
                    $errors[] = "Row {$processed}: " . $e->getMessage();
                }
            }

            fclose($handle);

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
                'filename',      // Required: Name of the image file in the ZIP
                'title',         // Required: Product title
                'price',         // Optional: Product price (default: 0)
                'accessibility', // Optional: free/paid (default: paid)
                'tags'          // Optional: Comma-separated tags
            ]);

            // Add example rows
            fputcsv($file, [
                'product1.jpg',
                'Beautiful Sunset Landscape',
                '19.99',
                'paid',
                'nature, sunset, landscape'
            ]);

            fputcsv($file, [
                'product2.jpg',
                'Mountain View',
                '29.99',
                'paid',
                'mountain, nature, landscape'
            ]);

            fputcsv($file, [
                'product3.jpg',
                'Free Beach Photo',
                '0',
                'free',
                'beach, ocean, summer'
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
