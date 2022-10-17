<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\KitchenController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::controller(AuthController::class)->group(function(){
    Route::get('loginPage','loginPage')->name('auth#login');
    Route::get('registerPage','registerPage')->name('auth#register');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::controller(KitchenController::class)
    ->group(function(){
        Route::get('/home','home')->name('kitchen#home');
    });
});
