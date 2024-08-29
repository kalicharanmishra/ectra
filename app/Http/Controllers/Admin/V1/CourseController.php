<?php



namespace App\Http\Controllers\Admin\V1;



use App\Models\Course;
use App\Models\Attendence;

use App\Models\Permission;

use App\Models\CourseComment;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Auth;

use Str;
use App\Models\class_course;
use App\Models\Course_enroll;

use App\Models\Transaction;
use DB;

use Illuminate\Support\Facades\Storage;



class CourseController extends Controller

{

    public function list($id=null)

    {

        if (!Auth::user()->can('course_view')) {



                return redirect(route('admin.v1.dashboard'))->with('message','You don\'t have this section permission');

        }

        if (auth()->user()->roles->pluck('name')[0] != "super admin" && auth()->user()->roles->pluck('name')[0] != "admin") {

           

                $courses = Course::where('user_id',Auth::user()->id)->with('courseHashTags','course_owner','categorydata')->withCount('course_enroll_student')->orderByDesc('id')->get();
        

        }else{

            if($id != null){

                $courses = Course::where('user_id',$id)->with('courseHashTags','course_owner','categorydata')->withCount('course_enroll_student')->orderByDesc('id')->get();

            }else{

                $courses = Course::with('courseHashTags','course_owner','categorydata')->withCount('course_enroll_student')->orderByDesc('id')->get();

            }

            

        }
        $acti = array(
            'active'          => "course",
            'activetxt'       => "course",
          );

        return view('admin.v1.courses.list', compact('courses','acti'));

    }








    // public function courselist($id=null)
    // {
    //     if (!Auth::user()->can('course_view')) {
    //             return redirect(route('admin.v1.dashboard'))->with('message','You don\'t have this section permission');
    //     }

    //     if (auth()->user()->roles->pluck('name')[0] != "super admin" && auth()->user()->roles->pluck('name')[0] != "admin") {

    //             $courses = Course::where('user_id',Auth::user()->id)->with('courseHashTags','course_owner','categorydata')->withCount('course_enroll_student')->orderByDesc('id')->get();

    //     }else{

    //         if($id != null){
    //             $courses = Course::where('user_id',$id)->with('courseHashTags','course_owner','categorydata')->withCount('course_enroll_student')->orderByDesc('id')->get();
    //         }else{
    //             $courses = Course::with('courseHashTags','course_owner','categorydata')->withCount('course_enroll_student')->orderByDesc('id')->get();
    //         }
    //     }
    //     $acti = array(
    //         'active'          => "course",
    //         'activetxt'       => "course",
    //       );

    //     return view('admin.v1.courses.list', compact('courses','acti'));
    // }
    // public function view()

    // {

    // }



    public function add()

    {

        if (!Auth::user()->can('course_add')) {

                return redirect(route('admin.v1.course.list'))->with('message','You don\'t have this section permission');

        }


        $acti = array(
            'active'          => "course",
            'activetxt'       => "course",
          );
        return view('admin.v1.courses.add',compact('acti'));

    }

//    add submit

