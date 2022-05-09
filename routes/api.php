<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Auth no token needed

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//Auth

Route::group([
    'middleware' => 'jwt.auth'
], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
});

//Users

Route::group([
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/users', [UserController::class, 'getAllUsers']);
    Route::put('/profile/{id}', [UserController::class, 'updateUserProfile']);
});

//Games

Route::group([
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/games', [GameController::class, 'getAllGames']);
    Route::post('/games', [GameController::class, 'createGame']);
    Route::put('/games/{id}', [GameController::class, 'updateGame']);
    Route::delete('/games/{id}', [GameController::class, 'deleteGame']);
});
