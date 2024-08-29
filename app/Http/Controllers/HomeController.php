<?php



namespace App\Http\Controllers;



use App\Models\Order;

use App\Models\CmsPage;

use App\Models\Permission;

use App\Models\SiteSetting;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;



class HomeController extends Controller

{

    /**

     * Create a new controller instance.

     *

     * @return void

     */

    public function __construct()

    {

        $this->middleware('auth');

    }



    /**

     * Show the application dashboard.

     *

     * @return \Illuminate\Contracts\Support\Renderable

     */

    public function index()

    {

        return redirect()->route('dashboard');

    }



    public function dashboard()

    {

        return view('front.dashboard');

        // return view('admin.index');

    }





    // public function



    public function logout()

    {

        //logout user

        auth()->logout();

        // redirect to homepage

        return redirect('/login');

    }





    public function cms()

    {



       

        if (!Auth::user()->can('cms_view')) {

                return redirect(route('admin.v1.dashboard'))->with('message','You don\'t have this section permission');

            }


            $acti = array(
                'active'          => "cms",
                'activetxt'       => "cms",
              );
        $list = CmsPage::get();

        $active_menu = "CMSManagement";

        $active_submenu = "CMSManagement";

        return view('admin.Cms.list', compact('list', 'active_menu', 'active_submenu','acti'));

    }



    public function cms_edit($id)

    {

        if (!Auth::user()->can('cms_edit')) {

                return redirect(route('admin.v1.dashboard'))->with('message', 'You don\'t have this section permission');

        }


        $acti = array(
            'active'          => "cms",
            'activetxt'       => "cms",
          );
        $edit = CmsPage::find($id);

        $active_menu = "CMSManagement";

        $active_submenu = "CMSManagement";

        return view('admin.Cms.edit', compact('edit', 'active_menu', 'active_submenu','acti'));

    }



    public function add_cms()

    {

        if (!Auth::user()->can('cms_add')) {

                return redirect(route('admin.v1.dashboard'))->with('message', 'You don\'t have this section permission');

        }



        $active_menu = "CMSManagement";

        $active_submenu = "CMSManagement";

        $acti = array(
            'active'          => "cms",
            'activetxt'       => "cms",
          );
        return view('admin.Cms.add', compact('active_menu', 'active_submenu','acti'));

    }



    public function add_cms_submit(Request $request)

    {

        $this->validate($request, [

            'title' => 'required',

            'slug' => 'required',

            'description' => 'required'

        ]);

        $update = new CmsPage();

        $update->title = $request->title;

        $update->slug = $request->slug;

        $update->description = $request->description;

        if ($update->save()) {

            return redirect()->route('admin.v1.cms.index');

        } else {

            return redirect()->back();

        }

    }

    public function cms_update(Request $request, $id)

    {

        $this->validate($request, [

            'title' => 'required',

            'slug' => 'required',

            'description' => 'required'

        ]);

        $update =  CmsPage::find($id);

        $update->description = $request->description;

        if ($update->save()) {

            return redirect()->route('admin.v1.cms.index');

        } else {

            return redirect()->back();

        }

    }



    public function cms_delete($id)

    {

        if (!Auth::user()->can('cms_delete')) {

                return redirect(route('admin.v1.dashboard'))->with('message', 'You don\'t have this section permission');

        }



        $update =  CmsPage::find($id);

        if ($update->delete()) {

            return redirect()->route('admin.v1.cms.index');

        } else {

            return redirect()->back();

        }

    }



    public function site_setting(Request $request)

    {

        if (!Auth::user()->can('sitesetting_view')) {

                return redirect(route('admin.v1.dashboard'))->with('message','You don\'t have this section permission');

        }



        $setting = SiteSetting::get();

        $active_menu = "SiteSetting";

        $active_submenu = "SiteSetting";

        return view('admin.Setting.list', compact('setting', 'active_menu', 'active_submenu','permission'));

    }



    public function setting_update(Request $request)

    {

        foreach ($_POST as $key => $value) {

            if ($key != '_token') {

                $update = SiteSetting::where('slug', $key)

                    ->update(array(

                        'value' => $value

                    ));

            }

        }

        return redirect()->route('site-setting');

        // $this->validate($request,[

        //     'value' => 'required'

        // ]);

        // $update =  SiteSetting::find($id);

        // $update->value = $request->value;

        // if ($update->save()) {

        //     return redirect()->route('site-setting');

        // }else{

        //     return redirect()->back();

        // }

    }



    public function PaymentManagement(Request $request)

    {

        $SiteSetting   = SiteSetting::where('slug', 'admin_commission')->first();

        $Orders = Order::where('payment_type', 'cod')->with('vendor_details', 'customer_details')->get();

        // $response = array();

        // foreach($Order as $key => $val){

        //     $get_per = ($val->price*$SiteSetting->value/100);

        //     $response[$key]['id'] = $val->id;

        //     $response[$key]['price'] = $val->price;

        //     $response[$key]['amount'] = $val->price-$get_per;

        //     $response[$key]['status'] = $val->status;

        //     $response[$key]['payment_type'] = $val->payment_type;

        //     $response[$key]['created_at'] = $val->created_at;

        // }

        $active_menu = "PaymentManagement";

        $active_submenu = "PaymentManagement";

        //echo "<pre>"; print_r($response); die;

        return view('admin.Orders.list', compact('Orders', 'active_menu', 'active_submenu', 'SiteSetting'));

    }

}

