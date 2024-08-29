<?php



namespace App\Http\Controllers\Admin\V1;



use App\Models\User;

use App\Models\UserMeta;

use App\Models\Permission;

use App\Models\Transaction;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Api\UserObj;

use App\Models\ReferredUser;



use Illuminate\Support\Facades\Storage;



class AppUsersController extends Controller

{



    public function list()

    {

        $users = User::with('user_activity_counters','coursesenroll')

        ->whereHas("roles", function($q){ $q->where("id",3); })

        ->get();

        // dd($users->toArray());

        if (auth()->user()->roles->pluck('name')[0] != "super admin" && auth()->user()->roles->pluck('name')[0] != "admin") {

            // if (!$permission->appuser_view) {



                return redirect(route('admin.v1.dashboard'))->with('message', 'You don\'t have this section permission');

            // }

        }

        $acti = array(
            'active'          => "user_dash",
            'activetxt'       => "user_dash",
          );

        return view('admin.v1.appusers.list', compact('users','acti'));

    }



    public function listid($id)

    {

        $users = User::with('user_activity_counters','coursesenroll')

        ->whereHas("roles", function($q){ $q->where("id",3); })->where('id',$id)

        ->first();

        $transaction = Transaction::where('subscriber_id',$id)->with('course','teacher','Circullum_topic')->get();

        // dd($transaction->toArray());

        if (auth()->user()->roles->pluck('name')[0] != "super admin" && auth()->user()->roles->pluck('name')[0] != "admin") {

            // if (!$permission->appuser_view) {



                return redirect(route('admin.v1.dashboard'))->with('message', 'You don\'t have this section permission');

            // }

        }
        $acti = array(
            'active'          => "user_dash",
            'activetxt'       => "user_dash",
          );
        return view('admin.v1.appusers.listid', compact('users','transaction','acti'));

    }



    // add view

    public function add()

    {

        if (!Auth::user()->can('add_user')) {

                return redirect(route('admin.v1.dashboard'))->with('message', 'You don\'t have this section permission');

        }

        $acti = array(
            'active'          => "user_dash",
            'activetxt'       => "user_dash",
          );

        return view('admin.v1.appusers.add',compact('acti'));

    }



    // add submit

    public function addSubmit(Request $request)

    {



        $this->validate($request, [

            'avtar'      =>  'mimes:jpeg,jpg,png,gif|max:300',

            'email'      =>  'required|email:rfc,dns|unique:users',

            'password'      =>  'required',

            'name'      =>  'required',

            'phone'      =>  'required',

        ]);



        if ($request->hasfile('avtar')) {

            $filed      = $request->file('avtar');

            $named      = 'user/appuser/' . time() . '.' . $filed->getClientOriginalExtension();

            Storage::disk('public')->put($named, file_get_contents($filed->getRealPath()));

            $icon_name = $named;

        } else {

            $icon_name = null;

        }

        $userObj = User::create(

            [

                'email' => $request->get('email'),

                'password' => Hash::make($request->get('password')),

                'name' => $request->name,

                'dob' => $request->dob,

                'gender' => $request->gender,

                'phone' => $request->phone,

                'avtars' => $icon_name

            ]

        );

        $userObj->assignRole('user');

       

        $request->session()->flash('success', 'Your user has been added successfully.');
        $acti = array(
            'active'          => "user_dash",
            'activetxt'       => "user_dash",
          );
        return redirect()->route('admin.v1.appuser.list');

    }



    // edit form

    public function edit(Request $request, $id)

    {

        if (!Auth::user()->can('appuser_view')) {

                return redirect(route('admin.v1.user.list'))->with('message', 'You don\'t have this section permission');

        }

        $acti = array(
            'active'          => "user_dash",
            'activetxt'       => "user_dash",
          );

        $user = User::findOrFail($id);

        return view('admin.v1.appusers.edit', compact('user','acti'));

    }



    // add submit

    public function editSubmit(Request $request, $id)

