<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 22/03/17
 * Time: 18.10
 */

 Route::group(['middleware' => 'auth'], function () {
    Route::resource('admin','AdminController');
    //
 });


