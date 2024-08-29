<?php

namespace App\Http\Controllers\Admin\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use DB;

class PermissionController extends Controller
{
    // listing of all permission
    public function list()
    {
        
        $role_permissions = Role::with('permissions')->get();
        $acti = array(
            'active'          => "set_view",
            'activetxt'       => "set_view",
          );
        return view('admin.v1.settings.permission.list', compact('role_permissions','acti'));
    }

    public function add_role_permission()
    {
        if (auth()->user()->roles->pluck('name')[0] != "super admin" ) {

            // if (!$permission->sitesetting_edit) {
                return redirect(route('admin.v1.dashboard'))->with('message', 'You don\'t have this section permission');
            // }
        }
        $acti = array(
            'active'          => "set_view",
            'activetxt'       => "set_view",
          );
        // $role_permissions = Role::whereId($id)->with('permissions')->first();
        return view('admin.v1.settings.permission.add',compact('acti'));
    }

    public function add_role_permission_submit(Request $request)
    {
       
        $this->validate($request, [
            'name'        => 'required|max:20|unique:roles,name,',
            // 'permissions' => 'required',
        ]);
       
        // update role
        $role = new Role();
            $role->name = $request->name;
            $role->save();

            $permissions = $request->permissions;
                
            if($permissions){
            foreach ($permissions as $permission) { 
                $p = Permission::where('name', '=', $permission)->first(); //Get corresponding form //permission in db
                if($p)
                   $role->givePermissionTo($p);  //Assign permission to role
            }
        }

        return redirect()->route('admin.v1.settings.permission');
    }
    public function edit($id)
    {
        if (auth()->user()->roles->pluck('name')[0] != "super admin" ) {

            // if (!$permission->sitesetting_edit) {
                return redirect(route('admin.v1.dashboard'))->with('message', 'You don\'t have this section permission');
            // }
        }
        $acti = array(
            'active'          => "set_view",
            'activetxt'       => "set_view",
          );
        $role_permissions = Role::whereId($id)->with('permissions')->first();
        return view('admin.v1.settings.permission.edit', compact('role_permissions','acti'));
    }

    public function editSubmit(Request $request, $id)
    {
       
        $this->validate($request, [
            'name'        => 'required|max:20',
            // 'permissions' => 'required',
        ]);
       
        // update role
        $role = Role::find($id);
            $role->name = $request->name;
            $role->save();

            $permissions = $request->permissions;
            $p_all = Permission::all(); //Get all permissions

            foreach ($p_all as $p) {
                $role->revokePermissionTo($p); //Remove all permissions associated with role
            }
    
            if($permissions){
            foreach ($permissions as $permission) { 
                $p = Permission::where('name', '=', $permission)->first(); //Get corresponding form //permission in db
                if($p)
                   $role->givePermissionTo($p);  //Assign permission to role
            }
        }

        return redirect()->route('admin.v1.settings.permission');
    }
    public function delete($id)
    {
       
        // update role
        $role = Role::whereId($id)->with('permissions')->first();
           
            $p_all = Permission::all(); //Get all permissions

            foreach ($p_all as $p) {
                $role->revokePermissionTo($p); //Remove all permissions associated with role
            }
    
            $role = Role::destroy($id);

        return redirect()->route('admin.v1.settings.permission');
    }
}
