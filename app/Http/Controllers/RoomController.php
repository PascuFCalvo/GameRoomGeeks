<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

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
               "description" => $request->description, //del body la description
               "videogame_id" => $videogame,
               "room_owner_id" => $user
            ]
         );

         return response()->json(
            [
               'message' => 'Room created successfully',
               'room' => $newRoom
            ],
            201
         );
      } catch (\Throwable) {
         return response()->json(['message' => 'Error creating room'], 500);
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
            200
         );
      } catch (\Throwable) {
         return response()->json(['message' => 'Error listing rooms'], 500);
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
            200
         );
      } catch (\Throwable) {
         return response()->json(['message' => 'Error listing rooms'], 500);
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
            200
         );
      } catch (\Throwable) {
         return response()->json(['message' => 'Error deleting room'], 500);
      }
   }
}
