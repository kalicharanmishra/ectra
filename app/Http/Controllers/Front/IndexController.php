<?php

namespace App\Http\Controllers\Front;

use aws_url;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Categories;

use App\Models\Course;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Validator;
use App\Models\CmsPage;
use App\Models\class_course;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

use Razorpay\Api\Api;

use Auth;

use Alert;

use DB;

class IndexController extends Controller

{

    public function index(){



        $categories = Categories::get(); 

        return view('front.index', compact('categories'));



    }



    public function notificationUpdate($token){

        $id = Auth::user()->id;

        $newuse = User::where('id',$id)->update([

            'firebase_token'=>$token,

        ]);

        if($newuse){

            return true;

        }else{

            return false;

        }

    }



    public function course(){

        $course = [];

        // if($categoryid){

        //     $course = Course::where('category',$categoryid)->with('course_owner')->paginate(15);

        // }else{

        //     $course = Course::with('course_owner')->paginate(15);

        // }



            return view('front.course',compact('course'));

        

    }



    public function category(){

        return view('front.category');

    }



    

    public function profile(){

        return view('front.profile');

    }



    public function profileUpdate(Request $request){

// dd($request->name,
// $request->email,
// $request->phone,
// $request->short_bio,
// $request->bio);


       $update = DB::table('users')->where('id',$request->id)->update([

            'name'=>$request->fname,

            // 'name'=>$request->lname,

            'email'=>$request->email,

            'phone'=>$request->phone,

        ]);
        
        return back();


    }



    public function login(Request $request){

        $password = bcrypt($request->password);

        DB::table('users')->create([

            'name'=>$request->fname.''.$request->lname,

            'email'=>$request->email,

            'password'=>$password,

        ]);

        return redirect('/login');



    }





    public function manage_courses(){

        return view('front.manage_courses');

    }

    public function my_transection(){

        return view('front.my_transection');

    }



    public function about(){

        return view('front.about');

    }



    public function how_it_works(){

        return view('front.how_it_works');

    }



    public function aboutUs($name){

        
            $detail = CmsPage::where('slug',$name)->first();

            if($name == "TermsConditions"){
                return view('terms',compact('detail','name'));

            }else{
                return view('front.description',compact('detail','name'));
            }

    }


    public function privacy(){

        return view('privacypolicy');

    }

    public function sub_contact(Request $request){

       
        //   dd($request->all());
          $data = [
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'message' => $request->message,
        ];
    
        DB::table('contactus_inquiry')->insert($data);
    
       return redirect()->back()->with('success', 'Your inquiry successfully sent.');
     }






    public function course_detail($name){

        $course = \App\Models\Course::where('slug',$name)
        ->with([
            'course_owner',
            'course_comments',
            'course_circullum',
        ])
        ->withCount('course_enroll_student')->first();
        $course->categorydata = \App\Models\Categories::where('id',$course->category)->first();
        $course->parentcategorydata = \App\Models\Categories::where('id',$course->categorydata->parent)->first();
        $course->parentcategorydataparent = \App\Models\Categories::where('id',$course->parentcategorydata->parent)->first();

        $review = \App\Models\CourseComment::where('course_id',$course->id)->with('use_name')->get();

        // dd($review->toArray());
        // dd($course);

        return view('front.course-detail',compact('course','review'));

    }



    public function course_cir_detail($name){

        $course = \App\Models\Course::where('slug',$name)->with('course_owner','course_comments','course_circullum')->withCount('course_enroll_student')->first();
        // dd($course->id); exit;
        $review = \App\Models\CourseComment::where('course_id',$course->id)->with('use_name')->get();
        
        // dd($review->toArray());

        return view('front.course-cir-detail',compact('course','review'));

    }





    public function review(Request $request){

            if(!$request->id){

                echo "you are not logged in!!";

            }else{

             $isexist =   \App\Models\CourseComment::where([

                    'course_id' => $request->course_id,

                    'comment_by' => $request->id

                ])->first();

                if($isexist){

                    Alert::success('You have already submit your review');

                    return back();

                }

                $review = \App\Models\CourseComment::create([

                    'course_id' => $request->course_id,

                    'comment_by' => $request->id,

                    'comment' => $request->review,

                    'rate' => $request->rate,

                    'name' => $request->name,

                ]);

                return back();

            }

    }

    



