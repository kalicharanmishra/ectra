<?php

namespace App\Http\Controllers\Api;

use App\Mail\EmailOtpMail;
use App\Mail\ForgotPasswordMail;
use App\Mail\RegisterMail;
use App\Models\User;
use App\Models\UserOtp;
use App\Models\Categories;
use App\Models\CmsPage;
use App\Models\Rating;
use App\Models\SiteSetting;
use App\Models\UserMeta;
use App\Models\UserActivityCounter;
use App\Models\RequestVerifications;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Api\UserObj;
use App\Models\Currency;
use App\Models\Follower;
use App\Models\Setting;
use App\Models\Video;
use App\Models\ReferredUser;
use URL;




class AuthController extends ApiController
{
    public function __construct()
    {
        //$this->stripe = new \Stripe\StripeClient('sk_test_51KChafCNkCGDprKVAbS23dqFrwThtvgBOX2vlwtc3jfH4XDQoHCJkMUalhJhaOjjX70NNFHxVOHhEA7Q4ls0Lkh900KJg2jNpp');
        //$this->defaultCurrency = "usd";
        //$this->middleware('auth');
    }
    /**
     * Login API
     *
     *
     */
    public function login(Request $request)
    {
        $rule = [
            'phone'     => 'required',
            'password'  => 'required',
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
                $user = Auth::user();

                if ($user->status == 'inactive') {
                    $this->status = false;
                    $this->error = true;
                    $this->message = "Your account is deactivated by admin, Please contact admin to activate your
                    account";
                    $this->data = [];
                    return $this->jsonView();
                }


                if ($user->status == 'active') { 
                    $input = array();
                    $userde = Auth::user();
                    $this->status = true;
                    DB::table('user_metas')
                        ->updateOrInsert(
                            ['user_id' => Auth()->user()->id, 'meta_key' => 'firebase_token'],
                            ['meta_value' => $request->firebase_token]
                        );

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

                    // User levels
                    $user_levels = UserMeta::where('meta_key', 'user_levels')
                        ->where('user_id', $userde->id)
                        ->first();

           
                 

                    $user_details_arr = [
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
                        'firebase_token' => UserMeta::where('user_id', $userde->id)->where('meta_key', 'firebase_token')->first()->meta_value ?? NULL,
                     
                            'referral_code' => $referral_code
                    ];
                    return response()->json([
                        'status' => true,
                        'error' => false,
                        'message' => 'You are logged in sucessfully.',
                        'data' => [
                            'user' => $user_details_arr,
                            'token' => $user->createToken('CATCHIN')->accessToken
                        ]
                    ]);
                } else {
                    $this->error = true;
                    $this->message = 'Your account is deactivated by administrator.Please contact to administrator.';
                }
            } else {
                $this->error = true;
                $this->message = 'User credential not matched.';
            }
        }
        return $this->jsonView();
    }
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        $this->error = false;
        $this->message = 'Logout success.';

        return $this->jsonView();
    }

    /**
     * Register API
     *
     *
     */
    public function register(Request $request)
    {
        $rule = [
            'name'      =>  'required',
            'phone'     =>  'required|unique:users,phone',
            // 'password'  =>  'required',
            'dob'       =>  'required'
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            // try {
                //     DB::beginTransaction();

                /**
                 * If user provide referral code, we will validate that code
                 * increase monthly and user wise counter
                 */
                if (isset($request->referral_code)) {
                    // verify
                    $referral_data = User::where('referral_code', $request->referral_code)->first();
                    if (!isset($referral_data->id)) {
                        return response()->json([
                            'status' => false,
                            'error' => true,
                            'message' => "Referral code is invalid.",
                            'data' => []
                        ]);
                    }
                }

                $input                      =   $data;
                $input['phone']             =   $input['phone'];
                $input['social_login_id']   =   (!empty($input['social_login_id'])) ? $input['social_login_id'] : null;
                $input['social_login_type'] =   (!empty($input['social_login_type'])) ? $input['social_login_type'] : null;

                if ($filed = $request->hasfile('avtars')) {
                    $filed      = $request->file('avtars');
                    $named      = 'profile_images' . time() . '.' . $filed->getClientOriginalExtension();
                    Storage::disk('profile_images')->put($named, file_get_contents($filed->getRealPath()));
                    $input['avtars'] = $named;
                } else {
                    $input['avtars'] = Null;
                }

                $input['password']      =   (@bcrypt($input['password'])) ?: '';
                // $input['username']      =   $this->generate_username($input['name']);
                $input['email']         =   $input['phone'] . '@thrill.com';
                  // save referral_code
                $input['referral_code'] =   $this->generateUniqueCode();
                  // save firebase token
                $input['firebase_token'] =   isset($input['firebase_token']) ? $input['firebase_token'] : '';
                $user = User::create($input);
Auth::loginUsingId($user->id);
                // Auth::attempt(['email' => $input['phone'] . '@thrill.com', 'password' => $request->password, 'role' => $request->role]);
                $userde = Auth::user();


                // create blank user levels
             


                /**
                 *  Update user invite counter
                 */
                if (isset($request->referral_code)) {
      
                   $this->userMonthlyInviteCounter($referral_data->id);

                   $UserInviteCounter = UserActivityCounter::where('user_id',$referral_data->id)->select(DB::raw("SUM(invite_counter) as total_invite"))->first();
             
               if(isset($UserInviteCounter->total_invite) && $UserInviteCounter->total_invite == 10){
                
                   $referral_data->system_active = 1;
                   $referral_data->save();
               } 

                    // save user referrals
                    if (!empty($referral_data->meta_value)) {
                        $ReferredUser = new ReferredUser;
                        $ReferredUser->user_id = $user->id;
                        $ReferredUser->referred_by = $referral_data->id;
                        $ReferredUser->save();
                    }
                }



                $user_details_arr = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'email' => (empty($user->social_login_id)) ? NULL : $user->email,
                    'dob' => $user->dob,
                    'phone' => $user->phone,
                    'avatar' => $user->avtars,
                    'social_login_id' => $user->social_login_id,
                    'social_login_type' => $user->social_login_type,
                    'is_verified' => '0',
                    'first_name' => NULL,
                    'last_name' => NULL,
                    'gender' => NULL,
                    'website_url' => NULL,
                    'bio' => NULL,
                    'youtube' => NULL,
                    'facebook' => NULL,
                    'instagram' => NULL,
                    'twitter' => NULL,
                    'firebase_token' => $user->firebase_token,
                    'referral_count' => '0',
                    'following' => '0',
                    'followers' => '0',
                    'likes' => '0',
                    'levels' => [
                        'current' => '0',
                        'next' => '1',
                        'progress' => '0'
                    ],
                    'total_videos' => '0',
                    'box_two' => '0',
                    'box_three' => '0',
                    'referral_code' => $user->referral_code
                ];

                return response()->json([
                    'status' => true,
                    'error' => false,
                    'message' => 'You are registered successfully.',
                    'data' => [
                        'user' => $user_details_arr,
                        'token' => $user->createToken('CATCHIN')->accessToken
                    ]
                ]);
                // DB::commit();
            // } catch (\Exception $exception) {
            //     // DB::rollBack();
            //     $this->error = true;
            //     $this->message = $exception->getMessage();
            //     $this->data = [];
            //     $this->code = 200;
            // }
        }
        return $this->jsonView();
    }

    private function userMonthlyInviteCounter($user_id)
    {
        // varaible
        $now = Carbon::now();
        $current_month      =   $now->month;
        $month_start_date   =   $now->startOfMonth()->format('Y-m-d');
        $month_end_date     =   $now->endOfMonth()->format('Y-m-d');
        $is_record_exits = UserActivityCounter::where('user_id', $user_id)->where('month_start_date',$month_start_date)->where('month_end_date',$month_end_date)->first();

        // get like counter
        $counter = (isset($is_record_exits['id']) && !empty($is_record_exits['id'])) ? $is_record_exits->invite_counter : 0;

        if (isset($is_record_exits->id) && !empty($is_record_exits->id)) {
            // Update counter
            $UserActivityCounter                    = UserActivityCounter::where('id', $is_record_exits->id)->first();
            $UserActivityCounter->invite_counter    = $counter + 1;
            $UserActivityCounter->save();
        } else {
            // insert record and update counter
            $UserActivityCounter = new UserActivityCounter;
            $UserActivityCounter->user_id = $user_id;
            $UserActivityCounter->month = $current_month;
            $UserActivityCounter->month_start_date = $month_start_date;
            $UserActivityCounter->month_end_date = $month_end_date;
            $UserActivityCounter->like_counter = 0;
            $UserActivityCounter->view_counter = 0;
            $UserActivityCounter->invite_counter = $counter + 1;
            $UserActivityCounter->save();
        }
        return true;
    }

    /**
     * Social login PI
     *
     *
     */


    public function SocialLogin(Request $request)
    {
        $rule = [
            'social_login_id' => 'required',
            'social_login_type' => 'required',
            'email' => 'required_if:social_login_type,facebook|required_if:social_login_type,google|email',
            'phone' => 'required_if:social_login_type,truecaller|digits:10'
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {

            // check if social email id already there in db

            // check if user logged in already as social
            if (isset($request->email)) {
                $user = User::where('social_login_id', $request->social_login_id)
                    ->where('social_login_type', $request->social_login_type)
                    ->where('email', $request->email)
                    ->first();
            } else {
                $user = User::where('social_login_id', $request->social_login_id)
                    ->where('social_login_type', $request->social_login_type)
                    ->where('phone', $request->phone)
                    ->first();
            }


            if (empty($user)) {
                if (isset($request->email)) {
                    $email_exists = User::where('email', $request->email)->first();
                } else {
                    $email_exists = User::where('phone', $request->phone)->first();
                }


                if (!empty($email_exists)) {
                    $this->status = false;
                    $this->error = true;
                    $this->message = "Your email from {$request->social_login_type} already there in system. Use different profile or forgot password.";
                    return $this->jsonView();
                }
                if (isset($request->referral_code)) {
                    $referral_data = User::where('referral_code', $request->referral_code)->first();
                    if (!isset($referral_data->id)) {
                        return response()->json([
                            'status' => false,
                            'error' => true,
                            'message' => "Referral code is invalid.",
                            'data' => []
                        ]);
                    }
                }
                // register
                $input = $data;
                $input['phone'] = (isset($request->phone)) ? $request->phone : '';
                $input['username'] = isset($request->email) ? $this->generate_username($input['email']) : "";
                $input['password'] = (@bcrypt($input['social_login_id'])) ?: '';
                 // Generate unique code and same in user 
                 $input['referral_code'] = $this->generateUniqueCode();
                 $input['firebase_token'] =   isset($input['firebase_token']) ? $input['firebase_token'] : '';
              
                $user = User::create($input);                
                /**
                 *  Update user invite counter
                 */
                if (isset($request->referral_code)) {
                    
                    $this->userMonthlyInviteCounter($referral_data->id);

                   $UserInviteCounter = UserActivityCounter::where('user_id',$referral_data->id)->select(DB::raw("SUM(invite_counter) as total_invite"))->first();
             
               if(isset($UserInviteCounter->total_invite) && $UserInviteCounter->total_invite == 10){
                
                   $referral_data->system_active = 1;
                   $referral_data->save();
               } 

                    // save user referrals
                    if (!empty($referral_data->meta_value)) {
                        $ReferredUser = new ReferredUser;
                        $ReferredUser->user_id = $user->id;
                        $ReferredUser->referred_by = $referral_data->id;
                        $ReferredUser->save();
                    }
                        }
                $user_current_levels_arr = [
                    'creators' => [
                        'current_level' => '',
                        'next_level' => '',
                        'earned_spin' => '',
                        'used_spin' => '',
                    ],
                    'viewers' => [
                        'current_level' => '',
                        'next_level' => '',
                        'earned_spin' => '',
                        'used_spin' => '',
                    ],
                    'referrals' => [
                        'current_level' => '',
                        'next_level' => '',
                        'earned_spin' => '',
                        'used_spin' => '',
                    ]
                ];
                DB::table('user_metas')
                    ->updateOrInsert(
                        ['user_id' => $user->id, 'meta_key' => 'user_levels'],
                        ['meta_value' => json_encode($user_current_levels_arr)]
                    );

                $user_details_arr = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'email' => (empty($user->social_login_id)) ? NULL : $user->email,
                    'dob' => $user->dob,
                    'phone' => $user->phone,
                    'avatar' => $user->avtars,
                    'social_login_id' => $user->social_login_id,
                    'social_login_type' => $user->social_login_type,
                    'is_verified' => '0',
                    'first_name' => NULL,
                    'last_name' => NULL,
                    'gender' => NULL,
                    'website_url' => NULL,
                    'bio' => NULL,
                    'youtube' => NULL,
                    'facebook' => NULL,
                    'instagram' => NULL,
                    'twitter' => NULL,
                    'firebase_token' => $user->firebase_token,
                    'referral_count' => '0',
                    'following' => '0',
                    'followers' => '0',
                    'likes' => '0',
                    'levels' => [
                        'current' => '0',
                        'next' => '1',
                        'progress' => '50'
                    ],
                    'total_videos' => '0',
                    'box_two' => '0',
                    'box_three' => '0',
                    'referral_code' =>$user->referral_code,
                ];
                return response()->json([
                    'status' => true,
                    'error' => false,
                    'message' => 'You are registered successfully.',
                    'data' => [
                        'user' => $user_details_arr,
                        'token' => $user->createToken('CATCHIN')->accessToken
                    ]
                ]);
            } else {
                // login
                if ($user->status == 'active') {
                    $this->status = true;
                   
                    $user['firebase_token'] = isset($input['firebase_token']) ? $input['firebase_token'] : $user['firebase_token'];
                    $user->save();
                    // User levels
                    $user_levels = UserMeta::where('meta_key', 'user_levels')
                        ->where('user_id', $user->id)
                        ->first();

                    if (!isset($user_levels->meta_value) || empty($user_levels->meta_value)) {
                        // create blank user levels
                        $user_current_levels_arr = [
                            'creators' => [
                                'current_level' => '',
                                'next_level' => '',
                                'earned_spin' => '',
                                'used_spin' => '',
                            ],
                            'viewers' => [
                                'current_level' => '',
                                'next_level' => '',
                                'earned_spin' => '',
                                'used_spin' => '',
                            ],
                            'referrals' => [
                                'current_level' => '',
                                'next_level' => '',
                                'earned_spin' => '',
                                'used_spin' => '',
                            ]
                        ];
                        DB::table('user_metas')
                            ->updateOrInsert(
                                ['user_id' => $user->id, 'meta_key' => 'user_levels'],
                                ['meta_value' => json_encode($user_current_levels_arr)]
                            );
                    }

                    $user_counters = UserActivityCounter::get();
                    $referral_count = DB::table('user_activity_counters')
                        ->select(DB::raw('SUM(invite_counter) as referral_count'))
                        ->where('user_id', $user->id)
                        ->first();
                    $likes = DB::table('user_activity_counters')
                        ->select(DB::raw('SUM(like_counter) as likes'))
                        ->where('user_id', $user->id)
                        ->first();

                    $user_levels_meta = UserMeta::where('user_id', $user->id)
                        ->where('meta_key', 'user_levels')
                        ->first();
                    $user_levels_meta_value = json_decode($user_levels_meta->meta_value);

                    $creators_current_level_arr = explode(',', $user_levels_meta_value->creators->current_level);
                    $creators_next_level_arr = explode(',', $user_levels_meta_value->creators->next_level);
                    $creators_current_level = $creators_current_level_arr[count($creators_current_level_arr) - 1];
                    $creators_next_level = $creators_next_level_arr[count($creators_next_level_arr) - 1];

                    $rv = RequestVerifications::where('user_id', $user->id)->first();
                    if (isset($rv->id)) {
                        $rv = (string)$rv->is_verified;
                    } else {
                        $rv = '0';
                    }


                    $user_details_arr = [
                        'id' => $user->id,
                        'name' => $user->name,
                        'username' => $user->username,
                        'email' => (empty($user->social_login_id)) ? NULL : $user->email,
                        'dob' => $user->dob,
                        'phone' => $user->phone,
                        'avatar' => $user->avtars,
                        'social_login_id' => $user->social_login_id,
                        'social_login_type' => $user->social_login_type,
                        'first_name' => UserMeta::where('user_id', $user->id)->where('meta_key', 'first_name')->first()->meta_value ?? NULL,
                        'last_name' => UserMeta::where('user_id', $user->id)->where('meta_key', 'last_name')->first()->meta_value ?? NULL,
                        'gender' => UserMeta::where('user_id', $user->id)->where('meta_key', 'gender')->first()->meta_value ?? NULL,
                        'website_url' => UserMeta::where('user_id', $user->id)->where('meta_key', 'website_url')->first()->meta_value ?? NULL,
                        'bio' => UserMeta::where('user_id', $user->id)->where('meta_key', 'bio')->first()->meta_value ?? NULL,
                        'youtube' => UserMeta::where('user_id', $user->id)->where('meta_key', 'youtube')->first()->meta_value ?? NULL,
                        'facebook' => UserMeta::where('user_id', $user->id)->where('meta_key', 'facebook')->first()->meta_value ?? NULL,
                        'instagram' => UserMeta::where('user_id', $user->id)->where('meta_key', 'instagram')->first()->meta_value ?? NULL,
                        'twitter' => UserMeta::where('user_id', $user->id)->where('meta_key', 'twitter')->first()->meta_value ?? NULL,
                        'firebase_token' => $user->firebase_token,
                        'referral_count' => (string)$referral_count->referral_count ?? '0',
                        'following' => (string)Follower::where('follower_user_id', $user->id)->count() ?? '0',
                        'followers' => (string)Follower::where('publisher_user_id', $user->id)->count() ?? '0',
                        'likes' => (string)$likes->likes ?? '0',
                        'is_verified' => $rv,
                        'levels' => [
                            'current' => (string)$creators_current_level ?? '0',
                            'next' => (string)$creators_current_level ?? '0',
                            'progress' => '50'
                        ],
                        'total_videos' => (string)Video::where('user_id', $user->id)->count(),
                        'box_two' => '0',
                        'box_three' => '0',
                        'referral_code' => $user->referral_code
                    ];
                    return response()->json([
                        'status' => true,
                        'error' => false,
                        'message' => 'You are logged in successfully.',
                        'data' => [
                            'user' => $user_details_arr,
                            'token' => $user->createToken('CATCHIN')->accessToken
                        ]
                    ]);
                } else {
                    $this->error = true;
                    $this->message = 'Your account is deactivated by administrator.Please contact to administrator.';
                    $this->code = 401;
                }
            }
        }
        return $this->jsonView();
    }

    /**
     * Send OTP
     * With check already exist email
     *
     */

    public function sendOtp(Request $request)
    {
        $rule = [
            'phone' => 'required',
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            $input = $data;
            $userDetail = User::where('phone', $input['phone'])->first();
            if(!$userDetail){
                if (isset($request->referral_code)) {
                    // verify
                    $referral_data = User::where('referral_code', $request->referral_code)->first();
                    if (!isset($referral_data->id)) {
                        return response()->json([
                            'status' => false,
                            'error' => true,
                            'message' => "Referral code is invalid.",
                            'data' => []
                        ]);
                    }
                }

            $input['phone']             =   $input['phone'];
            $input['social_login_id']   =   (!empty($input['social_login_id'])) ? $input['social_login_id'] : null;
            $input['social_login_type'] =   (!empty($input['social_login_type'])) ? $input['social_login_type'] : null;

            if ($filed = $request->hasfile('avtars')) {
                $filed      = $request->file('avtars');
                $named      = 'profile_images' . time() . '.' . $filed->getClientOriginalExtension();
                Storage::disk('profile_images')->put($named, file_get_contents($filed->getRealPath()));
                $input['avtars'] = $named;
            } else {
                $input['avtars'] = Null;
            }

            $input['password']      =   (@bcrypt($input['phone'])) ?: '';
            $input['username']      =   $this->generate_username($input['phone']);
            $input['email']         =   $input['phone'] . '@thrill.com';
              // save referral_code
            $input['referral_code'] =   $this->generateUniqueCode();
              // save firebase token
            $input['firebase_token'] =   isset($input['firebase_token']) ? $input['firebase_token'] : '';
            $user = User::create($input);
    // create blank user levels
    $user_current_levels_arr = [
        'creators' => [
            'current_level' => '',
            'next_level' => '',
            'earned_spin' => '',
            'used_spin' => '',
        ],
        'viewers' => [
            'current_level' => '',
            'next_level' => '',
            'earned_spin' => '',
            'used_spin' => '',
        ],
        'referrals' => [
            'current_level' => '',
            'next_level' => '',
            'earned_spin' => '',
            'used_spin' => '',
        ]
    ];
    DB::table('user_metas')
        ->updateOrInsert(
            ['user_id' => $user->id, 'meta_key' => 'user_levels'],
            ['meta_value' => json_encode($user_current_levels_arr)]
        );


    /**
     *  Update user invite counter
     */
    if (isset($request->referral_code)) {

       $this->userMonthlyInviteCounter($referral_data->id);

       $UserInviteCounter = UserActivityCounter::where('user_id',$referral_data->id)->select(DB::raw("SUM(invite_counter) as total_invite"))->first();
 
   if(isset($UserInviteCounter->total_invite) && $UserInviteCounter->total_invite == 10){
    
       $referral_data->system_active = 1;
       $referral_data->save();
   } 

        // save user referrals
        if (!empty($referral_data)) {
            $ReferredUser = new ReferredUser;
            $ReferredUser->user_id = $user->id;
            $ReferredUser->referred_by = $referral_data->id;
            $ReferredUser->save();
        }
    }
}

if ($userDetail && $userDetail->status == 'inactive') {
                    $this->status = false;
                    $this->error = true;
                    $this->message = "Your account is deactivated by admin, Please contact admin to activate your
                    account";
                    $this->data = [];
                    return $this->jsonView();
                }
                
            $UserOtp = UserOtp::where('phone', $input['phone'])->delete();
            $otp = rand(1000, 9999);
            $input['otp'] = $otp;
            $user = UserOtp::create($input);
            $this->status = true;
            $this->data = ['otp' => $otp];
            $this->message = 'Otp sent to your phone.';
            // send otp to phone > AuthKey sms gateway
            $this->sendSMSOTP($request->phone, $otp);
        }
        return $this->jsonView();
    }

    /**
     * Check Mail API
     *
     *
     */

    public function CheckMail(Request $request)
    {
        $rule = [
            'email'     => 'required|email| unique:users,email',
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            try {
                $this->error = true;
                $this->status = true;
                $this->message = 'Email Address not exist';
            } catch (\Exception $exception) {
                DB::rollBack();
                $this->error = true;
                $this->message = $exception->getMessage();
                $this->data = [];
                $this->code = 401;
            }
        }

        return $this->jsonView();
    }

    /**
     * Check Username API
     *
     *
     */

    public function CheckUsername(Request $request)
    {
        $rule = [
            'username'  => 'required| unique:users,username',
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            try {
                $this->error = true;
                $this->status = true;
                $this->message = 'Username not exist';
            } catch (\Exception $exception) {
                DB::rollBack();
                $this->error = true;
                $this->message = $exception->getMessage();
                $this->data = [];
                $this->code = 401;
            }
        }

        return $this->jsonView();
    }



    public function forgotPassword(Request $request)
    {
        $rule = [
            'phone' => 'required|exists:users',
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            $input = $data;
            $otp = rand(1000, 9999);
            DB::table('user_otp')->where(['phone' => $request->phone])->delete();
            $input['otp'] = $otp;
            $UserOtp = UserOtp::create($input);
            $this->status = true;
            $this->data = ['otp' => $otp];
            $this->message = 'The OTP has been sent.';
            $this->sendSMSOTP($request->phone, $otp);
        }
        return $this->jsonView();
    }

    public function resetPassword(Request $request)
    {
        $rule = [
            'phone'     => 'required|exists:users',
            'password'  => 'required',
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {

            User::where('phone', $request->phone)->update(['password' => Hash::make($request->password)]);

            $this->message = 'Your password has been changed Successfully.';
            $this->error   = false;
            $this->status  = true;
        }
        return $this->jsonView();
    }

    /**
     * Resend Otp PI
     *
     *
     */
    public function ChangePassword(Request $request)
    {
        $rule = [
            'oldpassword' => 'required',
            'password'    => 'required'
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {

            $user = User::find(Auth::user()->id);

            if (!Hash::check($request->oldpassword, $user->password)) {

                $this->error = true;
                $this->message = 'Current Password didn\'t match';
                $this->code = 401;
            } else {

                $udata['password'] = Hash::make($request->password);
                $user->update($udata);
                $this->status = true;
                $this->message = 'Your password has been changed Successfully.';
            }
        }

        return $this->jsonView();
    }

    /**
     * Email verification Api
     */
    public function verifyOtp(Request $request)
    {
        $rule = [
            'otp' => 'required|exists:user_otp',
            'phone' => 'required'
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            $input = $data;
      
            $UserOtp = UserOtp::where(['phone' => $input['phone'], 'otp' => $input['otp']])->first();
            if (!empty($UserOtp)) {
                // $this->status = true;
                // $this->message = 'The OTP has been verified.';
                // $UserOtp = UserOtp::where('phone', $input['phone'])->delete();
                  $user = User::where(['phone' => $input['phone']])->first();
               
                if (Auth::loginUsingId($user->id)) {
                    $user = User::find(Auth::user()->id);
                    $input = array();
                   
                    $this->status = true;
                    $user->firebase_token = isset($input['firebase_token']) ? $input['firebase_token'] : $user->firebase_token;
                    $user->save();

                    // User levels
                    $user_levels = UserMeta::where('meta_key', 'user_levels')
                        ->where('user_id', $user->id)
                        ->first();

                    if (!isset($user_levels->meta_value) || empty($user_levels->meta_value)) {
                        // create blank user levels
                        $user_current_levels_arr = [
                            'creators' => [
                                'current_level' => '',
                                'next_level' => '',
                                'earned_spin' => '',
                                'used_spin' => '',
                            ],
                            'viewers' => [
                                'current_level' => '',
                                'next_level' => '',
                                'earned_spin' => '',
                                'used_spin' => '',
                            ],
                            'referrals' => [
                                'current_level' => '',
                                'next_level' => '',
                                'earned_spin' => '',
                                'used_spin' => '',
                            ]
                        ];
                        DB::table('user_metas')
                            ->updateOrInsert(
                                ['user_id' => $userde->id, 'meta_key' => 'user_levels'],
                                ['meta_value' => json_encode($user_current_levels_arr)]
                            );
                    }

                    $user_counters = UserActivityCounter::get();
                    $referral_count = DB::table('user_activity_counters')
                        ->select(DB::raw('SUM(invite_counter) as referral_count'))
                        ->where('user_id', $user->id)
                        ->first();

                    $likes = DB::table('user_activity_counters')
                        ->select(DB::raw('SUM(like_counter) as likes'))
                        ->where('user_id', $user->id)
                        ->first();

                    $user_levels_meta = UserMeta::where('user_id', $user->id)
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

                    $rv = RequestVerifications::where('user_id', $user->id)->first();
                    if (isset($rv->id)) {
                        $rv = (string)$rv->is_verified;
                    } else {
                        $rv = '0';
                    }

                    $user_details_arr = [
                        'id' => $user->id,
                        'name' => $user->name,
                        'username' => $user->username,
                        'email' => (empty($user->social_login_id)) ? NULL : $user->email,
                        'dob' => $user->dob,
                        'phone' => $user->phone,
                        'avatar' => $user->avtars,
                        'social_login_id' => $user->social_login_id,
                        'social_login_type' => $user->social_login_type,
                        'first_name' => UserMeta::where('user_id', $user->id)->where('meta_key', 'first_name')->first()->meta_value ?? NULL,
                        'last_name' => UserMeta::where('user_id', $user->id)->where('meta_key', 'last_name')->first()->meta_value ?? NULL,
                        'gender' => UserMeta::where('user_id', $user->id)->where('meta_key', 'gender')->first()->meta_value ?? NULL,
                        'website_url' => UserMeta::where('user_id', $user->id)->where('meta_key', 'website_url')->first()->meta_value ?? NULL,
                        'bio' => UserMeta::where('user_id', $user->id)->where('meta_key', 'bio')->first()->meta_value ?? NULL,
                        'youtube' => UserMeta::where('user_id', $user->id)->where('meta_key', 'youtube')->first()->meta_value ?? NULL,
                        'facebook' => UserMeta::where('user_id', $user->id)->where('meta_key', 'facebook')->first()->meta_value ?? NULL,
                        'instagram' => UserMeta::where('user_id', $user->id)->where('meta_key', 'instagram')->first()->meta_value ?? NULL,
                        'twitter' => UserMeta::where('user_id', $user->id)->where('meta_key', 'twitter')->first()->meta_value ?? NULL,
                        'firebase_token' => $user->firebase_token,
                        'referral_count' => (string)$referral_count->referral_count ?? '0',
                        'following' => (string)Follower::where('follower_user_id', $user->id)->count() ?? '0',
                        'followers' => (string)Follower::where('publisher_user_id', $user->id)->count() ?? '0',
                        'likes' => (string)$likes->likes ?? '0',
                        'is_verified' => $rv,
                        'levels' => [
                            'current' => (string)$creators_current_level ?? '0',
                            'next' => (string)$creators_next_level ?? '1',
                            'progress' => '50'
                        ],
                        'total_videos' => (string)Video::where('user_id', $user->id)->count(),
                        'box_two' => '0',
                        'box_three' => '0',
                        'referral_code' => $user->referral_code
                    ];
                    $UserOtp->delete();
                    return response()->json([
                        'status' => true,
                        'error' => false,
                        'message' => 'You are logged in sucessfully.',
                        'data' => [
                            'user' => $user_details_arr,
                            'token' => $user->createToken('CATCHIN')->accessToken
                        ]
                    ]);
                }else{
                         
                }
            } else {
                $this->error = true;
                $this->code = 200;
                $this->message = 'Invalid OTP';
            }
        }
        return $this->jsonView();
    }

    public function updateProfile(Request $request)
    {
        $rule = [
            'name' => 'required',
            'phone' => 'required',
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            $input  = $data;
            $user   = User::find(Auth::user()->id);
            $input['name']   = $input['name'];
            $input['phone']   = $input['phone'];
            if ($filed = $request->hasfile('avtars')) {
                $filed      = $request->file('avtars');
                $named      = 'profile_images' . time() . '.' . $filed->getClientOriginalExtension();
                Storage::disk('profile_images')->put($named, file_get_contents($filed->getRealPath()));
                //$imgurl     = Storage::disk('profile_images')->url($named);
                $input['avtars'] = $named;
            } else {
                $input['avtars'] = $user->avtars;
            }
            if ($filed1 = $request->hasfile('cover_image')) {
                $filed1      = $request->file('cover_image');
                $named1      = 'cover_image' . time() . '.' . $filed1->getClientOriginalExtension();
                Storage::disk('profile_images')->put($named1, file_get_contents($filed1->getRealPath()));
                //$imgurl     = Storage::disk('profile_images')->url($named);
                $input['cover_image'] = $named1;
            } else {
                $input['cover_image'] = $user->cover_image;
            }
            $user->update($input);
            $this->status  = true;
            $this->data    = $user;
            $this->message = 'Your profile has been updated successfully.';
        }
        return $this->jsonView();
    }


    public function CmsPage(Request $request)
    {
        $rule = [
            'slug' => 'required',
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            $input  = $data;
            $CmsPage   = CmsPage::where('slug', $request->slug)->first();
            $this->status  = true;
            $this->data    = $CmsPage;
            $this->message = 'CMS Page details.';
        }
        return $this->jsonView();
    }

    public function OverviewInformation(Request $request)
    {
        $CmsPage   = CmsPage::where('slug', 'app_overview_information')->orderBy('id', 'DESC')->get();
        $this->status  = true;
        $this->data    = $CmsPage;
        $this->message = 'App overview information.';
        return $this->jsonView();
    }

    public function getList()
    {
        $data = Categories::Where('status', 'active')->get();

        if ($data) {
            $data = ['status' => true, 'message' => 'Foods  fetch Successfully.', 'data' => $data];
        } else {
            $data = ['status' => false, 'message' => 'Record not Found.', 'data' => []];
        }
        return response()->json($data);
    }

    public function NotificationSetting(Request $request)
    {
        $rule = [
            'notification' => '',
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            try {
                $mt = User::where('id', Auth::id())->first();
                $mt->update(['notification' => !($mt->notification)]);
                $this->status  = true;
                $this->data    = $mt->notification;
                $this->message = 'Notification Successfully ' . (($mt->notification) ? 'Activated' : 'Deactivated');
            } catch (\Exception $exception) {
                DB::rollBack();
                $this->error = true;
                $this->message = $exception->getMessage();
                $this->data = [];
                $this->code = 401;
            }
        }
        return $this->jsonView();
    }

    public function Feedback(Request $request)
    {
        $rule = [
            'vendor_id' => '',
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            $response = array();
            $user   = User::find(Auth::user()->id);
            $rating   = Rating::where('vendor_id', $request->vendor_id)
                ->with('customer_details')
                ->orderBy('id', 'desc')
                ->get();
            $this->status  = true;
            $this->data    = $rating;
            $this->message = 'Feedback list';
        }
        return $this->jsonView();
    }

    public function FA_Toggle(Request $request)
    {
        $rule = [
            '2FA_toggle' => '',
        ];
        $data = $request->all();
        if ($this->validateData($data, $rule)) {
            try {
                $mt = User::where('id', Auth::id())->first();
                $mt->update(['two_FA_toggle' => !($mt->two_FA_toggle)]);
                $this->status  = true;
                $this->data    = $mt->two_FA_toggle;
                $this->message = '2FA Successfully ' . (($mt->two_FA_toggle) ? 'Activated' : 'Deactivated');
            } catch (\Exception $exception) {
                DB::rollBack();
                $this->error = true;
                $this->message = $exception->getMessage();
                $this->data = [];
                $this->code = 401;
            }
        }
        return $this->jsonView();
    }

    public function SiteSettings(Request $request)
    {

        $currencies = Currency::where('is_active', 1)->get();
        $currency_codes = [];

        foreach ($currencies as $curr) {
            $currency_codes[] = $curr->code;
        }

        if ($request->name == 'payment_network_user') {
            $value = Setting::where('name', 'payment_network_user')->first()->value;
            $name[] = [
                'name' => 'payment_network_user',
                'value' => json_decode($value)
            ];
        } else if ($request->name == 'commission_fee') {
            $value = Setting::where('name', 'commission_fee')->first()->value;
            $name[] = [
                'name' => 'commission_fee',
                'value' => $value
            ];
        } else {
            $name = Setting::select('name', 'value')->get()->toArray();
            array_push($name, [
                'name' => 'currency_codes',
                'value' => $currency_codes
            ]);
        }

        return response()->json([
            'status' => true,
            'error' => false,
            'message' => 'OK',
            'data' => $name
        ]);
    }


    //Old
    ////////////////////////////User Change status Active/deactive/////////////////////////////////

    public function ChangeStatus(Request $request)
    {

        $rule = [
            'live_status' => '',
        ];

        $data = $request->all();
        if ($this->validateData($data, $rule)) {

            try {

                $mt = User::where('id', Auth::id())->first();
                $mt->update(['live_status' => !($mt->live_status)]);

                $this->status  = true;
                $this->data    = $mt->live_status;
                $this->message = 'User Successfully ' . (($mt->live_status) ? 'Activated' : 'Deactivated');
            } catch (\Exception $exception) {
                DB::rollBack();
                $this->error = true;
                $this->message = $exception->getMessage();
                $this->data = [];
                $this->code = 401;
            }
        }

        return $this->jsonView();
    }

    public function CoverImage(Request $request)
    {
        if ($request->hasfile('file')) {

            $filed      = $request->file('file');
            $named      = 'coverimage_' . time() . '.' . $filed->getClientOriginalExtension();
            $floorplan  = Storage::disk('product_uploads')->put($named, file_get_contents($filed->getRealPath()));

            $imgurl = Storage::disk('product_uploads')->url($named);



            $this->message = 'Uploaded Successfully.';
            $this->data = ['name' => url($imgurl), 'filename' => $named];
            $this->status = true;
        } else {
            $this->error = true;
            $this->message = 'Please select image';
            $this->code = 401;
        }

        return $this->jsonView();
    }

    public function ProfileImage(Request $request)
    {
        if ($request->hasfile('file')) {

            $filed      = $request->file('file');
            $named      = 'profileimage_' . time() . '.' . $filed->getClientOriginalExtension();
            $floorplan  = Storage::disk('product_uploads')->put($named, file_get_contents($filed->getRealPath()));

            $imgurl = Storage::disk('product_uploads')->url($named);


            $this->message = 'Uploaded Successfully.';
            $this->data = ['name' => url($imgurl), 'filename' => $named];
            $this->status = true;
        } else {
            $this->error = true;
            $this->message = 'Please select image';
            $this->code = 401;
        }

        return $this->jsonView();
    }

    public function updateProfile_old(Request $request)
    {

        $rule  = ['full_name'    => 'required',];
        $data  = $request->all();

        if ($this->validateData($data, $rule)) {

            $input  = $data;
            $user   = User::find(Auth::user()->id);
            //echo "<pre>"; print_r($user); die;
            if (isset($request->price)) {
                $udata['price']    = $input['price'];
            }

            if (isset($request->free_min)) {
                $udata['free_min']  = $input['free_min'];
            }

            $udata['full_name'] = $input['full_name'];

            if (isset($request->about_self)) {
                $udata['about_self']  = $input['about_self'];
            }

            if ($input['avtars'] == 'no') {

                if ($request->hasfile('profileimage')) {
                    $filed      = $request->file('profileimage');
                    $named      = 'profileimage_' . time() . '.' . $filed->getClientOriginalExtension();
                    Storage::disk('product_uploads')->put($named, file_get_contents($filed->getRealPath()));
                    $imgurl     = Storage::disk('product_uploads')->url($named);
                    $udata['profileimage'] = $imgurl;
                } else {
                    $udata['profileimage'] = $user->profileimage;
                }
            }

            $udata['avtars']    = $input['avtars'];

            if ($input['avtars'] == 'yes') {
                $udata['profileimage'] = (@$input['profileimage']) ?: $user->profileimage;
            }
            //echo "<pre>"; print_r($udata); die;
            $user->update($udata);
            $this->status  = true;
            $this->data    = $user;
            $this->message = 'Your profile has been updated successfully.';
        }
        return $this->jsonView();
    }

    private function generateUniqueCode()
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersNumber = strlen($characters);
        $codeLength = 6;
        $code = '';
        while (strlen($code) < 6) {
            $position = rand(0, $charactersNumber - 1);
            $character = $characters[$position];
            $code = $code . $character;
        }
        return $code;
    }

    public function testOtp(Request $request)
    {
        if (!isset($request->mobile) || empty($request->mobile)) {
            return response()->json('Provide mobile number');
        }
        if (!isset($request->name) || empty($request->name)) {
            return response()->json('Provide name');
        }
        if (!isset($request->otp) || empty($request->otp)) {
            return response()->json('Provide otp');
        }
        $sms = 'Use 123456 as your OTP to access your thrill, OTP is confidential and valid for 8';
        $authkeyUrl = "https://api.authkey.io/request?";
        $paramArray = array(
            'authkey' => '972c35b4d29906dc',
            'mobile' => (string)$request->mobile,
            'country_code' => '91',
            'sms' => $sms,
            'sender' => 'AUTHKY'
        );
        $parameters = http_build_query($paramArray);
        $url = $authkeyUrl . $parameters;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            return response()->json("cURL Error #:" . $err);
        } else {
            return response()->json($response);
        }
    }
    public function app_open(Request $request)
    {
        $data = DB::table('user_login_history')->insert(
            [
                'user_id' => Auth::user()->id,
                'ip' => $request->ip,
                'mac_address' => $request->mac
            ]
        );
        $this->status  = true;
        $this->data    = $data;
        $this->message = 'Your profile has been updated successfully.';

        return $this->jsonView();
    }
}
