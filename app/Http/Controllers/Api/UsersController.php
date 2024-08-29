<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserMeta;
use App\Models\Follower;
use App\Models\Video;
use App\Models\VideoLike;
use App\Models\VideoView;
use App\Models\UserActivityCounter;
use App\Models\AdminNotification;
use App\Models\RequestVerifications;
use App\Models\Notification;
use App\Models\Sound;
use App\Models\SoundCategory;
use App\Models\VideoComment;
use App\Models\BlockedUser;
use App\Models\ReportedUser;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\UserObj;
use App\Models\Level;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;

use Kreait\Firebase\Contract\Database;

class UsersController extends ApiController
{

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function edit(Request $request)
    {
        $rule = [
            'avatar' => 'nullable|mimes:png,jpg,jpeg,gif|max:2048',
            'username' => [
                'nullable',
                'alpha_dash',
                Rule::unique('users')->ignore(Auth::user()->id)
            ],
            'gender' => [
                'nullable',
                Rule::In(['Male', 'Female', 'Other'])
            ]
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            $userObj = User::find(Auth::user()->id);
            $input = $data;
            if ($filed = $request->hasfile('avatar')) {
                $filed      = $request->file('avatar');
                $named      = 'profile_images' . time() . '.' . $filed->getClientOriginalExtension();
                Storage::disk('profile_images')->put($named, file_get_contents($filed->getRealPath()));
                $input['avatar'] = $named;
                $userObj->avtars = $input['avatar'];
            }
            if (isset($input['username']) && !empty($input['username'])) {
                $is_user_exits = User::where('username', $input['username'])->where('id', '!=', Auth::user()->id)->first();
                if (isset($is_user_exits->id)) {
                    $this->status = false;
                    $this->error = true;
                    $this->message = "This username is already taken.";
                    $this->data = [];
                    return $this->jsonView();
                } else {
                    $userObj->username = $input['username'];
                }
            }
            if (!empty($input['name'])) {
                $userObj->name = $input['name'];
            }
            if (!empty($input['dob'])) {
                $userObj->dob = $input['dob'];
            }
            if (!empty($input['location'])) {
                $userObj->location = $input['location'];
            }
            if (!empty($input['phone'])) {
                $is_phone_exits = User::where('phone', $input['phone'])->where('id', '!=', Auth::user()->id)->first();
                if (isset($is_phone_exits->id)) {
                    $this->status = false;
                    $this->error = true;
                    $this->message = "This phone number already taken";
                    $this->data = [];
                    return $this->jsonView();
                }
                $userObj->phone = $input['phone'];
            }
            $userObj->save();

            // $referral_count = DB::table('user_activity_counters')
            //     ->select(DB::raw('SUM(invite_counter) as referral_count'))
            //     ->where('user_id', Auth()->user()->id)
            //     ->first();

            if (isset($input['first_name']) && !empty($input['first_name'])) {
                DB::table('user_metas')
                    ->updateOrInsert(
                        ['user_id' => Auth()->user()->id, 'meta_key' => 'first_name'],
                        ['meta_value' => $request->first_name]
                    );
            }

            if (isset($input['last_name']) && !empty($input['last_name'])) {
                DB::table('user_metas')
                    ->updateOrInsert(
                        ['user_id' => Auth()->user()->id, 'meta_key' => 'last_name'],
                        ['meta_value' => $request->last_name]
                    );
            }

            if (isset($input['gender']) && !empty($input['gender'])) {
                DB::table('user_metas')
                    ->updateOrInsert(
                        ['user_id' => Auth()->user()->id, 'meta_key' => 'gender'],
                        ['meta_value' => $request->gender]
                    );
            }

            if (isset($input['website_url']) && !empty($input['website_url'])) {
                DB::table('user_metas')
                    ->updateOrInsert(
                        ['user_id' => Auth()->user()->id, 'meta_key' => 'website_url'],
                        ['meta_value' => $request->website_url]
                    );
            }

            if (isset($input['bio']) && !empty($input['bio'])) {
                DB::table('user_metas')
                    ->updateOrInsert(
                        ['user_id' => Auth()->user()->id, 'meta_key' => 'bio'],
                        ['meta_value' => $request->bio]
                    );
            }

            if (isset($input['youtube']) && !empty($input['youtube'])) {
                DB::table('user_metas')
                    ->updateOrInsert(
                        ['user_id' => Auth()->user()->id, 'meta_key' => 'youtube'],
                        ['meta_value' => $request->youtube]
                    );
            }

            if (isset($input['facebook']) && !empty($input['facebook'])) {
                DB::table('user_metas')
                    ->updateOrInsert(
                        ['user_id' => Auth()->user()->id, 'meta_key' => 'facebook'],
                        ['meta_value' => $request->facebook]
                    );
            }

            if (isset($input['instagram']) && !empty($input['instagram'])) {
                DB::table('user_metas')
                    ->updateOrInsert(
                        ['user_id' => Auth()->user()->id, 'meta_key' => 'instagram'],
                        ['meta_value' => $request->instagram]
                    );
            }

            if (isset($input['twitter']) && !empty($input['twitter'])) {
                DB::table('user_metas')
                    ->updateOrInsert(
                        ['user_id' => Auth()->user()->id, 'meta_key' => 'twitter'],
                        ['meta_value' => $request->twitter]
                    );
            }

            if (isset($input['firebase_token']) && !empty($input['firebase_token'])) {
                DB::table('user_metas')
                    ->updateOrInsert(
                        ['user_id' => Auth()->user()->id, 'meta_key' => 'firebase_token'],
                        ['meta_value' => $request->firebase_token]
                    );
            }

            $userde = User::find(Auth()->user()->id);

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
            if (empty($creators_current_level)) {
                $creators_current_level = '0';
            }
            $creators_next_level = $creators_next_level_arr[count($creators_next_level_arr) - 1];
            if (empty($creators_next_level)) {
                $creators_next_level = '1';
            }

            $rv = RequestVerifications::where('user_id', $userde->id)->first();
            if (isset($rv->id)) {
                $rv = (string)$rv->is_verified;
            } else {
                $rv = '0';
            }


            // check if referral code created already
            $um_referral_code = UserMeta::where('meta_key', 'referral_code')
                ->where('user_id', $userde->id)
                ->first();

            if (!empty($um_referral_code->meta_value)) {
                $referral_code = $um_referral_code->meta_value;
            } else {
                // Generate unique code and same in user meta
                $referral_code = $this->generateUniqueCode();
                DB::table('user_metas')
                    ->updateOrInsert(
                        ['user_id' => $userde->id, 'meta_key' => 'referral_code'],
                        ['meta_value' => $referral_code]
                    );
            }

            $response['user'] = [
                'id' => $userde->id,
                'name' => $userde->name,
                'username' => $userde->username,
                'email' => (empty($userde->social_login_id)) ? NULL : $userde->email,
                'dob' => $userde->dob,
                'phone' => $userde->phone,
                'avatar' => $userde->avtars,
                'location' => $userde->location,
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
                'is_verified' => $rv,
                'levels' => [
                    'current' =>  (string)$creators_current_level ?? '0',
                    'next' => (string)$creators_next_level ?? '0',
                    'progress' => '50'
                ],
                'total_videos' => (string)Video::where('user_id', $userde->id)->count(),
                'box_two' => '0',
                'box_three' => '0',
                'referral_code' => $referral_code
            ];
            return response()->json([
                'status' => true,
                'error' => false,
                'message' => 'Your profile has been updated successfully.',
                'data' => $response
            ]);



            // // check if referral code created already
            // $um_referral_code = UserMeta::where('meta_key', 'referral_code')
            //     ->where('user_id', Auth()->user()->id)
            //     ->first();

            // if (!empty($um_referral_code->meta_value)) {
            //     $referral_code = $um_referral_code->meta_value;
            // } else {
            //     // Generate unique code and same in user meta
            //     $referral_code = $this->generateUniqueCode();
            //     DB::table('user_metas')
            //         ->updateOrInsert(
            //             ['user_id' => Auth()->user()->id, 'meta_key' => 'referral_code'],
            //             ['meta_value' => $referral_code]
            //         );
            // }

            // $response['user'] = [
            //     'id' => $userde->id,
            //     'name' => $userde->name,
            //     'username' => $userde->username,
            //     'email' => (empty($userde->social_login_id)) ? NULL : $userde->email,
            //     'dob' => $userde->dob,
            //     'phone' => $userde->phone,
            //     'avatar' => $userde->avtars,
            //     'social_login_id' => $userde->social_login_id,
            //     'social_login_type' => $userde->social_login_type,
            //     'first_name' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'first_name')->first()->meta_value ?? NULL,
            //     'last_name' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'last_name')->first()->meta_value ?? NULL,
            //     'gender' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'gender')->first()->meta_value ?? NULL,
            //     'website_url' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'website_url')->first()->meta_value ?? NULL,
            //     'bio' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'bio')->first()->meta_value ?? NULL,
            //     'youtube' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'youtube')->first()->meta_value ?? NULL,
            //     'facebook' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'facebook')->first()->meta_value ?? NULL,
            //     'instagram' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'instagram')->first()->meta_value ?? NULL,
            //     'twitter' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'twitter')->first()->meta_value ?? NULL,
            //     'firebase_token' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'firebase_token')->first()->meta_value ?? NULL,
            //     'referral_count' => (string)$referral_count->referral_count ?? '0',
            //     'following' => (string)Follower::where('follower_user_id', $userde->id)->count() ?? '0',
            //     'followers' => (string)Follower::where('publisher_user_id', $userde->id)->count() ?? '0',
            //     'likes' => (string)$likes->likes ?? '0',
            //     'is_verified' => $rv,
            //     'levels' => [
            //         'current' =>  (string)$creators_current_level ?? '0',
            //         'next' => (string)$creators_next_level ?? '0',
            //         'progress' => '50'
            //     ],
            //     'total_videos' => (string)Video::where('user_id', $userde->id)->count(),
            //     'box_two' => '0',
            //     'box_three' => '0',
            //     'referral_code' => $referral_code
            // ];


            // $user_details_arr = [
            //     'id' => $userObj->id,
            //     'name' => $userObj->name,
            //     'username' => $userObj->username,
            //     'email' => (empty($userObj->social_login_id)) ? NULL : $userObj->email,
            //     'dob' => $userObj->dob,
            //     'phone' => $userObj->phone,
            //     'avatar' => $userObj->avtars,
            //     'social_login_id' => $userObj->social_login_id,
            //     'social_login_type' => $userObj->social_login_type,
            //     'first_name' => UserMeta::where('user_id', $userObj->id)->where('meta_key', 'first_name')->first()->meta_value ?? NULL,
            //     'last_name' => UserMeta::where('user_id', $userObj->id)->where('meta_key', 'last_name')->first()->meta_value ?? NULL,
            //     'gender' => UserMeta::where('user_id', $userObj->id)->where('meta_key', 'gender')->first()->meta_value ?? NULL,
            //     'website_url' => UserMeta::where('user_id', $userObj->id)->where('meta_key', 'website_url')->first()->meta_value ?? NULL,
            //     'bio' => UserMeta::where('user_id', $userObj->id)->where('meta_key', 'bio')->first()->meta_value ?? NULL,
            //     'youtube' => UserMeta::where('user_id', $userObj->id)->where('meta_key', 'youtube')->first()->meta_value ?? NULL,
            //     'facebook' => UserMeta::where('user_id', $userObj->id)->where('meta_key', 'facebook')->first()->meta_value ?? NULL,
            //     'instagram' => UserMeta::where('user_id', $userObj->id)->where('meta_key', 'instagram')->first()->meta_value ?? NULL,
            //     'twitter' => UserMeta::where('user_id', $userObj->id)->where('meta_key', 'twitter')->first()->meta_value ?? NULL,
            //     'firebase_token' => UserMeta::where('user_id', $userObj->id)->where('meta_key', 'firebase_token')->first()->meta_value ?? NULL,
            //     'referral_code' => $referral_code
            // ];
            // $userFieldsObj = new UserObj($user_details_arr);
            // $this->status = true;
            // $this->message = "Your profile is updated successfully";
            // $this->data = ['user' => $userFieldsObj];
        }
        return $this->jsonView();
    }

