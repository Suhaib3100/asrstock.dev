<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Board;
use App\Models\BoardProduct;
use App\Models\City;
use App\Models\ContactUs;
use App\Models\ContactUsTopic;
use App\Models\FavouriteProduct;
use App\Models\Newsletter;
use App\Models\Policy;
use App\Models\Product;
use App\Models\State;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\TrustedBrand;
use App\Models\WhyUsPoint;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $data['searchDisable'] = true;
        $data['pageTitle'] = __('Home');
        $data['whyUs'] = WhyUsPoint::all();
        $data['testimonialData'] = Testimonial::all();
        $data['favouriteCheck'] = FavouriteProduct::where('customer_id', auth()->id())->get();
        $data['boardCheck'] = BoardProduct::join('boards', 'boards.id', '=', 'board_products.board_id')->where('customer_id', auth()->id())->get();
        $data['productTypeData'] = getProductType();
        $data['latestCollection'] = Product::published()->orderBy('id', 'desc')->take(8)->get();
        $data['blogsData'] = Blog::with(['category'])->active()->orderBy('id', 'DESC')->take(3)->get();
        $data['editorChoice'] = Product::published()->isFeatured()->orderBy('id', 'DESC')->take(11)->get();
        $data['trendingCollection'] = Product::published()->orderBy('total_watch', 'desc')->take(11)->get();
        return view('frontend.index', $data);
    }

    public function fetchCountryStates($country_id)
    {
        $response['states'] = State::whereCountryId($country_id)->get();
        return $this->success($response['states']);
    }

    public function fetchStateCities($state_id)
    {
        $response['cities'] = City::whereStateId($state_id)->get();
        return $this->success($response['cities']);
    }

    public function contactUs()
    {
        $data['searchDisable'] = true;
        $data['pageTitle'] = __('Contact Us');
        $data['contactUsTopic'] = ContactUsTopic::where('status', ACTIVE)->get();
        return view('frontend.contact-us', $data);
    }

    public function aboutUs()
    {
        $data['searchDisable'] = true;
        $data['pageTitle'] = __('About Us');
        $data['teamMembers'] = TeamMember::all();
        $data['settings'] = array(
            'top_area_title' => getOption('top_area_title'),
            'top_area_subtitle' => getOption('top_area_subtitle'),
            'gallery_first_image' => getSettingImage('gallery_first_image'),
            'gallery_second_image' => getSettingImage('gallery_second_image'),
            'gallery_third_image' => getSettingImage('gallery_third_image'),
            'gallery_fourth_image' => getSettingImage('gallery_fourth_image'),
            'team_member_title' => getOption('team_member_title'),
            'team_member_subtitle' => getOption('team_member_subtitle'),
            'about_us_image' => getSettingImage('about_us_image'),
            'about_us_description' => getOption('about_us_description'),
            'about_us_point1_title' => getOption('about_us_point1_title'),
            'about_us_point1_description' => getOption('about_us_point1_description'),
            'about_us_point2_title' => getOption('about_us_point2_title'),
            'about_us_point2_description' => getOption('about_us_point2_description'),
            'trusted_section_title' => getOption('trusted_section_title'),
            'about_us_total_assets' => getOption('about_us_total_assets'),
            'about_us_downloads' => getOption('about_us_downloads'),
            'about_us_creators' => getOption('about_us_creators'),
            'about_us_countries' => getOption('about_us_countries'),
        );
        $data['whyUs'] = WhyUsPoint::all();
        $data['trustedBrands'] = TrustedBrand::all();
        $data['testimonialData'] = Testimonial::all();
        return view('frontend.about-us', $data);
    }

    public function page($type)
    {
        $data['searchDisable'] = true;
        $data['pageTitle'] = __('Page Details');
        $data['policy'] = Policy::where('type', $type)->first();
        return view('frontend.page', $data);
    }

    public function contactUsStore(Request $request)
    {
        $validated = $request->validate([
            "name" => ['required', 'string', 'max:255'],
            "email" => ['required', 'email:rfc,dns', 'max:255'],
            'message' => ['required', 'string'],
            'contact_us_topic_id' => ['required'],
        ]);
        DB::beginTransaction();
        try {

            $contactUs = new ContactUs();
            $contactUs->name = $request->name;
            $contactUs->email = $request->email;
            $contactUs->message = $request->message;
            $contactUs->contact_us_topic_id = $request->contact_us_topic_id;
            $contactUs->save();

            DB::commit();
            $message = getMessage(SENT_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function favouriteProductStoreDelete(Request $request)
    {
        Validator::make($request->all(), [
            'product_id' => 'required',
        ]);

        if (!auth()->check()) {
            throw new Exception('Please log in first !');
        }

        $favouriteProduct = FavouriteProduct::where(['customer_id' => Auth::id(), 'product_id' => $request->product_id])->first();
        if ($favouriteProduct) {
            $favouriteProduct->delete();
            $response['message'] = 'Deleted from Favourite List.';
            return $this->success($response, $response['message']);
        }

        $favouriteProduct = new FavouriteProduct();
        $favouriteProduct->product_id = $request->product_id;
        $favouriteProduct->customer_id = Auth::id();
        $favouriteProduct->save();

        $response['message'] = 'Added from Favourite List.';
        return $this->success($response, $response['message']);

    }

    public function productBoardModal(Request $request, $product_id=null)
    {
        if (!auth()->check()) {
            $response['message'] = 'Please log in first !';
            return $this->error([], $response['message']);
        }
        $data['getBoardName'] = Board::where('customer_id', auth()->user()->id)->get();
        $data['product_id'] = $product_id;
        return view('customer.boards.board-modal', $data);
    }

    public function newsletter(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $newsletter = new Newsletter();
        $newsletter->email = $request->email;
        $newsletter->save();

        return $this->success([],__('Newsletter Subscribed Successfully'));
    }

}
