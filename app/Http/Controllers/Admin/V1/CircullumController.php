<?php



namespace App\Http\Controllers\Admin\V1;



use App\Models\Sound;

use App\Models\Permission;

use Illuminate\Http\Request;

use App\Models\Circullum;

use App\Models\Circullum_topic;

use App\Models\Course;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;



class CircullumController extends Controller

{

    /**

     * Sound Categories section

     */

    public function listCircullum($id)

    {

        $categories = Circullum::orderByDesc('id')->where('course_id',$id)->with('circullum_topic')->first();

        $course = Course::where('id',$id)->first();

        // dd($categories->toArray());

                $acti = array(

            'active'          => "course",

            'activetxt'       => "course",

          );

        return view('admin.v1.circullum.list', compact('categories','course','acti'));

    }











    public function addCircullum($id)

    {

        

        $course = Course::where('id',$id)->first();

        $coursecir = Circullum::where('course_id',$id)->first();

            $acti = array(

            'active'          => "course",

            'activetxt'       => "course",

          );

        return view('admin.v1.circullum.add',compact('course','coursecir','acti'));

    }







    public function addCircullumSubmit(Request $request)

    {



        // $this->validate($request, [

        //     'course'      =>  'required',

        //     'name'      =>  'required',

        //     'topic'      =>  'required',

        //     'url'      =>  'required',

        // ]);



        // dd($request->all());

        $courses = Course::where('title',$request->course)->first();





        $circullum = Circullum::updateOrCreate([

            'course_id' => $courses->id],[

            'title' => $request->title

        ]);







        

            $circullum_topic = Circullum_topic::insert([

                'course_id' => $courses->id,

                'circullum_id' => $circullum->id,

                'topic' => $request->topic,

                'description' => $request->description,

                'is_complete' => $request->complete,

                'cover_time' => $request->cover_time,

                'class_url' => $request->url,

            ]);

        



        $request->session()->flash('success', 'Your circullum has been added successfully.');

        return redirect()->route('admin.v1.course.list');

    }





    public function editCircullum($id)

    {

        if (!auth()->user()->can('course_edit')){

                return redirect(route('admin.v1.dashboard'))->with('message','You don\'t have this section permission');

        }

        $categories = Circullum_topic::where('id',$id)->first();

        // dd($categories);

        // if(!$categories){

        //     return redirect()->back()->with('error','Course has no circullum.');

        // }

        // $course = Course::where('id',$id)->first();

        // dd($categories,$course);

         $acti = array(

            'active'          => "course",

            'activetxt'       => "course",

          );

        return view('admin.v1.circullum.edit',compact('categories','acti'));

    }





    public function editCircullumSubmit(Request $request,$id)

    {



        $this->validate($request, [

            'url'      =>  'required',

        ]);

// dd($id);

        







        // foreach($request->topic as $key=>$items){

            $circullum_topic = Circullum_topic::where('id',$id)->update([

                'topic' => $request->topic,

                'description' => $request->description,

                'is_complete' => $request->complete,

                'cover_time' => $request->cover_time,

                'class_url' => $request->url

            ]);

        // }





        $request->session()->flash('success', 'Your category has been added successfully.');

        return redirect()->route('admin.v1.course.list');

    }



    public function deleteCircullum($id)

    {

        

        // Circullum::where('id', $id)->delete();

        Circullum_topic::where('id', $id)->delete();

        return redirect()->back();

    }



    // /**

    //  * Sound section

    //  */

    // public function list()

    // {

    //     $permission = Permission::where('sub_admin_id',Auth()->user()->id)->first();

    //     if (Auth()->user()->role == 3) {

    //         if(!$permission->sound_view){

    //             return redirect(route('admin.v1.dashboard'))->with('message','You don\'t have this section permission');

    //         }

    //     }

    //     $sounds = Sound::orderByDesc('id')->get();



    //     return view('admin.v1.sounds.list', compact('sounds','permission'));

    // }

    // public function add()

    // {

    //     $permission = Permission::where('sub_admin_id',Auth()->user()->id)->first();

    //     if (Auth()->user()->role == 3) {

    //         if(!$permission->sound_add){

    //             return redirect(route('admin.v1.dashboard'))->with('message','You don\'t have this section permission');

    //         }

    //     }



    //     $categories = Categories::orderByDesc('id')->get();

    //     return view('admin.v1.sounds.add', compact('categories'));

    // }

    // public function addSubmit(Request $request)

    // {

    //     $this->validate($request, [

    //         'sound'     =>  'required|mimes:wav,mp3|max:2000',

    //         'category'  =>  'required|exists:sound_categories,id',

    //         'soundname' =>  'required|unique:sounds,name'

    //     ]);



    //     if ($filed = $request->hasfile('sound')) {

    //         $filed      = $request->file('sound');

    //         $named      = 'sounds' . time() . '.' . $filed->getClientOriginalExtension();

    //         Storage::disk('sounds')->put($named, file_get_contents($filed->getRealPath()));

    //         $sound = $named;

    //     } else {

    //         $sound = Null;

    //     }



    //     $SoundObj = new Sound;

    //     $SoundObj->sound = $sound;

    //     $SoundObj->category = $request->category;

    //     $SoundObj->name = $request->soundname;

    //     $SoundObj->save();



    //     $request->session()->flash('success', 'Your Sound has been added successfully.');

    //     return redirect()->route('admin.v1.sound.category-list');

    // }

    // public function delete($id)

    // {

    //     $permission = Permission::where('sub_admin_id',Auth()->user()->id)->first();

    //     if (Auth()->user()->role == 3) {

    //         if(!$permission->sound_delete){

    //             return redirect(route('admin.v1.dashboard'))->with('message','You don\'t have this section permission');

    //         }

    //     }

    //     Sound::where('id', $id)->delete();

    //     return redirect()->back();

    // }

}