    public function getProfile(Request $request)
    {
        $rule = [
            'id' => 'required|exists:users',
        ];
        if ($this->validateData($request->all(), $rule)) {

            $progress = 0;

            $userde = User::find($request->id);

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
            if (empty($creators_current_level)) {
                $creators_current_level = '0';
            }
            $creators_next_level = $creators_next_level_arr[count($creators_next_level_arr) - 1];
            if (empty($creators_next_level)) {
                $creators_next_level = '1';
            }

            $next_level_details = Level::find($creators_next_level);
            $final_target = $next_level_details->likes;
            $current_likes = $this->get_current_likes(Auth::user()->id);
            if ($final_target < 1) {
                $progress = 0;
            } else {
                $progress = (int)round(($current_likes / $final_target) * 10);
            }

            $rv = RequestVerifications::where('user_id', $userde->id)->first();
            if (isset($rv->id)) {
                $rv = (string)$rv->is_verified;
            } else {
                $rv = '0';
            }

            // creators max levels
            $creators_levels = Level::where('activity_id', 1)->count();


            // check if referral code created already
            $um_referral_code = UserMeta::where('meta_key', 'referral_code')
                ->where('user_id', $userde->id)
                ->first();

            if (!empty($um_referral_code->meta_value)) {
                $referral_code = $um_referral_code->meta_value;
            } else {
                // Generate unique code and same in user meta
                $referral_code = $this->generateUniqueCode();
                DB::table('user_metas')
                    ->updateOrInsert(
                        ['user_id' => $userde->id, 'meta_key' => 'referral_code'],
                        ['meta_value' => $referral_code]
                    );
            }

            $response['user'] = [
                'id' => $userde->id,
                'name' => $userde->name,
                'username' => $userde->username,
                'email' => (empty($userde->social_login_id)) ? NULL : $userde->email,
                'dob' => $userde->dob,
                'phone' => $userde->phone,
                'avatar' => $userde->avtars,
                'location' => $userde->location,
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
                'is_verified' => $rv,
                'levels' => [
                    'current' =>  (string)$creators_current_level ?? '0',
                    'next' => (string)$creators_next_level ?? '0',
                    'progress' => (string)$progress,
                    'max_level' => (string)$creators_levels ?? '0',
                ],
                'total_videos' => (string)Video::where('user_id', $userde->id)->count(),
                'box_two' => '0',
                'box_three' => '0',
                'referral_code' => $referral_code
            ];
            return response()->json([
                'status' => true,
                'error' => false,
                'message' => 'OK',
                'data' => $response
            ]);
        }
        return $this->jsonView();
    }

