<?php

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

/*********************************** Admin Routes **************************************************/
Route::get('/test', function () {
    return json_decode(App\Student::paginate(10));
});
Route::get('/admin/login', 'Admin\Auth\LoginController@getLogin')->name('admin.login');
Route::post('/admin/login', 'Admin\Auth\LoginController@postLogin');
Route::get('admin/logout', 'Admin\Auth\LoginController@logout');
Route::get('testSendEmail', 'SendEmailTotalController@sendMailTest');

Route::post('postAddStage/{course}/{user}', 'StudentStageController@addStage');
Route::post('addVerify/{user}/{course}', 'Front\UserVerifyCertif@addVerify');
Route::get('delete-stage/{id}','StudentStageController@deleteStage')->name('delete.stage');
/*********study delete*****/
Route::get('delete-studycase/{id}','StudentStageController@deleteStudycase')->name('delete.studycase');

Route::get('payement_all_crs', 'Front\PayementAllCourses@payementAllCourse');

Route::get('createCertifClass', 'CerifClassroomController@createCertifClass');


// Password reset routes
Route::post('/admin/password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('/admin/password/reset/{token?}', 'Admin\Auth\ResetPasswordController@showResetForm');
Route::post('/admin/password/reset', 'Admin\Auth\ResetPasswordController@reset');

Route::get('admin/home/lock', 'Admin\HomeController@getLock');
Route::post('admin/home/lock', 'Admin\HomeController@postLock');

Route::group([
    'namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['admins']
], function () {


      require base_path('routes/admin/admin.php');

  
});

/*********************************** End Admin Routes **************************************************/


/*********************************** Teacher Routes **************************************************/

Route::get('/teachers/login', 'Teacher\Auth\LoginController@getLogin')->name("login");
Route::post('/teachers/login', 'Teacher\Auth\LoginController@postLogin');
Route::get('/teachers/login/{id}', 'Teacher\Auth\LoginController@idLogin');
Route::get('teachers/logout', 'Teacher\Auth\LoginController@logout');
Route::group([
    'namespace' => 'Teacher', 'prefix' => 'teachers', 'middleware' => ['teachers']
], function () {

    require base_path('routes/teacher/teacher.php');
   
});

/*********************************** End Teacher Routes **************************************************/


App::singleton('setting', function () {
    return App\Setting::find(1);
});

App::singleton('lang', function () {
    return LaravelLocalization::getCurrentLocale();
});

App::singleton('urlLang', function () {
    if (LaravelLocalization::getCurrentLocale() == "ar")
        return "";
    else
        return "en/";
});

Route::get('login', 'Front\Auth\LoginController@Login')->name("login");
Route::post('login', 'Front\Auth\LoginController@postLogin');
Route::get('logout', 'Front\Auth\LoginController@logout');

   Route::get('/payment/paypal','PaymentController@showform')->name('show.form');
   Route::post('stripe', 'PaymentController@payWithstripe')->name('stripe.payment.post');
   Route::post('paypal', 'PaymentController@payWithpaypal')->name('paypal.payment.post');

// route for check status of the payment
Route::get('status', 'PaymentController@getPaymentStatus');
Route::group([
    'namespace' => 'Front', 'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localizationRedirect']
], function () {


    if (session()->get('locale') == null) {
        App::setLocale('ar');
        session()->put('locale', 'ar');
    }


    require base_path('routes/front/front.php');


});