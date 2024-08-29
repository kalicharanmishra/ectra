<?php

namespace App\Http\Controllers\Admin\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Teacher_profile;
use App\Models\Course;
use App\Models\Attendence;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Auth;



use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function listid($id)
    {
        $users = User::where('id',$id)->with('user_activity_counters')
        ->whereHas("roles", function($q){ $q->where("id", 3); })
        ->first();
        $course = Course::where('user_id',$id)->get();
        $atten = Attendence::where('user_id',$id)->with('course')->with('usered')->with('circullum_topic')->get();

        $trnx = Transaction::where('subscriber_id',$id)->with('enroll')->with('usered')->with('course')->with('teacher')->with('usered')->get();
        $acti = array(
            'active'          => "stud_dash",
            'activetxt'       => "stud_dash",
        );

        return view('admin.v1.user.show', compact('users','course','atten','trnx','acti'));
    }

     // add submit

    // edit form

    public function edit(Request $request, $id)

    {
        $user = User::findOrFail($id);
        $acti = array(
            'active'          => "teach_dash",
            'activetxt'       => "teach_dash",
          );
        return view('admin.v1.user.edit', compact('user','acti'));

    } 

    public function editSubmit(Request $request, $id)

    {
        if(!auth()->user()->hasRole(['user']))
        {
            return redirect(route('admin.v1.appuser.listid', $id))->with('message', 'You don\'t have this sectionss permission');
        }

        $user = User::findOrFail($id);

        $this->validate($request, [

            'avtars'      =>  'mimes:jpeg,jpg,png,gif|max:300',

            'intro_video'      =>  'mimes:mp4|max:3072',

            'email'      =>  'required|email:rfc,dns|unique:users,email,'.$id,

            // 'area'  =>  'required',

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

        // $tutor_profileObj = Teacher_profile::whereUser_id($user->id)->first();

        






        

        // if(isset($request->area)){

        //     $tutor_profileObj->currency = $request->area;
    
        // }

        /*if(isset($request->profile_name)){

        $tutor_profileObj->profile_name = $request->profile_name;

        }

        if(isset($request->city)){

        $tutor_profileObj->city = $request->city;

        }

        if(isset($request->country)){

        $tutor_profileObj->country = $request->country;

        }*/



        



        /*if(isset($request->passing_out)){

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

        }*/





        /*if ($request->hasfile('intro_video')) {

            $filed      = $request->file('intro_video');

            $named      = 'user/teacher/intro_video/' . time() . '.' . $filed->getClientOriginalExtension();

            Storage::disk('public')->put($named, file_get_contents($filed->getRealPath()));

            $tutor_profileObj->intro_video = $named;

        }

        $tutor_profileObj->save();*/

        /*if ($request->filled('tutor-password')) {



            $tutorObj = User::Where('id', $user->id)->update(

                [

                    'password' => Hash::make($request->get('tutor-password')),

                ]

            );

        }*/

        if($tutorObj){

            $request->session()->flash('success', 'Your Student has been updated successfully.');

            return redirect()->route('admin.v1.appuser.listid', $id);

        }

    }
}
