<?php

namespace App\Http\Controllers\api;

use App\Models\Uninterested;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UninterestedController extends ApiController
{
    public function change_interest(Request $request){
        
        $rule = [
            // 'content_id' => 'required|exists:hash_tags,id|exists:users,id',
            'filter_by' => 'in:user,tag',
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            
        $data = Uninterested::where([
            'content_id' => $request->content_id,
            'type' => 'video',
            'filter_by' => $request->filter_by,
            'user_id' => Auth::user()->id,
        ])->first();

if($data){
$status = $data->delete();
$message = "Remove from Uniterested list";

        }else{
        
       $status = Uninterested::create([
            'content_id' => $request->content_id,
            'type' => 'video',
            'filter_by' => $request->filter_by,
            'user_id' => Auth::user()->id,
        ]);
 
        $message = "Add to Uniterested";
    }
        
        if ($status) {
            $this->status = true;
            $this->error = false;
            $this->message = $message;
            $this->data = [];
            return $this->jsonView();
        }
    }
    return $this->jsonView();
}

}
