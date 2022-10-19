<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

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
Route::middleware('loginAuth')
->group(function(){
    Route::redirect('/', 'loginPage')->name('auth#/');
    Route::controller(AuthController::class)->group(function(){
        Route::get('loginPage','loginPage')->name('auth#login');
        Route::get('registerPage','registerPage')->name('auth#register');
        Route::get('dashboard','dashboard')->name('auth#dashboard');
    });

    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified'
    ])->group(function () {

        Route::controller(KitchenController::class)
        ->prefix('kitchen')
        ->middleware('kitchenAuth')
        ->group(function(){
            Route::get('order','orderList')->name('kitchen#orderList');
            Route::get('order/detail/{id}','orderDetail')->name('kitchen#orderDetail');
            Route::get('order/ready/{id}','orderReady')->name('kitchen#orderReady');
            Route::get('order/cancel/{id}','orderCancel')->name('kitchen#orderCancel');
            Route::get('category/list','categoryList')->name('kitchen#categoryList');
            Route::post('category/create','categoryCreate')->name('kitchen#categoryCreate');
            Route::get('category/update','categoryUpdate');
            Route::get('category/delete/{id}','categoryDelete')->name('kitchen#categoryDelete');
            Route::get('table/add','addTables');
        });

        Route::controller(DishController::class)
        ->prefix('dish')
        ->middleware('kitchenAuth')
        ->group(function(){
            Route::get('home','index')->name('dish#index');
            Route::get('delete/{id}','dishDelete')->name('dish#delete');
            Route::get('create/page','createDishPage')->name('dish#createPage');
            Route::post('create','createDish')->name('dish#createDish');
            Route::get('edit/page/{id}','editDishPage')->name('dish#editPage');
            Route::post('update/{id}','updateDish')->name('dish#update');
        });

        Route::controller(OrderController::class)
        ->prefix('order')
        ->group(function(){
            Route::get('form','index')->name('order#index');
            Route::post('add/order','addOrder')->name('order#add');
            Route::get('serve/{id}','serveOrder')->name('order#serve');
            Route::get('bill/{id}','billingOrder')->name('order#billingOrder');
        });
    });
});

