<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use App\Models\UserMeta;

class ApiController extends BaseController
{


    public $status = false;
    public $message = '';
    public $code = 200;
    public $data = array();
    public $error = false;
    public $json = true;


    function __construct()
    {
        //\Log::info('Request Url: '. $_SERVER['REQUEST_URI']);
        //Log::info('Request params: ', Input::all());
    }

    function validateData($data, $rule)
    {
        $validator = Validator::make($data, $rule);
        $firstError = '';
        $error = [];
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                $firstError = $messages[0];
                $error[$field_name] = $messages[0];
                break;
            }
            $this->message = $firstError;
            $this->code = 200;
            $this->error = true;

            return false;
        } else {
            return true;
        }
    }

    function jsonView()
    {

        $resp = [
            'status' => $this->status,
            'data' => empty($this->data) ? [] :  (object)$this->data,
            'message' => $this->message,
            'error' => $this->error,
        ];

        return response()->json($resp, 200);
    }


    function __destruct()
    {
        return $this->jsonView();
    }

    function pr($data, $die = false)
    {
        echo "<pre>";
        print_r($data);
        "</pre>";
        if ($die)
            die();
    }

    public function get_user_available_chance($user_id)
    {
        $available_spin = 0;
        // check if user has available spin
        $user_levels = UserMeta::where('user_id', $user_id)
            ->where('meta_key', 'user_levels')
            ->first();
        $user_levels_de = json_decode($user_levels->meta_value);
        if (!empty($user_levels_de)) {
            $earned_spin_total = 0;
            $used_spin_total = 0;
            foreach ($user_levels_de as $user_level) {
                $earned_spin    =   (int)$user_level->earned_spin;
                $used_spin      =   (int)$user_level->used_spin;

                $earned_spin_total  +=  $earned_spin;
                $used_spin_total   +=  $used_spin;
            }
            $available_spin = $earned_spin_total - $used_spin_total;
        }
        return $available_spin;
    }
    public function get_user_used_chance($user_id)
    {
        $used_spin = 0;
        // check if user has available spin
        $user_levels = UserMeta::where('user_id', $user_id)
            ->where('meta_key', 'user_levels')
            ->first();
        $user_levels_de = json_decode($user_levels->meta_value);
        if (!empty($user_levels_de)) {

            $used_spin_total = 0;
            foreach ($user_levels_de as $user_level) {
                $used_spin      =   (int)$user_level->used_spin;
                $used_spin_total   +=  $used_spin;
            }
            $used_spin = $used_spin_total;
        }
        return $used_spin;
    }

    public function generate_username($string_name = "Mike Tyson", $rand_no = 200)
    {
        $bytes = random_bytes(5);
        return bin2hex($bytes);

        // $username_parts = array_filter(explode(" ", strtolower($string_name))); //explode and lowercase name
        // $username_parts = array_slice($username_parts, 0, 2); //return only first two arry part

        // $part1 = (!empty($username_parts[0])) ? substr($username_parts[0], 0, 8) : ""; //cut first name to 8 letters
        // $part2 = (!empty($username_parts[1])) ? substr($username_parts[1], 0, 5) : ""; //cut second name to 5 letters
        // $part3 = ($rand_no) ? rand(0, $rand_no) : "";

        // $username = $part1 . str_shuffle($part2) . $part3; //str_shuffle to randomly shuffle all characters
        // return $username;
    }

    public function random_username($string)
    {
        $bytes = random_bytes(10);
        return bin2hex($bytes);

        // $pattern = "";
        // $firstPart = strstr(strtolower($string), $pattern, true);
        // $secondPart = substr(strstr(strtolower($string), $pattern, false), 0, 3);
        // $username = trim($firstPart) . trim($secondPart);
        // return $username;
    }

    public function send_push_notification($type, $device_token, $message)
    {
        $url = "https://fcm.googleapis.com/fcm/send";
        $token = $device_token;
        $serverKey = 'AAAAzWymZ2o:APA91bEaha6_-P6JRL8HmBnP9ZMbrnuMsykDFZ4gSifBPnd_9eIlT2Vp8T4kIt0qk-KVeckQq6vyGtWiCJLYVe-PXU5pvy_WT7yNzKUJw9LVW653uXLWLRnuuHbevcBchraSN4drFwN5';
        $title = "Thrill";
        $body = $message;
        $notification = array('title' => $title, 'body' => $body, 'sound' => 'default', 'badge' => '1',);
        $data = array('type' => $type);
        $arrayToSend = array('to' => $token, 'notification' => $notification, 'data' => $data, 'priority' => 'high');
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
        return $result;
    }

    public function sendSMSOTP($phone, $otp)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.authkey.io/request?authkey=972c35b4d29906dc&mobile=' . $phone . '&country_code=91&sid=4265&name=Thrill&otp=' . $otp . '&company=thrill%20account&time=5%20minutes',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}
