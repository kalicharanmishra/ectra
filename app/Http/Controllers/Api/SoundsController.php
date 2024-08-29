<?php

namespace App\Http\Controllers\Api;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sound;
use App\Models\SoundCategory;
use App\Models\Video;
use App\Models\UserMeta;
use App\Models\UserActivityCounter;
use App\Models\User;
use App\Models\VideoComment;
use App\Models\VideoLike;
use App\Models\VideoView;
use App\Models\Follower;

use Illuminate\Support\Facades\DB;


class SoundsController extends ApiController
{
    public function index(Request $request)
    {

        $this->status = true;
        $this->message = "Sound list by category";
        if (!empty($request->category_id)) {
            $sounds_arr = [];
            $sounds = Sound::where('category', 5)->withCount('sound_used')->get();
            foreach ($sounds as $sound) {
                $sound_fav_data = Favorite::where('user_id', Auth::user()->id)->where('table_name', 'sounds')->where('table_id', $sound->id)->first();
                $is_favorite = 0;
                if (isset($sound_fav_data->id)) {
                    $is_favorite = $sound_fav_data->is_favorite;
                }
                $sound->is_favorite = $is_favorite;
                $sounds_arr[] = $sound;
            }
            return response()->json([
                'status' => true,
                'error' => false,
                'message' => "Sound list with category id",
                'data' => $sounds_arr
            ]);
        } else {
            $sounds_arr = [];
            $sounds = Sound::withCount('sound_used')->get();
            foreach ($sounds as $sound) {
                $sound_fav_data = Favorite::where('user_id', Auth::user()->id)->where('table_name', 'sounds')->where('table_id', $sound->id)->first();
                $is_favorite = 0;
                if (isset($sound_fav_data->id)) {
                    $is_favorite = $sound_fav_data->is_favorite;
                }
                $sound->is_favorite = $is_favorite;
                $sounds_arr[] = $sound;
            }
            return response()->json([
                'status' => true,
                'error' => false,
                'message' => "Sound list added by users",
                'data' => $sounds_arr
            ]);
        }
    }

    public function categoryList()
    {
        $this->status = true;
        $this->message = "Sound Categories";
        $this->data = SoundCategory::get();
        return $this->jsonView();
    }

    public function getSound(Request $request)
    {

        $rule = [
            'id' => 'required|exists:sounds,id',
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            $this->status = true;
            $this->message = "OK";
            $this->data = Sound::find($request->id);
            return $this->jsonView();
        }
    }

    public function videosBySound(Request $request)
    {
        $rule = [
            'sound' => 'required',
        ];
        if ($this->validateData($request->all(), $rule)) {
            $videos = Video::where('sound', $request->sound)->get();
            $response = [];

            if (!empty($videos)) {
                foreach ($videos as $video) {
                    if (isset($video->user_id)) {
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

                        $response[] = [
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
                            'is_duet' => $video->is_duet,
                            'duet_from' => $video->duet_from,
                            'is_duetable' => $video->is_duetable,
                            'is_commentable' => $video->is_commentable,
                            'sound_owner' => $sound_owner_name,
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
            }

            return response()->json([
                'status' => true,
                'error' => false,
                'message' => "Videos by Sound",
                'data' => $response
            ]);
        }
        return $this->jsonView();
    }
}
