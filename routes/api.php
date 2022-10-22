<?php

use App\Http\Controllers\ApiController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(ApiController::class)
->group(function(){
    // Dish api
    Route::get('dishes','dishes');
    Route::get('dishes/{id}','showDish');
    Route::post('dishes/create','createDish');
    Route::post('dishes/update/{id}','updateDish');
    Route::get('dishes/delete/{id}','deleteDish');

    // User api
    Route::get('users','users');
    Route::get('users/{id}','showUser');
    Route::post('users/register','createUser');
    Route::get('users/delete/{id}','deleteUser');

    // Category api
    Route::get('categories','categories');
    Route::get('categories/{id}','showCategory');
    Route::post('categories/create','createCategory');
    Route::post('categories/update/{id}','updateCategory');
    Route::get('categories/delete/{id}','deleteCategory');

    //Table api
    Route::get('tables','tables');
    Route::post('tables/add','addTables');
});
