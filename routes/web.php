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



    Route::get('/', 'HomeController@getIndex');
    Route::get('/login-user/{user_id}', 'HomeController@loginUser');
    Route::get('logout', 'HomeController@getLogout1');
    Route::post('/home/sendemail', 'HomeController@postSendemail');

    Route::get('/stage', 'StudentsStageController@getStudentStage');
    Route::get('/stages/{valid}/{stage}', 'StudentsStageController@UpdateStage');
    // Route::get('/stage/{valid}/{stage}', 'StudentsStageController@getStudentStage');

    Route::get('/view_stage/{stage}', 'StudentsStageController@ViewDemandeStage');
    Route::get('/view_evaluation/{stage}', 'StudentsStageController@ViewFileStage');


    //USER verify CPD

    Route::get('/user_cpd', 'StudentCertifCPDController@getUserVerifyCPD');
    Route::get('/update_user_cpd/{valid}/{userverify}', 'StudentCertifCPDController@UpdateVerifyCPD');
    // Route::get('/stage/{valid}/{stage}', 'StudentsStageController@getStudentStage');

    Route::get('/view_user_cpd/{userverify}', 'StudentCertifCPDController@ViewCertifVerify');


    Route::get('/roles', 'rolesController@getIndex');
    Route::get('/roles/create', 'rolesController@getCreate');
    Route::post('/roles/create', 'rolesController@postCreate');
    Route::get('/roles/edit/{id}', 'rolesController@getEdit');
    Route::post('/roles/edit/{id}', 'rolesController@postEdit');
    Route::post('/roles/delete/{id}', 'rolesController@postDelete');

    Route::get('/admins', 'adminsController@getIndex');
    Route::get('/admins/create', 'adminsController@getCreate');
    Route::post('/admins/create', 'adminsController@postCreate');
    Route::get('/admins/edit/{id}', 'adminsController@getEdit');
    Route::post('/admins/edit/{id}', 'adminsController@postEdit');
    Route::post('/admins/delete/{id}', 'adminsController@postDelete');
    Route::post('/admins/deleteimaeajax', 'adminsController@postDeleteimaeajax');


    Route::get('/reviews', 'reviewsController@getIndex');
    Route::get('/reviews/searchresults', 'reviewsController@getSearchresults');
    Route::post('/reviews/delete/{id}', 'reviewsController@postDelete');
    Route::post('/reviews/updatestateajax', 'reviewsController@postUpdatestateajax');
    Route::get('/reviews/reply/{id}', 'reviewsController@reply');
    Route::post('/reviews/reply/create', 'reviewsController@createreply');

    Route::get('/users', 'usersController@getIndex');
    Route::get('/users/searchresults', 'usersController@getSearchresults');
    Route::get('/users/create', 'usersController@getCreate');
    Route::post('/users/create', 'usersController@postCreate');
    Route::get('/users/edit/{id}', 'usersController@getEdit');
    Route::post('/users/edit/{id}', 'usersController@postEdit');
    Route::post('/users/delete/{id}', 'usersController@postDelete');
    Route::get('/users/view/{id}', 'usersController@getView');
    Route::post('/users/editfield', 'usersController@postEditfield');
    Route::post('/users/editimage', 'usersController@postEditimage');
    Route::post('/users/changepassword', 'usersController@postChangepassword');
    Route::get('/users/unique-username', 'usersController@getUniqueUsername');
    Route::get('/users/unique-email', 'usersController@getUniqueEmail');
    Route::get('/users/unique-mobile', 'usersController@getUniqueMobile');
    Route::post('/users/deleteimaeajax', 'usersController@postDeleteimaeajax');
    Route::post('/users/updatestateajax', 'usersController@postUpdatestateajax');
    Route::get('/users/governments', 'usersController@getGovernments');
    Route::post('users/merge', 'usersController@postMerge');

    Route::get('/students', 'studentsController@getIndex');
    Route::get('/students/searchresults', 'studentsController@getSearchresults');

    Route::get('/students/create', 'studentsController@getCreate');
    Route::post('/students/create', 'studentsController@postCreate');
    Route::get('/students/edit/{id}', 'studentsController@getEdit');
    Route::post('/students/edit/{id}', 'studentsController@postEdit');
    Route::post('/students/delete/{id}', 'studentsController@postDelete');
    /*********blocked students******* */
    Route::post('/students/blocked/{id}', 'studentsController@postBlocked');
    /*************end blocked *** */
    Route::get('/students/user-details', 'studentsController@getUserDetails');
    Route::get('/students/unique-user', 'studentsController@getUniqueUser');

    Route::get('/teachers', 'teachersController@getIndex');
    Route::get('/teachers/create', 'teachersController@getCreate');
    Route::post('/teachers/create', 'teachersController@postCreate');
    Route::get('/teachers/edit/{id}', 'teachersController@getEdit');
    Route::post('/teachers/edit/{id}', 'teachersController@postEdit');
    Route::post('/teachers/delete/{id}', 'teachersController@postDelete');
    Route::post('/teachers/updatestateajax', 'teachersController@postUpdatestateajax');
    Route::get('/teachers/unique-user', 'teachersController@getUniqueUser');

    Route::get('/newsletter', 'newsletterController@getIndex');
    Route::get('/newsletter/subscribers', 'newsletterController@getSubscribers');
    Route::get('/newsletter/create', 'newsletterController@getCreate');
    Route::post('/newsletter/create', 'newsletterController@postCreate');
    Route::get('/newsletter/edit/{id}', 'newsletterController@getEdit');
    Route::post('/newsletter/edit/{id}', 'newsletterController@postEdit');
    Route::post('/newsletter/deletesubscriber/{id}', 'newsletterController@postDeletesubscriber');
    Route::post('/newsletter/delete/{id}', 'newsletterController@postDelete');
    Route::get('/newsletter/template/{id}', 'newsletterController@getTemplate');
    Route::post('/newsletter/updatestateajax', 'newsletterController@postUpdatestateajax');

    Route::get('/news', 'newsController@getIndex');
    Route::get('/news/searchresults', 'newsController@getSearchresults');
    Route::get('/news/create', 'newsController@getCreate');
    Route::post('/news/create', 'newsController@postCreate');
    Route::get('/news/edit/{id}', 'newsController@getEdit');
    Route::post('/news/edit/{id}', 'newsController@postEdit');
    Route::post('/news/delete/{id}', 'newsController@postDelete');
    Route::post('/news/updatestateajax', 'newsController@postUpdatestateajax');
    Route::get('/news/unique-slug', 'newsController@getUniqueSlug');

    Route::get('/emailtemplates', 'EmailtemplatesController@getIndex');
    Route::get('/emailtemplates/create', 'EmailtemplatesController@getCreate');
    Route::post('/emailtemplates/create', 'EmailtemplatesController@postCreate');
    Route::get('/emailtemplates/edit/{id}', 'EmailtemplatesController@getEdit');
    Route::post('/emailtemplates/edit/{id}', 'EmailtemplatesController@postEdit');
    Route::post('/emailtemplates/delete/{id}', 'EmailtemplatesController@postDelete');
    Route::post('/emailtemplates/updatestateajax', 'EmailtemplatesController@postUpdatestateajax');
    Route::post('/emailtemplates/sendtestmail', 'EmailtemplatesController@postSendtestmail');

    Route::get('/settings/edit', 'SettingsController@getEdit');
    Route::post('/settings/edit', 'SettingsController@postEdit');
    Route::post('/settings/deleteimaeajax', 'SettingsController@postDeleteimaeajax');

    Route::get('/menus', 'menusController@getIndex');
    Route::get('/menus/links/{menuId}', 'menusController@getLinks');
    Route::post('/menus/savetree', 'menusController@postSavetree');
    Route::post('/menus/addmenu', 'menusController@postAddmenu');
    Route::post('/menus/deletemenu', 'menusController@postDeletemenu');
    Route::get('/menus/tab2content', 'menusController@getTab2content');
    Route::post('/menus/savemenupos', 'menusController@postSavemenupos');

    Route::get('/pages', 'pagesController@getIndex');
    Route::get('/pages/create', 'pagesController@getCreate');
    Route::post('/pages/create', 'pagesController@postCreate');
    Route::get('/pages/edit/{id}', 'pagesController@getEdit');
    Route::post('/pages/edit/{id}', 'pagesController@postEdit');
    Route::post('/pages/delete/{id}', 'pagesController@postDelete');
    Route::post('/pages/updatestateajax', 'pagesController@postUpdatestateajax');
    Route::get('/pages/unique-slug', 'pagesController@getUniqueSlug');

    Route::get('categories/unique-slug', 'categoriesController@uniqueSlug');
    Route::get('categories/unique-name', 'categoriesController@uniqueName');
    Route::post('categories/delete/{id}', 'categoriesController@delete');
    Route::get('categories/listing-ajax', 'categoriesController@listingAjax');
    Route::resource('categories', 'categoriesController');

    Route::get('/countries', 'countriesController@getIndex');
    Route::post('/countries/create', 'countriesController@postCreate');
    Route::post('/countries/edit/{id}', 'countriesController@postEdit');
    Route::post('/countries/delete/{id}', 'countriesController@postDelete');
    Route::get('/countries/unique-name', 'countriesController@getUniqueName');

    Route::get('/governments', 'governmentsController@getIndex');
    Route::get('/governments/searchgovernments/{countryId}', 'governmentsController@getSearchgovernments');
    Route::post('/governments/create', 'governmentsController@postCreate');
    Route::post('/governments/edit/{id}', 'governmentsController@postEdit');
    Route::post('/governments/delete/{id}', 'governmentsController@postDelete');
    Route::get('/governments/unique-name', 'governmentsController@getUniqueName');

    Route::get('/agents', 'agentsController@getIndex');
    Route::get('/agents/searchagents/{countryId}', 'agentsController@getSearchagents');
    Route::post('/agents/create', 'agentsController@postCreate');
    Route::post('/agents/edit/{id}', 'agentsController@postEdit');
    Route::post('/agents/delete/{id}', 'agentsController@postDelete');
    Route::post('/agents/updatestateajax', 'agentsController@postUpdatestateajax');

    Route::get('courses/unique-slug', 'coursesController@uniqueSlug');
    Route::post('courses/delete/{id}', 'coursesController@delete');
    Route::get('courses/listing-ajax', 'coursesController@listingAjax');
    Route::post('courses/updatestateajax', 'coursesController@postUpdatestateajax');
    Route::get('courses/listing', 'coursesController@listing');
    Route::get('courses/governments', 'coursesController@governments');
    Route::post('courses/merge', 'coursesController@postMerge');
    Route::post('courses/import', 'coursesController@postImport');
    Route::resource('courses', 'coursesController');

    Route::get('packs', 'packsController@getIndex');
    Route::get('packs/create', 'packsController@getCreate');
    Route::post('packs/create', 'packsController@postCreate');
    Route::get('packs/edit/{id}', 'packsController@getedit');
    Route::post('packs/edit/{id}', 'packsController@postedit');
    Route::post('/packs/deleteimaeajax', 'packsController@postDeleteimaeajax');
    Route::post('packs/delete/{id}', 'packsController@postDelete');
    Route::post('/packs/updatestateajax', 'packsController@postUpdatestateajax');

    Route::get('/coupons', 'couponsController@getIndex');
    Route::get('/coupons/create', 'couponsController@getCreate');
    Route::post('/coupons/create', 'couponsController@postCreate');
    Route::get('/coupons/edit/{id}', 'couponsController@getEdit');
    Route::post('/coupons/edit/{id}', 'couponsController@postEdit');
    Route::post('/coupons/delete/{id}', 'couponsController@postDelete');
    Route::get('/coupons/unique-number', 'couponsController@getUniqueNumber');

    Route::get('/orders', 'ordersController@getIndex');
    Route::get('/orders/searchresults', 'ordersController@getSearchresults');
    Route::get('/orders/edit/{id}', 'ordersController@getEdit');
    Route::post('/orders/edit/{id}', 'ordersController@postEdit');
    Route::get('/orders/report/{id}', 'ordersController@getReport');
    Route::post('/orders/delete-payment/{id}', 'ordersController@deletePayment');
    Route::post('orders/delete/{id}', 'ordersController@postDelete');
    Route::post('/orders/create-payment', 'ordersController@createPayment');
    Route::post('/orders/edit-payment/{id}', 'ordersController@editPayment');
    Route::get('/orders/move-courses', 'ordersController@moveCourses');
    Route::get('/orders/move-students', 'ordersController@moveOrderProductsStudents');

    Route::get('books/unique-slug', 'booksController@uniqueSlug');
    Route::get('books/unique-name', 'booksController@uniqueName');
    Route::post('books/delete/{id}', 'booksController@delete');
    Route::resource('books', 'booksController');

    Route::get('/book-orders', 'bookordersController@getIndex');
    Route::get('/book-orders/searchresults', 'bookordersController@getSearchresults');
    Route::get('/book-orders/edit/{id}', 'bookordersController@getEdit');
    Route::post('/book-orders/edit/{id}', 'bookordersController@postEdit');
    Route::get('/book-orders/report/{id}', 'bookordersController@getReport');

    Route::get('quizzes/unique-slug', 'quizzesController@uniqueSlug');
    Route::get('quizzes/unique-name', 'quizzesController@uniqueName');
    Route::post('quizzes/delete/{id}', 'quizzesController@delete');
    Route::resource('quizzes', 'quizzesController');

    Route::post('questions/delete/{id}', 'questionsController@delete');
    Route::resource('questions', 'questionsController');

    Route::get('videoexams/unique-slug', 'videoexamsController@uniqueSlug');
    Route::post('videoexams/delete/{id}', 'videoexamsController@delete');
    Route::resource('videoexams', 'videoexamsController');

    Route::get('students-exams/listing', 'studentsexamsController@listing');
    Route::get('students-exams/listing-ajax', 'studentsexamsController@listingAjax');
    Route::post('students-exams/delete/{id}', 'studentsexamsController@delete');
    Route::resource('students-exams', 'studentsexamsController');
    /****stage and study case *****/
    Route::get('students-stages','studentsexamsController@indexStageStudycase')->name('students.stage') ;
     Route::get('students-studycase','studentsexamsController@indexStudycase')->name('students.studycase') ;

     Route::get('students-studycase-edit/{id}','studentsexamsController@editstudycase')->name('students.studycase.edit');
    /********update*******/
     Route::get('students-stage-update/{id}','studentsexamsController@EditStatusStage')->name('students.stage.update') ;
      Route::post('students-studycase-update/{id}','studentsexamsController@EditStatusStudycase')->name('students.studycase.update') ;

     
    Route::get('/testimonials', 'testimonialsController@getIndex');
    Route::get('/testimonials/create', 'testimonialsController@getCreate');
    Route::post('/testimonials/create', 'testimonialsController@postCreate');
    Route::get('/testimonials/edit/{id}', 'testimonialsController@getEdit');
    Route::post('/testimonials/edit/{id}', 'testimonialsController@postEdit');
    Route::post('/testimonials/delete/{id}', 'testimonialsController@postDelete');
    Route::post('/testimonials/updatestateajax', 'testimonialsController@postUpdatestateajax');

    Route::get('/faq', 'faqController@getIndex');
    Route::post('/faq/create', 'faqController@postCreate');
    Route::post('/faq/edit/{id}', 'faqController@postEdit');
    Route::post('/faq/delete/{id}', 'faqController@postDelete');

    Route::get('certificates/test', 'certificatesController@test');
    Route::post('certificates/delete/{id}', 'certificatesController@delete');
    Route::get('certificates/export/{id}', 'certificatesController@getExport');
    Route::post('certificates/export/{id}', 'certificatesController@postExport');
    Route::get('certificates/students', 'certificatesController@getStudents');
    Route::resource('certificates', 'certificatesController');

    Route::get('students-certificates', 'studentscertificatesController@index');
    Route::post('students-certificates/delete', 'studentscertificatesController@delete');
    Route::post('/students-certificates/updatestateajax', 'studentscertificatesController@postUpdatestateajax');
    Route::get('students-certificates/listing-ajax', 'studentscertificatesController@listingAjax');
    Route::get('students-certificates/mail/{id}', 'studentscertificatesController@envmail');
    Route::get('/students-certificates/sendmail/{id}', 'studentscertificatesController@sendmail');
    Route::post('/students-certificates/changedate', 'studentscertificatesController@changedate');
    Route::post('/students-certificates/changestatus', 'studentscertificatesController@changestatus');


    Route::get('barcodes', 'barcodesController@index');
    Route::post('barcodes/delete', 'barcodesController@delete');
    Route::get('barcodes/listing-ajax', 'barcodesController@listingAjax');

    Route::get('trans-courses', 'transdataController@courses');
    Route::get('trans-quizzes', 'transdataController@quizzes');
    Route::get('trans-questions', 'transdataController@questions');
    Route::get('trans-accounts', 'transdataController@accounts');
    Route::get('trans-books', 'transdataController@books');
    Route::get('trans-books_orders', 'transdataController@books_orders');
    Route::get('trans-exams', 'transdataController@exams');
    Route::get('trans-videos', 'transdataController@videos');
    Route::get('trans-orders', 'transdataController@orders');
    Route::get('trans-certificates', 'transdataController@certificates');
    Route::get('trans-studentcertificates', 'transdataController@studentCertificates');


    Route::get('trans-users_edit', 'transdataController@usersEdit');

    Route::get('trans-courses-images', 'transdataController@coursesImages');
    Route::get('trans-question-images', 'transdataController@questionImages');
    Route::get('trans-account-images', 'transdataController@accountImages');
    Route::get('trans-book-images', 'transdataController@bookImages');
    Route::get('trans-order-images', 'transdataController@orderImages');
    Route::get('trans-video-images', 'transdataController@videoImages');
    Route::get('trans-certificates-images', 'transdataController@certificateImages');

    Route::get('trans-studentcertificates-images', 'transdataController@studentcertificateImages');

    Route::get('trans-studentcertificates1-images', 'transdataController@studentcertificate1Images');
    Route::get('trans-barcodes', 'transdataController@barcodes');
    Route::get('trans-test', 'transdataController@test');

    Route::get('/forum', 'forumController@getIndex');
    Route::get('/forum/searchresults', 'forumController@getSearchresults');
    Route::get('/forum/edit/{id}', 'forumController@getEdit');
    Route::post('/forum/edit/{id}', 'forumController@postEdit');
    Route::post('forum/delete/{id}', 'forumController@postDelete');
    Route::post('/forum/updatestateajax', 'forumController@postUpdatestateajax');

    Route::get('/notifications', 'notificationsController@index');
    Route::post('/notifications/delete/{id}', 'notificationsController@postDelete');

    Route::get('/historiques', 'historiquesController@index');

    Route::get('/invoice', 'facturesController@getIndex');
    Route::get('/invoice/create', 'facturesController@getCreate');
    Route::post('/invoice/create', 'facturesController@postCreate');
    Route::post('/invoice/delete/{id}', 'facturesController@postDelete');
    Route::get('/invoice/edit/{id}', 'facturesController@getEdit');
    Route::post('/invoice/edit/{id}', 'facturesController@postEdit');
    Route::get('/invoice/create/{id}', 'facturesController@createEdit');
    Route::get('/invoice/view/{id}', 'facturesController@view');
    Route::get('/invoice/send/{id}', 'facturesController@send');
    Route::get('/invoice/pdf/{id}', 'facturesController@getPDF');

    Route::get('/seo', 'seoController@index');
    Route::get('/seo/edit/{id}', 'seoController@edit');
    Route::post('/seo/edit/{id}', 'seoController@update');

    Route::get('/ticket', 'ticketController@index');
    Route::get('/ticket/edit/{id}', 'ticketController@edit');
    Route::post('/ticket/update', 'ticketController@createTicket');
    Route::get('/ticket/close/{id}', 'ticketController@closeTicket');





    /*****   test rouuuute    ********/
    Route::get('/testingapp', 'TestController@testEmail');
    Route::post('/register-photo', 'TestController@registerImage');

    Route::get('lang/{locale}', 'HomeController@lang');
    /***** route ajouté par sami ******/
    Route::get('/direct-order', 'directOrderController@index');
    Route::post('/create', 'directOrderController@create');
    Route::post('/create-order', 'directOrderController@createOrder');
    Route::post('/search-user', 'directOrderController@searchUser');
    Route::post('/edit', 'directOrderController@edit');
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
    Route::get('/', 'HomeController@getIndex')->name('teacherIndex');
    Route::get('/courses', 'coursesController@index');
    Route::get('/courses/view/{id}', 'coursesController@view');
    Route::get('/students-exams', 'studentsexamsController@index');
    Route::get('students-exams/listing-ajax', 'studentsexamsController@listingAjax');
    Route::get('/students-certificates', 'studentscertificatesController@index');



   


    Route::get('/forum', 'forumController@getIndex');
    Route::get('/forum/searchresults', 'forumController@getSearchresults');
    Route::get('/forum/edit/{id}', 'forumController@getEdit');
    Route::post('/forum/edit/{id}', 'forumController@postEdit');
    Route::post('forum/delete/{id}', 'forumController@postDelete');
    Route::post('/forum/updatestateajax', 'forumController@postUpdatestateajax');

    Route::get('/notifications', 'notificationsController@index');
    Route::get('/coupons', 'couponsController@getIndex');

    Route::get('/students', 'studentsController@getIndex');
    Route::get('/students/searchresults', 'studentsController@getSearchresults');
    Route::resource('students-exams', 'studentsexamsController');

    Route::get('/users/view/{id}', 'usersController@getView');
    Route::get('/reviews', 'reviewsController@getIndex');
    Route::get('/reviews/searchresults', 'reviewsController@getSearchresults');
    Route::get('/reviews/reply/{id}', 'reviewsController@reply');
    Route::post('/reviews/reply/create', 'reviewsController@createreply');
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

