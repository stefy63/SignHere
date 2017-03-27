<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 22/03/17
 * Time: 18.10
 */

 Route::group(['middleware' => ['auth','isAdmin']], function () {
     Route::get('/admin',function (){
         return view('/admin');
     });

     Route::resource('admin_acls','AdminBrandController');
     Route::resource('admin_brands','AdminBrandController');
     Route::resource('admin_clients','AdminBrandController');
     Route::resource('admin_devices','AdminBrandController');
     Route::resource('admin_doctypess','AdminBrandController');
     Route::resource('admin_documents','AdminBrandController');
     Route::resource('admin_locations','AdminBrandController');
     Route::resource('admin_modules','AdminBrandController');
     Route::resource('admin_users','AdminBrandController');


 });


