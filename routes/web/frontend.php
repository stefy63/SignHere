<?php

Route::group(['middleware' => 'auth'], function () {


    // Route for Sign //
   Route::resource('sign','SignController');




});
