<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        if (!Auth::user()->can('add_role')) {
            abort('403');
        } // end permission checking

        $data['pageTitle'] = 'All Roles';
        $data['subNavRoleIndexActiveClass'] = 'active';
        $data['showAdminManagement'] = 'show';
        $data['roles'] = Role::get();
        return view('admin.role.index', $data);
    }

    /**
     * Show the form for creating a new reso
     */
    public function create()
    {
        if (!Auth::user()->can('add_role')) {
            abort('403');
        } // end permission checking

        $data['pageTitle'] = 'Add Role';
        $data['roles'] = Role::all();
        $data['permissions'] = Permission::all();
        $data['subNavAddRoleActiveClass'] = 'active';
        $data['showAdminManagement'] = 'show';
        return view('admin.role.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(RoleRequest $request)
    {
        if(env('APP_DEMO') == 'active'){
            return redirect()->back()->with('error', 'This is a demo version! You can get full access after purchasing the application.');
        }

        $permissions = [];
        if (array_key_exists('group-a', $request->all())) {
            foreach ($request['group-a'] as $group) {
                if (array_key_exists('permissions', $group)) {
                    foreach ($group['permissions'] as $permission) {
                        array_push($permissions, $permission);
                    }
                }
                if (array_key_exists('mother-permissions', $group)) {
                    array_push($permissions, $group['mother-permissions']);
                }
            }
        }

        $role = new Role();
        $role->name = $request->name;
        $role->save();

        foreach ($permissions as $item) {
            $role->givePermissionTo($item);
        }

        return redirect()->route('admin.role.index')->with('success', __('Saved Successfully'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        $data['pageTitle'] = __('Role Permission Details');
        $data['subNavRoleIndexActiveClass'] = 'active';
        $data['showAdminManagement'] = 'show';
        $data['role'] = Role::find($id);

        $data['permissions'] = DB::table('role_has_permissions')
            ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->where('role_has_permissions.role_id', '=', $id)->get();

        return view('admin.role.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        $data['pageTitle'] = 'Edit Role';
        $data['subNavRoleIndexActiveClass'] = 'active';
        $data['showAdminManagement'] = 'show';
        $data['role'] = Role::find($id);
        $data['permissions'] = Permission::all();

        $data['parentSelectedPermissions'] = DB::table('role_has_permissions')
            ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->where('role_has_permissions.role_id', '=', $id)
            ->where('permissions.submodule_id', '=', 0)->get();


        $data['childSelectedPermissions'] = DB::table('role_has_permissions')
            ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->where('role_has_permissions.role_id', '=', $id)
            ->where('permissions.submodule_id', '!=', 0)
            ->get();

        return view('admin.role.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     */
    public function update(RoleRequest $request, $id)
    {
        if(env('APP_DEMO') == 'active'){
            return redirect()->back()->with('error', 'This is a demo version! You can get full access after purchasing the application.');
        }

        $permissions = [];
        if (array_key_exists('group-a', $request->all())) {
            foreach ($request['group-a'] as $group) {
                if (array_key_exists('permissions', $group)) {
                    foreach ($group['permissions'] as $permission) {
                        array_push($permissions, $permission);
                    }
                }
                if (array_key_exists('mother-permissions', $group)) {
                    array_push($permissions, $group['mother-permissions']);
                }
            }
        }


        $role = Role::find($id);
        $role->name = $request->get('name');
        $role->save();
        $role->syncPermissions();

        foreach ($permissions as $item) {
            $role->givePermissionTo($item);
        }
        return redirect()->route('admin.role.index')->with('success', __('Update Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     */
    public function destroy($id)
    {
        if(env('APP_DEMO') == 'active'){
            return redirect()->back()->with('error', 'This is a demo version! You can get full access after purchasing the application.');
        }

        $role = Role::find($id);
        $role->syncPermissions();
        $role->delete();
        return redirect()->route('admin.role.index')->with('success', 'Deleted Successfully');
    }

    public function getSubmodule($id)
    {
        $permissions = Permission::where("submodule_id", $id)->get();
        $permission = Permission::where('id', $id)->first();

        return response()->json(['permission' => $permission, 'permissions' => $permissions]);

    }
}