        public function addCourseSubmit(Request $request)
        {
           
            // dd($request->all());
           
            $this->validate($request, [

                'price_type'      =>  'required',
                // 'is_certification'      =>  'required',
                'price'      =>  'required_if:price_type,Paid',
                'title'      =>  'required',
                'category'      =>  'required',
                'short_desc'      =>  'required|max:255',
                'description'      =>  'required',
                'class_h_o'     =>  'required',
                'course_req_descrip'    =>  'required',
                'cduration'    =>  'required',
                'cdurationval'    =>  'required',
                'ctime'      =>  'required',
                'skill_level'      =>  'required',
                'attend_url'      =>  'required',
            
            ]);

           

            if ($request->hasfile('image')) {

                $filed      = $request->file('image');

                $named      = 'course/image/' . time() . '.' . $filed->getClientOriginalExtension();

                Storage::disk('public')->put($named, file_get_contents($filed->getRealPath()));

                $image = $named;

            } else {

                $image = null;

            }

            if ($request->hasfile('video')) {

                $filed      = $request->file('video');

                $named      = 'course/prev_video/' . time() . '.' . $filed->getClientOriginalExtension();

                Storage::disk('public')->put($named, file_get_contents($filed->getRealPath()));

                $video = $named;

            } else {

                $video = null;

            }

            if ($request->hasfile('video_thumbnail')) {

                $filed      = $request->file('video_thumbnail');

                $named      = 'course/video_thumbnail/' . time() . '.' . $filed->getClientOriginalExtension();

                Storage::disk('public')->put($named, file_get_contents($filed->getRealPath()));

                $video_thumbnail = $named;

            } else {

                $video_thumbnail = null;

            }

            $CourseObj = new Course();

            if(isset($request->ctime)){
                // dd($request->skill_level,$request->ctime);
                $CourseObj->timing = $request->ctime;
            }


            $CourseObj->title = $request->title;
            $CourseObj->user_id = Auth::user()->id;
            $CourseObj->image = $image;
            $CourseObj->video = $video;
            $CourseObj->video_thumbnail = $video_thumbnail;
            $CourseObj->category = $request->category;
            $CourseObj->class_held_on = $request->class_h_o;
            $CourseObj->skill_level = $request->skill_level;
            $CourseObj->price_type = $request->price_type;
            $CourseObj->short_desc = $request->short_desc;
            $CourseObj->description = $request->description;
            $CourseObj->is_certification = $request->is_certification;

            $CourseObj->slug = Str::slug($request->title);


            if(isset($request->price)){
                $CourseObj->hashtags = json_encode($request->hashtags);
            }else{
                $CourseObj->hashtags = json_encode([]);
            }

            if(isset($request->price)){
                $CourseObj->price = $request->price;
            }

            // if(isset($request->start_date)){

            //     $CourseObj->start_date = $request->start_date;

            // }

            

            if(isset($request->class_h_o)){
                $CourseObj->class_held_on = implode(" ",$request->class_h_o);
            }


            if(isset($request->course_req_descrip)){
                $CourseObj->course_requirment_description = $request->course_req_descrip;
            }


            if($request->cduration=='day'){
                // $request->cdurationval;
                $totmont=$request->cdurationval;
                $CourseObj->duration = $request->cdurationval;
                
            }
            elseif($request->cduration=='month'){
                $totmont=$request->cdurationval*30;
                $CourseObj->duration = $totmont;
             }
             elseif($request->cduration=='year'){
                $totmont=$request->cdurationval*365;
                $CourseObj->duration = $totmont."year";
             }
   
             $CourseObj->save();



            //  Start createing class according courses
                
                if($request!=""){
                        
                        $week=$totmont/7;
                        $class_days = implode(", ",$request->class_h_o);
                        $class_days_array = explode(", ", $class_days);
                        // $num_class_days = count($class_days_array);
                        // $totclass=$week * $num_class_days;
                        // $totcls=round($totclass);
                        // $noclass=intval($totclass);
                        // dd($totcls);


                        $current_day = date('l'); 
                        $nextday=date('1', strtotime('next monday'));
                        
                        $next_day_timestamp = strtotime($current_day . ' +7 day');
                        // $aday = date('l', $next_day_timestamp);
                    
                        // dd($class_days_array);
                        $a=1;
                        for($b=1; $b <= $week; $b++ ){  

                            $current_date = date('Y-m-d');
                            $afterdate=strtotime($current_date . ' +' . ($b * 7) . ' day');
                            $afdate = date('Y-m-d', $afterdate);
                            // dd($afdate);

                            foreach($class_days_array as $day){

                                    $current_day = date('l'); // gets the current day of the week in full textual representation (e.g. "Monday")
                                if ($current_day == $day) {
                                    $days_until_monday = 0; // if today is Monday, return 0 days until Monday
                                } else {
                                    $next_monday_timestamp = strtotime($day, strtotime($current_day)); // find the Unix timestamp for the next Monday from the current day
                                    $days_until_monday = ceil(($next_monday_timestamp - time()) / 86400); // calculate the number of days until the next Monday
                                }

                                // dd($totcls);

                                $next_day_timestamp = strtotime("$afdate +$days_until_monday day");
                                $afterdat=date('Y-m-d', $next_day_timestamp);

                                $class_course = new class_course();
                                
                                $class_course->course_name = 'Class'.$a++;
                                $class_course->course_id = $CourseObj->id;
                                
                                if($request!=""){
                                    $class_course->start_date = $afterdat;
                                }
                            
                                if(isset($request->attend_url)){
                                    $class_course->url = $request->attend_url;
                                }

                                if(isset($CourseObj->timing)){
                                    $class_course->time = $CourseObj->timing;
                                }
                                    
                                $class_course->save();

                            }
                           
                        }
                             
                }
    

            //  $corse=Course::where('id, $request->id')->first();
            //  dd($corse->duration); exit;

            //  $class_course = new class_course();
            //  $class_course->title = $request->title;


            // $circullum = Circullum::create([

            //     'title' => $request->title,

            //     'course_id' => $CourseObj->id

            // ]);

    

            // foreach($request->topic as $key=>$items){

            //     $circullum_topic = Circullum_topic::insert([

            //         'course_id' => $CourseObj->id,

            //         'circullum_id' => $circullum->id,

            //         'topic' => $request->topic[$key],

            //         'description' => $request->descriptioncir[$key],

            //         'is_complete' => $request->complete[$key],

            //         'cover_time' => $request->cover_time[$key],

            //     ]);

            // }



            // $request->session()->flash('success', 'Your Course has been added successfully.');



            $course = $CourseObj->id;

            $title = $request->title;



            return redirect()->route('admin.v1.course.list');

        }