    public function trialpay(Request $request){



        $input = $request->all();

        $api = new Api(env('ROZERPAY_KEY'), env('RAZORPAY_KEY_SECRET'));



        $payment = $api->payment->fetch($input['paymentID']);



        if (!empty($payment) && isset($payment['status'])) {

            if ($payment['status'] == 'authorized') {



                /* if the payment is authorized try to capture it using the API */

                $payment = $api->payment->fetch($input['paymentID']);

                $capture_response = $payment->capture(array('amount' => $payment['amount'], 'currency' => $payment['currency']));

                if ($capture_response['status'] == 'captured') {

                    $response['status'] = "1";

                    $response['message'] = "Payment captured successfully";

                    $response['amount'] = $capture_response['amount'] / 100;

                    $response['data'] = $capture_response;

                    

                } else if ($capture_response['status'] == 'refunded') {

                    $response['status'] = "0";

                    $response['message'] = "Payment is refunded.";

                    $response['amount'] = $capture_response['amount'] / 100;

                    $response['data'] = $capture_response;

                   

                } else {

                    $response['status'] = "0";

                    $response['message'] = "Payment could not be captured.";

                    $response['amount'] = (isset($capture_response['amount'])) ? $capture_response['amount'] / 100 : 0;

                    $response['data'] = $capture_response;

                   

                }

            } else if ($payment['status'] == 'captured') {

                $response['status'] = "1";

                $response['message'] = "Payment captured successfully";

                $response['amount'] = $payment['amount'] / 100;

                $response['data'] = $payment;

             

            } else if ($payment['status'] == 'created') {

                $response['status'] = "0";

                $response['message'] = "Payment is just created and yet not authorized / captured!";

                $response['amount'] = $payment['amount'] / 100;

                $response['data'] = $payment;

            

            } else {

                $response['status'] = "0";

                $response['message'] = "Payment is " . ucwords($payment['status']) . "! ";

                $response['amount'] = (isset($payment['amount'])) ? $payment['amount'] / 100 : 0;

                $response['data'] = $payment;

               

            }

        } else {

            

            $response['status'] = "0";

            $response['message'] = "Payment not found by the transaction ID!";

            $response['amount'] = 0;

            $response['data'] = [];

         

        }

   

        $techcourse = Course::where('id',$request->course_id)->first();

            if($response['status'] == "1"){

                $transaction = \App\Models\Transaction::create([

                    'course_id' => $request->course_id,

                    'subscriber_id' => $request->id,

                    'teacher_id' => $techcourse->user_id,

                    'price' => $techcourse->price,

                    'payment_request_id'=>$response['data']['id'],

                    'transaction_id'=>$input['paymentID'],

                    'status' => 'Credit'

                ]);


                $enroll = DB::table('trial_class')->insert([
                    'course_id' => $request->course_id,
                    'user_id' => $request->id,
                    'transaction_id' => $input['paymentID'],
                    // 'enroll_date' => $input['paymentDate']
                ]);

            }



            $name = \App\Models\Course::where('id',$request->course_id)->first();

            

            Alert::success('Payment Success');

            return redirect()->route('front.course_detail',$name->slug);



    }





