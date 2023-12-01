<?php

use App\Http\Controllers\MemberController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
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
    'middleware' => ['auth:sanctum']
], function () {
    //rutas de usuarios

Route::get('/profile', [UserController::class, 'profile']);
Route::post('/logout', [UserController::class, 'logout']);
Route::put('/users', [UserController::class, 'updateUsers']); //actualizar perfil menos contraseña/mail -opcional
Route::put('/users/password', [UserController::class, 'changePassword']); //actualizar contraseña -opcional
Route::put('/users/inactivate', [UserController::class, 'inactivate']); // "eliminar" usuario , pasar el isActive a false -opcional
Route::post('/videogame', [VideogameController::class, 'createVideogame']); //crear videojuego
Route::delete('/videogame/{id}', [VideogameController::class, 'deleteVideogameById']); //eliminar videojuego
});


//rutas de videojuegos
//aqui hace falta el middleware de superadmin para todos los endpoints
Route::get('/videogames', [VideogameController::class, 'getAllVideogames']);
Route::get('/videogame/{id}', [VideogameController::class, 'getVideogameById']); //listar videojuegos
//rutas de salas
//aqui hace falta el sanctum
Route::post('/rooms', [RoomController::class, 'createRoom']); //crear sala y crear el room owner lo que tiene es una id de sala y una id de usuario con lo cual se creara el primer registro en la tabla de miembros
Route::get('/rooms', [RoomController::class, 'getRooms']); //listar salas
Route::get('/rooms/{id}', [RoomController::class, 'getRoomsbyVideogame']); //hacer un where done la {id} sea la id del videjojuego a filtrar
Route::delete('/rooms/{id}', [RoomController::class, 'deleteRoom']); //eliminar sala por la id de la sala si cumplias que eras el room owner
//si el id del room owner coincide con el id del usuario que hace la peticion, se puede eliminar la sala
//rutas de miembros
Route::post('/members', [MemberController::class, 'create']); //se crea un registro en la tabla de miembros (create)
Route::get('/members', [MemberController::class, 'getMembers']); //se listan todos los miembros de la sala (index)
Route::delete('/members{id}', [MemberController::class, 'delete']); //se elimina un registro de la tabla de miembros siempre que seas el
//room owner
//rutas de mensajes
//aqui hace falta el sanctum
Route::post('/messages', [MessageController::class, 'create']); //solo para miembros de sala
Route::get('/messages', [MessageController::class, 'getMessages']); //solo para miembros de sala
Route::delete('/messages/{id}', [MessageController::class, 'delete']); //solo permitir eliminar mensajes que hayas enviado tu
Route::put('/messages/{id}', [MessageController::class, 'update']); //solo permitir editar mensajes que hayas enviado tu