        public function edit($id)

    {

        if (!auth()->user()->can('course_edit')){

                return redirect(route('admin.v1.course.list'))->with('message','You don\'t have this section permission');

        }
        //dd($id); exit;
        $course = Course::findOrFail($id);

        $acti = array(
            'active'          => "course",
            'activetxt'       => "course",
          );
        return view('admin.v1.courses.edit',compact('course','acti','id'));

    }

    public function opclas($id)

    {

        if (!auth()->user()->can('course_edit')){

                return redirect(route('admin.v1.course.list'))->with('message','You don\'t have this section permission');

        }

        $course = class_course::where('course_id', $id)->get();
        // $course = Course::where($id);
        // dd($course); exit;
        
        
        $acti = array(
            'active'          => "course",
            'activetxt'       => "course",
          );
        return view('admin.v1.courses.class.newclaslist',compact('course','acti','id'));

    }

    


    public function opedit($id)

    {

        if (!auth()->user()->can('course_edit')){

                return redirect(route('admin.v1.course.list'))->with('message','You don\'t have this section permission');

        }
        $id=$id;
        $acti = array(
            'active'          => "course",
            'activetxt'       => "course",
          );
        return view('admin.v1.courses.newedit',compact('id','acti'));

    }








    public function attendance(Request $request, $id)

    {

        // if (!auth()->user()->can('course_edit')){

        //         return redirect(route('admin.v1.course.list'))->with('message','You don\'t have this section permission');

        // }

        $categories = Attendence::orderByDesc('id')->where('class_id',$request->id)->with('class','teacher','course')->get();
      


        $id=$id;
        $acti = array(
            'active'          => "course",
            'activetxt'       => "course",
          );
        return view('admin.v1.courses.attendance',compact('categories','acti','id'));

    }



    



    public function coursedel($id)
    {

        // if (!Auth::user()->can('course_delete')) {
        //         return redirect(route('admin.v1.course.list'))->with('message','You don\'t have this section permission');
        // }

        class_course::where('id', $id)->delete();

        return redirect()->back();

    }



    public function newedit(Request $request)

