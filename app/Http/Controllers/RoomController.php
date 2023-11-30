<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoomController extends Controller
{
   public function createRoom(Request $request)
   {
      try {
         $user = User::query()
            ->where("isActive", true)
            ->get(["id"]);

         $videogame = Videogame::query()
            ->get(["id"]);

         $newRoom = Room::crate(
            [
               "name" => $request->name, //del body el name
               "videogame_id" => $videogame,
               "room_owner" => $user
            ]
         );

         return response()->json(
            [
               'message' => 'Room created successfully',
               'room' => $newRoom
            ],
            Response::HTTP_CREATED
         );
      } catch (\Throwable) {
         return response()->json(['message' => 'Error creating room'], response::HTTP_INTERNAL_SERVER_ERROR);
      }
   }

   public function getRooms()
   {
      try {
         $rooms = Room::query()
            ->get(["id", "name", "description", "videogame_id", "room_owner_id"]);


         return response()->json(
            [
               'message' => 'Rooms listed successfully',
               'rooms' => $rooms
            ],
            Response::HTTP_OK
         );
      } catch (\Throwable) {
         return response()->json(['message' => 'Error listing rooms'], response::HTTP_INTERNAL_SERVER_ERROR);
      }
   }

   public function getRoomsbyVideogame($id)
   {
      try {
         $rooms = Room::query()
            ->where("videogame_id", $id)
            ->get(["id", "name", "description", "videogame_id", "room_owner_id"]);

         return response()->json(
            [
               'message' => 'Rooms listed successfully',
               'rooms' => $rooms
            ],
            response::HTTP_OK
         );
      } catch (\Throwable) {
         return response()->json(['message' => 'Error listing rooms'], response::HTTP_INTERNAL_SERVER_ERROR);
      }
   }
   public function deleteRoom($id)
   {
      try {
         $room = Room::query()
            ->where("id", $id)
            ->get(["id", "name", "description", "videogame_id", "room_owner_id"]);

         $room->delete();

         return response()->json(
            [
               'message' => 'Room deleted successfully',
               'room' => $room
            ],
            response::HTTP_OK
         );
      } catch (\Throwable) {
         return response()->json(['message' => 'Error deleting room'], response::HTTP_INTERNAL_SERVER_ERROR);
      }
   }
}
