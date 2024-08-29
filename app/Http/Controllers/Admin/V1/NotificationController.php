<?php



namespace App\Http\Controllers\Admin\V1;



use App\Models\User;

use App\Models\Setting;

use App\Models\UserMeta;

use App\Models\Permission;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;



use Illuminate\Support\Facades\Auth;



class NotificationController extends Controller

{

    // listing of all site settings

    public function add()

    {

                  if (!Auth::user()->can('set_notification')) {

                return redirect(route('admin.v1.dashboard'))->with('message', 'You don\'t have this section permission');

     

        }



        $users = User::whereHas("roles", function($q){ 

            $q->where(["id"=>4,"id" => 3]);

         })

           ->get();

           $acti = array(
            'active'          => "set_noti",
            'activetxt'       => "set_noti",
          );

        return view('admin.v1.settings.setnotification', compact('users','acti'));

    }



    public function send(Request $request){



        $this->validate($request, [

            'title'=>'required|max:39',

            'message'=>'required|max:200',



        ]);

        if(isset($request->alluser)){

            $token_array = collect(User::whereNotNull('firebase_token')->select('firebase_token')->get())->pluck('firebase_token')->toArray();

            // $token_array =['fZkdkj-dlBoLNOBL5zZf8u:APA91bFi0x3c00kBDx6p8AIRcOuVZ3bQLDVxNY1LrnpX81StY6Jj0SE1RLaUx0ikuvy0f1cztu44gmAbeYQAOh3TUL5FrpM8r72YYzrrW5nWt_zbg17Q-NrgtrDyVgtk7eC9pw2DlSxY'];

        }else{

            $token_array = collect(User::whereIn('id', $request->users)->whereNotNull('firebase_token')->select('firebase_token')->get())->pluck('firebase_token')->toArray();

 

  }

        $this->send_push_notification($request->title, $token_array,$request->title, $request->message);



        return redirect()->route('admin.v1.settings.set-notification');



    }



    public function send_push_notification($type, $device_token, $title,$message)

    {

        $url = "https://fcm.googleapis.com/fcm/send";

        $token = $device_token;

        $serverKey = 'AAAAS1DIgAs:APA91bFEHr3a_uRy456DLsrUdlCqinN_NT9qL5mJJPHAP25loQSQVW7UGyho6nKMofR5rDaRTnQSvr0u6GsLUqtoAAEmxZABe-FswsLFQAkODHN5KOBAUhjNlhjwC32XRDpDbANxD1lz';

   

        $body = $message;

        $notification = array('title' => $title, 'body' => $body, 'sound' => 'default', 'badge' => '1',);

        $data = array('type' => $type);

        $arrayToSend = array('registration_ids' => $token, 'notification' => $notification, 'data' => $data, 'priority' => 'high');

        $json = json_encode($arrayToSend);

        //header with content_type api key

        $headers = array(

            'Content-Type:application/json',

            'Authorization:key=' . $serverKey

        );

        //CURL request to route notification to FCM connection server (provided by Google)

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

        $result = curl_exec($ch);

        if ($result === FALSE) {

            //die('Oops! FCM Send Error: ' . curl_error($ch));

        }

        curl_close($ch);



        // dd($result);

        return $result;

    }





}

