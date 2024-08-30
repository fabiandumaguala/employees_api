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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'prefix' => 'auth'

], function ($router) {
    Route::post('signup',  'Api\Auth\AuthController@signup');
    Route::post('login',   'Api\Auth\AuthController@login');
    Route::post('logout',  'Api\Auth\AuthController@logout');
    Route::post('refresh', 'Api\Auth\AuthController@refresh');
    Route::post('me',      'Api\Auth\AuthController@me');
});

Route::group([
    'middleware' => 'jwt.auth'
], function ($router) {
    //Employee
	Route::apiresource('employee', 'Api\EmployeeController');
});