    public function pay(Request $request){



        $input = $request->all();

        $api = new Api(env('ROZERPAY_KEY'), env('RAZORPAY_KEY_SECRET'));



        $payment = $api->payment->fetch($input['paymentID']);



        if (!empty($payment) && isset($payment['status'])) {

            if ($payment['status'] == 'authorized') {



                /* if the payment is authorized try to capture it using the API */

                $payment = $api->payment->fetch($input['paymentID']);

                $capture_response = $payment->capture(array('amount' => $payment['amount'], 'currency' => $payment['currency']));

                if ($capture_response['status'] == 'captured') {

                    $response['status'] = "1";

                    $response['message'] = "Payment captured successfully";

                    $response['amount'] = $capture_response['amount'] / 100;

                    $response['data'] = $capture_response;

                    

                } else if ($capture_response['status'] == 'refunded') {

                    $response['status'] = "0";

                    $response['message'] = "Payment is refunded.";

                    $response['amount'] = $capture_response['amount'] / 100;

                    $response['data'] = $capture_response;

                   

                } else {

                    $response['status'] = "0";

                    $response['message'] = "Payment could not be captured.";

                    $response['amount'] = (isset($capture_response['amount'])) ? $capture_response['amount'] / 100 : 0;

                    $response['data'] = $capture_response;

                   

                }

            } else if ($payment['status'] == 'captured') {

                $response['status'] = "1";

                $response['message'] = "Payment captured successfully";

                $response['amount'] = $payment['amount'] / 100;

                $response['data'] = $payment;

             

            } else if ($payment['status'] == 'created') {

                $response['status'] = "0";

                $response['message'] = "Payment is just created and yet not authorized / captured!";

                $response['amount'] = $payment['amount'] / 100;

                $response['data'] = $payment;

            

            } else {

                $response['status'] = "0";

                $response['message'] = "Payment is " . ucwords($payment['status']) . "! ";

                $response['amount'] = (isset($payment['amount'])) ? $payment['amount'] / 100 : 0;

                $response['data'] = $payment;

               

            }

        } else {

            

            $response['status'] = "0";

            $response['message'] = "Payment not found by the transaction ID!";

            $response['amount'] = 0;

            $response['data'] = [];

         

        }

   

        $techcourse = Course::where('id',$request->course_id)->first();

        //dd($techcourse);
            if($response['status'] == "1"){

                $transaction = \App\Models\Transaction::create([

                    'course_id' => $request->course_id,

                    'subscriber_id' => $request->id,

                    'teacher_id' => $techcourse->user_id,

                    'price' => $techcourse->price,
                    
                   
                    'teacher_commission' => $techcourse->price/10,
                    'admin_commission' => $techcourse->price - $techcourse->price/10,

                    'payment_request_id'=>$response['data']['id'],

                    'transaction_id'=>$input['paymentID'],

                    'status' => 'Credit'

                ]);



                $enroll = \App\Models\Course_enroll::insert([

                    'course_id' => $request->course_id,

                    'user_id' => $request->id,

                    'transaction_id'=>$input['paymentID'],

                    'enroll_date' => $input['paymentDate']

                ]);



                // $enroll = \App\Models\trial_class::insert([

                //     'course_id' => $request->course_id,

                //     'user_id' => $request->id,

                //     'transaction_id'=>$input['paymentID'],

                //     // 'enroll_date' => $input['paymentDate']

                // ]);

            }



            $name = \App\Models\Course::where('id',$request->course_id)->first();

            

            Alert::success('Payment Success');

            return redirect()->route('front.course_detail',$name->slug);



    }





    public function instructor_detail($id,$name){

       $id = \Crypt::decrypt($id);

       $teacher = User::where('id',$id)->with('teacher_profile','courses')->first();



        return view('front.instructor-detail',compact('teacher'));

    }

    public function instructor_layout(){

        return view('front.instructor-layout');

    }



    public function enroll($id){

        

        $data = \App\Models\Course::where('title',$id)->with('course_owner','course_comments','course_circullum')->withCount('course_enroll_student')->first();

        return view('front.enrolltransaction',compact('data'));

    }


    public function trialenroll($id){

        $trialdata = \App\Models\Course::where('title',$id)->with('course_owner','course_comments','course_circullum')->withCount('course_enroll_student')->first();
  
        return view('front.enrolltransaction',compact('trialdata'));

    }



    public function signup(){
        $allCountriesCities = allCountriesCitisList(0);
        $allCitiesArr = json_decode($allCountriesCities, true);
        return view('auth.register', compact('allCitiesArr'));

    }



    public function forgot(){

        return view('auth.passwords.email');

    }


