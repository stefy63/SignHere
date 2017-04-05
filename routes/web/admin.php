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
     Route::get('admin_acls/destroy/{id}', array('as' => 'admin_acls.destroy','uses' => 'AdminAclController@destroy'));
     // Route for Brands //
     Route::resource('admin_brands','AdminBrandController',array('except'=>array('destroy')));
     Route::get('admin_brands/destroy/{id}', array('as' => 'admin_brands.destroy','uses' => 'AdminBrandController@destroy'));
     // Route for Clients //
     Route::resource('admin_clients','AdminClientController');
     Route::get('admin_clients/destroy/{id}', array('as' => 'admin_clients.destroy','uses' => 'AdminClientController@destroy'));
     // Route for devices //
     Route::resource('admin_devices','AdminDeviceController',array('except'=>array('destroy')));
     Route::get('admin_devices/destroy/{id}', array('as' => 'admin_devices.destroy','uses' => 'AdminDeviceController@destroy'));
     // Route for DocType //
     Route::resource('admin_doctypes','AdminDoctypeController');
     Route::get('admin_doctypes/destroy/{id}', array('as' => 'admin_doctypes.destroy','uses' => 'AdminDoctypeController@destroy'));
     // Route for Document //
     Route::resource('admin_documents','AdminDocumentController');
     Route::get('admin_documents/destroy/{id}', array('as' => 'admin_documents.destroy','uses' => 'AdminDocumentController@destroy'));
     // Route for Locations //
     Route::resource('admin_locations','AdminLocationController');
     Route::get('admin_locations/destroy/{id}', array('as' => 'admin_locations.destroy','uses' => 'AdminLocationController@destroy'));
     // Route for Modules //
     Route::resource('admin_modules','AdminModuleController');
     Route::get('admin_modules/destroy/{id}', array('as' => 'admin_modules.destroy','uses' => 'AdminModuleController@destroy'));
     // Route for Users //
     Route::resource('admin_users','AdminUserController', ['except' => ['show', 'destroy']]);
     Route::get('admin_users/destroy/{id}', array('as' => 'admin_users.destroy','uses' => 'AdminUserController@destroy'));
     Route::get('admin_users/permission/{id}', array('as' => 'admin_users.permission','uses' => 'AdminUserController@permission'));
     Route::put('admin_users/permission/{id}', array('as' => 'admin_users.store_permission','uses' => 'AdminUserController@store_permission'));
     Route::get('admin_users/resetPwd/{id}', array('as' => 'admin_users.resetPwd','uses' => 'AdminUserController@resetPwd'));
     Route::post('admin_users/resetPwd', array('as' => 'admin_users.update_resetPwd','uses' => 'AdminUserController@update_resetPwd'));



 });