//Route::get('sitemap', function(){
//
//    // create new sitemap object
//    $sitemap = App::make("sitemap");
//    $date = null;
//    // add item to the sitemap (url, date, priority, freq)
//
//    $sitemap->add(URL::to('/'), $date, '1.0', 'daily');
//    //$sitemap->add(URL::to('/ar'), $date, '1.0', 'daily');
//    // $sitemap->add(URL::to('page'), '2012-08-26T12:30:00+02:00', '0.9', 'monthly');
//    $sitemap->add(URL::to('/contact'), $date, '0.9', 'weekly');
//    //$sitemap->add(URL::to('/ar/contact'), $date, '0.9', 'weekly');
//
//    $sitemap->add(URL::to('/faq'), $date, '0.6', 'weekly');
//    $sitemap->add(URL::to('/'), $date, '0.6', 'weekly');
//
//    $sitemap->add(URL::to('/faq'), $date, '0.6', 'weekly');
//    $sitemap->add(URL::to('/graduates'), $date, '0.6', 'weekly');
//
//    $pages = \App\Page::where('active',1)->get();
//    foreach($pages as $page){
//        $sitemap->add(URL::to('/pages/'.$page->page_trans("en")->slug), $page->updated_at, '0.6', 'weekly');
//        // $sitemap->add(URL::to('/ar/pages/'.$page->page_trans("ar")->slug), $page->updated_at, '0.6', 'weekly');
//    }
//
//    $courseTypes = \App\CourseType::where('course_types.type', '=', 'online')
//        ->orWhereHas('couseType_variations', function ($query) {
//            $now = date("Y-m-d");
//            $query->where('course_types.type', '=', 'presence')
//                ->where('coursetype_variations.date_from', '>=', $now);
//        })->get();
//    foreach($courseTypes as $courseType){
//        $sitemap->add(URL::to('/courses/'.$courseType->id), $courseType->course->updated_at, '0.6', 'daily');
//        //$sitemap->add(URL::to('/ar/blog/tag/'.$tag->tag_trans("ar")->slug), $tag->updated_at, '0.6', 'daily');
//    }
//
//    $sitemap->add(URL::to('/books'), $date, '0.6', 'weekly');
//    $books = \App\Book::get();
//    foreach($books as $book){
//        $sitemap->add(URL::to('/books/'.$book->book_trans("ar")->slug), $book->updated_at, '0.6', 'daily');
//        //$sitemap->add(URL::to('/ar/blog/'.$category->category_trans("ar")->slug), $category->updated_at, '0.6', 'daily');
//    }
//
//    $categories = \App\Category::get();
//    $sitemap->add(URL::to('/all-courses'), $date, '0.6', 'weekly');
//    foreach($categories as $category){
//        $sitemap->add(URL::to('/'.$category->category_trans("ar")->slug), $category->updated_at, '0.6', 'daily');
//        //$sitemap->add(URL::to('/ar/'.$category->category_trans("ar")->slug), $category->updated_at, '0.6', 'daily');
//    }
//
//    return $sitemap->render('xml');
//});

