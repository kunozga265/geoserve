<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

/*Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});*/

Route::group(['middleware'=>['auth:sanctum', 'verified']],function (){

    Route::get('/', [
        "uses"  => "App\Http\Controllers\RequestFormController@dashboard",
    ])->name('dashboard');

    Route::get('/index', [
        "uses"  => "App\Http\Controllers\RequestFormController@index",
    ])->name('index');

    Route::get('/approved', [
        "uses"  => "App\Http\Controllers\RequestFormController@approved",
    ])->name('approved');

    Route::get('/finance', [
        "uses"  => "App\Http\Controllers\RequestFormController@finance",
    ])->name('finance');


    Route::group(['prefix'=>'users'],function() {
        Route::get('/', [
            "uses" => "App\Http\Controllers\UserController@index",
        ])->name('users');

        Route::get('/view/{id}', [
            "uses" => "App\Http\Controllers\UserController@show",
        ])->name('users.show');

        Route::post('/verify/{id}', [
            "uses" => "App\Http\Controllers\UserController@verify",
        ])->name('users.verify');

        Route::post('/disable/{id}', [
            "uses" => "App\Http\Controllers\UserController@disable",
        ])->name('users.disable');

        Route::post('/discard/{id}', [
            "uses" => "App\Http\Controllers\UserController@discard",
        ])->name('users.discard');

    });

    Route::group(['prefix'=>'projects'],function(){
        Route::get('/', [
            "uses"  => "App\Http\Controllers\ProjectController@index",
        ])->name('projects');

        Route::get('/view/{id}', [
            "uses"  => "App\Http\Controllers\ProjectController@show",
        ])->name('projects.show');

        Route::get('/create', [
            "uses"  => "App\Http\Controllers\ProjectController@create",
        ])->name('projects.create');

        Route::post('/store', [
            "uses"  => "App\Http\Controllers\ProjectController@store",
        ])->name('projects.store');

        Route::get('/edit/{id}', [
            "uses"  => "App\Http\Controllers\ProjectController@edit",
        ])->name('projects.edit');

        Route::post('/edit/{id}', [
            "uses"  => "App\Http\Controllers\ProjectController@update",
        ])->name('projects.update');

        Route::post('/verify/{id}', [
            "uses"  => "App\Http\Controllers\ProjectController@verify",
        ])->name('projects.verify');

        Route::delete('/delete/{id}', [
            "uses"  => "App\Http\Controllers\ProjectController@destroy",
        ])->name('projects.delete');
    });

    Route::group(['prefix'=>'vehicles'],function(){
        Route::get('/', [
            "uses"  => "App\Http\Controllers\VehicleController@index",
        ])->name('vehicles');

        Route::get('/view/{id}', [
            "uses"  => "App\Http\Controllers\VehicleController@show",
        ])->name('vehicles.show');

        Route::get('/create', [
            "uses"  => "App\Http\Controllers\VehicleController@create",
        ])->name('vehicles.create');

        Route::post('/store', [
            "uses"  => "App\Http\Controllers\VehicleController@store",
        ])->name('vehicles.store');

        Route::get('/edit/{id}', [
            "uses"  => "App\Http\Controllers\VehicleController@edit",
        ])->name('vehicles.edit');

        Route::post('/edit/{id}', [
            "uses"  => "App\Http\Controllers\VehicleController@update",
        ])->name('vehicles.update');

        Route::post('/verify/{id}', [
            "uses"  => "App\Http\Controllers\VehicleController@verify",
        ])->name('vehicles.verify');

        Route::delete('/delete/{id}', [
            "uses"  => "App\Http\Controllers\VehicleController@destroy",
        ])->name('vehicles.delete');
    });

    Route::group(['prefix'=>'request-forms'],function() {

        Route::get('/create', [
            "uses"  => "App\Http\Controllers\RequestFormController@create",
        ])->name('request-forms.create');

        Route::post('/store', [
            "uses"  => "App\Http\Controllers\RequestFormController@store",
        ])->name('request-forms.store');

        Route::get('/view/{id}', [
            "uses"  => "App\Http\Controllers\RequestFormController@show",
        ])->name('request-forms.show');

        Route::get('/edit/{id}', [
            "uses"  => "App\Http\Controllers\RequestFormController@edit",
        ])->name('request-forms.edit');

        Route::post('/edit/{id}', [
            "uses"  => "App\Http\Controllers\RequestFormController@update",
        ])->name('request-forms.update');

        Route::post('/approve/{id}', [
            "uses"  => "App\Http\Controllers\RequestFormController@approve",
        ])->name('request-forms.approve');

        Route::post('/deny/{id}', [
            "uses"  => "App\Http\Controllers\RequestFormController@deny",
        ])->name('request-forms.deny');

        Route::delete('/delete/{id}', [
            "uses"  => "App\Http\Controllers\RequestFormController@destroy",
        ])->name('request-forms.delete');

        Route::delete('/discard/{id}', [
            "uses"  => "App\Http\Controllers\RequestFormController@discard",
        ])->name('request-forms.discard');

        Route::post('/initiate/{id}', [
            "uses"  => "App\Http\Controllers\RequestFormController@initiate",
        ])->name('request-forms.initiate');

        Route::post('/reconcile/{id}', [
            "uses"  => "App\Http\Controllers\RequestFormController@reconcile",
        ])->name('request-forms.reconcile');

    });

});
