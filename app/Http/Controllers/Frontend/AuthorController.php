<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Following;
use App\Models\User;

class AuthorController extends Controller
{
    public function profile($type, $user_name)
    {
        $data['pageTitle'] = __('Author\'s Profile');

        $data['type'] = $type;
        if ($type == 1) {
            $data['author'] = Customer::where('user_name', $user_name)->with(['followers.customer', 'followings.followingCustomer', 'followings.followingUser'])->firstOrFail();
        } else {
            $data['author'] = User::where('slug', $user_name)->with(['followers'])->firstOrFail();
        }

        $data['followings'] = Following::where('customer_id', auth()->id())->get();

        return view('frontend.author_details', $data);
    }
}