    {

        $user = User::findOrFail($id);

        $this->validate($request, [

            'avtar'      =>  'mimes:jpeg,jpg,png,gif|max:300',

            'name'      =>  'required',

            'email'      =>  'required|email:rfc,dns|unique:users,email,'.$id,

        ]);



        $userObj = User::find($user->id);

        if ($request->hasfile('avtar')) {

            $filed      = $request->file('avtar');

            $named      = 'user/appuser/' . time() . '.' . $filed->getClientOriginalExtension();

            Storage::disk('public')->put($named, file_get_contents($filed->getRealPath()));

            $userObj->avtars = $named;

        } 

        if(isset($request->email)){

            $userObj->email = $request->email;

        }

        if(isset($request->name)){

            $userObj->name = $request->name;

        }

        if(isset($request->username)){

            $userObj->username = $request->username;

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

        $userObj->save();

        if ($request->filled('user-password')) {



            $userObj = User::Where('id', $user->id)->update(

                [

                    'password' => Hash::make($request->get('user-password')),

                ]

            );

        }


        $request->session()->flash('success', 'Your user has been updated successfully.');

        return redirect()->route('admin.v1.appuser.list');

    }



    public function referredList($user_id)

    {

        $referred_by = collect(ReferredUser::where('referred_by', $user_id)->get())->pluck('user_id');

        $users = User::whereIn('id', $referred_by)->where('role', '!=', 2)->where('role', '!=', 3)->get();

        if (!Auth::user()->can('appuser_view')) {

                return redirect(route('admin.v1.dashboard'))->with('message', 'You don\'t have this section permission');

        }

        return view('admin.v1.appusers.list', compact('users'));

    }



    public function view($id)

    {

       

        if (!Auth::user()->can('appuser_view')) {

                return redirect(route('admin.v1.appuser.list'))->with('message', 'You don\'t have this section permission');

        }

        $user = User::where('id', $id)->first();

        $user_details_arr = [

            'id' => $user->id,

            'name' => $user->name,

            'username' => $user->username,

            'email' => (empty($user->social_login_id)) ? NULL : $user->email,

            'dob' => $user->dob,

            'phone' => $user->phone,

            'avatar' => $user->avtars,

            'social_login_id' => $user->social_login_id,

            'social_login_type' => $user->social_login_type,

            'first_name' => UserMeta::where('user_id', $user->id)->where('meta_key', 'first_name')->first()->meta_value ?? NULL,

            'last_name' => UserMeta::where('user_id', $user->id)->where('meta_key', 'last_name')->first()->meta_value ?? NULL,

            'gender' => UserMeta::where('user_id', $user->id)->where('meta_key', 'gender')->first()->meta_value ?? NULL,

            'website_url' => UserMeta::where('user_id', $user->id)->where('meta_key', 'website_url')->first()->meta_value ?? NULL,

            'bio' => UserMeta::where('user_id', $user->id)->where('meta_key', 'bio')->first()->meta_value ?? NULL,

            'youtube' => UserMeta::where('user_id', $user->id)->where('meta_key', 'youtube')->first()->meta_value ?? NULL,

            'facebook' => UserMeta::where('user_id', $user->id)->where('meta_key', 'facebook')->first()->meta_value ?? NULL,

            'instagram' => UserMeta::where('user_id', $user->id)->where('meta_key', 'instagram')->first()->meta_value ?? NULL,

            'twitter' => UserMeta::where('user_id', $user->id)->where('meta_key', 'twitter')->first()->meta_value ?? NULL,

            'firebase_token' => UserMeta::where('user_id', $user->id)->where('meta_key', 'firebase_token')->first()->meta_value ?? NULL,

            'referral_count' => NULL,

            'following' => NULL,

            'followers' => NULL,

            'likes' => NULL,

            'levels' => NULL,

            'total_videos' => NULL,

            'box_two' => NULL,

            'box_three' => NULL

        ];

        $userFieldsObj = new UserObj($user_details_arr);



        if (!Auth::user()->can('appuser_view')) {

                return redirect(route('admin.v1.dashboard'))->with('message', 'You don\'t have this section permission');

        }

        $acti = array(
            'active'          => "user_dash",
            'activetxt'       => "user_dash",
          );

        return view('admin.v1.appusers.view', compact('userFieldsObj','acti'));

    }



    public function block($id, $action)

    {

        if (!Auth::user()->can('appuser_block')) {

                return redirect(route('admin.v1.appuser.list'))->with('message', 'You don\'t have this section permission');

        }



        $action = ($action == 'block') ? 'inactive' : 'active';

        $userObj = User::find($id);

        $userObj->status = $action;

        $userObj->save();

        return redirect()->route('admin.v1.appuser.list');

    }



    public function verify($id, $action)

    {

        if (!Auth::user()->can('appuser_varify')) {

                return redirect(route('admin.v1.dashboard'))->with('message', 'You don\'t have this section permission');

        }

        $action = ($action == 'verify') ? 1 : 0;

        $userObj = User::find($id);

        $userObj->is_verified = $action;

        $userObj->save();

        return redirect()->route('admin.v1.appuser.list');

    }



    public function delete($id)

    {



                if (!Auth::user()->can('appuser_delete')) {

                return redirect(route('admin.v1.appuser.list'))->with('message', 'You don\'t have this section permission');

            }





        User::where('id', $id)->delete();

        return redirect()->back();

    }



    public function changePassword()

    {

        if (!Auth::user()->can('changepassword')) {

                return redirect(route('admin.v1.dashboard'))->with('message', 'You don\'t have this section permission');

        }



        return view('admin.v1.appusers.changepassword');

    }



    public function changePasswordSubmit(Request $request)

    {

        $this->validate($request, [

            'current_password'      =>  'required|current_password:web',

            'password'              =>  'required|confirmed',

            'password_confirmation' =>  'required'

        ]);



        $userObj = User::find(Auth::user()->id);

        $userObj->password = Hash::make($request->password);

        $userObj->save();

        $request->session()->flash('success', 'Your password has been change successfully.');

        return redirect()->route('admin.v1.appuser.changepassword');

    }

}

