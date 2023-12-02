<?php

use App\Http\Controllers\MemberController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VideogameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::group([
    'middleware' => ['auth:sanctum', 'is_superadmin']
], function () {
    Route::post('/videogame', [VideogameController::class, 'createVideogame']);
    Route::put('/videogame/{id}', [VideogameController::class, 'updateVideogameById']);
    Route::delete('/videogame/{id}', [VideogameController::class, 'deleteVideogameById']);
    Route::put('/users/activate/{id}', [UserController::class, 'activate']);
});
Route::group([
    'middleware' => ['auth:sanctum']
], function () {


    Route::get('/profile', [UserController::class, 'profile']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::put('/users', [UserController::class, 'updateUsers']);
    Route::put('/users/password', [UserController::class, 'changePassword']);
    Route::put('/users/inactivate', [UserController::class, 'inactivate']);
    Route::get('/videogames', [VideogameController::class, 'getAllVideogames']);


    Route::get('/videogame/{id}', [VideogameController::class, 'getVideogameById']);
    Route::post('/rooms', [RoomController::class, 'createRoom']);
    Route::get('/rooms', [RoomController::class, 'getRooms']);
    Route::get('/rooms/{id}', [RoomController::class, 'getRoomsbyVideogame']);
    Route::delete('/rooms/{id}', [RoomController::class, 'deleteRoom']);
    Route::put('/rooms/{id}', [RoomController::class, 'updateRoom']);
    Route::post('/member', [MemberController::class, 'createMember']);
    Route::get('/members', [MemberController::class, 'getMembers']);
    Route::delete('/member', [MemberController::class, 'deleteMember']);
});






Route::post('/messages', [MessageController::class, 'create']);
Route::get('/messages', [MessageController::class, 'getMessages']);
Route::delete('/messages/{id}', [MessageController::class, 'delete']);
Route::put('/messages/{id}', [MessageController::class, 'update']);
