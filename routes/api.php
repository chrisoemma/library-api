<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;

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

Route::group(['prefix' => 'v1'], function () {

    Route::group(['prefix' => 'auth'], function () {

        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
    });

    Route::middleware('auth:sanctum')->group(function () {
            Route::resource('/users', UserController::class);
            Route::resource('/books', BookController::class);

        Route::group(['prefix' => 'books'], function () {
          
            Route::group(['prefix' => 'favorite'], function () {
            Route::post('/{id}', [BookController::class, 'add_to_favorite']);
            Route::delete('/{id}', [BookController::class, 'remove_from_favorite']);
            
         });
         Route::group(['prefix' => 'likes'], function () {
            Route::post('/{id}', [BookController::class, 'like']);
            Route::delete('/{id}', [BookController::class, 'unlike']);
           });
       
         Route::group(['prefix' => 'comments/{id}'], function () {
            Route::post('/', [BookController::class, 'add_comment']);
            Route::get('/view', [BookController::class, 'view_comments']);
         });
       
        });
        Route::get('/popular', [BookController::class, 'popular']);
    });


});
Route::any('{path}', function() {
    return response()->json([
        'message' => 'Route not found'
    ], 404);
})->where('path', '.*');
