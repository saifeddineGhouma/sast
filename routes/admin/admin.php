<?php 

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
    Route::get('/students/update-lang','studentsController@updateLang')->name('update.lang');

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
     Route::get('courses/free','coursesController@activeFreeCourses');
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
    Route::get('students-stages','studentsexamsController@indexStage')->name('students.stage') ;
    Route::get('students-studycase','studentsexamsController@indexStudycase')->name('students.studycase') ;
    Route::get('stages/listing', 'studentsexamsController@listingstage')->name('stages.listing');

    Route::get('students-studycase-edit/{id}','studentsexamsController@editstudycase')->name('students.studycase.edit');
	Route::get('students-stage-edit/{id}','studentsexamsController@editstage')->name('students.stage.edit');
    Route::get('students-studycase/listing', 'studentsexamsController@listingstudycase')->name('studycase.listing');

    /********update*******/
    Route::post('students-stage-update/{id}','studentsexamsController@EditStatusStage')->name('students.stage.update') ;
    Route::post('students-studycase-update/{id}','studentsexamsController@EditStatusStudycase')->name('students.studycase.update') ;
   /*************course special*************/
   Route::get('courses_special','CourseSpecialController@index')->name('courses_special.index');
   Route::get('courses_special/listing', 'CourseSpecialController@listing');
   Route::get('courses_special-edit/{id}','CourseSpecialController@edit')->name('courses_special.edit');
    Route::post('courses_special-update/{id}','CourseSpecialController@update')->name('courses_special.update');
    Route::delete('courses_special-delete/{id}','CourseSpecialController@delete')->name('courses_special.delete');


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


?>