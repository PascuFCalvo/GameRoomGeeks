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
//rutas de autorizacion
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::group([
    'middleware' => ['auth:sanctum', 'is_superadmin']
], function () {
    Route::post('/videogame', [VideogameController::class, 'createVideogame']); 
    Route::put('/videogame/{id}', [VideogameController::class, 'updateVideogameById']); 
    Route::delete('/videogame/{id}', [VideogameController::class, 'deleteVideogameById']);
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
<<<<<<< HEAD
    Route::get('/videogame/{id}', [VideogameController::class, 'getVideogameById']); 
    Route::post('/rooms', [RoomController::class, 'createRoom']); 
    Route::get('/rooms', [RoomController::class, 'getRooms']); 
    Route::get('/rooms/{id}', [RoomController::class, 'getRoomsbyVideogame']); 
    Route::delete('/rooms/{id}', [RoomController::class, 'deleteRoom']); 
    Route::put('/rooms/{id}', [RoomController::class, 'updateRoom']); 
=======
    Route::get('/videogame/{id}', [VideogameController::class, 'getVideogameById']); //listar videojuegos
    Route::post('/rooms', [RoomController::class, 'createRoom']); //crear sala y crear el room owner lo que tiene es una id de sala y una id de usuario con lo cual se creara el primer registro en la tabla de miembros
    Route::get('/rooms', [RoomController::class, 'getRooms']); //listar salas
    Route::get('/rooms/{id}', [RoomController::class, 'getRoomsbyVideogame']); //hacer un where done la {id} sea la id del videjojuego a filtrar
    Route::delete('/rooms/{id}', [RoomController::class, 'deleteRoom']); //eliminar sala por la id de la sala si cumplias que eras el room owner
    Route::put('/rooms/{id}', [RoomController::class, 'updateRoom']); //actualizar sala por la id de la sala si cumplias que eras el room owner
    Route::post('/member', [MemberController::class, 'createMember']); //se crea un registro en la tabla de miembros (create)
    Route::get('/members', [MemberController::class, 'getMembers']); //se listan todos los miembros de la sala (index)
    Route::delete('/member', [MemberController::class, 'deleteMember']); //se elimina un registro de la tabla de miembros siempre que seas el
>>>>>>> 504cd2b1b8e4fd71067a9dff930f9511f7432f2c
});



<<<<<<< HEAD
Route::post('/members', [MemberController::class, 'create']); 
Route::get('/members', [MemberController::class, 'getMembers']); 
Route::delete('/members{id}', [MemberController::class, 'delete']); 

Route::post('/messages', [MessageController::class, 'create']); 
Route::get('/messages', [MessageController::class, 'getMessages']); 
Route::delete('/messages/{id}', [MessageController::class, 'delete']);
Route::put('/messages/{id}', [MessageController::class, 'update']); 
=======

//rutas de salas

//NUEVA RUTA si el id del room owner coincide con el id del usuario que hace la peticion, se puede eliminar la sala
//rutas de miembros
//room owner
//rutas de mensajes
//aqui hace falta el sanctum
Route::post('/messages', [MessageController::class, 'create']); //solo para miembros de sala
Route::get('/messages', [MessageController::class, 'getMessages']); //solo para miembros de sala
Route::delete('/messages/{id}', [MessageController::class, 'delete']); //solo permitir eliminar mensajes que hayas enviado tu
Route::put('/messages/{id}', [MessageController::class, 'update']); //solo permitir editar mensajes que hayas enviado tu
>>>>>>> 504cd2b1b8e4fd71067a9dff930f9511f7432f2c