    {

        // dd($request->all()); exit;
            $this->validate($request, [

               'course_nam'      =>  'required',

                'time'      =>  'required',

                'Ur_l'      =>  'required',

                'start_date'      =>  'required',

                'course_id'      =>  'required',
                
            ]);
           


            // $CourseObj = Course::find($request->id);
            $CourseObj = new class_course();
            // DB::table('users')->insert([
            
               

            // if(auth()->user()->hasRole('super admin') || auth()->user()->hasRole('admin') || auth()->user()->id == $CourseObj->user_id){



            // }else{

            //     return redirect(route('admin.v1.course.list'))->with('message','You don\'t have this section permission');

            // }
           

            $CourseObj->course_name = $request->course_nam;
            $CourseObj->course_id = $request->course_id;

            // $CourseObj->category = $request->category;

            

            if(isset($request->prcourse_nam)){
                
                $CourseObj->course_name = $request->course_nam;

            }

            if(isset($request->time)){

                $CourseObj->time = $request->time;

            }

            if(isset($request->Ur_l)){

                $CourseObj->Url = $request->Ur_l;

            }
            // echo "vxxxxvxc"; exit;

            // $CourseObj->slug = Str::slug($request->title);

            // if(isset($request->price)){

            //     $CourseObj->price = $request->price;

            // }

            if(isset($request->start_date)){

                $CourseObj->start_date = $request->start_date;

            }


            $CourseObj->save();

            $request->session()->flash('success', 'Your Course has been Updated successfully.');

            return redirect()->route('admin.v1.course.list');
        // return view('admin.v1.courses.newedit',compact('course','acti'));

    }



    public function editCourseSubmit(Request $request)

        {

            
          
           
            $this->validate($request, [

                // 'image'      =>  ' mimes:jpeg,jpg,png|max:300',

                // 'video_thumbnail'      =>  ' mimes:jpeg,jpg,png|max:300',

                // 'video'      =>  ' mimes:mp4|max:3000',

                'price_type'      =>  'required',

                // 'is_certification'      =>  'required',

                'price'      =>  'required_if:price_type,Paid',

                'title'      =>  'required',

                // 'start_date'      =>  'required|date|after:today',

                'category'      =>  'required',

                'short_desc'      =>  'required|max:255',

                'description'      =>  'required',

                'class_h_o'     =>      'required',
                
                'course_req_descrip'   =>  'required',

                'cduration'   =>  'required',

                'cdurationval'   =>  'required',
                'timing'   =>  'required',

            ],[

                // 'video.max'=>'The intro video must not be greater than 3mb.'

            ]);

             



            $CourseObj = Course::find($request->id);

            
            if(auth()->user()->hasRole('super admin') || auth()->user()->hasRole('admin') || auth()->user()->id == $CourseObj->user_id){



            }else{

                return redirect(route('admin.v1.course.list'))->with('message','You don\'t have this section permission');

            }

            if ($request->hasfile('image')) {

                $filed      = $request->file('image');

                $named      = 'course/image/' . time() . '.' . $filed->getClientOriginalExtension();

                Storage::disk('public')->put($named, file_get_contents($filed->getRealPath()));

                $CourseObj->image = $named;

            } 

            if ($request->hasfile('video')) {

                $filed      = $request->file('video');

                $named      = 'course/prev_video/' . time() . '.' . $filed->getClientOriginalExtension();

                Storage::disk('public')->put($named, file_get_contents($filed->getRealPath()));

                $CourseObj->video = $named;

            } 

            if ($request->hasfile('video_thumbnail')) {

                $filed      = $request->file('video_thumbnail');

                $named      = 'course/video_thumbnail/' . time() . '.' . $filed->getClientOriginalExtension();

                Storage::disk('public')->put($named, file_get_contents($filed->getRealPath()));

                $CourseObj->video_thumbnail = $named;

            }



            $CourseObj->title = $request->title;

            $CourseObj->category = $request->category;

            if(isset($request->skill_level)){

                $CourseObj->skill_level = $request->skill_level;

            }

            if(isset($request->price_type)){

                $CourseObj->price_type = $request->price_type;

            }

            if(isset($request->short_desc)){

                $CourseObj->short_desc = $request->short_desc;

            }

            if(isset($request->description)){

                $CourseObj->description = $request->description;

            }

            if(isset($request->is_certification)){

                $CourseObj->is_certification = $request->is_certification;

            }

            if(isset($request->hashtags)){

                $CourseObj->hashtags = json_encode($request->hashtags);

            }
            if(isset($request->timing)){

                $CourseObj->timing = $request->timing;

            }

            

            if(isset($request->description)){

                $CourseObj->description = $request->description;

            }

           

            $CourseObj->slug = Str::slug($request->title);

            if(isset($request->price)){

                $CourseObj->price = $request->price;

            }

            // if(isset($request->start_date)){

            //     $CourseObj->start_date = $request->start_date;

            // }


            if(isset($request->class_h_o)){
     
                $CourseObj->class_held_on = implode(", ",$request->class_h_o);

            }


            if(isset($request->course_req_descrip)){
                // dd($request->course_req_descrip);
                $CourseObj->course_requirment_description = $request->course_req_descrip;

            }


            if($request->cduration=='day'){
                // $request->cdurationval;
                $CourseObj->duration = $request->cdurationval;

            }
            elseif($request->cduration=='month'){
                $totmont=$request->cdurationval*30;
                $CourseObj->duration = $totmont;
             }
             elseif($request->cduration=='year'){
                $totmont=$request->cdurationval*365;
                $CourseObj->duration = $totmont."year";
             }


            
            // dd($request->cduration);

            

            $CourseObj->save();

            $request->session()->flash('success', 'Your Course has been Updated successfully.');

            return redirect()->route('admin.v1.course.list');

        }

