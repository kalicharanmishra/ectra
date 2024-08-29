<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use App\Models\UserBank;

use Illuminate\Support\Facades\Auth;

use DB;

use Illuminate\Support\Facades\URL;

class UserController extends Controller

{

        public function login(Request $request){
            // dd($request->all());
            $auth = false;
            $credentials = ['phone' => '', 'password'=>''];
            if(filter_var($request->email, FILTER_VALIDATE_EMAIL) !== false)
            {
                $credentials = $request->only('email', 'password');
            }elseif(preg_match('/^[0-9]{10}+$/', $request->email)){

                $credentials = ['phone' => $request->email, 'password'=>$request->password];
            }


                if (Auth::attempt($credentials, $request->has('remember'))) {

                    $auth = true; // Success
                    $userRole = auth()->user()->getRoleNames();
                    if(!auth()->user()->hasRole([$request->type]))
                    {
                        auth()->logout();
                        return response()->json(['error' => true]);
                    }

                }
            

                if ($request->ajax()) {

                    return response()->json([

                        'auth' => $auth,

                        'intended' => URL::previous()

                    ]);

                } else {

                    return redirect()->intended(URL::route('dashboard'));

                }

                return redirect(URL::route('login_page'));

        }
        
        /*public function forgotPassword(Request $request)
        {dd($request->all());
             $auth = false;
            if(filter_var($request->email, FILTER_VALIDATE_EMAIL) !== false)
            {
                $credentials = User::where(['email' => $request->email, 'user_type' => $request->user_type])->first();
            }elseif(preg_match('/^[0-9]{10}+$/', $request->email)){

                $credentials = User::where(['phone' => $request->email, 'user_type' => $request->user_type])->first();
            }
        }*/

        public function signup(Request $request){

                $auth = false;

                $credentials = $request->only('email', 'password');

            

                if (Auth::attempt($credentials, $request->has('remember'))) {

                    $auth = true; // Success

                }

            

                if ($request->ajax()) {

                    return response()->json([

                        'auth' => $auth,

                        'intended' => URL::previous()

                    ]);

                } else {

                    return redirect()->intended(URL::route('dashboard'));

                }

                return redirect(URL::route('login_page'));

        }

        public function success()
        {
            return view('admin.v1.success');
        }

        public function customer()

        {

                $list = User::where('role',1)->orderBy('id','desc')->get();

                $active_menu = "UserManagement";

                $active_submenu = "CustomerList";

                return view('admin.User.UserList',compact('list','active_menu','active_submenu'));

        }



        public function vendor()

        {

                $list = User::where('role',2)->orderBy('id','desc')->get();

                $active_menu = "UserManagement";

                $active_submenu = "VendorList";

                return view('admin.User.vendorList',compact('list','active_menu','active_submenu'));

        }



        public function changeStatus(Request $request, $status,$id)

        {

                //echo $status; die;

                $user = User::find($id);        

                $user->status = $status;

                $user->save();

                return redirect()->back();

        }



        public function delete($id)

        {

                $deletedata = User::where('id',$id)->delete();

                return redirect()->back();

        }



        public function view($id)

        {

                $dataview = User::find($id);

                $UserBank = UserBank::where('user_id',$id)->first();

                $active_menu = "UserManagement";

                $active_submenu = "VendorList";

                return view('admin.User.UserView', compact('dataview','UserBank','active_menu','active_submenu'));

        }

}