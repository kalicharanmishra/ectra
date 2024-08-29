<?php

namespace App\Http\Controllers\Api;

use App\Mail\EmailOtpMail;
use App\Mail\ForgotPasswordMail;
use App\Mail\RegisterMail;
use App\Models\User;
use App\Models\VenderOtp;
use App\Models\TruckManagment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Event;
use App\Models\Order;
use App\Models\UserBank;
use App\Models\SiteSetting;
use URL;
use attempt;

class VenderController extends ApiController
{


    public function GetProfile(Request $request)
    {
        $response = array();
        $user   = User::find(Auth::user()->id);
        $Events   = Event::where('vendor_id', $user->id)->orderBy('id', 'desc')->get();
        $orders   = Order::where('vendor_id', $user->id)
            ->with('customer_details', 'order_items.food')
            ->orderBy('id', 'desc')
            ->take(3)->get();
        $response['id'] = $user->id;
        $response['name'] = $user->name;
        $response['username'] = $user->username;
        $response['username'] = $user->username;
        $response['avtars'] = $user->avtars;
        $response['phone'] = $user->phone;
        $response['events'] = $Events;
        $response['orders'] = $orders;

        $this->status  = true;
        $this->data    = $response;
        $this->message = 'Profile Details.';

        return $this->jsonView();
    }


    public function GetEventDetails()
    {

        $data = Event::Where('vendor_id', Auth::user()->id)->with('Customer_details')->get();
        if ($data) {
            $data = ['status' => true, 'message' => 'Event Details', 'data' => $data];
        } else {
            $data = ['status' => false, 'message' => 'Event not Found.', 'data' => []];
        }
        return response()->json($data);
    }

    public function EventStatusUpdate(Request $request)
    {
        $rule = [
            'id' => 'required',
            'status'    => 'required'
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            $Event = Event::find($request->id);
            $udata['status'] = $request->status;
            $Event->update($udata);
            $this->status = true;
            $this->message = 'Event has been ' . $request->status . ' Successfully.';
        }
        return $this->jsonView();
    }

    public function MyBookings(Request $request)
    {
        $response = array();
        $user   = User::find(Auth::user()->id);
        // $Events   = Event::where('vendor_id', $user->id)
        //             ->with('truck_detail')
        //             ->with('truck_images')
        //             ->orderBy('id','desc')
        //             ->get();
        // $orders   = Order::where('vendor_id',$user->id)
        //             ->with('customer_details','order_items.food')
        //             ->orderBy('id','desc')
        //             ->get();
        // $response['events'] = $Events;
        // $response['orders'] = $orders;

        // Get list of events booked this user


        $events = Event::where('vendor_id', $user->id)
                    ->with('Customer_details')
                  ->orderBy('id', 'desc')
                  ->get();
        $response['events'] = $events;
        $this->status  = true;
        $this->data    = $response;
        $this->message = 'Booking history.';

        return $this->jsonView();
    }

    public function OrderStatusUpdate(Request $request)
    {
        $rule = [
            'id' => 'required',
            'status'    => 'required'
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            $Order = Order::find($request->id);
            $udata['status'] = $request->status;
            $Order->update($udata);
            $this->status = true;
            $this->message = 'Order has been ' . $request->status . ' Successfully.';
        }
        return $this->jsonView();
    }

    public function AddBank(Request $request)
    {
        $rule = [
            'bank_name' => 'required',
            'bank_account' => 'required',
            'bank_account_holder' => 'required',
            'bank_address' => 'required',
            'bank_ifsc' => 'required',
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            $user   = User::find(Auth::user()->id);
            $UserBank = UserBank::where('user_id', $user->id)
                ->first();
            if (!empty($UserBank)) {
                $update['bank_name']    = $request->bank_name;
                $update['bank_account']    = $request->bank_account;
                $update['bank_account_holder']    = $request->bank_account_holder;
                $update['bank_address']    = $request->bank_address;
                $update['bank_ifsc']    = $request->bank_ifsc;
                $UserBank->update($update);
                $data = ['status' => true, 'message' => 'Bank account update successfully!', 'data' => $UserBank];
            } else {
                $Bank = new UserBank();
                $Bank->user_id       = Auth::user()->id;
                $Bank->bank_name     = $request->bank_name;
                $Bank->bank_account       = $request->bank_account;
                $Bank->bank_account_holder    = $request->bank_account_holder;
                $Bank->bank_address      = $request->bank_address;
                $Bank->bank_ifsc      = $request->bank_ifsc;
                $Bank->save();
                $data = ['status' => true, 'message' => 'Bank account add successfully!', 'data' => $Bank];
            }
            return response()->json($data);
        }
        return $this->jsonView();
    }

    public function GetBank(Request $request)
    {
        $user   = User::find(Auth::user()->id);
        $UserBank = UserBank::where('user_id', $user->id)->first();

        $data = [
            'status' => false,
            'message' => 'Bank details!',
            'data' => $UserBank
        ];

        return response()->json($data);
    }

    public function GetTransactions(Request $request)
    {
        $user   = User::find(Auth::user()->id);
        $SiteSetting   = SiteSetting::where('slug', 'admin_commission')->first();
        $Order = Order::where('vendor_id', $user->id)->get();
        $response = array();
        foreach ($Order as $key => $val) {
            $get_per = ($val->price * $SiteSetting->value / 100);
            $response[$key]['id'] = $val->id;
            $response[$key]['price'] = $val->price;
            $response[$key]['amount'] = $val->price - $get_per;
            $response[$key]['status'] = $val->status;
            $response[$key]['payment_type'] = $val->payment_type;
            $response[$key]['created_at'] = $val->created_at;
        }
        $data = [
            'status' => false,
            'message' => 'Transactions!',
            'data' => $response
        ];
        return response()->json($data);
    }
}