    public function followUnfollowUser(Request $request)
    {
        $rule = [
            'publisher_user_id' => 'required|exists:users,id|numeric|min:1|max:99999999999999999999',
            'action' => [
                'required',
                'alpha',
                Rule::in(['follow', 'unfollow'])
            ]
        ];

        if ($this->validateData($request->all(), $rule)) {
            $otherUserData = User::find($request->publisher_user_id);
            if ($request->action == 'follow') {
                $followersObj = Follower::where('publisher_user_id', $request->publisher_user_id)
                    ->where('follower_user_id', Auth::user()->id)
                    ->first();

                if (isset($followersObj->id) && !empty($followersObj)) {
                    $this->status = false;
                    $this->error = true;
                    $this->message = "You have already followed this publisher: {$otherUserData->name}";
                    $this->data = [];
                    return $this->jsonView();
                }
                // Create record in followers table
                $followersObj = new Follower;
                $followersObj->publisher_user_id  =     $request->publisher_user_id;
                $followersObj->follower_user_id   =     Auth::user()->id;
                $followersObj->save();
                $this->status = true;
                $this->message = "You are now follower of this publisher: {$otherUserData->name}.";
                $this->data = [];

                // send push notification and record notification in table
                // to be ensure, data is there
                if (!empty($request->publisher_user_id)) {

                    $live_notification_push = UserMeta::where('user_id', $request->publisher_user_id)->where('meta_key', 'live_notification')->first();
                    if (!isset($live_notification_push->meta_value)) {
                        $live_notification_push = 1;
                    } else {
                        $live_notification_push = (int)$live_notification_push->meta_value;
                    }

                    $new_followers_push = UserMeta::where('user_id', $request->publisher_user_id)->where('meta_key', 'new_followers')->first();
                    if (!isset($new_followers_push->meta_value)) {
                        $new_followers_push = 1;
                    } else {
                        $new_followers_push = (int)$new_followers_push->meta_value;
                    }

                    if ($live_notification_push === 1 && $new_followers_push === 1) {
                        $user_detail = User::where('id', $request->publisher_user_id)->first();
                        $firebase_token = UserMeta::where('user_id', $user_detail->id)->where('meta_key', 'firebase_token')->select('id', 'meta_value')->first();
                        if (!empty($firebase_token->meta_value)) {
                            $follower_detail = User::where('id', Auth::user()->id)->first();
                            $NotificationObj = new Notification;
                            $NotificationObj->user_id = $user_detail->id;
                            $NotificationObj->other_id = Auth::user()->id;
                            $NotificationObj->title = "New follower";
                            $NotificationObj->body = "{$follower_detail->name} has now started following you.";
                            $NotificationObj->save();
                            $this->send_push_notification("New follower", $firebase_token->meta_value, "{$follower_detail->name} has now started following you.");
                        }
                    }
                }
            } else if ($request->action == 'unfollow') {
                // delete record from followers table
                $followersObj = Follower::where('publisher_user_id', $request->publisher_user_id)
                    ->where('follower_user_id', Auth::user()->id)
                    ->first();
                if (isset($followersObj->id) && !empty($followersObj)) {
                    $followersObj->delete();
                }
                $this->status = true;
                $this->message = "You are now no longer a follower of this publisher: {$otherUserData->name}.";
                $this->data = [];
                // send push notification and record notification in table
                // to be ensure, data is there
                // if (!empty($request->publisher_user_id)) {
                //     $live_notification_push = UserMeta::where('user_id', $request->publisher_user_id)->where('meta_key', 'live_notification')->first();
                //     if (!isset($live_notification_push->meta_value)) {
                //         $live_notification_push = 1;
                //     } else {
                //         $live_notification_push = (int)$live_notification_push->meta_value;
                //     }

                //     $new_followers_push = UserMeta::where('user_id', $request->publisher_user_id)->where('meta_key', 'new_followers')->first();
                //     if (!isset($new_followers_push->meta_value)) {
                //         $new_followers_push = 1;
                //     } else {
                //         $new_followers_push = (int)$new_followers_push->meta_value;
                //     }


                //     if ($live_notification_push === 1 && $new_followers_push === 1) {
                //         $user_detail = User::where('id', $request->publisher_user_id)->first();
                //         $firebase_token = UserMeta::where('user_id', $user_detail->id)->where('meta_key', 'firebase_token')->select('id', 'meta_value')->first();
                //         if (!empty($firebase_token->meta_value)) {
                //             $follower_detail = User::where('id', Auth::user()->id)->first();
                //             $NotificationObj = new Notification;
                //             $NotificationObj->user_id = $user_detail->id;
                //             $NotificationObj->title = "Unfollow";
                //             $NotificationObj->body = "{$follower_detail->name} has unfollowed you.";
                //             $NotificationObj->save();
                //             $this->send_push_notification("Unfollow", $firebase_token->meta_value, "{$follower_detail->name} has unfollowed you.");
                //         }
                //     }
                // }
            } else {
                $this->status = false;
                $this->error = true;
                $this->message = "No action defined.";
                $this->data = [];
            }
        }

        return $this->jsonView();
    }

