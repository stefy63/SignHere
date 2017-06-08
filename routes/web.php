<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
     if(Auth::check())
        return view('home');
    else
        return view('welcome');

})->middleware('ForceSecure');


Route::get('logout',  array('as' => 'logout',function (){
     if(Auth::check()) {
         Auth::logout();
         return view('welcome');
     }
    else
        return view('welcome');
}))->middleware('ForceSecure');

//Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Auth::routes('ForceSecure');

Route::get('home', 'HomeController@index')->middleware('ForceSecure');

foreach ( new DirectoryIterator(base_path().DIRECTORY_SEPARATOR.'routes/web') as $fileinfo ) {
    if ($fileinfo->isFile() && $fileinfo->getExtension() == 'php'){
        require_once base_path() . DIRECTORY_SEPARATOR . 'routes/web' . DIRECTORY_SEPARATOR . $fileinfo->getFilename();
    }
}