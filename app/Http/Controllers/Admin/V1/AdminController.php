<?php



namespace App\Http\Controllers\Admin\V1;



use App\Http\Controllers\Controller;

use App\Models\Permission;

use App\Models\User;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;

use Auth;



class AdminController extends Controller

{

    //list

    public function list()

    {

        if (!Auth::user()->can('tutor_view')) {

            return redirect(route('admin.v1.dashboard'))->with('message', 'You don\'t have this section permission');

        }

        $users = User::with('user_activity_counters')

        ->whereHas("roles", function($q){ $q->where("id", '!=',1)->where("id", '!=',3)->where("id", '!=',4); })

        ->get();

        $acti = array(
            'active'          => "team_dash",
            'activetxt'       => "team_dash",
          );

       

        return view('admin.v1.admin.list', compact('users','acti'));

    }

    // add view

    public function add()

    {

        if (!Auth::user()->can('add_user')) {

                return redirect(route('admin.v1.dashboard'))->with('message', 'You don\'t have this section permission');

        }

        $acti = array(
            'active'          => "team_dash",
            'activetxt'       => "team_dash",
          );

        return view('admin.v1.admin.add',compact('acti'));

    }



    // add submit

    public function addSubmit(Request $request)

    {



        $this->validate($request, [

            'email'      =>  'required|email:rfc,dns|unique:users',

            'password'      =>  'required',

            'phone'      =>  'required',

            'name'      =>  'required',

            'role'      =>  'required',

        ]);




        $userObj = User::create(

            [

                'email' => $request->get('email'),

                'password' => Hash::make($request->get('password')),

                // 'username' => $request->name,

                'name' => $request->name,

                'phone' => $request->phone

            ]

        );

        $userObj->assignRole($request->role);

       

        $request->session()->flash('success', 'Your user has been added successfully.');

        return redirect()->route('admin.v1.admin.list');

    }


    public function contactus_inquiry(){

        
        $contact=DB::table('contactus_inquiry')->get();
        
        $acti = array(
            'active'          => "contact",
            'activetxt'       => "contact",
          );

        return view('admin.v1.admin.contactus', compact('contact','acti'));
    }

    // edit form

    public function edit(Request $request, $id)

    {

        if (!Auth::user()->can('admin_edit')) {

                return redirect(route('admin.v1.admin.list'))->with('message', 'You don\'t have this section permission');

        }

        $acti = array(
            'active'          => "team_dash",
            'activetxt'       => "team_dash",
          );

        $user = User::findOrFail($id);

        return view('admin.v1.admin.edit', compact('user','acti'));

    }



    // add submit

    public function editSubmit(Request $request, $id)

    {

        $user = User::findOrFail($id);

        $this->validate($request, [

            'email'      =>  'required|email:rfc,dns|unique:users,email,'.$id,

            'name'      =>  'required',

        ]);



        $userObj = User::find($user->id);

        if(isset($request->email)){

            $userObj->email = $request->email;

        }

        if(isset($request->name)){

            $userObj->name = $request->name;

        }

        if(isset($request->dob)){

            $userObj->dob = $request->dob;

        }

        if(isset($request->gender)){

            $userObj->gender = $request->gender;

        }

        if(isset($request->phone)){

            $userObj->phone = $request->phone;

        }

        if(isset($request->role)){

            $userObj->roles()->detach();

            $userObj->assignRole($request->role);

        }

        $userObj->save();

        if ($request->filled('user-password')) {



            $userObj = User::Where('id', $user->id)->update(

                [

                    'password' => Hash::make($request->get('user-password')),

                ]

            );

        }

        $request->session()->flash('success', 'Your user has been updated successfully.');

        return redirect()->route('admin.v1.admin.list');

    }



    public function block($id, $action)

    {

        if (!Auth::user()->can('admin_block')) {

                return redirect(route('admin.v1.admin.list'))->with('message', 'You don\'t have this section permission');

        }



        $action = ($action == 'block') ? 'inactive' : 'active';

        $userObj = User::find($id);

        $userObj->status = $action;

        $userObj->save();

        return redirect()->route('admin.v1.admin.list');

    }



    // delete

    public function delete($id)

    {



                if (!Auth::user()->can('admin_delete')) {

                return redirect(route('admin.v1.admin.list'))->with('message', 'You don\'t have this section permission');

            }



        $user = User::findOrFail($id);

        $user->delete();



        return redirect()->back();

    }

}