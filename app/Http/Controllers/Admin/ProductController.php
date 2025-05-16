<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductComment;
use App\Models\ProductType;
use App\Models\ProductTypeExtension;
use App\Models\Tag;
use App\Models\Tax;
use App\Services\ProductUploadService;
use App\Traits\ApiStatusTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    use ApiStatusTrait;

    protected $productUploadService;

    public function __construct()
    {
        $this->productUploadService = new ProductUploadService;
    }

    public function index(Request $request, $status = null)
    {
        $products = Product::where(function ($q) use ($request) {
            if ($request->search_value) {
                $q->where('title', 'like', "%{$request->search_value}%")
                    ->orWhereHas('productCategory', function ($query) use ($request) {
                        $query->where('name', 'like', "%{$request->search_value}%");
                    })
                    ->orWhereHas('productType', function ($query) use ($request) {
                        $query->where('name', 'like', "%{$request->search_value}%");
                    });
            }
        })->latest();

        if($status == null){
            if (!Auth::user()->can('all_products')) {
                abort('403');
            }
            $data['pageTitle'] = __('All Products');
            $data['subNavAllProductsActiveClass'] = "active";
            $data['showProducts'] = 'show';
        }
        elseif ($status == PRODUCT_STATUS_PUBLISHED) {
            if (!Auth::user()->can('published_products')) {
                abort('403');
            }

            $data['pageTitle'] = __('Published Products');
            $data['subNavPublishedProductsActiveClass'] = "active";
            $data['showProducts'] = 'show';
            $products = $products->published();
        } elseif ($status == PRODUCT_STATUS_PENDING) {
            if (!Auth::user()->can('pending_product')) {
                abort('403');
            }

            $data['pageTitle'] = __('Pending Products');
            $data['subNavPendingProductsActiveClass'] = "active";
            $data['showProducts'] = 'show';
            $products = $products->pending();
        } elseif ($status == PRODUCT_STATUS_HOLD) {
            if (!Auth::user()->can('hold_product')) {
                abort('403');
            }

            $data['pageTitle'] = __('Hold Products');
            $data['subNavHoldProductsActiveClass'] = "active";
            $data['showProducts'] = 'show';
            $products = $products->hold();

        } elseif ($status == 4){
            if (!Auth::user()->can('in_house_products')) {
                abort('403');
            }
            $data['pageTitle'] = __('In House Product List');
            $data['subNavAdminProductsActiveClass'] = "active";
            $data['showProducts'] = 'show';
            $products = $products->uploadedByAdmin();

        } elseif ($status == 5){
            if (!Auth::user()->can('contributor_products')) {
                abort('403');
            }
            $data['pageTitle'] = __('Contributor Product List');
            $data['subNavContributorProductsActiveClass'] = "active";
            $data['showProducts'] = 'show';
            $products = $products->uploadedByContributor();
        }

        if($request->ajax()){
            return $this->productDataTable($products);
        }
        $data['status'] = $status;
        return view('admin.product.index', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('add_new_product')) {
            abort('403');
        }
        $data['pageTitle'] = __('Add Product');
        $data['subNavAddProductActiveClass'] = "active";
        $data['showProducts'] = 'show';
        $data['productTypes'] = ProductType::active()->get();
        $data['tags'] = Tag::all();
        $data['taxes'] = Tax::active()->get();
        $data['useOptions'] = getProductUseOption();
        $data['productTypeExtensions'] = ProductTypeExtension::join('product_type_product_type_extension', 'product_type_extensions.id', '=', 'product_type_product_type_extension.product_type_extension_id')->where('product_type_extensions.status', ACTIVE)->get();
        return view('admin.product.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $data['tags'] = $request->tags;
        $data['attribution_required'] = isset($data['attribution_required']) ? 1 : 0;
        return $this->productUploadService->store($data, 1);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $data['pageTitle'] = __('Product Details');
        $data['subNavProductActiveClass'] = "active";
        $data['showProducts'] = 'show';
        $data['product'] = Product::where('uuid', $uuid)->with('variations')->firstOrFail();
        return view('admin.product.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        $data['pageTitle'] = __('Edit Product');
        $data['subNavProductActiveClass'] = "active";
        $data['showProducts'] = 'show';
        $data['product'] = $this->productUploadService->getRecordByUuid($uuid);
        $data['productTypes'] = ProductType::active()->get();
        $data['productCategories'] = ProductCategory::where('product_type_id', $data['product']->product_type_id)->get();
        $data['useOptions'] = getProductUseOption();
        $data['productTags'] = $data['product']->productTags()->pluck('tag_id')->toArray();
        $data['tags'] = Tag::all();
        $data['taxes'] = Tax::active()->get();
        $data['productTypeExtensions'] = ProductTypeExtension::join('product_type_product_type_extension', 'product_type_extensions.id', '=', 'product_type_product_type_extension.product_type_extension_id')->where('product_type_extensions.status', ACTIVE)->get();

        return view('admin.product.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $uuid)
    {
        $data = $request->validated();
        $data['tags'] = $request->tags;
        $data['attribution_required'] = isset($data['attribution_required']) ? 1 : 0;
        return $this->productUploadService->update($data, $uuid);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $response = $this->productUploadService->delete($uuid);
        $responseData = $response->getData();
        return back()->with($responseData->success, $responseData->message);
    }

    public function fetchProductTypeCategory(Request $request)
    {
        $response['productCategories'] = ProductCategory::active()->where('product_type_id', $request->product_type_id)->get();
        return $this->successApiResponse($response);
    }

    public function changeProductStatus(Request $request)
    {
        if(env('APP_DEMO') == 'active'){
            $response['message'] = 'This is a demo version! You can get full access after purchasing the application.';
            return $this->notAllowedApiResponse($response);
        }

        $product = Product::findOrFail($request->id);
        $product->status = $request->status;
        $product->save();

        $response['message'] = 'Success';
        return $this->successApiResponse($response);
    }

    public function changeProductIsFeaturedStatus(Request $request)
    {
        if(env('APP_DEMO') == 'active'){
            $response['message'] = 'This is a demo version! You can get full access after purchasing the application.';
            return $this->notAllowedApiResponse($response);
        }

        $product = Product::findOrFail($request->id);
        $product->is_featured = $request->is_featured;
        $product->save();

        $response['message'] = 'Success';
        return $this->successApiResponse($response);
    }

    public function productSetting()
    {
        $data['pageTitle'] = __("Product Setting");
        $data['subNavProductSettingActiveClass'] = "active";
        $data['showProducts'] = 'show';
        return view('admin.product.product-setting')->with($data);
    }

    public function productComments()
    {
        $data['pageTitle'] = __("Product Comments");
        $data['subNavProductCommentActiveClass'] = "active";
        $data['showProducts'] = 'show';
        $data['productComments'] = ProductComment::latest()->get();;
        return view('admin.product.product-comment')->with($data);
    }

    public function productCommentDelete($id)
    {
        ProductComment::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Deleted Successfully');
    }

    public function changeProductCommentStatus(Request $request)
    {
        if(env('APP_DEMO') == 'active'){
            $response['message'] = 'This is a demo version! You can get full access after purchasing the application.';
            return $this->notAllowedApiResponse($response);
        }

        $productComment = ProductComment::findOrFail($request->id);
        $productComment->status = $request->status;
        $productComment->save();

        $response['message'] = 'Success';
        return $this->successApiResponse($response);
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $currency = Product::findOrFail($id);
            $currency->delete();
            DB::commit();
            $message = getMessage(DELETED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function statusModal($id)
    {
        $data['pageTitle'] = 'Edit Status';
        $data['product'] = Product::findOrFail($id);
        return view('admin.product.status-modal', $data);
    }

    public function isFeatureModal($id)
    {
        $data['pageTitle'] = "Edit 	Editor's Choice";
        $data['product'] = Product::findOrFail($id);
        return view('admin.product.is-feature-modal', $data);
    }

    public function statusUpdate(Request $request, $id)
    {
            $currency = Product::findOrfail($id);
            $currency->status = $request->status;
            $currency->save();
            return redirect()->back()->with('success', __('Update Successfully'));
    }

    public function isFeatureUpdate(Request $request, $id)
    {
        $currency = Product::findOrfail($id);
        $currency->is_featured = $request->is_featured;
        $currency->save();
        return redirect()->back()->with('success',__('Update Sucessfully'));

    }

    public function productDataTable($products){
        return datatables($products)
            ->addIndexColumn()
            ->editColumn('thumbnail_image', function ($data) {
                return '<div class="admin-dashboard-blog-list-img w-30 h-30 rounded-circle overflow-hidden">
                        <a class="test-popup-link" href="' . $data->thumbnail_image . '">
                            <img src="' . $data->thumbnail_image . '" alt="img" class="w-100 h-100 object-fit-cover">
                        </a>
                    </div>';
            })
            ->editColumn('title', function ($data) {
                return '<td class="finance-table-inner-item my-2">'.
                    $data->title .
                    '<div class="finance-table-inner-item my-2">'.
                    '<span class="fw-bold mr-1">' . __('Downloads') . ': </span>' .
                    $data->downloadProducts->count() .
                    '</div>' .
                    '</td>';
            })
            ->editColumn('productType', function ($data) {
                return '<span class="text-end">' .$data->productType->name . '</span>';
            })
            ->editColumn('productCategory', function ($data) {
                return '<span class="text-end">' .$data->productCategory->name . '</span>';
            })
            ->editColumn('accessibility', function ($data) {
                if($data->accessibility == 1){
                    return '<span class="text-danger">Paid</span>';
                }elseif ($data->accessibility == 2){
                    return '<span class="text-primary">Free</span>';
                }
            })
            ->editColumn('status', function ($data) {
                $statusHtml = '';
                if ($data->status == PRODUCT_STATUS_PUBLISHED) {
                    $statusHtml = '<span class="zBadge zBadge-published">Published</span>';
                } elseif ($data->status == PRODUCT_STATUS_PENDING) {
                    $statusHtml = '<span class="zBadge zBadge-pending">Pending</span>';
                } elseif ($data->status == PRODUCT_STATUS_HOLD) {
                    $statusHtml = '<span class="zBadge zBadge-hold">Hold</span>';
                }

                $dropdownMenu = '<ul class="action-list">
                        <li class="nav-item dropdown">
                            <a class="nav-link w-30 h-30 d-flex justify-content-center align-items-center bd-one bd-c-stroke rounded-circle" href=""
                               onclick="getEditModal(\'' . route('admin.product.status-modal', $data->id) . '\', \'#status-modal\')"
                               role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="' . asset('admin/images/icons/ellipsis-v.svg') . '" alt="icon" class="ellipsis-icon-img m-0">
                            </a>
                        </li>
                    </ul>';

                return '<div class="d-flex justify-content-start align-items-center g-10">
                                <div>' . $statusHtml . '</div>
                                <div>' . $dropdownMenu . '</div>
                            </div>';
            })

            ->editColumn('is_featured', function ($data) {
                $isFeaturedHtml = ($data->is_featured == PRODUCT_IS_FEATURED_YES)
                    ? '<span class="text-success fw-bold">Yes</span>'
                    : '<span class="text-danger fw-bold">No</span>';

                $dropdownMenu = '<ul class="action-list">
                                            <li class="nav-item dropdown">
                                                <a class="nav-link w-30 h-30 d-flex justify-content-center align-items-center bd-one bd-c-stroke rounded-circle" onclick="getEditModal(\'' . route('admin.product.is-feature-modal', $data->id) . '\', \'#is-feature-modal\')" href="#" o role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <img src="' . asset('admin/images/icons/ellipsis-v.svg') . '" alt="icon" class="ellipsis-icon-img m-0">
                                                </a>
                                            </li>
                                        </ul>';
                return '
                                            <div class="d-flex justify-content-start align-items-center g-10">
                                                <div>' . $isFeaturedHtml . '</div>
                                                <div>' . $dropdownMenu . '</div>
                                            </div>';
            })
            ->editColumn('created_by', function ($data) {
                return $data->uploaded_by == PRODUCT_UPLOADED_BY_ADMIN
                    ? $data->user->name . ' (Admin)'
                    : $data->customer->name . ' (Contributor)';
            })
            ->addColumn('action', function ($data) {
                return '<ul class="d-flex align-items-center cg-5 justify-content-end">
                            <li class="align-items-center d-flex gap-2">
                                <a  class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-stroke bg-white" target="_blank" href="' . route('admin.product.show', $data->uuid) . '">
                                    <svg width="15" height="12" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.5 8C8.60457 8 9.5 7.10457 9.5 6C9.5 4.89543 8.60457 4 7.5 4C6.39543 4 5.5 4.89543 5.5 6C5.5 7.10457 6.39543 8 7.5 8Z" fill="#5D697A"></path><path d="M14.9698 5.83C14.3817 4.30882 13.3608 2.99331 12.0332 2.04604C10.7056 1.09878 9.12953 0.561286 7.49979 0.5C5.87005 0.561286 4.29398 1.09878 2.96639 2.04604C1.6388 2.99331 0.617868 4.30882 0.0297873 5.83C-0.00992909 5.93985 -0.00992909 6.06015 0.0297873 6.17C0.617868 7.69118 1.6388 9.00669 2.96639 9.95396C4.29398 10.9012 5.87005 11.4387 7.49979 11.5C9.12953 11.4387 10.7056 10.9012 12.0332 9.95396C13.3608 9.00669 14.3817 7.69118 14.9698 6.17C15.0095 6.06015 15.0095 5.93985 14.9698 5.83ZM7.49979 9.25C6.857 9.25 6.22864 9.05939 5.69418 8.70228C5.15972 8.34516 4.74316 7.83758 4.49718 7.24372C4.25119 6.64986 4.18683 5.99639 4.31224 5.36596C4.43764 4.73552 4.74717 4.15642 5.20169 3.7019C5.65621 3.24738 6.23531 2.93785 6.86574 2.81245C7.49618 2.68705 8.14965 2.75141 8.74351 2.99739C9.33737 3.24338 9.84495 3.65994 10.2021 4.1944C10.5592 4.72886 10.7498 5.35721 10.7498 6C10.7485 6.86155 10.4056 7.68743 9.79642 8.29664C9.18722 8.90584 8.36133 9.24868 7.49979 9.25Z" fill="#5D697A"></path></svg>
                                </a>
                                 <a href="' . route('admin.product.edit', $data->uuid) . '" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-stroke bg-white">
                                    <svg width="12" height="13" viewBox="0 0 12 13" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.8067 3.19354C12.0667 2.93354 12.0667 2.5002 11.8067 2.25354L10.2467 0.693535C10 0.433535 9.56667 0.433535 9.30667 0.693535L8.08 1.91354L10.58 4.41354M0 10.0002V12.5002H2.5L9.87333 5.1202L7.37333 2.6202L0 10.0002Z" fill="#5D697A"></path></svg>
                                </a>
                                <button onclick="deleteItem(\'' . route('admin.product.delete', $data->id) . '\', \'customer-datatable\')"
                                    class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-stroke bg-white"
                                    title="Delete">
                                    <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.76256 2.51256C6.09075 2.18437 6.53587 2 7 2C7.46413 2 7.90925 2.18437 8.23744 2.51256C8.4448 2.71993 8.59475 2.97397 8.67705 3.25H5.32295C5.40525 2.97397 5.5552 2.71993 5.76256 2.51256ZM3.78868 3.25C3.89405 2.57321 4.21153 1.94227 4.7019 1.4519C5.3114 0.84241 6.13805 0.5 7 0.5C7.86195 0.5 8.6886 0.84241 9.2981 1.4519C9.78847 1.94227 10.106 2.57321 10.2113 3.25H13C13.4142 3.25 13.75 3.58579 13.75 4C13.75 4.41422 13.4142 4.75 13 4.75H12V13C12 13.3978 11.842 13.7794 11.5607 14.0607C11.2794 14.342 10.8978 14.5 10.5 14.5H3.5C3.10217 14.5 2.72064 14.342 2.43934 14.0607C2.15804 13.7794 2 13.3978 2 13V4.75H1C0.585786 4.75 0.25 4.41422 0.25 4C0.25 3.58579 0.585786 3.25 1 3.25H3.78868ZM5 6.37646C5.34518 6.37646 5.625 6.65629 5.625 7.00146V11.003C5.625 11.3481 5.34518 11.628 5 11.628C4.65482 11.628 4.375 11.3481 4.375 11.003V7.00146C4.375 6.65629 4.65482 6.37646 5 6.37646ZM9.625 7.00146C9.625 6.65629 9.34518 6.37646 9 6.37646C8.65482 6.37646 8.375 6.65629 8.375 7.00146V11.003C8.375 11.3481 8.65482 11.628 9 11.628C9.34518 11.628 9.625 11.3481 9.625 11.003V7.00146Z" fill="#5D697A"></path></svg>
                                </button>
                            </li>

                        </ul>';
            })
            ->rawColumns(['thumbnail_image', 'title','accessibility','productCategory', 'productType', 'status', 'is_featured', 'created_by','action'])
            ->make(true);
    }
}
