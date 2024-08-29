<?php

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\UserController;

use App\Http\Controllers\CategoriesController;

use App\Http\Controllers\Admin\V1\CategoryController;

use App\Http\Controllers\Admin\V1\CircullumController;

use App\Http\Controllers\Admin\V1\SoundsController;

use App\Http\Controllers\Admin\V1\CourseController;

use App\Http\Controllers\Admin\V1\BannersController;

use App\Http\Controllers\Admin\V1\AppUsersController;

use App\Http\Controllers\Admin\V1\DashboardController;

use App\Http\Controllers\Admin\V1\SpinWheelController;

use App\Http\Controllers\Admin\V1\TutorController;
use App\Http\Controllers\Admin\V1\StudentController;

use App\Http\Controllers\Admin\V1\CurrenciesController;

use App\Http\Controllers\Admin\V1\SettingsController;

use App\Http\Controllers\Admin\V1\HashTagsController;

use App\Http\Controllers\Admin\V1\NotificationController;

use App\Http\Controllers\Admin\V1\WithdrawalsController;

use App\Http\Controllers\Admin\V1\ReportController;

use App\Http\Controllers\Admin\V1\PermissionController;

use App\Http\Controllers\Admin\V1\AdminController;

/*

|--------------------------------------------------------------------------

| Web Routes

|--------------------------------------------------------------------------

|

| Here is where you can register web routes for your application. These

| routes are loaded by the RouteServiceProvider within a group which

| contains the "web" middleware group. Now create something great!

|

*/



Auth::routes();

Auth::routes(['verify' => true]);

// Route::get('/', function () {

//     return ('Hello');

// });



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::get('privacy-policy', function () {

    return view('privacypolicy');

});



Route::get('terms-conditions', function () {

    return view('terms');

});




Route::get('success', [App\Http\Controllers\UserController::class,'success'])->name('success');
Route::get('/profession', [App\Http\Controllers\Admin\RegisterController::class,'tutorProfession'])->name('tutor.profession');
Route::post('/tutor/profession/store', [App\Http\Controllers\Admin\RegisterController::class,'tutorProfessionStore'])->name('tutor.profession.store');


// clear route cache

Route::get('/clear-route-cache', function () {

    Artisan::call('route:cache');

    return 'Routes cache has clear successfully !';

});



//clear config cache

Route::get('/clear-config-cache', function () {

    Artisan::call('config:cache');

    return 'Config cache has clear successfully !';

});



// clear application cache

Route::get('/clear-app-cache', function () {

    Artisan::call('cache:clear');

    return 'Application cache has clear successfully!';

});



// clear view cache

