<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->can('admin_list')) {
            abort('403');
        } // end permission checking

        $data['pageTitle'] = __('All Admin');
        $data['subNavAdminIndexActiveClass'] = 'active';
        $data['showAdminManagement'] = 'show';
        $data['users'] = User::where(function ($q) use ($request) {
            if ($request->search_string) {
                $q->where('name', 'like', "%{$request->search_string}%");
            }
        })->where('id', '!=', 1)->latest()->get();
        return view('admin.user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('add_admin')) {
            abort('403');
        } // end permission checking

        $data['pageTitle'] = __('Add Admin');
        $data['subNavAddAdminActiveClass'] = 'active';
        $data['showAdminManagement'] = 'show';
        $data['roles'] = Role::all();
        return view('admin.user.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        if(env('APP_DEMO') == 'active'){
            return redirect()->back()->with('error', 'This is a demo version! You can get full access after purchasing the application.');
        }
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->slug = Str::slug($request->name);
        $user->contact_number = $request->contact_number;
        $user->address = $request->address;
        $user->password = Hash::make($request->password);
        $user->assignRole($request->role_name);
        $user->email_verified_at = Carbon::now()->format("Y-m-d H:i:s");
        $user->save();
        return redirect()->route('admin.user.index')->with('success', __('Created Successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['pageTitle'] = 'Edit Admin';
        $data['subNavAdminIndexActiveClass'] = 'active';
        $data['showAdminManagement'] = 'show';
        $data['roles'] = Role::all();
        $data['user'] = User::findOrFail($id);
        return view('admin.user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        if(env('APP_DEMO') == 'active'){
            return redirect()->back()->with('error', 'This is a demo version! You can get full access after purchasing the application.');
        }
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->slug = Str::slug($request->name);
        $user->contact_number = $request->contact_number;
        $user->address = $request->address;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->assignRole($request->role_name);

        $user->save();
        return redirect()->route('admin.user.index')->with('success', __('Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(env('APP_DEMO') == 'active'){
            return redirect()->back()->with('error', 'This is a demo version! You can get full access after purchasing the application.');
        }
        if(User::first()->id == $id || auth()->id() == $id){
            return redirect()->back()->with('error', __('User cannot be deleted. Please contact with super-admin'));
        }

        User::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Deleted Successfully');
    }
}
