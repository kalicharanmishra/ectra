<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Teacher_profile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->all();
        if(isset($data['user_type']) && $data['user_type'] == 'user')
        {
            $students = User::where('phone', $data['phone'])->whereHas('roles', function($q){
                $q->where('name', 'user');
            })->first();
            if(!empty($students))
            {
                $validator = Validator::make($data, [
                    'phone' => ['required','unique:users,phone','regex:/^([0-9\s\-\+\(\)]*)$/','min:10']
                 ]);
                if($validator->fails())
                {
                    return redirect()->back()->withInput()->withErrors($validator->messages());
                }
            }
        }
        
        if(isset($data['user_type']) && $data['user_type'] == 'tutor')
        {
            $students = User::where('phone', $data['phone'])->whereHas('roles', function($q){
                $q->where('name', 'tutor');
            })->first();
            if(!empty($students))
            {
                $validator = Validator::make($data, [
                    'phone' => ['required','unique:users,phone','regex:/^([0-9\s\-\+\(\)]*)$/','min:10']
                 ]);
                if($validator->fails())
                {
                    return redirect()->back()->withInput()->withErrors($validator->messages());
                }
            }
        }
        if(isset($data['email']))
        {
            $emailValidation=['string', 'email', 'max:255'];
        } else {
            $emailValidation = '';
        }
        $validator = Validator::make($data, [

            'name' => ['required', 'string', 'max:255'],

            'email' => $emailValidation,

            'password' => ['required', 'string', 'min:8', 'confirmed', 'required_with:password_confirmed'],
            'phone' => ['required','regex:/^([0-9\s\-\+\(\)]*)$/','min:10'],
            'gender'=> ['required'],
            'address' => ['required'],

        ],[
            'name.required' => 'This is a mandatory field, please fill this up.',
            'password.required' => 'This is a mandatory field, please fill this up.',
            'phone.required' => 'This is a mandatory field, please fill this up.',
            'gender.required' => 'This is a mandatory field, please fill this up.',
            'address.required' => 'This is a mandatory field, please fill this up.'
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withInput()->withErrors($validator->messages());
        }

        $user = User::create(['name' => $data['name'],
                'dob' => $data['dob'],
                'email' => @$data['email'],
                'phone' => $data['phone'],
                'gender' => $data['gender'],
                'location' => $data['address'],
                'password' => Hash::make($data['password'])
            ]);

        if($data['user_type'] == 'user')
        {
            $user->assignRole('user');
        } elseif($data['user_type'] == 'teacher') {
            $user->assignRole('tutor');
        }
        if($user)
        {
            return redirect()->route('success')->with(['success' => true, 'messgae' => 'Registration successfully', 'data' => $data]);
        } else {
            return redirect()->route('success')->with('failed', 'Registration not  successfully');
        }
    }


    public function tutorProfession()
    {
        return view('admin.v1.profession');
    }

    public function tutorProfessionStore(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'user_id' => ['required'],
            'degree' => ['required'],
            'institute' => ['required'],
            'passing_out' => ['required'],
            'since' => ['required','numeric', 'gte:passing_out'],
            'experience'=> ['required'],
            'introduction' => ['required'],
            'demo_video' => 'required|mimes:mp4,mov,ogg,qt,webm|max:30000',
            'profile' => 'required|mimes:jpeg,jpg,png,gif|max:20000',

        ],
        [
            'user_id.required' => 'This is a mandatory field, please fill this up.',
            'degree.required' => 'This is a mandatory field, please fill this up.',
            'institute.required' => 'This is a mandatory field, please fill this up.',
            'passing_out.required' => 'This is a mandatory field, please fill this up.',
            'since.required' => 'This is a mandatory field, please fill this up.',
            'experience.required' => 'This is a mandatory field, please fill this up.',
            'introduction.required' => 'This is a mandatory field, please fill this up.',
            'demo_video.required' => 'This is a mandatory field, please fill this up.',
            'profile.required' => 'This is a mandatory field, please fill this up.'
        ]);
        if($validator->fails())
        {
            return redirect()->back()->withInput()->withErrors($validator->messages());
        }   

        if ($request->hasfile('avtars')) {
            $filed      = $request->file('avtars');
            $named      = 'user/teacher/' . time() . '.' . $filed->getClientOriginalExtension();
            Storage::disk('public')->put($named, file_get_contents($filed->getRealPath()));
            $icon_name = $named;
        } else {
            $icon_name = null;
        }
        if ($request->hasfile('demo_video')) {
            $filed      = $request->file('demo_video');
            $named      = 'user/teacher/intro_video/' . time() . '.' . $filed->getClientOriginalExtension();
            Storage::disk('public')->put($named, file_get_contents($filed->getRealPath()));
            $intro_video = $named;
        } else {
            $intro_video = null;
        }

        $teacherData = new Teacher_profile();
        $teacherData->user_id = $data['user_id'];
        $teacherData->degree_obtained = $data['degree'];
        $teacherData->degree_from = $data['institute'];
        $teacherData->passing_out = $data['passing_out'];
        $teacherData->since = $data['since'];
        $teacherData->experence = $data['experience'];
        $teacherData->tag = @$data['expertise'];
        $teacherData->intro_text = $data['introduction'];
        $teacherData->intro_video = $intro_video;
        $teacherData->admin_commission = 1;
        $teacherData->save();
        $user = User::where('id', $data['user_id'])->first();

        if($user && !empty($user))
        {
            $user->avtars = $icon_name;
            $user->save();
        }

        return redirect()->route('admin.v1.course.add')->with('success', 'Profession added successfully.');
    }
}
