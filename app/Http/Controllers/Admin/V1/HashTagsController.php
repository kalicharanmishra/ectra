<?php

namespace App\Http\Controllers\Admin\V1;

use App\Models\Video;
use App\Models\HashTag;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\VideoHashTags;
use App\Http\Controllers\Controller;

class HashTagsController extends Controller
{
    public function list()
    {
        $permission = Permission::where('sub_admin_id',Auth()->user()->id)->first();

        if (Auth()->user()->role == 3) {

            if(!$permission->hashtag_view){
                return redirect(route('admin.v1.dashboard'))->with('message','You don\'t have this section permission');
            }
        }
        $hashtags = HashTag::get();
        return view('admin.v1.hashtags.list', compact('hashtags','permission'));
    }

    public function videos($id)
    {
        $permission = Permission::where('sub_admin_id',Auth()->user()->id)->first();
        if (Auth()->user()->role == 3) {
            if(!$permission->video_view){
                return redirect(route('admin.v1.hashtags.list'))->with('message','You don\'t have this section permission');
            }
        }

        $videos = VideoHashTags::where('hashtag_id', $id)->get();
        $videos_arr = [];
        if (!empty($videos)) {
            foreach ($videos as $video) {
                $videos_arr[] = $video->video_id;
            }
        }
        $videos_details = Video::whereIn('id', $videos_arr)->get();
        return view('admin.v1.hashtags.videos', compact('videos_details','permission'));
    }
}