Route::get('login', 'Front\Auth\LoginController@Login')->name("login");
Route::post('login', 'Front\Auth\LoginController@postLogin');
Route::get('logout', 'Front\Auth\LoginController@logout');


Route::group([
    'namespace' => 'Front', 'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localizationRedirect']
], function () {
    if (session()->get('locale') == null) {
        App::setLocale('ar');
        session()->put('locale', 'ar');
    }
    Route::get('/', 'SiteController@getIndex');
    Route::get('convert_pdf/{id}/{client}', 'HomeController@convertToPDF')->name('convertToPDF');
    Route::get('description_course', 'HomeController@getDescriptionCourse')->name('getDescriptionCourse');

    Route::get('payement_plus', 'HomeController@getPayment')->name('getPayment');


    Route::get('download_eval', 'HomeController@downloadEvaluation')->name('downloadEval');
    Route::get('download_eval_arab', 'HomeController@downloadEvaluationArab')->name('downloadEvaluationArab');
    Route::get('addStudLang/{lang}/{user}', 'StudentStudLangController@addStudLang')->name('add.student.lang');


    Route::get('download_stage', 'HomeController@downloadDemandeStage')->name('downloadStage');
    Route::get('download_stage_arab', 'HomeController@downloadDemandeStageArab')->name('downloadDemandeStageArab');
    //Route::get('download_evaluation', 'HomeController@downloadEvaluation');
    Route::get('lang/{locale}', 'HomeController@lang');

    Route::get('/12ZERFTGZ444/GGGG6675', 'CronController@cron');
    Route::get('/naderisback/pass_script', 'CronController@pass_script');
    Route::get('/naderisback/correction_script', 'CronController@correction_script');
    Route::get('/naderisback/coupons_script', 'CronController@coupons_script');
    Route::get('courses/script', 'CronController@script');

    Route::post('register', 'Auth\RegisterController@register');
    Route::get('facebooklogin', 'Auth\LoginController@getFacebooklogin');
    Route::get('twitterlogin', 'Auth\LoginController@getTwitterlogin');
    Route::get('googlelogin', 'Auth\LoginController@getGooglelogin');
    Route::get('/callbackfacebook', 'Auth\LoginController@getCallbackfacebook');
    Route::get('/callbacktwitter', 'Auth\LoginController@getCallbacktwitter');
    Route::get('/callbackgoogle', 'Auth\LoginController@getCallbackgoogle');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset/{token?}', 'Auth\ResetPasswordController@showResetForm');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::get('/contact', 'SiteController@getContact');
    Route::post('/contact', 'SiteController@postContact');
    Route::get('/faq', 'SiteController@getFaq');
    Route::get('/graduates', 'SiteController@getGraduates');

    //Partnership 
    Route::get('/partnership', 'SiteController@partnership')->name('partnership');
    Route::post('/partnership', 'SiteController@postPartnerShip')->name('postPartnerShip');

    //Route::get('/load-courses', 'SiteController@loadCourses');
    Route::get('/load-graduates', 'SiteController@loadGraduates');
    Route::get('/load-graduatesf', 'SiteController@loadGraduatesf');
    Route::get('/load-graduatesfaa', function () {
        $result =  DB::select('select * from students_certificates where active = ?', [1]);
        return response()->json($result);
        //var_dump($result);
    });
    Route::get('/certificates/{serialNumber}', 'SiteController@certificates');

    Route::get('/search', 'SiteController@getSearch');
    Route::get('/promo/{user_id}', 'SiteController@promo');
    Route::get('/newsletter-verification', 'SiteController@getNewsletterVerification');
    Route::get('/user-verification', 'SiteController@getUserVerification');
    Route::get('/mobile-verification', 'SiteController@getMobileVerification');
    Route::post('home/savenewsletter', 'HomeController@savenewsletter');
    Route::get('home/checkemail', 'HomeController@getCheckemail');
    Route::get('home/governments', 'HomeController@getGovernments');
    Route::get('home/agents', 'HomeController@getAgents');
    Route::get('home/unique-username', 'HomeController@getUniqueUsername');
    Route::get('home/unique-email', 'HomeController@getUniqueEmail');
    Route::get('home/unique-mobile', 'HomeController@getUniqueMobile');
    Route::get('/pages/{slug}', 'SiteController@getPage');
    Route::get('/PDF/{id}/{client}', 'HomeController@getPDF');


 /******** */
    Route::get('courses/quiz-attempt', 'CoursesController@quizAttempt');
    Route::get('courses/quiz-result', 'CoursesController@quizResult');
    Route::post('courses/save-course-review/{course_id}', 'CoursesController@postSaveCourseReview');
    Route::get('courses/video-exam', 'CoursesController@videoExam');
    Route::post('courses/submit-video', 'CoursesController@postSubmitVideo');
    Route::post('courses/save-reply/{courseQuestion_id}', 'CoursesController@postSaveReply');
    Route::post('courses/submit-quiz/{studentQuiz_id}', 'CoursesController@postSubmitQuiz');
    Route::get('courses/studies', 'CoursesController@getStudies');
    Route::get('courses/{coursetype_id}', 'CoursesController@getView');
    /***study case  */
    Route::post('courses/submit-study-case', 'CoursesController@postStudyCase')->name('post.study.case');
 /*********submitgetsujet */
 Route::post('/submitgetsujet', 'CoursesController@submitgetsujet')->name('submit.get.sujet');

 Route::post('/user-add-lang','StudentStudLangController@addStudLangNew')->name('user.add.lang');

    Route::get('publication/{type}', 'NewsController@getIndex');
    Route::get('publication/{type}/{slug}', 'NewsController@getView');

    Route::post('cart/add-to-cart', 'CartController@postAddToCart');
    Route::post('cart/deletefromcart', 'CartController@postDeletefromcart');
    Route::post('cart/updatecart', 'CartController@postUpdatecart');
    Route::get('cart/clear', 'CartController@getClear');
    Route::get('cart', 'CartController@getIndex');

    Route::get('checkout', 'CheckoutController@getIndex');
    Route::post('checkout/info', 'CheckoutController@postInfo');
    Route::get('checkout/payment', 'CheckoutController@getPayment');
    Route::post('checkout/payment', 'CheckoutController@postPayment');
    Route::get('checkout/details', 'CheckoutController@getDetails');
    Route::get('checkout/confirm', 'CheckoutController@getConfirm');
    Route::post('checkout/checkout', 'CheckoutController@postCheckout');
    Route::get('checkout/return', 'CheckoutController@getReturn');
    Route::post('checkout/pay', 'CheckoutController@postPay');

    Route::get('/books', 'BooksController@index');
    Route::get('/books/download/{id}', 'BooksController@getDownload')->name("getDownload");
    Route::get('/books/{slug}', 'BooksController@getView');

    Route::get('account', 'AccountController@getIndex');
    Route::get('account/info', 'AccountController@getInfo');
    Route::post('account/info', 'AccountController@postInfo');
    Route::get('account/desactive', 'AccountController@getDes');
    Route::post('account/desactivee', 'AccountController@postDes');
    Route::get('account/change-password', 'AccountController@getChangePassword');
    Route::post('account/save-password', 'AccountController@postSavePassword');
    Route::get('account/points', 'AccountController@getPoints');
    Route::get('account/coupons', 'AccountController@getCoupons');
    Route::get('account/orders', 'AccountController@getOrders');
    Route::get('account/view/{id}', 'AccountController@getView');
    Route::post('account/banktransfer', 'AccountController@postBanktransfer');
    Route::get('account/certificates', 'AccountController@getCertificates');
    Route::get('account/books', 'AccountController@getBooks');
    Route::get('account/email-verification', 'AccountController@getEmailVerification');
    Route::get('account/mobile-verification', 'AccountController@getMobileVerification');
    Route::post('account/send-verify-message', 'AccountController@postSendVerifyMessage');
    Route::post('account/send-verify-message-mobile', 'AccountController@postSendVerifyMessageMobile');

    Route::get('account/ticket', 'AccountController@getTicket');
    Route::get('account/ticket/add', 'AccountController@addTicket');
    Route::post('account/ticket/create', 'AccountController@createTicket');
    Route::get('account/ticket/add/{id}', 'AccountController@add2Ticket');
    Route::post('account/ticket/create2', 'AccountController@create2Ticket');
    Route::get('account/ticket/success/{id}', 'AccountController@successTicket');
    Route::get('account/ticket/warning/{id}', 'AccountController@warningTicket');

    Route::get('/packs', 'PacksController@getIndex');
    Route::get('packs/{packs_id}', 'PacksController@getView');

    Route::get('/categories/productsmore', 'CategoriesController@getProductsmore');
    Route::get('/categories/reload-products', 'CategoriesController@getReloadProducts');
    Route::get('/{slug}', 'CategoriesController@getView');
});