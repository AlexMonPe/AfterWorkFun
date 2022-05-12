<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PartyController;
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
    Route::put('/profile/{id}', [UserController::class, 'updateUserProfile']);
    Route::delete('/users/{id}', [UserController::class, 'deleteUser']);

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

//Parties

Route::group([
    'middleware' => 'jwt.auth'
], function () {
    Route::post('/parties', [PartyController::class, 'createParty']);
    Route::get('/partiesbyuser', [PartyController::class, 'getPartiesByUserId']);
    Route::get('/partiesbygame/{id}', [PartyController::class, 'getPartiesByGame']);
    Route::put('/parties/{id}', [PartyController::class, 'updateParty']);
    Route::delete('/parties/{id}', [PartyController::class, 'deleteParty']);
    Route::post('/joinparty/{id}', [PartyController::class, 'joinParty']);
    Route::post('/leaveparty/{id}', [PartyController::class, 'leaveParty']);

});

//Messages
Route::group([
    'middleware' => 'jwt.auth'
], function () {
    Route::get('/messagesfromparty/{id}', [MessageController::class, 'getAllMessagesFromParty']);
    Route::post('/messages', [MessageController::class, 'createMessage']);
    Route::put('/messages/{id}', [MessageController::class, 'updateMessage']);
    Route::delete('/messages/{id}', [MessageController::class, 'deleteMessage']);
    
});

Route::group([
    'middleware' => ['jwt.auth','isAdmin']
], function () {
    Route::get('/users', [UserController::class, 'getAllUsers']);
    Route::get('/parties', [PartyController::class, 'getAllParties']);
    Route::post('/create-admin/{id}', [UserController::class, 'createAdmin']);
    Route::delete('/delete-admin/{id}', [UserController::class, 'deleteRoleAdmin']);

    
});