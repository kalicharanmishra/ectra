<?php



namespace App\Http\Controllers\Admin\V1;



use App\Models\Setting;

use App\Models\Permission;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;



class SettingsController extends Controller

{

    // listing of all site settings

    public function list()

    {

        // $permission = Permission::where('sub_admin_id', Auth()->user()->id)->first();

        // if (Auth()->user()->role == 3) {



        //     if (!$permission->sitesetting_view) {

        //         return redirect(route('admin.v1.dashboard'))->with('message', 'You don\'t have this section permission');

        //     }

        // }

        $settings = Setting::whereNotIn('name', ['payment_network_user', 'commission_fee'])->get();

        $settings_arr = [];

        foreach ($settings as $setting) {

            if ($setting->name == "payment_network_user") {

                $setting_val = json_decode($setting->value);

                $setting_str = implode(",", $setting_val);

                $settings_arr[] = [

                    'id' => $setting->id,

                    'name' => $setting->name,

                    'value' => $setting_str,

                ];

            } else {

                $settings_arr[] = [

                    'id' => $setting->id,

                    'name' => $setting->name,

                    'value' => $setting->value,

                ];

            }

        }
        $acti = array(
            'active'          => "set_view",
            'activetxt'       => "set_view",
          );

        return view('admin.v1.settings.list', compact('settings_arr','acti'));

    }



    public function edit($id)

    {

        if (auth()->user()->roles->pluck('name')[0] != "super admin" ) {



            // if (!$permission->sitesetting_edit) {

                return redirect(route('admin.v1.dashboard'))->with('message', 'You don\'t have this section permission');

            // }

        }

        $setting = Setting::find($id);

        if ($setting->name == "payment_network_user") {

            $setting_val = json_decode($setting->value);

            $setting_str = implode(",", $setting_val);

            $setting->value = $setting_str;

        }
        $acti = array(
            'active'          => "set_view",
            'activetxt'       => "set_view",
          );
        return view('admin.v1.settings.edit', compact('setting','acti'));

    }



    public function editSubmit(Request $request, $id)

    {

        $setting = Setting::find($id);

        // $this->validate($request, [

        //     'setting-value' => 'required',

        // ]);

        if ($setting->name == "advertisement_image") {

            if ($filed = $request->hasfile('setting-value')) {

                $filed      = $request->file('setting-value');

                $named      = 'advertisement' . time() . '.' . $filed->getClientOriginalExtension();

                Storage::disk('profile_images')->put($named, file_get_contents($filed->getRealPath()));

                $setting->value = $named;

                $setting->save();

            } else {

                $setting->value = '';

                $setting->save();

            }

        } else {

            $setting->value = $request->{'setting-value'};

            $setting->save();

        }

        return redirect()->route('admin.v1.settings.list');

    }

}

