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

Route::group(['middleware'=>['auth:sanctum', 'verified','roles']],function (){

    Route::get('/', [
        "uses"  => "App\Http\Controllers\RequestFormController@dashboard",
    ])->name('dashboard');

    Route::get('/index', [
        "uses"  => "App\Http\Controllers\RequestFormController@index",
        'roles' =>['employee','management']
    ])->name('index');

    Route::get('/approved', [
        "uses"  => "App\Http\Controllers\RequestFormController@approved",
        'roles' =>['employee','management']
    ])->name('approved');

    Route::get('/finance', [
        "uses"  => "App\Http\Controllers\RequestFormController@finance",
        'roles' =>['employee','management']
    ])->name('finance');


    Route::group(['prefix'=>'users'],function() {
        Route::get('/', [
            "uses" => "App\Http\Controllers\UserController@index",
            'roles' =>['employee','management']
        ])->name('users');

        Route::get('/view/{id}', [
            "uses" => "App\Http\Controllers\UserController@show",
            'roles' =>['employee','management']
        ])->name('users.show');

        Route::post('/verify/{id}', [
            "uses" => "App\Http\Controllers\UserController@verify",
            'roles' =>['management']
        ])->name('users.verify');

        Route::post('/disable/{id}', [
            "uses" => "App\Http\Controllers\UserController@disable",
            'roles' =>['management']
        ])->name('users.disable');

        Route::post('/discard/{id}', [
            "uses" => "App\Http\Controllers\UserController@discard",
            'roles' =>['management']
        ])->name('users.discard');

    });

    Route::group(['prefix'=>'projects'],function(){
        Route::get('/', [
            "uses"  => "App\Http\Controllers\ProjectController@index",
            'roles' => ['employee','management']
        ])->name('projects');

        Route::get('/view/{id}', [
            "uses"  => "App\Http\Controllers\ProjectController@show",
            'roles' => ['employee','management']
        ])->name('projects.show');

        Route::get('/create', [
            "uses"  => "App\Http\Controllers\ProjectController@create",
            'roles' =>['administrator']
        ])->name('projects.create');

        Route::post('/store', [
            "uses"  => "App\Http\Controllers\ProjectController@store",
            'roles' =>['administrator']
        ])->name('projects.store');

        Route::get('/edit/{id}', [
            "uses"  => "App\Http\Controllers\ProjectController@edit",
            'roles' =>['administrator']
        ])->name('projects.edit');

        Route::post('/edit/{id}', [
            "uses"  => "App\Http\Controllers\ProjectController@update",
            'roles' =>['administrator']
        ])->name('projects.update');

        Route::post('/verify/{id}', [
            "uses"  => "App\Http\Controllers\ProjectController@verify",
            'roles' =>['management']
        ])->name('projects.verify');

        Route::post('/delete/{id}', [
            "uses"  => "App\Http\Controllers\ProjectController@destroy",
            'roles' => ['administrator','management']
        ])->name('projects.delete');
    });

    Route::group(['prefix'=>'vehicles'],function(){
        Route::get('/', [
            "uses"  => "App\Http\Controllers\VehicleController@index",
            'roles' => ['employee','management']
        ])->name('vehicles');

        Route::get('/view/{id}', [
            "uses"  => "App\Http\Controllers\VehicleController@show",
            'roles' => ['employee','management']
        ])->name('vehicles.show');

        Route::get('/create', [
            "uses"  => "App\Http\Controllers\VehicleController@create",
            'roles' =>['administrator']
        ])->name('vehicles.create');

        Route::post('/store', [
            "uses"  => "App\Http\Controllers\VehicleController@store",
            'roles' =>['administrator']
        ])->name('vehicles.store');

        Route::get('/edit/{id}', [
            "uses"  => "App\Http\Controllers\VehicleController@edit",
            'roles' =>['administrator']
        ])->name('vehicles.edit');

        Route::post('/edit/{id}', [
            "uses"  => "App\Http\Controllers\VehicleController@update",
            'roles' =>['administrator']
        ])->name('vehicles.update');

        Route::post('/verify/{id}', [
            "uses"  => "App\Http\Controllers\VehicleController@verify",
            'roles' =>['management']
        ])->name('vehicles.verify');

        Route::post('/delete/{id}', [
            "uses"  => "App\Http\Controllers\VehicleController@destroy",
            'roles' => ['administrator','management']
        ])->name('vehicles.delete');

        Route::get('/gases', [
            "uses"  => "App\Http\Controllers\GasController@edit",
            'roles' =>['administrator']
        ])->name('gases.edit');

        Route::post('/gases', [
            "uses"  => "App\Http\Controllers\GasController@update",
            'roles' =>['administrator']
        ])->name('gases.update');
    });

    Route::group(['prefix'=>'request-forms'],function() {

        Route::get('/create', [
            "uses"  => "App\Http\Controllers\RequestFormController@create",
            'roles' =>['employee','management']
        ])->name('request-forms.create');

        Route::post('/store', [
            "uses"  => "App\Http\Controllers\RequestFormController@store",
            'roles' =>['employee','management']
        ])->name('request-forms.store');

        Route::get('/view/{id}', [
            "uses"  => "App\Http\Controllers\RequestFormController@show",
            'roles' =>['employee','management']
        ])->name('request-forms.show');

        Route::post('/find/{code}', [
            "uses"  => "App\Http\Controllers\RequestFormController@findRequestForm",
            'roles' =>['employee','management']
        ])->name('request-forms.find');

        Route::get('/edit/{id}', [
            "uses"  => "App\Http\Controllers\RequestFormController@edit",
            'roles' =>['employee','management']
        ])->name('request-forms.edit');

        Route::post('/edit/{id}', [
            "uses"  => "App\Http\Controllers\RequestFormController@update",
            'roles' =>['employee','management']
        ])->name('request-forms.update');

        Route::post('/approve/{id}', [
            "uses"  => "App\Http\Controllers\RequestFormController@approve",
            'roles' =>['employee','management']
        ])->name('request-forms.approve');

        Route::post('/deny/{id}', [
            "uses"  => "App\Http\Controllers\RequestFormController@deny",
            'roles' =>['employee','management']
        ])->name('request-forms.deny');

        Route::post('/delete/{id}', [
            "uses"  => "App\Http\Controllers\RequestFormController@destroy",
            'roles' =>['employee','management']
        ])->name('request-forms.delete');

        Route::post('/discard/{id}', [
            "uses"  => "App\Http\Controllers\RequestFormController@discard",
            'roles' =>['employee','management']
        ])->name('request-forms.discard');

        Route::post('/add-remarks/{id}', [
            "uses"  => "App\Http\Controllers\RequestFormController@appendRemarks",
            'roles' =>['employee','management']
        ])->name('request-forms.add-remarks');

        Route::post('/initiate/{id}', [
            "uses"  => "App\Http\Controllers\RequestFormController@initiate",
             'roles' =>['accountant']
        ])->name('request-forms.initiate');

        Route::post('/reconcile/{id}', [
            "uses"  => "App\Http\Controllers\RequestFormController@reconcile",
             'roles' =>['accountant']
        ])->name('request-forms.reconcile');

        Route::get('/print/{id}', [
            "uses"  => "App\Http\Controllers\RequestFormController@print",
            'roles' =>['employee','management']
        ])->name('request-forms.print');

    });

    Route::group(['prefix'=>'notifications'],function() {

        Route::get('/', [
            "uses" => "App\Http\Controllers\NotificationController@index",
            'roles' => ['employee', 'management']
        ])->name('notifications');
    });

});