    public function pushNotificationSettingsSave(Request $request)
    {
        $rule = [
            'type' => [
                'required'
            ],
            'action' => [
                'required',
                Rule::In([0, 1])
            ],
        ];
        if ($this->validateData($request->all(), $rule)) {
            $UserMetaObj = UserMeta::where('user_id', Auth::user()->id)->where('meta_key', $request->type)->first();
            if (isset($UserMetaObj->id)) {
                // update
                $UserMetaObj = UserMeta::find($UserMetaObj->id);
                $UserMetaObj->meta_value = $request->action;
                $UserMetaObj->save();
            } else {
                $UserMetaObj = new UserMeta;
                $UserMetaObj->user_id = Auth::user()->id;
                $UserMetaObj->meta_key = $request->type;
                $UserMetaObj->meta_value = $request->action;
                $UserMetaObj->save();
            }
            $this->status = true;
            $this->message = "User notification settings";
            $this->data = [
                $request->type => UserMeta::where('user_id', Auth::user()->id)->where('meta_key', $request->type)->first()->meta_value ?? '0'
            ];
        }
        return $this->jsonView();
    }

    public function pushNotificationSettingsGet()
    {
        $this->status = true;
        $this->message = "Notification settings";
        $type_arr = ['likes', 'comments', 'new_followers', 'mentions', 'direct_messages', 'video_from_accounts_you_follow', 'live_notification'];

        // if not created already, then Create setting in user meta table and assign 1 be default
        foreach ($type_arr as $type) {
            $meta_likes = UserMeta::where('user_id', Auth::user()->id)->where('meta_key', $type)->first();
            if (!isset($meta_likes->id)) {
                $UserMetaObj = new UserMeta;
                $UserMetaObj->user_id = Auth::user()->id;
                $UserMetaObj->meta_key = $type;
                $UserMetaObj->meta_value = 1;
                $UserMetaObj->save();
            }
        }
        $this->data = [
            'likes' => UserMeta::where('user_id', Auth::user()->id)->where('meta_key', 'likes')->first()->meta_value ?? '1',
            'comments' => UserMeta::where('user_id', Auth::user()->id)->where('meta_key', 'comments')->first()->meta_value ?? '1',
            'new_followers' => UserMeta::where('user_id', Auth::user()->id)->where('meta_key', 'new_followers')->first()->meta_value ?? '1',
            'mentions' => UserMeta::where('user_id', Auth::user()->id)->where('meta_key', 'mentions')->first()->meta_value ?? '1',
            'direct_messages' => UserMeta::where('user_id', Auth::user()->id)->where('meta_key', 'direct_messages')->first()->meta_value ?? '1',
            'video_from_accounts_you_follow' => UserMeta::where('user_id', Auth::user()->id)->where('meta_key', 'video_from_accounts_you_follow')->first()->meta_value ?? '1',
            'live_notification' => UserMeta::where('user_id', Auth::user()->id)->where('meta_key', 'live_notification')->first()->meta_value ?? '1',
        ];
        return $this->jsonView();
    }

