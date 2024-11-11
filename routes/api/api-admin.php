<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 22/03/17
 * Time: 18.10
 */

 Route::group(['middleware' => ['auth','isAdmin','ForceSecure']], function () {

     Route::get('signing/send_code', array('as' => 'sign.send_code','uses' => 'Api\ApiSignController@SendCode'));
     Route::get('signing/{id}', array('as' => 'sign.signing','uses' => 'Api\ApiSignController@signing'));
     Route::get('signing/show/{id}', array('as' => 'sign.show','uses' => 'Api\ApiSignController@show'));
     Route::post('signing/verify_code', array('as' => 'sign.verify_code','uses' => 'Api\ApiSignController@VerifyCode'));

 });