Route::get('/clear-view-cache', function () {

    Artisan::call('view:clear');

    return 'View cache has clear successfully!';

});











    Route::get('/', [ App\Http\Controllers\Front\IndexController::class , 'index' ])->name('front.index');

    Route::get('profile', [ App\Http\Controllers\Front\IndexController::class , 'profile' ])->name('front.profile');

    Route::post('profile', [ App\Http\Controllers\Front\IndexController::class , 'profileUpdate' ])->name('front.profileUpdate');

    Route::get('manage_courses', [ App\Http\Controllers\Front\IndexController::class , 'manage_courses' ])->name('front.manage_courses');

    Route::get('my_transection', [ App\Http\Controllers\Front\IndexController::class , 'my_transection' ])->name('front.my_transection');

    Route::get('course', [ App\Http\Controllers\Front\IndexController::class , 'course' ])->name('front.course');

    Route::get('category', [ App\Http\Controllers\Front\IndexController::class , 'category' ])->name('front.category');

    Route::get('about', [ App\Http\Controllers\Front\IndexController::class , 'about' ])->name('front.about');

    Route::get('link/{name}', [ App\Http\Controllers\Front\IndexController::class , 'aboutUs' ])->name('front.aboutus');
    Route::get('linked/privacy-policy', [ App\Http\Controllers\Front\IndexController::class , 'privacy' ])->name('front.link');
    Route::get('how_it_works', [ App\Http\Controllers\Front\IndexController::class , 'how_it_works' ])->name('front.how_it_works');
    
    Route::any('sub_contact', [ App\Http\Controllers\Front\IndexController::class , 'sub_contact' ])->name('front.sub_contact');


    
    Route::get('api/notificationUpdate/{token}', [ App\Http\Controllers\Front\IndexController::class , 'notificationUpdate' ])->name('front.notificationUpdate');



    Route::get('course/{name}', [ App\Http\Controllers\Front\IndexController::class , 'course_detail' ])->name('front.course_detail');

    Route::get('course/{name}/circullum', [ App\Http\Controllers\Front\IndexController::class , 'course_cir_detail' ])->name('front.course_cir_detail');

    Route::get('instructor/{id}/{name}/', [ App\Http\Controllers\Front\IndexController::class , 'instructor_detail' ])->name('front.instructor_detail');

    Route::get('instructor_layout', [ App\Http\Controllers\Front\IndexController::class , 'instructor_layout' ])->name('front.instructor_layout');

    Route::get('signup', [ App\Http\Controllers\Front\IndexController::class , 'signup' ])->name('front.signup');

    Route::post('register', [ App\Http\Controllers\Auth\RegisterController::class , 'create' ])->name('register');
    Route::post('/sign-up', [ App\Http\Controllers\Admin\RegisterController::class , 'create' ])->name('front.signup.create');

    Route::get('forgot', [ App\Http\Controllers\Front\IndexController::class , 'forgot' ])->name('front.forgot');
    Route::post('forget/password', [App\Http\Controllers\Front\IndexController::class, 'forgotPassword'])->name('front.forgot.password');
    Route::get('/forgot/password/reset/{token}/{email}/{mobile}', [App\Http\Controllers\Front\IndexController::class, 'passwordReset'])->name('forgot.password.reset');
    Route::post('/forgot/password/update', [App\Http\Controllers\Front\IndexController::class, 'forgotPasswordUpdate'])->name('forgot.password.update');



    Route::post('review', [ App\Http\Controllers\Front\IndexController::class , 'review' ])->name('front.submitReview');



    Route::get('/course/{name}/enroll', [ App\Http\Controllers\Front\IndexController::class , 'enroll' ])->name('front.enroll');
    Route::get('/course/{name}/trialenroll', [ App\Http\Controllers\Front\IndexController::class , 'trialenroll' ])->name('front.trialenroll');
    
    Route::post('/course/pay', [ App\Http\Controllers\Front\IndexController::class , 'pay' ])->name('front.pay');
    Route::post('/course/trialpay', [ App\Http\Controllers\Front\IndexController::class , 'trialpay' ])->name('front.trialpay');

    

    Route::post('/auth/signin', [ App\Http\Controllers\UserController::class , 'login' ])->name('auth.signin');



    Route::post('login/sign', [ App\Http\Controllers\IndexController::class , 'login' ])->name('auth.sign');

    







