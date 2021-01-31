<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/device/register', 'App\Http\Controllers\DeviceController@create');
Route::post('/thirdparty', 'App\Http\Controllers\DeviceController@thirdparty');
Route::post('/subscription/purchase', 'App\Http\Controllers\SubscriptionController@purchase');
Route::get('/subscription/checksubscription', 'App\Http\Controllers\SubscriptionController@checksubscription');
Route::patch('/subscription/updatesubscriptionstatus', 'App\Http\Controllers\SubscriptionController@updateSubscriptionStatus');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
