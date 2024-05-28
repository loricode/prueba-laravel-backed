<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SecurityJWTController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CityController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::post('register', [SecurityJWTController::class, 'register']);


Route::group([
    'middleware' => 'api',
    'prefix' => 'country'
], function ($router) {
    Route::post('list', [CountryController::class, 'listCountries']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'city'
], function ($router) {
    Route::post('list', [CityController::class, 'listCities']);
    Route::post('detail', [CityController::class, 'detail']);
    Route::post('divisa', [CityController::class, 'getData']);
});


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('register', [SecurityJWTController::class, 'register']);
    Route::post('login', [SecurityJWTController::class, 'login']);
    //Route::post('logout', [SecurityJWTController::class, 'logout']);
    //Route::post('refresh', [SecurityJWTController::class, 'refresh']);
   // Route::get('profile', [SecurityJWTController::class, 'profile']);
});
