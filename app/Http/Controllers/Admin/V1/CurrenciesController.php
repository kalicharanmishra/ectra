<?php

namespace App\Http\Controllers\Admin\V1;

use App\Models\Network;
use App\Models\Currency;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CurrenciesController extends Controller
{
    //list
    public function list()
    {
       

        $currency = Currency::all();
        return view('admin.v1.currencies.list', compact('currency'));
    }

    // add view
    public function add()
    {
        $permission = Permission::where('sub_admin_id', Auth()->user()->id)->first();

        if (Auth()->user()->role == 3) {

            if (!$permission->currency_add) {
                return redirect(route('admin.v1.dashboard'))->with('message', 'You don\'t have this section permission');
            }
        }

        return view('admin.v1.currencies.add', compact('permission'));
    }

    // add submit
    public function addSubmit(Request $request)
    {

        $this->validate($request, [
            'code'      =>  'required',
        ]);

        if (!$request->get('symbol')) {
            $this->validate($request, [
                'currency-image' => 'required|mimes:jpeg,jpg,png,gif|required|max:300'
            ]);
            if ($request->hasfile('currency-image')) {
                $filed = $request->file('currency-image');
                $named = 'currency' . time() . '.' . $filed->getClientOriginalExtension();
                Storage::disk('currency')->put($named, file_get_contents($filed->getRealPath()));
                $image_name = $named;
            } else {
                $image_name = null;
            }
        }
        $CurrencyObj = Currency::create(
            [
                'code' => $request->get('code'),
                'symbol' => $request->get('symbol') ?? '',
                'image' => $image_name ?? '',
            ]
        );


        $request->session()->flash('success', 'Your Currency has been added successfully.');
        return redirect()->route('admin.v1.currencies.list');
    }

    // delete
    public function delete($id)
    {
        $permission = Permission::where('sub_admin_id', Auth()->user()->id)->first();

        if (Auth()->user()->role == 3) {

            if (!$permission->currency_delete) {
                return redirect(route('admin.v1.currencies.list'))->with('message', 'You don\'t have this section permission');
            }
        }

        $network = Network::where('currency_id', $id)->delete();
        $currency = Currency::where('id', $id)->delete();
        return redirect()->back();
    }

    public function getNetworks($currency_id)
    {
        $permission = Permission::where('sub_admin_id', Auth()->user()->id)->first();

        if (Auth()->user()->role == 3) {

            if (!$permission->currency_add) {
                return redirect(route('admin.v1.currencies.list'))->with('message', 'You don\'t have this section permission');
            }
        }
        $networks = Network::with('network_currency')->where('currency_id', $currency_id)->get();
        $currency = Currency::where('id', $currency_id)->first();
        return view('admin.v1.currencies.networks', compact('networks', 'currency', 'permission'));
    }

    public function addNetwork($currency_id)
    {
        $permission = Permission::where('sub_admin_id', Auth()->user()->id)->first();

        if (Auth()->user()->role == 3) {

            if (!$permission->currency_add) {
                return redirect(route('admin.v1.currencies.networks'))->with('message', 'You don\'t have this section permission');
            }
        }

        $currency = Currency::find($currency_id);
        return view('admin.v1.currencies.addnetwork', compact('currency', 'permission'));
    }


    public function addNetworkSubmit(Request $request, $currency_id)
    {
        $this->validate($request, [
            'network_name' => 'required|unique:networks,network_name',
            'min_amount' => 'nullable|numeric|gt:0',
            'max_amount' => 'nullable|numeric|gt:0',
            'fee_digit' => 'nullable|numeric|gt:0'
        ]);

        $networkObj = new Network;
        $networkObj->currency_id  =   $currency_id;
        $networkObj->network_name        =   $request->network_name;
        $networkObj->min_amount  =   $request->min_amount ?? 0;
        $networkObj->max_amount        =   $request->max_amount ?? 0;
        $networkObj->fee_digit        =   $request->fee_digit ?? 0;
        $networkObj->save();
        return redirect()->route('admin.v1.currencies.networks', ['currency_id' => $currency_id]);
    }

    public function updateNetwork($currency_id, $network_id)
    {
        $permission = Permission::where('sub_admin_id', Auth()->user()->id)->first();

        if (Auth()->user()->role == 3) {

            if (!$permission->currency_add) {
                return redirect(route('admin.v1.currencies.networks'))->with('message', 'You don\'t have this section permission');
            }
        }
        $currency = Currency::find($currency_id);
        $network = Network::find($network_id);
        return view('admin.v1.currencies.updatenetwork', compact('currency', 'network', 'permission'));
    }
    public function updateNetworkSubmit(Request $request, $currency_id, $network_id)
    {
        $this->validate($request, [
            'network_name' => 'required|unique:networks,network_name,' . $network_id,
            'min_amount' => 'nullable|numeric',
            'max_amount' => 'nullable|numeric',
            'fee_digit' => 'nullable|numeric'
        ]);
        $input = $request->all();
        unset($input['_token']);
        Network::where('id', $network_id)->update($input);
        return redirect()->route('admin.v1.currencies.networks', ['currency_id' => $currency_id]);
    }

    public function status($id, $status)
    {
        $Currency = Currency::find($id);
        if (isset($Currency->id) && ((int)$status == 1 || (int)$status == 0)) {
            $Currency->is_active = $status;
            $Currency->save();
        }
        return redirect()->back();
    }

    public function deleteNetworks($network_id){
        $Network = Network::find($network_id);
        if(isset($Network->id)){
            $Network->delete();
        }
        return redirect()->back();
    }
}
