<?php

use App\Http\Controllers\PositionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RequestFormController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
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

    //Unauthenticated Routes
    Route::post("/users/login",[UserController::class,'login']);
    Route::post("/users/register",[UserController::class,'register']);
    Route::get("/projects/create",[
        ProjectController::class,'create'
    ]);

    Route::post("/upload",[
        "uses" => "App\Http\Controllers\AppController@uploadFile",
        'roles' =>['employee','administrator']
    ]);

    Route::post("/upload/delete",[
        "uses" => "App\Http\Controllers\AppController@removeFile",
        'roles' =>['employee','administrator']
    ]);

    //Authenticated Routes
    Route::group(["middleware"=>["auth:sanctum","roles"]],function (){



        Route::group(['prefix'=>'positions'],function (){
            Route::get("/",[PositionController::class,'index']);
        });

        Route::group(['prefix'=>'users'],function (){
            Route::get("/",[UserController::class,'index']);

            Route::get("/view/{id}",[
                UserController::class,'show'
            ]);

            Route::post("/verify/{id}",[
                "uses" => "App\Http\Controllers\UserController@verify",
                'roles' =>['management']
            ]);

            Route::post("/disable/{id}",[
                "uses" => "App\Http\Controllers\UserController@disable",
                'roles' =>['management']
            ]);
        });

        Route::group(['prefix'=>'grades'],function (){
            Route::get("/",function (){
//            return
            });
        });

        Route::group(['prefix'=>'request-forms'],function (){

            Route::get("/",[
                "uses" => "App\Http\Controllers\RequestFormController@index",
                'roles' =>['employee','management']
            ]);

            Route::get("/approved",[
                "uses" => "App\Http\Controllers\RequestFormController@approved",
                'roles' =>['employee','management']
            ]);

            Route::get("/pending",[
                "uses" => "App\Http\Controllers\RequestFormController@pending",
                'roles' =>['employee','management']
            ]);

            Route::get("/view/{id}",[
                "uses" => "App\Http\Controllers\RequestFormController@show",
                'roles' =>['employee','management']
            ]);

            Route::post("/",[
                "uses" => "App\Http\Controllers\RequestFormController@store",
                'roles' =>['employee','management']
            ]);

            Route::post("/approve/{id}",[
                "uses" => "App\Http\Controllers\RequestFormController@approve",
                'roles' =>['employee','management']
            ]);

            Route::post("/deny/{id}",[
                "uses" => "App\Http\Controllers\RequestFormController@deny",
                'roles' =>['employee','management']
            ]);

            Route::post("/edit/{id}",[
                "uses" => "App\Http\Controllers\RequestFormController@update",
                'roles' =>['employee','management']
            ]);

            Route::post("/initiate/{id}",[
                "uses" => "App\Http\Controllers\RequestFormController@initiate",
                'roles' =>['accountant']
            ]);

            Route::post("/reconcile/{id}",[
                "uses" => "App\Http\Controllers\RequestFormController@reconcile",
                'roles' =>['accountant']
            ]);

        });

        Route::group(['prefix'=>'projects'],function (){

            Route::get("/",[
                ProjectController::class,'index'
            ]);

            Route::get("/view/{id}",[
                ProjectController::class,'show'
            ]);

            Route::post("/",[
                "uses" => "App\Http\Controllers\ProjectController@store",
                'roles' =>['administrator']
            ]);

            Route::post("/edit/{id}",[
                "uses" => "App\Http\Controllers\ProjectController@update",
                'roles' =>['administrator']
            ]);

            Route::post("/verify/{id}",[
                "uses" => "App\Http\Controllers\ProjectController@verify",
                'roles' =>['management']
            ]);

            Route::delete("/delete/{id}",[
                "uses" => "App\Http\Controllers\ProjectController@destroy",
                'roles' =>['administrator']
            ]);

        });

        Route::group(['prefix'=>'vehicles'],function (){

            Route::get("/",[
                VehicleController::class,'index'
            ]);

            Route::get("/view/{id}",[
                VehicleController::class,'show'
            ]);

            Route::post("/",[
                "uses" => "App\Http\Controllers\VehicleController@store",
                'roles' =>['administrator']
            ]);

            Route::post("/edit/{id}",[
                "uses" => "App\Http\Controllers\VehicleController@update",
                'roles' =>['administrator']
            ]);

            Route::post("/verify/{id}",[
                "uses" => "App\Http\Controllers\VehicleController@verify",
                'roles' =>['management']
            ]);

            Route::delete("/delete/{id}",[
                "uses" => "App\Http\Controllers\VehicleController@destroy",
                'roles' =>['administrator']
            ]);

        });

    });

});
