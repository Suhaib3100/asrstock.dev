<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\FileManager;
use App\Models\Following;
use App\Models\LoginDevice;
use App\Models\Product;
use App\Models\Source;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $data['pageTitle'] = __('My Profile');
        $data['profileActive'] = 'active';
        return view('customer.profile', $data);
    }

    public function profileUpdate(Request $request)
    {
        $customer = auth()->user();

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'contact_number' => 'required',
            'image' => 'bail|nullable|mimes:jpeg,png,jpg,gif,svg',
            'cover_photo' => 'bail|nullable|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->slug = Str::slug($request->first_name . $request->last_name . $customer->id);
        $customer->email = $request->email;
        $customer->contact_number = $request->contact_number;
        $customer->address = $request->address;
        $customer->save();

        /*File Manager Call upload*/
        if ($request->image) {
            $new_file = FileManager::where('origin_type', 'App\Models\Customer')->where('origin_id', auth()->id())->first();

            if ($new_file) {
                $upload = $new_file->upload('Customer', $request->image, null, $new_file->id);
            } else {
                $new_file = new FileManager();
                $upload = $new_file->upload('Customer', $request->image);
            }

            if ($upload['status']) {
                $upload['file']->origin_id = auth()->id();
                $upload['file']->origin_type = "App\Models\Customer";
                $upload['file']->save();
            }

        }
        /*End*/

        /*File Manager Call upload for Thumbnail Image*/
        if ($request->cover_photo) {
            $new_file = FileManager::find($customer->cover_image_id);

            if ($new_file) {
                $new_file->removeFile();
                $upload = $new_file->upload( 'Customer', $request->cover_photo, null, $new_file->id);
            } else {
                $new_file = new FileManager();
                $upload = $new_file->upload('Customer', $request->cover_photo);
            }
            if ($upload['status']) {
                $upload['file']->origin_type = "App\Models\Customer";
                $upload['file']->save();
                $customer->cover_image_id = $upload['file']->id;
                $customer->save();
            }
        }
        /*End*/

        $response['message'] = __('Updated Successfully');
        return $this->success([], $response['message']);
    }

    public function changePassword(Request $request)
    {
        $customer = auth()->user();

        $request->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) use ($customer) {
                    if (!Hash::check($value, $customer->password)) {
                        $fail(__('The current password is incorrect.'));
                    }
                },
            ],
            'password' => 'required|confirmed|min:6',
        ]);

        $customer->password = Hash::make($request->password);
        $customer->save();

        $response['message'] = __("Password Changed successfully");
        return $this->success([], $response['message']);
    }

    public function deleteMyAccount()
    {
        DB::beginTransaction();
        $customer = auth()->user();

        try {
            Following::where('customer_id', $customer->id)->orWhere('following_customer_id', $customer->id)->delete();
            Product::where('customer_id', $customer->id)->delete();
            $customer->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $response['message'] = SOMETHING_WENT_WRONG;
            return $this->error([], $response['message']);
        }

        $response['message'] = "Deleted Successfully";
        return $this->success([], $response['message']);
    }

    public function loginDevices(Request $request)
    {
        $data['pageTitle'] = __('Login Devices');
        $data['deviceActive'] = 'active';
        $data['used_device'] = LoginDevice::whereCustomerId(auth()->id())->orderBy('id', 'desc')->count();
        $customerPlan = customerPlanExit(auth()->id());
        if ($customerPlan) {
            $data['device_limit'] = $customerPlan->plan->device_limit;
        } else {
            $data['device_limit'] = 1;
        }

        if ($request->wantsJson()) {
            $devices = LoginDevice::orderBy('id', 'desc')->where('customer_id', auth()->id());
            return datatables($devices)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    if (session()->getId() == $data->session_id) {
                        return '<p class="zBadge zBadge-current">' . __('Current') . '</p>';
                    }
                    return '<button onclick="logoutItem(\'' . route('customer.devices.logout', $data->id) . '\')" class="border-0 logoutBtn">' . __('Log Out') . '<div class="icon"><img src="' . asset("assets/images/icon/logout-icon.svg") . '" alt="" /></div></a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('customer.devices', $data);
    }

    public function singleDeviceLogout($id)
    {
        DB::beginTransaction();
        try {
            $loginDevice = LoginDevice::where(['id' => $id, 'customer_id' => auth()->id()])->first();
            if ($loginDevice) {
                // Delete the device record
                $loginDevice->delete();

                // Remove the session file associated with the device
                $sessionFilePath = storage_path('framework/sessions/' . $loginDevice->session_id);
                if (file_exists($sessionFilePath) && !is_null($loginDevice->session_id)) {
                    unlink($sessionFilePath);
                }
            }

            DB::commit();
            $response['message'] = "Logout successfully";
            return $this->success([], $response['message']);
        } catch (\Exception $e) {
            DB::rollBack();
            $response['message'] = SOMETHING_WENT_WRONG;
            return $this->error([], $response['message']);
        }
    }

    public function beAContributor()
    {
        if (auth()->user()->contributor_status == CONTRIBUTOR_STATUS_APPROVED) {
            return redirect()->route('frontend.index')->with('error', __('Already contributor.'));
        }

        $data['pageTitle'] = __('Be A Contributor');
        $data['countries'] = Country::all();
        $data['sources'] = Source::all();
        $data['searchDisable'] = true;
        $data['settings'] = array(
            'contributor_first_portion_icon_title' => getOption('contributor_first_portion_icon_title'),
            'contributor_first_portion_first_para_title' => getOption('contributor_first_portion_first_para_title'),
            'contributor_first_portion_first_para_subtitle' => getOption('contributor_first_portion_first_para_subtitle'),
            'contributor_first_portion_second_para_title' => getOption('contributor_first_portion_second_para_title'),
            'contributor_first_portion_second_para_subtitle' => getOption('contributor_first_portion_second_para_subtitle'),
            'contributor_second_portion_image' => getSettingImage('contributor_second_portion_image'),
            'contributor_second_portion_title' => getOption('contributor_second_portion_title'),
            'contributor_second_portion_subtitle' => getOption('contributor_second_portion_subtitle'),
            'contributor_third_portion_title' => getOption('contributor_third_portion_title'),
            'contributor_third_portion_subtitle' => getOption('contributor_third_portion_subtitle'),
            'contributor_third_portion_image' => getSettingImage('contributor_third_portion_image'),
            'contributor_fourth_portion_image' => getSettingImage('contributor_fourth_portion_image'),
            'contributor_fourth_portion_title' => getOption('contributor_fourth_portion_title'),
            'contributor_fourth_portion_subtitle' => getOption('contributor_fourth_portion_subtitle'),
        );

        return view('frontend.be_a_contributor', $data);
    }

    public function beAContributorStore(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'contact_number' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'portfolio_link' => 'required|url',
            'source_id' => 'required',
        ]);

        $customer = auth()->user();

        if ($customer->contributor_apply == 1) {
            return $this->error([], __('Already applied.'));
        }

        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->slug = Str::slug($request->first_name . '' . $request->last_name);
        $customer->email = $request->email;
        $customer->contact_number = $request->contact_number;
        $customer->country_id = $request->country_id;
        $customer->state_id = $request->state_id;
        $customer->city_id = $request->city_id;
        $customer->portfolio_link = $request->portfolio_link;
        $customer->status = ACTIVE;
        $customer->source_id = $request->source_id;
        $customer->contributor_apply = CONTRIBUTOR_APPLY_YES;
        $customer->contributor_status = CONTRIBUTOR_STATUS_PENDING;
        $customer->save();

        return $this->success([], __('Applied Successfully'));
    }

    public function following(Request $request)
    {
        $data['pageTitle'] = __('My Following');
        $data['activeFollowing'] = 'active';
        $data['followings'] = Following::with(['followingCustomer', 'followingUser'])
            ->withCount(['contributorProducts', 'userProducts'])
            ->where('customer_id', auth()->id())
            ->paginate(10);

        return view('customer.followings', $data);
    }

    public function followingStoreRemove(Request $request)
    {
        $request->validate([
            'following_customer_id' => 'required_without:following_user_id',
        ]);

        $following = '';
        if ($request->following_user_id) {
            $following = Following::where('following_user_id', $request->following_user_id)->where('customer_id', auth()->id())->first();
        } elseif ($request->following_customer_id) {
            if (auth()->id() == $request->following_customer_id) {
                $response['message'] = __('You can\'t follow yourself.');
                return $this->error([], $response['message']);
            }
            $following = Following::where('following_customer_id', $request->following_customer_id)->where('customer_id', auth()->id())->first();
        }

        if ($following) {
            Following::find($following->id)->delete();
            return $this->success([],__('Unfollow Successfully.'));
        }

        $following = new Following();
        $following->following_user_id = $request->following_user_id;
        $following->following_customer_id = $request->following_customer_id;
        $following->customer_id = auth()->id();
        $following->save();

        return $this->success([],__('Follow Successfully.'));
    }
}
