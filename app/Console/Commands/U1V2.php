<?php

namespace App\Console\Commands;

use App\Models\Gateway;
use App\Models\Meta;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\ProductTypeExtension;
use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class U1V2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'u1v2 {--lqs=} {--v=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::beginTransaction();
        try {

            $dbBuildVersion = getCustomerCurrentBuildVersion();

            if ($dbBuildVersion < 3) {

                $lqs = $this->option('lqs');
                $lqs = utf8_decode(urldecode($lqs));
                if (!is_null($lqs) && $lqs != '') {
                    DB::unprepared($lqs);
                }

                $productTypes = ProductType::all();

                //migrate product type
                foreach ($productTypes as $productType) {
                    $productType->slug = getSlug($productType->name);
                    if ($productType->name == "Video") {
                        $productType->product_type_category = PRODUCT_TYPE_VIDEO;
                    } else if ($productType->name == "Sound") {
                        $productType->product_type_category = PRODUCT_TYPE_AUDIO;
                    }

                    $productType->slug = getSlug($productType->name);
                    $productType->save();
                }

                //product type extensions

                $now = now();
                ProductTypeExtension::insert([
                    ['product_type_category' => PRODUCT_TYPE_IMAGE, 'name' => 'jpeg', 'title' => 'JPEG', 'thumbnail_required' => DISABLE, 'maskingable' => ACTIVE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_IMAGE, 'name' => 'jpg', 'title' => 'JPG', 'thumbnail_required' => DISABLE, 'maskingable' => ACTIVE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_IMAGE, 'name' => 'png', 'title' => 'PNG', 'thumbnail_required' => DISABLE, 'maskingable' => ACTIVE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_IMAGE, 'name' => 'gif', 'title' => 'GIF', 'thumbnail_required' => DISABLE, 'maskingable' => ACTIVE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_IMAGE, 'name' => 'tif', 'title' => 'TIF', 'thumbnail_required' => DISABLE, 'maskingable' => ACTIVE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_IMAGE, 'name' => 'bmp', 'title' => 'BMP', 'thumbnail_required' => DISABLE, 'maskingable' => ACTIVE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_IMAGE, 'name' => 'ico', 'title' => 'ICO', 'thumbnail_required' => DISABLE, 'maskingable' => ACTIVE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_IMAGE, 'name' => 'psd', 'title' => 'PSD', 'thumbnail_required' => DISABLE, 'maskingable' => ACTIVE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_IMAGE, 'name' => 'webp', 'title' => 'WEBP', 'thumbnail_required' => DISABLE, 'maskingable' => ACTIVE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_IMAGE, 'name' => 'ai', 'title' => 'AI', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_IMAGE, 'name' => 'eps', 'title' => 'EPS', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_IMAGE, 'name' => 'svg', 'title' => 'SVG', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_IMAGE, 'name' => 'cdr', 'title' => 'CDR', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_IMAGE, 'name' => 'indd', 'title' => 'INDD', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_IMAGE, 'name' => 'raw', 'title' => 'RAW', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_IMAGE, 'name' => 'zip', 'title' => 'ZIP', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_IMAGE, 'name' => 'other', 'title' => 'Others', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_AUDIO, 'name' => 'm4a', 'title' => 'M4A', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_AUDIO, 'name' => 'mp3', 'title' => 'MP3', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_AUDIO, 'name' => 'wav', 'title' => 'WAV', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_VIDEO, 'name' => 'mp4', 'title' => 'MP4', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_VIDEO, 'name' => 'avi', 'title' => 'AVI', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_VIDEO, 'name' => 'mov', 'title' => 'MOV', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_VIDEO, 'name' => 'flv', 'title' => 'FLV', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_VIDEO, 'name' => 'avchd', 'title' => 'AVCHD', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_VIDEO, 'name' => 'zip', 'title' => 'ZIP', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_VIDEO, 'name' => 'other', 'title' => 'Others', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_FILE, 'name' => 'pdf', 'title' => 'PDF', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_FILE, 'name' => 'doc', 'title' => 'DOC', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_FILE, 'name' => 'docx', 'title' => 'DOCX', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_FILE, 'name' => 'pdf', 'title' => 'PDF', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_FILE, 'name' => 'html', 'title' => 'HTML', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_FILE, 'name' => 'html', 'title' => 'HTML', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_FILE, 'name' => 'xls', 'title' => 'XLS', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_FILE, 'name' => 'xlsx', 'title' => 'XLSX', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_FILE, 'name' => 'txt', 'title' => 'TXT', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_FILE, 'name' => 'ppt', 'title' => 'PPT', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_FILE, 'name' => 'pptx', 'title' => 'PPTX', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_FILE, 'name' => 'odp', 'title' => 'ODP', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_FILE, 'name' => 'key', 'title' => 'KEY', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_FILE, 'name' => 'zip', 'title' => 'ZIP', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                    ['product_type_category' => PRODUCT_TYPE_OTHERS, 'name' => 'other', 'title' => 'Others', 'thumbnail_required' => ACTIVE, 'maskingable' => DISABLE, 'status' => ACTIVE, 'created_at' => $now, 'updated_at' => $now],
                ]);

                //product use options
                $option = Setting::firstOrCreate(['option_key' => 'product_use_option']);

                $option->option_value =  json_encode([
                    ['id' => 1, 'name' => 'Free for commercial use'],
                    ['id' => 2, 'name' => 'Free for personal use'],
                    ['id' => 3, 'name' => 'Editor use only'],
                    ['id' => 4, 'name' => 'Use only on websites'],
                ]);
                $option->type = 1;
                $option->save();

                //migrate meta
                foreach (getPageName() as $index => $getPage) {
                    $meta = Meta::where('page_name', $getPage)->first();
                    if (!is_null($meta)) {
                        $meta->update(['page' => $index]);
                    } else {
                        Meta::create([
                            'page' => $index,
                            'page_name' => $getPage,
                            'meta_title' => $getPage,
                            'meta_description' => $getPage,
                            'meta_keyword' => $getPage,
                        ]);
                    }
                }

                //add in payment gateway

                Gateway::create([
                    'gateway_name' => 'mercadopago',
                    'gateway_currency' => 'BRL',
                    'gateway_parameters' => ["mode" => "sandbox","mercadopago_client_id" => "","mercadopago_client_secret" => ""],
                    'gateway_type' => 2,
                    'user_proof_param' => NULL,
                    'conversion_rate' => 5,
                    'status' => 1,
                    'wallet_gateway_status' => 0,
                ]);

                Gateway::create([
                    'gateway_name' => 'flutterwave',
                    'gateway_currency' => 'NGN',
                    'gateway_parameters' => ["mode" => "sandbox","public_key"=>"","client_secret"=>"","hash"=>""],
                    'gateway_type' => 2,
                    'user_proof_param' => NULL,
                    'conversion_rate' => 460,
                    'status' => 1,
                    'wallet_gateway_status' => 0,
                ]);

                Artisan::call('cache:forget spatie.permission.cache');
                $parentPermission = Permission::where('name', 'payment_gateway')->first();
                //Permissions
                Permission::create([
                    'name' => 'mercadopago',
                    'display_name' => 'Mercadopago',
                    'submodule_id' => $parentPermission->id,
                ]);


                Permission::create([
                    'name' => 'flutterwave',
                    'display_name' => 'Flutterwave',
                    'submodule_id' => $parentPermission->id,
                ]);

                $parentPermission = Permission::where('name', 'manage_products')->first();
                //Permissions
                Permission::create([
                    'name' => 'product_bulk_upload',
                    'display_name' => 'Bulk Upload',
                    'submodule_id' => $parentPermission->id,
                ]);

                $parentPermission = Permission::where('name', 'manage_customer')->first();
                Permission::create([
                    'name' => 'pending_customer',
                    'display_name' => 'Pending Customer',
                    'submodule_id' => $parentPermission->id,
                ]);

                $permissions = Permission::select('id')->get()->pluck('id')->toArray();

                $role = Role::first();

                $role->permissions()->sync($permissions);

                //migrate all product
                $products = Product::all();
                foreach ($products as $product) {
                    $fileManager = $product->fileAttach;
                    if (count($product->variations) == 0 && !is_null($fileManager)) {
                        $fileManager->origin_type == "App\Models\ProductVariation";
                        $fileManager->origin_id == NULL;
                        $fileManager->save();

                        $product->variations()->create([
                            'variation' => 'Main File',
                            'price' => !is_null($product->price) ? $product->price : 0.00,
                            'file' => $fileManager->id,
                        ]);
                    }
                }

                setCustomerBuildVersion(3);
                setCustomerCurrentVersion();
            }

            Log::info('from u1v2');
            DB::commit();
            echo "Command run successfully";
            return true;
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::info($exception->getMessage() . $exception->getFile() . $exception->getLine());
            return false;
        }

        return true;
    }
}
