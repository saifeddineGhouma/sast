<?php

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

?>