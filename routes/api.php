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
    Route::post('dishes/create','createDish');//you need to fill name/category_id/price
    Route::post('dishes/update/{id}','updateDish');//you need to fill name/category_id/price
    Route::get('dishes/delete/{id}','deleteDish');

    // User api
    Route::get('users','users');
    Route::get('users/{id}','showUser');
    Route::post('users/register','createUser');//you need to fill name/email/password
    Route::get('users/delete/{id}','deleteUser');

    // Category api
    Route::get('categories','categories');
    Route::get('categories/{id}','showCategory');
    Route::post('categories/create','createCategory');//you need to fill name
    Route::post('categories/update/{id}','updateCategory');//you need to fill name
    Route::get('categories/delete/{id}','deleteCategory');

    //Table api
    Route::get('tables','tables');
    Route::get('tables/avaliable','avaliableTable');
    Route::post('tables/add','addTables');//you need to fill quantity of tables that you want to add

    //Order api
    Route::get('orders','orders');
    Route::get('orders/group','orderGroup');
    Route::post('orders/add','addOrder');
    //Add Order api documentation
    //If you put some order your order must be contain dish id and qunatity
    //Define Dish id as key and Order id as value
    //and must be contain avaliable Table id
    Route::post('orders/ready','readyOrder');
    Route::post('orders/serve','serveOrder');
    Route::post('orders/billing','billingOrder');
    // Order api documentation
    // first order need to prepare making dishs of order
    // after making dishes order is ready(you can call order ready api)
    // then waiter can serve order to the dealing table(you can call order serve api)
    // after all done the customer billing the order(you can call order billing api)
    // ready/serve/billing all method need to fill order_id
});