    public function userLikedVideos(Request $request)
    {
        if (isset($request->user_id)) {
            $user_id = $request->user_id;
        } else {
            $user_id = Auth::user()->id;
        }

        $liked_videos = UserMeta::where('user_id', $user_id)
            ->where('meta_key', 'liked_videos')
            ->first();

        $video_arr = [];
        if (!empty($liked_videos->meta_value)) {
            $liked_videos = explode(',', $liked_videos->meta_value);


            foreach ($liked_videos as $videoD) {
                $video = Video::find($videoD);

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
            'error' => false,
            'message' => "User liked videos list.",
            'data' => $video_arr
        ]);
    }

    public function deactivateAccountRequest()
    {
        $UserObj = User::find(Auth::user()->id);

        if (isset($UserObj->id) && $UserObj->deactivation_request == 1) {
            $this->status = false;
            $this->error = true;
            $this->message = "Already your request for account deactivation has been received.";
            $this->data = [];
            return $this->jsonView();
        }

        if (isset($UserObj->id)) {
            $UserObj->deactivation_request = 1;
            $UserObj->save();
            $this->status = true;
            $this->error = false;
            $this->message = "Your request for account deactivation has been received.";
            $this->data = [];

            $AdminNotification = new AdminNotification;
            $AdminNotification->title = "User: {$UserObj->username} ID: {$UserObj->id} has requested to deactivate account.";
            $AdminNotification->save();
        } else {
            $this->status = false;
            $this->error = true;
            $this->message = "Unable to process this request now. Please try again later or contact to admin.";
            $this->data = [];
        }
        return $this->jsonView();
    }

