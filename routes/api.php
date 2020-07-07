<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

URL::forceScheme('https');

//Partie user normal
Route::post('login', 'UserController@authenticate');
Route::post('register', 'StudentController@RegisterStudent');
Route::post('register-teacher', 'TeacherController@register');
Route::post('contact', 'HomeController@postContact');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Partie students
Route::group(['middleware' => 'assign.guard:student'], function () {
    Route::get('profile-student', 'StudentController@getAuthenticatedStudent');
    Route::get('students', 'StudentController@getStudents');
});

//Partie teachers
Route::group(['middleware' => 'assign.guard:teacher'], function () {

    Route::get('teachers', 'TeacherController@getTeachers');
    Route::get('profile-teacher', 'TeacherController@getAuthenticatedTeacher');
});

//Partie admin
Route::group(['middleware' => 'assign.guard:admin'], function () {


    Route::group(['namespace' => 'admin'], function () {
        Route::post('add-menu', 'MenuController@postAddmenu');
        Route::delete('delete-menu', 'MenuController@postDeletemenu');
        Route::post('add_submenu', 'MenuController@AddSubmenu');
        Route::get('all-menu', 'MenuController@getMenu');
        Route::get('load-menu', 'MenuController@Menuhome');

        //Category Course
        Route::post('add-category', 'CategoriesCoursesController@AddCategory');
    });
});




//config


//Clear route cache:
Route::get('/route-cache', function () {
    $exitCode = Artisan::call('route:cache');
    return 'Routes cache cleared';
});

//Clear config cache:
Route::get('/config-cache', function () {
    $exitCode = Artisan::call('config:cache');
    return 'Config cache cleared';
});

// Clear application cache:
Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    return 'Application cache cleared';
});

// Clear view cache:
Route::get('/view-clear', function () {
    $exitCode = Artisan::call('view:clear');
    return 'View cache cleared';
});

Route::get('/jwt-secret', function () {
    $exitCode = Artisan::call('jwt:secret');
    return 'View cache cleared';
});

Route::get('/update-composer', function () {

    shell_exec('apt-get install php5.6-mysql/php7.2-mysql');
    return 'comp updata';
});


Route::get('/migrate', function () {
    $exitCode = Artisan::call('migrate');
    return 'Config cache cleared';
});
