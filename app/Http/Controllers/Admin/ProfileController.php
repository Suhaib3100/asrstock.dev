<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileRequest;
use App\Models\FileManager;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $data['pageTitle'] = 'Profile';
        $data['navAccountSettingActiveClass'] = 'active';
        $data['subNavProfileActiveClass'] = 'active';
        return view('admin.profile.index', $data);
    }

    public function changePassword()
    {
        $data['pageTitle'] = 'Change Password';
        $data['navAccountSettingActiveClass'] = 'active';
        $data['subNavChangePasswordActiveClass'] = 'active';

        return view('admin.profile.change-password', $data);
    }

    public function changePasswordUpdate(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6'
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();


        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function update(ProfileRequest $request)
    {
        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->contact_number = $request->contact_number;
        $user->address = $request->address;
        $user->save();

        /*File Manager Call upload*/
        if ($request->profile_image) {
            $new_file = FileManager::where('origin_type', 'App\Models\User')->where('origin_id',$user->id)->first();

            if ($new_file)
            {
                $new_file->removeFile();
                $upload = $new_file->upload('User', $request->profile_image, null, $new_file->id);
            } else {
                $new_file = new FileManager();
                $upload = $new_file->upload('User', $request->profile_image);
            }

            if ($upload['status']) {
                $upload['file']->origin_id = $user->id;
                $upload['file']->origin_type = "App\Models\User";
                $upload['file']->save();
            }
        }
        /*End*/

        /*File Manager Call upload for Thumbnail Image*/
        if ($request->cover_image) {
            $new_file = FileManager::find($user->cover_image_id);

            if ($new_file) {
                $new_file->removeFile();
                $upload = $new_file->upload('User', $request->cover_image, null, $new_file->id);
            } else {
                $new_file = new FileManager();
                $upload = $new_file->upload('User', $request->cover_image);
            }
            if ($upload['status']) {
                $upload['file']->origin_type = "App\Models\User";
                $upload['file']->save();
                $user->cover_image_id = $upload['file']->id;
                $user->save();
            }

        }
        /*End*/

        return redirect()->back()->with('success', 'Profile has been updated');
    }
}
