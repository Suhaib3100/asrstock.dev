<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NewsletterMail;
use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function list()
    {
        $data['pageTitle'] = 'Newsletter Subscriber List';
        $data['navNewsletterActiveClass'] = "active";
        $data['newsletters'] = Newsletter::get();
        $data['mails'] = Newsletter::select('email')->get();

        return view('admin.newsletter-list')->with($data);
    }

    public function delete($id)
    {
        Newsletter::findOrFail($id)->delete();
        return redirect()->back()->with('success', __('Deleted Successfully'));
    }

    public function sendMail(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'mail_type' => 'required',
            'message' => 'required'
        ]);

        if (getOption('app_mail_status') == 1) {
            if ($request->mail_type == 1)
            {
                $mails = Newsletter::select('email')->get();
                foreach ($mails as $mail){
                    try {
                        Mail::to($mail)->send(new NewsletterMail($request->subject, $request->message));
                    } catch (\Exception $exception) {
                        //
                    }
                }
            } elseif($request->mail_type == 2) {
                try {
                    Mail::to($request->mail)->send(new NewsletterMail($request->subject, $request->message));
                } catch (\Exception $exception) {
                    return redirect()->back()->with('error', __(SOMETHING_WENT_WRONG));
                }
            }

            return redirect()->back()->with('success', __('Mail sent has been processing'));
        }

        return redirect()->back()->with('success', __('Sorry! Mail sent is off now!'));

    }

}
