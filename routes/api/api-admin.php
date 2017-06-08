<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 22/03/17
 * Time: 18.10
 */

 Route::group(['prefix' => 'api/v1/', 'middleware' => ['auth','isAdmin','ForceSecure']], function () {



 });



