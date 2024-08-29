<?php



namespace App\Http\Controllers\Admin\V1;



use App\Models\Banner;

use App\Models\Permission;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;



class BannersController extends Controller

{

    public function list()

    {

        

            if(!auth()->user()->can('banner_view')){

                return redirect(route('admin.v1.dashboard'))->with('message','You don\'t have this section permission');

            }

            $acti = array(
                'active'          => "banner",
                'activetxt'       => "banner",
              );

        $banners = Banner::get();

        return view('admin.v1.banner.list', compact('banners','acti'));

    }



    public function add()

    {

       

            if (!auth()->user()->can('banner_add')) {

                return redirect(route('admin.v1.banner.list'))->with('message', 'You don\'t have this section permission');

            }

            $acti = array(
                'active'          => "banner",
                'activetxt'       => "banner",
              );

        return view('admin.v1.banner.add',compact('acti'));

    }

    public function edit($id)

    {

       $banner = Banner::find($id);

       if (!auth()->user()->can('banner_add')) {

                return redirect(route('admin.v1.banner.list'))->with('message', 'You don\'t have this section permission');

        }
        $acti = array(
            'active'          => "banner",
            'activetxt'       => "banner",
          );
        return view('admin.v1.banner.edit', compact('banner','acti'));

    }



    public function addSubmit(Request $request)

    {

        $this->validate($request, [

            'image'      =>  'required|mimes:jpeg,jpg,png,gif|required|max:1200',

            'start_date'      =>  'required|date|before_or_equal:end_date',

            'end_date'      =>  'required|date|after_or_equal:start_date',

        ]);



        if ($request->hasfile('image')) {

            $filed      = $request->file('image');

            $named      = 'banners' . time() . '.' . $filed->getClientOriginalExtension();

            Storage::disk('banners')->put($named, file_get_contents($filed->getRealPath()));

            $image_name = $named;

        } else {

            $image_name = null;

        }

        

        $bannerObj = new Banner;

        $bannerObj->image = $image_name;

        $bannerObj->banner_text = $request->banner_text;
        $bannerObj->start_date = $request->start_date;

        $bannerObj->end_date = $request->end_date;

        $bannerObj->save();

        $request->session()->flash('success', 'Banner has been uploaded successfully.');

        return redirect()->route('admin.v1.banner.list');

    }

    public function editSubmit(Request $request, $id)

    { 

        $this->validate($request, [

            'image'      =>  'nullable|mimes:jpeg,jpg,png,gif|max:300',

            'start_date'      =>  'required|date|before_or_equal:end_date',

            'end_date'      =>  'required|date|after_or_equal:start_date',

        ]);

        $bannerObj = Banner::find($id);

        if ($request->hasfile('image')) {

            $filed      = $request->file('image');

            $named      = 'banners' . time() . '.' . $filed->getClientOriginalExtension();

            Storage::disk('banners')->put($named, file_get_contents($filed->getRealPath()));

            $image_name = $named;

        } else {

            $image_name = $bannerObj->image;

        }

        

        $bannerObj->image = $image_name;

        $bannerObj->banner_text = $request->banner_text;

        $bannerObj->start_date = $request->start_date;

        $bannerObj->end_date = $request->end_date;

        $bannerObj->save();

        $request->session()->flash('success', 'Banner has been Update successfully.');

        return redirect()->route('admin.v1.banner.list');

    }



    public function delete($id)

    {

        if (!auth()->user()->can('banner_delete')) {

                return redirect(route('admin.v1.banner.list'))->with('message', 'You don\'t have this section permission');

        }

        Banner::where('id', $id)->delete();

        return redirect()->back();

    }

}

