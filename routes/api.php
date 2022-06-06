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
Route::group(['prefix'=>'1.0.0'],function (){

    Route::group(['prefix'=>'positions'],function (){
        Route::get("/",function (){
            $positions= \App\Models\Position::orderBy('title','asc')->get();
            return response()->json($positions);
        });
    });

    Route::group(['prefix'=>'grades'],function (){
        Route::get("/",function (){
//            return
        });
    });

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
