<?php



namespace App\Http\Controllers\Admin\V1;



use App\Http\Controllers\Controller;

use App\Models\Permission;

use App\Models\User;

use App\Models\Transaction;

use App\Models\Teacher_profile;

use App\Models\Course;

use App\Models\Attendence;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;

use Auth;



use Illuminate\Support\Facades\Storage;



class TutorController extends Controller

{

    //list

    public function list()

    {

        if (!Auth::user()->can('tutor_view')) {

            return redirect(route('admin.v1.dashboard'))->with('message', 'You don\'t have this section permission');

        }

        $users = User::with('user_activity_counters','courses')

        ->whereHas("roles", function($q){ $q->where("id", 4); })

        ->get();



        $acti = array(
            'active'          => "teach_dash",
            'activetxt'       => "teach_dash",
          );

        return view('admin.v1.tutor.list', compact('users','acti'));

    }



    public function listid($id)

    {

        

        $users = User::where('id',$id)->with('user_activity_counters')

        ->whereHas("roles", function($q){ $q->where("id", 4); })

        ->first();

        $course = Course::where('user_id',$id)->get();



        $atten = Attendence::where('teacher_id',$id)->with('course')->with('usered')->with('circullum_topic')->get();

        $trnx = Transaction::where('teacher_id',$id)->with('enroll')->with('usered')->with('course')->with('teacher')->with('teacher_profile')->get();



       
        $acti = array(
            'active'          => "teach_dash",
            'activetxt'       => "teach_dash",
        );


        return view('admin.v1.tutor.listid', compact('users','course','atten','trnx','acti'));

    }



    // add view

    public function add()

    {

        if (!Auth::user()->can('tutor_add')) {

                return redirect(route('admin.v1.dashboard'))->with('message', 'You don\'t have this section permission');

        }


        $acti = array(
            'active'          => "teach_dash",
            'activetxt'       => "teach_dash",
          );


        return view('admin.v1.tutor.add',compact('acti'));

    }



    // add submit

    public function addSubmit(Request $request)

