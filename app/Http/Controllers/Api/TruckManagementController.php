<?php

namespace App\Http\Controllers\Api;

use App\Mail\EmailOtpMail;
use App\Mail\ForgotPasswordMail;
use App\Mail\RegisterMail;
use App\Models\User;
use App\Models\UserOtp;
use App\Models\TruckManagment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\TruckImage;
use App\Models\TruckShop;
use URL;
use Illuminate\Support\Facades\Storage;

class TruckManagementController extends ApiController
{
    public function TruckCreate(Request $request)
    {
    	$validator = \Validator::make($request->all(), [
            'truck_name' => 'required',
            'description' => 'required',
            'street_name' => 'required',
            'state' => 'required',
            'city' => 'required',
            'zip_code' => 'required',
            'start_time' => 'required',
            'longitude' => 'required',
            'latitude' => 'required'
        ]);
        if ($validator->fails()) {
            $responseArr['message'] = $validator->errors();;
            $responseArr['token'] = '';
            return response()->json($responseArr);
        }
        $TruckManagment = new TruckManagment;
        $TruckManagment->truck_name = $request->truck_name;
        $TruckManagment->description = $request->description;
        $TruckManagment->street_name = $request->street_name;
        $TruckManagment->state = $request->state;
        $TruckManagment->city = $request->city;
        $TruckManagment->user_id = Auth::user()->id;
        $TruckManagment->zip_code = $request->zip_code;
        $TruckManagment->start_time = $request->start_time;
        $TruckManagment->end_time = $request->end_time;
        $TruckManagment->longitude = $request->longitude;
        $TruckManagment->latitude = $request->latitude;
        if ($TruckManagment->save()) {
            /*Truck Images Save*/
            if ($request->hasfile('truck_img')) {
                $prio = 1;
                $productImg = [];
                $prodImg = new TruckImage();
                foreach ($request->file('truck_img') as $key => $image) {
                    $name = 'truck_images_' . $TruckManagment->id . '-' . $prio . '-' . time() . '.' .$image->getClientOriginalExtension();
                    Storage::disk('truck_images')->put($name, file_get_contents($image->getRealPath()));
                    if (!empty($TruckManagment->id))
                     $productImg[] = ['truck_managment_id' => $TruckManagment->id, 'truck_image' => $name,'extension' => $image->getClientOriginalExtension()];
                    else
                     $productImg[] = ['truck_managment_id' => null, 'truck_image' => $name,'extension' => $image->getClientOriginalExtension()];
                    $prio++;
                }
                TruckImage::insert($productImg);
            }
            $data = [
              'status'=>true,
              'message'=>'Food Truck added Successfully.',
              'data'=> $TruckManagment,
           ];
        }else{
           $data = [
              'status'=>false,
              'message'=>'please try agin.',
              'data'=> [],
           ];
        }
        return response()->json($data);
    }

    public function GetTruckDetails(Request $request)
    {

       $data = TruckManagment::where('user_id',Auth::user()->id)
                ->with('vendor_details','truck_multiple_images','truck_shops')
                ->first();
       if ($data) {
         $data = ['status'=>true, 'message'=>'Truck Details','data'=> $data];
       }else{
          $data = ['status'=>false,'message'=>'Trucks not Found.','data'=> []]; 
       }
       return response()->json($data);
    }

    public function UpdateTruck(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'truck_name' => 'required',
            'description' => 'required',
            // 'street_name' => 'required',
            // 'state' => 'required',
            // 'city' => 'required',
            // 'zip_code' => 'required',
            // 'start_time' => 'required',
            // 'end_time' => 'required',
            'longitude' => 'required',
            'latitude' => 'required'
        ]);
        if ($validator->fails()) {
            $responseArr['message'] = $validator->errors();;
            $responseArr['token'] = '';
            return response()->json($responseArr);
        }
        $TruckManagment = TruckManagment::find($request->id);
        $TruckManagment->truck_name = $request->truck_name;
        $TruckManagment->description = $request->description;
        $TruckManagment->street_name = $request->street_name;
        $TruckManagment->state = $request->state;
        $TruckManagment->city = $request->city;
        $TruckManagment->user_id = Auth::user()->id;
        $TruckManagment->zip_code = $request->zip_code;
        $TruckManagment->start_time = $request->start_time;
        $TruckManagment->end_time = $request->end_time;
        $TruckManagment->longitude = $request->longitude;
        $TruckManagment->latitude = $request->latitude;
        if ($TruckManagment->save()) {
            /*Truck Images Save*/
            if ($request->hasfile('truck_img')) {
                $prio = 1;
                $productImg = [];
                $prodImg = new TruckImage();
                //echo "<pre>"; print_r($request->file('truck_img')); die;
                foreach ($request->file('truck_img') as $key => $image) {
                    $name = 'truck_images_' . $TruckManagment->id . '-' . $prio . '-' . time() . '.' .$image->getClientOriginalExtension();
                    Storage::disk('truck_images')->put($name, file_get_contents($image->getRealPath()));
                    if (!empty($TruckManagment->id))
                     $productImg[] = ['truck_managment_id' => $TruckManagment->id, 'truck_image' => $name,'extension' => $image->getClientOriginalExtension()];
                    else
                     $productImg[] = ['truck_managment_id' => null, 'truck_image' => $name,'extension' => $image->getClientOriginalExtension()];
                    $prio++;
                }
                TruckImage::insert($productImg);
            }
            $shops = $request->shops;
            if(isset($shops) && !empty($shops)){
                TruckShop::where("truck_managment_id",$TruckManagment->id)->delete();
                $shopsjson = json_decode($shops);
                //echo "<pre>"; print_r($shopsjson); die("df");
                $_shops = [];
                $_shops['truck_managment_id']    =  $TruckManagment->id;
                $t_shop = new TruckShop();
                foreach($shopsjson->shops as $val){
                    $_shops['street']    =  $val->street_name;
                    $_shops['state']    =  $val->state;
                    $_shops['city']    =  $val->city;
                    $_shops['zip_code']    =  $val->zip_code;
                    $_shops['start_time']    =  $val->start_time;
                    $_shops['end_time']    =  $val->end_time;
                    TruckShop::insert($_shops);
                }
                
            }

            $data = [
              'status'=>true,
              'message'=>'Food Truck added Successfully.',
              'data'=> $TruckManagment,
           ];
        }else{
           $data = [
              'status'=>false,
              'message'=>'please try agin.',
              'data'=> [],
           ];
        }
        return response()->json($data);
    }

    public function GetFoodDetails(Request $request)
    {

        $data = User::Where([['status', 'active'],['role', 2]])->get();
        if ($data) {
             $data = ['status'=>true, 'message'=>'Vendor Details','data'=> $data];
        }else{
              $data = ['status'=>false,'message'=>'Vendor not Found.','data'=> []]; 
            }
            return response()->json($data);
    }
}