    public function safetyPreferenceList()
    {
        $this->status = true;
        $this->error = false;
        $this->message = "User safety preference list";
        $this->data = [
            'safety_pref_allow_video_download' => UserMeta::where('user_id', Auth::user()->id)->where('meta_key', 'safety_pref_allow_video_download')->first()->meta_value ?? 'Off',
            'safety_pref_who_send_direct_message' => UserMeta::where('user_id', Auth::user()->id)->where('meta_key', 'safety_pref_who_send_direct_message')->first()->meta_value ?? 'Everyone',
            'safety_pref_who_view_your_videos' => UserMeta::where('user_id', Auth::user()->id)->where('meta_key', 'safety_pref_who_view_your_videos')->first()->meta_value ?? 'Everyone',
            'safety_pref_who_comment_your_videos' => UserMeta::where('user_id', Auth::user()->id)->where('meta_key', 'safety_pref_who_comment_your_videos')->first()->meta_value ?? 'Everyone',
            'who_can_duet_with_your_videos' => UserMeta::where('user_id', Auth::user()->id)->where('meta_key', 'who_can_duet_with_your_videos')->first()->meta_value ?? 'Everyone',
            'who_can_view_your_liked_videos' => UserMeta::where('user_id', Auth::user()->id)->where('meta_key', 'who_can_view_your_liked_videos')->first()->meta_value ?? 'Everyone',
        ];
        return $this->jsonView();
    }

    public function safetyPreferenceSave(Request $request)
    {
        $rule = [
            'type' => [
                'required'
            ],
            'action' => [
                'required'
            ],
        ];
        if ($this->validateData($request->all(), $rule)) {
            $UserMetaObj = UserMeta::where('user_id', Auth::user()->id)->where('meta_key', $request->type)->first();
            if (isset($UserMetaObj->id)) {
                // update
                $UserMetaObj = UserMeta::find($UserMetaObj->id);
                $UserMetaObj->meta_value = $request->action;
                $UserMetaObj->save();
            } else {
                $UserMetaObj = new UserMeta;
                $UserMetaObj->user_id = Auth::user()->id;
                $UserMetaObj->meta_key = $request->type;
                $UserMetaObj->meta_value = $request->action;
                $UserMetaObj->save();
            }
            $this->status = true;
            $this->message = "User safety preference";
            $this->data = [
                $request->type => UserMeta::where('user_id', Auth::user()->id)->where('meta_key', $request->type)->first()->meta_value ?? '0'
            ];
        }
        return $this->jsonView();
    }

