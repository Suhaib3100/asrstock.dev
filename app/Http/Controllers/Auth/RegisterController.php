<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Referral;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'user_name' => ['required', 'string', 'regex:/^\S*$/u', 'max:255', 'unique:customers,user_name'],
            'contact_number' => ['required', 'min:9', 'max:20'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new customer instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\Customer
     */
    protected function create(array $data)
    {
        return Customer::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'user_name' => $data['user_name'],
            'slug' => \Str::slug($data['first_name'] . '-' . $data['last_name']),
            'contact_number' => $data['contact_number'],
            'email' => $data['email'],
            'email_verified_at' => now(),
            'password' => Hash::make($data['password']),
            'status' => (getOption('registration_approval') == 1) ? PENDING : ACTIVE,
            'role' => 1, // Default customer role
        ]);
    }

    /**
     * Handle the registration process.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validate the input data
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Check if there's a referred_by field
        if ($request->referred_by) {
            $referredCustomer = Customer::where('user_name', $request->referred_by)->first();
            if (!$referredCustomer) {
                return back()->with('error', 'Your referred by name is invalid! Please try another or proceed without a referral.');
            }
        }

        DB::beginTransaction();
        try {
            // Create the new customer
            $customer = $this->create($request->all());

            // Handle referral if applicable
            if ($request->referred_by) {
                $referral = new Referral();
                $referral->parent_customer_id = $referredCustomer->id;
                $referral->child_customer_id = $customer->id;
                $referral->save();
            }

            // If registration approval is required
            if (getOption('registration_approval') == 1) {
                DB::commit();
                return redirect()->route('login')->with('success', 'You are successfully registered. Our admin will approve the request.');
            } else {
                DB::commit();
                return redirect(route('login'))->with('success', 'You are successfully registered.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong. Please try again later.');
        }
    }
    public function showRegistrationForm()
    {
        $data['searchDisable'] = false;
        return view('auth.register',$data);
    }
}
