<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|


Route::middleware('auth:api')->get('routes/user', function (Request $request) {
    return $request->user();
});
*/
 Route::group(['prefix' => 'api', 'middleware' => ['auth:api','ForceSecure']], function () {
     foreach ( new DirectoryIterator(base_path().DIRECTORY_SEPARATOR.'routes/api') as $fileinfo ) {
         if ($fileinfo->isFile() && $fileinfo->getExtension() == 'php'){
             require_once base_path() . DIRECTORY_SEPARATOR . 'routes/api' . DIRECTORY_SEPARATOR . $fileinfo->getFilename();
         }
     }
});
