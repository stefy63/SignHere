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

     // Route for ACLs //
     Route::resource('admin_acls','AdminAclController');
     // Route for Brands //
     Route::resource('admin_brands','AdminBrandController',array('except'=>array('destroy')));
     Route::get('admin_brands/destroy/{id}', array('as' => 'admin_brands.destroy','uses' => 'AdminBrandController@destroy'));
     // Route for Clients //
     Route::resource('admin_clients','AdminClientController');
     Route::resource('admin_devices','AdminDeviceController');
     Route::resource('admin_doctypess','AdminDoctypeController');
     Route::resource('admin_documents','AdminDocumentController');
     // Route for Locations //
     Route::resource('admin_locations','AdminLocationController');
     Route::get('admin_locations/destroy/{id}', array('as' => 'admin_locations.destroy','uses' => 'AdminLocationController@destroy'));

     Route::resource('admin_modules','AdminModuleController');
     Route::resource('admin_users','AdminUserController');


 });



