<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;

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



Route::post('/login', [UserController::class, 'login']);

Route::group(['middleware' => 'auth:api'], function () {

    Route::post('items/save/{id?}', [ItemController::class, 'saveItem']);
    Route::delete('items/{id?}', [ItemController::class, 'deleteItem']);
    Route::get('items/{status?}', [ItemController::class, 'items']);

});
