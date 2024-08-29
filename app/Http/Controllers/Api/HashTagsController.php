<?php

namespace App\Http\Controllers\Api;

use App\Models\HashTag;
use App\Models\VideoLike;
use App\Models\VideoView;
use App\Models\UserMeta;
use App\Models\Follower;
use App\Models\Video;
use App\Models\UserActivityCounter;
use App\Models\User;
use App\Models\Sound;
use App\Models\SoundCategory;
use App\Models\VideoComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class HashTagsController extends ApiController
{
    public function list()
    {
        $this->status = true;
        $this->message = "Hash tag list";
        $this->data = HashTag::orderByDesc('id')->get();
        return $this->jsonView();
    }

    public function topHashtagsVideos()
    {
        $hash_tags = DB::table('video_hashtags')
            ->select(DB::raw('hashtag_id,video_id, count(*) as video_count'))
            ->addSelect(['hashtag_name' => function ($query) {
                $query->select('name')
                    ->from('hash_tags')
                    ->whereColumn('id', 'video_hashtags.hashtag_id')
                    ->limit(1);
            }])
            ->groupBy('hashtag_id')
            ->orderByDesc('video_count')
            ->get();

        $response = [];
        foreach ($hash_tags as $tag) {
            $rsp['hashtag_id'] = $tag->hashtag_id;

            $rsp['hashtag_name'] = $tag->hashtag_name;
            // $rsp['videos']
            $videos = DB::table('video_hashtags')
                ->rightJoin('videos', 'video_hashtags.video_id', '=', 'videos.id')
                ->where('video_hashtags.hashtag_id', $tag->hashtag_id)
                ->select('videos.id', 'videos.user_id', 'videos.video', 'videos.video_thumbnail', 'videos.gif_image', 'videos.sound', 'videos.filter', 'videos.language', 'videos.category', 'videos.hashtags', 'videos.is_comment_allowed', 'videos.is_enabled', 'videos.description', 'videos.created_at', 'videos.updated_at', 'videos.speed', 'videos.is_duet', 'videos.duet_from', 'videos.is_duetable', 'videos.is_commentable', 'videos.sound_owner')
                ->limit(20)
                ->get();

            $rsp['video_count'] = count($videos);
            $video_arr = [];
            foreach ($videos as $video) {
                $userde = User::where('id', $video->user_id)->first();
                $user_counters = UserActivityCounter::get();
                $referral_count = DB::table('user_activity_counters')
                    ->select(DB::raw('SUM(invite_counter) as referral_count'))
                    ->where('user_id', $userde->id)
                    ->first();

                $likes = DB::table('user_activity_counters')
                    ->select(DB::raw('SUM(like_counter) as likes'))
                    ->where('user_id', $userde->id)
                    ->first();

                $user_levels_meta = UserMeta::where('user_id', $userde->id)
                    ->where('meta_key', 'user_levels')
                    ->first();
                $user_levels_meta_value = json_decode($user_levels_meta->meta_value);

                $creators_current_level_arr = explode(',', $user_levels_meta_value->creators->current_level);
                $creators_next_level_arr = explode(',', $user_levels_meta_value->creators->next_level);
                $creators_current_level = $creators_current_level_arr[count($creators_current_level_arr) - 1];
                $creators_next_level = $creators_next_level_arr[count($creators_next_level_arr) - 1];

                $sound_details = Sound::where('id', $video->sound)->first();

                if (isset($sound_details->category)) {
                    $sound_category = SoundCategory::where('id', $sound_details->category)->first();
                } else {
                    $sound_category = '';
                }

                $sound_owner_name = null;
                if (!empty($video->sound_owner)) {
                    $sound_owner = User::find($video->sound_owner);
                    if (isset($sound_owner->id)) {
                        $sound_owner_name = (!empty($sound_owner->name)) ? $sound_owner->name : $sound_owner->username;
                    }
                }
                 // get video like status
            $video_like_status = 0;
            $liked_videos_arr = [];
        if(isset(Auth::guard('api')->user()->id)){
            $user_liked_video_list = UserMeta::where('user_id', Auth::guard('api')->user()->id)
                ->where('meta_key', 'liked_videos')
                ->first();
            if (isset($user_liked_video_list->meta_value)) {
                $liked_videos = $user_liked_video_list->meta_value;
                $liked_videos_arr = explode(',', $liked_videos);
            }
            if (in_array($video->id, $liked_videos_arr)) {
                $video_like_status = 1;
            }
        }

                $video_arr[] = [
                    'id' => $video->id,
                    'video' => $video->video,
                    'description' => $video->description,
                    'sound' => $video->sound,
                    'sound_name' => $sound_details->name ?? '',
                    'sound_category_name' => $sound_category->name ?? '',
                    'filter' => $video->filter,
                    'likes' => VideoLike::where('video_id', $video->id)->first()->counter ?? 0,
                    'views' => VideoView::where('video_id', $video->id)->first()->counter ?? 0,
                    'gif_image' => $video->gif_image,
                    'speed' => $video->speed,
                    'comments' => VideoComment::where('video_id', $video->id)->count(),
                    'hashtags' => !empty(json_decode($video->hashtags)) ? HashTag::whereIn('name', json_decode($video->hashtags))->select('id','name')->get()->toArray() : null,
                    'is_duet' => $video->is_duet,
                    'duet_from' => $video->duet_from,
                    'is_duetable' => $video->is_duetable,
                    'is_commentable' => $video->is_commentable,
                    'sound_owner' => $sound_owner_name,
                    'video_like_status'=>$video_like_status,
                    'user' => [
                        'id' => $userde->id,
                        'name' => $userde->name,
                        'username' => $userde->username,
                        'email' => (empty($userde->social_login_id)) ? NULL : $userde->email,
                        'dob' => $userde->dob,
                        'phone' => $userde->phone,
                        'avatar' => $userde->avtars,
                        'social_login_id' => $userde->social_login_id,
                        'social_login_type' => $userde->social_login_type,
                        'first_name' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'first_name')->first()->meta_value ?? NULL,
                        'last_name' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'last_name')->first()->meta_value ?? NULL,
                        'gender' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'gender')->first()->meta_value ?? NULL,
                        'website_url' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'website_url')->first()->meta_value ?? NULL,
                        'bio' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'bio')->first()->meta_value ?? NULL,
                        'youtube' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'youtube')->first()->meta_value ?? NULL,
                        'facebook' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'facebook')->first()->meta_value ?? NULL,
                        'instagram' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'instagram')->first()->meta_value ?? NULL,
                        'twitter' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'twitter')->first()->meta_value ?? NULL,
                        'firebase_token' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'firebase_token')->first()->meta_value ?? NULL,
                        'referral_count' => (string)$referral_count->referral_count ?? '0',
                        'following' => (string)Follower::where('follower_user_id', $userde->id)->count() ?? '0',
                        'followers' => (string)Follower::where('publisher_user_id', $userde->id)->count() ?? '0',
                        'likes' => (string)$likes->likes ?? '0',
                        'levels' => [
                            'current' => (string)$creators_current_level ?? '0',
                            'next' => (string)$creators_next_level ?? '0',
                            'progress' => '50'
                        ],
                        'total_videos' => (string)Video::where('user_id', $userde->id)->count(),
                        'box_two' => '0',
                        'box_three' => '0',
                    ],
                ];
            }
            $rsp['videos'] = $video_arr;
            $response[] = $rsp;
        }

        return response()->json([
            'status' => true,
            'message' => "List of videos by Top hash tags.",
            'data' => $response
        ]);
    }
    
    public function getVideosByHashtag(Request $request)
    {
        $rule = [
            'hashtag_id'     => 'required|exists:hash_tags,id|min:1|max:999999999999999999999',
        ];
        if ($this->validateData($request->all(), $rule)) {
            $this->status = true;
            $this->message = "List of videos by hashtag id";
            $videos = DB::table('video_hashtags')
                ->leftJoin('videos', 'video_hashtags.video_id', '=', 'videos.id')
                ->where('video_hashtags.hashtag_id', $request->hashtag_id)
                ->select('videos.id', 'videos.user_id', 'videos.video', 'videos.video_thumbnail', 'videos.gif_image', 'videos.sound', 'videos.filter', 'videos.language', 'videos.category', 'videos.hashtags', 'videos.is_comment_allowed', 'videos.is_enabled', 'videos.description', 'videos.created_at', 'videos.updated_at', 'videos.speed', 'videos.is_duet', 'videos.duet_from', 'videos.is_duetable', 'videos.is_commentable', 'videos.sound_owner')
                ->limit(20)
                ->get() ?? [];

            $video_arr = [];
            foreach ($videos as $key =>$video) {
                if($video->id){
                $userde = User::where('id', $video->user_id)->first();
                $user_counters = UserActivityCounter::get();
                $referral_count = DB::table('user_activity_counters')
                    ->select(DB::raw('SUM(invite_counter) as referral_count'))
                    ->where('user_id', $userde->id)
                    ->first();

                $likes = DB::table('user_activity_counters')
                    ->select(DB::raw('SUM(like_counter) as likes'))
                    ->where('user_id', $userde->id)
                    ->first();

                $user_levels_meta = UserMeta::where('user_id', $userde->id)
                    ->where('meta_key', 'user_levels')
                    ->first();
                $user_levels_meta_value = json_decode($user_levels_meta->meta_value);

                $creators_current_level_arr = explode(',', $user_levels_meta_value->creators->current_level);
                $creators_next_level_arr = explode(',', $user_levels_meta_value->creators->next_level);
                $creators_current_level = $creators_current_level_arr[count($creators_current_level_arr) - 1];
                $creators_next_level = $creators_next_level_arr[count($creators_next_level_arr) - 1];

                $sound_details = Sound::where('id', $video->sound)->first();

                if (isset($sound_details->category)) {
                    $sound_category = SoundCategory::where('id', $sound_details->category)->first();
                } else {
                    $sound_category = '';
                }

                $sound_owner_name = null;
                if (!empty($video->sound_owner)) {
                    $sound_owner = User::find($video->sound_owner);
                    if (isset($sound_owner->id)) {
                        $sound_owner_name = (!empty($sound_owner->name)) ? $sound_owner->name : $sound_owner->username;
                    }
                }

                 // get video like status
            $video_like_status = 0;
            $liked_videos_arr = [];
        if(isset(Auth::guard('api')->user()->id)){
            $user_liked_video_list = UserMeta::where('user_id', Auth::guard('api')->user()->id)
                ->where('meta_key', 'liked_videos')
                ->first();
            if (isset($user_liked_video_list->meta_value)) {
                $liked_videos = $user_liked_video_list->meta_value;
                $liked_videos_arr = explode(',', $liked_videos);
            }
            if (in_array($video->id, $liked_videos_arr)) {
                $video_like_status = 1;
            }
        }

                $video_arr[] = [
                    'id' => $video->id,
                    'video' => $video->video,
                    'description' => $video->description,
                    'sound' => $video->sound,
                    'sound_name' => $sound_details->name ?? '',
                    'sound_category_name' => $sound_category->name ?? '',
                    'filter' => $video->filter,
                    'likes' => VideoLike::where('video_id', $video->id)->first()->counter ?? 0,
                    'views' => VideoView::where('video_id', $video->id)->first()->counter ?? 0,
                    'gif_image' => $video->gif_image,
                    'speed' => $video->speed,
                    'comments' => VideoComment::where('video_id', $video->id)->count(),
                    'hashtags' => !empty(json_decode($video->hashtags)) ? HashTag::whereIn('name', json_decode($video->hashtags))->select('id','name')->get()->toArray() : null,
                    'sound_owner' => $sound_owner_name,
                    'video_like_status'=>$video_like_status,
                    'user' => [
                        'id' => $userde->id,
                        'name' => $userde->name,
                        'username' => $userde->username,
                        'email' => (empty($userde->social_login_id)) ? NULL : $userde->email,
                        'dob' => $userde->dob,
                        'phone' => $userde->phone,
                        'avatar' => $userde->avtars,
                        'social_login_id' => $userde->social_login_id,
                        'social_login_type' => $userde->social_login_type,
                        'first_name' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'first_name')->first()->meta_value ?? NULL,
                        'last_name' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'last_name')->first()->meta_value ?? NULL,
                        'gender' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'gender')->first()->meta_value ?? NULL,
                        'website_url' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'website_url')->first()->meta_value ?? NULL,
                        'bio' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'bio')->first()->meta_value ?? NULL,
                        'youtube' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'youtube')->first()->meta_value ?? NULL,
                        'facebook' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'facebook')->first()->meta_value ?? NULL,
                        'instagram' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'instagram')->first()->meta_value ?? NULL,
                        'twitter' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'twitter')->first()->meta_value ?? NULL,
                        'firebase_token' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'firebase_token')->first()->meta_value ?? NULL,
                        'referral_count' => (string)$referral_count->referral_count ?? '0',
                        'following' => (string)Follower::where('follower_user_id', $userde->id)->count() ?? '0',
                        'followers' => (string)Follower::where('publisher_user_id', $userde->id)->count() ?? '0',
                        'likes' => (string)$likes->likes ?? '0',
                        'levels' => [
                            'current' => (string)$creators_current_level ?? '0',
                            'next' => (string)$creators_next_level ?? '0',
                            'progress' => '50'
                        ],
                        'total_videos' => (string)Video::where('user_id', $userde->id)->count(),
                        'box_two' => '0',
                        'box_three' => '0',
                    ],
                ];
            }
            }
            $this->data = $video_arr;


            return response()->json([
                'status' => true,
                'error' => false,
                'message' => $this->message,
                'data' => $this->data
            ]);
        }
        return $this->jsonView();
    }

    public function searchHashtags(Request $request)
    {
        $rule = [
            'search'     => 'nullable|min:1|max:255',
        ];
        if ($this->validateData($request->all(), $rule)) {
            if($request->search){
                $hashtag = HashTag::where('name', $request->search)->first();
                DB::table('hashtag_views')->insert([
                    'hashtag'=>$request->search,
                    'type'=>1,
                    'hashtag_id'=> $hashtag?$hashtag->id:null,
                ]);
            $hash_tags = HashTag::where('name', 'like', '%' . $request->search . '%')->get();
          
            $response = [];
            foreach ($hash_tags as $tag) {
                $rsp['id'] = $tag->id;
                $rsp['name'] = $tag->name;
                $videos = DB::table('video_hashtags')
                    ->leftJoin('videos', 'video_hashtags.video_id', '=', 'videos.id')
                    ->leftJoin('video_views', 'video_hashtags.video_id', '=', 'videos.id')
                    ->where('video_hashtags.hashtag_id', $tag->id)
                    ->select('videos.id', 'videos.user_id', 'videos.video', 'videos.video_thumbnail', 'videos.gif_image', 'videos.sound', 'videos.filter', 'videos.language', 'videos.category', 'videos.hashtags', 'videos.is_comment_allowed', 'videos.is_enabled', 'videos.description', 'videos.created_at', 'videos.updated_at', 'videos.speed', 'videos.is_duet', 'videos.duet_from', 'videos.is_duetable', 'videos.is_commentable', 'videos.sound_owner','video_views.counter as totalview')
                    ->orderBy('totalview','DESC')
                    ->limit(20)
                    ->get();
                $video_arr = [];
                $users_arr = [];
                $sounds_arr = [];
                foreach ($videos as $video) {
                    $userde = User::where('id', $video->user_id)->first();
                    $user_counters = UserActivityCounter::get();
                    $referral_count = DB::table('user_activity_counters')
                        ->select(DB::raw('SUM(invite_counter) as referral_count'))
                        ->where('user_id', $userde->id)
                        ->first();

                    $likes = DB::table('user_activity_counters')
                        ->select(DB::raw('SUM(like_counter) as likes'))
                        ->where('user_id', $userde->id)
                        ->first();

                    $user_levels_meta = UserMeta::where('user_id', $userde->id)
                        ->where('meta_key', 'user_levels')
                        ->first();
                    $user_levels_meta_value = json_decode($user_levels_meta->meta_value);

                    $creators_current_level_arr = explode(',', $user_levels_meta_value->creators->current_level);
                    $creators_next_level_arr = explode(',', $user_levels_meta_value->creators->next_level);
                    $creators_current_level = $creators_current_level_arr[count($creators_current_level_arr) - 1];
                    $creators_next_level = $creators_next_level_arr[count($creators_next_level_arr) - 1];

                    $sound_details = Sound::where('sound', $video->sound)->select('id','sound','category')->first();

                    if (isset($sound_details->category)) {
                        $sound_category = SoundCategory::where('id', $sound_details->category)->first();
                    } else {
                        $sound_category = '';
                    }

                    $sound_owner_name = null;
                    if (!empty($video->sound_owner)) {
                        $sound_owner = User::find($video->sound_owner);
                        if (isset($sound_owner->id)) {
                            $sound_owner_name = (!empty($sound_owner->name)) ? $sound_owner->name : $sound_owner->username;
                        }
                    }
                    $follower = Follower::where('follower_user_id', $userde->id);
                    $isfollow = 0;
                    if(Auth::guard('api')->user()){
                    $isfollow = $follower->where('publisher_user_id', Auth::guard('api')->user()->id)->count();
                    }

                     // get video like status
            $video_like_status = 0;
            $liked_videos_arr = [];
        if(isset(Auth::guard('api')->user()->id)){
            $user_liked_video_list = UserMeta::where('user_id', Auth::guard('api')->user()->id)
                ->where('meta_key', 'liked_videos')
                ->first();
            if (isset($user_liked_video_list->meta_value)) {
                $liked_videos = $user_liked_video_list->meta_value;
                $liked_videos_arr = explode(',', $liked_videos);
            }
            if (in_array($video->id, $liked_videos_arr)) {
                $video_like_status = 1;
            }
        }
                    $video_arr[] = [
                        'id' => $video->id,
                        'video' => $video->video,
                        'description' => $video->description,
                        'sound' => $video->sound,
                        'sound_name' => $sound_details->name ?? '',
                        'sound_category_name' => $sound_category->name ?? '',
                        'filter' => $video->filter,
                        'likes' => VideoLike::where('video_id', $video->id)->first()->counter ?? 0,
                        'views' => VideoView::where('video_id', $video->id)->first()->counter ?? 0,
                        'gif_image' => $video->gif_image,
                        'speed' => $video->speed,
                        'comments' => VideoComment::where('video_id', $video->id)->count(),
                        'hashtags' => !empty(json_decode($video->hashtags)) ? HashTag::whereIn('name', json_decode($video->hashtags))->select('id','name')->get()->toArray() : null,
                        'is_duet' => $video->is_duet,
                        'duet_from' => $video->duet_from,
                        'is_duetable' => $video->is_duetable,
                        'is_commentable' => $video->is_commentable,
                        'sound_owner' => $sound_owner_name,
                        'video_like_status'=>$video_like_status,
                        'totalview' => $video->totalview,
                        'user' => [
                            'id' => $userde->id,
                            'name' => $userde->name,
                            'username' => $userde->username,
                            'email' => (empty($userde->social_login_id)) ? NULL : $userde->email,
                            'dob' => $userde->dob,
                            'phone' => $userde->phone,
                            'avatar' => $userde->avtars,
                            'social_login_id' => $userde->social_login_id,
                            'social_login_type' => $userde->social_login_type,
                            'first_name' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'first_name')->first()->meta_value ?? NULL,
                            'last_name' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'last_name')->first()->meta_value ?? NULL,
                            'gender' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'gender')->first()->meta_value ?? NULL,
                            'website_url' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'website_url')->first()->meta_value ?? NULL,
                            'bio' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'bio')->first()->meta_value ?? NULL,
                            'youtube' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'youtube')->first()->meta_value ?? NULL,
                            'facebook' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'facebook')->first()->meta_value ?? NULL,
                            'instagram' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'instagram')->first()->meta_value ?? NULL,
                            'twitter' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'twitter')->first()->meta_value ?? NULL,
                            'firebase_token' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'firebase_token')->first()->meta_value ?? NULL,
                            'referral_count' => (string)$referral_count->referral_count ?? '0',
                            'following' => (string)$follower->count() ?? '0',
                            'followers' => (string)Follower::where('publisher_user_id', $userde->id)->count() ?? '0',
                            'isfollow' => $isfollow>0?1:0,
                            'likes' => (string)$likes->likes ?? '0',
                            'levels' => [
                                'current' => (string)$creators_current_level ?? '0',
                                'next' => (string)$creators_next_level ?? '0',
                                'progress' => '50'
                            ],
                            'total_videos' => (string)Video::where('user_id', $userde->id)->count(),
                            'box_two' => '0',
                            'box_three' => '0',
                        ],
                    ];
                    $users_arr[] = [
                        'id' => $userde->id,
                            'name' => $userde->name,
                            'username' => $userde->username
                    ];
                    if($sound_details){
                        $sounds_arr[] = $sound_details;
                    }
                }
                $rsp['videos'] = $video_arr;
                $rsp['hashtags'] =  $hash_tags->toArray();                
                $rsp['users'] = $this->unique_multidimensional_array($users_arr,'id');
                $rsp['sounds'] = $this->unique_multidimensional_array($sounds_arr,'id');
                $rsp['video_count'] = count($rsp['videos']);
                $response[] = $rsp;
            }
        }else{
            $hash_tag_all = DB::table('hashtag_views')
            ->where('created_at', '>', now()->subWeek())
            ->select('id', 'hashtag', DB::raw('count(*) as total'))
            ->groupBy('hashtag')
            ->orderBy('total','DESC')
            ->get();
            $hash_tags = $hash_tag_all->pluck('hashtag')->toArray();
        //   dd($hash_tags);
            $response = [];
           
            $videos = Video::where(['visibility' => 'Public'])
            ->Where(function ($query) use($hash_tags) {
                for ($i = 0; $i < count($hash_tags); $i++){
                   
                   $query->orWhere('hashtags', 'like',  DB::raw("'%$hash_tags[$i]%'"));
                 
                }      
           })
           ->leftJoin('video_views', 'video_views.video_id', '=', 'videos.id')
           ->select('videos.id', 'videos.user_id', 'videos.video', 'videos.video_thumbnail', 'videos.gif_image', 'videos.sound', 'videos.filter', 'videos.language', 'videos.category', 'videos.hashtags', 'videos.is_comment_allowed', 'videos.is_enabled', 'videos.description', 'videos.created_at', 'videos.updated_at', 'videos.speed', 'videos.is_duet', 'videos.duet_from', 'videos.is_duetable', 'videos.is_commentable', 'videos.sound_owner','videos.sound_owner','video_views.counter as totalview')
           ->orderBy('totalview','DESC')
           ->limit(20)
           ->get() ?? [];
         
                $video_arr = [];
                $tag_arr = [];
                $users_arr = [];
                $sounds_arr = [];
                foreach ($videos as $video) {
                    $userde = User::where('id', $video->user_id)->first();
                    $user_counters = UserActivityCounter::get();
                    $referral_count = DB::table('user_activity_counters')
                        ->select(DB::raw('SUM(invite_counter) as referral_count'))
                        ->where('user_id', $userde->id)
                        ->first();

                    $likes = DB::table('user_activity_counters')
                        ->select(DB::raw('SUM(like_counter) as likes'))
                        ->where('user_id', $userde->id)
                        ->first();

                    $user_levels_meta = UserMeta::where('user_id', $userde->id)
                        ->where('meta_key', 'user_levels')
                        ->first();
                    $user_levels_meta_value = json_decode($user_levels_meta->meta_value);

                    $creators_current_level_arr = explode(',', $user_levels_meta_value->creators->current_level);
                    $creators_next_level_arr = explode(',', $user_levels_meta_value->creators->next_level);
                    $creators_current_level = $creators_current_level_arr[count($creators_current_level_arr) - 1];
                    $creators_next_level = $creators_next_level_arr[count($creators_next_level_arr) - 1];

                    $sound_details = Sound::where('sound', $video->sound)->select('id','sound','category')->first();

                    if (isset($sound_details->category)) {
                        $sound_category = SoundCategory::where('id', $sound_details->category)->first();
                    } else {
                        $sound_category = '';
                    }

                    $sound_owner_name = null;
                    if (!empty($video->sound_owner)) {
                        $sound_owner = User::find($video->sound_owner);
                        if (isset($sound_owner->id)) {
                            $sound_owner_name = (!empty($sound_owner->name)) ? $sound_owner->name : $sound_owner->username;
                        }
                    }
                    $follower = Follower::where('follower_user_id', $userde->id);
                    $isfollow = 0;
                    if(Auth::guard('api')->user()){
                    $isfollow = $follower->where('publisher_user_id', Auth::guard('api')->user()->id)->count();
                    }

                     // get video like status
            $video_like_status = 0;
            $liked_videos_arr = [];
        if(isset(Auth::guard('api')->user()->id)){
            $user_liked_video_list = UserMeta::where('user_id', Auth::guard('api')->user()->id)
                ->where('meta_key', 'liked_videos')
                ->first();
            if (isset($user_liked_video_list->meta_value)) {
                $liked_videos = $user_liked_video_list->meta_value;
                $liked_videos_arr = explode(',', $liked_videos);
            }
            if (in_array($video->id, $liked_videos_arr)) {
                $video_like_status = 1;
            }
        }
                    $video_arr[] = [
                        'id' => $video->id,
                        'video' => $video->video,
                        'description' => $video->description,
                        'sound' => $video->sound,
                        'sound_name' => $sound_details->name ?? '',
                        'sound_category_name' => $sound_category->name ?? '',
                        'filter' => $video->filter,
                        'likes' => VideoLike::where('video_id', $video->id)->first()->counter ?? 0,
                        'views' => VideoView::where('video_id', $video->id)->first()->counter ?? 0,
                        'gif_image' => $video->gif_image,
                        'speed' => $video->speed,
                        'comments' => VideoComment::where('video_id', $video->id)->count(),
                        'hashtags' => !empty(json_decode($video->hashtags)) ? HashTag::whereIn('name', json_decode($video->hashtags))->select('id','name')->get()->toArray() : null,
                        'is_duet' => $video->is_duet,
                        'duet_from' => $video->duet_from,
                        'is_duetable' => $video->is_duetable,
                        'is_commentable' => $video->is_commentable,
                        'sound_owner' => $sound_owner_name,
                        'video_like_status'=>$video_like_status,
                        'totalview' => $video->totalview,
                        'user' => [
                            'id' => $userde->id,
                            'name' => $userde->name,
                            'username' => $userde->username,
                            'email' => (empty($userde->social_login_id)) ? NULL : $userde->email,
                            'dob' => $userde->dob,
                            'phone' => $userde->phone,
                            'avatar' => $userde->avtars,
                            'social_login_id' => $userde->social_login_id,
                            'social_login_type' => $userde->social_login_type,
                            'first_name' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'first_name')->first()->meta_value ?? NULL,
                            'last_name' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'last_name')->first()->meta_value ?? NULL,
                            'gender' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'gender')->first()->meta_value ?? NULL,
                            'website_url' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'website_url')->first()->meta_value ?? NULL,
                            'bio' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'bio')->first()->meta_value ?? NULL,
                            'youtube' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'youtube')->first()->meta_value ?? NULL,
                            'facebook' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'facebook')->first()->meta_value ?? NULL,
                            'instagram' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'instagram')->first()->meta_value ?? NULL,
                            'twitter' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'twitter')->first()->meta_value ?? NULL,
                            'firebase_token' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'firebase_token')->first()->meta_value ?? NULL,
                            'referral_count' => (string)$referral_count->referral_count ?? '0',
                            'following' => (string)$follower->count() ?? '0',
                            'followers' => (string)Follower::where('publisher_user_id', $userde->id)->count() ?? '0',
                            'isfollow' => $isfollow>0?1:0,
                            'likes' => (string)$likes->likes ?? '0',
                            'levels' => [
                                'current' => (string)$creators_current_level ?? '0',
                                'next' => (string)$creators_next_level ?? '0',
                                'progress' => '50'
                            ],
                            'total_videos' => (string)Video::where('user_id', $userde->id)->count(),
                            'box_two' => '0',
                            'box_three' => '0',
                        ],
                    ];
                 
                    $users_arr[] = [
                        'id' => $userde->id,
                            'name' => $userde->name,
                            'username' => $userde->username
                    ];
                    if($sound_details){
                        $sounds_arr[] = $sound_details;
                    }
                  
                }
                $rsp['videos'] = $video_arr;
                $rsp['hashtags'] = $hash_tag_all->toArray();                
                $rsp['users'] = $this->unique_multidimensional_array($users_arr,'id');
                $rsp['sounds'] = $this->unique_multidimensional_array($sounds_arr,'id');
                $rsp['video_count'] = count($rsp['videos']);
                $response[] = $rsp;
            
        }

            return response()->json([
                'status' => true,
                'message' => "Search result.",
                'data' => $response
            ]);
        }
        return $this->jsonView();
    }

    public function add(Request $request)
    {
        $rule = [
            'name' => 'required|alpha_dash',
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            $hashTagsObj = new HashTag;
            $hashTagsObj->name = $request->name;
            $hashTagsObj->user_id = Auth::user()->id;
            $hashTagsObj->save();

            $this->status = true;
            $this->message = "Hashtag added!!!";
            $this->data = $hashTagsObj;
            return $this->jsonView();
        }
        return $this->jsonView();
    }

    function unique_multidimensional_array($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();
    
        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
                $i++;
            }
            
        }
        return $temp_array;
    }
}
