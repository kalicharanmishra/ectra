<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// use App\Models\User;
use App\Models\Chat;
use App\Models\UserMeta;

class ChatController extends ApiController
{
    private $types = ['text'];

    public function sendMessage(Request $request)
    {
        $rule = [
            'user_to' => 'required|exists:users,id|numeric',
            'user_from' => 'required|exists:users,id|numeric',
            'type' => ['required', Rule::in(['text'])],
            'message' => 'required',
            'date' => 'required|date'
        ];
        $data = $request->all();

        if ($this->validateData($data, $rule)) {

            // check if logged in user send message, not other user
            if ($request->user_from != Auth::user()->id) {
                $this->status  = false;
                $this->data    = [];
                $this->message = 'user_from field must match with logged in user';
                return $this->jsonView();
            }

            // check if chat thread already
            // $chat_thread = Chat::where('user_to IN', [$request->user_to, $request->user_from])
            //     ->where(DB::raw("chats.user_from IN('{$request->user_to}','{$request->user_}')"))
            //     ->first();

            $chat_thread = DB::table('chats')->whereRaw("((user_to = '{$request->user_to}' or user_to = '{$request->user_from}') and (user_from = '{$request->user_to}' or user_from = '{$request->user_from}'))")->first();

            if (empty($chat_thread)) {
                $message = [];
                $message[] = [
                    'message_id' => uniqid(),
                    'to' => $request->user_to,
                    'from' => $request->user_from,
                    'type' => $request->type,
                    'message' => $request->message,
                    'date' => $request->date
                ];
                $chatObj = new Chat;
                $chatObj->user_to = $request->user_to;
                $chatObj->user_from = $request->user_from;
                $chatObj->messages = json_encode($message);
                $chatObj->created_at = date('Y-m-d H:i:s');
                $chatObj->updated_at = date('Y-m-d H:i:s');
                $chatObj->save();
                $this->message = 'Chat thread created.';
            } else {
                $chatObj = Chat::find($chat_thread->ID);
                $message = $chatObj->messages;
                $message_de = json_decode($message);
                $message_de[] = [
                    'message_id' => uniqid(),
                    'to' => $request->user_to,
                    'from' => $request->user_from,
                    'type' => $request->type,
                    'message' => $request->message,
                    'date' => $request->date
                ];
                $chatObj->messages = $message_de;
                $chatObj->save();
            }
            $this->status  = true;
            $this->data    = $chatObj;
            $this->message = 'Chat thread updated.';
        }
        return $this->jsonView();
    }

    public function inbox(Request $request)
    {
        $chats = Chat::where('user_from', Auth::user()->id)->orWhere('user_to', Auth::user()->id)->get();
        $chats_data = [];
        foreach ($chats as $chat) {
            $chat_m = json_decode($chat->messages);
            $chat->messages = $chat_m;
            $chats_data[] = $chat;
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'status' => true,
            'data' => $chats_data,
            'message' => 'User inbox'
        ]);
        die;
    }

    public function chatBox(Request $request)
    {
        $rule = [
            'other_user_id' => 'required|exists:users,id|numeric',
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            // check if logged in user send message, not other user
            if ($request->other_user_id == Auth::user()->id) {
                $this->status  = false;
                $this->data    = [];
                $this->message = 'Logged in user and field other_user_id cannot be same';
                return $this->jsonView();
            }
            // $chat = Chat::where('user_to', $request->user_to)->where('user_from', $request->user_from)->first();
            $user_id = Auth::user()->id;
            $chat = DB::table('chats')->whereRaw("((user_to = '{$request->other_user_id}' or user_to = '{$user_id}') and (user_from = '{$request->other_user_id}' or user_from = '{$user_id}'))")->first();
            if (!empty($chat)) {
                $chat_m = json_decode($chat->messages);
                $chat->messages = $chat_m;
            } else {
                $chat = [];
            }
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'status' => true,
                'data' => $chat,
                'message' => 'User chat box'
            ]);
            die;
        }
        return $this->jsonView();
    }


    public function SendChatNotification(Request $request)
    {
        $rule = [
            'other_user_id' => 'required|exists:users,id|numeric',
            'message' => 'required'
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            $token = UserMeta::where('user_id', $request->other_user_id)->where('meta_key', 'firebase_token')->select('meta_value')->first();                        
            if (isset($token->meta_value)) {                
                $this->send_push_notification('chat', $token->meta_value, $request->message);                
            }
            $this->status = true;
            $this->error = false;
            $this->message = "Send Notification Successfully";
            $this->data = [];            
        }
        return $this->jsonView();
    }
}