    {



        $this->validate($request, [

            'avtars'      =>  'mimes:jpeg,jpg,png,gif|max:300',

            'intro_video'      =>  'mimes:mp4|max:3072',

            'email'      =>  'required|email:rfc,dns|unique:users',

            'name'      =>  'required',

            'password'      =>  'required',

            'phone'      =>  'required',

        ],[

            'intro_video.max'=>'The intro video must not be greater than 3mb.'

        ]);

        // dd($request->all());

        if ($request->hasfile('avtars')) {

            $filed      = $request->file('avtars');

            $named      = 'user/teacher/' . time() . '.' . $filed->getClientOriginalExtension();

            Storage::disk('public')->put($named, file_get_contents($filed->getRealPath()));

            $icon_name = $named;

        } else {

            $icon_name = null;

        }

        if ($request->hasfile('intro_video')) {

            $filed      = $request->file('intro_video');

            $named      = 'user/teacher/intro_video/' . time() . '.' . $filed->getClientOriginalExtension();

            Storage::disk('public')->put($named, file_get_contents($filed->getRealPath()));

            $intro_video = $named;

        } else {

            $intro_video = null;

        }



        $tutorObj = User::create(

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

        if(!isset($request->tag)){

            $request['tag'] = [];

        }

        // dd($tutorObj->id);

        Teacher_profile::create(

            [

                'user_id' => $tutorObj->id,

                // 'profile_name' => $request->profile_name,

                'experence' => $request->experence,

                'intro_text' => $request->intro_text,

                'tag' => json_encode($request->tag),

                'intro_video' => $intro_video,

                'admin_commission' => $request->admin_commission

            ]

        );

        $tutorObj->assignRole('tutor');

       

        $request->session()->flash('success', 'Your Tutor has been added successfully.');

        return redirect()->route('admin.v1.tutor.list');

    }



    // edit form

    public function edit(Request $request, $id)

    {

        



        $user = User::findOrFail($id);
        $acti = array(
            'active'          => "teach_dash",
            'activetxt'       => "teach_dash",
          );
        return view('admin.v1.tutor.edit', compact('user','acti'));

    }



    // add submit

    public function editSubmit(Request $request, $id)

    {

        $user = User::findOrFail($id);

        $this->validate($request, [

            'avtars'      =>  'mimes:jpeg,jpg,png,gif|max:300',

            'intro_video'      =>  'mimes:mp4|max:3072',

            'email'      =>  'required|email:rfc,dns|unique:users,email,'.$id,

            // 'area'  =>  'required',

        ],[

            'intro_video.max'=>'The intro video must not be greater than 3mb.'

        ]);

        

         

        $tutorObj = User::find($user->id);

        if(isset($request->email)){

            $tutorObj->email = $request->email;

        }

        if(isset($request->name)){

            $tutorObj->name = $request->name;

        }

        // if(isset($request->username)){

        //     $tutorObj->username = $request->username;

        // }

        if(isset($request->dob)){

            $tutorObj->dob = $request->dob;

        }

        if(isset($request->gender)){

            $tutorObj->gender = $request->gender;

        }

        if(isset($request->phone)){

            $tutorObj->phone = $request->phone;

        }

        if(isset($request->location)){

            $tutorObj->location = $request->location;

        }

        if ($request->hasfile('avtars')) {

            $filed      = $request->file('avtars');

            $named      = 'user/teacher/' . time() . '.' . $filed->getClientOriginalExtension();

            Storage::disk('public')->put($named, file_get_contents($filed->getRealPath()));

            $tutorObj->avtars = $named;

        } 

        $tutorObj->save();

        $tutor_profileObj = Teacher_profile::whereUser_id($user->id)->first();

        






        

        // if(isset($request->area)){

        //     $tutor_profileObj->currency = $request->area;
    
        // }

        if(isset($request->profile_name)){

        $tutor_profileObj->profile_name = $request->profile_name;

        }

        if(isset($request->city)){

        $tutor_profileObj->city = $request->city;

        }

        if(isset($request->country)){

        $tutor_profileObj->country = $request->country;

        }



        



        if(isset($request->passing_out)){

        $tutor_profileObj->passing_out = $request->passing_out;

        }

        if(isset($request->degree_obtained)){

        $tutor_profileObj->degree_obtained = $request->degree_obtained;

        }

        if(isset($request->degree_from)){

        $tutor_profileObj->degree_from = $request->degree_from;

        }



        if(isset($request->experence)){

        $tutor_profileObj->experence = $request->experence;

        }

        if(isset($request->intro_text)){

        $tutor_profileObj->intro_text = $request->intro_text;

        }

        if(isset($request->tag)){

        $tutor_profileObj->tag = json_encode($request->tag);

        }





        if ($request->hasfile('intro_video')) {

            $filed      = $request->file('intro_video');

            $named      = 'user/teacher/intro_video/' . time() . '.' . $filed->getClientOriginalExtension();

            Storage::disk('public')->put($named, file_get_contents($filed->getRealPath()));

            $tutor_profileObj->intro_video = $named;

        }

        $tutor_profileObj->save();

        if ($request->filled('tutor-password')) {



            $tutorObj = User::Where('id', $user->id)->update(

                [

                    'password' => Hash::make($request->get('tutor-password')),

                ]

            );

        }

        if (Auth::user()->can('course_add')) {

            return redirect('/admin/v1/tutor/list/'.$tutor_profileObj->user_id);

        }else{

            $request->session()->flash('success', 'Your Tutor has been updated successfully.');

            return redirect()->route('admin.v1.tutor.list');

        }

    }



    // block

    public function block($id, $action)

    {

        if (!Auth::user()->can('tutor_block')) {

                return redirect(route('admin.v1.tutor.list'))->with('message', 'You don\'t have this section permission');

        }



        $action = ($action == 'block') ? 'inactive' : 'active';

        $userObj = User::find($id);

        $userObj->status = $action;

        $userObj->save();

        return redirect()->route('admin.v1.tutor.list');

    }



    // delete

    public function delete($id)

    {



                if (!Auth::user()->can('tutor_delete')) {

                return redirect(route('admin.v1.tutor.list'))->with('message', 'You don\'t have this section permission');

            }



        $user = User::findOrFail($id);

        $user->delete();



        return redirect()->back();

    }



    // access form

    public function access(Request $request, $id)

    {



            if (!Auth::user()->can('tutor_access')) {

                return redirect(route('admin.v1.tutor.list'))->with('message', 'You don\'t have this section permission');

            }



        $user = User::findOrFail($id);

        $permission = Permission::Where('sub_admin_id', $user->id)->first();

        if (empty($permission)) {

            $tutorObj = Permission::create([

                'sub_admin_id' => $id,

            ]);

        }

        $permission = Permission::Where('sub_admin_id', $user->id)->first();

        return view('admin.v1.tutor.access');

    }



    // access submit

    public function accessSubmit(Request $request, $id)

    {

        $user = User::findOrFail($id);

        $permission = Permission::Where('sub_admin_id', $user->id)->first();

        $tutorObj = Permission::Where('id', $permission->id)

            ->update([

                'dashboard_user'=>$request->filled('dashboard_user'),

                'dashboard_video'=>$request->filled('dashboard_video'),

                'dashboard_reward'=>$request->filled('dashboard_reward'),



                'appuser_view' => $request->filled('appuser_view'),

                'appuser_block' => $request->filled('appuser_block'),

                'appuser_delete' => $request->filled('appuser_delete'),

                'appuser_varify' => $request->filled('appuser_varify'),



                'tutor_view' => $request->filled('tutor_view'),

                'tutor_add' => $request->filled('tutor_add'),

                'tutor_edit' => $request->filled('tutor_edit'),

                'tutor_delete' => $request->filled('tutor_delete'),

                'tutor_block' => $request->filled('tutor_block'),

                'tutor_access' => $request->filled('tutor_access'),



                'video_view' => $request->filled('video_view'),

                'video_delete' => $request->filled('video_delete'),

                'video_block' => $request->filled('video_block'),



                'hashtag_view' => $request->filled('hashtag_view'),



                'comments_view' => $request->filled('comments_view'),

                'comments_block' => $request->filled('comments_block'),

                'comments_delete' => $request->filled('comments_delete'),



                'sound_view' => $request->filled('sound_view'),

                'sound_delete' => $request->filled('sound_delete'),



                'activity_view' => $request->filled('activity_view'),

                'activitylevels_view' => $request->filled('activitylevels_view'),

                'activitylevels_add' => $request->filled('activitylevels_add'),

                'activitylevels_edit' => $request->filled('activitylevels_edit'),



                'reward_view' => $request->filled('reward_view'),

                'reward_add' => $request->filled('reward_add'),

                'reward_edit' => $request->filled('reward_add'),



                'banner_view' => $request->filled('banner_view'),

                'banner_add' => $request->filled('banner_add'),

                'banner_delete' => $request->filled('banner_delete'),



                'currency_view' => $request->filled('currency_view'),

                'currency_add' => $request->filled('currency_add'),

                'currency_delete' => $request->filled('currency_delete'),



                'network_view' => $request->filled('network_view'),

                'network_add' => $request->filled('network_add'),

                'network_edit' => $request->filled('network_edit'),



                'cms_view' => $request->filled('cms_view'),

                'cms_edit' => $request->filled('cms_edit'),

                'cms_delete' => $request->filled('cms_delete'),



                'set_notification' => $request->filled('set_notification'),



                'sitesetting_view' => $request->filled('sitesetting_view'),

                'sitesetting_edit' => $request->filled('sitesetting_edit'),

                'changepassword' => $request->filled('changepassword'),



                'withdrawal_view' => $request->filled('withdrawal_view'),

                'withdrawal_edit' => $request->filled('withdrawal_edit'),

            ]);

        $request->session()->flash('success', 'Sub Admin Set Permission Successfully.');

        return redirect()->route('admin.v1.tutor.access', ['id' => $user->id]);

    }

}

