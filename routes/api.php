<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['controller' => CategoryController::class], function () {
    Route::get('category', 'index');
    Route::get('category/search', 'searchCategory');
    Route::get('category/{id}', 'show');
    Route::post('category/create', 'create');
    Route::put('category/update/{id}', 'update');
    Route::delete('category/delete', 'destroy');
});

Route::group(['controller' => PostController::class], function () {
    Route::get('post', 'index');
    Route::get('post/search', 'searchpost');
    Route::get('post/{id}', 'show');
    Route::post('post/create', 'create');
    Route::put('post/update/{id}', 'update');
    Route::delete('post/delete', 'destroy');
});