    public function requestVerification(Request $request)
    {
        $rule = [
            'username' => 'required|exists:users,username',
            'full_name' => 'required',
            'file' => 'required|image|max:2048'
        ];
        if ($this->validateData($request->all(), $rule)) {
            $is_request_already = RequestVerifications::where('user_id', Auth::user()->id)->first();
            if (isset($is_request_already->id)) {
                $this->status = false;
                $this->error = true;
                $this->message = "Request is already sent.";
                $this->data = [];
                return $this->jsonView();
            }

            $named = '';
            if ($filed = $request->hasfile('file')) {
                $filed      = $request->file('file');
                $named      = 'profile_images' . time() . '.' . $filed->getClientOriginalExtension();
                Storage::disk('profile_images')->put($named, file_get_contents($filed->getRealPath()));
            }

            $RequestVerificationsObj = new RequestVerifications;
            $RequestVerificationsObj->user_id = Auth::user()->id;
            $RequestVerificationsObj->username = $request->username;
            $RequestVerificationsObj->full_name = $request->full_name;
            $RequestVerificationsObj->file = $named;
            $RequestVerificationsObj->save();

            $this->status = true;
            $this->error = false;
            $this->message = "Request sent";
            $this->data = [];
        }
        return $this->jsonView();
    }

    public function checkUserStatus(Request $request)
    {
        if (isset(Auth::user()->id)) {
            $user = User::where('id', Auth::user()->id)->first();
            if (isset($user->status)) {
                $status = $user->status == 'active' ? 1 : 0;
            }
        } else {
            $status = 0;
        }
        $this->status = true;
        $this->error = false;
        $this->message = "User status";
        $this->data = [
            'status' => $status
        ];
        return $this->jsonView();
    }

