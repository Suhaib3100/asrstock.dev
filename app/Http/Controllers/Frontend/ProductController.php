<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BoardProduct;
use App\Models\FavouriteProduct;
use App\Models\Following;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductType;
use App\Models\ProductTypeExtension;
use App\Models\ReportedCategory;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ResponseTrait;

    public function productDetails($slug)
    {
        $data['searchDisable'] = true;

        $data['product'] = Product::published()->where(['slug' => $slug])
            ->with(['user', 'customer', 'productCategory', 'productTags.tag', 'comments.customer', 'variations:id,product_id,price,variation', 'colors'])
            ->withCount(['downloadProducts', 'favouriteProducts'])
            ->firstOrFail();
        $data['pageTitle'] = $data['product']->title;
        Product::where('id', $data['product']->id)->increment('total_watch', 1);

        $data['following'] = Following::where('customer_id', auth()->id())->get();
        $data['favouriteCheck'] = FavouriteProduct::where('customer_id', auth()->id())->get();
        $data['boardCheck'] = BoardProduct::join('boards', 'boards.id', '=', 'board_products.board_id')->where('customer_id', auth()->id())->get();
        $data['donatePrice'] = getOption('donate_price', 10);
        $data['relatedProducts'] = Product::where('product_type_id', $data['product']->product_type_id)->published()->latest()->take(8)->get();
        $data['reportedCategories'] = ReportedCategory::active()->get();

        return view('frontend.product_details', $data);
    }

    public function productType($uuid)
    {
        $productType = ProductType::where("uuid", $uuid)->first();
        $data['pageTitle'] = $productType->name;
        $data['productType'] = $productType;
        $data['favouriteCheck'] = FavouriteProduct::where('customer_id', auth()->id())->get();
        $data['boardCheck'] = BoardProduct::join('boards', 'boards.id', '=', 'board_products.board_id')->where('customer_id', auth()->id())->get();
        $data['blogsData'] = Blog::with(['category'])->active()->orderBy('id', 'DESC')->take(6)->get();
        $data['productCategory'] = ProductCategory::withCount('products')->with('product')->whereHas('product')->where('product_type_id', $productType->id)->get();
        $data['premiumResources'] = Product::published()->where(['product_type_id' => $productType->id, 'accessibility' => 1])->take(11)->get();
        $data['freeResources'] = Product::published()->where(['product_type_id' => $productType->id, 'accessibility' => 2])->take(11)->get();

        return view('frontend.product-types', $data);
    }

    public function searchResult(Request $request)
    {
        $data['pageTitle'] = __('Search Result');
        $query = Product::where('products.status', PRODUCT_STATUS_PUBLISHED);
        $query->select('products.*');
        // Filter by category if specified
        if ($request->has('asset_type') && $request->asset_type != 'all' && $request->asset_type != '' && $request->has('category') && is_array($request->category)) {
            $query->whereHas('productCategory', function ($query) use ($request) {
                $query->whereIn('product_categories.slug', $request->category);
            });
        }

        // Filter by color if specified
        if ($request->has('color')) {
            $query->join('product_colors', 'product_colors.product_id', 'products.id')
                ->where('color_code', $request->color);
        }

        if ($request->has('file_type') && $request->file_type != 'all' && $request->file_type != '') {
            $query->where('products.file_types', $request->file_type);
        }

        // Filter by is_featured if specified
        if ($request->has('choice')) {
            $query->where('products.is_featured', 1);
        }

        if ($request->has('license') && $request->license != 'all' && $request->license != '') {
            $query->where('products.accessibility', $request->license);
        }

        // Filter by product type (asset type) if specified
        if ($request->has('asset_type') && $request->asset_type != 'all' && $request->asset_type != '') {
            $query->whereHas('productCategory.productType', function ($query) use ($request) {
                $query->where('uuid', $request->asset_type);
            });
        }

        if ($request->has('search_key') && $request->search_key != '') {
            $searchKey = '%' . $request->search_key . '%';
            $query->leftJoin('product_tags', 'products.id', '=', 'product_tags.product_id')
                ->leftJoin('tags', 'product_tags.tag_id', '=', 'tags.id')
                ->where(function ($query) use ($searchKey) {
                    $query->where('products.title', 'like', $searchKey)
                        ->orWhere('products.description', 'like', $searchKey)
                        ->orWhere('tags.name', 'like', $searchKey);
                })->distinct(); // To avoid duplicate products
        }

        if ($request->has('sort_by') && $request->sort_by != '') {
            if ($request->sort_by == 'newest') {
                $query->orderBy('products.id', 'DESC');
            } elseif ($request->sort_by == 'oldest') {
                $query->orderBy('products.id', 'ASC');
            } else {
                $query->orderBy('products.total_watch', 'desc');
            }
        } else {
            $query->orderBy('products.id', 'DESC');
        }

        // Pagination
        $data['products'] = $query->paginate(16)->withQueryString();

        // Fetch product categories based on asset type
        $data['productCategories'] = ProductCategory::join('product_types', 'product_types.id', '=', 'product_categories.product_type_id')
            ->where('product_types.uuid', $request->asset_type)
            ->select('product_categories.*')
            ->get();

        $data['favouriteCheck'] = FavouriteProduct::where('customer_id', auth()->id())->get();
        $data['boardCheck'] = BoardProduct::join('boards', 'boards.id', '=', 'board_products.board_id')->where('customer_id', auth()->id())->get();

        $data['fileTypes'] = ProductTypeExtension::all();

        return view('frontend.search_results', $data);
    }

    public function getProductByContributor($type, $user_or_contributor_id, $product_type_id)
    {
        if ($type == 1) {
            $data['products'] = Product::published()->where('customer_id', $user_or_contributor_id);
        } else {
            $data['products'] = Product::published()->where('user_id', $user_or_contributor_id);
        }

        $data['favouriteCheck'] = FavouriteProduct::where('customer_id', auth()->id())->get();
        $data['boardCheck'] = BoardProduct::join('boards', 'boards.id', '=', 'board_products.board_id')->where('customer_id', auth()->id())->get();
        $data['products'] = $data['products']->where('product_type_id', $product_type_id)->get();

        return $this->success(['html' => view('frontend.author_product_list', $data)->render(), __('Data Fetch Successfully')]);
    }

}
