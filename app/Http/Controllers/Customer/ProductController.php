<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\DownloadProduct;
use App\Models\FavouriteProduct;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductComment;
use App\Models\ProductType;
use App\Models\ProductUploadRule;
use App\Models\ReportedProduct;
use App\Models\Tag;
use App\Models\Tax;
use App\Models\UserPurchase;
use App\Services\ProductUploadService;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class ProductController extends Controller
{
    use ResponseTrait;

    protected $productUploadService;

    public function __construct()
    {
        $this->productUploadService = new ProductUploadService;
    }

    public function index(Request $request)
    {
        $data['pageTitle'] = __('My Products');
        $data['myProductActive'] = 'active';
        if ($request->wantsJson()) {
            $products = Product::where('products.customer_id', auth()->id())
                ->selectRaw('products.slug, products.title, products.thumbnail_image_id, products.product_type_id, products.status, products.id, products.uuid')
                ->orderBy('products.id', 'DESC')
                ->withCount([
                    'orders as singleSalesCount' => function ($q) {
                        $q->select(DB::raw('COUNT(id)'))->where('payment_status', ORDER_PAYMENT_STATUS_PAID);
                    }
                    , 'orders as singleSalesAmount' => function ($q) {
                        $q->select(DB::raw('IFNULL(SUM(contributor_commission), 0)'))->where('payment_status', ORDER_PAYMENT_STATUS_PAID);
                    },
                    'downloadProducts as downloadSalesCount' => function ($q) {
                        $q->select(DB::raw('COUNT(id)'));
                    },
                    'downloadProducts as downloadSalesAmount' => function ($q) {
                        $q->select(DB::raw('IFNULL(SUM(earn_money), 0)'));
                    },
                ]);

            return datatables($products)
                ->addColumn('thumbnail', function ($data) {
                    return '<div class="table-thumbImage"><img src="' . $data->thumbnail_image . '" class="img-fluid img-thumbnail"></div>';
                })
                ->addColumn('sales', function ($data) {
                    return '<div class="text-nowrap">' . $data->singleSalesCount . '(' . showPrice($data->singleSalesAmount) . ')</div>';
                })
                ->addColumn('downloads', function ($data) {
                    return '<div class="text-nowrap">' . $data->downloadSalesCount . '(' . showPrice($data->downloadSalesAmount) . ')</div>';
                })
                ->addColumn('downloads', function ($data) {
                    return '<div class="text-nowrap">' . $data->downloadSalesCount . '(' . showPrice($data->downloadSalesAmount) . ')</div>';
                })
                ->addColumn('earning', function ($data) {
                    return showPrice($data->downloadSalesAmount + $data->singleSalesAmount);
                })
                ->addColumn('status', function ($data) {
                    return getProductStatus($data->status);
                })
                ->addColumn('action', function ($data) {
                    return '<div class="d-flex justify-content-end">
                                <div class="dropdown dropdown-one">
                                    <button class="dropdown-toggle p-0 bg-transparent w-30 h-30 bd-one bd-c-stroke rounded-circle d-flex justify-content-center align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis"></i></button>
                                    <div class="dropdown-menu">
                                        <ul class="dropdownItem-one">
                                            <li>
                                                <a class="d-flex align-items-center cg-8" href="' . route('customer.products.edit', $data->slug) . '">
                                                    <div class="d-flex">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                            <path d="M10.5553 2.91409C11.1142 2.30856 11.3936 2.0058 11.6906 1.8292C12.407 1.40307 13.2893 1.38982 14.0178 1.79424C14.3197 1.96185 14.6077 2.25609 15.1838 2.84457C15.7598 3.43305 16.0479 3.72729 16.2119 4.0357C16.6079 4.77984 16.5949 5.68109 16.1777 6.41302C16.0049 6.71637 15.7085 7.00183 15.1157 7.57275L8.06295 14.3657C6.93966 15.4477 6.378 15.9886 5.67605 16.2628C4.97409 16.537 4.2024 16.5168 2.65902 16.4764L2.44904 16.471C1.97918 16.4587 1.74425 16.4525 1.60769 16.2975C1.47113 16.1425 1.48977 15.9032 1.52706 15.4246L1.54731 15.1648C1.65226 13.8176 1.70473 13.1441 1.96778 12.5386C2.23083 11.9332 2.68458 11.4416 3.59207 10.4584L10.5553 2.91409Z" stroke="#686B8B" stroke-width="1.5" stroke-linejoin="round"/>
                                                            <path d="M9.75 3L15 8.25" stroke="#686B8B" stroke-width="1.5" stroke-linejoin="round"/>
                                                            <path d="M10.5 16.5H16.5" stroke="#686B8B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    </div>
                                                    <p class="fs-14 fw-400 lh-24 text-para-text">' . __('Edit') . '</p>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="d-flex align-items-center cg-8 deleteItem" onclick="deleteItem(\'' . route('customer.products.delete', $data->uuid) . '\', \'productTable\')" href="javascript:void(0);">
                                                    <div class="d-flex">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                            <path d="M14.625 4.125L14.1602 11.6438C14.0414 13.5648 13.9821 14.5253 13.5006 15.2159C13.2625 15.5573 12.956 15.8455 12.6005 16.062C11.8816 16.5 10.9192 16.5 8.99452 16.5C7.06734 16.5 6.10372 16.5 5.38429 16.0612C5.0286 15.8443 4.722 15.5556 4.48401 15.2136C4.00266 14.5219 3.94459 13.5601 3.82846 11.6364L3.375 4.125" stroke="#FF2121" stroke-width="1.5" stroke-linecap="round"/>
                                                            <path d="M2.25 4.125H15.75M12.0418 4.125L11.5298 3.0688C11.1897 2.3672 11.0196 2.01639 10.7263 1.79761C10.6612 1.74908 10.5923 1.70591 10.5203 1.66853C10.1954 1.5 9.80558 1.5 9.02588 1.5C8.2266 1.5 7.827 1.5 7.49676 1.67559C7.42357 1.71451 7.35373 1.75943 7.28797 1.80988C6.99123 2.03753 6.82547 2.40116 6.49396 3.12845L6.03969 4.125" stroke="#FF2121" stroke-width="1.5" stroke-linecap="round"/>
                                                            <path d="M7.125 12.375V7.875" stroke="#FF2121" stroke-width="1.5" stroke-linecap="round"/>
                                                            <path d="M10.875 12.375V7.875" stroke="#FF2121" stroke-width="1.5" stroke-linecap="round"/>
                                                        </svg>
                                                    </div>
                                                    <p class="fs-14 fw-400 lh-24 text-para-text">' . __('Delete') . '</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>';
                })
                ->rawColumns(['sales', 'downloads', 'thumbnail', 'action', 'status'])
                ->make(true);
        }
        return view('customer.products.index', $data);
    }

    public function create()
    {
        $data['pageTitle'] = __('Upload Product');
        $data['uploadProductActive'] = 'active';
        $data['productTypes'] = ProductType::active()->get();
        $data['tags'] = Tag::active()->get();
        $data['taxes'] = Tax::active()->get();
        $data['useOptions'] = getProductUseOption();
        $data['setting'] = array(
            'product_price_min_limit' => getOption('product_price_min_limit'),
            'product_price_max_limit' => getOption('product_price_max_limit')
        );

        return view('customer.products.create', $data);
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $data['tags'] = $request->tags;
        $data['status'] = PRODUCT_STATUS_PENDING; // 2 means Pending
        $data['uploaded_by'] = 2; // 2 means Contributor

        return $this->productUploadService->store($data, 2);
    }

    public function update($uuid, ProductRequest $request)
    {
        $data = $request->validated();
        $data['tags'] = $request->tags;
        $data['attribution_required'] = isset($data['attribution_required']) && $data['attribution_required'] == 1 ? 1 : 0;
        return $this->productUploadService->update($data, $uuid);
    }

    public function edit($slug)
    {
        $data['pageTitle'] = __('Update Product');
        $data['uploadProductActive'] = 'active';
        $data['productTypes'] = ProductType::active()->get();
        $data['tags'] = Tag::active()->get();
        $data['taxes'] = Tax::active()->get();
        $data['useOptions'] = getProductUseOption();
        $data['product'] = Product::with(['productTags', 'variations'])->where('slug', $slug)->first();
        $data['product_categories'] = ProductCategory::active()->where('product_type_id', $data['product']->product_type_id)->get();
        $productType = ProductType::where(['id' => $data['product']->product_type_id, 'status' => ACTIVE])->with('product_type_extensions:id,name,title')->select('id')->first();
        $data['file_types'] = $productType->product_type_extensions;
        $data['productCategories'] = ProductCategory::where('product_type_id', $data['product']->product_type_id)->get();
        $data['productTags'] = $data['product']->productTags()->pluck('tag_id')->toArray();
        $data['setting'] = array(
            'product_price_min_limit' => getOption('product_price_min_limit'),
            'product_price_max_limit' => getOption('product_price_max_limit')
        );

        return view('customer.products.edit', $data);
    }


    public function delete($uuid)
    {
        $response = $this->productUploadService->delete($uuid);
        return $this->success($response, __('Deleted Successfully.'));
    }

    public function fetchProductTypeCategory($product_type_id)
    {
        $response['product_categories'] = ProductCategory::active()->where('product_type_id', $product_type_id)->get();
        $productType = ProductType::where(['id' => $product_type_id, 'status' => ACTIVE])->with('product_type_extensions:id,name,title')->select('id')->first();
        $response['file_types'] = $productType->product_type_extensions;
        return $this->success($response);
    }

    public function sales(Request $request)
    {
        $data['pageTitle'] = __('All Sales');
        $data['saleActive'] = 'active';
        if ($request->wantsJson()) {
            $sales = Order::whereHas('product', function ($q) {
                $q->where('customer_id', auth()->id())
                    ->with('productType');
            })
                ->where('type', ORDER_TYPE_PRODUCT)
                ->where('payment_status', ORDER_PAYMENT_STATUS_PAID)
                ->latest();

            return datatables($sales)
                ->addColumn('thumbnail', function ($data) {
                    return '<div class="table-thumbImage"><img src="' . $data->product->thumbnail_image . '" class="img-fluid img-thumbnail"></div>';
                })
                ->addColumn('type', function ($data) {
                    return $data->product->productType->name ?? '';
                })
                ->addColumn('title', function ($data) {
                    return $data->product->title ?? '';
                })
                ->addColumn('earning', function ($data) {
                    return showPrice($data->contributor_commission);
                })
                ->addColumn('date', function ($data) {
                    return formatDate($data->created_at, 'd M Y');
                })
                ->rawColumns(['thumbnail', 'type', 'date'])
                ->make(true);
        }
        return view('customer.sales', $data);
    }

    public function donations(Request $request)
    {
        $data['pageTitle'] = __('All Donations');
        $data['saleDonation'] = 'active';
        if ($request->wantsJson()) {
            $sales = Order::whereHas('product', function ($q) {
                $q->where('customer_id', auth()->id())
                    ->with('productType');
            })
                ->where('type', ORDER_TYPE_DONATE)
                ->where('payment_status', ORDER_PAYMENT_STATUS_PAID)
                ->latest();

            return datatables($sales)
                ->addColumn('thumbnail', function ($data) {
                    return '<div class="table-thumbImage"><img src="' . $data->product->thumbnail_image . '" class="img-fluid img-thumbnail"></div>';
                })
                ->addColumn('type', function ($data) {
                    return $data->product->productType->name ?? '';
                })
                ->addColumn('title', function ($data) {
                    return $data->product->title ?? '';
                })
                ->addColumn('earning', function ($data) {
                    return showPrice($data->contributor_commission);
                })
                ->addColumn('date', function ($data) {
                    return formatDate($data->created_at, 'd M Y');
                })
                ->rawColumns(['thumbnail', 'type', 'date'])
                ->make(true);
        }
        return view('customer.donations', $data);
    }

    public function downloads(Request $request)
    {
        $data['pageTitle'] = __('All Download');
        $data['downloadActive'] = 'active';
        if ($request->wantsJson()) {
            $downloads = DownloadProduct::with(['product', 'customer', 'productType'])
                ->where('download_products.contributor_id', auth()->id())
                ->orderBy('download_products.id', 'DESC');


            return datatables($downloads)
                ->addColumn('thumbnail', function ($data) {
                    return '<div class="table-thumbImage"><img src="' . $data->product->thumbnail_image . '" class="img-fluid img-thumbnail"></div>';
                })
                ->addColumn('type', function ($data) {
                    return $data->productType->name ?? '';
                })
                ->addColumn('title', function ($data) {
                    return $data->product->title ?? '';
                })
                ->addColumn('customer', function ($data) {
                    return $data->customer->name ?? '';
                })
                ->addColumn('earning', function ($data) {
                    return showPrice($data->earn_money);
                })
                ->addColumn('date', function ($data) {
                    return '<span class="text-nowrap">' . formatDate($data->created_at, 'd M Y') . '</span>';
                })
                ->rawColumns(['thumbnail', 'type', 'date'])
                ->make(true);
        }
        return view('customer.downloads', $data);
    }

    public function myDownloads(Request $request)
    {
        $data['pageTitle'] = __('My Download');
        $data['downloadMyActive'] = 'active';

        if ($request->wantsJson()) {
            $downloads = DownloadProduct::select([
                'download_products.product_id',
                'download_products.product_type_id',
                'download_products.customer_id',
                'download_products.contributor_id',
                'download_products.user_id',
                DB::raw('COUNT(download_products.product_id) as download_count'),
                DB::raw('MAX(download_products.id) as latest_download_id') // Get latest download record per product
            ])
                ->where('download_products.customer_id', auth()->id())
                ->groupBy([
                    'download_products.product_id',
                    'download_products.product_type_id',
                    'download_products.customer_id',
                    'download_products.contributor_id',
                    'download_products.user_id'
                ])
                ->orderByDesc('latest_download_id') // Order by latest downloaded product
                ->with(['product', 'productType', 'contributor', 'user']); // Ensure relationships are eager-loaded

            return datatables($downloads)
                ->addColumn('thumbnail', function ($data) {
                    return '<div class="table-thumbImage"><img src="' . $data->product?->thumbnail_image . '" class="img-fluid img-thumbnail"></div>';
                })
                ->addColumn('type', function ($data) {
                    return $data->productType->name ?? 'N/A';
                })
                ->addColumn('title', function ($data) {
                    return $data->product->title ?? 'N/A';
                })
                ->addColumn('author', function ($data) {
                    return $data->user ? $data->user->name : $data->contributor?->name;
                })
                ->addColumn('download', function ($data) {
                    return $data->download_count;
                })
                ->rawColumns(['thumbnail', 'type'])
                ->make(true);
        }

        return view('customer.my_downloads', $data);
    }

    public function myPurchase(Request $request)
    {
        $data['pageTitle'] = __('My Purchase');
        $data['myPurchaseActive'] = 'active';

        if ($request->wantsJson()) {
            $purchases = UserPurchase::select([
                'user_purchases.product_id',
                'user_purchases.variations_id',
                'user_purchases.created_at',
                'product_variations.id as variation_id',
                'product_variations.variation',
                'products.title',
                'user_purchases.licence',
                'user_purchases.id',
                'user_purchases.price',
            ])
                ->leftJoin('product_variations', 'product_variations.id', '=', 'user_purchases.variations_id')
                ->leftJoin('products', 'products.id', '=', 'user_purchases.product_id')
                ->where('user_purchases.customer_id', auth()->id())
                ->orderBy('user_purchases.created_at', 'DESC');

            return datatables($purchases)
                ->addColumn('date', function ($data) {
                    return '<div class="text-nowrap">'. formatDate($data->created_at, 'd M Y') . '</div>';
                })
                ->addColumn('product', function ($data) {
                    return "<a target='_blank' href='" . route('customer.my_purchase_download', $data->variation_id) . "' class='d-inline-flex'><img src='" . asset('assets/images/icon/download-primary.svg') . "' alt=''></a>";
                })
                ->editColumn('price', function ($data) {
                    return '<div class="text-nowrap">'. showPrice($data->price) .'</div>';
                })
                ->addColumn('variation', function ($data) {
                    return $data->variation;
                })
                ->rawColumns(['product','date','price'])
                ->make(true);
        }

        return view('customer.my_purchases', $data);
    }

    public function myPurchaseDownload($variationId)
    {
        try {
            // Fetch the file associated with the purchase
            $productPurchase = UserPurchase::where([
                'variations_id' => $variationId,
                'customer_id' => auth()->id()
            ])
                ->join('product_variations', 'product_variations.id', '=', 'user_purchases.variations_id')
                ->join('file_managers', 'file_managers.id', '=', 'product_variations.file')
                ->select('storage_type', 'path')
                ->first();

            // Ensure the file exists in the database
            if (!$productPurchase) {
                return abort(404, __('File not found.'));
            }

            // Define the storage disk
            $disk = $productPurchase->storage_type;
            $filePath = $productPurchase->path;

            // Check if the file exists
            if (!Storage::disk($disk)->exists($filePath)) {
                return abort(404, __('File does not exist on the server.'));
            }

            // Handle public storage separately
            if ($disk === 'public') {
                return response()->download(storage_path("app/public/{$filePath}"));
            }

            // Handle Wasabi, S3, or any other cloud storage
            return Storage::disk($disk)->download($filePath);

        } catch (\Exception $e) {
            return abort(500, __('An error occurred while downloading the file.'));
        }
    }

    public function downloadProduct($variationId)
    {
        try {
            DB::beginTransaction();
            /*
          * Check product free or not. If free, then he can download without purchase plan
          * Check customer plan have or not. If you have, need to check end date gt current date
          * Plan unlimited or limited. If limited, check how many downloaded today less than download limited
          */

            $product = Product::join('product_variations', ['products.id' => 'product_variations.product_id', 'product_variations.id' => DB::raw("'$variationId'")])->where('products.status', PRODUCT_STATUS_PUBLISHED)->select('products.*', 'product_variations.file', 'product_variations.id as variation_id')->first();

            if ($product->customer_id == auth()->id()) {
                DB::rollBack();
                return back()->with('error', __('Own Product Can\'t Download'));
            }

            $customerPlan = customerPlanExit(auth()->id());
            if ($product) {
                if ($product->accessibility == PRODUCT_ACCESSIBILITY_FREE) {
                    $checkLimit = DownloadProduct::where(['download_accessibility_type' => DOWNLOAD_ACCESSIBILITY_TYPE_FREE])
                        ->whereDate('created_at', Carbon::today())
                        ->where('download_products.customer_id', auth()->id())
                        ->count();
                    if (($checkLimit >= getOption('free_download_per_day')) || !$customerPlan) {
                        DB::rollBack();
                        return back()->with('error', __('Daily Download limit exceed'));
                    }
                    return $this->generateDownloadLink($product->variation_id);
                }
            } else {
                DB::rollBack();
                return back()->with('error', __('Product not found.'));
            }

            /* If product is paid, check plan */
            if ($customerPlan) {
                $plan_details = $customerPlan->plan;
                if ($plan_details) {
                    if ($plan_details->download_limit_type == PLAN_DOWNLOAD_LIMIT_TYPE_LIMITED) {
                        $checkLimit = DownloadProduct::where(['download_accessibility_type' => DOWNLOAD_ACCESSIBILITY_TYPE_PAID])
                            ->whereBetween('created_at', [$customerPlan->start_date, $customerPlan->end_date])
                            ->where('download_products.customer_id', auth()->id())
                            ->count();
                        if ($plan_details->download_limit > $checkLimit) {
                            return $this->generateDownloadLink($product->variation_id);
                        } else {
                            DB::rollBack();
                            return back()->with('error', __('Your plan download limit has been exceeded. Please buy new plan.'));
                        }
                    } elseif ($plan_details->download_limit_type == PLAN_DOWNLOAD_LIMIT_TYPE_UNLIMITED) {
                        return $this->generateDownloadLink($product->variation_id);
                    }
                }
            }

            DB::rollBack();
            return back()->with('error', __('Sorry! You have no plan.'));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', __('An error occurred while downloading the file.'));
        }
    }

    public function generateDownloadLink($variationId)
    {
        $product = Product::join('product_variations', ['products.id' => 'product_variations.product_id', 'product_variations.id' => DB::raw("'$variationId'")])
            ->join('file_managers', 'file_managers.id', '=', 'product_variations.file')
            ->where('products.status', PRODUCT_STATUS_PUBLISHED)
            ->select('products.*', 'storage_type', 'path', 'product_variations.id as variation_id')
            ->first();

        if (!$product) {
            DB::rollBack();
            return back()->with('error', __('File does not exist on the server.'));
        }

        $disk = $product->storage_type;
        $filePath = $product->path;

        if (!Storage::disk($disk)->exists($filePath)) {
            DB::rollBack();
            return back()->with('error', __('File does not exist on the server.'));
        }

        // Store download log
        DownloadProduct::create([
            'product_type_id' => $product->product_type_id,
            'product_id' => $product->id,
            'customer_id' => auth()->id(),
            'contributor_id' => $product->customer_id,
            'user_id' => $product->user_id,
            'variation_id' => $product->variation_id,
            'download_accessibility_type' => $product->accessibility
        ]);

        DB::commit();

        // Encrypt file path and disk
        $token = Str::uuid()->toString();
        $encryptedPath = Crypt::encryptString($filePath);
        $encryptedDisk = Crypt::encryptString($disk);

        // Generate secure URL with encrypted params
        $downloadUrl = route('customer.one_time_download', [
            'token' => $token,
            'path' => $encryptedPath,
            'disk' => $encryptedDisk
        ]);

        return redirect($downloadUrl);
    }

    public function oneTimeDownload(Request $request)
    {
        if (!$request->has(['token', 'path', 'disk'])) {
            return back()->with('error', __('Invalid download request.'));
        }

        try {
            $filePath = Crypt::decryptString($request->path);
            $disk = Crypt::decryptString($request->disk);
        } catch (\Exception $e) {
            return back()->with('error', __('Invalid or tampered download link.'));
        }

        // Check file existence
        if (!Storage::disk($disk)->exists($filePath)) {
            return back()->with('error', __('File does not exist.'));
        }

        return Storage::disk($disk)->download($filePath);
    }

    public function favouriteProduct(Request $request)
    {
        $data['pageTitle'] = __('Favourites');
        $data['activeFavorite'] = 'active';

        if ($request->wantsJson()) {
            $favouriteProducts = FavouriteProduct::with(['product.user', 'product.customer', 'productType' => function ($q) {
                $q->select('name');
            }])->where('customer_id', auth()->id())
                ->orderBy('created_at', 'DESC');

            return datatables($favouriteProducts)
                ->addColumn('thumbnail', function ($data) {
                    return '<div class="table-thumbImage"><img src="' . $data->product?->thumbnail_image . '" class="img-fluid img-thumbnail"></div>';
                })
                ->addColumn('type', function ($data) {
                    return $data->productType->name ?? 'N/A';
                })
                ->addColumn('title', function ($data) {
                    return '<div class="text-nowrap">'.$data->product->title ?? 'N/A'.'</div>';
                })
                ->addColumn('author', function ($data) {
                    return $data->product?->user ? ($data->product->user->name ?? '') : ($data->product->customer->name ?? '');
                })
                ->addColumn('action', function ($data) {
                    return '<a class="d-flex justify-content-end align-items-center cg-8" href="' . route('customer.unfavourite', $data->id) . '">
                                <div class="d-flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                        <path d="M1.5 8.625C1.5 9.45345 2.17157 10.125 3 10.125C4.24264 10.125 5.25 9.11768 5.25 7.875V4.875C5.25 3.63236 4.24264 2.625 3 2.625C2.17157 2.625 1.5 3.29657 1.5 4.125V8.625Z" stroke="#5D697A" stroke-width="1.125" stroke-linecap="round" stroke-linejoin="round"></path>
                                        <path d="M11.609 12.1453L11.4093 11.5003C11.2456 10.9717 11.1638 10.7074 11.2267 10.4987C11.2777 10.3298 11.3894 10.1842 11.5417 10.0885C11.73 9.97012 12.0148 9.97012 12.5843 9.97012H12.8873C14.8149 9.97012 15.7786 9.97012 16.2339 9.39952C16.2859 9.33435 16.3321 9.26497 16.3722 9.19222C16.7224 8.55592 16.3243 7.69867 15.528 5.98417C14.7973 4.41083 14.4319 3.62416 13.7535 3.16114C13.6879 3.11631 13.6204 3.07402 13.5512 3.03439C12.837 2.625 11.9521 2.625 10.1823 2.625H9.79845C7.65427 2.625 6.58221 2.625 5.91611 3.2704C5.25 3.91579 5.25 4.95455 5.25 7.03205V7.76227C5.25 8.85405 5.25 9.3999 5.44375 9.89955C5.63751 10.3992 6.00851 10.81 6.75052 11.6317L9.81907 15.0296C9.89602 15.1148 9.9345 15.1574 9.96847 15.187C10.2851 15.4625 10.7739 15.4315 11.0508 15.1183C11.0805 15.0847 11.1129 15.0376 11.1777 14.9434C11.2791 14.796 11.3298 14.7223 11.374 14.6492C11.7696 13.9957 11.8893 13.2192 11.7081 12.4822C11.6878 12.3998 11.6616 12.3149 11.609 12.1453Z" stroke="#5D697A" stroke-width="1.125" stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                                <p class="fs-14 fw-500 lh-24 text-para-text">' . __('Unfavorite') . '</p>
                            </a>';
                })
                ->rawColumns(['thumbnail','title', 'type', 'action'])
                ->make(true);
        }

        return view('customer.favourites', $data);
    }


    public function unfavouriteProduct($id)
    {
        FavouriteProduct::where('customer_id', auth()->id())
            ->where('id', $id)
            ->delete();

        return back()->with('success', __('Unfavorite successfully'));
    }


    public function productReport(Request $request, $product_id)
    {
        $request->validate([
            'reason' => 'required'
        ]);

        $reported = new ReportedProduct();
        $reported->reported_by_customer_id = auth()->id();
        $reported->reported_to_product_id = $product_id;
        $reported->reason = $request->reason;
        $reported->save();

        $response['message'] = 'Reported Successfully';
        return $this->success([], $response['message']);
    }

    public function productComment(Request $request, $product_id)
    {
        $request->validate([
            'comment' => 'required',
        ]);

        $comment = new ProductComment();
        $comment->customer_id = auth()->id();
        $comment->product_id = $product_id;
        $comment->comment = $request->comment;
        $comment->status = ACTIVE;
        $comment->save();

        return $this->success([], __('Comment Created Successfully'));
    }
}
