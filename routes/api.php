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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/official/regions', 'RegionController@getAllRegions');
Route::get('/official/stats', 'RegionController@getAllStats');


Route::post('/upload-region-incidents', 'RegionController@uploadRegionData');
Route::post('/upload-stats', 'RegionController@uploadOfficialStats');




