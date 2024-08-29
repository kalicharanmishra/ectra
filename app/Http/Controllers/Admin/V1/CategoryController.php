<?php

namespace App\Http\Controllers\Admin\V1;



use App\Models\Sound;

use App\Models\Permission;

use Illuminate\Http\Request;

use App\Models\Categories;

use App\Models\Attendence;

use App\Models\Transaction;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;



class CategoryController extends Controller

{

    /**

     * Sound Categories section

     */

    public function listCategories(Request $request)

    {

        if (!auth()->user()->can('category_view')){

                return redirect(route('admin.v1.dashboard'))->with('message','You don\'t have this section permission');

        }



        if($request->id != ''){

        $categories = Categories::where('id',$request->id)->get();

        }else{

            $categories = Categories::orderByDesc('id')->get();

        }

// dd($categories);
$acti = array(
    'active'          => "course_clafi",
    'activetxt'       => "course_clafi",
  );

        return view('admin.v1.category.list', compact('categories','acti'));

    }



    public function listAttendance(Request $request,$teacher_id=null)

    {

        if (!auth()->user()->can('course_view')){

                return redirect(route('admin.v1.dashboard'))->with('message','You don\'t have this section permission');

        }

        // dd($request->teacher_id);
        if($request->teacher_id){
            
            $categories = Attendence::orderByDesc('id')->where('course_id',$request->teacher_id)->with('class','teacher','course')->get();
       
        }else if($teacher_id != null){

            $categories = Attendence::orderByDesc('id')->where('teacher_id',$teacher_id)->with('class','teacher','course')->get();

        }else{

            $categories = Attendence::orderByDesc('id')->with('class','teacher','course')->get();

        }


        $acti = array(
            'active'          => "attend",
            'activetxt'       => "attend",
          );

        return view('admin.v1.attendance.list', compact('categories','acti'));



    }

    public function listtransac($teacher_id=null)

    { 

        if (!auth()->user()->can('course_view')){

                return redirect(route('admin.v1.dashboard'))->with('message','You don\'t have this section permission');

        }

        if($teacher_id != null){

            $trnx = Transaction::where('teacher_id',$teacher_id)->orderByDesc('id')->with('enroll')->with('usered')->with('course')->with('teacher')->with('teacher_profile')->get();

           

        }else{

            $trnx = Transaction::orderByDesc('id')->with('enroll')->with('usered')->with('course')->with('teacher')->with('teacher_profile')->get();

        }

        
        $acti = array(
            'active'          => "transac",
            'activetxt'       => "transac",
          );

        return view('admin.v1.attendance.listtransaction', compact('trnx','acti'));



    }






    
    public function studentlist($teacher_id=null)
    {

        if (!auth()->user()->can('course_view')){
                return redirect(route('admin.v1.dashboard'))->with('message','You don\'t have this section permission');
        }

        if($teacher_id != null){
            $trnx = Transaction::where('teacher_id',$teacher_id)->orderByDesc('id')->with('enroll')->with('usered')->with('course')->with('teacher')->with('teacher_profile')->get();

        }else{
            $trnx = Transaction::orderByDesc('id')->with('enroll')->with('usered')->with('course')->with('teacher')->with('teacher_profile')->get();
        }

        $teacher_id= $teacher_id;
        $acti = array(
            'active'          => "paymentdet",
            'activetxt'       => "paymentdet",
          );

        return view('admin.v1.paymentdetail.student', compact('trnx','acti','teacher_id'));
    }




    public function courselist($teacher_id=null)
    {

        if (!auth()->user()->can('course_view')){
                return redirect(route('admin.v1.dashboard'))->with('message','You don\'t have this section permission');
        }

        if($teacher_id != null){
            $trnx = Transaction::where('teacher_id',$teacher_id)->orderByDesc('id')->with('enroll')->with('usered')->with('course')->with('teacher')->with('teacher_profile')->get();

        }else{
            $trnx = Transaction::orderByDesc('id')->with('enroll')->with('usered')->with('course')->with('teacher')->with('teacher_profile')->get();
        }

        $teacher_id=$teacher_id;
        
        $acti = array(
            'active'          => "paymentdet",
            'activetxt'       => "paymentdet",
          );

        return view('admin.v1.paymentdetail.course', compact('trnx','acti','teacher_id'));
    }


    

    public function addCategory()

    {

        if (!auth()->user()->can('categories_add')){

                return redirect(route('admin.v1.dashboard'))->with('message','You don\'t have this section permission');

        }
        $acti = array(
            'active'          => "course_clafi",
            'activetxt'       => "course_clafi",
          );
        return view('admin.v1.category.add',compact('acti'));

    }

    public function addCategorySubmit(Request $request)

