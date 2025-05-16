<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPasswordMail;
use App\Models\Customer;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Handle the password reset email sending.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        // Validate the email input
        $request->validate(['email' => 'required|email']);

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer) {
            return back()->withErrors(['email' => 'No user found with this email.']);
        }

        try {
            // Generate the reset token
            $token = Password::createToken($customer);

            // Check mail status and send the custom email
            if (getOption('app_mail_status') == 1) {
                Mail::to($customer->email)->send(new ForgotPasswordMail($customer, $token));
                return back()->with('success', 'A password reset link has been sent to your email.');
            } else {
                return back()->withErrors(['email' => 'Mail verification is currently disabled.']);
            }
        } catch (\Exception $exception) {
            return back()->withErrors(['email' => 'An error occurred while sending the email. Please try again later.']);
        }
    }
    public function showLinkRequestForm()
    {
        $data['searchDisable'] = false;
        return view('auth.passwords.email',$data);
    }
}
