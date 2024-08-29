<?php



namespace App\Http\Controllers\Admin\V1;



use Auth;

use Carbon\Carbon;

use App\Models\User;

use App\Models\Video;

use App\Models\Course;

use App\Models\Transaction;

use App\Models\Role;

use App\Models\Permission;

use App\Models\SpinReward;

use Illuminate\Http\Request;

use App\Models\UserSpinReward;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

use App\Models\Currency;

use hasRole;

class DashboardController extends Controller

{



    public function index()

    {

       

        // users count

        $user = [];

        $users = User::where('id', '!=', 1)->get();

        $user['total_users'] = $users->count();

        $users = User::where('id', '!=', 1)->whereDate('created_at', Carbon::today())->get();

        $user['today'] = $users->count();

        $users = User::where('id', '!=', 1)->where('created_at', '>', Carbon::now()->subDays(7))->get();

        $user['sevenday'] = $users->count();

        $users = User::where('id', '!=', 1)->where('created_at', '>', Carbon::now()->subDays(30))->get();

        $user['thirtyday'] = $users->count();



        // users count

        $teacher = [];

        $teachers = User::where('id', '!=', 1)

        ->whereHas("roles", function($q){ $q->where("id", '!=',1)->where("id", '!=',3)->where("id", '!=',2)->where("id", '!=',5); })

        ->get();

        $teacher['total_users'] = $teachers->count();

        $teachers = User::where('id', '!=', 1)        

        ->whereHas("roles", function($q){ $q->where("id", '!=',1)->where("id", '!=',3)->where("id", '!=',2)->where("id", '!=',5); })

        ->whereDate('created_at', Carbon::today())->get();

        $teacher['today'] = $teachers->count();

        $teachers = User::where('id', '!=', 1)

        ->whereHas("roles", function($q){ $q->where("id", '!=',1)->where("id", '!=',3)->where("id", '!=',2)->where("id", '!=',5); })

        ->where('created_at', '>', Carbon::now()->subDays(7))->get();

        $teacher['sevenday'] = $teachers->count();

        $teachers = User::where('id', '!=', 1)        

        ->whereHas("roles", function($q){ $q->where("id", '!=',1)->where("id", '!=',3)->where("id", '!=',2)->where("id", '!=',5); })

        ->where('created_at', '>', Carbon::now()->subDays(30))->get();

        $teacher['thirtyday'] = $teachers->count();



         // users count

         $student = [];

         $students = User::where('id', '!=', 1)        

         ->whereHas("roles", function($q){ $q->where("id", '!=',1)->where("id", '!=',4)->where("id", '!=',2)->where("id", '!=',5); })

         ->get();

         $student['total_users'] = $students->count();

         $students = User::where('id', '!=', 1)         

         ->whereHas("roles", function($q){ $q->where("id", '!=',1)->where("id", '!=',4)->where("id", '!=',2)->where("id", '!=',5); })

        ->whereDate('created_at', Carbon::today())->get();

         $student['today'] = $students->count();

         $students = User::where('id', '!=', 1)         

         ->whereHas("roles", function($q){ $q->where("id", '!=',1)->where("id", '!=',4)->where("id", '!=',2)->where("id", '!=',5); })

        ->where('created_at', '>', Carbon::now()->subDays(7))->get();

         $student['sevenday'] = $students->count();

         $students = User::where('id', '!=', 1)         

         ->whereHas("roles", function($q){ $q->where("id", '!=',1)->where("id", '!=',4)->where("id", '!=',2)->where("id", '!=',5); })

        ->where('created_at', '>', Carbon::now()->subDays(30))->get();

         $student['thirtyday'] = $students->count();



         $course = [];

         $course = Course::get();

         $courses['total_users'] = $course->count();

         $course = Course::whereDate('created_at', Carbon::today())->get();

         $courses['today'] = $course->count();

         $course = Course::where('created_at', '>', Carbon::now()->subDays(7))->get();

         $courses['sevenday'] = $course->count();

         $course = Course::where('created_at', '>', Carbon::now()->subDays(30))->get();

         $courses['thirtyday'] = $course->count();



         $transac = [];

         $transac = Transaction::get();

         $transacs['total_users'] = $transac->count();

         $transac = Transaction::whereDate('created_at', Carbon::today())->get();

         $transacs['today'] = $transac->count();

         $transac = Transaction::where('created_at', '>', Carbon::now()->subDays(7))->get();

         $transacs['sevenday'] = $transac->count();

         $transac = Transaction::where('created_at', '>', Carbon::now()->subDays(30))->get();

         $transacs['thirtyday'] = $transac->count();


         $acti = array(
            'active'          => "admin_dash",
            'activetxt'       => "admin_dash",
          );


        return view('admin.v1.dashboard', compact('user','teacher','student','courses','transacs','acti'));

    }

}

