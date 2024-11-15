<?php

Route::group(['middleware' => ['ForceSecure','auth']], function () {


    // Route for Sign //
   Route::resource('sign','SignController');
   Route::get('sign/destroy/{id}', array('as' => 'sign.destroy','uses' => 'SignController@destroy'));
   Route::get('sign/send/{id}', array('as' => 'sign.send','uses' => 'SignController@send'));
   Route::get('sign/signing/{id}', array('as' => 'sign.signing','uses' => 'SignController@signing'));
   Route::get('sign/signing_send/{id}', array('as' => 'sign.signing_send','uses' => 'SignController@signing_send'));
   Route::put('sign/store_signing/{id}', array('as' => 'sign.store_signing','uses' => 'SignController@store_signing'));
   Route::post('sign/sign_session', array('as' => 'sign.sign_session','uses' => 'SignController@sign_session'));

   // Route for change password //
    Route::get('home/resetpassword/{id}', array('as' => 'home.resetpassword','uses' => 'HomeController@resetPwd'));
    Route::Post('home/store_resetpassword', array('as' => 'home.store_resetpassword','uses' => 'HomeController@store_resetPwd'));


});
