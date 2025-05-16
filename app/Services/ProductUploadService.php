<?php

namespace App\Services;

use App\Models\FileManager;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductVariation;
use App\Traits\ApiStatusTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use ZipArchive;

class ProductUploadService
{
    use ApiStatusTrait;

    public function store($item, $uploadedBy = 2)
    {
        DB::beginTransaction();
        try {
            if (Product::where('slug', getSlug($item['title']))->count() > 0) {
                $slug = getSlug($item['title']) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($item['title']);
            }

            if ($uploadedBy == 1) {
                $userId = auth()->id();
                $customerId = null;
            } else {
                $userId = null;
                $customerId = auth()->id();
            }

            $data = [
                'title' => $item['title'],
                'slug' => $slug,
                'description' => $item['description'] ?? "",
                'accessibility' => $item['accessibility'],
                'status' => isset($item['status']) && $item['status'] != "" ? $item['status'] : PENDING,
                'uploaded_by' => $uploadedBy,
                'product_type_id' => $item['product_type_id'],
                'product_category_id' => $item['product_category_id'],
                'user_id' => $userId,
                'customer_id' => $customerId,
                'file_types' => $item['file_types'],
                'use_this_photo' => isset($item['use_this_photo']) && $item['use_this_photo'] != NULL ? $item['use_this_photo'] : NULL,
                'attribution_required' => $item['accessibility'] == 2 && isset($item['attribution_required']) && $item['attribution_required'] == 1 ? 1 : 0,
                'tax_id' => isset($item['tax_id']) && $item['tax_id'] != "" ? $item['tax_id'] : NULL,
            ];

            $product = Product::create($data);

            if (isset($item['tags'])) {
                foreach ($item['tags'] ?? [] as $tag) {
                    $product->productTags()->create([
                        'tag_id' => $tag
                    ]);
                }
            }

            if ($item['accessibility'] == DOWNLOAD_ACCESSIBILITY_TYPE_PAID) {
                $item['image'] = isset($item['thumbnail_image']) && $item['thumbnail_image'] != "" ? $item['thumbnail_image'] : current($item['main_files']);
                foreach ($item['variations'] ?? [] as $index => $variation) {

                    /*File Manager Call upload for Main File (Zip)*/
                    $extension = pathinfo($item['main_files'][$index]->getClientOriginalName(), PATHINFO_EXTENSION);
                    if ($extension !== 'zip') {
                        $getFileName = $item['main_files'][$index]->getClientOriginalName();
                        $getFileName = pathinfo($getFileName, PATHINFO_FILENAME);
                        $zipFileName = $getFileName . '.zip';
                        $zipFileName = str_replace(' ', '_', $zipFileName);

                        if (!file_exists(storage_path("app/public/unzip/sample"))) {
                            mkdir(storage_path("app/public/unzip/sample"), 0777, true);
                        }

                        $zip = new ZipArchive();
                        $zip->open(storage_path("app/public/unzip/sample/" . $zipFileName), ZipArchive::CREATE);
                        $zip->addFile($item['main_files'][$index], $getFileName . '.' . $extension);
                        $zip->close();

                        $uploadedMainFile = new UploadedFile(storage_path("app/public/unzip/sample/" . $zipFileName), $zipFileName);
                    } else {
                        $uploadedMainFile = $item['main_files'][$index];
                    }

                    $newMainFile = new FileManager();
                    $upload = $newMainFile->upload('Product', $uploadedMainFile, $slug, null,false, true);

                    if ($upload['status']) {
                        $upload['file']->origin_type = "App\Models\ProductVariation";
                        $upload['file']->save();

                        $variation = $product->variations()->create([
                            'variation' => $variation,
                            'price' => $item['prices'][$index],
                            'file' => $upload['file']->id,
                        ]);
                    } else {
                        throw new Exception($upload['message']);
                    }

                    if (isset($zipFileName) && file_exists(storage_path("app/public/unzip/sample/" . $zipFileName))) {
                        unlink(storage_path("app/public/unzip/sample/" . $zipFileName));
                    }
                    /*End Main File (Zip)*/
                }
            } else {
                $item['image'] = isset($item['thumbnail_image']) && $item['thumbnail_image'] != "" ? $item['thumbnail_image'] : $item['main_file'];

                /*File Manager Call upload for Main File (Zip)*/
                $extension = pathinfo($item['main_file']->getClientOriginalName(), PATHINFO_EXTENSION);
                if ($extension !== 'zip') {
                    $getFileName = $item['main_file']->getClientOriginalName();
                    $getFileName = pathinfo($getFileName, PATHINFO_FILENAME);
                    $zipFileName = $getFileName . '.zip';
                    $zipFileName = str_replace(' ', '_', $zipFileName);

                    if (!file_exists(storage_path("app/public/unzip/sample"))) {
                        mkdir(storage_path("app/public/unzip/sample"), 0777, true);
                    }

                    $zip = new ZipArchive();
                    $zip->open(storage_path("app/public/unzip/sample/" . $zipFileName), ZipArchive::CREATE);
                    $zip->addFile($item['main_file'], $getFileName . '.' . $extension);
                    $zip->close();

                    $uploadedMainFile = new UploadedFile(storage_path("app/public/unzip/sample/" . $zipFileName), $zipFileName);
                } else {
                    $uploadedMainFile = $item['main_file'];
                }

                $newMainFile = new FileManager();
                $upload = $newMainFile->upload('Product', $uploadedMainFile, $slug, null,false, true);

                if ($upload['status']) {
                    $upload['file']->origin_type = "App\Models\ProductVariation";
                    $upload['file']->save();

                    $variation = $product->variations()->create([
                        'variation' => 'Main File',
                        'file' => $upload['file']->id,
                    ]);
                } else {
                    throw new Exception($upload['message']);
                }

                if (isset($zipFileName) && file_exists(storage_path("app/public/unzip/sample/" . $zipFileName))) {
                    unlink(storage_path("app/public/unzip/sample/" . $zipFileName));
                }
                /*End Main File (Zip)*/
            }

            // START thumbnail image

            if (isset($item['image']) && $item['image'] != NULL && $item['image'] != "") {
                /*File Manager Call upload for Thumbnail Image*/
                $new_file = new FileManager();
                $extension = pathinfo($item['image']->getClientOriginalName(), PATHINFO_EXTENSION);

                if (in_array($extension, ['jpeg', 'jpg', 'png', 'gif', 'tif', 'bmp', 'ico', 'psd', 'webp'])) {
                    $upload = $new_file->upload('Product', $item['image'], $product->slug, null, getOption('watermark_status', false));
                } else {
                    throw new Exception(__('Invalid Thumbnail'));
                }

                if ($product->content_type == 'video' || $product->content_type == 'audio' || $product->content_type == 'Video' || $product->content_type == 'sound') {
                    if ($item['accessibility'] == DOWNLOAD_ACCESSIBILITY_TYPE_PAID) {
                        $upload_play_file = $new_file->upload('Product', $item['main_files'][0], $product->slug, null,false, false);
                    } else {
                        $upload_play_file = $new_file->upload('Product', $item['main_file'], $product->slug, null,false, false);
                    }
                }

                if ($upload['status']) {
                    $upload['file']->origin_type = "App\Models\Product";
                    $upload['file']->save();

                    /*if relation need to be saved in main model*/
                    $product->thumbnail_image_id = $upload['file']->id;
                    if (isset($upload_play_file)) {
                        $product->play_file = $upload_play_file['file']->id;
                    }
                    $product->save();
                    /*in file manager model relation*/

                    if ($product->content_type == 'image') {
                        $getColorPlates = getColorPlate($item['image']);
                        foreach ($getColorPlates as $value) {
                            $productColor = new ProductColor();
                            $productColor->product_id = $product->id;
                            $productColor->color_code = $value;
                            $productColor->save();
                        }
                    }
                } else {
                    throw new Exception($upload['message']);
                }

                /*End Thumbnail Image*/
            }

            DB::commit();
            return $this->success([], __("Created successfully"));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->failed([], $e->getMessage());
        }
    }