    public function forgotPassword(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'email' => 'required|min:10'

        ]);
        if($validator->fails())
        {
            return redirect()->back()->withInput()->withErrors($validator->messages());
        } else {
            $user = '';
            
            if(filter_var($request->email, FILTER_VALIDATE_EMAIL) !== false)
            {
                $userData = User::where('email', $data['email'])->first();
                if(empty($userData))
                {
                    return redirect()->back()->withInput()->with('errors', 'This email does not exist.');
                }
                $user = $userData;
            }elseif(preg_match('/^[0-9]{10}+$/', $data['email']))
            {
                 $userData = User::where('phone', $data['email'])->first();
                if(empty($userData))
                {
                    return redirect()->back()->withInput()->with('errors', 'This phone number does not exist.');
                }
                $user = $userData;
            }
            $randomToken = Hash::make(generateRandomString(16));
            $passwordUpdate = DB::table('password_resets')->insert(['email' => $user->email, 'token' => $randomToken, 'created_at' => date('Y-m-d h:i:s')]);

            $emailEncrypt = encrypt($user->email);
            $mobileEncrypt = encrypt($user->phone);

            $site_title = env('APP_NAME');
            $otpVerifyUrl = "<a class='btn btn-primary' href='".route('forgot.password.reset', ['token' => encrypt($randomToken), 'email' => $emailEncrypt, 'mobile' => $mobileEncrypt])."'>Reset my password</a>";
            $mailBody = '
            
            <p style="font-size:16px;color:#333333;line-height:24px;margin:0">Hi!</p>
            <p style="font-size:16px;color:#333333;line-height:24px;margin:0">You are receiving this email because we received a password reset request for your account.</p>
            <h3 style="color:#333333;font-size:24px;line-height:32px;margin:0;padding-bottom:23px;margin-top:20px;text-align:center">'
                . $otpVerifyUrl . '</h3>
            <p style="font-size:16px;color:#333333;line-height:24px;margin:0">This password reset link will expire in 60 minutes.</p>
            <p style="font-size:16px;color:#333333;line-height:24px;margin:0">If you did not request a password reset, please ignore this mail.</p>
            <p style="color:#333333;font-size:16px;line-height:24px;margin:0;padding-bottom:23px"Regards,<br /><br/>Team ' . $site_title . '</p>
            ';
            
            $array = array('subject' => $site_title.' - password reset link', 'view' => 'emails.forgot-password', 'body' => $mailBody);
            if (strpos($_SERVER['SERVER_NAME'], "localhost") === false && strpos($_SERVER['SERVER_NAME'], "leukewebpanel.local") === false) {
               $ff = Mail::to($user->email)->send(new SendMail($array));
            }
            
             return redirect()->back()->withInput()->with('success', 'Password reset link has been send!!!<br/>Please check your sms / email.');
        }
    }

    // forgot password reset
    public function passwordReset($token, $email, $mobile)
    {
        if(!empty($token) && !empty($email) && !empty($mobile))
        {
            $email = decrypt($email);
            $phone = decrypt($mobile);
            $userData = User::where(['email' => $email, 'phone' => $phone])->first();
            return view('auth.passwords.forgot-reset', compact('token', 'userData'));
        } else {
            return redirect()->back()->withInput()->with('error', 'Please token and email.');
        }
    }
  
    // forgot password update
    public function forgotPasswordUpdate (Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'token' => 'required',
            'email' => 'required',
            'password' => 'required|same:confirm_password',
            'confirm_password' => 'required'
        ]);

        if($validator->fails())
        {
            return redirect()->back()->withInput()->withErrors($validator->messages());
        } else {
            $checkToken = DB::table('password_resets')->where(['email' => $request->email, 'token' => decrypt($request->token)])->first();
            if(!$checkToken && empty($checkToken))
            {
                return redirect()->back()->withInput()->with('error', 'Token mismatch.');
            }

            $userUpdate = User::where('email', $request->email)->first();
            if(empty($userUpdate))
            {
                return redirect()->back()->withInput()->with('error', 'This user is not registered.');
            }

            $userUpdate->password = Hash::make($request->password);
            $userUpdate->save();

            return redirect()->back()->withInput()->with('success', 'Your password has been changed successfully.<br/>Please login your account.');
        }
    }

}

