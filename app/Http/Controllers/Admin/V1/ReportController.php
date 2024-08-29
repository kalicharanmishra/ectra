<?php

namespace App\Http\Controllers\Admin\V1;

use App\Http\Controllers\Controller;
use App\Models\ReportedUser;
use App\Models\ReportVideos;
use App\Models\UserWarning;
use App\Models\User;
use App\Models\UserMeta;
use App\Models\Notification;
use App\Models\Video;


class ReportController extends Controller
{
    public function reportedUsers()
    {
        $reports = ReportedUser::with('user_detail', 'reporter_detail', 'warning')->get();
        return view('admin.v1.reports.users', compact('reports'));
    }

    public function reportedVideos()
    {
        $reports = ReportVideos::with('video_detail', 'reporter_detail')->get();
        return view('admin.v1.reports.videos', compact('reports'));
    }

    public function warnReportedUser($id)
    {
        // check if already reported
        $UserWarningObj = UserWarning::where('user_id', $id)->first();
        if (isset($UserWarningObj->id)) {
            $UserWarningObj->warning_counter = ($UserWarningObj->warning_counter + 1);
            $UserWarningObj->save();
        } else {
            $UserWarningObj = new UserWarning;
            $UserWarningObj->user_id = $id;
            $UserWarningObj->warning_counter = 1;
            $UserWarningObj->save();
        }
        return redirect(route('admin.report.users'))->with('message', 'Warning sent');
    }

    public function notifyReportedUser($id)
    {
        $user_detail = User::where('id', $id)->first();
        $firebase_token = UserMeta::where('user_id', $user_detail->id)->where('meta_key', 'firebase_token')->select('id', 'meta_value')->first();
        if (!empty($firebase_token->meta_value)) {
            $message = "Warning: multiple user reported you. follow rules and code of conduct.";
            $title = "Report Warning";
            $NotificationObj = new Notification;
            $NotificationObj->user_id = $user_detail->id;
            $NotificationObj->title = $title;
            $NotificationObj->body = $message;
            $NotificationObj->save();
            $this->send_push_notification($title, $firebase_token->meta_value, $message);
        }
        return redirect(route('admin.report.users'))->with('message', 'Notice sent');
    }

    public function send_push_notification($type, $device_token, $message)
    {
        $url = "https://fcm.googleapis.com/fcm/send";
        $token = $device_token;
        $serverKey = 'AAAAzWymZ2o:APA91bEaha6_-P6JRL8HmBnP9ZMbrnuMsykDFZ4gSifBPnd_9eIlT2Vp8T4kIt0qk-KVeckQq6vyGtWiCJLYVe-PXU5pvy_WT7yNzKUJw9LVW653uXLWLRnuuHbevcBchraSN4drFwN5';
        $title = "Mohita";
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

    public function deleteReportedVideos($id)
    {
        $ReportVideosObj = ReportVideos::find($id);
        Video::where('id', $ReportVideosObj->video_id)->delete();
        ReportVideos::where('id', $id)->delete();
        return redirect(route('admin.report.videos'))->with('message', 'deleted');
    }
}