Route::group(['middleware' => ['auth', 'web']], function () {



    Route::prefix('admin/v1')->group(function () {

        // Dashboard

        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.v1.dashboard');

        

        // users

        Route::prefix('appuser')->group(function () {

            Route::get('list', [AppUsersController::class, 'list'])->name('admin.v1.appuser.list');

            Route::get('list/{id}', [AppUsersController::class, 'listid'])->name('admin.v1.appuser.listid');

             // add form

             Route::get('add', [AppUsersController::class, 'add'])->name('admin.v1.user.add');

             // add submit

             Route::post('add', [AppUsersController::class, 'addSubmit'])->name('admin.v1.user.add-submit');

             // edit form

             Route::get('edit/{id}', [AppUsersController::class, 'edit'])->name('admin.v1.user.edit');

             // edit submit

             Route::post('edit/{id}', [AppUsersController::class, 'editSubmit'])->name('admin.v1.user.edit-submit');

            Route::get('referred-user/{user_id?}', [AppUsersController::class, 'referredList'])->name('admin.v1.appuser.referred_user');

            Route::get('view/{id}', [AppUsersController::class, 'view'])->name('admin.v1.appuser.view');

            Route::get('block/{id}/action/{action}', [AppUsersController::class, 'block'])->name('admin.v1.appuser.block');

            Route::get('verify/{id}/action/{action}', [AppUsersController::class, 'verify'])->name('admin.v1.appuser.verify');

            Route::get('delete/{id}', [AppUsersController::class, 'delete'])->name('admin.v1.appuser.delete');

            Route::get('change-password', [AppUsersController::class, 'changePassword'])->name('admin.v1.appuser.changepassword');

            Route::post('change-password', [AppUsersController::class, 'changePasswordSubmit'])->name('admin.v1.appuser.changePasswordSubmit');

        });

        //superAdmiin

        Route::prefix('admin')->group(function () {

            // Route::get('/admin/contactus-inquiry', 'AdminController@contactus_inquiry')->name('admin.v1.contactus_inquiry');

            Route::get('/admin/contactus_inquiry', [AdminController::class, 'contactus_inquiry'])->name('admin.v1.contactus_inquiry');

            Route::get('list', [AdminController::class, 'list'])->name('admin.v1.admin.list');

             // add form

             Route::get('add', [AdminController::class, 'add'])->name('admin.v1.admin.add');

             // add submit

             Route::post('add', [AdminController::class, 'addSubmit'])->name('admin.v1.admin.add-submit');

             // edit form

             Route::get('edit/{id}', [AdminController::class, 'edit'])->name('admin.v1.admin.edit');

             // edit submit

             Route::post('edit/{id}', [AdminController::class, 'editSubmit'])->name('admin.v1.admin.edit-submit');

// block

Route::get('block/{id}/action/{action}', [AdminController::class, 'block'])->name('admin.v1.admin.block');

// delete

Route::get('delete/{id}', [AdminController::class, 'delete'])->name('admin.v1.admin.delete');

        });

        // subadmin
        Route::prefix('user')->group(function () {

            // student section

            // List
            Route::get('list/{id}', [UserController::class, 'listid'])->name('admin.v1.user.listid');

        });

        Route::prefix('student')->group(function () {



            // student section

            // List

            Route::get('list', [StudentController::class, 'list'])->name('admin.v1.student.list');

            Route::get('list/{id}', [StudentController::class, 'listid'])->name('admin.v1.student.listid');

            Route::get('edit/{id}', [StudentController::class, ''])->name('admin.v1.student.listid');

            // view

            // Route::get('view/{id}', [AppUsersController::class, 'view'])->name('admin.v1.subadmin.view');

            // block

            Route::get('block/{id}/action/{action}', [StudentController::class, 'block'])->name('admin.v1.student.block');

            // delete

            Route::get('delete/{id}', [StudentController::class, 'delete'])->name('admin.v1.student.delete');

            // add form

            Route::get('add', [StudentController::class, 'add'])->name('admin.v1.student.add');

            // add submit

            Route::post('add', [StudentController::class, 'addSubmit'])->name('admin.v1.student.add-submit');

            // edit form

            Route::get('edit/{id}', [StudentController::class, 'edit'])->name('admin.v1.student.edit');

            // edit submit

            Route::post('edit/{id}', [StudentController::class, 'editSubmit'])->name('admin.v1.student.edit-submit');

            // set access fomr

            Route::get('access/{id}', [StudentController::class, 'access'])->name('admin.v1.student.access');

            // submit access

            Route::post('access/{id}', [StudentController::class, 'accessSubmit'])->name('admin.v1.student.access-submit');

        });


        Route::prefix('tutor')->group(function () {



            // tutor section

            // List

            Route::get('list', [TutorController::class, 'list'])->name('admin.v1.tutor.list');

            Route::get('list/{id}', [TutorController::class, 'listid'])->name('admin.v1.tutor.listid');

            // view

            // Route::get('view/{id}', [AppUsersController::class, 'view'])->name('admin.v1.subadmin.view');

            // block

            Route::get('block/{id}/action/{action}', [TutorController::class, 'block'])->name('admin.v1.tutor.block');

            // delete

            Route::get('delete/{id}', [TutorController::class, 'delete'])->name('admin.v1.tutor.delete');

            // add form

            Route::get('add', [TutorController::class, 'add'])->name('admin.v1.tutor.add');

            // add submit

            Route::post('add', [TutorController::class, 'addSubmit'])->name('admin.v1.tutor.add-submit');

            // edit form

            Route::get('edit/{id}', [TutorController::class, 'edit'])->name('admin.v1.tutor.edit');

            // edit submit

            Route::post('edit/{id}', [TutorController::class, 'editSubmit'])->name('admin.v1.tutor.edit-submit');

            // set access fomr

            Route::get('access/{id}', [TutorController::class, 'access'])->name('admin.v1.tutor.access');

            // submit access

            Route::post('access/{id}', [TutorController::class, 'accessSubmit'])->name('admin.v1.tutor.access-submit');

        });

        // sounds

        Route::prefix('category')->group(function () {

            // Category section

            // List

            Route::get('category-list', [CategoryController::class, 'listCategories'])->name('admin.v1.category.list');

            // add form

            Route::get('category-add', [CategoryController::class, 'addCategory'])->name('admin.v1.category.add');

            // add submit

            Route::post('category-add', [CategoryController::class, 'addCategorySubmit'])->name('admin.v1.category.add-submit');

             // edit form

             Route::get('category-edit/{id}', [CategoryController::class, 'editCategory'])->name('admin.v1.category.edit');

             // edit submit

             Route::post('category-edit', [CategoryController::class, 'editCategorySubmit'])->name('admin.v1.category.edit-submit');

             // delete

            Route::get('category-delete/{id}', [CategoryController::class, 'deleteCategory'])->name('admin.v1.category.delete');



            // sound section

            // List

            Route::get('list', [SoundsController::class, 'list'])->name('admin.v1.sound.list');

            // add form

            Route::get('add', [SoundsController::class, 'add'])->name('admin.v1.sound.add');

            // add submit

            Route::post('add', [SoundsController::class, 'addSubmit'])->name('admin.v1.sound.add-submit');

            // delete

            Route::get('delete/{id}', [SoundsController::class, 'delete'])->name('admin.v1.sound.delete');

        });



        Route::prefix('attendance')->group(function () {

            // Category section

            // List

            Route::get('attendance-list/{teacher_id?}', [CategoryController::class, 'listAttendance'])->name('admin.v1.attendence.list');

            // add form

           

        });

        Route::prefix('transaction')->group(function () {

            // Category section

            // List

            Route::get('transaction-list/{teacher_id?}', [CategoryController::class, 'listtransac'])->name('admin.v1.attendence.listtransaction');

            // add form

           

        });

        

        Route::prefix('circullum')->group(function () {

            // circullum section

            Route::get('circullum-list/{id}', [CircullumController::class, 'listCircullum'])->name('admin.v1.circullum.list');

            Route::get('circullum-add/{id}', [CircullumController::class, 'addCircullum'])->name('admin.v1.circullum.add');



            Route::post('circullum-add', [CircullumController::class, 'addCircullumSubmit'])->name('admin.v1.circullum.add-submit');

             // edit form

             Route::get('circullum-edit/{id}', [CircullumController::class, 'editCircullum'])->name('admin.v1.circullum.edit');

             // edit submit

             Route::post('circullum-edit/{id}', [CircullumController::class, 'editCircullumSubmit'])->name('admin.v1.circullum.edit-submit');

             // delete

            Route::get('circullum-delete/{id}', [CircullumController::class, 'deleteCircullum'])->name('admin.v1.circullum.delete');



            // sound section

            // // List

            // Route::get('list', [SoundsController::class, 'list'])->name('admin.v1.sound.list');

            // // add form

            // Route::get('add', [SoundsController::class, 'add'])->name('admin.v1.sound.add');

            // // add submit

            // Route::post('add', [SoundsController::class, 'addSubmit'])->name('admin.v1.sound.add-submit');

            // // delete

            // Route::get('delete/{id}', [SoundsController::class, 'delete'])->name('admin.v1.sound.delete');

        });



        // Currencies

        Route::prefix('currencies')->group(function () {



            // subadmn section

            // List

            Route::get('list', [CurrenciesController::class, 'list'])->name('admin.v1.currencies.list');

            Route::get('status/{id}/{status}', [CurrenciesController::class, 'status'])->name('admin.v1.currencies.status');

            // delete

            Route::get('delete/{id}', [CurrenciesController::class, 'delete'])->name('admin.v1.currencies.delete');

            // add form

            Route::get('add', [CurrenciesController::class, 'add'])->name('admin.v1.currencies.add');

            // add submit

            Route::post('add', [CurrenciesController::class, 'addSubmit'])->name('admin.v1.currencies.add-submit');





            // network list

            Route::get('networks/{currency_id}', [CurrenciesController::class, 'getNetworks'])->name('admin.v1.currencies.networks');

            Route::get('networks/{network_id}/delete', [CurrenciesController::class, 'deleteNetworks'])->name('admin.v1.currencies.deleteNetworks');

            // add Netwok

            Route::get('networks/{currency_id}/add', [CurrenciesController::class, 'addNetwork'])->name('admin.v1.currencies.addNetwork');

            // add Network submit

            Route::post('networks/{currency_id}/add', [CurrenciesController::class, 'addNetworkSubmit'])->name('admin.v1.currencies.addNetworkSubmit');

            // update Network

            Route::get('networks/{currency_id}/update/{network_id}', [CurrenciesController::class, 'updateNetwork'])->name('admin.v1.currencies.updateNetwork');

            Route::post('networks/{currency_id}/update/{network_id}', [CurrenciesController::class, 'updateNetworkSubmit'])->name('admin.v1.currencies.updateNetworkSubmit');

        });



        // videos

        Route::prefix('course')->group(function () {

            // List

            Route::get('list/{id?}', [CourseController::class, 'list'])->name('admin.v1.course.list');

            Route::get('trial_pay_list/{id}', [CourseController::class, 'trial_pay'])->name('admin.v1.courses.trial_pay');

            // add form


            // payment details
            Route::get('studentlist/{id?}', [CategoryController::class, 'studentlist'])->name('admin.v1.paymentdetail.studentlist');
            Route::get('courselist/{id?}', [CategoryController::class, 'courselist'])->name('admin.v1.paymentdetail.courselist');

            

            Route::get('add', [CourseController::class, 'add'])->name('admin.v1.course.add');

            Route::Post('add', [CourseController::class, 'addCourseSubmit'])->name('admin.v1.course.add');

            Route::get('edit/{id}', [CourseController::class, 'edit'])->name('admin.v1.course.edit');

            Route::Post('edit/{id}', [CourseController::class, 'editCourseSubmit'])->name('admin.v1.course.edit');

            

            Route::get('opclas/{id}', [CourseController::class, 'opclas'])->name('admin.v1.course.opclas');
            Route::get('opedit/{id}', [CourseController::class, 'opedit'])->name('admin.v1.course.opedit');
            Route::get('attendance/{id}', [CourseController::class, 'attendance'])->name('admin.v1.course.attendance');


            Route::any('coursedel/{id}', [CourseController::class, 'coursedel'])->name('admin.v1.course.coursedel');

            Route::any('newedit', [CourseController::class, 'newedit'])->name('admin.v1.course.newedit');
            // delete

            Route::get('delete/{id}', [CourseController::class, 'delete'])->name('admin.v1.course.delete');

            // block

            Route::get('block/{id}/action/{action}', [CourseController::class, 'block'])->name('admin.v1.course.block');

            // comments

            Route::get('comments/{id}', [CourseController::class, 'comments'])->name('admin.v1.course.comments');

            Route::get('blockcomment/{id}/action/{action}', [CourseController::class, 'blockComment'])->name('admin.v1.course.blockcomment');

            Route::get('deletecomment/{id}', [CourseController::class, 'deleteComment'])->name('admin.v1.course.deletecomment');

        });



        // spin wheel

        Route::prefix('spin-wheel')->group(function () {

            // activites

            Route::get('activities', [SpinWheelController::class, 'activites'])->name('admin.v1.spinWheel.activites');

            // Levels

            Route::get('levels/{activity_id}', [SpinWheelController::class, 'getActivityLevels'])->name('admin.v1.spinWheel.activitylevels');

            // add levels

            Route::get('levels/{activity_id}/add', [SpinWheelController::class, 'addLevel'])->name('admin.v1.spinWheel.addLevel');



            // add level submit

            Route::post('levels/{activity_id}/add', [SpinWheelController::class, 'addLevelSubmit'])->name('admin.v1.spinWheel.addLevelSubmit');

            // update levels conditions

            Route::get('levels/{activity_id}/update/{level_id}', [SpinWheelController::class, 'updateLevel'])->name('admin.v1.spinWheel.updateLevel');

            Route::post('levels/{activity_id}/update/{level_id}', [SpinWheelController::class, 'updateLevelSubmit'])->name('admin.v1.spinWheel.updateLevelSubmit');



            // rewards

            Route::get('rewards', [SpinWheelController::class, 'rewards'])->name('admin.v1.spinWheel.rewards');

            // add reward

            Route::get('add-reward', [SpinWheelController::class, 'addReward'])->name('admin.v1.spinWheel.addReward');

            Route::post('add-reward', [SpinWheelController::class, 'addRewardSubmit'])->name('admin.v1.spinWheel.addRewardSubmit');

            Route::get('edit-reward/{id}', [SpinWheelController::class, 'editReward'])->name('admin.v1.spinWheel.editReward');

            Route::post('edit-reward/{id}', [SpinWheelController::class, 'editRewardSubmit'])->name('admin.v1.spinWheel.editRewardSubmit');

            // Route::get('block/{id}/action/{action}', [SpinWheelController::class, 'blockReward'])->name('admin.v1.spinWhell.blockReward');

        });



        // banner section

        Route::prefix('banner')->group(function () {

            Route::get('list', [BannersController::class, 'list'])->name('admin.v1.banner.list');

            Route::get('add', [BannersController::class, 'add'])->name('admin.v1.banner.add');

            Route::get('edit/{id}', [BannersController::class, 'edit'])->name('admin.v1.banner.edit');

            Route::post('add', [BannersController::class, 'addSubmit'])->name('admin.v1.banner.addSubmit');

            Route::post('edit/{id}', [BannersController::class, 'editSubmit'])->name('admin.v1.banner.editSubmit');

            Route::get('delete/{id}', [BannersController::class, 'delete'])->name('admin.v1.banner.delete');

        });



        // Cms Mangement

        Route::prefix('cms')->group(function () {

            Route::get('/cms-index', [HomeController::class, 'cms'])->name('admin.v1.cms.index');

            Route::get('/cms-edit/{id}', [HomeController::class, 'cms_edit'])->name('admin.v1.cms.edit');

            Route::post('/cms-update/{id}', [HomeController::class, 'cms_update'])->name('admin.v1.cms.update');

            Route::get('/cms-delete/{id}', [HomeController::class, 'cms_delete'])->name('admin.v1.cms.delete');

            Route::get('cms/add', [HomeController::class, 'add_cms'])->name('admin.v1.cms.add');

            Route::post('cms/add', [HomeController::class, 'add_cms_submit'])->name('admin.v1.cms.add');

        });



        // settings

        Route::prefix('settings')->group(function () {

            Route::get('list', [SettingsController::class, 'list'])->name('admin.v1.settings.list');

            Route::get('edit/{id}', [SettingsController::class, 'edit'])->name('admin.v1.settings.edit');

            Route::post('edit/{id}', [SettingsController::class, 'editSubmit'])->name('admin.v1.settings.editSubmit');

            Route::get('set-notification', [NotificationController::class, 'add'])->name('admin.v1.settings.set-notification');

            Route::post('send-notification', [NotificationController::class, 'send'])->name('admin.v1.settings.send-notification');

            Route::get('permission', [PermissionController::class, 'list'])->name('admin.v1.settings.permission');

            Route::get('permission/add', [PermissionController::class, 'add_role_permission'])->name('admin.v1.settings.permission.add');

            Route::get('permission/delete/{id}', [PermissionController::class, 'delete'])->name('admin.v1.settings.permission.delete');

            Route::post('permission/add', [PermissionController::class, 'add_role_permission_submit'])->name('admin.v1.settings.permission.add');

            Route::get('permission/edit/{id}', [PermissionController::class, 'edit'])->name('admin.v1.settings.permission.edit');

            Route::post('permission/edit/{id}', [PermissionController::class, 'editSubmit'])->name('admin.v1.settings.permission.editSubmit');

  

        });



        // hash tags

        Route::prefix('hashtags')->group(function () {

            Route::get('list', [HashTagsController::class, 'list'])->name('admin.v1.hashtags.list');

            Route::get('videos/{id}', [HashTagsController::class, 'videos'])->name('admin.v1.hashtags.videos');

        });



        // withdraw

        Route::prefix('withdraw')->group(function () {

            Route::get('list/{user_id?}', [WithdrawalsController::class, 'list'])->name('admin.v1.withdraw.list');

            Route::get('edit/{id}', [WithdrawalsController::class, 'edit'])->name('admin.v1.withdraw.edit');

            Route::post('edit/{id}', [WithdrawalsController::class, 'editSubmit'])->name('admin.v1.withdraw.editSubmit');

        });



        // report management

        Route::prefix('report')->group(function () {

            Route::get('users', [ReportController::class, 'reportedUsers'])->name('admin.report.users');

            Route::get('warn/users/{id}', [ReportController::class, 'warnReportedUser'])->name('admin.report.warn');

            Route::get('notify/users/{id}', [ReportController::class, 'notifyReportedUser'])->name('admin.report.notify');

            Route::get('videos', [ReportController::class, 'reportedVideos'])->name('admin.report.videos');

            Route::get('videos/delete/{id}', [ReportController::class, 'deleteReportedVideos'])->name('admin.report.videos.delete');

        });

    });



    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/logout', [HomeController::class, 'logout'])->name('logout');

    Route::get('/customer', [UserController::class, 'customer'])->name('admin.customer');

    Route::get('/vendor', [UserController::class, 'vendor'])->name('admin.vendor');

    Route::get('/view/{id}', [UserController::class, 'view'])->name('admin.view');

    Route::get('/delete/{id}', [UserController::class, 'delete'])->name('admin.delete');

    Route::get('/change-Status/{slug}/{id}', [UserController::class, 'changeStatus'])->name('change-Status');

    Route::get('/categories-index', [CategoriesController::class, 'index'])->name('categories.index');

    Route::get('/categories-add', [CategoriesController::class, 'add'])->name('categories.add');

    Route::post('/categories-store', [CategoriesController::class, 'store'])->name('categories.store');

    Route::get('/changeStatus/{slug}/{id}', [CategoriesController::class, 'changeStatus'])->name('changeStatus');

    Route::get('/category-delete/{id}', [CategoriesController::class, 'delete'])->name('categories.delete');

    Route::get('/categories-edit/{id}', [CategoriesController::class, 'edit'])->name('categories.edit');

    Route::post('/categories-update/{id}', [CategoriesController::class, 'update'])->name('categories.update');

    Route::get('/site-setting', [HomeController::class, 'site_setting'])->name('site-setting');

    Route::post('/setting-update', [HomeController::class, 'setting_update'])->name('setting.update');

    Route::get('/payment-management', [HomeController::class, 'PaymentManagement'])->name('payment.management');

});

