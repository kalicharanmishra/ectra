<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Language;
use App\Models\Video;
use App\Models\VideoLike;
use App\Models\VideoComment;
use App\Models\VideoView;
use App\Models\User;
use App\Models\UserMeta;
use App\Models\CommentLike;
use App\Models\Favorite;
use App\Models\HashTag;
use App\Models\VideoHashTags;
use App\Models\UserActivityCounter;
use App\Models\Follower;
use App\Models\Notification;
use App\Models\Sound;
use App\Models\ReportVideos;
use App\Models\SoundCategory;
use App\Models\FavoriteVideos;
use App\Models\Uninterested;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class VideosController extends ApiController
{
    private $visibility;

    public function getCourseCategories($id=null)
    { 
       if($id){
            $cat_arr = \App\Models\Categories::whereHas('parent_cat_data', function($q) use($id) {
            $q->where('id', '=', $id);
            })
              ->withCount('childcat')
            ->withCount('courses')
            ->get();
            }else{
            $cat_arr = \App\Models\Categories::where('parent',null)->withCount('childcat')->withCount('courses')->get();
            }
        $this->status = true;
        $this->message = "OK";
        $this->data = $cat_arr;
        return $this->jsonView();
    }

    public function getVideoLanguages()
    {
        $this->status = true;
        $this->message = "OK";
        $this->data = Language::get();
        return $this->jsonView();
    }

    public function postVideo(Request $request)
    {
        $this->visibility = ['Public', 'Private'];
        $rule = [
            'user_id' => 'required|exists:users,id',
            'video' => 'required',
            'language' => 'nullable|exists:languages,id',
            'category' => 'nullable|exists:categories,id',
            'visibility' => [
                'required',
                Rule::in($this->visibility)
            ],
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            $input = $data;
            if (isset($input['is_duet']) && $input['is_duet'] == 'Yes') {
                if (!empty($input['duet_from'])) {
                    $parent_video = Video::where('video', $input['duet_from'])->first();
                    $input['sound_owner'] = $parent_video->sound_owner;
                }
            }
            $video = Video::create($input);
            if (!empty($request->hashtags)) {
                $hashtags = json_decode($request->hashtags);
                if (is_array($hashtags)) {
                    foreach ($hashtags as $hash_tag) {
                        $is_hash_tag_exits = HashTag::where('name', $hash_tag)->first();
                        // Create hash tag in system if not exists
                        if (!isset($is_hash_tag_exits->id)) {
                            $HashTagObj = new HashTag;
                            $HashTagObj->user_id = Auth::user()->id;
                            $HashTagObj->name = $hash_tag;
                            $HashTagObj->save();
                        }
                        // Record history of applied video hash tag in seprate table
                        $VideoHashtags = new VideoHashTags;
                        $VideoHashtags->video_id = $video->id;
                        $VideoHashtags->hashtag_id =  HashTag::where('name', $hash_tag)->first()->id ?? 0;
                        $VideoHashtags->save();
                    }
                }
            }
            // add sound in different table if not already exists
            if (!empty($request->sound_owner) && isset($request->sound) && !empty($request->sound)) {
                $is_sound_exits = Sound::where('sound', $request->sound)->first();
                if (!isset($is_sound_exits->id)) {
                    $SoundObj = new Sound;
                    $SoundObj->sound = $request->sound;
                    $SoundObj->name = $request->sound_name ?? 'Original';
                    $SoundObj->user_id = Auth::user()->id;
                    $SoundObj->save();
                }
            }
            $this->data = $video;
            $this->status = true;
            $this->message = "Wow!!! The video has been posted sucessfully to our server.";

            // send push notification and record notification in table
            // get user followers
            $user_followers = Follower::where('publisher_user_id', Auth::user()->id)->get();

            // to be ensure, data is there
            if (isset($user_followers[0]->id)) {
                foreach ($user_followers as $user_follower) {

                    $live_notification_push = UserMeta::where('user_id', $user_follower->follower_user_id)->where('meta_key', 'live_notification')->first();

                    if (!isset($live_notification_push->meta_value)) {
                        $live_notification_push = 1;
                    } else {
                        $live_notification_push = (int)$live_notification_push->meta_value;
                    }

                    $video_from_accounts_you_follow = UserMeta::where('user_id', $user_follower->follower_user_id)->where('meta_key', 'video_from_accounts_you_follow')->first();
                    // if setting not created already, then we will make it live
                    if (!isset($video_from_accounts_you_follow->meta_value)) {
                        $video_from_accounts_you_follow = 1;
                    } else {
                        $video_from_accounts_you_follow = (int)$video_from_accounts_you_follow->meta_value;
                    }
                    if ($live_notification_push === 1 && $video_from_accounts_you_follow === 1) {
                        $user_detail = User::where('id', $user_follower->follower_user_id)->first();
                        $firebase_token = UserMeta::where('user_id', $user_detail->id)->where('meta_key', 'firebase_token')->select('id', 'meta_value')->first();
                        if (!empty($firebase_token->meta_value)) {
                            $publisher_user_de = User::find(Auth::user()->id);
                            $NotificationObj = new Notification;
                            $NotificationObj->user_id = $user_detail->id;
                            $NotificationObj->title = "New video";
                            $NotificationObj->video_id = $video->id;
                            $NotificationObj->body = "{$publisher_user_de->name} has posted a new video.";
                            $NotificationObj->save();
                            $this->send_push_notification("New video", $firebase_token->meta_value, "{$publisher_user_de->name} has posted a new video.");
                        }
                    }
                }
            }
        }
        return $this->jsonView();
    }

    public function likeVideo(Request $request)
    {

        $rule = [
            'video_id' => 'required|exists:videos,id',
            'is_like' => 'required', // 1: like 0: dislike
        ];

        $data = $request->all();

        if ($this->validateData($data, $rule)) {
            // assign all input data to $input
            $input = $data;

            // get video like data of video id
            $videoLike = VideoLike::where('video_id', $input['video_id'])->first();
            // get counter of that video
            $counter = (!empty($videoLike)) ? $videoLike->counter : 0;

            // if user like the video
            if ($request->is_like == 1) {
                // increase like counter by 1
                $input['counter'] = $counter + 1;
            }
            // if user dislike the video and like counter must be greated then 0
            else if ($request->is_like == 0 && $counter > 0) {
                // descrease like counter by 1
                $input['counter'] = $counter - 1;
            }
            // if user dislike video and counter already 0
            else {
                // assign default counter value 0
                $input['counter'] = $counter;
            }

            // if video like counter already exists then, only update counter
            if (!empty($videoLike)) {
                // update
                $videoLikeObj = VideoLike::find($videoLike->id);
                $videoLikeObj->counter = $input['counter'];
                $videoLikeObj->is_like = $input['is_like'];
                $videoLikeObj->save();
                $this->status = true;
                $this->data = ['likes' => $input['counter']];
                $this->message = "Like counter updated.";
            }
            // if video like counter not exists then, only insert video counter record
            else {
                // insert
                $videoLikeObj = new VideoLike;
                $videoLikeObj->video_id = $input['video_id'];
                $videoLikeObj->counter = $input['counter'];
                $videoLikeObj->is_like = $input['is_like'];
                $videoLikeObj->save();
                $this->status = true;
                $this->data = ['likes' => $input['counter']];
                $this->message = "Like counter added.";
            }

            /**
             * User monthly videos like counter
             */
            $video_detail = Video::where('id', $request->video_id)->first();
            $this->userMonthlyVideosLikeCounter($video_detail->user_id, $input['is_like']);

            /**
             * Create list of liked video for user who like the video
             */
            // check if this video already likes
            $user_liked_video_list = UserMeta::where('user_id', Auth::user()->id)
                ->where('meta_key', 'liked_videos')
                ->first();

            if (isset($user_liked_video_list->meta_value)) {
                $liked_videos = $user_liked_video_list->meta_value;
                $liked_videos_arr = explode(',', $liked_videos);
                if (in_array($request->video_id, $liked_videos_arr)) {
                    if ($request->is_like == 0) {
                        if (($key = array_search($request->video_id, $liked_videos_arr)) !== false) {
                            unset($liked_videos_arr[$key]);
                        }
                        // $liked_videos_arr[] = $request->video_id;
                        $meta_value = implode(',', $liked_videos_arr);
                        $UserMetaObj = UserMeta::find($user_liked_video_list->id);
                        $UserMetaObj->meta_value = rtrim($meta_value, ',');
                        $UserMetaObj->save();
                    }
                } else {
                    if ($request->is_like == 1) {
                        $liked_videos_arr[] = $request->video_id;
                        $meta_value = implode(',', $liked_videos_arr);
                        $meta_value = rtrim($meta_value, ',');
                        $meta_value = ltrim($meta_value, ',');
                        $UserMetaObj = UserMeta::find($user_liked_video_list->id);
                        $UserMetaObj->meta_value = $meta_value;
                        $UserMetaObj->save();
                    }
                }
            } else {
                if ($request->is_like == 1) {

                    $liked_videos_arr = [];
                    $liked_videos_arr[] = $request->video_id;
                    $meta_value = implode(',', $liked_videos_arr);
                    $UserMetaObj = new UserMeta;
                    $UserMetaObj->user_id = Auth::user()->id;
                    $UserMetaObj->meta_key = 'liked_videos';
                    $UserMetaObj->meta_value = rtrim($meta_value, ',');
                    $UserMetaObj->save();
                }
            }


            // send push notification and record notification in table
            if ($request->is_like == 1) {
                $video_detail = Video::where('id', $request->video_id)->select('id', 'user_id')->first();
                // to be ensure, data is there
                if (isset($video_detail->id)) {
                    $live_notification_push = UserMeta::where('user_id', $video_detail->user_id)->where('meta_key', 'live_notification')->first();
                    if (!isset($live_notification_push->meta_value)) {
                        $live_notification_push = 1;
                    } else {
                        $live_notification_push = (int)$live_notification_push->meta_value;
                    }

                    $likes_push = UserMeta::where('user_id', $video_detail->user_id)->where('meta_key', 'likes')->first();
                    if (!isset($likes_push->meta_value)) {
                        $likes_push = 1;
                    } else {
                        $likes_push = (int)$likes_push->meta_value;
                    }
                    if ($live_notification_push === 1 && $likes_push === 1) {

                        $user_detail = User::where('id', $video_detail->user_id)->first();
                        $firebase_token = UserMeta::where('user_id', $user_detail->id)->where('meta_key', 'firebase_token')->select('id', 'meta_value')->first();

                        if (!empty($firebase_token->meta_value)) {
                            $NotificationObj = new Notification;
                            $NotificationObj->user_id = $user_detail->id;
                            $NotificationObj->video_id = $request->video_id;
                            $NotificationObj->title = "Video Liked";
                            $NotificationObj->body = "Someone liked your video.";
                            $NotificationObj->save();
                            $r = $this->send_push_notification("Video Liked", $firebase_token->meta_value, "Someone liked your video.");
                        }
                    }
                }
            }
        }
        return $this->jsonView();
    }

    private function userMonthlyVideosLikeCounter($user_id, $is_like)
    {
        $is_record_exits = UserActivityCounter::where('user_id', $user_id)->first();

        // get like counter
        $counter = (isset($is_record_exits['id']) && !empty($is_record_exits['id'])) ? $is_record_exits->like_counter : 0;
        // if user like the video
        if ($is_like == 1) {
            // increase like counter by 1
            $like_counter = $counter + 1;
        }
        // if user dislike the video and like counter must be greated then 0
        else if ($is_like == 0 && $counter > 0) {
            // descrease like counter by 1
            $like_counter = $counter - 1;
        }
        // if user dislike video and counter already 0
        else {
            // assign default counter value 0
            $like_counter = $counter;
        }

        // varaible
        $now = Carbon::now();
        $current_month      =   $now->month;
        $month_start_date   =   $now->startOfMonth()->format('Y-m-d');
        $month_end_date     =   $now->endOfMonth()->format('Y-m-d');
        if (isset($is_record_exits->id) && !empty($is_record_exits->id)) {
            // Update counter
            $UserActivityCounter                = UserActivityCounter::where('id', $is_record_exits->id)->first();
            $UserActivityCounter->like_counter  = $like_counter;
            $UserActivityCounter->save();
        } else {
            // insert record and update counter
            $UserActivityCounter = new UserActivityCounter;
            $UserActivityCounter->user_id = $user_id;
            $UserActivityCounter->month = $current_month;
            $UserActivityCounter->month_start_date = $month_start_date;
            $UserActivityCounter->month_end_date = $month_end_date;
            $UserActivityCounter->like_counter = $like_counter;
            $UserActivityCounter->view_counter = 0;
            $UserActivityCounter->invite_counter = 0;
            $UserActivityCounter->save();
        }
        return true;
    }
    private function userMonthlyVideosViewsCounter($user_id)
    {
        $is_record_exits = UserActivityCounter::where('user_id', $user_id)->first();

        // get like counter
        $counter = (isset($is_record_exits->view_counter) && !empty($is_record_exits->view_counter)) ? $is_record_exits->view_counter : 0;
        // varaible
        $now = Carbon::now();
        $current_month      =   $now->month;
        $month_start_date   =   $now->startOfMonth()->format('Y-m-d');
        $month_end_date     =   $now->endOfMonth()->format('Y-m-d');
        if (isset($is_record_exits->id) && !empty($is_record_exits->id)) {
            // Update counter
            $UserActivityCounter                = UserActivityCounter::where('id', $is_record_exits->id)->first();
            $UserActivityCounter->view_counter  = $counter + 1;
            $UserActivityCounter->save();
        } else {
            // insert record and update counter
            $UserActivityCounter = new UserActivityCounter;
            $UserActivityCounter->user_id = $user_id;
            $UserActivityCounter->month = $current_month;
            $UserActivityCounter->month_start_date = $month_start_date;
            $UserActivityCounter->month_end_date = $month_end_date;
            $UserActivityCounter->like_counter = 0;
            $UserActivityCounter->view_counter = 1;
            $UserActivityCounter->invite_counter = 0;
            $UserActivityCounter->save();
        }
        return true;
    }

    public function commentVideo(Request $request)
    {
        $rule = [
            'video_id' => 'required|exists:videos,id',
            'comment_by' => 'required|exists:users,id',
            'comment' => 'required',
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            // send push notification and record notification in table
            $video_detail = Video::where('id', $request->video_id)->select('id', 'user_id')->first();

            // check if user allowered everyone to comment on video
            $video_pushblisher_user_id = $video_detail->user_id;
            // get comment setting
            $is_comment_allowed = UserMeta::where('user_id', $video_pushblisher_user_id)->where('meta_key', 'safety_pref_who_comment_your_videos')->first();
            if (isset($is_comment_allowed->id)) {
                $comment_setting = strtolower($is_comment_allowed->meta_value);
                if ($comment_setting == 'followers') {
                    // if logged in user is its followers
                    $is_follower = Follower::where('publisher_user_id', $video_pushblisher_user_id)->where('follower_user_id', Auth::user()->id)->first();
                    if (!isset($is_follower->id)) {
                        $this->status = false;
                        $this->error = true;
                        $this->message = "Comment not allowed on this video";
                        $this->data = [];
                        return $this->jsonView();
                    }
                } else if ($comment_setting == 'me') {
                    if ($video_pushblisher_user_id != Auth::user()->id) {
                        $this->status = false;
                        $this->error = true;
                        $this->message = "Comment not allowed on this video";
                        $this->data = [];
                        return $this->jsonView();
                    }
                }
            }

            $this->status = true;
            $input = $data;
            $VideoComment = VideoComment::create($input);
            $this->data = $VideoComment;
            $this->message = "comment done.";

            // to be ensure, data is there
            if (isset($video_detail->id)) {
                $live_notification_push = UserMeta::where('user_id', $video_detail->user_id)->where('meta_key', 'live_notification')->first();
                if (!isset($live_notification_push->meta_value)) {
                    $live_notification_push = 1;
                } else {
                    $live_notification_push = (int)$live_notification_push->meta_value;
                }

                $comments_push = UserMeta::where('user_id', $video_detail->user_id)->where('meta_key', 'comments')->first();
                if (!isset($comments_push->meta_value)) {
                    $comments_push = 1;
                } else {
                    $comments_push = (int)$comments_push->meta_value;
                }

                if ($live_notification_push === 1 && $comments_push === 1) {
                    $user_detail = User::where('id', $video_detail->user_id)->first();
                    $firebase_token = UserMeta::where('user_id', $user_detail->id)->where('meta_key', 'firebase_token')->select('id', 'meta_value')->first();
                    if (!empty($firebase_token->meta_value)) {
                        $NotificationObj = new Notification;
                        $NotificationObj->user_id = $user_detail->id;
                        $NotificationObj->title = "Video comment";
                        $NotificationObj->video_id = $request->video_id;
                        $NotificationObj->body = "Someone comment on your video.";
                        $NotificationObj->save();
                        $this->send_push_notification("Video comment", $firebase_token->meta_value, "Someone comment on your video.");
                    }
                }
            }
        }
        return $this->jsonView();
    }

    public function viewVideo(Request $request)
    {
        $this->visibility = ['Public', 'Private'];
        $rule = [
            'video_id' => 'required|exists:videos,id',
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            $input = $data;
            // set counter if same user view the same video multiple times
            $is_viewed = VideoView::where('video_id', $input['video_id'])
                ->first();
            $counter = (isset($is_viewed->counter) && !empty($is_viewed->counter)) ? $is_viewed->counter : 0;

            if (isset($is_viewed->id) && !empty($is_viewed->id)) {
                $VideoView = VideoView::find($is_viewed->id);
                $VideoView->counter = $counter + 1;
                $VideoView->save();
                $this->status = true;
                $this->message = "View counter is updated.";
                $this->data = ['counter' => VideoView::where('video_id', $request->video_id)->first()->counter ?? 0];
            } else {
                // insert record
                $VideoView = new VideoView;
                $VideoView->video_id = $request->video_id;
                $VideoView->counter = $counter + 1;
                $VideoView->save();
                $this->status = true;
                $this->message = "View counter is created.";
                $this->data = ['counter' => VideoView::where('video_id', $request->video_id)->first()->counter ?? 0];
            }
            /**
             * User monthly video view counter
             */
            $video_detail = Video::where('id', $request->video_id)->first();
            $this->userMonthlyVideosViewsCounter($video_detail->user_id);
        }
        return $this->jsonView();
    }

    public function listCourse(Request $request)
    {
     
        $response = [];  
          $courses = \App\Models\Course::where(['visibility' => 'Public']);
			 if(isset(request()->category) && request()->category != ''){
				$courses = $courses->whereHas('cat_data', function($q) {
            $q->where('name', '=', request()->category);
            });
		}
		if(isset(request()->instructor)){
				$courses = $courses->whereIn('user_id',request()->instructor);
		}
		if(isset(request()->skill_level)){
				$courses = $courses->whereIn('skill_level',request()->skill_level);
		}
		if(isset(request()->price)){
			if(request()->price == 'All'){

			}else{
				$courses = $courses->where('price',request()->price);
			}
		}
				$courses = $courses->withCount('course_enroll_student')->with('course_owner',)->paginate(15)->toArray();
        

        return response()->json([
            'status' => true,
            'message' => 'OK',
            'data' => $courses,
            'error' => false,
        ]);
    }
    public function private(Request $request)
    {

        if (isset($request->user_id)) {
            $user_id = $request->user_id;
        } else {
            $user_id = Auth::user()->id;
        }

        $response = [];
        $videos = Video::where('visibility', 'Private')->where('user_id', $user_id)->orderByDesc('id')->get();

        $liked_videos_arr = [];
        $user_liked_video_list = UserMeta::where('user_id', $user_id)
            ->where('meta_key', 'liked_videos')
            ->first();
        if (isset($user_liked_video_list->meta_value)) {
            $liked_videos = $user_liked_video_list->meta_value;
            $liked_videos_arr = explode(',', $liked_videos);
        }



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

            $sound_owner_name = null;
            if (!empty($video->sound_owner)) {
                $sound_owner = User::find($video->sound_owner);
                if (isset($sound_owner->id)) {
                    $sound_owner_name = (!empty($sound_owner->name)) ? $sound_owner->name : $sound_owner->username;
                }
            }
            // get video like status
            $video_like_status = 0;
            if (in_array($video->id, $liked_videos_arr)) {
                $video_like_status = 1;
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
        return response()->json([
            'status' => true,
            'message' => 'OK',
            'data' => $response,
            'error' => false,
        ]);
    }


    public function deleteVideo(Request $request)
    {
        if ($this->validateData($request->all(), ['video_id' => 'required|exists:videos,id'])) {

            // check if logged in user is owner of this video
            $video = Video::find($request->video_id);
            if ($video->user_id !== Auth::user()->id) {
                $this->status = false;
                $this->error = true;
                $this->message = "You cannot delete other user's video.";
                $this->data = [];
                return $this->jsonView();
            }

            Video::destroy($request->video_id);
            $this->status = true;
            $this->error = false;
            $this->message = "Video has been deleted successfully.";
            $this->data = [];
        }
        return $this->jsonView();
    }

    public function publishPrivate(Request $request)
    {
        if ($this->validateData($request->all(), ['video_id' => 'required|exists:videos,id'])) {

            // check if logged in user is owner of this video
            $video = Video::find($request->video_id);
            if ($video->user_id !== Auth::user()->id) {
                $this->status = false;
                $this->error = true;
                $this->message = "You cannot publish other user's video.";
                $this->data = [];
                return $this->jsonView();
            }

            $video = Video::find($request->video_id);
            $video->visibility = 'Public';
            $video->save();

            $this->status = true;
            $this->error = false;
            $this->message = "Video is now public.";
            $this->data = [];
        }
        return $this->jsonView();
    }

    public function videoComments(Request $request)
    {
        $rule = [
            'course_id' => 'required|exists:course,id',
        ];
        if ($this->validateData($request->all(), $rule)) {
            $data = CourseComment::where('course_id',$course->id)->with('use_name')->get();

            $response = [];
            
            return response()->json([
                'status' => true,
                'message' => "OK",
                'data' => $data
            ]);
        }
        return $this->jsonView();
    }



    public function videoCommentLike(Request $request)
    {
        $rule = [
            'comment_id' => 'required|exists:video_comments,id',
            'is_like' => 'required',
        ];
        if ($this->validateData($request->all(), $rule)) {
            $CommentLike =  CommentLike::where('comment_id', $request->comment_id)->first();
            $counter = (!empty($CommentLike)) ? $CommentLike->counter : 0;

            if ($request->is_like == 1) {
                $input_counter = $counter + 1;
            } else if ($request->is_like == 0 && $counter > 0) {
                $input_counter = $counter - 1;
            } else {
                $input_counter = $counter;
            }

            if (!empty($CommentLike)) {
                // update
                $CommentLikeObj = CommentLike::find($CommentLike->id);
                // delete comment like_by
                $liked_by = explode(',', $CommentLikeObj->like_by);
                if ($request->is_like == 1 && ($key = array_search(Auth::user()->id, $liked_by) === false)) {
                    $CommentLikeObj->like_by .= ',' . Auth::user()->id;
                    $CommentLikeObj->counter = $input_counter;
                } else if ($request->is_like == 0 && $counter > 0 && ($key = array_search(Auth::user()->id, $liked_by) !== false)) {
                    array_splice($liked_by, $key, 1);
                    // unset($liked_by[$key]);
                    $CommentLikeObj->like_by = implode(',', $liked_by);
                    $CommentLikeObj->counter = $input_counter;
                } else {
                }
                $CommentLikeObj->save();
                $this->status = true;
                $this->data = ['likes' => $CommentLikeObj->counter];
                $this->message = "Liked updated.";
            } else {
                // insert
                $CommentLikeObj = new CommentLike;
                $CommentLikeObj->comment_id = $request->comment_id;
                // save comment like_by
                $liked_by = explode(',', $CommentLikeObj->like_by);
                if ($request->is_like == 1 && ($key = array_search(Auth::user()->id, $liked_by) === false)) {
                    $CommentLikeObj->like_by .= ',' . Auth::user()->id;
                }
                $CommentLikeObj->counter = $input_counter;
                $CommentLikeObj->save();
                $this->status = true;
                $this->data = ['likes' => $CommentLikeObj->counter];
                $this->message = "Liked added.";
            }
        }
        return $this->jsonView();
    }

    public function videoCommentLikeData()
    {
        $user_id = Auth::user()->id;
        $commentArr = [];
        $CommentLikeObj = CommentLike::all();
        foreach ($CommentLikeObj as $commentLike) {
            $liked_by = explode(',', $commentLike->like_by);
            if (($key = array_search(Auth::user()->id, $liked_by)) !== false) {
                array_push($commentArr, $commentLike);
            }
        }
        $response = collect();
        $response = $response->toBase()->merge($commentArr);
        $this->data = $response;
        $this->status = true;
        $this->message = "OK";
        return $this->jsonView();
    }

    public function getFieldData()
    {
        $response = [
            'languages' => Language::get(),
            'categories' => Categories::where('status', 1)->get(),
            'hashtags' => HashTag::get(),
        ];
        $this->status = true;
        $this->message = "OK";
        $this->data = $response;
        return $this->jsonView();
    }

    public function userVideos(Request $request)
    {
        if (isset($request->user_id)) {
            $user_id = $request->user_id;
        } else {
            $user_id = Auth::user()->id;
        }

        $response = [];
        $videos = Video::where('visibility', 'Public')->where('user_id', $user_id)->orderByDesc('id')->limit(20)->get();

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

        return response()->json([
            'status' => true,
            'message' => 'OK',
            'data' => $response,
            'error' => false,
        ]);
    }

    public function following()
    {
        $following_users = Follower::where('follower_user_id', Auth::user()->id)->get();
        $video_arr = [];
        if (!empty($following_users)) {
            foreach ($following_users as $user) {
                $publisher_user_id = $user->publisher_user_id;
                $videos = Video::where('user_id', $publisher_user_id)->inRandomOrder()->limit(2)->get();
                if (!empty($videos)) {
                    foreach ($videos as $video) {
                        // $video_arr[] = $video;

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

                        $sound_owner_name = null;
                        if (!empty($video->sound_owner)) {
                            $sound_owner = User::find($video->sound_owner);
                            if (isset($sound_owner->id)) {
                                $sound_owner_name = (!empty($sound_owner->name)) ? $sound_owner->name : $sound_owner->username;
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
        }
        shuffle($video_arr);
        array_slice($video_arr, 30);

        return response()->json([
            'status' => true,
            'message' => 'OK',
            'data' => $video_arr,
            'error' => false,
        ]);
    }

    public function popular()
    {
        $videos = VideoView::orderByDesc('counter')->limit(30)->get();
        $video_arr = [];
        if (!empty($videos)) {
            foreach ($videos as $video_a) {
                // $video_arr[] = Video::find($video->video_id);
                // $userde = User::find($video->user_id)->first();
                $video = Video::where('id', $video_a->video_id)->first();
                if (!isset($video->id)) {
                    continue;
                }
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
        return response()->json([
            'status' => true,
            'message' => 'OK',
            'data' => $video_arr,
            'error' => false,
        ]);
    }

    public function isVideoReported(Request $request)
    {
        $rule = [
            'video_id' => 'required|exists:videos,id',
            'reported_by' => 'required|exists:users,id',
        ];
        if ($this->validateData($request->all(), $rule)) {
            // check if already reported
            $report_data = ReportVideos::where('video_id', $request->video_id)->where('reported_by', $request->reported_by)->first();
            if (isset($report_data->id)) {
                $this->status = true;
                $this->error = false;
                $this->message =  "Video reported.";
                $this->data = [];
                return $this->jsonView();
            } else {
                $this->status = false;
                $this->error = true;
                $this->message =  "Video not reported.";
                $this->data = [];
                return $this->jsonView();
            }
        }
        return $this->jsonView();
    }

    public function report(Request $request)
    {
        $rule = [
            'video_id' => 'required|exists:videos,id',
            'reported_by' => 'required|exists:users,id',
            'reason' => 'required'
        ];
        if ($this->validateData($request->all(), $rule)) {
            // check if already reported
            $report_data = ReportVideos::where('video_id', $request->video_id)->where('reported_by', $request->reported_by)->first();
            if (isset($report_data->id)) {
                $this->status = false;
                $this->error = true;
                $this->message =  "You have already report this video.";
                $this->data = [];
                return $this->jsonView();
            }

            $ReportVideos = new ReportVideos;
            $ReportVideos->video_id = $request->video_id;
            $ReportVideos->reported_by = $request->reported_by;
            $ReportVideos->reason = $request->reason;
            $ReportVideos->save();
            $this->status = true;
            $this->error = false;
            $this->message =  "Video reported.";
            $this->data = [];
        }
        return $this->jsonView();
    }

    public function doFavUnfav(Request $request)
    {
        $rule = [
            'video_id' => 'required|exists:videos,id',
            'action' => [
                'required',
                Rule::in(['fav', 'unfav'])
            ],
        ];
        if ($this->validateData($request->all(), $rule)) {
            // check if try to mark fav to already fav
            if ($request->action == 'fav') {
                $fav_data = FavoriteVideos::where('video_id', $request->video_id)->where('user_id', Auth::user()->id)->first();
                if (isset($fav_data->id)) {
                    $this->status = false;
                    $this->error = true;
                    $this->message = "Already favorite";
                    $this->data = [];
                    return $this->jsonView();
                }
            }
            // check if try to mar unfav to already unfav
            if ($request->action == 'unfav') {
                $fav_data = FavoriteVideos::where('video_id', $request->video_id)->where('user_id', Auth::user()->id)->first();
                if (!isset($fav_data->id)) {
                    $this->status = false;
                    $this->error = true;
                    $this->message = "No favorite video to make unfavorite";
                    $this->data = [];
                    return $this->jsonView();
                }
            }


            if ($request->action == 'fav') {
                $FavoriteVideos = new FavoriteVideos;
                $FavoriteVideos->video_id = $request->video_id;
                $FavoriteVideos->user_id = Auth::user()->id;
                $FavoriteVideos->save();
                $this->status = true;
                $this->error = false;
                $this->message = "Video added to your favorite list";
                $this->data = [];
                return $this->jsonView();
            }

            if ($request->action == 'unfav') {
                FavoriteVideos::where('video_id', $request->video_id)->where('user_id', Auth::user()->id)->delete();
                $this->status = true;
                $this->error = false;
                $this->message = "Video removed from your favorite list";
                $this->data = [];
                return $this->jsonView();
            }
        }
        return $this->jsonView();
    }

    public function favoriteVideos()
    {
        $videos = FavoriteVideos::where('user_id', Auth::user()->id)->get();
        $response = [];
        foreach ($videos as $video_d) {
            $video = Video::find($video_d->video_id);
            if (!isset($video->id)) {
                continue;
            }
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
                'sound' => $video->sound ?? null,
                'sound_name' => $video->sound_name ?? null,
                'sound_category_name' => $sound_category->name ?? null,
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
        return response()->json([
            'status' => true,
            'error' => false,
            'message' => 'Favorite video list',
            'data' => $response
        ]);
    }

    public function changeVisibility(Request $request)
    {
        $rule = [
            'video_id' => 'required|exists:videos,id',
            'visibility' => [
                'required',
                Rule::in(['Public', 'Private'])
            ],
        ];
        if ($this->validateData($request->all(), $rule)) {
            $VideoObj = Video::where('id', $request->video_id)->where('user_id', Auth::user()->id)->first();
            if (isset($VideoObj->id)) {
                $VideoObj->visibility = $request->visibility;
                $VideoObj->save();
                $this->status = true;
                $this->error = false;
                $this->message =  "OK";
                $this->data = [];
            } else {
                $this->status = false;
                $this->error = true;
                $this->message =  "Invalid user";
                $this->data = [];
            }
        }
        return $this->jsonView();
    }
}
