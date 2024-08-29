<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserMeta;

class PrivateController extends Controller
{

    public function getUserLevels(Request $request)
    {
        $data = UserMeta::where('user_id', $request->user_id)
            ->where('meta_key', 'user_levels')
            ->select('meta_value')
            ->first();
        $meta_value = json_decode($data->meta_value);
        return response()->json($meta_value);
    }
}