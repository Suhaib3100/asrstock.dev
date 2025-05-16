<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkUploadRequest;
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
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
        $data['pageTitle'] = 'Product Bulk Upload';
        $data['subNavProductBulkUploadActiveClass'] = 'active';
        $data['showProducts'] = 'show';
        return view('admin.product.bulk-upload', $data);
    }

    public function product_bulk_upload_file(BulkUploadRequest $request)
    {
        DB::beginTransaction();
        try {
            if (is_dir(storage_path("app\unzip\public\\"))) {
                rmdir(storage_path("app\unzip\public\\"));
            }
            $zip = new ZipArchive();
            $status = $zip->open($request->file("bulk_upload_file")->getRealPath());
            if ($status !== true) {
                throw new \Exception($status);
            } else {
                $storageDestinationPath = storage_path("app\public\unzip\\");

                if (!file_exists($storageDestinationPath)) {
                    mkdir($storageDestinationPath, 0755, true);
                }
                $zip->extractTo($storageDestinationPath);
                $zip->close();
            }
            DB::commit();
            return redirect()->route('admin.product.bulk-upload.check');
        } catch (Exception $e) {
            Log::info($e);
            DB::rollBack();
            return redirect()->route('admin.product.bulk-upload.index')->with('error', __('Something Went Wrong'));
        }
    }

    public function product_bulk_upload_check()
    {
        DB::beginTransaction();
        try {
            $getCsvFile = asset("storage/unzip/sample/mapping.csv");
            $handle = fopen($getCsvFile, 'r');
            $productTypes = ProductType::with('product_type_extensions')->get();
            if ($handle !== false) {
                while (($line = fgets($handle)) !== false) {

                    $row =  explode('|', $line);
                    $type = ProductType::whereRaw('LOWER(`name`) LIKE ? ', [trim(strtolower($row[5])) . '%'])->first();
                    $category = ProductCategory::whereRaw('LOWER(`name`) LIKE ? ', [trim(strtolower($row[6])) . '%'])->first();
                    $tagIds = Tag::whereIn('name', explode(',', $row[7]))->select('id')->pluck('id')->toArray();

                    // Value Assign
                    $value['title'] = $row[0];
                    $value['thumbnail'] = asset("storage/unzip/sample/" . $row[1]);
                    $value['thumbnailName'] = $row[1];
                    $value['variation'] = $row[2];
                    $value['price'] = $row[3];
                    $value['file'] = asset("storage/unzip/sample/" . $row[4]);
                    $value['fileName'] = $row[4];
                    $value['type'] = $type->id ?? null;
                    $value['category'] = $category->id ?? null;
                    $value['tags'] = $tagIds ?? [];
                    $value['status'] = DISABLE;
                    $value['file_types'] = "";

                    if(file_exists(storage_path("app/public/unzip/sample/". $row[4]))){
                        $pathInfo = pathinfo(storage_path("app/public/unzip/sample/". $row[4]));
                        $extension = $pathInfo['extension'];
                        $productType = $productTypes->where('id', $value['type'])->first();
                        if(!is_null($productType)){
                            $productTypeExtension =$productType->product_type_extensions->where('name', $extension)->first();
                            if(!is_null($productTypeExtension)){
                                if($value['thumbnailName'] == ""){
                                    $value['status'] = ACTIVE;
                                    $value['file_types'] = $productTypeExtension->name;
                                }
                                elseif(file_exists(storage_path("app/public/unzip/sample/". $value['thumbnailName']))){
                                    $value['status'] = ACTIVE;
                                    $value['file_types'] = $productTypeExtension->name;
                                }
                            }
                        }
                    }
                    // Items
                    $data['items'][] = $value;
                }
            } else {
                throw new Exception('Mapping File Mismatch');
            }

            fclose($handle);
            DB::commit();
            $data['pageTitle'] = 'Product Bulk Upload Check';
            $data['productTypes'] = ProductType::active()->get();
            $data['tags'] = Tag::all();
            $data['subNavProductBulkUploadActiveClass'] = 'active';
            $data['showProducts'] = 'show';
            return view('admin.product.bulk-upload-check', $data);
        } catch (Exception $e) {
            Log::info($e);
            DB::rollBack();
            return redirect()->route('admin.product.bulk-upload.index')->with('error', __('Something Went Wrong'));
        }
    }

    public function product_bulk_upload_confirm(Request $request)
    {
        foreach ($request->items as $item) {
            if($item['status'] == 1 && $item['file_name'] != ""){
                $category = ProductCategory::find($item['category']);
                if(!is_null($category)){
                    $item['product_category_id'] = $category->id;
                    $item['product_type_id'] = $category->product_type_id;
                    $item['accessibility'] = $item['price'] == 0 ? PRODUCT_ACCESSIBILITY_FREE : PRODUCT_ACCESSIBILITY_PAID;
                    if( $item['accessibility'] == PRODUCT_ACCESSIBILITY_FREE){
                        $item['use_this_photo'] = 1;
                    }


                    if(!isset($item['thumbnail_image'])){
                        if($item['thumbnail_image_path'] != ""){
                            $uploadedMainFile = new UploadedFile(storage_path("app/public/unzip/sample/".$item['thumbnail_image_path']), $item['title'].'_thumb.'.$item['file_types']);
                            $item['thumbnail_image'] = $uploadedMainFile;
                        }
                        else{
                            $item['thumbnail_image'] = "";
                        }

                    }
                    else{
                        $item['thumbnail_image'] = $item['thumbnail_image'];
                    }

                    if(!isset($item['file'])){
                        $uploadedMainFile = new UploadedFile(storage_path("app/public/unzip/sample/".$item['file_name']), $item['title'].'.'.$item['file_types']);
                        $item['main_files'][] = $uploadedMainFile;
                    }
                    else{
                        $item['main_files'][] = $item['file'];
                    }

                    $item['variations'][] = $item['variation'];
                    $item['prices'][] = $item['price'];
                    unset($item['status']);
                    $this->productUploadService->store($item, 1);
                }

            }
        }

        return redirect()->route('admin.product.bulk-upload.index')->with('success', __('Created Successfully'));
    }
}