    public function notificationList()
    {
        $notificationObj = Notification::where('user_id', Auth::user()->id)->with('user_details')->with('other_user_details')->orderByDesc('id')->get();
        foreach ($notificationObj as $obj) {
            if ($obj->title == 'New follower' || $obj->title == 'Unfollow') {
                $redirectTo = 'user';
            } elseif ($obj->title == 'Video Liked' || $obj->title == 'New video') {
                $redirectTo = 'video';
            } elseif ($obj->title == 'Video comment') {
                $redirectTo = 'comment';
            } else {
                $redirectTo = null;
            }
            data_set($obj, 'redirect_type', $redirectTo);

            $is_video_exits = Video::where('visibility', 'Public')->where('id', $obj->video_id)->orderByDesc('id')->first();

            if ($obj->video_id !== null && isset($is_video_exits->id)) {

                $video = Video::where('visibility', 'Public')->where('id', $obj->video_id)->orderByDesc('id')->first();

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

                $response = [
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
                data_set($obj, 'video_details', $response);
            } else {
                data_set($obj, 'video_details', null);
            }
        }
        $this->status = true;
        $this->error = false;
        $this->data = $notificationObj ?? [];
        $this->message = "Notification list!!!";
        return $this->jsonView();
    }

    public function chatInbox()
    {
        $secondUser = [];
        $reference = $this->database->getReference('chats');
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();
        if (!empty($value)) {
            foreach ($value as $key => $node) {
                $users = explode('_', $key);
                if ($users[0] == Auth::user()->id) {
                    $user = User::where('id', $users[1])->select('id', 'avtars as user_image', 'name')->first();
                    $lastChat = last($node);
                    data_set($user, 'message', $lastChat['message']);
                    data_set($user, 'time', $lastChat['time']);
                    array_push($secondUser, $user);
                    continue;
                }
                if ($users[1] == Auth::user()->id) {
                    $user = User::where('id', $users[0])->select('id', 'avtars as user_image', 'name')->first();
                    $lastChat = last($node);
                    data_set($user, 'message', $lastChat['message']);
                    data_set($user, 'time', $lastChat['time']);
                    array_push($secondUser, $user);
                    continue;
                }
            }
        }
        $this->data = $secondUser;
        return response()->json([
            'status' => true,
            'message' => "chat inbox",
            'error' => false,
            'data' => $secondUser
        ]);
    }

    public function getFollowers(Request $request)
    {
        if (isset($request->user_id)) {
            $user_id = $request->user_id;
        } else {
            $user_id = Auth::user()->id;
        }
        $followers = Follower::where('publisher_user_id', $user_id)->get();
        $user_arr = [];
        if (!empty($followers)) {
            foreach ($followers as $follower) {
                $user_arr[] = User::find($follower->follower_user_id);
            }
        }

        return response()->json([
            'status' => true,
            'error' => false,
            'message' => "Followers list",
            'data' => $user_arr
        ]);
    }

    // whom he follow
    public function getFollowings(Request $request)
    {
        if (isset($request->user_id)) {
            $user_id = $request->user_id;
        } else {
            $user_id = Auth::user()->id;
        }

        $followings = Follower::where('follower_user_id', $user_id)->get();

        $user_arr = [];
        if (!empty($followings)) {
            foreach ($followings as $follower) {
                $user_arr[] = User::find($follower->publisher_user_id);
            }
        }

        return response()->json([
            'status' => true,
            'error' => false,
            'message' => "Followings list",
            'data' => $user_arr
        ]);
    }

    public function doBlockUnblockUser(Request $request)
    {
        $rule = [
            'blocked_user' => 'required|exists:users,id',
            'action' => [
                'required',
                Rule::In(["Block", "Unblock"])
            ]
        ];
        if ($this->validateData($request->all(), $rule)) {
            // check if already blocked
            if ($request->action == "Block") {
                $blocked_data = BlockedUser::where('blocked_user', $request->blocked_user)->where('blocked_by', Auth::user()->id)->first();
                if (isset($blocked_data->id)) {
                    return response()->json([
                        'status' => false,
                        'error' => true,
                        'message' => "You have already blocked this user",
                        'data' => []
                    ]);
                }
            }

            // if try to unblock someone who is not blocked.
            if ($request->action == "Unblock") {
                $blocked_data = BlockedUser::where('blocked_user', $request->blocked_user)->where('blocked_by', Auth::user()->id)->first();
                if (!isset($blocked_data->id)) {
                    return response()->json([
                        'status' => false,
                        'error' => true,
                        'message' => "You cannot unblock user who is not blocked by you",
                        'data' => []
                    ]);
                }
            }

            if ($request->action == "Block") {
                $BlockedUserObj = new BlockedUser;
                $BlockedUserObj->blocked_user = $request->blocked_user;
                $BlockedUserObj->blocked_by = Auth::user()->id;
                $BlockedUserObj->save();
                return response()->json([
                    'status' => true,
                    'error' => false,
                    'message' => "User blocked",
                    'data' => []
                ]);
            }

            if ($request->action == "Unblock") {
                BlockedUser::where('blocked_user', $request->blocked_user)->where('blocked_by', Auth::user()->id)->delete();
                return response()->json([
                    'status' => true,
                    'error' => false,
                    'message' => "User Unblocked",
                    'data' => []
                ]);
            }
        }
        return $this->jsonView();
    }

    public function doReportUser(Request $request)
    {
        $rule = [
            'reported_user' => 'required|exists:users,id',
            'report_reason' => 'required'
        ];
        if ($this->validateData($request->all(), $rule)) {
            // check if already reported
            $reported_data = ReportedUser::where('reported_user', $request->reported_user)->where('reported_by', Auth::user()->id)->first();
            if (isset($reported_data->id)) {
                return response()->json([
                    'status' => false,
                    'error' => true,
                    'message' => "You have already reported this user.",
                    'data' => []
                ]);
            }

            $ReportedUserObj = new ReportedUser;
            $ReportedUserObj->reported_user = $request->reported_user;
            $ReportedUserObj->reported_by = Auth::user()->id;
            $ReportedUserObj->report_reason = $request->report_reason;
            $ReportedUserObj->save();
            return response()->json([
                'status' => true,
                'error' => false,
                'message' => "User reported.",
                'data' => []
            ]);
        }
        return $this->jsonView();
    }

    public function checkBlockUnblockUser(Request $request)
    {
        $rule = [
            'blocked_user' => 'required|exists:users,id'
        ];
        if ($this->validateData($request->all(), $rule)) {
            $blocked_data = BlockedUser::where('blocked_user', $request->blocked_user)->where('blocked_by', Auth::user()->id)->first();
            if (isset($blocked_data->id)) {
                return response()->json([
                    'status' => true,
                    'error' => false,
                    'message' => "This user blocked by you",
                    'data' => []
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'error' => true,
                    'message' => "This user is not blocked by you yet",
                    'data' => []
                ]);
            }
        }
        return $this->jsonView();
    }

    private function get_current_likes($user_id)
    {
        $UserActivityCounterObj = UserActivityCounter::where('user_id', $user_id)->whereMonth('created_at', Carbon::now()->month)->first();
        if (isset($UserActivityCounterObj->id)) {
            return $UserActivityCounterObj->like_counter;
        }
        return 0;
    }
}
