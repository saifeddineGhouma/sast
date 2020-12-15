<?php 
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
    Route::get('/pages/{slug}', 'SiteController@fv');
    Route::get('/PDF/{id}/{client}', 'HomeController@getPDF');


 /******** */
    Route::get('courses/quiz-attempt', 'CoursesController@quizAttempt');
    Route::get('courses/quiz-result', 'CoursesController@quizResult');
    Route::post('courses/save-course-review/{course_id}', 'CoursesController@postSaveCourseReview');
    Route::get('courses/video-exam', 'CoursesController@videoExam');
    Route::post('courses/submit-video', 'CoursesController@postSubmitVideo');
    Route::post('courses/edit-video/{studentVideoExam_id}', 'CoursesController@postUpdateVideo');
    Route::post('courses/save-reply/{courseQuestion_id}', 'CoursesController@postSaveReply');
    Route::post('courses/submit-quiz/{studentQuiz_id}', 'CoursesController@postSubmitQuiz')->name('post.submit.quiz');
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
    /*facture*/
    Route::get('generate/facture','CheckoutController@generateFacture')->name('generate.facture');
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
    /*mes factures */
    Route::get('account/factures', 'AccountController@getfactures')->name('get.factures');

    /*end factures */
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

    ?>