    public function delete($id)

    {

        if (!Auth::user()->can('course_delete')) {

                return redirect(route('admin.v1.course.list'))->with('message','You don\'t have this section permission');

        }



        Course::where('id', $id)->delete();
        class_course::where('course_id', $id)->delete();
        Transaction::where('course_id', $id)->delete();
        Course_enroll::where('course_id', $id)->delete();
                
        return redirect()->back();

    }



    public function block($id, $action)

    {

        if (!Auth::user()->can('course_block')) {

                return redirect(route('admin.v1.course.list'))->with('message','You don\'t have this section permission');

        }



        $action = ($action == 'block') ? 0 : 1;

        $courseObj = course::find($id);

        $courseObj->is_enabled = $action;

        $courseObj->save();

        return redirect()->back();

    }



    
    public function trial_pay($id)
    {
        $trial_payy = DB::table('trial_class')->where('course_id', $id)->get();
        $firstTrialPay = $trial_payy->first();
    
        $users = [];
        if ($firstTrialPay) {
            $users = DB::table('users')->where('id', $firstTrialPay->user_id)->get();
        }
    
        $acti = [
            'active' => "trial_pay",
            'activetxt' => "trial_pay",
        ];
    
        return view('admin.v1.courses.trial_pay_list', compact('trial_payy', 'users', 'acti'));
    }
    
    



    public function comments($id)

    {

        if (!Auth::user()->can('comments_view')) {

                return redirect(route('admin.v1.course.list'))->with('message','You don\'t have this section permission');

        }



        $comments = CourseComment::where('course_id', $id)->orderByDesc('id')->get();

        return view('admin.v1.courses.comments', compact('comments'));

    }



    public function blockComment($id, $action)

    {

        if (!Auth::user()->can('comments_block')) {

                return redirect(route('admin.v1.course.list'))->with('message','You don\'t have this section permission');

        }



        $action = ($action == 'block') ? 0 : 1;

        $CourseComment = CourseComment::find($id);

        $CourseComment->is_approved = $action;

        $CourseComment->save();

        return redirect()->back();

    }

    public function deleteComment($id)

    {

        if (!Auth::user()->can('comments_delete')) {

                return redirect(route('admin.v1.course.list'))->with('message','You don\'t have this section permission');

        }



        CourseComment::where('id', $id)->delete();

        return redirect()->back();

    }

}

