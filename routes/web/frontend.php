<?php

Route::group(['middleware' => 'auth'], function () {


    // Route for Sign //
   Route::resource('sign','SignController');
   Route::get('sign/destroy/{id}', array('as' => 'sign.destroy','uses' => 'SignController@destroy'));
   Route::get('sign/signing/{id}', array('as' => 'sign.signing','uses' => 'SignController@signing'));



});