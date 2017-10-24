<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 22/03/17
 * Time: 18.10
 */

 Route::group(['middleware' => ['auth','isAdmin','ForceSecure']], function () {


     Route::get('signing/{id}', array('as' => 'sign.signing','uses' => 'Api\ApiSignController@signing'));

 });