    {



        $this->validate($request, [

            'icon'      =>  'required|mimes:jpeg,jpg,png,gif,svg,webp|required|max:1200',

            'category-name'      =>  'required|unique:categories,name',

            'parent'      =>  'required_if:isparent,on',

        ]);



        if ($request->hasfile('icon')) {

            $filed      = $request->file('icon');

            $named      = 'icon/icon' . time() . '.' . $filed->getClientOriginalExtension();

            Storage::disk('public')->put($named, file_get_contents($filed->getRealPath()));

            $icon_name = $named;

        } else {

            $icon_name = null;

        }

       



        $CategoriesObj = new Categories;

        $CategoriesObj->name = $request->{'category-name'};

        $CategoriesObj->icon = $icon_name;

        $CategoriesObj->short_description = $request->{'description'};

        if($request->isparent != 'null'){

            $CategoriesObj->parent = $request->category;

        }else{
            $CategoriesObj->parent = $request->isparent;
        }

        /*if($request->category != 'null')
        {
            $CategoriesObj->parent = $request->category;
        } else {
            $CategoriesObj->parent = $request->isparent;
        }*/



        $CategoriesObj->save();



        $request->session()->flash('success', 'Your category has been added successfully.');

        return redirect()->route('admin.v1.category.list');

    }

    public function editCategory($id)

    {

        if (!auth()->user()->can('categories_edit')){

                return redirect(route('admin.v1.dashboard'))->with('message','You don\'t have this section permission');

        }

        $categories = Categories::findOrFail($id);
        $acti = array(
            'active'          => "course_clafi",
            'activetxt'       => "course_clafi",
          );
        return view('admin.v1.category.edit',compact('categories','acti'));

    }

    public function editCategorySubmit(Request $request)

    {



        $this->validate($request, [

            'icon'      =>  'mimes:jpeg,jpg,png,gif,svg|max:1200',

            'name'      =>  'required',

            'parent'      =>  'required_if:isparent,on',

        ]);



        



        $CategoriesObj = Categories::find($request->id);

        if ($request->hasfile('icon')) {

            $filed      = $request->file('icon');

            $named      = 'icon/icon' . time() . '.' . $filed->getClientOriginalExtension();

            Storage::disk('public')->put($named, file_get_contents($filed->getRealPath()));

            $CategoriesObj->icon = $named;

        }

        $CategoriesObj->name = $request->name;

        $CategoriesObj->short_description = $request->short_description;

        if(isset($request->isparent)){

            $CategoriesObj->parent = $request->parent;

        }



        $CategoriesObj->save();


        $request->session()->flash('success', 'Your category has been added successfully.');

        return redirect()->route('admin.v1.category.list');

    }

    public function deleteCategory($id)

    {

        if (!auth()->user()->can('categories_delete')){

                return redirect(route('admin.v1.dashboard'))->with('message','You don\'t have this section permission');

        }

        Categories::where('id', $id)->delete();

        return redirect()->back();

    }



    /**

     * Sound section

     */

    public function list()

    {

        $permission = Permission::where('sub_admin_id',Auth()->user()->id)->first();

        if (Auth()->user()->role == 3) {

            if(!$permission->sound_view){

                return redirect(route('admin.v1.dashboard'))->with('message','You don\'t have this section permission');

            }

        }

        $sounds = Sound::orderByDesc('id')->get();



        return view('admin.v1.sounds.list', compact('sounds','permission'));

    }

    public function add()

    {

        $permission = Permission::where('sub_admin_id',Auth()->user()->id)->first();

        if (Auth()->user()->role == 3) {

            if(!$permission->sound_add){

                return redirect(route('admin.v1.dashboard'))->with('message','You don\'t have this section permission');

            }

        }



        $categories = Categories::orderByDesc('id')->get();

        return view('admin.v1.sounds.add', compact('categories'));

    }

    public function addSubmit(Request $request)

    {

        $this->validate($request, [

            'sound'     =>  'required|mimes:wav,mp3|max:2000',

            'category'  =>  'required|exists:sound_categories,id',

            'soundname' =>  'required|unique:sounds,name'

        ]);



        if ($filed = $request->hasfile('sound')) {

            $filed      = $request->file('sound');

            $named      = 'sounds' . time() . '.' . $filed->getClientOriginalExtension();

            Storage::disk('sounds')->put($named, file_get_contents($filed->getRealPath()));

            $sound = $named;

        } else {

            $sound = Null;

        }



        $SoundObj = new Sound;

        $SoundObj->sound = $sound;

        $SoundObj->category = $request->category;

        $SoundObj->name = $request->soundname;

        $SoundObj->save();



        $request->session()->flash('success', 'Your Sound has been added successfully.');

        return redirect()->route('admin.v1.sound.category-list');

    }

    public function delete($id)

    {

        $permission = Permission::where('sub_admin_id',Auth()->user()->id)->first();

        if (Auth()->user()->role == 3) {

            if(!$permission->sound_delete){

                return redirect(route('admin.v1.dashboard'))->with('message','You don\'t have this section permission');

            }

        }

        Sound::where('id', $id)->delete();

        return redirect()->back();

    }

}

