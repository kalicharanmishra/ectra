<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use Validator;
use Auth;

class EventController extends ApiController
{
    public function bookevent(Request $request)
    {   

        $validator = \Validator::make($request->all(), [
           'street_name'=>'required',
           'city'=>'required',
           'state'=>'required',
           'zipcode'=>'required',
           'date'=>'required',
           'time'=>'required',
           'phone'=>'required',
           'email'=>'required',
           'duration'=>'required',
           'vendor_id'=>'required'
           ]);
      
        if ($validator->fails()) {
            $responseArr['message'] = $validator->errors();;
            $responseArr['token'] = '';
            return response()->json($responseArr);
        }
            $Event =  new Event;
            $Event->street_name = $request->street_name;
            $Event->city = $request->city;
            $Event->street_name = $request->street_name;
            $Event->state = $request->state;
            $Event->user_id = Auth::user()->id;
            $Event->vendor_id = $request->vendor_id;
            $Event->zipcode = $request->zipcode;
            $Event->date = $request->date;
            $Event->time = $request->time;
            $Event->phone = $request->phone;
            $Event->email = $request->email;
            $Event->duration = $request->duration;
            $Event->save();
            return response()->json([
            "success" => true,
            "message" => "event booked successfully.",
            "data" => $Event
            ]);
    }
    public function GetEventDetails()
    { 
          $data = Event::Where('user_id',Auth::user()->id)->with('vendor_details','truck_detail')->get();
            if ($data) {
                  $data = ['status'=>true, 'message'=>'Event Details','data'=> $data];
               }else{
                  $data = ['status'=>false,'message'=>'Event not Found.','data'=> []]; 
               }
               return response()->json($data);
    }

    public function editevent(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'location'=>'required',
            'date'=>'required',
             'time'=>'required',
             'phone'=>'required',
             'email'=>'required',
             'duration'=>'required'
          ]);
          if($validator->fails()){
            $responseArr['message']= $validator->errors();
            return response()->json($responseArr);
          }
          $event = event::Where('id',$request->id)->first();
          $event->location= $input['location'];
          $event->date = $input['date'];
          $event->time= $input['time'];
          $event->phone= $input['phone'];
          $event->email= $input['email'];
          $event->duration= $input['duration'];

          $event->save();
          return response()->json([
          "success" => true,
          "message" =>" event updated successfully.",
          "data" => $event
          ]);
    }
}
