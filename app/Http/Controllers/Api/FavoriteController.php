<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Video;
use App\Models\Sound;
use App\Models\HashTag;
use App\Models\Favorite;
use App\Models\UserMeta;
use App\Models\VideoLike;
use App\Models\VideoView;
use App\Models\User;
use App\Models\UserActivityCounter;
use App\Models\Follower;
use App\Models\SoundCategory;
use App\Models\VideoComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoriteController extends ApiController
{
    /**
     * This will mark favorite for sounds, and hashtags
     *
     * parameter
     *
     * 1. id
     * 2. type: sound|hashtag
     */
    public function addToFavorite(Request $request)
    {
        $rule = [
            'id'     => 'required',
            'type'  => [
                'required',
                Rule::In(['sound', 'hashtag'])
            ],
            'action' => [
                'required',
                Rule::In([0, 1])
            ]
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            // custom validation if sound, hashtag id valid or not
            if ($request->type == 'sound') {
                $sound = Sound::where('id', $request->id)->first();
                if (!isset($sound->id)) {
                    $this->status = false;
                    $this->error = true;
                    $this->message = "Provided sound id is not valid.";
                    $this->data = [];
                    return $this->jsonView();
                }
                $this->update_favorite_status($request->id, 'sounds', $request->action, $sound, 'sound');
            }
            if ($request->type == 'hashtag') {
                $hashtag = HashTag::where('id', $request->id)->first();
                if (!isset($hashtag->id)) {
                    $this->status = false;
                    $this->error = true;
                    $this->message = "Provided hashtag id is not valid.";
                    $this->data = [];
                    return $this->jsonView();
                }
                $this->update_favorite_status($request->id, 'hash_tags', $request->action, $hashtag, 'hashtag');
            }
        }
        return $this->jsonView();
    }

    private function update_favorite_status($table_id, $table_name, $action, $data, $label)
    {
        $is_favorite = Favorite::where('table_id', $table_id)
            ->where('user_id', Auth::user()->id)
            ->where('table_name', $table_name)
            ->first();


        if (isset($is_favorite->id)) {
            // just update status
            $FavoriteObj = Favorite::find($is_favorite->id);
            $FavoriteObj->is_favorite = $action;
            $FavoriteObj->save();
            $this->status = true;
            $status_lebel = ($action == 1) ? 'added to' : 'removed from';
            $this->message = "This {$label}: {$data->name} is now {$status_lebel} your favorite list.";
            $this->data = [];
        } else {
            // create record and update status
            $FavoriteObj = new Favorite;
            $FavoriteObj->user_id = Auth::user()->id;
            $FavoriteObj->table_id = $table_id;
            $FavoriteObj->table_name = $table_name;
            $FavoriteObj->is_favorite = $action;
            $FavoriteObj->save();
            $this->status = true;
            $status_lebel = ($action == 1) ? 'added to' : 'removed from';
            $this->message = "This {$label}: {$data->name} is now {$status_lebel} your favorite list.";
            $this->data = [];
        }
        return true;
    }

    public function userFavoritesList()
    {
        $fav_sounds = Favorite::where('user_id', Auth::user()->id)->where('table_name', 'sounds')->where('is_favorite', 1)->get();
        $fav_hash_tags = Favorite::where('user_id', Auth::user()->id)->where('table_name', 'hash_tags')->where('is_favorite', 1)->get();

        $sounds_arr = [];
        $hash_tags_arr = [];

        foreach ($fav_sounds as $sound) {
            $sounds_arr[] = Sound::find($sound->table_id);
        }
        foreach ($fav_hash_tags as $tags) {
            $hash_tags_arr[] = HashTag::find($tags->table_id);
        }
        $liked_videos = UserMeta::where('user_id', Auth::user()->id)->where('meta_key', 'liked_videos')->first();

        if (isset($liked_videos->meta_value)) {
            $liked_videos = $liked_videos->meta_value;
            $videos = Video::whereIn('id', explode(',', $liked_videos))->get();
            $video_arr = [];
            foreach ($videos as $video) {
                // $userde = User::find($video->user_id)->first();
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
                    'hashtags' => !empty(json_decode($video->hashtags)) ? json_decode($video->hashtags) : null,
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
                // $video->views = VideoLike::where('video_id', $video->id)->first()->counter ?? 0;
                // $video->likes = VideoView::where('video_id', $video->id)->first()->counter ?? 0;
                // $video_arr[] = $video;
            }
            $videos = $video_arr;
        } else {
            $videos = [];
        }



        $this->status = true;
        $this->message = "User Favorite list for videos, sounds and hashtags";
        $this->data = [
            'videos' => $videos,
            'sounds' => $sounds_arr,
            'hash_tags' => $hash_tags_arr,
        ];
        return $this->jsonView();
    }
}