    public function update($item, $uuid)
    {
        DB::beginTransaction();
        try {

            $product = Product::where('uuid', $uuid)->firstOrFail();

            $slug = $product->slug;

            $data = [
                'title' => $item['title'],
                'description' => $item['description'],
                'accessibility' => $item['accessibility'],
                'status' => isset($item['status']) && $item['status'] != "" ? $item['status'] : $product->status,
                'product_type_id' => $item['product_type_id'],
                'product_category_id' => $item['product_category_id'],
                'file_types' => $item['file_types'],
                'use_this_photo' => isset($item['use_this_photo']) && $item['use_this_photo'] != NULL && $item['use_this_photo'] != "" ? $item['use_this_photo'] : NULL,
                'attribution_required' => $item['accessibility'] == 2 && isset($item['attribution_required']) && $item['attribution_required'] == 1 ? 1 : 0,
                'tax_id' => isset($item['tax_id']) && $item['tax_id'] != "" ? $item['tax_id'] : NULL,
            ];

            $product->update($data);
            $product->productTags()->delete();
            if (isset($item['tags'])) {
                foreach ($item['tags'] ?? [] as $tag) {
                    $product->productTags()->create([
                        'tag_id' => $tag
                    ]);
                }
            }


            $now = now();
            if ($item['accessibility'] == DOWNLOAD_ACCESSIBILITY_TYPE_PAID) {
                $item['image'] = request()->hasFile('thumbnail_image') ? $item['thumbnail_image'] : NULL;
                foreach ($item['variations'] ?? [] as $index => $variation) {
                    if (isset($item['main_files'][$index]) && $item['main_files'][$index] != NULL) {
                        /*File Manager Call upload for Main File (Zip)*/
                        $extension = pathinfo($item['main_files'][$index]->getClientOriginalName(), PATHINFO_EXTENSION);
                        if ($extension !== 'zip') {
                            $getFileName = $item['main_files'][$index]->getClientOriginalName();
                            $getFileName = pathinfo($getFileName, PATHINFO_FILENAME);
                            $zipFileName = $getFileName . '.zip';
                            $zipFileName = str_replace(' ', '_', $zipFileName);

                            if (!file_exists(storage_path("app/public/unzip/sample"))) {
                                mkdir(storage_path("app/public/unzip/sample"), 0777, true);
                            }

                            $zip = new ZipArchive();
                            $zip->open(storage_path("app/public/unzip/sample/" . $zipFileName), ZipArchive::CREATE);
                            $zip->addFile($item['main_files'][$index], $getFileName . '.' . $extension);
                            $zip->close();

                            $uploadedMainFile = new UploadedFile(storage_path("app/public/unzip/sample/" . $zipFileName), $zipFileName);
                        } else {
                            $uploadedMainFile = $item['main_files'][$index];
                        }

                        $newMainFile = new FileManager();
                        $upload = $newMainFile->upload('Product', $uploadedMainFile, $slug, null,false, true);

                        if ($upload['status']) {
                            $upload['file']->origin_type = "App\Models\ProductVariation";
                            $upload['file']->save();

                            if (isset($item['variation_id']) && isset($item['variation_id'][$index]) && $item['variation_id'][$index] != "") {
                                ProductVariation::find($item['variation_id'][$index])->update([
                                    'variation' => $variation,
                                    'price' => $item['prices'][$index],
                                    'file' => $upload['file']->id,
                                    'updated_at' => $now,
                                ]);
                            } else {
                                $variation = $product->variations()->create([
                                    'variation' => $variation,
                                    'price' => $item['prices'][$index],
                                    'file' => $upload['file']->id,
                                    'updated_at' => $now,
                                ]);
                            }
                        } else {
                            throw new Exception($upload['message']);
                        }

                        if (isset($zipFileName) && file_exists(storage_path("app/public/unzip/sample/" . $zipFileName))) {
                            unlink(storage_path("app/public/unzip/sample/" . $zipFileName));
                        }
                    } else {
                        if (isset($item['variation_id']) && isset($item['variation_id'][$index])) {
                            ProductVariation::find($item['variation_id'][$index])->update([
                                'variation' => $variation,
                                'price' => $item['prices'][$index],
                                'updated_at' => $now,
                            ]);
                        }
                    }
                    /*End Main File (Zip)*/
                }
            } else {
                if (isset($item['main_file']) || isset($item['thumbnail_image'])) {
                    $item['image'] = isset($item['thumbnail_image']) ? $item['thumbnail_image'] : NULL;

                    /*File Manager Call upload for Main File (Zip)*/
                    if(isset($item['main_file'])){
                        $extension = pathinfo($item['main_file']->getClientOriginalName(), PATHINFO_EXTENSION);
                        if ($extension !== 'zip') {
                            $getFileName = $item['main_file']->getClientOriginalName();
                            $getFileName = pathinfo($getFileName, PATHINFO_FILENAME);
                            $zipFileName = $getFileName . '.zip';
                            $zipFileName = str_replace(' ', '_', $zipFileName);

                            if (!file_exists(storage_path("app/public/unzip/sample"))) {
                                mkdir(storage_path("app/public/unzip/sample"), 0777, true);
                            }

                            $zip = new ZipArchive();
                            $zip->open(storage_path("app/public/unzip/sample/" . $zipFileName), ZipArchive::CREATE);
                            $zip->addFile($item['main_file'], $getFileName . '.' . $extension);
                            $zip->close();

                            $uploadedMainFile = new UploadedFile(storage_path("app/public/unzip/sample/" . $zipFileName), $zipFileName);
                        } else {
                            $uploadedMainFile = $item['main_file'];
                        }

                        $newMainFile = new FileManager();
                        $upload = $newMainFile->upload('Product', $uploadedMainFile, $slug, null,false, true);

                        if ($upload['status']) {
                            $upload['file']->origin_type = "App\Models\ProductVariation";
                            $upload['file']->save();

                            $variation = $product->variations()->create([
                                'variation' => 'Main File',
                                'file' => $upload['file']->id,
                                'updated_at' => $now,
                            ]);
                        } else {
                            throw new Exception($upload['message']);
                        }

                        if (isset($zipFileName) && file_exists(storage_path("app/public/unzip/sample/" . $zipFileName))) {
                            unlink(storage_path("app/public/unzip/sample/" . $zipFileName));
                        }
                    }else{
                        $product->variations()->first()->update([
                            'updated_at' => $now,
                        ]);
                    }
                } else {
                    $product->variations()->first()?->update([
                        'updated_at' => $now,
                    ]);
                }
                /*End Main File (Zip)*/
            }

            ProductVariation::where('updated_at', '!=', $now)->where('product_id', $product->id)->delete();

            // START thumbnail image
            if ($product->content_type == 'video' || $product->content_type == 'audio' || $product->content_type == 'Video' || $product->content_type == 'sound') {
                $new_file = new FileManager();
                if ($item['accessibility'] == DOWNLOAD_ACCESSIBILITY_TYPE_PAID && isset($item['main_files']) && isset($item['main_files'][0])) {
                    $upload_play_file = $new_file->upload('Product', $item['main_files'][0], $product->slug, null, false, false);
                } elseif (isset($item['main_file'])) {
                    $upload_play_file = $new_file->upload('Product', $item['main_file'], $product->slug, null, false, false);
                }
            }
            if (isset($upload_play_file)) {
                $product->play_file = $upload_play_file['file']->id;
                $product->save();
            }

            if (isset($item['image']) && $item['image'] != NULL && $item['image'] != "") {
                /*File Manager Call upload for Thumbnail Image*/
                $new_file = new FileManager();
                $extension = pathinfo($item['image']->getClientOriginalName(), PATHINFO_EXTENSION);

                if (in_array($extension, ['jpeg', 'jpg', 'png', 'gif', 'tif', 'bmp', 'ico', 'psd', 'webp'])) {
                    $upload = $new_file->upload('Product', $item['image'], $product->slug, null, getOption('watermark_status', false));
                } else {
                    throw new Exception(__('Invalid Thumbnail'));
                }


                if ($upload['status']) {
                    $upload['file']->origin_type = "App\Models\Product";
                    $upload['file']->save();

                    /*if relation need to be saved in main model*/
                    $product->thumbnail_image_id = $upload['file']->id;
                    $product->save();
                    /*in file manager model relation*/

                    if ($product->content_type == 'image') {
                        $getColorPlates = getColorPlate($item['image']);
                        foreach ($getColorPlates as $value) {
                            $productColor = new ProductColor();
                            $productColor->product_id = $product->id;
                            $productColor->color_code = $value;
                            $productColor->save();
                        }
                    }
                } else {
                    throw new Exception($upload['message']);
                }

                /*End Thumbnail Image*/
            }

            DB::commit();
            return $this->success([], __("Updated successfully"));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->failed([], $e->getMessage());
        }
    }

    public function getRecordByUuid($uuid)
    {
        return Product::whereUuid($uuid)->firstOrFail();
    }

    public function delete($uuid)
    {
        $product = $this->getRecordByUuid($uuid);
        try {
            $product->delete();
            return $this->success([], __('Successfully Deleted'));
        } catch (\Exception $e) {
            return $this->failed([], $e->getMessage());
        }
    }
}
